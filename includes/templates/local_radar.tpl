{include file="includes/header.tpl" title="{$radar_icao|capitalize} Local Radar For {$locname|capitalize}, {$state}"}


<div style="margin-left: auto; margin-right: auto; width: 100%;">

{include file="includes/localdescrip.tpl"}

{include file="nav/arealink.tpl"}


{$radarurl = "http://radar.weather.gov/ridge/"}

<script type="text/javascript">
 var theProduct;
 <!--
 // determine browser data object model (DOM) and build object string based on DOM
 var onoroff = "OFF";
 var isNav,isIE,isDOM;
 var coll = "";
 var styleObj = "";
 //test for DHTML capable browser
 if (document.getElementById || document.all || document.layers) {
 	// test for NN/Gecko Layer API browser
 	if(document.layers) { 
 	  isNav=true;				//set object string variables - use defaults
 	} else {
 	  if(document.all) {				//test for IE DOM browser, set object string variables
 		isIE=true;
 		coll="all.";
 		styleObj=".style";
 	  }	else {							// assume W3C DOM browser, set object string variables
 		isDOM=true;
 		coll="getElementById('";
 		styleObj="').style";
 		}
 	}
 }
 function show(imgobj) {	imgobj.visibility = "visible";	}
 function hide(imgobj) {	imgobj.visibility = "hidden";	}
 function changeVisibility(Obj,num) {
   var imgstr = "document." + coll + "image" + num + styleObj;
   var imgobj = eval(imgstr);
   if ((Obj.checked == "1") || (Obj.checked == "true")) show(imgobj); else hide(imgobj);
 }
 function setVisibility() {
   var i;
   var objs= new Array("checkbox0","checkbox1","checkbox2","checkbox3","checkbox4","checkbox5","checkbox6","checkbox7");
   var theObj
 var values = new Array(
'ON','ON','ON','OFF','ON','ON','ON','ON');
  for(i=0; i<objs.length; i++) {
	if (values[i] == "ON") {
	  theObj = eval("document.checkform1." + objs[i]);
      theObj.checked = true;
    } else {
	  theObj = eval("document.checkform1." + objs[i]);
	  theObj.checked = false;
	}
	changeVisibility(theObj,i);
}
  theProduct = "{$radtype}";
  var dt = "datetime2";
    getnewimg(theProduct,'{$radar}',0,dt);
  }
  function go(loop) { window.location.href = loop; }
  function newpage(radarid,product,loop) {
  	var cbox;
  	var isloop = (loop==1 ? "yes" : "no");
  	var thelink = "wxweb"  + ".php";
    var arg1 = "?run=nws_radar_loop"
  	var arg1 = "&radar_icao=" + radarid;
  	var arg4 = "&loop=" + isloop;
  	var arg2 = "&product=" + product;
  	var arg3 = "&overlay=";
  	for (i=0; i<8; i++) {
  		cbox = eval("document.checkform1.checkbox"+i);
  		arg3+= (cbox.checked ? "1" : "0");
  	}
  	window.location = thelink + arg1 + arg2 + arg3 + arg4; 
  }
  -->
</script>








<div id="bkgrnd">
<div id="basemap"><img src="{$radarurl}graphics/black.gif" alt=""/></div>
<div id="image0"><img style="z-index:0" src="{$radarurl}Overlays/Topo/Short/{$radar}_Topo_Short.jpg" alt=""/></div>
<div id="image1"><img style="z-index:1" src="{$radarurl}/RadarImg/{$radtype}/{$radar}_{$radtype}_0.gif" alt=""/></div>
<div id="image2"><img style="z-index:2" src="{$radarurl}Overlays/County/Short/{$radar}_County_Short.gif" alt=""/></div>
<div id="image3"><img style="z-index:3" src="{$radarurl}Overlays/Rivers/Short/{$radar}_Rivers_Short.gif" alt=""/></div>
<div id="image4"><img style="z-index:4" src="{$radarurl}Overlays/Highways/Short/{$radar}_Highways_Short.gif" alt=""/></div>
<div id="image5"><img style="z-index:5" src="{$radarurl}Overlays/Cities/Short/{$radar}_City_Short.gif" alt=""/></div>
<div id="image6"><img style="z-index:6" src="{$radarurl}Warnings/Short/{$radar}_Warnings_0.gif" alt=""/></div>
<div id="image7"><img style="z-index:7" src="{$radarurl}/Legend/{$radtype}/{$radar}_{$radtype}_Legend_0.gif" alt=""/></div>
<div id="toggles">
<form action="#" name="checkform1">
<input type="checkbox" onclick="changeVisibility(this,0)" id="checkbox0" name="checkbox0" checked="checked" /><label for="checkbox0">Topo</label>&nbsp; 
<input type="checkbox" onclick="changeVisibility(this,1)" id="checkbox1" name="checkbox1" checked="checked" /><label for="checkbox1">Radar</label>&nbsp;
<input type="checkbox" onclick="changeVisibility(this,2)" id="checkbox2" name="checkbox2" checked="checked" /><label for="checkbox2">Counties</label>&nbsp;
<input type="checkbox" onclick="changeVisibility(this,3)" id="checkbox3" name="checkbox3" checked="checked" /><label for="checkbox3">Rivers</label>&nbsp;
<input type="checkbox" onclick="changeVisibility(this,4)" id="checkbox4" name="checkbox4" checked="checked" /><label for="checkbox4">Highways</label>&nbsp;
<input type="checkbox" onclick="changeVisibility(this,5)" id="checkbox5" name="checkbox5" checked="checked" /><label for="checkbox5">Cities</label>&nbsp;
<input type="checkbox" onclick="changeVisibility(this,6)" id="checkbox6" name="checkbox6" checked="checked" /><label for="checkbox6">Warnings</label>&nbsp;
<input type="checkbox" onclick="changeVisibility(this,7)" id="checkbox7" name="checkbox7" checked="checked" /><label for="checkbox7">Legend</label>
</form>
</div>
</div>
 


</div>














{include file="includes/footer.tpl"}

