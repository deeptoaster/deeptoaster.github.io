<?
define(
  'SQUIFFLES_BLIP_TEMPLATE',
  '<span class="map-blip" style="top: {$top}em; left: {$left}em;"></span>'
);

define('SQUIFFLES_CONFIG_FILE', __DIR__ . '/../config.php');
define('SQUIFFLES_MAP_FILE', __DIR__ . '/../bin/images/world.png');
define('SQUIFFLES_PX_PER_EM', 20);
define('SQUIFFLES_TRELLO_PATTERN', '/\bhttps?:\/\/trello.com\/c\/(\w+)/');

$config = [];

include(SQUIFFLES_CONFIG_FILE);

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

  $fields = [
    'key' => $config['trello_key'],
    'token' => $config['trello_token'],
    'url' => $url
  ];

  $query = http_build_query([
    'fields' => 'url',
    'key' => $config['trello_key'],
    'token' => $config['trello_token']
  ]);

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
 * Adds or updates config values both for the current session and persistently.
 * @param array<string,string> $settings Settings as key-value pairs.
 */
function squiffles_config_set($settings) {
  global $config;

  foreach ($settings as $key => $value) {
    $config[$key] = $value;
  }

  ksort($config);
  $stream = fopen(SQUIFFLES_CONFIG_FILE, 'w');
  fwrite($stream, "<?\n");

  foreach ($config as $key => $value) {
    fwrite($stream, "\$config['$key'] = '$value';\n");
  }

  fwrite($stream, "?>\n");
  fclose($stream);
}

/**
 * Retrives a lat-lng pair from the blip spreadsheet.
 * @param number [output] Latitude.
 * @param number [output] Longitude.
 * @return number The HTTP request's response code.
 */
function squiffles_fetch_location(&$lat, &$lng) {
  global $config;

  $handle = curl_init();
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_HTTPGET, true);

  curl_setopt($handle, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $config[google_access_token]"
  ]);

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

/**
 * Projects a lat-lng pair onto a Mercator map.
 * @param number $lat Latitude.
 * @param number $lng Longitude.
 * @return array<number> The x-y pair of the point on world.png.
 */
function squiffles_project($lat, $lng) {
  static $width = 0;

  if ($width === 0) {
    $width = getimagesize(SQUIFFLES_MAP_FILE)[0];
  }

  return [
    ($lng + 185) * $width / 333,
    440 - $width * log(tan(M_PI / 4 + $lat * M_PI / 360)) / M_PI / 2 * 1.05
  ];
}
?>
