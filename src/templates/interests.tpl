<div class="content">
  <h2>Interests</h2>
  <p class="lead">Things I'm learning, mostly.</p>
  <ul class="list-group">
{foreach from=$interests item=interest}    <li class="list-group-item">
      <span>{$interest}</span>
    </li>
{/foreach}  </ul>
</div>
<div class="coaster">
  <div class="coaster-track" style="margin-left: -64.5em">
    {include file='interests_coaster.tpl'}
  </div>
  <div class="coaster-track" style="margin-left: -21.5em">
    {include file='interests_coaster.tpl'}
  </div>
  <div class="coaster-track" style="margin-left: 21.5em">
    {include file='interests_coaster.tpl'}
  </div>
</div>
