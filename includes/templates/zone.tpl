
{include file="includes/header.tpl" title="{$locname|capitalize}, {$state} Forecast"}



{include file="includes/localdescrip.tpl"}

{include file="nav/arealink.tpl"}
<table style="width:100%; borderspacing:1px;">
<tr><td style="width:50%;">

{runner run="metar" locname="{$locname}" state="{$state}" dpp="1"}
{include file="includes/metar.tpl"}

</td>
<td style="width:50%;">
{runner run="astro" locname="{$locname}" state="{$state}"}
{include file="includes/astro.tpl"}
</td></tr>
</table>

<div id="dwmlfull">
<div class="sechead">
Updated: {$update}
</div>

{include file="includes/zonefull.tpl"}
</div>







<!--  -->

















{include file="includes/footer.tpl"}