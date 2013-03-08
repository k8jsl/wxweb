{include file="includes/header.tpl"}

<div style="text-align:left;">
{for $x=0 to $rss_total -1}
<a href="{$rss_link[$x]}" target="_blank">{$rss_title[$x]}</a><br />
{$rss_description[$x]}<br />
{if $rss_author[$x]}
Author: {$rss_author[$x]}{/if} Published: {$rss_pubdate[$x]}<hr/>
{/for}
</div>






























{include file="includes/footer.tpl"}
