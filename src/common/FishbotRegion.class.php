<?php
namespace Squiffles;

include_once(__DIR__ . '/FishbotNode.class.php');

/**
 * Represents a polygon in a graph with no interior edges.
 */
class FishbotRegion {
  protected array $nodes;

  public function __construct(array $nodes) {
    $this->nodes = $nodes;
  }

  /**
   * Draws the region as HTML elements.
   */
  public function draw(): void {}
}
