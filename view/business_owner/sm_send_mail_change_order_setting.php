<?php
ini_set( 'max_execution_time', -1 );
ini_set( 'display_errors', 1 );
//error_reporting(0);
error_reporting( E_ALL );
require_once '/home3/brigloo/production.brigloo.com/config/cron_config.php';
include_once FL_USER;
$user = new user();
include_once FL_HTML_TEMPLATE;
$template = new template();
include_once FL_PICKUP;
$pickup = new pickup(); 
include_once FL_LOCATION;
$location = new location();
//print_r($argv);
$id = isset( $argv[1] ) && $argv[1] > 0 ? $argv[1] : 0;
$ch_form = isset( $argv[2] ) && $argv[2] ? $argv[2] : 0;
$ch_to = isset( $argv[3] ) && $argv[3] ? $argv[3] : 0;
$ch_type = isset( $argv[4] ) && $argv[4] ? $argv[4] : '';
// $id =  $_GET['id'];
// $ch_form =  $_GET['form'];
// $ch_to =  $_GET['to'];
// $ch_type =  $_GET['type'];
// print_r($_GET);
$manager_ids = $location->get_location_data_by( 'in_user_id' , $id );
$arr_managerids = array();
$arr_manager_id = array();
if( isset( $manager_ids ) && $manager_ids > 0 ){
    foreach( $manager_ids as $mk => $mv ){
        array_push( $arr_managerids , $mv['in_manager_id'] );
    }
    $arr_manager_id = array_unique( $arr_managerids );
}

$bo_name = $user->get_user_data_by_key( $id, 'st_first_name' );
$bo_email_id = $user->get_user_data_by_key( $id, 'st_email_id' );                    
$st_ch_delivery_day = $user->get_bo_data_by_key( $id, 'st_ch_delivery_day' );

$f_day = date( 'l', strtotime( "  Sunday + {$ch_form} days" ) );
$t_day = date( 'l', strtotime( "  Sunday + {$ch_to} days" ) );
$d_day = date( 'l', strtotime( "  Sunday + {$st_ch_delivery_day} days") );


if( isset( $arr_manager_id ) ){
    
    foreach ( $arr_manager_id as $mk => $mv ) {
        $sm_emailid = $user->get_user_data_by_key( $mv, 'st_email_id' );
        if ( MAIL_MODE == 'test' ){
            $sm_email_id = TEST_EMAIL;
        } else{
            $sm_email_id = $sm_emailid;
        }
        if( $ch_type == "admin" ){
            $mail_data = array( 
                "f_day" => $f_day,
                "t_day" => $t_day ,
                "admin" => "Admin" ,
                "day" => $d_day, 
                "base_url" => SITE_NAME 
                );
            $email_sm_templet = $template->get_template( 'email', '', 'admin_co_change_days', TRUE );
            
            $user->send_mail_by_template( $mv, $sm_email_id, 'Change order scheduled by Admin.', $email_sm_templet, $mail_data );
            
        }else{
            $mail_data = array( 
                "f_day" => $f_day,
                "t_day" => $t_day ,
                "business_owner" => $bo_name ,
                "day" => $d_day, 
                "base_url" => SITE_NAME
                );
            $email_sm_templet = $template->get_template( 'email', '', 'bo_co_change_days', TRUE );
            
            $user->send_mail_by_template( $mv, $sm_email_id, 'Change order scheduled by Business owner.', $email_sm_templet, $mail_data );
        }
    }
}
