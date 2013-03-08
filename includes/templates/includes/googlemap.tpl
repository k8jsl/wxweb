


<div id="google-wrap">
If your browser supports Geolocation,<br />
it should center on your location<br />
Click the area for your forecast
<script type="text/javascript"
        src="http://maps.googleapis.com/maps/api/js?api={$googleapi}&amp;sensor=true"></script>




<script type="text/javascript">
{literal}
var initialLocation;

var newyork = new google.maps.LatLng(34.10, -94.58);
var browserSupportFlag =  new Boolean();

function initialize() {
  var myOptions = {
    zoom: 8,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  
  // Try W3C Geolocation (Preferred)
  if(navigator.geolocation) {
    browserSupportFlag = true;
    navigator.geolocation.getCurrentPosition(function(position) {
      initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
      map.setCenter(initialLocation);
    }, function() {
      handleNoGeolocation(browserSupportFlag);
    });
  // Try Google Gears Geolocation
  
  } else {
    browserSupportFlag = false;
    handleNoGeolocation(browserSupportFlag);
  }
  
  function handleNoGeolocation(errorFlag) {
    if (errorFlag == true) {
      alert("Geolocation service failed.");
      initialLocation = newyork;
    } else {
      alert("Geolocation Failed");
      initialLocation = newyork;
    }
    map.setCenter(initialLocation);
  }
  
     google.maps.event.addListener(map, 'click', function(event)  {  
    var myLatLng = event.latLng;
    var lat = myLatLng.lat();
    var lng = myLatLng.lng();
     link(lat, lng); });
     
     function link(lat,lon){
     window.location="http://www.michiganwxsystem.com/wxweb.php?run=quikcast&lat=" +lat+ "&lon=" +lon ;
      }
}
 google.maps.event.addDomListener(window, 'load', initialize);
{/literal}
</script>
    <div id="map_canvas"></div>

 </div>
