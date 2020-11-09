<?php
$user = new user();

class user {

    public $flag_err = FALSE;
   
    function __construct() {
        $this->flag_err = FALSE;
        $this->active = ' in_is_active = 1 ';
    }


    function add_user( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            // $username = ( isset( $data['txt_user_name'] ) && trim( $data['txt_user_name'] ) !== '' ) ? trim( $data['txt_user_name'] ) : '';
            $firstname = ( isset( $data['txt_first_name'] ) && trim( $data['txt_first_name'] ) !== '' ) ? trim( $data['txt_first_name'] ) : '';
            $lastname = ( isset( $data['txt_last_name'] ) && trim( $data['txt_last_name'] ) !== '' ) ? trim( $data['txt_last_name'] ) : '';
            $phone_no = ( isset( $data['txt_phone_no'] ) && trim( $data['txt_phone_no'] ) !== '' ) ? trim( $data['txt_phone_no'] ) : '';
            $license_no = ( isset( $data['txt_license_no'] ) && $data['txt_license_no'] !== '' ) ?  $data['txt_license_no']  : '';
            $email = ( isset( $data['txt_email_address'] ) && trim( $data['txt_email_address'] ) !== '' ) ? trim( $data['txt_email_address'] ) : '';
            $user_type = ( isset( $data['txt_user_type'] ) && trim( $data['txt_user_type'] ) !== '' ) ? trim( $data['txt_user_type'] ) : '';
            $password = ( isset( $data['txt_pwd'] ) && trim( $data['txt_pwd'] ) !== '' ) ? trim( $data['txt_pwd'] ) : '';
            $business_name = ( isset( $data['txt_business_name'] ) && trim( $data['txt_business_name'] ) !== '' ) ? trim( $data['txt_business_name'] ) : '';
            $eni_no = ( isset( $data['txt_eni_no'] ) && trim( $data['txt_eni_no'] ) !== '' ) ? trim( $data['txt_eni_no'] ) : '';
            $job_title = ( isset( $data['txt_job_title'] ) && trim( $data['txt_job_title'] ) !== '' ) ? trim( $data['txt_job_title'] ) : '';
            $address_1 = ( isset( $data['txt_address_1'] ) && $data['txt_address_1'] !== '' ) ?  $data['txt_address_1']  : '';
            $address_2 = ( isset( $data['txt_address_2'] ) && trim( $data['txt_address_2'] ) !== '' ) ? trim( $data['txt_address_2'] ) : '';
            $city = ( isset( $data['txt_city'] ) && trim( $data['txt_city'] ) !== '' ) ? trim( $data['txt_city'] ) : '';
            $state = ( isset( $data['txt_state'] ) && trim( $data['txt_state'] ) !== '' ) ? trim( $data['txt_state'] ) : '';
            $zip_code = ( isset( $data['txt_zip_code'] ) && trim( $data['txt_zip_code'] ) !== '' ) ? trim( $data['txt_zip_code'] ) : '';

            global $mydb;
            
            // $str_query = 'SELECT * FROM ' .$mydb->prefix . TBL_USER . ' WHERE st_username = "' . $username . '" AND st_email_id = "' .$email .'"';
       
            // $user_data = $mydb->query( $str_query );
            
            // $str_username_query = 'SELECT * FROM ' .$mydb->prefix . TBL_USER . ' WHERE st_username = "' . $username . '" ';
       
            // $user_username_data = $mydb->query( $str_username_query );
            
            $str_email_query = 'SELECT * FROM ' .$mydb->prefix . TBL_USER . ' WHERE st_email_id = "' .$email .'" AND in_is_active = 1';
       
            $user_email_data = $mydb->query( $str_email_query );
            
            
            if( isset( $user_data['in_user_id'] ) && $user_data['in_user_id'] != '' ){
            //   if( isset( $user_data['in_is_active'] ) && $user_data['in_is_active'] == -1 ){
            //         $arr_data = array(
            //             // 'st_username' => $username,
            //             'st_first_name' => $firstname,
            //             'st_last_name'  => $lastname,
            //             'st_email_id' => $email,
            //             'st_password' => md5( $password ),
            //             'st_user_type' => $user_type,
            //             'in_contact_no' => $phone_no,
            //             'st_address_1' => $address_1,
            //             'st_address_2' => $address_2,
            //             'st_city' => $city,
            //             'st_state' => $state,
            //             'in_is_approve' => 0,
            //             'in_is_active' => 1,
            //             'st_zipcode' => $zip_code
            //         );
            //         $arr_where = array(
            //             'in_user_id' => $user_data['in_user_id']
            //         );
            //         $insert_id = $mydb->update( TBL_USER, $arr_data,$arr_where );

            //         if ( $insert_id != '' && $insert_id > 0 ) {
            //             if( isset( $user_type ) && $user_type == "driver" ){
            //                 $arr_driver_data = array(
            //                     'in_user_id' => $user_data['in_user_id'],
            //                     'in_license_no' => $license_no
            //                 );
            //                 $insert_driver_id = $mydb->update( TBL_DRIVER, $arr_driver_data,$arr_where );
            //                 $this->update_usermeta( $user_data['in_user_id'], 'user_signup_attempt' , 1 );
            //                 $this->update_usermeta( $user_data['in_user_id'], 'admin_user_reject_attempt' , 0 );
            //             }else if( isset( $user_type ) && $user_type == "business_owner" ){
            //                 $arr_bo_data = array(
            //                     'in_user_id' => $user_data['in_user_id'],
            //                     'st_business_name' => $business_name,
            //                     'in_eni_number' => $eni_no,
            //                     'st_job_title' => $job_title
            //                 );
            //                 $insert_bo_id = $mydb->update( TBL_BUSINESS_OWNER, $arr_bo_data,$arr_where );
            //                 $this->update_usermeta( $user_data['in_user_id'], 'user_signup_attempt' , 1 );
            //                 $this->update_usermeta( $user_data['in_user_id'], 'admin_user_reject_attempt' , 0 );
            //             }else if( isset( $user_type ) && $user_type == "store_manager" ){
            //                 $arr_bo_data = array(
            //                     'in_store_manager_id' => $user_data['in_user_id']
            //                 );
            //                 $arr_bo_where = array(
            //                     'in_user_id' => $bo_id
            //                 );
            //                 $insert_bo_id = $mydb->update( TBL_BUSINESS_OWNER, $arr_bo_data, $arr_bo_where );
            //             }
            //             if ( $this->flag_err == FALSE ) {
            //                 return $user_data['in_user_id'];
            //             } else {
            //                 return 0;
            //             }
            //         } else {
            //             $this->flag_err = TRUE;
            //         }
            //     }else{
            //         return -3;
            //     }
            }else if( isset( $user_username_data['in_user_id'] ) && $user_username_data['in_user_id'] != '' ){
                // if( isset( $user_username_data['in_is_active'] ) && $user_username_data['in_is_active'] == -1 ){
                //     $arr_data = array(
                //         'st_username' => $username,
                //         'st_first_name' => $firstname,
                //         'st_last_name'  => $lastname,
                //         'st_email_id' => $email,
                //         'st_password' => md5( $password ),
                //         'st_user_type' => $user_type,
                //         'in_contact_no' => $phone_no,
                //         'st_address_1' => $address_1,
                //         'st_address_2' => $address_2,
                //         'st_city' => $city,
                //         'st_state' => $state,
                //         'in_is_approve' => 0,
                //         'in_is_active' => 1,
                //         'st_zipcode' => $zip_code
                //     );
                //     $arr_where = array(
                //         'in_user_id' => $user_username_data['in_user_id']
                //     );
                //     $insert_id = $mydb->update( TBL_USER, $arr_data,$arr_where );

                //     if ( $insert_id != '' && $insert_id > 0 ) {
                //         if( isset( $user_type ) && $user_type == "driver" ){
                //             $arr_driver_data = array(
                //                 'in_user_id' => $user_username_data['in_user_id'],
                //                 'in_license_no' => $license_no
                //             );
                //             $insert_driver_id = $mydb->update( TBL_DRIVER, $arr_driver_data,$arr_where );
                //             $this->update_usermeta( $user_username_data['in_user_id'], 'user_signup_attempt' , 1 );
                //             $this->update_usermeta( $user_username_data['in_user_id'], 'admin_user_reject_attempt' , 0 );
                //         }else if( isset( $user_type ) && $user_type == "business_owner" ){
                //             $arr_bo_data = array(
                //                 'in_user_id' => $user_username_data['in_user_id'],
                //                 'st_business_name' => $business_name,
                //                 'in_eni_number' => $eni_no,
                //                 'st_job_title' => $job_title
                //             );
                //             $insert_bo_id = $mydb->update( TBL_BUSINESS_OWNER, $arr_bo_data,$arr_where );
                //             $this->update_usermeta( $user_username_data['in_user_id'], 'user_signup_attempt' , 1 );
                //             $this->update_usermeta( $user_username_data['in_user_id'], 'admin_user_reject_attempt' , 0 );
                //         }else if( isset( $user_type ) && $user_type == "store_manager" ){
                //             $arr_bo_data = array(
                //                 'in_store_manager_id' => $user_username_data['in_user_id']
                //             );
                //             $arr_bo_where = array(
                //                 'in_user_id' => $bo_id
                //             );
                //             $insert_bo_id = $mydb->update( TBL_BUSINESS_OWNER, $arr_bo_data, $arr_bo_where );
                //         }
                //         if ( $this->flag_err == FALSE ) {
                //             return $user_username_data['in_user_id'];
                //         } else {
                //             return 0;
                //         }
                //     } else {
                //         $this->flag_err = TRUE;
                //     }
                // }else{
                //     return -1;
                // }
            }else if( isset( $user_email_data['in_user_id'] ) && $user_email_data['in_user_id'] != '' ){
                if( isset( $user_email_data['in_is_active'] ) && $user_email_data['in_is_active'] == -1 ){
                    $arr_data = array(
                        'st_username' => $username,
                        'st_first_name' => $firstname,
                        'st_last_name'  => $lastname,
                        'st_email_id' => $email,
                        'st_password' => md5( $password ),
                        'st_user_type' => $user_type,
                        'in_contact_no' => $phone_no,
                        'st_address_1' => $address_1,
                        'st_address_2' => $address_2,
                        'st_city' => $city,
                        'st_state' => $state,
                        'in_is_active' => 1,
                        'in_is_approve' => 0,
                        'st_zipcode' => $zip_code
                    );
                    $arr_where = array(
                        'in_user_id' => $user_email_data['in_user_id']
                    );
                    $insert_id = $mydb->update( TBL_USER, $arr_data,$arr_where );

                    if ( $insert_id != '' && $insert_id > 0 ) {
                        if( isset( $user_type ) && $user_type == "driver" ){
                            $arr_driver_data = array(
                                'in_user_id' => $user_email_data['in_user_id'],
                                'in_license_no' => $license_no
                            );
                            $insert_driver_id = $mydb->update( TBL_DRIVER, $arr_driver_data,$arr_where );
                            $this->update_usermeta( $user_email_data['in_user_id'], 'user_signup_attempt' , 1 );
                            $this->update_usermeta( $user_email_data['in_user_id'], 'admin_user_reject_attempt' , 0 );
                        }else if( isset( $user_type ) && $user_type == "business_owner" ){
                            $arr_bo_data = array(
                                'in_user_id' => $user_email_data['in_user_id'],
                                'st_business_name' => $business_name,
                                'in_eni_number' => $eni_no,
                                'st_job_title' => $job_title
                            );
                            $insert_bo_id = $mydb->update( TBL_BUSINESS_OWNER, $arr_bo_data,$arr_where );
                            $this->update_usermeta( $user_email_data['in_user_id'], 'user_signup_attempt' , 1 );
                            $this->update_usermeta( $user_email_data['in_user_id'], 'admin_user_reject_attempt' , 0 );
                        }else if( isset( $user_type ) && $user_type == "store_manager" ){
                            $arr_bo_data = array(
                                'in_store_manager_id' => $user_email_data['in_user_id']
                            );
                            $arr_bo_where = array(
                                'in_user_id' => $bo_id
                            );
                            $insert_bo_id = $mydb->update( TBL_BUSINESS_OWNER, $arr_bo_data, $arr_bo_where );
                        }
                        if ( $this->flag_err == FALSE ) {
                            return $user_email_data['in_user_id'];
                        } else {
                            return 0;
                        }
                    } else {
                        $this->flag_err = TRUE;
                    }
                }else{
                    return -2;
                }
                
            }else{
                $arr_data = array(
                    'st_username' => $username,
                    'st_first_name' => $firstname,
                    'st_last_name'  => $lastname,
                    'st_email_id' => $email,
                    'st_password' => md5( $password ),
                    'st_user_type' => $user_type,
                    'in_contact_no' => $phone_no,
                    'st_address_1' => $address_1,
                    'st_address_2' => $address_2,
                    'st_city' => $city,
                    'st_state' => $state,
                    'in_is_active' => 1,
                    'in_is_approve' => 0,
                    'st_zipcode' => $zip_code
                );
                $insert_id = $mydb->insert( TBL_USER, $arr_data );

                if ( $insert_id !== '' && $insert_id > 0 ) {
                    if( isset( $user_type ) && $user_type == "driver" ){
                        $arr_driver_data = array(
                            'in_user_id' => $insert_id,
                            'in_license_no' => $license_no
                        );
                        $insert_driver_id = $mydb->insert( TBL_DRIVER, $arr_driver_data );
                        $this->update_usermeta( $insert_id, 'user_signup_attempt' , 1 );
                        $this->update_usermeta( $insert_id, 'admin_user_reject_attempt' , 0 );
                    }else if( isset( $user_type ) && $user_type == "business_owner" ){
                        $arr_bo_data = array(
                            'in_user_id' => $insert_id,
                            'st_business_name' => $business_name,
                            'in_eni_number' => $eni_no,
                            'st_job_title' => $job_title
                        );
                        $insert_bo_id = $mydb->insert( TBL_BUSINESS_OWNER, $arr_bo_data );
                        $this->update_usermeta( $insert_id, 'user_signup_attempt' , 1 );
                        $this->update_usermeta( $insert_id, 'admin_user_reject_attempt' , 0 );
                    }else if( isset( $user_type ) && $user_type == "store_manager" ){
                        $arr_bo_data = array(
                            'in_store_manager_id' => $insert_id
                        );
                        $arr_bo_where = array(
                            'in_user_id' => $bo_id
                        );
                        $insert_bo_id = $mydb->update( TBL_BUSINESS_OWNER, $arr_bo_data, $arr_bo_where );
                    }
                    if ( $this->flag_err == FALSE ) {
                        return $insert_id;
                    } else {
                        return 0;
                    }
                } else {
                    $this->flag_err = TRUE;
                }
            }
        }
    }
    
    function add_sm_user($data) {
        if (isset($data) && is_array($data)) {
            $email = ( isset($data['txt_email_address'] ) && trim( $data['txt_email_address'] ) !== '' ) ? trim( $data['txt_email_address'] ) : '';
            $password = ( isset($data['txt_pwd'] ) && trim( $data['txt_pwd'] ) !== '' ) ? trim( $data['txt_pwd'] ) : '';
            $bo_id = ( isset($data['user_id'] ) && trim( $data['user_id'] ) > 0 ) ? trim( $data['user_id'] ) : 0;
            $store_manager_id = ( isset($data['sm_id'] ) && trim( $data['sm_id'] ) > 0 ) ? trim( $data['sm_id'] ) : 0;
            $user_type = ( isset( $data['txt_user_type'] ) && trim( $data['txt_user_type'] ) !== '' ) ? trim( $data['txt_user_type'] ) : '';

            global $mydb;
            
            $str_email_query = 'SELECT * FROM ' .$mydb->prefix . TBL_USER . ' WHERE st_email_id = "' .$email .'"';
       
            $user_email_data = $mydb->query( $str_email_query );
            $str_sm_query = 'SELECT * FROM ' .$mydb->prefix . TBL_USER . ' WHERE st_email_id = "' .$email .'" AND in_user_id=' .$store_manager_id .'';
       
            $user_sm_data = $mydb->query( $str_sm_query );
            
            if( isset( $user_sm_data['in_user_id'] ) && $user_sm_data['in_user_id'] > 0 ){
                $sm_id = $this->get_bo_data_by_key( $bo_id, 'in_store_manager_id' );
                $sm_where = array(
                    'in_user_id' => $sm_id
                );
                $arr_data = array(
                    'st_password' => md5( $password ),
                    'st_user_type' => $user_type
                );
                $check_sm_exist = $this->get_user_data_by_key( $sm_id, 'in_user_id' );
                if( isset( $check_sm_exist ) && $check_sm_exist > 0 ){
                    $insert_id = $mydb->update( TBL_USER, $arr_data, $sm_where );
                    if( $insert_id > 0 ){
                        $insert_id = $sm_id;
                    }
                }else{
                    $insert_id = $mydb->insert( TBL_USER, $arr_data );
                }
                if ( $insert_id !== '' && $insert_id > 0 ){
                    $arr_bo_data = array(
                        'in_store_manager_id' => $insert_id,
                        'st_sm_password' => $password
                    );

                    $arr_bo_where = array(
                        'in_user_id' => $bo_id
                    );
                    $insert_bo_id = $mydb->update( TBL_BUSINESS_OWNER, $arr_bo_data, $arr_bo_where );
                    
                    if ( $this->flag_err == FALSE ) {
                        return $insert_id;
                    } else {
                        return 0;
                    }
                } else {
                    $this->flag_err = TRUE;
                }
                
            }else if( isset( $user_email_data['in_user_id'] ) && $user_email_data['in_user_id'] != '' ){
                return -2;
            }else{
                $sm_id = $this->get_bo_data_by_key( $bo_id, 'in_store_manager_id' );
                $sm_where = array(
                    'in_user_id' => $sm_id
                );
                $arr_data = array(
                    'st_email_id' => $email,
                    'st_password' => md5( $password ),
                    'st_user_type' => $user_type
                );
                $check_sm_exist = $this->get_user_data_by_key( $sm_id, 'in_user_id' );
                if( isset( $check_sm_exist ) && $check_sm_exist > 0 ){
                    $insert_id = $mydb->update( TBL_USER, $arr_data, $sm_where );
                    if( $insert_id > 0 ){
                        $insert_id = $sm_id;
                    }
                }else{
                    $insert_id = $mydb->insert( TBL_USER, $arr_data );
                }
                if ( $insert_id !== '' && $insert_id > 0 ) {
                    $arr_bo_data = array(
                        'in_store_manager_id' => $insert_id,
                        'st_sm_password' => $password
                    );

                    $arr_bo_where = array(
                        'in_user_id' => $bo_id
                    );
                    $insert_bo_id = $mydb->update( TBL_BUSINESS_OWNER, $arr_bo_data, $arr_bo_where );
                    
                    if ( $this->flag_err == FALSE ) {
                        return $insert_id;
                    } else {
                        return 0;
                    }
                } else {
                    $this->flag_err = TRUE;
                }
            }
        }
    }
    
    function get_bo_data_by_key( $user_id, $key = '' ) {
        global $mydb;
        if( isset( $user_id ) && trim( $user_id ) !== '' && $user_id > 0 ){
            $select = '*';
            $where = ' WHERE in_user_id = ' . $user_id;
            if( isset( $key ) && trim( $key ) !== '' ){
                $select = $key;
            }
            $str_query = 'SELECT ' . $select . ' FROM ' . $mydb->prefix . TBL_BUSINESS_OWNER . $where;
            $response = $mydb->query( $str_query );
           
            if ( $response != 0 && count( $response ) > 0) { 
                if( trim( $key ) !== '' ){
                    return $response[$key];
                } else {
                    return $response;
                }
            }
        }
    }
    
    public function get_bo_data_by( $key = '', $value = '' ) {

        global $mydb;

        $str_query = 'SELECT * from ' . $mydb->prefix . TBL_BUSINESS_OWNER . ' WHERE ' . $key . ' = "' . $value . '"';

        $response = $mydb->query($str_query);

        if ($response != 0 && count($response) > 0) {
            return $response;
        }
    }
    
    function get_user_data_by_key( $user_id, $key = '' ) {
        global $mydb;
        if( isset( $user_id ) && trim( $user_id ) != '' && $user_id > 0 ){
            $select = '*';
            $where = ' WHERE in_user_id = ' . $user_id;
            if( isset( $key ) && trim( $key ) !== '' ){
                $select = $key;
            }
            $str_query = 'SELECT ' . $select . ' FROM ' . $mydb->prefix . TBL_USER . $where;
            $response = $mydb->query( $str_query );
           
            if ( $response != 0 && count( $response ) > 0) { 
                if( trim( $key ) !== '' ){
                    return $response[$key];
                } else {
                    return $response;
                }
            }
        }
    }
    
    function get_driver_data_by_key( $user_id, $key = '' ) {
        global $mydb;
        if( isset( $user_id ) && trim( $user_id ) !== '' && $user_id > 0 ){
            $select = '*';
            $where = ' WHERE in_user_id = ' . $user_id;
            if( isset( $key ) && trim( $key ) !== '' ){
                $select = $key;
            }
            $str_query = 'SELECT ' . $select . ' FROM ' . $mydb->prefix . TBL_DRIVER . $where;
            $response = $mydb->query( $str_query );
           
            if ( $response != 0 && count( $response ) > 0) { 
                if( trim( $key ) !== '' ){
                    return $response[$key];
                } else {
                    return $response;
                }
            }
        }
    }
    
    public function get_user_data_by( $key = '', $value = '' ) {

        global $mydb;

        $str_query = 'SELECT * from ' . $mydb->prefix . TBL_USER . ' WHERE ' . $key . ' = "' . $value . '"';

        $response = $mydb->query($str_query);

        if ($response != 0 && count($response) > 0) {
            return $response;
        }
    }
    
    function add_user_data( $user_id = 0, $key = '', $value = '' ) {
        if ($user_id > 0 && trim($key) !== '') {
            global $mydb;
           $where = array(
                'in_user_id' => $user_id
            );
            
            $arr_data = array(
                'in_user_id' => $user_id,
                $key => $value
            );
            $insert_id = $mydb->insert(TBL_USERMETA, $arr_data);
            if ($insert_id != 0 && $insert_id > 0) {
                return( $insert_id );
            } else {
                return 0;
            }
        }
    }

    
    function update_userdata( $user_id = 0, $key = '', $value = '' ) {
        if ( $user_id > 0 && trim( $key ) !== '') {
            global $mydb;
            $update = FALSE;
            $where = array(
                'in_user_id' => $user_id
            );
            
            $arr_data = array(
                $key => $value
            );
            $update_id = $mydb->update( TBL_USER, $arr_data, $where );
            if ( $update_id != 0 && $update_id > 0 ) {
                return( $update_id );
            } else {
                return 0;
            }
        }
    }
    
    public function send_confirmation_data( $user_id = '' ) {
        include_once FL_HTML_TEMPLATE;
        $template = new template();
        $current_time = time();
        $key = md5( $user_id . $current_time );

        if (isset( $user_id ) ) {

            $user_link = $this->get_user_data_by_key( $user_id, 'link_data' );
            $user_data = $this->get_user_data_by('in_user_id', $user_id );
            $meta_key = "link_data";
            $meta_value = array( "generated_key" => $key,
                "generated_time" => $current_time,
                "link_verified" => 0 );

            $email = $user_data['st_email_id'];
            if ( MAIL_MODE == 'test' ) {
                $send_email_id = TEST_EMAIL;
            } else {
                $send_email_id = $email;
            }
            if ( isset( $user_link ) && trim( $user_link ) != '' ) {

                $this->update_userdata( $user_id, $meta_key, json_encode( $meta_value ) );

                $data = array( "user_name" => $user_data['st_first_name'],
                     "site_url" => BASE_URL,
                     "base_url" => SITE_NAME ,
                    "send_link" => VW_VARIFICATION . "?id=" . $user_id . "&k=" . $key );
                $email_templet = $template->get_template('email', '', 'signup_resend_verification', TRUE);
                
                $this->send_mail_by_template( $user_id, $send_email_id, 'Cop Express Registration Link Verification', $email_templet, $data);
            } else {
                $this->update_userdata( $user_id, $meta_key, json_encode( $meta_value ) );

                $data = array("user_name" => $user_data['st_first_name'],
                    "site_url" => BASE_URL,
                    "base_url" => SITE_NAME ,
                    "send_link" => VW_VARIFICATION . "?id=" . $user_id . "&k=" . $key);
                $email_templet = $template->get_template('email', '', 'signup_resend_verification', TRUE);
                
                $this->send_mail_by_template( $user_id, $send_email_id, 'Cop Express Registration Link Verification', $email_templet, $data);

           }
        }
    }
    
    public function send_bo_sm_confirmation_data( $user_id = 0, $sm_id = 0 ) {
        include_once FL_HTML_TEMPLATE;
        $template = new template();
        $current_time = time();
        $key = md5( $user_id . $current_time );

        if (isset( $user_id ) ) {

            $user_link = $this->get_bo_data_by_key( $user_id, 'sm_link_data' );
            $sm_password = $this->get_bo_data_by_key( $user_id, 'st_sm_password' );
            $user_data = $this->get_user_data_by('in_user_id', $user_id );
            $sm_data = $this->get_user_data_by('in_user_id', $sm_id );
            $meta_key = "sm_link_data";
            $meta_value = array( "generated_key" => $key,
                "generated_time" => $current_time,
                "link_verified" => 0 );

            $email = $user_data['st_email_id'];
            if ( MAIL_MODE == 'test' ) {
                $send_email_id = TEST_EMAIL;
            } else {
                $send_email_id = $user_data['st_email_id'];
            }
            if ( isset( $user_link ) && trim( $user_link ) != '' ) {

                $decode_data = json_decode( $user_link, TRUE );

                if ( $decode_data['link_verified'] == 0 ) {

                    $this->update_bo_data( $user_id, $meta_key, json_encode( $meta_value ) );

                    $data = array( 
                            "user_name" => $user_data['st_first_name'],
                            "sm_email" => $sm_data['st_email_id'],
                            "sm_password" => $sm_password,
                            "base_url" => SITE_NAME,
                        );
                    $email_reset_templet = $template->get_template( 'email', '', 'sm_signup_send_verification', TRUE);
                    
                    $this->send_mail_by_template( $user_id, $send_email_id, 'Store Manger Account Verification', $email_reset_templet, $data );
                }
            } else {
                $this->update_bo_data( $user_id, $meta_key, json_encode( $meta_value ) );

                $data = array( "user_name" => $user_data['st_first_name'],
                        "sm_email" => $sm_data['st_email_id'],
                        "sm_password" => $sm_password,
                        "base_url" => SITE_NAME,
                        );
                $email_reset_templet = $template->get_template( 'email', '', 'sm_signup_send_verification', TRUE);

                $this->send_mail_by_template( $user_id, $send_email_id, 'Store Manger Account Verification', $email_reset_templet, $data );
            }
        }
    }
    
    function update_bo_data( $user_id = 0, $key = '', $value = '' ) {
        if ( $user_id > 0 && trim( $key ) !== '') {
            global $mydb;
            $update = FALSE;
            $where = array(
                'in_user_id' => $user_id
            );
            
            $arr_data = array(
                $key => $value
            );
            $update_id = $mydb->update( TBL_BUSINESS_OWNER, $arr_data, $where );
            if ( $update_id != 0 && $update_id > 0 ) {
                return( $update_id );
            } else {
                return 0;
            }
        }
    }
    
    function send_mail_by_template( $user_id = 0, $email_id = '', $boby = '', $tmp_template = '', $body_data = '' ) {
        include_once FL_NOTIFICATION;
        $notification = new notification();
        $email_body = $notification->prepare_notify_message( $user_id, $tmp_template, $body_data );
        $mail_id = $this->send_mail( $email_id, $boby, $email_body );
        return $mail_id;
    }
    
    public function send_mail( $email = '', $subject = '', $body = '' ) {
        if (isset( $email ) && trim( $email ) != "" && filter_var( $email, FILTER_VALIDATE_EMAIL ) && isset( $body ) && trim( $body ) != "" ) {
            include_once PL_MAILER . '/src/Exception.php';
            include_once PL_MAILER . '/src/PHPMailer.php';
            include_once PL_MAILER . '/src/SMTP.php';

            $mail = new PHPMailer();
            $new_body = '';
            $mail->IsSMTP();
            $mail->SMTPSecure = SMTP_SECURE;
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER_NAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->Port = SMTP_PORT;
            $mail->From = SMTP_USER_NAME;
            $mail->FromName = SMTP_FROM_NAME;
            $mail->addAddress($email);
            $mail->IsHTML(true);
            $mail->AddReplyTo( SMTP_USER_NAME );
            $mail->smtpConnect([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ]);
            $mail->Subject = $subject;
            $mail->AddEmbeddedImage( IMAGES_PATH . 'logo-new.png' , 'logo' );       
            $img_body = "<img src='cid:logo' style='max-width:250px;'>"; 
            $new_body .= $img_body;
            $new_body .= $body;
            $mail->Body = $new_body;
            $mail->AltBody = "This is the body in plain text for non-HTML mail clients ";
            $mail_id = $mail->Send();
            if ( !$mail_id ) {
                return $mail->ErrorInfo;
            } else {
                return $mail_id;
            }
        }
    }
    
    public function get_register_verification_data( $id = '', $keys = '', $type = '' ) {
        $user_id = isset( $_GET['id'] ) && $_GET['id'] != '' ? $_GET['id'] : '';
        if ( isset( $id ) && $id == $user_id ) {

            $user_id = $this->get_user_data_by( 'in_user_id', $id );

            if ( isset( $user_id ) ) {
                if( $type == "change_password" ){
                    $user_link = $this->get_user_meta( $id, 'ch_pwd_varification_link_data', TRUE ); 
                } else if( $type == "change_email" ){
                    $user_link = $this->get_user_meta( $id, 'ch_email_varification_link_data', TRUE ); 
                }else {
                    $user_link = $this->get_user_data_by_key( $id, 'link_data', true );
                }
                 
                $user_verification = json_decode( $user_link, true );
                if ( strcmp( $user_verification["generated_key"], $keys ) == 0 && isset( $user_verification["generated_key"] ) ) {
                    $mail_type = "";
                    $current_time = time();
                    $varified_time = $user_verification["generated_time"] + ( 24 * 60 * 60 );
                    if ( $current_time < $varified_time && $user_verification["link_verified"] == 0  ) {
                        $data = array( "generated_key" => $user_verification["generated_key"],
                            "generated_time" => $user_verification["generated_time"],
                            "link_verified" => 1 );
                        if( $type == "change_password" ){
                            $update_id = $this->update_usermeta( $id, 'ch_pwd_varification_link_data', json_encode( $data ) ); 
                            if( isset( $update_id ) && $update_id > 0 ){
                                $mail_type = 'change_password';
                            }
                            
                        }else if( $type == "change_email" ){
                            $data = array( "generated_key" => $user_verification["generated_key"],
                                "generated_time" => $user_verification["generated_time"],
                                "email_id" => $user_verification["email_id"] ,
                                "link_verified" => 1 );
                            if( isset( $user_verification["email_id"] ) && $user_verification["email_id"] != ''){
                                $this->update_userdata( $id, 'st_email_id' ,$user_verification["email_id"] );
                                $update_id = $this->update_usermeta( $id, 'ch_email_varification_link_data', json_encode( $data ) );
                                $mail_type = 'change_email';
                            }
                        }else {
                            $mail_type = '';
                            $update_id = $this->update_userdata( $user_id['in_user_id'], 'link_data', json_encode( $data ) );
                        }
                        if( $update_id > 0 ){
                            $this->result['type'] = $mail_type;
                            $this->result['success_flag'] = 0;
                            $this->result['message'] = 'Congratulations, your account has been approved.';
                        }else{
                            $this->result['success_flag'] = 1;
                            $this->result['type'] = $mail_type;
                            $this->result['message'] = 'Sorry Your link is broken !! Please Try again';
                        }
                        return $this->result;
                    } else {
                        $msg = "<div id='new_msg'>Sorry your link has expired !!! </div>";
                        $this->result['type'] = $mail_type;
                        $this->result['success_flag'] = 1;
                        $this->result['message'] = $msg;
                        return $this->result;
                    }
                } else {
                    $this->result['success_flag'] = 1;
                    $this->result['message'] = 'Sorry Your link is broken !! Please Try again';
                    return $this->result;
                }
            }
        } else {
            $this->result['success_flag'] = 1;
            $this->result['message'] = 'Please verify your email address !!';
            return $this->result;
        }
    }
    
    public function get_admin_user_list() {
        global $mydb;
        
        $str_query = 'SELECT * from ' . $mydb->prefix . TBL_USER . ' WHERE st_user_type != "admin"  AND st_user_type != "store_manager" AND in_is_active = 1 OR in_is_active = -2 '; 
        $response = $mydb->query( $str_query );
        if( isset( $response['in_user_id'] ) ){
            $response = array( $response );
        }
        if ( $response != 0 && count( $response ) > 0 ) {
            return $response;
        }
    }
    
    function get_user_meta( $user_id, $meta_key = '', $single = FALSE ) {
        
        global $mydb;
        if ($user_id > 0) {
            $where = '';
            $select = 'st_meta_value';
            if ( trim($meta_key) == '' ) {
                $select = 'st_meta_key, st_meta_value';
            }
            if ( trim($meta_key) !== '' ) {
                $where .= ' AND st_meta_key = "' . $meta_key . '"';
            }
            $str_query = 'SELECT ' . $select . ' FROM ' . $mydb->prefix . TBL_USERMETA . ' WHERE  in_user_id = ' . $user_id . $where;
           
            $response = $mydb->query( $str_query );
            
            if ( $response != 0 && count( $response ) > 0 ) {

                
                if ($single == FALSE) {
                    return $response;
                } else {
                    if (isset($response['st_meta_value'])) {
                        return $response['st_meta_value'];
                    } else {
                        $arr_all_meta = array();
                        foreach ($response as $rk => $rv) {
                            $arr_all_meta[$rv['st_meta_key']] = $rv['st_meta_value'];
                        }

                        return $arr_all_meta;
                    }
                }
            }
        }
    }
    
    function update_usermeta( $user_id = 0, $key = '', $value = '' ) {
        if ( $user_id > 0 && trim( $key ) !== '' ) {
            global $mydb;
            $update = FALSE;
            $sl_where = array(
                'in_user_id' => $user_id,
                'st_meta_key' => $key
            );
            $user_meta = $mydb->get_all( TBL_USERMETA, 'st_meta_key, st_meta_value', $sl_where );
            
            
            if ( $user_meta != 0 && count( $user_meta ) > 0 ) {
                $update = TRUE;
            }
            if ( $update == TRUE ) {
                $arr_data = array(
                    'st_meta_value' => $value
                );
                $where = array(
                    'in_user_id' => $user_id,
                    'st_meta_key' => $key
                );

                $update_id = $mydb->update(TBL_USERMETA, $arr_data, $where);
                
                if ( $update_id != 0 && $update_id > 0 ) {
                    return( $update_id );
                } else {
                    return 0;
                }
            } else {
                return $this->add_user_meta($user_id, $key, $value);
            }
        }
    }
    
    function add_user_meta( $user_id = 0, $key = '', $value = '' ) {
        if ( $user_id > 0 && trim( $key ) !== '' ) {
            global $mydb;
            $arr_data = array(
                'in_user_id' => $user_id,
                'st_meta_key' => $key,
                'st_meta_value' => $value
            );
            $insert_id = $mydb->insert( TBL_USERMETA, $arr_data );
            if ( $insert_id != 0 && $insert_id > 0 ) {
                return( $insert_id );
            } else {
                return 0;
            }
        }
    }
    
    public function send_change_password_link( $user_id  ) {
        
        if( isset( $user_id ) && $user_id != '' ) {
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            if ( !session_id() ) {
                session_start();
            } 
            $user_type = isset( $_SESSION['user_type'] ) && $_SESSION['user_type'] != '' ? $_SESSION['user_type'] : '';
            global $mydb;
            if( $user_type ==  "driver" ||  $user_type == "business_owner" ||  $user_type == "admin" ) {
                $id = $user_id;
                $usermeta_info = $this->get_user_meta( $id , 'ch_pwd_varification_link_data', TRUE );
                $user_data = $this->get_user_data_by('in_user_id', $user_id );
                
                $email = $user_data['st_email_id'];
                if ( MAIL_MODE == 'test' ) {
                    $send_email_id = TEST_EMAIL;
                } else {
                    $send_email_id = $email;
                }
                if ( isset( $usermeta_info[0]['st_meta_value'] ) ){
                    $varification_data = json_decode( $usermeta_info[0]['st_meta_value'] );
                    $link_varified = $varification_data->link_verified;
                    $current_time = time();
                    $key = md5( $id . '-' . $current_time );
                    $meta_key = "ch_pwd_varification_link_data";
                    $meta_value = array( "generated_key" => $key,
                            "generated_time" => $current_time,
                            "link_verified" => 0 );
                    $where = array('id'=> $id ,
                                    'st_meta_key' => 'ch_pwd_varification_link_data'  
                                );
                    $insert_meta_data = $this->update_usermeta( $id , 'ch_pwd_varification_link_data', json_encode( $meta_value ) );
                    
                    $data = array( "base_url" => SITE_NAME,
                                    "link" => VW_VARIFICATION . 
                                    "?id=" . $id . "&type=change_password&k=" . $key
                                );
                    $email_reset_templet = $template->get_template( 'email', '', 'change_password', TRUE );

                    $mail_id = $this->send_mail_by_template( $user_id, $send_email_id, 'Cop Express Change Passwprd Link verification', $email_reset_templet, $data );
                    
                    $this->update_usermeta( $user_id, $meta_key, json_encode( $meta_value ) );

                    return $mail_id;
                }else{
                    
                    $current_time = time();
                    $key = md5( $id . '-' . $current_time );
                    $meta_key = "ch_pwd_varification_link_data";
                    $meta_value = array( "generated_key" => $key,
                            "generated_time" => $current_time,
                            "link_verified" => 0 );
                    $this->update_usermeta( $user_id, $meta_key, json_encode( $meta_value ) );
                    $data = array( "base_url" => SITE_NAME,
                                    "link" => VW_VARIFICATION . 
                                    "?id=" . $id . "&type=change_password&k=" . $key
                                );
                    $email_reset_templet = $template->get_template( 'email', '', 'change_password', TRUE );
                    $mail_id = $this->send_mail_by_template( $user_id, $send_email_id, SITE_NAME . ' Change Password Link verification', $email_reset_templet, $data );
                    return $mail_id;
                }
            }
        }
        return false;
    }
    
    public function send_change_email_link( $user_id, $email_id  ) {

        if( isset( $user_id ) && $user_id != '' ) {
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            $user_type = isset( $_SESSION['user_type'] ) && $_SESSION['user_type'] != '' ? $_SESSION['user_type'] : '';
            if ( !session_id() ) {
                session_start();
            }
            global $mydb;
            if( $user_type ==  "driver" ||  $user_type == "business_owner" ) {
                $id = $user_id;
                $str_email_query = 'SELECT * FROM ' .$mydb->prefix . TBL_USER . ' WHERE st_email_id = "' .$email_id .'"';
       
                $user_email_data = $mydb->query( $str_email_query );
                if( isset( $user_email_data['in_user_id'] ) && $user_email_data['in_user_id'] != '' ){
                    return -1;
                }else{
                    $usermeta_info = $this->get_user_meta( $id ,'ch_email_varification_link_data', TRUE );
                    $user_data = $this->get_user_data_by( 'in_user_id', $id );

                    $email = $user_data['st_email_id'];
                    if ( MAIL_MODE == 'test' ) {
                        $send_email_id = TEST_EMAIL;
                    } else {
                        $send_email_id = $email;
                    }
                    if ( isset( $usermeta_info['st_meta_value'] ) ){
                        $varification_data = json_decode( $usermeta_info['st_meta_value'] );
                        $link_varified = $varification_data->link_verified;
                        $current_time = time();
                        $key = md5( $id . '-' . $current_time );
                        $meta_key = "ch_email_varification_link_data";
                        $meta_value = array( "generated_key" => $key,
                                "generated_time" => $current_time,
                                "email_id" => $email_id,
                                "link_verified" => 0 );
                        $where = array( 'id'=> $id ,
                                        'st_meta_key' => 'ch_email_varification_link_data'  
                                    );
                        $insert_meta_data = $this->update_usermeta( $id , 'ch_email_varification_link_data', json_encode( $meta_value ) );

                        $data = array( "user_name" => $user_data['st_first_name'],
                                        "site_url" => BASE_URL,
                                        "send_link" => VW_VARIFICATION . 
                                        "?id=" . $id . "&type=change_email&k=" . $key
                                    );
                        $email_reset_templet = $template->get_template( 'email', '', 'signup_resend_verification', TRUE );

                        $mail_id = $this->send_mail_by_template( $user_id, $send_email_id, 'Cop Express Change Email Link verification', $email_reset_templet, $data );

                        $this->update_usermeta( $user_id, $meta_key, json_encode( $meta_value ) );

                        return $mail_id;
                    }else{
                        $current_time = time();
                        $key = md5( $id . '-' . $current_time );
                        $meta_key = "ch_email_varification_link_data";
                        $meta_value = array( "generated_key" => $key,
                                "generated_time" => $current_time,
                                "email_id" => $email_id,
                                "link_verified" => 0 );
                        $this->update_usermeta( $id, $meta_key, json_encode( $meta_value ) );
                        $data = array( "user_name" => $user_data['st_first_name'],
                                        "site_url" => BASE_URL,
                                        "send_link" => VW_VARIFICATION . 
                                        "?id=" . $id . "&type=change_email&k=" . $key
                                    );
                        $email_reset_templet = $template->get_template( 'email', '', 'signup_resend_verification', TRUE );

                        $mail_id =  $this->send_mail_by_template( $user_id, $send_email_id, 'Cop Express Change Email Link verification', $email_reset_templet, $data );

                        return $mail_id ;
                    }
                }
            }
        }
        return false;
    }
    
    public function search_user_by_type( $type = '' ,$user_name ){
        if( isset( $type ) && $type != '' ){
            global $mydb;
            $str_user_name = '';
            if( isset( $user_name ) && $user_name != "" ){
                $str_user_name = " AND st_first_name LIKE '%" . $user_name ."%' ";
            }
            $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_USER . ' WHERE  st_user_type = "' . $type  . '" ' . $str_user_name. ' AND in_is_active = 1 ';
           
            $user_data = $mydb->query( $str_query );
            if( isset( $user_data ) ){
                if( isset( $user_data['in_user_id'] ) ){
                    $user_data = array( $user_data );
                }
                return $user_data;
            }else{
                return '';
            }
        }
        return '';
    }
    public function get_user_bankdetails( $user_id ){
        if ( isset( $user_id ) && $user_id != "" ){
            global $mydb;
            $where = array( 
                'in_user_id'=> $user_id 
            );
            $user_data = $mydb->get_all( TBL_BUSINESS_OWNER, '*', $where );
            if( isset( $user_data ) && is_array( $user_data ) ){
                return $user_data;
            }else{
                return '';
            }
        }
    }
    
    public function get_user_by_id( $user_id = 0 ){
        if ( isset( $user_id ) && $user_id > 0 ){
            global $mydb;
            $where = array( 
                'in_user_id'=> $user_id 
            );
            $user_data = $mydb->get_all( TBL_USER, '*', $where );
            if( isset( $user_data ) && $user_data != '' ){
                if( $user_data['st_user_type'] == "business_owner" ){
                    $where = array( 
                        'in_user_id'=> $user_data['in_user_id'] 
                    );
                    $user_data['other_info'] = $mydb->get_all( TBL_BUSINESS_OWNER, '*', $where );
                }else{
                    $where = array( 
                        'in_user_id'=> $user_data['in_user_id'] 
                    );
                    $user_data['other_info'] = $mydb->get_all( TBL_DRIVER, '*', $where );
                }
                return $user_data;
            }else{
                return '';
            }
        }
    }
    
    public function send_confirmation_contact_data( $contact_id = 0 ){
        if( isset( $contact_id ) &&  $contact_id > 0 ){
            global $mydb;
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            $where = array( 
                'in_contact_id' => $contact_id
            );
            $contact_data = $mydb->get_all( TBL_CONTACT, '*', $where );
            
            $site_data = array( 
                "firstname" => $contact_data['st_first_name'],
                "lastname" => $contact_data['st_last_name'],
                "email_address" => $contact_data['st_email_id'] ,
                "phone_number" => $contact_data['in_contact_no'] ,
                "base_url" => SITE_NAME ,
                "how_can_we_help" => $contact_data['st_description']
                
            );
            $site_data_templete = $template->get_template( 'email', '', 'send_contact_mail_to_site', TRUE );
            $mail_id =  $this->send_mail_by_template( $contact_id, SMTP_USER_NAME, 'Contact form submission ', $site_data_templete, $site_data );
            
            $contact_user_data = array( 
                "firstname" => $contact_data['st_first_name'],
                "base_url" => SITE_NAME
            );
            $contact_user_data_templete = $template->get_template( 'email', '', 'send_contact_mail_to_user', TRUE );
            $mail_id =  $this->send_mail_by_template( $contact_id, $contact_data['st_email_id'], ' Thank you for submission', $contact_user_data_templete, $contact_user_data );

            return $mail_id ;
        }
    }
    
}