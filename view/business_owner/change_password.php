<?php 
session_start();
require_once '../../config/config.php';
require_once '../../backend/config/admin_config.php';
if( !isset( $_SESSION['user_id'] ) && !isset( $_SESSION['user_type'] ) ){
    header( "location:" . BASE_URL );
} else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] != "business_owner" && $_SESSION['user_type'] != "driver" && $_SESSION['user_type'] != "admin" ){	
    header( "location:" . BASE_URL );
}
include_once FL_LOGIN_HEADER;
include_once FL_LOGIN_SIDEBAR;

include_once FL_USER;
$user = new user();
if( isset( $_SESSION['user_id'] ) &&  $_SESSION['user_id'] != "" ){
    $user_id = $_SESSION['user_id'];
} else if ( isset( $_SESSION['admin_id'] ) &&  $_SESSION['admin_id'] != "" ){
    $user_id = $_SESSION['admin_id'];
} else{
    
}
 
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
                    <div class="panel-body"> 
                        <div class="panel-heading">
                            <h3 class="panel-title" style="text-transform: capitalize">Change Password</h3>
                            
                        </div>
                        <div class="page-content-wrap" style="margin-top:20px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-success alert-dismissable change_password-success hide-el" style="display: none;">

                                        <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                        <span class="change_password-msg"></span>

                                    </div>

                                    <div class="alert alert-danger alert-dismissable change_password-failed hide-el" style="display: none;">

                                        <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                        <span class="change_password-msg"></span>

                                    </div>
                                    <form id="frm_change_password" name="frm_change_password"  method="post" role="form" class="form-horizontal" action="">                            
                                        <div class="form-group">
                                            <label class="col-md-3">Old Password:</label>
                                            <div class="col-md-9">
                                                <input type="password" class=" form-control" id="txt_old_pwd" name="txt_old_pwd"/>
                                                <span class="help-block">Required</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3">New Password:</label>
                                            <div class="col-md-9">
                                                <input type="password" class=" form-control" id="txt_new_pwd" name="txt_new_pwd"/>
                                                <span class="help-block">Required</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3">Confirm Password:</label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control" id="txt_new_cpwd" name="txt_new_cpwd"/>
                                                <span class="help-block">Required</span>
                                            </div>                          
                                        </div>
                                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>"/>
                                        <div class="btn-group pull-right">
                                            <button class="btn btn-primary" type="submit">Submit</button>
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

<?php
require_once FL_LOGIN_FOOTER_INCLUDE;
?>
<script type='text/javascript' src="<?php echo ADMIN_JS_PLUGINS_PATH .'icheck/icheck.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'mcustomscrollbar/jquery.mCustomScrollbar.min.js'; ?>"></script>
 

<?php
include_once FL_LOGIN_FOOTER;
?>