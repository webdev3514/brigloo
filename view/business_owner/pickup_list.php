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
                    <h3 class="panel-title">Pick Up List</h3>
                </div>
                <div class="panel-body table-responsive">
                    <table id="pickup_list" class="table datatable">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Pick Up Id</th>
                                <th>Date Requested</th>
                                <th>Pick Up Date</th>
                                <!--<th>Location</th>-->
                                <th>Address</th>
                                <th>Amount</th>
                                <th>Recurring</th>
                                <th>Requested By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $all_userdata = $pickup->get_pickups( $user_id );
                            if( isset( $all_userdata ) && $all_userdata != '' ){
                                foreach( $all_userdata as $key => $value ){
//                                    $location_name = $location->get_location_by_key( $value['in_location_id'], 'st_location_name' );
                                    $location_address = $location->get_location_by_key( $value['in_location_id'], 'st_address' );
                                    $user_name = $user->get_user_data_by_key( $value['in_user_id'], 'st_first_name' );
                                ?>
                                <tr class="pickup_<?php echo $value['in_pickup_id']; ?>" >
                                    <td><?php 
                                        if( isset( $value['st_order_type'] ) && $value['st_order_type'] == "change_order" ){ 
                                            echo "<i title='Change Order' class='fa fa-rotate-left'></i>";
                                        }else{
                                            echo "<i title='Pick Up' class='fa fa-location-arrow'></i>";
                                        }
                                        ?>
                                    </td>
                                    <td><span></span><?php echo $value['in_pickup_id']; ?></td>
                                    <td><?php echo date("m-d-Y H:i:s", strtotime( $value['dt_created_at'] ) );?></td>
                                    <td class="pickup_date_check" data-date="<?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?>"><?php echo date("m-d-Y", strtotime( $value['dt_pickup'] ) ); ?></td>
                                    <!--<td><?php // echo $location_name; ?></td>-->
                                    <td class="cut_location_address" title="<?php echo $location_address; ?>"><?php echo $location_address; ?></td>
                                    <td class="pickup_amount"><?php echo '$' . ( isset( $value['fl_amount'] ) && $value['fl_amount'] == '' || $value['fl_amount'] > 0 ? $value['fl_amount'] : "0" ); ?></td>
                                    <td><?php 
                                        if( isset( $value['st_pickup_type'] ) && $value['st_pickup_type'] == "recurring" ){ 
                                            ?><img title='Recurring' src="<?php echo IMAGES_URL . 'location.png'; ?>"/><?php
                                        }else{
                                            echo "";
                                        }
                                        ?>
                                    </td>
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
<script>

$( '#pickup_list' ).DataTable( {
    "order": [[ 1, "desc" ]]
});
</script>
