<?
namespace Squiffles;

define('Squiffles\ITEMS_PER_PAGE', 4);

include(__DIR__ . '/../lib/cleverly/Cleverly.class.php');
include(__DIR__ . '/../lib/functions.php');

function squiffles_arc($city0, $city1, $height, $type) {
  list($x0, $y0) = squiffles_project($city0);
  list($x1, $y1) = squiffles_project($city1);
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

function squiffles_point($city, $label, $right) {
  list($x, $y) = squiffles_project($city);

  return [
    'label' => $label,
    'side' => $right ? 'right' : 'left',
    'style' => sprintf(
      'top: %.2fem; left: %.2fem;',
      $y / PX_PER_EM,
      $x / PX_PER_EM
    )
  ];
}

function squiffles_showcase($items) {
  $pages = [];
  $page_count = (int)((count($items) + ITEMS_PER_PAGE - 1) / ITEMS_PER_PAGE);

  foreach ($items as $item_number => $item) {
    if ($item_number % ITEMS_PER_PAGE === 0) {
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
    ITEMS_PER_PAGE - 1 - (count($items) + ITEMS_PER_PAGE - 1) % ITEMS_PER_PAGE,
    null
  );

  return $pages;
}

$arcs = [
  squiffles_arc(City::PORTLAND, City::LOS_ANGELES, 20, 'plane'), // 2013-04-23
  squiffles_arc(City::PORTLAND, City::LOS_ANGELES, 30, 'plane'), // 2013-04-28
  squiffles_arc(City::PORTLAND, City::SHANGHAI, 150, 'plane'), // 2014-09-09
  squiffles_arc(City::PORTLAND, City::SHANGHAI, 165, 'plane'), // 2014-09-24
  squiffles_arc(City::LOS_ANGELES, City::SAN_FRANCISCO, 5, 'plane'), // 2015-01-11
  squiffles_arc(City::SAN_FRANCISCO, City::LOS_ANGELES, 20, 'plane'), // 2015-01-12
  squiffles_arc(City::VANCOUVER, City::LOS_ANGELES, 45, 'plane'), // 2015-03-31
  squiffles_arc(City::PORTLAND, City::MIAMI, 60, 'plane'), // 2015-09-10
  squiffles_arc(City::PORTLAND, City::MIAMI, 75, 'plane'), // 2015-09-19
  squiffles_arc(City::BOGOTA, City::LOS_ANGELES, 45, 'plane'), // 2016-03-07
  squiffles_arc(City::BOGOTA, City::LOS_ANGELES, 60, 'plane'), // 2016-03-11
  squiffles_arc(City::VANCOUVER, City::LOS_ANGELES, 55, 'plane'), // 2016-03-16
  squiffles_arc(City::DENVER, City::LOS_ANGELES, 30, 'plane'), // 2016-06-17
  squiffles_arc(City::LOS_ANGELES, City::LONDON, 30, 'plane'), // 2016-12-03
  squiffles_arc(City::LOS_ANGELES, City::LONDON, 45, 'plane'), // 2016-12-09
  squiffles_arc(City::PORTLAND, City::LAS_VEGAS, 35, 'plane'), // 2016-12-25
  squiffles_arc(City::PORTLAND, City::LAS_VEGAS, 45, 'plane'), // 2016-12-28
  squiffles_arc(City::CHICAGO, City::LOS_ANGELES, 45, 'plane'), // 2016-02-03
  squiffles_arc(City::CHICAGO, City::LOS_ANGELES, 60, 'plane'), // 2016-02-07
  squiffles_arc(City::TOKYO, City::LOS_ANGELES, 165, 'plane'), // 2017-03-19
  squiffles_arc(City::TOKYO, City::LOS_ANGELES, 180, 'plane'), // 2017-03-29
  squiffles_arc(City::SHANGHAI, City::BUCHAREST, 60, 'plane'), // 2017-07-02
  squiffles_arc(City::BELGRADE, City::LOS_ANGELES, 120, 'plane'), // 2017-07-21
  squiffles_arc(City::SAN_FRANCISCO, City::DUBLIN, 135, 'plane'), // 2017-10-21
  squiffles_arc(City::DUBLIN, City::PRAGUE, 45, 'plane'), // 2017-10-29
  squiffles_arc(City::MUNICH, City::SAN_FRANCISCO, 45, 'plane'), // 2017-11-03
  squiffles_arc(City::SAN_FRANCISCO, City::DENVER, 40, 'plane'), // 2017-11-18
  squiffles_arc(City::SAN_FRANCISCO, City::DENVER, 50, 'plane'), // 2017-11-20
  squiffles_arc(City::SAN_FRANCISCO, City::LAS_VEGAS, 15, 'plane'), // 2017-12-02
  squiffles_arc(City::SAN_FRANCISCO, City::LAS_VEGAS, 25, 'plane'), // 2017-12-04
  squiffles_arc(City::SAN_FRANCISCO, City::PORTLAND, 25, 'plane'), // 2017-12-22
  squiffles_arc(City::SAN_FRANCISCO, City::PORTLAND, 35, 'plane'), // 2018-01-04
  squiffles_arc(City::SAN_FRANCISCO, City::ALBUQUERQUE, 40, 'plane'), // 2018-01-13
  squiffles_arc(City::SAN_FRANCISCO, City::ALBUQUERQUE, 50, 'plane'), // 2018-01-16
  squiffles_arc(City::SAN_FRANCISCO, City::SEATTLE, 45, 'plane'), // 2018-03-16
  squiffles_arc(City::SEATTLE, City::DUBLIN, 60, 'plane'), // 2018-03-19
  squiffles_arc(City::DUBLIN, City::VENICE, 45, 'plane'), // 2018-03-24
  squiffles_arc(City::ROME, City::SAN_FRANCISCO, 75, 'plane'), // 2018-03-31
  squiffles_arc(City::DALLAS, City::SAN_FRANCISCO, 75, 'plane'), // 2018-06-24
  squiffles_arc(City::DALLAS, City::SAN_FRANCISCO, 85, 'plane'), // 2018-06-27
  squiffles_arc(City::CASABLANCA, City::SAN_FRANCISCO, 60, 'plane'), // 2018-09-01
  squiffles_arc(City::CASABLANCA, City::SAN_FRANCISCO, 75, 'plane'), // 2018-09-07
  squiffles_arc(City::SAN_FRANCISCO, City::OSLO, 165, 'plane'), // 2018-09-15
  squiffles_arc(City::OSLO, City::RIGA, 30, 'plane'), // 2018-09-16
  squiffles_arc(City::SAN_FRANCISCO, City::RIGA, 165, 'plane'), // 2018-09-26
  squiffles_arc(City::TAMPA, City::SAN_FRANCISCO, 105, 'plane'), // 2018-10-07
  squiffles_arc(City::TAMPA, City::SAN_FRANCISCO, 120, 'plane'), // 2018-10-09
  squiffles_arc(City::DALLAS, City::LOS_ANGELES, 30, 'plane'), // 2019-01-07
  squiffles_arc(City::KUALA_LUMPUR, City::SAN_FRANCISCO, 120, 'plane'), // 2019-01-19
  squiffles_arc(City::LANGKAWI, City::SAN_FRANCISCO, 120, 'plane'), // 2019-01-19
  squiffles_arc(City::SAN_FRANCISCO, City::WARSAW, 60, 'plane'), // 2019-03-31
  squiffles_arc(City::SAN_FRANCISCO, City::WARSAW, 75, 'plane'), // 2019-04-14
  squiffles_arc(City::AUSTIN, City::SAN_FRANCISCO, 80, 'plane'), // 2019-10-13
  squiffles_arc(City::PITTSBURGH, City::AUSTIN, 30, 'plane'), // 2019-10-19
  squiffles_arc(City::SAN_DIEGO, City::SAN_FRANCISCO, 60, 'plane'), // 2019-11-16
  squiffles_arc(City::DENVER, City::LOS_ANGELES, 20, 'plane'), // 2019-11-23
  squiffles_arc(City::ATHENS, City::SAN_FRANCISCO, 120, 'plane'), // 2020-01-05
  squiffles_arc(City::BUDAPEST, City::ATHENS, 25, 'plane'), // 2020-01-10
  squiffles_arc(City::NICE, City::BUDAPEST, 25, 'plane'), // 2020-01-17
  squiffles_arc(City::PORTLAND, City::PARIS, 30, 'plane'), // 2020-01-23
  squiffles_arc(City::PORTLAND, City::PITTSBURGH, 35, 'plane'), // 2020-01-26
  squiffles_arc(City::DENVER, City::PITTSBURGH, 40, 'plane'), // 2020-03-10
  squiffles_arc(City::SEATTLE, City::PITTSBURGH, 45, 'plane'), // 2020-09-15
  squiffles_arc(City::HONOLULU, City::SEATTLE, 60, 'plane'), // 2020-09-16
  squiffles_arc(City::HONOLULU, City::PORTLAND, 50, 'plane'), // 2020-11-16
  squiffles_arc(City::PORTLAND, City::DENVER, 25, 'plane'), // 2021-01-15
  squiffles_arc(City::PORTLAND, City::CHICAGO, 25, 'plane'), // 2021-06-17
  squiffles_arc(City::PORTLAND, City::CHICAGO, 15, 'plane'), // 2021-06-20
  squiffles_arc(City::PORTLAND, City::VANCOUVER, 25, 'plane'), // 2021-09-19
  squiffles_arc(City::VANCOUVER, City::PITTSBURGH, 45, 'plane'), // 2021-10-19
  squiffles_arc(City::PORTLAND, City::NEW_YORK, 60, 'plane'), // 2021-11-25
  squiffles_arc(City::NEW_YORK, City::SAN_FRANCISCO, 10, 'plane'), // 2021-12-06
  squiffles_arc(City::NEW_YORK, City::SAN_FRANCISCO, 20, 'plane'), // 2021-12-17
  squiffles_arc(City::PITTSBURGH, City::SAN_FRANCISCO, 35, 'plane'), // 2022-01-15
  squiffles_arc(City::CALGARY, City::NEW_YORK, 60, 'plane'), // 2022-03-21
  squiffles_arc(City::SEATTLE, City::CALGARY, 15, 'plane'), // 2022-03-27
  squiffles_arc(City::SEATTLE, City::NEW_YORK, 75, 'plane'), // 2022-03-31
  squiffles_arc(City::PORTLAND, City::NEW_YORK, 70, 'plane'), // 2022-05-12
  squiffles_arc(City::SEATTLE, City::PITTSBURGH, 35, 'plane'), // 2022-07-27
  squiffles_arc(City::SAN_FRANCISCO, City::DUBLIN, 120, 'plane'), // 2022-08-09
  squiffles_arc(City::DUBLIN, City::NEW_YORK, 30, 'plane'), // 2022-08-17
  squiffles_arc(City::PITTSBURGH, City::NEW_YORK, 10, 'plane'), // 2022-08-20
  squiffles_arc(City::PITTSBURGH, City::NEW_YORK, 20, 'plane'), // 2022-09-10
  squiffles_arc(City::PITTSBURGH, City::LOS_ANGELES, 35, 'plane'), // 2022-10-26
  squiffles_arc(City::PITTSBURGH, City::NASHVILLE, 15, 'plane'), // 2022-11-17
  squiffles_arc(City::NEW_YORK, City::MINNEAPOLIS, 45, 'plane'), // 2022-11-21
  squiffles_arc(City::SEATTLE, City::VANCOUVER, 20, 'plane'), // 2023-01-03
  squiffles_arc(City::SAN_FRANCISCO, City::VANCOUVER, 60, 'plane'), // 2023-01-06
  squiffles_arc(City::SAN_FRANCISCO, City::SEATTLE, 55, 'plane'), // 2023-04-30
  squiffles_arc(City::PITTSBURGH, City::BOSTON, 30, 'plane'), // 2023-06-03
  squiffles_arc(City::PITTSBURGH, City::BOSTON, 45, 'plane'), // 2023-06-04
  squiffles_arc(City::PITTSBURGH, City::LOS_ANGELES, 45, 'plane'), // 2023-08-13
  squiffles_arc(City::PITTSBURGH, City::SAN_FRANCISCO, 45, 'plane'), // 2023-10-19
  squiffles_arc(City::NEW_YORK, City::LOS_ANGELES, 75, 'plane'), // 2023-12-15
  squiffles_arc(City::NEW_YORK, City::LOS_ANGELES, 95, 'plane'), // 2024-01-21
  squiffles_arc(City::HONG_KONG, City::LOS_ANGELES, 160, 'plane'), // 2024-01-28
  squiffles_arc(City::HONG_KONG, City::SHANGHAI, 20, 'plane'), // 2024-01-30
  squiffles_arc(City::GENEVA, City::SHANGHAI, 60, 'plane'), // 2024-02-13
  squiffles_arc(City::NEW_YORK, City::MILAN, 45, 'plane'), // 2024-02-13
  squiffles_arc(City::WHEELER_RIDGE, City::LOS_ANGELES, 5, 'thumb'), // 2014-11-06
  squiffles_arc(City::SAN_FRANCISCO, City::WHEELER_RIDGE, 10, 'thumb'), // 2014-11-07
  squiffles_arc(City::SACRAMENTO, City::LOS_ANGELES, 25, 'thumb'), // 2015-03-23
  squiffles_arc(City::EUGENE, City::SACRAMENTO, 10, 'thumb'), // 2015-03-24
  squiffles_arc(City::PORTLAND, City::EUGENE, 10, 'thumb'), // 2015-03-25
  squiffles_arc(City::SEATTLE, City::PORTLAND, 10, 'thumb'), // 2015-03-27
  squiffles_arc(City::VANCOUVER, City::SEATTLE, 10, 'thumb'), // 2015-03-29
  squiffles_arc(City::LOS_ANGELES, City::ATASCADERO, 10, 'thumb'), // 2015-07-03
  squiffles_arc(City::ATASCADERO, City::SAN_FRANCISCO, 10, 'thumb'), // 2015-07-04
  squiffles_arc(City::LOS_ANGELES, City::SAN_FRANCISCO, 30, 'thumb'), // 2015-08-22
  squiffles_arc(City::LOS_ANGELES, City::SAN_FRANCISCO, 45, 'thumb'), // 2015-11-21
  squiffles_arc(City::VANCOUVER, City::EVERETT, 25, 'thumb'), // 2016-03-18
  squiffles_arc(City::EVERETT, City::PORTLAND, 25, 'thumb'), // 2016-03-19
  squiffles_arc(City::PORTLAND, City::SEATTLE, 10, 'thumb'), // 2016-03-20
  squiffles_arc(City::SEATTLE, City::VANCOUVER, 10, 'thumb'), // 2016-03-21
  squiffles_arc(City::LAS_VEGAS, City::LOS_ANGELES, 10, 'thumb'), // 2016-06-12
  squiffles_arc(City::LAS_VEGAS, City::RICHFIELD, 15, 'thumb'), // 2016-06-13
  squiffles_arc(City::RICHFIELD, City::DENVER, 20, 'thumb'), // 2016-06-14
  squiffles_arc(City::TOKYO, City::OSAKA, 10, 'thumb'), // 2017-03-21
  squiffles_arc(City::OSAKA, City::TOKYO, 10, 'thumb'), // 2017-03-24
  squiffles_arc(City::BUCHAREST, City::BRASOV, 10, 'thumb'), // 2017-07-05
  squiffles_arc(City::BRASOV, City::CONSTANTA, 10, 'thumb'), // 2017-07-07
  squiffles_arc(City::CONSTANTA, City::VARNA, 15, 'thumb'), // 2017-07-11
  squiffles_arc(City::VARNA, City::SKOPJE, 20, 'thumb'), // 2017-07-13
  squiffles_arc(City::SKOPJE, City::PRISTINA, 5, 'thumb'), // 2017-07-16
  squiffles_arc(City::TAHOE_CITY, City::SAN_FRANCISCO, 10, 'thumb'), // 2017-09-02
  squiffles_arc(City::SAN_FRANCISCO, City::TAHOE_CITY, 10, 'thumb'), // 2017-09-03
  squiffles_arc(City::VENICE, City::BOLOGNA, 10, 'thumb'), // 2018-03-26
  squiffles_arc(City::CASABLANCA, City::MARRAKESH, 10, 'thumb'), // 2018-09-08
  squiffles_arc(City::PALANGA, City::LIEPAJA, 5, 'thumb'), // 2018-09-21
  squiffles_arc(City::KUALA_LUMPUR, City::BUTTERWORTH, 10, 'thumb'), // 2019-01-26
  squiffles_arc(City::LAS_VEGAS, City::LOS_ANGELES, 25, 'thumb')  // 2019-08-11
];

$points = [
  squiffles_point(City::BEIJING, 'Beijing, China', false),
  squiffles_point(City::LOS_ANGELES, 'Los Angeles, California', true),
  squiffles_point(City::NANTONG, 'Nantong, China', false),
  squiffles_point(City::PITTSBURGH, 'Pittsburgh, Pennsylvania', false),
  squiffles_point(City::PORTLAND, 'Portland, Oregon', false),
  squiffles_point(City::PROVO, 'Provo, Utah', false),
  squiffles_point(City::SAN_FRANCISCO, 'San Francisco, California', false),
  squiffles_point(City::WAIANAE, 'Waianae, Hawaii', true),
  squiffles_point(City::LEADVILLE, 'Leadville, Colorado', true),
  squiffles_point(City::VANCOUVER, 'Vancouver, British Columbia', true),
  squiffles_point(City::NEW_YORK, 'New York, New York', true)
];

$pages = squiffles_showcase([
  [
    'description' =>
        'Terminal interface built for a one-day action-movie-themed puzzle hunt.',
    'image' => '/bin/images/showcase_action.gif'
  ],
  [
    'description' =>
        'An efficient and easily extensible <a href="https://github.com/deeptoaster/nato-lights">software library</a> and Arduino Uno&ndash;based hardware demo for decorative NeoPixel lighting strips.',
    'image' => '/bin/images/showcase_lights.gif'
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
        'Fishbot, a jellyfish-like mechanism designed and built from machined acrylic and 3D-printed parts for Caltech\'s <a href="https://catalog.caltech.edu/current/2023-24/department/ME/#design-and-fabrication">ME 14</a>.',
    'image' => '/bin/images/showcase_fishbot.gif'
  ],
  [
    'description' =>
        'Online demo of a bunch of <a href="/css/">stupid things</a> you can do with CSS. Check out the <a href="https://fishbotwilleatyou.com/blog/tag/stupid-css/">writeup on the blog</a> or the <a href="https://github.com/deeptoaster/stupid-css">code on GitHub</a>!',
    'image' => '/bin/images/showcase_css.png'
  ],
  [
    'description' =>
        'Custom sign-up experience built for a one-day cyberpunk-themed puzzle hunt called Project Hyperskelion.',
    'image' => '/bin/images/showcase_hyper.gif'
  ],
  [
    'description' =>
        'Online grasp solver for point contacts with friction (PCWF). Check it out <a href="/force-closure/">online</a> or <a href="https://github.com/deeptoaster/force-closure">on GitHub</a>!',
    'image' => '/bin/images/showcase_force-closure.gif'
  ],
  [
    'description' =>
        'Poster designed for Hornsdale, a one-day puzzle hunt in 2017.',
    'image' => '/bin/images/showcase_hornsdale.png'
  ],
  [
    'description' =>
        'A neuomorphic webapp to generate Tasker configs for quantified-self projects. Check it out <a href="/tracker/">online</a> or <a href="https://github.com/deeptoaster/tasker-tracker">on GitHub</a>!',
    'image' => '/bin/images/showcase_tracker.gif'
  ],
  [
    'description' =>
        'Header of an infographic designed in 2016.',
    'image' => '/bin/images/showcase_real.png'
  ],
  [
    'description' =>
        'An early webapp built for the graphing calculator community, the <a href="https://clrhome.org/ies/">Integrated Editor System</a> is an IDE for creating TI-83 Plus&ndash;series calculator programs and other variables online.',
    'image' => '/bin/images/showcase_ies.png'
  ],
  [
    'description' =>
        'A neuomorphic webapp to automatically clean up Last.fm scrobbles. Check it out <a href="/vacuum/">online</a> or <a href="https://github.com/deeptoaster/vacuum">on GitHub</a>!',
    'image' => '/bin/images/showcase_vacuum.gif'
  ],
  [
    'description' =>
        'A <a href="https://clrhome.org/table/">dynamic reference table</a> and API for Z80 assembly instructions.',
    'image' => '/bin/images/showcase_table.png'
  ],
  [
    'description' =>
        '<a href="https://blacker.caltech.edu/">Website and complete suite of administrative apps</a> built for Blacker Hovse, one of the eight undergraduate houses at Caltech.',
    'image' => '/bin/images/showcase_blacker.png'
  ]
]);

$cleverly = new \Cleverly();
$cleverly->preserveIndent = true;
$cleverly->setTemplateDir(__DIR__ . '/templates');
$cleverly->addTemplateDir(__DIR__ . '/common/templates');
ob_start();

include(__DIR__ . '/coaster.php');

$coaster = ob_get_clean();

$cleverly->display('index.tpl', [
  'arcs' => $arcs,
  'blip' => $cleverly->fetch(
    'string:' . BLIP_TEMPLATE,
    ['left' => 99, 'top' => 99]
  ),
  'coaster' => $coaster,
  'date' => strftime('%F'),
  'points' => $points,
  'pages' => $pages,
  'path' => '/',
  'root' => $config['ROOT'],
  'title' => 'Deep Toaster'
]);
?>
