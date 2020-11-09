(function ($) {
    var curr_include_add_item = 1;
    var curr_include_co_item = 1;
    var total_cost = 0;
    var autocomplete;
    var geocoder;
    var gmarkers = [];

    function initialize() {
        var hdn_latitude =  $( "#hdn_latitude" ).val() ;
        var hdn_longitude =  $( "#hdn_longitude" ).val() ;
        if( hdn_latitude == "" ) {
            hdn_latitude = parseFloat( '-34.397' );
        }else{
            hdn_latitude = parseFloat( hdn_latitude );
        }
        if( hdn_longitude == "" ) {
            hdn_longitude = parseFloat( '150.644' );
        }else{
            hdn_longitude = parseFloat( hdn_longitude );
        }
        geocoder = new google.maps.Geocoder();
        var map = new google.maps.Map(document.getElementById('location'), {
            center: {lat: hdn_latitude, lng: hdn_longitude},
            zoom: 13
        });

        var input = document.getElementById( 'txt_address' );
        var searchBox = new google.maps.places.SearchBox( input );
        var marker = [];
        marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng( hdn_latitude,hdn_longitude )
        });
        gmarkers.push( marker );
        map.addListener( 'bounds_changed', function () {
            searchBox.setBounds(map.getBounds());
        });

        var markers = [];
          var contentString = ''+ input.value +'';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            google.maps.event.addListener( marker, 'click', function() {
                infowindow.open( map,marker );
            });

            // To add the marker to the map, call setMap();
            marker.setMap(map);
            searchBox.addListener( 'places_changed', function () {
            var places = searchBox.getPlaces();

            if ( places.length == 0 ) {
                return;
            }

            // Clear out the old markers.
            for ( var i = 0; i < gmarkers.length; i++ ) {
                gmarkers[i].setMap(null);
            }
            markers = [];
            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach( function ( place ) {
                if ( !place.geometry ) {
                    console.log( "Returned place contains no geometry" );
                    return;
                }

                // Create a marker for each place.
                markers = new google.maps.Marker({
                    map: map,
                    title: place.name,
                    draggable: true,
                    position: place.geometry.location
                });
                gmarkers.push( markers );
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();
                google.maps.event.addListener( markers, 'dragend', function (e) {
                    lat = this.getPosition().lat();
                    lng = this.getPosition().lng();
                    var latlng = {lat: this.getPosition().lat(), lng: this.getPosition().lng()};
                    geocoder.geocode( {'location': latlng}, function ( results ) {
                        if ( results[0].formatted_address ) {
                            $( "#txt_address" ).val( results[0].formatted_address );
                        }
                    });
                });
                $( '#hdn_latitude' ).val( lat );
                $( '#hdn_longitude' ).val( lng );
                google.maps.event.addListener( markers, 'click', function (evt) {
                });
                google.maps.event.trigger( markers, 'click' );
                if ( place.geometry.viewport ) {
                    bounds.union( place.geometry.viewport );
                } else {
                    bounds.extend( place.geometry.location );
                }
            });
            map.fitBounds( bounds );
        });
        google.maps.event.addListener( map, 'bounds_changed', function () {
            var bounds = map.getBounds();
            searchBox.setBounds( bounds );
        });
    }
    
    function initialize_location() {
        var hdn_latitude =  $( "#hdn_co_latitude" ).val() ;
        var hdn_longitude =  $( "#hdn_co_longitude" ).val() ;
        if( hdn_latitude == "" ) {
            hdn_latitude = parseFloat( '-34.397' );
        }else{
            hdn_latitude = parseFloat( hdn_latitude );
        }
        if( hdn_longitude == "" ) {
            hdn_longitude = parseFloat( '150.644' );
        }else{
            hdn_longitude = parseFloat( hdn_longitude );
        }
        geocoder = new google.maps.Geocoder();
        var map = new google.maps.Map( document.getElementById('location_co'), {
            center: {lat: hdn_latitude, lng: hdn_longitude},
            zoom: 13
        });

        var input = document.getElementById( 'txt_co_address' );
        var searchBox = new google.maps.places.SearchBox( input );
//            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        var marker = [];
        marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng( hdn_latitude,hdn_longitude)
        });
        gmarkers.push(marker);
        map.addListener( 'bounds_changed', function () {
            searchBox.setBounds( map.getBounds() );
        });

        var markers = [];
          var contentString = ''+ input.value +'';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
              google.maps.event.addListener( marker, 'click', function() {
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
            for ( var i = 0; i < gmarkers.length; i++ ) {
                gmarkers[i].setMap( null );
            }
            markers = [];
            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach( function ( place ) {
                if ( !place.geometry ) {
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
                gmarkers.push( markers );
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();
                google.maps.event.addListener( markers, 'dragend', function (e) {
                    lat = this.getPosition().lat();
                    lng = this.getPosition().lng();
                    var latlng = {lat: this.getPosition().lat(), lng: this.getPosition().lng()};
                    geocoder.geocode({'location': latlng}, function (results) {
                        if (results[0].formatted_address) {
                            $("#txt_co_address").val(results[0].formatted_address);
                        }
                    });
                });
                $( '#hdn_co_latitude' ).val( lat );
                $( '#hdn_co_longitude' ).val( lng );
                google.maps.event.addListener( markers, 'click', function (evt) {
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
            map.fitBounds( bounds );
        });
        google.maps.event.addListener( map, 'bounds_changed', function () {
            var bounds = map.getBounds();
            searchBox.setBounds( bounds );
        });
    }
        
    var location_mode = 'new';   
    var edit_location = '';
    set_events_location();
    
    function set_events_location() {
        set_edit_location_events();
        set_location_delete_events();
        set_co_update_item_events();
        set_co_cent_update_item_events();
    }
    $( document ).on( 'click', '#add_location', function ( e ) {
        e.preventDefault();
        reset_form("frm_add_location");
        location_mode = 'new';
        $("#frm_add_location").slideToggle();
        $("#hdn_latitude").val('' );
        $("#hdn_longitude").val( '' );
        $( ".sm_section" ).hide();
        initialize();
        $("#hdn_location_action").val('add_location');
        return false;
    });
    
    //Validation Engine Add location
    var feValidation = function(){
        
        if( $( "form[id^='frm_add_location']" ).length > 0 ){

            // Validation prefix for custom form elements
            var prefix = "valPref_";

            //Add prefix to Bootstrap select plugin
            $( "form[id^='frm_add_location'] .select" ).each( function(){
               $( this ).next( "div.bootstrap-select" ).attr( "id", prefix + $( this ).attr( "id" ) ).removeClass("validate[required]");
            });

            // Validation Engine init
            $("form[id^='frm_add_location']").validationEngine('attach', {promptPosition : "bottomLeft", scroll: false});
        }
    }//END Validation Engine
    var bo_reg_validator = $( "#frm_add_location" ).validate({
        onsubmit: true,
        rules: {
            txt_email_address: {
                required: true,
                email: true
            },
            txt_pwd: {
                required: true,
                minlength: 6,
                maxlength: 16
            },
            txt_crm_pwd: {
                required: true,
                minlength: 6,
                maxlength: 16,
                equalTo: "#txt_pwd"
            }
        },
        
    });
    $( '.sm_section' ).hide();
    $( document ).on( 'click', '.single_account', function(){
        $( '.sm_section' ).hide();
        
    });
    
    $( document ).on( 'click', '.multiple_account', function(){
        $( '.sm_section' ).css( 'display' , 'block' );
    });

    $( document ).on( 'submit', '#frm_add_location', function ( e ) {
        show_loader();
        e.preventDefault();
        if( location_mode == 'new' ){
            var str = '&action=add_location';
        }else{
            var str = '&action=edit_location';
        }
        var location_name = $( "#txt_store_id" ).val();
        show_loader();
        setTimeout( function(){ 
        $.ajax({
            type:       "POST",
            dataType:   "html",
            url:        USER_AJAX_URL,
            data:       $( "#frm_add_location" ).serialize()  + str,
            async:      false,
            success:    function ( data ) {
                console.log( data );
                var decode_data = JSON.parse(data);
                if ( decode_data['success_flag'] == true ) {
                    hide_loader();
                    show_new_location( decode_data['data'] );
                    $( "#frm_add_location" ).slideUp();
                    set_edit_location_events();
                    reset_form( "frm_add_location" );
                    swal( "", decode_data['message'], "success" );
                    $( "#add_pickup_location" ).modal( 'hide' );
                    $( "#add_co_pickup_location" ).modal( 'hide' );
                    $( "#pickup_location" ).append( "<option value='" + decode_data['data'] + "' selected>" + location_name + "</option>" );
                    var pick_length = $( ".pickup_location .select" ).siblings().find("ul li").length;
                    
                    $( ".pickup_location .select" ).siblings().find( "ul li" ).removeClass( "selected" );
                    $( ".pickup_location .select" ).siblings().find( "ul" ).append( "<li rel='" + pick_length + 
                            "' class='selected'><a tabindex='0' class='' style=''><span class='text'>" + location_name + 
                            "</span><i class='glyphicon glyphicon-ok icon-ok check-mark'></i></a></option>" );
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
    
    function show_new_location ( location_id ) {
        show_loader();
        var str = '&action=get_location_by_id&location_id=' + location_id;
        $.ajax({
            type: "POST",
            dataType: "html",
            url: USER_AJAX_URL,
            data: str,
            async: false,
            success: function (data) {
                var location = JSON.parse(data);
                if ( location_mode == 'new' ) {
                    $(".location-data tbody" ).prepend( '<tr class="location_' + location.in_location_id + '">' +
                            '<td>' + location.in_location_id    + '</td>' +
                            '<td>' + location.st_store_id       + '</td>' +
                            '<td>' + location.st_store_emailid       + '</td>' +
//                            '<td>' + location.st_location_name  + '</td>' +
                            '<td>' + location.st_address        + '</td>' +
                            '<td class="edit_location" data-edit_location=' + location.in_location_id + '><i class="fa fa-edit btn btn-primary"></i></td>' +
                            '<td class="delete_location" data-delete_location=' + location.in_location_id + '><i class="fa fa-times btn btn-danger"></i></td>' +
                            '</tr>'
                            );
                } else {
                    $( ".location_" + location_id ).replaceWith( '<tr class="location_' + location + '">' +
                            '<td>' + location.in_location_id    + '</td>' +
                            '<td>' + location.st_store_id       + '</td>' +
                            '<td>' + location.st_store_emailid       + '</td>' +
//                            '<td>' + location.st_location_name  + '</td>' +
                            '<td>' + location.st_address        + '</td>' +
                            '<td class="edit_location" data-edit_location=' + location.in_location_id + '><i class="fa fa-edit btn btn-primary"></i></td>' +
                            '<td class="delete_location" data-delete_location=' + location.in_location_id + '><i class="fa fa-times btn btn-danger"></i></td>' +
                            '</tr>'
                            );

                }
                hide_loader();
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                hide_loader();
            }
        });
    }

    function set_location_delete_events() {
        $( ".delete_location" ).unbind( 'click' );
        $( document ).on( 'click', '.delete_location', function ( e ) {
            var location_id = $( this ).data( 'delete_location' );
            show_loader();
            e.preventDefault();
            swal({
                title: "",
                text: "Are you sure you want to delete location?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-warning",
                confirmButtonText: "Yes",
                closeOnConfirm: true
            },function() {
                var str = 'location_id=' + location_id + '&action=delete_location';
                setTimeout( function(){ 
                    $.ajax({
                        type:       "POST",
                        dataType:   "html",
                        url:        USER_AJAX_URL,
                        data:       str,
                        async:      false,
                        success: function ( data ) {
                            var decode_data = JSON.parse( data );
                            if ( decode_data['success_flag'] == true ) {
                                swal( "", decode_data['message'], "success" );
                                $( ".location_" + location_id ).remove();
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
            });
            hide_loader();
            return false;
        });
    }


    function set_edit_location_events() {
        $( ".edit_location" ).unbind( 'click' );
        $( document ).on( 'click', '.edit_location', function ( e ) {    
            var location_id = $( this ).data( 'edit_location' );
            get_location( location_id );
            var location = JSON.parse( edit_location );
            console.log(location);
            var location_data = {
                'hdn_location_id': location_id,
//                'txt_location_name': location.st_location_name,
                'txt_address': location.st_address,
                'hdn_latitude': location.in_latitude,
                'hdn_longitude': location.in_longitude
            };
            set_values( location_data );
            console.log(location.st_type );
            if( location.st_type  == 'multiple' ){
                $( "#txt_email_address" ).val( location.sm_email_id );
                $( "#txt_pwd" ).val( location.st_sm_password );
                $( "#txt_crm_pwd" ).val( location.st_sm_password );
                $( "#sm_id" ).val( location.in_manager_id );
                $( ".sm_section" ).show();
                $( "#single" ).prop( 'checked' , false );
                $( "#multiple" ).prop( 'checked' , true );
            }else if( location.st_type  != 'multiple' ){
                $( ".sm_section" ).hide();
                $( "#sm_id" ).val( location.in_manager_id );
                $( "#multiple" ).prop( 'checked' , false );
                $( "#single" ).prop( 'checked' , true );
                $( "#txt_email_address" ).val('');
                $( "#txt_pwd" ).val('');
                $( "#txt_crm_pwd" ).val('');
            }
            $( "#hdn_location_id" ).val( location_id );
            $( "#txt_store_id" ).val( location.st_store_id );
//            $( "#txt_location_name" ).val( location.st_location_name );
            $( "#txt_address" ).val( location.st_address );
            $( "#hdn_latitude" ).val( location.in_latitude );
            $( "#hdn_longitude" ).val( location.in_longitude );
            location_mode = 'edit';
            initialize();
            $( "#frm_add_location" ).slideDown();
            return false;
        });
    }
    
    


    function get_location( location_id ) {
        show_loader();
        var str = 'action=get_location_by_id&location_id=' + location_id;
        $.ajax({
            type: "POST",
            dataType: "html",
            url: USER_AJAX_URL,
            data: str,
            async: false,
            success: function (data) {
                edit_location = data;
                hide_loader();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                hide_loader();
            }
        });
    }
    
    $( document ).on( 'click' , '.calender_open', function (){
        $( this ).find( '.datepicker' ).datepicker("show");
    });
    
    var date = new Date();
    date.setDate( date.getDate() );
    $('.datepicker').datepicker({  
        startDate: date,
        format: 'yyyy-mm-dd',
        autoclose: true
    });
    $('.co_datepicker').datepicker({  
        startDate: date,
        format: 'yyyy-mm-dd',
        autoclose: true
    });
    $( '.select' ).selectpicker();
    $( '.select_location' ).selectpicker();
    
    var $clone =  $( '.pick-body' ).first().html();
    $( document ).on( 'click', '#add_pickup', function ( e ) {
        var html_new_item = get_new_add_item_html( $clone );
        var $new_el = $( html_new_item );
        var newattachment = $new_el.appendTo( '.pick-body' );
        $(newattachment).find('input[type=text]').val('');
        $(newattachment).find('select').val('');
        $(newattachment).find( ".recurr" ).hide();
        $(newattachment).find( ".weekly_recurring" ).hide();
        $(newattachment).find( ".monthly_recurring" ).hide();
        var date = new Date();
        date.setDate( date.getDate() );
        $new_el.find('.datepicker').datepicker({  
            startDate: date,
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        $new_el.find('.bootstrap-select' ).remove();
        $new_el.find('.select' ).selectpicker();
        curr_include_add_item++;
    });
    
    var $co_clone =  $( '.co-body' ).first().html();
//    $( document ).on( 'click', '#change_order', function ( e ) {
//        var html_new_item = get_new_cd_add_item_html( $co_clone );
//        var $new_el = $( html_new_item );
//        var newattachment = $new_el.appendTo( '.co-body' );
//        $(newattachment).find('input[type=text]').val('');
//        $(newattachment).find('select').val('');
//        var date = new Date();
//        date.setDate( date.getDate() );
//        $new_el.find('.co_datepicker').datepicker({  
//            startDate: date,
//            format: 'yyyy-mm-dd',
//            autoclose: true
//        });
//        $new_el.find('.bootstrap-select' ).remove();
//        $new_el.find('.select_location' ).selectpicker();
//        curr_include_co_item++;
//    });
    
    function set_co_update_item_events() {
        total_cost = 0;
        $( ".pickup_amt" ).unbind( 'change' );
        $( document ).on( 'change', '.pickup_amt', function () {
            set_only_digits( ".pickup_amt" );
            $( this ).closest( '.ch_amount' ).find( '.total_cost' ).html('');
            var item_price = $( this ).val();
            var update_item = $( this ).closest( '.co_calculation' );
            var update_d_item = parseFloat( update_item.find( '.change_co_amt' ).val() );
            var total = ( ( update_d_item * item_price ) );
            
            if ( isNaN( item_price ) ) {
                update_item.find( '.change_co_amt' ).val( "0.00" );
            } else {
                
            }
            
            update_item.find( '.sub_amt' ).html( '$' + total );
            update_item.find( '.sub_amoumt' ).val( total );
            total_cost = 0;
            $( this ).closest( '.ch_amount' ).find( ".sub_amoumt" ).each( function(){
                total_cost = + total_cost +  +$( this ).val() ;
            });
                
            $( this ).closest( '.ch_amount' ).find( '.sub_total_amoumt' ).val(  total_cost  );
            $( this ).closest( '.ch_amount' ).find( '.total_cost' ).html( '$' + total_cost  );
            
            var cent_amt = $( this ).closest( '.ch_amount' ).find( '.sub_cent_total_amoumt' ).val();
            if( cent_amt == undefined ){
                var conv_dollar = 0;
                var grand_total = +conv_dollar + +total_cost;
            }else{
                var conv_dollar = cent_amt / 100;
                var grand_total = +conv_dollar + +total_cost;
            }
            
            $( this ).closest( '.ch_amount' ).find( ".grand_total" ).html( '$' + grand_total  );
            $( this ).closest( '.ch_amount' ).find( ".gt_total_amoumt" ).val( grand_total  );
        });
    }
    
    function set_co_cent_update_item_events() {
        total_cost = 0;
        
        $( ".pickup_cent_amt" ).unbind( 'change' );
        $( document ).on( 'change', '.pickup_cent_amt', function () {
            set_only_digits( ".pickup_cent_amt" );
            $( this ).closest( '.ch_amount' ).find( '.total_cent_cost' ).html( '' );
            var item_price = $( this ).val();
            var update_item = $( this ).closest( '.co_cent_calculation' );
            var update_d_item =  update_item.find( '.change_co_cent_amt' ).val() ;
            var total = ( ( update_d_item * item_price ) );
            
            if ( isNaN( item_price ) ) {
                update_item.find( '.change_co_amt' ).val( "0.00" );
            } else {
                
            }
            
            update_item.find( '.sub_cent_amt' ).html( total + '¢' );
            update_item.find( '.sub_cent_amoumt' ).val( total );
            total_cost = 0;
            $( this ).closest( '.ch_amount' ).find( ".sub_cent_amoumt" ).each( function(){
                total_cost = + total_cost +  +$( this ).val() ;
            });
            $( this ).closest( '.ch_amount' ).find( '.sub_cent_total_amoumt' ).val(  total_cost  );
            $( this ).closest( '.ch_amount' ).find( '.total_cent_cost' ).html( total_cost + '¢' );
            var conv_dollar = total_cost / 100;
            
            var dollar_amt = $( this ).closest( '.ch_amount' ).find( '.sub_total_amoumt' ).val();
            if( dollar_amt == undefined ){
                dollar_amt = 0;
                var grand_total = +conv_dollar + +dollar_amt;
            }else{
                var grand_total = +conv_dollar + +dollar_amt;
            }
            
            
            $( this ).closest( '.ch_amount' ).find( ".grand_total" ).html( '$' + grand_total  );
            $( this ).closest( '.ch_amount' ).find( ".gt_total_amoumt" ).val( grand_total  );
        });
    }

    $( "#frm_edit_change_orders" ).hide();
    
    $( document ).on( 'click', '.edit_change_order', function(){
        var pickup_id = $( this ).data( 'pickup_id' );
        
        var str = 'action=edit_change_order_data&pickup_id=' + pickup_id ;
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
                        var sub_tot_50 = 50 * decode_data['data']['fl_dollar_50'];
                        var sub_tot_20 = 20 * decode_data['data']['fl_dollar_20'];
                        var sub_tot_10 = 10 * decode_data['data']['fl_dollar_10'];
                        var sub_tot_5 = 5 * decode_data['data']['fl_dollar_5'];
                        var sub_tot_1 = 1 * decode_data['data']['fl_dollar_1'];
                        var sub_tot_c_1 = 1 * decode_data['data']['ft_cent_1'] ;
                        var sub_tot_c_5 = 5 * decode_data['data']['ft_cent_5'];
                        var sub_tot_c_10 = 10 * decode_data['data']['ft_cent_10'];
                        var sub_tot_c_25 = 25 * decode_data['data']['ft_cent_25'];
                        var gt_d_tot = sub_tot_50 + sub_tot_20 + sub_tot_10 + sub_tot_5 + sub_tot_1;
                        var gt_c_tot = sub_tot_c_1 + sub_tot_c_5 + sub_tot_c_10 + sub_tot_c_25;
                        $( "#amt_d_50.pickup_amt" ).val( decode_data['data']['fl_dollar_50'] );
                        $( "#amt_d_20.pickup_amt" ).val( decode_data['data']['fl_dollar_20'] );
                        $( "#amt_d_10.pickup_amt" ).val( decode_data['data']['fl_dollar_10'] );
                        $( "#amt_d_5.pickup_amt" ).val( decode_data['data']['fl_dollar_5'] );
                        $( "#amt_d_1.pickup_amt" ).val( decode_data['data']['fl_dollar_1'] );
                        $( "#amt_c_1.pickup_cent_amt" ).val( decode_data['data']['ft_cent_1'] );
                        $( "#amt_c_5.pickup_cent_amt" ).val( decode_data['data']['ft_cent_5'] );
                        $( "#amt_c_10.pickup_cent_amt" ).val( decode_data['data']['ft_cent_10'] );
                        $( "#amt_c_25.pickup_cent_amt" ).val( decode_data['data']['ft_cent_25'] );
                        
                        // console.log( gt_d_tot );
                        // console.log( gt_c_tot );
                        $( "#amt_d_50" ).closest( '.co_calculation' ).find( '.sub_amt' ).html( sub_tot_50 );
                        $( "#amt_d_10" ).closest( '.co_calculation' ).find( '.sub_amt' ).html( sub_tot_10 );
                        $( "#amt_d_20" ).closest( '.co_calculation' ).find( '.sub_amt' ).html( sub_tot_20 );
                        $( "#amt_d_5" ).closest( '.co_calculation' ).find( '.sub_amt' ).html( sub_tot_5 );
                        $( "#amt_d_1" ).closest( '.co_calculation' ).find( '.sub_amt' ).html( sub_tot_1 );
                        $( "#amt_c_1" ).closest( '.co_cent_calculation' ).find( '.sub_cent_amt' ).html( sub_tot_c_1 );
                        $( "#amt_c_5" ).closest( '.co_cent_calculation' ).find( '.sub_cent_amt' ).html( sub_tot_c_5 );
                        $( "#amt_c_10" ).closest( '.co_cent_calculation' ).find( '.sub_cent_amt' ).html( sub_tot_c_10 );
                        $( "#amt_c_25" ).closest( '.co_cent_calculation' ).find( '.sub_cent_amt' ).html( sub_tot_c_25 );
                        
                        $( "#amt_d_50" ).closest( '.co_calculation' ).find( '.sub_amoumt' ).val( sub_tot_50 );
                        $( "#amt_d_10" ).closest( '.co_calculation' ).find( '.sub_amoumt' ).val( sub_tot_10 );
                        $( "#amt_d_20" ).closest( '.co_calculation' ).find( '.sub_amoumt' ).val( sub_tot_20 );
                        $( "#amt_d_5" ).closest( '.co_calculation' ).find( '.sub_amoumt' ).val( sub_tot_5 );
                        $( "#amt_d_1" ).closest( '.co_calculation' ).find( '.sub_amoumt' ).val( sub_tot_1 );
                        $( "#amt_c_1" ).closest( '.co_cent_calculation' ).find( '.sub_cent_amoumt' ).val( sub_tot_c_1 );
                        $( "#amt_c_5" ).closest( '.co_cent_calculation' ).find( '.sub_cent_amoumt' ).val( sub_tot_c_5 );
                        $( "#amt_c_10" ).closest( '.co_cent_calculation' ).find( '.sub_cent_amoumt' ).val( sub_tot_c_10 );
                        $( "#amt_c_25" ).closest( '.co_cent_calculation' ).find( '.sub_cent_amoumt' ).val( sub_tot_c_25 );
                        $( ".grand_total").text( decode_data['data']['fl_amount'] );
                        $( ".gt_total_amoumt").val( decode_data['data']['fl_amount'] );
                        $( ".total_cost").text( gt_d_tot );
                        $( ".total_cent_cost").text( gt_c_tot );
                        $( ".sub_total_amoumt").val( gt_d_tot );
                        $( ".sub_cent_total_amoumt").val( gt_c_tot );
                        $( "#pickup_id").val( pickup_id );
                        set_co_update_item_events();
                        $( "#frm_edit_change_orders" ).slideDown();
//                        $( ".change_order_" + pickup_id ).remove();
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

    var add_pickup_validator = $( "#frm_add_pickup" ).validate({
        onsubmit: true,
        rules: {
            pickup_location: {
                required: true
            },
            pickup_type: {
                required: true
            },
            pickup_date: {
                required: true
            }
        },
    });

    $( ".recurr" ).hide();
    $( ".weekly_recurring" ).hide();
    $( ".monthly_recurring" ).hide();
    $( document ).on( 'change', '.pickup_type', function ( e ) {
        var pickup_type = $( this ).val();
        var pickup_section = $( this ).closest( '.pickup-section' );
        if( pickup_type == "oneoff" ){
            pickup_section.find( ".on-off" ).show();
            pickup_section.find( ".recurr" ).hide();
        }else if(  pickup_type == "recurring"  ){
            pickup_section.find( ".recurr" ).show();
            pickup_section.find( ".on-off" ).hide();
            pickup_section.find( ".monthly_recurring_chk" ).removeAttr("checked");
            pickup_section.find( ".weekly_recurring" ).show();
            pickup_section.find( ".weekly_recurring_chk" ).prop( "checked",true);
            pickup_section.find( ".monthly_recurring" ).hide();
        }
    });
    
    $( document ).on( 'change', '.recurring_type', function ( e ) {
        var recurring_type = $( this ).val();
        console.log(recurring_type);
        var pickup_section = $( this ).closest( '.pickup-section' );
        if( recurring_type == "weekly" ){
            
            pickup_section.find( ".monthly_recurring_chk" ).removeAttr("checked");
            pickup_section.find( ".weekly_recurring_chk" ).attr("checked",true);
            pickup_section.find( ".weekly_recurring" ).show();
            pickup_section.find( ".monthly_recurring" ).hide();
        }else if(  recurring_type == "monthly"  ){
            pickup_section.find( ".weekly_recurring_chk" ).removeAttr("checked");
            pickup_section.find( ".monthly_recurring_chk" ).attr("checked",true);
            pickup_section.find( ".weekly_recurring" ).hide();
            pickup_section.find( ".monthly_recurring" ).show();
        }
    });
    
    $( document ).on( 'submit', '#frm_add_pickup', function ( e ) {
        e.preventDefault();
        var str = '&action=add_pickup';
        show_loader();
        setTimeout(function(){ 
            $.ajax({
                type:       "POST",
                dataType:   "html",
                url:        USER_AJAX_URL,
                data:       $( "#frm_add_pickup" ).serialize() + str,
                async:      false,
                success:    function ( data ) {
                    var decode_data = JSON.parse( data );
                    if( decode_data['success_flag'] == true ){
                        hide_loader();
                        swal({
                            title: "",
                            text: decode_data['message'],
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-warning",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false
                        },function() {
                            location.reload();
                        });
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
    });
    
    var add_change_order_validator = $( "#frm_change_orders" ).validate({
        onsubmit: true,
        rules: {
            pickup_location: {
                required: true
            },
            pickup_date: {
                required: true
            }
        },
    });
 
  
    $( document ).on( 'submit', '#frm_change_orders', function ( e ) {
        e.preventDefault();
        var check_amt = 0;
        $( '.ch_amount' ).find( ".gt_total_amoumt" ).each( function(){
            if( $( this ).val() == 0 ){
                check_amt = 1;
            }
        });
        if( check_amt == 1 ){
            swal( "", "Total amount must be greater than 0.", "warning");
            return false;
        }else{
            
        }
        var str = '&action=add_change_order';
        show_loader();
        setTimeout(function(){ 
            $.ajax({
                type:       "POST",
                dataType:   "html",
                url:        USER_AJAX_URL,
                data:       $( "#frm_change_orders" ).serialize() + str,
                async:      false,
                success:    function ( data ) {
                    var decode_data = JSON.parse( data );
                    if( decode_data['success_flag'] == true ){
                        hide_loader();
                        location.reload();
                    } else {
                        hide_loader();
                        $( ".pickup-failed" ).find( ".pickup-msg" ).html( "<strong>" + decode_data['message'] + "</strong>" );
                        $( ".pickup-success" ).hide();
                        close_notification( ".pickup-failed" );
                    }

                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                }
            });
        }, 1000);
        return false;
    });
    
    $( document ).on( 'submit', '#frm_edit_change_orders', function ( e ) {
        e.preventDefault();
        var check_amt = 0;
        $( '.ch_amount' ).find( ".gt_total_amoumt" ).each( function(){
            if( $( this ).val() == 0 ){
                check_amt = 1;
            }
        });
        if( check_amt == 1 ){
            swal( "", "Total amount must be greater than 0.", "warning");
            return false;
        }else{
            
        }
        var pickup_id = $( "#pickup_id" ).val();
        var gt_total_amoumt = $( ".gt_total_amoumt" ).val();
        var str = '&action=edit_change_order';
        show_loader();
        setTimeout(function(){ 
            $.ajax({
                type:       "POST",
                dataType:   "html",
                url:        USER_AJAX_URL,
                data:       $( "#frm_edit_change_orders" ).serialize() + str,
                async:      false,
                success:    function ( data ) {
                    var decode_data = JSON.parse( data );
                    if( decode_data['success_flag'] == true ){
                        $( '.change_order_' + pickup_id ).find( '.pickup_amount' ).text( ' $' + gt_total_amoumt );
                        hide_loader();
                        swal( "", decode_data['message'], "success" );
                        $( "#frm_edit_change_orders" ).slideUp();
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
    });
    
    $("#open_location_modal").click( function (){
        initialize();
        $( "#frm_add_location" ).find('input[type=text]').val('');
        $( "#frm_add_location" ).find('select').val('');
        $( "#frm_add_location" ).css("display","block");
    });
    
    $("#open_change_order_location_modal").click( function (){
        initialize_location();
        $( "#frm_add_location" ).find('input[type=text]').val('');
        $( "#frm_add_location" ).find('select').val('');
        $( "#frm_add_location" ).css("display","block");
    });
    
    $( "#change_status_popup_request" ).click( function(){
        var info = $( "#change_status_popup" ).val();
            setTimeout( function(){ 
                var job_id = $( '.change_driver_job_status' ).data( 'job-id' );
                var pick_id = $( '.change_driver_job_status' ).data( 'pick-id' );
                var same_loc_pick_id = $( '.change_driver_job_status' ).data( 'same-loc-pick-id' );
                var pickup_status = $( '#pickup_status' ).val();
                var job_status = $( '#job_status' ).val();
                var pickup_code = $( '#pickup_code' ).val();
                var pickup_code_id = $( '#pickup_code_id' ).val();
                var txt_manager_name = $( '#txt_manager_name' ).val();
                var txt_license_no = $( '#txt_license_no' ).val();
                var pickup_note = $( '#pickup_note' ).val();
                if( pickup_status == "completed" ){
                    if( pickup_code_id == "" && txt_manager_name == "" && txt_license_no == "" && pickup_note == "" ){
                        swal( "", "Please add Pick Up information", "warning" );
                        return false;
                    }
                }
                var str = 'action=change_driver_job_status&job_id=' + job_id + '&pick_id=' + pick_id + '&same_loc_pick_id=' + same_loc_pick_id
                        + '&pickup_status=' + pickup_status + '&job_status=' + job_status + '&pickup_code=' + pickup_code 
                        + '&pickup_code_id=' + pickup_code_id + '&txt_manager_name=' + txt_manager_name  + '&txt_license_no=' + txt_license_no  + '&txt_license_no=' + txt_license_no + '&pickup_note=' + pickup_note;
                if( same_loc_pick_id > 0 && pickup_status == "completed" ){
                    swal({
                        title: '',
                        text: 'Confirm change order delivery!',
                        html: true,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    },function( isConfirm ) {
                        str += '&change_order_verify=Yes';
                        $( ".confirm" ).addClass( 'loader' );
                        show_loader();
                        if ( isConfirm ) {
                            swal({
                                title: "",
                                text: "Have you received a package from store manager?",
                                type: "warning",
                                html: true,
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "Yes",
                                cancelButtonText: "No",
                                closeOnConfirm: false,
                                closeOnCancel: true
                            },function( isConfirm ) {
                                str += '&pickup_verify=Yes';
                                $( ".confirm" ).addClass( 'loader' );
                                show_loader();
                                if ( isConfirm ) { 
                                   
                                    $.ajax({
                                        type:       "POST",
                                        dataType:   "html",
                                        url:        USER_AJAX_URL,
                                        data:       str,
                                        async:      false,
                                        success:    function ( data ) {
                                            var decode_data = JSON.parse( data );
                                            if( decode_data['success_flag'] == true ){
                                                hide_loader();
                                                if( pickup_status == "onroute" ){
                                                    window.open(
                                                        decode_data['location'],
                                                        '_blank' 
                                                    );
                                                     location.reload();
                                                }
                                                if( pickup_status == "completed" && decode_data['location'] != "" ){
                                                    
                                                    window.open(
                                                        decode_data['location'],
                                                        '_blank' 
                                                    ); 
                                                   
                                                }
                                               location.reload();
                                            } else {
                                                if( pickup_status == "completed" ){
                                                    setInterval(function(){ 
                                                        $.ajax({
                                                            type:       "POST",
                                                            dataType:   "html",
                                                            url:        USER_AJAX_URL,
                                                            data:       "action=check_store_manager_verify&job_id=" + job_id + "&pickup_id=" + pick_id,
                                                            async:      false,
                                                            success:    function ( data ) {
                                                                
                                                                var decode_data = JSON.parse( data );
                                                                if( decode_data['success_flag'] == true ){
                                                                     $.ajax({
                                                                        type:       "POST",
                                                                        dataType:   "html",
                                                                        url:        USER_AJAX_URL,
                                                                        data:       str,
                                                                        async:      false,
                                                                        success:    function ( data ) {
                                                                            var decode_data = JSON.parse( data );
                                                                            if( decode_data['success_flag'] == true ){
                                                                                hide_loader();
                                                                                if( pickup_status == "onroute" ){
                                                                                    window.open(
                                                                                        decode_data['location'],
                                                                                        '_blank' 
                                                                                    );
                                                                                     location.reload();
                                                                                }
                                                                                if( pickup_status == "completed" && decode_data['location'] != "" ){
                                                                                    window.open(
                                                                                        decode_data['location'],
                                                                                        '_blank' 
                                                                                    );
                                                                                    
                                                                                }
                                                                               location.reload();
                                                                            } else {
                                                                                hide_loader();
                                                                                 $( ".confirm" ).removeClass( 'loader' );
                                                                                 $( ".confirm" ).removeClass( 'show' );
                                                                                swal( "", decode_data['message'], "warning");
                                                                                $( ".confirm" ).removeClass( 'show' );
                                                                                
                                                                            }
                                                                            hide_loader();
                                                                        },
                                                                        error: function ( jqXHR, textStatus, errorThrown ) {
                                                                            console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                                                                        }
                                                                        
                                                                    });
                                                                    hide_loader();
                                                                    // location.reload();
                                                                } else {
                                                                }
                                                            },
                                                            error: function ( jqXHR, textStatus, errorThrown ) {
                                                                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                                                            }
                                                        });
                                                    }, 3000);
                                                }
                                                hide_loader();
                                                 $( ".confirm" ).removeClass( 'loader' );
                                                 $( ".confirm" ).removeClass( 'show' );
                                                swal( "", decode_data['message'], "warning");
                                                $( ".confirm" ).removeClass( 'show' );
                                                 
                                            }
                                            hide_loader();
                                        },
                                        error: function ( jqXHR, textStatus, errorThrown ) {
                                            console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                                        }
                                    });
                                }
                                hide_loader();
                            });
                            hide_loader();
                        } 
                        return false;
                    });
                    hide_loader();
                }else{
                    var btn_text = "Yes";
                    if( pickup_status == 'completed' || pickup_status == 'onroute' || pickup_status == "arrived" ) {
                        btn_text = "Confirm";
                    }else{
                        btn_text = "Yes";
                    }
                    swal({
                        title: "",
                        text: info,
                        type: "warning",
                        showCancelButton: true,
                        className: "loader",
                        confirmButtonClass: "btn-warning",
                        confirmButtonText: btn_text,
                        closeOnConfirm: false,
                        closeOnCancel: true
                    },function( isConfirm ) {
                        console.log(str);
                        
                        $( ".confirm" ).addClass( 'loader' );
                        
                        show_loader();
                        if ( isConfirm ) {
                            
                            $.ajax({
                                type:       "POST",
                                dataType:   "html",
                                url:        USER_AJAX_URL,
                                data:       str,
                                async:      false,
                                success:    function ( data ) {
                                    var decode_data = JSON.parse( data );
                                    if( decode_data['success_flag'] == true ){
                                        hide_loader();
                                        if( pickup_status == "onroute" ){
                                            window.open(
                                                decode_data['location'],
                                                '_blank' 
                                            );
                                             location.reload();
                                        }
                                        if( pickup_status == "completed" && decode_data['location'] != "" ){
                                            window.open(
                                                decode_data['location'],
                                                '_blank' 
                                            );
                                            
                                        }
                                       location.reload();
                                    } else {
                                        if( pickup_status == "completed" ){
                                            setInterval(function(){ 
                                                $.ajax({
                                                    type:       "POST",
                                                    dataType:   "html",
                                                    url:        USER_AJAX_URL,
                                                    data:       "action=check_store_manager_verify&job_id=" + job_id + "&pickup_id=" + pick_id,
                                                    async:      false,
                                                    success:    function ( data ) {
                                                        
                                                        var decode_data = JSON.parse( data );
                                                        if( decode_data['success_flag'] == true ){
                                                            $.ajax({
                                                                type:       "POST",
                                                                dataType:   "html",
                                                                url:        USER_AJAX_URL,
                                                                data:       str,
                                                                async:      false,
                                                                success:    function ( data ) {
                                                                    var decode_data = JSON.parse( data );
                                                                    if( decode_data['success_flag'] == true ){
                                                                        hide_loader();
                                                                        if( pickup_status == "onroute" ){
                                                                            window.open(
                                                                                decode_data['location'],
                                                                                '_blank' 
                                                                            );
                                                                             location.reload();
                                                                        }
                                                                        if( pickup_status == "completed" && decode_data['location'] != "" ){
                                                                            window.open(
                                                                                decode_data['location'],
                                                                                '_blank' 
                                                                            );
                                                                            
                                                                        }
                                                                       location.reload();
                                                                    } else {
                                                                        hide_loader();
                                                                         $( ".confirm" ).removeClass( 'loader' );
                                                                         $( ".confirm" ).removeClass( 'show' );
                                                                        swal( "", decode_data['message'], "warning");
                                                                        $( ".confirm" ).removeClass( 'show' );
                                                                        
                                                                    }
                                                                    hide_loader();
                                                                },
                                                                error: function ( jqXHR, textStatus, errorThrown ) {
                                                                    console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                                                                }
                                                                
                                                            });
                                                             hide_loader();
                                                        } else {
                                                        }
                                                    },
                                                    error: function ( jqXHR, textStatus, errorThrown ) {
                                                        console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                                                    }
                                                });
                                            }, 3000);
                                        }
                                        hide_loader();
                                                 $( ".confirm" ).removeClass( 'loader' );
                                                 $( ".confirm" ).removeClass( 'show' );
                                                swal( "", decode_data['message'], "warning");
                                                $( ".confirm" ).removeClass( 'show' );
                                        
                                    }
                                    hide_loader();
                                },
                                error: function ( jqXHR, textStatus, errorThrown ) {
                                    console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                                }
                                
                            });
                             hide_loader();
                        }
                    });
                    hide_loader();
                }
            }, 1000);
            return false;
    });
    
    $( document ).on( 'click', '.change_job_status', function ( e ) {
        
    });
    
    $( document ).on( 'click', '.resend_mail', function ( e ) {
        var pick_id = $( this ).data( 'pick-id' );
        var manager_id = $( this ).data( 'manager-id' );
        var s_loc_id = $( this ).data( 'same-loc-id' );
        var str = 'action=sm_resend_mail&pick_id=' + pick_id 
                + '&manager_id=' + manager_id + '&s_loc_id=' + s_loc_id;
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
                        swal("", decode_data['message'], "success");
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
    });
    
    $( document ).on( 'click', '#check_sm_verify', function ( e ) {
        var job_id = $( this ).data( 'job-id' );
        var pick_id = $( this ).data( 'pick-id' );
        
        var str = 'action=check_sm_verify&job_id=' + job_id + '&pick_id=' + pick_id;
        show_loader();
        setTimeout(function(){ 
            $.ajax({
                type:       "POST",
                dataType:   "html",
                url:        USER_AJAX_URL,
                data:       str,
                async:      false,
                success:    function ( data ) {
                    var decode_data = JSON.parse( data );
                    if( decode_data['success_flag'] == true ){
                        location.reload();
                    } else {
                        swal("", decode_data['message'], "warning");
                    }

                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                }
            });
        }, 1000);
        return false;
    });
    
    $( document ).on( 'click', '#job_completed', function ( e ) {
        var info = $("#change_status_popup").val();
        var st_type = $( this ).data( 'st_type' );
//        swal("", info, "warning");
        if( st_type  == "Other" ){
            st_type = "other";
        }else{
            st_type = "bank";
        }
        swal({
            title: "",
            text: "You appear to be far from the " + st_type + " location. Confirm arrival",
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
                    text: 'Confirm package delivery to ' + st_type + '.',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-warning loader",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },function( isConfirm ) {
                    if ( isConfirm ) {  
                        swal({
                            title: "",
                            text: info,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-warning loader",
                            confirmButtonText: "Yes",
                            closeOnConfirm: false
                        },function() {
                            var job_id = $( '#job_completed' ).data( 'job-id' );
                            var str = 'job_id='+ job_id + '&action=driver_job_complete' ;
                            show_loader();
                            setTimeout(function(){ 
                                $.ajax({
                                    type:       "POST",
                                    dataType:   "html",
                                    url:        USER_AJAX_URL,
                                    data:       str,
                                    async:      false,
                                    success:    function ( data ) {
                                        var decode_data = JSON.parse( data );
                                        if( decode_data['success_flag'] == true ){
                                            swal({
                                                title: "",
                                                text: decode_data['message'],
                                                type: "success",
                                                showCancelButton: true,
                                                confirmButtonClass: "btn-warning",
                                                confirmButtonText: "Ok",
                                                showCancelButton:false,
                                                closeOnConfirm: false
                                            },function() {
                                                redirect_to_URL( decode_data['redirect'] );
                                            });
                                        } else {
                                            swal("", decode_data['message'], "warning");
                                        }
                
                                    },
                                    error: function ( jqXHR, textStatus, errorThrown ) {
                                        console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                                    }
                                });
                            }, 1000);
                        });
                    }
                });
                return false;
            }
        });
        return false;
    });
    
    $( document ).on( 'click', '#arrived_bank', function ( e ) {
        var info = $("#change_status_popup").val();
        var type = $( this ).data( 'type' ); 
        swal({
            title: "",
            text: "You appear to be far from the " + type + " location. Confirm arrival",
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
                    confirmButtonClass: "btn-warning loader",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                },function() {
                    $(".confirm").addClass('loader');
                    var job_id = $( '#arrived_bank' ).data( 'job-id' );
                    var str = 'job_id='+ job_id + '&action=ch_arrived_at_bank' ;
                    show_loader();
                    setTimeout(function(){ 
                        $.ajax({
                            type:       "POST",
                            dataType:   "html",
                            url:        USER_AJAX_URL,
                            data:       str,
                            async:      false,
                            success:    function ( data ){
                                var decode_data = JSON.parse( data );
                                if( decode_data['success_flag'] == true ){
                                    hide_loader();
                                    swal({
                                        title: "",
                                        text: decode_data['message'],
                                        type: "success",
                                        confirmButtonClass: "btn-warning",
                                        confirmButtonText: "Confirm",
                                        closeOnConfirm: false
                                    },function(){
                                        if( decode_data['location'] != "" ){
                                            window.open(
                                                decode_data['location'],
                                                '_blank' 
                                            );
                                        }
                                        location.reload();
                                    });
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
                });
                return false;
            }
        });
        return false;
    });
        
    $( document ).on( 'click', '.change_order_approve', function ( e ) {
        e.preventDefault();
        var id = $( this ).data( 'id' );
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Ok",
            cancelButtonText: "Cancel",
            closeOnConfirm: false
        },
        function( isConfirm ) {
            if ( isConfirm && id != "" ) {
                $(".confirm").addClass('loader');
                show_loader();
                setTimeout(function(){ 
                    $.ajax({
                        dataType:   "html",
                        url:        USER_AJAX_URL,
                        method:     "POST",
                        cache:      false,
                        data:       { 'id': id, 'action': 'change_order_approve' },
                        success:    function ( data ) {
                            var decode_data = JSON.parse( data );
                            if( decode_data['success_flag'] == true ) {
                                hide_loader();
                                swal( '',decode_data['message'], "success" );
                                var change_data = "";
                                change_data += "<a href='#'  class='btn btn-success'>Approved</a>";
                                $( '.change_order_'+ id ).find( '.change_order_approve' ).replaceWith( change_data );
                                $( '.change_order_'+ id ).find( '.change_order_reject' ).remove();
                            } else {
                                hide_loader();
                                swal( '',decode_data['message'], "warning" );
                            }
                        },
                        error: function ( jqXHR, textStatus, errorThrown ) {
                            console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                        }
                    });
                }, 1000);
            } else {
                swal( "Cancelled", "Its Cancelled :)", "error" );
            }
        });
    }); 
    
    $( document ).on( 'click', '.change_order_reject', function ( e ) {
        e.preventDefault();
        var id = $( this ).data( 'id' );
        swal({
            title: "<h3>Enter Your Reason</h3>",
            text: "<textarea id='text' class='form-control'></textarea><div class='text-danger' id='def_error'></div>",
            html: true,
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Ok",
            cancelButtonText: "Cancel",
            closeOnConfirm: false
        },
        function( isConfirm ) {
            var val = document.getElementById( 'text' ).value;
            if ( val == "" ) {
                document.getElementById( "def_error" ).innerHTML = 'Please enter reason';
                return false;
            } 
            if ( isConfirm && id != "" && val != "" ) {   
                $(".confirm").addClass('loader');
                show_loader();
                setTimeout(function(){ 
                    $.ajax({
                        dataType:   "html",
                        url:        USER_AJAX_URL,
                        method:     "POST",
                        cache:      false,
                        data:       {'id': id, 'val': val, 'action': 'change_order_reject'},
                        success:    function ( data ) {
                            var decode_data = JSON.parse( data );
                            if( decode_data['success_flag'] == true ) {
                                hide_loader();
                                swal( '', decode_data['message'], "success" );
                                var change_data = "";
                                change_data = "<button type='button' class='btn btn-danger'>Rejected</button>";
                                $( '.change_order_'+ id ).find( '.change_order_reject' ).replaceWith( change_data );
                                $( '.change_order_'+ id ).find( '.change_order_approve' ).remove();
                            } else{
                                hide_loader();
                                swal( '', decode_data['message'], "warning" );
                            }
                        },
                        error: function ( jqXHR, textStatus, errorThrown ) {
                            console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                        }
                    });
                }, 1000);
            } else {
                swal( "Cancelled", "Its Cancelled :)", "error" );
            }
        });
    });
    
   $( document ).on( 'click', '.em_stop_job', function ( e ) {
        var job_id = $( this ).data( 'job-id' );
        var pickup_id = $( this ).data( 'pickup-id' );
        swal({
            title: "<h3>Enter Your Reason</h3>",
            text: "<textarea id='em_stop_reason' class='form-control'></textarea><div class='text-danger' id='def_error'></div>",
            html: true,
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Ok",
            cancelButtonText: "Cancel",
            closeOnConfirm: false
        },
        function( isConfirm ) {
            var val = document.getElementById( 'em_stop_reason' ).value;
            if ( val == "" ) {
                document.getElementById( "def_error" ).innerHTML = 'Please enter reason';
                return false;
            } 
            if ( isConfirm && job_id != "" && val != "" ) {   
                $( ".confirm" ).addClass( 'loader' );
                show_loader();
                setTimeout(function(){ 
                    $.ajax({
                        dataType:   "html",
                        url:        USER_AJAX_URL,
                        method:     "POST",
                        cache:      false,
                        data:       { 'job_id': job_id,'pickup_id': pickup_id, 'em_stop_reason': val, 'action': 'driver_stop_job'},
                        success:    function ( data ) {
                            var decode_data = JSON.parse( data );
                            if( decode_data['success_flag'] == true ) {
                                hide_loader();
                                swal({
                                    title: "",
                                    text: decode_data['message'],
                                    type: "success",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-warning",
                                    confirmButtonText: "Ok",
                                    closeOnConfirm: false
                                },function(){
                                    redirect_to_URL( decode_data['redirect'] );
                                });
                            } else{
                                hide_loader();
                                swal( '', decode_data['message'], "warning" );
                            }
                        },
                        error: function ( jqXHR, textStatus, errorThrown ) {
                            console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                        }
                    });
                }, 1000);
            } else {
                swal( "Cancelled", "Its Cancelled :)", "error" );
            }
        });
    });
    
    $( document ).on( 'click', '.resume_pickup', function ( e ) {
        var job_id = $( this ).data( 'job-id' );
        var pickup_id = $( this ).data( 'pickup-id' );
        show_loader();
        setTimeout(function(){ 
            $.ajax({
                dataType:   "html",
                url:        USER_AJAX_URL,
                method:     "POST",
                cache:      false,
                data:       { 'job_id': job_id,'pickup_id': pickup_id, 'action': 'driver_resume_pickup'},
                success:    function ( data ) {
                    var decode_data = JSON.parse( data );
                    if( decode_data['success_flag'] == true ) {
                        hide_loader();
                        swal({
                            title: "",
                            text: decode_data['message'],
                            type: "success",
                            showCancelButton: true,
                            confirmButtonClass: "btn-warning",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false
                        },function(){
                            redirect_to_URL( decode_data['redirect'] );
                        });
                    } else{
                        hide_loader();
                        swal( '', decode_data['message'], "warning" );
                    }
                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                }
            });
        }, 1000);
    });
    
    function get_new_add_item_html( html ) {
        var html_append_new_item = html.replace(/pickup\[0\]/g, 'pickup[' + curr_include_add_item + ']');
        console.log( html_append_new_item );
        return html_append_new_item;
    }
    function get_new_cd_add_item_html( html ) {
        var html_append_new_item = html.replace(/change\[0\]/g, 'change[' + curr_include_co_item + ']');
        console.log( html_append_new_item );
        return html_append_new_item;
    }
    $( '.pickup_report' ).DataTable({
        "order": [[ 0, "asc" ]]
    });
    
    return { // Init all form element features
        init: function(){   
            feValidation();
        }
    }
        
})(jQuery);
    
