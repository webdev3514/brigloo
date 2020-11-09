<?php
define( 'ADMIN_DIR', 'admin' );
define( 'INCLUDE_DIR', 'includes' );
define( 'USER_INCLUDE_DIR', 'user_includes' );
define( 'VIEW_DIR', 'view' );
define( 'DRIVER_DIR', 'driver' );
define( 'BO_DIR', 'business_owner' );
define( 'SM_DIR', 'store_manager' );
define( 'TMP_SM_DIR', 'store_manager' );
define( 'ASSET_DIR', 'assets' );
define( 'CORE_DIR', 'core' );
define( 'USER_DIR', 'user' );
define( 'IMAGES_DIR', 'images' );
define( 'BACKEND_DIR', 'backend' );
define( 'UPLOAD_DIR', 'uploads' );
define( 'TEMPLATE_PART_DIR', 'template_parts' );
define( 'JS_PATH', BASE_URL . DIR_SEPERATOR . ASSET_DIR . DIR_SEPERATOR . 'js' . DIR_SEPERATOR);
define( 'JS_PLUGINS_PATH', BASE_URL . DIR_SEPERATOR . ASSET_DIR . DIR_SEPERATOR . 'js' . DIR_SEPERATOR ."plugins" . DIR_SEPERATOR  );
define( 'ADMIN_JS_PATH', BASE_URL . DIR_SEPERATOR . BACKEND_DIR . DIR_SEPERATOR . ASSET_DIR . DIR_SEPERATOR . 'js' . DIR_SEPERATOR);
define( 'ADMIN_URL', BASE_URL . DIR_SEPERATOR . BACKEND_DIR . DIR_SEPERATOR );
define( 'CSS_PATH', BASE_URL . DIR_SEPERATOR . ASSET_DIR . DIR_SEPERATOR . 'css' . DIR_SEPERATOR );
define( 'UPLOAD_URL', BASE_URL . UPLOAD_DIR . DIR_SEPERATOR );
define( 'UPLOAD_PATH', BASE_PATH . UPLOAD_DIR . DIR_SEPERATOR );
define( 'IMAGES_URL', BASE_URL . IMAGES_DIR . DIR_SEPERATOR );
define( 'IMAGES_PATH', BASE_PATH . IMAGES_DIR . DIR_SEPERATOR );

//Database
define( 'HOSTNAME', 'localhost' );
define( 'DBUSERNAME', 'brigloo_brigloo' );
define( 'DBPASSWORD', 'brigloo123*' );
define( 'DBNAME', 'brigloo_brigloo' );
define( 'DBPREFIX', 'brigloo_' );

//Table Names
define( 'TBL_USER', 'user' );
define( 'TBL_GROUP', 'group' );
define( 'TBL_USERMETA', 'usermeta' );
define( 'TBL_DRIVER', 'driver' );
define( 'TBL_BUSINESS_OWNER', 'business_owner' );
define( 'TBL_HTML_TEMPLATE', 'html_templates' );
define( 'TBL_NOTIFICATION', 'notification' );
define( 'TBL_LOCATION', 'location' );
define( 'TBL_PICKUP', 'pickups' );
define( 'TBL_JOB', 'jobs' );
define( 'TBL_CHANGE_ORDER', 'change_order' );
define( 'TBL_CHANGE_ORDER_MAIL', 'change_order_mail' );
define( 'TBL_SETTINGS', 'settings' );
define( 'TBL_ACTIVITY', 'activity_log' );
define( 'TBL_RECURRING_PICKUP', 'recurring_pickup' );
define( 'TBL_CRON', 'cron' );
define( 'TBL_CONTACT', 'contact' );
define( 'TBL_ORDER', 'order' );

/* Core Files */
define( 'FL_USER', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'user.php');
define( 'FL_HTML_TEMPLATE', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'template.php');
define( 'FL_NOTIFICATION', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'notification.php');
define( 'FL_LOCATION', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'location.php');
define( 'FL_PICKUP', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'pickup.php');
define( 'FL_SETTINGS', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'settings.php');
define( 'FL_ACTIVITY', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'activity.php');
define( 'FL_CRON', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'cron.php');
define( 'FL_GROUP', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'group.php');
define( 'FL_BACKGROUND_PROCESS', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'PHPBackgroundProcesser.php');

/* Includes */
define( 'FL_USER_HEADER', BASE_PATH . DIR_SEPERATOR . INCLUDE_DIR . DIR_SEPERATOR . 'header.php');
define( 'FL_USER_HEADER_INCLUDE', BASE_PATH . DIR_SEPERATOR . INCLUDE_DIR . DIR_SEPERATOR . 'header_includes.php');
define( 'FL_USER_FOOTER', BASE_PATH . DIR_SEPERATOR . INCLUDE_DIR . DIR_SEPERATOR . 'footer.php');
define( 'FL_USER_FOOTER_INCLUDE', BASE_PATH . DIR_SEPERATOR . INCLUDE_DIR . DIR_SEPERATOR . 'footer_includes.php');

