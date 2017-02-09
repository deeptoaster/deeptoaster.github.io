<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Deep Toaster</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/lib/breakout/breakout.css" type="text/css" rel="stylesheet" />
		<link href="/lib/fonts/flaticon.css" type="text/css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Raleway:800|Titillium+Web:400,700" type="text/css" rel="stylesheet" />
    <style type="text/css">
      html {
        background-color: #161819;
      }
      body {
        margin: 0;
        font: 20px/1.5em 'Titillium Web', sans-serif;;
      }
      h1 {
        display: inline-block;
        margin: 0;
        padding: 0.5em;
        font-size: 2em;
      }
      h2 {
        margin: 0;
        padding: 0.625em 0;
        font-size: 1.6em;
      }
      h3 {
        margin: 0;
        padding: 2.5em 0 0.5em 0;
        font-size: 1em;
      }
      p {
        margin: 0;
        padding: 0.5em 0;
      }
      cite {
        display: block;
        font-size: 0.7em;
      }
      a {
        color: inherit;
        text-decoration: none;
      }
      a:hover {
        text-decoration: underline;
      }
			i {
				font-style: normal;
				padding-right: 0.5em;
			}
      .section {
        padding: 1em 0;
        overflow: hidden;
        text-align: center;
      }
      .content {
        position: relative;
      }
      .col {
        float: left;
      }
      .lead {
        font-size: 1.2em;
      }
      .map {
        position: absolute;
        top: 0;
        overflow: hidden;
      }
      .map-left {
        left: -20em;
      }
      .map-right {
        right: -20em;
      }
      .map img {
        display: block;
        position: relative;
      }
      .map-left img {
        height: 24em;
        top: 1em;
      }
      .map-right img {
        height: 48em;
        bottom: 16em;
      }
      .map span {
        display: block;
        position: absolute;
        border-width: 0.2em 0 0 0;
        border-style: solid;
        border-radius: 50%;
      }
      .pull-right {
        float: right;
      }
      .reel {
        display: inline-block;
        height: 1em;
        margin-bottom: -0.2em;
        padding-bottom: 0.2em;
        overflow: hidden;
        text-align: right;
        vertical-align: top;
      }
      .reel-symbol {
        display: block;
      }
      .honeycomb {
        margin: 1em 0;
      }
      .honeycomb-row {
        margin: -0.9em;
      }
      .honeycomb-row-offset {
        margin-left: 3.46em;
      }
      .honeycomb-cell {
        display: inline-block;
        position: relative;
        width: 3.46em;
        height: 2em;
        margin: 1em -0.05em;
        background-color: #232627;
        white-space: nowrap;
      }
      .honeycomb-cell::before, .honeycomb-cell::after {
        content: '';
        display: block;
        position: absolute;
        right: 0;
        left: 0;
        border-right: 1.73em solid transparent;
        border-left: 1.73em solid transparent;
      }
      .honeycomb-cell::before {
        bottom: 100%;
        border-bottom: 1em solid #232627;
      }
      .honeycomb-cell::after {
        top: 100%;
        border-top: 1em solid #232627;
      }
      .honeycomb-cell.honeycomb-1064 {
        background-color: #246c60;
      }
      .honeycomb-cell.honeycomb-1064::before {
        border-bottom: 1em solid #246c60;
      }
      .honeycomb-cell.honeycomb-1064::after {
        border-top: 1em solid #246c60;
      }
      .honeycomb-cell.honeycomb-caltech {
        background-color: #61412b;
      }
      .honeycomb-cell.honeycomb-caltech::before {
        border-bottom: 1em solid #61412b;
      }
      .honeycomb-cell.honeycomb-caltech::after {
        border-top: 1em solid #61412b;
      }
      .honeycomb-cell.honeycomb-clrhome {
        background-color: #614d2b;
      }
      .honeycomb-cell.honeycomb-clrhome::before {
        border-bottom: 1em solid #614d2b;
      }
      .honeycomb-cell.honeycomb-clrhome::after {
        border-top: 1em solid #614d2b;
      }
      .honeycomb-cell.honeycomb-omnimaga {
        background-color: #313975;
      }
      .honeycomb-cell.honeycomb-omnimaga::before {
        border-bottom: 1em solid #313975;
      }
      .honeycomb-cell.honeycomb-omnimaga::after {
        border-top: 1em solid #313975;
      }
      .honeycomb-honey {
        position: relative;
        z-index: 1;
        height: 100%;
      }
      .breakout {
        margin: 1em auto;
      }
      #header {
        position: fixed;
        z-index: 9;
        width: 100%;
        border-bottom: 1px solid #232627;
        background-color: #161819;
        background-color: rgba(22, 24, 25, 0.8);
        color: #617078;
      }
      #header .pull-right, h1, h2, h3 {
        text-transform: uppercase;
        line-height: 1em;
        font-family: Raleway, sans-serif;
        letter-spacing: 0.2em;
      }
      #header a {
        display: block;
        text-decoration: none;
      }
      #header .pull-right a {
        display: inline-block;
        padding: 1.5em 1em;
      }
      #breakout {
        padding-top: 3em;
        font-size: 1.5em;
      }
      #about {
        position: relative;
        background-color: #a6b8c1;
        color: #374952;
      }
      #about .row {
        margin: 0 -4em;
      }
      #about .row::after {
        content: '';
        display: block;
        clear: both;
      }
      #about .col {
        width: 50%;
      }
      #about #presence {
        width: 10em;
        margin: auto;
      }
      #about .content {
        padding: 0 16em;
      }
      #about .map span {
        border-color: #ff8900;
      }
      #about h2, #about h3, #about cite {
        color: #477286;
      }
      #about ul {
        list-style-type: none;
        margin: 0;
        padding: 0.5em 0;
      }
      #about li {
        text-align: left;
      }
      #about em {
        display: inline-block;
        height: 1em;
        margin: -0.1em 0 -0.3em 0;
        border: 0.1em dashed #d4a36a;
        padding-bottom: 0.2em;
        background-color: #ffb158;
        font-style: normal;
      }
      #activities {
        background-color: #d2d7d9;
        color: #232627;
      }
      #activities h2 {
        color: #27556c;
      }
      #gallery h2 {
        color: #617078;
      }
			@media screen and (max-width: 960px) {
				body {
					font-size: 16px;
				}
			}
			@media screen and (max-width: 768px) {
        #about .row {
          margin: 0;
        }
				#about .content {
          background-color: #d2dbe0;
          background-color: rgba(255, 255, 255, 0.5);
          margin: 0 1em;
          padding: 1em;
        }
			}
    </style>
    <script type="text/javascript" src="/lib/js/jquery.min.js"></script>
    <script type="text/javascript" src="/lib/breakout/breakout.js"></script>
    <script type="text/javascript" src="/lib/breakout/breakoutpresenter.js"></script>
    <script type="text/javascript">// <![CDATA[
      function arc(x0, y0, x1, y1, b) {
        var x = x1 - x0;
        var y = y1 - y0;
        var transform = 'rotate(' + Math.round(Math.atan(y / x) * 180 / Math.PI) + 'deg)';
        var a = Math.sqrt(x * x + y * y) / 2;

        return 'width: ' + Math.round(a * 20) / 10 + 'em; height: ' + Math.round(b * 20) / 10 + 'em; top: ' + Math.round((y0 + y1) * 5 - b * 10) / 10 + 'em; left: ' + Math.round((x0 + x1) * 5 - a * 10) / 10 + 'em; transform: ' + transform + '; -webkit-transform: ' + transform + '; -o-transform: ' + transform + '; -moz-transform: ' + transform + ';';
      }

      $(function() {
        var presenter = new BreakoutPresenter('#breakout');
        var breakout = new Breakout(presenter);
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
            var top = $(this).scrollTop();
            var newTop;

            do {
              newTop = $children.height() * Math.floor(Math.random() * $children.length);
            } while (top == newTop);

            $(this).animate({
              scrollTop: newTop
            });
          });
        }, 2000);
      });
    // ]]></script>
  </head>
  <body>
    <div id="header">
      <div class="pull-right">
        <a href="/blog/">Blog</a>
        <a href="/resume/">Resume</a>
      </div>
      <h1>
        <a href="/">Deep Toaster</a>
      </h1>
    </div>
    <div id="breakout" class="section"></div>
    <div id="about" class="section">
      <div class="map map-left">
        <img src="/lib/img/asia.png" alt="" />
      </div>
      <div class="map map-right">
        <img src="/lib/img/north_america.png" alt="" />
        <span style="width: 2.1em; height: 1em; top: 15.5em; left: 10.2em; transform: rotate(76deg); -webkit-transform: rotate(76deg); -o-transform: rotate(76deg); -moz-transform: rotate(76deg);"></span>
        <span style="width: 1.8em; height: 1em; top: 13.8em; left: 9.6em; transform: rotate(56deg); -webkit-transform: rotate(56deg); -o-transform: rotate(56deg); -moz-transform: rotate(56deg);"></span>
        <span style="width: 3.5em; height: 2em; top: 14.3em; left: 9.5em; transform: rotate(82deg); -webkit-transform: rotate(82deg); -o-transform: rotate(82deg); -moz-transform: rotate(82deg);"></span>
        <span style="width: 3.5em; height: 2em; top: 10.8em; left: 9.5em; transform: rotate(98deg); -webkit-transform: rotate(98deg); -o-transform: rotate(98deg); -moz-transform: rotate(98deg);"></span>
        <span style="width: 1.1em; height: 1em; top: 9em; left: 11.2em; transform: rotate(117deg); -webkit-transform: rotate(117deg); -o-transform: rotate(117deg); -moz-transform: rotate(117deg);"></span>
        <span style="width: 1.1em; height: 1em; top: 8em; left: 11.7em; transform: rotate(117deg); -webkit-transform: rotate(117deg); -o-transform: rotate(117deg); -moz-transform: rotate(117deg);"></span>
        <span style="width: 1em; height: 1em; top: 7em; left: 12em; transform: rotate(90deg); -webkit-transform: rotate(90deg); -o-transform: rotate(90deg); -moz-transform: rotate(90deg);"></span>
        <span style="width: 1.8em; height: 1em; top: 15.8em; left: 10.1em; transform: rotate(-124deg); -webkit-transform: rotate(-124deg); -o-transform: rotate(-124deg); -moz-transform: rotate(-124deg);"></span>
        <span style="width: 2.1em; height: 1em; top: 14em; left: 9.2em; transform: rotate(-104deg); -webkit-transform: rotate(-104deg); -o-transform: rotate(-104deg); -moz-transform: rotate(-104deg);"></span>
        <span style="width: 3.8em; height: 3em; top: 13.8em; left: 8.8em; transform: rotate(-113deg); -webkit-transform: rotate(-113deg); -o-transform: rotate(-113deg); -moz-transform: rotate(-113deg);"></span>
        <span style="width: 3.8em; height: 4em; top: 13.3em; left: 8.8em; transform: rotate(-113deg); -webkit-transform: rotate(-113deg); -o-transform: rotate(-113deg); -moz-transform: rotate(-113deg);"></span>
        <span style="width: 1em; height: 1em; top: 7em; left: 12em; transform: rotate(-90deg); -webkit-transform: rotate(-90deg); -o-transform: rotate(-90deg); -moz-transform: rotate(-90deg);"></span>
        <span style="width: 1.1em; height: 1em; top: 8em; left: 11.7em; transform: rotate(-63deg); -webkit-transform: rotate(-63deg); -o-transform: rotate(-63deg); -moz-transform: rotate(-63deg);"></span>
        <span style="width: 1em; height: 2em; top: 6.5em; left: 12em; transform: rotate(90deg); -webkit-transform: rotate(90deg); -o-transform: rotate(90deg); -moz-transform: rotate(90deg);"></span>
        <span style="width: 1.1em; height: 2em; top: 7.5em; left: 11.7em; transform: rotate(117deg); -webkit-transform: rotate(117deg); -o-transform: rotate(117deg); -moz-transform: rotate(117deg);"></span>
        <span style="width: 2.2em; height: 1em; top: 16em; left: 11.4em; transform: rotate(153deg); -webkit-transform: rotate(153deg); -o-transform: rotate(153deg); -moz-transform: rotate(153deg);"></span>
        <span style="width: 2.5em; height: 2em; top: 14.3em; left: 13.3em; transform: rotate(-37deg); -webkit-transform: rotate(-37deg); -o-transform: rotate(-37deg); -moz-transform: rotate(-37deg);"></span>
        <span style="width: 3.5em; height: 2em; top: 13.8em; left: 15.5em; transform: rotate(8deg); -webkit-transform: rotate(8deg); -o-transform: rotate(8deg); -moz-transform: rotate(8deg);"></span>
      </div>
      <div class="content">
        <h2>About</h2>
        <p class="lead">
          <span class="reel">
            <span class="reel-symbol">Game</span>
            <span class="reel-symbol">Graphic</span>
            <span class="reel-symbol">Web</span>
          </span>
          <span>designer, avid <em>hitchhiker</em>, and student of life who drinks tea and poops code.</span>
        </p>
        <div class="row">
          <div class="col">
            <h3>Affiliations</h3>
            <div class="honeycomb">
              <div class="honeycomb-row">
                <a class="honeycomb-cell honeycomb-caltech" href="http://caltech.edu/">
                  <img class="honeycomb-honey" src="/lib/img/caltech.png" alt="Caltech" title="Caltech" />
                </a>
                <a class="honeycomb-cell" href="https://blacker.caltech.edu/">
                  <img class="honeycomb-honey" src="/lib/img/blacker.png" alt="Blacker" title="Blacker" />
                </a>
                <a class="honeycomb-cell honeycomb-1064" href="http://ohaithe.re/">
                  <img class="honeycomb-honey" src="/lib/img/1064.png" alt="1064cbread" title="1064cbread" />
                </a>
              </div>
              <div class="honeycomb-row">
                <a class="honeycomb-cell honeycomb-omnimaga" href="https://www.omnimaga.org/">
                  <img class="honeycomb-honey" src="/lib/img/omnimaga.png" alt="Omnimaga" title="Omnimaga" />
                </a>
                <a class="honeycomb-cell honeycomb-clrhome" href="http://clrhome.org/">
                  <img class="honeycomb-honey" src="/lib/img/clrhome.png" alt="ClrHome" title="ClrHome" />
                </a>
              </div>
            </div>
          </div>
          <div class="col">
            <h3>Presence</h3>
            <ul id="presence">
              <li>
                <i class="flaticon-mail-envelope"></i>
                <a href="mailto:yizhenwilliam@gmail.com">Email</a>
              </li>
              <li>
                <i class="flaticon-facebook-app-logo"></i>
                <a href="https://www.facebook.com/yizhenwilliam">Facebook</a>
              </li>
              <li>
                <i class="flaticon-people"></i>
                <a href="https://www.couchsurfing.com/people/yizhenwilliam">Couchsurfing</a>
              </li>
              <li>
                <i class="flaticon-multimedia"></i>
                <a href="http://https://github.com/DThought">GitHub</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div id="activities" class="section">
      <h2>Activities</h2>
    </div>
    <div id="gallery" class="section">
      <h2>Gallery</h2>
    </div>
  </body>
</html>
