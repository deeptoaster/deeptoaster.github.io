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
        font-size: 20px;
      }
      #header {
        position: fixed;
        z-index: 9;
        width: 100%;
        border-bottom: 1px solid #232627;
        background-color: #161819;
        background-color: rgba(22, 24, 25, 0.8);
      }
      h1, h3, .h1, .h3 {
        line-height: 1em;
        font-family: Raleway, sans-serif;
        text-transform: uppercase;
        letter-spacing: 0.2em;
      }
      h1, .h1 {
        font-size: 2em;
      }
      h3, .h3 {
        font-size: 1em;
      }
      #header .h1, #header .h3 {
        display: inline-block;
        margin: 0;
        color: #617078;
        text-decoration: none;
      }
      #header .h1 {
        padding: 0.5em;
      }
      #header .h3 {
        padding: 1.5em 1em;
      }
      .pull-right {
        float: right;
      }
      #breakout {
        padding-top: 4em;
        padding-bottom: 2em;
        font-size: 1.5em;
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
        <a class="h3" href="/blog/">Blog</a>
        <a class="h3" href="/resume/">Resume</a>
      </div>
      <a class="h1" href="/">Deep Toaster</a>
    </div>
    <div id="breakout" class="section"></div>
  </body>
</html>

