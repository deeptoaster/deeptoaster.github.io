<?php
namespace Squiffles;

include_once(__DIR__ . '/FishbotEdge.class.php');

/**
 * Represents a wedge formed by two adjacent edges.
 */
class FishbotWedge extends FishbotEdge {
  public bool $consumed = false;
  public FishbotNode $middle;
  private FishbotEdge $left;
  private FishbotEdge $right;

  public function __construct(FishbotEdge $left, FishbotEdge $right) {
    if ($left->start->hash != $right->start->hash) {
      throw new OutOfBoundsException("Edges must radiate from the same node");
    }

    parent::__construct($left->end, $right->end);
    $this->left = $left;
    $this->right = $right;
    $this->middle = $left->start;
  }

  public bool $flat {
    get => (
      abs(abs($this->left->theta - $this->right->theta) - 180) <
          FISHBOT_THRESHOLD
    );
  }
}
