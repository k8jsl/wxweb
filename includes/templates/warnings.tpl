{include file="includes/header.tpl" title="{$locname|capitalize}, {$state} Advisories"}




<div style="margin-left: auto; margin-right: auto; width: 100%;">

{include file="includes/localdescrip.tpl"}
{include file="nav/arealink.tpl"}
<div id="warnings">
{if {$warntotal}}
{for $x=0 to $warntotal - 1}
<span class="warntitle">&nbsp;&nbsp;{$warnname[$x]}&nbsp;&nbsp;&nbsp;</span><br/>
<span class="datebold">Issued:</span> <span class="date">{$warnissue[$x]}</span><br/>
<span class="datebold">Expires:</span> <span class="date">{$warnexpire[$x]}</span><br/>
<pre>{$warnbody[$x]}</pre><hr/>
{/for}
{/if}

{runner run="special" zone="{$zone}" warncounty="{$warncounty}" dpp="1"}
{if $warntotal > '1' && $specialtotal > '1'}
There are currently no Watches, Warnings or Advisories for<br />
{$locname|capitalize}, {$state}
{/if}
<br />

{if {$specialtotal}}
{for $x=0 to $specialtotal - 1}
<span class="warntitle">&nbsp;&nbsp;{$specialname[$x]}&nbsp;&nbsp;&nbsp;</span><br/>
<span class="datebold">Issued:</span> <span class="date">{$specialissue[$x]}</span><br/>
<pre>{$specialbody[$x]}</pre><hr/>
{/for}
{/if}










</div>

</div>










{include file="includes/footer.tpl"}