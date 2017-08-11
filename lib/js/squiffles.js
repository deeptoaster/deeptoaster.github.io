function arc(x0, y0, x1, y1, b) {
  var x = x1 - x0;
  var y = y1 - y0;
  var transform = 'rotate(' + Math.round(Math.atan(y / x) * 180 / Math.PI) + 'deg)';
  var a = Math.sqrt(x * x + y * y) / 2;

  return 'width: ' + Math.round(a * 20) / 10 + 'em; height: ' + Math.round(b * 20) / 10 + 'em; top: ' + Math.round((y0 + y1) * 5 - b * 10) / 10 + 'em; left: ' + Math.round((x0 + x1) * 5 - a * 10) / 10 + 'em; -webkit-transform: ' + transform + '; -o-transform: ' + transform + '; -moz-transform: ' + transform + '; transform: ' + transform + ';';
}

$(function() {
  var breakoutpresenter = new BreakoutPresenter($('#breakout div'));
  var breakout = new Breakout(breakoutpresenter);
  var showcasepresenter = new ShowcasePresenter($('#gallery .content div'));
  var showcase = new Showcase(showcasepresenter);
  var i = 0;

  breakout.load(4, 12);

  showcase.load([
    {
      caption: '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,</p>',
      image: 'http://via.placeholder.com/450x300'
    },
    {
      caption: '<p>sed doeiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enimad minim veniam,</p>',
      image: 'http://via.placeholder.com/600x400'
    },
    {
      caption: '<p>quis nostrud exercitation ullamco laboris nisi utaliquip ex ea commodo consequat.</p>',
      image: 'http://via.placeholder.com/750x500'
    },
    {
      caption: '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,</p>',
      image: 'http://via.placeholder.com/450x300'
    },
    {
      caption: '<p>sed doeiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enimad minim veniam,</p>',
      image: 'http://via.placeholder.com/600x400'
    },
    {
      caption: '<p>quis nostrud exercitation ullamco laboris nisi utaliquip ex ea commodo consequat.</p>',
      image: 'http://via.placeholder.com/750x500'
    },
    {
      caption: '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,</p>',
      image: 'http://via.placeholder.com/450x300'
    },
    {
      caption: '<p>sed doeiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enimad minim veniam,</p>',
      image: 'http://via.placeholder.com/600x400'
    },
    {
      caption: '<p>quis nostrud exercitation ullamco laboris nisi utaliquip ex ea commodo consequat.</p>',
      image: 'http://via.placeholder.com/750x500'
    }
  ]);

  showcasepresenter.autoHide();

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
