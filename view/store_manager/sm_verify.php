<?php
if ( !session_id() ) {
    session_start();
}
require_once '../../config/config.php';
require_once '../../backend/config/admin_config.php';

include_once FL_USER;
$user = new user();
include_once FL_PICKUP;
$pickup = new pickup();  
include_once FL_LOCATION;
$location = new location();
$key = isset( $_REQUEST['key'] ) &&  $_REQUEST['key'] != '' ?  $_REQUEST['key'] : '';
$job_id = isset( $_REQUEST['id'] ) &&  $_REQUEST['id'] != '' ?  $_REQUEST['id'] : '';
$pickup_id = isset( $_REQUEST['p_id'] ) &&  $_REQUEST['p_id'] != '' ?  $_REQUEST['p_id'] : '';
$same_loc_id = isset( $_REQUEST['s_lid'] ) &&  $_REQUEST['s_lid'] != '' ?  $_REQUEST['s_lid'] : '';
$st_sm_link = $pickup->get_pickup_by_key( $pickup_id, 'st_sm_link' );
$st_driver_verify = $pickup->get_pickup_by_key( $pickup_id, 'st_driver_verify' );
$st_sm_verify = $pickup->get_pickup_by_key( $pickup_id, 'st_sm_verify' );
$st_order_type = $pickup->get_pickup_by_key( $pickup_id, 'st_order_type' );
$check_verify = $pickup->check_verify_sm( $job_id, $key, 1 );
include_once FL_USER_HEADER;
  
if( $same_loc_id > 0 ){
    $where = array(
        'in_pickup_id' => $same_loc_id
    );
    $response = $mydb->get_all( TBL_PICKUP , '*' , $where );
    $other_order_type = $response['st_order_type'];
}else{
    $other_order_type = $st_order_type;
}

?>
<div class="container">
    <div class="separate-section login-section">
        <?php 
        if( isset( $st_driver_verify ) && $st_driver_verify == 0 && $st_sm_verify == 1 ){
            echo '<div class="loader show"><h4 class="nothing-msg loader show">Driver verified successfully.
                Please wait until driver verifies store manager
                .</h4></div>';
        }else if( isset( $check_verify['in_pickup_id'] ) ){
            echo '<h4 class="nothing-msg"><p>Thank you for verifying the driver.</p><p>You may exit the window now.</p></h4><h4 class=""></h4>';
        }else{
            ?>
            <h2 class="form-title">
                <div class="form-icon login-icon">
                    <i class="fa fa-sign-in" aria-hidden="true"></i>
                </div>
                Please verify the driver before proceeding
            </h2>
            <div class="alert alert-success alert-dismissable login-success hide-el" style="display: none;">
    
                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
    
                <span class="login-msg"></span>
    
            </div>
    
            <div class="alert alert-danger alert-dismissable login-failed hide-el" style="display: none;">
    
                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>
    
                <span class="login-msg"></span>
    
            </div>
            <?php 
        
            if( isset( $st_sm_link ) && $st_sm_link != "" ){
                if( $key == $st_sm_link ){
                   ?>

                    <form method="post" action="" id="sm_verify_driver_info" name="sm_verify_driver_info">
                        <input type="hidden" id="id" name="id" value="<?php echo $job_id; ?>">
                        <input type="hidden" id="pickup_id" name="pickup_id" value="<?php echo $pickup_id; ?>">
                        <div class="form-control">
                            <label>License Number</label>
                            <input type="text" required="" class="input-field" id="txt_liecense_id" name="txt_liecense_id"/>
                        </div>
                        <div class="form-control">
                            <label>Store ID</label>
                            <input type="text" required="" class="input-field" id="txt_store_id" name="txt_store_id" />
                        </div>
                      
                        <?php if( isset( $st_order_type ) && $st_order_type == "change_order" && $other_order_type == "change_order" ){ 
                            ?>
                            <input type='hidden' value='Did you receive change orders today?' name='order_type_msg' id='order_type_msg'/>
                            <?php
                        }else{ ?>
                        <div class="form-control">
                            <label>Deposit amount</label>
                            <input type='hidden' value="Are you sure to give the today's pickup to the driver?" name='order_type_msg' id='order_type_msg'/>
                            <input type="number" required="" class="input-field" id="txt_amount" name="txt_amount"/>
                        </div>
                        <?php }  ?>
                        <div class="form-control">
                            <label>Note( Optional )</label>
                            <textarea class="input-field" id="txt_note" name="txt_note"></textarea>
                        </div>
                        <input type="hidden" name="same_loc_id" value="<?php echo $same_loc_id; ?>" id="same_loc_id">
                        <input type="hidden" name="pickup_type" value="<?php echo $st_order_type; ?>" id="pickup_type">
                        <div class="form-control submit-wrapper">
                            <input type="submit" value="Submit" name="" class="common-button">
                        </div>
                        
                    </form>
                   <?php
                }else{
                    echo "Sorry, You can not verify through this link. ";
                }
            }
        }?>
    </div>
</div>


<?php
require_once FL_USER_FOOTER_INCLUDE;
?>
<script type='text/javascript' src="<?php echo ADMIN_JS_PLUGINS_PATH .'icheck/icheck.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'mcustomscrollbar/jquery.mCustomScrollbar.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'datatables/jquery.dataTables.min.js'; ?>"></script>  
<!--<script type="text/javascript" src="<?php echo JS_PATH .'location.js'; ?>"></script>  -->
<?PHP 
include_once FL_USER_FOOTER;
?>
<?php 
if( isset( $st_driver_verify ) && $st_driver_verify == 0  && $st_sm_verify == 1 ){
?>
<script>
    setInterval(function(){ 
        $.ajax({
            type:       "POST",
            dataType:   "html",
            url:        USER_AJAX_URL,
            data:       "action=check_driver_verify&pickup_id=" + <?php echo $pickup_id; ?>,
            async:      false,
            success:    function ( data ) {
                
                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ){
                    hide_loader();
                    location.reload();
                } else {
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
    }, 3000);
</script>
<?php 
}
?>