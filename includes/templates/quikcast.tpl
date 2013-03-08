{include file="includes/header.tpl" title="{$location|capitalize}, {$state|upper} Forecast"}





	
<script type="text/javascript" src="http://www.michiganwxsystem.com/includes/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="http://www.michiganwxsystem.com/includes/js/jquery-ui-1.8.16.custom.min.js"></script>


<script type="text/javascript">
{literal}
$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3" });
	
				// Tabs
				$('#tabs').tabs();
	

				// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});

				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});
				
				// Slider
				$('#slider').slider({
					range: true,
					values: [17, 67]
				});
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 20 
				});
				
				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
			});
{/literal}
</script>

<div style="margin-left: auto; margin-right: auto; width: 70%;">

{include file="includes/localdescrip.tpl"}

{include file="nav/arealink.tpl"}

{if {$alerttotal}}
{include file="includes/alertbox.tpl"}
{/if}



{include file="includes/metarhorz.tpl"}








<div id="quikwrap">
<table style="width:100%;">
<tr><td class="sechead">
{$for_date}
</td></tr></table>
<table style="border-spacing:2px; width:100%; text-align:center;">
<tr>

{for $x=0 to {$QCcount} - 1}
<td class="dayholders">
{$QCdayname[$x]|capitalize}<br/>
<img src="{$iconspath}/wxdir/wxdesk48/glossy/{$QCicon[$x]}" alt="" width="50" height="50" /><br/>
{$QCwx[$x]|capitalize}<br/>
{if $QCMaxtemp[$x]}
<span style="color:red;">H: {$QCMaxtemp[$x]}&deg;F</span>
{else}
<span style="color:blue;">L: {$QCMintemp[$x]}&deg;F</span>
{/if}
{if $QCpop[$x] >= 20}
<br/><span style="color:green;">PoP {$QCpop[$x]}%</span>
{/if}
</td>
{/for}
      
			</tr>
            </table>
            </div>

{include file="includes/astro.tpl"}
<table style="width:100%;">
<tr>
<td style="width:40%; text-align:left; vertical-align:top;">
{include file="includes/googleforecast.tpl"}
</td>
<td style="width:25%;">

{if {$keytotal}}
<table>
{for $x=0 to $keytotal - 1}
<tr><td style="text-align:left;" > 
<table style="height: 10px;width: 15px;border: 1px solid #000000; background-color: #{$keycolor[$x]};"> 
<tr><td style="text-align:left;"></td></tr></table> 
</td>
<td style="text-align:left;">
<span class="advtext">&nbsp;{$keyname[$x]|capitalize}</span></td>
</tr>
{/for}
</table>
{/if}

</td>
<td style="width:35%; text-align:right; vertical-align:top;">
<img src="http://mapper.michiganwxsystem.com/warnmap.php?state={$state|lower}&amp;size=320" alt="" />
</td>
</tr>
</table>


</div>


<!--  -->

















{include file="includes/footer.tpl"}