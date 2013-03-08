
<div id="metar">
<table style="width:100%; text-align:center;">
<tr><td class="sechead" colspan="3">
{$mname1x}
</td></tr>

<tr>
<td class="tdname">
Dew Point:&nbsp;</td>
<td class="tdvalue">
{$metardew_c}&deg;C
</td>


<td class="tdname" rowspan="10">
<img src="{$imgpath}/wxicons/metar/{$metarwx_icon}" alt="" /><br/>
{$metarclouds_condition}<br/>
{$metarweather_condition|capitalize}<br/>

<span class="temp">{$metartemp_c}&deg;C</span>
</td>


</tr>
<tr>

<td class="tdname">
Wind Speed:&nbsp;
</td>
<td class="tdvalue">
{$metarwind_knots}knt
</td>

</tr>
<tr>

<td class="tdname">
Wind Direction:&nbsp;</td>
<td class="tdvalue">
{$metarwind_eng} ({$metarwind_deg}&deg;)
</td>

</tr>
<tr>

<td class="tdname">
Wind Gusts:&nbsp;</td>
<td class="tdvalue">
{$metarwind_gust_knots}
</td>

</tr>
<tr>

<td class="tdname">
Humidity:&nbsp;</td>
<td class="tdvalue">
{$metarrel_humidity}%
</td>

</tr>
<tr>

<td class="tdname">
Feels Like:&nbsp;</td>
<td class="tdvalue">
{round(($metarfeelslike_f - 32) / 1.8)}&deg;C
</td>

</tr>
<tr>

<td class="tdname">
Visibility:&nbsp;</td>
<td class="tdvalue">
{$metarvisibility_km}km(s)
</td>

</tr>
<tr>

<td class="tdname">
Pressure:&nbsp;</td>
<td class="tdvalue">
{$metarinhg}" ({$metarhpa})
</td>

</tr>
<tr>

<td class="tdname">
Station:&nbsp;</td>
<td class="tdvalue">
{$metaricao}
</td>

</tr>



<tr><td class="tdname">
Updated:&nbsp;</td>
<td class="tdvalue">
{$metarupdate}
</td></tr></table>
</div>