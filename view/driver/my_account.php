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
$userdata = $user->get_user_data_by_key( $user_id );
?>
<!-- PAGE CONTENT -->
<div class="page-content">

    <!-- START X-NAVIGATION VERTICAL -->
    <?php  include_once FL_LOGIN_SUB_HEADER;?> 
    <!-- END X-NAVIGATION VERTICAL -->    

<div class="page-content-wrap">
    <div class="row">
    <!-- PAGE CONTENT WRAPPER -->
    <div class="panel panel-default">
        <div class="tab-pane active" >
            <div class=" tabs">
                    <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="#my_information" data-toggle="tab">My Information</a></li>
                    <li><a href="#change_email_password" data-toggle="tab">Change Email/Password</a></li>
                </ul>
                <div class="panel-body tab-content">
                    <div class="tab-pane active" id="my_information" role="tabpanel">
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
                                    <form method="post" action="" id="driver_edit" name="driver_edit">
                                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                                        <input type="hidden" name="txt_user_type" value="driver">
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
                                        <?php 
                                            $license_no = $user->get_driver_data_by_key( $user_id , 'in_license_no' )
                                        ?>
                                        <div class="form-group">
                                            <label class="col-md-3" for="txt_liece">License No<span class="required-feild">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="txt_liece" name="txt_liece" value="<?php echo $license_no; ?>"/>
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
                                        <div class="form-group">
                                            <label class="col-md-3" for="txt_address_1">Address Line 1<span class="required-feild">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="txt_address_1" name="txt_address_1" value="<?php echo $userdata['st_address_1']; ?>"/>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3" for="txt_address_2">Address Line 2:</label>
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
                                        <div class="btn-group pull-right">
                                            <button class="btn btn-primary" type="submit">Save Changes</button>
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
                </div>
            </div>
        </div>                        
                <!-- END VERTICAL TABS WITH HEADING -->
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
