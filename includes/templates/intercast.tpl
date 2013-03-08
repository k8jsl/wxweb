{include file="includes/header.tpl" title="{$locname|capitalize}, {$state} Forecast"}



{include file="includes/localdescrip.tpl"}



<table style="width:100%; borderspacing:1px;">
<tr><td style="width:50%;">

{runner run="metar" locname="{$locname}" state="{$state}" dpp="1"}
{include file="includes/metar_inter.tpl"}

</td>
<td style="width:50%;">
{runner run="astro" locname="{$locname}" state="{$state}"}
{include file="includes/astro.tpl"}
</td></tr>
</table>



<div id="dwmlall">
<div style="text-align:center;">
<table style="width:100%; border-spacing:1px;">
<tr>
{for $x=0 to $QCcount -1}
<td style="width:60px; text-align:center; vertical-align:baseline;">
<span class="daytitles">
{$QCdays[$x]|capitalize}</span>
</td>
{/for}

</tr><tr>
{for $x=0 to $QCcount -1}
<td style="width:60px; text-align:center; vertical-align:baseline;">
<img src="{$iconspath}/wxdir/wxdesk48/{$QCicon[$x]}" alt="" width="40" height="40" />
</td>
{/for}
</tr><tr>
{for $x=0 to $QCcount -1}
<td style="width:60px; text-align:center; vertical-align:baseline;">
<span class="daywx">
{$QCwx[$x]|capitalize}
</span>
</td>
{/for}
</tr><tr>

{for $x=0 to $QCcount -1}
<td style="width:60px; text-align:center; vertical-align:baseline;">
<span style="color:red; font-size:.75em;">H: {$QCMaxC[$x]}&deg;C</span>
<br />
<span style="color:blue; font-size:.75em;">L: {$QCMinC[$x]}&deg;C</span>

</td>
{/for}
</tr></table>
</td>
      
			</tr>
            </table>
            </div>





</div>




















{include file="includes/footer.tpl"}