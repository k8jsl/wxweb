 <script type="text/javascript"
        src="http://maps.googleapis.com/maps/api/js?api={$googleapi}&amp;sensor=false"></script>
        
 <script type="text/javascript" >
 function initialize() {
  var myLatlng = new google.maps.LatLng({$lat},{$lon});
  var myOptions = { 
    zoom: 8,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.TERRAIN
  } 
  var map = new google.maps.Map(document.getElementById("forecast_map"), myOptions);
 
  var marker = new google.maps.Marker({ 
      position: myLatlng,
      map: map,
      title:"Hello World!"
  });
  
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
</script>


<div id="forecast_map"></div>