/* Includes */
define( 'FL_LOGIN_HEADER', BASE_PATH . DIR_SEPERATOR  . USER_INCLUDE_DIR . DIR_SEPERATOR . 'header.php');
define( 'FL_LOGIN_HEADER_INCLUDE', BASE_PATH . DIR_SEPERATOR   . USER_INCLUDE_DIR . DIR_SEPERATOR . 'header_includes.php');
define( 'FL_LOGIN_FOOTER', BASE_PATH . DIR_SEPERATOR   . USER_INCLUDE_DIR . DIR_SEPERATOR . 'footer.php');
define( 'FL_LOGIN_FOOTER_INCLUDE', BASE_PATH . DIR_SEPERATOR   . USER_INCLUDE_DIR . DIR_SEPERATOR . 'footer_includes.php');
define( 'FL_LOGIN_SIDEBAR', BASE_PATH . DIR_SEPERATOR  . USER_INCLUDE_DIR . DIR_SEPERATOR . 'sidebar.php');
define( 'FL_LOGIN_SUB_HEADER', BASE_PATH . DIR_SEPERATOR . USER_INCLUDE_DIR . DIR_SEPERATOR . 'sub_header.php');


/* Views File */
define( 'VW_HOME', BASE_PATH . VIEW_DIR . DIR_SEPERATOR . 'home.php' );
define( 'VW_APPROVE_REJECT', BASE_URL . VIEW_DIR . DIR_SEPERATOR . 'approve_reject.php' );
define( 'VW_LOGIN', BASE_URL . VIEW_DIR . DIR_SEPERATOR . 'login.php' );
define( 'VW_CONTACT', BASE_URL . VIEW_DIR . DIR_SEPERATOR . 'contact.php' );
define( 'VW_DRIVER_REGISTRATION', BASE_URL . VIEW_DIR . DIR_SEPERATOR . 'driver_registration.php' );
define( 'VW_BO_REGISTRATION', BASE_URL . VIEW_DIR . DIR_SEPERATOR . 'bo_registration.php' );
define( 'VW_SM_REGISTRATION', BASE_URL . VIEW_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'sm_registration.php' );
define( 'VW_VARIFICATION', BASE_URL . VIEW_DIR . DIR_SEPERATOR . 'user_varification.php' );
define( 'VW_DRIVER_HOME', BASE_URL . VIEW_DIR . DIR_SEPERATOR . DRIVER_DIR . DIR_SEPERATOR . 'home.php' );
define( 'VW_BO_HOME', BASE_URL . VIEW_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'home.php' );
define( 'SEND_MAIL_SM_BG_PROCESS', BASE_PATH . VIEW_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'sm_send_mail_change_order_setting.php' );
define( 'VW_DRIVER_REPORT', BASE_URL . VIEW_DIR . DIR_SEPERATOR . DRIVER_DIR . DIR_SEPERATOR . 'driver_report.php' );
define( 'VW_DRIVER_MYACCOUNT', BASE_URL . VIEW_DIR . DIR_SEPERATOR . DRIVER_DIR . DIR_SEPERATOR . 'my_account.php' );
define( 'VW_DRIVER_PENDINGJOBS', BASE_URL . VIEW_DIR . DIR_SEPERATOR . DRIVER_DIR . DIR_SEPERATOR . 'pending_jobs.php' );
//define( 'VW_DRIVER_COMPLETED_JOBS', BASE_URL . VIEW_DIR . DIR_SEPERATOR . DRIVER_DIR . DIR_SEPERATOR . 'completed_job.php' );
define( 'VW_DRIVER_MYJOBS', BASE_URL . VIEW_DIR . DIR_SEPERATOR . DRIVER_DIR . DIR_SEPERATOR . 'my_jobs.php' );
define( 'VW_DRIVER_PICKUP_AMOUNT', BASE_URL . VIEW_DIR . DIR_SEPERATOR . DRIVER_DIR . DIR_SEPERATOR . 'driver_pickup_amt.php' );
define( 'VW_DRIVER_ACTIVEJOB', BASE_URL . VIEW_DIR . DIR_SEPERATOR . DRIVER_DIR . DIR_SEPERATOR . 'active_job.php' );   
define( 'VW_DRIVER_ARCHIVED_JOBS', BASE_URL . VIEW_DIR . DIR_SEPERATOR . DRIVER_DIR . DIR_SEPERATOR . 'archived_job.php' );   
define( 'VW_BO_MYACCOUNT', BASE_URL . VIEW_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'my_account.php' );
define( 'VW_BO_REPORT', BASE_URL . VIEW_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'bo_report.php' );
define( 'VW_MY_LOCATIONS', BASE_URL . VIEW_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'my_location.php' );
define( 'VW_CHANGE_PASSWORD', BASE_URL . VIEW_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'change_password.php' );
define( 'VW_NEW_PICKUP', BASE_URL . VIEW_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'new_pickup.php' );
define( 'VW_CHANGE_ORDERS', BASE_URL . VIEW_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'change_orders.php' );
define( 'VW_ADD_CHANGE_ORDER', BASE_URL . VIEW_DIR . DIR_SEPERATOR . SM_DIR . DIR_SEPERATOR . 'add_change_orders.php' );
define( 'VW_LOGOUT',  BASE_URL  . VIEW_DIR . DIR_SEPERATOR . 'logout.php' );
define( 'VW_SM_HOME', BASE_URL . VIEW_DIR . DIR_SEPERATOR . SM_DIR . DIR_SEPERATOR . 'home.php' );
define( 'VW_SM_VERIFY', BASE_URL . VIEW_DIR . DIR_SEPERATOR . SM_DIR . DIR_SEPERATOR . 'sm_verify.php' );
define( 'VW_PICK_LIST', BASE_URL . VIEW_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'pickup_list.php' );
define( 'VW_RECURRING_LIST', BASE_URL . VIEW_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'recurring_list.php' );
define( 'VW_INTERRUPT_JOB', BASE_URL . VIEW_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'interrupt_jobs.php' );
define( 'VW_SEND_MAIL_SM_BG_PROCESS', BASE_URL . VIEW_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'sm_send_mail_change_order_setting.php' );
define( 'VW_PASSWORD_RECOVERY_URL',  BASE_URL  . VIEW_DIR . DIR_SEPERATOR . 'password_recovery.php' );


