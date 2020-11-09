<?php //
session_start();
require_once '../../config/config.php';
require_once '../../backend/config/admin_config.php';
if( !isset( $_SESSION['user_id'] ) && !isset( $_SESSION['user_type'] ) ){
    header( "location:" . BASE_URL );
} else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] != "business_owner"  ){	
    header( "location:" . BASE_URL );
}
include_once FL_LOGIN_HEADER;
include_once FL_LOGIN_SIDEBAR;

include_once FL_USER;
$user = new user();
$user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] != '' ? $_SESSION['user_id'] : '';
$userdata = $user->get_user_data_by_key( $user_id );

?>
<!-- PAGE CONTENT -->
<div class="page-content">
    <div class="page-content-wrap">
        <div class="row">
            <!-- START X-NAVIGATION VERTICAL -->
            <?php  include_once FL_LOGIN_SUB_HEADER; ?> 
            <!-- END X-NAVIGATION VERTICAL -->    
            <!-- PAGE CONTENT WRAPPER -->
            <div class="panel panel-default">
                <div class="tab-pane active" >
                    <div class=" tabs">
                        <ul class="nav nav-tabs nav-justified">
                            <li ><a href="#my_information" data-toggle="tab">My Information</a></li>
                            <li><a href="#change_email_password" data-toggle="tab">Change Email/Password</a></li>
                            <li class="active"><a href="#bank_detail" data-toggle="tab">Bank Details</a></li>
                        </ul>
                        <div class="panel-body tab-content">
                            <div class="tab-pane " id="my_information" role="tabpanel">
                                <div class="page-content-wrap" style="margin-top:20px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-success alert-dismissable info-success hide-el" style="display: none;">

                                                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                                <span class="info-msg"></span>

                                            </div>

                                            <div class="alert alert-danger alert-dismissable info-failed hide-el" style="display: none;">

                                                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                                <span class="info-msg"></span>

                                            </div>
                                            <form method="post" action="" id="bo_edit" name="bo_edit">
                                                <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                                                <input type="hidden" name="txt_user_type" value="business_owner">
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_first_name">First Name<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_first_name" name="txt_first_name" value="<?php echo isset( $userdata['st_first_name'] ) && $userdata['st_first_name'] != '' ? $userdata['st_first_name'] : '' ; ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_last_name">Last Name<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_last_name" name="txt_last_name" value="<?php echo isset( $userdata['st_last_name'] ) && $userdata['st_last_name'] != '' ? $userdata['st_last_name'] : ''; ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_phone_no">Phone Number<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_phone_no" name="txt_phone_no" value="<?php echo $userdata['in_contact_no']; ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <?php 
                                                $business_name = $user->get_bo_data_by_key( $user_id, 'st_business_name' );
                                                $eni_no = $user->get_bo_data_by_key( $user_id, 'in_eni_number' );
                                                $job_title = $user->get_bo_data_by_key( $user_id, 'st_job_title' );
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_business_name">Business Name<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_business_name" name="txt_business_name" value="<?php echo isset( $business_name ) && $business_name != '' ? $business_name : '' ;  ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_eni_no">EIN Number<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_eni_no" name="txt_eni_no" value="<?php echo isset( $eni_no ) && $eni_no != '' ? $eni_no : '' ;  ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_job_title">Job Title<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_job_title" name="txt_job_title" value="<?php echo isset( $job_title ) && $job_title != '' ? $job_title : '' ;  ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_address_1">Address Line 1<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_address_1" name="txt_address_1" value="<?php echo $userdata['st_address_1']; ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_address_2">Address Line 2</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_address_2" name="txt_address_2" value="<?php echo $userdata['st_address_2']; ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_city">City<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_city" name="txt_city" value="<?php echo $userdata['st_city']; ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_city">State<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_state" name="txt_state" value="<?php echo $userdata['st_state']; ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <?php 
                                                    $home_address = $user->get_user_meta( $user_id , 'st_bo_home_address', TRUE );
                                                    $home_lat = $user->get_user_meta( $user_id , 'st_bo_home_lat', TRUE );
                                                    $home_log = $user->get_user_meta( $user_id , 'st_bo_home_long', TRUE );
                                                    $warehouse_address = $user->get_user_meta( $user_id , 'st_bo_warehouse_address', TRUE );
                                                    $warehouse_lat = $user->get_user_meta( $user_id , 'st_bo_warehouse_lat', TRUE );
                                                    $warehouse_log = $user->get_user_meta( $user_id , 'st_bo_warehouse_long', TRUE );
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_home_address">Home Address</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="validate[required] form-control" id="txt_home_address" name="txt_home_address" placeholder="Address" value="<?php echo isset( $home_address ) ? $home_address : '';  ?>" />
                                                        <input type="hidden" id="hdn_home_latitude" name="hdn_home_latitude" value="<?php echo isset( $home_lat ) ? $home_lat : '';  ?>"/>
                                                        <input type="hidden" id="hdn_home_longitude" name="hdn_home_longitude" value="<?php echo isset( $home_log ) ? $home_log : '';  ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3"></label>
                                                    <div class="col-md-9">
                                                        <div id="map_home_address" style="width: 100%; height: 200px;"></div>
                                                        <div class="clearfix">&nbsp;</div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_warehouse_address">Warehouse Address</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="validate[required] form-control" id="txt_warehouse_address" name="txt_warehouse_address" placeholder="Address" value="<?php echo isset( $warehouse_address ) ? $warehouse_address : '';  ?>" />
                                                        <input type="hidden" id="hdn_warehouse_latitude" name="hdn_warehouse_latitude" value="<?php echo isset( $warehouse_lat ) ? $warehouse_lat : '';  ?>"/>
                                                        <input type="hidden" id="hdn_warehouse_longitude" name="hdn_warehouse_longitude" value="<?php echo isset( $warehouse_log ) ? $warehouse_log : '';  ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3"></label>
                                                    <div class="col-md-9">
                                                        <div id="map_warehouse_address" style="width: 100%; height: 200px;"></div>
                                                        <div class="clearfix">&nbsp;</div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <div class="btn-group pull-right">
                                                    <button class="btn btn-primary loader" type="submit">Save Changes</button>
                                                </div> 
                                            </form>
                                        </div>
                                    </div>                    
                                </div>
                            </div>
                            <div class="tab-pane" id="change_email_password" role="tabpanel">
                                <p>
                                    <button class="btn btn-primary btn-lg send_change_password_link">Change Password</button>
                                </p>
                                <p>
                                    <button class="btn btn-primary btn-lg mm" data-toggle="collapse" data-target="#send_change_email_link">Change Email</button>
                                </p>

                                <div class="page-content-wrap" style="margin-top:20px;">
                                    <div class="row" >
                                        <div class="alert alert-success alert-dismissable change_email-success hide-el"  style="display: none;">

                                            <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                            <span class="change_email-msg"></span>

                                        </div>

                                        <div class="alert alert-danger alert-dismissable change_email-failed hide-el" style="display: none;">

                                            <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                            <span class="change_email-msg"></span>

                                        </div>
                                        <div class="col-md-12 collapse" id="send_change_email_link">

                                            <form method="post" action="" id="frm_change_email" name="frm_change_email" class="form-horizontal">                           
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_email_id">Email Id<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_email_id" name="txt_email_id"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="in_user_id" name="in_user_id" value="<?php echo $user_id; ?>">
                                                <!--<input type="hidden" name="action" id="hdn_location_action"/>-->
                                                <div class="btn-group pull-right">
                                                    <button class="btn btn-primary mm" type="submit">Submit</button>
                                                </div>                                                                
                                            </form>
                                        </div>
                                    </div>                    
                                </div>
                            </div> 
                            <div class="tab-pane active" id="bank_detail" role="tabpanel">
                                <div class="page-content-wrap" style="margin-top:20px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php $user_bank_deatils = $user->get_user_bankdetails( $user_id );  ?>
                                            <form method="post" action="" id="bank_bo_edit" name="bank_bo_edit">
                                                <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_full_name">Account Holder Name<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_full_name" name="txt_full_name" value="<?php echo isset( $user_bank_deatils['st_account_holder_name'] ) ? $user_bank_deatils['st_account_holder_name'] : '';  ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_acc_no">Account Number<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_acc_no" name="txt_acc_no" value="<?php echo isset( $user_bank_deatils['in_account_number'] ) ? $user_bank_deatils['in_account_number'] : '';  ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_bank_name">Bank Name<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_bank_name" name="txt_bank_name" value="<?php echo isset( $user_bank_deatils['st_bank_name'] ) ? $user_bank_deatils['st_bank_name'] : '';  ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_branch_name">Branch Name<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_branch_name" name="txt_branch_name" value="<?php echo isset( $user_bank_deatils['st_branch_name'] ) ? $user_bank_deatils['st_branch_name'] : '';  ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_routing_no">Routing Number<span class="required-feild">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_routing_no" name="txt_routing_no" value="<?php echo isset( $user_bank_deatils['in_routing_number'] ) ? $user_bank_deatils['in_routing_number'] : '';  ?>"/>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="txt_address">Address</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="txt_address" name="txt_address" placeholder="Address" value="<?php echo isset( $user_bank_deatils['st_add'] ) ? $user_bank_deatils['st_add'] : '';  ?>" />
                                                        <input type="hidden" id="hdn_latitude" name="hdn_latitude" value="<?php echo isset( $user_bank_deatils['in_latitude'] ) ? $user_bank_deatils['in_latitude'] : '';  ?>"/>
                                                        <input type="hidden" id="hdn_longitude" name="hdn_longitude" value="<?php echo isset( $user_bank_deatils['in_longitude'] ) ? $user_bank_deatils['in_longitude'] : '';  ?>"/>
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

                                                <div class="btn-group pull-right">
                                                    <button class="btn btn-primary loader" type="submit">Save Changes</button>
                                                </div> 
                                            </form>
                                        </div>
                                    </div>                    
                                </div>
                            </div> 
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

<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=<?php echo GOOGLE_MAPS_API_KEY; ?>"></script>
<script type="text/javascript" src="<?php echo JS_PLUGINS_PATH; ?>location-picker/locationpicker.jquery.min.js"></script>

<script type="text/javascript" src="<?php echo JS_PATH; ?>pickup.js"></script>
<script>google.maps.event.addDomListener(window, 'load', home_initialize);
    google.maps.event.addDomListener(window, 'load', warehouse_initialize);</script>
<script>
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
<?php
include_once FL_LOGIN_FOOTER;
?>
