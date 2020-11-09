<?php
session_start();
require_once '../config/config.php';
if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "business_owner"  ){	
    header( "location:" . VW_BO_HOME );
}else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "store_manager"  ){	
    header( "location:" . VW_SM_HOME );
}else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "driver"  ){	
    header( "location:" . VW_DRIVER_HOME );
}else if( isset( $_SESSION['admin_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "admin"  ){	
    header( "location:" . BACKEND_DIR );
}else{
    
}
include_once FL_USER_HEADER;
?>
<div class="container">
    <div class="separate-section Driver-section">
        <h2 class="form-title">
            <div class="form-icon car-icon">    
                    <i class="fa fa-car" aria-hidden="true"></i>	
            </div>
            Driver Register with Cop Express
        </h2>
        <div class="alert alert-success alert-dismissable signup-success hide-el" style="display: none;">

            <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

            <span class="signup-msg"></span>

        </div>

        <div class="alert alert-danger alert-dismissable signup-failed hide-el" style="display: none;">

            <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

            <span class="signup-msg"></span>

        </div>
        <form action="#" role="form" method="post" class="common-form driver-register" name="frm_driver_registration" id="frm_driver_registration">
            <!--<div class="form-control">-->
            <!--    <label for="txt_user_name">Username<span class="required-feild">*</span></label>-->
            <!--    <input type="text"  placeholder="Username" name="txt_user_name" id="txt_user_name" class="input-field">-->
            <!--</div>-->
            <div class="form-control">
                <label for="txt_first_name">First Name<span class="required-feild">*</span></label>
                <input type="text" placeholder="First Name" name="txt_first_name" id="txt_first_name" class="input-field"> 
            </div>
            <div class="form-control">
                <label for="txt_last_name">Last Name<span class="required-feild">*</span></label>
                <input type="text" placeholder="Last Name" name="txt_last_name" id="txt_last_name" class="input-field"> 
            </div>
            <div class="form-control">
                <label for="txt_email_address">E-mail Address<span class="required-feild">*</span></label>
                <input type="text" placeholder="E-mail Address" name="txt_email_address" id="txt_email_address" class="input-field">
            </div>
            <div class="form-control">
                <label for="txt_phone_no">Phone Number<span class="required-feild">*</span></label>
                <input type="text" placeholder="Phone Number" name="txt_phone_no" id="txt_phone_no" class="input-field">
            </div>						
            <div class="form-control">
                <label for="txt_license_no">Driver's License Number<span class="required-feild">*</span></label>
                <input type="text" placeholder="Driver's License No" name="txt_license_no" id="txt_license_no" class="input-field">
            </div>
            <div class="form-control">
                <label for="txt_pwd">Password<span class="required-feild">*</span></label>
                <input type="password" placeholder="Password" name="txt_pwd" id="txt_pwd" class="input-field">
            </div>
            <div class="form-control">
                <label for="txt_crm_pwd">Confirm Password<span class="required-feild">*</span></label>
                <input type="password" placeholder="Confirm Password" name="txt_crm_pwd" id="txt_crm_pwd" class="input-field">
            </div>
            <input type="hidden" value="driver" name="txt_user_type"/>
            <div class="form-control check-wraper">
                <input type="checkbox" id="term_condition" name="term_condition">I agree to the <a href="#">terms and conditions</a>.
            </div>
            <div class="form-control submit-wrapper">
                <input type="submit" value="Register" name="" class="common-button loader">
            </div>
            
        </form>
    </div>
</div>
<?php 
include_once FL_USER_FOOTER_INCLUDE;
include_once FL_USER_FOOTER;
?>