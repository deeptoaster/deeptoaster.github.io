<?php
namespace Squiffles;

include_once(__DIR__ . '/FishbotEdge.class.php');

/**
 * Represents a wedge formed by two adjacent edges.
 */
class FishbotWedge extends FishbotEdge {
  public bool $consumed = false;
  public FishbotNode $middle;

  public function __construct(FishbotEdge $left, FishbotEdge $right) {
    if ($left->start->hash != $right->start->hash) {
      throw new OutOfBoundsException("Edges must radiate from the same node");
    }

    parent::__construct($left->end, $right->end);
    $this->middle = $left->start;
  }
}
