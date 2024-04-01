<?
namespace Squiffles;

define(
  'Squiffles\BLIP_TEMPLATE',
  '<span class="map-blip" style="top: {$top}em; left: {$left}em;"></span>'
);

define('Squiffles\CONFIG_FILE', __DIR__ . '/../.env');
define('Squiffles\MAP_FILE', __DIR__ . '/../bin/images/world.png');
define('Squiffles\PX_PER_EM', 20);
define('Squiffles\TRELLO_PATTERN', '/\bhttps?:\/\/trello.com\/c\/(\w+)/');

$config = parse_ini_file(CONFIG_FILE);

abstract class City {
  const ALBUQUERQUE = [35.0844, -106.6504];
  const ATASCADERO = [35.4894, -120.6707];
  const ATHENS = [37.9838, 23.7275];
  const AUSTIN = [30.2672, -97.7431];
  const BEIJING = [39.9042, 116.4074];
  const BELGRADE = [44.7866, 20.4489];
  const BOGOTA = [4.7110, -74.0721];
  const BOLOGNA = [44.4949, 11.3426];
  const BRASOV = [45.6427, 25.5887];
  const BUCHAREST = [44.4268, 26.1025];
  const BUDAPEST = [47.4979, 19.0402];
  const BUTTERWORTH = [5.4380, 100.3882];
  const CALGARY = [51.0458, -114.0575];
  const CASABLANCA = [33.5731, -7.5898];
  const CHICAGO = [41.8781, -87.6298];
  const CONSTANTA = [44.1598, 28.6348];
  const DALLAS = [32.7767, -96.7970];
  const DENVER = [39.7392, -104.9903];
  const DUBLIN = [53.3498, -6.2603];
  const EUGENE = [44.0521, -123.0868];
  const EVERETT = [47.9790, -122.2021];
  const HONOLULU = [21.3069, -157.8583];
  const KUALA_LUMPUR = [3.1390, 101.6869];
  const LANGKAWI = [6.3500, 99.8000];
  const LAS_VEGAS = [36.1699, -115.1398];
  const LEADVILLE = [39.2467, -106.2935];
  const LIEPAJA = [56.5047, 21.0108];
  const LONDON = [51.5074, 0.1278];
  const LOS_ANGELES = [34.0522, -118.2437];
  const MARRAKESH = [31.6295, -7.9811];
  const MIAMI = [25.7617, -80.1918];
  const MUNICH = [48.1351, 11.5820];
  const NANTONG = [31.9802, 120.8943];
  const NEW_YORK = [40.7306, -73.9352];
  const NICE = [43.7102, 7.2620];
  const OSAKA = [34.6937, 135.5023];
  const OSLO = [59.9139, 10.7522];
  const PALANGA = [55.9202, 21.0678];
  const PARIS = [48.8566, 2.3522];
  const PITTSBURGH = [40.4406, -79.9959];
  const PORTLAND = [45.5051, -122.6750];
  const PRAGUE = [50.0755, 14.4378];
  const PRISTINA = [42.6629, 21.1655];
  const PROVO = [40.2338, -111.6585];
  const RICHFIELD = [38.7725, -112.0841];
  const RIGA = [56.9489, 24.1064];
  const ROME = [41.9028, 12.4964];
  const SACRAMENTO = [38.5816, -121.4944];
  const SAN_DIEGO = [32.7157, -117.1611];
  const SAN_FRANCISCO = [37.7749, -122.4194];
  const SEATTLE = [47.6062, -122.3321];
  const SHANGHAI = [31.2304, 121.4737];
  const SKOPJE = [41.9981, 21.4254];
  const TAHOE_CITY = [39.1677, -120.1452];
  const TAMPA = [27.9506, -82.4572];
  const TOKYO = [35.6762, 139.6503];
  const VANCOUVER = [49.2827, -123.1207];
  const VARNA = [43.2141, 27.9147];
  const VENICE = [45.4408, 12.3155];
  const WAIANAE = [21.4360, -158.1849];
  const WARSAW = [52.2297, 21.0122];
  const WHEELER_RIDGE = [35.0044, -118.9495];
}

/**
 * Creates attachments from a URL on each of a list of Trello cards.
 * @param array<string> $cards The list of card URLs to attach to.
 * @param string $url The URL from which to create attachments.
 */
function squiffles_attach_to_trello($cards, $url) {
  global $config;

  if (!isset($config['TRELLO_KEY']) || !isset($config['TRELLO_TOKEN'])) {
    return;
  }

  $fields = [
    'key' => $config['TRELLO_KEY'],
    'token' => $config['TRELLO_TOKEN'],
    'url' => $url
  ];

  $query = http_build_query([
    'fields' => 'url',
    'key' => $config['TRELLO_KEY'],
    'token' => $config['TRELLO_TOKEN']
  ]);

  $handle = curl_init();
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

  foreach ($cards as $card) {
    if (preg_match(TRELLO_PATTERN, $card, $matches)) {
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
  $stream = fopen(CONFIG_FILE, 'w');

  foreach ($config as $key => $value) {
    fwrite($stream, "$key=\"$value\"\n");
  }

  fclose($stream);
}

/**
 * Retrives a lat-lng pair from the blip spreadsheet.
 * @param number [output] Latitude.
 * @param number [output] Longitude.
 * @return number The HTTP request's response code.
 */
function squiffles_fetch_location(&$latitude, &$longitude) {
  global $config;

  $handle = curl_init();
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_HTTPGET, true);

  curl_setopt($handle, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $config[GOOGLE_ACCESS_TOKEN]"
  ]);

  curl_setopt(
    $handle,
    CURLOPT_URL,
    "https://sheets.googleapis.com/v4/spreadsheets/$config[BLIP_SHEET_ID]/values/'$config[BLIP_SHEET_NAME]'!$config[BLIP_SHEET_RANGE]"
  );

  $response = json_decode(curl_exec($handle));
  $response_code = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);

  if ($response_code === 200) {
    $latitude = (float)$response->values[0][0];
    $longitude = (float)$response->values[0][1];
  }

  curl_close($handle);
  return $response_code;
}

/**
 * Projects a lat-lng pair onto a Mercator map.
 * @param array<number> $lat_lng The lat-lng pair to project.
 * @return array<number> The x-y pair of the point on world.png.
 */
function squiffles_project($lat_lng) {
  static $width = 0;

  if ($width === 0) {
    $width = getimagesize(MAP_FILE)[0];
  }

  list($latitude, $longitude) = $lat_lng;

  return [
    ($longitude + 185) * $width / 333,
    440 -
        $width * log(tan(M_PI / 4 + $latitude * M_PI / 360)) / M_PI / 2 * 1.05
  ];
}
?>
