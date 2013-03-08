<div id="dwmlall">
<div style="text-align:center;">
<table style="width:100%; border-spacing:1px;">
<tr>
{for $x=0 to $DayCount -1}
<td style="width:60px; text-align:center; vertical-align:baseline;">
<span class="daytitles">
{$DayNames[$x]|capitalize}
</span>
</td>
{/for}

</tr><tr>

{for $x=0 to $DayCount -1}
<td style="width:60px; text-align:center; vertical-align:baseline;">
<img src="{$NWSicon[$x]}" alt="" width="50" height="50" />
</td>
{/for}


</tr><tr>

{for $x=0 to $DayCount -1}
<td style="width:60px; text-align:center; vertical-align:baseline;">
<span class="daywx">{$Daywx[$x]|capitalize}</span>
</td>
{/for}


</tr><tr>

{for $x=0 to $DayCount -1}
<td style="width:60px; text-align:center; vertical-align:baseline;">
{if $Dayhi[$x]}
<span style="color:red; font-size:.75em;">H: {$Dayhi[$x]}</span>
{/if}
{if $Daylo[$x]}
<span style="color:blue; font-size:.75em;">L: {$Daylo[$x]}</span>
{/if}
{if $Daypop[$x]}
<br /><span style="color:green; font-size:.75em;">Pop: {$Daypop[$x]}%</span>
{/if}
</td>
{/for}

</tr>
</table>

</div>
</div>