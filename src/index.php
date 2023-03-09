<?
define('SQUIFFLES_ITEMS_PER_PAGE', 4);

include(__DIR__ . '/../lib/cleverly/Cleverly.class.php');
include(__DIR__ . '/../lib/functions.php');

function squiffles_arc($lat0, $lng0, $lat1, $lng1, $height, $type) {
  list($x0, $y0) = squiffles_project($lat0, $lng0);
  list($x1, $y1) = squiffles_project($lat1, $lng1);
  $x = $x1 - $x0;
  $y = $y1 - $y0;
  $width = sqrt($x * $x + $y * $y);
  $top = ($y0 + $y1 - $height) / 2;
  $left = ($x0 + $x1 - $width) / 2;
  $theta = atan2($y, $x) * 180 / M_PI;
  $transform = sprintf('transform: rotate(%.2fdeg);', $theta);

  return [
    'style' => sprintf(
      'width: %.2fem; height: %.2fem; top: %.2fem; left: %.2fem; -webkit-%s ' .
          '-moz-%s %s',
      $width / 20,
      $height / 20,
      $top / 20,
      $left / 20,
      $transform,
      $transform,
      $transform
    ),
    'type' => $type
  ];
}

function squiffles_point($lat, $lng, $label, $right) {
  list($x, $y) = squiffles_project($lat, $lng);

  return [
    'label' => $label,
    'side' => $right ? 'right' : 'left',
    'style' => sprintf(
      'top: %.2fem; left: %.2fem;',
      $y / SQUIFFLES_PX_PER_EM,
      $x / SQUIFFLES_PX_PER_EM
    )
  ];
}

function squiffles_showcase($items) {
  $pages = [];

  $page_count = (int)(
    (count($items) + SQUIFFLES_ITEMS_PER_PAGE - 1) / SQUIFFLES_ITEMS_PER_PAGE
  );

  foreach ($items as $item_number => $item) {
    if ($item_number % SQUIFFLES_ITEMS_PER_PAGE === 0) {
      $page_number = (int)($item_number / 4);

      $pages[$page_number] = [
        'id' => $page_number,
        'next' => $page_number === $page_count - 1
          ? 0
          : $page_number + 1,
        'previous' => $page_number === 0
          ? $page_count - 1
          : $page_number - 1,
        'thumbnails' => []
      ];
    }

    $pages[$page_number]['thumbnails'][] = $item + ['id' => $item_number];
    $pages[$page_number]['padding'] = [];
  }

  $pages[$page_number]['padding'] = array_fill(
    0,
    SQUIFFLES_ITEMS_PER_PAGE - 1 -
        (count($items) + SQUIFFLES_ITEMS_PER_PAGE - 1) %
        SQUIFFLES_ITEMS_PER_PAGE,
    null
  );

  return $pages;
}

