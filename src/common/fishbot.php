<?
/** @file */
namespace Squiffles;

define('Squiffles\FISHBOT_FILE', __DIR__ . '/../images/fishbot.svg');
define('FISHBOT_THRESHOLD', 0.01);

include(__DIR__ . '/FishbotGraph.class.php');
include(__DIR__ . '/FishbotWedge.class.php');

/**
 * Collects line and ellipse parameters from an SVG object into a flat array.
 * @param $xml The SVG node as parsed by SimpleXML.
 * @param [out] $lines The array for lines.
 * @param [out] $ellipses The array for ellipses.
 * @param $settings Accumulated settings for the SVG node.
 */
function squiffles_collect(
  \SimpleXMLElement $xml,
  array &$lines,
  array &$ellipses,
  array $settings
): void {
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
      $ellipses[] = new FishbotEllipse(
        (float)$xml['cx'],
        (float)$xml['cy'],
        (float)$xml['rx'],
        (float)$xml['ry'],
        (float)$settings['stroke-width']
      );

      break;
    case 'line':
      $lines[] = new FishbotLine(
        (float)$xml['x1'],
        (float)$xml['y1'],
        (float)$xml['x2'],
        (float)$xml['y2'],
        $settings['stroke-linecap'],
        (float)$settings['stroke-width']
      );

      break;
  }

  foreach ($xml->children() as $child) {
    squiffles_collect($child, $lines, $ellipses, $settings);
  }
}

/**
 * Finds regions from lines and ellipses and fills them.
 * @param $lines The array of lines.
 * @param $ellipses The array of ellipses.
 * @param $scale The scale factor for the SVG.
 */
function squiffles_fill(array $lines, array $ellipses, float $scale): void {
  $graph = new FishbotGraph($lines, $ellipses);
  $regions = $graph->getRegions();

  foreach ($regions as $region) {
    $delay = -rand() / getrandmax();

    if ($region instanceof FishbotTriangularRegion) {
      $projection = $region->anchor_edge->project($region->anchor_node);

      $height = new FishbotEdge(
        $region->anchor_node,
        $projection
      )->length * $scale;

      $left = new FishbotEdge(
        $region->anchor_edge->start,
        $projection
      )->length * $scale;
      
      $right = new FishbotEdge(
        $region->anchor_edge->end,
        $projection
      )->length * $scale;

      $transform =
          sprintf('transform: rotate(%.2fdeg);', $region->anchor_edge->theta);
      $transform_origin = sprintf('transform-origin: %.2fem top;', $left);

      printf(
        <<<EOF
    <span class="svg-region" style="top: %.2fem; left: %.2fem; margin-left: -%.2fem; border-width: 0 %.2fem %.2fem %.2fem; -webkit-%s -moz-%s %s -webkit-%s -moz-%s %s animation-delay: %.1fs;"></span>

  EOF
        ,
        $region->anchor_node->y * $scale,
        $region->anchor_node->x * $scale,
        $left,
        $right,
        $height,
        $left,
        $transform,
        $transform,
        $transform,
        $transform_origin,
        $transform_origin,
        $transform_origin,
        $delay
      );
    } else if ($region instanceof FishbotTrapezoidalRegion) {
      $projection = $region->long_edge->project($region->short_edge->end);

      $height = new FishbotEdge(
        $region->short_edge->end,
        $projection
      )->length * $scale;

      $left = new FishbotEdge(
        $region->long_edge->start,
        $projection
      )->length * $scale;
      
      $right = (new FishbotEdge(
        $region->long_edge->end,
        $projection
      )->length - $region->short_edge->length) * $scale;

      $transform =
          sprintf('transform: rotate(%.2fdeg);', $region->long_edge->theta);
      $transform_origin = sprintf('transform-origin: %.2fem top;', $left);

      printf(
        <<<EOF
    <span class="svg-region" style="top: %.2fem; left: %.2fem; width: %.2fem; margin-left: -%.2fem; border-width: 0 %.2fem %.2fem %.2fem; -webkit-%s -moz-%s %s -webkit-%s -moz-%s %s animation-delay: %.1fs;"></span>

  EOF
        ,
        $region->short_edge->end->y * $scale,
        $region->short_edge->end->x * $scale,
        $region->short_edge->length * $scale,
        $left,
        max($right, 0),
        $height,
        $left,
        $transform,
        $transform,
        $transform,
        $transform_origin,
        $transform_origin,
        $transform_origin,
        $delay
      );
    }
  }
}

/**
 * Draws lines and ellipses.
 * @param $lines The array of lines.
 * @param $ellipses The array of ellipses.
 * @param $scale The scale factor for the SVG.
 */
function squiffles_stroke(array $lines, array $ellipses, float $scale): void {
  foreach ($lines as $line) {
    $width = $line->length * $scale;
    $top = ($line->center->y - $line->width / 2) * $scale;
    $left = $line->center->x * $scale - $width / 2;
    $transform = sprintf('transform: rotate(%.2fdeg);', $line->theta);
    $border = $line->width / 2 * $scale;
    $border_left_right = '';
    $radius = '';

    switch ($line->linecap) {
      case 'butt':
        $border_left_right = ' 0';
        break;
      case 'round':
        $radius = sprintf(" border-radius: %.2fem;", $border);
      case 'square':
        $left -= $line->width / 2 * $scale;
        break;
    }

    $delay = random_int(1, 3) / 3;

    printf(
      <<<EOF
  <span class="svg-line" style="top: %.2fem; left: %.2fem; width: %.2fem; border-width: %.2fem%s;%s -webkit-%s -moz-%s %s animation-delay: %.1fs, %.1fs;"></span>

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
    $delay = -rand() / getrandmax();

    printf(
      <<<EOF
  <span class="svg-ellipse" style="top: %.2fem; left: %.2fem; width: %.2fem; height: %.2fem; border-width: %.2fem; animation-delay: %.1fs;"></span>

EOF
      ,
      ($ellipse->center->y - $ellipse->ry - $ellipse->width / 2) * $scale,
      ($ellipse->center->x - $ellipse->rx - $ellipse->width / 2) * $scale,
      ($ellipse->rx * 2 - $ellipse->width) * $scale,
      ($ellipse->ry * 2 - $ellipse->width) * $scale,
      $ellipse->width * $scale,
      $delay
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
squiffles_fill($lines, $ellipses, 0.1);
squiffles_stroke($lines, $ellipses, 0.1);

echo <<<EOF
</div>

EOF;
?>
