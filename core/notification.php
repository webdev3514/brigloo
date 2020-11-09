<?php

$notification = new notification();

class notification {
    function __construct(){
    }
    
    function set_notify_message( $user_id = 0, $notify_type = '', $notify_datatype = 'text', $template_data = array(), $body_data = '' ){        
        
        if( isset( $user_id ) && trim( $user_id ) !== '' && $user_id > 0 ){
           
            global $mydb;
            $body = $this->prepare_notify_message( $user_id, $template_data, $body_data );
            $arr_data = array(
                'in_user_id' => $user_id,
                'st_notify_type' => $notify_type,
                'st_notify_datatype' => $notify_datatype,
                'st_body' => $body
            );
            $insert_id = $mydb->insert( TBL_NOTIFICATION, $arr_data );
            
            if( $insert_id !== '' && $insert_id > 0 ){
                return $insert_id;
            } else {
                return 0;
            }
        }
    }
    
    function get_user_notification( $user_id = 0, $notify_type = '', $select = '*', $is_read = 0, $limit = 0 ){
        if( isset( $user_id ) && trim( $user_id ) !== '' && $user_id > 0 ){
            global $mydb;
            
            if ( isset( $limit ) && $limit > 0 ) {
                $str_limit = $limit ;
            }
            $where = array(
                'in_user_id' => $user_id,
                'in_is_read' => $is_read,
                'in_is_active' => 1
            );
            
            if( isset( $notify_type ) && trim( $notify_type ) !== '' ){
                $where['st_notify_type'] = $notify_type;
            }
            $user_notification = $mydb->get_all( TBL_NOTIFICATION, $select, $where, 'dt_created_at DESC');
            if( isset( $user_notification['in_notify_id'] ) ){
                $user_notification = array( $user_notification );
            }
            return $user_notification;
        }
    }
    
    function get_user_count_notification( $user_id = 0, $is_read = 0 ){
        if( isset( $user_id ) && trim( $user_id ) !== '' && $user_id > 0 ){
            global $mydb;
            $where = array(
                'in_user_id' => $user_id,
                'in_is_read' => $is_read,
                'in_is_active' => 1
            );
           $str_sl = ' SELECT st_notify_type as type, count(*) as total_notify FROM ' . $mydb->prefix . TBL_NOTIFICATION . ' WHERE in_user_id = ' . $user_id
                    . ' AND in_is_read = ' . $is_read
                    . ' AND in_is_active = ' . 1
                    . ' GROUP BY st_notify_type '
                    ;
                    
            $user_count_notification = $mydb->query( $str_sl );
            if( isset( $user_count_notification['type'] ) ){
                $user_count_notification = array( $user_count_notification );
            }
            return $user_count_notification;
        }
    }
    
    function prepare_notify_message( $user_id = 0, $template_data = array(), $body_data = '' ){
        if( isset( $user_id ) && trim( $user_id ) !== '' && $user_id > 0 ){
            if( isset( $template_data ) ){
                if( isset( $template_data['st_template_value'] ) ){
                    $msg_tpl = $template_data['st_template_value'];
                } else {
                    $msg_tpl = $template_data;
                }
                $str_replaced = $this->prepare_body( $body_data, $msg_tpl );
                return $str_replaced;
            }
        }
    }
    
    function prepare_body( $body_data, $template ){
        $arr_replace_from = array();
        $arr_replace_to = array();
        foreach ( $body_data as $bdk => $bdv ) {
            $arr_replace_from[] = '/\[' . $bdk . '\]/';
            $arr_replace_to[] = $bdv;
        }
        $str_replaced = preg_replace( $arr_replace_from, $arr_replace_to, $template );
        
        return $str_replaced;
    }
}