<div class="page-content-wrap" style="margin-top:20px;">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable location-success hide-el" style="display: none;">

                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                <span class="location-msg"></span>

            </div>

            <div class="alert alert-danger alert-dismissable location-failed hide-el" style="display: none;">

                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                <span class="location-msg"></span>

            </div>
            <form id="frm_add_location"  style="display: none;" method="post" role="form" class="form-horizontal" action="">                            
                <div class="form-group">
                    <label class="col-md-3">Account Type<span class="required-feild">*</span></label>
                    <div class="col-md-9">
                        <input type="radio" value="single" id="single" name="account_type" checked="" class='form-control single_account' />
                        <label for="single">Single</label>
                        <input type="radio" value="multiple" id="multiple" name="account_type" class='form-control multiple_account' />
                        <label for="multiple">Separate</label>
                    </div>
                </div>
                <div class="sm_section">
                    <div class="form-group">
                        <label for="txt_email_address" class="col-md-3">E-mail Address:</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="E-mail Address" value="<?php echo isset( $sm_email_id ) && $sm_email_id != '' ? $sm_email_id : '' ?>" id="txt_email_address" name="txt_email_address" class="input-field form-control">
                        </div>                          
                    </div>
                    <div class="form-group">
                        <label for="txt_pwd" class="col-md-3">Password:</label>
                        <div class="col-md-9">
                            <input type="password" placeholder="Password" id="txt_pwd" name="txt_pwd" class="input-field form-control">
                        </div>                          
                    </div>
                    <div class="form-group">
                        <label for="txt_crm_pwd" class="col-md-3">Confirm Password:</label>
                        <div class="col-md-9">
                            <input type="password"placeholder="Confirm Password" id="txt_crm_pwd" name="txt_crm_pwd" class="input-field form-control">
                        </div>                          
                    </div>
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>"/>
                    <input type="hidden" name="sm_id" id="sm_id" value=""/>
                            
                </div>
<!--                <div class="form-group">
                    <label class="col-md-3">Location Name<span class="required-feild">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="validate[required] form-control" id="txt_location_name" name="txt_location_name"/>
                        <span class="help-block"></span>
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="col-md-3">Store ID<span class="required-feild">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="validate[required] form-control" id="txt_store_id" name="txt_store_id"/>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3">Full Address<span class="required-feild">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="validate[required] form-control" id="txt_address" name="txt_address" placeholder="Address" />
                        <input type="hidden" id="hdn_latitude" name="hdn_latitude" value=""/>
                        <input type="hidden" id="hdn_longitude" name="hdn_longitude" value=""/>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3"></label>
                    <div class="col-md-9">
                        <div id="location" style="width: 100%; height: 200px;"></div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <input type="hidden" name="hdn_location_id" id="hdn_location_id"/>
                <!--<input type="hidden" name="action" id="hdn_location_action"/>-->
                <div class="btn-group pull-right">
                    <button class="btn btn-primary loader" type="submit">Submit</button>
                </div>                                                                
            </form>
        </div>
    </div>                    

</div>