<?php 
require_once '../../config/config.php';
require_once '../config/admin_config.php';
if( !isset( $_SESSION['user_id'] ) && !isset( $_SESSION['user_type'] ) ){
    header( "location:" . BASE_URL );
} else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] != "admin"  ){	
    header( "location:" . VW_LOGOUT );
}
$admin_id = isset( $_SESSION['admin_id'] ) && $_SESSION['admin_id'] != "" ? $_SESSION['admin_id'] : 0;
include_once FL_LOGIN_HEADER;
include_once FL_LOGIN_SIDEBAR;

include_once FL_USER;
$user = new user();
include_once FL_LOCATION;
$location = new location();
include_once FL_PICKUP;
$pickup = new pickup();  
include_once FL_SETTINGS;
$settings = new settings();
?>
<!-- PAGE CONTENT -->
<div class="page-content">

    <!-- START X-NAVIGATION VERTICAL -->
    <?php  include_once FL_LOGIN_SUB_HEADER;?> 
    <!-- END X-NAVIGATION VERTICAL -->    


    <!-- PAGE CONTENT WRAPPER -->
    <div class="panel panel-default">
        <div class="tab-pane active">
            <div class="tabs">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="#change_order_request_day" data-toggle="tab">Change Order</a>
                    </li>
                    <li class="">
                        <a href="#other_setting" data-toggle="tab">
                            Other Settings
                        </a>
                    </li>
                    <li class="">
                        <a href="#change_password" data-toggle="tab">
                            Change Password
                        </a>
                    </li>
                </ul>
                <div class="panel-body tab-content">
                    <div class="tab-pane active" id="change_order_request_day" role="tabpanel">
                        <div class="page-content-wrap">
                            <div class="alert alert-danger alert-dismissable pickup-failed hide-el" style="display: none;">

                                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                <span class="pickup-msg"></span>

                            </div>
                            <!-- START WIDGETS -->                    
                            <form class="form-horizontal" method="post" name="frm_change_order_request_days" id="frm_change_order_request_days" >
                                <div class="panel panel-default">

                                    <div class="pick-body">
                                        <div class="panel-body  col-md-12">
                                            <div class="panel-heading">
                                                <h3 class="panel-title" style="text-transform: capitalize">Change Order Request</h3>
                                            </div>
                                            <div style="margin-top: 60px;">
                                                <div class="form-group">
                                                    <label class="col-md-3">Business Owner Name<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input class="form-control ui-autocomplete-input" type="text" id="txt_driver_name1"  name="txt_driver_name1" placeholder="Business Owner name" autocomplete="off">
                                                        <input class="form-contro" type="hidden" id="txt_bo_id"  name="txt_bo_id" >
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group change_order_form">
                                                    <label class="col-md-3">Add change order from day:</label>
                                                    <div class="col-md-9">
                                                        <select class=" select" id="ch_from" name="ch_from">
                                                            <option  value="1">Monday</option>
                                                            <option  value="2">Tuesday</option>
                                                            <option  value="3">Wednesday</option>
                                                            <option  value="4">Thursday</option>
                                                            <option  value="5">Friday</option>
                                                            <option  value="6">Saturday</option>
                                                            <option  value="7">Sunday</option>
                                                        </select>                           
                                                    </div>                        
                                                </div>
                                                <div class="form-group change_order_to">
                                                    <label class="col-md-3">Add change order to day:</label>
                                                    <div class="col-md-9">
                                                        <select class=" select" id="ch_to" name="ch_to">
                                                            <option  value="1" disabled="">Monday</option>
                                                            <option  value="2">Tuesday</option>
                                                            <option  value="3">Wednesday</option>
                                                            <option  value="4">Thursday</option>
                                                            <option  value="5">Friday</option>
                                                            <option  value="6">Saturday</option>
                                                            <option  value="7">Sunday</option>
                                                        </select>                         
                                                    </div>                        
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3">The day to deliver money to store:</label>
                                                    <div class="col-md-9">
                                                        <select class=" select" id="ch_delivery_time" name="ch_delivery_time">
                                                            <option  value="1">Monday</option>
                                                            <option  value="2">Tuesday</option>
                                                            <option  value="3">Wednesday</option>
                                                            <option  value="4">Thursday</option>
                                                            <option  value="5">Friday</option>
                                                            <option  value="6">Saturday</option>
                                                            <option  value="7">Sunday</option>
                                                        </select>                          
                                                    </div>                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">  
                                        <button type="submit" class="btn btn-primary pull-right loader">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane" id="other_setting" role="tabpanel">
                        <div class="page-content-wrap">
                            <div class="alert alert-danger alert-dismissable pickup-failed hide-el" style="display: none;">

                                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                <span class="pickup-msg"></span>

                            </div>
                            <!-- START WIDGETS -->                    
                            <form class="form-horizontal" method="post" name="frm_other_settings" id="frm_other_settings" >
                                <div class="panel panel-default">

                                    <div class="pick-body">
                                        <div class="panel-body  col-md-12">
                                            <div class="panel-heading">
                                                <h3 class="panel-title" style="text-transform: capitalize">Other Settings</h3>
                                            </div>
                                            <?php 
                                                $mail_mode = $settings->get_settings( 'mail_mode' , TRUE );
                                            ?>
                                            <div style="margin-top: 60px;">
                                                <div class="form-group">
                                                    <label class="col-md-3">Mail mode:</label>
                                                    <div class="col-md-9">
                                                        <select class=" select" id="other_settings" name="other_settings[mail_mode]">
                                                            <option  value="live" <?php echo ( $mail_mode == "live" ) ? "selected" : ''; ?>>Live</option>
                                                            <option  value="test" <?php echo ( $mail_mode == "test" ) ? "selected" : ''; ?>>Test</option>
                                                        </select> 
                                                    </div>
                                                </div>
                                                <?php 
                                                    $driver_pickup_amount = $settings->get_settings( 'driver_pickup_amount' , TRUE );
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-md-3">Driver Pick UP amount:</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control" type="number" id="txt_driver_pickup_amt" value="<?php echo isset( $driver_pickup_amount ) && $driver_pickup_amount != '' || $driver_pickup_amount != 0 ? $driver_pickup_amount : 0; ?>"  name="other_settings[driver_pickup_amount]" >
                                                    </div>
                                                </div>
                                                <?php 
                                                    $bo_bank_address = $settings->get_settings( 'bo_bank_address' , TRUE );
                                                    $bo_latitude = $settings->get_settings( 'bo_latitude' , TRUE );
                                                    $bo_longitude = $settings->get_settings( 'bo_longitude' , TRUE );
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_address">Bank Address<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="validate[required] form-control" id="txt_address" name="other_settings[bo_bank_address]" placeholder="Address" value="<?php echo isset( $bo_bank_address ) && $bo_bank_address != '' ? $bo_bank_address : '';  ?>" />
                                                        <input type="hidden" id="hdn_latitude" name="other_settings[bo_latitude]" value="<?php echo isset( $bo_latitude ) && $bo_latitude != '' ? $bo_latitude : '';  ?>"/>
                                                        <input type="hidden" id="hdn_longitude" name="other_settings[bo_longitude]" value="<?php echo isset( $bo_longitude ) && $bo_longitude != '' ? $bo_longitude : '';  ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3"></label>
                                                    <div class="col-md-9">
                                                        <div id="location" style="width: 100%; height: 200px;"></div>
                                                        <div class="clearfix">&nbsp;</div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">  
                                        <button type="submit" class="btn btn-primary pull-right loader">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane" id="change_password" role="tabpanel">
                        <div class="page-content-wrap">
                            <div class="alert alert-danger alert-dismissable pickup-failed hide-el" style="display: none;">

                                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                <span class="pickup-msg"></span>

                            </div>
                            <!-- START WIDGETS -->                    
                            <form class="form-horizontal" method="post" name="frm_other_settings" id="frm_other_settings" >
                                <div class="panel panel-default">

                                    <div class="pick-body">
                                        <div class="panel-body  col-md-12">
                                            <div class="panel-heading">
                                                <h3 class="panel-title" style="text-transform: capitalize">Change Password</h3>
                                            </div>
                                            <input type="hidden" value='<?php echo $admin_id; ?>'name='user_id' id="user_id" />
                                            <div style="margin-top: 60px;">
                                                <p>
                                                    <button class="btn
                                                    btn-primary btn-lg  send_change_password_link">Change Password</button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">  
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<div class="modal fade" id="pickup_job_assign" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Driver List</h4>
            </div>
            <div class="modal-body">
                <div class="page-content-wrap" style="margin-top:20px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissable location-success hide-el" style="display: none;">

                                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                <span class="location-msg"></span>

                            </div>

                            <div class="alert alert-danger alert-dismissable location-failed hide-el" style="display: none;">

                                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                <span class="location-msg"></span>

                            </div>
                            <form id="frm_request_driver"  method="post" role="form" class="form-horizontal" action="">                            
                                <div class="selected_driver">
                                    
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-3">Driver Name:</label>
                                    <div class="col-md-9">
                                        <?php $user_data = $user->search_user_by_type( 'driver', '' );?>
                                        <select class="select" id="txt_driver_name" name="txt_driver_name">
                                            <?php 
                                            if( isset( $user_data ) ){
                                                foreach ( $user_data as $key => $value ) { ?>
                                                    <option  value="<?php echo $value['in_user_id']; ?>" ><?php echo $value['st_first_name']; ?></option>
                                            <?php }
                                            }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary loader" type="submit">Submit</button>
                                </div>                                                                
                            </form>
                        </div>
                    </div>                    

                </div>
            </div>
        </div>
    </div>
