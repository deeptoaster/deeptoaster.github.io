<?
function squiffles_draw($xml, $settings, $scale) {
  foreach ($xml->attributes() as $key => $value) {
    switch ($key) {
      case 'fill':
      case 'stroke':
      case 'stroke-linecap':
      case 'stroke-width':
        $settings[$key] = $value;
        break;
    }
  }

  switch ($xml->getName()) {
    case 'ellipse':
      $top = ($xml['cy'] - $xml['ry'] - $settings['stroke-width'] / 2) * $scale;
      $left = ($xml['cx'] - $xml['rx'] - $settings['stroke-width'] / 2) *
          $scale;
      $width = ($xml['rx'] * 2 - $settings['stroke-width'] * 2) * $scale;
      $height = ($xml['ry'] * 2 - $settings['stroke-width'] * 2) * $scale;
      $border = $settings['stroke-width'] * $scale;

      echo <<<EOF
  <span class="svg-ellipse" style="top: ${top}em; left: ${left}em; width: ${width}em; height: ${height}em; border-width: ${border}em;"></span>

EOF;

      break;
    case 'line':
      $cx = ($xml['x1'] + $xml['x2']) / 2;
      $cy = ($xml['y1'] + $xml['y2']) / 2;
      $x = $xml['x2'] - $xml['x1'];
      $y = $xml['y2'] - $xml['y1'];
      $width = (sqrt($x * $x + $y * $y)) * $scale;
      $top = ($cy - $settings['stroke-width']) * $scale;
      $left = $cx * $scale - $width / 2;
      $theta = atan2($y, $x) * 180 / M_PI;
      $transform = sprintf('transform: rotate(%.1fdeg);', $theta);
      $border = ceil($settings['stroke-width'] / 2) * $scale . 'em';
      $radius = '';
      $linecap = $settings['stroke-linecap'];

      switch ($settings['stroke-linecap']) {
        case 'butt':
          $border .= ' 0';
          break;
        case 'round':
          $radius = " border-radius: $border;";
        case 'square':
          $left -= $settings['stroke-width'] * $scale;
          break;
      }

      $delay = random_int(1, 3) / 3;

      printf(
        <<<EOF
  <span class="svg-line svg-%s" style="top: %.1fem; left: %.1fem; width: %.1fem; border-width: %s;%s -webkit-%s -moz-%s %s animation-delay: %.1fs, %.1fs"></span>

EOF
        ,
        $linecap,
        $top,
        $left,
        $width,
        $border,
        $radius,
        $transform,
        $transform,
        $transform,
        $delay,
        $delay
      );

      break;
  }

  foreach ($xml->children() as $child) {
    squiffles_draw($child, $settings, $scale);
  }
}

$xml = simplexml_load_file(__DIR__ . '/images/fishbot.svg');
$width = $xml['width'] / 10;
$height = $xml['height'] / 10;

echo <<<EOF
<div class="svg" style="width: ${width}em; height: ${height}em;">

EOF;

squiffles_draw($xml, array(
  'stroke-linecap' => 'butt'
), 0.1);

echo <<<EOF
</div>

EOF;
?>
