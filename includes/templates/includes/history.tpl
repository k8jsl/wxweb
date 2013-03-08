{include file="header.tpl" title="{$icao1x|capitalize} - 3 day weather history for {$wxhistory_place}"}


<div style="margin-left: auto; margin-right: auto; width: 70%;">

{include file="includes/localdescrip.tpl"}

{include file="nav/arealink.tpl"}

{if {$alerttotal}}
{include file="includes/alertbox.tpl"}
{/if}


<table class="history">
<tbody>
<tr class="trhead">
<th rowspan="3">D<br />a<br />t<br />e</th>
<th rowspan="3">Time</th>
<th rowspan="3">Wind<br />(mph)</th>
<th rowspan="3">Vis.<br />(mi.)</th>
<th rowspan="3">Weather</th>
<th rowspan="3">Sky Cond.</th>
<th colspan="6">Temperature (&deg;F)</th>
<th rowspan="3">Relative<br />Humidity</th>
<th colspan="2">Pressure</th>
<th colspan="3">Precipitation (in.)</th></tr>

<tr class="trhead">

<th rowspan="2">Air</th>
<th rowspan="2">Dwpt</th>
<th rowspan="2">WC</th>
<th rowspan="2">HI</th>
<th colspan="2">6 hour</th>
<th rowspan="2">altimeter<br />(in.)</th>
<th rowspan="2">sea level<br />(mb)</th>
<th rowspan="2">1 hr</th>
<th rowspan="2">3 hr</th>
<th rowspan="2">6 hr</th>

</tr><tr class="trhead">

<th>Max.</th>
<th>Min.</th>

</tr>

{if $wxhistory_total}
{for $x=0 to $wxhistory_total - 1}
{if $x is even}
<tr class="even">
{else}
<tr class="odd">
{/if}
    <td>{$wxhistory_date[$x]}</td>
    <td>{$wxhistory_time[$x]}</td>
    <td>{$wxhistory_wind[$x]}</td>
    <td>{$wxhistory_vis[$x]}</td>
    <td>{$wxhistory_wx[$x]}</td>
    <td>{$wxhistory_skycond[$x]}</td>
    <td>{$wxhistory_temp[$x]}</td>
    <td>{$wxhistory_dwpt[$x]}</td>
    <td>{$wxhistory_wc[$x]}</td>
    <td>{$wxhistory_hi[$x]}</td>
    <td></td>
    <td></td>
    <td>{$wxhistory_rh[$x]}</td>
    <td>{$wxhistory_pressalt[$x]}</td>
    <td>{$wxhistory_pressmb[$x]}</td>
    <td>{$wxhistory_precipone[$x]}</td>
    <td>{$wxhistory_precipthree[$x]}</td>
    <td>{$wxhistory_precipsix[$x]}</td>
</tr>
{/for}
{/if}
</table>












</div>















{include file="footer.tpl"}

