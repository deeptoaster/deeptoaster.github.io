<?php
namespace Squiffles;

include_once(__DIR__ . '/FishbotNode.class.php');

/**
 * Represents an edge between two nodes.
 */
class FishbotEdge implements \ArrayAccess {
  public FishbotNode $end;
  public FishbotNode $start;

  public function __construct(FishbotNode $start, FishbotNode $end) {
    $this->start = $start;
    $this->end = $end;
  }

  public function offsetExists(mixed $t): bool {
    return is_numeric($t);
  }

  public function offsetGet(mixed $t): FishbotNode {
    return new FishbotNode(
      $this->start->x + $t * ($this->end->x - $this->start->x),
      $this->start->y + $t * ($this->end->y - $this->start->y)
    );
  }

  public function offsetSet(mixed $t, mixed $value): void {}
  public function offsetUnset(mixed $t): void {}

  /**
   * Finds the projection of a node on the edge.
   * @param $node The node to project.
   * @return The projection of the node on the edge.
   */
  public function project(FishbotNode $node): FishbotNode {
    return $this[(
      ($this->end->x - $this->start->x) * ($node->x - $this->start->x) +
          ($this->end->y - $this->start->y) * ($node->y - $this->start->y)
    ) / $this->length ** 2];
  }

  public float $length {
    get => sqrt(
      ($this->end->x - $this->start->x) ** 2 +
          ($this->end->y - $this->start->y) ** 2
    );
  }

  public float $theta {
    get => atan2(
      $this->end->y - $this->start->y,
      $this->end->x - $this->start->x
    ) * 180 / M_PI;
  }
}
