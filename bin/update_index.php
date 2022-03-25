<?
define(
  'SQUIFFLES_GOOGLE_AUTH_URL',
  'https://accounts.google.com/o/oauth2/v2/auth'
);

define('SQUIFFLES_GOOGLE_SCOPE', 'https://www.googleapis.com/auth/spreadsheets.readonly');
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

function squiffles_fetch_location(&$lat, &$lng) {
  global $config;

  $handle = curl_init();
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_HTTPGET, true);

  curl_setopt($handle, CURLOPT_HTTPHEADER, array(
    "Authorization: Bearer $config[google_access_token]"
  ));

  curl_setopt(
    $handle,
    CURLOPT_URL,
    "https://sheets.googleapis.com/v4/spreadsheets/$config[blip_sheet_id]/values/'$config[blip_sheet_name]'!$config[blip_sheet_range]"
  );

  $response = json_decode(curl_exec($handle));
  $response_code = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);

  if ($response_code === 200) {
    $lat = (float)$response->values[0][0];
    $lng = (float)$response->values[0][1];
  }

  curl_close($handle);
  return $response_code;
}

session_start();

if (isset($_GET['code'])) {
  $handle = curl_init();
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_POST, true);

  curl_setopt($handle, CURLOPT_POSTFIELDS, array(
    'client_id' => $config['google_client_id'],
    'client_secret' => $config['google_client_secret'],
    'code' => $_GET['code'],
    'grant_type' => 'authorization_code',
    'redirect_uri' => SQUIFFLES_REDIRECT_URL
  ));

  curl_setopt($handle, CURLOPT_URL, SQUIFFLES_GOOGLE_TOKEN_URL);
  $response = json_decode(curl_exec($handle));

  squiffles_config_set(array(
    'google_access_token' => $response->access_token,
    'google_refresh_token' => $response->refresh_token
  ));

  curl_close($handle);
} elseif (
  !@$config['google_access_token'] ||
      !@$config['google_refresh_token']
) {
  header(sprintf(
    'Location: %s?access_type=offline&client_id=%s&prompt=consent&redirect_uri=%s&response_type=code&scope=%s&state=state_parameter_passthrough_value',
    SQUIFFLES_GOOGLE_AUTH_URL,
    $config['google_client_id'],
    rawurlencode(SQUIFFLES_REDIRECT_URL),
    rawurlencode(SQUIFFLES_GOOGLE_SCOPE)
  ));

  die();
}

$lat = null;
$lng = null;
$response_code = squiffles_fetch_location($lat, $lng);

if ($response_code === 401) {
  $handle = curl_init();
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_POST, true);

  curl_setopt($handle, CURLOPT_POSTFIELDS, array(
    'client_id' => $config['google_client_id'],
    'client_secret' => $config['google_client_secret'],
    'grant_type' => 'refresh_token',
    'refresh_token' => $config['google_refresh_token']
  ));

  curl_setopt($handle, CURLOPT_URL, SQUIFFLES_GOOGLE_TOKEN_URL);
  $response = json_decode(curl_exec($handle));

  squiffles_config_set(array(
    'google_access_token' => $response->access_token
  ));

  curl_close($handle);
  $response_code = squiffles_fetch_location($lat, $lng);
}

if ($response_code === 200) {
  list($x, $y) = squiffles_project($lat, $lng);
  $read_handle = fopen(SQUIFFLES_INDEX_FILE, 'r');
  $write_file = tempnam(sys_get_temp_dir(), '');
  $write_handle = fopen($write_file, 'c');
  $cleverly = new Cleverly();

  $pattern = '/' . str_replace(
    '\\$\\$',
    '[\.\d]+', preg_quote($cleverly->fetch(
    'string:' . SQUIFFLES_BLIP_TEMPLATE,
    array('left' => '$$', 'top' => '$$')
  ), '/')) . '/';

  $replacement = $cleverly->fetch(
    'string:' . SQUIFFLES_BLIP_TEMPLATE,
    array(
      'left' => round($x / SQUIFFLES_PX_PER_EM, 2),
      'top' => round($y / SQUIFFLES_PX_PER_EM, 2)
    )
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
