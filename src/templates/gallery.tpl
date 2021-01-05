<div class="content">
  <h2>Gallery</h2>
  <div class="showcase">
    <div class="showcase-pages">
      <div>
{foreach from=$pages item=page}        <div id="showcase-page-{$page.id}" class="showcase-page">
          <a class="showcase-pager" href="#showcase-page-{$page.previous}">
            &lang;
          </a>
{foreach from=$page.thumbnails item=thumbnail}          <a class="showcase-thumbnail" href="#showcase-centerfold-{$thumbnail.id}">
            <img src="{$thumbnail.image}" alt="" />
          </a>
{/foreach}{foreach from=$page.padding}          <span class="showcase-thumbnail"></span>
{/foreach}          <a class="showcase-pager" href="#showcase-page-{$page.next}">
            &rang;
          </a>
        </div>
{/foreach}      </div>
    </div>
    <div class="showcase-focus">
      <div>
{foreach from=$pages item=page}{foreach from=$page.thumbnails item=thumbnail}        <div id="showcase-centerfold-{$thumbnail.id}" class="showcase-centerfold">
          <img src="{$thumbnail.image}" alt="" />
          <div class="showcase-caption">
            <p>{$thumbnail.description}</p>
          </div>
        </div>
{/foreach}{/foreach}      </div>
    </div>
  </div>
</div>
<div class="coaster">
  <div class="coaster-track" style="margin-left: -64.5em">
    {$coaster}  </div>
  <div class="coaster-track" style="margin-left: -21.5em">
    {$coaster}  </div>
  <div class="coaster-track" style="margin-left: 21.5em">
    {$coaster}  </div>
</div>
