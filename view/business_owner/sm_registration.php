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
$user_id = isset( $_SESSION['user_id'] ) &&  $_SESSION['user_id'] != "" ? $_SESSION['user_id'] : '';  
$bo_data = $user->get_bo_data_by_key( $user_id, 'in_store_manager_id' );
if( isset( $bo_data ) && $bo_data > 0 ){
    $sm_email_id = $user->get_user_data_by_key( $bo_data, 'st_email_id' );
    $sm_password_id = $user->get_user_data_by_key( $bo_data, 'st_email_id' );
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
                    <div class="panel-heading">
                        <h3 class="panel-title">Store Manager</h3>
                        <?php if( isset( $bo_data ) && $bo_data > 0 ){ ?>
                            <a href="#" class="a-pickup edit_sm"><div class="btn btn-danger">Edit</div></a>
                        <?php } ?>
                        <?php
                        $disable = '';
                        if( isset( $bo_data ) && $bo_data > 0 ){ 
                            $disable = "disabled";
                        } ?>
                    </div>
                    <div class="panel-body">
                        <form name="frm_sm_registration" id="frm_sm_registration"  method="post" role="form" class="form-horizontal" action="">                            
                            <div class="form-group">
                                <label for="txt_email_address" class="col-md-3">E-mail Address:</label>
                                <div class="col-md-9">
                                    <input type="text" <?php echo $disable; ?> placeholder="E-mail Address" value="<?php echo isset( $sm_email_id ) && $sm_email_id != '' ? $sm_email_id : '' ?>" id="txt_email_address" name="txt_email_address" class="input-field form-control">
                                </div>                          
                            </div>
                            <div class="form-group">
                                <label for="txt_pwd" class="col-md-3">Password:</label>
                                <div class="col-md-9">
                                    <input type="password" <?php echo $disable; ?> placeholder="Password" id="txt_pwd" name="txt_pwd" class="input-field form-control">
                                </div>                          
                            </div>
                            <div class="form-group">
                                <label for="txt_crm_pwd" class="col-md-3">Confirm Password:</label>
                                <div class="col-md-9">
                                    <input type="password" <?php echo $disable; ?> placeholder="Confirm Password" id="txt_crm_pwd" name="txt_crm_pwd" class="input-field form-control">
                                </div>                          
                            </div>
                            <input type="hidden" value="store_manager" name="txt_user_type"/>
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>"/>
                            <input type="hidden" name="sm_id" id="sm_id" value="<?php echo $bo_data;?>"/>
                            
                            <div class="btn-group pull-right">
                                <button class="btn btn-primary loader" id="submit_edit_sm" <?php echo $disable; ?> type="submit">Submit</button>
                            </div>                                                                
                        </form>
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