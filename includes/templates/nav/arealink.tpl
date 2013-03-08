<div id="arealink">
<div class="tabsarealink">
<ul>


<li {if $run == 'daycast'} class="active" {else} class="silent"{/if}>
<a href="{$wxurl}/{$scriptname}?run=daycast&amp;locname={$url_locname}&amp;state={$state|lower}">Forecast</a>
</li>


<li {if $run == 'tabular'} class="active" {else} class="silent"{/if}>
<a href="{$wxurl}/{$scriptname}?run=tabular&amp;locname={$url_locname}&amp;state={$state|lower}">
Hourly Forecast</a>
</li>

<li {if $run == 'warnings'} class="active" {else} class="silent"{/if}>
<a href="{$wxurl}/{$scriptname}?run=warnings&amp;locname={$url_locname}&amp;state={$state|lower}">Advisories</a>
</li>

<li {if $run == 'text'} class="active" {else} class="silent"{/if}>
<a href="{$wxurl}/{$scriptname}?run=discussion&amp;locname={$url_locname}&amp;state={$state|lower}">Discussion</a>
</li>

<li {if $run == 'history'} class="active" {else} class="silent"{/if}>
<a href="{$wxurl}/{$scriptname}?run=wxhistory&amp;locname={$url_locname}&amp;state={$state|lower}">3 Day History</a>
</li>

<li {if $run == 'local_radar'} class="active" {else} class="silent"{/if}>
<a href="{$wxurl}/{$scriptname}?run=nwsradar&amp;locname={$url_locname}&amp;state={$state|lower}">Local Radar</a>
</li>
</ul>
</div>
</div>
{if $run == 'nwsradar'}
{include file="nav/nav_local_radar.tpl"}
{else}
{include file="nav/stateextra.tpl"}
{/if}