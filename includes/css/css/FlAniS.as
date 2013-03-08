/* This is the FlAniS -- Flash version of the AnimationS applet.

This code is Copyright(C) 2008-2009 by Tom Whittaker. You may use
this for any lawful purpose, and we are not responsible for what you
do with it. It was developed as an outcome of the  VISIT Project and
uses many classes from the VISITview collaborative training / distance
learning tool. 

*/

// this is compiled with the mxmlc using the flanis.mxml template...
//

package {
  import mx.controls.Button;
  import mx.controls.CheckBox;
  import mx.controls.ComboBox;
  import mx.controls.Label;
  import mx.controls.HSlider;
  import mx.controls.RadioButton;
  import mx.controls.RadioButtonGroup;
  import mx.controls.ProgressBar;
  import mx.controls.Alert;
  import mx.controls.TextArea;
  import mx.core.*;
  import mx.containers.HBox;
  import mx.containers.VBox;
  import mx.containers.Canvas;
  import mx.containers.Panel;
  import mx.containers.TitleWindow;

  import mx.core.UIComponent;
  import mx.events.SliderEvent;
  import mx.events.ListEvent;
  import mx.events.CloseEvent;
  import mx.utils.StringUtil;
  import flash.display.Loader;
  import flash.display.Bitmap;
  import flash.display.Sprite;
  import flash.display.BitmapData;
  import flash.display.Graphics;
  import flash.display.SimpleButton;
  import flash.events.Event;
  import flash.events.MouseEvent;
  import flash.events.KeyboardEvent;
  import flash.events.IOErrorEvent;
  import flash.events.SecurityErrorEvent;
  import flash.events.HTTPStatusEvent;
  import flash.external.ExternalInterface;
  import flash.net.URLRequest;
  import flash.geom.Point;
  import flash.geom.Rectangle;
  import flash.geom.Matrix;
  import flash.geom.ColorTransform;
  import flash.printing.PrintJob;
  import flash.printing.PrintJobOptions;

  import flash.utils.Timer;
  import flash.events.TimerEvent;
  import flash.system.System;
  import flash.system.Capabilities;

  import flash.net.*;
  import flash.text.*;

  import mx.managers.PopUpManager;
  


  public class FlAniS {

    private var version:String;

    private var isDebug:Boolean;
    private var debugTextArea:TextArea;
    private var debugText:String;

    private var background:int;
    private var foreground:int;
    private var usingIP:Boolean;
    private var onlyShowFirstImage:Boolean;
    private var quietReload:Boolean;
    private var quietLoadem:Boolean;
    private var noControls:Boolean;
    private var useProgressBar:Boolean;
    private var isLoading:Boolean;
    private var countFrames:int;
    private var doExcludeCaching:Boolean;
    private var excludeCaching:String;
    private var useCaching:Boolean;
    private var useAntiCaching:Boolean;
    private var antiCacheIndex:int;
    private var baseStatic:Boolean;
    private var imageBase:String;
    private var s:Array;
    private var its:int;

    private var showButt:Button;
    private var printButt:Button;
    private var zoom:Button;
    private var zoomLabelTrue:String;
    private var zoomLabelFalse:String;
    private var keepZoom:Boolean;
    private var activeZoom:Boolean;
    private var zoomScale:Number;
    private var zoomXFactor:Number;
    private var zoomYFactor:Number;
    private var zoomXBase:Number;
    private var zoomYBase:Number;
    private var isZooming:Boolean;
    private var enableZooming:Boolean;
    private var frameLabelWidth:int;
    private var frameLabelField:Label;
    private var hasFrameLabel:Boolean;
    private var frameLabels:Array;

    private var doLayoutControls:Boolean;
    private var useBottomControls:Boolean;
    private var looprock:Button;
    private var looprockLabelTrue:String;
    private var looprockLabelFalse:String;
    private var isLoopRock:Boolean;
    private var loopDirection:int;
    private var isRocking:Boolean;
    private var autoOnOff:Button;
    private var autoOnOffLabelTrue:String;
    private var autoOnOffLabelFalse:String;
    private var refreshRate:int;
    private var refreshTimer:Timer;
    private var autoState:Boolean;
    private var refresh:Button;
    private var isAutoRefresh:Boolean;
    private var showAllOnOff:Boolean;
    private var onOffWidth:int;
    private var onOffHeight:int;
    private var onOffSpacing:int;
    private var onOffState:Array;
    private var onOffBM:Bitmap;
    private var onOffRect:Rectangle;
    private var onOffBMD:BitmapData;
    private var onOffUI:UIComponent;
    private var onOffSprite:Sprite;
    private var onOffBackground:uint;
    private var isOnOff:Boolean;
    private var incFrame:int;

    private var stepBack:Button;
    private var stepForward:Button;
    private var isStepping:Boolean;
    private var stepFirst:Button;
    private var stepLast:Button;

    private var setFrameScrollbar:HSlider;
    private var setFrameText:String;
    private var isSetFrameScrollbar:Boolean;

    private var setFaderScrollbar:HSlider;
    private var faderToggle:Button;
    private var setFaderText:String;
    private var isFader:Boolean;
    private var faderFrame:int;
    private var faderImages:Array;
    private var isShowingFrames:Boolean;

    private var faderLabel:String;
    private var startFrame:int;
    private var basename:String;
    private var baseNumber:int;
    private var numFrames:int;
    private var currentFrame:int;
    private var deadFrames:int;
    private var firstFrame:int;
    private var lastFrame:int;

    private var enh:Array;
    private var enhNames:Array;
    private var enhanceChoice:ComboBox;
    private var madeEnhBitmaps:Boolean;
    private var enhBitmaps:Array;
    private var enhOverlay:int;

    private var location:Array;
    private var lat:Number;
    private var lon:Number;
    private var isLoc:Boolean;
    private var doingLoc:Boolean;
    private var locLabel:Label;
    private var locLabelDigits:int;
    private var locLabelFirst:String;
    private var locLabelSecond:String;
    private var xMouse:int;
    private var yMouse:int;
    private var locOffset:int;
    private var locButt:Button;
    private var locLabelOff:String;
    private var locLabelOn:String;
    private var locLabels:Array;

    private var vb:VBox;
    private var vbc:VBox;
    private var hb:HBox;
    private var controlBox:HBox;
    private var overlayControlBox:HBox;
    private var overlayControlContainer:VBox;
    private var speed:HSlider;
    private var dwell:int;
    private var minSpeed:int;
    private var maxSpeed:int;
    private var mySpeed:int;
    private var addDwell:int;
    private var pauseOnLast:int;
    private var pausePercent:int;
    private var startstop:Button;
    private var startstopLabelTrue:String;
    private var startstopLabelFalse:String;
    private var bm:Bitmap;
    private var grandma:Application;
    private var mom:Canvas;
    private var sp:Sprite;
    private var timer:Timer;
    private var isLooping:Boolean;
    private var wasLooping:Boolean;
    private var isOverlay:Boolean;
    private var overlay:Array;
    private var overlayLinks:Array;
    private var overlayOrder:Array;
    private var overlayHidden:Array;
    private var overlayStatic:Array;
    private var overlayZoom:Array;
    private var overlayTransparentAmount:Array;
    private var ct:ColorTransform;
    private var transparency:int;
    private var numOverlayLabels:int;
    private var doneOverlayMask:Array;
    private var overlayMask:Array;

    private var probeValues:Array;
    private var probe:CheckBox;
    private var isProbe:Boolean;
    private var probeEnabled:Boolean;

    private var fnList:Array;
    private var biList:Array;
    private var olList:Array;
    private var hiresFnList:Array;
    private var fnDwell:Array;
    private var useDwell:Boolean;
    private var minDwell:int;
    private var canResetDwell:Boolean;

    private var hsButton:Array;
    private var hsUI:UIComponent;
    private var hsType:Array;
    private var hsValue:Array;
    private var hsPoint:Array;
    private var hsPan:Array;
    private var hsBitmaps:Array;
    private var hsColor:int;
    private var hsImageNames:Array;
    private var hsLoaders:Array;
    private var hsLoaderInfo:Array;
    private var hsCan:Canvas;

    private var doingHotspots:Boolean;
    private var loadingHotspot:Boolean;

    private var backhsButton:Array;
    private var backhsType:Array;
    private var backhsValue:Array;
    private var doingBackHotspots:Boolean;
    private var loadingBackHotspot:Boolean;

    private var drawingPaper:UIComponent;
    private var probePaper:UIComponent;

    private var pbar:ProgressBar;
    private var totalFrames:int;
    private var initialLoad:Boolean;
    private var imgList:Array;
    private var hiresImgList:Array;
    private var singleImage:Array;
    private var imgSmoothList:Array;
    private var imgUIBack:UIComponent;
    private var imgLoaderList:Array;
    private var hiresImgLoaderList:Array;
    private var imgLoaderInfoList:Array;
    private var hiresImgLoaderInfoList:Array;
    private var imgZoomableList:Array;
    private var preserve:Array;
    private var preRect:Rectangle;
    private var prePoint:Point;
    private var xImage:int;
    private var yImage:int;
    private var xLineEnd:int;
    private var yLineEnd:int;
    private var xScreen:int;
    private var yScreen:int;
    private var xMove:int;
    private var yMove:int;
    private var bmBack:Bitmap;
    private var bmBackground:BitmapData;
    private var bmBackCreated:Boolean
    private var bmBackLoaded:Array
    private var bmWidth:int;
    private var bmHeight:int;
    private var userWindowSize:Boolean;
    private var imgWidth:int;
    private var imgHeight:int;

    private var biComp:UIComponent;
    private var biSprite:Sprite;
    private var usingBI:Boolean;

    private var activeKey:int;
    private var backSprite:Sprite;

    private var upperLeft:Point;
    private var lowerRight:Point;
    private var imgRect:Rectangle;
    private var bmRect:Rectangle;
    private var isDragging:Boolean;
    private var isDrawingLine:Boolean;

    private var paramNames:Array;
    private var paramValues:Array;
    private var pLabels:Array

    private var verLab:Label;

    // Application point of entry

    public static function main(defConfig:int):void {
      var ec:FlAniS = new FlAniS();
      ec.letterroll(defConfig);
    }


/** letterroll()
*
* Why did we call it this?
*
*/
    public function letterroll(defConfig:int):void {

      grandma = Application(Application.application);
      grandma.layout="absolute";
      grandma.frameRate = 1;

      //grandma.addEventListener(KeyboardEvent.KEY_DOWN, kclick);
      mom = new Canvas();
      mom.height = grandma.height;
      mom.width = grandma.width;
      mom.setStyle("backgroundColor", grandma.getStyle("backgroundColor"));
      mom.setFocus();
      mom.addEventListener(KeyboardEvent.KEY_DOWN, kclick);
      mom.addEventListener(KeyboardEvent.KEY_UP, kclick);
      grandma.addChild(mom);

      initialLoad = true;
      canResetDwell = false;
      currentFrame = 0;
      bmBackCreated = false;
      zoomXFactor = 1.0;
      zoomYFactor = 1.0;
      isZooming = false;
      enableZooming = false;
      isDragging = false;
      isDrawingLine = false;
      isOverlay = false;
      incFrame = 1;
      isFader = false;
      preRect = new Rectangle();
      prePoint = new Point();
      madeEnhBitmaps = false;
      locOffset = 20;

      upperLeft = new Point(0,0);
      lowerRight = new Point(mom.width,mom.height);  // until image defined

      ct = new ColorTransform(1.0,1.0,1.0,1.0);
      version = "FlAniS version 1.4";

      trace(version);
      debugText = version+"\n";

      // all set up must be serialized, since there is no
      // other way to do it...hmmmm....

      paramNames = new Array();
      paramValues = new Array();

      // see if name supplied in Flashvars
      var cfname:String = grandma.parameters.configFilename;
      if (defConfig == 1) cfname = "flanis.cfg";

      if (cfname == null) {
        debugText = debugText + "\n NO config filename!";
        configParams();

      } else {

        trace ("config filename = "+cfname);
        debugText = debugText +"\nConfig filename = "+cfname;
        if (cfname.indexOf("?") > 0) {
          var bar:RegExp = /\|/g;
          cfname = cfname.replace(bar,"&");
          debugText = debugText + "\nPHP config = "+cfname;
        }

        isLoading = false;

        try {
          var configLoader:URLLoader = new URLLoader();
          configLoader.dataFormat = URLLoaderDataFormat.TEXT;
          configLoader.addEventListener(Event.COMPLETE, configLoaded);
          configLoader.addEventListener(IOErrorEvent.IO_ERROR, errorLoadingConfigFile);

          var request:URLRequest = new URLRequest(cfname);

          // turn off caching ?
          request.requestHeaders.push(new URLRequestHeader("Cache-Control","no-store,max-age=0,no-cache,must-revalidate"));
          request.requestHeaders.push(new URLRequestHeader("Expires","Mon, 26 Jul 1997 05:00:00 GMT"));
          request.requestHeaders.push(new URLRequestHeader("Pragma","no-cache"));

          configLoader.load(request);

        } catch (ibce:Error) {
          Alert.show("Unable to load config file: "+cfname+" Error="+ibce);
        }
      }
    }





/** configLoaded(Event)
*
* after getting the "configFile", parse it and create lists for
* getParameter() calls...
*
*/
 
    private function configLoaded(event:Event) : void {

      trace("into configLoaded.........");
      var cfl:URLLoader = URLLoader(event.target);

      var lines:Array = cfl.data.split("\n");
      var eqinx:int = 0;

      // first, parse the basic requests
      for (var i:int=0; i<lines.length; i++) {
        if (lines[i].length < 5) continue;
        eqinx = lines[i].indexOf("=");
        if (eqinx < 1) continue;

        trace("text:  "+lines[i]);

        paramNames.push(StringUtil.trim(
               lines[i].substring(0,eqinx)).toLowerCase());

        var args:Array = lines[i].substring(eqinx+1).split(",");

        // scan the array and trim the values
        for (var k:int=0; k<args.length; k++) {
          args[k] = StringUtil.trim(args[k]);
        }

        trace("name="+paramNames[paramNames.length-1]+"  args = "+args);
        debugText = debugText+ "\n param name="+paramNames[paramNames.length-1]+"  args = "+args;

        paramValues.push(args);
      }

      configParams();
    }
    


/** configParams()
*
* now get the parameters off the flashVars list, if any...
*
*/
    private function configParams() : void {

      // now add in all the flashVars parameters
      debug("in configParams");
      var fvars:Object = grandma.parameters;
      var args:Array;
      if (fvars != null) {
        var key:String;
        var keyval:String;
        for (key in fvars) {
          trace("fvars = "+key+"  val="+fvars[key]);
          debugText = debugText+"\nfvars = "+key+"  val="+fvars[key];
          paramNames.push(StringUtil.trim(key));

          args = fvars[key].split(",");
          for (var k:int=0; k<args.length; k++) {
            args[k] = StringUtil.trim(args[k]);
          }
          paramValues.push(args);
        }
      }


      // done with setup for getParameter()....

      isDebug = false;
      s = getParameter("debug");
      if (s !=null && s[0].toLowerCase() == "true") {
        isDebug = true;
        debugTextArea = new TextArea();
        debugTextArea.editable = false;
        debugTextArea.wordWrap = true;
        debugTextArea.text = debugText;
        debugTextArea.width=430;
        debugTextArea.height=200;
        var debugButt:Button = new Button();
        debugButt.label = "Close";
        var debugClear:Button = new Button();
        debugClear.label = "Clear";
        var debugPanel:Panel = new Panel();
        debugPanel.title = "FlAniS Debug Panel";
        debugPanel.width = 450;
        debugPanel.height = 280;
        debugPanel.addChild(debugTextArea)
        var debughb:HBox = new HBox();
        debughb.addChild(debugButt);
        debughb.addChild(debugClear);
        debugPanel.addChild(debughb);
        PopUpManager.addPopUp(debugPanel, grandma, false);
        PopUpManager.centerPopUp(debugPanel);

        debugButt.addEventListener(MouseEvent.CLICK,
          function(e:Event):void {
            isDebug = false;
            PopUpManager.removePopUp(debugPanel);
            mom.setFocus();
          }
        );
        debugClear.addEventListener(MouseEvent.CLICK,
          function(e:Event):void {
            debugTextArea.text = version+"\n";
          }
        );

      }


      s = getParameter("height");
      if (s != null) {
        mom.height = parseInt(s[0]);
      }

      s = getParameter("width");
      if (s != null) {
        mom.width = parseInt(s[0]);
      }

      background = mom.getStyle("backgroundColor");
      s = getParameter("backcolor");
      if (s != null) {
        background = parseHex(s[0]);
        mom.setStyle("backgroundColor", background);
      }

      foreground = mom.getStyle("color");
      s = getParameter("forecolor");
      if (s != null) {
        foreground = parseHex(s[0]);
        mom.setStyle("color", foreground);
      }

      s = getParameter("hotspot_color");
      hsColor = 0;
      if (s != null) hsColor = parseHex(s[0]);

      s = getParameter("font_size");
      if (s != null) {
        mom.setStyle("fontSize",parseInt(s[0]));
      }

      usingIP = false;
      s = getParameter("use_IP");
      if (s != null && s[0].toLowerCase() == "true") usingIP = true;

      onlyShowFirstImage = false;
      s = getParameter("only_show_first_image");
      if (s != null && s[0].toLowerCase() == "true") onlyShowFirstImage = true;

      quietReload = false;
      quietLoadem = false;
      s = getParameter("quiet_reload");
      if (s != null && s[0].toLowerCase() == "true") quietReload = true;
      if (s != null && s[0].toLowerCase() == "very") {
        quietReload = true;
        quietLoadem = true;
      }

      noControls = false;
      s = getParameter("no_controls");
      if (s != null && s[0].toLowerCase() == "true") noControls = true;

      useProgressBar = true;
      s = getParameter("use_progress_bar");
      if (s != null && s[0].toLowerCase() == "false") useProgressBar = false;

      doExcludeCaching = false;
      s = getParameter("exclude_caching");
      if (s != null) {
        doExcludeCaching = true;
        excludeCaching = s[0];
      }

      useCaching = false;
      s = getParameter("use_caching");
      if (s != null && s[0].toLowerCase() == "true") useCaching = true;

      useAntiCaching = true;
      s = getParameter("use_anti_caching");
      if (s != null) {
        if (s[0].toLowerCase() == "true") useAntiCaching = true;
        if (s[0].toLowerCase() == "false") useAntiCaching = false;
      }

      baseStatic = false;
      s = getParameter("base_static");
      if (s != null && s[0].toLowerCase() == "true") baseStatic = true;

      imageBase = null;
      s = getParameter("image_base");
      if (s != null) imageBase = s[0];

      fnList = new Array();
      s = getParameter("filenames");
      if (s != null) {
        fnList[0] = s;
        debug("got filenames="+fnList[0]);
        numFrames = fnList[0].length;
        lastFrame = numFrames - 1;
        firstFrame = 0;
        currentFrame = 0;
      }

      s = getParameter("hires_filenames");
      if (s != null) {
        hiresFnList = s;
      }


      keepZoom = false;
      s = getParameter("keep_zoom");
      if (s != null && s[0].toLowerCase() == "true") keepZoom = true;

      activeZoom = false;
      s = getParameter("active_zoom");
      if (s != null && s[0].toLowerCase() == "true") activeZoom = true;
      enableZooming = activeZoom;

      zoomScale = 1.0;
      s = getParameter("zoom_scale");
      if (s != null) zoomScale = parseFloat(s[0]);

      refreshRate = 1;
      isAutoRefresh = false;
      s = getParameter("auto_refresh");
      if (s != null) {
        refreshRate = parseInt(s[0]);
        refreshTimer = new Timer(refreshRate*60*1000);
        refreshTimer.addEventListener(TimerEvent.TIMER, refreshImages, false, 0, true);
        isAutoRefresh = true;
      }

      startFrame = 0;
      s = getParameter("start_frame");
      if (s != null) startFrame = parseInt(s[0]);

      fnDwell = new Array();
      useDwell = false;
      s = getParameter("dwell_rates");
      if (s != null) {
        for (var i:int = 0; i<s.length; i++) {
          fnDwell.push( parseInt(s[i]));
        }
        useDwell = true;
      }

      frameLabelWidth = 100;
      s = getParameter("frame_label_width");
      if (s != null) frameLabelWidth = parseInt(s[0]);

      isLooping = true;
      s = getParameter("start_looping");
      if (s != null) {
        if (startsWith(s[0],"f") || startsWith(s[0],"F") ) {
          isLooping = false;
        }
      }
      wasLooping = isLooping;

      s = getParameter("basename");
      if (s == null) s = getParameter("basenames");
      if (s != null) {
        basename = s[0];
        baseNumber = 0;
        s = getParameter("base_starting_number");
        if (s!= null) baseNumber = parseInt(s[0]);
        s = getParameter("num_frames");
        if (s == null) s = getParameter("num_images");
        if (s == null) {
          debug("******** Problem with config -- no num_frames parameter!");
        }
        numFrames = parseInt(s[0]);
        lastFrame = numFrames - 1;
        fnList[0] = getNamesUsingBaseName(basename, numFrames);
      }


      s = getParameter("overlay_filenames");
      if (s !=null) {
        debug("got overlays = "+s);
        for (var m:int = 1; m<s.length+1; m++) {
          debug("olList m = "+m);
          fnList[m] = s[m-1].split("&");
          debug("  number="+fnList[m].length);
          for (var n:int=0; n<fnList[m].length; n++) {
            debug("   added:"+fnList[m][n]);
            fnList[m][n] = StringUtil.trim(fnList[m][n]);
          }

        }
      }


      enhOverlay = 0;
      s = getParameter("enhance_overlay");
      if (s != null) enhOverlay = parseInt(s[0]) - 1;
      if (enhOverlay < 0) enhOverlay = 0;


      isProbe = false;
      probeEnabled = false;
      s = getParameter("probe_values");
      //probe_values=0x00ff00=15C, 0x00ff01=16C & 0xff0000=2du, 0xff0001=2du

      if (s != null) {
        probeEnabled = true;
        probeValues = new Array(s.length);
        for (var p:int=0; p<s.length; p++) {
          if (s[p] == null || s[p].length < 2) {
            probeValues[p] = null;
          } else {
            var pa:Array = s[p].split("&");
            probeValues[p] = new Array(pa.length);
            for (var pan:int=0; pan<pa.length; pan++){
              var pab:Array = pa[pan].split("=");
              probeValues[p][pa] = new Array(2);
              probeValues[p][pa][0] = parseInt(pab[0]);
              probeValues[p][pa][1] = pab[1];
              debug("....probeValues for p, pan="+p+" "+pan+" ==> "+ probeValues[p][pa][0]+" : "+probeValues[p][pa][1]);
            }
          }
        }
      }



      // minimum dwell
      minDwell = 10000/100;  //set to 10 fps

      s = getParameter("minimum_dwell");
      if (s != null) minDwell = parseInt(s[0]);
      if (minDwell < 20) minDwell = 20;  // 50 fps

      // now pick up params with no associated widget....
      minSpeed = 2;
      maxSpeed = 10000/minDwell;
      mySpeed = (maxSpeed + minSpeed)/2

      s = getParameter("rate");
      if (s != null) {
        mySpeed = parseInt(s[0]);

        if (mySpeed > 500 || mySpeed < 1) {
          debug("******** Invalid value for 'rate' parameter, = "+mySpeed);
          mySpeed = (maxSpeed + minSpeed)/2;
        }

        if (s.length > 1) {
          minSpeed = parseInt(s[1]);
          maxSpeed = parseInt(s[2]);
          if (maxSpeed > 500 || maxSpeed < mySpeed) {
            maxSpeed = 300;
            debug("******** Invalid value for 'rate' maxSpeed parameter....");
          }
          if (minSpeed < 0 || minSpeed > mySpeed) {
            maxSpeed = 2;
            debug("******** Invalid value for 'rate' minSpeed parameter....");
          }

        } else {
          
          // compute minSpeed = mySpeed - (maxSpeed - mySpeed);
          if (mySpeed >= maxSpeed) {
            maxSpeed = mySpeed + 50;
            minDwell = 10000/maxSpeed;
          }
          if (maxSpeed - mySpeed > 10) minSpeed = 2*mySpeed - maxSpeed;
          if (minSpeed < 2) minSpeed = 2;
        }
      }

      dwell = 10000/mySpeed;

      s = getParameter("rocking");
      if (s != null) {
        if (startsWith(s[0],"t") || startsWith(s[0],"T")) isRocking=true;
      } else {
        isRocking = false;
      }

      s = getParameter("loop");


      s = getParameter("pause");
      pauseOnLast = 0;
      if (s != null) {
        pauseOnLast = parseInt(s[0]);
        if (pauseOnLast < 0 || pauseOnLast > 20000) {
          pauseOnLast = 0;
          debug("******** Bad value for 'pause' parameter = "+pauseOnLast);
        }
      }

      s = getParameter("pause_percent");
      pausePercent = 0;
      if (s != null) {
        pausePercent = parseInt(s[0]);
        if (pausePercent < 0 || pausePercent > 20000) {
          pausePercent = 0;
          debug("******** Bad value for 'pause' parameter = "+pausePercent);
        }

      }

      s = getParameter("transparency");
      transparency = 0x00000000;
      if (s != null) {
        transparency = parseHex(s[0]);
      }


      s = getParameter("image_preserve");
      if (s != null) {
        if (s.length % 4 != 0) {
          debug("******** image_preserve -- incorrect number of parameters!");
          preserve = null;
        } else {
          preserve = new Array(s.length);
          for (i = 0; i<s.length; i++) {
            preserve[i] = parseInt(s[i]);
          }
        }
      }

      isLoc = false;
      doingLoc = false;
      s = getParameter("coordinates");
      makeCoordinates(s);


      //hotspot
      doingHotspots = false;
      loadingHotspot = false;
      s = getParameter("hotspot");
      if (s == null) s = getParameter("hotspot0");
      hsButton = new Array();
      hsPoint = new Array();
      hsType = new Array();
      hsValue = new Array();
      hsPan = new Array();
      hsImageNames = new Array();
      hsLoaders = new Array();
      hsLoaderInfo = new Array();
      hsBitmaps = new Array();

      var hsi:int = 0;

      while (s != null) {
        doingHotspots = true;
        makeHotspot(s);
        hsi = hsi + 1;
        s = getParameter("hotspot"+hsi);
      }

      // background_hotspot

      doingBackHotspots = false;
      loadingBackHotspot = false;
      s = getParameter("background_hotspot");
      if (s == null) s = getParameter("background_hotspot0");
      backhsButton = new Array();
      backhsType = new Array();
      backhsValue = new Array();
      hsi = 0;

      while (s != null) {
        doingBackHotspots = true;
        makeBackHotspot(s);
        hsi = hsi + 1;
        s = getParameter("background_hotspot"+hsi);
      }


      // userWindowSize
      userWindowSize = false;
      zoomXBase = 1.0;
      zoomYBase = 1.0;
      s = getParameter("image_window_size");
      if (s != null) {
        bmWidth = parseInt(s[0]);
        bmHeight = parseInt(s[1]);
        bmRect = new Rectangle(0,0,bmWidth, bmHeight);
        userWindowSize = true;
      }

      var xpos:int = 0;
      var ypos:int = 3;
      s = getParameter("content_position");
      if (s != null) {
        xpos = parseInt(s[0]);
        ypos = parseInt(s[1]);
      }

      // not implemented...yet....
      s = getParameter("initial_zoom_state");
      s = getParameter("fade");
      s = getParameter("blank_screen");
      s = getParameter("overlay_locations");
      s = getParameter("image_size");

      // control layout must be done after the image info is available...

      doLayoutControls = true;

      // timer for animation
      timer = new Timer(50);
      timer.addEventListener(TimerEvent.TIMER, showFrames, false, 0, true);

      s = getParameter("background_image");
      onOffBackground = mom.getStyle("backgroundColor");
      usingBI = false;

      if (s != null) {
        debug("......doing background_image...........");
        onOffBackground = 0x00000000;
        biSprite = new Sprite();
        var biBitmap:Bitmap = new Bitmap(new BitmapData(mom.width, mom.height));
        biSprite.addChild(biBitmap);
        biComp =new UIComponent();
        biComp.addChild(biSprite);
        biComp.x = 0;
        biComp.y = 0;
        biComp.width = mom.width;
        biComp.height= mom.height;

        if (doingBackHotspots) {
          for (i=0; i<backhsButton.length; i++) {
            biComp.addChild(backhsButton[i]);
          }
        }

        mom.addChild(biComp);
        usingBI = true;

        var biName:String = s[0];
        if (useAntiCaching) {
          antiCacheIndex = Math.random()*1677216.0;
          biName = biName+"?"+antiCacheIndex;
        }

        var biLoader:Loader = new Loader();
        biLoader.contentLoaderInfo.addEventListener(Event.COMPLETE,
          function(e:Event):void {
            biBitmap.bitmapData = e.target.content.bitmapData;
          }
        );
        biLoader.contentLoaderInfo.addEventListener(IOErrorEvent.IO_ERROR, 
          function(e:IOErrorEvent):void {
            debug("******** Error loading background_image "+biName);
          } );


        try {
          if (imageBase != null) {
            biName = imageBase+biName;
          }

          biLoader.load( new URLRequest(biName));

        } catch (ibe:Error) {
          Alert.show("Unable to load background_image "+biName);
        }
        
      }

      // Now create the VBox to hold the UI components...and addChild it
      vb = new VBox();
      vb.move(xpos, ypos);
      vb.width=mom.width-xpos;
      vb.height=mom.height-ypos;
      vb.setStyle("horizontalAlign","center");
      vb.setStyle("verticalGap",2);
      mom.addChild(vb);

      enh = null;
      var doEnh:Boolean = false;
      var sc:Array = getParameter("controls");
      if (sc != null && sc.indexOf("enhance") > -1) doEnh = true;
      sc = getParameter("bottom_controls");
      if (sc != null && sc.indexOf("enhance") > -1) doEnh = true;

      s = getParameter("no_enh");

      if (s != null || !doEnh) {
        getImageFilenames();

      } else {

        var enhLoader:URLLoader = new URLLoader();
        enhLoader.dataFormat = URLLoaderDataFormat.TEXT;
        enhLoader.addEventListener(Event.COMPLETE, doneGettingEnhTab);
        enhLoader.addEventListener(IOErrorEvent.IO_ERROR, 

          function(e:IOErrorEvent):void {
            debug("IOErrorEvent for enh.tab file");
            getImageFilenames();
          } );


        var enhName:String = "enh.tab";
        s = getParameter("enhance_filename");
        if (s != null) enhName = s[0];

        try {

          if (useAntiCaching) {
            antiCacheIndex = Math.random()*1677216.0;
            enhName = "enh.tab?"+antiCacheIndex;
          }
          if (imageBase != null) enhName = imageBase+enhName;

          var request:URLRequest = new URLRequest(enhName);

          // turn off caching ?
          request.requestHeaders.push(new URLRequestHeader("Cache-Control","no-store,max-age=0,no-cache,must-revalidate"));
          request.requestHeaders.push(new URLRequestHeader("Expires","Mon, 26 Jul 1997 05:00:00 GMT"));
          request.requestHeaders.push(new URLRequestHeader("Pragma","no-cache"));

          enhLoader.load( request);

        } catch (ioe:Error) {
          debug("Other Error for enh.tab file");
          Alert.show("Unable to load enhancement file: "+enhName+"  Error: "+ioe);
        }
        
      }

    }



/** getImageFilenames()
*
* come here to get the filenames (initially and/or on "refresh")
*
* if file_of_filenames, initiate read of that
*
* otherwise, just continue on....
*
*/

    private function getImageFilenames():void {

      var s:Array = getParameter("file_of_filenames");
      if (s != null) {
        fnList = new Array();
        var fnLoader:URLLoader = new URLLoader();
        fnLoader.dataFormat = URLLoaderDataFormat.TEXT;
        fnLoader.addEventListener(Event.COMPLETE, doneGettingFilenames);
        fnLoader.addEventListener(IOErrorEvent.IO_ERROR, errorLoadingFilenames);

        var fofName:String = s[0];
        try {

          if (fofName.indexOf("?") > 0) {
            var bar:RegExp = /\|/g;
            fofName = fofName.replace(bar,"&");
            debugText = debugText + "\nPHP file-of-filenames = "+fofName;

          } else if (useAntiCaching) {
            antiCacheIndex = Math.random()*1677216.0;
            fofName = StringUtil.trim(s[0])+"?"+antiCacheIndex;
          }

          if (imageBase != null) fofName = imageBase+fofName;
          var request:URLRequest = new URLRequest(fofName);

          // turn off caching ?
          request.requestHeaders.push(new URLRequestHeader("Cache-Control","no-store,max-age=0,no-cache,must-revalidate"));
          request.requestHeaders.push(new URLRequestHeader("Expires","Mon, 26 Jul 1997 05:00:00 GMT"));
          request.requestHeaders.push(new URLRequestHeader("Pragma","no-cache"));

          fnLoader.load( request);

        } catch (ioe:Error) {
          Alert.show("Unable to load configuration file: "+s[0]+"  Error: "+ioe);
        }
        
      } else {
        doneGettingFilenames(null);
      }
    }



/** doneGettingFilenames(Event)
*
* handler for file_of_filenames
*
* if called from elsewhere, just continue on to getImages()
*
*/

    private function doneGettingFilenames(event:Event) : void {

      frameLabels = getParameter("frame_label");
      if (event != null) {

        if (frameLabels == null) frameLabels = new Array();
        var fnl:URLLoader = URLLoader(event.target);
        var lines:Array = fnl.data.split("\n");
        var firstTime:Boolean = true;
        var firstHotspot:Boolean = true;

        // first push for background ([0])
        fnList.push(new Array());

        for (var i:int=0; i<lines.length; i++) {

          debug("f_o_f reading line = "+lines[i]);

          lines[i] = StringUtil.trim(lines[i]);
          if (lines[i].slice(0,1) == "#") continue;
          if (lines[i].length < 2) continue;

          if (startsWith(lines[i],"hotspot") ) {
            
            if (firstHotspot) {
              hsButton = new Array();
              hsType = new Array();
              hsValue = new Array();
              hsPoint = new Array();
              hsPan = new Array();
              doingHotspots = true;
              firstHotspot = false;
            }
            var sh:Array = lines[i].split("=");
            var shh:Array = sh[1].split(",");
            makeHotspot(shh);


          } else if (startsWith(lines[i],"coordinates") ) {
            var sc:Array = lines[i].split("=");
            var sch:Array = sc[1].split(",");
            makeCoordinates(sch);

          } else {


            var begindex:int = lines[i].indexOf("\"");
            debug("Looking for quote mark, index="+begindex);
            if (begindex >= 0) {
              var endindex:int = lines[i].lastIndexOf("\"");
              if (begindex == endindex) {
                debug("Error processing frameLabel in "+lines[i]);
                hasFrameLabel = false;
                frameLabels.push(" ");
              } else {
                hasFrameLabel = true;
                frameLabels.push(lines[i].substring(begindex+1,endindex));
              }

              lines[i] = 
                 (lines[i].substring(0,begindex)+lines[i].substring(endindex+1));
            }

            lines[i] = StringUtil.trim(lines[i]);
            debug("now lines = "+lines[i]);

            begindex = lines[i].indexOf(" [");
            //trace("Looking for bracket, index="+begindex);
            if (begindex >= 0) {
              endindex = lines[i].lastIndexOf("]");
              if (endindex < begindex) {
                debug("******** Error processing frameDwell in "+lines[i]);
                fnDwell.push(300);
              } else {
                fnDwell.push(parseInt(lines[i].substring(begindex+2,endindex)));
                useDwell = true;
              }

              lines[i] = 
                 (lines[i].substring(0,begindex)+lines[i].substring(endindex+1));
            }

            //debug("now lines = "+lines[i]);

            lines[i] = StringUtil.trim(lines[i]);
            var inx:int = lines[i].indexOf(" ");
            //trace("Looking for space, index="+inx);

            if (inx > 0) {
              var leftHand:String = StringUtil.trim(lines[i].substring(0,inx));
              var rightHand:String = StringUtil.trim(lines[i].substring(inx));
              fnList[0].push(leftHand);

              var lt:Array = rightHand.split("=");
              //trace("rightHand = "+rightHand);
              //trace("lt[0] = "+lt[0]);
              //trace("lt[1] = "+lt[1]);

              if (lt.length != 2) {
                debug("******** Error processing overlay= in "+lines[i]);
              }

              // comma-separated list of overlay names for this frame...
              if (StringUtil.trim(lt[0]) == "overlay") {
                var olnames:Array = lt[1].split(",");

                for (var k:int = 0; k<olnames.length; k++ ) {
                  if (firstTime) fnList.push(new Array());
                  fnList[k+1].push (StringUtil.trim(olnames[k])); 
                }
                firstTime = false;

              } else {
                debug("******** Error processing overlay name in "+lines[i]);
              }


            } else {

              // just the background filename given -- push it onto the array.
              fnList[0].push(lines[i]);
            }

            
          }
        }
      }

      loadUpImages();
       
    }



/** loadUpImages
*
* initial housekeeping prior to actually loading images
*
*/

    private function loadUpImages(): void {

      if (initialLoad) {
        imgList = new Array(fnList.length);
        singleImage = new Array(fnList.length);
        imgLoaderList = new Array(fnList.length);
        imgLoaderInfoList = new Array(fnList.length);
        bmBackLoaded = new Array(fnList.length);
        overlayStatic = new Array(fnList.length);
        doneOverlayMask = new Array(fnList.length);
        overlayMask = new Array(fnList.length);
        for (var m:int=0; m<fnList.length; m++) {
           overlayStatic[m] = false;
           overlayMask[m] = false;
        }
        overlayStatic[0] = baseStatic;
      }

      // estimate totalframes - will be computed later...
      totalFrames = 0;
      numFrames = fnList[0].length;
      lastFrame = numFrames -1;

      // create a list for image load completed
      for (var i:int=0; i<fnList.length; i++) {

        if (!initialLoad && !loadingHotspot && overlayStatic[i]) continue;

        var bll:Array = new Array(fnList[i].length);
        var blo:Array = new Array(fnList[i].length);
        singleImage[i] = true;

        for (var k:int = 0; k<fnList[i].length; k++ ) {
          bll[k] = false;
          blo[k] = false;
          if (fnList[i][k] != fnList[i][0]) singleImage[i] = false;
          totalFrames = totalFrames + 1;
        }

        if (singleImage[i]) totalFrames = totalFrames - (fnList[i].length - 1);
        bmBackLoaded[i] = bll;
        doneOverlayMask[i] = blo;
      }

      debug("Estimated Total Frames = "+totalFrames);
      debug("Num of layers = "+fnList.length);

      if ( (totalFrames > 0) && useProgressBar && !quietReload && (pbar == null) ) {
        pbar = new ProgressBar();
        pbar.labelPlacement="center";
        pbar.label="Reading image files";
        pbar.indeterminate = false;
        pbar.mode = "manual";
        pbar.setProgress(0,totalFrames);
        pbar.width=200;
        pbar.move(mom.width/2-100, mom.height/2);
        mom.addChild(pbar);
      }


      if (doLayoutControls) {
        layoutControls();
      }

      if (doingHotspots && baseStatic && (hsCan != null)) {
        hsCan.removeAllChildren();
        debug("ADDING hotspots to existing canvas....."+hsButton.length);
        for (m = 0; m<hsButton.length; m++) {
          hsCan.addChild(hsButton[m]);
        }

      }

      getImages();

    }



/** layoutControls()
*
* from the "controls=" and/or "bottom_controls=" parameters,
* crete and layout the control widgets
*
*/

    private function layoutControls():void {

      // now analyze the 'control' parameters -- only the first time...
      //trace("in doLayoutControls..............................");
      hasFrameLabel = false;
      isLoopRock = false;
      loopDirection = 1;
      isOnOff = false;
      onOffUI = null;
      autoState = false;
      isStepping = false;
      useBottomControls = false;
      var tips:Array;

      imgSmoothList = new Array(fnList.length);
      imgZoomableList = new Array(fnList.length);
      for (var h:int=0; h<fnList.length; h++) {
        imgZoomableList[h] = true;
        imgSmoothList[h] = false;
      }


      for (var ctb:int=0; ctb<2; ctb++) {

        vbc= new VBox();
        vbc.setStyle("horizontalAlign","center");
        vbc.setStyle("verticalGap",0);

        //trace("ctb = "+ctb);

        if (ctb == 0) {
          s = getParameter("controls");
          tips = getParameter("controls_tooltip");
        } else {
          s = getParameter("bottom_controls");
          tips = getParameter("bottom_controls_tooltip");
        }

        debug("s = "+s);

        if (s != null) {
          controlBox = new HBox();
          controlBox.height = 40;
          controlBox.setStyle("verticalGap","0");
          var ctsp:Array = getParameter("controls_gap");
          var ctgap:int = 5;
          if (ctsp != null) {
            ctgap = parseInt(ctsp[0]);
          }
          controlBox.setStyle("horizontalGap",ctgap);

          overlayControlBox = null;
          onOffUI = null;
          var gotControls:Boolean = false;

          for (var cn:int=0; cn<s.length; cn++) {

            if (startsWith(s[cn], "/")) {

              if (gotControls) vbc.addChild(controlBox);
              controlBox = new HBox();
              controlBox.height = 40;
              controlBox.setStyle("verticalGap","0");
              controlBox.setStyle("horizontalGap",ctgap);
              s[cn] = s[cn].substring(1);
            }

            if (s[cn] == "startstop") {
              startstop = new Button();
              pLabels = getParameter("startstop_labels");
              if (pLabels == null) {
                startstopLabelFalse= "Start";
                startstopLabelTrue = " Stop ";
              } else {
                startstopLabelTrue = pLabels[0];
                startstopLabelFalse = pLabels[1];
                if (pLabels.length == 3) {
                  startstop.width = parseInt(pLabels[2]);
                }

              }

              if (isLooping) {
                startstop.label=startstopLabelTrue;
              } else {
                startstop.label=startstopLabelFalse;
              }

              startstop.addEventListener(MouseEvent.CLICK, bclick);
              if (tips != null) startstop.toolTip = tips[cn];
              controlBox.addChild(startstop);
              gotControls = true;

            } else if (s[cn] == "speed") {
              speed = new HSlider();
              speed.setStyle("labelOffset",0);
              pLabels = getParameter("speed_label");
              if (pLabels == null) {
                speed.labels = [" ","Set Animation Speed"," "];
              } else {
                speed.labels = [" ",pLabels[0]," "];
                if (pLabels.length == 2) {
                  speed.width = parseInt(pLabels[1]);
                }
              }
              speed.showDataTip = false;
              speed.maximum = maxSpeed;
              speed.minimum = minSpeed;
              speed.value = mySpeed;
              //trace("speed min/max/val = "+minSpeed+"  "+maxSpeed+" "+mySpeed);
              speed.liveDragging = true;
              speed.addEventListener(SliderEvent.CHANGE, changeSpeed);
              if (tips != null) speed.toolTip = tips[cn];
              controlBox.addChild(speed);
              gotControls = true;

            } else if (s[cn] == "framelabel") {
              frameLabelField = new Label();
              frameLabelField.width = frameLabelWidth;
              frameLabelField.height = 20;
              var fls:Array = getParameter("frame_label_style");
              if (fls != null) {
                frameLabelField.opaqueBackground = parseInt(fls[0]);
                frameLabelField.setStyle("color", parseInt(fls[1]));
                if (fls.length > 2) {
                  frameLabelField.setStyle("fontSize",parseInt(fls[2]));
                }
                if (fls.length > 3) {
                  frameLabelField.height = parseInt(fls[3]);
                }

              } else {
                frameLabelField.opaqueBackground = background;
                frameLabelField.setStyle("color",foreground);
              }
              frameLabelField.graphics.lineStyle(1,foreground);
              frameLabelField.graphics.drawRect(0,0,frameLabelWidth,frameLabelField.height);
              frameLabelField.text = " ";

              hasFrameLabel = true;
              if (tips != null) frameLabelField.toolTip = tips[cn];
              controlBox.addChild(frameLabelField);
              gotControls = true;

            } else if (s[cn] == "looprock") {
              looprock = new Button();
              pLabels = getParameter("looprock_labels");
              if (pLabels == null) {
                looprockLabelTrue = "Loop";
                looprockLabelFalse = "Rock";
              } else {
                looprockLabelTrue = pLabels[0]; 
                looprockLabelFalse =  pLabels[1];
                if (pLabels.length == 3) {
                  looprock.width = parseInt(pLabels[2]);
                }
              }

              if (isRocking) {
                looprock.label = looprockLabelTrue;
              } else {
                looprock.label = looprockLabelFalse;
              }

              looprock.addEventListener(MouseEvent.CLICK, bclick);
              isLoopRock = true;
              if (tips != null) looprock.toolTip = tips[cn];
              controlBox.addChild(looprock);
              gotControls = true;

            } else if ( (s[cn].indexOf("autotoggle") == 0) ||
                        (s[cn].indexOf("autorefresh") == 0) ) {
              autoOnOff = new Button();
              pLabels = getParameter("autotoggle_labels");
              if (pLabels == null) pLabels = getParameter("autorefresh_labels");
              if (pLabels == null) {
                autoOnOffLabelTrue = "Auto On ";
                autoOnOffLabelFalse = "Auto Off";
              } else {
                autoOnOffLabelTrue = pLabels[0]; 
                autoOnOffLabelFalse =  pLabels[1];
                if (pLabels.length == 3) {
                  autoOnOff.width = parseInt(pLabels[2]);
                }
              }

              if (!isAutoRefresh) {
                
                refreshRate = 1;
                refreshTimer = new Timer(refreshRate*60*1000);
                refreshTimer.addEventListener(TimerEvent.TIMER, refreshImages, false, 0, true);
                isAutoRefresh = true;
              }

              if (s[cn].indexOf("/off") > 0) {
                autoOnOff.label = autoOnOffLabelTrue;
                autoState = false;
                refreshTimer.stop();
              } else {
                autoOnOff.label = autoOnOffLabelFalse;
                autoState = true;
              }
              if (tips != null) autoOnOff.toolTip = tips[cn];
              autoOnOff.addEventListener(MouseEvent.CLICK, bclick);
              controlBox.addChild(autoOnOff);
              gotControls = true;

            } else if (s[cn] == "refresh") {
              refresh = new Button();
              pLabels = getParameter("refresh_label");
              if (pLabels == null) {
                refresh.label = "Refresh";
              } else {
                refresh.label = pLabels[0];
                if (pLabels.length == 2) {
                  refresh.width = parseInt(pLabels[1]);
                }
              }

              refresh.addEventListener(MouseEvent.CLICK, bclick);
              if (tips != null) refresh.toolTip = tips[cn];
              controlBox.addChild(refresh);
              gotControls = true;

            } else if (s[cn] == "location") {
              locButt = new Button();
              locLabels = getParameter("location_labels");
              if (locLabels == null) {
                locLabelOff = "Show Location";
                locLabelOn = "Hide Location";
                locButt.width = 100;
              } else {
                locLabelOff = locLabels[0];
                locLabelOn = locLabels[1];
                if (locLabels.length == 3) {
                  locButt.width = parseInt(locLabels[2]);
                }
              }

              locButt.label = locLabelOff;
              isLoc = false;
              locButt.addEventListener(MouseEvent.CLICK, bclick);
              if (tips != null) locButt.toolTip = tips[cn];
              locLabel.visible = false;
              controlBox.addChild(locButt);
              gotControls = true;

            } else if (s[cn] == "probe") {
              probe = new CheckBox();
              pLabels = getParameter("probe_label");
              if (pLabels == null) {
                probe.label = "Probe";
              } else {
                probe.label = pLabels[0];
                if (pLabels.length == 2) {
                  probe.width = parseInt(pLabels[1]);
                }
              }

              probe.addEventListener(MouseEvent.CLICK, bclick);
              if (tips != null) probe.toolTip = tips[cn];
              controlBox.addChild(probe);
              isProbe = true;
              probeEnabled = false;
              gotControls = true;

            } else if (s[cn] == "show") {
              debug("Making show button....");
              if (ExternalInterface.available) {
                debug("External interface available...");
                showButt = new Button();
                showButt.label = "Show";
                var sbl:Array = getParameter("show_label");
                if (sbl != null) showButt.label = sbl[0];
                showButt.addEventListener(MouseEvent.CLICK, bclick);
                if (tips != null) showButt.toolTip = tips[cn];
                if (isLooping) {
                  showButt.enabled = false;
                } else {
                  showButt.enabled = true;
                }
                controlBox.addChild(showButt);
                gotControls = true;

              } else {
                debug("External Interface is NOT availble - so no Show Button!")
              }

            } else if (s[cn] == "print")  {
              printButt = new Button();
              printButt.label = "Print";
              var pbl:Array = getParameter("print_label");
              //if (pbl == null) pbl = getParameter("show_label");
              if (pbl != null) printButt.label = pbl[0];
              printButt.addEventListener(MouseEvent.CLICK, bclick);
              if (tips != null) printButt.toolTip = tips[cn];
              if (isLooping) {
                printButt.enabled = false;
              } else {
                printButt.enabled = true;
              }

              controlBox.addChild(printButt);
              gotControls = true;

            } else if (s[cn] == "step") {
              stepBack = new Button();
              stepBack.label="<";
              stepBack.width=20;
              stepBack.addEventListener(MouseEvent.CLICK, bclick);
              stepForward = new Button();
              stepForward.label=">";
              stepForward.width=20;
              stepForward.addEventListener(MouseEvent.CLICK, bclick);
              isStepping = true;
              if (tips != null) stepBack.toolTip = tips[cn];
              if (tips != null) stepForward.toolTip = tips[cn];
              controlBox.addChild(stepBack);
              controlBox.addChild(stepForward);
              gotControls = true;

            } else if (s[cn] == "firstlast") {
              stepFirst = new Button();
              stepFirst.label = "<|";
              stepFirst.width = 30;
              stepFirst.addEventListener(MouseEvent.CLICK, bclick);
              stepLast = new Button();
              stepLast.label = "|>";
              stepLast.width = 30;
              stepLast.addEventListener(MouseEvent.CLICK, bclick);
              if (tips != null) stepFirst.toolTip = tips[cn];
              if (tips != null) stepLast.toolTip = tips[cn];
              controlBox.addChild(stepFirst);
              controlBox.addChild(stepLast);
              gotControls = true;

            } else if (s[cn] == "setframe") {
              setFrameScrollbar = new HSlider();
              var sft:Array = getParameter("setframe_label");
              setFrameText = "Set Frame *";
              if (sft != null) setFrameText = StringUtil.trim(sft[0]);

              setFrameScrollbar.setStyle("labelOffset",0);
              //setFrameScrollbar.height=40;
              setFrameScrollbar.showDataTip = false;
              setFrameScrollbar.maximum = numFrames - 1;
              setFrameScrollbar.minimum = startFrame; 
              setFrameScrollbar.liveDragging = true;
              setFrameScrollbar.addEventListener(SliderEvent.CHANGE,changeFrame);
              if (tips != null) setFrameScrollbar.toolTip = tips[cn];
              //setFrameScrollbar.labels = [" ",setFrameText," "];
              changeFrame(null);
              controlBox.addChild(setFrameScrollbar);
              gotControls = true;

            } else if (s[cn].indexOf("toggle") == 0) {
              var toggles:Array = getParameter("toggle_size");
              if (s[cn].toLowerCase().indexOf("/showall") != -1) {
                showAllOnOff = true;
              } else {
                showAllOnOff = false;
              }

              onOffWidth = 10;
              onOffHeight = 10;
              onOffSpacing = 3;

              if (toggles != null) {
                onOffWidth = parseInt(toggles[0]);
                onOffHeight = parseInt(toggles[1]);
                if (toggles.length > 2) onOffSpacing = parseInt(toggles[2]);
              }

              onOffBMD = new BitmapData(numFrames*(onOffSpacing+onOffWidth), 
                                  onOffHeight+3, true, onOffBackground);
              onOffBM = new Bitmap(onOffBMD);
              onOffSprite = new Sprite();
              onOffSprite.addChild(onOffBM);
              onOffRect = new Rectangle(0,0,onOffWidth, onOffHeight);
              onOffUI = new UIComponent();
              onOffUI.addChild(onOffSprite);
              onOffUI.height = onOffHeight+3;
              onOffUI.width = (onOffSpacing+onOffWidth)*numFrames;

              onOffState =new Array();
              for (var nof:int = 0; nof<numFrames; nof++) {
                onOffState[nof] = 0;
              }

              isOnOff = true;
              if (tips != null) {
                onOffUI.toolTip = tips[cn];
              } else {
                onOffUI.toolTip = "Click on frame to disable; Shift+click to show the frame";
              }
              onOffUI.addEventListener(MouseEvent.CLICK, ooclick);
              drawOnOff();

            } else if (s[cn] == "zoom") {
              zoom = new Button();
              pLabels = getParameter("zoom_labels");
              if (pLabels == null) {
                zoomLabelTrue = "  Zoom  ";
                zoomLabelFalse = "Un-zoom";
              } else {
                zoomLabelTrue = pLabels[0];
                zoomLabelFalse = pLabels[1];
                if (pLabels.length == 3) {
                  zoom.width = parseInt(pLabels[2]);
                }
              }

              zoom.label=zoomLabelTrue;
              zoom.width=70;
              if (tips != null) zoom.toolTip = tips[cn];
              controlBox.addChild(zoom);
              activeZoom = false;
              enableZooming = false;
              isZooming = false;
              gotControls = true;
              zoom.addEventListener(MouseEvent.CLICK, bclick);
              showFrames(null);


            } else if (s[cn] == "fader") {
              setFaderScrollbar = new HSlider();
              var sfd:Array = getParameter("fader_label");
              setFaderText = "Use slider to fade";
              if (sfd != null) setFaderText = StringUtil.trim(sfd[0]);
              sfd = getParameter("fader_width");
              if (sfd != null) setFaderScrollbar.width = parseInt(sfd[0]);

              setFaderScrollbar.setStyle("labelOffset",0);
              setFaderScrollbar.setStyle("slideDuration",10);
              setFaderScrollbar.labels = [" ",setFaderText," "];
              setFaderScrollbar.showDataTip = false;
              setFaderScrollbar.maximum = 10*(numFrames-1);
              faderImages = new Array(10*numFrames);
              setFaderScrollbar.minimum = 0; 
              setFaderScrollbar.value = 0; 
              setFaderScrollbar.liveDragging = true;
              faderFrame = 0;
              setFaderScrollbar.addEventListener(SliderEvent.CHANGE,changeFade);
              if (tips != null) setFaderScrollbar.toolTip = tips[cn];
              controlBox.addChild(setFaderScrollbar);
              isFader = true;
              gotControls = true;

            } else if (s[cn] == "fadertoggle") {
              faderToggle = new Button();
              faderToggle.addEventListener(MouseEvent.CLICK, bclick);
              var stl:Array = getParameter("fadertoggle_label");
              if (stl != null) {
                faderToggle.label = stl[0];
              } else {
                faderToggle.label = "Toggle Original Images";
              }
              if (tips != null) faderToggle.toolTip = tips[cn];
              controlBox.addChild(faderToggle);
              gotControls = true;
                
              
            } else if (s[cn] == "enhance") {
              if (enh == null) {
                Alert.show("No enhancement file 'enh.tab' found...");

              } else {

                enhanceChoice = new ComboBox();
                enhanceChoice.editable = false;
                enhanceChoice.rowCount = 20;
                enhanceChoice.addEventListener(ListEvent.CHANGE, changeEnh);
                var ehp:Array = getParameter("pick_enhancement");
                if (ehp == null) {
                  ehp = new Array();
                  ehp[0] = "Pick Enhancement";
                }
                for (var ie:int =0; ie<enhNames.length; ie++) {
                  ehp[ie+1] = enhNames[ie];
                }
                enhanceChoice.dataProvider = ehp;
                if (tips != null) enhanceChoice.toolTip = tips[cn];

                controlBox.addChild(enhanceChoice);
                gotControls = true;
              }
              

            } else if (s[cn] == "overlay") {
              var ols:Array = getParameter("overlay_labels");
              if (ols == null) ols = getParameter("overlay_label");
              overlayControlBox = new HBox();

              //overlayControlBox.height=30;
              overlayControlBox.setStyle("verticalGap",1);
              var olsp:Array = getParameter("overlay_gap");
              var olgap:int = 8;
              if (olsp != null) {
                olgap = parseInt(olsp[0]);
              }
              overlayControlBox.setStyle("horizontalGap",olgap);

              overlayControlContainer = new VBox();
              overlayControlContainer.setStyle("horizontalAlign","center");
              overlayControlContainer.setStyle("verticalGap",0);
              overlayControlContainer.setStyle("paddingBottom",10);

              if (ols != null) {
                var olct:Array = getParameter("overlay_labels_color");
                var olmoct:Array = getParameter("overlay_labels_mouseover_color");
                var olr:Array = getParameter("overlay_radio");
                var olta:Array = getParameter("overlay_transparent_amount");
                var oll:Array = getParameter("overlay_links");
                var olzo:Array = getParameter("overlay_zorder");
                var olst:Array = getParameter("overlay_static");
                var olzm:Array = getParameter("overlay_zoom");
                var olsmoo:Array = getParameter("overlay_smooth");
                var oltips:Array = getParameter("overlay_tooltip");
                var olbold:Array = getParameter("overlay_labels_bold");

                numOverlayLabels = ols.length;
                if (numOverlayLabels != fnList.length-1) {
                  debug("******** Error: Number of overlay files must equal number of overlay_labels");
                }
                overlay = new Array(numOverlayLabels+1);  //  0=backgnd

                overlayLinks = new Array(numOverlayLabels+1);
                overlayOrder = new Array(numOverlayLabels+1);
                overlayHidden = new Array(numOverlayLabels+1);
                overlayStatic = new Array(numOverlayLabels+1);
                overlayZoom = new Array(numOverlayLabels+1);
                overlayTransparentAmount = new Array(numOverlayLabels+1);

                var doAllAsRadio:Boolean = false;
                var rbg:RadioButtonGroup;
                if (olr != null) {
                  if (olr.indexOf(",") < 0) doAllAsRadio = true;
                  rbg = new RadioButtonGroup();
                }

                var initState:Boolean = false;
                var hiddenState:Boolean = false;
                overlayHidden[i+1] = false;
                overlay[0] = null;

                for (var i:int =0; i<numOverlayLabels; i++) {
                  //trace("filling in overlay sub "+i+"  lab="+ols[i]);
                  initState = false
                  hiddenState = false
                  if (startsWith(ols[i],"/") ) {
                    overlayControlContainer.addChild(overlayControlBox);
                    overlayControlBox = new HBox();
                    //overlayControlBox.height=30;
                    overlayControlBox.setStyle("verticalGap",1);
                    overlayControlBox.setStyle("horizontalGap",olgap);

                    ols[i] = ols[i].substring(1);
                  }
                  if (endsWith(ols[i],"/on")) {
                    ols[i] = ols[i].substring(0,ols[i].length-3);
                    initState = true;
                  } else if (endsWith(ols[i],"/always")) {
                    ols[i] = ols[i].substring(0,ols[i].length-7);
                    initState = true;
                    hiddenState = true;
                  } else if (endsWith(ols[i],"/hidden")) {
                    ols[i] = ols[i].substring(0,ols[i].length-7);
                    initState = false;
                    hiddenState = true;
                    overlayHidden[i+1] = true;
                  } else if (endsWith(ols[i],"/mask") ) {
                    ols[i] = ols[i].substring(0,ols[i].length-5);
                    overlayMask[i+1] = true;

                  }

                 // trace("filling in overlay sub "+i+"  lab="+ols[i]);
                  if (olr != null) {
                    if (startsWith(olr[i],"t") || 
                                 startsWith(olr[i],"T") ) {
                      overlay[i+1] = new RadioButton();
                      if (!hiddenState) overlay[i+1].group = rbg;
                    } else {
                      overlay[i+1] = new CheckBox();
                    }

                  } else {
                    overlay[i+1] = new CheckBox();
                  }

                  if (oltips != null) {
                    overlay[i+1].toolTip = oltips[i];
                  }

                  overlay[i+1].selected = initState;


                  if (olct != null) {
                    overlay[i+1].setStyle("color",parseHex(olct[i]));
                  }

                  if (olmoct != null) {
                    overlay[i+1].setStyle("textRollOverColor",parseHex(olmoct[i]));
                  }

                  if (olbold != null) {
                    if (startsWith(olbold[i],"t") || startsWith(olbold[i],"T") 
                     || startsWith(olbold[i],"b") || startsWith(olbold[i],"B") )  
                           overlay[i+1].setStyle("fontWeight","bold");
                  }

                  if (!hiddenState) {
                    overlay[i+1].label = ols[i];
                    overlay[i+1].addEventListener(MouseEvent.CLICK, cbclick);
                    overlayControlBox.addChild(overlay[i+1]);
                  }


                  if (olta == null) {
                    overlayTransparentAmount[i+1] = 100;
                  } else {
                    overlayTransparentAmount[i+1] = parseInt(olta[i]);
                  }


                  overlayLinks[0] = 0;
                  if (oll == null) {
                    overlayLinks[i+1] = 0;
                  } else {
                    overlayLinks[i+1] = parseInt(oll[i]);
                  }

                  overlayOrder[0] = 0;
                  if (olzo == null) {
                    overlayOrder[i+1] = i + 1;
                  } else {
                    var zo:int = parseInt(olzo[i]);
                    overlayOrder[zo+1] = i + 1;
                  }

                  if (olst == null) {
                    overlayStatic[i+1] = false;
                  } else {
                    if (startsWith(olst[i],"t") ||
                            startsWith(olst[i],"T") ||
                            startsWith(olst[i],"y") ||
                            startsWith(olst[i],"Y") ||
                            startsWith(olst[i],"1")) {
                      overlayStatic[i+1] = true;
                    } else {
                      overlayStatic[i+1] = false;
                    }

                  }
                  overlayStatic[0] = baseStatic;

                  imgZoomableList[0] = true;
                  if (olzm != null) {

                    if (startsWith(olzm[i], "f") ||
                           startsWith(olzm[i], "F") ||
                           startsWith(olzm[i], "n") ||
                           startsWith(olzm[i], "N")) {
                      imgZoomableList[i+1] = false
                    } else {
                      imgZoomableList[i+1] = true;
                    }
                  }
                   
                  imgSmoothList[0] = false;
                  if (olsmoo != null) {

                    if (startsWith(olsmoo[i], "t") ||
                           startsWith(olsmoo[i], "T") ||
                           startsWith(olsmoo[i], "y") ||
                           startsWith(olsmoo[i], "Y")) {
                      imgSmoothList[i+1] = true
                    } else {
                      imgSmoothList[i+1] = false;
                    }
                  }
                }


                // fix up hidden overlay initial states.....
                for (var n:int=0; n<numOverlayLabels; n++) {
                  if (overlayLinks[n+1] > 0) {
                    for (var m:int=0; m<numOverlayLabels; m++) {
                      if (overlayLinks[m+1] == -overlayLinks[n+1]) {
                        if (overlayHidden[m+1]) overlay[m+1].selected = overlay[n+1].selected;
                      }
                    }
                  }  
                }


                isOverlay = true;

              } else {
                Alert.show("Missing 'overlay_labels' parameter!");
              }


            } else {
              debug("******** The control parameter '"+s[cn]+"' is not recognized!");
            }
          }

          // now add the controls, overalys, and toggles if present

          if (gotControls) vbc.addChild(controlBox);

          if (overlayControlBox != null) {
            overlayControlContainer.addChild(overlayControlBox);
            vbc.addChild(overlayControlContainer);
          }

          if (onOffUI != null) vbc.addChild(onOffUI);

          // if top of view, add now; otherwise, defer
          if (ctb == 0) {
            if (!noControls) vb.addChild(vbc);
            useBottomControls = false;
          } else {
            useBottomControls = true;
          }

        } 

      }

      if (isAutoRefresh) refreshTimer.start();

    }


/** cbclick(MouseEvent)
*
* handle events for the overlay checkboxes
*
* complicated by the linking....
*
*/
    private function cbclick(event:MouseEvent): void {
      // we are here because an overlay checkbox was clicked upon

      for (var i:int = 0; i<numOverlayLabels; i++) {
        if (event.currentTarget == overlay[i+1]) {
          if (overlayLinks[i+1] > 0) {
            for (var k:int = 0; k<numOverlayLabels; k++) {
              if (overlayLinks[k+1] == -overlayLinks[i+1]) {
                if (overlayHidden[k+1]) {
                  overlay[k+1].selected = overlay[i+1].selected;
                } else {
                  if (overlay[i+1].selected) overlay[k+1].selected=true;

                }
              }
            }
          }
        }

        if (overlay[i+1] is RadioButton) {
          for (var m:int = 0; m<numOverlayLabels; m++) {
            if (overlayLinks[m+1] > 0) {
              for (k = 0; k<numOverlayLabels; k++) {
                if ( (overlayLinks[k+1] == -overlayLinks[m+1]) &&
                                               overlayHidden[k+1] ) {
                     overlay[k+1].selected = overlay[m+1].selected;
                }
              }
            }
          }
        }
       
      }

      showFrames(null);
      //event.updateAfterEvent();
    }



/** ooclick(MouseEvent)
*
* handle events for the "toggle boxes"
*
*/

    private function ooclick(event:MouseEvent): void {
      var wf:int = event.localX/(onOffWidth + onOffSpacing);
      if (event.shiftKey) {
        setCurrentFrame(true, wf, false);

      } else {
        if (onOffState[wf] == -1) {
          onOffState[wf] = 0;
        } else {
          onOffState[wf] = -1;
        }
        drawOnOff();
      }

      //event.updateAfterEvent();
      
    }



/** changeFrame(SliderEvent)
*
* handle events for the "setframe" Slider
*
*/

    private function changeFrame(event:SliderEvent): void {
      var inx:int = setFrameText.indexOf("*");
      if (inx >= 0) {
        setFrameScrollbar.labels = [" ",
        (setFrameText.substring(0,inx)+(Math.round(setFrameScrollbar.value)+1)+setFrameText.substring(inx+1)),
        " "];
      }
      setCurrentFrame(true, Math.round(setFrameScrollbar.value), false);
    }


/** changeSpeed(SliderEvent)
*
* handle events for the speed changer Slider
*
*/

    private function changeSpeed(event:SliderEvent): void {
      if (event.currentTarget != speed) return;
      //dwell = 1000 + minDwell - speed.value;
      dwell = 10000/speed.value;
      //trace("set dwell = "+dwell+"  speed.val="+speed.value);
      if (canResetDwell) timer.delay = dwell;
    }



/** changeFade(SliderEvent)
*
* handle events for the fader Slider
*
*/ 
    private function changeFade(event:SliderEvent): void {
      if (event.currentTarget != setFaderScrollbar) return;
      timer.stop();  // no longer needed....
      setCurrentFrame(false, 0, false);
      if (!isShowingFrames) showFrames(null);
    }



/** bdrag(MouseEvent)
*
* handle mouse drag events.
*
* if roaming, then cause the image to (xy)Move
*
* if drawing The Line, just define the endpoints
*/


    private function bdrag(event:MouseEvent) : void {

      if (event.buttonDown == true) {

        if (event.shiftKey) {
          xLineEnd = event.localX;
          yLineEnd = event.localY;
          isDrawingLine = true;
          if (!isShowingFrames) showFrames(null);
          return;
        }

        if (zoomXFactor <= zoomXBase) return;

        if (isDragging || (Math.abs(event.localX - xScreen) > 3) || 
                (Math.abs(event.localY - yScreen) > 3) ) {

           xScreen = event.localX;
           yScreen = event.localY;
           xMove = Math.round(xScreen - xImage*zoomXFactor);
           yMove = Math.round(yScreen - yImage*zoomYFactor);

           isDragging = true;
        }
      }

      if (isLoc) updateLocation(event);

      if (!isShowingFrames) showFrames(null);
      //event.updateAfterEvent();
    }


/** updateLocation()
*
* update the Location readout, if active...
*/
  private function updateLocation(event:MouseEvent) : void {
    xMouse = event.localX;
    yMouse = event.localY;
    if (xMouse < 0 || xMouse > bmWidth) return;
    if (yMouse < 0 || yMouse > bmHeight) return;

    lat = (location[0] - ( (location[0] - location[2])* 
                        (yMouse-yMove) )/bmHeight/zoomYFactor);
    lon = (location[1] - ( (location[1] - location[3])*
                        (xMouse-xMove) )/bmWidth/zoomXFactor);

    locLabel.text = locLabelFirst+lat.toFixed(locLabelDigits)+"  "+locLabelSecond+lon.toFixed(locLabelDigits);
    locLabel.height = locLabel.measureText(locLabel.text).height + 3;
    locLabel.width = locLabel.measureText(locLabel.text).width + 5;

    if (xMouse+locOffset + locLabel.width > bmWidth) {
      locLabel.x = bmWidth - locLabel.width;
    } else {
      locLabel.x = xMouse+locOffset;
    }

    if (yMouse + locOffset + locLabel.height > bmHeight) {
      locLabel.y = bmHeight - locLabel.height;
    } else {
      locLabel.y = yMouse + locOffset;
    }

    locLabel.invalidateSize();
  }



/** resetZoom()
*
* reset the zoom factor to the default.  Reset the pointers
* for offset displays of the image
*/

    private function resetZoom(): void {
      zoomXFactor = zoomXBase;
      zoomYFactor = zoomYBase;

      isZooming = false;
      if (zoom != null) {
        zoom.label = zoomLabelTrue;
        enableZooming = false;
      }
      xImage = xScreen;
      yImage = yScreen;
      xMove = 0;
      yMove = 0;
    }



/** bclick(MouseEvent)
*
* handle button clicking events
*/

    private function bclick(event:MouseEvent): void {

      debug("Event = "+event+"  Target = "+event.target);

      if (event.target == backSprite) {

        // did we click?
        if (event.type == "mouseUp" ) {

          if (!event.shiftKey && !isDrawingLine && !isDragging) {

            if (Math.abs(event.localX - xScreen) < 3 &&
                Math.abs(event.localY - yScreen) < 3) {

               xScreen = event.localX;
               yScreen = event.localY;

              if (event.altKey) {
                resetZoom();

              } else {

                if (enableZooming) {
                  if (event.ctrlKey) {
                    zoomXFactor = zoomXFactor - .1*zoomScale;
                    zoomYFactor = zoomYFactor - .1*zoomScale;
                    if (zoomXFactor < zoomXBase || zoomYFactor < zoomYBase) {
                      zoomXFactor = zoomXBase;
                      zoomYFactor = zoomYBase;
                      xImage = xScreen;
                      yImage = yScreen;
                      xMove = 0;
                      yMove = 0;
                    }

                  } else {

                    zoomXFactor = zoomXFactor + .1*zoomScale;
                    zoomYFactor = zoomYFactor + .1*zoomScale;
                  }
                }

                isZooming = true;
                xMove = Math.round(xScreen - xImage*zoomXFactor);
                yMove = Math.round(yScreen - yImage*zoomYFactor);
              }
            }

            if (isLoc) updateLocation(event);

          } else {

            isDragging = false;
            if (isDrawingLine) drawingPaper.graphics.clear();
            isDrawingLine = false;
          }

        } else if (event.type == "mouseDown") {

          //if (!checkHotspot(event, true)) {
            xScreen = event.localX;
            yScreen = event.localY;
            xImage = Math.round( (xScreen - xMove)/zoomXFactor);
            yImage = Math.round( (yScreen - yMove)/zoomYFactor);
            isDragging = false;
            if (isDrawingLine) drawingPaper.graphics.clear();
            isDrawingLine = false;
          //}
        }

        if (!isShowingFrames) showFrames(null);


      } else if (event.target == startstop) {

        if (isLooping) {
          timer.stop();
          stopLooping();
        } else {
          startLooping();
          timer.start();
        }

      } else if (event.target == showButt) {
        try {
          var fnshow:String = fnList[0][currentFrame];
          if (imageBase != null) fnshow = imageBase+fnList[0][currentFrame];
          debug("calling ExInt with fn = "+fnshow);
          ExternalInterface.call("flanis_show", fnshow);

        } catch (e:Error) {
          debug("ExternInterface error = "+e);
        }

      } else if (event.target == printButt) {
         try {
           var pj:PrintJob = new PrintJob();
           var pjo:PrintJobOptions = new PrintJobOptions();
           pjo.printAsBitmap = true;
           pj.start();
           pj.addPage(backSprite, null, pjo);
           pj.send();
           pj = null;
         } catch (e:Error) {
           debug("printButt error = "+e);
         }

      } else if (event.target == stepForward) {

        loopDirection = 1;
        setCurrentFrame(false, loopDirection, true);

      } else if (event.target == stepBack) {

        loopDirection = -1;
        setCurrentFrame(false, loopDirection, true);


      } else if (event.target == stepFirst) {
        setCurrentFrame(true, 0, true);

      } else if (event.target == stepLast) {
        setCurrentFrame(true, lastFrame, true);

      } else if (event.target == zoom) {
         if (enableZooming) {
           resetZoom();
         } else {
           enableZooming = true;
           zoom.label = zoomLabelFalse;
         }
         if (!isShowingFrames) showFrames(null);

      } else if (event.target == looprock) {
        isRocking = !isRocking;
        if (isRocking) {
          looprock.label = looprockLabelTrue;
        } else {
          looprock.label = looprockLabelFalse;
          loopDirection = 1;
          setCurrentFrame(false, loopDirection, false);
        }

      } else if (event.target == autoOnOff) {
        if (autoState) {
          autoOnOff.label = autoOnOffLabelTrue;
          refreshTimer.stop();
          autoState = false;
        } else {
          autoOnOff.label = autoOnOffLabelFalse;
          refreshTimer.delay = refreshRate*60*1000;
          refreshTimer.start();
          autoState = true;
        }

      } else if (event.target == refresh) {
        refreshImages(null);

      } else if (event.target == faderToggle) {
        var v:int = setFaderScrollbar.value;
        v = (v+10)/10*10;
        if (v > setFaderScrollbar.maximum) v = 0;
        setFaderScrollbar.value = v;
        setCurrentFrame(false, 0, false);
        if (!isShowingFrames) showFrames(null);

      } else if (event.target == locButt) {
        if (isLoc) {
          isLoc = false;
          locButt.label = locLabelOff;
          locLabel.visible = false;
        } else {
          isLoc = true;
          locButt.label = locLabelOn;
          locLabel.visible = true;
        }

      } else {

        if (doingHotspots) {
        debug("checking hotspots for button click....."+hsButton.length);

          for (var n:int = 0; n<hsButton.length; n++) {

            if (event.target == hsButton[n].getChildAt(0)) {

              if (hsType[n] == "fof") {
                var mm:int = paramNames.indexOf("file_of_filenames");
                if (mm != -1) paramValues[mm][0] = hsValue[n];
                loadingHotspot = true;
                refreshImages(null);
                return;

              } else if (hsType[n] == "popup" ) {

                  showHotspotText(hsValue[n]);

              } else if (hsType[n] == "link") {
                ExternalInterface.call("flanis_link", hsValue[n]);
              }
            }
          }


        } 

        if (doingBackHotspots) {
          debug("checking backhotspots for button click....."+backhsButton.length);

          for (n = 0; n<backhsButton.length; n++) {

            if (event.target == backhsButton[n]) {

              if (backhsType[n] == "fof") {
                mm = paramNames.indexOf("file_of_filenames");
                if (mm != -1) paramValues[mm][0] = backhsValue[n];
                loadingHotspot = true;
                refreshImages(null);
                return;

              } else if (backhsType[n] == "popup" ) {

                  showHotspotText(backhsValue[n]);

              } else if (backhsType[n] == "link") {
                ExternalInterface.call("flanis_link", backhsValue[n]);
              }
            }
          }

        }
      }

      event.updateAfterEvent();
    }

/** doPopUpText(s:String)
*
* this needs to be more auto-scaled, though....
*
*/

    private function showHotspotText(s:String):void {
      var hotspotText:TextArea = new TextArea();

      hotspotText.editable = false;
      hotspotText.wordWrap = true;
      hotspotText.htmlText = s;
      hotspotText.horizontalScrollPolicy = "off";
      hotspotText.verticalScrollPolicy = "auto";
      hotspotText.validateNow();
      hotspotText.percentWidth = 100;
      hotspotText.percentHeight = 100;

      var hsTW:TitleWindow = new TitleWindow();
      hsTW.horizontalScrollPolicy = "auto";
      hsTW.verticalScrollPolicy = "auto";
      hsTW.layout = "vertical";
      hsTW.showCloseButton = true;
      hsTW.width = 160;
      hsTW.height = 200;
      hsTW.validateNow();

      hsTW.addChild(hotspotText);
      PopUpManager.addPopUp(hsTW, grandma, false);

      hsTW.addEventListener(CloseEvent.CLOSE,
        function (e:Event): void {
          PopUpManager.removePopUp(hsTW);
          mom.setFocus();
        }
      );
    }



/** kclick()
*
* handler for key clicks
*
*/
    private function kclick(e:KeyboardEvent):void {
     debug("keyboard...keyCode="+e.keyCode+" charCode="+e.charCode);
      if (e.type == "keyUp") {
        activeKey = -1;
        return;
      }

      activeKey = e.keyCode;
      if (e.keyCode == 37) {
        // back one
        setCurrentFrame(false, -1, true);
      } else if (e.keyCode == 39) {
        // forward one
        setCurrentFrame(false, 1, true);
      }

      //trace("active key = "+activeKey);
    }




/** drawOnOff()
*
* draw the "toggle boxes" -- just set their colors based on onOffState
* values.
*
*/

    private function drawOnOff():void {
      for (var nof:int = 0; nof<numFrames; nof++) {

        onOffRect.x = nof*(onOffWidth+onOffSpacing);

        if (onOffState[nof] == -1) {
          onOffBMD.fillRect(onOffRect, 0xffff0000);
        } else if (onOffState[nof] == 1) {
          onOffBMD.fillRect(onOffRect, 0xff0000ff);
        } else {
          onOffBMD.fillRect(onOffRect, 0xff00ff00);
        }
      }
    }
    



/** setCurrentFrame(Boolean, int, Boolean)
*
* set the currentFrame value based on inputs
*
* handle toggle button changes as well (if needed)
*
* set the dwell rates as appropriate
*/

    private function setCurrentFrame(isAbsolute:Boolean, value:int, isButton:Boolean): void {

      if (!isAbsolute) value = value * incFrame;
      if (numFrames < 0) return;
      if (isFader) {
        currentFrame = setFaderScrollbar.value;
        return;
      }

      if (isOnOff && currentFrame != -1) {
        if (onOffState[currentFrame] != -1) onOffState[currentFrame] = 0;
      }

      if (isAbsolute) {
        stopLooping();
        currentFrame = value;

      } else {
        deadFrames = 0;
        while (true) {
          currentFrame = currentFrame + value;
          if (currentFrame > lastFrame) {
            if (isRocking && !isButton) {
              currentFrame = lastFrame - incFrame;
              if (currentFrame < firstFrame) currentFrame = firstFrame;
              loopDirection = -loopDirection;
              value = -value;
            } else {
              currentFrame = firstFrame;
            }

          } else if (currentFrame < firstFrame) {
            if (isRocking && !isButton) {
              currentFrame = firstFrame + incFrame;
              loopDirection = -loopDirection;
              value = -value;
            } else {
              currentFrame = lastFrame;
            }
          }

          if (!isOnOff) break;
          if (onOffState[currentFrame] != -1) break;

          deadFrames = deadFrames + 1;
          if (deadFrames >= numFrames) {
            currentFrame = 0;
            break;
          }
        }
      }

      if (isOnOff) { 
        onOffState[currentFrame] = 1;
        drawOnOff();
      }

      if (hasFrameLabel && (frameLabels != null)) {
        frameLabelField.text = frameLabels[currentFrame];
      }

      addDwell = 0;
      if (useDwell) {
        dwell = fnDwell[currentFrame];
      } else {
        if (currentFrame == (numFrames - 1)) {
          if (pausePercent > 0) {
            addDwell = (dwell * pausePercent) / 100;
          } else {
            addDwell = pauseOnLast;
          }
        }
      }

      if (canResetDwell) timer.delay = (dwell + addDwell);
      if (!isLooping && !isShowingFrames) showFrames(null);
    }





/** showFrames(TimerEvent)
*
* the workhorse
*
*/

    private function showFrames(event:TimerEvent): void {

      //debug("show Frames, Timer count="+timer.currentCount+"  delay="+timer.delay+" frame="+currentFrame+" mem="+System.totalMemory);

      if (!bmBackCreated) return;
      isShowingFrames = true;
      if (event != null && isLooping) setCurrentFrame(false,loopDirection,false);
      // initialize the background
      var bgndInit:Boolean = true;
      //bmBack.bitmapData.fillRect(bmRect, mom.getStyle("backgroundColor") );

      var mat:Matrix = new Matrix();
      mat.scale (zoomXFactor, zoomYFactor);
      mat.translate (xMove, yMove);


      // check to see if they dragged too far....

      var ptt:Point = mat.transformPoint(upperLeft);
      if (ptt.x > 0) {
        mat.translate(-ptt.x,0);
        xMove = xMove - ptt.x;
      }
      if (ptt.y > 0) {
        mat.translate(0, -ptt.y);
        yMove = yMove - ptt.y;
      }

      ptt = mat.transformPoint(lowerRight);
      if (ptt.x < bmWidth) {
        mat.translate(bmWidth - ptt.x,0);
        xMove = xMove + (bmWidth - ptt.x);
      }

      if (ptt.y < bmHeight) {
        mat.translate(0,bmHeight - ptt.y);
        yMove = yMove + (bmHeight - ptt.y);
      }

      if (doingHotspots ) {
        var ptxy:Point = new Point();
        for (var m:int=0; m<hsButton.length; m++) {
          if (hsPan[m] == "pan") {
            ptxy.x = hsPoint[m].x + hsButton[m].width/2;
            ptxy.y = hsPoint[m].y + hsButton[m].height/2;
            ptxy = mat.transformPoint(ptxy);
            hsButton[m].x = ptxy.x - hsButton[m].width/2;
            hsButton[m].y = ptxy.y - hsButton[m].height/2;
          }
        }
      }


      //trace("zxf="+zoomXFactor+"  zyf="+zoomYFactor+" xM="+xMove+" yM="+yMove);
      var oo:int;

      if (isFader) {
        its = currentFrame / 10;
        var scale:int = (256 * (currentFrame % 10) )/10;

        if (bmBackLoaded[0][its] != false) {

          if (bgndInit) {
            bmBack.bitmapData.fillRect(bmRect,mom.getStyle("backgroundColor") );
            bgndInit = false;
          }

          canResetDwell = true;

          if (faderImages[currentFrame] == null) {

             faderImages[currentFrame] = new BitmapData(imgWidth,imgHeight,
                                    false,mom.getStyle("backgroundColor"));

             if (imgList[0][its] != null) {
                  faderImages[currentFrame].copyPixels(imgList[0][its],
                                    imgRect,upperLeft);
             }

             if (currentFrame % 10 != 0) {
               if (imgList[0][its+1] != null) 
                     faderImages[currentFrame].merge(imgList[0][its+1], 
                            imgRect,upperLeft, scale, scale, scale, scale); 
             }

          }

          bmBack.bitmapData.draw(faderImages[currentFrame], mat, 
                         null, null, bmRect);
        }


      } else {

        for (var i:int=0; i<imgList.length; i++) {
          its = currentFrame;

          if ( ( overlayOrder != null) && (i != 0)) {
            oo = overlayOrder[i];
          } else {
            oo = i;
          }

          if (singleImage[oo]) its = 0;
          if (its > imgList[oo].length-1) its = imgList[oo].length - 1;

          //trace("bmBackLoaded="+bmBackLoaded[oo][its]+"  oo="+oo+ " its="+its+" imgRect="+imgRect+" bmRect="+bmRect);

          if (bmBackLoaded[oo][its] == false) continue;
          if (bgndInit) {
            bmBack.bitmapData.fillRect(bmRect,mom.getStyle("backgroundColor") );
            bgndInit = false;
          }
          canResetDwell = true;

          if (i == 0 || ( (oo != 0) && isOverlay && 
                           overlay[oo].selected == true)) {

            // masking...
            if (overlayMask[oo] && 
                   !doneOverlayMask[oo][its] && bmBackLoaded[oo-1][its]) {

              var bmdm:BitmapData = imgList[oo-1][its].clone();

              //trace(" masking oo = "+oo+"  its="+ 
              //its+" h/w="+bmdm.height+" "+bmdm.width);

              var knt:int = bmdm.threshold(imgList[oo][its], imgRect,
                  upperLeft, "!=", 0xffffffff, 0x00000000, 0x00ffffff, false);
              imgList[oo][its] = bmdm;
              doneOverlayMask[oo][its] = true;
              //trace("  masking count = "+knt);
            }



            // if zoomable, apply zoom and pan; otherwise, just do it...

            if (imgZoomableList[oo] == true) {
               if (imgList[oo][its] != null) 
                    bmBack.bitmapData.draw(imgList[oo][its], mat, 
                            null, null, bmRect, imgSmoothList[oo]);
            
            } else {

               if (imgList[oo][its] != null) 
                      bmBack.bitmapData.draw(imgList[oo][its],null,
                               null,null,bmRect,imgSmoothList[oo]);
            }

            // if part is preserved, draw it....

            if (i == 0 && preserve != null) {
              for (var p:int=0; p<preserve.length; p=p+4) {
                preRect.x = preserve[p];
                preRect.y = preserve[p+1];
                preRect.right = preserve[p+2];
                preRect.bottom = preserve[p+3];
                prePoint.x = preserve[p];
                prePoint.y = preserve[p+1];
                bmBack.bitmapData.copyPixels(imgList[oo][its], preRect, prePoint);
              }
            }



            // when will probes every be enabled, eh?
            if (probeEnabled) {
              if (probeValues[oo] != null) {
                var pix:int = imgList[oo][its].getPixel(xImage, yImage);
                //debug("at x,y="+xImage+","+yImage+"  val="+Number(pix).toString(16));

              }
            }

          }
        }
      }


      if (isDrawingLine) {
        drawingPaper.graphics.clear();
        drawingPaper.graphics.lineStyle(1,0xffffff);
        drawingPaper.graphics.moveTo(xScreen, yScreen);
        drawingPaper.graphics.lineTo(xLineEnd, yLineEnd);
      }

      mat = null;
      event = null;
      isShowingFrames = false;
    }



      

/** getImages()
*
* continue the chain of events in setting this up.
*
* here, create the Loaders and begin the loading operations
*
* event handler is called "doneLoading"
*/

    public function getImages() :void {

      //trace("in getImages, initialLoad = "+initialLoad);

      var fName:String = " ";
      totalFrames = 0;
      isLoading = true;
      countFrames = 0;

      for (var i:int=0; i<fnList.length; i++) {

        if (initialLoad) {
          imgLoaderList[i] = new Array(fnList[i].length);
          imgLoaderInfoList[i] = new Array(fnList[i].length);
          imgList[i] = new Array(fnList[i].length);

        } else if (!loadingHotspot && overlayStatic[i]) {
          //trace("overlay Static = "+i);
          if (i == 0) {
            bmBackCreated = true;
            doLayoutControls = false;  // only the first time...

            // now restart as required...
            isLooping = wasLooping;
            if (isLooping) {
              startLooping();
            } else {
              stopLooping();
            }
            timer.start();
          }
          continue;
        }


        for (var k:int=0; k<fnList[i].length; k++) {
          //trace("getImage i="+i+" k="+k);
          if (singleImage[i] && (k != 0) ) continue;

          try {


            if (imgLoaderList[i][k] != null) {
              imgLoaderList[i][k].unload();
            }


            imgLoaderList[i][k] = new Loader();
            imgLoaderInfoList[i][k] = imgLoaderList[i][k].contentLoaderInfo;
            imgLoaderInfoList[i][k].addEventListener(Event.COMPLETE, 
                                  doneLoading);
            imgLoaderInfoList[i][k].addEventListener(IOErrorEvent.IO_ERROR, 
                                  errorLoading);
            fName = fnList[i][k];
            if (imageBase != null) fName = imageBase+fName;

            var request:URLRequest;

            //trace("use="+useCaching+"  doEx="+ doExcludeCaching+" fName="+fName+"  exString="+excludeCaching);

            if (!useCaching || (doExcludeCaching && 
                           (fName.indexOf(excludeCaching) != -1) ) ) {

              if (useAntiCaching && fName.indexOf("?") == -1) {
                antiCacheIndex = Math.random()*1677216.0;
                fName = fName+"?"+antiCacheIndex;
              }

              request = new URLRequest(fName);

              request.requestHeaders.push(new URLRequestHeader("Cache-Control","no-store,max-age=0,no-cache,must-revalidate"));
              request.requestHeaders.push(new URLRequestHeader("Expires","Mon, 26 Jul 1997 05:00:00 GMT"));
              request.requestHeaders.push(new URLRequestHeader("Pragma","no-cache"));

            } else {
              request = new URLRequest(fName);
            }

            debug("Read file: "+fName);

            imgLoaderList[i][k].load(request);
            totalFrames = totalFrames + 1;

          } catch (ioe:Error) {

            debug("******** Error in getImages for "+fName+":"+ioe);
            imgList[i][k] = null;
          }

        }
      }

      if (hiresFnList != null) {
        for (i=0; i<hiresFnList.length; i++) {
          if (hiresFnList[i] != null && (hiresFnList[i].length > 3) ) {
            //trace("would read hires = "+hiresFnList[i]);
          }
        }
      }

      loadingHotspot = false;

      //initialLoad = false;

      //trace("Done with getImages....");
      
    }



/** errorLoadingFilenames(IOErrorEvent)
*
* come here if there is a problem reading file_of_filenames
*
*/
    public function errorLoadingFilenames(e:IOErrorEvent) : void {
      Alert.show("Could not load file_of_filenames!! "+e);
    }

/** errorLoadingConfigFile(IOErrorEvent)
*
* come here if there is a problem reading file_of_filenames
*
*/
    public function errorLoadingConfigFile(e:IOErrorEvent) : void {
      Alert.show("Could not read config file! Error="+e);
    }



/** errorLoading(IOErrorEvent)
*
* if there was an error loading images, come here -- 
* null out the BitmapData reference and dock the totalFrames
* count.
*/
    public function errorLoading(e:IOErrorEvent) : void {

      for (var i:int=0; i<imgLoaderList.length; i++) {
        // now scan each element of the overlay list
        for (var k:int=0; k<imgLoaderList[i].length; k++) {
          if (e.target == imgLoaderInfoList[i][k]) {
            debug("******** Error loading frame "+k+" from overlay "+i);
            imgList[i][k] = null;
          }
        }
      }
      updatePBar();
    }


/** updatePBar()
*
* update the value of the Progress Bar.  Test whether we're done
*/
    private function updatePBar():void {
      countFrames = countFrames + 1;
      if (countFrames >= totalFrames) {
        isLoading = false;
        if (refresh != null) refresh.enabled = true;
      }


      if ( (pbar != null) && useProgressBar) {
        pbar.setProgress(pbar.value+1, totalFrames);
        pbar.validateNow();

        //trace("value = "+pbar.value+"  totalFrames="+totalFrames);

        if ( (pbar != null) && (pbar.value >= totalFrames)) {
          mom.removeChild(pbar);
          pbar = null;
          // reset isLoading now
          isLoading = false;
          if (refresh != null) refresh.enabled = true;
        }
      }

    }



/** doneLoading(Event)
*
* event handler -- after an image is loaded, this will be
* called.  Search thru the list of Loaders and find the right
* one.  Get the BitmapData for that image and store it away.
*
* Also, set the stage for displaying, make the Sprite for all
* this.  Finish the GUI if appropriate (bottom_controls).  Add
* in the "paper" UIComps for drawing and readouts.
*/
    public function doneLoading(e:Event):void {

      //trace("Enter doneLoading, usePbar = "+useProgressBar);


      imgHeight = e.target.content.bitmapData.height;
      imgWidth = e.target.content.bitmapData.width;
      imgRect = new Rectangle(0,0,imgWidth, imgHeight);

      // look through imgLoaderList for match...which image is this?
      for (var i:int=0; i<imgLoaderList.length; i++) {

        // now scan each element of the overlay list
        for (var k:int=0; k<imgLoaderList[i].length; k++) {

          if (e.target.loader == imgLoaderList[i][k]) {

            debug("MATCHED LOADER for i="+i+"  k="+k);

            // element 0 is special = background image

            if (i == 0) {
            
              if (initialLoad && imgHeight > 0 && imgWidth > 0) {
                if (!userWindowSize) {
                  bmHeight = imgHeight;
                  bmWidth = imgWidth;
                  bmRect = new Rectangle(0,0,bmWidth, bmHeight);

                } else {
                  zoomXBase = bmWidth/imgWidth;
                  zoomYBase = bmHeight/imgHeight;
                  zoomXFactor = zoomXBase;
                  zoomYFactor = zoomYBase;
                }
                bmBackground = new BitmapData(bmWidth, bmHeight, 
                              false, mom.getStyle("backgroundColor") );
                bmBack = new Bitmap(bmBackground);
                initialLoad = false;
              }


              if (imgList[i][k] != null) imgList[i][k].dispose();
              imgList[i][k] = new BitmapData(imgWidth, imgHeight, false);
              imgList[i][k].copyPixels(e.target.content.bitmapData, imgRect, upperLeft);
              //trace("imgList[i][k] width="+imgList[i][k].width);
              //trace("bmHeight = "+bmHeight+"  width="+bmWidth);

              // if first image, then make a UIComponent & Sprite for it
              if (k == 0) {
                lowerRight = new Point(imgWidth, imgHeight);

                if (backSprite != null) backSprite.removeChild(bmBack);

                debug("defined bmBack "+i+" width="+bmBack.bitmapData.width);
                backSprite = new Sprite();
                backSprite.addChild(bmBack);

                if (imgUIBack != null) vb.removeChild(imgUIBack);

                imgUIBack = new UIComponent();
                imgUIBack.height = bmHeight;
                imgUIBack.width = bmWidth;
                imgUIBack.addChild(backSprite);


                backSprite.addEventListener(MouseEvent.MOUSE_DOWN, bclick);
                backSprite.addEventListener(MouseEvent.MOUSE_UP, bclick);
                backSprite.addEventListener(MouseEvent.MOUSE_MOVE, bdrag);

                // now add background image...
                drawingPaper = new UIComponent();
                drawingPaper.x = 0;
                drawingPaper.y = 0;
                drawingPaper.width = bmWidth;
                drawingPaper.height = bmHeight;
                imgUIBack.addChild(drawingPaper);

                probePaper = new UIComponent();
                probePaper.x = 0;
                probePaper.y = 0;
                probePaper.width = bmWidth;
                probePaper.height = bmHeight;
                imgUIBack.addChild(probePaper);
                if (doingLoc) imgUIBack.addChild(locLabel);

                if (doingHotspots) {
                  if (hsCan != null) hsCan.removeAllChildren();
                  hsCan = new Canvas();
                  hsCan.width = bmWidth;
                  hsCan.height = bmHeight;
                  hsCan.autoLayout = false;
                  hsCan.clipContent = true;
                  hsCan.horizontalScrollPolicy = "off"; 
                  hsCan.verticalScrollPolicy = "off";

                  ////// maybe the UIComp needs to have its location fixed....

                 debug(".....ADDING hotspots to new bgnd....."+hsButton.length);
                  for (var m:int = 0; m<hsButton.length; m++) {
                    hsCan.addChild(hsButton[m]);
                    //imgUIBack.addChild(hsButton[m]);

                  }

                  imgUIBack.addChild(hsCan);
                }

                vb.addChild(imgUIBack);

                bmBackCreated = true;

                if (!doLayoutControls && useBottomControls) {
                  vb.removeChild(vbc);
                  doLayoutControls = true;
                }

                if (doLayoutControls && useBottomControls) {
                  if (!noControls) vb.addChild(vbc);
                }

                doLayoutControls = false;  // only the first time...

                // now restart as required...
                isLooping = wasLooping;
                if (isLooping) {
                  startLooping();
                } else {
                  stopLooping();
                }
                timer.start();
              }

            } else {

              var bmd:BitmapData = new BitmapData(imgWidth,imgHeight,true);

              // fix the transparent level
              bmd.threshold(e.target.content.bitmapData, imgRect, upperLeft, "==", transparency, 0x00000000, 0x00FFFFFF, true);

              if  (overlayTransparentAmount != null) {
                ct.alphaMultiplier = overlayTransparentAmount[i]/100.0;
                bmd.colorTransform(imgRect, ct);
              }

              imgList[i][k] = bmd;
              
            }  

            bmBackLoaded[i][k] = true;
            break;
          }
        }

      }

      updatePBar();
      
      //trace("exit doneLoading");
    }





/** refreshImages(Event)
*
* prepare to refresh images - either from the Refresh button
* having been pressed, or the refreshTimer ticked...
*/

    private function refreshImages(event:TimerEvent) :void {
      
      if (isLoading) return;
      timer.stop();
      canResetDwell = false;
      timer.delay = 50;
      bmBackCreated = false;
      if (refresh != null) refresh.enabled = false;
      wasLooping = isLooping;
      stopLooping();
      if (isOnOff) {
        for (var n:int=0; n<onOffState.length; n++) {
          onOffState[n] = 0;
        }
        drawOnOff();
      }

      if (printButt != null) printButt.enabled = false;
      if (showButt != null) showButt.enabled = false;
      currentFrame = 0;
      if (loadingHotspot || !keepZoom) {
        isZooming = false;
        if (zoom != null) zoom.label=zoomLabelTrue;
        zoomXFactor = zoomXBase;
        zoomYFactor = zoomYBase;
        xMove = 0;
        yMove = 0;
        enableZooming = activeZoom;
      }

      isDragging = false;
      if (isDrawingLine) drawingPaper.graphics.clear();
      isDrawingLine = false;
      incFrame = 1;
      numFrames = 0;
      getImageFilenames();
    }
    
/** getParameter(String)
*
* get the (array of) values for the named parameter
*/
    private function getParameter(s:String):Array {
      for (var m:int=0; m<paramNames.length; m++) {
        if (paramNames[m] == s) {
          return paramValues[m];
        }
      }
      return null;
    }



/** stopLooping()
*
* stop the looping and reset the button labels
*/
    private function stopLooping():void {
      // stop the looping
      //timer.stop();
      if (startstop != null) startstop.label=startstopLabelFalse;
      if (printButt != null) printButt.enabled = true;
      if (showButt != null) showButt.enabled = true;
      isLooping = false;
    }



/** startLooping()
*
* reset the button labels and activate looping mode
*/
    private function startLooping(): void {
      //timer.start();
      if (startstop != null) startstop.label=startstopLabelTrue;
      if (printButt != null) printButt.enabled = false;
      if (showButt != null) showButt.enabled = false;
      isLooping = true;
    }



/** parseHex(String)
*
* parse the hex value that starts with 0x, 0X, or # (or anything
* else, actually) are retunr an int
*/
    private function parseHex(v:String):int {
      if (startsWith(v,"0x") || startsWith(v,"0X") ) {
        return parseInt(v);
        
      } else {
        return parseInt(v.substring(1),16);
      }
    }



/** getFirstChar(String)
*
* simply returns the first character of a String
*/
    private function getFirstChar(s:String):String {
      return (StringUtil.trim(s).charAt(0) );
    }

/** startsWith(String, String)
*
* tests if the given String begins with the match string
*
*/
    private function startsWith(s:String, match:String):Boolean {
      return !StringUtil.trim(s).indexOf(match);
    }


/** endsWith(String, String)
*
* tests if the given String ends with the match string
*
*/
    private function endsWith(s:String, match:String):Boolean {

      return ( (StringUtil.trim(s).lastIndexOf(match) > 0) && 
         (StringUtil.trim(s).lastIndexOf(match) == (StringUtil.trim(s).length - match.length)));
    }




/** getNamesUsingBaseName(String, int)
*
* from this wild-carded list of basenames, this creates actual file
* names by replacing the * or ? with monotonically increasing numbers.
*
*/
    private function getNamesUsingBaseName(fn:String, count:int): Array {
      var filenames:Array = new Array(count);
      for (var i:int=0; i<count; i++) {
        var val:int = i+baseNumber;
        if (fn.indexOf("*") >= 0) {
          filenames[i] = fn.replace("*",String(val));


        } else if (fn.indexOf("?") > 0) {
          var substitute:String = fn;
          var li:int;
          while ( (li=substitute.lastIndexOf("?")) >= 0) {
            var ts:String = substitute.substring(0,li)+(val % 10) + substitute.substring(li+1);
            substitute = ts;
            val = val /10;
          }
          filenames[i] = substitute;

        } else {
          filenames[i] = fn+i;
        }

      }
      return filenames;
    }



/** doneGettingEnhTab(Event)
*
* This event handler is called when the file (enh.tab) containing the
* enhancement tables is read.  It parses this file and populates
* the Combobox list as well as creating the RGB look-up tables.
*
*/

    private function doneGettingEnhTab(event:Event) : void {
      var fne:URLLoader = URLLoader(event.target);
      var lines:Array = fne.data.split("\n");
      var stuff:Array = new Array();
      var m:int;
      var ienh:int = -1;
      enh = new Array();
      enhNames = new Array();
      var re:RegExp = / +/;
      debug("Done loading enh table....");

      for (var i:int=0; i<lines.length; i++) {
        //trace("i = "+i+": "+lines[i]);

        if (lines[i].length < 2) continue;
        m = StringUtil.trim(lines[i]).indexOf("#");
        if (m == 0) continue;
        if (m > 0) lines[i] = lines[i].substring(0,m);

        if (startsWith(lines[i],"*")) {
          ienh = ienh + 1;
          enh[ienh] = new Array(3);
          enhNames[ienh] = StringUtil.trim(lines[i].substring(1));
          for (var k:int=0; k<3; k++) {
            enh[ienh][k] = new Array(256);
            for (var n:int=0; n<256; n++) {
              enh[ienh][k][n] = n;
            }
          }

        } else {
          var vx:Array = lines[i].split(re);
          var a:Array = new Array();
          for (k=0; k<vx.length; k++) {
            a[k] = parseInt(StringUtil.trim(vx[k]));
          }
          var num:int = a[1] - a[0];
          //trace("num = "+num);
          var bred:Number = a[2];
          var ered:Number = a[3];
          var redinc:Number = (ered - bred)/(num);
          var bgreen:Number = a[4];
          var egreen:Number = a[5];
          var greeninc:Number = (egreen - bgreen)/(num);
          var bblue:Number = a[6];
          var eblue:Number = a[7];
          var blueinc:Number = (eblue - bblue)/(num);
          for (k = a[0]; k<=a[1]; k++) {
            enh[ienh][0][k] = int(Math.round(bred)) << 16;
            enh[ienh][1][k] = int(Math.round(bgreen)) << 8;
            enh[ienh][2][k] = int(Math.round(bblue));
            bred = bred + redinc;
            bgreen = bgreen + greeninc;
            bblue = bblue + blueinc;
          }

        }

      }

      getImageFilenames();
    }

/** makeCoordinates(Array)
*
* create the location array of lat,lon values for image corner points
*
*/
    private function makeCoordinates(s:Array) : void {
      if (s != null) {
        if (s.length != 4) {
          debug("******** navigation -- incorrect number of parameters!");
          location = null;
        } else {
          location = new Array(s.length);
          for (var i:int = 0; i<s.length; i++) {
            location[i] = parseFloat(s[i]);
          }
          isLoc = true;
          doingLoc = true;
          locLabel = new Label();
          locLabelDigits = 2;
          locLabelFirst="Lat=";
          locLabelSecond="Lon=";

          var ls:Array = getParameter("coordinates_style");
          if (ls != null) {
            locLabel.opaqueBackground = parseInt(ls[0] );
            locLabel.setStyle("color", parseInt(ls[1]) );
            if (ls.length > 2) {
              if (ls[2].length > 0)  
                       locLabel.setStyle("fontSize", parseInt(ls[2]) );
              if (ls.length > 3) {
                locLabelFirst = ls[3];
                locLabelSecond = ls[4];
                if (ls.length > 5) locLabelDigits = parseInt(ls[5]);
              }
            }
          } else {
            locLabel.opaqueBackground = background;
            locLabel.setStyle("color", foreground);
          }
          locLabel.x = 0;
          locLabel.y = 0;
          locLabel.visible = true;
          //trace("location = "+location);
        }
      }
    }


/** makeHotspot(String[])
*
* make a hotspot and add to list
*
* hsButton, hsType, hsValue are all defined prior to calling this!!
*
* hotspot = x,y, w, h, pan, type, value
* hotspot = x,y,icon,filename, pan, type, value [,tooltip]
*/

    private function makeHotspot(s:Array) : void {
      //trace("making Hotspot out of this: "+s);
      hsPan.push(StringUtil.trim(s[4]));
      hsType.push(StringUtil.trim(s[5]));
      hsValue.push(StringUtil.trim(s[6]));

      var hsb:SimpleButton;
      if (StringUtil.trim(s[2]).toLowerCase() == "icon") {
        var gotit:Boolean = false;
       // trace(".....making image hotspot....");
        for (var i:int = 0; i<hsImageNames.length; i++) {
          if (StringUtil.trim(s[3]) == hsImageNames[i]) {
            gotit = true;
           // trace("found hs image match for hs = "+i);
            hsb = new SimpleButton(hsBitmaps[i], hsBitmaps[i],
                       hsBitmaps[i], hsBitmaps[i]);
          }
        }

        if (!gotit) {
          debug("no icon match for "+s[3]);
          hsImageNames.push(StringUtil.trim(s[3]));
          hsBitmaps.push(new Bitmap());
          hsb =new SimpleButton( hsBitmaps[hsBitmaps.length-1],
                   hsBitmaps[hsBitmaps.length-1], 
                   hsBitmaps[hsBitmaps.length-1],
                   hsBitmaps[hsBitmaps.length-1]);

          hsLoaders.push(new Loader());
          hsLoaderInfo.push(hsLoaders[hsLoaders.length-1].contentLoaderInfo);

          hsLoaderInfo[hsLoaderInfo.length-1].addEventListener(Event.COMPLETE, 
            function(e:Event):void {
             // trace("looking for hs.....");
              for (var ii:int=0; ii<hsLoaders.length; ii++) {
                if (e.target.loader == hsLoaders[ii]) {
                  hsBitmaps[ii].bitmapData = e.target.content.bitmapData;
                 // trace("found hs for ii = "+ii);
                }
              }
            }
          );

          hsLoaderInfo[hsLoaderInfo.length-1].addEventListener(
                                               IOErrorEvent.IO_ERROR, 
            function(e:Event):void {
              debug("Error loading icon image");
            }
          );
           
          try {
            hsLoaders[hsLoaders.length-1].load(
                 new URLRequest(hsImageNames[hsImageNames.length-1]));
          } catch (ice:Error) {
            debug("Unable to load icon image..."+ice);
          }

        }

      } else {
       // trace("making internal hotspot.......");
        var hsw:int = parseInt(s[2]);
        var hsh:int = parseInt(s[3]);
        var hsbmd:BitmapData = new BitmapData(hsw, hsh,true,hsColor);
        var hsbm:Bitmap = new Bitmap(hsbmd);
        hsb = new SimpleButton(hsbm,hsbm,hsbm,hsbm);
      }

      hsb.useHandCursor = true;
      hsUI = new UIComponent();
      hsUI.addChild(hsb);
      hsUI.x = parseInt(s[0]);
      hsUI.y = parseInt(s[1]);
      hsUI.addEventListener(MouseEvent.CLICK, bclick);
      if (s.length == 8) hsUI.toolTip = StringUtil.trim(s[7]);
      hsButton.push(hsUI);
      var hsp:Point =new Point(hsUI.x, hsUI.y);
      hsPoint.push(hsp);
     // trace("added hs = "+s);
    }


/** makeBackHotspot(String[])
*
* make a background_image hotspot and add to list
*
* hsButton, hsType, hsValue are all defined prior to calling this!!
*
* hotspot = x,y, w, h, type, value
* hotspot = x,y,image,filename, type, value
*/

    private function makeBackHotspot(s:Array) : void {
     // trace("making background Hotspot out of this: "+s);
      backhsType.push(StringUtil.trim(s[4]));
      backhsValue.push(StringUtil.trim(s[5]));
      var hsw:int = parseInt(s[2]);
      var hsh:int = parseInt(s[3]);
      var hsbmd:BitmapData = new BitmapData(hsw, hsh,true,hsColor);
      var hsbm:Bitmap = new Bitmap(hsbmd);
      var hsb:SimpleButton = new SimpleButton(hsbm,hsbm,hsbm,hsbm);
      hsb.x = parseInt(s[0]);
      hsb.y = parseInt(s[1]);
      hsb.useHandCursor = true;
      hsb.addEventListener(MouseEvent.CLICK, bclick);
      backhsButton.push(hsb);
     // trace("added back_hs = "+s);
    }


/** changeEnh(Event)
*
* When the user selects an ehnacmenet from the list this
* sets the selected palette into the sequence of bitmaps.
*
* Note that the first time, a backup set of bitmaps are cloned
* from the originals...
*
*/
    private function changeEnh(e:Event):void {
      if (e.target == enhanceChoice) {
        var sel:int = enhanceChoice.selectedIndex - 1;
        //trace("selected = "+sel);

        if (!madeEnhBitmaps) {
          enhBitmaps = new Array();
          for (var ie:int = 0; ie<imgList[enhOverlay].length; ie++) {
            enhBitmaps[ie] = imgList[enhOverlay][ie].clone();
          }

        }
        madeEnhBitmaps = true;

        if (sel < 0) {
          for (ie = 0; ie<imgList[enhOverlay].length; ie++) {
            imgList[enhOverlay][ie] = enhBitmaps[ie].clone();
          }

        } else {

          for (ie = 0; ie<imgList[enhOverlay].length; ie++ ) {
            imgList[enhOverlay][ie].paletteMap(enhBitmaps[ie], imgRect, 
                         upperLeft, enh[sel][0], enh[sel][1], enh[sel][2]);
          }
        }

        showFrames(null);
      }
    }

/** debug(String)
*
* append the string onto the debugTextArea.text preceded by "\n"
*
* also, trace the string
*/
   private function debug(s:String):void {
     if (isDebug) {
       debugTextArea.text = debugTextArea.text + "\n"+s;
     }

     trace(s);
   }


  }

}

