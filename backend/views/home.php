<?php 
require_once '../../config/config.php';
require_once '../config/admin_config.php';
if( !isset( $_SESSION['user_id'] ) && !isset( $_SESSION['user_type'] ) ){
    header( "location:" . BASE_URL );
} else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] != "admin"  ){	
    header( "location:" . BASE_URL );
}
include_once FL_LOGIN_HEADER;
include_once FL_LOGIN_SIDEBAR;

include_once FL_USER;
$user = new user();
include_once FL_LOCATION;
$location = new location();
include_once FL_PICKUP;
$pickup = new pickup();
include_once FL_ACTIVITY;
$activity = new activity();    
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
                        <h3 class="panel-title">Admin</h3>
                    </div>
                    <div class="panel-body">
                    <!-- START DATATABLE EXPORT -->
                        <?php 
                        $all_userdata = $pickup->get_admin_unassign_pickups( 'all' );
                       if( isset( $all_userdata ) && $all_userdata != '' ){
                            $count_unassign_pickup = count( $all_userdata );
                        }else{
                            $count_unassign_pickup = 0;
                        }
                        ?>    
                        <h3 class="main-title">You have received ( <?php echo $count_unassign_pickup; ?> ) new Pick UP request </h3>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                              <a href="<?php echo VW_ADMIN_USER_LIST; ?>" class="center-block main-box">
                                  <span class="fa fa-user"></span>
                                  <h4>User List</h4>
                              </a>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                              <a href="<?php echo VW_ADMIN_GROUP_LIST; ?>" class="center-block main-box">
                                  <span class="fa fa-users"></span>
                                  <h4>Group List</h4>
                              </a>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                              <a href="<?php echo VW_ADMIN_PICK_LIST; ?>" class="center-block main-box">
                                  <span class="fa fa-location-arrow"></span>
                                  <h4>Pick UP List</h4>
                              </a>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                              <a href="<?php echo VW_ADMIN_DRIVER_PICKUP_AMT; ?>" class="center-block main-box">
                                  <span class="fa fa-dollar"></span>
                                  <h4>Driver Completions</h4>
                              </a>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                              <a href="<?php echo VW_ADMIN_GENERAL_SETTING; ?>" class="center-block main-box">
                                  <span class="fa fa-cog"></span>
                                  <h4>Settings</h4>
                              </a>
                        </div>
                        <!--<div class="col-xs-12 col-sm-6 col-md-4">-->
                        <!--    <a href="<?php //echo VW_ADMIN_INTERRUPT_JOB; ?>" class="center-block main-box">-->
                        <!--        <span class="fa fa-dot-circle-o"></span>-->
                        <!--        <h4>Modified Trips</h4>-->
                        <!--    </a>-->
                        <!--</div>-->
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <a href="<?php echo VW_ADMIN_REPORT; ?>" class="center-block main-box">
                                <span class="fa fa-file"></span>
                                <h4>Reports</h4>
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                              <a href="<?php echo VW_ADMIN_ACTIVITY_LOG ; ?>" class="center-block main-box">
                                   <span class="fa fa-list-alt"></span>
                                   <h4>Activity Logs</h4>
                              </a>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <a href="<?php echo VW_ADMIN_DRIVER_LIST; ?>" class="center-block main-box">
                                <span class="fa fa-bars"></span>
                                <h4>Driver List</h4>
                            </a>
                        </div> 
                    </div>
                </div>

                    <!-- END DATATABLE EXPORT --> 
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