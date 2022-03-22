<?
define(
  'SQUIFFLES_BLIP_TEMPLATE',
  '<span class="map-blip" style="top: {$top}em; left: {$left}em;"></span>'
);

define('SQUIFFLES_PX_PER_EM', 20);
define('SQUIFFLES_TRELLO_PATTERN', '/\bhttps?:\/\/trello.com\/c\/(\w+)/');

$config = array();

include(__DIR__ . '/../config.php');

/**
 * Creates attachments from a URL on each of a list of Trello cards.
 * @param array<string> $cards The list of card URLs to attach to.
 * @param string $url The URL from which to create attachments.
 */
function squiffles_attach_to_trello($cards, $url) {
  global $config;

  if (!isset($config['trello_key']) || !isset($config['trello_token'])) {
    return;
  }

  $fields = array(
    'key' => $config['trello_key'],
    'token' => $config['trello_token'],
    'url' => $url
  );

  $query = http_build_query(array(
    'fields' => 'url',
    'key' => $config['trello_key'],
    'token' => $config['trello_token']
  ));

  $handle = curl_init();
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

  foreach ($cards as $card) {
    if (preg_match(SQUIFFLES_TRELLO_PATTERN, $card, $matches)) {
      $api_url = "https://api.trello.com/1/cards/$matches[1]/attachments";
      curl_setopt($handle, CURLOPT_HTTPGET, true);
      curl_setopt($handle, CURLOPT_URL, "$api_url?$query");
      $attachments = json_decode(curl_exec($handle));
      $exists = false;

      foreach ($attachments as $attachment) {
        if ($attachment->url === $url) {
          $exists = true;
          break;
        }
      }

      if (!$exists) {
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($handle, CURLOPT_URL, $api_url);
        curl_exec($handle);
      }
    }
  }

  curl_close($handle);
}

/**
 * Projects a lat-lng pair onto a Mercator map.
 * @param number $lat Latitude.
 * @param number $lng Longitude.
 * @return array<number> The x-y pair of the point on world.png.
 */
function squiffles_project($lat, $lng) {
  static $width = 0;

  if ($width === 0) {
    $width = getimagesize(__DIR__ . '/../bin/images/world.png')[0];
  }

  return array(
    ($lng + 188) * $width / 343,
    440 - $width * log(tan(M_PI / 4 + $lat * M_PI / 360)) / M_PI / 2 * 1.05
  );
}
?>
