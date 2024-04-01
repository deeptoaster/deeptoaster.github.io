<?
define(
  'SQUIFFLES_BLIP_TEMPLATE',
  '<span class="map-blip" style="top: {$top}em; left: {$left}em;"></span>'
);

define('SQUIFFLES_CONFIG_FILE', __DIR__ . '/../.env');
define('SQUIFFLES_MAP_FILE', __DIR__ . '/../bin/images/world.png');
define('SQUIFFLES_PX_PER_EM', 20);
define('SQUIFFLES_TRELLO_PATTERN', '/\bhttps?:\/\/trello.com\/c\/(\w+)/');

$config = parse_ini_file(SQUIFFLES_CONFIG_FILE);

$cities = [
  'Albuquerque' => [35.0844, -106.6504],
  'Atascadero' => [35.4894, -120.6707],
  'Athens' => [37.9838, 23.7275],
  'Austin' => [30.2672, -97.7431],
  'Beijing' => [39.9042, 116.4074],
  'Belgrade' => [44.7866, 20.4489],
  'Bogota' => [4.7110, -74.0721],
  'Bologna' => [44.4949, 11.3426],
  'Brasov' => [45.6427, 25.5887],
  'Bucharest' => [44.4268, 26.1025],
  'Budapest' => [47.4979, 19.0402],
  'Butterworth' => [5.4380, 100.3882],
  'Calgary' => [51.0458, -114.0575],
  'Casablanca' => [33.5731, -7.5898],
  'Chicago' => [41.8781, -87.6298],
  'Constanta' => [44.1598, 28.6348],
  'Dallas' => [32.7767, -96.7970],
  'Denver' => [39.7392, -104.9903],
  'Dublin' => [53.3498, -6.2603],
  'Eugene' => [44.0521, -123.0868],
  'Everett' => [47.9790, -122.2021],
  'Honolulu' => [21.3069, -157.8583],
  'Kuala Lumpur' => [3.1390, 101.6869],
  'Langkawi' => [6.3500, 99.8000],
  'Las Vegas' => [36.1699, -115.1398],
  'Leadville' => [39.2467, -106.2935],
  'Liepaja' => [56.5047, 21.0108],
  'London' => [51.5074, 0.1278],
  'Los Angeles' => [34.0522, -118.2437],
  'Marrakesh' => [31.6295, -7.9811],
  'Miami' => [25.7617, -80.1918],
  'Munich' => [48.1351, 11.5820],
  'Nantong' => [31.9802, 120.8943],
  'New York' => [40.7306, -73.9352],
  'Nice' => [43.7102, 7.2620],
  'Osaka' => [34.6937, 135.5023],
  'Oslo' => [59.9139, 10.7522],
  'Palanga' => [55.9202, 21.0678],
  'Paris' => [48.8566, 2.3522],
  'Pittsburgh' => [40.4406, -79.9959],
  'Portland' => [45.5051, -122.6750],
  'Prague' => [50.0755, 14.4378],
  'Pristina' => [42.6629, 21.1655],
  'Provo' => [40.2338, -111.6585],
  'Richfield' => [38.7725, -112.0841],
  'Riga' => [56.9489, 24.1064],
  'Rome' => [41.9028, 12.4964],
  'Sacramento' => [38.5816, -121.4944],
  'San Diego' => [32.7157, -117.1611],
  'San Francisco' => [37.7749, -122.4194],
  'Seattle' => [47.6062, -122.3321],
  'Shanghai' => [31.2304, 121.4737],
  'Skopje' => [41.9981, 21.4254],
  'Tahoe City' => [39.1677, -120.1452],
  'Tampa' => [27.9506, -82.4572],
  'Tokyo' => [35.6762, 139.6503],
  'Vancouver' => [49.2827, -123.1207],
  'Varna' => [43.2141, 27.9147],
  'Venice' => [45.4408, 12.3155],
  'Waianae' => [21.4360, -158.1849],
  'Warsaw' => [52.2297, 21.0122],
  'Wheeler Ridge' => [35.0044, -118.9495]
];

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
 * Finds coordinates of a city on a Mercator projection.
 * @param number|string $city_or_latitude The name of the city or its latitude.
 * @param number $longitude The longitude of the city.
 * @return array<number> The x-y pair of the point on world.png.
 */
function squiffles_project($city_or_latitude, $longitude = 0) {
  global $cities;
  static $width = 0;

  if (is_string($city_or_latitude)) {
    list($latitude, $longitude) = $cities[$city_or_latitude];
  } else {
    $latitude = $city_or_latitude;
  }

  if ($width === 0) {
    $width = getimagesize(SQUIFFLES_MAP_FILE)[0];
  }

  return [
    ($longitude + 185) * $width / 333,
    440 -
        $width * log(tan(M_PI / 4 + $latitude * M_PI / 360)) / M_PI / 2 * 1.05
  ];
}
?>
