<?php 
require_once '../config/config.php';
require_once '../backend/config/admin_config.php';
if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "business_owner"  ){	
    header( "location:" . VW_BO_HOME );
}else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "store_manager"  ){	
    header( "location:" . VW_SM_HOME );
}else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "driver"  ){	
    header( "location:" . VW_DRIVER_HOME );
}else if( isset( $_SESSION['admin_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "admin"  ){	
    header( "location:" . VW_ADMIN_HOME );
}else{
    
}
include_once FL_USER_HEADER;
?>
<?php $page = 'login'; ?>
    <div class="container">
        <div class="separate-section login-section">
            <h2 class="form-title">
                <div class="form-icon login-icon">
                    <i class="fa fa-sign-in" aria-hidden="true"></i>
                </div>
                Log in to Cop Express
            </h2>
            <div class="alert alert-success alert-dismissable login-success hide-el" style="display: none;">

                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                <span class="login-msg"></span>

            </div>

            <div class="alert alert-danger alert-dismissable login-failed hide-el" style="display: none;">

                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                <span class="login-msg"></span>

            </div>
            <form class="common-form login-form" method="POST" action="" id="frm_login">
                <div class="form-control">
                    <label>E-mail Address</label>
                    <input type="text" placeholder="E-mail Address" id="txt_email" name="txt_email" class="input-field">
                </div>
                
                <div class="form-control">
                    <label>Password</label>
                    <input type="password" placeholder="Password" id="txt_password" name="txt_password" class="input-field">
                </div>
                <div class="form-control">                
                    <a data-toggle="modal" data-target="#forgot_password" class="forgot_popup" style="cursor:pointer;" id="forgot_pwd" >Forgot Password ?</a>                
                    <!--<button type="button" data-toggle="modal" data-target="#myModal">Forgot Password</button>-->
                </div>
                <div class="form-control submit-wrapper">
                    <input type="submit" value="Log in" name="" class="common-button loader">
                </div>
                
                
            </form>	
        </div>
    	
    </div>
<?PHP 
include TP_FORGOT_PASSWORD;
include_once FL_USER_FOOTER_INCLUDE;
include_once FL_USER_FOOTER;
?>