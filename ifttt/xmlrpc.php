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

$xml = file_get_contents('php://input');
$xml = simplexml_load_string($xml);

switch ($xml->methodName) {
  case 'mt.supportedMethods':
    ifttt_success('metaWeblog.getRecentPosts');
  case 'metaWeblog.getRecentPosts':
    ifttt_success('<array><data /></array>');
  case 'metaWeblog.newPost':
    mail($email, 'IFTTT', $xml);

    if ($xml->params->param[1]->value->string == 'admin' and password_verify($xml->params->param[2]->value->string, '$2y$10$B6nLvebuCgY.hrHTB/vfBu/yT6Gg8BUJWyN3Sy7ecJhl8sp.vuK3e')) {
      $data = $xml->params->param[3]->value->struct->member;
      $title = '';
      $description = '';

      foreach($data as $datum) {
        if ($datum->name == 'title') {
          $title = $datum->value->string;
        } elseif ($datum->name == 'description') {
          $description = $datum->value->string;
        }
      }

      $ch = curl_init();
      $cards = preg_match_all('/#(\w+)/', $title, $matches);
      curl_setopt($ch, CURLOPT_POST, 3);
      curl_setOpt($ch, CURLOPT_POSTFIELDS, array(
        'key' => '18e84ee5652c3619af4402c4db8b150e',
        'token' => 'fb6ae19955adcc10f1240365e43c1a0d268a8ff6432761ccde663d9b97b5c29d',
        'text' => $description
      ));

      foreach ($matches[1] as $match) {
        curl_setopt($ch, CURLOPT_URL, "https://api.trello.com/1/cards/$match/actions/comments");
        $response = curl_exec($ch);
      }

      curl_close($ch);
    }

    ifttt_success('200 OK');
}
?>
