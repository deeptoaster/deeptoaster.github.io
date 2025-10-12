<?
/** @file */
namespace Squiffles;

define('Squiffles\FISHBOT_FILE', __DIR__ . '/../images/fishbot.svg');
define('FISHBOT_THRESHOLD', 0.001);

include(__DIR__ . '/FishbotEdge.class.php');
include(__DIR__ . '/FishbotEllipse.class.php');
include(__DIR__ . '/FishbotLine.class.php');
include(__DIR__ . '/FishbotNode.class.php');
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
 * Finds triangles and quadrilaterals from lines and ellipses and fills them.
 * @param $lines The array of lines.
 * @param $ellipses The array of ellipses.
 * @param $scale The scale factor for the SVG.
 */
function squiffles_fill(array $lines, array $ellipses, float $scale): void {
  $nodes = [];

  foreach ($lines as $l1_index => $l1) {
    for ($l2_index = $l1_index + 1; $l2_index < count($lines); $l2_index++) {
      $l1->intersect($lines[$l2_index], $nodes);
    }
  }

  foreach ($lines as $line) {
    echo "Line from ({$line->start->hash}) to ({$line->end->hash})\n";
  }

  $edges = [];
  $edges_by_node = [];

  foreach ($lines as $line) {
    $line->collectEdges($edges);
  }

  foreach ($nodes as $node) {
    $edges_by_node[$node->hash] = [];
  }

  foreach ($edges as $edge) {
    $edges_by_node[$edge->start->hash][] = $edge;

    $edges_by_node[$edge->end->hash][] = new FishbotEdge(
      $edge->end,
      $edge->start
    );
  }

  # sorting &$node_edges in place leads to a duplication bug
  foreach ($edges_by_node as $node_hash => $node_edges) {
    usort($node_edges, function(FishbotEdge $a, FishbotEdge $b) {
      return $a->theta <=> $b->theta;
    });

    $edges_by_node[$node_hash] = $node_edges;
  }

  foreach ($edges_by_node as $node_hash => $node_edges) {
    echo count($node_edges), " edges from ($node_hash) to:\n";

    foreach ($node_edges as $edge) {
      echo "  ({$edge->end->hash}) at {$edge->theta}\n";
    }
  }

  $wedges = [];
  $wedges_by_node = [];

  foreach ($nodes as $node) {
    $wedges_by_node[$node->hash] = [];
  }

  foreach ($edges_by_node as $node_hash => $node_edges) {
    foreach ($node_edges as $edge_index => $edge) {
      $next_edge = $node_edges[($edge_index + 1) % count($node_edges)];
      $wedge = new FishbotWedge($edge, $next_edge);
      $wedges[] = $wedge;
      $wedges_by_node[$edge->end->hash][$node_hash] = $wedge;
    }
  }

  $regions = [];

  foreach ($wedges as $start_wedge) {
    if ($start_wedge->consumed) {
      continue;
    }

    $region = [];
    $wedge = $start_wedge;

    do {
      $region[] = $wedge->start;
      $wedge->consumed = true;
      $wedge = $wedges_by_node[$wedge->middle->hash][$wedge->end->hash];
    } while ($wedge !== $start_wedge);

    $regions[] = $region;
    $start_wedge->consumed = true;
  }

  foreach ($regions as $region) {
    echo "Region over (", implode("), (", array_map(function($node) {
      return $node->hash;
    }, $region)), ")\n";
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
    $top = ($line->cy - $line->width / 2) * $scale;
    $left = $line->cx * $scale - $width / 2;
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
    printf(
      <<<EOF
  <span class="svg-ellipse" style="top: %.2fem; left: %.2fem; width: %.2fem; height: %.2fem; border-width: %.2fem;"></span>

EOF
      ,
      ($ellipse->cy - $ellipse->ry - $ellipse->width / 2) * $scale,
      ($ellipse->cx - $ellipse->rx - $ellipse->width / 2) * $scale,
      ($ellipse->rx * 2 - $ellipse->width) * $scale,
      ($ellipse->ry * 2 - $ellipse->width) * $scale,
      $ellipse->width * $scale
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