/* Templates */
define( 'TP_ADD_LOCATION', BASE_PATH . DIR_SEPERATOR . TEMPLATE_PART_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'tmp_add_location.php' );
define( 'TP_EDIT_RECURRING', BASE_PATH . DIR_SEPERATOR . TEMPLATE_PART_DIR . DIR_SEPERATOR . BO_DIR . DIR_SEPERATOR . 'tmp_edit_recurring.php' );
define( 'TP_EDIT_CHANGE_ORDER', BASE_PATH . DIR_SEPERATOR . TEMPLATE_PART_DIR . DIR_SEPERATOR . TMP_SM_DIR . DIR_SEPERATOR . 'tmp_edit_change_order.php' );
define( 'FL_USER_FORGOT_PASSWORD', BASE_PATH .  DIR_SEPERATOR . TEMPLATE_PART_DIR . DIR_SEPERATOR . 'forgot_password.php' );
define( 'TPL_USER_LOGIN', BASE_URL . 'login.php' );
define( 'TPL_USER_LOGOUT', BASE_URL . 'logout.php' );
define( 'TP_FORGOT_PASSWORD', BASE_PATH . DIR_SEPERATOR . TEMPLATE_PART_DIR . DIR_SEPERATOR . 'forgot_password.php' );



/* plugin file */
define( 'PHP_PLUGIN_URL', BASE_PATH .DIR_SEPERATOR .'plugins' . DIR_SEPERATOR );
define( 'PL_MAILER', PHP_PLUGIN_URL . 'PHPMailer' .DIR_SEPERATOR );
define( 'PL_MAILER_NEW', PHP_PLUGIN_URL . 'phpmailer_new' .DIR_SEPERATOR );
define( 'PL_SMS_TWILIO', PHP_PLUGIN_URL . 'twilio-php-master' .DIR_SEPERATOR );

/* Other Files */
define('FL_CONNECTION', BASE_PATH . DIR_SEPERATOR . CONFIG_DIR . DIR_SEPERATOR . 'connection.php');
define('FL_COMMON', BASE_PATH . DIR_SEPERATOR . CONFIG_DIR . DIR_SEPERATOR . 'common.php');
/*  Google Map  API key */
define('GOOGLE_MAPS_API_KEY', 'AIzaSyCMH2G4lznu8c0A5PRHfScM_pVq_py0Mfo');

/* Mail section  */


define( 'SMTP_SECURE', 'ssl' );
define( 'SMTP_HOST', 'gator3276.hostgator.com' );
define( 'SMTP_PORT', '465' );
define( 'SMTP_USER_NAME', 'info@copexpress.com' ); //SMTP Gmail Email ID
define( 'SMTP_PASSWORD', 'info123*' ); //SMTP Gmail Password
define( 'SMTP_FROM_NAME', 'Cop Express' );

/* SMS section  */
define( 'SMS_MODE' , "test" );
define( 'SMS_TO_NUMBER' , "9638783045" ); //Twilio API fixed 'To Number'
define( 'SMS_FORM_NUMBER' , "" ); //Twilio API 'From Number'
define( 'SMS_SID' , "" ); //Twilio API SID
define( 'SMS_TOKEN' , "" ); //Twilio API Token

$admin_extra_js = array();
$extra_js = array();
error_reporting(0);

require_once FL_CONNECTION;
$connection = new connection();
require_once FL_COMMON;
$common = new common();
include_once FL_SETTINGS;
$settings = new settings();
if ( !session_id() ) {
    $session_id = session_start();
}
$mail_mode = $settings->get_settings( 'mail_mode' , TRUE );
$mailmode = isset( $mail_mode ) && $mail_mode != '' ? $mail_mode : 'test';
define( 'MAIL_MODE' , $mailmode );
if ( MAIL_MODE == 'live' ) {
    
} else if ( MAIL_MODE == 'test' ) {
    define( 'TEST_EMAIL', 'mtachmuhammedov@yahoo.com' );
}

