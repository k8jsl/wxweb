
{if $metarvisibility_miles == '0.25'}
{$vis = '&frac14;'}
{elseif $metarvisibility_miles == '0.50'}
{$vis = '&frac12;'}
{elseif $metarvisibility_miles == '0.75'}
{$vis = '&frac34;'}
{else}
{$vis = $metarvisibility_miles}
{/if}





<div id="metarhorz">
<table  style="border-spacing:1px; width:100%; text-align:center;">
<tr><td class="sechead">
{$metaricao} : {$mname}
</td></tr>
<tr><td>


<table   style="border-spacing:1px; width:100%;">
<tr>
<td rowspan="2">
<img src="{$iconspath}/metar/{$metarwx_icon}" alt="" width="60" height="60" /><br/>
<span class="skywx">{$metarclouds_condition}<br/></span>
{if {$metarweather_condition}}
<span class="skywx">{$metarweather_condition|capitalize}</span>
{/if}
</td><td rowspan="2">
<span class="temp">{$metartemp_f}</span><span class="desig">&deg;F</span>
</td><td class="tdname">
Dew Point:&nbsp;
</td>
<td class="tdvalue">
{$metardew_f}&deg;F
</td>
<td class="tdname">
Humidity:&nbsp;</td>
<td class="tdvalue">
{$metarrel_humidity}%
</td>
<td class="tdname">
Feels Like:&nbsp;</td>
<td class="tdvalue">
{$metarfeelslike_f}&deg;F
</td>
<td class="tdname">
Pressure:&nbsp;</td>
<td class="tdvalue">
{$metarinhg}" ({$metarhpa})
</td>


</tr><tr>
<td class="tdname">
Wind Speed:&nbsp;
</td>
<td class="tdvalue">
{$metarwind_mph}
</td>
<td class="tdname">
Wind Direction:&nbsp;
</td>
<td class="tdvalue">
{$metarwind_eng}
</td>
<td class="tdname">
Wind Gusts:&nbsp;</td>
<td class="tdvalue">
{$metarwind_gust_mph}
</td>
<td class="tdname">
Visibility:&nbsp;</td>
<td class="tdvalue">
{$vis}{if $vis > '2'} miles {else} mile{/if}
</td>
</tr>
</table>

</td></tr>
<tr>

<td class="sechead">
{$metarupdate}
</td></tr></table>
</div>