<?
define('SQUIFFLES_ITEMS_PER_PAGE', 4);

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
  squiffles_arc('Portland', 'Los Angeles', 20, 'plane'), // 2013-04-23
  squiffles_arc('Portland', 'Los Angeles', 30, 'plane'), // 2013-04-28
  squiffles_arc('Portland', 'Shanghai', 150, 'plane'), // 2014-09-09
  squiffles_arc('Portland', 'Shanghai', 165, 'plane'), // 2014-09-24
  squiffles_arc('Los Angeles', 'San Francisco', 5, 'plane'), // 2015-01-11
  squiffles_arc('San Francisco', 'Los Angeles', 20, 'plane'), // 2015-01-12
  squiffles_arc('Vancouver', 'Los Angeles', 45, 'plane'), // 2015-03-31
  squiffles_arc('Portland', 'Miami', 60, 'plane'), // 2015-09-10
  squiffles_arc('Portland', 'Miami', 75, 'plane'), // 2015-09-19
  squiffles_arc('Bogota', 'Los Angeles', 45, 'plane'), // 2016-03-07
  squiffles_arc('Bogota', 'Los Angeles', 60, 'plane'), // 2016-03-11
  squiffles_arc('Vancouver', 'Los Angeles', 55, 'plane'), // 2016-03-16
  squiffles_arc('Denver', 'Los Angeles', 30, 'plane'), // 2016-06-17
  squiffles_arc('Los Angeles', 'London', 30, 'plane'), // 2016-12-03
  squiffles_arc('Los Angeles', 'London', 45, 'plane'), // 2016-12-09
  squiffles_arc('Portland', 'Las Vegas', 35, 'plane'), // 2016-12-25
  squiffles_arc('Portland', 'Las Vegas', 45, 'plane'), // 2016-12-28
  squiffles_arc('Chicago', 'Los Angeles', 45, 'plane'), // 2016-02-03
  squiffles_arc('Chicago', 'Los Angeles', 60, 'plane'), // 2016-02-07
  squiffles_arc('Tokyo', 'Los Angeles', 165, 'plane'), // 2017-03-19
  squiffles_arc('Tokyo', 'Los Angeles', 180, 'plane'), // 2017-03-29
  squiffles_arc('Shanghai', 'Bucharest', 60, 'plane'), // 2017-07-02
  squiffles_arc('Belgrade', 'Los Angeles', 120, 'plane'), // 2017-07-21
  squiffles_arc('San Francisco', 'Dublin', 135, 'plane'), // 2017-10-21
  squiffles_arc('Dublin', 'Prague', 45, 'plane'), // 2017-10-29
  squiffles_arc('Munich', 'San Francisco', 45, 'plane'), // 2017-11-03
  squiffles_arc('San Francisco', 'Denver', 40, 'plane'), // 2017-11-18
  squiffles_arc('San Francisco', 'Denver', 50, 'plane'), // 2017-11-20
  squiffles_arc('San Francisco', 'Las Vegas', 15, 'plane'), // 2017-12-02
  squiffles_arc('San Francisco', 'Las Vegas', 25, 'plane'), // 2017-12-04
  squiffles_arc('San Francisco', 'Portland', 25, 'plane'), // 2017-12-22
  squiffles_arc('San Francisco', 'Portland', 35, 'plane'), // 2018-01-04
  squiffles_arc('San Francisco', 'Albuquerque', 40, 'plane'), // 2018-01-13
  squiffles_arc('San Francisco', 'Albuquerque', 50, 'plane'), // 2018-01-16
  squiffles_arc('San Francisco', 'Seattle', 50, 'plane'), // 2018-03-16
  squiffles_arc('Seattle', 'Dublin', 60, 'plane'), // 2018-03-19
  squiffles_arc('Dublin', 'Venice', 45, 'plane'), // 2018-03-24
  squiffles_arc('Rome', 'San Francisco', 75, 'plane'), // 2018-03-31
  squiffles_arc('Dallas', 'San Francisco', 70, 'plane'), // 2018-06-24
  squiffles_arc('Dallas', 'San Francisco', 80, 'plane'), // 2018-06-27
  squiffles_arc('Casablanca', 'San Francisco', 60, 'plane'), // 2018-09-01
  squiffles_arc('Casablanca', 'San Francisco', 75, 'plane'), // 2018-09-07
  squiffles_arc('San Francisco', 'Oslo', 165, 'plane'), // 2018-09-15
  squiffles_arc('Oslo', 'Riga', 30, 'plane'), // 2018-09-16
  squiffles_arc('San Francisco', 'Riga', 165, 'plane'), // 2018-09-26
  squiffles_arc('Tampa', 'San Francisco', 105, 'plane'), // 2018-10-07
  squiffles_arc('Tampa', 'San Francisco', 120, 'plane'), // 2018-10-09
  squiffles_arc('Dallas', 'Los Angeles', 30, 'plane'), // 2019-01-07
  squiffles_arc('Kuala Lumpur', 'San Francisco', 120, 'plane'), // 2019-01-19
  squiffles_arc('Langkawi', 'San Francisco', 120, 'plane'), // 2019-01-19
  squiffles_arc('San Francisco', 'Warsaw', 60, 'plane'), // 2019-03-31
  squiffles_arc('San Francisco', 'Warsaw', 75, 'plane'), // 2019-04-14
  squiffles_arc('Austin', 'San Francisco', 75, 'plane'), // 2019-10-13
  squiffles_arc('Pittsburgh', 'Austin', 30, 'plane'), // 2019-10-19
  squiffles_arc('San Diego', 'San Francisco', 60, 'plane'), // 2019-11-16
  squiffles_arc('Denver', 'Los Angeles', 20, 'plane'), // 2019-11-23
  squiffles_arc('Athens', 'San Francisco', 120, 'plane'), // 2020-01-05
  squiffles_arc('Budapest', 'Athens', 25, 'plane'), // 2020-01-10
  squiffles_arc('Nice', 'Budapest', 25, 'plane'), // 2020-01-17
  squiffles_arc('Portland', 'Paris', 30, 'plane'), // 2020-01-23
  squiffles_arc('Portland', 'Pittsburgh', 35, 'plane'), // 2020-01-26
  squiffles_arc('Denver', 'Pittsburgh', 40, 'plane'), // 2020-03-10
  squiffles_arc('Seattle', 'Pittsburgh', 45, 'plane'), // 2020-09-15
  squiffles_arc('Honolulu', 'Seattle', 60, 'plane'), // 2020-09-16
  squiffles_arc('Honolulu', 'Portland', 50, 'plane'), // 2020-11-16
  squiffles_arc('Portland', 'Denver', 25, 'plane'), // 2021-01-15
  squiffles_arc('Portland', 'Chicago', 25, 'plane'), // 2021-06-17
  squiffles_arc('Portland', 'Chicago', 15, 'plane'), // 2021-06-20
  squiffles_arc('Portland', 'Vancouver', 20, 'plane'), // 2021-09-19
  squiffles_arc('Vancouver', 'Pittsburgh', 45, 'plane'), // 2021-10-19
  squiffles_arc('Portland', 'New York', 60, 'plane'), // 2021-11-25
  squiffles_arc('New York', 'San Francisco', 10, 'plane'), // 2021-12-06
  squiffles_arc('New York', 'San Francisco', 20, 'plane'), // 2021-12-17
  squiffles_arc('Pittsburgh', 'San Francisco', 40, 'plane'), // 2022-01-15
  squiffles_arc('Calgary', 'New York', 60, 'plane'), // 2022-03-21
  squiffles_arc('Seattle', 'Calgary', 15, 'plane'), // 2022-03-27
  squiffles_arc('Seattle', 'New York', 75, 'plane'), // 2022-03-31
  squiffles_arc('Portland', 'New York', 70, 'plane'), // 2022-05-12
  squiffles_arc('Seattle', 'Pittsburgh', 35, 'plane'), // 2022-07-27
  squiffles_arc('San Francisco', 'Dublin', 120, 'plane'), // 2022-08-09
  squiffles_arc('Dublin', 'New York', 30, 'plane'), // 2022-08-17
  squiffles_arc('Pittsburgh', 'New York', 10, 'plane'), // 2022-08-20
  squiffles_arc('Pittsburgh', 'New York', 20, 'plane'), // 2022-09-10
  squiffles_arc('Pittsburgh', 'Los Angeles', 35, 'plane'), // 2022-10-26
  squiffles_arc('Wheeler Ridge', 'Los Angeles', 5, 'thumb'), // 2014-11-06
  squiffles_arc('San Francisco', 'Wheeler Ridge', 10, 'thumb'), // 2014-11-07
  squiffles_arc('Sacramento', 'Los Angeles', 25, 'thumb'), // 2015-03-23
  squiffles_arc('Eugene', 'Sacramento', 10, 'thumb'), // 2015-03-24
  squiffles_arc('Portland', 'Eugene', 10, 'thumb'), // 2015-03-25
  squiffles_arc('Seattle', 'Portland', 10, 'thumb'), // 2015-03-27
  squiffles_arc('Vancouver', 'Seattle', 10, 'thumb'), // 2015-03-29
  squiffles_arc('Los Angeles', 'Atascadero', 10, 'thumb'), // 2015-07-03
  squiffles_arc('Atascadero', 'San Francisco', 10, 'thumb'), // 2015-07-04
  squiffles_arc('Los Angeles', 'San Francisco', 30, 'thumb'), // 2015-08-22
  squiffles_arc('Los Angeles', 'San Francisco', 45, 'thumb'), // 2015-11-21
  squiffles_arc('Vancouver', 'Everett', 25, 'thumb'), // 2016-03-18
  squiffles_arc('Everett', 'Portland', 25, 'thumb'), // 2016-03-19
  squiffles_arc('Portland', 'Seattle', 10, 'thumb'), // 2016-03-20
  squiffles_arc('Seattle', 'Vancouver', 10, 'thumb'), // 2016-03-21
  squiffles_arc('Las Vegas', 'Los Angeles', 10, 'thumb'), // 2016-06-12
  squiffles_arc('Las Vegas', 'Richfield', 15, 'thumb'), // 2016-06-13
  squiffles_arc('Richfield', 'Denver', 20, 'thumb'), // 2016-06-14
  squiffles_arc('Tokyo', 'Osaka', 10, 'thumb'), // 2017-03-21
  squiffles_arc('Osaka', 'Tokyo', 10, 'thumb'), // 2017-03-24
  squiffles_arc('Bucharest', 'Brasov', 10, 'thumb'), // 2017-07-05
  squiffles_arc('Brasov', 'Constanta', 10, 'thumb'), // 2017-07-07
  squiffles_arc('Constanta', 'Varna', 15, 'thumb'), // 2017-07-11
  squiffles_arc('Varna', 'Skopje', 20, 'thumb'), // 2017-07-13
  squiffles_arc('Skopje', 'Pristina', 5, 'thumb'), // 2017-07-16
  squiffles_arc('Tahoe City', 'San Francisco', 10, 'thumb'), // 2017-09-02
  squiffles_arc('San Francisco', 'Tahoe City', 10, 'thumb'), // 2017-09-03
  squiffles_arc('Venice', 'Bologna', 10, 'thumb'), // 2018-03-26
  squiffles_arc('Casablanca', 'Marrakesh', 10, 'thumb'), // 2018-09-08
  squiffles_arc('Palanga', 'Liepaja', 5, 'thumb'), // 2018-09-21
  squiffles_arc('Kuala Lumpur', 'Butterworth', 10, 'thumb'), // 2019-01-26
  squiffles_arc('Las Vegas', 'Los Angeles', 25, 'thumb')  // 2019-08-11
];

