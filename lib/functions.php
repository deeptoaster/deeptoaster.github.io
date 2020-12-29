<?
$config = array();

include(__DIR__ . '/../config.php');

/**
 * Creates attachments from a URL on each of a list of Trello cards.
 * @param $cards The list of card URLs to attach to.
 * @param $url The URL from which to create attachments.
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
    if (preg_match('/^https?:\/\/trello.com\/c\/(\w+)/', $card, $matches)) {
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
?>
