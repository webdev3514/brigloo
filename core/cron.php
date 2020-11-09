<?php
$cron = new cron();

class cron {
    public $flag_err = FALSE;
    public $arr_services = array();
    
    function __construct(){
        
    }
        
    function add_cron_data( $cron_data = '' ) {
        if( isset( $cron_data ) && trim( $cron_data ) != '' ){
            global $mydb;
            $arr_data = array(
                'dt_last_executed' => $update_time
            );
            $where = array(                
                'st_cron_name' => $cron_name,
            );
            
            $update_id = $mydb->update( TBL_CRON, $arr_data, $where );            
            if( $update_id != 0 && $update_id > 0 ){
                return( $update_id );
            } else {
                return 0;
            }
        }
    }
    
    /* Function will add pickup which has recurring */
    public function add_recurring_pickup() {
        global $mydb;
        if ( !session_id() ) {
            session_start();
        }
        include_once FL_PICKUP;
        $pickup = new pickup();
        include_once FL_USER;
        $user = new user();
        include_once FL_LOCATION;
        $location = new location();
        include_once FL_HTML_TEMPLATE;
        $template = new template();
        $i = 0;
        $recurring_id = array();
        $pickup_id = array();
        if( isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] ){
            $user_id = $_SESSION['user_id'];
        }else if( isset( $_SESSION['admin_id'] ) && $_SESSION['admin_id'] ){
            $user_id = $_SESSION['admin_id'];
        }else{
            $user_id = 0;
        }
        $recurring_data = $pickup->get_all_recurring( );
        if( isset( $recurring_data ) && $recurring_data != 0 ){
            if( isset( $recurring_data['in_recurring_id'] ) ){
                $recurring_data = array( $recurring_data );
            }
            foreach( $recurring_data as $rdk => $rdv ){
                if( $rdv['st_recurring_type'] == "weekly" ){
                    $t_day = date( 'l', strtotime(" Sunday + {$rdv['st_recurring_date']} days") );
                    $pickup_date = date( 'Y-m-d', strtotime( 'next ' . $t_day ) );
                    $where = array(
                        'in_parent_id' => $rdv['in_recurring_id'],
                        'dt_pickup' => $pickup_date
                    );
                    $pickup_exist = $mydb->get_all( TBL_PICKUP, '*', $where );
                    if( isset( $pickup_exist ) && $pickup_exist != '' && isset( $pickup_exist['in_pickup_id'] ) ){
                    }else{
//                        if( date( "N" ) == $rdv['st_recurring_date'] ){

                            $sm_id = $user->get_bo_data_by_key( $rdv['in_user_id'], 'in_store_manager_id' );
                            $arr_data = array(
                                'in_user_id' =>  $rdv['in_user_id'],
                                'in_location_id' => $rdv['in_location_id'],
                                'in_manager_id' => $sm_id,
                                'dt_pickup' => $pickup_date,
                                'st_pickup_type' => 'recurring',
                                'in_parent_id' => $rdv['in_recurring_id'],
                                'fl_amount' => $rdv['fl_amount'],
                            );
                            $insert_id = $mydb->insert( TBL_PICKUP, $arr_data );
                            $i++;
                            if( isset( $insert_id ) && $insert_id > 0 ){
                                array_push( $recurring_id , $rdv['in_recurring_id'] );
                                array_push( $pickup_id , $insert_id );
                            }
                            $loc_name = $location->get_location_by_key( $rdv['in_location_id'], 'st_address' );
                            $bo_name = $user->get_user_data_by_key( $rdv['in_user_id'], 'st_first_name' );
                            $bo_email = $user->get_user_data_by_key( $rdv['in_user_id'], 'st_email_id' );
                            $mail_data = array( "bo_name" => $bo_name,
                                "location" => $loc_name,
                                "base_url" => SITE_NAME 
                                );
                            $email_sm_templet = $template->get_template( 'email', '', 'recurring_cron_mail', TRUE );
                            if ( MAIL_MODE == 'test' ){
                                $bo_email_id = TEST_EMAIL;
                            } else{
                                $bo_email_id = $bo_email;
                            }
                            $user->send_mail_by_template( $rdv['in_user_id'], $bo_email_id, 'Pickup Recurring Request', $email_sm_templet, $mail_data );
//                        }
                    }
                    
                }else{
                    $last_date = date( 'd',strtotime( 'last day of this month' ) );
                    $pickup_date = date( 'Y-m-d' );
                    $recu_date = date( 'd',strtotime(  $rdv['st_recurring_date'] ) );
                    
                    if( $pickup_date >= $rdv['st_recurring_date'] ){
                        if( $recu_date == 31 ){
                            $recurring_date = $last_date;
                        }else{
                            $recurring_date = $recu_date;
                        }
                        $where = array(
                            'in_parent_id' => $rdv['in_recurring_id'],
                            'dt_pickup' => $pickup_date
                        );
                        $pickup_exist = $mydb->get_all( TBL_PICKUP, '*', $where );
                        if( isset( $pickup_exist ) && $pickup_exist != '' && isset( $pickup_exist['in_pickup_id'] ) ){
                        }else{
//                            if( date( "d" ) == $recurring_date ){

                            
                                $sm_id = $user->get_bo_data_by_key( $rdv['in_user_id'], 'in_store_manager_id' );
                                $arr_data = array(
                                    'in_user_id' =>  $rdv['in_user_id'],
                                    'in_location_id' => $rdv['in_location_id'],
                                    'in_manager_id' => $sm_id,
                                    'dt_pickup' => $pickup_date,
                                    'st_pickup_type' => 'recurring',
                                    'in_parent_id' => $rdv['in_recurring_id'],
                                    'fl_amount' => $rdv['fl_amount'],
                                );
                                $insert_id = $mydb->insert( TBL_PICKUP, $arr_data );
                                $i++;
                                if( isset( $insert_id ) && $insert_id > 0 ){
                                    array_push( $recurring_id , $rdv['in_recurring_id'] );
                                    array_push( $pickup_id , $insert_id );
                                }
                                $loc_name = $location->get_location_by_key( $rdv['in_location_id'], 'st_address' );
                                $bo_name = $user->get_user_data_by_key( $rdv['in_user_id'], 'st_first_name' );
                                $bo_email = $user->get_user_data_by_key( $rdv['in_user_id'], 'st_email_id' );
                                $mail_data = array( "bo_name" => $bo_name,
                                    "location" => $loc_name,
                                    "base_url" => SITE_NAME 
                                    );
                                $email_sm_templet = $template->get_template( 'email', '', 'recurring_cron_mail', TRUE );
                                if ( MAIL_MODE == 'test' ){
                                    $bo_email_id = TEST_EMAIL;
                                } else{
                                    $bo_email_id = $bo_email;
                                }
                                $user->send_mail_by_template( $rdv['in_user_id'], $bo_email_id, 'Pickup Recurring Request', $email_sm_templet, $mail_data );
//                            }
                        }
                    }
                    
                }
                
            }
            $cron_run_type = !isset( $_ENV['SSH_CLIENT'] );
            $arr_data = array( 
                'in_user_id' => $user_id,
                'in_added_count' => $i,
                'in_check_cron_type' => $cron_run_type,
                'in_recurring_id' => json_encode( $recurring_id ),
                'in_pickup_id' => json_encode( $pickup_id )
            );
            $insert_id = $mydb->insert( TBL_CRON, $arr_data ); 
            echo  $i . " Pickup created.";
        }
    }
    
    /* Function will add pickup which has recurring */
    public function change_order_pickup_mail() {
        global $mydb;
        if ( !session_id() ) {
            session_start();
        }
        if( isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] ){
            $user_id = $_SESSION['user_id'];
        }else if( isset( $_SESSION['admin_id'] ) && $_SESSION['admin_id'] ){
            $user_id = $_SESSION['admin_id'];
        }else{
            $user_id = 0;
        }
        include_once FL_PICKUP;
        $pickup = new pickup();
        include_once FL_USER;
        $user = new user();
        include_once FL_LOCATION;
        $location = new location();
        include_once FL_HTML_TEMPLATE;
        $template = new template();
        $i = 0;
        $recurring_id = array();
        $pickup_id = array();
        
        $co_data = $pickup->get_all_change_order_by_bo( );
       
        if( isset( $co_data ) && $co_data != 0 ){
            if( isset( $co_data['in_user_id'] ) ){
                $co_data = array( $co_data );
            }
            
            foreach( $co_data as $cok => $cov ){
                $bo_id = isset( $cov['in_user_id'] ) && $cov['in_user_id'] ? $cov['in_user_id'] : 0;
                $st_ch_from_to_day = $user->get_bo_data_by_key( $bo_id, 'st_ch_from_to_day' );
                if( isset( $st_ch_from_to_day ) && $st_ch_from_to_day != "" ){
                    $bo_ch_day = json_decode( $st_ch_from_to_day, true );
                    $last = end( $bo_ch_day );
                    if( $last == 7 ){
                        $last = 1;
                    }else{
                        $last = $last + 1;
                    }
                }
                $ch_delivery_day = $user->get_bo_data_by_key( $bo_id, 'st_ch_delivery_day' );
                if(  isset( $ch_delivery_day ) && $ch_delivery_day > 0  ){
                    if( date( "N" ) == $last ){
                        $bo_name = $user->get_user_data_by_key( $cov['in_user_id'], 'st_first_name' );
                        $bo_email = $user->get_user_data_by_key( $cov['in_user_id'], 'st_email_id' );
                        if( isset( $cov['pickup_ids'] ) && isset( $cov['pickup_ids'] ) ){
                            $pickup_ids = explode( ",", $cov['pickup_ids'] );
                            $location_ids = explode( ",", $cov['location_ids'] );
                            $location_count = count( $location_ids );
                            if( isset( $pickup_ids ) ){
                                $location_name = '';
                                foreach( $pickup_ids as $pk => $pv ){
                                    $i++;
                                    $update_id = $pickup->update_pickupdata( $pv, 'in_is_show', 1 );
                                    if( isset( $update_id ) && $update_id > 0 ){
                                        $loc_name = $location->get_location_by_key( $location_ids[$pk], 'st_address' );
                                        if( $i == $location_count ){
                                            $location_name .= $loc_name . '';
                                        }else{
                                            $location_name .= $loc_name . ', ';
                                        }
                                    }
                                    
                                }
                                // $mail_data = array( "bo_name" => $bo_name,
                                //     "location" => $location_name,
                                //     "base_url" => SITE_NAME 
                                //     );
                                // $email_sm_templet = $template->get_template( 'email', '', 'sm_add_change_order', TRUE );
                                // if ( MAIL_MODE == 'test' ){
                                //     $bo_email_id = TEST_EMAIL;
                                // } else{
                                //     $bo_email_id = $bo_email;
                                // }
                                // $user->send_mail_by_template( $bo_id, $bo_email_id, 'Store Manager of has sent a request', $email_sm_templet, $mail_data );
    
                                $str_query = "DELETE FROM " . $mydb->prefix .  TBL_CHANGE_ORDER_MAIL . ' WHERE in_user_id = ' . $bo_id . ' ';
                                $mydb->query( $str_query );
                            }
                            
                        }
                       
                    }
                }else{
                    if( date( "N" ) == 6 ){
                        $bo_name = $user->get_user_data_by_key( $cov['in_user_id'], 'st_first_name' );
                        $bo_email = $user->get_user_data_by_key( $cov['in_user_id'], 'st_email_id' );
                        if( isset( $cov['pickup_ids'] ) && isset( $cov['pickup_ids'] ) ){
                            $pickup_ids = explode( ",", $cov['pickup_ids'] );
                            $location_ids = explode( ",", $cov['location_ids'] );
                            $location_count = count( $location_ids );
                            if( isset( $pickup_ids ) ){
                                $location_name = '';
                                foreach( $pickup_ids as $pk => $pv ){
                                    $i++;
                                    $update_id = $pickup->update_pickupdata( $pv, 'in_is_show', 1 );
                                    if( isset( $update_id ) && $update_id > 0 ){
                                        $loc_name = $location->get_location_by_key( $location_ids[$pk], 'st_address' );
                                        if( $i == $location_count ){
                                            $location_name .= $loc_name . '';
                                        }else{
                                            $location_name .= $loc_name . ', ';
                                        }
    
                                        
                                    }
                                    
                                }
                                // $mail_data = array( "bo_name" => $bo_name,
                                //     "location" => $location_name,
                                //     "base_url" => SITE_NAME 
                                //     );
                                // $email_sm_templet = $template->get_template( 'email', '', 'sm_add_change_order', TRUE );
                                // if ( MAIL_MODE == 'test' ){
                                //     $bo_email_id = TEST_EMAIL;
                                // } else{
                                //     $bo_email_id = $bo_email;
                                // }
                                // $user->send_mail_by_template( $bo_id, $bo_email_id, 'Store Manager of has sent a request', $email_sm_templet, $mail_data );
    
                                $str_query = "DELETE FROM " . $mydb->prefix .  TBL_CHANGE_ORDER_MAIL . ' WHERE in_user_id = ' . $bo_id . ' ';
                                $mydb->query( $str_query );
                            }
                            
                        }
                       
                    }
                }
            }
        }   
        $cron_run_type = !isset( $_ENV['SSH_CLIENT'] );
        $arr_data = array( 
            'in_user_id' => $user_id,
            'in_added_count' => $i,
            'in_check_cron_type' => $cron_run_type,
            'in_recurring_id' => json_encode( $recurring_id ),
            'in_pickup_id' => json_encode( $pickup_id )
        );
        $insert_id = $mydb->insert( TBL_CRON, $arr_data ); 
        echo  $i . " change created.";
    }
}