

<table class="inner">
{for $x=0 to $DayCount -1}
{if $x is even}
    <tr class="even">
    {else}
    <tr class="odd">
    {/if}
<td class="date">
{$DayNames[$x]|capitalize}<br/>
{if $Dayhi[$x]}
<span style="color:red; font-size:.85em;">H: {$Dayhi[$x]}</span>
{/if}
{if $Daylo[$x]}
<span style="color:blue; font-size:.85em;">L: {$Daylo[$x]}</span>
{/if}
</td>
<td class="daycast">
{$Daycast[$x]|capitalize}
</td></tr>
{/for}



</table>
