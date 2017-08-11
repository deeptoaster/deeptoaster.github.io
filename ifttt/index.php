<?
$data = json_decode(file_get_contents('php://input'));
$ch = curl_init();
$cards = preg_match_all('/#(\w+)/', implode(',', $data->categories), $matches);
curl_setopt($ch, CURLOPT_POST, 3);
curl_setOpt($ch, CURLOPT_POSTFIELDS, array(
  'key' => '18e84ee5652c3619af4402c4db8b150e',
  'token' => 'fb6ae19955adcc10f1240365e43c1a0d268a8ff6432761ccde663d9b97b5c29d',
  'text' => $data->title
));

foreach ($matches[1] as $match) {
  curl_setopt($ch, CURLOPT_URL, "https://api.trello.com/1/cards/$match/actions/comments");
  $response = curl_exec($ch);
}

curl_close($ch);
?>
