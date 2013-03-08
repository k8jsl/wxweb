{include file="includes/header.tpl" title="{$radar_icao|capitalize} Local Radar For {$locname|capitalize}, {$state}"}


<div style="margin-left: auto; margin-right: auto; width: 100%;">

{include file="includes/localdescrip.tpl"}

{include file="nav/arealink.tpl"}





<div id="bkgrnd">
<object type="application/x-shockwave-flash" data="{$csspath}/js/flanis.swf" width="620" height="700" id="FlAniS">
<param name="movie" value="{$csspath}/js/flanis.swf" />
<param name="quality" value="high" />
<param name="menu" value="false" />
<param name="FlashVars" value="{$flashvars}" />
</object>
</div>




</div>














{include file="includes/footer.tpl"}

