<?php 
if ( !session_id() ) {
    session_start();
}
require_once '../../config/config.php';
require_once '../../backend/config/admin_config.php';
if( isset( $_SERVER['HTTP'] ) ){
    $redirect = 'https' . '://' . $_SERVER['SERVER_NAME'] . DIR_SEPERATOR  . BASE_DIR . DIR_SEPERATOR . VIEW_DIR . DIR_SEPERATOR . DRIVER_DIR 
         . DIR_SEPERATOR . 'active_job.php';
     header( "location:" . $redirect );
}
if( !isset( $_SESSION['user_id'] ) && !isset( $_SESSION['user_type'] ) ){
    header( "location:" . BASE_URL );
} else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] != "driver"  ){	
    header( "location:" . BASE_URL );
}
include_once FL_LOGIN_HEADER;
include_once FL_LOGIN_SIDEBAR;

include_once FL_USER;
$user = new user();
include_once FL_PICKUP;
$pickup = new pickup();
$user_id = isset( $_SESSION['user_id'] ) &&  $_SESSION['user_id']  != '' ? $_SESSION['user_id'] : '';  
$job_id = isset( $_REQUEST['job_id'] ) &&  $_REQUEST['job_id']  != '' ? $_REQUEST['job_id'] : '';  
?>
<!-- PAGE CONTENT -->
<div class="page-content">

    <!-- START X-NAVIGATION VERTICAL -->
    <?php  include_once FL_LOGIN_SUB_HEADER;?> 
    <!-- END X-NAVIGATION VERTICAL -->    


    <!-- PAGE CONTENT WRAPPER -->
    
    <div class="page-content-wrap">
        <div class="page-title">                    
            <h2>My Active Trip #<?php echo $job_id; ?></h2>
        </div>
        <!-- START WIDGETS -->                    
        <div class="row">
            <?php 
            $driver_job = $pickup->get_driver_assign_job( $job_id );
            $check_ch_job = $pickup->check_ch_bank_job( $job_id );
            $check_pickup_exists = $pickup->check_pickup_exists_job( $job_id );
            if( isset( $driver_job ) && is_array( $driver_job ) ){
                if( isset( $check_ch_job['st_order_type'] ) &&  $check_ch_job['st_order_type'] == "change_order" ){
                    ?>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Trip #<?php echo $job_id; ?></h3>
                            </div>
                            <?php 
                            $bank_data = $pickup->get_job_address_data( $job_id, 'change_order' );
                            $bank_name = isset( $bank_data['st_add'] ) && $bank_data['st_add'] != '' ? $bank_data['st_add'] : '';
                            $bank_lat = isset( $bank_data['in_latitude'] ) && $bank_data['in_latitude'] != '' ? $bank_data['in_latitude'] : '';
                            $bank_log = isset( $bank_data['in_longitude'] ) && $bank_data['in_longitude'] != '' ? $bank_data['in_longitude'] : '';
                            ?>
                            <div class="panel-body">
                                
                                <div class=""><h5>Navigate to <?php echo $bank_name; ?></h5></div>
                                <div class="col-md-12">
                                    <div id="location"></div>
                                    <input type="hidden" id="start_latlog"/>
                                    <input type="hidden" id="end_latlog" value="<?php echo $bank_lat . ',' . $bank_log; ?>"/>
                                </div>
                            </div>
                            <?php $bank_address_plus = preg_replace( '/\s/ ', '+', $bank_name ); ?>
                            <div class="panel-footer col-md-12"> 
                                <a href="#" class="" id="arrived_bank" data-type="<?php echo $bank_data['st_type']; ?>" data-job-id="<?php echo $job_id;?>">
                                    <button  class="btn btn-info btn-lg">Arrived At <?php echo $bank_data['st_type']; ?></button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <input id="change_status_popup" value="<?php echo 'Did you receive change orders from ' . $bank_data['st_type'] . ' personnel?'; ?>" type="hidden">
                    
                    <?php
                }else{
                    if( isset( $driver_job['type'] ) && $driver_job['type'] == "bank" ){
                        $bank_data = $pickup->get_job_address_data( $job_id , '', 'bank' );
                        $st_type = isset( $bank_data['st_type'] ) && $bank_data['st_type'] != '' ? $bank_data['st_type'] : '';
                        $bank_name = isset( $bank_data['st_add'] ) && $bank_data['st_add'] != '' ? $bank_data['st_add'] : '';
                        $bank_lat = isset( $bank_data['in_latitude'] ) && $bank_data['in_latitude'] != '' ? $bank_data['in_latitude'] : '';
                        $bank_log = isset( $bank_data['in_longitude'] ) && $bank_data['in_longitude'] != '' ? $bank_data['in_longitude'] : '';
                        $bank_plus = preg_replace( '/\s/ ', '+', $bank_name );
                        if( $driver_job['status'] == "assign" ){
                            ?>
                            <div class="panel-body">
                                <div class="">
                                    <h5>
                                        <?php 
                                        if( $st_type == 'other' ){
                                            ?>
                                            Now navigate to the <?php echo $st_type . "Address"; 
                                        }else{
                                            ?>
                                            Now navigate to the <?php echo $st_type; 
                                        }
                                        ?>
                                    </h5>
                                </div>
                                <div class=""><h5>Navigate to <?php echo $bank_name; ?></h5></div>
                                <div class="col-md-12">
                                    <div id="location"></div>
                                    <input type="hidden" id="start_latlog"/>
                                    <input type="hidden" id="end_latlog" value="<?php echo $bank_lat . ',' . $bank_log; ?>"/>
                                </div>
                            </div>
                            <div class="panel-footer col-md-12"> 
                                <a href="#" class="" id="navigate_mid_point" data-job-id="<?php echo $job_id;?>">
                                    <button  class="btn btn-info btn-lg">
                                        <?php 
                                        if( $st_type == 'other'){
                                            ?>
                                            Navigate <?php echo $st_type . "Address"; 
                                        }else{
                                            ?>
                                            Navigate at <?php echo $st_type; 
                                        }
                                        ?>
                                    </button>
                                </a>
                            </div>
                            <input id="change_status_popup" value="<?php echo 'Are you sure you want to navigate to bank?'; ?>" type="hidden">
                            <input id="mid_type" value="bank" type="hidden">
                            <input id="st_status" value="start" type="hidden">
                            <?php
                        }else{
                            ?>
                            <div class="panel-body">
                                <div class="">
                                    <h5>
                                        <?php 
                                        if( $st_type == 'other' ){
                                            ?>
                                            Now navigate to the <?php echo $st_type . "Address"; 
                                        }else{
                                            ?>
                                            Now navigate to the <?php echo $st_type; 
                                        }
                                        ?>
                                    </h5>
                                </div>
                                <div class=""><h5>Navigate to <?php echo $bank_name; ?></h5></div>
                                <div class="col-md-12">
                                    <div id="location"></div>
                                    <input type="hidden" id="start_latlog"/>
                                    <input type="hidden" id="end_latlog" value="<?php echo $bank_lat . ',' . $bank_log; ?>"/>
                                </div>
                            </div>
                            <div class="panel-footer col-md-12"> 
                                <a href="#" class=""  id="navigate_mid_point"  data-job-id="<?php echo $job_id;?>">
                                    <button  class="btn btn-info btn-lg">
                                        <?php 
                                        if( $st_type == 'other' ){
                                            ?>
                                            Arrived at <?php echo $st_type . "Address"; 
                                        }else{
                                            ?>
                                             Arrived at <?php echo $st_type; 
                                        }
                                        ?>
                                    </button>
                                </a>
                            </div>
                            <input id="change_status_popup" value="<?php echo 'Are you sure you Arrived at ' . $st_type . ' ?'; ?>" type="hidden">
                            <input id="mid_type" value="bank" type="hidden">
                            <input id="st_status" value="completed" type="hidden">
                            <?php
                        }
                    }else{
                        
                        foreach( $driver_job as $d_job ){
                            if( $d_job['job_status'] == "interrupt" ){
                                 echo "<script>
                                    window.location.href = '" . VW_DRIVER_ARCHIVED_JOBS . "';</script>";
                            }
                            if( isset( $d_job['dt_pickup'] ) && $d_job['dt_pickup'] ){
                                $curr_date = date( "Y-m-d" );
                                $newDate = date( "Y-m-d", strtotime( $d_job['dt_pickup'] ) );

    //                            if( $curr_date == $newDate ){
    //                                $disable = "";
    //                            }else{
    //                                 echo "<script>
    //                                window.location.href = '" . VW_DRIVER_MYJOBS . "';</script>";
    //                            }
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                        <?php
                                        if( $d_job['st_order_type'] == "change_order" ) {
                                            echo "Change Order #" . $d_job['in_pickup_id']; 
                                        }else{
                                            echo "Pick-up #" . $d_job['in_pickup_id']; 
                                        }?></h3>
                                    </div>
                                    <?php 
                                        if( isset( $d_job['location'] ) ){
                                        ?>
                                            <div class="panel-body">
                                                <!--<h3><?php //echo $d_job['location']['st_location_name']; ?></h3>-->
                                                <p><?php echo $d_job['location']['st_address']; ?></p>
                                            </div>
                                        <?php
                                        }
                                    ?> 

                                </div>
                            </div>
                            <?php
                                $pickup_location_plus = preg_replace( '/\s/ ', '+', $d_job['location']['st_address'] );
                                $job_status = $pickup->get_job_by_key( $job_id, 'st_status' );
                                if( isset( $job_status ) && $job_status != 'completed' ){
                                    $jobstatus = "in_progress";
                                }
                                if( isset( $d_job['st_status'] ) && $d_job['st_status'] == 'assign' ){
                                    $pickup_status = "onroute";
                                }else if( isset( $d_job['st_status'] ) && $d_job['st_status'] == 'onroute' ){
                                    $pickup_status = "arrived";
                                }else if( isset( $d_job['st_status'] ) && $d_job['st_status'] == 'arrived' ){
                                    $pickup_status = "completed";
                                }
                                if( $d_job['st_status'] == "assign" ){
                                ?>
                                <div class="panel-footer col-md-12">    
                                    <a href="#" class="change_driver_job_status" id="change_status_popup_request" data-pick-id="<?php echo $d_job['in_pickup_id']; ?>" data-job-id="<?php echo $job_id;?>" data-same-loc-pick-id="<?php echo $d_job['same_location']?>">
                                        <button  class="btn btn-success btn-lg">Ready To Start?</button>
                                    </a>
                                <?php 
                                }else if( $d_job['st_status'] == "onroute" ){

                                ?>
                                <div class="panel-footer col-md-12">
                                    <div id="location"></div>
                                    <input type="hidden" id="start_latlog"/>
                                    <input type="hidden" id="end_latlog" value="<?php echo $d_job['location']['in_latitude'] . ',' . $d_job['location']['in_longitude']; ?>"/>
                                    <a href="#" class="change_driver_job_status" id="change_status_popup_request" data-pick-id="<?php echo $d_job['in_pickup_id']; ?>" data-job-id="<?php echo $job_id;?>" data-same-loc-pick-id="<?php echo $d_job['same_location']?>">
                                        <button  class="btn btn-info btn-lg">Tap On Arrival</button>
                                    </a>
                                    <a href="#" class="em_stop_job"  data-job-id="<?php echo $job_id;?>" data-pickup-id="<?php echo $d_job['in_pickup_id']; ?>" ><button  class="btn btn-danger btn-lg">Emergency Stop</button></a>
                                <?php
                                } else if( $d_job['st_status'] == "pause" ){

                                ?>
                                <div class="panel-footer col-md-12">
                                    <div id="location"></div>
                                    <input type="hidden" id="start_latlog"/>
                                    <input type="hidden" id="end_latlog" value="<?php echo $d_job['location']['in_latitude'] . ',' . $d_job['location']['in_longitude']; ?>"/>
                                    <a href="#" class="resume_pickup"  data-job-id="<?php echo $job_id;?>" data-pickup-id="<?php echo $d_job['in_pickup_id']; ?>" >
                                        <button  class="btn btn-danger btn-lg loader">Resume</button>
                                    </a>
                                <?php
                                } else if( $d_job['st_status'] == "arrived" ){
                                ?>
                                <div class="col-md-12">
                                    <div id="location"></div>
                                    <input type="hidden" id="start_latlog"/>
                                    <input type="hidden" id="end_latlog" value="<?php echo $d_job['location']['in_latitude'] . ',' . $d_job['location']['in_longitude']; ?>"/>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Please verify the store manager
                                        </div>

                                        <div class="panel-body">

                                            <div class="form-group">
                                                <label class="col-md-3">Store Manager Name<span class="required-feild">*</span></label>
                                                <div class="col-md-9">
                                                    <input type="text" required="" class="form-control" id="txt_manager_name" name="txt_manager_name" />
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3">License number<span class="required-feild">*</span></label>
                                                <div class="col-md-9">
                                                    <input type="text" required="" class="form-control" id="txt_license_no" name="txt_license_no" />
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3">Note( Optional ):</label>
                                                <div class="col-md-9">
                                                    <textarea required="" class="form-control" id="pickup_note" name="pickup_note"></textarea>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-footer col-md-12"> 
                                    <a href="#" class="change_driver_job_status" id="change_status_popup_request" data-pick-id="<?php echo $d_job['in_pickup_id']; ?>" data-job-id="<?php echo $job_id;?>" data-same-loc-pick-id="<?php echo $d_job['same_location']?>">
                                        <button  class="btn btn-info btn-lg">Tap To Complete</button>
                                    </a>
                                    <?php $s_lid = ( isset( $d_job['same_location']) && $d_job['same_location'] > 0 ) ? $d_job['same_location'] : '0' ?>
                                    <a href="#" class="resend_mail" data-manager-id="<?php echo $d_job['in_manager_id']; ?>" data-pick-id="<?php echo $d_job['in_pickup_id']; ?>" data-location_name="<?php //echo $d_job['location']['st_location_name'];?>" data-same-loc-id="<?php echo $s_lid;?>">
                                        <button  class="btn btn-info btn-lg">Resend Mail</button>
                                    </a>


                                <?php } else if( $d_job['st_status'] == "completed" ){
                                ?>
                                <div class="col-md-12">
                                    <div id="location"></div>
                                    <input type="hidden" id="start_latlog"/>
                                    <input type="hidden" id="end_latlog" value="<?php echo $d_job['location']['in_latitude'] . ',' . $d_job['location']['in_longitude']; ?>"/>
                                </div>
                                <div class="panel-footer col-md-12"> 

                                    <?php if( $d_job['st_driver_verify'] == 1 ){ ?>
                                        <a href="#" class="" id="check_sm_verify" data-pick-id="<?php echo $d_job['in_pickup_id']; ?>" data-job-id="<?php echo $job_id;?>">
                                            <button  class="btn btn-info btn-lg">Navigate to next</button>
                                        </a>
                                    <?php } ?>
                                <?php } ?>

                                </div>

                                <?php 
                                    $info_ms = '';
                                    if( $d_job['st_status'] == "assign" ){
                                        $info_ms = 'Are you ready to start this Pick up?';
                                    }else if ( $d_job['st_status'] == "onroute" ) {
                                        
                                        $info_ms = "You appear to be far from the pick-up location. Confirm arrival";
                                    }else if ( $d_job['st_status'] == "arrived" ) {
                                        if( $d_job['st_order_type'] == "change_order" ){
                                             $info_ms = 'Confirm package delivery';
                                        }else{
                                             $info_ms = 'Have you collected the package?';
                                        }

                                    }
                                ?>
                                <input id="change_status_popup" value="<?php echo $info_ms; ?>" type="hidden">

                            </div>
                            <?php
                        }
                    }
                }
                ?>
                <input type="hidden" name="pickup_status" id="pickup_status" value="<?php echo $pickup_status; ?>"/>
                <input type="hidden" name="job_status" id="job_status" value="<?php echo $jobstatus; ?>"/>
                <?php
            }else{
                if( isset( $check_pickup_exists ) && $check_pickup_exists != "" ){
                    
                ?>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Trip #<?php echo $job_id; ?> Completed</h3>
                        </div>
                        <?php 
                        $bank_data = $pickup->get_job_address_data( $job_id );
                        $st_type = isset( $bank_data['st_type'] ) && $bank_data['st_type'] != '' ? $bank_data['st_type'] : '';
                        $bank_name = isset( $bank_data['st_add'] ) && $bank_data['st_add'] != '' ? $bank_data['st_add'] : '';
                        $bank_lat = isset( $bank_data['in_latitude'] ) && $bank_data['in_latitude'] != '' ? $bank_data['in_latitude'] : '';
                        $bank_log = isset( $bank_data['in_longitude'] ) && $bank_data['in_longitude'] != '' ? $bank_data['in_longitude'] : '';
                        $bank_plus = preg_replace( '/\s/ ', '+', $bank_data['st_add'] );
                        ?>
                        <div class="panel-body">
                            <div class="">
                                <h5>
                                    <?php 
                                    //     if( $st_type == 'other' ){
                                    // ?>
                                          <!--Now navigate to the -->
                                          <?php //echo $st_type . "Address"; 
                                    // }else{
                                    //     ?>
                                    <!--//       Now navigate to the -->
                                    <?php //echo $st_type; 
                                    // }
                                    ?>
                                </h5>
                            </div>
                            <div class=""><h5>Navigate to <?php echo $bank_name; ?></h5></div>
                            <div class="col-md-12">
                                <div id="location"></div>
                                <input type="hidden" id="start_latlog"/>
                                <input type="hidden" id="end_latlog" value="<?php echo $bank_lat . ',' . $bank_log; ?>"/>
                            </div>
                        </div>
                        <div class="panel-footer col-md-12"> 
                            <a href="#" class="" data-st_type="<?php echo $st_type; ?>" id="job_completed" data-job-id="<?php echo $job_id;?>">
                                <button  class="btn btn-info btn-lg">
                                    <?php 
                                        if( $st_type == 'other' ){
                                    ?>
                                        Arrived
                                        <?php
                                    }else{
                                        ?>
                                         Arrived
                                         <?php
                                    }
                                    ?></button>
                            </a>
                        </div>
                    </div>
                </div>
                
                <input id="change_status_popup" value="<?php echo 'Are you sure you want to mark this job as complete?'; ?>" type="hidden">
                <?php
            }else{
                $update_id = $pickup->driver_job_complete( $job_id );
                 echo "<script>
                window.location.href = '" . VW_DRIVER_MYJOBS . "';</script>";
            } 
                
            }
            ?>
                    
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
<script type="text/javascript" src="<?php echo JS_PATH; ?>location.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>pickup.js"></script>

<script>
    google.maps.event.addDomListener(window, 'load', initMap);
    var map;
    var geocoder;
    function initMap() {

        geocoder = new google.maps.Geocoder();
        
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
//                var pos = {
//                    lat: position.coords.latitude,
//                    lng: position.coords.longitude
//                };
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                var directionsService = new google.maps.DirectionsService;
                var directionsDisplay = new google.maps.DirectionsRenderer;
                $( '#start_latlog' ).val( lat + ',' + lng );
                map = new google.maps.Map(document.getElementById('location'), {
                    zoom: 7,
                    center: {lat: 41.85, lng: -87.65}
                });
                
                directionsDisplay.setMap( map );
                directionsService.route({
                    origin: document.getElementById( 'start_latlog' ).value,
                    destination: document.getElementById( 'end_latlog' ).value,
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
</script>
<?php
include_once FL_LOGIN_FOOTER;
?>