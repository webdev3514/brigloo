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
include_once FL_GROUP;
$group = new group(); 
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
                    <li class="active"><a href="#unassign_job" data-toggle="tab">Unassign Pick Ups<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="List of un-assign pickup request, by Select and merge can assign pickup list to driver."><i class="fa fa-info"></i></button></a></li>
                    <li><a href="#pending_job" data-toggle="tab">Pending Trips<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=" List of all Pending jobs which assign to All the driver but not taken by any driver."><i class="fa fa-info"></i></button></a></li>
                    <li><a href="#assign_job" data-toggle="tab">Assigned Trips<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="List of all assigned job of driver "><i class="fa fa-info"></i></button></a></li>
                    <li><a href="#archied_job" data-toggle="tab">Archived Pick Ups<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title=" List of all past pick up date"><i class="fa fa-info"></i></button></a></li>
                    <li><a href="#completed_job" data-toggle="tab">Completed Trips<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="List of all completed job"><i class="fa fa-info"></i></button></a></li>
                </ul>
                <div class="panel-body tab-content">
                    <div class="tab-pane active" id="unassign_job" role="tabpanel">
                        <div class="panel panel-default nav-tabs-vertical">
                            <div class="tab-pane active">
                                <div class="tabs">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a class="pickup_date"  href="#pickup_job_all" data-toggle="tab" data-date="all">All Pick UP</a></li>
                                        <li><a class="pickup_date"  href="#pickup_job_today" data-toggle="tab" data-date="today">Todays's Pick UP</a></li>
                                        <li><a class="pickup_date" href="#pickup_job_tomorrow" data-toggle="tab" data-date="tomorrow"unassign_job>Tomorrow Pick UP</a></li>
                                        <li><a class="pickup_date" href="#pickup_job_week" data-toggle="tab" data-date="week">This week</a></li>
                                        <li><a class="pickup_date" href="#pickup_job_month" data-toggle="tab" data-date="month">This Month</a></li>
                                    </ul>
                                                        
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="pickup_job_all" role="tabpanel">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Pick UP List</h3>
                                                <a href="#" class="a-pickup"><div class="btn btn-danger assign_drivers_job" data-toggle="modal" data-target="#pickup_job_assign">Merge & send to drivers</div></a>
                                                <a href="#" class="a-pickup"><div class="btn btn-danger check_driver_name" data-toggle="modal" data-target="#pickup_job_assign">Merge & select driver</div></a>
                                            </div>
                                            <div class="panel-body table-responsive">
                                                <table id="pickup_list" class="table datatable ">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Action</th>
                                                            <th>Id</th>
                                                            <th>Pick UP Date</th>
                                                            <th>Location</th>
                                                            <th>Group Name</th>
                                                            <th>Amount</th>
                                                            <th>Requested By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $all_userdata = $pickup->get_admin_unassign_pickups( 'all' );
                                                        if( isset( $all_userdata ) && $all_userdata != '' ){
                                                            foreach( $all_userdata as $key => $value ){
                                                                $location_name = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                                                $location_grp_id = $location->get_location_by_key( $value['in_location_id'], 'in_group_id' );
                                                                $group_name = $group->get_group_by_key( $location_grp_id, 'st_group_name' );
                                                                $location_address = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                                                $user_name = $user->get_user_data_by_key( $value['in_user_id'], 'st_first_name' );
                                                            ?>
                                                            <tr class="pickup_<?php echo $value['in_pickup_id']; ?>" >
                                                                <td>
                                                                    <div class="checkbox-wrap">
                                                                        <input type="checkbox" id="pickup_<?php echo $value['in_pickup_id']; ?>" class='arr_pickup' name='arr_pick[]' data-date='<?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) );  ?>' data-id='<?php echo $value['in_pickup_id']; ?>' data-group-id="<?php echo $location_grp_id; ?>" value='<?php echo $value['in_pickup_id']; ?>' />
                                                                        <label for="pickup_<?php echo $value['in_pickup_id']; ?>"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="button-wrap">
                                                                        <button class="btn btn-danger cancel_pickup" name="cancel_pickup" data-pickup-id="<?php echo $value['in_pickup_id']; ?>"><i class="fa fa-close"></i></button>
                                                                        <button  class="btn btn-danger view_icon view_pickup_detail" data-pickup-id="<?php echo $value['in_pickup_id']; ?>" ><i class="fa fa-eye"></i></button>
                                                                    </div>
                                                                </td>
                                                                <td><span>#</span><?php echo $value['in_pickup_id']; ?></td>
                                                                <td class="pickup_date_check" data-group-id="<?php echo $location_grp_id; ?>"  data-date="<?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?>"><?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?></td>
                                                                <td class="cut_location_address" title="<?php echo $location_address; ?>"><?php echo $location_name; ?></td>
                                                                <td><?php echo isset( $group_name ) && $group_name != "" ? $group_name : '-'; ?></td>
                                                                <td class="pickup_amount"><?php echo '$' . ( isset( $value['fl_amount'] ) && $value['fl_amount'] == '' || $value['fl_amount'] > 0 ? $value['fl_amount'] : "0" ); ?></td>
                                                                <td><?php
                                                                    if( $value['st_order_type'] == "change_order" ){ 
                                                                        $bo_data = $user->get_bo_data_by( 'in_store_manager_id', $value['in_user_id'] );
                                                                        $user_name = $user->get_user_data_by_key( $bo_data['in_user_id'], 'st_first_name' );
                                                                        echo $user_name;
                                                                    }else{
                                                                        echo $user_name;
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
                                        <div class="tab-pane" id="pickup_job_today" role="tabpanel">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Pick UP List</h3>
                                                <a href="#" class="a-pickup"><div class="btn btn-danger assign_drivers_job" data-toggle="modal" data-target="#pickup_job_assign">Merge & send to drivers</div></a>
                                                <a href="#" class="a-pickup"><div class="btn btn-danger check_driver_name" data-toggle="modal" data-target="#pickup_job_assign">Merge & select driver</div></a>
                                            </div>
                                            <div class="panel-body table-responsive">
                                                <table id="pickup_list1" class="table datatable pickup_job_list">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Action</th>
                                                            <th>Id</th>
                                                            <th>Pick UP Date</th>
                                                            <th>Location</th>
                                                            <th>Group Name</th>
                                                            <th>Amount</th>
                                                            <th>Requested By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $all_userdata = $pickup->get_admin_unassign_pickups( 'today' );
                                                        if( isset( $all_userdata ) && $all_userdata != '' ){
                                                            foreach( $all_userdata as $key => $value ){
                                                                $location_name = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                                                $location_grp_id = $location->get_location_by_key( $value['in_location_id'], 'in_group_id' );
                                                                $group_name = $group->get_group_by_key( $location_grp_id, 'st_group_name' );
                                                                $location_address = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                                                $user_name = $user->get_user_data_by_key( $value['in_user_id'], 'st_first_name' );
                                                            ?>
                                                            <tr class="pickup_<?php echo $value['in_pickup_id']; ?>">
                                                                <td>
                                                                    <div class="checkbox-wrap">
                                                                        <input type="checkbox" id="pickup_<?php echo $value['in_pickup_id']; ?>" class='arr_pickup' name='arr_pick[]' data-date='<?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) );  ?>' data-id='<?php echo $value['in_pickup_id']; ?>' value='<?php echo $value['in_pickup_id']; ?>' />
                                                                        <label for="pickup_<?php echo $value['in_pickup_id']; ?>"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="button-wrap">
                                                                        <button class="btn btn-danger cancel_pickup" name="cancel_pickup" data-pickup-id="<?php echo $value['in_pickup_id']; ?>"><i class="fa fa-close"></i></button>
                                                                        <button  class="btn btn-danger view_icon view_pickup_detail" data-pickup-id="<?php echo $value['in_pickup_id']; ?>" ><i class="fa fa-eye"></i></button>
                                                                    </div>
                                                                </td>
                                                                <td><span>#</span><?php echo $value['in_pickup_id']; ?></td>
                                                                <td class="pickup_date_check" data-date="<?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?>"><?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?></td>
                                                                <td class="cut_location_address" title="<?php echo $location_address; ?>"><?php echo $location_name; ?></td>
                                                                <td><?php echo $group_name; ?></td>
                                                                <td  class="pickup_amount"><?php echo '$' . ( isset( $value['fl_amount'] ) && $value['fl_amount'] == '' || $value['fl_amount'] > 0 ? $value['fl_amount'] : "0" ); ?></td>
                                                                <td><?php
                                                                    if( $value['st_order_type'] == "change_order" ){ 
                                                                        $bo_data = $user->get_bo_data_by( 'in_store_manager_id', $value['in_user_id'] );
                                                                        $user_name = $user->get_user_data_by_key( $bo_data['in_user_id'], 'st_first_name' );
                                                                        echo $user_name;
                                                                    }else{
                                                                        echo $user_name;
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
                                        <div class="tab-pane" id="pickup_job_tomorrow" role="tabpanel">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Pick UP List</h3>
                                                <a href="#" class="a-pickup"><div class="btn btn-danger assign_drivers_job" data-toggle="modal" data-target="#pickup_job_assign">Merge & send to drivers</div></a>
                                                <a href="#" class="a-pickup"><div class="btn btn-danger check_driver_name" data-toggle="modal" data-target="#pickup_job_assign">Merge & select driver</div></a>
                                            </div>
                                            <div class="panel-body table-responsive">
                                                <table id="pickup_list3" class="table datatable pickup_job_list">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Action</th>
                                                            <th>Id</th>
                                                            <th>Pick UP Date</th>
                                                            <th>Location</th>
                                                            <th>Group Name</th>
                                                            <th>Amount</th>
                                                            <th>Requested By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $all_userdata = $pickup->get_admin_unassign_pickups( 'tomorrow' );
                                                        if( isset( $all_userdata ) && $all_userdata != '' ){
                                                            foreach( $all_userdata as $key => $value ){
                                                                $location_name = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                                                $location_address = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                                                $location_grp_id = $location->get_location_by_key( $value['in_location_id'], 'in_group_id' );
                                                                $group_name = $group->get_group_by_key( $location_grp_id, 'st_group_name' );
                                                                $user_name = $user->get_user_data_by_key( $value['in_user_id'], 'st_first_name' );
                                                            ?>
                                                            <tr class="pickup_<?php echo $value['in_pickup_id']; ?>">
                                                                <td>
                                                                    <div class="checkbox-wrap">
                                                                        <input type="checkbox" id="pickup_<?php echo $value['in_pickup_id']; ?>" class='arr_pickup' name='arr_pick[]' data-date='<?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) );  ?>' data-id='<?php echo $value['in_pickup_id']; ?>' value='<?php echo $value['in_pickup_id']; ?>' />
                                                                        <label for="pickup_<?php echo $value['in_pickup_id']; ?>"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="button-wrap">
                                                                        <button class="btn btn-danger cancel_pickup" name="cancel_pickup" data-pickup-id="<?php echo $value['in_pickup_id']; ?>"><i class="fa fa-close"></i></button>
                                                                        <button  class="btn btn-danger view_icon view_pickup_detail" data-pickup-id="<?php echo $value['in_pickup_id']; ?>" ><i class="fa fa-eye"></i></button> 
                                                                    </div>
                                                                </td>
                                                                <td><span>#</span><?php echo $value['in_pickup_id']; ?></td>
                                                                <td class="pickup_date_check" data-date="<?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?>"><?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?></td>
                                                                <td class="cut_location_address" title="<?php echo $location_address; ?>"><?php echo $location_name; ?></td>
                                                                <td><?php echo $group_name; ?></td>
                                                                <td  class="pickup_amount"><?php echo '$' . ( isset( $value['fl_amount'] ) && $value['fl_amount'] == '' || $value['fl_amount'] > 0 ? $value['fl_amount'] : "0" ); ?></td>
                                                                <td><?php
                                                                    if( $value['st_order_type'] == "change_order" ){ 
                                                                        $bo_data = $user->get_bo_data_by( 'in_store_manager_id', $value['in_user_id'] );
                                                                        $user_name = $user->get_user_data_by_key( $bo_data['in_user_id'], 'st_first_name' );
                                                                        echo $user_name;
                                                                    }else{
                                                                        echo $user_name;
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
                                        <div class="tab-pane" id="pickup_job_week" role="tabpanel">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Pick UP List</h3>
                                                <a href="#" class="a-pickup"><div class="btn btn-danger assign_drivers_job" data-toggle="modal" data-target="#pickup_job_assign">Merge & send to drivers</div></a>
                                                <a href="#" class="a-pickup"><div class="btn btn-danger check_driver_name" data-toggle="modal" data-target="#pickup_job_assign">Merge & select driver</div></a>
                                            </div>
                                            <div class="panel-body table-responsive">
                                                <table id="pickup_list4" class="table datatable pickup_job_list">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Action</th>
                                                            <th>Id</th>
                                                            <th>Pick UP Date</th>
                                                            <th>Location</th>
                                                            <th>Group Name</th>
                                                            <th>Amount</th>
                                                            <th>Requested By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $all_userdata = $pickup->get_admin_unassign_pickups( 'week' );
                                                        if( isset( $all_userdata ) && $all_userdata != '' ){
                                                            foreach( $all_userdata as $key => $value ){
                                                                $location_name = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                                                $location_address = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                                                $location_grp_id = $location->get_location_by_key( $value['in_location_id'], 'in_group_id' );
                                                                $group_name = $group->get_group_by_key( $location_grp_id, 'st_group_name' );
                                                                $user_name = $user->get_user_data_by_key( $value['in_user_id'], 'st_first_name' );
                                                            ?>
                                                            <tr class="pickup_<?php echo $value['in_pickup_id']; ?>">
                                                                <td>
                                                                    <div class="checkbox-wrap">
                                                                        <input type="checkbox" id="pickup_<?php echo $value['in_pickup_id']; ?>" class='arr_pickup' name='arr_pick[]' data-date='<?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) );  ?>' data-id='<?php echo $value['in_pickup_id']; ?>' value='<?php echo $value['in_pickup_id']; ?>' />
                                                                        <label for="pickup_<?php echo $value['in_pickup_id']; ?>"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="button-wrap">
                                                                        <button class="btn btn-danger cancel_pickup" name="cancel_pickup" data-pickup-id="<?php echo $value['in_pickup_id']; ?>"><i class="fa fa-close"></i></button>
                                                                        <button  class="btn btn-danger view_icon view_pickup_detail" data-pickup-id="<?php echo $value['in_pickup_id']; ?>" ><i class="fa fa-eye"></i></button>
                                                                    </div>
                                                                </td>
                                                                <td><span>#</span><?php echo $value['in_pickup_id']; ?></td>
                                                                <td class="pickup_date_check" data-date="<?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?>"><?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?></td>
                                                                <td class="cut_location_address" title="<?php echo $location_address; ?>"><?php echo $location_name; ?></td>
                                                                <td><?php echo $group_name; ?></td>
                                                                <td  class="pickup_amount"><?php echo '$' . ( isset( $value['fl_amount'] ) && $value['fl_amount'] == '' || $value['fl_amount'] > 0 ? $value['fl_amount'] : "0" ); ?></td>
                                                              
                                                                <td><?php
                                                                    if( $value['st_order_type'] == "change_order" ){ 
                                                                        $bo_data = $user->get_bo_data_by( 'in_store_manager_id', $value['in_user_id'] );
                                                                        $user_name = $user->get_user_data_by_key( $bo_data['in_user_id'], 'st_first_name' );
                                                                        echo $user_name;
                                                                    }else{
                                                                        echo $user_name;
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
                                        <div class="tab-pane" id="pickup_job_month" role="tabpanel">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Pick UP List</h3>
                                                <a href="#" class="a-pickup"><div class="btn btn-danger assign_drivers_job" data-toggle="modal" data-target="#pickup_job_assign">Merge & send to drivers</div></a>
                                                <a href="#" class="a-pickup"><div class="btn btn-danger check_driver_name" data-toggle="modal" data-target="#pickup_job_assign">Merge & select driver</div></a>
                                            </div>
                                            <div class="panel-body table-responsive">
                                                <table id="pickup_list5" class="table datatable pickup_job_list">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Action</th>
                                                            <th>Id</th>
                                                            <th>Pick UP Date</th>
                                                            <th>Location</th>
                                                            <th>Group Name</th>
                                                            <th>Amount</th>
                                                            <th>Requested By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $all_userdata = $pickup->get_admin_unassign_pickups( 'month' );
                                                        if( isset( $all_userdata ) && $all_userdata != '' ){
                                                            foreach( $all_userdata as $key => $value ){
                                                                $location_name = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                                                $location_address = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                                                $user_name = $user->get_user_data_by_key( $value['in_user_id'], 'st_first_name' );
                                                                $location_grp_id = $location->get_location_by_key( $value['in_location_id'], 'in_group_id' );
                                                                $group_name = $group->get_group_by_key( $location_grp_id, 'st_group_name' );
                                                            ?>
                                                            <tr class="pickup_<?php echo $value['in_pickup_id']; ?>">
                                                                <td>
                                                                    <div class="checkbox-wrap">
                                                                        <input type="checkbox" id="pickup_<?php echo $value['in_pickup_id']; ?>" class='arr_pickup' name='arr_pick[]' data-date='<?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) );  ?>' data-id='<?php echo $value['in_pickup_id']; ?>' value='<?php echo $value['in_pickup_id']; ?>' />
                                                                        <label for="pickup_<?php echo $value['in_pickup_id']; ?>"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="button-wrap">
                                                                        <button class="btn btn-danger cancel_pickup" name="cancel_pickup" data-pickup-id="<?php echo $value['in_pickup_id']; ?>"><i class="fa fa-close"></i></button>
                                                                        <button  class="btn btn-danger view_icon view_pickup_detail" data-pickup-id="<?php echo $value['in_pickup_id']; ?>" ><i class="fa fa-eye"></i></button> 
                                                                    </div>
                                                                </td>
                                                                <td><span>#</span><?php echo $value['in_pickup_id']; ?></td>
                                                                <td class="pickup_date_check" data-date="<?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?>"><?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?></td>
                                                                <td class="cut_location_address" title="<?php echo $location_address; ?>"><?php echo $location_name; ?></td>
                                                                <td><?php echo $group_name; ?></td>
                                                                <td  class="pickup_amount"><?php echo '$' . ( isset( $value['fl_amount'] ) && $value['fl_amount'] == '' || $value['fl_amount'] > 0 ? $value['fl_amount'] : "0" ); ?></td>
                                                                <td><?php
                                                                    if( $value['st_order_type'] == "change_order" ){ 
                                                                        $bo_data = $user->get_bo_data_by( 'in_store_manager_id', $value['in_user_id'] );
                                                                        $user_name = $user->get_user_data_by_key( $bo_data['in_user_id'], 'st_first_name' );
                                                                        echo $user_name;
                                                                    }else{
                                                                        echo $user_name;
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
                                        <!-- END DATATABLE EXPORT --> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="pending_job" role="tabpanel">
                        <div class="page-content-wrap">
                            <!-- START WIDGETS -->                    
                            <div class="row">
                                <div class="col-md-12">
                                        <!-- START DATATABLE EXPORT -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Pick UP List</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                <table id="customers2" class="table datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Driver Name</th>
                                                            <th>Date Requested</th>
                                                            <th>Pick UP Date</th>
                                                            <th>Location</th>
                                                            <th >Amount</th>
                                                            <th>Status</th>
                                                            <th>Type</th>
                                                            <th>Recurring</th>
                                                            <th>Requested By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $all_userdata = $pickup->get_pending_assign_pickups();
                                                       
                                                        if( isset( $all_userdata ) && $all_userdata != '' ){
                                                            foreach( $all_userdata as $key => $value ){
                                                               $bo_user_name = $user->get_user_data_by_key( $value['bo_id'], 'st_first_name' );
                                                            ?>
                                                                <tr class="job_<?php echo $value['in_job_id']; ?>">
                                                                    <td><span>#</span><?php echo $value['in_job_id'];?></td>
                                                                    <td>All</td>
                                                                    <td><?php echo $value['dt_created_at'];?></td>
                                                                    <td><?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?></td>
                                                                    <td><?php echo $value['pickup_count'];?></td>
                                                                    <td  class="pickup_amount"><?php echo '$' . ( isset( $value['pickup_sum'] ) && $value['pickup_sum'] == '' || $value['pickup_sum'] > 0 ? $value['pickup_sum'] : "0" );?></td>
                                                                    <td><?php echo $value['st_status']; ?></td>
                                                                    <td><?php echo $value['pickup_type']; ?></td>
                                                                    <td><?php echo ( isset( $value['recurring'] ) &&  $value['recurring'] != "" ? $value['recurring'] : "No" ); ?></td>
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
                    <div class="tab-pane" id="assign_job" role="tabpanel">
                        <div class="page-content-wrap">
                            <!-- START WIDGETS -->                    
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- START DATATABLE EXPORT -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Trip List</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table id="assign_pickup_list" class="table datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Id</th>
                                                            <th>Driver Name</th>
                                                            <th>Pick UP Date</th>
                                                            <th>Amount</th>
                                                            <th>Requested By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $all_userdata = $pickup->get_assign_pickups();
                                                        if( isset( $all_userdata ) && $all_userdata != '' ){
                                                            foreach( $all_userdata as $key => $value ){
                                                                $bo_user_name = $user->get_user_data_by_key( $value['bo_id'], 'st_first_name' );
                                                                $driver_user_name = $user->get_user_data_by_key( $value['in_driver_id'], 'st_first_name' );
                                                            ?>
                                                                <tr class="job_<?php echo $value['in_job_id']; ?>">
                                                                    <td>
                                                                        <div class="button-wrap"><?php 
                                                                            if( $value['st_status'] == "assign" ){ ?>
                                                                                <button class="btn btn-danger reassign_pickup" data-toggle="modal" data-target="#pickup_reassign_driver" name="reassign_pickup" data-job-id="<?php echo $value['in_job_id']; ?>" data-bo-id="<?php echo $value['bo_id']; ?>">Re-Assign</button>
                                                                            <?php } ?>
                                                                            <button  class="btn btn-danger view_icon view_job_detail" data-job-id="<?php echo $value['in_job_id']; ?>"><i class="fa fa-eye"></i></button>
                                                                        </div>
                                                                    </td>
                                                                    <td><span>#</span><?php echo $value['in_job_id'];?></td>
                                                                    <td class="driver_name"><?php echo $driver_user_name;?></td>
                                                                    <td><?php echo date( "m-d-Y", strtotime( $value['dt_pickup'] ) ); ?></td>
                                                                    <td class="pickup_amount"><?php echo '$' . ( isset( $value['pickup_sum'] ) && $value['pickup_sum'] == '' || $value['pickup_sum'] > 0 ? $value['pickup_sum'] : "0" );?></td>
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
                    
                    <div class="tab-pane" id="archied_job" role="tabpanel">
                        <div class="page-content-wrap">
                            <!-- START WIDGETS -->                    
                            <div class="row">
                                <div class="col-md-12">
                                        <!-- START DATATABLE EXPORT -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Pick UP List</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                <table id="archive_pickup_list" class="table datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Id</th>
                                                            <th>Driver Name</th>
                                                            <th>Pick UP Date</th>
                                                            <th>Location</th>
                                                            <th>Amount</th>
                                                            <th>Requested By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $all_userdata = $pickup->get_archive_assign_pickups();
                                                        if( isset( $all_userdata ) && $all_userdata != '' ){
                                                            foreach( $all_userdata as $key => $value ){
                                                                $location_name = $location->get_location_by_key( $value['in_location_id'], 'st_location_name' );
                                                                $location_address = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                                                $bo_user_name = $user->get_user_data_by_key( $value['in_user_id'], 'st_first_name' );
                                                                $driver_id = $pickup->get_job_by_key( $value['in_job_id'], 'in_driver_id' );
                                                                $driver_user_name = $user->get_user_data_by_key( $driver_id, 'st_first_name' );
                                                            ?>
                                                                <tr class="pickup_<?php echo $value['in_pickup_id']; ?>">
                                                                    <td>
                                                                        <div class="button-wrap">
                                                                            <button  class="btn btn-danger view_icon view_pickup_detail" data-pickup-id="<?php echo $value['in_pickup_id']; ?>"><i class="fa fa-eye "></i></button>
                                                                        </div>
                                                                    </td>
                                                                    <td><span>#</span><?php echo $value['in_pickup_id'];?></td>
                                                                    <td><?php echo $driver_user_name;?></td>
                                                                    <td><?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?></td>
                                                                    <td><?php echo $location_name;?></td>
                                                                    <td class="pickup_amount"><?php echo '$' . ( isset( $value['fl_amount'] ) && $value['fl_amount'] == '' || $value['fl_amount'] > 0 ? $value['fl_amount'] : "0" );?></td>
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
                    <div class="tab-pane" id="completed_job" role="tabpanel">
                        <div class="page-content-wrap">
                            <!-- START WIDGETS -->                    
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- START DATATABLE EXPORT -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Completed Trip</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table id="completed_job_list" class="table datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Driver Name</th>
                                                            <th>Date Requested</th>
                                                            <th>Pick UP Date</th>
                                                            <th>Location</th>
                                                            <th  >Amount</th>
                                                            <th>Type</th>
                                                            <th>Recurring</th>
                                                            <th>Requested By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $all_userdata = $pickup->get_completed_job( );
                                                        if( isset( $all_userdata ) && $all_userdata != '' ){
                                                            foreach( $all_userdata as $key => $value ){
                                                                $bo_user_name = $user->get_user_data_by_key( $value['bo_id'], 'st_first_name' );
                                                                $driver_user_name = $user->get_user_data_by_key( $value['in_driver_id'], 'st_first_name' );
                                                            ?>
                                                                <tr class="job_<?php echo $value['in_job_id']; ?>">
                                                                    <td><span>#</span><?php echo $value['in_job_id'];?></td>
                                                                    <td><?php echo $driver_user_name;?></td>
                                                                    <td><?php echo $value['dt_created_at'];?></td>
                                                                    <td><?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?></td>
                                                                    <td><?php echo $value['pickup_count'];?></td>
                                                                    <td class="pickup_amount"><?php echo '$' . ( isset( $value['pickup_sum'] ) && $value['pickup_sum'] == '' || $value['pickup_sum'] > 0 ? $value['pickup_sum'] : "0" );?></td>
                                                                    <td><?php echo $value['pickup_type']; ?></td>
                                                                    <td><?php echo ( isset( $value['recurring'] ) &&  $value['recurring'] != "" ? $value['recurring'] : "No" ); ?></td>
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
                                <div class="other_location">
                                    <div class="form-group">
                                        <label class="col-md-3" for="txt_address">Other Address</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txt_address" name="txt_address" placeholder="Address" />
                                            <input type="hidden" id="hdn_latitude" name="hdn_latitude"/>
                                            <input type="hidden" id="hdn_longitude" name="hdn_longitude"/>
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
                                </div>
                                <div class="form-group assign_driver" >
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
                                <?php 
                                    $driver_pickup_amount = $settings->get_settings( 'driver_pickup_amount' , TRUE );
                                ?>
                                <input type="hidden" name="driver_amt" value="<?php echo $driver_pickup_amount; ?>" id="driver_amt" />
                                <div class="form-group">
                                    <label class="col-md-3">Amount ($)<span class="required-feild">*</span></label>
                                    <div class="col-md-9">
                                        <input type="number" required="" class="form-control" id="driver_pickup_amt" name="driver_pickup_amt"/>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                               
                                
                                <input type="hidden" name="driver_assign_mode" id="driver_assign_mode"/>
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


<div class="modal fade" id="pickup_reassign_driver" role="dialog">
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
                            <form id="frm_reassign_driver"  name="frm_reassign_driver" method="post" role="form" class="form-horizontal" action="">                            
                                <div class="form-group assign_driver" >
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
                                
                                <input type="hidden" name="reassign_job_id" id="reassign-job_id"/>
                                <input type="hidden" name="reassign_bo_id" id="reassign_bo_id"/>
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

<div class="modal fade" id="pickup_detail" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">View Details</h4>
            </div>
            <div class="modal-body">
                <div class="page-content-wrap" style="margin-top:20px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row" >
                                <label class="col-md-3">Date Requested:</label>
                                <label class="col-md-9 sw_pickup_ct_dt"></label>
                            </div>
                             <div class="form-group row" >
                                <label class="col-md-3">Address:</label>
                                <label class="col-md-9 sw_pickup_address"></label>
                            </div>
                            <div class="form-group row" >
                                <label class="col-md-3">Type:</label>
                                <label class="col-md-9 sw_pickup_type"></label>
                            </div>
                            <div class="form-group row" >
                                <label class="col-md-3">Recurring:</label>
                                <label class="col-md-9 sw_pickup_recurring"></label>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="job_detail" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">View Details</h4>
            </div>
            <div class="modal-body">
                <div class="page-content-wrap" style="margin-top:20px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row" >
                                <label class="col-md-3">Date Requested:</label>
                                <label class="col-md-9 sw_pickup_ct_dt"></label>
                                
                            </div>
                            <div class="form-group row" >
                                <label class="col-md-3">Location:</label>
                                <label class="col-md-9 sw_pickup_location"></label>
                            </div>
                            <div class="form-group row" >
                                <label class="col-md-3">Status:</label>
                                <label class="col-md-9 sw_pickup_status"></label>
                            </div>
                           
                            <div class="form-group row" >
                                <label class="col-md-3">Type:</label>
                                <label class="col-md-9 sw_pickup_type"></label>
                                
                            </div>
                            <div class="form-group row" >
                                <label class="col-md-3">Recurring:</label>
                                <label class="col-md-9 sw_pickup_recurring"></label>
                            </div>
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
                            <h4 class="modal-title">Please select pickup request.</h4>
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


    <?php
include_once FL_LOGIN_FOOTER;
?>
<script>
$( '#archive_pickup_list, #assign_pickup_list' ).DataTable({
    "order": [[ 0, "desc" ]]
});
$( '.pickup_job_list' ).DataTable({
    "order": [[ 2, "desc" ]]
});


    
</script>
