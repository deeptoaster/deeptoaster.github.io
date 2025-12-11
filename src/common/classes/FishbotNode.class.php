<?php
namespace Squiffles;

/**
 * Represents an intersection point between line segments or ellipses.
 */
class FishbotNode {
  public float $x;
  public float $y;

  public function __construct(float $x, float $y) {
    $this->x = $x;
    $this->y = $y;
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

  public string $hash {
    get => "$this->x,$this->y";
  }
}
