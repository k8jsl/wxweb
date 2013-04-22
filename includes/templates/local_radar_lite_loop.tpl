{include file="includes/header.tpl" title="{$radar_icao|capitalize} Local Radar For {$locname|capitalize}, {$state}"}


<div style="margin-left: auto; margin-right: auto; width: 100%;">

{include file="includes/localdescrip.tpl"}

{include file="nav/arealink.tpl"}
{include file="nav/nav_lite_radar_loop.tpl"}


{$radarurl = "http://radar.weather.gov/ridge/lite/"}



<img src="{$radarurl}{$radtype}/{$radar|capitalize}_loop.gif" alt="" />










{include file="includes/footer.tpl"}

