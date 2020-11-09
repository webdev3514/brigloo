<?php 
require_once '../../config/config.php';
require_once '../config/admin_config.php';
if( !isset( $_SESSION['user_id'] ) && !isset( $_SESSION['user_type'] ) ){
    header( "location:" . BASE_URL );
} else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] != "admin"  ){	
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
?>
<!-- PAGE CONTENT -->
<div class="page-content">

    <!-- START X-NAVIGATION VERTICAL -->
    <?php  include_once FL_LOGIN_SUB_HEADER;?> 
    <!-- END X-NAVIGATION VERTICAL -->    


    <!-- PAGE CONTENT WRAPPER -->
    <div class="panel panel-default">
        <div class="tab-pane active">
            <div class="tabs">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="#change_order" data-toggle="tab">Change Order</a></li>
                    <li><a href="#assign_job" data-toggle="tab">Assign Job</a></li>
                </ul>
                <div class="panel-body tab-content">
                    <div class="tab-pane active" id="change_order" role="tabpanel">
                        <div class="page-content-wrap">
                            <!-- START WIDGETS -->                    
                            <form class="form-horizontal" method="post" name="frm_change_order_request_days" id="frm_change_order_request_days" >
                                <div class="panel panel-default">

                                    <div class="pick-body">
                                        <div class="panel-body  col-md-12">
                                            <div class="panel-heading">
                                                <h3 class="panel-title" style="text-transform: capitalize">Change Order Request</h3>
                                            </div>
                                            <div style="margin-top: 60px;">
                                                <div class="form-group pickup_location">
                                                    <label class="col-md-3">From:</label>
                                                    <div class="col-md-9">
                                                        <select class=" select" id="ch_from" name="pickup[0][location]">
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
                                                <div class="form-group pickup_location">
                                                    <label class="col-md-3">To:</label>
                                                    <div class="col-md-9">
                                                        <select class=" select" id="ch_to" name="pickup[0][location]">
                                                            <option  value="1" disabled="">Monday</option>
                                                            <option  value="2" disabled="">Tuesday</option>
                                                            <option  value="3" disabled="">Wednesday</option>
                                                            <option  value="4" disabled="">Thursday</option>
                                                            <option  value="5">Friday</option>
                                                            <option  value="6" disabled="">Saturday</option>
                                                            <option  value="7" disabled="">Sunday</option>
                                                        </select>
                                                        </select>                           
                                                    </div>                        
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">  
                                        <button type="submit" class="btn btn-primary pull-right loader">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane" id="assign_job" role="tabpanel">
                        <div class="page-content-wrap">
                            <!-- START WIDGETS -->                    
                            <div class="row">
                                <div class="col-md-12">
                                        <!-- START DATATABLE EXPORT -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Pickup List</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table id="customers2" class="table datatable">
                                                        <thead>
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Driver Name</th>
                                                                <th>Date Requested</th>
                                                                <th>Pickup Date</th>
                                                                <th>Location</th>
                                                                <th>Address</th>
                                                                <th>Amount</th>
                                                                <th>Type</th>
                                                                <th>Requested By</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php

                                                            $all_userdata = $pickup->get_assign_pickups( );
                                                            if( isset( $all_userdata ) && $all_userdata != '' ){
                                                                foreach( $all_userdata as $key => $value ){
                                                                    $location_name = $location->get_location_by_key( $value['in_location_id'], 'st_location_name' );
                                                                    $location_address = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                                                    $bo_user_name = $user->get_user_data_by_key( $value['in_user_id'], 'st_first_name' );
                                                                    $driver_id = $pickup->get_job_by_key( $value['in_job_id'], 'in_driver_id' );
                                                                    $driver_user_name = $user->get_user_data_by_key( $driver_id, 'st_first_name' );
                                                                ?>
                                                                    <tr class="pickup_<?php echo $value['in_pickup_id']; ?>">
                                                                        <td><span>#</span><?php echo $value['in_pickup_id'];?></td>
                                                                        <td><?php echo $driver_user_name;?></td>
                                                                        <td><?php echo $value['dt_created_at'];?></td>
                                                                        <td><?php echo $value['dt_pickup'];?></td>
                                                                        <td><?php echo $location_name;?></td>
                                                                        <td><?php echo $location_address;?></td>
                                                                        <td><?php echo $value['fl_amount'];?></td>
                                                                        <td><?php 
                                                                            if( isset( $value['st_order_type'] ) && $value['st_order_type'] == "change_order"){ 
                                                                                echo "Change Order";
                                                                            }else{
                                                                                echo "-";
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $bo_user_name;?></td>
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

                                        <!-- END DATATABLE EXPORT --> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<div class="modal fade" id="pickup_job_assign" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Driver List</h4>
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
                            <form id="frm_request_driver"  method="post" role="form" class="form-horizontal" action="">                            
                                <div class="selected_driver">
                                    
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Driver Name:</label>
                                    <div class="col-md-9">
                                       
                                        <?php $user_data = $user->search_user_by_type( 'driver', '' );?>
                                        <select class="select" id="txt_driver_name" name="txt_driver_name">
                                            
                                                <?php 
                                                if( isset( $user_data ) ){
                                                    foreach ( $user_data as $key => $value ) { ?>
                                                        <option  value="<?php echo $value['in_user_id']; ?>" ><?php echo $value['st_first_name']; ?></option>
                                                <?php }
                                                }?>
                                        </select>
                                            
                                    </div>
                                </div>
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary loader" type="submit">Submit</button>
                                </div>                                                                
                            </form>
                        </div>
                    </div>                    

                </div>
            </div>
        </div>
      
    </div>
</div>
    
<div class="modal fade" id="select_driver" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Driver List</h4>
            </div>
            <div class="modal-body">
                <div class="page-content-wrap" style="margin-top:20px;">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="modal-title">Please select driver</h4>
                        </div>
                    </div>                    

                </div>
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
<script type='text/javascript' src="<?php echo ADMIN_JS_PLUGINS_PATH .'bootstrap/bootstrap-select.js' ; ?>"></script><?php
include_once FL_LOGIN_FOOTER;
?>