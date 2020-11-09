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
    <div class="separate-section Business-section">
        <h2 class="form-title">
            <div class="form-icon car-icon">
                <i class="fa fa-briefcase" aria-hidden="true"></i>	
            </div>
            Business Registration
        </h2>
        <div class="alert alert-success alert-dismissable signup-success hide-el" style="display: none;">

            <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

            <span class="signup-msg"></span>

        </div>

        <div class="alert alert-danger alert-dismissable signup-failed hide-el" style="display: none;">

            <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

            <span class="signup-msg"></span>

        </div>
        <form action="#" class="common-form register-business" role="form" method="post" name="frm_bo_registration" id="frm_bo_registration">
            <!--<div class="form-control">-->
            <!--    <label for="txt_user_name">Username<span class="required-feild">*</span></label>-->
            <!--    <input type="text" placeholder="Username" id="txt_user_name" name="txt_user_name" class="input-field">-->
            <!--</div>-->
            <div class="form-control">
                <label for="txt_first_name">First Name<span class="required-feild">*</span></label>
                <input type="text" placeholder="First Name" id="txt_first_name" name="txt_first_name" class="input-field">
            </div>
            <div class="form-control">
                <label for="txt_last_name">Last Name<span class="required-feild">*</span></label>
                <input type="text" placeholder="Last Name" name="txt_last_name" id="txt_last_name" class="input-field"> 
            </div>
            <div class="form-control">
                <label for="txt_job_title">Job Title</label>
                <input type="text" placeholder="Job Title" id="txt_job_title" name="txt_job_title" class="input-field">
            </div>
            <div class="form-control">
                <label for="txt_email_address">E-mail Address<span class="required-feild">*</span></label>
                <input type="text" placeholder="E-mail Address" id="txt_email_address" name="txt_email_address" class="input-field">
            </div>
            
            <div class="form-control">
                <label for="txt_pwd">Password<span class="required-feild">*</span></label>
                <input type="password" placeholder="Password" id="txt_pwd" name="txt_pwd" class="input-field">
            </div>
            <div class="form-control">
                <label for="txt_crm_pwd">Confirm Password<span class="required-feild">*</span></label>
                <input type="password" placeholder="Confirm Password" id="txt_crm_pwd" name="txt_crm_pwd" class="input-field">
            </div>
            <div class="form-control">
                <label for="txt_phone_no">Phone Number<span class="required-feild">*</span></label>
                <input type="text" placeholder="Phone Number" id="txt_phone_no" name="txt_phone_no" class="input-field">
            </div>
            <div class="form-control">
                <label for="txt_business_name">Business Name<span class="required-feild">*</span></label>
                <input type="text" placeholder="Business Name" id="txt_business_name" name="txt_business_name" class="input-field">
            </div>
            <div class="form-control">
                <label for="txt_eni_no">EIN Number<span class="required-feild">*</span></label>
                <input type="text" placeholder="EIN Number" id="txt_eni_no" name="txt_eni_no" class="input-field">
            </div>
            
            <div class="form-control">
                <label for="txt_address_1">Address Line 1<span class="required-feild">*</span></label>
                <input type="text" placeholder="Address Line 1" id="txt_address_1" name="txt_address_1" class="input-field">
            </div>
            <div class="form-control">
                <label for="txt_address_2">Address Line 2</label>
                <input type="text" placeholder="Address Line 2" id="txt_address_2" name="txt_address_2" class="input-field">
            </div>
            <div class="form-control">
                <label for="txt_city">City<span class="required-feild">*</span></label>
                <input type="text" placeholder="City" id="txt_city" name="txt_city" class="input-field">
            </div>
            <div class="form-control">
                <label for="txt_state">State<span class="required-feild">*</span></label>
                <input type="text" placeholder="State" id="txt_state" name="txt_state" class="input-field">
            </div>
            <div class="form-control">
                <label for="txt_zip_code">Zip Code<span class="required-feild">*</span></label>
                <input type="text" placeholder="Zip Code" id="txt_zip_code" name="txt_zip_code" class="input-field">
            </div>
            <div class="form-control check-wraper">
                <input type="checkbox" id="term_condition" name="term_condition">I agree to the <a href="#">terms and conditions</a>.
                <label class="err_checkbox"></label>
            </div>
            <input type="hidden" value="business_owner" name="txt_user_type"/>
            <div class="form-control submit-wrapper">
                <input type="submit" value="Register" name="" class="common-button loader">
            </div>
            
            </div>
        </form>
    </div>
</div>
<?php 
include_once FL_USER_FOOTER_INCLUDE;
include_once FL_USER_FOOTER;
?>