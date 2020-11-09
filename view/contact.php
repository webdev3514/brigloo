<?php 
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
$page = 'Contact';
    
include_once FL_USER_HEADER;
?>
    <div class="container">
        <div class="separate-section login-section">
            <h2 class="form-title">
                <div class="form-icon login-icon">
                    <i class="fa fa-sign-in" aria-hidden="true"></i>
                </div>
                Contact
            </h2>
            <div class="alert alert-success alert-dismissable login-success hide-el" style="display: none;">

                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                <span class="login-msg"></span>

            </div>

            <div class="alert alert-danger alert-dismissable login-failed hide-el" style="display: none;">

                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                <span class="login-msg"></span>

            </div>
            <form class="common-form login-form" method="POST" action="" id="frm_contact">
                <div class="form-control">
                    <label for="txt_first_name">First Name<span class="required-feild">*</span></label>
                    <input type="text" placeholder="First Name" id="txt_first_name" name="txt_first_name" class="input-field">
                </div>
                <div class="form-control">
                    <label for="txt_last_name">Last Name<span class="required-feild">*</span></label>
                    <input type="text" placeholder="Last Name" name="txt_last_name" id="txt_last_name" class="input-field"> 
                </div>
                <div class="form-control">
                    <label for="txt_email_address">E-mail Address<span class="required-feild">*</span></label>
                    <input type="text" placeholder="E-mail Address" id="txt_email_address" name="txt_email_address" class="input-field">
                </div>
                <div class="form-control">
                    <label for="txt_phone_no">Phone Number<span class="required-feild">*</span></label>
                    <input type="text" placeholder="Phone Number" id="txt_phone_no" name="txt_phone_no" class="input-field">
                </div>
                <div class="form-control">
                    <label for="txt_des">How Can We Help?<span class="required-feild">*</span></label>
                    <textarea placeholder="How Can We Help?" id="txt_des" name="txt_des" class="input-field"></textarea>
                </div>
                
                <div class="form-control submit-wrapper">
                    <input type="submit" value="Submit" name="" class="common-button loader">
                </div>
                
            </form>	
        </div>
    	
    </div>
</div>

<?PHP 
include_once FL_USER_FOOTER_INCLUDE;
include_once FL_USER_FOOTER;
?>