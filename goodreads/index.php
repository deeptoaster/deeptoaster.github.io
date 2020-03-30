<?
define('FEED_FILE', __DIR__ . '/feed.xml');
define('USERS_FILE', __DIR__ . '/users.txt');

$callback = sprintf(
  'http%s://%s%s',
  @$_SERVER['HTTPS'] ? 's' : '',
  $_SERVER['HTTP_HOST'],
  strtok($_SERVER['REQUEST_URI'], '?')
);

$known_users = @file(USERS_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
  ?: array();
$url = array_shift($known_users);

if (@$_GET['format'] == 'xml') {
  if (time() - @filemtime(FEED_FILE) < 3600) {
    $feed = file_get_contents(FEED_FILE);
  } else {
    $feed = file_get_contents($url);
    $feed = str_replace(' href="/', ' href="https://www.goodreads.com/', $feed);
    $feed = preg_replace('/\s*<dc:date>[^<]+<\/dc:date>/', '', $feed);
    $feed = preg_replace('/ only_path="\w+"/', '', $feed);

    $feed = preg_replace(
      '/ xmlns:dc="[^"]+"/',
      ' xmlns:atom="http://www.w3.org/2005/Atom"' .
          ' xmlns:content="http://purl.org/rss/1.0/modules/content/"',
      $feed
    );

    $feed = preg_replace(
      '/(\s*)<item>/',
      "$1<atom:link href=\"$callback?format=xml\" rel=\"self\" />$1<item>",
      $feed,
      1
    );

    $feed = preg_replace(
      '/\s*<item>\s*<title>([^<]+ (liked a [^<]+|entered a giveaway)|#?&amp;#60'
          . ';[^<]+&amp;#62;)<\/title>.*?<\/item>/s',
      '',
      $feed
    );

    $feed = preg_replace(
      '/(\s*)<title>([^<]+) [a-z]+ed [^<]+<\/title>/',
      '$0$1<author>$2</author>',
      $feed
    );

    $feed = preg_replace_callback(
      '/(\s*)<link>([^<]+)<\/link>/',
      function($match) {
        return preg_match(
          "/<meta content='([^']+)' property='og:image'>/",
          file_get_contents($match[2]),
          $submatch
        )
          ? $match[0] . $match[1] .
                '<content:encoded><![CDATA[<img src="' .
                $submatch[1] . '" />]]></content:encoded>'
          : $match[0];
      },
      $feed,
      3
    );

    file_put_contents(FEED_FILE, $feed);
  }

  header('Content-Type: application/rss+xml');
  die($feed);
}

$config = array(
  'access_url' => 'https://www.goodreads.com/oauth/access_token',
  'authorize_url' => 'https://www.goodreads.com/oauth/authorize',
  'request_url' => 'https://www.goodreads.com/oauth/request_token'
);

include(__DIR__ . '/config.php');

session_start();

$oauth = new OAuth(
  $config['key'],
  $config['secret'],
  OAUTH_SIG_METHOD_HMACSHA1,
  OAUTH_AUTH_TYPE_URI
);

if (!isset($_GET['oauth_token']) && $_SESSION['goodreads_oauth_state'] == 1) {
  $_SESSION['goodreads_oauth_state'] = 0;
}

switch ((int)@$_SESSION['goodreads_oauth_state']) {
  case 0:
    $request_token = $oauth->getRequestToken($config['request_url'], $callback);
    $_SESSION['goodreads_oauth_secret'] =
        $request_token['oauth_token_secret'];
    $_SESSION['goodreads_oauth_state'] = 1;

    header(
      "Location: $config[authorize_url]?oauth_token=$request_token[oauth_token]"
          . '&oauth_callback=' . $callback
    );

    die();
  case 1:
    $oauth->setToken(
      @$_GET['oauth_token'],
      $_SESSION['goodreads_oauth_secret']
    );

    $access_token_info = $oauth->getAccessToken($config['access_url']);
    $_SESSION['goodreads_oauth_state'] = 2;
    $_SESSION['goodreads_oauth_token'] = $access_token_info['oauth_token'];
    $_SESSION['goodreads_oauth_secret'] =
        $access_token_info['oauth_token_secret'];
    break;
  case 2:
    break;
}

$oauth->setToken(
  $_SESSION['goodreads_oauth_token'],
  $_SESSION['goodreads_oauth_secret']
);

$ids = array();
$i = 1;

do {
  $oauth->fetch("https://www.goodreads.com/group/members/1080207.xml?page=$i");
  $xml = simplexml_load_string($oauth->getLastResponse());
  $new_users = $xml->xpath('/GoodreadsResponse/group_users/group_user/user/id');
  $new_ids = array_map('intval', $new_users);
  $ids = array_merge($ids, $new_ids);
  $i++;

  echo $xml->asXML();
} while (count($new_ids));

sort($ids, SORT_NUMERIC);
$known_ids = array_map('intval', $known_users);

if ($ids != $known_ids) {
  $handle = curl_init();
  curl_setopt($handle, CURLOPT_COOKIEFILE, USERS_FILE);
  curl_setopt($handle, CURLOPT_COOKIEJAR, 'nom-nom');
  curl_setopt($handle, CURLOPT_COOKIESESSION, true);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_URL, 'http://rssmix.com/');
  $response = curl_exec($handle);
  preg_match('/<meta name="csrf-token" content="(.*?)">/', $response, $match);

  $fields = array(
    '_csrf' => $match[1],
    'createMix' => '1',
    'mix_title' => '',
    'urls' => implode("\r\n", array_map(function($id) {
      return 'https://www.goodreads.com/user/updates_rss/' . $id;
    }, $ids))
  );

  curl_setopt($handle, CURLOPT_POST, 1);
  curl_setopt($handle, CURLOPT_POSTFIELDS, $fields);
  $response = curl_exec($handle);
  preg_match('/http:\/\/rssmix.com\/u\/\d+\/rss.xml/', $response, $match);
  $handle = fopen(USERS_FILE, 'w');
  fwrite($handle, $match[0] . "\n");

  foreach ($ids as $id) {
    fwrite($handle, $id . "\n");
  }

  fclose($handle);
}
?>
