<div class="aside aside-left">
  <h2>Travel</h2>
</div>
<div class="map">
  <img src="bin/images/world.png" alt="" />
{foreach from=$arcs item=arc}  <span class="map-arc map-arc-{$arc.type}" style="{$arc.style}"></span>
{/foreach}{foreach from=$points item=point}  <span class="map-point map-point-{$point.side}" style="{$point.style}">
    <span>
      <span>{$point.label}</span>
    </span>
  </span>
{/foreach}</div>
