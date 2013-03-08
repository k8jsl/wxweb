{include file="includes/header.tpl" title="{$locname|capitalize}, {$state} Hourly Forecast"}

<div style="margin-left: auto; margin-right: auto; width: 100%;">

{include file="includes/localdescrip.tpl"}

{include file="nav/arealink.tpl"}


<div id="tabular">

<table class="tabdata">
<tr>
<td class="head">
Date<br />Time
</td><td class="head">
Weather
</td><td class="head">
Clouds
</td><td class="head">
Temp. &deg;F
</td><td class="head">
DewPt &deg;F
</td><td class="head">
Humidity
</td><td class="head">
Feels<br />Like
</td><td class="head">
Wind<br />Speed
</td><td class="head">
Direction
</td><td class="head">
Gust's
</td><td class="head">
PoP*
</td><td class="head">
Precip<br />Amt
</td><td class="head">
Snow<br />Amt
</td>
</tr>
{for $x=0 to {$Tabcount} - 1}
{if $x is even}
    <tr class="even">
    {else}
    <tr class="odd">
    {/if}
<td class="data">
{$Tabdate[$x]}<br />{$Tabtime[$x]}
</td><td class="data">
{$Tabwx[$x]}
</td><td class="data">
<img src="{$iconspath}/wxdir/wxdesk48/glossy/{$Tabicon[$x]}" alt="" width="35" height="35" /><br/>
{$Tabclouds[$x]}
</td><td class="data">
{$Tabtemp[$x]}
</td><td class="data">
{$Tabdew[$x]}
</td><td class="data">
{$Tabrh[$x]}
</td><td class="data">
{$Tabapt[$x]}
</td><td class="data">
{$Tabwsp[$x]}
</td><td class="data">
{$Tabweng[$x]}
</td><td class="data">
{$Tabgust[$x]}
</td><td class="data">
{$Tabpop[$x]}
</td><td class="data">
{$Tabqpf[$x]}
</td><td class="data">
{$Tabsnow[$x]}
</td></tr>
{/for}
</table>
</div>




{include file="includes/googleforecast.tpl"}


</div>


<!--  -->

















{include file="includes/footer.tpl"}