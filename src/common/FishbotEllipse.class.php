<?php
namespace Squiffles;

include(__DIR__ . '/FishbotLine.class.php');

/**
 * Represents an ellipse in an SVG.
 */
class FishbotEllipse {
  public FishbotNode $center;
  public float $rx;
  public float $ry;
  public float $width;
  private array $intersections = [];

  public function __construct(
    float $cx,
    float $cy,
    float $rx,
    float $ry,
    float $width
  ) {
    $this->center = new FishbotNode($cx, $cy);
    $this->rx = $rx;
    $this->ry = $ry;
    $this->width = $width;
  }

  /**
   * Tests for an incidence between this ellipse and a line segment.
   * @param $line The line segment to test for incidence with.
   * @param [in, out] $nodes The running list of nodes in the graph.
   * @return Whether or not an endpoint of the segment touches the ellipse.
   */
  public function coincide(FishbotLine $line, array &$nodes): bool {
    $start_endpoint = $this->coincideNode($line->start, $nodes);
    $end_endpoint = $this->coincideNode($line->end, $nodes);

    if ($start_endpoint !== null) {
      $line->addNode(0, $start_endpoint);
    }

    if ($end_endpoint !== null) {
      $line->addNode(1, $end_endpoint);
    }

    return $start_endpoint !== null || $end_endpoint !== null;
  }

  /**
   * Splits the ellipse into edges at its recorded intersections.
   * @param [out] $edges The running list of edges in the graph.
   */
  public function collectEdges(array &$edges): void {
    if (count($this->intersections) == 2) {
      $edges[] = new FishbotEdge(
        reset($this->intersections),
        end($this->intersections)
      );
    } else if (count($this->intersections) >= 3) {
      ksort($this->intersections, SORT_NUMERIC);
      $previous_node = end($this->intersections);

      foreach ($this->intersections as $node) {
        $edges[] = new FishbotEdge($previous_node, $node);
        $previous_node = $node;
      }
    }
  }

  private function coincideNode(
    FishbotNode $endpoint,
    array &$nodes
  ): FishbotNode | null {
    if (abs(
      ($endpoint->x - $this->center->x) ** 2 / $this->rx ** 2 +
          ($endpoint->y - $this->center->y) ** 2 / $this->ry ** 2 - 1
    ) >= FISHBOT_THRESHOLD) {
      return null;
    }

    $node_found = false;

    foreach ($nodes as $node) {
      if ($node->isClose($endpoint)) {
        $endpoint = $node;
        $node_found = true;
        break;
      }
    }

    if (!$node_found) {
      $nodes[] = $endpoint;
    }

    if (!in_array($endpoint, $this->intersections, true)) {
      $this->intersections[(string)round(new FishbotEdge(
        $this->center,
        $endpoint
      )->theta)] = $endpoint;
    }

    return $endpoint;
  }
}
?>
