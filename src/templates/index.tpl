<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
  {include file='head.tpl'}
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
      {$fishbot}      {$fishbot}      {include file='links.tpl'}
    </div>
    <div id="scroll">
      <a id="top"></a>
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
