<?php 
session_start();
require_once '../../config/config.php';
require_once '../../backend/config/admin_config.php';
if( !isset( $_SESSION['user_id'] ) && !isset( $_SESSION['user_type'] ) ){
    header( "location:" . VW_LOGOUT );
} else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] != "store_manager"  ){	
    header( "location:" . BASE_URL );
} else if( isset( $_SESSION['admin_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "admin"  ){	
    header( "location:" . BASE_URL );
}
include_once FL_LOGIN_HEADER;
include_once FL_LOGIN_SIDEBAR;

$user_id = isset( $_SESSION['user_id'] ) &&  $_SESSION['user_id']  != '' ? $_SESSION['user_id'] : '';
include_once FL_USER;
$user = new user();
include_once FL_LOCATION;
$location = new location();
$manager_ids = $location->get_location_data_by( 'in_manager_id' , $user_id );
$arr_managerids = array();
if( isset( $manager_ids ) && $manager_ids > 0  ){
    if( isset( $manager_ids['in_user_id'] ) ){
        $manager_ids = array( $manager_ids );
    }
    foreach( $manager_ids as $mk => $mv ){
        array_push( $arr_managerids , $mv['in_user_id'] );
    }
}
$arr_manager_id = array_unique( $arr_managerids );
if( isset( $arr_manager_id ) && is_array( $arr_manager_id ) ){
    foreach( $arr_manager_id as $ak => $av ){
        $bo_data = $user->get_bo_data_by( 'in_user_id', $av );
    }
}
$st_change_order_fields = $user->get_bo_data_by_key( $bo_data['in_user_id'], 'st_change_order_fields' );
if( isset( $st_change_order_fields ) ){
    $change_order_fields = json_decode( $st_change_order_fields, true );
}
$change_order_fields = json_decode( $bo_data['st_change_order_fields'], true ) ;
?>
<!-- PAGE CONTENT -->
<div class="page-content">

    <!-- START X-NAVIGATION VERTICAL -->
    <?php  include_once FL_LOGIN_SUB_HEADER; ?> 
    <!-- END X-NAVIGATION VERTICAL -->    


    <!-- PAGE CONTENT WRAPPER -->
     
    <div class="page-content-wrap">
        <!-- START WIDGETS -->                    
        <div class="row">
            <div class="col-md-12 ">
                <?php
                if( isset( $bo_data['st_ch_from_to_day'] ) && $bo_data['st_ch_from_to_day'] != "" ){
                    $bo_ch_day = json_decode( $bo_data['st_ch_from_to_day'],true );
                }
                if( isset( $bo_ch_day ) && $bo_ch_day != "" && !in_array( date("N") , $bo_ch_day ) ){
                    $first = reset( $bo_ch_day );
                    $last = end( $bo_ch_day );
                    $f_day = date( 'l', strtotime(" Sunday +{$first} days") );
                    $t_day = date( 'l', strtotime(" Sunday +{$last} days") );
                    ?>
                    <div class="panel panel-default">
                        <div class="co-body">
                            <div class="panel-body  col-md-12">
                                <h4>
                                    You can add request from <?php echo $f_day; ?> ( 12:00 AM ) to <?php echo $t_day; ?> ( 11:59 PM )
                                </h4>
                            </div>
                        </div>
                    </div>
                    <?php
                }else if( isset( $bo_ch_day ) && $bo_ch_day != "" && in_array( date("N") , $bo_ch_day ) ){
                    ?>
                <div class="alert alert-success alert-dismissable pickup-success hide-el" style="display: none;">

                    <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                    <span class="pickup-msg"></span>

                </div>

                <div class="alert alert-danger alert-dismissable pickup-failed hide-el" style="display: none;">

                    <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                    <span class="pickup-msg"></span>

                </div>
                <form class="form-horizontal" method="post" name="frm_change_orders" id="frm_change_orders" >
                    <div class="panel panel-default">
                        <div class="co-body">
                            <div class="panel-body  col-md-12">
                                <div class="panel-heading">
                                    <h3 class="panel-title" style="text-transform: capitalize">change Order</h3>
                                </div>
                                <div class="alert alert-danger alert-dismissable amount-failed hide-el" style="display: none;">

                                    <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                    <span class="amount-msg"></span>

                                </div>
                                <div style="margin-top: 60px;">
                                    <?php 
                                        $bo_id = $user->get_bo_data_by( 'in_store_manager_id', $user_id );
                                        if( isset( $bo_id ) && $bo_id != "" || $bo_id > 0 ){
                                    ?>
                                    <div class="form-group pickup_location">
                                        <label class="col-md-3">Pickup Location:</label>
                                        <div class="col-md-3">
                                            <?php 
                                            $location_data = $location->get_location_by_type( $bo_id['in_user_id'] , 'single' );  ?>
                                            <select class="select_location" id="pickup_location" name="change[0][location]">
<!--                                                <option value="0">Choose location</option>-->
                                                <?php 
                                                if( isset( $location_data ) ){
                                                    foreach( $location_data as $l_data ){
                                                    ?>
                                                        <option  value="<?php echo $l_data['in_location_id']; ?>"><?php echo $l_data['st_store_id']; ?></option>
                                                <?php }
                                                }?>
                                            </select>                           
                                        </div>                        
                                    </div>
                                        <?php } ?>
                                    <div class="form-group ch_amount">
                                        <label class="col-md-3">Denominations:</label>
                                        <div class="col-md-4">
                                            <?php 
                                            if( isset( $change_order_fields['rp_50'] ) && $change_order_fields['rp_50'] == 1 ){ ?>
                                            <div class='col-md-12 co_calculation'>
                                                <label class="col-md-2">$50:</label>
                                                <input type='hidden' value='50' class='change_co_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number" class="form-control pickup_amt"  name="change[0][amt_d_50]"/>
                                                </div>
                                                <label class="col-md-2 sub_amt"></label>
                                                <input type="hidden" class="sub_amoumt"/>
                                            </div>
                                            <?php } ?>
                                            <?php if( isset( $change_order_fields['rp_20'] ) && $change_order_fields['rp_20'] == 1 ){ ?>
                                            <div class='col-md-12 co_calculation'>
                                                <label class="col-md-2">$20:</label>
                                                <input type='hidden' value='20' class='change_co_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number" class=" form-control pickup_amt"  name="change[0][amt_d_20]"/>
                                                </div>
                                                <label class="col-md-2 sub_amt"></label>
                                                <input type="hidden" class="sub_amoumt"/>
                                            </div>
                                            <?php } ?>
                                            <?php if( isset( $change_order_fields['rp_10'] ) && $change_order_fields['rp_10'] == 1 ){ ?>
                                            <div class='col-md-12 co_calculation'>
                                                <label class="col-md-2">$10:</label>
                                                <input type='hidden' value='10' class='change_co_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number" class=" form-control pickup_amt"  name="change[0][amt_d_10]"/>
                                                </div>
                                                <label class="col-md-2 sub_amt"></label>
                                                <input type="hidden" class="sub_amoumt"/>
                                            </div>
                                            <?php } ?>
                                            <?php if( isset( $change_order_fields['rp_5'] ) && $change_order_fields['rp_5'] == 1 ){ ?>
                                            <div class='col-md-12 co_calculation'>
                                                <label class="col-md-2">$5:</label>
                                                <input type='hidden' value='5' class='change_co_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number" class=" form-control pickup_amt"  name="change[0][amt_d_5]"/>
                                                </div>
                                                <label class="col-md-2 sub_amt"></label>
                                                <input type="hidden" class="sub_amoumt"/>
                                            </div>
                                            <?php } ?>
                                            <?php if( isset( $change_order_fields['rp_1'] ) && $change_order_fields['rp_1'] == 1 ){ ?>
                                            <div class='col-md-12 co_calculation'>
                                                <label class="col-md-2">$1:</label>
                                                <input type='hidden' value='1' class='change_co_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number"  class=" form-control pickup_amt"  name="change[0][amt_d_1]"/>
                                                </div>
                                                <label class="col-md-2 sub_amt"></label>
                                                <input type="hidden" class="sub_amoumt"/>
                                            </div>
                                            <?php } ?>
                                            <?php if( isset( $change_order_fields['rp_1'] ) || isset( $change_order_fields['rp_10'] ) || 
                                                isset( $change_order_fields['rp_5'] ) || isset( $change_order_fields['rp_20'] ) || isset( $change_order_fields['rp_50'] ) ){?>
                                            <div class='col-md-12'>
                                                <label class="col-md-2">Total:</label>
                                                <label class="col-md-10 total_cost">0.00</label>
                                                <input type="hidden" class="sub_total_amoumt" value="0"/>
                                            </div>
                                                <?php } ?>
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <?php if( isset( $change_order_fields['c_1'] ) && $change_order_fields['c_1'] == 1 ){ ?>
                                            <div class='col-md-12 co_cent_calculation'>
                                                <label class="col-md-2">1¢:</label>
                                                <input type='hidden' value='1' class='change_co_cent_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number" class=" form-control pickup_cent_amt"  name="change[0][amt_c_1]"/>
                                                </div>
                                                <label class="col-md-2 sub_cent_amt"></label>
                                                <input type="hidden" class="sub_cent_amoumt"/>
                                            </div>
                                            <?php } ?>
                                            <?php if( isset( $change_order_fields['c_5'] ) && $change_order_fields['c_5'] == 1 ){ ?>
                                            <div class='col-md-12 co_cent_calculation'>
                                                <label class="col-md-2">5¢:</label>
                                                <input type='hidden' value='5' class='change_co_cent_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number"  class=" form-control pickup_cent_amt"  name="change[0][amt_c_5]"/>
                                                </div>
                                                <label class="col-md-2 sub_cent_amt"></label>
                                                <input type="hidden" class="sub_cent_amoumt"/>
                                            </div>
                                            <?php } ?>
                                            <?php if( isset( $change_order_fields['c_10'] ) && $change_order_fields['c_10'] == 1 ){ ?>
                                            <div class='col-md-12 co_cent_calculation'>
                                                <label class="col-md-2">10¢:</label>
                                                <input type='hidden' value='10' class='change_co_cent_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number"  class=" form-control pickup_cent_amt"  name="change[0][amt_c_10]"/>
                                                </div>
                                                <label class="col-md-2 sub_cent_amt"></label>
                                                <input type="hidden" class="sub_cent_amoumt"/>
                                            </div>
                                            <?php } ?>
                                            <?php if( isset( $change_order_fields['c_25'] ) && $change_order_fields['c_25'] == 1 ){ ?>
                                            <div class='col-md-12 co_cent_calculation'>
                                                <label class="col-md-2">25¢:</label>
                                                <input type='hidden' value='25' class='change_co_cent_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number" class="form-control pickup_cent_amt"  name="change[0][amt_c_25]"/>
                                                </div>
                                                <label class="col-md-2 sub_cent_amt"></label>
                                                <input type="hidden" class="sub_cent_amoumt"/>
                                            </div>
                                            <?php } ?>
                                            <?php if( isset( $change_order_fields['c_1'] ) || isset( $change_order_fields['c_5'] ) || 
                                                isset( $change_order_fields['c_10'] ) || isset( $change_order_fields['c_25'] ) ){?>
                                            <div class='col-md-12'>
                                                <label class="col-md-2">Total:</label>
                                                <label class="col-md-10 total_cent_cost">0.00</label>
                                                <input type="hidden" class="sub_cent_total_amoumt" value="0"/>
                                            </div>
                                            <?php } ?>
                                            <span class="help-block"></span>
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label class="col-md-3">Grand Total:</label>
                                            <div class="col-md-9 grand_total">
                                                0.00
                                            </div>
                                            <input type="hidden" class="gt_total_amoumt" value="0" name="change[0][gt_amt]"/>
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
                <?php
                }else if( date("N") == "6" || date("N") == "7" ){
                    ?>
                    <div class="panel panel-default">
                        <div class="co-body">
                            <div class="panel-body  col-md-12">
                                <h4>
                                    You can add request from Monday ( 12:00 AM ) to Friday ( 11:59 PM )
                                </h4>
                            </div>
                        </div>
                    </div>
                    <?php
                }else{
                    
                ?>
                <div class="alert alert-success alert-dismissable pickup-success hide-el" style="display: none;">

                    <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                    <span class="pickup-msg"></span>

                </div>

                <div class="alert alert-danger alert-dismissable pickup-failed hide-el" style="display: none;">

                    <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                    <span class="pickup-msg"></span>

                </div>
                <form class="form-horizontal" method="post" name="frm_change_orders" id="frm_change_orders" >
                    <div class="panel panel-default">
                        <div class="co-body">
                            <div class="panel-body  col-md-12">
                                <div class="panel-heading">
                                    <h3 class="panel-title" style="text-transform: capitalize">change Order</h3>
                                </div>
                                <div class="alert alert-danger alert-dismissable amount-failed hide-el" style="display: none;">

                                    <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                    <span class="amount-msg"></span>

                                </div>
                                <div style="margin-top: 60px;">
                                    <?php 
                                        $bo_id = $user->get_bo_data_by( 'in_store_manager_id', $user_id );
                                        if( isset( $bo_id ) && $bo_id != "" || $bo_id > 0 ){
                                    ?>
                                    <div class="form-group pickup_location">
                                        <label class="col-md-3">Pickup Location:</label>
                                        <div class="col-md-3">
                                            <?php 
                                            $location_data = $location->get_all_location( $bo_id['in_user_id'] );  ?>
                                            <select class="select_location" id="pickup_location" name="change[0][location]">
<!--                                                <option value="0">Choose location</option>-->
                                                <?php 
                                                if( isset( $location_data ) ){
                                                    foreach( $location_data as $l_data ){
                                                    ?>
                                                        <option  value="<?php echo $l_data['in_location_id']; ?>"><?php echo $l_data['st_store_id']; ?></option>
                                                <?php }
                                                }?>
                                            </select>                           
                                        </div>                        
                                    </div>
                                    <?php } ?>
                                    <div class="form-group ch_amount">
                                        <label class="col-md-3">Denominations:</label>
                                        <div class="col-md-4">
                                            <div class='col-md-12 co_calculation'>
                                                <label class="col-md-2">$50:</label>
                                                <input type='hidden' value='50' class='change_co_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number" class="form-control pickup_amt"  name="change[0][amt_d_50]"/>
                                                </div>
                                                <label class="col-md-2 sub_amt"></label>
                                                <input type="hidden" class="sub_amoumt"/>
                                            </div>
                                            <div class='col-md-12 co_calculation'>
                                                <label class="col-md-2">$20:</label>
                                                <input type='hidden' value='20' class='change_co_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number" class=" form-control pickup_amt"  name="change[0][amt_d_20]"/>
                                                </div>
                                                <label class="col-md-2 sub_amt"></label>
                                                <input type="hidden" class="sub_amoumt"/>
                                            </div>
                                            <div class='col-md-12 co_calculation'>
                                                <label class="col-md-2">$10:</label>
                                                <input type='hidden' value='10' class='change_co_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number" class=" form-control pickup_amt"  name="change[0][amt_d_10]"/>
                                                </div>
                                                <label class="col-md-2 sub_amt"></label>
                                                <input type="hidden" class="sub_amoumt"/>
                                            </div>
                                            <div class='col-md-12 co_calculation'>
                                                <label class="col-md-2">$5:</label>
                                                <input type='hidden' value='5' class='change_co_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number" class=" form-control pickup_amt"  name="change[0][amt_d_5]"/>
                                                </div>
                                                <label class="col-md-2 sub_amt"></label>
                                                <input type="hidden" class="sub_amoumt"/>
                                            </div>
                                            <div class='col-md-12 co_calculation'>
                                                <label class="col-md-2">$1:</label>
                                                <input type='hidden' value='1' class='change_co_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number"  class=" form-control pickup_amt"  name="change[0][amt_d_1]"/>
                                                </div>
                                                <label class="col-md-2 sub_amt"></label>
                                                <input type="hidden" class="sub_amoumt"/>
                                            </div>
                                            <div class='col-md-12'>
                                                <label class="col-md-2">Total:</label>
                                                <label class="col-md-10 total_cost">0.00</label>
                                                <input type="hidden" class="sub_total_amoumt" value="0"/>
                                            </div>
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <div class='col-md-12 co_cent_calculation'>
                                                <label class="col-md-2">1¢:</label>
                                                <input type='hidden' value='1' class='change_co_cent_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number" class=" form-control pickup_cent_amt"  name="change[0][amt_c_1]"/>
                                                </div>
                                                <label class="col-md-2 sub_cent_amt"></label>
                                                <input type="hidden" class="sub_cent_amoumt"/>
                                            </div>
                                            <div class='col-md-12 co_cent_calculation'>
                                                <label class="col-md-2">5¢:</label>
                                                <input type='hidden' value='5' class='change_co_cent_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number"  class=" form-control pickup_cent_amt"  name="change[0][amt_c_5]"/>
                                                </div>
                                                <label class="col-md-2 sub_cent_amt"></label>
                                                <input type="hidden" class="sub_cent_amoumt"/>
                                            </div>
                                            <div class='col-md-12 co_cent_calculation'>
                                                <label class="col-md-2">10¢:</label>
                                                <input type='hidden' value='10' class='change_co_cent_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number"  class=" form-control pickup_cent_amt"  name="change[0][amt_c_10]"/>
                                                </div>
                                                <label class="col-md-2 sub_cent_amt"></label>
                                                <input type="hidden" class="sub_cent_amoumt"/>
                                            </div>
                                            <div class='col-md-12 co_cent_calculation'>
                                                <label class="col-md-2">25¢:</label>
                                                <input type='hidden' value='25' class='change_co_cent_amt'/>
                                                <div class='col-md-8'>
                                                    <input type="number" class="form-control pickup_cent_amt"  name="change[0][amt_c_25]"/>
                                                </div>
                                                <label class="col-md-2 sub_cent_amt"></label>
                                                <input type="hidden" class="sub_cent_amoumt"/>
                                            </div>
                                            <div class='col-md-12'>
                                                <label class="col-md-2">Total:</label>
                                                <label class="col-md-10 total_cent_cost">0.00</label>
                                                <input type="hidden" class="sub_cent_total_amoumt" value="0"/>
                                            </div>
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="col-md-3">Grand Total:</label>
                                            <div class="col-md-9 grand_total">
                                                0.00

                                            </div>
                                            <input type="hidden" class="gt_total_amoumt" value="0" name="change[0][gt_amt]"/>
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
                <?php } ?>
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

<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=<?php echo GOOGLE_MAPS_API_KEY; ?>"></script>
<script type="text/javascript" src="<?php echo JS_PLUGINS_PATH; ?>location-picker/locationpicker.jquery.min.js"></script>

<script type="text/javascript" src="<?php echo JS_PATH; ?>location.js"></script>
<?php
include_once FL_LOGIN_FOOTER;
?>