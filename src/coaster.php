<?
function squiffles_cap($bottom, $left, $width, $height) {
  $x = $width / 10 - $left - 0.3;
  $y = $bottom + $height - 13 - 0.3;

  printf(
    <<<EOF
<span class="coaster-cap" style="bottom: %.1fem; left: %.1fem; width: %dem; height: %dem;">
  <span style="background-position: %.2fem %.2fem;">
    <span style="background-position: %.2fem %.2fem"></span>
  </span>
</span>

EOF
    ,
    $bottom,
    $left,
    $width,
    $height,
    $x,
    $y,
    $x + 0.3,
    $y - ($height + 0.6) / 4 + 0.3
  );
}

function squiffles_clear($bottom, $left, $width, $height) {
  printf(
    <<<EOF
<span class="coaster-clear" style="bottom: %.1fem; left: %.1fem; width: %.1fem; height: %.1fem;"></span>

EOF
    ,
    $bottom,
    $left,
    $width,
    $height,
  );
}

function squiffles_cup($bottom, $left, $width, $height) {
  printf(
    <<<EOF
<span class="coaster-cup" style="bottom: %.1fem; left: %.1fem; width: %dem; height: %dem;">
  <span style="background-position: %.2fem %.2fem"></span>
  <span></span>
</span>

EOF
    ,
    $bottom,
    $left,
    $width,
    $height,
    -$left + 0.3,
    $bottom + $height / 4 - 13
  );
}

function squiffles_line($bottom, $left, $width, $theta) {
  $transform = sprintf('transform: rotate(%ddeg);', $theta);

  printf(
    <<<EOF
<span class="coaster-line" style="bottom: %.1fem; left: %.1fem; width: %dem; -webkit-%s -moz-%s %s"><span></span></span>

EOF
    ,
    $bottom,
    $left,
    $width,
    $transform,
    $transform,
    $transform
  );
}

squiffles_cap(2, 0, 5, 10);
squiffles_line(9.5, 4.9, 4, 70);
squiffles_cup(2.2, 6.3, 9, 16);
squiffles_cap(-2.4, 14.4, 7, 9);
squiffles_cup(4, 20.9, 4, 4);
squiffles_line(4.8, 24.9, 3, -55);
squiffles_cap(-0.2, 26.6, 7, 10);
squiffles_line(7.3, 33.5, 3, 60);
squiffles_cup(2.7, 35.1, 5, 8);
squiffles_line(4.5, 40.2, 6, -60);
squiffles_clear(9.8, 5, 38, 2.2);
squiffles_clear(6.6, 15, 6, 3.2);
squiffles_clear(7.5, 21, 5.6, 2.3);
squiffles_clear(7.5, 33.6, 7, 2.3);
squiffles_clear(12, 0, 43, 2);
?>
