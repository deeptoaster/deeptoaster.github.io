<?
namespace Squiffles;

define('Squiffles\FISHBOT_FILE', __DIR__ . '/../images/fishbot.svg');

/**
 * Collects line and ellipse parameters from an SVG object into a flat array.
 * @param SimpleXMLElement $xml The SVG node as parsed by SimpleXML.
 * @param array<array<string,number>> $lines The array for lines.
 * @param array<array<string,number>> $ellipses The array for ellipses.
 * @param array<string,string> $settings Accumulated settings for the SVG node.
 */
function squiffles_collect($xml, &$lines, &$ellipses, $settings) {
  foreach ($xml->attributes() as $key => $value) {
    switch ($key) {
      case 'stroke-linecap':
      case 'stroke-width':
        $settings[$key] = $value;
        break;
    }
  }

  switch ($xml->getName()) {
    case 'ellipse':
      $ellipses[] = [
        'cx' => $xml['cx'],
        'cy' => $xml['cy'],
        'rx' => $xml['rx'],
        'ry' => $xml['ry'],
        'stroke-width' => $settings['stroke-width']
      ];

      break;
    case 'line':
      $lines[] = [
        'x1' => $xml['x1'],
        'x2' => $xml['x2'],
        'y1' => $xml['y1'],
        'y2' => $xml['y2'],
        'stroke-linecap' => $settings['stroke-linecap'],
        'stroke-width' => $settings['stroke-width']
      ];

      break;
  }

  foreach ($xml->children() as $child) {
    squiffles_collect($child, $lines, $ellipses, $settings);
  }
}

/**
 * Finds triangles and quadrilaterals from lines and ellipses and fills them.
 * @param array<array<string,number>> $lines The array of lines.
 * @param array<array<string,number>> $ellipses The array of ellipses.
 * @param number $scale The scale factor for the SVG.
 */
function squiffles_fill($lines, $ellipses, $scale) {
}

/**
 * Draws lines and ellipses.
 * @param array<array<string,number>> $lines The array of lines.
 * @param array<array<string,number>> $ellipses The array of ellipses.
 * @param number $scale The scale factor for the SVG.
 */
function squiffles_stroke($lines, $ellipses, $scale) {
  foreach ($lines as $line) {
    $cx = ($line['x1'] + $line['x2']) / 2;
    $cy = ($line['y1'] + $line['y2']) / 2;
    $dx = $line['x2'] - $line['x1'];
    $dy = $line['y2'] - $line['y1'];
    $width = sqrt($dx * $dx + $dy * $dy) * $scale;
    $top = ($cy - $line['stroke-width'] / 2) * $scale;
    $left = $cx * $scale - $width / 2;
    $theta = atan2($dy, $dx) * 180 / M_PI;
    $transform = sprintf('transform: rotate(%.2fdeg);', $theta);
    $border = $line['stroke-width'] / 2 * $scale;
    $border_left_right = '';
    $radius = '';

    switch ($line['stroke-linecap']) {
      case 'butt':
        $border_left_right = ' 0';
        break;
      case 'round':
        $radius = " border-radius: ${border}em;";
      case 'square':
        $left -= $line['stroke-width'] / 2 * $scale;
        break;
    }

    $delay = random_int(1, 3) / 3;

    printf(
      <<<EOF
  <span class="svg-line" style="top: %.2fem; left: %.2fem; width: %.2fem; border-width: %.2fem%s;%s -webkit-%s -moz-%s %s animation-delay: %.1fs, %.1fs"></span>

EOF
      ,
      $top,
      $left,
      $width,
      $border,
      $border_left_right,
      $radius,
      $transform,
      $transform,
      $transform,
      $delay,
      $delay
    );
  }

  foreach ($ellipses as $ellipse) {
    $top = ($ellipse['cy'] - $ellipse['ry'] - $ellipse['stroke-width'] / 2) *
        $scale;
    $left = ($ellipse['cx'] - $ellipse['rx'] - $ellipse['stroke-width'] / 2) *
        $scale;
    $width = ($ellipse['rx'] * 2 - $ellipse['stroke-width']) * $scale;
    $height = ($ellipse['ry'] * 2 - $ellipse['stroke-width']) * $scale;
    $border = $ellipse['stroke-width'] * $scale;

    printf(
      <<<EOF
  <span class="svg-ellipse" style="top: %.2fem; left: %.2fem; width: %.2fem; height: %.2fem; border-width: %.2fem;"></span>

EOF
      ,
      $top,
      $left,
      $width,
      $height,
      $border
    );
  }
}

$xml = simplexml_load_file(FISHBOT_FILE);
$width = $xml['width'] / 10;
$height = $xml['height'] / 10;

echo <<<EOF
<div class="svg" style="width: ${width}em; height: ${height}em;">

EOF;

$lines = [];
$ellipses = [];
$settings = ['stroke-linecap' => 'butt'];
squiffles_collect($xml, $lines, $ellipses, $settings);
squiffles_stroke($lines, $ellipses, 0.1);
squiffles_fill($lines, $ellipses, 0.1);

echo <<<EOF
</div>

EOF;
?>
