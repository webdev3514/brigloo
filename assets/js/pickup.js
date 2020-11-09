(function ($) {
    
    set_events_recurring();
    var edit_recurring = '';
    function set_events_recurring() {
        set_edit_recurring_events();
        set_delete_recurring_events();
    }
    
    var frm_change_order_request_days = $( "#frm_change_order_request_days" ).validate({
        onsubmit: true,
        rules: {
            ch_from: {
                required: true
            },
            txt_driver_name1: {
                required: true
            },
            ch_to: {
                required: true
            },
            ch_delivery_time: {
                required: true,
            }
        },
    });
    
    $( document ).on( 'change', '#ch_from', function () {
        var ch_form = $( this ).val();
        var z;
        var selectobject = $( "#ch_to" ).find( "option" );
        for(z=0;z<selectobject.length;z++){
            selectobject[z].disabled=false;
        }
        selectobject[ch_form-1].disabled = true;
        $('#ch_to').selectpicker('render');
    });
    
    $( document ).on( 'change', '#ch_to', function () {
        var ch_form = $( this ).val();
        var z;
        var selectobject = $( "#ch_from" ).find( "option" );
        for( z=0;z<selectobject.length;z++ ){
            selectobject[z].disabled=false;
        }
        selectobject[ch_form-1].disabled = true;
        $( '#ch_from' ).selectpicker( 'render' );
    });
    
    $( document ).on( 'submit', '#frm_change_order_request_days', function ( e ) {
        e.preventDefault();
        var str = '&action=change_order_request_days';
        var bo_id = $( "#txt_bo_id" ).val();
        if( bo_id =='' ){
            $( ".pickup-failed").find(".pickup-msg").html("<strong>No Business owner avaiable</strong>");
            $( ".pickup-success").hide();
            close_notification(".pickup-failed");
        }else{
            show_loader();
            setTimeout(function(){ 
                $.ajax({
                    type:       "POST",
                    dataType:   "html",
                    url:        USER_AJAX_URL,
                    data:       $( "#frm_change_order_request_days" ).serialize() + str,
                    async:      false,
                    success:    function ( data ) {
                        console.log( data );
                        var decode_data = JSON.parse( data );
                        if( decode_data['success_flag'] == true ){
                            hide_loader();
                            swal( "" , decode_data['message'], "success" );
                        } else {
                            hide_loader();
                            swal( "" , decode_data['message'], "warning" );
                        }
                    },
                    error: function ( jqXHR, textStatus, errorThrown ) {
                        console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                    }
                });
            }, 1000);
        }
        return false;
    });
    
    function set_edit_recurring_events() {
        $( ".edit_recurring" ).unbind( 'click' );
        $( document ).on( 'click', '.edit_recurring', function ( e ) {    
            var recurring_id = $( this ).data( 'recurring_id' );
            $( "#pickup_monthly_recurring_date" ).val('');
            
            get_recurring( recurring_id );
            var recurring = JSON.parse( edit_recurring );
            $( "#hdn_recurring_id" ).val( recurring_id );
            $( "#pickup_amt" ).val( recurring['data'].fl_amount );
            if( recurring['data'].st_recurring_type == "weekly" ){
                $( ".weekly_recurring_chk" ).prop("checked",true);
                $( ".weekly_recurring" ).show();
                $( 'select[name=location]' ).val( recurring['data'].in_location_id );
                $( 'select[name=pickup_weekly_recurring_date]' ).val( recurring['data'].st_recurring_date );
                $( '.select' ).selectpicker( 'refresh' );
                $( "#ch_delivery_time" ).val( recurring['data'].st_recurring_date );
                $( ".monthly_recurring" ).hide();
            }else{
                $( ".monthly_recurring_chk" ).prop("checked",true);
                $( 'select[name=location]' ).val( recurring['data'].in_location_id );
                $( '.select' ).selectpicker( 'refresh' );
                $( "#pickup_monthly_recurring_date" ).val( recurring['data'].st_recurring_date );
                $( ".monthly_recurring" ).show();
                $( ".weekly_recurring" ).hide();
            }
            
            $( "#frm_edit_pickup" ).slideDown();
            return false;
        });
    }
    
    var frm_edit_pickup = $( "#frm_edit_pickup" ).validate({
        onsubmit: true,
        rules: {
            pickup_location: {
                required: true
            },
            recurring_type: {
                required: true
            },
        },
    });
    
    $( document ).on( 'submit', '#frm_edit_pickup', function ( e ) {
        e.preventDefault();
        var str = '&action=edit_recurring';
        show_loader();
        setTimeout( function(){ 
        $.ajax({
            type:       "POST",
            dataType:   "html",
            url:        USER_AJAX_URL,
            data:       $( "#frm_edit_pickup" ).serialize()  + str,
            async:      false,
            success:    function ( data ) {
                console.log( data );
                var decode_data = JSON.parse(data);
                if ( decode_data['success_flag'] == true ) {
                    hide_loader();
                    $( ".recurring_" + decode_data['data'].in_recurring_id ).replaceWith( 
                        '<tr class="recurring_' + decode_data['data'].in_recurring_id + '">' +
                            '<td>' +
                                '<div class="button-wrap">' +
                                    '<button  class="btn btn-danger edit_recurring" data-recurring_id="' + decode_data['data'].in_recurring_id    + '"><i class="fa fa-pencil "></i></button>' +
                                    '<button  class="btn btn-danger cancel_recurring" data-recurring_id="' + decode_data['data'].in_recurring_id    + '"><i class="fa fa-close "></i></button>' +
                                '</div>' +
                            '</td>' +
                            '<td>' + decode_data['data'].in_recurring_id    + '</td>' +
                            '<td>' + decode_data['data'].dt_created_at    + '</td>' +
                            '<td>' + decode_data['data'].recurring_date       + '</td>' +
                            '<td>' + decode_data['data'].location_name  + '</td>' +
                            '<td>' + cutString( decode_data['data'].location_address )  + '</td>' +
                            '<td>' + decode_data['data'].recurring_type  + '</td>' +
                            '<td>' + decode_data['data'].recurring_amt  + '</td>' +
                            '<td>' + decode_data['data'].user_name  + '</td>' +
                        '</tr>'
                        );
                $( "#frm_edit_pickup" ).slideUp();
                } else {
                    hide_loader();
                    swal( "", decode_data['message'], "warning" );
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
        }, 1000);
        return false;
    });
    
    
    $( document ).on( 'click', '.check_change_order_direct', function ( e ) {
        $.each( $( "input[name='arr_pick[]']" ), function(){            
            $( this ).prop("checked", true);
        });
    });
    
    $( document ).on( 'click', '.uncheck_change_order_direct', function ( e ) {
         $.each( $( "input[name='arr_pick[]']" ), function(){            
            $( this ).prop("checked", false);
        });
    });
    
    $( document ).on( 'click', '.arr_pickup', function ( e ) {
        var pickup_id = $( this ).data( 'id' );
        
        console.log(pickup_id);
        // $( this ).closest( '.pickup_job_list' ).find( '.pickup_date_check' ).each( function(){
        //     var current_pickup_date = $( this ).data( 'date' );
        //     var current_group_id = $( this ).data( 'group-id' );
        //     if( current_pickup_date == pickup_date ){
        //         if( group_id == current_group_id ){
        //             $( this ).siblings().find( '.arr_pickup' ).attr( 'disabled' , false );
        //         }else{
        //             $( this ).siblings().find( '.arr_pickup' ).attr( 'disabled' , true );
        //         }
        //     }else{
        //         $( this ).siblings().find( '.arr_pickup' ).attr( 'disabled' , true );
        //     }
        // });
        // var ckName = document.getElementsByName( "arr_pick[]" );
        // if( $( 'input[name="arr_pick[]"]:checked' ).length == 0 ){
        //     for(  var i=0; i < ckName.length; i++ ){
        //         ckName[i].disabled = false;
        //     } 
        // }
        
     });
    
    function get_recurring( recurring_id ) {
        show_loader();
        var str = 'action=get_recurring_by_id&recurring_id=' + recurring_id;
        $.ajax({
            type: "POST",
            dataType: "html",
            url: USER_AJAX_URL,
            data: str,
            success: function (data) {
                
                edit_recurring = data;
                hide_loader();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                hide_loader();
            }
        });
    }
    
    function set_delete_recurring_events(){
        $( ".cancel_recurring" ).unbind( 'click' );
        $( document ).on( 'click', '.cancel_recurring', function ( e ) {
            var recurring_id = $( this ).data( 'recurring_id' );
            swal({
                title: "",
                text: "Are you sure you want to delete this location?",
                html: true,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "Cancel",
                closeOnConfirm: false
            },
            function( isConfirm ) {
                if ( isConfirm ) {   
                    $(".confirm").addClass('loader');
                    var str = 'action=cancel_recurring&recurring_id=' + recurring_id ;
                    show_loader();
                    setTimeout(function(){ 
                        $.ajax({
                            type:       "POST",
                            dataType:   "html",
                            url:        USER_AJAX_URL,
                            data:       str,
                            async:      false,
                            success:    function ( data ) {
                                console.log(data);
                                var decode_data = JSON.parse( data );
                                if( decode_data['success_flag'] == true ){
                                    hide_loader();
                                    swal( "", decode_data['message'], "success" );
                                    $( ".recurring_" + recurring_id ).remove();
                                } else {
                                    hide_loader();
                                    swal( "", decode_data['message'], "warning" );
                                }
                            },
                            error: function ( jqXHR, textStatus, errorThrown ) {
                                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                            }
                        });
                    }, 1000);
                    return false;
                }
            });
        }); 
    }
    
    $( document ).on( 'click', '.start_job', function ( e ) {
        var job_id = $( this ).data( 'job_id' );
        
        var str = 'action=add_job_start&job_id=' + job_id ;
        show_loader();
        setTimeout(function(){ 
            $.ajax({
                type:       "POST",
                dataType:   "html",
                url:        USER_AJAX_URL,
                data:       str,
                async:      false,
                success:    function ( data ) {
                    console.log(data);
                    var decode_data = JSON.parse( data );
                    if( decode_data['success_flag'] == true ){
                        if( decode_data['location'] != "" ){
                            window.open(
                                decode_data['location'],
                                '_blank' 
                            );
                        }
                        redirect_to_URL( decode_data['redirect'] );
                    } else {
                        swal( "", decode_data['message'], "warning" );
                    }

                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                }
            });
        }, 1000);
        return false;
    }); 
    
    $( document ).on( 'click', '.accept_job', function ( e ) {
        var job_id = $( this ).data( 'job_id' );
        swal({
            title: "",
            text: "Are you sure you want to pick up this request?",
            html: true,
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            closeOnConfirm: true
        },
        function( isConfirm ) {
            if ( isConfirm ) {   
                $(".confirm").addClass('loader');
                var str = 'action=driver_assign_job&job_id=' + job_id ;
                show_loader();
                setTimeout(function(){ 
                    $.ajax({
                        type:       "POST",
                        dataType:   "html",
                        url:        USER_AJAX_URL,
                        data:       str,
                        async:      false,
                        success:    function ( data ) {
                            console.log(data);
                            var decode_data = JSON.parse( data );
                            if( decode_data['success_flag'] == true ){
                                hide_loader();
                                $( ".pending_job_" + job_id ).remove();
                            } else {
                                hide_loader();
                                swal("", decode_data['message'], "warning");
                            }

                        },
                        error: function ( jqXHR, textStatus, errorThrown ) {
                            console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                        }
                    });
                }, 1000);
                return false;
            }
        });
    }); 
    
    $( document ).on( 'click', '#navigate_mid_point', function ( e ) {
        var mid_type = $( "#mid_type" ).val();
        var info = $( "#change_status_popup" ).val();
        var st_status = $( "#st_status" ).val();
        var job_id = $( this ).data( 'job-id' );
        swal({
            title: "",
            text: "You appear to be far from the bank location. Confirm arrival",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            closeOnConfirm: false
        },
        function( isConfirm ) {
            if ( isConfirm  ) {
                swal({
                    title: "",
                    text: info,
                    type: "warning",
                    showCancelButton: true,
                    className: "loader",
                    confirmButtonClass: "btn-warning",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },
                function( isConfirm ) {
                    if ( isConfirm ) {   
                        $( ".confirm" ).addClass( 'loader' );
                        var str = 'action=driver_mid_point_status&job_id=' + job_id + '&mid_type=' + mid_type ;
                        show_loader();
                        setTimeout(function(){ 
                            $.ajax({
                                type:       "POST",
                                dataType:   "html",
                                url:        USER_AJAX_URL,
                                data:       str,
                                async:      false,
                                success:    function ( data ) {
                                    console.log(data);
                                    var decode_data = JSON.parse( data );
                                    if( decode_data['success_flag'] == true ){
                                        
                                        hide_loader();
                                        if( st_status == "start" && decode_data['location'] != "" ){
                                            window.open(
                                                decode_data['location'],
                                                '_blank' 
                                            );
                                        }
                                        location.reload();
                                        
                                    } else {
                                        hide_loader();
                                        swal( "", decode_data['message'], "warning");
                                    }
        
                                },
                                error: function ( jqXHR, textStatus, errorThrown ) {
                                    console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                                }
                            });
                        }, 1000);
                        return false;
                    }
                });
            }
        });
        return false;
    });  
    
     $( document ).on( 'click', '.delivery_change_order_direct', function ( e ) {
         
        var arr_pick = [];
        $.each( $( "input[name='arr_pick[]']:checked" ), function(){            
            arr_pick.push( $(this).val() );
        });
        var arr_pick1 = arr_pick;
        arr_pick = arr_pick.join(", ");
        var arr_pick = arr_pick.split(",").map(Number);
        var pickup_id = arr_pick1;
        if( pickup_id != "" ){
            swal({
                title: "",
                text:  '<div class=" col-md-12 form-group monthly_recurring">' +                                        
                        '<label class="col-md-4">Pickup Date<span class="required-feild">*</span></label>' +
                        '<div class="col-md-8 calender_open">' +
                            '<div class="input-group">' +
                                '<span class="input-group-addon"><span class="fa fa-calendar"></span></span>' +
                                    '<input type="text" required="" class="form-control datepicker" id="change_order_date" name="pickup[0][pickup_monthly_recurring_date]"/>' +           
                            '</div>' +
                            '<span class="help-block"></span>' +
                        '</div>' +
                        '<div class="text-danger" id="def_error"></div>' +
                        '</div>',
                html: true,
                
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Ok",
                cancelButtonText: "Cancel",
                closeOnConfirm: false
            },
            function( isConfirm ) {
                
                var val = document.getElementById( 'change_order_date' ).value;
                if ( val == "" ) {
                    document.getElementById( "def_error" ).innerHTML = 'Please enter reason';
                    return false;
                } 
                if ( isConfirm && pickup_id != "" && val != "" ) {   
                    $( ".confirm" ).addClass( 'loader' );
                    var str = 'action=delivery_change_order_direct&pickup_id=' + pickup_id + '&pickup_date=' + val ;
                    show_loader();
                    setTimeout( function(){ 
                        $.ajax({
                            type:       "POST",
                            dataType:   "html",
                            url:        USER_AJAX_URL,
                            data:       str,
                            async:      false,
                            success:    function ( data ) {
                                console.log(data);
                                var decode_data = JSON.parse( data );
                                if( decode_data['success_flag'] == true ){
                                    hide_loader();
                                    swal( "", decode_data['message'], "success");
                                    for ( var i = 0; i < arr_pick.length; i++ ) {
                                        $( ".change_order_" + arr_pick[i] ).remove();
                                    }
                                } else {
                                    hide_loader();
                                    swal( "", decode_data['message'], "warning" );
                                }
                            },
                            error: function ( jqXHR, textStatus, errorThrown ) {
                                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                            }
                        });
                    }, 1000);
                    return false;
                }
            });
        }
          
        var date = new Date();
        date.setDate( date.getDate() );
        $( '#change_order_date' ).datepicker({  
            startDate: date,
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });   
    
    
})(jQuery);

var autocomplete;
var geocoder;
var gmarkers = [];    
function home_initialize() {
    var hdn_latitude =  $( "#hdn_home_latitude" ).val() ;
    var hdn_longitude =  $( "#hdn_home_longitude" ).val() ;
    if( hdn_latitude == "" ){
        hdn_latitude = parseFloat( '-34.397' );
    }else{
        hdn_latitude = parseFloat( hdn_latitude );
    }
    if( hdn_longitude == "" ){
        hdn_longitude = parseFloat( '150.644' );
    }else{
        hdn_longitude = parseFloat( hdn_longitude );
    }
    geocoder = new google.maps.Geocoder();
    var map = new google.maps.Map(document.getElementById('map_home_address'), {
        center: {lat: hdn_latitude, lng: hdn_longitude},
        zoom: 13
    });

    var input = document.getElementById('txt_home_address');
    var searchBox = new google.maps.places.SearchBox(input);
//            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    var marker = [];
    marker = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng(hdn_latitude,hdn_longitude)
    });
    gmarkers.push(marker);
    map.addListener('bounds_changed', function () {
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];
      var contentString = ''+ input.value +'';
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });

        // To add the marker to the map, call setMap();
        marker.setMap( map );
        searchBox.addListener( 'places_changed', function () {
        var places = searchBox.getPlaces();

        if ( places.length == 0 ) {
            return;
        }

        // Clear out the old markers.
        for (var i = 0; i < gmarkers.length; i++) {

            gmarkers[i].setMap(null);
        }
        markers = [];
        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function (place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }

            // Create a marker for each place.
            markers = new google.maps.Marker({
                map: map,
                title: place.name,
                draggable: true,
                position: place.geometry.location
            });
            gmarkers.push(markers);
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            google.maps.event.addListener(markers, 'dragend', function (e) {
                lat = this.getPosition().lat();
                lng = this.getPosition().lng();
                console.log(markers.getPosition().lat());
                var latlng = {lat: this.getPosition().lat(), lng: this.getPosition().lng()};
//                          console.log(markers);
                geocoder.geocode({'location': latlng}, function (results) {
                    console.log(results);
                    if (results[0].formatted_address) {
                        $("#txt_home_address").val(results[0].formatted_address);
                    }
                });
            });
            $('#hdn_home_latitude').val(lat);
            $('#hdn_home_longitude').val(lng);
            google.maps.event.addListener(markers, 'click', function (evt) {
                console.log();
            });
            google.maps.event.trigger( markers, 'click' );
            if ( place.geometry.viewport ) {
                // Only geocodes have viewport.
                bounds.union( place.geometry.viewport );
            } else {
                bounds.extend( place.geometry.location );
            }
        });
        map.fitBounds(bounds);
    });
    google.maps.event.addListener(map, 'bounds_changed', function () {
        var bounds = map.getBounds();
        searchBox.setBounds( bounds );
    });
} 

function warehouse_initialize() {
    var hdn_latitude =  $( "#hdn_warehouse_latitude" ).val() ;
    var hdn_longitude =  $( "#hdn_warehouse_longitude" ).val() ;
    if( hdn_latitude == "" ){
        hdn_latitude = parseFloat( '-34.397' );
    }else{
        hdn_latitude = parseFloat( hdn_latitude );
    }
    if( hdn_longitude == "" ){
        hdn_longitude = parseFloat( '150.644' );
    }else{
        hdn_longitude = parseFloat( hdn_longitude );
    }
    geocoder = new google.maps.Geocoder();
    var map = new google.maps.Map(document.getElementById('map_warehouse_address'), {
        center: {lat: hdn_latitude, lng: hdn_longitude},
        zoom: 13
    });

    var input = document.getElementById('txt_warehouse_address');
    var searchBox = new google.maps.places.SearchBox(input);
//            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    var marker = [];
    marker = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng(hdn_latitude,hdn_longitude)
    });
    gmarkers.push(marker);
    map.addListener('bounds_changed', function () {
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];
      var contentString = ''+ input.value +'';
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });

        // To add the marker to the map, call setMap();
        marker.setMap( map );
        searchBox.addListener( 'places_changed', function () {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        // Clear out the old markers.
        for (var i = 0; i < gmarkers.length; i++) {

            gmarkers[i].setMap(null);
        }
        markers = [];
        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function (place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }

            // Create a marker for each place.
            markers = new google.maps.Marker({
                map: map,
                title: place.name,
                draggable: true,
                position: place.geometry.location
            });
            gmarkers.push(markers);
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            google.maps.event.addListener(markers, 'dragend', function (e) {
                lat = this.getPosition().lat();
                lng = this.getPosition().lng();
                console.log(markers.getPosition().lat());
                var latlng = {lat: this.getPosition().lat(), lng: this.getPosition().lng()};
//                          console.log(markers);
                geocoder.geocode({'location': latlng}, function (results) {
                    console.log(results);
                    if (results[0].formatted_address) {
                        $("#txt_warehouse_address").val(results[0].formatted_address);
                    }
                });
            });
            $('#hdn_warehouse_latitude').val(lat);
            $('#hdn_warehouse_longitude').val(lng);
            google.maps.event.addListener(markers, 'click', function (evt) {
                console.log();

            });
            google.maps.event.trigger(markers, 'click');
            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });
    google.maps.event.addListener(map, 'bounds_changed', function () {
        var bounds = map.getBounds();
        searchBox.setBounds( bounds );
    });
} 