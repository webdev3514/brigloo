<?php
require_once 'config/config.php';

$ajax = new user_ajax();

if ( isset ( $_REQUEST['term'] ) &&  isset ( $_REQUEST['type'] ) ) {
    $ajax->search_user( $_REQUEST );
}

if( isset( $_POST['action'] ) && trim( $_POST['action'] ) !== '' ) {
    switch ( $_POST['action'] ) {
        case 'user_login' :
            if ( isset( $_POST['txt_email'] ) && trim($_POST['txt_email']) !== '' && isset( $_POST['txt_password'] ) && trim( $_POST['txt_password'] ) !== '' ) {
                $ajax->user_login( $_POST['txt_email'], $_POST['txt_password']);
            }
            break;
        case 'add_driver' :
            $ajax->add_driver( $_POST );
            break;
        case 'add_business_owner' :
            $ajax->add_business_owner( $_POST );
            break;
        case 'user_approve' :
            $ajax->user_approve( $_POST );
            break;
        case 'user_reject' :
            $ajax->user_reject( $_POST );
            break;
        case 'update_driver' :
            $ajax->update_driver( $_POST );
            break;
        case 'update_business_owner' :
            $ajax->update_business_owner( $_POST );
            break;
        case 'send_change_password_link' :
            $ajax->send_change_password_link( $_POST );
            break;
        case 'send_change_email_link' :
            $ajax->send_change_email_link( $_POST );
            break;
        case 'add_location' :
            $ajax->add_location( $_POST );
            break;
        case 'edit_location' :
            $ajax->edit_location( $_POST );
            break;
        case 'get_location_by_id' :
            $ajax->get_location_by_id( $_POST );
            break;
        case 'delete_location' :
            $ajax->delete_location( $_POST );
            break;
        case 'change_password' :
            $ajax->change_password( $_POST );
            break;
        case 'add_pickup' :
            $ajax->add_pickup( $_POST );
            break;
        case 'driver_request' :
            $ajax->driver_request( $_POST );
            break;
        case 'change_driver_job_status' :
            $_POST = array_map( 'trim', $_POST );
            $ajax->change_driver_job_status( $_POST );
            break;
        case 'add_store_manager' :
            $ajax->add_store_manager( $_POST );
            break;
        case 'update_bank_detail' :
            $ajax->update_bank_detail( $_POST );
            break;
        case 'sm_resend_mail' :
            $ajax->sm_resend_mail( $_POST );
            break;
        case 'sm_verify_driver_info' :
            $ajax->sm_verify_driver_info( $_POST );
            break;
        case 'check_sm_verify' :
            $ajax->check_sm_verify( $_POST );
            break;
        case 'check_store_manager_verify' :
            $ajax->check_store_manager_verify( $_POST );
            break;
        case 'driver_job_complete' :
            $ajax->driver_job_complete( $_POST );
            break;
        case 'ch_arrived_at_bank' :
            $ajax->ch_arrived_at_bank( $_POST );
            break;
        case 'resend_signup_link' :
            $ajax->resend_signup_link( $_POST );
            break;
        case 'get_drivers_info' :
            $ajax->get_drivers_info( $_POST );
            break;
        case 'add_change_order' :
            $ajax->add_change_order( $_POST );
            break;
        case 'change_order_approve' :
            $ajax->change_order_approve( $_POST );
            break;
        case 'change_order_reject' :
            $ajax->change_order_reject( $_POST );
            break;
        case 'change_order_request_days' :
            $ajax->change_order_request_days( $_POST );
            break;
        case 'admin_other_setting' :
            $ajax->admin_other_setting( $_POST );
            break;
        case 'add_job_start' :
            $ajax->add_job_start( $_POST );
            break;
        case 'all_driver_request' :
            $ajax->all_driver_request( $_POST );
            break;
        case 'driver_assign_job' :
            $ajax->driver_assign_job( $_POST );
            break;
        case 'cancel_pickup_list' :
            $ajax->cancel_pickup_list( $_POST );
            break;
        case 'job_reassign_driver' :
            $ajax->job_reassign_driver( $_POST );
            break;
        case 'driver_pay_amounts' :
            $ajax->driver_pay_amounts( $_POST );
            break;
        case 'get_job_lat_long' :
            $ajax->get_job_lat_long( $_POST );
            break;
        case 'get_pickup_info' :
            $ajax->get_pickup_info( $_POST );
            break;
        case 'get_job_info' :
            $ajax->get_job_info( $_POST );
            break;
        case 'get_user_info' :
            $ajax->get_user_info( $_POST );
            break;
        case 'cancel_recurring' :
            $ajax->cancel_recurring( $_POST );
            break;
        case 'get_recurring_by_id' :
            $ajax->get_recurring_by_id( $_POST );
            break;
        case 'edit_recurring' :
            $ajax->edit_recurring( $_POST );
            break;
        case 'user_delete' :
            $ajax->user_delete( $_POST );
            break;
        case 'user_disable' :
            $ajax->user_disable( $_POST );
            break;
        case 'user_enable' :
            $ajax->user_enable( $_POST );
            break;
        case 'check_driver_verify' :
            $ajax->check_driver_verify( $_POST );
            break;
        case 'add_contact_data' :
            $ajax->add_contact_data( $_POST );
            break;
        case 'edit_change_order_data' :
            $ajax->edit_change_order_data( $_POST );
            break;
        case 'verify_driver_sm_info' :
            $ajax->verify_driver_sm_info( $_POST );
            break;
        case 'edit_change_order' :
            $ajax->edit_change_order( $_POST );
            break;
        case 'driver_stop_job' :
            $ajax->driver_stop_job( $_POST );
            break;
        case 'load_location_bo' :
            $ajax->load_location_bo( $_POST );
            break;
        case 'load_location_data' :
            $ajax->load_location_data( $_POST );
            break;
        case 'add_group' :
            $ajax->add_group( $_POST );
            break;
        case 'edit_group' :
            $ajax->edit_group( $_POST );
            break;
        case 'get_group_info' :
            $ajax->get_group_info( $_POST );
            break;
        case 'driver_mid_point_status' :
            $ajax->driver_mid_point_status( $_POST );
            break;
        case 'forgot_password' :            
            $ajax->forgot_password( $_POST );            
            break;    
        case 'recovery_password':
            $ajax->recovery_password( $_POST );
            break;
        case 'driver_resume_pickup' :
            $ajax->driver_resume_pickup( $_POST );
            break;
        case 'delivery_change_order_direct' :
            $ajax->delivery_change_order_direct( $_POST );
            break;
        default :
            die(0);
    }
}

class user_ajax {

    public function __construct() {
        $this->result['success_flag'] = false;
        $this->result['message'] = '';
        $this->result['data'] = array();
//        $_POST = array_map( 'trim', $_POST );
    }
    
    public function user_login( $id, $password ) {
        global $mydb;
        $where = array( 
            'st_email_id' => $id,
            'in_is_active' => 1,
            'st_password' => md5( $password )
        );
        
        $response = $mydb->get_all( TBL_USER, 'in_user_id,in_is_active, st_user_type, link_data', $where );
        
        if ( $response != 0 && count( $response ) > 0 ) {
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_USER;
            $user = new user();
            include_once FL_LOCATION;
            $location = new location();
            $cookie_name = 'pnd_logged';
            $sess_id = session_id();
            $user_id = $response['in_user_id'];
            $current_time = time();
            $key = md5( $sess_id . $user_id . $current_time );
            $cookie_value = array(
                'id' => $user_id,
                'session_id' => $sess_id,
                'key' => $key
            );
            $varification_data = json_decode( $response['link_data'] );
            if ( $response['st_user_type'] == 'store_manager' ) {
                if( $response['in_is_active'] == 1 ){
                    $_SESSION['user_id'] = $response['in_user_id'];
                    
                    $arr_data = array(
                        'in_user_id' => $user_id,
                        'in_session_id' => $sess_id,
                        'st_key' => $key
                    );
//                    $insert_cookie_id = $mydb->insert( TBL_COOKIE, $arr_data );
//                    if( isset( $insert_cookie_id ) &&  $insert_cookie_id > 0 ){
//                        setcookie( $cookie_name, json_encode( $cookie_value ), strtotime( "+1 year" ) );
//                    }de
                    $this->result['success_flag'] = true;
                    $this->result['message'] = 'Login successfully';
                    $_SESSION['user_type'] = $response['st_user_type'];
                    $this->result['redirect'] = VW_SM_HOME ;
                }else{
                    $this->result['success_flag'] = false;
                    $this->result['message'] = "Email Id and Password is wrong.";
                }
            } else if( isset( $varification_data ) && $varification_data->link_verified == 1 ) {
                if( $response['in_is_active'] == -2 ){
                    $this->result['success_flag'] = false;
                    $this->result['message'] = "Your Account has been disabled by the admin.";
                }else if( $response['in_is_active'] == -1 ){
                    $this->result['success_flag'] = false;
                    $this->result['message'] = "Your Account has been deleted by the admin.";
                }else if( $response['in_is_active'] == 1  ){
                    $_SESSION['user_id'] = $response['in_user_id'];
                    $_SESSION['user_type'] = $response['st_user_type'];
                    $arr_data = array(
                        'in_user_id' => $user_id,
                        'in_session_id' => $sess_id,
                        'st_key' => $key
                    );
//                    $insert_cookie_id = $mydb->insert( TBL_COOKIE, $arr_data );
//                    if( isset( $insert_cookie_id ) &&  $insert_cookie_id > 0 ){
//                        setcookie( $cookie_name, json_encode( $cookie_value ), strtotime("+1 year"));
//                    }
                    $this->result['success_flag'] = true;
                    $this->result['message'] = 'Login successfully';
                    if ( $_SESSION['user_type'] == 'driver' ) {
                        $this->result['redirect'] = VW_DRIVER_HOME ;
                    } else if ( $_SESSION['user_type'] == 'business_owner' ) {
                        $in_is_approve = $user->get_user_data_by_key(  $_SESSION['user_id'],'in_is_approve' );
                        if( isset( $in_is_approve ) && $in_is_approve == 1 ){
                            $user_bank_deatils = $user->get_user_bankdetails( $_SESSION['user_id'] );
                            $bo_data = $user->get_bo_data_by_key( $_SESSION['user_id'], 'in_store_manager_id' );
                            $location_data = $location->get_all_location( $_SESSION['user_id'] , 'DESC' );
                            if( !isset( $user_bank_deatils['in_account_number'] ) ){
                                $this->result['redirect'] = VW_BO_MYACCOUNT ;
                            }else if(  $bo_data == 0 || $bo_data == '' ){
                                $this->result['redirect'] = VW_SM_REGISTRATION ;
                            }else if( $location_data == 0 || $location_data == '' ){
                                $this->result['redirect'] = VW_MY_LOCATIONS ;
                            }else{
                                $this->result['redirect'] = VW_BO_HOME ;
                            }
                        }else{
                            $this->result['redirect'] = VW_BO_HOME ;
                        }

                    } else if ( $_SESSION['user_type'] == 'store_manager' ) {
                        $this->result['redirect'] = VW_SM_HOME ;
                    } 
                }
            }else{
                if ( $response['st_user_type'] == 'admin') {
                    $_SESSION['admin_id'] = $response['in_user_id'];
                    $_SESSION['user_type'] = $response['st_user_type'];
                    $this->result['success_flag'] = true;
                    $this->result['redirect'] = BASE_URL . DIR_SEPERATOR . BACKEND_DIR . DIR_SEPERATOR . 'views/user_list.php';
                } else{
                    $this->result['success_flag'] = false;
                    $this->result['message'] = "You have not verified your account. Please check your email for verification link.";
                }
            }
        } else{
            $this->result['success_flag'] = false;
            $this->result['message'] = 'Wrong Email ID or Password';
        }
        die( json_encode( $this->result ) );
    }  
    
