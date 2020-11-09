<?php 
if ( !session_id() ) {
    session_start();
}
require_once '../../config/config.php';
require_once '../../backend/config/admin_config.php';
if( !isset( $_SESSION['user_id'] ) && !isset( $_SESSION['user_type'] ) ){
    header( "location:" . BASE_URL );
} else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] != "driver"  ){	
    header( "location:" . BASE_URL );
}
include_once FL_LOGIN_HEADER;
include_once FL_LOGIN_SIDEBAR;

include_once FL_USER;
$user = new user();
include_once FL_PICKUP;
$pickup = new pickup();  

$user_id = isset( $_SESSION['user_id'] ) &&  $_SESSION['user_id']  != '' ? $_SESSION['user_id'] : '';  
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
                    <!-- START DATATABLE EXPORT -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Driver Pick UP Amount</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="driver_pay_list" class="table datatable">
                                <thead>
                                    <tr>
                                        <th class="id_column">Trip ID</th>
                                        <th>Location</th>
                                        <th>Amount</th>
                                        <th>Pick UP Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    global $mydb;
                                    $all_driver_pickup= $pickup->get_driver_pickup_amt_list( $user_id );
                                    if( isset( $all_driver_pickup ) && ( $all_driver_pickup != '' || $all_driver_pickup != 0 ) ){
                                        if( isset( $all_driver_pickup['in_job_id'] ) ){
                                            $all_driver_pickup = array( $all_driver_pickup );
                                        }
                                        foreach( $all_driver_pickup as $key => $value ){
                                            
                                            $driver_name = $user->get_user_data_by_key( $value['in_driver_id'], 'st_first_name' ); 
                                            $in_license_no= $user->get_driver_data_by_key( $value['in_driver_id'], 'in_license_no' ); 
                                        ?>
                                        <tr class="job_<?php echo $value['in_job_id']; ?>">
                                            <td class="id_column"><?php echo $value['in_job_id'];?></td>
                                            <td><?php echo $value['location_count'];?></td>
                                            <td class="pickup_amount"><?php echo isset( $value['fl_driver_pickup_amt'] ) && $value['fl_driver_pickup_amt'] > 0 ?  " $" . $value['fl_driver_pickup_amt'] : 0; ?></td>
                                            <td><?php echo date( "m-d-Y", strtotime( $value['dt_pickup'] ) );?></td>
                                            <td><?php 
                                                if( $value['st_pay_status'] == "pending" ){ ?>
                                                    <label class="">Pending</label>
                                                <?php } else { ?>
                                                    <label class="paid_amt btn btn-danger">Paid</label>
                                                <?php } ?>
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

<?php
require_once FL_LOGIN_FOOTER_INCLUDE;
?>
<script type='text/javascript' src="<?php echo ADMIN_JS_PLUGINS_PATH .'icheck/icheck.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'mcustomscrollbar/jquery.mCustomScrollbar.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'datatables/jquery.dataTables.min.js'; ?>"></script>  
<?php
include_once FL_LOGIN_FOOTER;
?>
<script>
$( "#driver_pay_list" ).DataTable({
    "order": [[ 0, "desc" ]]
});
</script>