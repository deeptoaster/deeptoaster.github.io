<?
function ifttt_success($value) {
  $xml = <<<EOF
<?xml version="1.0"?>
<methodResponse>
  <params>
    <param>
      <value>$value</value>
    </param>
  </params>
</methodResponse>
EOF;

  header('Connection: close');
  header('Content-Length: ' . strlen($value));
  header('Content-Type: text/xml');
  header('Date: ' . date('r'));
  die($xml);
}

$xml = simplexml_load_string(file_get_contents('php://input'));

switch ($xml->methodName) {
  case 'mt.supportedMethods':
    ifttt_success('metaWeblog.getRecentPosts');
  case 'metaWeblog.getRecentPosts':
    ifttt_success('<array><data /></array>');
  case 'metaWeblog.newPost':
    if (
      (string)$xml->params->param[1]->value->string == 'admin' and
          password_verify(
        (string)$xml->params->param[2]->value->string,
        '$2y$10$oo7w0op8jhhkzCtNTSQ2hOZMWOrHbrlmXu5Eq0aWlJzXPVQBZVA42'
      )
    ) {
      $members = $xml->params->param[3]->value->struct->member;
      $title = '';
      $config = array('text' => '');

      include(__DIR__ . '/config.php');

      foreach($members as $member) {
        if ((string) $member->name == 'title') {
          $title = trim((string) $member->value->string);
        } elseif ((string) $member->name == 'description') {
          $config['text'] = trim((string) $member->value->string);
        }
      }

      $handle = curl_init();
      preg_match_all('/#(\w+)/', $title, $matches);
      curl_setopt($handle, CURLOPT_POST, 3);
      curl_setopt($handle, CURLOPT_POSTFIELDS, $config);

      foreach ($matches[1] as $match) {
        curl_setopt(
          $handle,
          CURLOPT_URL,
          "https://api.trello.com/1/cards/$match/actions/comments"
        );

        curl_exec($handle);
      }

      curl_close($handle);
    }

    ifttt_success('200 OK');
}
?>
