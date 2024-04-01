<?
define(
  'SQUIFFLES_GOOGLE_AUTH_URL',
  'https://accounts.google.com/o/oauth2/v2/auth'
);

define(
  'SQUIFFLES_GOOGLE_SCOPE',
  'https://www.googleapis.com/auth/spreadsheets.readonly'
);

define('SQUIFFLES_GOOGLE_TOKEN_URL', 'https://oauth2.googleapis.com/token');
define('SQUIFFLES_INDEX_FILE', __DIR__ . '/../index.html');

define('SQUIFFLES_REDIRECT_URL', sprintf(
  'http%s://%s%s',
  $_SERVER['HTTPS'] ? 's' : '',
  $_SERVER['HTTP_HOST'],
  $_SERVER['PHP_SELF']
));

include(__DIR__ . '/../lib/cleverly/Cleverly.class.php');
include(__DIR__ . '/../lib/functions.php');

session_start();

if (isset($_GET['code'])) {
  $handle = curl_init();
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_POST, true);

  curl_setopt($handle, CURLOPT_POSTFIELDS, [
    'client_id' => $config['GOOGLE_CLIENT_ID'],
    'client_secret' => $config['GOOGLE_CLIENT_SECRET'],
    'code' => $_GET['code'],
    'grant_type' => 'authorization_code',
    'redirect_uri' => SQUIFFLES_REDIRECT_URL
  ]);

  curl_setopt($handle, CURLOPT_URL, SQUIFFLES_GOOGLE_TOKEN_URL);
  $response = json_decode(curl_exec($handle));

  squiffles_config_set([
    'GOOGLE_ACCESS_TOKEN' => $response->access_token,
    'GOOGLE_REFRESH_TOKEN' => $response->refresh_token
  ]);

  curl_close($handle);
}

$latitude = null;
$longitude = null;
$response_code = 401;

if (@$config['GOOGLE_ACCESS_TOKEN']) {
  squiffles_fetch_location($latitude, $longitude);
}

if ($response_code === 401) {
  if (!@$config['GOOGLE_REFRESH_TOKEN']) {
    header(sprintf(
      'Location: %s?access_type=offline&client_id=%s&prompt=consent&redirect_uri=%s&response_type=code&scope=%s&state=state_parameter_passthrough_value',
      SQUIFFLES_GOOGLE_AUTH_URL,
      $config['GOOGLE_CLIENT_ID'],
      rawurlencode(SQUIFFLES_REDIRECT_URL),
      rawurlencode(SQUIFFLES_GOOGLE_SCOPE)
    ));

    die();
  }

  $handle = curl_init();
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_POST, true);

  curl_setopt($handle, CURLOPT_POSTFIELDS, [
    'client_id' => $config['GOOGLE_CLIENT_ID'],
    'client_secret' => $config['GOOGLE_CLIENT_SECRET'],
    'grant_type' => 'refresh_token',
    'refresh_token' => $config['GOOGLE_REFRESH_TOKEN']
  ]);

  curl_setopt($handle, CURLOPT_URL, SQUIFFLES_GOOGLE_TOKEN_URL);
  $response = json_decode(curl_exec($handle));

  squiffles_config_set([
    'GOOGLE_ACCESS_TOKEN' => $response->access_token
  ]);

  curl_close($handle);
  $response_code = squiffles_fetch_location($latitude, $longitude);
}

if ($response_code === 200) {
  list($x, $y) = squiffles_project([$latitude, $longitude]);
  $read_handle = fopen(SQUIFFLES_INDEX_FILE, 'r');
  $write_file = tempnam(sys_get_temp_dir(), '');
  $write_handle = fopen($write_file, 'c');
  $cleverly = new Cleverly();

  $pattern = '/' . str_replace(
    '\\$\\$',
    '[\.\d]+',
    preg_quote($cleverly->fetch(
      'string:' . SQUIFFLES_BLIP_TEMPLATE,
      ['left' => '$$', 'top' => '$$']
    ), '/')
  ) . '/';

  $replacement = $cleverly->fetch(
    'string:' . SQUIFFLES_BLIP_TEMPLATE,
    [
      'left' => round($x / SQUIFFLES_PX_PER_EM, 2),
      'top' => round($y / SQUIFFLES_PX_PER_EM, 2)
    ]
  );

  while (($line = fgets($read_handle)) !== false) {
    fwrite($write_handle, preg_replace($pattern, $replacement, $line));
  }

  fclose($read_handle);
  fclose($write_handle);
  unlink(SQUIFFLES_INDEX_FILE);
  rename($write_file, SQUIFFLES_INDEX_FILE);
  chmod(SQUIFFLES_INDEX_FILE, 0644);
}
?>
