<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Deep Toaster</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/lib/breakout/breakout.css" type="text/css" rel="stylesheet" />
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
        margin: 0.625em 0;
        font-size: 1.6em;
      }
      p {
        margin: 1em 0;
      }
      .section {
        padding: 1em 0;
      }
      .lead {
        font-size: 1.2em;
      }
      .pull-right {
        float: right;
      }
      .reel {
        display: inline-block;
        height: 1em;
        overflow: hidden;
        text-align: right;
      }
      .reel-symbol {
        display: block;
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
      }
      #header .pull-right, h1, h2 {
        text-transform: uppercase;
        line-height: 1em;
        font-family: Raleway, sans-serif;
        letter-spacing: 0.2em;
      }
      #header a {
        display: block;
        color: #617078;
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
        padding-left: 8em;
        padding-right: 8em;
        background-color: #a6b8c1;
        color: #374952;
        text-align: center;
      }
      #about h2 {
        color: #477286;
      }
    </style>
    <script type="text/javascript" src="/lib/js/jquery.min.js"></script>
    <script type="text/javascript" src="/lib/breakout/breakout.js"></script>
    <script type="text/javascript" src="/lib/breakout/breakoutpresenter.js"></script>
    <script type="text/javascript">// <![CDATA[
      $(function() {
        var presenter = new BreakoutPresenter('#breakout');
        var breakout = new Breakout(presenter);
        breakout.load(4, 12);

        $(document).keydown(function(e) {
          if (e.which == 0x0d || e.which == 0x20) {
            breakout.start();
          };
        });
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
      <h2>About</h2>
      <p class="lead">
        <span class="reel">
          <span class="reel-symbol">Game</span>
          <span class="reel-symbol">Graphic</span>
          <span class="reel-symbol">Web</span>
        </span>
        <span>designer, avid hitchhiker, and student of life who drinks tea and poops code.</span>
      </p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>
  </body>
</html>