$arcs = [
  squiffles_arc(45.5051, -122.6750, 34.0522, -118.2437,  20, 'plane'), // 2013-04-23
  squiffles_arc(45.5051, -122.6750, 34.0522, -118.2437,  30, 'plane'), // 2013-04-28
  squiffles_arc(45.5051, -122.6750, 31.2304,  121.4737, 150, 'plane'), // 2014-09-09
  squiffles_arc(45.5051, -122.6750, 31.2304,  121.4737, 165, 'plane'), // 2014-09-24
  squiffles_arc(34.0522, -118.2437, 37.7749, -122.4194,   5, 'plane'), // 2015-01-11
  squiffles_arc(37.7749, -122.4194, 34.0522, -118.2437,  20, 'plane'), // 2015-01-12
  squiffles_arc(49.2827, -123.1207, 34.0522, -118.2437,  45, 'plane'), // 2015-03-31
  squiffles_arc(45.5051, -122.6750, 25.7617,  -80.1918,  60, 'plane'), // 2015-09-10
  squiffles_arc(45.5051, -122.6750, 25.7617,  -80.1918,  75, 'plane'), // 2015-09-19
  squiffles_arc( 4.7110,  -74.0721, 34.0522, -118.2437,  45, 'plane'), // 2016-03-07
  squiffles_arc( 4.7110,  -74.0721, 34.0522, -118.2437,  60, 'plane'), // 2016-03-11
  squiffles_arc(49.2827, -123.1207, 34.0522, -118.2437,  55, 'plane'), // 2016-03-16
  squiffles_arc(39.7392, -104.9903, 34.0522, -118.2437,  30, 'plane'), // 2016-06-17
  squiffles_arc(34.0522, -118.2437, 51.5074,    0.1278,  30, 'plane'), // 2016-12-03
  squiffles_arc(34.0522, -118.2437, 51.5074,    0.1278,  45, 'plane'), // 2016-12-09
  squiffles_arc(45.5051, -122.6750, 36.1699, -115.1398,  35, 'plane'), // 2016-12-25
  squiffles_arc(45.5051, -122.6750, 36.1699, -115.1398,  45, 'plane'), // 2016-12-28
  squiffles_arc(41.8781,  -87.6298, 34.0522, -118.2437,  45, 'plane'), // 2016-02-03
  squiffles_arc(41.8781,  -87.6298, 34.0522, -118.2437,  60, 'plane'), // 2016-02-07
  squiffles_arc(35.6762,  139.6503, 34.0522, -118.2437, 165, 'plane'), // 2017-03-19
  squiffles_arc(35.6762,  139.6503, 34.0522, -118.2437, 180, 'plane'), // 2017-03-29
  squiffles_arc(31.2304,  121.4737, 44.4268,   26.1025,  60, 'plane'), // 2017-07-02
  squiffles_arc(44.7866,   20.4489, 34.0522, -118.2437, 120, 'plane'), // 2017-07-21
  squiffles_arc(37.7749, -122.4194, 53.3498,   -6.2603, 135, 'plane'), // 2017-10-21
  squiffles_arc(53.3498,   -6.2603, 50.0755,   14.4378,  45, 'plane'), // 2017-10-29
  squiffles_arc(48.1351,   11.5820, 37.7749, -122.4194,  45, 'plane'), // 2017-11-03
  squiffles_arc(37.7749, -122.4194, 39.7392, -104.9903,  40, 'plane'), // 2017-11-18
  squiffles_arc(37.7749, -122.4194, 39.7392, -104.9903,  50, 'plane'), // 2017-11-20
  squiffles_arc(37.7749, -122.4194, 36.1699, -115.1398,  15, 'plane'), // 2017-12-02
  squiffles_arc(37.7749, -122.4194, 36.1699, -115.1398,  25, 'plane'), // 2017-12-04
  squiffles_arc(37.7749, -122.4194, 45.5051, -122.6750,  25, 'plane'), // 2017-12-22
  squiffles_arc(37.7749, -122.4194, 45.5051, -122.6750,  35, 'plane'), // 2018-01-04
  squiffles_arc(37.7749, -122.4194, 35.0844, -106.6504,  40, 'plane'), // 2018-01-13
  squiffles_arc(37.7749, -122.4194, 35.0844, -106.6504,  50, 'plane'), // 2018-01-16
  squiffles_arc(37.7749, -122.4194, 47.6062, -122.3321,  50, 'plane'), // 2018-03-16
  squiffles_arc(47.6062, -122.3321, 53.3498,   -6.2603,  60, 'plane'), // 2018-03-19
  squiffles_arc(53.3498,   -6.2603, 45.4408,   12.3155,  45, 'plane'), // 2018-03-24
  squiffles_arc(41.9028,   12.4964, 37.7749, -122.4194,  75, 'plane'), // 2018-03-31
  squiffles_arc(32.7767,  -96.7970, 37.7749, -122.4194,  70, 'plane'), // 2018-06-24
  squiffles_arc(32.7767,  -96.7970, 37.7749, -122.4194,  80, 'plane'), // 2018-06-27
  squiffles_arc(33.5731,   -7.5898, 37.7749, -122.4194,  60, 'plane'), // 2018-09-01
  squiffles_arc(33.5731,   -7.5898, 37.7749, -122.4194,  75, 'plane'), // 2018-09-07
  squiffles_arc(37.7749, -122.4194, 59.9139,   10.7522, 165, 'plane'), // 2018-09-15
  squiffles_arc(59.9139,   10.7522, 56.5047,   21.0108,  30, 'plane'), // 2018-09-16
  squiffles_arc(37.7749, -122.4194, 56.5047,   21.0108, 165, 'plane'), // 2018-09-26
  squiffles_arc(27.9506,  -82.4572, 37.7749, -122.4194, 105, 'plane'), // 2018-10-07
  squiffles_arc(27.9506,  -82.4572, 37.7749, -122.4194, 120, 'plane'), // 2018-10-09
  squiffles_arc(32.7767,  -96.7970, 34.0522, -118.2437,  30, 'plane'), // 2019-01-07
  squiffles_arc( 3.1390,  101.6869, 37.7749, -122.4194, 120, 'plane'), // 2019-01-19
  squiffles_arc( 6.3500,   99.8000, 37.7749, -122.4194, 120, 'plane'), // 2019-01-19
  squiffles_arc(37.7749, -122.4194, 52.2297,   21.0122,  60, 'plane'), // 2019-03-31
  squiffles_arc(37.7749, -122.4194, 52.2297,   21.0122,  75, 'plane'), // 2019-04-14
  squiffles_arc(30.2672,  -97.7431, 37.7749, -122.4194,  75, 'plane'), // 2019-10-13
  squiffles_arc(40.4406,  -79.9959, 30.2672,  -97.7431,  30, 'plane'), // 2019-10-19
  squiffles_arc(32.7157, -117.1611, 37.7749, -122.4194,  60, 'plane'), // 2019-11-16
  squiffles_arc(39.7392, -104.9903, 34.0522, -118.2437,  20, 'plane'), // 2019-11-23
  squiffles_arc(37.9838,   23.7275, 37.7749, -122.4194, 120, 'plane'), // 2020-01-05
  squiffles_arc(47.4979,   19.0402, 37.9838,   23.7275,  25, 'plane'), // 2020-01-10
  squiffles_arc(43.7102,    7.2620, 47.4979,   19.0402,  25, 'plane'), // 2020-01-17
  squiffles_arc(45.5051, -122.6750, 48.8566,    2.3522,  30, 'plane'), // 2020-01-23
  squiffles_arc(45.5051, -122.6750, 40.4406,  -79.9959,  35, 'plane'), // 2020-01-26
  squiffles_arc(39.7392, -104.9903, 40.4406,  -79.9959,  40, 'plane'), // 2020-03-10
  squiffles_arc(47.6062, -122.3321, 40.4406,  -79.9959,  45, 'plane'), // 2020-09-15
  squiffles_arc(21.3069, -157.8583, 47.6062, -122.3321,  60, 'plane'), // 2020-09-16
  squiffles_arc(21.3069, -157.8583, 45.5051, -122.6750,  50, 'plane'), // 2020-11-16
  squiffles_arc(45.5051, -122.6750, 39.7392, -104.9903,  25, 'plane'), // 2021-01-15
  squiffles_arc(45.5051, -122.6750, 41.8781,  -87.6298,  25, 'plane'), // 2021-06-17
  squiffles_arc(45.5051, -122.6750, 41.8781,  -87.6298,  15, 'plane'), // 2021-06-20
  squiffles_arc(45.5051, -122.6750, 49.2827, -123.1207,  20, 'plane'), // 2021-09-19
  squiffles_arc(49.2827, -123.1207, 40.4406,  -79.9959,  45, 'plane'), // 2021-10-19
  squiffles_arc(45.5051, -122.6750, 40.7306,  -73.9352,  60, 'plane'), // 2021-11-25
  squiffles_arc(40.7306,  -73.9352, 37.7749, -122.4194,  10, 'plane'), // 2021-12-06
  squiffles_arc(40.7306,  -73.9352, 37.7749, -122.4194,  20, 'plane'), // 2021-12-17
  squiffles_arc(40.4406,  -79.9959, 37.7749, -122.4194,  40, 'plane'), // 2022-01-15
  squiffles_arc(51.0458, -114.0575, 40.7306,  -73.9352,  60, 'plane'), // 2022-03-21
  squiffles_arc(47.6062, -122.3321, 51.0458, -114.0575,  15, 'plane'), // 2022-03-27
  squiffles_arc(47.6062, -122.3321, 40.7306,  -73.9352,  75, 'plane'), // 2022-03-31
  squiffles_arc(45.5051, -122.6750, 40.7306,  -73.9352,  70, 'plane'), // 2022-05-12
  squiffles_arc(47.6062, -122.3321, 40.4406,  -79.9959,  35, 'plane'), // 2022-07-27
  squiffles_arc(37.7749, -122.4194, 53.3498,   -6.2603, 120, 'plane'), // 2022-08-09
  squiffles_arc(53.3498,   -6.2603, 40.7306,  -73.9352,  30, 'plane'), // 2022-08-17
  squiffles_arc(40.4406,  -79.9959, 40.7306,  -73.9352,  10, 'plane'), // 2022-08-20
  squiffles_arc(40.4406,  -79.9959, 40.7306,  -73.9352,  20, 'plane'), // 2022-09-10
  squiffles_arc(40.4406,  -79.9959, 34.0522, -118.2437,  35, 'plane'), // 2022-10-26
  squiffles_arc(35.0044, -118.9495, 34.0522, -118.2437,   5, 'thumb'), // 2014-11-06
  squiffles_arc(37.7749, -122.4194, 35.0044, -118.9495,  10, 'thumb'), // 2014-11-07
  squiffles_arc(38.5816, -121.4944, 34.0522, -118.2437,  25, 'thumb'), // 2015-03-23
  squiffles_arc(44.0521, -123.0868, 38.5816, -121.4944,  10, 'thumb'), // 2015-03-24
  squiffles_arc(45.5051, -122.6750, 44.0521, -123.0868,  10, 'thumb'), // 2015-03-25
  squiffles_arc(47.6062, -122.3321, 45.5051, -122.6750,  10, 'thumb'), // 2015-03-27
  squiffles_arc(49.2827, -123.1207, 47.6062, -122.3321,  10, 'thumb'), // 2015-03-29
  squiffles_arc(34.0522, -118.2437, 35.4894, -120.6707,  10, 'thumb'), // 2015-07-03
  squiffles_arc(35.4894, -120.6707, 37.7749, -122.4194,  10, 'thumb'), // 2015-07-04
  squiffles_arc(34.0522, -118.2437, 37.7749, -122.4194,  30, 'thumb'), // 2015-08-22
  squiffles_arc(34.0522, -118.2437, 37.7749, -122.4194,  45, 'thumb'), // 2015-11-21
  squiffles_arc(49.2827, -123.1207, 47.9790, -122.2021,  25, 'thumb'), // 2016-03-18
  squiffles_arc(47.9790, -122.2021, 45.5051, -122.6750,  25, 'thumb'), // 2016-03-19
  squiffles_arc(45.5051, -122.6750, 47.6062, -122.3321,  10, 'thumb'), // 2016-03-20
  squiffles_arc(47.6062, -122.3321, 49.2827, -123.1207,  10, 'thumb'), // 2016-03-21
  squiffles_arc(36.1699, -115.1398, 34.0522, -118.2437,  10, 'thumb'), // 2016-06-12
  squiffles_arc(36.1699, -115.1398, 38.7725, -112.0841,  15, 'thumb'), // 2016-06-13
  squiffles_arc(38.7725, -112.0841, 39.7392, -104.9903,  20, 'thumb'), // 2016-06-14
  squiffles_arc(35.6762,  139.6503, 34.6937,  135.5023,  10, 'thumb'), // 2017-03-21
  squiffles_arc(34.6937,  135.5023, 35.6762,  139.6503,  10, 'thumb'), // 2017-03-24
  squiffles_arc(44.4268,   26.1025, 45.6427,   25.5887,  10, 'thumb'), // 2017-07-05
  squiffles_arc(45.6427,   25.5887, 44.1598,   28.6348,  10, 'thumb'), // 2017-07-07
  squiffles_arc(44.1598,   28.6348, 43.2141,   27.9147,  15, 'thumb'), // 2017-07-11
  squiffles_arc(43.2141,   27.9147, 41.9981,   21.4254,  20, 'thumb'), // 2017-07-13
  squiffles_arc(41.9981,   21.4254, 42.6629,   21.1655,   5, 'thumb'), // 2017-07-16
  squiffles_arc(39.1677, -120.1452, 37.7749, -122.4194,  10, 'thumb'), // 2017-09-02
  squiffles_arc(37.7749, -122.4194, 39.1677, -120.1452,  10, 'thumb'), // 2017-09-03
  squiffles_arc(45.4408,   12.3155, 44.4949,   11.3426,  10, 'thumb'), // 2018-03-26
  squiffles_arc(33.5731,   -7.5898, 31.6295,   -7.9811,  10, 'thumb'), // 2018-09-08
  squiffles_arc(55.9202,   21.0678, 56.5047,   21.0108,   5, 'thumb'), // 2018-09-21
  squiffles_arc( 3.1390,  101.6869,  5.4380,  100.3882,  10, 'thumb'), // 2019-01-26
  squiffles_arc(36.1699, -115.1398, 34.0522, -118.2437,  25, 'thumb')  // 2019-08-11
];

