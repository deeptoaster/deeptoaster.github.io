<?
define('SQUIFFLES_GOOGLE_TOKEN_URL', 'https://oauth2.googleapis.com/token');

include(__DIR__ . '/../lib/cleverly/Cleverly.class.php');
include(__DIR__ . '/../lib/functions.php');
include(__DIR__ . '/../lib/google-apis/vendor/autoload.php');

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
    'redirect_uri' => sprintf(
      'http%s://%s%s',
      $_SERVER['HTTPS'] ? 's' : '',
      $_SERVER['HTTP_HOST'],
      $_SERVER['PHP_SELF']
    )
  ));

  curl_setopt($handle, CURLOPT_URL, SQUIFFLES_GOOGLE_TOKEN_URL);
  $response = json_decode(curl_exec($handle));

  squiffles_config_set(array(
    'google_access_token' => $response->access_token,
    'google_refresh_token' => $response->response_token
  ));

  curl_close($handle);
}

$lat = null;
$lng = null;
$response_code = squiffles_fetch_location($lat, $lng);

var_dump($lat, $lng);

if ($response_code === 403) {
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
?>
