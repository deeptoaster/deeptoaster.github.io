<h3>Languages</h3>
{foreach from=$languages item=language}<div class="col col-40">
  <p>{$language.name}</p>
</div>
<div class="col col-60">
  <div class="progress">
    <span style="width: {$language.proficiency}%;"></span>
  </div>
</div>
{/foreach}
