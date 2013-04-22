
%%hwi=header%%
%%let hwvchoice6color= 'navBarAct' let%%

%%hwi=nav_state%%

%%hwi=radar_header%%

<!-- BEGIN RADAR DATA //-->





<!-- Determine radar url //-->
%%let hwvradartype= ('%%hwvradartype%%') ? '%%hwvradartype%%' : 'base' let%%
%%let hwvradarserver= 'radar.weather.gov' let%%

%%LET hwvRadar= (preg_match('/[PKT](\w\w\w)/i', '%%uc_radar_icao%%', $m)) ? $m[1] : '%%uc_radar_icao%%'; LET%%

%%IF ('%%hwvradartype%%' == 'lrbase') THEN %%let hwvradarpath='N0Z' let%%  %%let hwvradarname='Long Range Base' let%% %%let hwvchoice7color= 'navBarAct' let%% IF%%

%%IF ('%%hwvradartype%%' == 'comp') THEN %%let hwvradarpath='NCR' let%%  %%let hwvradarname='Composite' let%% %%let hwvchoice8color= 'navBarAct' let%% IF%%

%%IF ('%%hwvradartype%%' == 'base') THEN %%let hwvradarpath='N0R' let%%  %%let hwvradarname='Base Reflectivity' let%%  %%let hwvchoice2color= 'navBarAct' let%% IF%%
%%IF ('%%hwvradartype%%' == 'relmot') THEN %%let hwvradarpath='N0S' let%%  %%let hwvradarname='Storm Relative Motion' let%% %%let hwvchoice3color= 'navBarAct' let%% IF%%
%%IF ('%%hwvradartype%%' == 'basevel') THEN %%let hwvradarpath='N0V' let%%  %%let hwvradarname='Base Velocity' let%% %%let hwvchoice4color= 'navBarAct' let%% IF%%

%%IF ('%%hwvradartype%%' == 'onehr') THEN %%let hwvradarpath='N1P' let%%  %%let hwvradarname='Rainfall 1 Hour Total' let%% %%let hwvchoice5color= 'navBarAct' let%% IF%%
%%IF ('%%hwvradartype%%' == 'stormtotal') THEN %%let hwvradarpath='NTP' let%%  %%let hwvradarname='Rainfall Storm Total' let%% %%let hwvchoice9color= 'navBarAct' let%% IF%%
<!-- end Determine radar url //-->

<!-- Determine the directory for the long range or short -->
%%LET hwvDir = ('%%uc_hwvradarpath%%' == 'N0Z') ? 'Long' : 'Short' LET%%
<!-- End Determine the directory for the long range or short -->







%%FORECAST forecast=nexradridgeloop radar_icao=%%radar_icao%% hwvradartype=%%hwvradartype%% config=%%config%% FORECAST%%
%%let hwvTotalImages= %%nexrad_total_loop_images%%-1 let%%


<script type="text/javascript">

/* This code is Copyright (c) 1996 Nick Heinle and Athenia Associates, 
 * all rights reserved. In order to receive the right to license this 
 * code for use on your site the original code must be copied from the
 * Web site webreference.com/javascript/. License is granted to user to 
 * reuse this code on their own Web site if and only if this entire copyright
 * notice is included. Code written by Nick Heinle of webreference.com.
 */

delay = 1000;
imgNumber = 0;
totalimgNumber = %%hwvTotalImages%%;
anim = new Array();
anim_legend = new Array();
anim_warn = new Array();
nws_url = 'http://%%hwvradarserver%%/RadarImg/%%hwvradarpath%%/%%hwvRadar%%/';
nws_legend_url = 'http://%%hwvradarserver%%/Legend/%%hwvradarpath%%/%%hwvRadar%%/';
nws_warn_url = 'http://%%hwvradarserver%%/Warnings/%%hwvDir%%/%%hwvRadar%%/';

dot_url = '%%hwvMainIMagesPath%%loopcontrol/';
var start_stop  = 0;

bluedot = new Image (5, 5);
reddot = new Image(5,5);
bluedot.src = dot_url + 'bluedot.gif';
reddot.src = dot_url + 'reddot.gif';


stopbutton = new Image(40,20);
startbutton = new Image(40,20);
stopbutton.src = dot_url + 'stop.gif';
startbutton.src = dot_url + 'start.gif';


for (i = 0; i <= totalimgNumber; i++) {
   anim[i] = new Image (600, 550);
   anim_legend[i] = new Image (600, 550);
   anim_warn[i] = new Image (600, 550);
}




%%REPEAT 0 %%hwvTotalImages%%  anim_warn[%%hwcounter%%].src = nws_warn_url +'%%nexrad_loop_images%%hwcounter%%%%_Warnings.gif'; %%lf%%  REPEAT%%

