<?php
namespace Squiffles;

/**
 * Represents a line segment in an SVG.
 */
class FishbotLine {
  public string $linecap;
  public float $width;
  public float $x1;
  public float $x2;
  public float $y1;
  public float $y2;

  public function __construct(
    float $x1,
    float $y1,
    float $x2,
    float $y2,
    string $linecap,
    float $width
  ) {
    $this->x1 = $x1;
    $this->y1 = $y1;
    $this->x2 = $x2;
    $this->y2 = $y2;
    $this->linecap = $linecap;
    $this->width = $width;
  }

  public float $cx {
    get => ($this->x1 + $this->x2) / 2;
  }

  public float $cy {
    get => ($this->y1 + $this->y2) / 2;
  }

  public float $length {
    get => sqrt(($this->x2 - $this->x1) ** 2 + ($this->y2 - $this->y1) ** 2);
  }

  public float $theta {
    get => atan2($this->y2 - $this->y1, $this->x2 - $this->x1) * 180 / M_PI;
  }
}
?>
