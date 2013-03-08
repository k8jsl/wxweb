<div id="topinfo">
<div>
<span class="name">
{$locname|capitalize}, {$state_full|capitalize}&nbsp;&nbsp;&nbsp;</span>
<span class="info">
{if $county} | {$county|capitalize} {if $state=='LA'}Parish{else}County{/if}{/if}
{if $zipcode} | {$zipcode}{/if}
{if $dlat} | {$dlat}{/if}
{if $dlon} | {$dlon}{/if}
{if $icao1x} | {$icao1x}{/if}
{if $distance} | {$distance} Miles from clicked{/if}
</span>
</div>
</div>