</div>
    
<div class="modal fade" id="select_driver" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Driver List</h4>
            </div>
            <div class="modal-body">
                <div class="page-content-wrap" style="margin-top:20px;">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="modal-title">Please select driver</h4>
                        </div>
                    </div>                    

                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once FL_LOGIN_FOOTER_INCLUDE;
?>
<script type='text/javascript' src="<?php echo ADMIN_JS_PLUGINS_PATH .'icheck/icheck.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'mcustomscrollbar/jquery.mCustomScrollbar.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'datatables/jquery.dataTables.min.js'; ?>"></script>  
<script type='text/javascript' src="<?php echo ADMIN_JS_PLUGINS_PATH .'bootstrap/bootstrap-select.js' ; ?>"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>pickup.js"></script>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=<?php echo GOOGLE_MAPS_API_KEY; ?>"></script>
<script type="text/javascript" src="<?php echo JS_PLUGINS_PATH; ?>location-picker/locationpicker.jquery.min.js"></script>

<?php
include_once FL_LOGIN_FOOTER;
?>
<script>
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast( term ) {
        return split( term ).pop();
    }
    $( "#txt_driver_name1" ).bind( "keydown", function ( event ) {
        $( "#txt_bo_id" ).val( 0 );
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 1,
        source: function( request, response ){
            // delegate back to autocomplete, but extract the last term
            $.getJSON( USER_AJAX_URL + "?type=" + "business_owner",{ term : extractLast( request.term )},response);
        },
        focus: function ( event, ui ) {
            
            return false;
        },
        select: function ( event, ui ) {
            this.value = ui.item.value + '( ' + ui.item.email + ' )';
            $( "#txt_bo_id" ).val( ui.item.id  );
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function ( ul, item ) {
        return $( "<li>" )
        .append( "<a>" + item.value + '( ' + item.email + ' )' + "<br>" + "</a>" )
        .appendTo( ul );
    };
    
    var autocomplete;
        var geocoder;
        var gmarkers = [];
        
        google.maps.event.addDomListener(window, 'load', initialize);
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

            var input = document.getElementById('txt_address');
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
                marker.setMap(map);
                searchBox.addListener('places_changed', function () {
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
                                $("#txt_address").val(results[0].formatted_address);
                            }
                        });
                    });
                    $('#hdn_latitude').val(lat);
                    $('#hdn_longitude').val(lng);
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
                searchBox.setBounds(bounds);
            });
        }
</script>