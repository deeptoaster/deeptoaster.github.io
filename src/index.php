<?
include(__DIR__ . '/../lib/cleverly/Cleverly.class.php');

function squiffles_project($lat, $lng) {
  list($width, $height) = getimagesize(__DIR__ . '/../bin/images/world.png');

  return array(
    ($lng + 187) * $width / 330,
    355 - $width * log(tan(M_PI / 4 + $lat * M_PI / 360)) / M_PI / 2 * 1.1
  );
}

function squiffles_arc($lat0, $lng0, $lat1, $lng1, $height) {
  list($x0, $y0) = squiffles_project($lat0, $lng0);
  list($x1, $y1) = squiffles_project($lat1, $lng1);
  $x = $x1 - $x0;
  $y = $y1 - $y0;
  $width = sqrt($x * $x + $y * $y);
  $top = ($y0 + $y1 - $height) / 2;
  $left = ($x0 + $x1 - $width) / 2;
  $theta = atan2($y, $x) * 180 / M_PI;
  $transform = sprintf('transform: rotate(%ddeg);', $theta);

  return sprintf(
    'width: %.2fem; height: %.2fem; top: %.2fem; left: %.2fem; -webkit-%s ' .
        '-moz-%s %s',
    $width / 20,
    $height / 20,
    $top / 20,
    $left / 20,
    $transform,
    $transform,
    $transform
  );
}

function squiffles_point($lat, $lng, $label, $right) {
  list($x, $y) = squiffles_project($lat, $lng);

  return array(
    'label' => $label,
    'side' => $right ? 'right' : 'left',
    'style' => sprintf('top: %.2fem; left: %.2fem;', $y / 20, $x / 20)
  );
}

$arcs = array(
  squiffles_arc(35.0044, -118.9495, 34.0522, -118.2437,  5), // 2014-11-06
  squiffles_arc(37.7749, -122.4194, 35.0044, -118.9495, 10), // 2014-11-07
  squiffles_arc(38.5816, -121.4944, 34.0522, -118.2437, 25), // 2015-03-23
  squiffles_arc(44.0521, -123.0868, 38.5816, -121.4944, 10), // 2015-03-24
  squiffles_arc(45.5051, -122.6750, 44.0521, -123.0868, 10), // 2015-03-25
  squiffles_arc(47.6062, -122.3321, 45.5051, -122.6750, 10), // 2015-03-27
  squiffles_arc(49.2827, -123.1207, 47.6062, -122.3321, 10), // 2015-03-29
  squiffles_arc(34.0522, -118.2437, 35.4894, -120.6707, 10), // 2015-07-03
  squiffles_arc(35.4894, -120.6707, 37.7749, -122.4194, 10), // 2015-07-04
  squiffles_arc(34.0522, -118.2437, 37.7749, -122.4194, 30), // 2015-08-22
  squiffles_arc(34.0522, -118.2437, 37.7749, -122.4194, 45), // 2015-11-21
  squiffles_arc(49.2827, -123.1207, 47.9790, -122.2021, 25), // 2016-03-18
  squiffles_arc(47.9790, -122.2021, 45.5051, -122.6750, 25), // 2016-03-19
  squiffles_arc(45.5051, -122.6750, 47.6062, -122.3321, 10), // 2016-03-20
  squiffles_arc(47.6062, -122.3321, 49.2827, -123.1207, 10), // 2016-03-21
  squiffles_arc(36.1699, -115.1398, 34.0522, -118.2437, 10), // 2016-06-12
  squiffles_arc(36.1699, -115.1398, 38.7725, -112.0841, 15), // 2016-06-13
  squiffles_arc(38.7725, -112.0841, 39.7392, -104.9903, 20), // 2016-06-14
  squiffles_arc(35.6762,  139.6503, 34.6937,  135.5023, 10), // 2017-03-21
  squiffles_arc(34.6937,  135.5023, 35.6762,  139.6503, 10), // 2017-03-24
  squiffles_arc(44.4268,   26.1025, 45.6427,   25.5887, 10), // 2017-07-05
  squiffles_arc(45.6427,   25.5887, 44.1598,   28.6348, 10), // 2017-07-07
  squiffles_arc(44.1598,   28.6348, 43.2141,   27.9147, 15), // 2017-07-11
  squiffles_arc(43.2141,   27.9147, 41.9981,   21.4254, 20), // 2017-07-13
  squiffles_arc(41.9981,   21.4254, 42.6629,   21.1655,  5), // 2017-07-16
  squiffles_arc(39.1677, -120.1452, 37.7749, -122.4194, 10), // 2017-09-02
  squiffles_arc(37.7749, -122.4194, 39.1677, -120.1452, 10), // 2017-09-03
  squiffles_arc(45.4408,   12.3155, 44.4949,   11.3426, 10), // 2018-03-26
  squiffles_arc(33.5731,   -7.5898, 31.6295,   -7.9811, 10), // 2018-09-08
  squiffles_arc(55.9202,   21.0678, 56.5047,   21.0108,  5), // 2018-09-21
  squiffles_arc( 3.1390,  101.6869,  5.4380,  100.3882, 10)  // 2019-01-26
);

$points = array(
  squiffles_point(39.9042,  116.4074, 'Beijing, China', false),
  squiffles_point(34.0522, -118.2437, 'Los Angeles, California', true),
  squiffles_point(31.9802,  120.8943, 'Nantong, China', false),
  squiffles_point(40.4406,  -79.9959, 'Pittsburgh, Pennsylvania', true),
  squiffles_point(45.5051, -122.6750, 'Portland, Oregon', false),
  squiffles_point(37.7749, -122.4194, 'San Francisco, California', false),
  squiffles_point(21.4360, -158.1849, 'Waianae, Hawaii', true)
);

$cleverly = new Cleverly();
$cleverly->preserveIndent = true;
$cleverly->setTemplateDir(__DIR__ . '/templates');
ob_start();

include(__DIR__ . '/coaster.php');

$coaster = ob_get_clean();

$cleverly->display('index.tpl', array(
  'arcs' => $arcs,
  'coaster' => $coaster,
  'points' => $points
));
?>