    public function add_driver( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_USER;
            $user = new user();
           
            $insert_id = $user->add_user( $data );
            if ( $insert_id > 0 ) {
                if ( !session_id() ) {
                    session_start();
                }
                $user->send_confirmation_data( $insert_id );
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "Thank you for registering with Cop Express. Please use the link emailed to complete your registration.";
                $this->result['redirect'] = VW_LOGIN;
                
            } else if ( $insert_id == -1 ){
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Username  already exist";
            } else if ( $insert_id == -2 ){
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Email id already exist";
            } else if ( $insert_id == -3 ){
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Email and Username already exist";
            }else{
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
            }
            die( json_encode( $this->result ) );
        }
    }
    
    public function add_business_owner( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_USER;
            $user = new user();
           
            $insert_id = $user->add_user( $data );
            if ( $insert_id > 0 ) {
                if ( !session_id() ) {
                    session_start();
                }
                $user->send_confirmation_data( $insert_id );
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "Thank you for registering with Cop Express. Please use the link emailed to complete your registration.";
                $this->result['redirect'] = VW_LOGIN;
            } else if ( $insert_id == -1 ){
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Username  already exist";
            } else if ( $insert_id == -2 ){
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Email id already exist";
            } else if ( $insert_id == -3 ){
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Email and Username already exist";
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
            }
            die( json_encode( $this->result ) );
        }
    }
    
    public function user_approve( $data ) {
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_USER;
            $user = new user();
            $user_id = isset( $data['id'] ) && $data['id'] != '' ? $data['id'] : '';
            if( $user_id != '' ){
                $update_id = $user->update_userdata( $user_id , 'in_is_approve', 1 );
                if( isset( $update_id ) && $update_id != '' ){
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $user_id;
                    $this->result['message'] = 'User approve successfully';
                }else{
                    $this->result['success_flag'] = false;
                    $this->result['data'] = '';
                    $this->result['message'] = 'User not approve';
                }
            }
            die( json_encode( $this->result ) );
        }
    }
    
    public function user_reject( $data ) {
        if( isset( $data ) && is_array( $data ) ){
            $user_id = $data['id'];
            $val     = $data['val'];
            global $mydb;
            include_once FL_USER;
            $user = new user();
            if( $user_id != '' && $val != "" ){
                $in_is_approve = $user->get_user_data_by_key( $user_id,'in_is_approve' );
                $where = array(
                    'in_user_id' => $user_id
                );
                $approved = "-1";
                if( isset( $in_is_approve ) && $in_is_approve == "-1" ){
                    $approved = "-2";
                }else if( isset( $in_is_approve ) && $in_is_approve == "-2" ){
                    $approved = "-3";
                }else{
                    $approved = "-1";
                }
                $arr_data = array(
                    'in_is_approve' => $approved,
                    'st_reason'     => $val 
                );
                $update_id = $mydb->update( TBL_USER, $arr_data, $where );
                $user_signup_attempt = $user->get_user_meta( $user_id, 'admin_user_reject_attempt', TRUE ); 
                $update_bo = $user->update_usermeta( $user_id, 'admin_user_reject_attempt', $user_signup_attempt + 1 );    
                if( isset( $update_id ) && $update_id != '' ){
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $update_id;
                    $this->result['message'] = 'User has been successfully rejected.';
                } else {
                    $this->result['success_flag'] = false;
                    $this->result['data'] = '';
                    $this->result['message'] = 'User not reject';
                }
            }
            die( json_encode( $this->result ) );
        }
    }
    
    public function update_business_owner( $data ) {
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_USER;
            $user = new user();
            $user_id = isset( $data['user_id'] ) && $data['user_id'] != '' ?  $data['user_id'] : '' ;
            $firstname = ( isset($data['txt_first_name'] ) && trim( $data['txt_first_name'] ) !== '' ) ? trim( $data['txt_first_name'] ) : '';
            $lastname = ( isset($data['txt_last_name'] ) && trim( $data['txt_last_name'] ) !== '' ) ?   trim( $data['txt_last_name'] ) : ''; 
            $phone_no = ( isset($data['txt_phone_no'] ) && trim( $data['txt_phone_no'] ) !== '' ) ? trim( $data['txt_phone_no'] ) : '';
            $user_type = ( isset( $data['txt_user_type'] ) && trim( $data['txt_user_type'] ) !== '' ) ? trim( $data['txt_user_type'] ) : '';
            $address_1 = ( isset($data['txt_address_1'] ) && $data['txt_address_1'] !== '' ) ?  $data['txt_address_1'] : '';
            $address_2 = ( isset($data['txt_address_2'] ) && trim( $data['txt_address_2'] ) !== '' ) ? trim( $data['txt_address_2'] ) : '';
            $city = ( isset( $data['txt_city'] ) && trim( $data['txt_city'] ) !== '' ) ? trim( $data['txt_city'] ) : '';
            $txt_business_name = ( isset($data['txt_business_name'] ) && $data['txt_business_name'] !== '' ) ?  $data['txt_business_name'] : '';
            $txt_eni_no = ( isset($data['txt_eni_no'] ) && trim( $data['txt_eni_no'] ) !== '' ) ? trim( $data['txt_eni_no'] ) : '';
            $txt_job_title = ( isset( $data['txt_job_title'] ) && trim( $data['txt_job_title'] ) !== '' ) ? trim( $data['txt_job_title'] ) : '';
            $state = ( isset($data['txt_state'] ) && trim( $data['txt_state'] ) !== '' ) ? trim( $data['txt_state'] ) : '';
            $txt_home_address = ( isset($data['txt_home_address'] ) && trim( $data['txt_home_address'] ) !== '' ) ? trim( $data['txt_home_address'] ) : '';
            $hdn_home_latitude = ( isset($data['hdn_home_latitude'] ) && trim( $data['hdn_home_latitude'] ) !== '' ) ? trim( $data['hdn_home_latitude'] ) : '';
            $hdn_home_longitude = ( isset($data['hdn_home_longitude'] ) && trim( $data['hdn_home_longitude'] ) !== '' ) ? trim( $data['hdn_home_longitude'] ) : '';
            $txt_warehouse_address = ( isset($data['txt_warehouse_address'] ) && trim( $data['txt_warehouse_address'] ) !== '' ) ? trim( $data['txt_warehouse_address'] ) : '';
            $hdn_warehouse_latitude = ( isset($data['hdn_warehouse_latitude'] ) && trim( $data['hdn_warehouse_latitude'] ) !== '' ) ? trim( $data['hdn_warehouse_latitude'] ) : '';
            $hdn_warehouse_longitude = ( isset($data['hdn_warehouse_longitude'] ) && trim( $data['hdn_warehouse_longitude'] ) !== '' ) ? trim( $data['hdn_warehouse_longitude'] ) : '';
            $where = array(
                'in_user_id' => $user_id
            );
             $arr_data = array(
                'st_first_name' => $firstname,
                'st_last_name'  => $lastname,
                'in_contact_no' => $phone_no,
                'st_address_1' => $address_1,
                'st_address_2' => $address_2,
                'st_city' => $city,
                'st_state' => $state
            );
            if ( $user_id != "" ) {
                $update_bo_id = $mydb->update( TBL_USER, $arr_data, $where );    
                $update_bo = $user->update_usermeta( $user_id, 'st_bo_home_address', $txt_home_address );    
                $update_bo = $user->update_usermeta( $user_id, 'st_bo_home_lat', $hdn_home_latitude );    
                $update_bo = $user->update_usermeta( $user_id, 'st_bo_home_long', $hdn_home_longitude );    
                $update_bo = $user->update_usermeta( $user_id, 'st_bo_warehouse_address', $txt_warehouse_address );    
                $update_bo = $user->update_usermeta( $user_id, 'st_bo_warehouse_lat', $hdn_warehouse_latitude );    
                $update_bo = $user->update_usermeta( $user_id, 'st_bo_warehouse_long', $hdn_warehouse_longitude );    
                $update_bo = $user->update_bo_data( $user_id, 'st_business_name', $txt_business_name );    
                $update_bo = $user->update_bo_data( $user_id, 'in_eni_number', $txt_eni_no );    
                $update_bo = $user->update_bo_data( $user_id, 'st_job_title', $txt_job_title );    
               
                $arr_bo_data = $mydb->get_all( TBL_USER, '*', $where );  
                $arr_bo_data['st_bo_home_address'] = $user->get_user_meta( $user_id, 'st_bo_home_address', TRUE );    
                $arr_bo_data['st_bo_home_lat'] = $user->get_user_meta( $user_id, 'st_bo_home_lat', TRUE );    
                $arr_bo_data['st_bo_home_long'] = $user->get_user_meta( $user_id, 'st_bo_home_long', TRUE );    
                $arr_bo_data['st_bo_warehouse_address'] = $user->get_user_meta( $user_id, 'st_bo_warehouse_address', TRUE );    
                $arr_bo_data['st_bo_warehouse_lat'] = $user->get_user_meta( $user_id, 'st_bo_warehouse_lat', TRUE );    
                $arr_bo_data['st_bo_warehouse_long'] = $user->get_user_meta( $user_id, 'st_bo_warehouse_long', TRUE );    
                $arr_bo_data['st_business_name'] = $user->get_bo_data_by_key( $user_id, 'st_business_name' );    
                $arr_bo_data['in_eni_number'] = $user->get_bo_data_by_key( $user_id, 'in_eni_number' );    
                $arr_bo_data['st_job_title'] = $user->get_bo_data_by_key( $user_id, 'st_job_title' );    
                
                if( isset( $data['user_request'] ) && $data['user_request'] ){
                   $user_signup_attempt = $user->get_user_meta( $user_id, 'user_signup_attempt', TRUE ); 
                   $update_bo = $user->update_usermeta( $user_id, 'user_signup_attempt', $user_signup_attempt + 1 );    
                }
                if( isset( $update_bo_id ) && $update_bo_id != '' ){
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $arr_bo_data;
                    $this->result['message'] = 'User info successfully changed';
                }else{
                    $this->result['success_flag'] = false;
                    $this->result['data'] = '';
                    $this->result['message'] = 'User info not updated';
                }
            }
            die( json_encode( $this->result ) );
        }
    }
    
    public function update_driver( $data ) {
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_USER;
            $user = new user();
            $user_id = isset( $data['user_id'] ) && $data['user_id'] != '' ?  $data['user_id'] : '' ;
            $firstname = ( isset($data['txt_first_name'] ) && trim( $data['txt_first_name'] ) !== '' ) ? trim( $data['txt_first_name'] ) : '';
            $lastname = ( isset($data['txt_last_name'] ) && trim( $data['txt_last_name'] ) !== '' ) ? trim( $data['txt_last_name'] ) : '';
            $phone_no = ( isset($data['txt_phone_no'] ) && trim( $data['txt_phone_no'] ) !== '' ) ? trim( $data['txt_phone_no'] ) : '';
            $user_type = ( isset( $data['txt_user_type'] ) && trim( $data['txt_user_type'] ) !== '' ) ? trim( $data['txt_user_type'] ) : '';
            $address_1 = ( isset($data['txt_address_1'] ) && $data['txt_address_1'] !== '' ) ?  $data['txt_address_1']  : '';
            $address_2 = ( isset($data['txt_address_2'] ) && trim( $data['txt_address_2'] ) !== '' ) ? trim( $data['txt_address_2'] ) : '';
            $city = ( isset( $data['txt_city'] ) && trim( $data['txt_city'] ) !== '' ) ? trim( $data['txt_city'] ) : '';
            $state = ( isset( $data['txt_state'] ) && trim( $data['txt_state'] ) !== '' ) ? trim( $data['txt_state'] ) : '';
            $liece = ( isset( $data['txt_liece'] ) && trim( $data['txt_liece'] ) !== '' ) ? trim( $data['txt_liece'] ) : '';
            $where = array(
                'in_user_id' => $user_id
            );
            
            if ( isset( $liece ) && $liece != "" ) {
                $liece_data = array(
                    'in_license_no'  => $liece
                );
                $update_liece_id = $mydb->update( TBL_DRIVER, $liece_data, $where );
                if ( isset( $update_liece_id ) && $update_liece_id != '' ) {
                    $liece_data = $mydb->get_all( TBL_DRIVER, '*', $where );    
                }       
            }
            
             $arr_data = array(
                'st_first_name'   => $firstname,
                'st_last_name'    => $lastname,
                'in_contact_no' => $phone_no,
                'st_address_1' => $address_1,
                'st_address_2' => $address_2,
                'st_city' => $city,
                'st_state' => $state
            );
            if ( $user_id != "" ) {
                $update_bo_id = $mydb->update( TBL_USER, $arr_data, $where ); 
                if( isset( $data['user_request'] ) && $data['user_request'] ){
                   $user_signup_attempt = $user->get_user_meta( $user_id, 'user_signup_attempt', TRUE ); 
                   $update_bo = $user->update_usermeta( $user_id, 'user_signup_attempt', $user_signup_attempt + 1 );  
                   
                }
                $arr_data = $mydb->get_all( TBL_USER, '*', $where );
                if ( isset( $liece_data ) && is_array( $liece_data ) ) {
                    $update_bo_data = array_merge( $arr_data, $liece_data );       
                } else {
                    $update_bo_data = $arr_data;
                }
                
                if( isset( $update_bo_id ) && $update_bo_id != '' ){
                    $this->result['success_flag'] = true;
                    $this->result['data']         = $update_bo_data;
                    $this->result['message']      = 'User info successfully changed';
                }else{
                    $this->result['success_flag'] = false;
                    $this->result['data'] = '';
                    $this->result['message'] = 'User info not updated';
                }
            }
             die( json_encode( $this->result ) );
        }
    }
    
    public function send_change_password_link( $data ) {
        if( isset( $data ) && is_array( $data ) ){
            include_once FL_USER;
            $user = new user();
            global $mydb;
            $user_id = isset( $data['user_id'] ) && $data['user_id'] != '' ?  $data['user_id'] : '' ;
            if ( $user_id != "" ) {
                $send_id = $user->send_change_password_link( $user_id );
                if( isset( $send_id ) && $send_id > 0 ){
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $user_id;
                    $this->result['message'] = 'Change password link has been send successfully.';
                }else{
                    $this->result['success_flag'] = false;
                    $this->result['data'] = '';
                    $this->result['message'] = 'Link not send';
                }
            }
             die( json_encode( $this->result ) );
        }
    }
    
    public function send_change_email_link( $data ) {
        if( isset( $data ) && is_array( $data ) ){
            include_once FL_USER;
            $user = new user();
            global $mydb;
            $user_id = isset( $data['in_user_id'] ) && $data['in_user_id'] != '' ?  $data['in_user_id'] : '' ;
            $email = isset( $data['txt_email_id'] ) && $data['txt_email_id'] != '' ?  $data['txt_email_id'] : '' ;
            
            if ( $user_id != "" ) {
                $send_id = $user->send_change_email_link( $user_id , $email );
                if( isset( $send_id ) && $send_id > 0 ){
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $user_id;
                    $this->result['message'] = 'Link send successfully';
                } else if( isset( $send_id ) && $send_id == -1 ){
                    $this->result['success_flag'] = false;
                    $this->result['data'] = $user_id;
                    $this->result['message'] = 'Email id already exists';
                }else{
                    $this->result['success_flag'] = false;
                    $this->result['data'] = '';
                    $this->result['message'] = 'Link not send';
                }
            }
             die( json_encode( $this->result ) );
        }
    }
    
    public function add_location( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_LOCATION;
            $location = new location();
           
            $insert_id = $location->add_location( $data );
            if ( $insert_id > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "Location has been added successfully.";
            }else if ( $insert_id == -2 ) {
                $this->result['success_flag'] = false;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "Store manager email id already exists.";
            }else if ( $insert_id == -1 ) {
                $this->result['success_flag'] = false;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "Store id already exists";
            }else{
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Location not added";
            }
            die( json_encode( $this->result ) );
        }
    }
    
    public function edit_location( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_LOCATION;
            $location = new location();
           
            $update_id = $location->edit_location( $data );
            if ( $update_id > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['data'] = $update_id;
                $this->result['message'] = "Location has been updated successfully.";
            }else if ( $update_id == -1 ) {
                $this->result['success_flag'] = false;
                $this->result['data'] = $update_id;
                $this->result['message'] = "Store id already exists";
            }else{
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Email id already existed.";
            }
            die( json_encode( $this->result ) );
        }
    }
    
    public function get_location_by_id( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_LOCATION;
            $location = new location();
            include_once FL_USER;
            $user = new user();
            $location_id = isset( $data['location_id'] ) && $data['location_id'] != '' ?  $data['location_id'] : '';
            $location_data = $location->get_location_by_id( $location_id );
            $location_data['st_store_emailid'] = $user->get_user_data_by_key( $location_data['in_manager_id'], 'st_email_id' );
            echo ( json_encode( $location_data ) );
        }
    }
    
    public function delete_location( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_LOCATION;
            $location = new location();
            include_once FL_PICKUP;
            $pickup = new pickup();
            $where = array(
                'in_location_id' => $data['location_id']
            );
            $set = array(
                'in_is_active' => 0
            );
            
            $str_query = "SELECT * FROM " . $mydb->prefix . TBL_PICKUP . " WHERE in_location_id=" . $data['location_id'] . " AND st_status != 'completed' ";
            $pickup_data = $mydb->query( $str_query );
           
            if( isset( $pickup_data ) && $pickup_data != "" ){
                $this->result['success_flag'] = false;
                $this->result['message'] = "Trip request has been sent to driver for this location. You can not delete it.";
            }else{
                if ( $data['location_id'] != "" ) {
                    $update_id = $mydb->update( TBL_LOCATION, $set, $where );
                    $str_query = "SELECT * FROM " . $mydb->prefix . TBL_PICKUP . " WHERE in_location_id = " . $data['location_id'] . " AND st_status IS NULL";
                    $pickup_data = $mydb->query( $str_query );
                    if( isset( $pickup_data ) && $pickup_data != "" ){
                        if( isset( $pickup_data['in_recurring_id'] ) ) {
                            $pickup_data = array( $pickup_data );
                        }
                        foreach( $pickup_data as $rk => $rv ){
                            $where = array(
                                'in_location_id' => $data['location_id']
                            );
                            $set = array(
                                'in_is_active' => 0
                            );
                            $delete_id = $mydb->update( TBL_PICKUP, $set, $where );
                        }
                    }
                    if ( $update_id > 0 ) {
                        $str_recurring_query = "SELECT * FROM " . $mydb->prefix . TBL_RECURRING_PICKUP . " WHERE in_location_id=" . $data['location_id'] . " ";
                        $recurring_data = $mydb->query( $str_recurring_query );
                        if( isset( $recurring_data ) && $recurring_data != "" ){
                            if( isset( $recurring_data['in_recurring_id'] ) ) {
                                $recurring_data = array( $recurring_data );
                            }
                            foreach( $recurring_data as $rk => $rv ){
                                $where = array(
                                    'in_location_id' => $data['location_id']
                                );
                                $set = array(
                                    'in_is_active' => 0
                                );
                                $delete_id = $mydb->update( TBL_RECURRING_PICKUP, $set, $where );
                            }
                        }
                        $location_data = $location->get_location_by_id( $data['location_id'] );
                        if( isset( $location_data ) && $location_data > 0 || $location_data != "" ){
                            if( isset( $location_data['st_type'] ) && $location_data['st_type'] == "multiple" ){
                                // $delete_user_query = "DELETE FROM " . $mydb->prefix . TBL_USER . " WHERE in_user_id = " . $location_data['in_manager_id'] ;
                                // $delete_id = $mydb->query( $delete_user_query );
                                
                                $where = array(
                                    'in_user_id' => $location_data['in_manager_id']
                                );
                                $set = array(
                                    'in_is_active' => 0
                                );
                                $delete_id = $mydb->update( TBL_USER, $set, $where );
                            }
                        }
                        $this->result['success_flag'] = true;
                        $this->result['data'] = $update_id;
                        $this->result['message'] = "Location Delete Successfully";
                    } else {
                        $this->result['success_flag'] = false;
                        $this->result['message'] = "Location not delete ";
                    }
                }
            }
            echo ( json_encode( $this->result ) );
        }
    }
    
    public function change_password( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            $old_pwd = isset( $data['txt_old_pwd'] ) && $data['txt_old_pwd'] != "" ? $data['txt_old_pwd'] : '';
            $new_pwd = isset( $data['txt_new_pwd'] ) && $data['txt_new_pwd'] != "" ? $data['txt_new_pwd'] : '';
            $user_id = isset( $data['user_id'] ) && $data['user_id'] != "" ? $data['user_id'] : '';
            $where = array(
                'st_password' => md5( $old_pwd ),
                'in_user_id' => $user_id
            );
            $user_data = $mydb->get_all( TBL_USER, '*', $where );
            if( !isset( $user_data['in_user_id'] ) ){
                $this->result['success_flag'] = false;
                $this->result['message'] = "Password is wrong";
            }else{
                $where = array(
                    'in_user_id' => $user_id
                );
                $set = array(
                    'st_password' => md5( $new_pwd )
                );
                $update_id = $mydb->update( TBL_USER, $set, $where );

                if ( $update_id > 0 ) {
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $update_id;
                    $this->result['message'] = "Password Update Successfully";
                } else {
                    $this->result['success_flag'] = false;
                    $this->result['message'] = "Password not update";
                }
            }
        }
        echo ( json_encode( $this->result ) );
        
    }
    
   public function add_pickup( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            
            $insert_id  = $pickup->add_pickup( $data );
            if ( $insert_id > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "Pick Up has been added successfully.";
            } else if ( $insert_id == -1 ) {
                $this->result['success_flag'] = false;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "Please create store manager account to continue...";
            } else {
                $this->result['success_flag'] = false;
                $this->result['message'] = "Pick not added";
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function search_user( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_USER;
            $user = new user();
            $user_type = isset( $data['type'] ) && $data['type'] != '' ? $data['type'] : '';
            $user_name = isset( $data['term'] ) && $data['term'] != '' ? $data['term'] : '';
            $user_data  = $user->search_user_by_type( $user_type, $user_name );
            $user_info = array();
            if( isset( $user_data ) && $user_data != "" ){
                foreach( $user_data as $ing ){
                    $tmp_ing = array(
                        'id' => $ing['in_user_id'],
                        'label' => $ing['st_first_name'],
                        'value' => $ing['st_first_name'],
                        'email' => $ing['st_email_id']
                    );
                    $user_info[] = $tmp_ing;
                }  
            }else{
                $user_info = "";
            }
            
        }
        echo ( json_encode( $user_info ) );
    }
    
    public function driver_request( $data ) {
        
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            $insert_id  = $pickup->add_job( $data );
            if ( $insert_id > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "Trip assign successfully..";
            } else if( $insert_id == -1 ) {
                $this->result['success_flag'] = false;
                $this->result['message'] = "Some of the location has been deleted from this trip. You can not submit it.";
            } else{
                $this->result['success_flag'] = false;
                $this->result['message'] = "Trip not assign";
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function all_driver_request( $data ) {
        
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            $insert_id  = $pickup->add_all_driver_job( $data );
            if ( $insert_id > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "Trip assign successfully..";
            } else {
                $this->result['success_flag'] = false;
                $this->result['message'] = "Trip not assign";
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function change_driver_job_status( $data ) {
        
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            include_once FL_LOCATION;
            $location = new location();
            $insert_id  = $pickup->change_driver_job_status( $data  );
            if ( $insert_id > 0 ) {
                $this->result['location'] = '';
                if( isset( $data['pickup_status'] ) &&  $data['pickup_status'] == "onroute" ){
                    $where_pickup = array(
                        'in_pickup_id' => $data['pick_id']
                    );
                    $pickup_data = $mydb->get_all( TBL_PICKUP, '*', $where_pickup );
                    $location_name = $location->get_location_by_key( $pickup_data['in_location_id'], 'st_address' );
                    $pickup_location_plus = preg_replace( '/\s/ ', '+', $location_name );
                    $this->result['location'] = 'https://www.google.com/maps/dir/?api=1&dir_action=navigate&destination=' . $pickup_location_plus;
                }
                if( isset( $data['pickup_status'] ) &&  $data['pickup_status'] == "completed" ){
                    $where_job = array(
                        'in_job_id' => $data['job_id']
                    );
                    $pickup_data = $mydb->get_all( TBL_PICKUP, '*', $where_job, 'in_pickup_sort DESC' , '', 1 );
                    if( isset( $pickup_data ) && $pickup_data != '' || $pickup_data > 0 ){
                        if( $pickup_data['st_status'] == "completed" ){
                            $check_pickup_exists = $pickup->check_pickup_exists_job( $data['job_id'] );
                            if( isset( $check_pickup_exists ) && $check_pickup_exists != "" ){
                                $bank_data = $pickup->get_job_address_data( $data['job_id'] );
                                $bank_name = isset( $bank_data['st_add'] ) && $bank_data['st_add'] != '' ? $bank_data['st_add'] : '';
                                $bank_plus = preg_replace( '/\s/ ', '+', $bank_name );
                                $this->result['location'] = 'https://www.google.com/maps/dir/?api=1&dir_action=navigate&destination=' . $bank_plus;
                            }
                        }
                    }
                }
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "Trip status changed successfully";
            } else if ( $insert_id == -1 ){
                $this->result['success_flag'] = false;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "Please check information";
            } else if( isset( $insert_id ) && $insert_id == -2 ){
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Please wait for store manager to complete verification process.';
            } else {
                $this->result['success_flag'] = false;
                $this->result['message'] = "Trip status not changed";
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function sm_verify_driver_info( $data ) {
        
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            $insert_id  = $pickup->sm_verify_driver_info( $data  );
            if ( $insert_id > 0 ) {
                $pickup_id = isset( $data['pickup_id'] ) &&  $data['pickup_id'] > 0 ?  $data['pickup_id'] : '';
                $order_type = $pickup->get_pickup_by_key( $pickup_id, 'st_order_type' );
                if( $order_type == "change_order" ){
                    $success_msg = "Yes, You can collect packets from driver";
                }else{
                    $success_msg = "Yes, you can give packets to driver";
                }
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = $success_msg;
            } else if ( $insert_id == -1 ){
                $this->result['success_flag'] = false;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "Please check Driver information";
            } else {
                $this->result['success_flag'] = false;
                $this->result['message'] = "Incorrect driver information.please recheck.";
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function verify_driver_sm_info( $data ) {
        
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            $insert_id  = $pickup->verify_driver_sm_info( $data  );
            if ( $insert_id > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = $success_msg;
            } else{
                $this->result['success_flag'] = false;
                $this->result['message'] = "Incorrect driver information. Please recheck!";
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function check_sm_verify( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            $verify_id = 0;
            $job_id = isset( $data['job_id'] ) &&  $data['job_id'] > 0 ?  $data['job_id'] : '';
            $pickup_id = isset( $data['pick_id'] ) &&  $data['pick_id'] > 0 ?  $data['pick_id'] : '';
            if( $job_id > 0 && $pickup_id > 0 ){
                $sm_verify = $pickup->get_pickup_by_key( $pickup_id, 'st_driver_verify' );
                if( $sm_verify == 1 ){
                    $verify_id = 1;
                }
            }
            
            if ( $verify_id > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['data'] = $verify_id;
                $this->result['message'] = "Store manger verify driver information successfully.";
            } else {
                $this->result['success_flag'] = false;
                $this->result['message'] = "Please wait for store manager to complete verification process.";
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function check_store_manager_verify( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            $verify_id = 0;
            $job_id = isset( $data['job_id'] ) &&  $data['job_id'] > 0 ?  $data['job_id'] : 0;
            $pickup_id = isset( $data['pickup_id'] ) &&  $data['pickup_id'] > 0 ?  $data['pickup_id'] : 0;
            if( $job_id > 0 && $pickup_id > 0 ){
                $sm_verify = $pickup->get_pickup_by_key( $pickup_id, 'st_sm_verify' );
                if( $sm_verify == 1 ){
                    $verify_id = 1;
                }
            }
            if ( $verify_id > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['data'] = $verify_id;
                $this->result['message'] = "Store manger verify driver information successfully.";
            } else {
                $this->result['success_flag'] = false;
                $this->result['message'] = "Please wait for store manager to complete verification process.";
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function driver_job_complete( $data ) {
        
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            $job_id = isset( $data['job_id'] ) &&  $data['job_id'] > 0 ?  $data['job_id'] : '';
            if( $job_id > 0 ){
                $update_id = $pickup->driver_job_complete( $job_id );
            }
            
            if ( $update_id > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['data'] = $update_id;
                $this->result['redirect'] = VW_DRIVER_MYJOBS;
                $this->result['message'] = "Trip completed successfully.";
            } else {
                $this->result['success_flag'] = false;
                $this->result['message'] = "Trip not completed.";
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function ch_arrived_at_bank( $data ) {
        
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            include_once FL_ACTIVITY;
            $activity = new activity();
            include_once FL_LOCATION;
            $location = new location();
            $job_id = isset( $data['job_id'] ) &&  $data['job_id'] > 0 ?  $data['job_id'] : '';
            if( $job_id > 0 ){
                
                $activity_data = $activity->get_activity_by_data( $job_id, '0', 'end' );
                if( $activity_data && $activity_data != '' ){

                }else{
                    $updateid = $activity->add_activity( $job_id, '0', 'end' );
                }
                $update_id = $pickup->ch_arrived_at_bank( $job_id );
            }
            
            if ( $update_id > 0 ) {
                $this->result['location'] = '';
                $driver_job = $pickup->get_driver_assign_job( $job_id );
                foreach( $driver_job as $d_job ){
                    $start_time = date( "Y-m-d H:i:s" );
                    $where_pickup = array(
                        'in_pickup_id' => $d_job['in_pickup_id']
                    );
                    $pickup_data = $mydb->get_all( TBL_PICKUP, '*', $where_pickup );
                    $location_name = $location->get_location_by_key( $pickup_data['in_location_id'], 'st_address' );
                    $pickup_location_plus = preg_replace( '/\s/ ', '+', $location_name );
                    $this->result['location'] = 'https://www.google.com/maps/dir/?api=1&dir_action=navigate&destination=' . $pickup_location_plus;
                }
                $this->result['success_flag'] = true;
                $this->result['data'] = $update_id;
                $this->result['redirect'] = VW_DRIVER_MYJOBS;
                $this->result['message'] = "Please confirm you have received change order";
            } else {
                $this->result['success_flag'] = false;
                $this->result['message'] = "Driver not received the Change order request from the bank";
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function add_store_manager( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_USER;
            $user = new user();
            include_once FL_LOCATION;
            $location = new location();
            $sm_id = isset( $data['sm_id'] ) && $data['sm_id'] > 0 ? $data['sm_id'] : 0;
            $bo_id = isset( $data['user_id'] ) && $data['user_id'] > 0 ? $data['user_id'] : 0;
            $insert_id = $user->add_sm_user( $data );
            if ( $insert_id > 0 ) {
                if ( !session_id() ) {
                    session_start();
                }
                if( isset( $sm_id ) && $sm_id > 0 ){
                    $user->send_bo_sm_confirmation_data( $bo_id, $sm_id );
                }else{
                    $user->send_bo_sm_confirmation_data( $bo_id, $insert_id );
                }
                
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                if( isset( $sm_id ) && $sm_id > 0 ){
                    $this->result['message'] = "Store manager information updated successfully";
                }else{
                    $this->result['message'] = "Store manager information added successfully";
                }
                
                $location_data = $location->get_all_location( $_SESSION['user_id'] , 'DESC' );
                if( $location_data == 0 || $location_data == '' ){
                    $this->result['redirect'] = VW_MY_LOCATIONS ;
                }else{
                    $this->result['redirect'] = VW_SM_REGISTRATION ;
                }
                
                
            } else if ( $insert_id == -1 ){
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Username already exist";
            } else if ( $insert_id == -2 ){
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Email id already exist";
            } else if ( $insert_id == -3 ){
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Email and Username already exist";
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
            }
            die( json_encode( $this->result ) );
        }
    }
    
    public function update_bank_detail( $data ) {
        if( isset( $data ) && is_array( $data ) && isset( $data['user_id'] ) && $data['user_id'] != "" ) {
            $id = $data['user_id'];
            include_once FL_USER;
            $user = new user();
            if ( $id != "" ){
                $txt_full_name = isset( $data['txt_full_name'] ) && $data['txt_full_name'] != ""  ? $data['txt_full_name'] : '';
                $txt_acc_no = isset( $data['txt_acc_no']  ) && $data['txt_acc_no'] != "" ? $data['txt_acc_no'] : "";
                $txt_bank_name = isset( $data['txt_bank_name'] ) && $data['txt_bank_name'] != "" ? $data['txt_bank_name'] : '';
                $txt_branch_name = isset( $data['txt_branch_name'] ) && $data['txt_branch_name'] != "" ? $data['txt_branch_name'] : '';
                $txt_routing_no = isset( $data['txt_routing_no'] ) && $data['txt_routing_no'] > 0 ? $data['txt_routing_no'] : '';
                $txt_address = isset( $data['txt_address'] ) && $data['txt_address'] != "" ? $data['txt_address'] : "";
                if( $txt_address != ""){
                    $hdn_latitude = isset( $data['hdn_latitude']  ) && $data['hdn_latitude'] != "" ? $data['hdn_latitude'] : 0 ;
                    $hdn_longitude = isset( $data['hdn_longitude'] ) &&  $data['hdn_longitude'] != "" ?  $data['hdn_longitude'] : 0;
                }else{
                    $hdn_latitude = '';
                    $hdn_longitude = '';
                }
                
        
                global $mydb;
                $where = array(
                    'in_user_id' => $id
                );

                $arr_data = array(
                    'st_account_holder_name' => $txt_full_name,
                    'in_account_number'      => $txt_acc_no,
                    'st_bank_name'           => $txt_bank_name,
                    'st_branch_name'         => $txt_branch_name,
                    'in_routing_number'      => $txt_routing_no,
                    'st_add'                 => $txt_address,
                    'in_latitude'            => $hdn_latitude,
                    'in_longitude'           => $hdn_longitude
                );

                $update_id = $mydb->update( TBL_BUSINESS_OWNER, $arr_data, $where );
                $arr_userdata = $mydb->get_all( TBL_BUSINESS_OWNER, '*', $where );
                if( isset( $update_id ) && $update_id != '' ) {
                    $bo_data = $user->get_bo_data_by_key( $id, 'in_store_manager_id' );
                    
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $arr_userdata;
                    $this->result['message'] = 'Bank info updated successfully';
                    if(  $bo_data == 0 || $bo_data == ''  ){
                        $this->result['redirect'] = VW_SM_REGISTRATION;
                    }else{
                        $this->result['redirect'] = VW_BO_MYACCOUNT;
                    }
                    
                } else {
                    $this->result['success_flag'] = false;
                    $this->result['data'] = '';
                    $this->result['message'] = 'Bank info not updated';
                }
            }else {
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Bank info not updated';
            }
        }
        echo ( json_encode( $this->result ) );
    }

    
    public function sm_resend_mail( $data ) {
       
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            include_once FL_USER;
            $user = new user();
            include_once FL_PICKUP;
            $pickup = new pickup();
            include_once FL_LOCATION;
            $location = new location();
            $manager_id = isset( $data['manager_id'] ) &&  $data['manager_id'] != '' ?  $data['manager_id'] : '';
            $pick_id = isset( $data['pick_id'] ) &&  $data['pick_id'] != '' ?  $data['pick_id'] : '';
            $s_lid = isset( $data['s_loc_id'] ) &&  $data['s_loc_id'] != '' ?  $data['s_loc_id'] : '';
            $update_id = 0;
            if( $pick_id > 0  ){
                $verify_code = $pickup->get_pickup_by_key( $pick_id, 'st_veriry_code' );
                $location_id = $pickup->get_pickup_by_key( $pick_id, 'in_location_id' );
                $manager_id = $pickup->get_pickup_by_key( $pick_id, 'in_manager_id' );
                $job_id = $pickup->get_pickup_by_key( $pick_id, 'in_job_id' );
                $store_id = $location->get_location_by_key( $location_id, 'st_store_id' );
                $st_address = $location->get_location_by_key( $location_id, 'st_address' );
                $sm_email_id = $user->get_user_data_by_key( $manager_id, 'st_email_id' );
                $current_time = time();
                $key = md5( $store_id . $current_time );
                $where = array( 
                    'in_pickup_id' => $pick_id
                );
                $set = array(  
                    'st_sm_link' => $key
                );
                $update_key = $mydb->update( TBL_PICKUP, $set, $where );
//                $updatemeta_key = $user->update_usermeta( $pick_id , 'st_sm_driver_verify_link', $key );
                if( isset( $update_key ) ){                                     
                    $sm_mail_data = array( 
                        "location_name" => $st_address,
                        "base_url" => SITE_NAME ,
                        "link" => VW_SM_VERIFY . '?key=' . $key . '&id=' . $job_id . '&p_id=' . $pick_id . '&s_lid=' . $s_lid );
                    $email_sm_templet = $template->get_template( 'email', '', 'driver_start_sm_mail', TRUE );
                    if ( MAIL_MODE == 'test' ){
                        $sm_emailid = TEST_EMAIL;
                    } else {
                        $sm_emailid = $sm_email_id;
                    }
                    $update_id = $user->send_mail_by_template( $pick_id, $sm_emailid, 'Cop Express - Driver Arrived from the location address: '. $st_address . '', $email_sm_templet, $sm_mail_data );
                }
            }
            
            if( isset( $update_key ) && $update_key > 0 ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $update_key;
                $this->result['message'] = 'Mail has been successfully sent to Store Manager.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Mail not sent';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function resend_signup_link( $data ) {

        if( isset( $data ) && is_array( $data ) ) {
            
            global $mydb;
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            include_once FL_USER;
            $user = new user();
            $email_id = isset( $data['mail_id'] ) &&  $data['mail_id'] != '' ?  $data['mail_id'] : '';
            $update_id = 0;
            if( $email_id != '' ){
                $user_data = $user->get_user_data_by( 'st_email_id',  $email_id);
                $current_time = time();
                
                $meta_key = "link_data";
                $meta_value = array( "generated_key" => $key,
                    "generated_time" => $current_time,
                    "link_verified" => 0 );
                if( isset( $user_data ) && isset( $user_data['in_user_id'] ) ){
                    $key = md5( $user_data['in_user_id'] . $current_time );
                    $update_id = $user->update_userdata( $user_data['in_user_id'], $meta_key, json_encode( $meta_value ) );

                    $data = array( "user_name" => $user_data['st_first_name'],
                         "site_url" => BASE_URL,
                        "send_link" => VW_VARIFICATION . "?id=" . $user_data['in_user_id'] . "&k=" . $key );
                    $email_reset_templet = $template->get_template('email', '', 'signup_resend_verification', TRUE);
                    $emailid = "webdev3514@gmail.com";
                    $this->send_mail_by_template( $user_data['in_user_id'], $emailid, 'Cop Express Link verification', $email_reset_templet, $data );
                }
            }
            
            if( isset( $update_key ) && $update_key > 0 ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $update_key;
                $this->result['message'] = 'Mail Send Successfully';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Mail not sent';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function get_drivers_info( $data ) {

        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            include_once FL_USER;
            $user = new user();
            include_once FL_SETTINGS;
            $settings = new settings();
            $bo_bank_address = $settings->get_settings( 'bo_bank_address' , TRUE );
            
            $pickup_id = isset( $data['pickup_id'] ) &&  $data['pickup_id'] != '' ?  $data['pickup_id'] : '';
            $update_id = 0;
            $home = '';
            $warehouse = '';
            if( $pickup_id != '' ){
                global $mydb;
                $str_query = 'SELECT p.*,b.in_user_id bo_id,b.st_add,l.st_location_name,l.st_address FROM ' . $mydb->prefix . TBL_PICKUP . ' p , ' 
                        . $mydb->prefix . TBL_LOCATION . ' l , ' . $mydb->prefix . TBL_BUSINESS_OWNER . ' b   WHERE ( ( p.st_order_type IS NULL AND  p.in_user_id = b.in_user_id  ) OR  (  p.st_order_type = "change_order" AND p.in_manager_id = l.in_manager_id AND  p.in_user_id = l.in_user_id  AND p.in_user_id = b.in_user_id  ) ) AND p.in_pickup_id IN ( ' 
                        . $pickup_id . ' ) AND p.in_location_id = l.in_location_id ';
                $response = $mydb->query( $str_query );
                if( isset( $response ) && $response != '' ){
                    if( isset( $response['in_pickup_id'] ) ){
                        $response = array( $response );
                    }
                    $check_user_id = 0;
                    $order_type = '';
                    $same_user = '';
                    foreach( $response as $value ){
                        if( $check_user_id > 0 && $value['bo_id'] != $check_user_id  ){
                            $home = "";
                            $warehouse = "";
                            $same_user = 'yes';
                            $bank_name = '';
                            $bank_name = $bo_bank_address;
                        }else{
                            if( $same_user == "yes" ){
                                $bank_name = $bo_bank_address; 
                            }else{
                                if( $value['st_add'] == "" ){
                                    $bank_name = $bo_bank_address;
                                }else{
                                    $bank_name = $value['st_add'];
                                }
                                $home_address = $user->get_user_meta( $value['in_user_id'] , 'st_bo_home_address', TRUE );
                                $home_lat = $user->get_user_meta( $value['in_user_id'] , 'st_bo_home_lat', TRUE );
                                $home_log = $user->get_user_meta( $value['in_user_id']  , 'st_bo_home_long', TRUE );
                                $warehouse_address = $user->get_user_meta( $value['in_user_id'] , 'st_bo_warehouse_address', TRUE );
                                $warehouse_lat = $user->get_user_meta( $value['in_user_id']  , 'st_bo_warehouse_lat', TRUE );
                                $warehouse_log = $user->get_user_meta( $value['in_user_id']  , 'st_bo_warehouse_long', TRUE );
                                if( isset( $home_address ) &&  isset( $home_lat ) &&  isset( $home_log ) ){
                                    $home = $home_address;
                                }
                                if( isset( $warehouse_address ) &&  isset( $warehouse_lat ) &&  isset( $warehouse_log ) ){
                                    $warehouse = $warehouse_address;
                                }
                                
                            }
                        }
                        if( isset( $value['st_order_type'] ) && $value['st_order_type'] == "change_order" ){
                            $order_type = $value['st_order_type'];
                            $check_user_id = $value['bo_id'] ;
                        }else{
                            $check_user_id = $value['in_user_id'] ;
                        }
                        
                    }
                }
            }
          
            if( isset( $response ) && $response != '' ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $response;
                $this->result['message'] = '';
                $this->result['type'] = $order_type;
                $this->result['bank'] = $bank_name;
                $this->result['home_add'] = $home;
                $this->result['warehouse_add'] = $warehouse;
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = '';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function add_change_order( $data ) {

        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            $insert_id = $pickup->add_change_order( $data );
            if( isset( $insert_id ) && $insert_id > 0 ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = 'Add change order request added successfully.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Add change order request not added successfully.';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function edit_change_order( $data ) {

        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            $insert_id = $pickup->edit_change_order( $data );
            if( isset( $insert_id ) && $insert_id > 0 ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = 'Change order request updated successfully.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Change order request not updated successfully.';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function admin_other_setting( $data ) {
        include_once FL_SETTINGS;
        $settings = new settings();
        if ( isset( $data ) ) {
            global $mydb;
            if ( isset( $data['other_settings'] ) ) {
                foreach ( $data['other_settings'] as $other_key => $other_value ) {
                    $updateid = $settings->update_settings( $other_key, $other_value );
                }

                if ( $updateid > 0 ) {
                    $this->result['success_flag'] = true;
                    $this->result['message'] = 'Other settings update Successfully';
                    $this->result['data'] = $updateid;
                } else {
                    $this->result['success_flag'] = true;
                    $this->result['message'] = 'Other settings  not update Successfully';
                    $this->result['data'] = '';
                }
            }
            echo( json_encode($this->result) );
        }
    }
    
    public function add_job_start( $data ) {
        if ( !session_id() ) {
            session_start();
        }
        global $mydb;
        
        include_once FL_ACTIVITY;
        $activity = new activity();
        include_once FL_PICKUP;
        $pickup = new pickup();
        $driver_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 ? $_SESSION['user_id'] : 0;
        if ( isset( $data ) ) {
            $date = date( "Y-m-d" );
             $str_query = 'SELECT * FROM ' . $mydb->prefix . TBL_JOB . ' WHERE in_driver_id = ' . $driver_id . 
                    ' AND dt_pickup >= "' . $date . '"  AND st_status != "completed"  ORDER BY in_job_id DESC ';
            $driver_job = $mydb->query( $str_query );
            $running_job = '';
            if( isset( $driver_job ) && $driver_job != '' || $driver_job > 0 ){
                if( isset( $driver_job['in_job_id'] ) ){
                    $driver_job = array( $driver_job );
                }
                foreach( $driver_job as $djk => $djv ){
                    if( $djv['st_status'] == "in_progress" ){
                        $running_job = 'yes';
                    }
                }
            }
            
            if( isset( $data['job_id'] ) && $data['job_id'] > 0 ){
                if( $running_job == "yes" ){
                    $update_job = -1;
                }else{
                    $job_id = $data['job_id'];
                    $start_time = date( "Y-m-d H:i:s" );
                    $arr_job = array(
                        'st_status' => "start",
                        'dt_start_time' => $start_time
                    );
                    $where_job = array(
                        'in_job_id' => $job_id
                    );
                    $update_job = $mydb->update( TBL_JOB, $arr_job, $where_job );
                    $activity_data = $activity->get_activity_by_data( $job_id, '0', 'start' );

                    if( $activity_data && $activity_data != '' ){

                    }else{
                        $updateid = $activity->add_activity( $job_id, '0', 'start' );
                    }
                    $this->result['location'] = '';
                    $check_ch_job = $pickup->check_ch_bank_job( $job_id );
                    if( isset( $check_ch_job['st_order_type'] ) &&  $check_ch_job['st_order_type'] == "change_order" ){
                        $bank_data = $pickup->get_job_address_data( $job_id, 'change_order' );
                        $bank_name = isset( $bank_data['st_add'] ) && $bank_data['st_add'] != '' ? $bank_data['st_add'] : '';
                        $bank_address_plus = preg_replace( '/\s/ ', '+', $bank_name );
                        $this->result['location'] = 'https://www.google.com/maps/dir/?api=1&dir_action=navigate&destination=' . $bank_address_plus;
                    }
                }
                if ( isset( $update_job ) && $update_job > 0 ) {
                    $this->result['success_flag'] = true;
                    $this->result['message'] = 'Trip has been start';
                    $this->result['redirect'] = VW_DRIVER_ACTIVEJOB . "?job_id=" . $job_id;
                    $this->result['data'] = $update_job;
                } else if ( isset( $update_job ) && $update_job == -1 ) {
                    $this->result['success_flag'] = false;
                    $this->result['message'] = 'Your another trip is currently in process. You need to complete previous trip before start the next trip.';
                    $this->result['data'] = $update_job;
                } else {
                    $this->result['success_flag'] = false;
                    $this->result['message'] = 'trip not start';
                    $this->result['data'] = '';
                }
            }
            echo( json_encode( $this->result ) );
        }
    }

    public function change_order_approve( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            include_once FL_USER;
            $user = new user();
            include_once FL_LOCATION;
            $location = new location();
            include_once FL_PICKUP;
            $pickup = new pickup();
            $user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 ? $_SESSION['user_id'] : '';
            if( isset( $data['id'] ) && $data['id'] > 0 ){
                $pickup_id = $data['id'];
                $set = array(
                    'in_is_approve' => 1
                );
                $where = array(
                    'in_pickup_id' => $pickup_id
                );
                $ch_delivery_day = $user->get_bo_data_by_key( $user_id, 'st_ch_delivery_day' );
                $st_first_name = $user->get_user_data_by_key( $user_id, 'st_first_name' );
                $update_id = $mydb->update( TBL_CHANGE_ORDER, $set, $where );
                if( isset( $ch_delivery_day ) && $ch_delivery_day != "" ){
                    $t_day = date( 'l', strtotime(" Sunday + {$ch_delivery_day} days") );
                    $pickup_date = date( 'Y-m-d', strtotime( 'next ' . $t_day ) );
                }else{
                    $pickup_date = date( 'Y-m-d', strtotime( 'next monday' ) );
                }
                $set = array(
                    'dt_pickup' => $pickup_date
                );
                
                $update_id = $mydb->update( TBL_PICKUP, $set, $where );
                if( isset( $update_id ) && $update_id > 0 ){
                    $sm_id = $pickup->get_pickup_by_key( $pickup_id, 'in_user_id' );
                    $location_id = $pickup->get_pickup_by_key( $pickup_id, 'in_location_id' );
                    $locationname = $location->get_location_by_key( $location_id, 'st_address' );
                    $sm_data = $user->get_user_data_by( 'in_user_id', $sm_id );    
                    $mail_data = array( "location" => $locationname,
                        "business_owner" => $st_first_name,
                        "base_url" => SITE_NAME );
                    $email_sm_templet = $template->get_template( 'email', '', 'bo_approve_sm_co', TRUE );
                    if ( MAIL_MODE == 'test' ){
                        $sm_email_id = TEST_EMAIL;
                    } else{
                        $sm_email_id = $sm_data['st_email_id'];
                    }
                    $user->send_mail_by_template( $sm_id, $sm_email_id, ' Change Order Request Approved by Business Owner', $email_sm_templet, $mail_data );
                    
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $pickup_id;
                    $this->result['message'] = 'Change order request has been successfully accepted.';
                } else{
                    $this->result['success_flag'] = false;
                    $this->result['data'] = '';
                    $this->result['message'] = 'Change order request not accepted successfully.';
                }
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function change_order_reject( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            include_once FL_USER;
            $user = new user();
            include_once FL_LOCATION;
            $location = new location();
            include_once FL_PICKUP;
            $pickup = new pickup(); 
            $user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 ? $_SESSION['user_id'] : '';
            if( isset( $data['id'] ) && $data['id'] > 0 ){
                $pickup_id = $data['id'];
                $set = array(
                    'in_is_approve' => -1,
                    'st_reject_note' => $data['val']
                );
                $where = array(
                    'in_pickup_id' => $pickup_id
                );
                $update_id = $mydb->update( TBL_CHANGE_ORDER, $set, $where );
                $st_first_name = $user->get_user_data_by_key( $user_id, 'st_first_name' );
                if( isset( $update_id ) && $update_id > 0 ){
                    $sm_id = $pickup->get_pickup_by_key( $pickup_id, 'in_user_id' );
                    $location_id = $pickup->get_pickup_by_key( $pickup_id, 'in_location_id' );
                    $reject_note = $pickup->get_change_order_by_key( $pickup_id, 'st_reject_note' );
                    $locationname = $location->get_location_by_key( $location_id, 'st_address' );
                    $sm_data = $user->get_user_data_by( 'in_user_id', $sm_id );    
                    $mail_data = array( "location" => $locationname,
                        "note" => $reject_note ,
                        "business_owner" => $st_first_name,
                        "base_url" => SITE_NAME );
                    $email_sm_templet = $template->get_template( 'email', '', 'bo_reject_sm_co', TRUE );
                    if ( MAIL_MODE == 'test' ){
                        $sm_email_id = TEST_EMAIL;
                    } else{
                        $sm_email_id = $sm_data['st_email_id'];
                    }
                    $user->send_mail_by_template( $sm_id, $sm_email_id, 'Change Order Request Rejected by Business Owner', $email_sm_templet, $mail_data );
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $pickup_id;
                    $this->result['message'] = 'Change order request rejected. ';
                } else{
                    $this->result['success_flag'] = false;
                    $this->result['data'] = '';
                    $this->result['message'] = 'Change order request rejected not successfully.';
                }
            }
            
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function driver_pay_amounts( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_USER;
            $user = new user();
            include_once FL_PICKUP;
            $pickup = new pickup(); 
            if( isset( $data['id'] ) && $data['id'] > 0 ){
                $job_id = $data['id'];
                $set = array(
                    'st_pay_status' => "payed"
                );
                $where = array(
                    'in_job_id' => $job_id
                );
                $update_id = $mydb->update( TBL_JOB, $set, $where );
                if( isset( $update_id ) && $update_id > 0 ){
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $job_id;
                    $this->result['message'] = 'Driver amount paid successfully.';
                } else{
                    $this->result['success_flag'] = false;
                    $this->result['data'] = '';
                    $this->result['message'] = 'Driver amount not paid successfully';
                }
            }
            
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function change_order_request_days( $data ){
        
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_USER;
            $user = new user();
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            include_once FL_PICKUP;
            $pickup = new pickup(); 
            include_once FL_LOCATION;
            $location = new location();
            include_once FL_BACKGROUND_PROCESS;
            $proc = new BackgroundProcess();
            $form_to = array();
            $form = array(); 
            $to = array();
            $to_sort = array();
            $ch_form = isset( $data['ch_from'] ) && $data['ch_from'] > 0 ? $data['ch_from'] : '';
            $ch_to = isset( $data['ch_to'] ) && $data['ch_to'] > 0 ? $data['ch_to'] : '';
            $txt_bo_id = isset( $data['txt_bo_id'] ) && $data['txt_bo_id'] > 0 ? $data['txt_bo_id'] : '';
            $txt_bo_name = isset( $data['txt_driver_name1'] ) && $data['txt_driver_name1'] != "" ? $data['txt_driver_name1'] : '';
            $ch_delivery_time = isset( $data['ch_delivery_time'] ) && $data['ch_delivery_time'] > 0 ? $data['ch_delivery_time'] : '';
            $user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 ? $_SESSION['user_id'] : '';
            $st_ch_delivery_day = $user->get_bo_data_by_key( $txt_bo_id, 'st_ch_delivery_day' );
            $co_data = $pickup->get_all_change_order_by_bo( $txt_bo_id );
            
            if( isset( $co_data ) &&  is_array( $co_data ) ){
                
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'You can not change the settings as already request sent by store manager.';
            }else{
                if( $ch_form > $ch_to ){
                    for( $i = $ch_form; $i <= 7; $i++ ){
                        array_push( $form,$i );
                    }
                    for( $i = $ch_to; $i >= 1; $i-- ){
                        array_push( $to,$i );
                    };
                    asort( $to );
                    $form_to = array_merge( $form, $to );
                }else{
                    for( $i = $ch_form; $i <= $ch_to; $i++ ){
                        array_push( $form_to,$i );
                    }
                }
                if( isset( $data['arr_rp'] ) ){
                    $arr_rp = json_encode( $data['arr_rp'] );
                }
                
                
                if( isset( $data['arr_rp'] ) && is_array( $data['arr_rp'] ) ){
                     $set = array(
                        'st_ch_from_to_day' => json_encode( $form_to ),
                        'st_change_order_fields' => $arr_rp,
                        'st_ch_delivery_day' => $ch_delivery_time
                    );
                }else{
                    $set = array(
                        'st_ch_from_to_day' => json_encode( $form_to ),
                        'st_ch_delivery_day' => $ch_delivery_time
                    );
                }
                if( $txt_bo_id > 0 ){
                    $user_id = $txt_bo_id;
                    
                }
                if( $user_id > 0 ){
                    $where = array(
                        'in_user_id' => $user_id
                    );
                    $update_id = $mydb->update( TBL_BUSINESS_OWNER, $set, $where );
                }
                if( isset( $update_id ) && $update_id > 0 ){
                   
                    $manager_ids = $location->get_location_data_by( 'in_user_id' , $user_id );
                    $arr_managerids = array();
                    $arr_manager_id = array();
                    if( isset( $manager_ids ) && $manager_ids > 0 ){
                        foreach( $manager_ids as $mk => $mv ){
                            array_push( $arr_managerids , $mv['in_manager_id'] );
                        }
                        $arr_manager_id = array_unique( $arr_managerids );
                    }
                    
                    $bo_name = $user->get_user_data_by_key( $user_id, 'st_first_name' );
                    $bo_email_id = $user->get_user_data_by_key( $user_id, 'st_email_id' );
                    $admin_data = $user->get_user_data_by( 'st_user_type', 'admin' );
                    $sm_id = $user->get_bo_data_by_key( $user_id, 'in_store_manager_id' );
                    $sm_emailid = $user->get_user_data_by_key( $user_id, 'st_first_name' );
                    $f_day = date( 'l', strtotime( "  Sunday + {$ch_form} days" ) );
                    $t_day = date( 'l', strtotime( "  Sunday + {$ch_to} days" ) );
                    $d_day = date( 'l', strtotime( "  Sunday + {$ch_delivery_time} days") );
                    if( $bo_email_id != ""  && isset( $data['txt_driver_name1'] )  && $txt_bo_id > 0 ){
                        
                        $admin_mail_data = array( 
                            "business_owner" => $bo_name ,
                            "day" => $d_day, 
                            "base_url" => SITE_NAME );
                        $email_admin_templet = $template->get_template( 'email', '', 'admin_driver_delivery_day', TRUE );
                        
                        if ( MAIL_MODE == 'test' ){
                            $admin_email_id = TEST_EMAIL;
                        } else{
                            $admin_email_id = $admin_data['st_email_id'];
                        }
                        
                        $user->send_mail_by_template( $admin_data['in_user_id'],$admin_email_id , 'Change order request delivery day scheduled by Admin.', $email_admin_templet, $admin_mail_data );
                        // $command = 'nohup php '. SEND_MAIL_SM_BG_PROCESS . ' '. $user_id . ' ' . $ch_form . ' ' . $ch_to . ' admin  > /dev/null  2>&1  & ';
                        // exec( $command );
                        $command = 'nohup php '. SEND_MAIL_SM_BG_PROCESS . ' '. $user_id . ' ' . $ch_form . ' ' . $ch_to . ' business_owner > /dev/null 2>&1  & echo $!';
                        exec( $command );
                    }else{
                       $admin_mail_data = array( 
                            "admin" => "Admin" ,
                            "day" => $d_day, 
                            "base_url" => SITE_NAME 
                            );
                        
                        $email_admin_templet = $template->get_template( 'email', '', 'bo_admin_driver_delivery_day', TRUE );
                        if ( MAIL_MODE == 'test' ){
                            $bo_emailid = TEST_EMAIL;
                        } else{
                            $bo_emailid = $bo_email_id;
                        }
                       
                        $user->send_mail_by_template( $admin_data['in_user_id'], $bo_emailid, 'Change order request delivery day scheduled by Business owner.', $email_admin_templet, $admin_mail_data );

                        
                        // exec( 'ssh -p 2222 brigloo@192.254.236.251' );
                        // exec('Hostgator55' );

                        // exec("ls",$o);
                        // print_r($o);
                        //exec( 'mkdir view/test' );
                        // $cmd = 'ssh -p 2222 brigloo@192.254.236.251 "nohup command1 > /dev/null 2>&1 &"';
                        $command = 'nohup php5 '. SEND_MAIL_SM_BG_PROCESS . ' '. $user_id . ' ' . $ch_form . ' ' . $ch_to . ' business_owner > /dev/null 2>&1  & echo $';
                        exec( $command, $ops );
                        //print_r($ops);
                        // $command = '/usr/bin/php -f '. SEND_MAIL_SM_BG_PROCESS . ' '. $user_id . ' ' . $ch_form . ' ' . $ch_to . ' business_owner';
                        // $proc->setCmd( $command );
                        // $proc->start();
                    }
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $update_id;
                    $this->result['message'] = 'Change order request setting has been updated successfully.';
                } else{
                    $this->result['success_flag'] = false;
                    $this->result['data'] = '';
                    $this->result['message'] = 'Change order request setting  not set successfully.';
                }
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function driver_assign_job( $data ) {

        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_PICKUP;
            $pickup = new pickup();
            $job_id = isset( $data['job_id'] ) && $data['job_id'] > 0 ? $data['job_id'] : '';
            $user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 ? $_SESSION['user_id'] : '';
            $update_id = $pickup->driver_assign_job( $user_id, $job_id );
            if( isset( $update_id ) && $update_id > 0 ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $update_id;
                $this->result['message'] = 'Driver trip assign successfully.';
            } else if( isset( $update_id ) && $update_id == -1 ){
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'This trip has been taken by another driver. please take another trip or kindly wait.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Driver trip not assign.';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function cancel_pickup_list( $data ) {

        if( isset( $data ) && is_array( $data ) ) {
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
            $pickup_id = isset( $data['id'] ) && $data['id'] > 0 ? $data['id'] : '';
            $cancel_reason = isset( $data['val'] ) && $data['val'] != '' ? $data['val'] : '';
            $user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 ? $_SESSION['user_id'] : '';
            $where = array(
                'in_pickup_id' => $pickup_id
            );
            $arr_set = array(
                'st_cancel_reason' => $cancel_reason,
                'in_is_active' => 0
            );
            $update_id = $mydb->update( TBL_PICKUP, $arr_set, $where );
            if( isset( $update_id ) && $update_id > 0 ){
                $pickup_data = $pickup->get_pickup_data_by_key( $pickup_id );
                $locationname = $location->get_location_by_key( $pickup_data['in_location_id'], 'st_store_id' );
                if( $pickup_data['st_order_type'] == "change_order" ){
                    $bo_data = $user->get_bo_data_by( 'in_store_manager_id',  $pickup_data['in_user_id'] );
                    $bo_id = $bo_data['in_user_id'];
                    $bo_id = $pickup_data['in_user_id'];
                }else{
                    $bo_id = $pickup_data['in_user_id'];
                }
                $bo_name = $user->get_user_data_by_key( $bo_id, 'st_first_name' );
                $bo_emailid = $user->get_user_data_by_key( $bo_id, 'st_email_id' );
                $mail_data = array( 
                    "business_owner" => $bo_name ,
                    "location" => $locationname, 
                    "date" => date( 'Y-m-d', strtotime( $pickup_data['dt_pickup'] ) ) , 
                    "reason" => $pickup_data['st_cancel_reason'], 
                    "base_url" => SITE_NAME 
                    );
                $email_bo_templet = $template->get_template( 'email', '', 'admin_cancel_pickup_request', TRUE );
                if ( MAIL_MODE == 'test' ){
                    $bo_email_id = TEST_EMAIL;
                } else{
                    $bo_email_id = $bo_emailid;
                }
                $user->send_mail_by_template( $bo_id, $bo_email_id, 'Pick-up list canceled by Admin', $email_bo_templet, $mail_data );
                $this->result['success_flag'] = true;
                $this->result['data'] = $update_id;
                $this->result['message'] = 'Pick Up request has been cancel.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Pickup request not cancel.';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function get_job_lat_long( $data ) {

        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_PICKUP;
            $pickup = new pickup();
            $job_id = isset( $data['job_id'] ) && $data['job_id'] > 0 ? $data['job_id'] : '';
            $job_data = $pickup->get_job_by_key( $job_id, 'st_route' );
             if( isset( $job_data ) && ( $job_data != '' || $job_data != 0 ) ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $job_data;
                $this->result['message'] = 'Pick Up request has been cancel.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Pick Up request not cancel.';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function get_pickup_info( $data ) {

        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_PICKUP;
            $pickup = new pickup();
            $id = isset( $data['id'] ) && $data['id'] > 0 ? $data['id'] : '';
            $job_data = $pickup->get_pickiup_by_id( $id );
             if( isset( $job_data ) && ( $job_data != '' || $job_data != 0 ) ){
                $job_data['dt_created_at'] = date( "m-d-Y H:i:s", strtotime( $job_data['dt_created_at'] ) ); 
                $this->result['success_flag'] = true;
                $this->result['data'] = $job_data;
                $this->result['message'] = '';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = '';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function get_job_info( $data ) {

        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_PICKUP;
            $pickup = new pickup();
            $id = isset( $data['id'] ) && $data['id'] > 0 ? $data['id'] : '';
            $job_data = $pickup->get_assign_pickups_by_job_id( $id );
             if( isset( $job_data ) && ( $job_data != '' || $job_data != 0 ) ){
                $job_data[0]['dt_created_at'] = date( "m-d-Y H:i:s", strtotime( $job_data[0]['dt_created_at'] ) ); 
                $job_data[0]['dt_pickup'] = date( "m-d-Y H:i:s", strtotime( $job_data[0]['dt_pickup'] ) ); 
                $this->result['success_flag'] = true;
                $this->result['data'] = $job_data;
                $this->result['message'] = '';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = '';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function get_user_info( $data ) {

        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_USER;
            $user = new user();
            $id = isset( $data['id'] ) && $data['id'] > 0 ? $data['id'] : '';
            $user_data = $user->get_user_by_id( $id );
             if( isset( $user_data ) && ( $user_data != '' || $user_data != 0 ) ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $user_data;
                $this->result['message'] = '';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = '';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    /**
     * 
     * 
     **/
    public function job_reassign_driver( $data ) {
        if( isset( $data ) && is_array( $data ) ) {
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
            $driver_id = isset( $data['txt_driver_name'] ) && $data['txt_driver_name'] != '' ? $data['txt_driver_name'] : '';
            $job_id = isset( $data['reassign_job_id'] ) && $data['reassign_job_id'] > 0 ? $data['reassign_job_id'] : '';
            $bo_id = isset( $data['reassign_bo_id'] ) && $data['reassign_bo_id'] > 0 ? $data['reassign_bo_id'] : '';
            $old_driver_id = $pickup->get_job_by_key( $job_id, 'in_driver_id' );
            $where = array(
                'in_job_id' => $job_id
            );
            $arr_set = array(
                'in_driver_id' => $driver_id
            );
            $update_id = $mydb->update( TBL_JOB, $arr_set, $where );
            if( isset( $update_id ) && $update_id > 0 ){
                $pickup_data = $pickup->get_job_data_by_key( $job_id );
                $dt_pickup = $pickup_data['dt_pickup'];
                $pick_date = date("m-d-Y", strtotime( $dt_pickup ) );
                
                /* send mail to Store manager */
//                if( $pickup_data['st_order_type'] == "change_order" ){
//                    $manager_id = $pickup_data['in_user_id'];
//                }else{
//                    $manager_id = $pickup_data['in_manager_id'];
//                }
//                $dt_pickup = $pickup_data['dt_pickup'];
//                $pick_date = date("m-d-Y", strtotime( $dt_pickup ) );
//                $sm_email_id = $user->get_user_data_by_key( $manager_id, 'st_email_id' );
//                $sm_name = $user->get_user_data_by_key( $manager_id, 'st_first_name' );
//                $sm_mail_data = array( "user_name" => $sm_name,
//                    "date" => $pick_date,
//                    "base_url" => SITE_NAME );
//                $email_sm_templet = $template->get_template( 'email', '', 'store_manager_pickup_schedule', TRUE );
//                if ( MAIL_MODE == 'test' ){
//                    $sm_email_id = TEST_EMAIL;
//                } else{
//                    $sm_email_id = $sm_email_id;
//                }
//                $user->send_mail_by_template( $manager_id, $sm_email_id, 'Cop Express - Pickup list assigned to driver ', $email_sm_templet, $sm_mail_data );
                
//                $locationname = $location->get_location_by_key( $pickup_data['in_location_id'], 'st_location_name' );
                
                /* send mail to Old driver */
                $old_driver_name = $user->get_user_data_by_key( $old_driver_id, 'st_first_name' );
                $old_driver_emailid = $user->get_user_data_by_key( $old_driver_id, 'st_email_id' );
                $old_driver_mail_data = array( 
                    "driver" => $old_driver_name,
                    "date" => $pick_date,  
                    "base_url" => SITE_NAME 
                );
                $email_old_driver_templet = $template->get_template( 'email', '', 'send_driver_admin_reasssign_pickup_request', TRUE );
                if ( MAIL_MODE == 'test' ){
                    $old_driver_email_id = TEST_EMAIL;
                } else{
                    $old_driver_email_id = $old_driver_emailid;
                }
                $user->send_mail_by_template( $old_driver_id, $old_driver_email_id, 'Pick Up list cancel by Admin', $email_old_driver_templet, $old_driver_mail_data );
                
                /* send mail to New driver */
                $driver_email_id = $user->get_user_data_by_key( $driver_id, 'st_email_id' );
                $drivername = $user->get_user_data_by_key( $driver_id, 'st_first_name' );
                $email_driver_templete = $template->get_template('email', '', 'pickup_schedule', TRUE);
                $driver_mail_data = array( 
                        "user_name" => $drivername,
                        "date" => $pick_date,
                        "base_url" => SITE_NAME 
                    );
                $email_driver_templet = $template->get_template('email', '', 'driver_pickup_schedule', TRUE);
                if ( MAIL_MODE == 'test' ){
                    $driver_email_id = TEST_EMAIL;
                } else {
                    $driver_email_id = $driver_email_id;
                }
                $user->send_mail_by_template( $driver_id, $driver_email_id, 'Cop Express - Pick up list assigned to driver: '.$drivername.' ', $email_driver_templete, $driver_mail_data );
                
                /* send mail to Business owner */
//                if( $pickup_data['st_order_type'] == "change_order" ){
//                    $bo_data = $user->get_bo_data_by( 'in_store_manager_id',  $pickup_data['in_user_id'] );
//                    $bo_id = $bo_data['in_user_id'];
//                }else{
//                    $bo_id = $pickup_data['in_user_id'];
//                }
//                $bo_name = $user->get_user_data_by_key( $bo_id, 'st_first_name' );
//                $bo_emailid = $user->get_user_data_by_key( $bo_id, 'st_email_id' );
//                if ( MAIL_MODE == 'test' ){
//                    $bo_email_id = TEST_EMAIL;
//                } else{
//                    $bo_email_id = $bo_emailid;
//                }
//                $bo_email_templete = $template->get_template('email', '', 'pickup_schedule', TRUE);
//                $bo_mail_data = array( 
//                    "user_name" => $bo_name,
//                    "pickup_id" => $locationname,
//                    "base_url" => SITE_NAME );
//                $user->send_mail_by_template( $bo_id, $bo_email_id,'Cop Express - Pickup list assigned to driver: ' . $drivername . ' ', $bo_email_templete, $bo_mail_data );
                
                $this->result['success_flag'] = true;
                $this->result['data'] = $drivername;
                $this->result['id'] = $job_id;
                $this->result['message'] = 'Pick Up request has been reassign.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Pick Up request not reassign.';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function cancel_recurring( $data ) {
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_PICKUP;
            $pickup = new pickup();
            $recurring_id = isset( $data['recurring_id'] ) && $data['recurring_id'] > 0 ? $data['recurring_id'] : '';
            $where = array(
                'in_recurring_id' => $recurring_id
            );
            $arr_set = array(
                'in_is_active' => 0
            );
            $update_id = $mydb->update( TBL_RECURRING_PICKUP, $arr_set, $where );
            if( isset( $update_id ) && $update_id > 0 ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $update_id;
                $this->result['message'] = 'Route request has been deleted';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Route request has been not deleted';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function get_recurring_by_id( $data ) {
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_PICKUP;
            $pickup = new pickup();
            $recurring_id = isset( $data['recurring_id'] ) && $data['recurring_id'] > 0 ? $data['recurring_id'] : '';
            
            $recurring_data = $pickup->get_recurring_by_id( $recurring_id );
            if( isset( $recurring_data ) && ( $recurring_data != '' && $recurring_data != 0 ) ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $recurring_data;
                $this->result['message'] = '';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = '';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function edit_recurring( $data ) {
        if( isset( $data ) && is_array( $data ) ) {
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
            $recurring_id = isset( $data['hdn_recurring_id'] ) && $data['hdn_recurring_id'] > 0 ? $data['hdn_recurring_id'] : '';
            $recurring_type = isset( $data['recurring_type'] ) && $data['recurring_type'] != '' ? $data['recurring_type'] : '';
            $pickup_weekly_recurring_date = isset( $data['pickup_weekly_recurring_date'] ) && $data['pickup_weekly_recurring_date'] != "" ? $data['pickup_weekly_recurring_date'] : '';
            $pickup_monthly_recurring_date = isset( $data['pickup_monthly_recurring_date'] ) && $data['pickup_monthly_recurring_date'] != "" ? $data['pickup_monthly_recurring_date'] : '';
            $amt = isset( $data['amt'] ) && $data['amt'] > 0 ? $data['amt'] : '';
            $location_id = isset( $data['location'] ) && $data['location'] > 0 ? $data['location'] : '';
            if( isset( $recurring_id ) && $recurring_id > 0 ){
                $where = array(
                    'in_recurring_id' => $recurring_id
                );
                if( $recurring_type == "weekly" ){
                    $type = $pickup_weekly_recurring_date;
                }else{
                    $type = $pickup_monthly_recurring_date;
                }
                $arr_set = array(
                    'in_location_id' => $location_id,
                    'st_recurring_type' => $recurring_type,
                    'st_recurring_date' => $type,
                    'fl_amount' => $amt
                );
                $update_id = $mydb->update( TBL_RECURRING_PICKUP, $arr_set, $where );
                $recurring_data = $pickup->get_recurring_by_id( $recurring_id );
                if( isset( $recurring_data['st_recurring_type'] ) && $recurring_data['st_recurring_type'] == "weekly"  ){
                    $recurring_data['recurring_date'] =  date( 'l', strtotime(" Sunday + {$recurring_data['st_recurring_date']} days") );
                }else{
                   $recurring_data['recurring_date'] = date( "m-d-Y", strtotime( $recurring_data['st_recurring_date'] ) ); 
                }
                $recurring_data['recurring_type'] = isset( $recurring_data['st_recurring_type'] ) && $recurring_data['st_recurring_type'] == "weekly" ? "<img src='" . IMAGES_URL . "weekly.png' title='Weekly'/>" : "<img src='" . IMAGES_URL . "calendar.png' title='Monthly'/>"; 
                $recurring_data['recurring_amt'] = '$' . ( isset( $recurring_data['fl_amount'] ) && $recurring_data['fl_amount'] == '' || $recurring_data['fl_amount'] > 0 ? $recurring_data['fl_amount'] : "0" );
                $recurring_data['location_name'] = $location->get_location_by_key( $recurring_data['in_location_id'], 'st_location_name' );
                $recurring_data['location_address'] = $location->get_location_by_key( $recurring_data['in_location_id'], 'st_address' );
                $recurring_data['user_name'] = $user->get_user_data_by_key( $recurring_data['in_user_id'], 'st_first_name' );
            }
            
            if( isset( $update_id ) && ( $update_id != '' && $update_id != 0 ) ){
                
                $this->result['success_flag'] = true;
                $this->result['data'] = $recurring_data;
                $this->result['message'] = '';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = '';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function user_delete( $data ) {
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_PICKUP;
            $pickup = new pickup();
            $id = isset( $data['id'] ) && $data['id'] > 0 ? $data['id'] : '';
            $where = array(
                'in_user_id' => $id
            );
            $arr_set = array(
                'in_is_active' => -1
            );
            $update_id = $mydb->update( TBL_USER, $arr_set, $where );
            if( isset( $update_id ) && $update_id > 0 ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $update_id;
                $this->result['message'] = 'User has been deleted successfully.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'User not deleted.';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function user_disable( $data ) {
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_PICKUP;
            $pickup = new pickup();
            $id = isset( $data['id'] ) && $data['id'] > 0 ? $data['id'] : '';
            $where = array(
                'in_user_id' => $id
            );
            $arr_set = array(
                'in_is_active' => -2
            );
            $update_id = $mydb->update( TBL_USER, $arr_set, $where );
            if( isset( $update_id ) && $update_id > 0 ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $update_id;
                $this->result['message'] = 'User has been disable successfully.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'User not disable.';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    public function user_enable( $data ) {
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_PICKUP;
            $pickup = new pickup();
            $id = isset( $data['id'] ) && $data['id'] > 0 ? $data['id'] : '';
            $where = array(
                'in_user_id' => $id
            );
            $arr_set = array(
                'in_is_active' => 1
            );
            $update_id = $mydb->update( TBL_USER, $arr_set, $where );
            if( isset( $update_id ) && $update_id > 0 ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $update_id;
                $this->result['message'] = 'User has been enable successfully.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'User not enable.';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function check_driver_verify( $data ){
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            include_once FL_PICKUP;
            $pickup = new pickup();
            $pickup_id = isset( $data['pickup_id'] ) && $data['pickup_id'] > 0 ? $data['pickup_id'] : 0;
            $st_driver_verify = 0;
            if( $pickup_id > 0 ){
                $st_driver_verify = $pickup->get_pickup_by_key( $pickup_id, 'st_driver_verify' );
            }
            if( isset( $st_driver_verify ) && $st_driver_verify > 0 ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $st_driver_verify;
                $this->result['message'] = '';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = '';
            }
        }
         echo ( json_encode( $this->result ) );
    }
    
    public function add_contact_data( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_USER;
            $user = new user();
            $first_name = isset( $data['txt_first_name'] ) && $data['txt_first_name'] ? $data['txt_first_name'] : '';
            $last_name = isset( $data['txt_last_name'] ) && $data['txt_last_name'] ? $data['txt_last_name'] : '';
            $email_id = isset( $data['txt_email_address'] ) && $data['txt_email_address'] ? $data['txt_email_address'] : '';
            $phone_no = isset( $data['txt_phone_no'] ) && $data['txt_phone_no'] ? $data['txt_phone_no'] : '';
            $description = isset( $data['txt_des'] ) && $data['txt_des'] ? $data['txt_des'] : '';
            $arr_data = array(
                'st_first_name' => $first_name,
                'st_last_name' => $last_name,
                'st_email_id' => $email_id,
                'in_contact_no' => $phone_no,
                'st_description' => $description
            );
            $insert_id = $mydb->insert( TBL_CONTACT, $arr_data );
            if ( $insert_id > 0 ) {
                $user->send_confirmation_contact_data( $insert_id );
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "
Thank you for getting in touch! We will get back to you shortly..";
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
            }
            die( json_encode( $this->result ) );
        }
    }
    
    public function edit_change_order_data( $data ){
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            $pickup_id = isset( $data['pickup_id'] ) && $data['pickup_id'] > 0 ? $data['pickup_id'] : 0;
            $pickup_data = $pickup->get_change_order_by_id( $pickup_id );
            $pickup_data['fl_amount'] = $pickup->get_pickup_by_key( $pickup_id , 'fl_amount' );
            if( isset( $pickup_data ) && $pickup_data > 0 ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $pickup_data;
                $this->result['message'] = 'Change order request updated successfully.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Change order request not updated successfully.';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    
    public function driver_stop_job( $data ){
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            include_once FL_USER;
            $user = new user();
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            $job_id = isset( $data['job_id'] ) && $data['job_id'] > 0 ? $data['job_id'] : 0;
            $pickup_id = isset( $data['pickup_id'] ) && $data['pickup_id'] > 0 ? $data['pickup_id'] : 0;
            $em_stop_reason = isset( $data['em_stop_reason'] ) && $data['em_stop_reason'] != '' ? $data['em_stop_reason'] : '';
            if( $job_id > 0 && $pickup_id > 0 ){
                $em_pause_reason = $pickup->get_pickup_by_key( $pickup_id, 'st_em_resume_reason' );
                $em_pause_time = $pickup->get_pickup_by_key( $pickup_id, 'dt_em_pause' );
                if( isset( $em_pause_time ) && $em_pause_time != "" ){
                    $arr_pause_reason = json_decode( $em_pause_reason );
                    $arr_pause_time = json_decode( $em_pause_time );
                    $start_time = date( "Y-m-d H:i:s" );
                    array_push( $arr_pause_time, $start_time );
                    $start_time = json_encode( $arr_pause_time );
                    array_push( $arr_pause_reason, $em_stop_reason ) ;
                    $pause_reason = json_encode( $arr_pause_reason );
                }else{
                    $arr_pause_time = array( date( "Y-m-d H:i:s" ) );
                    $start_time = json_encode( $arr_pause_time );
                    $arr_pause_reason = array( $em_stop_reason );
                    $pause_reason = json_encode( $arr_pause_reason );
                }
                
                $arr_set_pickup = array(
                    'st_status' => 'pause',
                    'st_em_resume_reason' => $pause_reason,
                    'dt_em_pause' => $start_time    
                );
                $arr_where_pickup = array(
                    'in_pickup_id' => $pickup_id
                );
                $update_id = $mydb->update( TBL_PICKUP, $arr_set_pickup, $arr_where_pickup );
//                $arr_set = array(
//                    'st_stop_reason' => $em_stop_reason,
//                    'st_status' => 'pause'
//                );
//                $arr_where = array(
//                    'in_job_id' => $job_id
//                );
//                $update_id = $mydb->update( TBL_JOB, $arr_set, $arr_where );
            }
            if( isset( $update_id ) && $update_id > 0 ){
                $bo_id = $pickup->get_pickup_by_key( $pickup_id, 'in_user_id' );
                $bo_name = $user->get_user_data_by( 'st_user_type', 'admin' );
                
                if ( MAIL_MODE == 'test' ){
                    $admin_email_id = TEST_EMAIL;
                } else{
                    $admin_email_id = $bo_name['st_email_id'];
                }
                $bo_email_templete = $template->get_template( 'email', '', 'bo_driver_stop_job', TRUE );
                $bo_mail_data = array( 
                    "bo_name" => $bo_name['st_first_name'],
                    "job_id" => $job_id,
                    "reason" => $em_stop_reason,
                    "base_url" => SITE_NAME );
                $user->send_mail_by_template( $bo_id,  $admin_email_id,'Cop Express - Driver trip has been paused ', $bo_email_templete, $bo_mail_data );
                $this->result['success_flag'] = true;
                $this->result['data'] = $job_id;
                $this->result['redirect'] = VW_DRIVER_ACTIVEJOB . "?job_id=" . $job_id;
                $this->result['message'] = 'Your trip has been paused.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Your trip not stop successfully.';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function driver_resume_pickup( $data ){
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PICKUP;
            $pickup = new pickup();
            include_once FL_USER;
            $user = new user();
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            $job_id = isset( $data['job_id'] ) && $data['job_id'] > 0 ? $data['job_id'] : 0;
            $pickup_id = isset( $data['pickup_id'] ) && $data['pickup_id'] > 0 ? $data['pickup_id'] : 0;
            if( $job_id > 0 && $pickup_id > 0 ){
                $em_resume_time = $pickup->get_pickup_by_key( $pickup_id, 'dt_em_resume' );
                if( isset( $em_resume_time ) && $em_resume_time != "" ){
                    $arr_resume_time = json_decode( $em_resume_time );
                    $start_time = date( "Y-m-d H:i:s" );
                    array_push( $arr_resume_time, $start_time );
                    $resume_time = json_encode( $arr_resume_time );
                    
                }else{
                    $arr_resume_time = array( date( "Y-m-d H:i:s" ) );
                    $resume_time = json_encode( $arr_resume_time );
                }
                $arr_set_pickup = array(
                    'st_status' => 'onroute',
                    'dt_em_resume' => $resume_time
                );
                $arr_where_pickup = array(
                    'in_pickup_id' => $pickup_id
                );
                $update_id = $mydb->update( TBL_PICKUP, $arr_set_pickup, $arr_where_pickup );
            }
            if( isset( $update_id ) && $update_id > 0 ){
                $bo_id = $pickup->get_pickup_by_key( $pickup_id, 'in_user_id' );
                $bo_name = $user->get_user_data_by( 'st_user_type', 'admin' );
                
                if ( MAIL_MODE == 'test' ){
                    $admin_email_id = TEST_EMAIL;
                } else{
                    $admin_email_id = $bo_name['st_email_id'];
                }
                $bo_email_templete = $template->get_template( 'email', '', 'driver_resume_trip', TRUE );
                $bo_mail_data = array( 
                    "bo_name" => $bo_name['st_first_name'],
                    "job_id" => $job_id,
                    "base_url" => SITE_NAME );
                $user->send_mail_by_template( $bo_id, $admin_email_id,'Cop Express - Driver trip is continue. ', $bo_email_templete, $bo_mail_data );
                $this->result['success_flag'] = true;
                $this->result['data'] = $job_id;
                $this->result['redirect'] = VW_DRIVER_ACTIVEJOB . "?job_id=" . $job_id;
                $this->result['message'] = 'Your trip is continue.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Your trip not resume successfully.';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    function load_location_bo( $a_data ){
        
        if( isset( $a_data ) && is_array( $a_data ) ){
            include_once FL_USER;
            $user = new user();
            include_once FL_LOCATION;
            $location = new location();
            global $mydb;
            
            $where = '';
            $order_by = '';
            $params = $columns = $totalRecords = $data = array();
            $params = $a_data;
            $columns = array(
                0 => 'action',
                1 => 'location_id',
                2 => 'location_name',
                3 => 'bo_name'
            );
            
            if (!empty($params['search']['value'])) {
                $where .= "AND ";
                $where .= " ( st_nocation_name LIKE '%" . $params['search']['value'] . "%' ) ";
            }
            
            if ( isset( $params['order'] ) ) {
                $order_col = $columns[$params['order'][0]['column']];                
                $order_dir = $params['order'][0]['dir'];
                $order_by = ' ORDER BY ' . $order_col . ' ' . $order_dir . ' ';                
            }
            
            $sr_no = $params['start'];
            $limit = ' LIMIT 10 ';
            if ( isset( $params['start'] ) && isset( $params['length'] ) ) {
                $params['start'] = ( ( $params['start'] > 0 ) ? $params['start'] : 0 );
                $params['length'] = ( ( $params['length'] > 0 ) ? $params['length'] : 10 );
                $limit = ' LIMIT ' . $params['start'] . ', ' . $params['length'];
            }
            
            $bo_id = isset( $a_data['bo_id'] ) ? $a_data['bo_id'] : 0;
            $group_id = isset( $a_data['group_id'] ) ? $a_data['group_id'] : 0;
            
            $where_group = '';
            if( isset( $group_id )  && $group_id > 0 ){
                $where_group = ' AND in_group_id != ' . $group_id . '  ';
            }
            
            $str_quer_cnt = 'SELECT count(*)   FROM ' . $mydb->prefix . TBL_LOCATION . ' WHERE in_user_id = ' . $bo_id . ' AND in_is_active = 1 ' . $where . $where_group;
            $response_cnt = $mydb->query( $str_quer_cnt );
            
            $str_query = 'SELECT *   FROM ' . $mydb->prefix . TBL_LOCATION . ' WHERE in_user_id = ' . $bo_id . ' AND in_is_active = 1 ' . $where . $where_group . $limit;
            $response = $mydb->query( $str_query );
            
            if( isset( $response ) && $response > 0 || $response != '' ){
                if( isset( $response['in_location_id'] ) ){
                    $response = array( $response );
                }
                $loc_count = count( $response );
                foreach ( $response as $resk => $resv ) { 
                    $bo_name = $user->get_user_data_by_key( $resv['in_user_id'] , 'st_first_name' );
                    $counter = '<div class=""> ' .
                            '<button type="button" id="location_chk_' . $resv['in_location_id'] . '" class="arr_location btn btn-success" name="arr_location[]" value="' . $resv['in_location_id'] . '" >' .
                                'Add</button>' .
                            '</div>';
                    $data[] = array(
                        'action' => $counter,
                        'location_id' => $resv['in_location_id'],                    
                        'location_name' => $resv['st_location_name'],                    
                        'bo_name' => $bo_name,                    
                    );        
                }
            }
             
            $json_encode = array(  
                "recordsTotal" => intval( $response_cnt ),  
                "recordsFiltered" => intval( $response_cnt ),
                "data" => $data 
            );
            echo json_encode( $json_encode );
        }
    }
    
    function load_location_data( $a_data ){
        
        if( isset( $a_data ) && is_array( $a_data ) ){
            include_once FL_USER;
            $user = new user();
            include_once FL_LOCATION;
            $location = new location();
            global $mydb;
            
            $where = '';
            $order_by = '';
            $params = $columns = $totalRecords = $data = array();
            $params = $a_data;
            $columns = array(
                0 => 'action',
                1 => 'location_id',
                // 2 => 'location_name',
                2 => 'address',
                3 => 'bo_name'
            );
            
            if (!empty($params['search']['value'])) {
                $where .= "AND ";
                $where .= " ( st_nocation_name LIKE '%" . $params['search']['value'] . "%' ) ";
            }
            
            if ( isset( $params['order'] ) ) {
                $order_col = $columns[$params['order'][0]['column']];                
                $order_dir = $params['order'][0]['dir'];
                $order_by = ' ORDER BY ' . $order_col . ' ' . $order_dir . ' ';                
            }
            
            $limit = ' LIMIT 10 ';
            if ( isset( $params['start'] ) && isset( $params['length'] ) ) {
                $params['start'] = ( ( $params['start'] > 0 ) ? $params['start'] : 0 );
                $params['length'] = ( ( $params['length'] > 0 ) ? $params['length'] : 10 );
                $limit = ' LIMIT ' . $params['start'] . ', ' . $params['length'];
            }
            
            $loc_name = isset( $a_data['loc_name'] ) && $a_data['loc_name'] != '' ? $a_data['loc_name'] : '';
            $group_id = isset( $a_data['group_id'] ) ? $a_data['group_id'] : 0;
            
            $where_group = '';
            if( isset( $group_id )  && $group_id > 0 ){
                $where_group = ' AND in_group_id != ' . $group_id . '  ';
            }
            
            $str_quer_cnt = 'SELECT count(in_location_id) as count   FROM ' . $mydb->prefix . TBL_LOCATION . ' WHERE st_location_name LIKE "%' . $loc_name . '%" OR st_address LIKE "%' . $loc_name . '%" AND in_is_active = 1 ' . $where . $where_group;
            $response_cnt = $mydb->query( $str_quer_cnt );
            $str_query = 'SELECT *   FROM ' . $mydb->prefix . TBL_LOCATION . ' WHERE ( st_location_name LIKE "%' . $loc_name . '%" OR st_address LIKE "%' . $loc_name . '%" ) AND in_is_active = 1 ' . $where . $where_group . $limit;
            $response = $mydb->query( $str_query );
            
            if( isset( $response ) && $response > 0 || $response != '' ){
                if( isset( $response['in_location_id'] ) ){
                    $response = array( $response );
                }
                $loc_count = count( $response );
                foreach ( $response as $resk => $resv ) { 
                    $bo_name = $user->get_user_data_by_key( $resv['in_user_id'] , 'st_first_name' );
                    $counter = '<div class=""> ' .
                            '<button type="button" id="location_chk_' . $resv['in_location_id'] . '" class="arr_location btn btn-success" name="arr_location[]" value="' . $resv['in_location_id'] . '" >' .
                                'Add</button>' .
                            '</div>';
                    $data[] = array(
                        'action' => $counter,
                        'location_id' => $resv['in_location_id'],                    
                        // 'location_name' => $resv['st_location_name'],                    
                        'address' => $resv['st_address'],                    
                        'bo_name' => $bo_name,                    
                    );        
                }
            }
            $json_encode = array(  
                "recordsTotal" => intval( $response_cnt['count'] ),  
                "recordsFiltered" => intval( $response_cnt['count'] ),
                "data" => $data 
            );
            echo json_encode( $json_encode );
        }
    }
    
    public function add_group( $data ){
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_GROUP;
            $group = new group();
            $txt_group_name = isset( $data['txt_group_name'] ) && $data['txt_group_name'] != '' ? $data['txt_group_name'] : 0;
            
            if( $txt_group_name != "" ){
                $insert_id = $group->add_group( $data );
            }
            
            if( isset( $insert_id ) && $insert_id > 0 ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = 'Group created successfully.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Group not created successfully';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function edit_group( $data ){
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            
            include_once FL_GROUP;
            $group = new group();
            $txt_group_name = isset( $data['txt_group_name'] ) && $data['txt_group_name'] != '' ? $data['txt_group_name'] : 0;
            
            if( $txt_group_name != "" ){
                $insert_id = $group->edit_group( $data );
            }
            
            if( isset( $insert_id ) && $insert_id > 0 ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = 'Group edit successfully.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Group not edit successfully';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function driver_mid_point_status( $data ){
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            
            include_once FL_PICKUP;
            $pickup = new pickup();
            $job_id= isset( $data['job_id'] ) && $data['job_id'] != '' ? $data['job_id'] : 0;
            $mid_type= isset( $data['mid_type'] ) && $data['mid_type'] != '' ? $data['mid_type'] : '';
            
            if( $job_id != "" ){
                $insert_id = $pickup->driver_mid_point_status( $job_id, $mid_type );
            }
            
            if( isset( $insert_id ) && $insert_id > 0 ){
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = 'Driver navigate to bank.';
                $bank_data = $pickup->get_job_address_data( $data['job_id'], '', 'bank' );
                $bank_name = isset( $bank_data['st_add'] ) && $bank_data['st_add'] != '' ? $bank_data['st_add'] : '';
                $bank_plus = preg_replace( '/\s/ ', '+', $bank_name );
                $this->result['location'] = 'https://www.google.com/maps/dir/?api=1&dir_action=navigate&destination=' . $bank_plus;
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Driver not navigate to bank.';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    
    public function get_group_info( $data ){
        if( isset( $data ) && is_array( $data ) ) {
            
            global $mydb;
            include_once FL_USER;
            $user = new user();
            include_once FL_GROUP;
            $group = new group();  
            include_once FL_LOCATION;
            $location = new location();
            $group_id = isset( $data['group_id'] ) && $data['group_id'] != '' ? $data['group_id'] : 0;
            
            if( $group_id != "" ){
                $group_data = $group->get_group_by_id( $group_id );
            }
            
            if( isset( $group_data ) && $group_data > 0 || $group_data != "" ){
                $location_data = $location->get_location_data_by( 'in_group_id', $group_data['in_group_id'] );
                
                if( isset( $location_data ) && $location_data != "" || $location_data > 0 ){
                    if( isset( $location_data['in_location_id'] ) ){
                        $location_data = array( $location_data );
                    }
                    $group_data['location'] = $location_data;
                    foreach( $location_data as $loc_k => $loc_v ){
                        $group_data['location'][$loc_k]['bo_name'] = $user->get_user_data_by_key( $loc_v['in_user_id'] , 'st_first_name' );
                    }
                }
                
                $this->result['success_flag'] = true;
                $this->result['data'] = $group_data;
                $this->result['message'] = 'Group data fetch successfully.';
            } else{
                $this->result['success_flag'] = false;
                $this->result['data'] = '';
                $this->result['message'] = 'Group data not fetch successfully';
            }
        }
        echo ( json_encode( $this->result ) );
    }
    
    public function forgot_password( $data ) {
        
        if ( isset( $data['email'] ) ) {
            include_once FL_USER;
            $user = new user();
            include_once FL_HTML_TEMPLATE;
            $template = new template();
            $user_data = $user->get_user_data_by( 'st_email_id', $data['email'] );            
            $userdata = $user->get_user_data_by( $user_data['in_user_id'] );
            $arr_data = array();

            if ( isset( $user_data ) && $user_data !== '' ) {
                
                $current_timestamp = time();
                $generate_key = $user_data['in_user_id'] . $current_timestamp;
                $generate_time = $current_timestamp;
                $arr_data['generated_key'] = md5( $generate_key );
                $arr_data['generated_time'] = $generate_time;
                $arr_data['link_verified'] = 0;
                $insert_id = $user->update_userdata( $user_data['in_user_id'], 'st_password_recovery_link', json_encode( $arr_data ) );
                $bo_emailid = $data['email'];
                if ( MAIL_MODE == 'test' ){
                    $bo_email_id = TEST_EMAIL;
                } else{
                    $bo_email_id = $data['email'];
                }
                $link = VW_PASSWORD_RECOVERY_URL . "?email=" . $data['email'];
                
                $bo_email_templete = $template->get_template( 'email', '', 'forgot_password_mail', TRUE );
                $bo_mail_data = array( 
                    "link" => $link,
                    "base_url" => SITE_NAME );
                $user->send_mail_by_template( $user_data['in_user_id'], $bo_email_id,'Cop Express - Password Recovery', $bo_email_templete, $bo_mail_data );
                
                
                

//                $user->send_mail( $data['email'], "Password Recovery", $body );
            }

            if ( $insert_id !== '' && count( $insert_id ) > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['message'] = 'Please check your Email...';
                $this->result['data']['email'] = $data['email'];
            } else {
                $this->result['success_flag'] = false;
                $this->result['message'] = 'Email id not exist......';
                $this->result['data'] = "";
            }

            echo json_encode( $this->result );
        }
    }
    
    function recovery_password( $data ) {

        if ( !session_id() ) {
            session_start();
        }
        
        if ( isset( $data['email'] ) ) {
            global $mydb;
            $password = ( isset( $data['txt_pwd'] ) && $data['txt_pwd'] !== '' ) ? md5( $data['txt_pwd'] ) : '';

            $arr_data = array(
                'st_password' => $password,
            );
            $where = array(
                'st_email_id' => $data['email'],
            );
            $insert_id = $mydb->update( TBL_USER, $arr_data, $where );

            if ( $insert_id !== '' && $insert_id > 0 ) {


                $this->result['success_flag'] = true;
                $this->result['message'] = 'Password Set';
                $this->result['data'] = $insert_id;
            } else {
                $this->result['success_flag'] = false;
                $this->result['message'] = 'Password not set';
                $this->result['data'] = '';
            }
        }
        echo ( json_encode($this->result) );
    }
    
    function delivery_change_order_direct( $data ){
        global $mydb;
        if( isset( $data ) && is_array( $data ) ) {
            include_once FL_PICKUP;
            $pickup = new pickup();
            
            $pickup_id = isset( $data['pickup_id'] ) && $data['pickup_id'] > 0 ? $data['pickup_id'] : 0;
            $pickup_date = isset( $data['pickup_date'] ) && $data['pickup_date'] != "" ? $data['pickup_date'] : '';
            if( $pickup_id > 0 ){
                
                $update_id = $pickup->delivery_change_order_direct( $data );
                if( isset( $update_id ) && $update_id > 0 ){
                    $this->result['success_flag'] = true;
                    $this->result['message'] = 'Request submitted successfully.';
                    $this->result['data'] = $update_id;
                } else {
                    $this->result['success_flag'] = false;
                    $this->result['message'] = 'Request not submitted.';
                    $this->result['data'] = '';
                }
            }
        }
        echo ( json_encode($this->result) );
    }
    
}