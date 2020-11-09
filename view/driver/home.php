<?php 
session_start();
require_once '../../config/config.php';
require_once '../../backend/config/admin_config.php';
if( !isset( $_SESSION['user_id'] ) && !isset( $_SESSION['user_type'] ) ){
    header( "location:" . BASE_URL );
} else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] != "driver"  ){	
    header( "location:" . VW_LOGOUT );
}
include_once FL_LOGIN_HEADER;
include_once FL_LOGIN_SIDEBAR;

include_once FL_USER;
$user = new user();
$user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] != '' ? $_SESSION['user_id'] : '';    
$user_signup_attempt = $user->get_user_meta( $user_id, 'user_signup_attempt', TRUE ); 
$admin_user_reject_attempt = $user->get_user_meta( $user_id, 'admin_user_reject_attempt', TRUE ); 
?>
<!-- PAGE CONTENT -->
<div class="page-content">

    <!-- START X-NAVIGATION VERTICAL -->
    <?php  include_once FL_LOGIN_SUB_HEADER;?> 
    <!-- END X-NAVIGATION VERTICAL -->    


    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <!-- START WIDGETS -->                    
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Driver</h3>
                    </div>
                    <div class="panel-body">
                        <?php 
                            $all_userdata = $user->get_user_data_by_key( $user_id );
                            if ( isset( $all_userdata ) &&  $all_userdata['in_is_approve'] == "-1" || $all_userdata['in_is_approve'] == "-2" ||  $all_userdata['in_is_approve'] == "-3" ) {
                                echo "<p>Your account has been rejected by admin. Kindly refer the given reason: " . $all_userdata['st_reason'] . "</p>";    
                                if( $user_signup_attempt == $admin_user_reject_attempt  && $user_signup_attempt <= 2 ){
                                ?>
                                <div class="alert alert-success alert-dismissable info-success hide-el" style="display: none;">
                                    <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                                    <span class="info-msg"></span>
                                </div>

                                <div class="alert alert-danger alert-dismissable info-failed hide-el" style="display: none;">
                                    <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                                    <span class="info-msg"></span>
                                </div>
                                <form method="post" action="" id="driver_edit" name="driver_edit">
                                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                                    <input type="hidden" name="txt_user_type" value="driver">
                                    <div class="form-group">
                                        <label class="col-md-3" for="txt_first_name">First Name:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txt_first_name" name="txt_first_name" value="<?php echo isset( $all_userdata['st_first_name'] ) && $all_userdata['st_first_name'] != '' ? $all_userdata['st_first_name'] : '' ; ?>"/>
                                            <span class="help-block">Required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3" for="txt_last_name">Last Name:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txt_last_name" name="txt_last_name" value="<?php echo isset( $all_userdata['st_last_name'] ) && $all_userdata['st_last_name'] != '' ? $all_userdata['st_last_name'] : ''; ?>"/>
                                            <span class="help-block">Required</span>
                                        </div>
                                    </div>
                                    <?php 
                                        $license_no = $user->get_driver_data_by_key( $user_id , 'in_license_no' )
                                    ?>
                                    <div class="form-group">
                                        <label class="col-md-3" for="txt_liece">License No:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txt_liece" name="txt_liece" value="<?php echo $license_no; ?>"/>
                                            <span class="help-block">Required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3" for="txt_phone_no">Phone Number:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txt_phone_no" name="txt_phone_no" value="<?php echo isset( $all_userdata['in_contact_no'] ) && $all_userdata['in_contact_no'] != '' ? $all_userdata['in_contact_no'] : ''; ?>"/>
                                            <span class="help-block">Required</span>
                                        </div>
                                    </div>
                                    <input type="hidden" id="user_request" name="user_request" value="1"/>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-primary" type="submit">Save Changes</button>
                                    </div> 
                                </form>
                                <?php
                                }
                            }else if ( isset( $all_userdata ) &&  $all_userdata['in_is_approve'] == "" ) {
                                echo "<p>Thank you for registering with Cop Express. We are currently reviewing your account and we’ll be in touch shortly." . "</p>";
                            }else if ( isset( $all_userdata ) &&  $all_userdata['in_is_approve'] == 0 ) {
                                echo "<p>Thank you for registering with Cop Express. We are currently reviewing your account and we’ll be in touch shortly." . "</p>";
                            }else if (  isset( $all_userdata ) &&  $all_userdata['in_is_approve'] == 1 ){
                                $driver_job = $pickup->get_pending_driver_jobs();
                                if( isset( $driver_job ) && $driver_job != '' ){
                                    $driver_available_jobs_count = count( $driver_job ) ;
                                }else{
                                    $driver_available_jobs_count = 0;
                                }
                                ?>
                                <h3 class="main-title">You have ( <?php echo $driver_available_jobs_count; ?> ) available jobs in your Available jobs list. </h3>
                                <?php
                                    $driver_job = $pickup->get_driver_jobs( $_SESSION['user_id'] );
                                    if( isset( $driver_job ) && $driver_job != '' ){
                                        $driver_my_jobs_count = count( $driver_job ) ;
                                    }else{
                                        $driver_my_jobs_count = 0;
                                    }
                                ?>
                                <h3 class="main-title">You have ( <?php echo $driver_my_jobs_count; ?> ) jobs in your My jobs list.</h3>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <a href="<?php echo VW_DRIVER_MYACCOUNT; ?>" class="center-block main-box">
                                        <span class="fa fa-user"></span>
                                        <h4>My Account</h4>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <a href="<?php echo VW_DRIVER_PENDINGJOBS; ?>" class="center-block main-box">
                                        <span class="fa fa-bell"></span>
                                        <h4>Available Jobs</h4>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <a href="<?php echo VW_DRIVER_MYJOBS; ?>" class="center-block main-box">
                                        <span class="fa fa-truck"></span>
                                        <h4>My Jobs</h4>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <a href="<?php echo VW_DRIVER_PICKUP_AMOUNT; ?>" class="center-block main-box">
                                        <span class="fa fa-dollar"></span>
                                        <h4>Driver Completions</h4>
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <a href="<?php echo VW_DRIVER_REPORT; ?>" class="center-block main-box">
                                        <span class="fa fa-file"></span>
                                        <h4>Reports</h4>
                                    </a>
                                </div>  
                                 
                                <?php
                            }
                        ?>
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
<?php
include_once FL_LOGIN_FOOTER;
?>