%%REPEAT 0 %%hwvTotalImages%%    anim_legend[%%hwcounter%%].src = nws_legend_url +'%%nexrad_loop_images%%hwcounter%%%%_%%hwvradarpath%%_Legend.gif'; %%lf%%  REPEAT%%

%%REPEAT 0 %%hwvTotalImages%%   anim[%%hwcounter%%].src = nws_url +'%%nexrad_loop_images%%hwcounter%%%%_%%hwvradarpath%%.gif'; %%lf%%  REPEAT%%




function Switch() {
   document.radarloop.src = anim[imgNumber].src;
   %%IF ('%%CFG:Radar Options:legend%%') THEN document.legendloop.src = anim_legend[imgNumber].src; IF%%
   %%IF ('%%CFG:Radar Options:warnings%%' && '%%hwvradarpath%%' eq 'N0R') THEN document.warnloop.src = anim_warn[imgNumber].src; IF%%



    var oldimgNum = imgNumber -1;
    if (oldimgNum < 0) { oldimgNum = totalimgNumber; }

    eval('document.dot' + oldimgNum + '.src = bluedot.src;');
    eval('document.dot' + imgNumber + '.src = reddot.src;');

   imgNumber++;
   if(imgNumber > totalimgNumber) imgNumber = 0;
}

function SwitchTo(num) {
   if (num < 0) num=0;
   if (num > totalimgNumber) num=totalimgNumber;

   imgNumber=num;
   document.radarloop.src = anim[imgNumber].src;
   %%IF ('%%CFG:Radar Options:legend%%') THEN document.legendloop.src = anim_legend[imgNumber].src; IF%%
   %%IF ('%%CFG:Radar Options:warnings%%' && '%%hwvradarpath%%' eq 'N0R') THEN document.warnloop.src = anim_warn[imgNumber].src; IF%%
}


var myTimer;
function animate() {
   if (start_stop == 1) {
      Switch();
      myTimer=setTimeout("animate()", delay);
   }
}

function slower(amount) {
   if (start_stop == 1) {
      delay+=amount;
      if(delay > 4000) delay = 4000;
   }
}

function faster(amount) {
   if (start_stop == 1) {
      delay-=amount;
      if(delay < 500) delay = 500;
   }
}

function startstop() {
   if (start_stop == 0) {
      start_stop=1;
      animate();

   }
   else {
      start_stop=0;
      clearTimeout("myTimer");

   }

   adjust_start_stop_button();

}

function gotoImage (num) {
   if (num < 0) { num = 0; }
   if (num > totalimgNumber) { num = totalimgNumber; }

    var oldimgNum = imgNumber -1;
    if (oldimgNum < 0) { oldimgNum = totalimgNumber ; }
    eval('document.dot' + oldimgNum + '.src = bluedot.src;');

   imgNumber = num;
   document.radarloop.src = anim[imgNumber].src;
   %%IF ('%%CFG:Radar Options:legend%%') THEN document.legendloop.src = anim_legend[imgNumber].src; IF%%
   %%IF ('%%CFG:Radar Options:warnings%%' && '%%hwvradarpath%%' eq 'N0R') THEN document.warnloop.src = anim_warn[imgNumber].src; IF%%

   eval('document.dot' + imgNumber + '.src = reddot.src;');


}



function adjust_start_stop_button() {
   if (start_stop == 0) {
      document.loopstartstop.src = startbutton.src;
   }
   else {
      document.loopstartstop.src = stopbutton.src;
   }
}

</script>









<table border="0" width="100%">
   <tr>
      <td valign="top" class="headerTD">
         <table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
            <td valign="top" align="left"><span class="headerText">Local %%hwvradarname%% Radar Loop:</span> <a href="http://weather.noaa.gov/radar/mosaic/DS.p19r0/ar.us.conus.shtml" class="zoneDay">(via NWS)</a></td>
            <td valign="top" align="right"><a href="%%scripturl%%?config=%%url_config%%&amp;forecast=pass&amp;pass=local_radar&amp;dpp=1&amp;radar_icao=%%radar_icao%%&amp;hwvradartype=%%hwvradartype%%&amp;place=%%url_place%%&amp;state=%%url_state%%&amp;zipcode=%%url_zipcode%%&amp;country=%%url_country%%&amp;county=%%county%%&amp;zone=%%zone%%" class="zoneDay">Latest</a>&nbsp;</td>
         </tr></table>
      </td>
   </tr>


   <tr>
      <td align="center" width="100%">
      %%hwi=nav_radar_loop%%
      </td>
   </tr>



