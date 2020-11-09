<?php
session_start();
require_once '../config/config.php';
header( "location:" . VW_LOGIN );
include_once FL_USER_HEADER;

$page = isset( $_REQUEST['page'] ) &&  $_REQUEST['page'] != '' ?  $_REQUEST['page'] : '';
if( $page != "" ){
    switch ( $page ){
        case 'login':
            include_once VW_LOGIN;
            break;
        default :
            die(0);
    }
}else{
    include_once VW_HOME;
}


include_once FL_USER_FOOTER_INCLUDE;
include_once FL_USER_FOOTER;
?>