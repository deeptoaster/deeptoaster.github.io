<?php
namespace Squiffles;

/**
 * Represents an intersection point between line segments or ellipses.
 */
class FishbotNode {
  public array $edges;
  public float $x;
  public float $y;

  public function __construct(float $x, float $y) {
    $this->edges = [];
    $this->x = $x;
    $this->y = $y;
  }

  /**
   * Adds an edge to this node.
   * @param $edge The edge to add.
   */
  public function addEdge(FishbotEdge $edge): void {
    if (!in_array($edge, $this->edges, true)) {
      $this->edges[] = $edge;
    }
  }

  /**
   * Tests if this node is close to another node.
   * @param $other The other node to test.
   * @return Whether or not the nodes are close.
   */
  public function isClose(FishbotNode $other): bool {
    return sqrt(
      ($this->x - $other->x) ** 2 + ($this->y - $other->y) ** 2
    ) < FISHBOT_THRESHOLD;
  }
}
