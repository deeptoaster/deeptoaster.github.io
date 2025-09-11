<?php
namespace Squiffles;

/**
 * Represents an ellipse in an SVG.
 */
class FishbotEllipse {
  public float $cx;
  public float $cy;
  public float $rx;
  public float $ry;
  public float $width;

  public function __construct(
    float $cx,
    float $cy,
    float $rx,
    float $ry,
    float $width
  ) {
    $this->cx = $cx;
    $this->cy = $cy;
    $this->rx = $rx;
    $this->ry = $ry;
    $this->width = $width;
  }
}
?>
