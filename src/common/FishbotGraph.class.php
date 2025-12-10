<?php
namespace Squiffles;

include(__DIR__ . '/FishbotEllipse.class.php');
include(__DIR__ . '/FishbotLine.class.php');
include(__DIR__ . '/FishbotTriangularRegion.class.php');

/**
 * Represents a planar graph derived form an SVG.
 */
class FishbotGraph {
  private array $edges = [];
  private array $nodes = [];

  public function __construct(array $lines, array $ellipses) {
    foreach ($lines as $l1_index => $l1) {
      for ($l2_index = $l1_index + 1; $l2_index < count($lines); $l2_index++) {
        $l1->intersect($lines[$l2_index], $this->nodes);
      }
    }

    foreach ($lines as $line) {
      $line->collectEdges($this->edges);
    }
  }

  /**
   * Computes non-intersecting regions.
   * @return The non-intersecting regions of this graph.
   */
  public function getRegions(): array {
    $edges_by_node = [];

    foreach ($this->nodes as $node) {
      $edges_by_node[$node->hash] = [];
    }

    foreach ($this->edges as $edge) {
      $edges_by_node[$edge->start->hash][] = $edge;

      $edges_by_node[$edge->end->hash][] = new FishbotEdge(
        $edge->end,
        $edge->start
      );
    }

    // sorting &$node_edges in place leads to a duplication bug
    foreach ($edges_by_node as $node_hash => $node_edges) {
      usort($node_edges, function(FishbotEdge $a, FishbotEdge $b) {
        return $a->theta <=> $b->theta;
      });

      $edges_by_node[$node_hash] = $node_edges;
    }

    $wedges = [];
    $wedges_by_node = [];

    foreach ($this->nodes as $node) {
      $wedges_by_node[$node->hash] = [];
    }

    foreach ($edges_by_node as $node_hash => $node_edges) {
      foreach ($node_edges as $edge_index => $edge) {
        $next_edge = $node_edges[($edge_index + 1) % count($node_edges)];
        $wedge = new FishbotWedge($edge, $next_edge);
        $wedges[] = $wedge;
        $wedges_by_node[$edge->end->hash][$node_hash] = $wedge;
      }
    }

    $regions = [];

    foreach ($wedges as $start_wedge) {
      if ($start_wedge->consumed) {
        continue;
      }

      $region = [];
      $wedge = $start_wedge;
      $skip_next_node = false;

      do {
        if (!$skip_next_node) {
          $region[] = $wedge->start;
        }

        $wedge->consumed = true;
        $skip_next_node = $wedge->flat;
        $wedge = $wedges_by_node[$wedge->middle->hash][$wedge->end->hash];
      } while ($wedge !== $start_wedge);

      if ($skip_next_node) {
        array_shift($region);
      }

      $regions[] = count($region) === 3
        ? new FishbotTriangularRegion($region)
        : new FishbotRegion($region);
      $start_wedge->consumed = true;
    }

    return $regions;
  }
}
