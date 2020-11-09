<?php
session_start();
require_once '../config/config.php';

$page_title = ucwords("user verification");
if( isset( $_SESSION['user_id'] ) &&  $_SESSION['user_id'] != "" ){
    $user_id = $_SESSION['user_id'];
} else if ( isset( $_SESSION['admin_id'] ) &&  $_SESSION['admin_id'] != "" ){
    $user_id = $_SESSION['admin_id'];
} else{
    
}

$id = isset( $_GET['id'] ) && $_GET['id'] != '' ? $_GET['id'] : '';
$user_key = isset( $_GET['k'] ) && $_GET['k'] != '' ? $_GET['k'] : '';
$user_type = isset( $_GET['type'] ) && $_GET['type'] != '' ? $_GET['type'] : '';
if( $user_type == "change_password" && !$user_id ){
    header( "location:" . VW_LOGIN );
    exit;
}else if(  $user_type == "change_email" && !$user_id ){
    header( "location:" . VW_LOGIN );
    exit;
}else{
    
}
include_once FL_USER_HEADER;
include_once FL_USER;

$user = new user();

$verified_data = $user->get_register_verification_data( $id, $user_key, $user_type );

if ( $verified_data['success_flag'] == 0 ) {
    ?>
    <div class="container">
        <div class="message-display-section">
            <img src="<?php echo IMAGES_URL;?>/green-tick.png" class="verify-img" height="15" width="15">
            <div id="new_msg"><?php echo $verified_data['message']; ?></div>
            <div class="msg-display"><?php echo 'Thank you for joining Cop Express!'; ?></div>
        </div>
    </div>
<?php } else {
    ?>
    <div class="container">
        <div class="message-display-section">
            <img src="<?php echo IMAGES_URL;?>/Red_cross_tick.png" class="verify-img" height="15" width="15">
            <div id="new_msg"><?php echo $verified_data['message']; ?></div>
        </div>
    </div>
<?php }
?>

<?php //$extra_js[] = 'user.js'; ?>

<?php
include_once FL_USER_FOOTER_INCLUDE;
?>
<?php if ( $verified_data['success_flag'] == 0 ) {
    if( isset( $verified_data['type'] ) && $verified_data['type'] == "change_password" && $user_id = $id ){?>
        <script>
            setTimeout( function(){ window.location.href = '<?php echo VW_CHANGE_PASSWORD; ?>'; }, 3000);
        </script>
    <?php } else if( isset( $verified_data['type'] ) && $verified_data['type'] == "change_email" ){?>
        <script>
            setTimeout( function(){ window.location.href = '<?php echo VW_LOGOUT; ?>'; }, 3000);
        </script>
    <?php }else{
    ?>
        <script>
            setTimeout( function(){ window.location.href = '<?php echo VW_LOGOUT; ?>'; }, 3000);
        </script>
    <?php
    } ?>
<?php
}?>
<?php
include_once FL_USER_FOOTER;
?>
