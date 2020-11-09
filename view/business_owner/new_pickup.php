<?php 
session_start();
require_once '../../config/config.php';
require_once '../../backend/config/admin_config.php';
if( !isset( $_SESSION['user_id'] ) && !isset( $_SESSION['user_type'] ) ){
    header( "location:" . BASE_URL );
} else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] != "business_owner"  ){	
    header( "location:" . VW_LOGOUT );
}else if( isset( $_SESSION['admin_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "admin"  ){	
    header( "location:" . VW_LOGOUT );
}
include_once FL_LOGIN_HEADER;
include_once FL_LOGIN_SIDEBAR;

$user_id = isset( $_SESSION['user_id'] ) &&  $_SESSION['user_id']  != '' ? $_SESSION['user_id'] : '';
include_once FL_USER;
$user = new user();
include_once FL_LOCATION;
$location = new location();   
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
            
                <div class="alert alert-success alert-dismissable pickup-success hide-el" style="display: none;">

                    <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                    <span class="pickup-msg"></span>

                </div>

                <div class="alert alert-danger alert-dismissable pickup-failed hide-el" style="display: none;">

                    <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                    <span class="pickup-msg"></span>

                </div>
                <form class="form-horizontal" method="post" name="frm_add_pickup" id="frm_add_pickup" >
                    <div class="panel panel-default">
                        <div class="pick-body">
                            <div class="panel-body  col-md-12 pickup-section">
                                <div class="panel-heading">
                                    <h3 class="panel-title" style="text-transform: capitalize">Add New Pick Up</h3>
                                </div>
                                <div style="margin-top: 60px;">
                                    <div class="form-group pickup_location">
                                        <label class="col-md-3">Pick Up Location<span class="required-feild">*</span></label>
                                        <div class="col-md-3">
                                            <?php $location_data = $location->get_all_location( $user_id );  ?>
                                            <select class=" select" id="pickup_location" name="pickup[0][location]">
<!--                                                <option value="0">Choose location</option>-->
                                                <?php 
                                                if( isset( $location_data ) ){
                                                    foreach( $location_data as $l_data ){
                                                ?>
                                                        <option  value="<?php echo $l_data['in_location_id']; ?>"><?php echo $l_data['st_store_id']; ?></option>
                                                <?php } 
                                                }?>
                                            </select>                           
                                            <span class="">Don't see a location? <a href="" id='open_location_modal' data-toggle="modal" data-target="#add_pickup_location">Click Here</a> to add a new location.</span>
                                        </div>                        
                                    </div>  
                                    
                                    <div class="form-group">
                                        <label class="col-md-3">Choose Type<span class="required-feild">*</span></label>
                                        <div class="col-md-3">
                                            <select class=" select pickup_type" id="pickup_type" name="pickup[0][type]">
                                                <option value="oneoff">One Off Collection</option>
                                                <option value="recurring">Recurring Collection</option>
                                            </select>                           
                                            <span class="help-block"></span>
                                        </div>                        
                                    </div>
                                    
                                    <div class="recurr">
                                        <div class="form-group recurring_collection">
                                            <label class="col-md-3">Recurring Type<span class="required-feild">*</span></label>
                                            <div class="col-md-3">                                   
                                                <label><input type="radio" class="recurring_type weekly_recurring_chk"  value="weekly" checked=""  name="pickup[0][recurring_type]"/>Weekly</label>
                                                <label><input type="radio" class="recurring_type monthly_recurring_chk"  value="monthly" name="pickup[0][recurring_type]"/> Monthly</label>
                                            </div>                        
                                        </div>

                                        <div class="form-group weekly_recurring">
                                            <label class="col-md-3">Choose Day<span class="required-feild">*</span></label>
                                            <div class="col-md-3">
                                                <select class=" select" id="ch_delivery_time" name="pickup[0][pickup_weekly_recurring_date]">
                                                    <option  value="1">Monday</option>
                                                    <option  value="2">Tuesday</option>
                                                    <option  value="3">Wednesday</option>
                                                    <option  value="4">Thursday</option>
                                                    <option  value="5">Friday</option>
                                                    <option  value="6">Saturday</option>
                                                    <option  value="7">Sunday</option>
                                                </select>                          
                                            </div>                        
                                        </div>
                                        <div class="form-group monthly_recurring">                                        
                                            <label class="col-md-3">Monthly Date<span class="required-feild">*</span></label>
                                            <div class="col-md-3 calender_open">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                    <input type="text" required="" class="form-control datepicker" id="pickup_monthly_recurring_date" name="pickup[0][pickup_monthly_recurring_date]"/>             
                                                </div>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
<!--                                        <div class="form-group monthly_recurring">
                                            <label class="col-md-3"><span class="required-feild">*</span></label>
                                            <div class="col-md-3">
                                                <input type="text" required="" class="form-control datepicker" id="pickup_monthly_recurring_date" name="pickup[0][pickup_monthly_recurring_date]"/>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>-->
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-3">Pick Up Amount ($)</label>
                                        <div class="col-md-3">
                                            <input type="number"  class="pickup_amt form-control" id="pickup_amt" name="pickup[0][amt]"/>
                                            <span class="help-block"></span>
                                            <span class="pickup_amount"></span>
                                        </div>
                                    </div>
                                    <div class="on-off">
                                        <div class="form-group one_off_type">                                        
                                            <label class="col-md-3">One-off Pick Up Date<span class="required-feild">*</span></label>
                                            <div class="col-md-3 calender_open">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                    <input type="text" required="" class="form-control datepicker" id="pickup_date" name="pickup[0][date]">                                            
                                                </div>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
<!--                                        <div class="form-group one_off_type">
                                            <label class="col-md-3">One-off Pickup Date<span class="required-feild">*</span></label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                    <input type="text" class="form-control datepicker" value="2015-11-01">                                            
                                                </div>
                                                <input type="text" required="" class="form-control datepicker" id="pickup_date" name="pickup[0][date]"/>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>-->
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer">  
                            <a href="#"><div class="btn btn-success" id="add_pickup"><i class="fa fa-plus "></i> Add Pick Up</div></a>
                            <button type="submit" class="btn btn-primary pull-right loader">Submit</button>
                        </div>
                    </div>
                </form>
        </div> 
    </div>
                    
</div>
<div class="modal fade" id="add_pickup_location" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add location</h4>
            </div>
            <div class="modal-body">
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
                            <form id="frm_add_location"  method="post" role="form" class="form-horizontal" action="">                            
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
<!--                                <div class="form-group">
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=<?php echo GOOGLE_MAPS_API_KEY; ?>"></script>
<script type="text/javascript" src="<?php echo JS_PLUGINS_PATH; ?>location-picker/locationpicker.jquery.min.js"></script>

<script type="text/javascript" src="<?php echo JS_PATH; ?>location.js"></script>
<?php
include_once FL_LOGIN_FOOTER;
?>