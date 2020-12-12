<?php 
require_once '../../config/config.php';
require_once '../config/admin_config.php';
if( !isset( $_SESSION['user_id'] ) && !isset( $_SESSION['user_type'] ) ){
    header( "location:" . BASE_URL );
} else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] != "admin"  ){	
    header( "location:" . BASE_URL );
}
include_once FL_LOGIN_HEADER;
include_once FL_LOGIN_SIDEBAR;

include_once FL_USER;
$user = new user();
include_once FL_LOCATION;
$location = new location();
include_once FL_PICKUP;
$pickup = new pickup();
include_once FL_ACTIVITY;
$activity = new activity(); 

?>
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo ADMIN_CSS_PATH; ?>buttons.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo ADMIN_CSS_PATH; ?>jquery.dataTables.min.css"/>

<!-- PAGE CONTENT -->
<div class="page-content">

    <!-- START X-NAVIGATION VERTICAL -->
    <?php  include_once FL_LOGIN_SUB_HEADER;?> 
    <!-- END X-NAVIGATION VERTICAL -->    


    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <!-- START WIDGETS -->                    
        <div class="row">
            <div class="col-md-12">
                    <!-- START DATATABLE EXPORT -->
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Trip Reports</h3>
                        </div>
                        <?php
                        global $mydb;
                        $all_jobdata = $pickup->get_job_data( 'admin' , '' , 'completed' );
                        if( isset( $all_jobdata ) && $all_jobdata != '' ){
                            //print_r($all_jobdata);exit;
                            foreach( $all_jobdata as $job_key => $job_value ){
                                $location_lat_long = $job_value['st_route'];
                                if( isset( $job_value['in_bo_id'] ) && is_array( $job_value['in_bo_id'] ) ){
                                    $i = 0;
                                    $bo_name = '';
                                    $job_bo_id = array_unique( $job_value['in_bo_id'] );
                                    $bo_count = count( $job_bo_id );
                                    foreach( $job_bo_id as $bk => $bv ){
                                        $i++;  
                                        $business_name = $user->get_user_data_by_key( $bv,'st_first_name' );
                                        if( $bo_count ==  $i ){
                                            $bo_name .= $business_name . ' ';
                                        }else{
                                            $bo_name .= $business_name . ', ';
                                        }
                                    }
                                }
                               
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
                                            $pickup_title = $pickup_order_count . " <i title='Pick UP' class='fa fa-location-arrow'></i> : $" . $pickup_amount;
                                        }
                                    }
                                }
                                ?>
                                <div class="admin-main-report-list">
                                <div class="bo-list">
                                    <div class="bo-box">
                                        <div class="bo-item">
                                            <p>BO Name:
                                                <label><?php echo $bo_name; ?></label>
                                            </p>
                                        </div>
                                        <div class="bo-item">
                                            <p>Trip ID:
                                                <label>#<?php echo $job_value['in_job_id']; ?></label>
                                                on <?php echo date( "m-d-Y", strtotime( $job_value['dt_pickup'] ) ); ?>
                                                    ( <?php echo $change_order_title;
                                                    echo  ( $change_order_title != '' && $pickup_title != '' ) ? ' and '. $pickup_title : $pickup_title; ?> )
                                            </p>
                                        </div>
                                    </div>
                                    <a data-toggle="collapse" data-target="#history_<?php  echo $job_value['in_job_id']; ?>"  class=" btn btn-success report_open" data-job_id="<?php  echo $job_value['in_job_id']; ?>" href="#">View</a>
                                </div>
                                <div class="panel-body collapse" id="history_<?php  echo $job_value['in_job_id']; ?>">
                                    <div class="report_map" id="map_<?php echo $job_value['in_job_id']; ?>" data-job_id="<?php echo $job_value['in_job_id']; ?>"></div>
                                    <div class="table-responsive">
                                        <table id="pickup_report_<?php echo $job_value['in_job_id']; ?>" class="table pickup_report common-report">
                                            <thead>
                                                <tr>
                                                    <th>Number</th>
                                                    <th>Activity</th>
                                                    <th>Driver Name</th>
                                                    <th>Driver License No</th>
                                                    <!--<th>Location</th>-->
                                                    <th>Location Address</th>
                                                    <th>Store Manager</th>
                                                    <th>Store Manager License</th>
                                                    <th>Store Id</th>
                                                    <th>Amount</th>
                                                    <th>Amount from Store Manager</th>
                                                    <th>Start Time</th>
                                                    <th>Arrival Time</th>
                                                    <th>Packet Receive Time</th>
                                                    <th>Packet Deliver Time</th>
                                                    <th>Dispatch Time</th>
                                                    <th>Pause reason</th>
                                                    <th>Pause Time</th>
                                                    <th>Resume Time</th>
                                                    <th>Notes of Store Manager</th>
                                                    <th>Notes of Driver</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td>Trip Assigned</td>
                                                    <td><?php echo $driver_name; ?></td>
                                                    <td><?php echo $license_no; ?></td>
                                                    <!--<td>-</td>-->
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td><?php echo date("m-d-Y H:i:s", strtotime( $job_value['dt_pickup'] ) ); ?></td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Trip Started</td>
                                                    <td><?php echo $driver_name; ?></td>
                                                    <td><?php echo $license_no; ?></td>
                                                    <!--<td>-</td>-->
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td><?php echo date("m-d-Y H:i:s", strtotime( $job_value['dt_start_time'] ) ); ?></td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                                
                                                <?php 
                                                $arr_location = array();
                                                if( isset( $job_value['pickup'] ) ){
                                                    $bank_data = $pickup->get_job_address_data( $job_value['in_job_id'], 'change_order' );
                                                    if( isset( $bank_data ) && $bank_data != '' || $bank_data > 0 ){
                                                        
                                                        $bank_name = isset( $bank_data['st_add'] ) && $bank_data['st_add'] != '' ? $bank_data['st_add'] : '';
                                                        $bank_start_data = $activity->get_activity_by_data( $job_value['in_job_id'], '0', 'start' );
                                                        if( isset( $bank_start_data ) && $bank_start_data != '' ){
                                                            $bank_start_time = date( "H:i:s", strtotime( $bank_start_data['dt_created_at'] ) );
                                                        }else{
                                                            $bank_start_time = '-';  
                                                        }
                                                        $bank_end_data = $activity->get_activity_by_data( $job_value['in_job_id'], '0', 'end' );
                                                        if( isset( $bank_end_data ) && $bank_end_data != '' ){
                                                            $bank_end_time = date( "H:i:s", strtotime( $bank_end_data['dt_created_at'] ) );
                                                        }else{
                                                            $bank_end_time = '-';  
                                                        }
                                                        
                                                        ?>
                                                        <tr>
                                                            <td>0</td>
                                                            <td>Arrived <?php echo $bank_data['st_type'] ; ?></td>
                                                            <td><?php echo $driver_name; ?></td>
                                                            <td><?php echo $license_no; ?></td>
                                                            <!--<td>Bank</td>-->
                                                            <td class="cut_location_address" title="<?php echo $bank_name; ?>"><?php echo $bank_name ?></td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td><?php echo $bank_start_time; ?></td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td><?php echo $bank_end_time; ?></td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                        </tr>
                                                        
                                                        <?php
                                                    }
                                                    $i = 1;
                                                    foreach( $job_value['pickup'] as $pickup_key => $pickup_value ){ 
                                                        if( isset( $pickup_value ) && $pickup_value['st_order_type'] == 'bank' ){
                                                            $bank_data = $pickup->get_job_address_data( $job_value['in_job_id'] );
                                                            $bank_name = isset( $bank_data['st_add'] ) && $bank_data['st_add'] != '' ? $bank_data['st_add'] : '';
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
                                                                <td><?php echo $driver_name; ?></td>
                                                                <td><?php echo $license_no; ?></td>
                                                                <!--<td>Bank</td>-->
                                                                <td class="cut_location_address" title="<?php echo $bank_name; ?>"><?php echo $bank_name ?></td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td><?php echo $bank_start_time; ?></td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td><?php echo $bank_end_time; ?></td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                            </tr>

                                                            <?php
                                                        }else{
                                                        $location_data = $location->get_location( $pickup_value['in_location_id'] );
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $pickup_value['in_pickup_sort']; ?></td>
                                                            <td><?php echo isset( $pickup_value['st_order_type'] ) &&  $pickup_value['st_order_type'] == "change_order" ?  "Change Order"  : "Pick UP" ; ?></td>
                                                            <td><?php echo $driver_name; ?></td>
                                                            <td><?php echo $license_no; ?></td>
                                                            <!--<td><?php // echo $location_data['st_location_name']; ?></td>-->
                                                            <td class="cut_location_address" title="<?php echo $location_data['st_address']; ?>"><?php echo $location_data['st_address']; ?></td>
                                                            <td><?php echo $pickup_value['st_sm_name']; ?></td>
                                                            <td><?php echo $pickup_value['st_sm_license']; ?></td>
                                                            <td><?php echo $location_data['st_store_id']; ?></td>
                                                            <td  class="pickup_amount"><?php echo '$' . ( isset( $pickup_value['fl_amount'] ) && $pickup_value['fl_amount'] == '' || $pickup_value['fl_amount'] > 0 ? $pickup_value['fl_amount'] : "0" ); ?></td>
                                                            <td class="pickup_amount">
                                                                <?php
                                                                if( $pickup_value['st_order_type'] == "change_order" ){
                                                                    $change_order_data = $pickup->get_change_order_by_id( $pickup_value['in_pickup_id'] );
                                                                    $change_order_info = '<div class="">';
                                                                    if( isset( $change_order_data['fl_dollar_50'] ) && $change_order_data['fl_dollar_50'] > 0 ){
                                                                        $change_order_info .= "<div class='col-md-12'>$50 * " . $change_order_data['fl_dollar_50'] ." = $"  . 50 * $change_order_data['fl_dollar_50'] . "</div>";
                                                                    }
                                                                    if( isset( $change_order_data['fl_dollar_20'] ) && $change_order_data['fl_dollar_20'] > 0 ){
                                                                        $change_order_info .= "<div class='col-md-12'>$20 * " . $change_order_data['fl_dollar_20'] ." = $"  . 20 * $change_order_data['fl_dollar_20'] . "</div>";
                                                                    }
                                                                    if( isset( $change_order_data['fl_dollar_10'] ) && $change_order_data['fl_dollar_10'] > 0 ){
                                                                        $change_order_info .= "<div class='col-md-12'>$10 * " . $change_order_data['fl_dollar_10'] ." = $" . 10 * $change_order_data['fl_dollar_10'] . "</div>";
                                                                    }
                                                                    if( isset( $change_order_data['fl_dollar_5'] ) && $change_order_data['fl_dollar_5'] > 0 ){
                                                                        $change_order_info .= "<div class='col-md-12'>$5 * " . $change_order_data['fl_dollar_5'] ." = $"  . 5 * $change_order_data['fl_dollar_5'] . "</div>";
                                                                    }
                                                                    if( isset( $change_order_data['fl_dollar_1'] ) && $change_order_data['fl_dollar_1'] > 0 ){
                                                                        $change_order_info .= "<div class='col-md-12'>$1 *  " . $change_order_data['fl_dollar_1'] ." = $"  . 1 * $change_order_data['fl_dollar_1'] . "</div>";
                                                                    }
                                                                    if( isset( $change_order_data['ft_cent_1'] ) && $change_order_data['ft_cent_1'] > 0 ){
                                                                        $change_order_info .= "<div class='col-md-12'>1¢ * " . $change_order_data['ft_cent_1'] ." = "  . $change_order_data['ft_cent_1'] / 100 . "¢ </div>";
                                                                    }
                                                                    if( isset( $change_order_data['ft_cent_5'] ) && $change_order_data['ft_cent_5'] > 0 ){
                                                                        $change_order_info .= "<div class='col-md-12'>5¢ * " . $change_order_data['ft_cent_5'] ." = "  . $change_order_data['ft_cent_5'] / 100 . "¢ </div>";
                                                                    }
                                                                    if( isset( $change_order_data['ft_cent_10'] ) && $change_order_data['ft_cent_10'] > 0 ){
                                                                        $change_order_info .= "<div class='col-md-12'>10¢ * " . $change_order_data['ft_cent_10'] ." = "  . $change_order_data['ft_cent_10'] / 100 . "¢ </div>";
                                                                    }
                                                                    if( isset( $change_order_data['ft_cent_25'] ) && $change_order_data['ft_cent_25'] > 0 ){
                                                                        $change_order_info .= "<div class='col-md-12'>25¢ * " . $change_order_data['ft_cent_25'] ." = "  . $change_order_data['ft_cent_25'] / 100 . "¢ </div>";
                                                                    }
                                                                    
                                                                    $change_order_info .= "</div>";
                                                                    echo '$' . ( isset( $pickup_value['fl_amount'] ) && $pickup_value['fl_amount'] == '' || $pickup_value['fl_amount'] > 0 ? $pickup_value['fl_amount'] : "0" );
                                                                    echo $change_order_info;
                                                                    
                                                                }else{
                                                                    echo '$' . ( isset( $pickup_value['fl_sm_amount'] ) && $pickup_value['fl_sm_amount'] == '' || $pickup_value['fl_sm_amount'] > 0 ? $pickup_value['fl_sm_amount'] : "0" ); 
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo date("H:i:s", strtotime( $pickup_value['dt_start_time'] ) ); ?></td>
                                                            <td><?php echo date("H:i:s", strtotime( $pickup_value['dt_arrival_time'] ) ); ?></td>
                                                            <?php
                                                            if( $pickup_value['st_order_type'] == "change_order" ){
                                                                ?>
                                                                <td>-</td>
                                                                <td><?php echo date("H:i:s", strtotime( $pickup_value['dt_end_time'] ) ); ?></td>
                                                                <?php
                                                            }else{
                                                            ?>
                                                                <td><?php echo date("H:i:s", strtotime( $pickup_value['dt_end_time'] ) ); ?></td>
                                                                <td>-</td>
                                                                <?php
                                                            }
                                                            ?>
                                                            
                                                            <td><?php echo date("H:i:s", strtotime( $pickup_value['dt_end_time'] ) ); ?></td>
                                                            <td><?php 
                                                                    if( $pickup_value['st_em_resume_reason'] && $pickup_value['st_em_resume_reason'] != "" ){
                                                                        $arr_pause_reason = json_decode( $pickup_value['st_em_resume_reason']  );
                                                                        ?>
                                                                        <ul>
                                                                        <?php
                                                                        if( isset( $arr_pause_reason ) && is_array( $arr_pause_reason ) ){
                                                                        foreach( $arr_pause_reason as $prk => $prv ){
                                                                            ?>
                                                                            <li><?php echo $prv ; ?></li>
                                                                            <?php
                                                                        }
                                                                        }
                                                                        ?>
                                                                        </ul>
                                                                        <?php
                                                                    }else{
                                                                        echo ' - '; 
                                                                    }
                                                                        
                                                                    ?>
                                                                </td>
                                                                <td><?php 
                                                                    if( $pickup_value['dt_em_pause'] && $pickup_value['dt_em_pause'] != "" ){
                                                                        $arr_pause_reason = json_decode( $pickup_value['dt_em_pause']  );
                                                                        ?>
                                                                        <ul>
                                                                        <?php
                                                                         if( isset( $arr_pause_reason ) && is_array( $arr_pause_reason ) ){
                                                                        foreach( $arr_pause_reason as $prk => $prv ){
                                                                            ?>
                                                                            <li><?php echo date( "H:i:s", strtotime( $prv ) ); ?></li>
                                                                            <?php
                                                                        }
                                                                         }
                                                                        ?>
                                                                        </ul>
                                                                        <?php
                                                                    }else{
                                                                        echo ' - '; 
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                    if( $pickup_value['dt_em_resume'] && $pickup_value['dt_em_resume'] != "" ){
                                                                        $arr_pause_reason = json_decode( $pickup_value['dt_em_resume']  );
                                                                        ?>
                                                                        <ul>
                                                                        <?php
                                                                         if( isset( $arr_pause_reason ) && is_array( $arr_pause_reason ) ){
                                                                        foreach( $arr_pause_reason as $prk => $prv ){
                                                                            ?>
                                                                            <li><?php echo date( "H:i:s", strtotime( $prv ) ); ?></li>
                                                                            <?php
                                                                        }
                                                                         }
                                                                        ?>
                                                                        </ul>
                                                                        <?php
                                                                    }else{
                                                                        echo ' - '; 
                                                                    }
                                                                    ?>
                                                                </td>
                                                            <td><?php echo $pickup_value['st_sm_note']; ?></td>
                                                            <td><?php echo $pickup_value['st_driver_note']; ?></td>
                                                        </tr>
                                                    <?php  
                                                        }
                                                        $i++;
                                                    }
                                                    $check_pickup_exists = $pickup->check_pickup_exists_job( $job_value['in_job_id'] );
                                                    if( isset( $check_pickup_exists ) && $check_pickup_exists != "" ){
                                                        $bank_data = $pickup->get_job_address_data( $job_value['in_job_id'] );
                                                        $st_type = isset( $bank_data['st_type'] ) && $bank_data['st_type'] != '' ? $bank_data['st_type'] : '';
                                                        $bank_name = isset( $bank_data['st_add'] ) && $bank_data['st_add'] != '' ? $bank_data['st_add'] : '';
                                                        if( isset( $bank_data ) && $bank_data != '' ){
                                                            $bank_name = isset( $bank_data['st_add'] ) && $bank_data['st_add'] != '' ? $bank_data['st_add'] : '';
                                                            $bank_start_data = $activity->get_activity_by_data( $job_value['in_job_id'], '-1', 'start' );
                                                            if( isset( $bank_start_data ) && $bank_start_data != '' ){
                                                                $bank_start_time = date( "H:i:s", strtotime( $bank_start_data['dt_created_at'] ) );
                                                            }else{
                                                                $bank_start_time = '-';  
                                                            }
                                                            $bank_end_data = $activity->get_activity_by_data( $job_value['in_job_id'], '-1', 'end' );
                                                            if( isset( $bank_end_data ) && $bank_end_data != '' ){
                                                                $bank_end_time = date( "H:i:s", strtotime( $bank_end_data['dt_created_at'] ) );
                                                            }else{
                                                                $bank_end_time = '-';  
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i++; ?></td>
                                                                <td>   
                                                                                <?php if( $st_type == 'other' ){
                                                    ?>
                                                        Arrived to <?php echo $st_type . " Address"; 
                                                    }else{
                                                        ?>
                                                         Arrived to <?php echo $st_type; 
                                                    }
                                                    ?></td>
                                                                <td><?php echo $driver_name; ?></td>
                                                                <td><?php echo $license_no; ?></td>
                                                                <!--<td>-->   
                                                                                <?php //if( $st_type == 'Other' ){
                                                    ?>
                                                        <?php //echo $st_type . "  Address"; 
                                                    //}else{
                                                        ?>
                                                        <?php //echo $st_type; 
                                                    //}
                                                    ?>
                                                                <!--</td>-->
                                                                <td class="cut_location_address" title="<?php echo $bank_name; ?>"><?php echo $bank_name ?></td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td><?php echo $bank_start_time; ?></td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td><?php echo $bank_end_time; ?></td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                            </tr>
                                                            
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i++ ?></td>
                                                        <td>Trip Ended</td>
                                                        <td><?php echo $driver_name; ?></td>
                                                        <td><?php echo $license_no; ?></td>
                                                        <!--<td>-</td>-->
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td><?php echo date("m-d-Y H:i:s", strtotime( $job_value['dt_end_time'] ) ); ?></td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                    </tr>
                                                    <?php
                                                }?>
                                               
                                            </tbody>
                                        </table>                                    
                                    </div>
                                </div>
                                </div>
                               <?php
                           } 
                        }
                        ?>
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
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'datatables/buttons.html5.min.js'; ?>"></script>  
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'datatables/buttons.print.min.js'; ?>"></script>  
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'datatables/dataTables.buttons.min.js'; ?>"></script>  
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'datatables/jszip.min.js'; ?>"></script>  
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'datatables/pdfmake.min.js'; ?>"></script>  
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'datatables/vfs_fonts.js'; ?>"></script>  
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PATH; ?>admin_custom.js"></script>   
<?php
include_once FL_LOGIN_FOOTER;
?>

<script>
      //FOR ADD MA
    $( '.pickup_report' ).DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel',{
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            }
        ]
    });
    
</script>