{include file="includes/header.tpl" title="Multiple Locations"}




<div style="font-size:1.3em; font-weight:bold; text-align:left;">
Multiple Locations
<br/>
<div style="font-size:.75em; font-weight:normal;">
{for $x=0 to $multiple_count - 1}
<a href="{$wxurl}/{$scriptname}?run=daycast&amp;lon={$multiple_locs[$x][3]}&amp;lat={$multiple_locs[$x][2]}">
{$multiple_locs[$x][0]}, {$multiple_locs[$x][1]}</a> Lat: {$multiple_locs[$x][2]} Lon: {$multiple_locs[$x][3]}<br />
{/for}
</div>

























</div>


<!--  -->

















{include file="includes/footer.tpl"}