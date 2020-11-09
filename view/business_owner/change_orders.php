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
include_once FL_PICKUP;
$pickup = new pickup(); 
//$sm_id = $user->get_bo_data_by_key( $user_id, 'in_store_manager_id' );
$manager_ids = $location->get_location_data_by( 'in_user_id' , $user_id );
$arr_managerids = array();
$arr_manager_id = array();
if( isset( $manager_ids ) && $manager_ids > 0  ){
    if( isset( $manager_ids['in_manager_id'] ) ){
        $manager_ids = array( $manager_ids );
    }
    foreach( $manager_ids as $mk => $mv ){
        array_push( $arr_managerids , $mv['in_manager_id'] );
    }
    $arr_manager_id = array_unique( $arr_managerids );
}
$st_change_order_fields = $user->get_bo_data_by_key( $user_id, 'st_change_order_fields' );
$st_ch_delivery_day = $user->get_bo_data_by_key( $user_id, 'st_ch_delivery_day' );
$change_order_fields = json_decode( $st_change_order_fields, true ) ;
?>
<div class="page-content">
    <?php  include_once FL_LOGIN_SUB_HEADER;?>  
    <div class="panel panel-default">
        <div class="tab-pane active">
            <div class="tabs">
                <ul class="nav nav-tabs nav-justified">
                    <li ><a href="#change_order" data-toggle="tab">Change Order List</a></li>
                    <li class="active"><a href="#change_order_pending " data-toggle="tab">Incoming Change Orders</a></li>
                    <li><a href="#change_order_request_day" data-toggle="tab">Change Order settings</a></li>
                </ul>
                <div class="panel-body tab-content">
                    <div class="tab-pane " id="change_order" role="tabpanel">
                        <div class="page-content-wrap">
                            <!-- START WIDGETS -->                    
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Change Order List</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table id="customers2" class="table datatable">
                                                    <thead>
                                                        <tr>
                                                            <th class="td-width">Id</th>
                                                            <th>Requested</th>
                                                            <th>Pick Up Date</th>
                                                            <!--<th>Location</th>-->
                                                            <th>Address</th>
                                                            <th>Amount</th>
                                                            <th>Approve/Reject</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $all_userdata = '';
                                                        if( isset( $arr_manager_id ) && is_array( $arr_manager_id ) && !empty( $arr_manager_id ) ){
                                                            $all_userdata = $pickup->get_unassign_pickups( $arr_manager_id, "change_order" );
                                                        }
                                                        if( isset( $all_userdata ) && $all_userdata != '' ){
//                                                            echo "<pre>";print_r($all_userdata);echo "</pre>";
                                                            foreach( $all_userdata as $key => $value ){
//                                                                $location_name = $location->get_location_by_key( $value['in_location_id'], 'st_location_name' );
                                                                $location_address = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                                                $bo_user_name = $user->get_user_data_by_key( $value['in_user_id'], 'st_first_name' );
                                                                $driver_id = $pickup->get_job_by_key( $value['in_job_id'], 'in_driver_id' );
                                                                $driver_user_name = $user->get_user_data_by_key( $driver_id, 'st_first_name' );

                                                                ?>
                                                                <tr class="change_order_<?php echo $value['in_pickup_id']; ?>">
                                                                    <td class="td-width"><span></span><?php echo $value['in_pickup_id'];?></td>
                                                                    <td><?php echo $value['dt_created_at'];?></td>
                                                                    <td><?php echo $value['dt_pickup'];?></td>
                                                                    <!--<td><?php // echo $location_name;?></td>-->
                                                                    <td  class="cut_location_address" title="<?php echo $location_address; ?>"><?php echo $location_address;?></td>
                                                                    <td class="pickup_amount"><?php echo '$' . ( isset( $value['fl_amount'] ) && $value['fl_amount'] == '' || $value['fl_amount'] > 0 ? $value['fl_amount'] : "0" );?></td>
                                                                   
                                                                    <td>
                                                                        <?php
                                                                        $approved = $pickup->get_change_order_by_key( $value['in_pickup_id'], 'in_is_approve' );
                                                                        if( isset( $approved ) && $approved == 1 ){
                                                                            echo "<button  class='btn btn-success'>Approved</button>";
                                                                        }else if( isset( $approved ) && $approved == 0 ){
                                                                            ?>
                                                                            <a href="#" data-id="<?php echo $value['in_pickup_id']; ?>" class="btn btn-success change_order_approve">Approve</a>
                                                                            <?php
                                                                        }
                                                                        ?> 
                                                                        <?php
                                                                        if( isset( $approved ) && $approved == -1 ){
                                                                            echo "<button  class='btn btn-danger'>Rejected</button>";
                                                                        }else if( isset( $approved ) && $approved == 1 ){
                                                                            ?>

                                                                            <?php
                                                                        }else if( isset( $approved ) && $approved == 0 ){
                                                                            ?>
                                                                            <a href="" data-id="<?php echo $value['in_pickup_id']; ?>" class="btn btn-danger change_order_reject">Reject</a> 
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </td>
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
                        </div>
                    </div>
                    <div class="tab-pane active" id="change_order_pending" role="tabpanel">
                        <div class="page-content-wrap">
                            <!-- START WIDGETS -->                    
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Change Order List</h3>
                                        </div>
                                        <?php include_once TP_EDIT_CHANGE_ORDER; ?>
                                        <div class="panel-body">
                                            <h4>Note : Change Orders cannot be modified on the day they are scheduled for processing.</h4>
                                            <button class="btn btn-success delivery_change_order_direct" data-pickup_id="<?php echo $value['in_pickup_id']; ?>">Submit for Delivery</button>
                                            <button class="btn btn-success check_change_order_direct" data-pickup_id="<?php echo $value['in_pickup_id']; ?>">Select All</button>
                                            <button class="btn btn-success uncheck_change_order_direct" data-pickup_id="<?php echo $value['in_pickup_id']; ?>">Select None</button>
                                            <div class="table-responsive change_incoming">
                                                <table id="customers2" class="table datatable">
                                                    <thead>
                                                        <tr>
                                                            <th class="td-width">Id</th>
                                                            <th class="td-width">Id</th>
                                                            <!--<th>Location</th>-->
                                                            <th>Address</th>
                                                            <th>Amount</th>
                                                            <th>Edit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $all_userdata = '';
                                                        if( isset( $arr_manager_id ) && is_array( $arr_manager_id ) && !empty( $arr_manager_id ) ){
                                                            $all_userdata = $pickup->get_unassign_pickups( $arr_manager_id, "change_order" , 0 );
                                                        }
                                                        if( isset( $all_userdata ) && $all_userdata != '' ){
//                                                            echo "<pre>";print_r($all_userdata);echo "</pre>";
                                                            foreach( $all_userdata as $key => $value ){
//                                                                $location_name = $location->get_location_by_key( $value['in_location_id'], 'st_location_name' );
                                                                $location_address = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                                                $bo_user_name = $user->get_user_data_by_key( $value['in_user_id'], 'st_first_name' );
                                                                $driver_id = $pickup->get_job_by_key( $value['in_job_id'], 'in_driver_id' );
                                                                $driver_user_name = $user->get_user_data_by_key( $driver_id, 'st_first_name' );

                                                                ?>
                                                                <tr class="change_order_<?php echo $value['in_pickup_id']; ?>">
                                                                    <td>
                                                                    <div class="checkbox-wrap">
                                                                        <input type="checkbox" id="pickup_<?php echo $value['in_pickup_id']; ?>" class='arr_pickup' name='arr_pick[]'  data-id='<?php echo $value['in_pickup_id']; ?>'  value='<?php echo $value['in_pickup_id']; ?>' />
                                                                        <label for="pickup_<?php echo $value['in_pickup_id']; ?>"></label>
                                                                    </div>
                                                                </td>
                                                                    <td class="td-width"><span></span><?php echo $value['in_pickup_id'];?></td>
                                                                    <!--<td><?php // echo $location_name;?></td>-->
                                                                    <td  class="cut_location_address" title="<?php echo $location_address; ?>"><?php echo $location_address;?></td>
                                                                    <td class="pickup_amount"><?php echo '$' . ( isset( $value['fl_amount'] ) && $value['fl_amount'] == '' || $value['fl_amount'] > 0 ? $value['fl_amount'] : "0" );?></td>
                                                                    <td>
                                                                        <?php if( date( "N" ) == $st_ch_delivery_day ){ ?>
                                                                            <button disabled="" class="btn btn-success">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </button>
                                                                        <?php }else{ ?>
                                                                            <a href="#" data-pickup_id="<?php echo $value['in_pickup_id']; ?>" class="btn btn-success edit_change_order" title="Edit">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </a>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>                                    <button class="btn btn-success delivery_change_order_direct" data-pickup_id="<?php echo $value['in_pickup_id']; ?>">Submit for Delivery</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="tab-pane" id="change_order_request_day" role="tabpanel">
                        <div class="page-content-wrap">
                            <!-- START WIDGETS -->                    
                            <form class="form-horizontal" method="post" name="frm_change_order_request_days" id="frm_change_order_request_days" >
                                <div class="panel panel-default">
                                    <div class="pick-body">
                                        <div class="panel-body  col-md-12">
                                            <?php 
                                                $st_ch_from_to_day = $user->get_bo_data_by_key( $user_id, 'st_ch_from_to_day' );
                                                $st_ch_delivery_day = $user->get_bo_data_by_key( $user_id, 'st_ch_delivery_day' );
                                            ?>
                                            
                                            <div class="panel-heading">
                                                <h3 class="panel-title" style="text-transform: capitalize">Change Order Request Days</h3>
                                            </div>
                                            <?php 
                                                $first = '';
                                                $last = '';
                                                if( isset( $st_ch_from_to_day ) && $st_ch_from_to_day != "" ){
                                                    $bo_ch_day = json_decode( $st_ch_from_to_day,true );
                                                    $first = reset( $bo_ch_day );
                                                    $last = end( $bo_ch_day );
                                                    $f_day = date( 'l', strtotime( " Sunday +{$first} days") );
                                                    $t_day = date( 'l', strtotime( " Sunday +{$last} days") );
                                                }
                                               
                                                ?>
                                            <div style="margin-top: 60px;">
                                                <div class="form-group change_order_form">
                                                    <label class="col-md-3">Start Day:</label>
                                                    <div class="col-md-9">
                                                        <select class=" select" id="ch_from" name="ch_from">
                                                            <option  value="1" <?php echo ( $first == "1" ) ? "selected" : ''; ?>>Monday</option>
                                                            <option  value="2" <?php echo ( $first == "2" ) ? "selected" : ''; ?>>Tuesday</option>
                                                            <option  value="3" <?php echo ( $first == "3" ) ? "selected" : ''; ?>>Wednesday</option>
                                                            <option  value="4" <?php echo ( $first == "4" ) ? "selected" : ''; ?>>Thursday</option>
                                                            <option  value="5" <?php echo ( $first == "5" ) ? "selected" : ''; ?>>Friday</option>
                                                            <option  value="6" <?php echo ( $first == "6" ) ? "selected" : ''; ?>>Saturday</option>
                                                            <option  value="7" <?php echo ( $first == "7" ) ? "selected" : ''; ?>>Sunday</option>
                                                        </select>                             
                                                    </div>                        
                                                </div>
                                                <input class="form-contro" type="hidden" id="txt_bo_id" value="<?php echo $user_id;?>" name="txt_bo_id" >
                                                <div class="form-group change_order_to">
                                                    <label class="col-md-3">End Day:</label>
                                                    <div class="col-md-9">
                                                        <select class=" select" id="ch_to" name="ch_to">
                                                            <option  value="1" <?php echo ( $last == "1" ) ? "selected" : ''; ?> disabled="">Monday</option>
                                                            <option  value="2" <?php echo ( $last == "2" ) ? "selected" : ''; ?>>Tuesday</option>
                                                            <option  value="3" <?php echo ( $last == "3" ) ? "selected" : ''; ?>>Wednesday</option>
                                                            <option  value="4" <?php echo ( $last == "4" ) ? "selected" : ''; ?>>Thursday</option>
                                                            <option  value="5" <?php echo ( $last == "5" ) ? "selected" : ''; ?>>Friday</option>
                                                            <option  value="6" <?php echo ( $last == "6" ) ? "selected" : ''; ?>>Saturday</option>
                                                            <option  value="7" <?php echo ( $last == "7" ) ? "selected" : ''; ?>>Sunday</option>
                                                        </select>                          
                                                    </div>                        
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3">Delivery Day:</label>
                                                    <div class="col-md-9">
                                                        <select class=" select" id="ch_delivery_time" name="ch_delivery_time">
                                                            <option  value="1" <?php echo ( $st_ch_delivery_day == "1" ) ? "selected" : ''; ?>>Monday</option>
                                                            <option  value="2" <?php echo ( $st_ch_delivery_day == "2" ) ? "selected" : ''; ?>>Tuesday</option>
                                                            <option  value="3" <?php echo ( $st_ch_delivery_day == "3" ) ? "selected" : ''; ?>>Wednesday</option>
                                                            <option  value="4" <?php echo ( $st_ch_delivery_day == "4" ) ? "selected" : ''; ?>>Thursday</option>
                                                            <option  value="5" <?php echo ( $st_ch_delivery_day == "5" ) ? "selected" : ''; ?>>Friday</option>
                                                            <option  value="6" <?php echo ( $st_ch_delivery_day == "6" ) ? "selected" : ''; ?>>Saturday</option>
                                                            <option  value="7" <?php echo ( $st_ch_delivery_day == "7" ) ? "selected" : ''; ?>>Sunday</option>
                                                        </select>                          
                                                    </div>                        
                                                </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3">Denominations:</label>
                                                        <div class="col-md-4">
                                                            <?php 
                                                                $rp_50_checked = "checked";
                                                                if( isset( $change_order_fields['rp_50'] ) && $change_order_fields['rp_50'] == 1 ){ 
                                                                    $rp_50_checked = "checked";
                                                                } else{
                                                                    $rp_50_checked = "";
                                                                }

                                                            ?>
                                                            <div class='col-md-12'>
                                                                <div class="checkbox-wrap">
                                                                    <input type="checkbox" <?php echo $rp_50_checked; ?> id="rp_50" value="1" name='arr_rp[rp_50]' />
                                                                    <label for="rp_50">$50</label>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                                $rp_20_checked = "";
                                                                if( isset( $change_order_fields['rp_20'] ) && $change_order_fields['rp_20'] == 1 ){ 
                                                                    $rp_20_checked = "checked";
                                                                }else{
                                                                    $rp_20_checked = "";
                                                                } 
                                                            ?>
                                                            <div class='col-md-12 co_calculation'>
                                                                <div class="checkbox-wrap">
                                                                    <input type="checkbox" <?php echo $rp_20_checked; ?> id="rp_20" value="1" name='arr_rp[rp_20]' />
                                                                    <label for="rp_20">$20</label>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                $rp_10_checked = '';
                                                                if( isset( $change_order_fields['rp_10'] ) && $change_order_fields['rp_10'] == 1 ){ 
                                                                    $rp_10_checked = "checked";
                                                                }else{
                                                                    $rp_10_checked = "";
                                                                }  
                                                            ?>
                                                            <div class='col-md-12 co_calculation'>
                                                                <div class="checkbox-wrap">
                                                                    <input type="checkbox" <?php echo $rp_10_checked; ?> id="rp_10" value="1" name='arr_rp[rp_10]' />
                                                                    <label for="rp_10">$10</label>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                                $rp_5_checked = "";
                                                                if( isset( $change_order_fields['rp_5'] ) && $change_order_fields['rp_5'] == 1 ){ 
                                                                    $rp_5_checked = "checked";
                                                                }else{
                                                                    $rp_5_checked = "";
                                                                } 
                                                            ?>
                                                            <div class='col-md-12 co_calculation'>
                                                                <div class="checkbox-wrap">
                                                                    <input type="checkbox" <?php echo $rp_5_checked; ?> id="rp_5" value="1" name='arr_rp[rp_5]' />
                                                                    <label for="rp_5">$5</label>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                                $rp_1_checked = "";
                                                                if( isset( $change_order_fields['rp_1'] ) && $change_order_fields['rp_1'] == 1 ){ 
                                                                    $rp_1_checked = "checked";
                                                                }else{
                                                                    $rp_1_checked = "";
                                                                } 
                                                            ?>

                                                            <div class='col-md-12 co_calculation'>
                                                                <div class="checkbox-wrap">
                                                                    <input type="checkbox" <?php echo $rp_1_checked; ?> id="rp_1" value="1" name='arr_rp[rp_1]' />
                                                                    <label for="rp_1">$1</label>
                                                                </div>
                                                            </div>
                                                            <span class="help-block"></span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <?php 
                                                                $c_1_checked = "";
                                                                if( isset( $change_order_fields['c_1'] ) && $change_order_fields['c_1'] == 1 ){ 
                                                                    $c_1_checked = "checked";
                                                                }else{
                                                                    $c_1_checked = "";
                                                                } 
                                                            ?>
                                                            <div class='col-md-12'>
                                                                <div class="checkbox-wrap">
                                                                    <input type="checkbox" <?php echo $c_1_checked; ?> id="c_1" value="1" name='arr_rp[c_1]' />
                                                                    <label for="c_1">1¢</label>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                                $c_5_checked = "";
                                                                if( isset( $change_order_fields['c_5'] ) && $change_order_fields['c_5'] == 1 ){ 
                                                                    $c_5_checked = "checked";
                                                                }else{
                                                                    $c_5_checked = "";
                                                                } 
                                                            ?>
                                                            <div class='col-md-12 co_cent_calculation'>
                                                                <div class="checkbox-wrap">
                                                                    <input type="checkbox" id="c_5" <?php echo $c_5_checked; ?> value="1" name='arr_rp[c_5]' />
                                                                    <label for="c_5">5¢</label>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                                $c_10_checked = "";
                                                                if( isset( $change_order_fields['c_10'] ) && $change_order_fields['c_10'] == 1 ){ 
                                                                    $c_10_checked = "checked";
                                                                }else{
                                                                    $c_10_checked = "";
                                                                } 
                                                            ?>
                                                            <div class='col-md-12 co_cent_calculation'>
                                                                <div class="checkbox-wrap">
                                                                    <input type="checkbox" id="c_10" <?php echo $c_10_checked; ?> value="1" name='arr_rp[c_10]' />
                                                                    <label for="c_10">10¢</label>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                                $c_25_checked = "";
                                                                if( isset( $change_order_fields['c_25'] ) && $change_order_fields['c_25'] == 1 ){ 
                                                                    $c_25_checked = "checked";
                                                                }else{
                                                                    $c_25_checked = "";
                                                                } 
                                                            ?>
                                                            <div class='col-md-12 co_cent_calculation'>
                                                                <div class="checkbox-wrap">
                                                                    <input type="checkbox" id="c_25" <?php echo $c_25_checked; ?> value="1" name='arr_rp[c_25]' />
                                                                    <label for="c_25">25¢</label>
                                                                </div>
                                                            </div>

                                                            <span class="help-block"></span>
                                                        </div>
                                                    </div>
                                            </div>
                                            <input type="hidden" name="txt_bo_id" id="txt_bo_id" value="<?php echo $user_id; ?>" />
                                            
                                        </div>
                                    </div>
                                    <?php 
                                    $co_data = $pickup->get_all_change_order_by_bo( $user_id );
                                    $disable = '';
                                    if( isset( $co_data ) &&  is_array( $co_data ) ){
                                        $disable = 'disabled';
                                    }
                                    ?>
                                    <div class="panel-footer">  
                                        <button type="submit" <?php echo $disable; ?> class="btn btn-primary pull-right loader">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
                                <div class="form-group">
                                    <label class="col-md-3">Location Name:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="validate[required] form-control" id="txt_location_name" name="txt_location_name"/>
                                        <span class="help-block">Required</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Store ID:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="validate[required] form-control" id="txt_store_id" name="txt_store_id"/>
                                        <span class="help-block">Required</span>
                                    </div>
                                </div>
                                <!--                                <div class="form-group">
                                    <label class="col-md-3">Store manager name:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="validate[required] form-control" id="txt_store_manager_name" name="txt_store_manager_name"/>
                                        <span class="help-block">Required</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Store manager email:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="validate[required] form-control" id="txt_store_manager_email" name="txt_store_manager_email"/>
                                        <span class="help-block">Required</span>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <label class="col-md-3">Full Address:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="validate[required] form-control" id="txt_address" name="txt_address" placeholder="Address" />
                                        <input type="hidden" id="hdn_latitude" name="hdn_latitude" value=""/>
                                        <input type="hidden" id="hdn_longitude" name="hdn_longitude" value=""/>
                                        <span class="help-block">Required</span>
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

<div class="modal fade" id="add_co_pickup_location" role="dialog">
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
                                    <label class="col-md-3">Location Name:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="validate[required] form-control" id="txt_location_name" name="txt_location_name"/>
                                        <span class="help-block">Required</span>
                                    </div>
                                </div>
                                <!--                                <div class="form-group">
                                    <label class="col-md-3">Store manager name:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="validate[required] form-control" id="txt_store_manager_name" name="txt_store_manager_name"/>
                                        <span class="help-block">Required</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Store manager email:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="validate[required] form-control" id="txt_store_manager_email" name="txt_store_manager_email"/>
                                        <span class="help-block">Required</span>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <label class="col-md-3">Store manager email:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="validate[required] form-control" id="txt_store_manager_email" name="txt_store_manager_email"/>
                                        <span class="help-block">Required</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Full Address:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="validate[required] form-control" id="txt_co_address" name="txt_address" placeholder="Address" />
                                        <input type="hidden" id="hdn_co_latitude" name="hdn_latitude" value=""/>
                                        <input type="hidden" id="hdn_co_longitude" name="hdn_longitude" value=""/>
                                        <span class="help-block">Required</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3"></label>
                                    <div class="col-md-9">
                                        <div id="location_co" style="width: 100%; height: 200px;"></div>
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



<script type="text/javascript" src="<?php echo JS_PATH; ?>location.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>pickup.js"></script>
<?php
include_once FL_LOGIN_FOOTER;
?>