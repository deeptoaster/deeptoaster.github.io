<?
include(__DIR__ . '/../lib/cleverly/Cleverly.class.php');

function squiffles_project($lat, $lng) {
  list($width, $height) = getimagesize(__DIR__ . '/../bin/images/world.png');

  return array(
    ($lng + 187) * $width / 330,
    355 - $width * log(tan(M_PI / 4 + $lat * M_PI / 360)) / M_PI / 2 * 1.1
  );
}

function squiffles_transform($lat0, $lng0, $lat1, $lng1, $height) {
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

$arcs = array(
  squiffles_transform(35.0044, -118.9495, 34.0522, -118.2437,  5), // 2014-11-06
  squiffles_transform(37.7749, -122.4194, 35.0044, -118.9495, 10), // 2014-11-07
  squiffles_transform(38.5816, -121.4944, 34.0522, -118.2437, 25), // 2015-03-23
  squiffles_transform(44.0521, -123.0868, 38.5816, -121.4944, 10), // 2015-03-24
  squiffles_transform(45.5051, -122.6750, 44.0521, -123.0868, 10), // 2015-03-25
  squiffles_transform(47.6062, -122.3321, 45.5051, -122.6750, 10), // 2015-03-27
  squiffles_transform(49.2827, -123.1207, 47.6062, -122.3321, 10), // 2015-03-29
  squiffles_transform(34.0522, -118.2437, 35.4894, -120.6707, 10), // 2015-07-03
  squiffles_transform(35.4894, -120.6707, 37.7749, -122.4194, 10), // 2015-07-04
  squiffles_transform(34.0522, -118.2437, 37.7749, -122.4194, 30), // 2015-08-22
  squiffles_transform(34.0522, -118.2437, 37.7749, -122.4194, 45), // 2015-11-21
  squiffles_transform(49.2827, -123.1207, 47.9790, -122.2021, 25), // 2016-03-18
  squiffles_transform(47.9790, -122.2021, 45.5051, -122.6750, 25), // 2016-03-19
  squiffles_transform(45.5051, -122.6750, 47.6062, -122.3321, 10), // 2016-03-20
  squiffles_transform(47.6062, -122.3321, 49.2827, -123.1207, 10), // 2016-03-21
  squiffles_transform(36.1699, -115.1398, 34.0522, -118.2437, 10), // 2016-06-12
  squiffles_transform(36.1699, -115.1398, 38.7725, -112.0841, 15), // 2016-06-13
  squiffles_transform(38.7725, -112.0841, 39.7392, -104.9903, 20), // 2016-06-14
  squiffles_transform(35.6762,  139.6503, 34.6937,  135.5023, 10), // 2017-03-21
  squiffles_transform(34.6937,  135.5023, 35.6762,  139.6503, 10), // 2017-03-24
  squiffles_transform(44.4268,   26.1025, 45.6427,   25.5887, 10), // 2017-07-05
  squiffles_transform(45.6427,   25.5887, 44.1598,   28.6348, 10), // 2017-07-07
  squiffles_transform(44.1598,   28.6348, 43.2141,   27.9147, 15), // 2017-07-11
  squiffles_transform(43.2141,   27.9147, 41.9981,   21.4254, 20), // 2017-07-13
  squiffles_transform(41.9981,   21.4254, 42.6629,   21.1655,  5), // 2017-07-16
  squiffles_transform(39.1677, -120.1452, 37.7749, -122.4194, 10), // 2017-09-02
  squiffles_transform(37.7749, -122.4194, 39.1677, -120.1452, 10), // 2017-09-03
  squiffles_transform(45.4408,   12.3155, 44.4949,   11.3426, 10), // 2018-03-26
  squiffles_transform(33.5731,   -7.5898, 31.6295,   -7.9811, 10), // 2018-09-08
  squiffles_transform(55.9202,   21.0678, 56.5047,   21.0108,  5), // 2018-09-21
  squiffles_transform( 3.1390,  101.6869,  5.4380,  100.3882, 10)  // 2019-01-26
);

$interests = array(
  'building things',
  'calligraphy',
  'climbing',
  'fencing',
  'fire spinning',
  'making music',
  'self-defense',
  'urban exploration',
  'writing'
);

$cleverly = new Cleverly();
$cleverly->preserveIndent = true;
$cleverly->setTemplateDir(__DIR__ . '/templates');

$cleverly->display('index.tpl', array(
  'interests' => $interests,
  'arcs' => $arcs,
));
?>
