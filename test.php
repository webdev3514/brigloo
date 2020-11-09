<?php
require_once '../config/config.php';
$ajax = new user_ajax();

if ( isset( $_POST['action'] ) && !empty( trim( $_POST['action'] ) ) ) {
    $call = trim( $_POST['action'] );
    if( method_exists( $ajax, $call ) ){
        $ajax->$call( $_POST );
    } else {
        $result = array(
            'success_flag' => 0,
            'message' => 'No AJAX call available...'
        );
        echo json_encode( $result );
    }
}

class user_ajax {

    public function __construct() {
        $this->result['success_flag'] = false;
        $this->result['message'] = '';
        $this->result['data'] = array();
    }
    
    /* User login */
    public function user_exits( $data ) {
        global $mydb;
        if( $id != "" && $password != "" ){
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
                $sess_id = session_id();
                $result = array();
                $result = $this->result;
                $varification_data = json_decode( $response['link_data'] );
                if ( $response['st_user_type'] == 'store_manager' ) {
                    if( $response['in_is_active'] == 1 ){
                        $result['success_flag'] = true;
                        $result['message'] = 'Login successfully';
                    }else{
                        $result['success_flag'] = false;
                        $result['message'] = "Email Id and Password is wrong.";
                    }
                } else if( isset( $varification_data ) && $varification_data->link_verified == 1 ) {
                    if( $response['in_is_active'] == 1  ){
                        $result['success_flag'] = true;
                        $result['message'] = 'Login successfully';
                    }
                }else{
                    if ( $response['st_user_type'] == 'admin') {
                        $result['success_flag'] = true;
                        $result['message'] = 'Login successfully';
                    } else{
                        $result['success_flag'] = false;
                        $result['message'] = "You have not verified your account. Please check your email for verification link.";
                    }
                }
            } else{
                $result['success_flag'] = false;
                $result['message'] = 'Wrong Email ID or Password';
            }
            echo( json_encode( $result ) );
        }

    }
    
}

            
    ?>
