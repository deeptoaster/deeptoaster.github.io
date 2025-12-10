<?php
namespace Squiffles;

include_once(__DIR__ . '/FishbotRegion.class.php');

/**
 * Represents a region with exactly three sides.
 */
class FishbotTriangularRegion extends FishbotRegion {
  public function draw(): void {
    echo "Region over (", implode("), (", array_map(function($node) {
      return $node->hash;
    }, $this->nodes)), ")\n";
  }
}
