function arc(x0, y0, x1, y1, b) {
  var x = x1 - x0;
  var y = y1 - y0;
  var transform = 'rotate(' + Math.round(Math.atan(y / x) * 180 / Math.PI) + 'deg)';
  var a = Math.sqrt(x * x + y * y) / 2;

  return 'width: ' + Math.round(a * 20) / 10 + 'em; height: ' + Math.round(b * 20) / 10 + 'em; top: ' + Math.round((y0 + y1) * 5 - b * 10) / 10 + 'em; left: ' + Math.round((x0 + x1) * 5 - a * 10) / 10 + 'em; -webkit-transform: ' + transform + '; -o-transform: ' + transform + '; -moz-transform: ' + transform + '; transform: ' + transform + ';';
}

$(function() {
  var presenter = new BreakoutPresenter('#breakout');
  var breakout = new Breakout(presenter);
  var i = 0;

  breakout.load(4, 12);

  $(document).keydown(function(e) {
    if (e.which == 0x0d || e.which == 0x20) {
      breakout.start();
      return false;
    };
  });

  $('.map').click(function(e) {
    var offset = $(this).offset();

    console.log((e.pageX - offset.left) / 16, (e.pageY - offset.top) / 16);
  });

  setInterval(function() {
    $('.reel').each(function() {
      var $children = $(this).children();

      i = (i + 1) % $children.length;

      $(this).animate({
        scrollTop: $children.height() * i
      });
    });
  }, 2000);
});