%%IF '%%radar_icao%%' THEN __
            <tr><td align="right"><table border="0" align="left" width="100%" cellspacing="0" cellpadding="0"><tr><td>  __
         &nbsp;&nbsp;<img  src="%%hwvMainIMagesPath%%loopcontrol/stop.gif" name="loopstartstop" border="0" width="40" height="20" alt="" onClick="startstop();" />&nbsp; __
         <img  src="%%hwvMainIMagesPath%%loopcontrol/slower.gif" name="loopslower" border="0" width="40" height="20" onClick="slower(500);" alt="" />&nbsp; __
         <img src="%%hwvMainIMagesPath%%loopcontrol/faster.gif" name="loopfaster" border="0" width="40" height="20" onClick="faster(500);" alt="" />&nbsp;&nbsp;&nbsp; __
            </td><td width="65%"><table  border="0" align="right" cellspacing="0" cellpadding="0"><tr> __
               <td align="left"><font style="color:blue; font-size:11px;">Click Block For Image -></font>&nbsp;</td>__
                  %%_REPEAT 0 %%hwvTotalImages%%  <td align="center" width=15><a href="javascript:gotoImage(%%hwcounter%%);"><img name="dot%%hwcounter%%" src="%%hwvMainIMagesPath%%loopcontrol/bluedot.gif" style="width:5px;height:5px;border:0px;" alt="" /></a>&nbsp;&nbsp;</td> __
                      %%lf%%  _REPEAT%% __
               </tr></table></td></tr></table></td></tr> __
  IF%%



   <tr>
      <td valign="top" align="center">
<div id="radartable">
<table align="center">
 <tr><td align="center" valign="top">

<div class="radarmap">
%%IF ('%%CFG:Radar Options:topo%%') THEN <div class="image2"><img style="z-index:0" src="http://%%hwvradarserver%%/Overlays/Topo/%%hwvDir%%/%%hwvRadar%%_Topo_%%hwvDir%%.jpg" alt="" /></div> IF%%
%%IF ('%%CFG:Radar Options:latlon%%') THEN <div class="image10"><img style="z-index:10" src="http://%%hwvradarserver%%/Overlays/LatLon/%%hwvDir%%/%%hwvRadar%%_LatLon_%%hwvDir%%.gif" alt="" /></div> IF%%
<div class="image3"><img style="z-index:1" name="radarloop" id="radarloop" src="http://%%hwvradarserver%%/RadarImg/%%hwvradarpath%%/%%hwvRadar%%_%%hwvradarpath%%_0.gif" alt=""  height="550" width="600" /></div>
%%IF ('%%CFG:Radar Options:county%%') THEN <div class="image4"><img style="z-index:2" src="http://%%hwvradarserver%%/Overlays/County/%%hwvDir%%/%%hwvRadar%%_County_%%hwvDir%%.gif" alt="" /></div> IF%%
%%IF ('%%CFG:Radar Options:highways%%') THEN <div class="image5"><img style="z-index:3" src="http://%%hwvradarserver%%/Overlays/Highways/%%hwvDir%%/%%hwvRadar%%_Highways_%%hwvDir%%.gif" alt="" /></div> IF%%
%%IF ('%%CFG:Radar Options:rivers%%') THEN <div class="image7"><img style="z-index:4" src="http://%%hwvradarserver%%/Overlays/Rivers/%%hwvDir%%/%%hwvRadar%%_Rivers_%%hwvDir%%.gif" alt="" /></div> IF%%
%%IF ('%%CFG:Radar Options:city%%') THEN <div class="image6"><img style="z-index:5" src="http://%%hwvradarserver%%/Overlays/Cities/%%hwvDir%%/%%hwvRadar%%_City_%%hwvDir%%.gif" alt="" /></div> IF%%
%%IF ('%%CFG:Radar Options:legend%%') THEN <div class="image8"><img style="z-index:6" name="legendloop" id="legendloop" src="http://%%hwvradarserver%%/Legend/%%hwvradarpath%%/%%hwvRadar%%_%%hwvradarpath%%_Legend_0.gif" alt="" /></div> IF%%
%%IF ('%%CFG:Radar Options:warnings%%' && '%%hwvradarpath%%' eq 'N0R') THEN <div class="image9"><img style="z-index:7"  name="warnloop" id="warnloop" src="http://%%hwvradarserver%%/Warnings/%%hwvDir%%/%%hwvRadar%%_Warnings_0.gif" alt="" /></div> IF%%
</div>
     </td> </tr>
</table>
</div>
</td> </tr>


</table>

 <script type="text/javascript"> startstop();</script>

<!-- END ridge loop DATA //-->


%%hwi=footer%%
