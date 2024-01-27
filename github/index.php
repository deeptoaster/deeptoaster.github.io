<?
include(__DIR__ . '/../lib/functions.php');

if ($_SERVER['HTTP_X_GITHUB_EVENT'] !== 'push') {
  return;
}

if (!hash_equals(
  'sha256=' . hash_hmac(
    'sha256',
    file_get_contents('php://input'),
    $config['GITHUB_SECRET']
  ),
  $_SERVER['HTTP_X_HUB_SIGNATURE_256']
)) {
  return;
}

$push = json_decode($_POST['payload']);

foreach ($push->commits as $commit) {
  if (preg_match_all(
    SQUIFFLES_TRELLO_PATTERN,
    $commit->message,
    $matches
  ) !== 0) {
    squiffles_attach_to_trello($matches[0], $commit->url);
  }
}
?>
