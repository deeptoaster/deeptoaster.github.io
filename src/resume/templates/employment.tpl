<h1>Experience</h1>
<dl class="timeline">
{foreach from=$employment item=item}  <dt{if $item.disabled} class="disabled"{/if}>{$item.date}</dt>
  <dd>
    <h4>{$item.title}</h4>
    <h3>{$item.employer}</h3>
{if $item.notes}    <ul>
{foreach from=$item.notes item=note}      <li>{$note}</li>
{/foreach}    </ul>
{/if}  </dd>
{/foreach}</dl>
