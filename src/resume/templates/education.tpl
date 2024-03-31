<h1>Education</h1>
<dl class="timeline">
{foreach from=$education item=item}  <dt{if $item.disabled} class="disabled"{/if}>{$item.date}</dt>
  <dd>
    <h4>{$item.major}</h4>
    <h3>{$item.school}</h3>
{if $item.notes}      <p>{$item.notes}</p>
{/if}  </dd>
{/foreach}</dl>
