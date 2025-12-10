<?php
namespace Squiffles;

include_once(__DIR__ . '/FishbotRegion.class.php');

/**
 * Represents a region with exactly three sides.
 */
class FishbotTriangularRegion extends FishbotRegion {
  public FishbotEdge $anchor_edge;
  public FishbotNode $anchor_node;

  public function __construct(array $nodes) {
    $opposite_edges = [
      new FishbotEdge($nodes[1], $nodes[2]),
      new FishbotEdge($nodes[2], $nodes[0]),
      new FishbotEdge($nodes[0], $nodes[1])
    ];

    $this->anchor_node = $nodes[0];
    $this->anchor_edge = $opposite_edges[0];

    for ($index = 1; $index < 3; $index++) {
      if ($opposite_edges[$index]->length > $this->anchor_edge->length) {
        $this->anchor_node = $nodes[$index];
        $this->anchor_edge = $opposite_edges[$index];
      }
    }
  }
}
