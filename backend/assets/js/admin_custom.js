(function ($) {
    $( document ).on( 'click', '.report_open', function ( e ) {
        var job_id = $( this ).data( 'job_id' );
        var  str = "action=get_job_lat_long&job_id=" + job_id;
        $.ajax({
            dataType:   "html",
            url:        USER_AJAX_URL,
            method:     "POST",
            cache:      false,
            data:       str,
            success:    function ( data ) {
                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ) {
                    initialize( job_id, decode_data['data'] );
                } else {
                    
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
        
    });
    
    var geocoder;
var map;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();


function initialize( job_id, job_route ) {
    directionsDisplay = new google.maps.DirectionsRenderer();
    var locations = [
      [-33.80010128657071, 151.28747820854187],
      [-33.890542, 151.274856],
      [-33.923036, 151.259052],
      [-33.950198, 151.259302],
      [-34.028249, 151.157507]
    ];
    var location = JSON.parse( job_route );
    var res = Object.keys(location)
        .map(function(k) {
          return [location[k]];
    });

    var map = new google.maps.Map(document.getElementById( 'map_' + job_id ), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    directionsDisplay.setMap(map);
    var infowindow = new google.maps.InfoWindow();

    var marker, i;
    var request = {
      travelMode: google.maps.TravelMode.DRIVING
    };
    for (i = 0; i < res.length; i++) {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(res[i][0].lat, res[i][0].long),
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infowindow.setContent(res[i][0].add);
            infowindow.open( map, marker );
          }
      })(marker, i));

      if (i == 0) request.origin = marker.getPosition();
      else if (i == res.length - 1) request.destination = marker.getPosition();
      else {
        if (!request.waypoints) request.waypoints = [];
        request.waypoints.push({
          location: marker.getPosition(),
          stopover: true
        });
      }

    }
    directionsService.route(request, function(result, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(result);
      }
    });
}
})(jQuery);