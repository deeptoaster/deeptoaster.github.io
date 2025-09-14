<?php
namespace Squiffles;

/**
 * Represents an edge between two nodes.
 */
class FishbotEdge {
  public FishbotNode $start;
  public FishbotNode $end;

  public function __construct(FishbotNode $start, FishbotNode $end) {
    $this->start = $start;
    $this->end = $end;
  }

  public float $theta {
    get => atan2(
      $this->start->x - $this->start->y,
      $this->end->x - $this->end->y
    ) * 180 / M_PI;
  }
}
