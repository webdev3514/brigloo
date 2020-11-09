<?php
$location = new location();

class location {

    public $flag_err = FALSE;
   
    function __construct() {
        $this->flag_err = FALSE;
        $this->active = ' in_is_active = 1 ';
    }


    function add_location( $data ) {
        
        include_once FL_USER;
        $user = new user();
        include_once FL_HTML_TEMPLATE;
        $template = new template();
        if ( isset( $data ) && is_array( $data ) ) {
            $location_name = ( isset($data['txt_location_name'] ) && trim( $data['txt_location_name'] ) !== '' ) ? trim( $data['txt_location_name'] ) : '';
            $address = ( isset( $data['txt_address'] ) && trim( $data['txt_address'] ) !== '' ) ? trim( $data['txt_address'] ) : '';
            $latitude = ( isset($data['hdn_latitude'] ) && trim( $data['hdn_latitude'] ) !== '' ) ? trim( $data['hdn_latitude'] ) : '';
            $longitude = ( isset($data['hdn_longitude'] ) && $data['hdn_longitude'] !== '' ) ? $data['hdn_longitude']  : '';
            $store_id = ( isset($data['txt_store_id'] ) && $data['txt_store_id'] !== '' ) ? $data['txt_store_id']  : '';
            $account_type = ( isset( $data['account_type'] ) && $data['account_type'] !== '' ) ? $data['account_type']  : '';
            $current_time = time();
            
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            $user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] != '' ?  $_SESSION['user_id'] : '';
            $str_store_query = 'SELECT * FROM ' .$mydb->prefix . TBL_LOCATION . ' WHERE st_store_id = "' . $store_id . '" AND in_user_id = ' . $user_id . ' AND in_is_active = 1';
            $user_store_data = $mydb->query( $str_store_query );
            
            if( isset( $user_store_data['in_location_id'] ) && $user_store_data['in_location_id'] != '' ){
                return -1;
            }else{
                
                if( isset( $user_id ) && $user_id != '' ){
                    $insert_sm_email = ( isset( $data['txt_email_address'] ) && trim( $data['txt_email_address'] ) !== '' ) ? trim( $data['txt_email_address'] ) : '';
                    $password = ( isset( $data['txt_pwd'] ) && trim( $data['txt_pwd'] ) !== '' ) ? trim( $data['txt_pwd'] ) : '';
                    $bo_id = ( isset( $data['user_id'] ) && trim( $data['user_id'] ) > 0 ) ? trim( $data['user_id'] ) : 0;
                    $store_manager_id = ( isset( $data['sm_id'] ) && trim( $data['sm_id'] ) > 0 ) ? trim( $data['sm_id'] ) : 0;
                    $user_type = ( isset( $data['txt_user_type'] ) && trim( $data['txt_user_type'] ) !== '' ) ? trim( $data['txt_user_type'] ) : '';
                    
                    if( $account_type == "multiple" ){
                        $arr_sm_data = array(
                            'st_email_id' => $insert_sm_email,
                            'st_password' => md5( $password ),
                            'st_user_type' => 'store_manager',
                        );
                        $str_email_query = 'SELECT * FROM ' .$mydb->prefix . TBL_USER . ' WHERE st_email_id = "' .$insert_sm_email .'" AND in_is_active = 1';
       
                        $user_email_data = $mydb->query( $str_email_query );
                        if( isset( $user_email_data['in_user_id'] ) && $user_email_data['in_user_id'] != '' ){
                            return -2;
                        }else{
                            $insert_sm_id = $mydb->insert( TBL_USER, $arr_sm_data );
                        }
                        
                        // $user->send_bo_sm_confirmation_data( $bo_id, $insert_sm_id );
                        $arr_data = array(
                            'in_user_id'        => $user_id,
                            'st_store_id'       => $store_id ,
                            'in_manager_id'     => $insert_sm_id ,
                            'st_sm_password'    => $password ,
                            'st_type'           => 'multiple' ,
                            'st_location_name'  => $location_name,
                            'st_address'        => $address,
                            'in_latitude'       => $latitude,
                            'in_longitude'      => $longitude,
                        );
                    }else{
                        $sm_id = $user->get_bo_data_by_key( $bo_id, 'in_store_manager_id' );
                        $sm_password = $user->get_bo_data_by_key( $bo_id, 'st_sm_password' );
                        $arr_data = array(
                            'in_user_id'        => $user_id,
                            'st_store_id'       => $store_id ,
                            'in_manager_id'     => $sm_id ,
                            'st_sm_password'    => $sm_password ,
                            'st_type'           => 'single' ,
                            'st_location_name'  => $location_name,
                            'st_address'        => $address,
                            'in_latitude'       => $latitude,
                            'in_longitude'      => $longitude,
                        );
                    }
                    
                    $insert_id = $mydb->insert( TBL_LOCATION, $arr_data );

                    if ( $insert_id !== '' && $insert_id > 0 ) {
                        
                        if( $account_type == "multiple" ){
                            $business_name = $user->get_bo_data_by_key( $user_id, 'st_business_name' );
                            $data = array( "location" => $address,
                                "sm_email" => $insert_sm_email,
                                "sm_password" => $password,
                                "base_url" => SITE_NAME,
                                "business_name" => $business_name );
                            $email_reset_templet = $template->get_template('email', '', 'bo_location_sm_mail', TRUE);
                            if ( MAIL_MODE == 'test' ){
                                $send_email_id = TEST_EMAIL;
                            } else{
                                $send_email_id = $insert_sm_email;
                            }
                            $user->send_mail_by_template( $user_id, $send_email_id, ' One more location has been added', $email_reset_templet, $data );
                        }else{
                            $business_name = $user->get_bo_data_by_key( $user_id, 'st_business_name' );
                            $sm_id = $user->get_bo_data_by_key( $user_id, 'in_store_manager_id' );
                            $sm_password = $user->get_bo_data_by_key( $user_id, 'st_sm_password' );
                            $sm_data = $user->get_user_data_by('in_user_id', $sm_id );
                            $data = array( "location" => $address,
                                "sm_email" => $sm_data['st_email_id'],
                                "sm_password" => $sm_password,
                                "base_url" => SITE_NAME,
                                "business_name" => $business_name );
                            $email_reset_templet = $template->get_template( 'email', '', 'bo_location_sm_mail', TRUE);
                            if ( MAIL_MODE == 'test' ){
                                $send_email_id = TEST_EMAIL;
                            } else {
                                $send_email_id = $sm_data['st_email_id'];
                            }
                            $user->send_mail_by_template( $user_id, $send_email_id, ' One more location has been added', $email_reset_templet, $data );
                        }
                        return $insert_id;
                    } else {
                        $this->flag_err = TRUE;
                    }
                }else{
                    return 0;
                }
            }
        }
    }
    
    function edit_location( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            $location_name = ( isset($data['txt_location_name'] ) && trim( $data['txt_location_name'] ) !== '' ) ? trim( $data['txt_location_name'] ) : '';
            $address = ( isset($data['txt_address'] ) && trim( $data['txt_address'] ) !== '' ) ? trim( $data['txt_address'] ) : '';
            $latitude = ( isset($data['hdn_latitude'] ) && trim( $data['hdn_latitude'] ) !== '' ) ? trim( $data['hdn_latitude'] ) : '';
            $longitude = ( isset($data['hdn_longitude'] ) && $data['hdn_longitude'] !== '' ) ? $data['hdn_longitude']  : '';
            $location_id = ( isset( $data['hdn_location_id'] ) && $data['hdn_location_id'] !== '' ) ?  $data['hdn_location_id']  : '';
            $store_id = ( isset( $data['txt_store_id'] ) && $data['txt_store_id'] !== '' ) ? $data['txt_store_id']  : '';
            $account_type = ( isset( $data['account_type'] ) && $data['account_type'] !== '' ) ? $data['account_type']  : '';
            global $mydb;
            if (!session_id()) {
                session_start();
            }
            include_once FL_USER;
            $user = new user();
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            $user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] != '' ?  $_SESSION['user_id'] : '';
            
            $str_loaction_store_query = 'SELECT * FROM ' . $mydb->prefix . TBL_LOCATION . ' WHERE  in_location_id = "' . $location_id . '" AND st_store_id = "' . $store_id . '" AND in_user_id = ' . $user_id . '';
            $user_location_store_data = $mydb->query( $str_loaction_store_query );
            
            $str_store_query = 'SELECT * FROM ' . $mydb->prefix . TBL_LOCATION . ' WHERE st_store_id = "' . $store_id . '" AND in_user_id = ' . $user_id . ' AND in_is_active = 1';
            $user_store_data = $mydb->query( $str_store_query );
            $st_location_type = $this->get_location_by_key( $location_id , 'st_type' );
            $in_manager_id = $this->get_location_by_key( $location_id , 'in_manager_id' );
            if( isset( $user_location_store_data['in_location_id'] ) && $user_location_store_data['in_location_id'] != ''  ){
                if( isset( $user_id ) && $user_id != '' ){
                    
                    $insert_sm_email = ( isset( $data['txt_email_address'] ) && trim( $data['txt_email_address'] ) !== '' ) ? trim( $data['txt_email_address'] ) : '';
                    $password = ( isset( $data['txt_pwd'] ) && trim( $data['txt_pwd'] ) !== '' ) ? trim( $data['txt_pwd'] ) : '';
                    $bo_id = ( isset( $data['user_id'] ) && trim( $data['user_id'] ) > 0 ) ? trim( $data['user_id'] ) : 0;
                    $store_manager_id = ( isset( $data['sm_id'] ) && trim( $data['sm_id'] ) > 0 ) ? trim( $data['sm_id'] ) : 0;
                    $user_type = ( isset( $data['txt_user_type'] ) && trim( $data['txt_user_type'] ) !== '' ) ? trim( $data['txt_user_type'] ) : '';
                    
                    if( $account_type == "multiple" ){
                        if( $st_location_type == 'multiple' ){
                            
                        }else{
                            
                        }
                        $arr_sm_data = array(
                            'st_email_id' => $insert_sm_email,
                            'st_password' => md5( $password ),
                            'st_user_type' => 'store_manager'
                        );
                        $sm_where = array(
                            'in_user_id' => $store_manager_id
                        );
                        $str_email_query = 'SELECT * FROM ' .$mydb->prefix . TBL_USER . ' WHERE st_email_id = "' . $insert_sm_email .'" AND in_is_active = 1 ';
       
                        $user_email_data = $mydb->query( $str_email_query );
                        $str_sm_query = 'SELECT * FROM ' .$mydb->prefix . TBL_USER . ' WHERE st_email_id = "' .$insert_sm_email .'" AND in_user_id=' . $store_manager_id .' ';
       
                        $user_sm_data = $mydb->query( $str_sm_query );

                        if( isset( $user_sm_data['in_user_id'] ) && $user_sm_data['in_user_id'] > 0 ){
                            $insert_sm_id = $mydb->update( TBL_USER, $arr_sm_data, $sm_where );
                            $insert_sm_id = $in_manager_id;
                        }else if( isset( $user_email_data['in_user_id'] ) && $user_email_data['in_user_id'] != '' ){
                            return -2;
                        }else{
                            $set = array(
                                'in_is_active' => 0
                            );
                            $where = array(
                                'in_user_id' => $in_manager_id
                            );
                            $insert_sm_id = $mydb->insert( TBL_USER, $arr_sm_data );
                            if( $st_location_type == 'multiple' ){
                                $where = array(
                                    'in_user_id' => $in_manager_id,
                                    'in_is_active' => 1
                                );
                                $set = array(
                                    'in_is_active' => 0
                                );
                                
                                $delete_id = $mydb->update( TBL_USER, $set, $where );
                            }else{
                                
                            }
                            
                        }
                        
                        // $user->send_bo_sm_confirmation_data( $bo_id, $insert_sm_id );
                        $arr_data = array(
                            'in_user_id'        => $user_id,
                            'st_store_id'       => $store_id ,
                            'in_manager_id'     => $insert_sm_id ,
                            'st_sm_password'    => $password ,
                            'st_type'           => 'multiple' ,
                            'st_location_name'  => $location_name,
                            'st_address'        => $address,
                            'in_latitude'       => $latitude,
                            'in_longitude'      => $longitude,
                        );
                    }else{
                        if( $st_location_type == 'multiple' ){
                             $where = array(
                                'in_user_id' => $in_manager_id,
                                'in_is_active' => 1
                            );
                            $set = array(
                                'in_is_active' => 0
                            );
                            
                            $delete_id = $mydb->update( TBL_USER, $set, $where );
                        }else{
                            
                        }
                        $sm_id = $user->get_bo_data_by_key( $bo_id, 'in_store_manager_id' );
                        $sm_password = $user->get_bo_data_by_key( $bo_id, 'st_sm_password' );
                        $arr_data = array(
                            'st_store_id'       => $store_id ,
                            'in_manager_id'     => $sm_id ,
                            'st_sm_password'    => $sm_password ,
                            'st_type'           => 'single' ,
                            'st_location_name'  => $location_name,
                            'st_address'        => $address,
                            'in_latitude'       => $latitude,
                            'in_longitude'      => $longitude,
                        );
                    }
                    
                    $where = array(
                        'in_location_id' => $location_id,
                        'in_user_id' => $user_id
                    );
                    $update_id = $mydb->update( TBL_LOCATION, $arr_data, $where );

                    if ( $update_id != '' && $update_id > 0 ){
                        if( $account_type == "multiple" ){
                            $business_name = $user->get_bo_data_by_key( $user_id, 'st_business_name' );
                            $data = array( "location" => $location_name,
                                "sm_email" => $insert_sm_email,
                                "sm_password" => $password,
                                "base_url" => SITE_NAME,
                                "business_name" => $business_name );
                            $email_reset_templet = $template->get_template('email', '', 'bo_update_location_sm_mail', TRUE);
                            if ( MAIL_MODE == 'test' ){
                                $send_email_id = TEST_EMAIL;
                            } else{
                                $send_email_id = $insert_sm_email;
                            }
                            $user->send_mail_by_template( $user_id, $send_email_id, ' One more location ' . $location_name . ' has been added', $email_reset_templet, $data );
                        }else{
                            
                        }
                        return $location_id;
                    } else {
                        $this->flag_err = TRUE;
                    }
                }else{
                    return 0;
                }
            }else if( isset( $user_store_data['in_location_id'] ) && $user_store_data['in_location_id'] != '' ){
                return -1;
            }else{
                if( isset( $user_id ) && $user_id != '' ){
                    $insert_sm_email = ( isset( $data['txt_email_address'] ) && trim( $data['txt_email_address'] ) !== '' ) ? trim( $data['txt_email_address'] ) : '';
                    $password = ( isset( $data['txt_pwd'] ) && trim( $data['txt_pwd'] ) !== '' ) ? trim( $data['txt_pwd'] ) : '';
                    $bo_id = ( isset( $data['user_id'] ) && trim( $data['user_id'] ) > 0 ) ? trim( $data['user_id'] ) : 0;
                    $store_manager_id = ( isset( $data['sm_id'] ) && trim( $data['sm_id'] ) > 0 ) ? trim( $data['sm_id'] ) : 0;
                    $user_type = ( isset( $data['txt_user_type'] ) && trim( $data['txt_user_type'] ) !== '' ) ? trim( $data['txt_user_type'] ) : '';
                    
                    if( $account_type == "multiple" ){
                        $arr_sm_data = array(
                            'st_email_id' => $insert_sm_email,
                            'st_password' => md5( $password ),
                            'st_user_type' => $user_type
                        );
                        $sm_where = array(
                            'in_user_id' => $store_manager_id,
                            'in_is_active' => 1
                            
                        );
                        $str_email_query = 'SELECT * FROM ' .$mydb->prefix . TBL_USER . ' WHERE st_email_id = "' .$insert_sm_email .'"  AND in_is_active = 1 ';
       
                        $user_email_data = $mydb->query( $str_email_query );
                        $str_sm_query = 'SELECT * FROM ' .$mydb->prefix . TBL_USER . ' WHERE st_email_id = "' .$insert_sm_email .'" AND in_user_id=' . $store_manager_id .'';
       
                        $user_sm_data = $mydb->query( $str_sm_query );

                        if( isset( $user_sm_data['in_user_id'] ) && $user_sm_data['in_user_id'] > 0 ){
                            $insert_sm_id = $mydb->update( TBL_USER, $arr_sm_data, $sm_where );
                            $insert_sm_id = $in_manager_id;
                        }else if( isset( $user_email_data['in_user_id'] ) && $user_email_data['in_user_id'] != '' ){
                            return -2;
                        }else{
                            $set = array(
                                'in_is_active' => 0
                            );
                            $where = array(
                                'in_user_id' => $in_manager_id
                            );
                            $insert_sm_id = $mydb->insert( TBL_USER, $arr_sm_data );
                            if( $st_location_type == 'multiple' ){
                                 $where = array(
                                    'in_user_id' => $in_manager_id,
                                    'in_is_active' => 1
                                );
                                $set = array(
                                    'in_is_active' => 0
                                );
                                
                                $delete_id = $mydb->update( TBL_USER, $set, $where );
                            }else{
                                
                            }
                            
                        }
                        
                        $user->send_bo_sm_confirmation_data( $bo_id, $insert_sm_id );
                        $arr_data = array(
                            'in_user_id'        => $user_id,
                            'st_store_id'       => $store_id ,
                            'in_manager_id'     => $insert_sm_id ,
                            'st_sm_password'    => $password ,
                            'st_type'           => 'multiple' ,
                            'st_location_name'  => $location_name,
                            'st_address'        => $address,
                            'in_latitude'       => $latitude,
                            'in_longitude'      => $longitude,
                        );
                        $where = array(
                            'in_location_id' => $location_id,
                            'in_user_id' => $user_id
                        );
                    }else{
                        if( $st_location_type == 'multiple' ){
                             $where = array(
                                'in_user_id' => $in_manager_id,
                                'in_is_active' => 1
                            );
                            $set = array(
                                'in_is_active' => 0
                            );
                            
                            $delete_id = $mydb->update( TBL_USER, $set, $where );
                        }else{
                            
                        }
                        $sm_id = $user->get_bo_data_by_key( $bo_id, 'in_store_manager_id' );
                        $sm_password = $user->get_bo_data_by_key( $bo_id, 'st_sm_password' );
                        $arr_data = array(
                            'st_store_id'       => $store_id ,
                            'in_manager_id'     => $sm_id ,
                            'st_sm_password'    => $sm_password ,
                            'st_type'           => 'single' ,
                            'st_location_name'  => $location_name,
                            'st_address'        => $address,
                            'in_latitude'       => $latitude,
                            'in_longitude'      => $longitude,
                        );
                        $where = array(
                            'in_location_id' => $location_id,
                            'in_user_id' => $user_id
                        );

                    }
                    
                    $update_id = $mydb->update( TBL_LOCATION, $arr_data, $where );

                    if ( $update_id != '' && $update_id > 0 ) {
                        if( $account_type == "multiple" ){
                            $business_name = $user->get_bo_data_by_key( $user_id, 'st_business_name' );
                            $data = array( "location" => $location_name,
                                "sm_email" => $insert_sm_email,
                                "sm_password" => $password,
                                "base_url" => SITE_NAME,
                                "business_name" => $business_name );
                            $email_reset_templet = $template->get_template('email', '', 'bo_update_location_sm_mail', TRUE);
                            if ( MAIL_MODE == 'test' ){
                                $send_email_id = TEST_EMAIL;
                            } else{
                                $send_email_id = $insert_sm_email;
                            }
                            $user->send_mail_by_template( $user_id, $send_email_id, ' One more location ' . $location_name . ' has been added', $email_reset_templet, $data );
                        }else{
                            
                        }
                        return $location_id;
                    } else {
                        $this->flag_err = TRUE;
                    }
                }else{
                    return 0;
                }
            }
        }
    }
    
    public function get_location_data_by( $key = '', $value = '' ) {

        global $mydb;

        $str_query = 'SELECT * from ' . $mydb->prefix . TBL_LOCATION . ' WHERE in_is_active = 1 AND ' . $key . ' = "' . $value . '"';

        $response = $mydb->query($str_query);

        if ( $response != 0 && count($response) > 0 ) {
            return $response;
        }
    }
    
    function get_location_by_id( $location_id = 0  ){
        if( isset( $location_id ) && $location_id > 0 ){
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_USER;
            $user = new user();
            $user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] != '' ?  $_SESSION['user_id'] : '';
            $where = array( 'in_user_id' => $user_id,
                            'in_location_id' => $location_id
                
                );
            
            $location_data = $mydb->get_all( TBL_LOCATION, '*', $where );
            $location_data['sm_email_id'] = $user->get_user_data_by_key( $location_data['in_manager_id'], 'st_email_id' );
            if ( $location_data !== '' && $location_data > 0 ) {
                return $location_data;
            } else {
                return 0;
            }
        }
    }
    
    function get_location( $location_id = 0  ){
        if( isset( $location_id ) && $location_id > 0 ){
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            
            $where = array( 
                    'in_location_id' => $location_id
                );
            
            $location_data = $mydb->get_all( TBL_LOCATION, '*', $where );
            if ( $location_data !== '' && $location_data > 0 ) {
                return $location_data;
            } else {
                return 0;
            }
        }
    }
    
    function get_all_location( $user_id = 0 , $order_by = 'ASC' ){
        if( isset( $user_id ) && $user_id > 0 ){
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            $where = array( 
                'in_user_id' => $user_id,
                'in_is_active' => 1,
                );
            $st_order = "";
            if( $order_by != "" ){
               $st_order = " in_location_id " .  $order_by . " ";
            }
            $location_data = $mydb->get_all( TBL_LOCATION, '*', $where , $st_order );
            if( isset( $location_data['in_location_id'] ) ){
                $location_data = array( $location_data );
            }
            if ( $location_data !== '' && $location_data > 0 ) {
                return $location_data;
            } else {
                return 0;
            }
        }
    }
    
    function get_bo_all_location(){
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            $where = array( 
                'in_is_active' => 1,
                );
            $st_order = "";
            $st_order = " in_location_id DESC ";
            $location_data = $mydb->get_all( TBL_LOCATION, '*', $where );
            if( isset( $location_data['in_location_id'] ) ){
                $location_data = array( $location_data );
            }
            if ( $location_data !== '' && $location_data > 0 ) {
                return $location_data;
            } else {
                return 0;
            }
    }
    
    function get_location_by_type( $user_id = 0 , $type = '', $order_by = 'ASC' ){
        if( isset( $user_id ) && $user_id > 0 ){
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            if( $type == "multiple" ){
                $where = array( 
                    'in_user_id' => $user_id,
                    'in_is_active' => 1,
                    'st_type' => 'multiple',
                );
            }else{
                $where = array( 
                    'in_user_id' => $user_id,
                    'in_is_active' => 1,
                    'st_type' => 'single',
                );
            }
            $st_order = "";
            if( $order_by != "" ){
               $st_order = " in_location_id " .  $order_by . " ";
            }
            $location_data = $mydb->get_all( TBL_LOCATION, '*', $where , $st_order );
            if( isset( $location_data['in_location_id'] ) ){
                $location_data = array( $location_data );
            }
            if ( $location_data !== '' && $location_data > 0 ) {
                return $location_data;
            } else {
                return 0;
            }
        }
    }
    
    function get_location_by_key( $location_id, $key = '' ) {
        global $mydb;
        if( isset( $location_id ) && trim( $location_id ) !== '' && $location_id > 0 ){
            $select = '*';
            $where = ' WHERE in_location_id = ' . $location_id;
            if( isset( $key ) && trim( $key ) !== '' ){
                $select = $key;
            }
            $str_query = 'SELECT ' . $select . ' FROM ' . $mydb->prefix . TBL_LOCATION . $where;
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
    
}