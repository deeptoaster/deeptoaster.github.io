<?
if (PHP_SAPI != 'CLI') {
  header('Location: /', true, 301);
}

include(__DIR__ . '/../lib/cleverly/Cleverly.class.php');

function squiffles_transform($x0, $y0, $x1, $y1, $height) {
  $x = $x1 - $x0;
  $y = $y1 - $y0;
  $width = sqrt($x * $x + $y * $y);
  $top = ($y0 + $y1 - $height) / 2;
  $left = ($x0 + $x1 - $width) / 2;
  $theta = atan2($y, $x) * 180 / M_PI;
  $transform = "transform: rotate(${theta}deg);";

  return sprintf(
    'width: %.1fem; height: %.1fem; top: %.1fem; left: %.1fem; -webkit-%s ' .
        '-o-%s -moz-%s %s',
    $width,
    $height,
    $top,
    $left,
    $transform,
    $transform,
    $transform,
    $transform
  );
}

$left = array(
  squiffles_transform(34.0, 11.0, 36.0, 9.5, 2.0),
  squiffles_transform(36.0, 9.5, 34.0, 11.0, 2.0)
);

$right = array(
  squiffles_transform(11.0, 15.0, 11.5, 17.0, 1.0),
  squiffles_transform(10.0, 13.5, 11.0, 15.0, 1.0),
  squiffles_transform(11.0, 13.5, 11.5, 17.0, 2.0),
  squiffles_transform(11.5, 10.0, 11.0, 13.5, 2.0),
  squiffles_transform(12.0, 9.0, 11.5, 10.0, 1.0),
  squiffles_transform(12.5, 8.0, 12.0, 9.0, 1.0),
  squiffles_transform(12.5, 7.0, 12.5, 8.0, 1.0),
  squiffles_transform(11.5, 17.0, 10.5, 15.5, 1.0),
  squiffles_transform(10.5, 15.5, 10.0, 13.5, 1.0),
  squiffles_transform(11.5, 17.0, 10.0, 13.5, 3.0),
  squiffles_transform(11.5, 17.0, 10.0, 13.5, 4.0),
  squiffles_transform(12.5, 8.0, 12.5, 7.0, 1.0),
  squiffles_transform(12.0, 9.0, 12.5, 8.0, 1.0),
  squiffles_transform(12.5, 7.0, 12.5, 8.0, 2.0),
  squiffles_transform(12.5, 8.0, 12.0, 9.0, 2.0),
  squiffles_transform(13.5, 16.0, 11.5, 17.0, 1.0),
  squiffles_transform(13.5, 16.0, 15.5, 14.5, 2.0),
  squiffles_transform(15.5, 14.5, 19.0, 15.0, 2.0)
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
  'left' => $left,
  'right' => $right,
));
?>
