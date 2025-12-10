<?php
namespace Squiffles;

include_once(__DIR__ . '/FishbotEdge.class.php');

/**
 * Represents a line segment in an SVG.
 */
class FishbotLine extends FishbotEdge {
  public string $linecap;
  public float $width;
  private array $intersections = [];

  public function __construct(
    float $x1,
    float $y1,
    float $x2,
    float $y2,
    string $linecap,
    float $width
  ) {
    parent::__construct(new FishbotNode($x1, $y1), new FishbotNode($x2, $y2));
    $this->linecap = $linecap;
    $this->width = $width;
  }

  /**
   * Splits the line segment into edges at its recorded intersections.
   * @param [out] $edges The running list of edges in the graph.
   */
  public function collectEdges(array &$edges): void {
    ksort($this->intersections, SORT_NUMERIC);
    $previous_node = null;

    foreach ($this->intersections as $node) {
      if ($previous_node !== null) {
        $edges[] = new FishbotEdge($previous_node, $node);
      }

      $previous_node = $node;
    }
  }

  /**
   * Tests for an intersection between line segments and records it.
   * @param $other The other line to intersect.
   * @param [in,out] $nodes The running list of nodes in the graph.
   * @return Whether or not the line segments intersect.
   */
  public function intersect(FishbotLine $other, array &$nodes): bool {
    $denominator = ($this->start->x - $this->end->x) *
        ($other->start->y - $other->end->y) -
        ($this->start->y - $this->end->y) *
        ($other->start->x - $other->end->x);

    if (abs($denominator) < FISHBOT_THRESHOLD) {
      return false;
    }

    $t = (
      ($this->start->x - $other->start->x) *
          ($other->start->y - $other->end->y) -
          ($this->start->y - $other->start->y) *
          ($other->start->x - $other->end->x)
    ) / $denominator;

    $u = (
      ($this->start->y - $this->end->y) *
          ($this->start->x - $other->start->x) -
          ($this->start->x - $this->end->x) *
          ($this->start->y - $other->start->y)
    ) / $denominator;

    if (
      $t <= -FISHBOT_THRESHOLD || $t - 1 >= FISHBOT_THRESHOLD ||
          $u <= -FISHBOT_THRESHOLD || $u - 1 >= FISHBOT_THRESHOLD
    ) {
      return false;
    }

    $intersection = $this[$t];
    $node_found = false;

    foreach ($nodes as $node) {
      if ($node->isClose($intersection)) {
        $intersection = $node;
        $node_found = true;
        break;
      }
    }

    if (!$node_found) {
      $nodes[] = $intersection;
    }

    $this->addNode($t, $intersection);
    $other->addNode($u, $intersection);
    return true;
  }

  private function addNode(float $t, FishbotNode $node): void {
    if (!in_array($node, $this->intersections, true)) {
      $this->intersections[
        (string)abs(round($t / FISHBOT_THRESHOLD) * FISHBOT_THRESHOLD)
      ] = $node;
    }
  }

  public float $cx {
    get => ($this->start->x + $this->end->x) / 2;
  }

  public float $cy {
    get => ($this->start->y + $this->end->y) / 2;
  }
}
?>
