
<div id="metar">
<table style="width:100%; text-align:center;">
<tr><td class="sechead" colspan="3">
{$mname1x}
</td></tr>

<tr>
<td class="tdname">
Dew Point:&nbsp;</td>
<td class="tdvalue">
{$metardew_f}&deg;F
</td>


<td class="tdname" rowspan="10">
<img src="{$imgpath}/wxicons/metar/{$metarwx_icon}" alt="" /><br/>
{$metarclouds_condition}<br/>
{$metarweather_condition|capitalize}<br/>

<span class="temp">{$metartemp_f}&deg;F</span>
</td>


</tr>
<tr>

<td class="tdname">
Wind Speed:&nbsp;
</td>
<td class="tdvalue">
{$metarwind_mph}
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
{$metarwind_gust_mph}
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
{$metarfeelslike_f}&deg;F
</td>

</tr>
<tr>

<td class="tdname">
Visibility:&nbsp;</td>
<td class="tdvalue">
{$metarvisibility_miles}mile(s)
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