$points = [
  squiffles_point('Beijing', 'Beijing, China', false),
  squiffles_point('Los Angeles', 'Los Angeles, California', true),
  squiffles_point('Nantong', 'Nantong, China', false),
  squiffles_point('Pittsburgh', 'Pittsburgh, Pennsylvania', false),
  squiffles_point('Portland', 'Portland, Oregon', false),
  squiffles_point('Provo', 'Provo, Utah', false),
  squiffles_point('San Francisco', 'San Francisco, California', false),
  squiffles_point('Waianae', 'Waianae, Hawaii', true),
  squiffles_point('Leadville', 'Leadville, Colorado', true),
  squiffles_point('Vancouver', 'Vancouver, British Columbia', true),
  squiffles_point('New York', 'New York, New York', true),
];

$pages = squiffles_showcase([
  [
    'description' =>
        'Custom sign-up experience built for a one-day cyberpunk-themed puzzle hunt called Project Hyperskelion.',
    'image' => '/bin/images/showcase_hyper.gif'
  ],
  [
    'description' =>
        'An easily extensible <a href="https://github.com/deeptoaster/nato-lights">software library</a> and Arduino Uno&ndash;based hardware demo for decorative NeoPixel lighting strips.',
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
        'Online demo of a bunch of <a href="/css/">stupid things</a> you can do with CSS. Check out the <a href="https://fishbotwilleatyou.com/blog/tag/stupid-css/">writeup on the blog</a> or the code <a href="https://github.com/deeptoaster/stupid-css">on GitHub</a>!',
    'image' => '/bin/images/showcase_css.png'
  ],
  [
    'description' =>
        '<a href="https://blacker.caltech.edu/">Website and complete suite of administrative apps</a> built for Blacker Hovse, one of the eight undergraduate houses at Caltech.',
    'image' => '/bin/images/showcase_blacker.png'
  ],
  [
    'description' =>
        'Online grasp solver for point contacts with friction (PCWF). Check it out <a href="/force-closure/">online</a> or <a href="https://github.com/deeptoaster/force-closure">on GitHub</a>!',
    'image' => '/bin/images/showcase_pcwf.gif'
  ],
  [
    'description' =>
        'Poster designed for Hornsdale, a one-day puzzle hunt in 2017.',
    'image' => '/bin/images/showcase_hornsdale.png'
  ],
  [
    'description' =>
        'A neuomorphic webapp for generating Tasker configs for quantified-self projects. Check it out <a href="/tracker/">online</a> or <a href="https://github.com/deeptoaster/tasker-tracker">on GitHub</a>!',
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
  ]
]);

$cleverly = new Cleverly();
$cleverly->preserveIndent = true;
$cleverly->setTemplateDir(__DIR__ . '/templates');
$cleverly->addTemplateDir(__DIR__ . '/common/templates');
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
  'path' => '/',
  'root' => $config['ROOT'],
  'title' => 'Deep Toaster'
]);
?>
