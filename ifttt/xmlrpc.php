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
$obj = new stdClass;

switch ($xml->methodName) {
  case 'mt.supportedMethods':
    ifttt_success('metaWeblog.getRecentPosts');
  case 'metaWeblog.getRecentPosts':
    ifttt_success('<array><data /></array>');
  case 'metaWeblog.newPost':
    if ($xml->params->param[1]->value->string == 'admin' and password_verify($xml->params->param[2]->value->string, '$2y$10$2/PlchN6.KXLRXBGFsqesOGhp1zgX4/Klqua6VWZZw/PBInv00r92')) {
      $data = $xml->params->param[3]->value->struct->member;
      $title = '';
      $description = '';

      foreach($data as $datum) {
        if ($datum->name == 'title') {
          $title = (string) $datum->value->string;
        } elseif ($datum->name == 'description') {
          $description = (string) $datum->value->string;
        }
      }

      $ch = curl_init();
      $cards = preg_match_all('/#(\w+)/', $obj->title, $matches);
      curl_setopt($ch, CURLOPT_POST, 3);
      curl_setOpt($ch, CURLOPT_POSTFIELDS, array(
        'key' => '18e84ee5652c3619af4402c4db8b150e',
        'token' => 'fb6ae19955adcc10f1240365e43c1a0d268a8ff6432761ccde663d9b97b5c29d',
        'text' => $obj->description
      ));

      foreach ($matches[1] as $match) {
        curl_setopt($ch, CURLOPT_URL, "https://api.trello.com/1/cards/$match/actions/comments");
        $response = curl_exec($ch);
      }

      curl_close($ch);
      ifttt_success('200 OK');
    } else {
      die(<<<EOF
<?xml version="1.0"?>
<methodResponse>
  <fault>
    <value>
      <struct>
        <member>
          <name>faultCode</name>
          <value>
            <int>403</int>
          </value>
        </member>
        <member>
          <name>faultString</name>
          <value>
            <string>Incorrect username or password.</string>
          </value>
        </member>
      </struct>
    </value>
  </fault>
</methodResponse>
EOF
        );
    }
}
?>