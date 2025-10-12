<?php
namespace Squiffles;

/**
 * Represents an edge between two nodes.
 */
class FishbotEdge {
  public FishbotNode $end;
  public FishbotNode $start;

  public function __construct(FishbotNode $start, FishbotNode $end) {
    $this->start = $start;
    $this->end = $end;
  }

  public float $theta {
    get => atan2(
      $this->end->y - $this->start->y,
      $this->end->x - $this->start->x
    ) * 180 / M_PI;
  }
}
