<?php 
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
                        <h3 class="panel-title">Business Owner</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                            $all_userdata = $user->get_user_data_by_key( $user_id );
                            if ( isset( $all_userdata ) &&  $all_userdata['in_is_approve'] == "-1" ) {
                                echo "<p>Your account has been rejected by admin. Kindly refer the given reason: " . $all_userdata['st_reason'] . "</p>"; 
                                if( $user_signup_attempt == $admin_user_reject_attempt && $user_signup_attempt <= 2 ){
                                ?>
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
                                    <div class="form-group">
                                        <label class="col-md-3" for="txt_phone_no">Phone Number:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txt_phone_no" name="txt_phone_no" value="<?php echo isset( $all_userdata['in_contact_no'] ) && $all_userdata['in_contact_no'] != '' ? $all_userdata['in_contact_no'] : '' ; ?>"/>
                                            <span class="help-block">Required</span>
                                        </div>
                                    </div>
                                    <?php 
                                    $business_name = $user->get_bo_data_by_key( $user_id, 'st_business_name' );
                                    $eni_no = $user->get_bo_data_by_key( $user_id, 'in_eni_number' );
                                    $job_title = $user->get_bo_data_by_key( $user_id, 'st_job_title' );
                                    ?>
                                    <div class="form-group">
                                        <label class="col-md-3" for="txt_business_name">Business Name:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txt_business_name" name="txt_business_name" value="<?php echo isset( $business_name ) && $business_name != '' ? $business_name : '' ;  ?>"/>
                                            <span class="help-block">Required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3" for="txt_eni_no">ENI Number:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txt_eni_no" name="txt_eni_no" value="<?php echo isset( $eni_no ) && $eni_no != '' ? $eni_no : '' ;  ?>"/>
                                            <span class="help-block">Required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3" for="txt_job_title">Trip Title:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txt_job_title" name="txt_job_title" value="<?php echo isset( $job_title ) && $job_title != '' ? $job_title : '' ;  ?>"/>
                                            <span class="help-block">Required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3" for="txt_address_1">Address Line 1:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txt_address_1" name="txt_address_1" value="<?php echo isset( $all_userdata['st_address_1'] ) && $all_userdata['st_address_1'] != '' ? $all_userdata['st_address_1'] : '' ; ?>"/>
                                            <span class="help-block">Required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3" for="txt_address_2">Address Line 2:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txt_address_2" name="txt_address_2" value="<?php echo isset( $all_userdata['st_address_2'] ) && $all_userdata['st_address_2'] != '' ? $all_userdata['st_address_2'] : '' ; ?>"/>
                                            <span class="help-block">Required</span>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-3" for="txt_city">City:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txt_city" name="txt_city" value="<?php echo $all_userdata['st_city']; ?>"/>
                                            <span class="help-block">Required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3" for="txt_city">State:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txt_state" name="txt_state" value="<?php echo $all_userdata['st_state']; ?>"/>
                                            <span class="help-block">Required</span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_request" value="1"/>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-primary loader" type="submit">Save Changes</button>
                                    </div> 
                                </form>
                                <?php
                                }
                            }else if ( isset( $all_userdata ) &&  $all_userdata['in_is_approve'] == "" ) {
                                echo "<p>Your account has been submitted for approval, thank you for your patience." . "</p>";    
                            }else if ( isset( $all_userdata ) &&  $all_userdata['in_is_approve'] == 0 ) {
                                echo "<p>Thank you for registering with Cop Express. We are currently reviewing your account and we’ll be in touch shortly." . "</p>";
                            }else if(  isset( $all_userdata ) &&  $all_userdata['in_is_approve'] == 1 ){
                            $manager_ids = $location->get_location_data_by( 'in_user_id' , $id );
                            $arr_managerids = array();
                            if( isset( $manager_ids ) && $manager_ids > 0  ){
                                if( isset( $manager_ids['in_manager_id'] ) ){
                                    $manager_ids = array( $manager_ids );
                                }
                                foreach( $manager_ids as $mk => $mv ){
                                    array_push( $arr_managerids , $mv['in_manager_id'] );
                                }
                                $arr_manager_id = array_unique( $arr_managerids );
                                if( isset( $arr_manager_id ) && is_array( $arr_manager_id )){
                                    $pickup_count = $pickup->get_pickups_pending_for_approve( $arr_manager_id ); 
                                }
                            }
                            ?>
                                <h3 class="main-title">You have received <?php echo $pickup_count; ?> new change order requests in your Change Orders list.</h3>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                      <a href="<?php echo VW_BO_MYACCOUNT; ?>" class="center-block main-box">
                                          <span class="fa fa-user"></span>
                                          <h4>My Account</h4>
                                      </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                      <a href="<?php echo VW_MY_LOCATIONS; ?>" class="center-block main-box">
                                          <span class="fa fa-map-marker"></span>
                                          <h4>My Locations</h4>
                                      </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                      <a href="<?php echo VW_NEW_PICKUP; ?>" class="center-block main-box">
                                          <span class="fa fa-location-arrow"></span>
                                          <h4>Add Pick Up</h4>
                                      </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                      <a href="<?php echo VW_RECURRING_LIST; ?>" class="center-block main-box">
                                          <span class="fa fa-retweet"></span>
                                          <h4>Recurring List</h4>
                                      </a>
                                </div>
                                <!--<div class="col-xs-12 col-sm-6 col-md-4">-->
                                <!--      <a href="<?php //echo VW_INTERRUPT_JOB; ?>" class="center-block main-box">-->
                                <!--          <span class="fa fa-dot-circle-o"></span>-->
                                <!--          <h4>Modified Trips</h4>-->
                                <!--      </a>-->
                                <!--</div>-->
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                      <a href="<?php echo VW_CHANGE_ORDERS; ?>" class="center-block main-box">
                                          <span class="fa fa-rotate-left"></span>
                                          <h4>Change Orders</h4>
                                      </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                      <a href="<?php echo VW_SM_REGISTRATION; ?>" class="center-block main-box">
                                           <span class="fa fa-users"></span>
                                           <h4>Store Manager</h4>
                                      </a>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                      <a href="<?php echo VW_BO_REPORT; ?>" class="center-block main-box">
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