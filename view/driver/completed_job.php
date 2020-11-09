<?php 
session_start();
require_once '../../config/config.php';
require_once '../../backend/config/admin_config.php';
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
?>
<!-- PAGE CONTENT -->
<div class="page-content">

    <!-- START X-NAVIGATION VERTICAL -->
    <?php  include_once FL_LOGIN_SUB_HEADER;?> 
    <!-- END X-NAVIGATION VERTICAL -->    


    <!-- PAGE CONTENT WRAPPER -->
    
    <div class="page-content-wrap">
        <div class="page-title">                    
            <h2>Completed Trips</h2>
        </div>
        <!-- START WIDGETS -->                    
        <div class="row">
            <?php $driver_job = $pickup->get_job_data( 'driver', $user_id, 'completed' );
            if( isset( $driver_job ) && is_array( $driver_job ) ){
                foreach( $driver_job as $d_job ){
                    ?>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Missed Trip #<?php echo $d_job['in_job_id'];?> </h3>
                                
                            </div>
                            <?php 
                                if( isset( $d_job['location'] ) && is_array( $d_job['location'] ) ){
                                    $location_count = count( $d_job['location'] );
                                    ?>
                                        <div class="panel-body">
                                            <h4>You have to deliver packets to <?php echo $location_count; ?> 
                                                location(s). To start the first location click the "Go to" button</h4>
                                        </div>
                                    <?php
                                }
                            ?> 
                            
                        </div>
                    </div>
                    
                    <?php
                }
            }  else{
                ?>
                <div class="col-md-12 ">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                No job Available
                            </h3>
                        </div>
                    </div>
                </div>
                <?php
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

<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyAI2Jc0LEvGW1LwaXD49hPL9bTk0uIKwR8"></script>
<script type="text/javascript" src="<?php echo JS_PLUGINS_PATH; ?>location-picker/locationpicker.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>location.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>pickup.js"></script>
<?php
include_once FL_LOGIN_FOOTER;
?>