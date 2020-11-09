<?php
$group = new group();

class group {

    public $flag_err = FALSE;
   
    function __construct() {
        $this->flag_err = FALSE;
        $this->active = ' in_is_active = 1 ';
    }


    function add_group( $data ) {
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            $arr_location_id = isset( $data['arr_location_id'] ) && $data['arr_location_id'] != '' ? $data['arr_location_id'] : 0;
                $txt_group_name = isset( $data['txt_group_name'] ) && $data['txt_group_name'] != '' ? $data['txt_group_name'] : 0;
                $arr_loc_id = explode( ',', $arr_location_id );
            $arr_data = array(
                'st_group_name' => $txt_group_name
            );
            $insert_id = $mydb->insert( TBL_GROUP , $arr_data );
            if( isset( $insert_id ) && $insert_id > 0 ){
                foreach( $arr_loc_id as $loc_k => $loc_v ){
                    $arr_where = array(
                        'in_location_id' => $loc_v
                    );
                    $arr_set = array(
                        'in_group_id' => $insert_id
                    );
                    $update_id = $mydb->update( TBL_LOCATION , $arr_set, $arr_where );
                }
                return $insert_id;
            }else{
                return 0;
            }
        }
    }
    
    function edit_group( $data ) {
        if( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_LOCATION;
            $location = new location();
            
            $arr_location_id = isset( $data['arr_location_id'] ) && $data['arr_location_id'] != '' ? $data['arr_location_id'] : 0;
            $edit_group_id = isset( $data['edit_group_id'] ) && $data['edit_group_id'] != '' ? $data['edit_group_id'] : 0;
            $txt_group_name = isset( $data['txt_group_name'] ) && $data['txt_group_name'] != '' ? $data['txt_group_name'] : 0;
            $arr_loc_id = explode( ',', $arr_location_id );
            $arr_data = array(
                'st_group_name' => $txt_group_name
            );
            $arr_group_where = array(
                'in_group_id' => $edit_group_id
            );
            $update_id = $mydb->update( TBL_GROUP , $arr_data, $arr_group_where );
            if( isset( $update_id ) && $update_id > 0 ){
                $location_data = $location->get_location_data_by( 'in_group_id', $edit_group_id );
                if( isset( $location_data ) && $location_data != "" || $location_data > 0 ){
                    if( isset( $location_data['in_location_id'] ) ){
                        $location_data = array( $location_data );
                    }
                    foreach( $location_data as $loc_k => $loc_v ){
                        $arr_where = array(
                            'in_location_id' => $loc_v['in_location_id']
                        );
                        $arr_set = array(
                            'in_group_id' => 0
                        );
                        $update_id = $mydb->update( TBL_LOCATION , $arr_set, $arr_where );
                    }
                }
                foreach( $arr_loc_id as $loc_k => $loc_v ){
                    $arr_where = array(
                        'in_location_id' => $loc_v
                    );
                    $arr_set = array(
                        'in_group_id' => $edit_group_id
                    );
                    $update_id = $mydb->update( TBL_LOCATION , $arr_set, $arr_where );
                }
                return $update_id;
            }else{
                return 0;
            }
        }
    }
    
    function get_all_group(){
        
        global $mydb;
        if ( !session_id() ) {
            session_start();
        }

        $group_data = $mydb->get_all( TBL_GROUP, '*' );
        if ( $group_data !== '' && $group_data > 0 ) {
            return $group_data;
        } else {
            return 0;
        }
    }
    
    function get_group_by_id( $group_id = 0  ){
        if( isset( $group_id ) && $group_id > 0 ){
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            
            $where = array( 
                'in_group_id' => $group_id
            );
            
            $group_data = $mydb->get_all( TBL_GROUP, '*', $where );
            if ( $group_data !== '' && $group_data > 0 ) {
                return $group_data;
            } else {
                return 0;
            }
        }
    }
    
    function get_group_by_key( $group_id, $key = '' ) {
        global $mydb;
        if( isset( $group_id ) && trim( $group_id ) !== '' && $group_id > 0 ){
            $select = '*';
            $where = ' WHERE in_group_id = ' . $group_id;
            if( isset( $key ) && trim( $key ) !== '' ){
                $select = $key;
            }
            $str_query = 'SELECT ' . $select . ' FROM ' . $mydb->prefix . TBL_GROUP . $where;
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