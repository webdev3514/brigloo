<?php 
if ( !session_id() ) {
    session_start();
}
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

include_once FL_USER;
$user = new user();
include_once FL_LOCATION;
$location = new location();
include_once FL_PICKUP;
$pickup = new pickup();   
$user_id = isset( $_SESSION['user_id'] ) &&  $_SESSION['user_id']  != '' ? $_SESSION['user_id'] : '';  
?>
<!-- PAGE CONTENT -->
<div class="page-content">

    <!-- START X-NAVIGATION VERTICAL -->
    <?php  include_once FL_LOGIN_SUB_HEADER;?> 
    <!-- END X-NAVIGATION VERTICAL -->    
    <div class="page-content-wrap">
        <!-- START WIDGETS -->                    
        <div class="row">

    <!-- PAGE CONTENT WRAPPER -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Recurring List</h3>
                </div>
                <?php include_once TP_EDIT_RECURRING;?>
                <div class="panel-body table-responsive">
                    <table id="pickup_list" class="table datatable">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Recurring Id</th>
                                <th>Date Requested</th>
                                <th>Pick Up Date/Day</th>
                                <!--<th>Location</th>-->
                                <th>Address</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Requested By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $all_userdata = $pickup->get_recurring_by_user_id( $user_id );
                            if( isset( $all_userdata ) && $all_userdata != '' ){
                                foreach( $all_userdata as $key => $value ){
//                                    $location_name = $location->get_location_by_key( $value['in_location_id'], 'st_location_name' );
                                    $location_address = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                    $user_name = $user->get_user_data_by_key( $value['in_user_id'], 'st_first_name' );
                                    ?>
                                    <tr class="recurring_<?php echo $value['in_recurring_id']; ?>" >
                                        <td>
                                            <div class="button-wrap">
                                                <button  class="btn btn-danger edit_recurring" data-recurring_id="<?php echo $value['in_recurring_id']; ?>"><i class="fa fa-pencil "></i></button>
                                                <button  class="btn btn-danger cancel_recurring" data-recurring_id="<?php echo $value['in_recurring_id']; ?>"><i class="fa fa-close "></i></button>
                                            </div>
                                        </td>
                                        <td><span></span><?php echo $value['in_recurring_id']; ?></td>
                                        <td><?php echo date("m-d-Y H:i:s", strtotime( $value['dt_created_at'] ) );?></td>
                                        <td><?php 
                                            if( isset( $value['st_recurring_type'] ) && $value['st_recurring_type'] == "weekly"  ){
                                                echo date( 'l', strtotime(" Sunday + {$value['st_recurring_date']} days") );
                                            }else{
                                               echo date("m-d-Y", strtotime( $value['st_recurring_date'] ) ); 
                                            }
                                            ?>
                                        </td>
                                        <!--<td><?php // echo $location_name; ?></td>-->
                                        <td class="cut_location_address" title="<?php echo $location_address; ?>"><?php echo $location_address; ?></td>
                                        <td ><?php echo isset( $value['st_recurring_type'] ) && $value['st_recurring_type'] == "weekly" ? "<img src='" . IMAGES_URL . "weekly.png' title='Weekly'/>" : "<img title='Monthly' src='" . IMAGES_URL . "calendar.png'/>"; ?></td>
                                        
                                        <td class="pickup_amount"><?php echo '$' . ( isset( $value['fl_amount'] ) && $value['fl_amount'] == '' || $value['fl_amount'] > 0 ? $value['fl_amount'] : "0" ); ?></td>
                                        <td><?php echo $user_name; ?></td>
                                    </tr>
                                <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>                                    
                </div>
            </div>
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
                                    <button class="btn btn-primary" type="submit">Submit</button>
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
<script type='text/javascript' src="<?php echo ADMIN_JS_PLUGINS_PATH .'bootstrap/bootstrap-select.js' ; ?>"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=<?php echo GOOGLE_MAPS_API_KEY; ?>"></script>
<script type="text/javascript" src="<?php echo JS_PLUGINS_PATH; ?>location-picker/locationpicker.jquery.min.js"></script>

<script type="text/javascript" src="<?php echo JS_PATH; ?>pickup.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>location.js"></script>
<?php
include_once FL_LOGIN_FOOTER;
?>
<script>
$( '#pickup_list' ).DataTable({
    "order": [[ 1, "desc" ]]
});
</script>
