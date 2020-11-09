<?php
session_start();
require_once '../config/config.php';
$page_title = ucwords( "password recovery " );

if( !session_id() ){
    session_start();
}

include_once FL_USER_HEADER; //Please do not forget to include header while implementing
require_once FL_USER_HEADER_INCLUDE; 

if( !isset( $_REQUEST['email'] ) ){    
    ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12 password">
                    <h4 class="fs-title">Link is Broken.......</h4>
                </div>
            </div>
        </div>
    <?php
} else if( isset( $_REQUEST['email'] ) ){    
    include_once FL_USER;
    $user = new user();
   
    $user_email = $_REQUEST['email'];
//    $key = $_REQUEST['key'];
    
    $user_data = $user->get_user_data_by( 'st_email_id', $user_email );

    ?>
        <!--content-->
       <div class="container">
        <div class="separate-section login-section">
                <div class="tabs-trademark">
                    <h1 class="title">Forgot Password</h1>
                    <div class="trademark-wrap">
                        <form class="form-edit-profile" id="frm_recovery_password" name="frm_recovery_password" method="post">
                            <div class="form-control">
                                <label class="form-label">PASSWORD</label>
                                <div class="input-group">
                                    <span class="input-group-addon"></span>
                                    <input type="password" id="txt_pwd" name="txt_pwd" placeholder="PASSWORD" class="input-field">
                                </div>
                            </div>
                            <div class="form-control">
                                <label class="form-label">CONFIRM PASSWORD</label>
                                <div class="input-group">
                                    <span class="input-group-addon"></span>
                                    <input type="password" name="txt_cpwd" placeholder="CONFIRM PASSWORD" class="input-field">
                                </div>
                            </div>
                            <div class="form-control a-center bg-btn">
                                <input type="submit" name="submit" value="Submit" class="btn btn-login submit btn-common">
                            </div>	
                            <input type="hidden" value="<?php echo $user_email; ?>" name="email"/>
                            <input type="hidden" value="<?php echo $user_data['in_user_id']; ?>" name="user_id"/>                            
                        </form>
                    </div>	
                </div>
                
<?php } ?>

            </div>
        </div>	
<!--content-->	

<!--footer-->
<?php 
include_once FL_USER_FOOTER_INCLUDE;
include_once FL_USER_FOOTER;
?>

<script>
    $(document).ready(function ($) {
        
        $( "#frm_recovery_password" ).validate({
            onsubmit: true,
            rules: {
                txt_pwd: {
                    required: true,
                    minlength: 5
                    
                },
                txt_cpwd: {
                    required: true,
                    minlength: 5,
                    equalTo: "#txt_pwd"
                }
            },
            messages: {
                txt_pwd: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                txt_cpwd: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Please enter the same password as above"
                },
            }
        });
    });
</script>
