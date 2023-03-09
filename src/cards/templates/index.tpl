<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
  <head>
    <title>{$title}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta property="og:image" content="https://{$root}/bin/images/preview.png" />
    <meta property="og:title" content="{$title}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://{$root}/cards/" />
    <link href="/bin/fonts/squiffles.css" type="text/css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Raleway:800%7CTitillium+Web:400,700" type="text/css" rel="stylesheet" />
    <link href="/squiffles.css?v={$date}" type="text/css" rel="stylesheet" />
    <script async="async" src="https://www.googletagmanager.com/gtag/js?id=UA-168811289-1"></script>
    <script src="/bin/js/ga.js"></script>
  </head>
  <body class="page">
    <div class="page-inner">
{foreach loop=12}      <div class="card">
        <div class="card-inner">
          <div class="honeycomb">
            <div class="honeycomb-row">
              <div class="honeycomb-cell honeycomb-dark"></div>
              <div class="honeycomb-cell honeycomb-dark"></div>
              <div class="honeycomb-cell honeycomb-dark"></div>
              <div class="honeycomb-cell honeycomb-dark"></div>
              <div class="honeycomb-cell honeycomb-dark"></div>
              <div class="honeycomb-cell honeycomb-dark"></div>
              <div class="honeycomb-cell honeycomb-dark"></div>
              <div class="honeycomb-cell honeycomb-dark"></div>
              <div class="honeycomb-cell honeycomb-dark"></div>
            </div>
            <div class="honeycomb-row">
              <div class="honeycomb-cell honeycomb-medium"></div>
              <div class="honeycomb-cell honeycomb-medium"></div>
              <div class="honeycomb-cell honeycomb-medium"></div>
              <div class="honeycomb-cell"></div>
              <div class="honeycomb-cell honeycomb-medium"></div>
              <div class="honeycomb-cell honeycomb-medium"></div>
              <div class="honeycomb-cell honeycomb-medium"></div>
              <div class="honeycomb-cell honeycomb-medium"></div>
            </div>
            <div class="honeycomb-row">
              <div class="honeycomb-cell"></div>
              <div class="honeycomb-cell honeycomb-light"></div>
              <div class="honeycomb-cell honeycomb-light"></div>
              <div class="honeycomb-cell"></div>
              <div class="honeycomb-cell honeycomb-light"></div>
              <div class="honeycomb-cell"></div>
              <div class="honeycomb-cell honeycomb-light"></div>
              <div class="honeycomb-cell"></div>
              <div class="honeycomb-cell honeycomb-light"></div>
            </div>
          </div>
          <div class="card-fishbot">
            {$fishbot}          </div>
          <div class="card-content">
            <h2>Will Yu</h2>
            <p>
              <a href="tel:+15034278483">(503) 427-8483</a>
              <i class="icon-telephone-of-old-design"></i>
            </p>
            <p>
              <a href="mailto:deeptoaster@gmail.com">deeptoaster@gmail.com</a>
              <i class="icon-note"></i>
            </p>
            <p>
              <a href="http://{$root}/">{$root}</a>
              <i class="icon-link"></i>
            </p>
          </div>
        </div>
      </div>
{/foreach}    </div>
  </body>
</html>
