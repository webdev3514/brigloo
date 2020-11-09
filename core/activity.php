<?php

$activity = new activity();

class activity {
    function __construct(){
    }
    
    function get_activity( $act_id = 0, $order_by = 'in_activity_id DESC' ){
        if( isset( $act_id ) && trim( $act_id ) != '' && $act_id > 0 ){
            global $mydb;
            $sl_where = array(
                'in_activity_id' => $act_id
            );      
            $response = $mydb->get_all( TBL_ACTIVITY, '*', $sl_where, $order_by );
            if( $response != 0 && count( $response ) > 0 ) {
                return $response;
            }
        }
    }
    
    function get_activity_by_data( $job_id = 0, $location_id = 0, $status = '' ) {
        if( isset( $job_id ) && $job_id > 0 ){
            global $mydb;
            $arr_where = array(
                'in_job_id' => $job_id,
                'in_location_id' => $location_id,
                'st_status' => $status
            );
            $activity_data = $mydb->get_all( TBL_ACTIVITY, '*', $arr_where );
            if( isset( $activity_data ) && $activity_data != '' ){
                return $activity_data;
            } else {
                return 0;
            }
        }
    }
    
    function get_activity_by_conv( $conv_id = 0, $order_by = 'in_activity_id DESC' ){
        if( isset( $conv_id ) && trim( $conv_id ) != '' && $conv_id > 0 ){
            global $mydb;
            $sl_where = array(
                'in_conversation_id' => $conv_id
            );      
            $response = $mydb->get_all( TBL_ACTIVITY, '*', $sl_where, $order_by );
            if( $response != 0 && count( $response ) > 0 ) {
                if( isset( $response['in_activity_id'] ) ){
                    $response = array( $response );
                }
                return $response;
            }
        }
    }
    
    function add_activity( $job_id = 0, $location_id = 0, $status = '' ) {
        if( isset( $job_id ) && $job_id > 0 ){
            global $mydb;
            $start_time = date( "Y-m-d H:i:s" );
            $arr_insert = array(
                'in_job_id' => $job_id,
                'in_location_id' => $location_id,
                'st_status' => $status,
                'dt_created_at' => $start_time
            );
            $insert_id = $mydb->insert( TBL_ACTIVITY, $arr_insert );
            if( $insert_id > 0 ){
                return $insert_id;
            } else {
                return 0;
            }
        }
    }
    
}