$points = [
  squiffles_point(39.9042,  116.4074, 'Beijing, China', false),
  squiffles_point(34.0522, -118.2437, 'Los Angeles, California', true),
  squiffles_point(31.9802,  120.8943, 'Nantong, China', false),
  squiffles_point(40.4406,  -79.9959, 'Pittsburgh, Pennsylvania', false),
  squiffles_point(45.5051, -122.6750, 'Portland, Oregon', false),
  squiffles_point(40.2338, -111.6585, 'Provo, Utah', false),
  squiffles_point(37.7749, -122.4194, 'San Francisco, California', false),
  squiffles_point(21.4360, -158.1849, 'Waianae, Hawaii', true),
  squiffles_point(39.2467, -106.2935, 'Leadville, Colorado', true),
  squiffles_point(49.2827, -123.1207, 'Vancouver, British Columbia', true),
  squiffles_point(40.7306,  -73.9352, 'New York, New York', true),
];

$pages = squiffles_showcase([
  [
    'description' =>
        'This is a custom sign-up experience built for a one-day cyberpunk-themed puzzle hunt called Project Hyperskelion.',
    'image' => '/bin/images/showcase_hyper.gif'
  ],
  [
    'description' =>
        'This is an online grasp solver for point contacts with friction (PCWF). Check it out <a href="/force-closure/">online</a> or <a href="https://github.com/deeptoaster/force-closure">on GitHub</a>!',
    'image' => '/bin/images/showcase_pcwf.gif'
  ],
  [
    'description' =>
        'Poster designed for We\'re All Mad Here, a one-day puzzle hunt in 2018.',
    'image' => '/bin/images/showcase_mad.png'
  ],
  [
    'description' =>
        'One of my first projects to gain traction online, <a href="https://www.polygon.com/gaming/2012/9/28/3422822/fruit-ninja-gets-all-scientific-on-this-ti-83-plus-calculator">Fruit Ninja on a TI-83 Plus</a> is a real game for the graphing calculator series.',
    'image' => '/bin/images/showcase_ninja.gif'
  ],
  [
    'description' =>
        'An early webapp built for the graphing calculator community, the <a href="https://clrhome.org/ies/">Integrated Editor System</a> is an IDE for creating TI-83 Plus&ndash;series calculator programs and other variables online.',
    'image' => '/bin/images/showcase_ies.png'
  ],
  [
    'description' =>
        'This is a <a href="https://blacker.caltech.edu/">website and complete suite of administrative apps</a> built for Blacker Hovse, one of the eight undergraduate houses at Caltech.',
    'image' => '/bin/images/showcase_blacker.png'
  ],
  [
    'description' =>
        'Poster designed for Hornsdale, a one-day puzzle hunt in 2017.',
    'image' => '/bin/images/showcase_hornsdale.png'
  ],
  [
    'description' =>
        'Header of an infographic designed in 2016.',
    'image' => '/bin/images/showcase_real.png'
  ]
]);

$cleverly = new Cleverly();
$cleverly->preserveIndent = true;
$cleverly->setTemplateDir(__DIR__ . '/templates');
ob_start();

include(__DIR__ . '/coaster.php');

$coaster = ob_get_clean();

$cleverly->display('index.tpl', [
  'arcs' => $arcs,
  'blip' => $cleverly->fetch(
    'string:' . SQUIFFLES_BLIP_TEMPLATE,
    ['left' => 99, 'top' => 99]
  ),
  'coaster' => $coaster,
  'date' => strftime('%F'),
  'points' => $points,
  'pages' => $pages,
  'root' => $config['root'],
  'title' => 'Deep Toaster'
]);
?>
