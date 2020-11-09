<!DOCTYPE html>
 
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions Service</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        #map {
          height: 100%;
        }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      
    </style>
  </head>
  <body>
     <?php 

require_once 'config/config.php';
require_once 'backend/config/admin_config.php';
?>
    <div id="floating-panel">
    <!-- <select id="start"> -->
        <input type="hidden" name="id" id="start_latlog" value="">
        <input type="hidden" name="id" id="end_latlog" value="21.170240, 72.831062">
   
    </div>
    <p id="map"></p>
    <button>Stop</button>
    <?php
        require_once FL_LOGIN_FOOTER_INCLUDE;
//  ?>
    <!--<script src="http://maps.google.com/maps/api/js?sensor=true"></script>-->

    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyCMH2G4lznu8c0A5PRHfScM_pVq_py0Mfo"></script>

    <script>
    var watchID = null;
        $(document).ready(function(){
            var optn = {
                enableHighAccuracy: true,
                timeout: Infinity,
                maximumAge: 0	
            };
            if( navigator.geolocation )
                navigator.geolocation.watchPosition(success, fail, optn);
            else
                $("p").html("HTML5 Not Supported");
            $("button").click(function(){

                if(watchID)
                 navigator.geolocation.clearWatch(watchID);

                watchID = null;
                return false;
            });
        });

        function success(position)
        {
            var googleLatLng = new google.maps.LatLng(position.coords.latitude, 
                                                    position.coords.longitude);


            map = new google.maps.Map( document.getElementById( 'map' ), {
                zoom: 7,
                center: { lat: 41.85, lng: -87.65 }
            });
            var end_point =  $( '#end_latlog' ).val();
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            directionsDisplay.setMap( map );
            directionsService.route({
                origin: googleLatLng,
                destination: end_point,
                travelMode: 'DRIVING'
            }, function( response, status ) {
                if ( status === 'OK' ) {
                    directionsDisplay.setDirections( response );
                } else {
                    window.alert( 'Directions request failed due to ' + status );
                }
            });                                          
        
//                var mapOtn={
//                    zoom:10,
//                    center:googleLatLng,
//                    mapTypeId:google.maps.MapTypeId.ROAD
//                };
//
//                var Pmap=document.getElementById("map");
//
//                var map=new google.maps.Map(Pmap, mapOtn);
//                addMarker(map, googleLatLng, "Technotip.com", 
//                          "SATISH B<br /><b>About Me:</b>http://technotip.com/about/");
        }

        function addMarker(map, googleLatLng, title, content){
                var markerOptn={
                    position:googleLatLng,
                    map:map,
                    title:title,
                    animation:google.maps.Animation.DROP
                };

                var marker=new google.maps.Marker(markerOptn);

                var infoWindow=new google.maps.InfoWindow({ content: content, 
                                                               position: googleLatLng});
            google.maps.event.addListener(marker, "click", function(){
                        infoWindow.open(map);
                });												   
        }

        function fail(error)
        {
                var errorType={
        0:"Unknown Error",
        1:"Permission denied by the user",
        2:"Position of the user not available",
        3:"Request timed out"
                };

                var errMsg = errorType[error.code];

                if(error.code == 0 || error.code == 2){
                        errMsg = errMsg+" - "+error.message;
                }

                $("p").html(errMsg);
        }
        
        
    google.maps.event.addDomListener(window, 'load', initMap);
    var map;
    var geocoder;
    function initMap() {

        geocoder = new google.maps.Geocoder();
        
        if ( navigator.geolocation ) {
            navigator.geolocation.getCurrentPosition(function ( position ) {
//                var pos = {
//                    lat: position.coords.latitude,
//                    lng: position.coords.longitude
//                };
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                
                
                var directionsService = new google.maps.DirectionsService;
                var directionsDisplay = new google.maps.DirectionsRenderer;
                $( '#start_latlog' ).val( lat + ',' + lng );
                var start_point =  $( '#start_latlog' ).val();
                var end_point =  $( '#end_latlog' ).val();
                map = new google.maps.Map( document.getElementById( 'location' ), {
                    zoom: 7,
                    center: { lat: 41.85, lng: -87.65 }
                });
                
                directionsDisplay.setMap( map );
                directionsService.route({
                    origin: start_point,
                    destination: end_point,
                    travelMode: 'DRIVING'
                }, function( response, status ) {
                    if ( status === 'OK' ) {
                        directionsDisplay.setDirections( response );
                    } else {
                        window.alert( 'Directions request failed due to ' + status );
                    }
                });
                
            }, function () {
//                 alert();
//            localStorage.setItem('display_radius', false);
            });
        }
        
    }
     
      //FOR ADD MA

    </script>
  </body>
</html>

















