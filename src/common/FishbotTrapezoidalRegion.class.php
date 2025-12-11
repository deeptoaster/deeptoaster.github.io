<?php
namespace Squiffles;

include_once(__DIR__ . '/FishbotRegion.class.php');

/**
 * Represents a region with exactly four sides, two of which are parallel.
 */
class FishbotTrapezoidalRegion extends FishbotRegion {
  public FishbotEdge $long_edge;
  public FishbotEdge $short_edge;

  public function __construct(array $nodes) {
    $edges = [
      new FishbotEdge($nodes[0], $nodes[1]),
      new FishbotEdge($nodes[1], $nodes[2]),
      new FishbotEdge($nodes[2], $nodes[3]),
      new FishbotEdge($nodes[3], $nodes[0])
    ];

    if (
      abs(abs($edges[0]->theta - $edges[2]->theta) - 180) <
          abs(abs($edges[1]->theta - $edges[3]->theta) - 180)
    ) {
      if ($edges[0]->length > $edges[2]->length) {
        $this->long_edge = $edges[0];
        $this->short_edge = $edges[2];
      } else {
        $this->long_edge = $edges[2];
        $this->short_edge = $edges[0];
      }
    } else {
      if ($edges[1]->length > $edges[3]->length) {
        $this->long_edge = $edges[1];
        $this->short_edge = $edges[3];
      } else {
        $this->long_edge = $edges[3];
        $this->short_edge = $edges[1];
      }
    }
  }
}
