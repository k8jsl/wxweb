<div>
<table id="dwmltab">
<tr><td colspan="5" class="sechead">
12hr <i>snapcast</i>
</td></tr>

<tr>
{for $x=0 to 4}
<td class="time">
{$Tabtime[$x]}</td>
{/for}
</tr><tr>
{for $x=0 to 4}
<td style="text-align:center;">
<img src="{$iconspath}/wxdir/wxdesk48/glossy/{$Tabicon[$x]}" alt="" width="35" height="35" /><br/>
</td>
{/for}
</tr><tr>
{for $x=0 to 4}
<td class="clouds">
{$Tabclouds[$x]}
</td>
{/for}

</tr><tr>
{for $x=0 to 4}
<td class="wx">
{$Tabwx[$x]}
</td>
{/for}

</tr><tr>
{for $x=0 to 4}
<td class="temp">
{$Tabtemp[$x]}&deg;F
</td>
{/for}

</tr></table>
</div>