<div class="modal fade white-popup modal-popup" id="forgot_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title">Forgot Password ?</h5>
                <!--<button title="Close (Esc)" type="button" class="mfp-close">×</button>-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center forgot-password-body">                                                
                <div class="text-center">
                    <p>Enter the email associated with your account and a password recovery link will be sent to your email.</p>
                    <div class="panel-body">                                            
                        <form method="post" id="frm_forgot_password" name="frm_forgot_password">
                            <div class="form-control">
                                <div class="input-group">
                                    <span class="input-group-addon"></span>
                                    <input type="email" id="td_client_name" name="email" placeholder="EMAIL ADDRESS" class="input-field" required>
                                </div>
                            </div>
<!--                            <div class="form-control a-center bg-btn submit-btn">
                                <input value="Reset My Password" type="submit" name="forgot_submit" class="login-btn common-btn btn-common btn-common">
                            </div>    -->
                            <div class="form-group text-left">
                                <input class="btn btn-primary" value="Reset My Password" type="submit" name="forgot_submit">
                            </div>
                        </form> 
                        <div class="alert alert-success alert-dismissable forgot_pwd-success hide-el" style="display: none;">
                            <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                            <span class="forgot_pwd-msg"></span>
                        </div>
                        <div class="alert alert-danger alert-dismissable forgot_pwd-failed hide-el" style="display: none;">
                            <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
                            <span class="forgot_pwd-msg"></span>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>

