<?php
$pickup = new pickup();

class pickup {

    public $flag_err = FALSE;
   
    function __construct() {
        $this->flag_err = FALSE;
        $this->active = ' in_is_active = 1 ';
    }

   function add_pickup( $pickup_data ) {
        if ( isset( $pickup_data ) && is_array( $pickup_data ) ) {
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_USER;
            $user = new user();
            include_once FL_LOCATION;
            $location = new location();
            
            $user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] != '' ?  $_SESSION['user_id'] : '';
            
            if( isset( $user_id ) && $user_id != '' ){
                $bo_data = $user->get_bo_data_by_key( $_SESSION['user_id'], 'in_store_manager_id' );
                if( $bo_data == 0 || $bo_data == '' ){
                    return -1;
                }else{
                    foreach( $pickup_data['pickup'] as $data ){
                        $location_name = ( isset( $data['location'] ) && trim( $data['location'] ) !== '' ) ? trim( $data['location'] ) : '';
                        $pickup_type = ( isset( $data['type'] ) && trim( $data['type'] ) !== '' ) ? trim( $data['type'] ) : '';
                        $pickup_amt = ( isset( $data['amt'] ) && trim( $data['amt'] ) !== '' ) ? trim( $data['amt'] ) : '';
                        $pickup_date = ( isset( $data['date'] ) && $data['date'] !== '' ) ? $data['date']  : '';
                        $recurring_type = ( isset( $data['recurring_type'] ) && $data['recurring_type'] !== '' ) ? $data['recurring_type']  : '';
                        $pickup_weekly_recurring_date = ( isset( $data['pickup_weekly_recurring_date'] ) && $data['pickup_weekly_recurring_date'] !== '' ) ? $data['pickup_weekly_recurring_date']  : '';
                        $pickup_monthly_recurring_date = ( isset( $data['pickup_monthly_recurring_date'] ) && $data['pickup_monthly_recurring_date'] !== '' ) ? $data['pickup_monthly_recurring_date']  : '';
                        $newDate = date( "Y-m-d", strtotime( $pickup_date ) );
                        
                        $st_location_type = $location->get_location_by_key( $location_name, 'st_type' );
                        if( $st_location_type == "multiple" ){
                            $sm_id = $location->get_location_by_key( $location_name, 'in_manager_id' );
                        }else{
                            $sm_id = $user->get_bo_data_by_key( $user_id, 'in_store_manager_id' );
                        }
                        
                        if( $pickup_type == "recurring" ){
                            if( $recurring_type == "weekly" ){
                                $type = $pickup_weekly_recurring_date;
                            }else{
                                $type = $pickup_monthly_recurring_date;
                            }
                            $arr_data = array(
                                'in_user_id' => $user_id,
                                'in_location_id' => $location_name,
                                'st_recurring_type' => $recurring_type,
                                'st_recurring_date' => $type,
                                'fl_amount' => $pickup_amt,
                            );
                            $insert_id = $mydb->insert( TBL_RECURRING_PICKUP, $arr_data );
                        }else{
                            $arr_data = array(
                                'in_user_id' => $user_id,
                                'in_location_id' => $location_name,
                                'in_manager_id' => $sm_id,
                                'dt_pickup' => $newDate,
                                'st_pickup_type' => $pickup_type,
                                'fl_amount' => $pickup_amt,
                            );
                            $insert_id = $mydb->insert( TBL_PICKUP, $arr_data );
                        }
                    }
                    if ( $insert_id !== '' && $insert_id > 0 ) {
                        return $insert_id;
                    } else {
                        $this->flag_err = TRUE;
                    }
                }
            }else{
                return 0;
            }
        }
    }
    
    function add_change_order( $change_data ) {
        if ( isset( $change_data ) && is_array( $change_data ) ) {
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            
            include_once FL_LOCATION;
            $location = new location();
            include_once FL_USER;
            $user = new user();
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            $user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] != '' ?  $_SESSION['user_id'] : '';
            
            if( isset( $user_id ) && $user_id != '' ){
                foreach( $change_data['change'] as $data ){
                    $location_name = ( isset( $data['location'] ) && trim( $data['location'] ) !== '' ) ? trim( $data['location'] ) : '';
                    $pickup_date = ( isset( $data['date'] ) && $data['date'] !== '' ) ? $data['date']  : '';
                    $amt_d_50 = ( isset( $data['amt_d_50'] ) && trim( $data['amt_d_50'] ) !== '' ) ? trim( $data['amt_d_50'] ) : 0;
                    $amt_d_20 = ( isset( $data['amt_d_20'] ) && $data['amt_d_20'] !== '' ) ? $data['amt_d_20']  : 0;
                    $amt_d_10 = ( isset( $data['amt_d_10'] ) && trim( $data['amt_d_10'] ) !== '' ) ? trim( $data['amt_d_10'] ) : 0;
                    $amt_d_5 = ( isset( $data['amt_d_5'] ) && $data['amt_d_5'] !== '' ) ? $data['amt_d_5']  : 0;
                    $amt_d_1 = ( isset( $data['amt_d_1'] ) && trim( $data['amt_d_1'] ) !== '' ) ? trim( $data['amt_d_1'] ) : 0;
                    $amt_c_1 = ( isset( $data['amt_c_1'] ) && $data['amt_c_1'] !== '' ) ? $data['amt_c_1']  : 0;
                    $amt_c_5 = ( isset( $data['amt_c_5'] ) && trim( $data['amt_c_5'] ) !== '' ) ? trim( $data['amt_c_5'] ) : 0;
                    $amt_c_10 = ( isset( $data['amt_c_10'] ) && $data['amt_c_10'] !== '' ) ? $data['amt_c_10']  : 0;
                    $amt_c_25 = ( isset( $data['amt_c_25'] ) && trim( $data['amt_c_25'] ) !== '' ) ? trim( $data['amt_c_25'] ) : 0;
                    $gt_amt = ( isset( $data['gt_amt'] ) && trim( $data['gt_amt'] ) !== '' ) ? trim( $data['gt_amt'] ) : 0;
                    $newDate = date( "Y-m-d", strtotime( $pickup_date ) );
                    
                    if( isset( $location_name ) && $location_name != '' ){
//                        $location_data = $location->get_location_data_by( 'in_manager_id' , $user_id );
                        $location_user_id = $location->get_location_by_key( $location_name, 'in_user_id' );
                        $locationname = $location->get_location_by_key( $location_name, 'st_location_name' );
                        $bo_data = $user->get_bo_data_by( 'in_store_manager_id', $user_id );
                        $arr_data = array(
                            'in_user_id' => $location_user_id,
                            'in_manager_id' => $user_id,
                            'in_location_id' => $location_name,
                            'dt_pickup' => $newDate,
                            'st_order_type' => "change_order",
                            'fl_amount' => $gt_amt
                        );
                    }else{
                        $location_data = $location->get_location_data_by( 'in_manager_id' , $user_id );
                        $arr_data = array(
                            'in_user_id' => $location_data['in_user_id'],
                            'in_manager_id' => $user_id,
                            'in_location_id' => $location_data['in_location_id'],
                            'dt_pickup' => $newDate,
                            'st_order_type' => "change_order",
                            'fl_amount' => $gt_amt
                        );
                        
                    }
                    $insert_id = $mydb->insert( TBL_PICKUP, $arr_data );
                    if( isset( $insert_id ) && $insert_id > 0 ){
                        $arr_data = array(
                            'in_pickup_id' => $insert_id,
                            'fl_dollar_50' => $amt_d_50,
                            'fl_dollar_20' => $amt_d_20,
                            'fl_dollar_10' => $amt_d_10,
                            'fl_dollar_5' => $amt_d_5,
                            'fl_dollar_1' => $amt_d_1,
                            'ft_cent_1' => $amt_c_1,
                            'ft_cent_5' => $amt_c_5,
                            'ft_cent_10' => $amt_c_10,
                            'ft_cent_25' => $amt_c_25,
                        );
                        
                        $co_insert_id = $mydb->insert( TBL_CHANGE_ORDER, $arr_data );
                        
                        $sm_id = $this->get_pickup_by_key( $insert_id, 'in_user_id' );
                        if( isset( $location_name ) && $location_name > 0 ){
//                            $location_data = $location->get_location_data_by( 'in_manager_id' , $user_id );
                            $location_user_id = $location->get_location_by_key( $location_name, 'in_user_id' );
                            $locationname = $location->get_location_by_key( $location_name, 'st_location_name' );
                            $bo_data = $user->get_bo_data_by( 'in_store_manager_id', $sm_id );
                            $bo_data['in_user_id'] = $location_user_id;
                        }else{
                            $location_data = $location->get_location_data_by( 'in_manager_id' , $user_id );
                            $locationname = $location->get_location_by_key( $location_data['in_location_id'], 'st_location_name' );
                            $bo_data['in_user_id'] = $location_data['in_user_id'];
                            $location_name = $location_data['in_location_id'];
                        }
                        
                        $arr_co_data = array(   
                            'in_pickup_id' => $insert_id,
                            'in_location_id' => $location_name,
                            'in_user_id' => $bo_data['in_user_id']
                        );
                        
                        $co_mail_insert_id = $mydb->insert( TBL_CHANGE_ORDER_MAIL, $arr_co_data );
                        
                    }
                }
                if ( $insert_id !== '' && $insert_id > 0 ) {
                    return $insert_id;
                } else {
                    $this->flag_err = TRUE;
                }
            }else{
                return 0;
            }
        }
    }
    
    
    public function get_pickup_data_by_key( $pickup_id = 0 ) {

        global $mydb;

        $str_query = 'SELECT * from ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_pickup_id = ' . $pickup_id . '';

        $response = $mydb->query($str_query);

        if ($response != 0 && count($response) > 0) {
            return $response;
        }
    }
    public function get_job_data_by_key( $job_id = 0 ) {

        global $mydb;

        $str_query = 'SELECT * from ' . $mydb->prefix . TBL_JOB . ' WHERE in_job_id = ' . $job_id . '';

        $response = $mydb->query($str_query);

        if ($response != 0 && count($response) > 0) {
            return $response;
        }
    }
    
    function update_pickupdata( $pick_id = 0, $key = '', $value = '' ) {
        if ( $pick_id > 0 && trim( $key ) !== '' ) {
            global $mydb;
            $update = FALSE;
            $where = array(
                'in_pickup_id' => $pick_id
            );
            
            $arr_data = array(
                $key => $value
            );
            $update_id = $mydb->update( TBL_PICKUP, $arr_data, $where );
            if ( $update_id != 0 && $update_id > 0 ) {
                return( $update_id );
            } else {
                return 0;
            }
        }
    }
    
    function add_job( $data ) {
        
        if ( isset( $data ) && is_array( $data ) ) {
            
            global $mydb;
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            include_once FL_USER;
            $user = new user();
            include_once FL_LOCATION;
            $location = new location();
            include_once FL_SETTINGS;
            $settings = new settings();
            $bo_admin_bank_address = $settings->get_settings( 'bo_bank_address' , TRUE );
            
            if ( !session_id() ) {
                session_start();
            }
            $last_address = ( isset( $data['last_addess'] ) && trim( $data['last_addess'] ) !== '' ) ? trim( $data['last_addess'] ) : '';
            $txt_address = ( isset( $data['txt_address'] ) && trim( $data['txt_address'] ) !== '' ) ? trim( $data['txt_address'] ) : '';
            $hdn_latitude = ( isset( $data['hdn_latitude'] ) && trim( $data['hdn_latitude'] ) !== '' ) ? trim( $data['hdn_latitude'] ) : '';
            $hdn_longitude = ( isset( $data['hdn_longitude'] ) && trim( $data['hdn_longitude'] ) !== '' ) ? trim( $data['hdn_longitude'] ) : '';
            $first_last_address = ( isset( $data['first_last_address'] ) && trim( $data['first_last_address'] ) !== '' ) ? trim( $data['first_last_address'] ) : '';
            $txt_other_address = ( isset( $data['txt_other_address'] ) && trim( $data['txt_other_address'] ) !== '' ) ? trim( $data['txt_other_address'] ) : '';
            $hdn_other_latitude = ( isset( $data['hdn_other_latitude'] ) && trim( $data['hdn_other_latitude'] ) !== '' ) ? trim( $data['hdn_other_latitude'] ) : '';
            $hdn_other_longitude = ( isset( $data['hdn_other_longitude'] ) && trim( $data['hdn_other_longitude'] ) !== '' ) ? trim( $data['hdn_other_longitude'] ) : '';
            $driver_name = ( isset( $data['txt_driver_name'] ) && trim( $data['txt_driver_name'] ) !== '' ) ? trim( $data['txt_driver_name'] ) : '';
            $driver_pickup_amt = ( isset( $data['driver_pickup_amt'] ) && trim( $data['driver_pickup_amt'] ) > 0 ) ? trim( $data['driver_pickup_amt'] ) : 0;
            $arr_data = array(
                'in_driver_id' => $driver_name,
                'st_status' => "assign",
                'st_bo_last_address' => $last_address,
                'st_bo_first_address' => $first_last_address,
                'st_address' => $txt_address,
                'in_latitude' => $hdn_latitude,
                'in_longitude' => $hdn_longitude,
                'st_ch_other_address' => $txt_other_address,
                'in_ch_other_latitude' => $hdn_other_latitude,
                'in_ch_other_longitude' => $hdn_other_longitude,
                'fl_driver_pickup_amt' => $driver_pickup_amt,
                'st_pay_status' => 'pending'
            );
            
            
            $pickid = ( isset( $data['pickup_id'] ) && trim( $data['pickup_id'] ) !== '' ) ? trim( $data['pickup_id'] ) : '';
            $delete_pickup = 0;
            $pickup_id = explode( ",", $pickid );
            if( isset( $pickup_id ) && is_array( $pickup_id ) ){
                foreach( $pickup_id as $id ){
                    $in_is_active = $this->get_pickup_by_key( $id, 'in_is_active' );
                    if( $in_is_active == 0 ){
                        $delete_pickup = 1;
                    }
                }
            }
            if( $delete_pickup == 1 ){
                return -1;
            }else{
                $insert_id = $mydb->insert( TBL_JOB, $arr_data );
                if ( $insert_id !== '' && $insert_id > 0 ) {
                    
                    $pickid = ( isset( $data['pickup_id'] ) && trim( $data['pickup_id'] ) !== '' ) ? trim( $data['pickup_id'] ) : '';
                    $pickup_id = explode( ",", $pickid );
                    $location_name = array();
                    if( isset( $pickup_id ) && is_array( $pickup_id ) ){
                        foreach( $pickup_id as $id ){
                            $current_time = time();
                            $key = md5( $id . $current_time );
                            $verify_code = $key;
                            $p_key =  array_search( $id, $data['pickup_type'] );
                            $sort_p = $p_key;
                            $set = array( 
                                'in_job_id' => $insert_id,
                                'st_veriry_code' => $verify_code,
                                'st_status' => "assign",
                                'in_pickup_sort' => $sort_p
                            );
                            $where = array( 
                                'in_pickup_id' => $id
                            );
                            $update_id = $mydb->update( TBL_PICKUP, $set, $where );
                        }
                        
                        array_shift( $data['pickup_type'] );
                        foreach (  $data['pickup_type']  as $pk => $pv ){
                            $data['pickup_type'][$pk] = array(
                                'type' => $pv,
                                'status' => 'assign'
                            );
                        }
                        $arr_order_data = array(
                            'in_job_id' => $insert_id,
                            'st_order_no' => json_encode( $data['pickup_type'] )
                        );
                        $insert_grp_id = $mydb->insert( TBL_ORDER, $arr_order_data );
                        
                        $str_query = 'SELECT in_user_id,in_location_id,in_pickup_id,st_order_type,max(dt_pickup) as dt_pickup FROM ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_job_id = ' . $insert_id . ' GROUP BY in_user_id';
                        $response = $mydb->query( $str_query );
                        if( isset( $response['in_user_id'] ) ){
                            $response = array( $response );
                        }
                        
                        $arr_sm_id = array();
                        $arr_bo_id = array();
                        foreach( $response as $res ){
                            $pick_date = date( "m-d-Y", strtotime( $res['dt_pickup'] ) );
                            $arr_data = array(
                                'dt_pickup' => $res['dt_pickup']
                            );
                            $where = array(
                                'in_job_id' => $insert_id,
                            );
                            $update = $mydb->update( TBL_JOB, $arr_data, $where );
                            if( $res['st_order_type'] == "change_order" ){
                                $bo_data = $user->get_bo_data_by( 'in_store_manager_id', $res['in_user_id'] );
                                $bo_id = $bo_data['in_user_id'];
                                array_push( $arr_sm_id, $res['in_user_id'] );
                                array_push( $arr_bo_id, $bo_id );
                            }else{
                                $bo_id = $res['in_user_id'];
                                $sm_id = $user->get_bo_data_by_key( $res['in_user_id'], 'in_store_manager_id' );
                                array_push( $arr_sm_id, $sm_id );
                                array_push( $arr_bo_id, $bo_id );
                            }
                        }
                        $arr_smid = array_unique( $arr_sm_id );
                        $arr_boid = array_unique( $arr_bo_id );
                        if( isset( $arr_smid ) && is_array( $arr_smid ) ){
                            foreach( $arr_smid as $smk => $smv ){
    //                            $sm_email_id = $user->get_user_data_by_key( $smv, 'st_email_id' );
    //                            $sm_name = $user->get_user_data_by_key( $smv, 'st_first_name' );
    //                            $mail_data = array( "user_name" => $sm_name,
    //                                "date" => $pick_date,
    //                                "base_url" => SITE_NAME );
    //                            $email_sm_templet = $template->get_template( 'email', '', 'store_manager_pickup_schedule', TRUE );
    //                            if ( MAIL_MODE == 'test' ){
    //                                $sm_email_id = TEST_EMAIL;
    //                            } else{
    //                                $sm_email_id = $sm_email_id;
    //                            }
    //                            $user->send_mail_by_template( $smv, $sm_email_id, 'Cop Express - Pickup list assigned to driver ', $email_sm_templet, $mail_data );
                            }
                        }
                        $drivername = $user->get_user_data_by_key( $driver_name, 'st_first_name' );
                        if( isset( $arr_boid ) && is_array( $arr_boid ) ){
                            $bo_count = count( $arr_boid );
                            foreach( $arr_boid as $bok => $bov ){
                                
    //                            $location_name = array();
    //                            $bo_email_id = $user->get_user_data_by_key( $bov, 'st_email_id' );
    //                            $bo_name = $user->get_user_data_by_key( $bov, 'st_first_name' );
    //                            if( isset( $last_address ) && $last_address == "home" ){
    //                                $last_pickup_address = $user->get_user_meta( $bov , 'st_bo_home_address', TRUE );
    //                                
    //                            }else if( isset( $last_address ) && $last_address == "warehouse" ){
    //                                $last_pickup_address = $user->get_user_meta( $bov , 'st_bo_warehouse_address', TRUE );
    //                            }else{
    //                                
    //                                if( $bo_count > 1 ){
    //                                    $last_pickup_address = $bo_admin_bank_address;
    //                                }else{
    //                                    $last_pickup_address = $user->get_bo_data_by_key( $bov, 'st_add' );
    //                                    if( $last_pickup_address != '' ){
    //                                        $last_pickup_address = $last_pickup_address;
    //                                    }else{
    //                                        $last_pickup_address = $bo_admin_bank_address;
    //                                    }
    //                                }
    //                            }
    //                            
    //                            $admin_mail_data = array( "bo_name" => $bo_name,
    //                                "address_type" => $last_address,
    //                                "address" => $last_pickup_address,
    //                                "base_url" => SITE_NAME );
    //                            $email_admin_templet = $template->get_template( 'email', '', 'admin_select_last_location', TRUE );
    //                            
    //                            if ( MAIL_MODE == 'test' ) {
    //                                $bo_email_id = TEST_EMAIL;
    //                            } else {
    //                                $bo_email_id = $bo_email_id;
    //                            }
    //                            $query = "SELECT in_location_id FROM " . $mydb->prefix . TBL_PICKUP . " WHERE in_job_id = " . $insert_id . " AND ( ( st_order_type IS NULL AND in_user_id = " 
    //                                    . $bov . " ) || ( st_order_type = 'change_order' AND in_user_id in ( SELECT in_store_manager_id FROM " . $mydb->prefix . TBL_BUSINESS_OWNER . " ) ) ) "; 
    //                                
    //                            $location_res = $mydb->query( $query );
    //                            
    //                            if( isset( $location_res ) && is_array( $location_res ) ){
    //                                if( isset( $location_res['in_location_id'] ) ){
    //                                    $location_res = array( $location_res );
    //                                }
    //                                foreach( $location_res as $lk => $lv ){
    //                                    $loc_name = $location->get_location_by_key( $lv['in_location_id'], 'st_location_name' );
    //                                    $location_name[] = $loc_name;
    //                                }
    //                            }
    //                            $user->send_mail_by_template( $bo_id, $bo_email_id, SITE_NAME . ' - Pickup list delivery location scheduled', $email_admin_templet, $admin_mail_data );
    //                            $locationname = implode( ",",$location_name );
    //                            $email_data = array( "user_name" => $bo_name,
    //                                "pickup_id" => $locationname,
    //                                "base_url" => SITE_NAME );
    //                            $email_reset_templet = $template->get_template('email', '', 'pickup_schedule', TRUE);
    //                            $user->send_mail_by_template( $bo_id, $bo_email_id,'Cop Express - Pickup list assigned to driver: ' . $drivername . ' ', $email_reset_templet, $email_data );
                            }
                        }
                        
                        $driver_email_id = $user->get_user_data_by_key( $driver_name, 'st_email_id' );
                        
                        $mail_data = array( "user_name" => $drivername,
                            "date" => $pick_date,
                            "base_url" => SITE_NAME );
                        $email_driver_templet = $template->get_template('email', '', 'driver_pickup_schedule', TRUE);
                        $email_sm_templet = $template->get_template('email', '', 'store_manager_pickup_schedule', TRUE);
    //                    $emailid = $email_id;
                        if ( MAIL_MODE == 'test' ) {
                            $driver_email_id = TEST_EMAIL;
                        } else {
                            $driver_email_id = $driver_email_id;
                        }
                        $user->send_mail_by_template( $driver_name, $driver_email_id, 'Cop Express - Pickup list assigned to driver: '.$drivername.' ', $email_driver_templet, $mail_data );
                    }
                    return $insert_id;
                } else {
                    $this->flag_err = TRUE;
                }  
            }
        }else{
            return 0;
        }
    }
    
    function add_all_driver_job( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            include_once FL_USER;
            $user = new user();
            include_once FL_LOCATION;
            $location = new location();
            if ( !session_id() ) {
                session_start();
            }
            $last_address = ( isset( $data['last_addess'] ) && trim( $data['last_addess'] ) !== '' ) ? trim( $data['last_addess'] ) : '';
            $txt_address = ( isset( $data['txt_address'] ) && trim( $data['txt_address'] ) !== '' ) ? trim( $data['txt_address'] ) : '';
            $hdn_latitude = ( isset( $data['hdn_latitude'] ) && trim( $data['hdn_latitude'] ) !== '' ) ? trim( $data['hdn_latitude'] ) : '';
            $hdn_longitude = ( isset( $data['hdn_longitude'] ) && trim( $data['hdn_longitude'] ) !== '' ) ? trim( $data['hdn_longitude'] ) : '';
            $driver_name = ( isset( $data['txt_driver_name'] ) && trim( $data['txt_driver_name'] ) !== '' ) ? trim( $data['txt_driver_name'] ) : '';
            $driver_pickup_amt = ( isset( $data['driver_pickup_amt'] ) && trim( $data['driver_pickup_amt'] ) > 0 ) ? trim( $data['driver_pickup_amt'] ) : 0;
            $first_last_address = ( isset( $data['first_last_address'] ) && trim( $data['first_last_address'] ) !== '' ) ? trim( $data['first_last_address'] ) : '';
            $txt_other_address = ( isset( $data['txt_other_address'] ) && trim( $data['txt_other_address'] ) !== '' ) ? trim( $data['txt_other_address'] ) : '';
            $hdn_other_latitude = ( isset( $data['hdn_other_latitude'] ) && trim( $data['hdn_other_latitude'] ) !== '' ) ? trim( $data['hdn_other_latitude'] ) : '';
            $hdn_other_longitude = ( isset( $data['hdn_other_longitude'] ) && trim( $data['hdn_other_longitude'] ) !== '' ) ? trim( $data['hdn_other_longitude'] ) : '';
            
            $arr_data = array(
                'in_driver_id' => 0,
                'st_status' => "pending",
                'st_admin_assign_type' => "all",
                'st_bo_last_address' => $last_address,
                'st_bo_first_address' => $first_last_address,
                'st_address' => $txt_address,
                'in_latitude' => $hdn_latitude,
                'in_longitude' => $hdn_longitude,
                'st_ch_other_address' => $txt_other_address,
                'in_ch_other_latitude' => $hdn_other_latitude,
                'in_ch_other_longitude' => $hdn_other_longitude,
                'fl_driver_pickup_amt' => $driver_pickup_amt,
                'st_pay_status' => 'pending'
            );
            
    
            $insert_id = $mydb->insert( TBL_JOB, $arr_data );
            if ( $insert_id !== '' && $insert_id > 0 ) {
                
                $pickid = ( isset( $data['pickup_id'] ) && trim( $data['pickup_id'] ) !== '' ) ? trim( $data['pickup_id'] ) : '';
                $pickup_id = explode( ",", $pickid );
                $location_name = array();
                if( isset( $pickup_id ) && is_array( $pickup_id ) ){
                    foreach( $pickup_id as $id ){
                        $current_time = time();
                        $key = md5( $id . $current_time );
                        $verify_code = $key;
                        $p_key =  array_search( $id, $data['pickup_sorting'] );
                        $sort_p = $p_key + 1;
                        $set = array( 
                            'in_job_id' => $insert_id,
                            'st_veriry_code' => $verify_code,
                            'st_status' => "assign",
                            'in_pickup_sort' => $sort_p
                        );
                        $where = array( 
                            'in_pickup_id' => $id
                        );
                        $update_id = $mydb->update( TBL_PICKUP, $set, $where );
                        $locationid = $this->get_pickup_by_key( $id, 'in_location_id' );
                        $st_order_type = $this->get_pickup_by_key( $id, 'st_order_type' );
                        $loc_name = $location->get_location_by_key( $locationid, 'st_location_name' );
                        $location_name[] = $loc_name;
                        
                        if( $st_order_type == "change_order" ){
                            $manager_id = $this->get_pickup_by_key( $id, 'in_user_id' );
                        }else{
                            $manager_id = $this->get_pickup_by_key( $id, 'in_manager_id' );
                        }
                        $dt_pickup = $this->get_pickup_by_key( $id, 'dt_pickup' );
                        $pick_date = date("m-d-Y", strtotime( $dt_pickup ) );
                    }
                    
                    array_shift( $data['pickup_type'] );
                    foreach (  $data['pickup_type']  as $pk => $pv ){
                        $data['pickup_type'][$pk] = array(
                            'type' => $pv,
                            'status' => 'assign'
                        );
                    }
                    $arr_order_data = array(
                        'in_job_id' => $insert_id,
                        'st_order_no' => json_encode( $data['pickup_type'] )
                    );
                    $insert_grp_id = $mydb->insert( TBL_ORDER, $arr_order_data );
                    
                    $locationname = implode( ",",$location_name );
                    $str_query = 'SELECT in_user_id,st_order_type,max(dt_pickup) as dt_pickup FROM ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_job_id = ' . $insert_id . ' GROUP BY in_user_id';
                    $response = $mydb->query( $str_query );
                    if( isset( $response['in_user_id'] ) ){
                        $response = array( $response );
                    }
                    foreach( $response as $res ){
                        date("m-d-Y", strtotime( $res['dt_pickup'] ) );
                        $arr_data = array(
                            'dt_pickup' => $res['dt_pickup']
                        );
                        $where = array(
                            'in_job_id' => $insert_id,
                        );
                        $update = $mydb->update( TBL_JOB, $arr_data, $where );
                        if( $res['st_order_type'] == "change_order" ){
                            $bo_data = $user->get_bo_data_by( 'in_store_manager_id', $res['in_user_id'] );
                            $bo_id = $bo_data['in_user_id'];
                        }else{
                            $bo_id = $res['in_user_id'];
                        }
                    }
                    
                    $bo_email_id = $user->get_user_data_by_key( $bo_id, 'st_email_id' );
                    $bo_name = $user->get_user_data_by_key( $bo_id, 'st_first_name' );
                    if( isset( $last_address ) && $last_address == "home" ){
                        $last_pickup_address = $user->get_user_meta( $bo_id , 'st_bo_home_address', TRUE );
                    }else if( isset( $last_address ) && $last_address == "warehouse" ){
                        $last_pickup_address = $user->get_user_meta( $bo_id , 'st_bo_warehouse_address', TRUE );
                    }else{
                        $last_pickup_address = $user->get_bo_data_by_key( $bo_id, 'st_add' );
                    }
                    
//                    $admin_mail_data = array( "bo_name" => $bo_name,
//                        "address_type" => $last_address,
//                        "address" => $last_pickup_address,
//                        "base_url" => SITE_NAME );
//                    $email_data = array( "user_name" => $bo_name,
//                        "pickup_id" => $locationname,
//                        "base_url" => SITE_NAME );
//                    
//                    
//                    if ( MAIL_MODE == 'test' ) {
//                        $bo_email_id = TEST_EMAIL;
//                    } else {
//                        $bo_email_id = $bo_email_id;
//                    }
//                    
//                    $email_admin_templet = $template->get_template( 'email', '', 'admin_select_last_location', TRUE );
//                    $email_reset_templet = $template->get_template( 'email', '', 'pickup_schedule', TRUE);
//                    $user->send_mail_by_template( $bo_id, $bo_email_id, SITE_NAME . '  pickup list Job request sent to all drivers ' , $email_reset_templet, $email_data );
//                    $user->send_mail_by_template( $bo_id, $bo_email_id, SITE_NAME . ' - Pickup list delivery location scheduled', $email_admin_templet, $admin_mail_data );
                }
                return $insert_id;
            } else {
                $this->flag_err = TRUE;
            }  
        }else{
            return 0;
        }
    }
    
    function update_jobdata( $pick_id = 0, $key = '', $value = '' ) {
        if ( $pick_id > 0 && trim( $key ) !== '') {
            global $mydb;
            $update = FALSE;
            $where = array(
                'in_pickup_id' => $pick_id
            );
            
            $arr_data = array(
                $key => $value
            );
            $update_id = $mydb->update( TBL_JOB, $arr_data, $where );
            if ( $update_id != 0 && $update_id > 0 ) {
                return( $update_id );
            } else {
                return 0;
            }
        }
    }
    
    public function get_unassign_pickups( $user_id = 0 , $type = "" ,$show = 1 ){
        global $mydb;
        $check_id = '';
        $check_type = '';
        if( isset( $type ) && $type != "" ){
            if( isset( $show ) && $show == 0 ){
                $check_type = " AND st_order_type = 'change_order' AND in_is_show = 0 ";
            }else{
                $check_type = " AND st_order_type = 'change_order' AND in_is_show = 1 ";
            }
        }
        if( isset( $user_id ) && $user_id > 0 && !is_array( $user_id ) ){
            if( isset( $type ) && $type != "" ){
                $check_id = " AND in_manager_id = " . $user_id . " ";
            }else{
                $check_id = " AND in_user_id = " . $user_id . " ";
            }
            
        }
        if( isset( $user_id ) && is_array( $user_id ) ){
            if( isset( $type ) && $type != "" ){
                $id = implode( ',', $user_id );
                $check_id = " AND in_manager_id IN (" . $id . ") ";
            }else{
                $id = implode( ',', $user_id );
                $check_id = " AND in_user_id IN (" . $id . ") ";
            }
            
        }
        $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_job_id = 0 AND in_location_id IN ( SELECT in_location_id  FROM ' . $mydb->prefix . TBL_LOCATION . ' WHERE in_is_active = 1 ) '  . $check_type . $check_id;
        $response = $mydb->query( $str_query );
        if( isset( $response ) && $response != '' ){
            if( isset( $response['in_pickup_id'] ) ){
                $response = array( $response );
            }
            return $response;
        }
        return '';
    }
    
    public function get_pickups_pending_for_approve( $user_id = 0 ){
        global $mydb;
        $check_id = '';
        $check_type = '';
        if( isset( $type ) && $type != "" ){
            $check_type = " AND st_order_type = 'change_order'  ";
        }
        if( isset( $user_id ) && $user_id > 0 && !is_array( $user_id ) ){
            $check_id = " AND in_manager_id = " . $user_id . " ";
        }
        if( isset( $user_id ) && is_array( $user_id ) ){
            $id = implode( ',', $user_id );
            $check_id = " AND in_manager_id IN (" . $id . ") ";
        }
        $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_job_id = 0 AND st_order_type = "change_order" ' 
                . $check_id . ' AND in_is_show = 1 AND in_pickup_id IN ( SELECT in_pickup_id FROM  ' . $mydb->prefix . TBL_CHANGE_ORDER . ' WHERE in_is_approve = 0 )  AND in_location_id IN ( SELECT in_location_id  FROM ' . $mydb->prefix . TBL_LOCATION . ' WHERE in_is_active = 1 )';
        $response = $mydb->query( $str_query );
        if( isset( $response ) && $response != '' ){
            if( isset( $response['in_pickup_id'] ) ){
                $response = array( $response );
            }
            $count_pickup = count( $response );
            return $count_pickup;
        }
        return 0;
    }
    
    public function get_admin_unassign_pickups( $date_type ){
        global $mydb;
        if( isset( $date_type ) && $date_type == 'all' ){
            $date = date( "Y-m-d" );
            $str_query = 'SELECT DISTINCT p.in_pickup_id ,p.* FROM ' . $mydb->prefix . TBL_PICKUP . ' p,  ' . 
                $mydb->prefix . TBL_CHANGE_ORDER . ' c WHERE  p.in_job_id = 0 AND p.in_is_active = 1 AND p.dt_pickup >= "' . $date . '" AND ( p.st_order_type IS NULL || ( p.st_order_type = "change_order" AND p.in_pickup_id = c.in_pickup_id AND c.in_is_approve = 1 ) ) AND p.in_location_id in ( SELECT in_location_id FROM  ' . $mydb->prefix . TBL_LOCATION . ' WHERE in_is_active = 1 ) ';
            $response = $mydb->query( $str_query ); 
        }else if( isset( $date_type ) && $date_type == 'today' ){
            $date = date( "Y-m-d" );
            $str_query = 'SELECT DISTINCT p.in_pickup_id ,p.* FROM ' . $mydb->prefix . TBL_PICKUP . ' p,  ' . 
                $mydb->prefix . TBL_CHANGE_ORDER . ' c WHERE  p.in_job_id = 0 AND p.in_is_active = 1 AND p.dt_pickup = "' . $date . '" AND ( p.st_order_type IS NULL || ( p.st_order_type = "change_order" AND p.in_pickup_id = c.in_pickup_id AND c.in_is_approve = 1 ) ) AND p.in_location_id in ( SELECT in_location_id FROM  ' . $mydb->prefix . TBL_LOCATION . ' WHERE in_is_active = 1 ) ';
            $response = $mydb->query( $str_query );
        }else if( isset( $date_type ) && $date_type == 'tomorrow' ){
            $date = date( "Y-m-d", strtotime( 'tomorrow' ) );
            $str_query = 'SELECT DISTINCT p.in_pickup_id ,p.* FROM ' . $mydb->prefix . TBL_PICKUP . ' p,  ' . 
                $mydb->prefix . TBL_CHANGE_ORDER . ' c WHERE  p.in_job_id = 0 AND p.in_is_active = 1 AND p.dt_pickup = "' . $date . '" AND ( p.st_order_type IS NULL || ( p.st_order_type = "change_order" AND p.in_pickup_id = c.in_pickup_id AND c.in_is_approve = 1 ) ) AND p.in_location_id in ( SELECT in_location_id FROM  ' . $mydb->prefix . TBL_LOCATION . ' WHERE in_is_active = 1 ) ';
            $response = $mydb->query( $str_query );
        }else if( isset( $date_type ) && $date_type == 'week' ){
            $date = date( "Y-m-d" );
            $start = ( date( 'D' ) != 'Mon' ) ? date( 'Y-m-d', strtotime( 'last Monday' ) ) : date('Y-m-d' );
            $finish = ( date( 'D' ) != 'Sun' ) ? date( 'Y-m-d', strtotime( 'next Sunday' ) ) : date('Y-m-d' );
            $str_query = 'SELECT DISTINCT p.in_pickup_id ,p.* FROM ' . $mydb->prefix . TBL_PICKUP . ' p,  ' . 
                $mydb->prefix . TBL_CHANGE_ORDER . ' c WHERE  p.in_job_id = 0 AND p.in_is_active = 1 AND ( p.st_order_type IS NULL || ( p.st_order_type = "change_order" AND p.in_pickup_id = c.in_pickup_id AND c.in_is_approve = 1 ) ) AND p.dt_pickup BETWEEN "' . $date . '" AND "' . $finish . '" AND p.in_location_id in ( SELECT in_location_id FROM  ' . $mydb->prefix . TBL_LOCATION . ' WHERE in_is_active = 1 ) ';
            $response = $mydb->query( $str_query );
        }else if( isset( $date_type ) && $date_type == 'month' ){
            $date = date( "Y-m-d" );
            $last_date = date( 'Y-m-d',strtotime( 'last day of this month' ) );
            $str_query = 'SELECT DISTINCT p.in_pickup_id ,p.* FROM ' . $mydb->prefix . TBL_PICKUP . ' p,  ' . 
                $mydb->prefix . TBL_CHANGE_ORDER . ' c WHERE  p.in_job_id = 0 AND p.in_is_active = 1 AND ( p.st_order_type IS NULL || ( p.st_order_type = "change_order" AND p.in_pickup_id = c.in_pickup_id AND c.in_is_approve = 1 ) ) AND p.dt_pickup BETWEEN "' . $date . '" AND "' . $last_date . '" AND p.in_location_id in ( SELECT in_location_id FROM  ' . $mydb->prefix . TBL_LOCATION . ' WHERE in_is_active = 1 ) ';
            $response = $mydb->query( $str_query );
        }
        
        if( isset( $response ) && $response != '' ){
            if( isset( $response['in_pickup_id'] ) ){
                $response = array( $response );
            }
            return $response;
        }
        return '';
    }
    
    public function get_unassign_change_orders(){
        global $mydb;
        
        $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_CHANGE_ORDER . ' WHERE in_job_id = 0 ';
        $response = $mydb->query( $str_query );
        if( isset( $response ) && $response != '' ){
            if( isset( $response['in_pickup_id'] ) ){
                $response = array( $response );
            }
            return $response;
        }
        return '';
    }
    
    public function get_assign_pickups(){
        global $mydb;
        include_once FL_USER;
        $user = new user();
        $date = date( "Y-m-d" );
        $str_query = 'SELECT DISTINCT j.* FROM ' . $mydb->prefix . TBL_JOB . ' j ,' . $mydb->prefix . TBL_PICKUP 
                .' p WHERE p.in_job_id != 0 AND j.in_job_id = p.in_job_id AND j.dt_pickup >= "' . $date . '" ';
        $response = $mydb->query( $str_query );
        if( isset( $response ) && $response != '' || $response > 0 ){
            if( isset( $response['in_job_id'] ) ){
                $response = array( $response );
            }
            foreach( $response as $res_k => $res_v ){
                $where = array(
                    'in_job_id' => $res_v['in_job_id']
                );
                $response[$res_k]['pickup_list'] = $mydb->get_all( TBL_PICKUP , '*' , $where );
                if( isset( $response[$res_k]['pickup_list'] ) && $response[$res_k]['pickup_list'] != '' || $response[$res_k]['pickup_list'] > 0 ){
                    if( isset( $response[$res_k]['pickup_list']['in_pickup_id'] ) ){
                        $response[$res_k]['pickup_list'] = array( $response[$res_k]['pickup_list'] );
                    }
                    $response[$res_k]['pickup_count'] = count( $response[$res_k]['pickup_list'] );
                    $response[$res_k]['pickup_sum'] = 0;
                    $is_change = '';
                    $is_pickup = '';
                    $is_recurring = '';
                    foreach( $response[$res_k]['pickup_list'] as $pdk => $pdv ){
                        $response[$res_k]['pickup_sum'] = $pdv['fl_amount'] + $response[$res_k]['pickup_sum'];
                        if( $pdv['st_order_type'] == "change_order" ){
                            $is_change = "yes";
                        }else{
                            $is_pickup = "yes";
                        }
                        if( $pdv['st_order_type'] == "change_order" ){
                            $bo_data = $user->get_bo_data_by( 'in_store_manager_id',  $pdv['in_user_id'] );
                            $response[$res_k]['bo_id'] = $bo_data['in_user_id'];
                        }else{
                            $response[$res_k]['bo_id'] = $pdv['in_user_id'];
                        }
                        if( $pdv['st_pickup_type'] == "recurring" ){
                           $is_recurring = "yes";
                        }
                    }

                    if( $is_change == "yes" && $is_pickup == "yes" ){
                        $response[$res_k]['pickup_type'] = ' Change Order and Pickup';
                    }else if( $is_change == "yes" ){
                        $response[$res_k]['pickup_type'] = ' Change Order';
                    }else if( $is_pickup == "yes" ){
                        $response[$res_k]['pickup_type'] = ' Pickup';
                    }
                    if( $is_recurring == "yes" ){
                        $response[$res_k]['recurring'] = "Yes";
                    }
                }
                $response[$res_k]['pickup_list'] = '';
            }

        }
        
        if( isset( $response ) && $response != '' ){
            if( isset( $response['in_pickup_id'] ) ){
                $response = array( $response );
            }
            return $response;
        }
        return '';
    }
    
    public function get_completed_job(){
        global $mydb;
        include_once FL_USER;
        $user = new user();
        $date = date( "Y-m-d" );
        $str_query = 'SELECT DISTINCT j.* FROM ' . $mydb->prefix . TBL_JOB . ' j ,' . $mydb->prefix . TBL_PICKUP 
                .' p WHERE p.in_job_id != 0 AND j.in_job_id = p.in_job_id AND j.st_status = "completed" ';
        $response = $mydb->query( $str_query );
        if( isset( $response ) && $response != '' || $response > 0 ){
            if( isset( $response['in_job_id'] ) ){
                $response = array( $response );
            }
            foreach( $response as $res_k => $res_v ){
                $where = array(
                    'in_job_id' => $res_v['in_job_id']
                );
                $response[$res_k]['pickup_list'] = $mydb->get_all( TBL_PICKUP , '*' , $where );
                if( isset( $response[$res_k]['pickup_list'] ) && $response[$res_k]['pickup_list'] != '' || $response[$res_k]['pickup_list'] > 0 ){
                    if( isset( $response[$res_k]['pickup_list']['in_pickup_id'] ) ){
                        $response[$res_k]['pickup_list'] = array( $response[$res_k]['pickup_list'] );
                    }
                    $response[$res_k]['pickup_count'] = count( $response[$res_k]['pickup_list'] );
                    $response[$res_k]['pickup_sum'] = 0;
                    $is_change = '';
                    $is_pickup = '';
                    $is_recurring = '';
                    foreach( $response[$res_k]['pickup_list'] as $pdk => $pdv ){
                        $response[$res_k]['pickup_sum'] = $pdv['fl_amount'] + $response[$res_k]['pickup_sum'];
                        if( $pdv['st_order_type'] == "change_order" ){
                            $is_change = "yes";
                        }else{
                            $is_pickup = "yes";
                        }
                        if( $pdv['st_order_type'] == "change_order" ){
                            $bo_data = $user->get_bo_data_by( 'in_store_manager_id',  $pdv['in_user_id'] );
                            $response[$res_k]['bo_id'] = $bo_data['in_user_id'];
                        }else{
                            $response[$res_k]['bo_id'] = $pdv['in_user_id'];
                        }
                        if( $pdv['st_pickup_type'] == "recurring" ){
                           $is_recurring = "yes";
                        }
                    }

                    if( $is_change == "yes" && $is_pickup == "yes" ){
                        $response[$res_k]['pickup_type'] = ' Change Order and Pickup';
                    }else if( $is_change == "yes" ){
                        $response[$res_k]['pickup_type'] = ' Change Order';
                    }else if( $is_pickup == "yes" ){
                        $response[$res_k]['pickup_type'] = ' Pickup';
                    }
                    if( $is_recurring == "yes" ){
                        $response[$res_k]['recurring'] = "Yes";
                    }
                }
                $response[$res_k]['pickup_list'] = '';
            }

        }
        if( isset( $response ) && $response != '' ){
            if( isset( $response['in_pickup_id'] ) ){
                $response = array( $response );
            }
            return $response;
        }
        return '';
    }
    
    public function get_pending_assign_pickups(){
        global $mydb;
        include_once FL_USER;
        $user = new user();
        $date = date( "Y-m-d" );
//        $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_job_id != 0 AND in_job_id IN ( SELECT in_job_id FROM ' . $mydb->prefix . TBL_JOB . ' WHERE in_driver_id = 0 )'  ;
//            $response = $mydb->query( $str_query );
        $str_query = 'SELECT DISTINCT j.* FROM ' . $mydb->prefix . TBL_JOB . ' j ,' . $mydb->prefix . TBL_PICKUP 
                .' p WHERE p.in_job_id != 0 AND j.in_job_id = p.in_job_id AND j.in_driver_id = 0 ';
        $response = $mydb->query( $str_query );
        if( isset( $response ) && $response != '' || $response > 0 ){
            if( isset( $response['in_job_id'] ) ){
                $response = array( $response );
            }
            foreach( $response as $res_k => $res_v ){
                $where = array(
                    'in_job_id' => $res_v['in_job_id']
                );
                $response[$res_k]['pickup_list'] = $mydb->get_all( TBL_PICKUP , '*' , $where );
                if( isset( $response[$res_k]['pickup_list'] ) && $response[$res_k]['pickup_list'] != '' || $response[$res_k]['pickup_list'] > 0 ){
                    if( isset( $response[$res_k]['pickup_list']['in_pickup_id'] ) ){
                        $response[$res_k]['pickup_list'] = array( $response[$res_k]['pickup_list'] );
                    }
                    $response[$res_k]['pickup_count'] = count( $response[$res_k]['pickup_list'] );
                    $response[$res_k]['pickup_sum'] = 0;
                    $is_change = '';
                    $is_pickup = '';
                    $is_recurring = '';
                    foreach( $response[$res_k]['pickup_list'] as $pdk => $pdv ){
                        $response[$res_k]['pickup_sum'] = $pdv['fl_amount'] + $response[$res_k]['pickup_sum'];
                        if( $pdv['st_order_type'] == "change_order" ){
                            $is_change = "yes";
                        }else{
                            $is_pickup = "yes";
                        }
                        if( $pdv['st_order_type'] == "change_order" ){
                            $bo_data = $user->get_bo_data_by( 'in_store_manager_id',  $pdv['in_user_id'] );
                            $response[$res_k]['bo_id'] = $bo_data['in_user_id'];
                        }else{
                            $response[$res_k]['bo_id'] = $pdv['in_user_id'];
                        }
                        if( $pdv['st_pickup_type'] == "recurring" ){
                           $is_recurring = "yes";
                        }
                    }

                    if( $is_change == "yes" && $is_pickup == "yes" ){
                        $response[$res_k]['pickup_type'] = ' Change Order and Pickup';
                    }else if( $is_change == "yes" ){
                        $response[$res_k]['pickup_type'] = ' Change Order';
                    }else if( $is_pickup == "yes" ){
                        $response[$res_k]['pickup_type'] = ' Pickup';
                    }
                    if( $is_recurring == "yes" ){
                        $response[$res_k]['recurring'] = "Yes";
                    }
                }
                $response[$res_k]['pickup_list'] = '';
            }

        }
        
        if( isset( $response ) && $response != '' || $response != 0 ){
            if( isset( $response['in_pickup_id'] ) ){
                $response = array( $response );
            }
            return $response;
        }
        return '';
    }
    
    public function get_archive_assign_pickups(){
        global $mydb;
        $date = date( "Y-m-d" );
        $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_job_id = 0 AND  dt_pickup < "' . $date . '" OR in_is_active = 0 ORDER BY in_pickup_id DESC ' ;
        $response = $mydb->query( $str_query );
        if( isset( $response ) && $response != '' || $response != 0 ){
            if( isset( $response['in_pickup_id'] ) ){
                $response = array( $response );
            }
            return $response;
        }
        return '';
    }
    
    public function get_driver_archive_pickups( $user_id = 0 ){
        global $mydb;
        $date = date( "Y-m-d" );
        $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_JOB . ' WHERE ( ( in_driver_id != 0 AND in_driver_id != ' . $user_id . 
                ' && st_admin_assign_type = "all" ) || ( st_status != "completed" && dt_pickup < "' . $date . '" ) ) ORDER BY in_job_id DESC' ;
        $response = $mydb->query( $str_query );
        if( isset( $response ) && $response != '' || $response != 0  ){
            if( isset( $response['in_job_id'] ) ){
                $response = array( $response );
            }
            return $response;
        }
        return '';
    }
    
    public function get_driver_jobs( $driver_id = 0 ){
        if( isset( $driver_id ) && $driver_id != '' ){
            global $mydb;
            $date = date( "Y-m-d" );
            $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_JOB . ' WHERE in_driver_id = ' . $driver_id . 
                    ' AND dt_pickup >= "' . $date . '"  AND st_status != "completed"  AND st_status != "interrupt" ORDER BY in_job_id DESC ';
            $driver_job = $mydb->query( $str_query );
           
            if( isset( $driver_job ) && $driver_job != '' ){
                if( isset( $driver_job['in_job_id'] ) ){
                    $driver_job = array( $driver_job );
                }
                foreach( $driver_job as $job_key => $job_value ){
                    
                    $str_query = 'SELECT max( l.st_location_name ) st_location_name,max( l.st_address ) st_address,p.in_pickup_sort  FROM ' . $mydb->prefix . TBL_LOCATION .
                            ' l, ' . $mydb->prefix . TBL_PICKUP .
                            ' p WHERE p.in_location_id  = l.in_location_id AND p.in_job_id = '. $job_value['in_job_id'] . ' GROUP BY p.in_pickup_sort ';
                    $driver_job[$job_key]['location'] = $mydb->query( $str_query );
                    if( isset( $driver_job[$job_key]['location']['st_location_name'] ) ){
                        $driver_job[$job_key]['location'] = array( $driver_job[$job_key]['location'] );
                    }
                }
                return $driver_job;
            }
        }else{
            return '';
        }
    }
    
    function get_change_order_by_key( $pickup_id, $key = '' ) {
        global $mydb;
        if( isset( $pickup_id ) && trim( $pickup_id ) !== '' && $pickup_id > 0 ){
            $select = '*';
            $where = ' WHERE in_pickup_id = ' . $pickup_id;
            if( isset( $key ) && trim( $key ) !== '' ){
                $select = $key;
            }
            $str_query = 'SELECT ' . $select . ' FROM ' . $mydb->prefix . TBL_CHANGE_ORDER . $where;
            $response = $mydb->query( $str_query );
           
            if ( $response != 0 && count( $response ) > 0 ) { 
                if( trim( $key ) !== '' ){
                    return $response[$key];
                } else {
                    return $response;
                }
            }
        }
    }
    
    function get_change_order_by_id( $pickup_id ) {
        global $mydb;
        if( isset( $pickup_id ) && trim( $pickup_id ) !== '' && $pickup_id > 0 ){
            $select = '*';
            $where = ' WHERE in_pickup_id = ' . $pickup_id;
            
            $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_CHANGE_ORDER . $where;
            $response = $mydb->query( $str_query );
           
            if ( $response != 0 && count( $response ) > 0 ) { 
                return $response;
            }else{
                return 0;
            }
        }
    }
    
    function get_pickup_by_key( $pickup_id, $key = '' ) {
        global $mydb;
        if( isset( $pickup_id ) && trim( $pickup_id ) !== '' && $pickup_id > 0 ){
            $select = '*';
            $where = ' WHERE in_pickup_id = ' . $pickup_id;
            if( isset( $key ) && trim( $key ) !== '' ){
                $select = $key;
            }
            $str_query = 'SELECT ' . $select . ' FROM ' . $mydb->prefix . TBL_PICKUP . $where;
            $response = $mydb->query( $str_query );
           
            if ( $response != 0 && count( $response ) > 0 ) { 
                if( trim( $key ) !== '' ){
                    return $response[$key];
                } else {
                    return $response;
                }
            }
        }
    }
    
    function get_job_by_key( $job_id, $key = '' ){
        global $mydb;
        if( isset( $job_id ) && trim( $job_id ) !== '' && $job_id > 0 ){
            $select = '*';
            $where = ' WHERE in_job_id = ' . $job_id;
            if( isset( $key ) && trim( $key ) !== '' ){
                $select = $key;
            }
            $str_query = 'SELECT ' . $select . ' FROM ' . $mydb->prefix . TBL_JOB . $where;
            $response = $mydb->query( $str_query );
           
            if ( $response != 0 && count( $response ) > 0 ){ 
                if( trim( $key ) !== '' ){
                    return $response[$key];
                } else {
                    return $response;
                }
            }
        }
    }
    public function get_driver_assign_job( $job_id = 0 ){
        if( isset( $job_id ) && $job_id != '' ){
            global $mydb;
            $arr_where_group = array(
                'in_job_id' => $job_id
            );
            $order_data = $mydb->get_all( TBL_ORDER, '*', $arr_where_group );
            if( isset( $order_data ) && $order_data > 0 || $order_data != "" ){
                $order_type = json_decode( $order_data['st_order_no'], true );
               
                foreach( $order_type as $otk => $otv ){
                    if( $otv['type'] == "bank" ){
                        if( $otv['status'] != "completed" ){
                            return $otv;
                        }else{
                            
                        }
                        
                    }else if( $otv['status'] != "completed" ){
                        $str_query = 'SELECT p.* , j.st_status as job_status FROM ' . $mydb->prefix . TBL_PICKUP . ' p , ' .  $mydb->prefix . TBL_JOB  . ' j WHERE p.in_job_id = ' . $job_id . ' AND p.in_job_id = j.in_job_id AND p.st_driver_verify = 0  ORDER BY p.in_pickup_sort,p.in_pickup_id  LIMIT 1';
                        $driver_job = $mydb->query( $str_query );
                        if( isset( $driver_job['in_pickup_id'] ) && isset( $driver_job['st_sm_verify'] ) && $driver_job['st_sm_verify'] == 1 ){
                            $str_query = 'SELECT p.* , j.st_status as job_status FROM ' . $mydb->prefix . TBL_PICKUP . ' p , ' .  $mydb->prefix . TBL_JOB  . ' j  WHERE p.in_job_id = ' . $job_id . ' AND p.in_job_id = j.in_job_id  AND p.st_sm_verify = 1 AND p.st_status != "completed"  ORDER BY p.in_pickup_id  LIMIT 1';
                            $driver_job = $mydb->query( $str_query );
                        }
                       
                        if( isset( $driver_job ) && $driver_job != '' ){
                            $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_LOCATION .
                                    ' WHERE in_location_id in ( SELECT in_location_id FROM '  . 
                                    $mydb->prefix . TBL_PICKUP . ' WHERE in_pickup_id = '. $driver_job['in_pickup_id'] . ')';
                            $driver_job['location'] = $mydb->query( $str_query );
                            if( isset( $driver_job['in_pickup_id'] ) ){
                                $loc_id = $driver_job['location']['in_location_id'];
                                $pickup_sort = $driver_job['in_pickup_sort'] + 1;
                                $order_type = $driver_job['st_order_type'];
                                $driver_job = array( $driver_job );   
                            }
                        
                            $str_query = 'SELECT p.in_pickup_id FROM ' . $mydb->prefix . TBL_PICKUP . ' p , ' .  $mydb->prefix . TBL_JOB  . ' j WHERE p.in_job_id = ' . $job_id . ' AND p.in_job_id = j.in_job_id AND p.st_driver_verify = 0 AND p.in_location_id = ' . $loc_id . ' AND p.in_pickup_sort = ' . $pickup_sort;
                            $pick_data = $mydb->query( $str_query );
                            
                            if( isset( $pick_data ) && $pick_data != ''  ){
                                $driver_job[0]['same_location'] = $pick_data['in_pickup_id'];
                            }else{
                                $driver_job[0]['same_location'] = '0';
                            }  
                            return $driver_job;
                        }
                    }
                } 
            }  
        }else{
            return '';
        }
    }

    public function sm_verify_driver_info( $data ){
        global $mydb;
        $liecense_id = isset( $data['txt_liecense_id'] ) &&  $data['txt_liecense_id'] != '' ?  trim($data['txt_liecense_id']) : '';
        $amount = isset( $data['txt_amount'] ) &&  $data['txt_amount'] > 0 ?  $data['txt_amount'] : '';
        $store_id = isset( $data['txt_store_id'] ) &&  $data['txt_store_id'] != '' ?  $data['txt_store_id'] : '';
        $txt_note = isset( $data['txt_note'] ) &&  $data['txt_note'] != ''?  $data['txt_note'] : '';
        $user_id = isset( $data['user_id'] ) &&  $data['user_id'] > 0 ?  $data['user_id'] : '';
        $job_id = isset( $data['id'] ) &&  $data['id'] > 0 ?  $data['id'] : '';
        $pickup_id = isset( $data['pickup_id'] ) &&  $data['pickup_id'] > 0 ?  $data['pickup_id'] : '';
        $same_loc_id = isset( $data['same_loc_id'] ) &&  $data['same_loc_id'] > 0 ?  $data['same_loc_id'] : '';
        if( isset( $liecense_id ) ){
            include_once FL_USER;
            $user = new user();
            include_once FL_LOCATION;
            $location = new location();
            $driver_id = $this->get_job_by_key( $job_id, 'in_driver_id' );
            if( isset( $driver_id ) && $driver_id > 0 ){
                $license_no = $user->get_driver_data_by_key( $driver_id, 'in_license_no' );
                $location_id = $this->get_pickup_by_key( $pickup_id, 'in_location_id' );
                $st_store_id = $location->get_location_by_key( $location_id, 'st_store_id' );
                if( isset( $license_no ) && $license_no == $liecense_id &&  isset( $st_store_id ) && $st_store_id == $store_id ){
                    $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_job_id = ' . $job_id .
                            ' AND st_sm_verify = 0  AND in_pickup_id = ' . $pickup_id . ' ORDER BY in_pickup_id  LIMIT 1';
                    $driver_job = $mydb->query( $str_query );
                    $update_id = $this->update_pickupdata( $driver_job['in_pickup_id'], 'fl_sm_amount', $amount );
                    $update_id = $this->update_pickupdata( $driver_job['in_pickup_id'], 'st_sm_note', $txt_note );
                    $update_id = $this->update_pickupdata( $driver_job['in_pickup_id'], 'st_sm_verify', 1 );
                    
                    if( $same_loc_id > 0 ){
                        $update_id = $this->update_pickupdata( $same_loc_id, 'fl_sm_amount', $amount );
                        $update_id = $this->update_pickupdata( $same_loc_id, 'st_sm_note', $txt_note );
                        $update_id = $this->update_pickupdata( $same_loc_id, 'st_sm_verify', 1 );
                    }
                    return $update_id;
                }
            }else{
                return -1;
            }
        }else{
            return 0;
        }
    }
    
    public function verify_driver_sm_info( $data ){
        global $mydb;
        $liecense_id = isset( $data['txt_liecense_id'] ) &&  $data['txt_liecense_id'] != '' ?  trim($data['txt_liecense_id']) : '';
        $amount = isset( $data['txt_amount'] ) &&  $data['txt_amount'] > 0 ?  $data['txt_amount'] : '';
        $store_id = isset( $data['txt_store_id'] ) &&  $data['txt_store_id'] != '' ?  $data['txt_store_id'] : '';
        $txt_note = isset( $data['txt_note'] ) &&  $data['txt_note'] != ''?  $data['txt_note'] : '';
        $user_id = isset( $data['user_id'] ) &&  $data['user_id'] > 0 ?  $data['user_id'] : '';
        $job_id = isset( $data['id'] ) &&  $data['id'] > 0 ?  $data['id'] : '';
        $pickup_id = isset( $data['pickup_id'] ) &&  $data['pickup_id'] > 0 ?  $data['pickup_id'] : '';
        $same_loc_id = isset( $data['same_loc_id'] ) &&  $data['same_loc_id'] > 0 ?  $data['same_loc_id'] : '';
        if( isset( $liecense_id ) ){
            include_once FL_USER;
            $user = new user();
            include_once FL_LOCATION;
            $location = new location();
            $driver_id = $this->get_job_by_key( $job_id, 'in_driver_id' );
            if( isset( $driver_id ) && $driver_id > 0 ){
                $license_no = $user->get_driver_data_by_key( $driver_id, 'in_license_no' );
                $location_id = $this->get_pickup_by_key( $pickup_id, 'in_location_id' );
                $st_store_id = $location->get_location_by_key( $location_id, 'st_store_id' );
                if( isset( $license_no ) && $license_no == $liecense_id &&  isset( $st_store_id ) && $st_store_id == $store_id ){
                    return 1;
                }
            }else{
                return -1;
            }
        }else{
            return 0;
        }
    }
    
    public function check_verify_sm( $job_id = 0, $key = '' , $verified = 0, $pickup_id = 0 ){
        
        if( isset( $job_id ) && $job_id > 0 ){
            global $mydb;
            $str_pickup = '';
            if( isset( $pickup_id ) && $pickup_id > 0 ){
                $str_pickup = ' AND in_pickup_id = ' . $pickup_id . '';
            }
            $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_job_id = ' . $job_id .
                    ' AND st_sm_verify = "' . $verified . '" AND st_sm_link = "' . $key . '" ' . $str_pickup . '  ORDER BY in_pickup_id  LIMIT 1';
            $driver_job = $mydb->query( $str_query );
        }
        if( isset( $driver_job ) ){
            return $driver_job;
        }else{
            return '';
        }
    }
    
    public function change_driver_job_status( $data ){
//        print_r($data);
        $job_id = isset( $data['job_id'] ) &&  $data['job_id'] > 0 ?  $data['job_id'] : '';
        $pickup_id = isset( $data['pick_id'] ) &&  $data['pick_id'] > 0 ?  $data['pick_id'] : '';
        $pickup_status = isset( $data['pickup_status'] ) &&  $data['pickup_status'] != '' ?  $data['pickup_status'] : '';
        $job_status = isset( $data['job_status'] ) &&  $data['job_status'] != ''?  $data['job_status'] : '';
        $key = isset( $data['pickup_code'] ) &&  $data['pickup_code'] != ''?  $data['pickup_code'] : '';
        $same_loc_pick_id =  isset( $data['same_loc_pick_id'] ) &&  trim( $data['same_loc_pick_id'] ) != '' ?  trim( $data['same_loc_pick_id'] ) : '';
        $s_lid = ( $same_loc_pick_id != 0 ) ? $same_loc_pick_id : '0';
        if( isset( $job_id ) && isset( $pickup_id ) && isset( $job_status ) && isset( $pickup_status ) &&
            $job_id > 0 && $pickup_id > 0 && $job_status != '' && $pickup_status != '' ){
            global $mydb;
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            include_once FL_USER;
            $user = new user();
            include_once FL_LOCATION;
            $location = new location();
            include_once FL_ACTIVITY;
            $activity = new activity();
            if ( !session_id() ) {
                session_start();
            }
            $user_driver_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 ? $_SESSION['user_id'] : '';
            
            if( $pickup_status == "completed" ){
                $txt_manager_name = isset( $data['txt_manager_name'] ) &&  $data['txt_manager_name'] != ''?  $data['txt_manager_name'] : '';
                $txt_license_no = isset( $data['txt_license_no'] ) &&  $data['txt_license_no'] != ''?  $data['txt_license_no'] : '';
                $pickup_note = isset( $data['pickup_note'] ) &&  $data['pickup_note'] != ''?  $data['pickup_note'] : '';

                $where_pickup = array(
                    'in_pickup_id' => $pickup_id
                );
                $pickup_data = $mydb->get_all( TBL_PICKUP, '*', $where_pickup );
                $store_id = $location->get_location_by_key( $pickup_data['in_location_id'], 'st_store_id' );
                $in_license_no = $user->get_driver_data_by_key( $user_driver_id, 'in_license_no' );
//                if( $pickup_code_id == $pickup_data['st_veriry_code'] && $store_id == $pickup_store_id ){
                if( isset( $pickup_data['st_sm_verify'] ) && $pickup_data['st_sm_verify'] == 1 ){
                    if( $txt_manager_name != "" &&  $txt_license_no  != "" ){
                        $end_time = date( "Y-m-d H:i:s" );
                        $arr_job = array(
                            'st_status' => $job_status
                        );
                        $where_job = array(
                            'in_job_id' => $job_id
                        );
                        $update_job = $mydb->update( TBL_JOB, $arr_job, $where_job );
                        $arr_pickup = array(
                            'st_status' => $pickup_status,
                            'st_driver_note' => $pickup_note,
                            'st_driver_verify' => 1,
                            'dt_end_time' => $end_time,
                            'st_sm_license' => $txt_license_no,
                            'st_sm_name' => $txt_manager_name
                        );
                        $where_pickup = array(
                            'in_pickup_id' => $pickup_id
                        );
                        $update_pickup = $mydb->update( TBL_PICKUP, $arr_pickup, $where_pickup );
                        if( $same_loc_pick_id !=0 ){
                            $where_pickup = array(
                                'in_pickup_id' => $same_loc_pick_id
                            );
                            $mydb->update( TBL_PICKUP, $arr_pickup, $where_pickup );
                        } 
                        $str_query = 'SELECT in_pickup_id FROM ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_job_id = ' . $job_id .
                        ' ORDER BY in_pickup_sort DESC  LIMIT 1';
                        $driver_job = $mydb->query( $str_query );
                        $order_status_id = $this->driver_mid_point_status( $job_id,$pickup_id );
                        if( isset( $driver_job['in_pickup_id'] ) && $driver_job['in_pickup_id'] == $pickup_id ){
                            $activity_data = $activity->get_activity_by_data( $job_id, '-1', 'start' );
                            if( $activity_data && $activity_data != '' ){
                                
                            }else{
                                $updateid = $activity->add_activity( $job_id, '-1', 'start' );
                            }
                        }
                        return $update_pickup;
                    }
                    return -1;
                }else{
                    return -2;
                }
            }else if( $pickup_status == "onroute" ){
                $where_pickup = array(
                    'in_pickup_id' => $pickup_id
                );
                $pickup_data = $mydb->get_all( TBL_PICKUP, '*', $where_pickup );
                $arr_job = array(
                    'st_status' => $job_status
                );
                $where_job = array(
                    'in_job_id' => $job_id
                );
                $update_job = $mydb->update( TBL_JOB, $arr_job, $where_job );
                $arr_pickup = array(
                    'st_status' => $pickup_status
                );

                $update_pickup = $mydb->update( TBL_PICKUP, $arr_pickup, $where_pickup );
                $update_job = $update_pickup;
                $order_status_id = $this->driver_mid_point_status( $job_id,$pickup_id );
                if( $same_loc_pick_id !=0 ){
                    $where_pickup = array(
                        'in_pickup_id' => $same_loc_pick_id
                    );
                    $mydb->update( TBL_PICKUP, $arr_pickup, $where_pickup );
                } 
                
                if( isset( $update_pickup ) && $update_pickup > 0 ){
                    $arrival_time = date( "Y-m-d H:i:s" );
                    if( isset( $pickup_data['st_order_type'] ) && $pickup_data['st_order_type'] == "change_order" ){
                        $sm_email_id = $user->get_user_data_by_key( $pickup_data['in_manager_id'], 'st_email_id' );
                        $sm_name = $user->get_user_data_by_key( $pickup_data['in_manager_id'], 'st_first_name' );
                        $boid = $user->get_bo_data_by( 'in_user_id',$pickup_data['in_user_id'] );
                        $bo_email_id = $user->get_user_data_by_key( $boid['in_user_id'], 'st_email_id' );
                        $bo_name = $user->get_user_data_by_key( $boid['in_user_id'], 'st_first_name' );
                        $location_name = $location->get_location_by_key( $pickup_data['in_location_id'], 'st_address' );
                        $store_id = $location->get_location_by_key( $pickup_data['in_location_id'], 'st_store_id' );
                        $bo_mail_data = array( "user_name" => $bo_name,
                            "pickup_id" => $location_name );

                        $current_time = time();
                        $key = md5( $store_id . $pickup_data['in_user_id'] . $current_time );

                        $where = array( 
                            'in_pickup_id' => $pickup_id
                        );
                        $set = array(  
                            'st_sm_link' => $key,
                            'dt_start_time' => $arrival_time
                        );
                        $update_key = $mydb->update( TBL_PICKUP, $set, $where );
                        if( $same_loc_pick_id !=0 ){
                            $where_pickup = array(
                                'in_pickup_id' => $same_loc_pick_id
                            );
                            $mydb->update( TBL_PICKUP, $set, $where_pickup );
                        } 
                        $updatemeta_key = $user->update_usermeta( $pickup_data['in_user_id'] , 'driver_verify_sm_link', $key );
                        $sm_mail_data = array( 
                            "user_name" => $sm_name,
                            "location_name" => $location_name,
                            "base_url" => SITE_NAME ,
                            "link" => VW_SM_VERIFY . '?key=' . $key . '&id=' . $job_id . '&p_id=' . $pickup_id . '&s_lid=' . $s_lid );
                        $email_sm_templet = $template->get_template( 'email', '', 'driver_start_sm_mail', TRUE );
//                        $email_bo_templet = $template->get_template( 'email', '', 'driver_start_bo_mail', TRUE );
//                        if ( MAIL_MODE == 'test' ) {
//                            $bo_emailid = TEST_EMAIL;
//                        } else {
//                            $bo_emailid = $bo_email_id;
//                        }
                        if ( MAIL_MODE == 'test' ) {
                            $sm_emailid = TEST_EMAIL;
                        } else {
                            $sm_emailid = $sm_email_id;
                        }
//                        $user->send_mail_by_template( $boid['in_user_id'], $bo_emailid, 'Cop Express - Driver Arrived from the location: '. $location_name . '', $email_bo_templet, $bo_mail_data );
                        $user->send_mail_by_template( $pickup_data['in_manager_id'], $sm_emailid, SITE_NAME . ' - Driver arrived from the location: : '. $location_name . '', $email_sm_templet, $sm_mail_data );

                    }else{
                        $sm_email_id = $user->get_user_data_by_key( $pickup_data['in_manager_id'], 'st_email_id' );
                        $sm_name = $user->get_user_data_by_key( $pickup_data['in_manager_id'], 'st_first_name' );
                        $location_name = $location->get_location_by_key( $pickup_data['in_location_id'], 'st_address' );
                        $store_id = $location->get_location_by_key( $pickup_data['in_location_id'], 'st_store_id' );
                        
                        $current_time = time();
                        $key = md5( $store_id . $pickup_data['in_manager_id'] . $current_time );

                        $where = array( 
                            'in_pickup_id' => $pickup_id
                        );
                        $set = array(  
                            'st_sm_link' => $key,
                            'dt_start_time' => $arrival_time
                        );
                        $update_key = $mydb->update( TBL_PICKUP, $set, $where );
                        if( $same_loc_pick_id !=0 ){
                            $where_pickup = array(
                                'in_pickup_id' => $same_loc_pick_id
                            );
                            $mydb->update( TBL_PICKUP, $set, $where_pickup );
                        } 
                        $updatemeta_key = $user->update_usermeta( $pickup_data['in_manager_id'] , 'driver_verify_sm_link', $key );
                        $sm_mail_data = array( "user_name" => $sm_name,
                            "base_url" => SITE_NAME ,
                            "location_name" => $location_name,
                            "link" => VW_SM_VERIFY . '?key=' . $key . '&id=' . $job_id . '&p_id=' . $pickup_id . '&s_lid=' . $s_lid );
                        $email_sm_templet = $template->get_template( 'email', '', 'driver_start_sm_mail', TRUE );
//                        $email_bo_templet = $template->get_template( 'email', '', 'driver_start_bo_mail', TRUE );
//                        if ( MAIL_MODE == 'test' ) {
//                            $bo_emailid = TEST_EMAIL;
//                        } else {
//                            $bo_emailid = $bo_email_id;
//                        }
                        if ( MAIL_MODE == 'test' ){
                            $sm_emailid = TEST_EMAIL;
                        } else {
                            $sm_emailid = $sm_email_id;
                        }
//                        $user->send_mail_by_template( $pickup_data['in_user_id'], $bo_emailid, 'Cop Express - Driver Arrived from the location: '. $location_name . '', $email_bo_templet, $bo_mail_data );
                        $user->send_mail_by_template( $pickup_data['in_manager_id'], $sm_emailid, 'Cop Express - Driver arrived from the location: '. $location_name . '', $email_sm_templet, $sm_mail_data );
                    }
                    return $update_pickup;
                }else{
                    return 0;
                }
            }else{
                $start_time = date( "Y-m-d H:i:s" );
                $arr_pickup = array(
                    'st_status' => $pickup_status,
                    'dt_arrival_time' => $start_time
                );
                $where_pickup = array(
                    'in_pickup_id' => $pickup_id
                );
                $update_job = $mydb->update( TBL_PICKUP, $arr_pickup, $where_pickup );
                if( $same_loc_pick_id !=0 ){
                    $where_pickup = array(
                        'in_pickup_id' => $same_loc_pick_id
                    );
                    $mydb->update( TBL_PICKUP, $arr_pickup, $where_pickup );
                } 
            }
            if( isset( $update_job ) && $update_job > 0  ){
                return $update_job;
            }else{
                return 0;
            }
        }else{
            return 0;
        }  
    }

    public function ch_arrived_at_bank( $job_id ) {
        if( isset( $job_id ) && $job_id != '' ){
            global $mydb;
            include_once FL_USER;
            $user = new user();
            include_once FL_LOCATION;
            $location = new location();
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            $driver_job = $this->get_driver_assign_job( $job_id );
            
            foreach( $driver_job as $d_job ){
                $s_lid = ( isset( $d_job['same_location']) && $d_job['same_location'] > 0 ) ? $d_job['same_location'] : '0';
                
                $start_time = date( "Y-m-d H:i:s" );
                $where_pickup = array(
                    'in_pickup_id' => $d_job['in_pickup_id']
                );
                $pickup_data = $mydb->get_all( TBL_PICKUP, '*', $where_pickup );
                $arr_job = array(
                    'st_status' => "in_progress",
                    'dt_start_time' => $start_time
                );
                $where_job = array(
                    'in_job_id' => $job_id
                );
                $update_job = $mydb->update( TBL_JOB, $arr_job, $where_job );
                $arr_pickup = array(
                    'st_status' => "onroute"
                );
                $order_status_id = $this->driver_mid_point_status( $job_id,$d_job['in_pickup_id'] );
                $update_pickup = $mydb->update( TBL_PICKUP, $arr_pickup, $where_pickup );
                if( $s_lid !=0 ){
                    $where_pickup = array(
                        'in_pickup_id' => $s_lid
                    );
                    $mydb->update( TBL_PICKUP, $arr_pickup, $where_pickup );
                } 
                if( isset( $update_pickup ) && $update_pickup > 0 ){
                    if( isset( $d_job['st_order_type'] ) &&  $d_job['st_order_type'] == "change_order" ){
                        $sm_email_id = $user->get_user_data_by_key( $d_job['in_manager_id'], 'st_email_id' );
                        $sm_name = $user->get_user_data_by_key( $d_job['in_manager_id'], 'st_first_name' );
//                        $boid = $user->get_bo_data_by( 'in_store_manager_id',$d_job['in_user_id'] );
//                        $bo_email_id = $user->get_user_data_by_key( $boid['in_user_id'], 'st_email_id' );
//                        $bo_name = $user->get_user_data_by_key( $boid['in_user_id'], 'st_first_name' );
                        $location_name = $location->get_location_by_key( $d_job['in_location_id'], 'st_address' );
                        $store_id = $location->get_location_by_key( $d_job['in_location_id'], 'st_store_id' );
//                        $bo_mail_data = array( 
//                                    "user_name" => $bo_name,
//                                    "pickup_id" => $location_name 
//                                );

                        $current_time = time();
                        $key = md5( $store_id . $d_job['in_user_id'] . $current_time );

                        $where = array( 
                            'in_pickup_id' => $d_job['in_pickup_id']
                        );

                        $set = array(  
                            'st_sm_link' => $key,
                            'dt_start_time' => $start_time
                        );
                        $update_key = $mydb->update( TBL_PICKUP, $set, $where );
                        if( $s_lid != 0 ){
                            $where_pickup = array(
                                'in_pickup_id' => $s_lid
                            );
                            $mydb->update( TBL_PICKUP, $set, $where_pickup );
                        }
                        $updatemeta_key = $user->update_usermeta( $d_job['in_user_id'] , 'driver_verify_sm_link', $key );
                        $sm_mail_data = array( "user_name" => $sm_name,
                            "location_name" => $location_name,
                            "base_url" => SITE_NAME,
                            "link" => VW_SM_VERIFY . '?key=' . $key . '&id=' . $job_id . '&p_id=' . $d_job['in_pickup_id'] . '&s_lid=' . $s_lid );
                        $email_sm_templet = $template->get_template( 'email', '', 'driver_start_sm_mail', TRUE );
//                        $email_bo_templet = $template->get_template( 'email', '', 'driver_start_bo_mail', TRUE );
//                        if ( MAIL_MODE == 'test' ) {
//                            $bo_emailid = TEST_EMAIL;
//                        } else {
//                            $bo_emailid = $bo_email_id;
//                        }
                        if ( MAIL_MODE == 'test' ) {
                            $sm_emailid = TEST_EMAIL;
                        } else {
                            $sm_emailid = $sm_email_id;
                        }
//                        $user->send_mail_by_template( $boid['in_user_id'], $bo_emailid, 'Cop Express - Driver Arrived from the location: '. $location_name . '', $email_bo_templet, $bo_mail_data );
                        $user->send_mail_by_template( $d_job['in_manager_id'], $sm_emailid, 'Cop Express - Driver arrived from the location: '. $location_name . '', $email_sm_templet, $sm_mail_data );

                    }else{
                        $sm_email_id = $user->get_user_data_by_key( $d_job['in_manager_id'], 'st_email_id' );
                        $sm_name = $user->get_user_data_by_key( $d_job['in_manager_id'], 'st_first_name' );
//                        $bo_email_id = $user->get_user_data_by_key( $d_job['in_user_id'], 'st_email_id' );
//                        $bo_name = $user->get_user_data_by_key( $d_job['in_user_id'], 'st_first_name' );
                        $location_name = $location->get_location_by_key( $d_job['in_location_id'], 'st_address' );
                        $store_id = $location->get_location_by_key( $d_job['in_location_id'], 'st_store_id' );
//                        $bo_mail_data = array( 
//                            "user_name" => $bo_name,
//                            "pickup_id" => $location_name 
//                                );

                        $current_time = time();
                        $key = md5( $store_id . $d_job['in_manager_id'] . $current_time );

                        $where = array( 
                            'in_pickup_id' => $d_job['in_pickup_id']
                        );

                        $set = array(  
                            'st_sm_link' => $key,
                            'dt_start_time' => $start_time
                        );
                        $update_key = $mydb->update( TBL_PICKUP, $set, $where );
                        if( $s_lid != 0 ){
                            $where_pickup = array(
                                'in_pickup_id' => $s_lid
                            );
                            $mydb->update( TBL_PICKUP, $set, $where_pickup );
                        }
                        $updatemeta_key = $user->update_usermeta( $d_job['in_manager_id'] , 'driver_verify_sm_link', $key );
                        $sm_mail_data = array( "user_name" => $sm_name,
                            "location_name" => $location_name,
                            "base_url" => SITE_NAME,
                            "link" => VW_SM_VERIFY . '?key=' . $key . '&id=' . $job_id . '&p_id=' . $d_job['in_pickup_id'] . '&s_lid=' . $s_lid );
                        $email_sm_templet = $template->get_template( 'email', '', 'driver_start_sm_mail', TRUE );
//                        $email_bo_templet = $template->get_template( 'email', '', 'driver_start_bo_mail', TRUE );
//                        if ( MAIL_MODE == 'test' ) {
//                            $bo_emailid = TEST_EMAIL;
//                        } else {
//                            $bo_emailid = $bo_email_id;
//                        }
                        if ( MAIL_MODE == 'test' ) {
                            $sm_emailid = TEST_EMAIL;
                        } else {
                            $sm_emailid = $sm_email_id;
                        }
//                        $user->send_mail_by_template( $d_job['in_user_id'], $bo_emailid, 'Cop Express - Driver Arrived from the location: '. $location_name . '', $email_bo_templet, $bo_mail_data );
                        $user->send_mail_by_template( $d_job['in_manager_id'], $sm_emailid, 'Cop Express - Driver arrived from the location: '. $location_name . '', $email_sm_templet, $sm_mail_data );
                    }
                    return $update_pickup;
                }else{
                    return 0;
                }
            }
            if( isset( $driver_job ) && $driver_job != '' ){
                return $driver_job;
            }
        }else{
            return '';
        }
    }
    
    public function check_ch_bank_job( $job_id ) {
        if( isset( $job_id ) && $job_id != '' ){
            global $mydb;
            $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_PICKUP . '  p, ' . $mydb->prefix . TBL_JOB .
                    ' j  WHERE j.in_job_id = ' . $job_id . ' AND j.st_status = "start" AND p.in_job_id = ' . $job_id . ' AND p.st_order_type = "change_order"  GROUP BY p.st_order_type ORDER BY p.in_pickup_sort,p.in_pickup_id  LIMIT 1';
            $driver_job = $mydb->query( $str_query );
            
            if( isset( $driver_job ) && $driver_job != '' ){
                return $driver_job;
            }
        }else{
            return '';
        }
    }
    
    public function check_pickup_exists_job( $job_id ) {
        if( isset( $job_id ) && $job_id != '' ){
            global $mydb;
            $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_job_id = ' . $job_id . ' AND st_order_type IS NULL ';
            $driver_job = $mydb->query( $str_query );
            
            if( isset( $driver_job ) && $driver_job > 0 ){
                return $driver_job;
            }
        }else{
            return 0;
        }
    }
    
    public function get_job_bank_data( $job_id = 0, $type = '' ){
        if( isset( $job_id ) && $job_id > 0 ){
            global $mydb;
            include_once FL_SETTINGS;
            $settings = new settings();
            $bo_bank_address = $settings->get_settings( 'bo_bank_address' , TRUE );
            $bo_latitude = $settings->get_settings( 'bo_latitude' , TRUE );
            $bo_longitude = $settings->get_settings( 'bo_longitude' , TRUE );
            
            if( isset( $type ) && $type != '' && $type == 'change_order' ){
                $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_BUSINESS_OWNER . 
                        ' WHERE in_user_id IN ( SELECT in_user_id FROM ' . $mydb->prefix . TBL_PICKUP . 
                        ' WHERE in_job_id = ' . $job_id . ' AND st_order_type = "change_order" )';
                $bank_data = $mydb->query( $str_query );
                if( isset( $bank_data ) && $bank_data != "" || $bank_data > 0){
                    if( isset( $bank_data['in_user_id'] ) ){
                        if( $bank_data['st_add'] == "" ){
                            $bank_data['st_add'] = $bo_bank_address;
                            $bank_data['in_latitude'] = $bo_latitude;
                            $bank_data['in_longitude'] = $bo_longitude;
                        }
                        $bank_data['st_type'] = "bank";
                    }else{
                        $bank_data['st_type'] = "bank";
                        $bank_data['st_add'] = $bo_bank_address;
                        $bank_data['in_latitude'] = $bo_latitude;
                        $bank_data['in_longitude'] = $bo_longitude;
                    }
                }
            }else{
                $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_BUSINESS_OWNER . ' WHERE in_user_id IN ( SELECT in_user_id FROM ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_job_id = ' . $job_id . ')';
                $bank_data = $mydb->query( $str_query );
            }
            if( isset( $bank_data ) && $bank_data != '' ){
                return $bank_data;
            }else{
                return 0;
            }
        }
    }
    
    
    public function get_pending_driver_jobs(){
        
        global $mydb;
        $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_JOB . ' WHERE in_driver_id = 0 AND st_status = "pending" ORDER BY in_job_id DESC ';
        $driver_job = $mydb->query( $str_query );

        if( isset( $driver_job ) && $driver_job != '' ){
            if( isset( $driver_job['in_job_id'] ) ){
                $driver_job = array( $driver_job );
            }
            foreach( $driver_job as $job_key => $job_value ){
                $str_query = 'SELECT max( l.st_location_name ) st_location_name,max( l.st_address ) st_address,p.in_pickup_sort  FROM ' . $mydb->prefix . TBL_LOCATION .
                        ' l, ' . $mydb->prefix . TBL_PICKUP .
                        ' p WHERE p.in_location_id  = l.in_location_id AND p.in_job_id = '. $job_value['in_job_id'] . ' GROUP BY p.in_pickup_sort ';
                $driver_job[$job_key]['location'] = $mydb->query( $str_query );
                if( isset( $driver_job[$job_key]['location']['st_location_name'] ) ){
                    $driver_job[$job_key]['location'] = array( $driver_job[$job_key]['location'] );
                }
            }
            return $driver_job;
        }else{
            return '';
        }
    }
    
    public function get_job_address_data( $job_id = 0, $type = '', $ar_type = '' ){
        if( isset( $job_id ) && $job_id > 0 ){
            global $mydb;
            include_once FL_USER;
            $user = new user();
            include_once FL_SETTINGS;
            $settings = new settings();
            $bo_bank_address = $settings->get_settings( 'bo_bank_address' , TRUE );
            $bo_latitude = $settings->get_settings( 'bo_latitude' , TRUE );
            $bo_longitude = $settings->get_settings( 'bo_longitude' , TRUE );
            
            
            
            if( isset( $type ) && $type != '' && $type == 'change_order' ){
                $last_address_type = $this->get_job_by_key( $job_id, 'st_bo_first_address' );
                $st_ar_type = '';
                if( isset( $ar_type ) && $ar_type != "" ){
                    $last_address_type = $ar_type;
                }
                if( isset( $last_address_type ) && $last_address_type == "home" ){
                    $str_query = 'SELECT in_user_id FROM ' . $mydb->prefix . TBL_BUSINESS_OWNER . 
                            ' WHERE in_user_id IN ( SELECT in_user_id FROM ' . $mydb->prefix . TBL_PICKUP . 
                            ' WHERE in_job_id = ' . $job_id . ' AND st_order_type = "change_order" )';
                    $response = $mydb->query( $str_query );
                    
                    $bank_data['st_type'] = "home";
                    $bank_data['st_add'] = $user->get_user_meta( $response['in_user_id'] , 'st_bo_home_address', TRUE );
                    $bank_data['in_latitude'] = $user->get_user_meta( $response['in_user_id'] , 'st_bo_home_lat', TRUE );
                    $bank_data['in_longitude'] = $user->get_user_meta( $response['in_user_id'] , 'st_bo_home_long', TRUE );
                }else if( isset( $last_address_type ) && $last_address_type == "warehouse" ){
                    $str_query = 'SELECT in_user_id FROM ' . $mydb->prefix . TBL_BUSINESS_OWNER . 
                            ' WHERE in_user_id IN ( SELECT in_user_id FROM ' . $mydb->prefix . TBL_PICKUP . 
                            ' WHERE in_job_id = ' . $job_id . ' AND st_order_type = "change_order" )';
                    $response = $mydb->query( $str_query );
                    $bank_data['st_type'] = "warehouse";
                    $bank_data['st_add'] = $user->get_user_meta( $response['in_user_id'] , 'st_bo_warehouse_address', TRUE );
                    $bank_data['in_latitude'] = $user->get_user_meta( $response['in_user_id'] , 'st_bo_warehouse_lat', TRUE );
                    $bank_data['in_longitude'] = $user->get_user_meta( $response['in_user_id'] , 'st_bo_warehouse_long', TRUE );
                }else if( isset( $last_address_type ) && $last_address_type == "other" ){
                    $st_address = $this->get_job_by_key( $job_id, 'st_ch_other_address' );
                    $in_latitude = $this->get_job_by_key( $job_id, 'in_ch_other_latitude' );
                    $in_longitude = $this->get_job_by_key( $job_id, 'in_ch_other_longitude' );
                    $bank_data['st_type'] = "Other";
                    $bank_data['st_add'] = $st_address;
                    $bank_data['in_latitude'] = $in_latitude;
                    $bank_data['in_longitude'] = $in_longitude;
                }else{
                    
                    $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_BUSINESS_OWNER . 
                            ' WHERE in_user_id IN ( SELECT in_user_id FROM ' . $mydb->prefix . TBL_PICKUP . 
                            ' WHERE in_job_id = ' . $job_id . ' AND st_order_type = "change_order" )';
                    $bank_data = $mydb->query( $str_query );
                    
                    if( isset( $bank_data['in_user_id'] ) ){
                        if( $bank_data['st_add'] == "" ){
                            $bank_data['st_add'] = $bo_bank_address;
                            $bank_data['in_latitude'] = $bo_latitude;
                            $bank_data['in_longitude'] = $bo_longitude;
                        }
                        $bank_data['st_type'] = "bank";
                    }else{
                        $bank_data['st_type'] = "bank";
                        $bank_data['st_add'] = $bo_bank_address;
                        $bank_data['in_latitude'] = $bo_latitude;
                        $bank_data['in_longitude'] = $bo_longitude;
                    }
                }
            }else{
                $last_address_type = $this->get_job_by_key( $job_id, 'st_bo_last_address' );
                $st_ar_type = '';
                if( isset( $ar_type ) && $ar_type != "" ){
                    $last_address_type = $ar_type;
                }
                if( isset( $last_address_type ) && $last_address_type == "home" ){
                    $str_query = 'SELECT in_user_id FROM ' . $mydb->prefix . TBL_BUSINESS_OWNER . 
                            ' WHERE in_user_id IN ( SELECT in_user_id FROM ' . $mydb->prefix . TBL_PICKUP . 
                            ' WHERE in_job_id = ' . $job_id . ' )';
                    $response = $mydb->query( $str_query );
                    
                    $bank_data['st_type'] = "home";
                    $bank_data['st_add'] = $user->get_user_meta( $response['in_user_id'] , 'st_bo_home_address', TRUE );
                    $bank_data['in_latitude'] = $user->get_user_meta( $response['in_user_id'] , 'st_bo_home_lat', TRUE );
                    $bank_data['in_longitude'] = $user->get_user_meta( $response['in_user_id'] , 'st_bo_home_long', TRUE );
                }else if( isset( $last_address_type ) && $last_address_type == "warehouse" ){
                    $str_query = 'SELECT in_user_id FROM ' . $mydb->prefix . TBL_BUSINESS_OWNER . 
                            ' WHERE in_user_id IN ( SELECT in_user_id FROM ' . $mydb->prefix . TBL_PICKUP . 
                            ' WHERE in_job_id = ' . $job_id . '  )';
                    $response = $mydb->query( $str_query );
                    $bank_data['st_type'] = "warehouse";
                    $bank_data['st_add'] = $user->get_user_meta( $response['in_user_id'] , 'st_bo_warehouse_address', TRUE );
                    $bank_data['in_latitude'] = $user->get_user_meta( $response['in_user_id'] , 'st_bo_warehouse_lat', TRUE );
                    $bank_data['in_longitude'] = $user->get_user_meta( $response['in_user_id'] , 'st_bo_warehouse_long', TRUE );
                }else if( isset( $last_address_type ) && $last_address_type == "other" ){
                    $st_address = $this->get_job_by_key( $job_id, 'st_address' );
                    $in_latitude = $this->get_job_by_key( $job_id, 'in_latitude' );
                    $in_longitude = $this->get_job_by_key( $job_id, 'in_longitude' );
                    $bank_data['st_type'] = "Other";
                    $bank_data['st_add'] = $st_address;
                    $bank_data['in_latitude'] = $in_latitude;
                    $bank_data['in_longitude'] = $in_longitude;
                }else{
                    
                    $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_BUSINESS_OWNER .
                            ' WHERE in_user_id IN ( SELECT in_user_id FROM ' . $mydb->prefix . 
                            TBL_PICKUP . ' WHERE in_job_id = ' . $job_id . ')';
                    $bank_data = $mydb->query( $str_query );
                    if( isset( $bank_data['in_user_id'] ) ){
                        if( $bank_data['st_add'] == "" ){
                            $bank_data['st_add'] = $bo_bank_address;
                            $bank_data['in_latitude'] = $bo_latitude;
                            $bank_data['in_longitude'] = $bo_longitude;
                        }
                        $bank_data['st_type'] = "bank";
                    }else{
                         
                        $bank_data = array();
                        $bank_data['st_type'] = "bank";
                        $bank_data['st_add'] = $bo_bank_address;
                        $bank_data['in_latitude'] = $bo_latitude;
                        $bank_data['in_longitude'] = $bo_longitude;
                    }
                    
                }   
            }
            if( isset( $bank_data ) && $bank_data != '' ){
                return $bank_data;
            }else{
                return 0;
            }
        }
    }
    
    public function driver_job_complete( $job_id = 0 ){
        if( isset( $job_id ) && $job_id > 0 ){
            global $mydb;
            include_once FL_ACTIVITY;
            $activity = new activity();
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            include_once FL_USER;
            $user = new user();
            $end_time = date( "Y-m-d H:i:s" );
            $activity_data = $activity->get_activity_by_data( $job_id, '-1', 'end' );
            if( $activity_data && $activity_data != '' ){
            }else{
                $updateid = $activity->add_activity( $job_id, '-1', 'end' );
            }
            $arr_route = array();
            $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_PICKUP . '  p, ' . $mydb->prefix . TBL_JOB .
                    ' j  WHERE j.in_job_id = ' . $job_id . ' AND p.in_job_id = ' . $job_id . ' AND p.st_order_type = "change_order"  GROUP BY p.st_order_type ORDER BY p.in_pickup_sort,p.in_pickup_id  LIMIT 1';
            $check_ch_job = $mydb->query( $str_query );
            $check_pickup_exists = $this->check_pickup_exists_job( $job_id );
            if( isset( $check_ch_job['st_order_type'] ) &&  $check_ch_job['st_order_type'] == "change_order" ){
                $bank_data = $this->get_job_bank_data( $job_id, 'change_order' );$bank_name = isset( $bank_data['st_add'] ) && $bank_data['st_add'] != '' ? $bank_data['st_add'] : '';
                $bank_lat = isset( $bank_data['in_latitude'] ) && $bank_data['in_latitude'] != '' ? $bank_data['in_latitude'] : '';
                $bank_log = isset( $bank_data['in_longitude'] ) && $bank_data['in_longitude'] != '' ? $bank_data['in_longitude'] : '';
                $arr_bank1 = array(
                    'add' => $bank_name,
                    'lat' => $bank_lat,
                    'long'=> $bank_log
                );
                array_push( $arr_route , $arr_bank1 );
            }
            
            $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_job_id = ' . $job_id . ' ORDER BY in_pickup_sort,in_pickup_id';
            $driver_job = $mydb->query( $str_query );
            
            if( isset( $driver_job ) && $driver_job != '' ){
                $arr_where_group = array(
                    'in_job_id' => $job_id
                );
                $order_data = $mydb->get_all( TBL_ORDER, '*', $arr_where_group );
                if( isset( $order_data ) && $order_data > 0 || $order_data != "" ){
                    $order_type = json_decode( $order_data['st_order_no'], true );
                    foreach( $order_type as $otk => $otv ){
                        if( $otv['type'] == "bank" ){
                            $bank_data = $this->get_job_address_data( $job_id , '', 'bank' );
                            $st_type = isset( $bank_data['st_type'] ) && $bank_data['st_type'] != '' ? $bank_data['st_type'] : '';
                            $bank_name = isset( $bank_data['st_add'] ) && $bank_data['st_add'] != '' ? $bank_data['st_add'] : '';
                            $bank_lat = isset( $bank_data['in_latitude'] ) && $bank_data['in_latitude'] != '' ? $bank_data['in_latitude'] : '';
                            $bank_log = isset( $bank_data['in_longitude'] ) && $bank_data['in_longitude'] != '' ? $bank_data['in_longitude'] : '';
                            $arr_location = array(
                                'add' => $bank_name,
                                'lat' => $bank_lat,
                                'long'=> $bank_log
                            );
                            array_push( $arr_route , $arr_location );
                        }else{
                            if( isset( $driver_job['in_pickup_id'] ) ){
                                $driver_job = array( $driver_job );
                            }
                            $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_LOCATION .
                                ' WHERE in_location_id in ( SELECT in_location_id FROM '  . 
                                $mydb->prefix . TBL_PICKUP . ' WHERE in_pickup_id = '. $otv['type'] . ')';
                            $driver_location = $mydb->query( $str_query );
                            $arr_location = array(
                                'add' => $driver_location['st_address'],
                                'lat' => $driver_location['in_latitude'],
                                'long'=> $driver_location['in_longitude']
                            );
                            array_push( $arr_route , $arr_location );
                        }
                    }
                }
                
            }
            if( isset( $check_pickup_exists ) && $check_pickup_exists != "" ){
                $bank_data = $this->get_job_address_data( $job_id );
                $bank_name = isset( $bank_data['st_add'] ) && $bank_data['st_add'] != '' ? $bank_data['st_add'] : '';
                $bank_lat = isset( $bank_data['in_latitude'] ) && $bank_data['in_latitude'] != '' ? $bank_data['in_latitude'] : '';
                $bank_log = isset( $bank_data['in_longitude'] ) && $bank_data['in_longitude'] != '' ? $bank_data['in_longitude'] : '';
                $arr_bank2 = array(
                    'add' => $bank_name,
                    'lat' => $bank_lat,
                    'long'=> $bank_log
                );
                array_push( $arr_route , $arr_bank2 );
            }
            
            $set = array( 
                'st_status' => 'completed',
                'dt_end_time' => $end_time,
                'st_route' => json_encode( $arr_route )
                );
            $where = array(
                'in_job_id' => $job_id
                );
            $update_id = $mydb->update( TBL_JOB, $set, $where );
            
            if( isset( $update_id ) && $update_id > 0 ){
                $str_query = 'SELECT in_user_id,in_location_id,in_pickup_id,st_order_type,max(dt_pickup) as dt_pickup FROM ' . $mydb->prefix 
                        . TBL_PICKUP . ' WHERE in_job_id = ' . $job_id . ' GROUP BY in_user_id';
                $response = $mydb->query( $str_query );
                if( isset( $response['in_user_id'] ) ){
                    $response = array( $response );
                }

                $arr_bo_id = array();
                foreach( $response as $res ){
                    if( $res['st_order_type'] == "change_order" ){
                        $bo_data = $user->get_bo_data_by( 'in_user_id', $res['in_user_id'] );
                        $bo_id = $bo_data['in_user_id'];
                        array_push( $arr_bo_id, $bo_id );
                    }else{
                        $bo_id = $res['in_user_id'];
                        array_push( $arr_bo_id, $bo_id );
                    }
                }
                $arr_boid = array_unique( $arr_bo_id );
            
                if( isset( $arr_boid ) && is_array( $arr_boid ) ){
                    foreach( $arr_boid as $bok => $bov ){
                        $bo_email_id = $user->get_user_data_by_key( $bov, 'st_email_id' );
                        $bo_name = $user->get_user_data_by_key( $bov, 'st_first_name' );
                        $mail_data = array( "user_name" => $bo_name,
                            "id" => $job_id,
                            "base_url" => SITE_NAME );
                        $email_bo_templete = $template->get_template( 'email', '', 'driver_job_complete', TRUE );
                        if ( MAIL_MODE == 'test' ){
                            $bo_email_id = TEST_EMAIL;
                        } else{
                            $bo_email_id = $bo_email_id;
                        }
                        $user->send_mail_by_template( $bov, $bo_email_id, 'Cop Express - Driver trip has been completed ', $email_bo_templete, $mail_data );
                    }
                }
                return $update_id;
            }else{
                return 0;
            }
        }
    }
    
    
    public function get_job_data( $type = '', $user_id = 0 , $status = 'completed' ){
        global $mydb;
        include_once FL_USER;
        $user = new user();
        
        if( $type == "admin" ){
            $where = array(
                'st_status' => $status
            );
            $job_data = $mydb->get_all( TBL_JOB , '*' , $where, 'in_job_id DESC' );
        }else if( $type == "driver" ){ 
            $where = array(
                'st_status' => $status,
                'in_driver_id' => $user_id
            );
            $job_data = $mydb->get_all( TBL_JOB , '*' , $where, 'in_job_id DESC' );
        }else if( $type == "business_owner" ){
            $str_query = 'SELECT DISTINCT j.* FROM ' . $mydb->prefix . TBL_PICKUP . 
                    ' p, ' . $mydb->prefix . TBL_JOB . ' j WHERE j.st_status = "' . $status . '" AND j.in_job_id = p.in_job_id AND ( ( p.st_order_type  IS NULL AND p.in_user_id = '
                . $user_id .  ' ) || ( p.st_order_type = "change_order" AND p.in_user_id in ( SELECT in_user_id FROM  ' . $mydb->prefix . TBL_BUSINESS_OWNER .
                    ' WHERE in_user_id = ' . $user_id . ' ) ) ) ORDER BY j.in_job_id DESC ';
            $job_data = $mydb->query( $str_query );
        }
        if( isset( $job_data ) && $job_data != '' ){
            if( isset( $job_data['in_job_id'] ) ){
                $job_data = array( $job_data );
            }
            
            foreach( $job_data as $key => $value ){
                
                $job_data[$key]['in_bo_id'] = array();
                $pickup_where = array(
                    'in_job_id' => $value['in_job_id']
                );
                $str_query = 'SELECT in_user_id,st_order_type FROM ' . $mydb->prefix . TBL_PICKUP . 
                    ' WHERE in_job_id = ' . $value['in_job_id'] . ' ORDER BY  in_user_id';
                    
                $response = $mydb->query( $str_query );
                if( isset( $response ) && is_array( $response ) ){
                    // print_r($response);
                    if( isset( $response['in_user_id'] ) ){
                        $response = array( $response );
                    }
                    foreach( $response as $resk => $resv ){
                        array_push( $job_data[$key]['in_bo_id'], $resv['in_user_id'] );
                    }
                }
                
                $arr_where_group = array(
                    'in_job_id' => $value['in_job_id']
                );
                $order_data = $mydb->get_all( TBL_ORDER, '*', $arr_where_group );
                if( isset( $order_data ) && $order_data > 0 || $order_data != "" ){
                    $order_type = json_decode( $order_data['st_order_no'], true );
                    if( isset( $order_type ) && $order_type > 0 ){
                    foreach( $order_type as $otk => $otv ){
                        if( $otv['type'] == "bank" ){
                            $job_data[$key]['pickup'][$otk]['st_order_type'] = '';
                            $job_data[$key]['pickup'][$otk]['type'] = "bank";
                            $job_data[$key]['pickup'][$otk]['st_order_type'] = "bank";
                        }else{
                            $pickup_where = array(
                                'in_job_id' => $value['in_job_id'],
                                'in_pickup_sort' => $otk + 1
                            );
                            $job_data[$key]['pickup'][$otk] = $mydb->get_all( TBL_PICKUP , '*' , $pickup_where, ' in_pickup_sort' );
//                            if( isset( $job_data[$key]['pickup']['in_pickup_id'] ) ){
//                                $job_data[$key]['pickup'][$otk] = array( $job_data[$key]['pickup'] );
//                            }
                           
                        }
                    }
                    }
                }
            }
            return $job_data;
        }else{
            return 0;
        }
    }
    
    public function driver_assign_job( $user_id = 0, $job_id = 0 ){
        global $mydb;
        include_once FL_USER;
        $user = new user();
        if( isset( $user_id ) && $user_id > 0 && isset( $job_id ) && $job_id > 0 ){
            $driver_id = $this->get_job_by_key( $job_id, 'in_driver_id' );
            if( isset( $driver_id ) && $driver_id > 0 ){
                return -1;
            }else{
                $arr_data = array(
                    'in_driver_id' => $user_id,
                    'st_status' => "assign"
                );
                $where = array(
                    'in_job_id' => $job_id,
                    'st_status' => "pending"
                );
                $update_id = $mydb->update( TBL_JOB, $arr_data, $where );
                return $update_id;
            }    
        }else{
            return 0;
        }
    }
    
    public function get_all_recurring(){
        global $mydb;
        $where = array(
            'in_is_active' => 1
        );
        $recurring_data = $mydb->get_all( TBL_RECURRING_PICKUP, '*', $where );
        if( isset( $recurring_data ) && $recurring_data != '' || $recurring_data != 0 ){
            if( isset( $recurring_data['in_recurring_id'] ) ){
                $recurring_data = array( $recurring_data );
            } 
            return $recurring_data;
        }else{
            return 0;
        }
    }
    
    public function get_recurring_by_user_id( $user_id = 0 ){
        if( isset( $user_id ) && $user_id > 0 ){
            $where = array(
                'in_user_id' => $user_id,
                'in_is_active' => 1
            );
            global $mydb;
            $recurring_data = $mydb->get_all( TBL_RECURRING_PICKUP, '*', $where );
            if( isset( $recurring_data ) && $recurring_data != '' || $recurring_data != 0 ){
                if( isset( $recurring_data['in_recurring_id'] ) ){
                    $recurring_data = array( $recurring_data );
                } 
                return $recurring_data;
            }
        }else{
            return 0;
        }
    }
    
    public function driver_mid_point_status( $job_id = 0, $st_mid_type = '' ){
        if( isset( $job_id ) && $job_id > 0 ){
            $where = array(
                'in_job_id' => $job_id
            );
            global $mydb;
            include_once FL_ACTIVITY;
            $activity = new activity();
            $order_data = $mydb->get_all( TBL_ORDER, '*', $where );
            if( isset( $order_data ) && $order_data != '' || $order_data != 0 ){
                $mid_type = isset( $st_mid_type ) && $st_mid_type != "" ? $st_mid_type : '';
                
                $order_type = json_decode( $order_data['st_order_no'], true );
                foreach( $order_type as $otk => $otv ){
                    if( $otv['type'] ==  $mid_type && $otv['status'] != "completed" ){
                        if( $otv['status'] == "assign" ){
                            $order_type[$otk]['status'] = 'in_progress';
                            $arr_set = array (
                                'st_order_no' => json_encode( $order_type )
                            );
                            $update_id = $mydb->update( TBL_ORDER, $arr_set, $where );
                            if( $update_id > 0 ){
                            $activity_data = $activity->get_activity_by_data( $job_id, $otk + 1, 'start' );
                            if( $activity_data && $activity_data != '' ){
                            }else{
                                $updateid = $activity->add_activity( $job_id, $otk + 1, 'start' );
                            }
                        }
                        }else{
                            $order_type[$otk]['status'] = 'completed';
                            $arr_set = array (
                                'st_order_no' => json_encode( $order_type )
                            );
                            $update_id = $mydb->update( TBL_ORDER, $arr_set, $where );
                            if( $update_id > 0 ){
                            $activity_data = $activity->get_activity_by_data( $job_id, $otk + 1, 'end' );
                            if( $activity_data && $activity_data != '' ){
                            }else{
                                $updateid = $activity->add_activity( $job_id, $otk + 1, 'end' );
                            }
                        }
                        }
                        
                        return $update_id;
                    }
                }
                return 0;
            }
        }else{
            return 0;
        }
    }
    
    public function get_recurring_by_id( $recurring_id = 0 ){
        if( isset( $recurring_id ) && $recurring_id > 0 ){
            $where = array(
                'in_recurring_id' => $recurring_id
            );
            global $mydb;
            $recurring_data = $mydb->get_all( TBL_RECURRING_PICKUP, '*', $where );
            if( isset( $recurring_data ) && $recurring_data != '' || $recurring_data != 0 ){
                return $recurring_data;
            }
        }else{
            return 0;
        }
    }
    
    public function get_driver_pickup_amt_list( $user_id = 0 ){
        global $mydb;
        $str_user = '';
        if( isset( $user_id ) && $user_id > 0 ){
            $str_user = " AND in_driver_id = " . $user_id;
        }
        $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_JOB . ' WHERE in_driver_id != 0  ' . $str_user . ' ORDER BY in_job_id DESC ';
        $driver_pickup_amt = $mydb->query( $str_query );
        if( isset( $driver_pickup_amt ) && $driver_pickup_amt != '' || $driver_pickup_amt != 0 ){
            if( isset( $driver_pickup_amt['in_job_id'] ) ){
                $driver_pickup_amt = array( $driver_pickup_amt );
            }
            foreach( $driver_pickup_amt as $dpk => $dpv ){
                $str_query = 'SELECT count( in_pickup_id ) as location_count FROM ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_job_id = ' . $dpv['in_job_id'] . ' ';
                $driver_pickup_count = $mydb->query( $str_query );
                $driver_pickup_amt[$dpk]['location_count'] = $driver_pickup_count['location_count'];
            }
            return $driver_pickup_amt;
        }else{
            return 0;
        }
    }
    
    public function get_pickups( $user_id = 0 ){
        if( isset( $user_id ) && $user_id > 0 ){
            global $mydb;
            $date = date( "Y-m-d" );
            $str_query = 'SELECT DISTINCT p.in_pickup_id ,p.* FROM ' . $mydb->prefix . TBL_PICKUP . ' p,  ' . 
                $mydb->prefix . TBL_CHANGE_ORDER . ' c WHERE  p.in_is_active = 1  AND (  ( p.st_order_type IS NULL AND  p.in_user_id =  ' . $user_id .
                    ' ) || ( p.st_order_type = "change_order" AND p.in_pickup_id = c.in_pickup_id AND c.in_is_approve = 1 AND p.in_user_id in ( SELECT in_store_manager_id FROM  '
                    . $mydb->prefix . TBL_BUSINESS_OWNER . ' WHERE in_user_id = ' . $user_id . ') ) )';
            $response = $mydb->query( $str_query ); 
            if( isset( $response ) && $response != '' || $response != 0 ){
                if( isset( $response['in_pickup_id'] ) ){
                    $response = array( $response );
                } 
            }
            return $response;
        }else{
            return 0;
        }
    }
    
    public function get_pickiup_by_id( $pickup_id = 0 ){
        if( isset( $pickup_id ) && $pickup_id != '' ){
            global $mydb;
            $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_PICKUP . ' WHERE in_pickup_id = ' . $pickup_id . ' ';
            $driver_job = $mydb->query( $str_query );
      
            if( isset( $driver_job ) && $driver_job != '' ){
                $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_LOCATION .
                        ' WHERE in_location_id in ( SELECT in_location_id FROM '  . 
                        $mydb->prefix . TBL_PICKUP . ' WHERE in_pickup_id = '. $pickup_id . ')';
                $driver_job['location'] = $mydb->query( $str_query );
                return $driver_job;
            }
        }else{
            return '';
        }
    }
    
    public function get_assign_pickups_by_job_id( $job_id ){
        global $mydb;
        if( isset( $job_id ) && $job_id > 0 ){
            include_once FL_USER;
            $user = new user();
            $date = date( "Y-m-d" );
            $str_query = 'SELECT DISTINCT j.* FROM ' . $mydb->prefix . TBL_JOB . ' j ,' . $mydb->prefix . TBL_PICKUP 
                    .' p WHERE p.in_job_id = ' . $job_id . ' AND j.in_job_id = p.in_job_id AND j.dt_pickup >= "' . $date . '" ';
            $response = $mydb->query( $str_query );
            if( isset( $response ) && $response != '' || $response > 0 ){
                if( isset( $response['in_job_id'] ) ){
                    $response = array( $response );
                }
                foreach( $response as $res_k => $res_v ){
                    $where = array(
                        'in_job_id' => $res_v['in_job_id']
                    );
                    if( $res_v['st_status'] == "pending" ){
                        $response[$res_k]['st_status'] = "Pending";
                    }else if( $res_v['st_status'] == "completed" ){
                        $response[$res_k]['st_status'] = "Completed";
                    }else if( $res_v['st_status'] == "assign" ){
                        $response[$res_k]['st_status'] = "Assign";
                    }else if( $res_v['st_status'] == "in_progress" ){
                        $response[$res_k]['st_status'] = "Progress";
                    }else{
                        $response[$res_k]['st_status'] = $response[$res_k]['st_status'];
                    }
                    $response[$res_k]['pickup_list'] = $mydb->get_all( TBL_PICKUP , '*' , $where );
                    if( isset( $response[$res_k]['pickup_list'] ) && $response[$res_k]['pickup_list'] != '' || $response[$res_k]['pickup_list'] > 0 ){
                        if( isset( $response[$res_k]['pickup_list']['in_pickup_id'] ) ){
                            $response[$res_k]['pickup_list'] = array( $response[$res_k]['pickup_list'] );
                        }
                        $response[$res_k]['pickup_count'] = count( $response[$res_k]['pickup_list'] );
                        $response[$res_k]['pickup_sum'] = 0;
                        $is_change = '';
                        $is_pickup = '';
                        $is_recurring = '';
                        foreach( $response[$res_k]['pickup_list'] as $pdk => $pdv ){
                            $response[$res_k]['pickup_sum'] = $pdv['fl_amount'] + $response[$res_k]['pickup_sum'];
                            if( $pdv['st_order_type'] == "change_order" ){
                                $is_change = "yes";
                            }else{
                                $is_pickup = "yes";
                            }
                            if( $pdv['st_order_type'] == "change_order" ){
                                $bo_data = $user->get_bo_data_by( 'in_store_manager_id',  $pdv['in_user_id'] );
                                $response[$res_k]['bo_id'] = $bo_data['in_user_id'];
                            }else{
                                $response[$res_k]['bo_id'] = $pdv['in_user_id'];
                            }
                            if( $pdv['st_pickup_type'] == "recurring" ){
                               $is_recurring = "yes";
                            }
                        }

                        if( $is_change == "yes" && $is_pickup == "yes" ){
                            $response[$res_k]['pickup_type'] = ' Change Order and Pickup';
                        }else if( $is_change == "yes" ){
                            $response[$res_k]['pickup_type'] = ' Change Order';
                        }else if( $is_pickup == "yes" ){
                            $response[$res_k]['pickup_type'] = ' Pickup';
                        }
                        if( $is_recurring == "yes" ){
                            $response[$res_k]['recurring'] = "Yes";
                        }else{
                            $response[$res_k]['recurring'] = "No";
                        }
                    }
                    $response[$res_k]['pickup_list'] = '';
                }
            }

            if( isset( $response ) && $response != '' ){
                
                return $response;
            }
            return '';
        }
    }
    
    public function  get_all_change_order_by_bo( $user_id = 0, $pickup_id = 0 ){
        global $mydb;
        $where = '';
        if( isset( $user_id ) &&  $user_id > 0 ){
            $where_pickup = '';
            if( isset( $pickup_id ) && $pickup_id > 0 ){
                $where_pickup = " AND in_pickup_id = " . $pickup_id . " ";
            }
            $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_CHANGE_ORDER_MAIL  
                .' WHERE in_user_id = ' . $user_id . $where_pickup .' ORDER BY in_pickup_id';
            $response = $mydb->query( $str_query );
        }else{
            $str_query = 'SELECT GROUP_CONCAT( in_pickup_id ) as pickup_ids,GROUP_CONCAT( in_location_id ) as location_ids, in_user_id FROM ' . $mydb->prefix . TBL_CHANGE_ORDER_MAIL  
                .' ' . $where . ' GROUP BY in_user_id';
            $response = $mydb->query( $str_query );
        }
        
        if( isset( $response ) && $response != '' ){
            return $response;
        }else{
            return '';
        }
    }
    
    
    
    function edit_change_order( $change_data ) {
        if ( isset( $change_data ) && is_array( $change_data ) ) {
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_LOCATION;
            $location = new location();
            include_once FL_USER;
            $user = new user();
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            $user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] != '' ?  $_SESSION['user_id'] : '';
            
            if( isset( $user_id ) && $user_id != '' ){
                $pickup_id = ( isset( $change_data['pickup_id'] ) && trim( $change_data['pickup_id'] ) > 0 ) ? trim( $change_data['pickup_id'] ) : 0;
                foreach( $change_data['change'] as $data ){
                    $location_name = ( isset( $data['location'] ) && trim( $data['location'] ) !== '' ) ? trim( $data['location'] ) : '';
                    $pickup_date = ( isset( $data['date'] ) && $data['date'] !== '' ) ? $data['date']  : '';
                    
                    $amt_d_50 = ( isset( $data['amt_d_50'] ) && trim( $data['amt_d_50'] ) !== '' ) ? trim( $data['amt_d_50'] ) : 0;
                    $amt_d_20 = ( isset( $data['amt_d_20'] ) && $data['amt_d_20'] !== '' ) ? $data['amt_d_20']  : 0;
                    $amt_d_10 = ( isset( $data['amt_d_10'] ) && trim( $data['amt_d_10'] ) !== '' ) ? trim( $data['amt_d_10'] ) : 0;
                    $amt_d_5 = ( isset( $data['amt_d_5'] ) && $data['amt_d_5'] !== '' ) ? $data['amt_d_5']  : 0;
                    $amt_d_1 = ( isset( $data['amt_d_1'] ) && trim( $data['amt_d_1'] ) !== '' ) ? trim( $data['amt_d_1'] ) : 0;
                    $amt_c_1 = ( isset( $data['amt_c_1'] ) && $data['amt_c_1'] !== '' ) ? $data['amt_c_1']  : 0;
                    $amt_c_5 = ( isset( $data['amt_c_5'] ) && trim( $data['amt_c_5'] ) !== '' ) ? trim( $data['amt_c_5'] ) : 0;
                    $amt_c_10 = ( isset( $data['amt_c_10'] ) && $data['amt_c_10'] !== '' ) ? $data['amt_c_10']  : 0;
                    $amt_c_25 = ( isset( $data['amt_c_25'] ) && trim( $data['amt_c_25'] ) !== '' ) ? trim( $data['amt_c_25'] ) : 0;
                    $gt_amt = ( isset( $data['gt_amt'] ) && trim( $data['gt_amt'] ) !== '' ) ? trim( $data['gt_amt'] ) : 0;
                    $newDate = date( "Y-m-d", strtotime( $pickup_date ) );
                    
                    $arr_where = array( 
                        'in_pickup_id' => $pickup_id
                    );
                    
                    $arr_data = array(
                        'fl_amount' => $gt_amt
                    );
                    $insert_id = $mydb->update( TBL_PICKUP, $arr_data, $arr_where );
                    if( isset( $insert_id ) && $insert_id > 0 ){
                        $arr_data = array(
                            'fl_dollar_50' => $amt_d_50,
                            'fl_dollar_20' => $amt_d_20,
                            'fl_dollar_10' => $amt_d_10,
                            'fl_dollar_5' => $amt_d_5,
                            'fl_dollar_1' => $amt_d_1,
                            'ft_cent_1' => $amt_c_1,
                            'ft_cent_5' => $amt_c_5,
                            'ft_cent_10' => $amt_c_10,
                            'ft_cent_25' => $amt_c_25,
                        );
                        
                        $co_insert_id = $mydb->update( TBL_CHANGE_ORDER, $arr_data, $arr_where  );
                        
                    }
                }
                if ( $insert_id !== '' && $insert_id > 0 ) {
                    return $insert_id;
                } else {
                    $this->flag_err = TRUE;
                }
            }else{
                return 0;
            }
        }
    }
    
    public function get_driver_interrupt_jobs( $user_id = 0 ){
        global $mydb;
        $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_JOB . ' WHERE  st_status = "interrupt"  ORDER BY in_job_id DESC' ;
        $response = $mydb->query( $str_query );
        if( isset( $response ) && $response != '' || $response != 0  ){
            if( isset( $response['in_job_id'] ) ){
                $response = array( $response );
            }
            return $response;
        }
        return '';
    }
    
    function delivery_change_order_direct( $data ){
        global $mydb;
        if( isset( $data ) && is_array( $data ) ) {
            $pickup_ids = isset( $data['pickup_id'] ) && $data['pickup_id'] != "" ? $data['pickup_id'] : 0;
            $pickup_date = isset( $data['pickup_date'] ) && $data['pickup_date'] != "" ? $data['pickup_date'] : '';
            if( $pickup_ids > 0 ){
                $arr_pickup_id = explode( ',', $pickup_ids );
                foreach( $arr_pickup_id as $apk => $apv ){
                    $pickup_id = $apv;
                    $pickup_date = date( "Y-m-d", strtotime( $pickup_date ) );
                    $arr_data = array(
                        'in_is_show' => 1,
                        'dt_pickup' => $pickup_date,
                    );
                    $where = array(
                        'in_pickup_id' => $pickup_id,
                    );
                    $update_id = $mydb->update( TBL_PICKUP, $arr_data, $where );
                    
                    $arr_data = array(
                        'in_is_approve' => 1,
                    );
                    $where = array(
                        'in_pickup_id' => $pickup_id,
                    );
                    $update_id = $mydb->update( TBL_CHANGE_ORDER, $arr_data, $where );
                    
                    $str_query = 'DELETE FROM ' . $mydb->prefix . TBL_CHANGE_ORDER_MAIL . ' WHERE  in_pickup_id = ' . $pickup_id ;
                    $response = $mydb->query( $str_query );
                }
                if( isset( $update_id ) && $update_id > 0 ){
                    return $update_id;
                } else {
                    return 0;
                }
            }
        }
        return 0;
    }
    
}