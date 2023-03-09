<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
  <head>
    <title>{$title}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta property="og:image" content="https://{$root}/bin/images/preview.png" />
    <meta property="og:title" content="{$title}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://{$root}/" />
    <link href="/bin/fonts/squiffles.css" type="text/css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Raleway:800%7CTitillium+Web:400,700" type="text/css" rel="stylesheet" />
    <link href="/squiffles.css?v={$date}" type="text/css" rel="stylesheet" />
    <script async="async" src="https://www.googletagmanager.com/gtag/js?id=UA-168811289-1"></script>
    <script src="/bin/js/ga.js"></script>
  </head>
  <body>
    <div id="header">
      <div class="pull-right">
        <a href="/blog/">Blog</a>
        <a href="/resume/">Resume</a>
      </div>
      <h1>
        <a href="/">{$title}</a>
      </h1>
    </div>
    <div id="fishbot">
      {include_php file='fishbot.php'}
      {include file='links.tpl'}
    </div>
    <div id="scroll">
      <div id="about">
        {include file='about.tpl'}
      </div>
      <div id="travel">
        {include file='travel.tpl'}
      </div>
      <div id="gallery">
        {include file='gallery.tpl'}
      </div>
    </div>
  </body>
</html>
