<?php 
session_start();
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
include_once FL_ACTIVITY;
$activity = new activity();
$user_id = isset( $_SESSION['user_id'] ) &&  $_SESSION['user_id']  != '' ? $_SESSION['user_id'] : '';  
?>
<div class="page-content">
    <?php  include_once FL_LOGIN_SUB_HEADER;?> 
    <div class="panel panel-default">
        <div class="tab-pane active">
            <div class="tabs">
                <?php
                    $driver_job = $pickup->get_driver_archive_pickups( $_SESSION['user_id'] );
                    if( isset( $driver_job ) && $driver_job != '' ){
                        $driver_archived_jobs_count = count( $driver_job ) ;
                    }else{
                        $driver_archived_jobs_count = 0;
                    }
                ?>
                <ul class="nav nav-tabs nav-justified">
                    <li><a href="#archived_job" data-toggle="tab">Archived Trips ( <?php echo $driver_archived_jobs_count; ?> )</a></li>
                    <!--<li  class="active"><a href="#interrupt_job" data-toggle="tab">Modified Trips</a></li>-->
                </ul>
                <div class="panel-body tab-content">
                    <div class="tab-pane active" id="archived_job" role="tabpanel">
                        
                        <div class="page-content-wrap">
                            <div class="page-title">                    
                                <h2>Archived Jobs</h2>
                            </div>                  
                            <div class="row">
                                <?php $driver_job = $pickup->get_driver_archive_pickups( $user_id );
                                if( isset( $driver_job ) && is_array( $driver_job ) ){
                                    foreach( $driver_job as $d_job ){
                                        ?>
                                        <div class="col-md-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">Missed Trip #<?php echo $d_job['in_job_id'];?> </h3>
                                                </div>
                                                <?php 
                                                    if( isset( $d_job['location'] ) && is_array( $d_job['location'] ) ){
                                                        $location_count = count( $d_job['location'] );
                                                        ?>
                                                            <div class="panel-body">
                                                                <h4>You have to deliver packets to <?php echo $location_count; ?> 
                                                                    location(s). To start the first location click the "Go to" button</h4>
                                                            </div>
                                                        <?php
                                                    }
                                                ?> 

                                            </div>
                                        </div>

                                        <?php
                                    }
                                }  else{
                                    ?>
                                    <div class="col-md-12 ">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    No Trip Available
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                    ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="interrupt_job" role="tabpanel">
                        
                        <div class="page-content-wrap">
                            <div class="page-title">                    
                                <h2>Modified Trips</h2>
                            </div>                  
                            <div class="row">
                                <?php 
                                    
                                    global $mydb;
                                    $all_jobdata = $pickup->get_job_data( "driver", $user_id, 'interrupt' );
                                    if( isset( $all_jobdata ) && $all_jobdata != '' ){
                                        foreach( $all_jobdata as $job_key => $job_value ){
                                            $driver_name = $user->get_user_data_by_key( $job_value['in_driver_id'],'st_first_name' );
                                            $license_no = $user->get_driver_data_by_key( $job_value['in_driver_id'],'in_license_no' );
                                            $change_order_amount = 0;
                                            $pickup_amount = 0;
                                            $change_order_count = 0;
                                            $pickup_order_count = 0;
                                            $change_order_title = '';
                                            $pickup_title = '';
                                            if( isset( $job_value['pickup'] ) ){
                                                foreach( $job_value['pickup'] as $pickup_key => $pickup_value ){
                                                    if( isset( $pickup_value['st_order_type'] ) && $pickup_value['st_order_type'] == "change_order" ){
                                                        $change_order_count++;
                                                        $change_order_amount = $change_order_amount + $pickup_value['fl_amount'];
                                                        $change_order_title = $change_order_count . " <i title='Change Order' class='fa fa-rotate-left'></i> : $" . $change_order_amount;
                                                    }else if( $pickup_value['st_order_type'] == "" ){
                                                        $pickup_order_count++;
                                                        $pickup_amount = $pickup_amount + $pickup_value['fl_sm_amount'];
                                                        $pickup_title = $pickup_order_count . " <i title='Pick Up' class='fa fa-location-arrow'></i> : $" . $pickup_amount;
                                                    }
                                                }
                                            }
                                            ?>
                                            <div id="admin-bo-list">
                                                <div class="bo-list">
                                                    <div class="bo-box">
                                                        <div class="bo-item">
                                                            <p>Trip ID:
                                                                <label>#<?php echo $job_value['in_job_id']; ?> </label>
                                                                on <?php echo date("m-d-Y", strtotime( $job_value['dt_pickup'] ) ); ?>
                                                                ( <?php echo $change_order_title;
                                                                echo  ( $change_order_title != '' && $pickup_title != '' ) ? ' and '. $pickup_title : $pickup_title; ?> ) 
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <a data-toggle="collapse" data-target="#history_<?php  echo $job_value['in_job_id']; ?>"  class=" btn btn-success report_open" data-job_id="<?php  echo $job_value['in_job_id']; ?>" href="#">History</a>
                                                </div>
                                                <div class="panel-body collapse" id="history_<?php  echo $job_value['in_job_id']; ?>">
                                                    <div class="table-responsive">
                                                        <table id="pickup_report" class="table pickup_report common-report">
                                                            <thead>
                                                                <tr>
                                                                    <th>Id</th>
                                                                    <th>Activity</th>
                                                                    <!--<th>Location</th>-->
                                                                    <th>Location Address</th>
                                                                    <th>Store Manager</th>
                                                                    <th>Start Time</th>
                                                                    <th>Arrival Time</th>
                                                                    <th>Dispatch Time</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Trip Assigned</td>
                                                                    <!--<td>-</td>-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td><?php echo date("m-d-Y H:i:s", strtotime( $job_value['dt_pickup'] ) ); ?></td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Trip Started</td>
                                                                    <!--<td>-</td>-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td><?php echo date("m-d-Y H:i:s", strtotime( $job_value['dt_start_time'] ) ); ?></td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                </tr>
                                                                <?php 
                                                                if( isset( $job_value['pickup'] ) ){

                                                                    $bank_data = $pickup->get_job_bank_data( $job_value['in_job_id'], 'change_order' );
                                                                    if( isset( $bank_data ) && $bank_data != '' || $bank_data > 0 ){
                                                                        $bank_name = isset( $bank_data['st_add'] ) && $bank_data['st_add'] != '' ? $bank_data['st_add'] : '';
                                                                        $bank_start_data = $activity->get_activity_by_data( $job_value['in_job_id'], '0', 'start' );
                                                                        if( isset( $bank_start_data ) && $bank_start_data != '' ){
                                                                            $bank_start_time = date("H:i:s", strtotime( $bank_start_data['dt_created_at'] ) );
                                                                        }else{
                                                                            $bank_start_time = '-';  
                                                                        }
                                                                        $bank_end_data = $activity->get_activity_by_data( $job_value['in_job_id'], '0', 'end' );
                                                                        if( isset( $bank_end_data ) && $bank_end_data != '' ){
                                                                            $bank_end_time = date("H:i:s", strtotime( $bank_end_data['dt_created_at'] ) );
                                                                        }else{
                                                                            $bank_end_time = '-';  
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                            <td>0</td>
                                                                            <td>Arrived Bank</td>
                                                                            <!--<td>Bank</td>-->
                                                                            <td><?php echo $bank_name ?></td>
                                                                            <td>-</td>
                                                                            <td><?php echo $bank_start_time; ?></td>
                                                                            <td><?php echo $bank_end_time; ?></td>
                                                                            <td>-</td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    $i = 0;
                                                                    foreach( $job_value['pickup'] as $pickup_key => $pickup_value ){ 
                                                                        if( isset( $pickup_value ) && $pickup_value['st_order_type'] == 'bank' ){
                                                                        $bank_start_data = $activity->get_activity_by_data( $job_value['in_job_id'], $pickup_key + 1, 'start' );
                                                                        if( isset( $bank_start_data ) && $bank_start_data != '' ){
                                                                            $bank_start_time = date( "H:i:s", strtotime( $bank_start_data['dt_created_at'] ) );
                                                                        }else{
                                                                            $bank_start_time = '-';  
                                                                        }
                                                                        $bank_end_data = $activity->get_activity_by_data( $job_value['in_job_id'], $pickup_key + 1, 'end' );
                                                                        if( isset( $bank_end_data ) && $bank_end_data != '' ){
                                                                            $bank_end_time = date( "H:i:s", strtotime( $bank_end_data['dt_created_at'] ) );
                                                                        }else{
                                                                            $bank_end_time = '-';  
                                                                        }

                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $i; ?></td>
                                                                            <td>Arrived Bank</td>
                                                                            <!--<td>Bank</td>-->
                                                                            <td><?php echo $bank_name ?></td>
                                                                            <td>-</td>
                                                                            <td><?php echo $bank_start_time; ?></td>
                                                                            <td><?php echo $bank_end_time; ?></td>
                                                                            <td>-</td>
                                                                        </tr>

                                                                        <?php
                                                                    }else{
                                                                        if( $pickup_value['st_status'] != "interrupt" ){
                                                                        $location_data = $location->get_location( $pickup_value['in_location_id'] );
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $pickup_value['in_pickup_sort']; ?></td>
                                                                            <td><?php echo isset( $pickup_value['st_order_type'] ) &&  $pickup_value['st_order_type'] == "change_order" ?  "Change Order"  : "Pick Up" ; ?></td>
                                                                            <!--<td><?php echo $location_data['st_location_name']; ?></td>-->
                                                                            <td class="cut_location_address" title="<?php echo $location_data['st_address']; ?>"><?php echo $location_data['st_address']; ?></td>
                                                                            <td><?php echo $pickup_value['st_sm_name']; ?></td>
                                                                            <td><?php echo date( "H:i:s", strtotime( $pickup_value['dt_start_time'] ) ); ?></td>
                                                                            <td><?php echo date( "H:i:s", strtotime( $pickup_value['dt_arrival_time'] ) ); ?></td>
                                                                            <td><?php echo date( "H:i:s", strtotime( $pickup_value['dt_end_time'] ) ); ?></td>
                                                                        </tr>

                                                                    <?php
                                                                        }else{
                                                                            ?>
                                                                        <tr>
                                                                            <td><?php echo $pickup_value['in_pickup_sort']; ?></td>
                                                                            <td>Interrupt : <?php echo $job_value['st_stop_reason'] ; ?></td>
                                                                            <!--<td></td>-->
                                                                            <td class="cut_location_address" ></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    <?php
                                                                        } 
                                                                    }
                                                                    $i++; 
                                                                }
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>                                    
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        } 
                                    } else{
                                    ?>
                                    <div class="col-md-12 ">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    No Trip Available
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                            </div>
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

<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyAI2Jc0LEvGW1LwaXD49hPL9bTk0uIKwR8"></script>
<script type="text/javascript" src="<?php echo JS_PLUGINS_PATH; ?>location-picker/locationpicker.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>location.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>pickup.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PATH; ?>admin_custom.js"></script>  
<?php
include_once FL_LOGIN_FOOTER;
?>