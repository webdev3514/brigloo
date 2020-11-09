<?php 
require_once '../../config/config.php';
require_once '../../backend/config/admin_config.php';
if ( !session_id() ) {
    session_start();
}
if( !isset( $_SESSION['user_id'] ) && !isset( $_SESSION['user_type'] ) ){
    header( "location:" . BASE_URL );
} else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] != "business_owner"  ){	
    header( "location:" . BASE_URL );
}
include_once FL_LOGIN_HEADER;
include_once FL_LOGIN_SIDEBAR;

include_once FL_USER;
$user = new user();
$user_id = isset( $_SESSION['user_id'] ) &&  $_SESSION['user_id']  != '' ? $_SESSION['user_id'] : '';  
?>
<div class="page-content">
    <?php  include_once FL_LOGIN_SUB_HEADER;?> 
    <div class="page-content-wrap">                  
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body"> 
                        <div class="panel-heading">
                            <h3 class="panel-title" style="text-transform: capitalize">My Locations</h3>
                            <a href="#"><div style="float: right;" class="btn btn-danger" id="add_location"> Add New Location <i class="fa fa-plus "></i> </div></a>
                        </div>
                        <?php include_once TP_ADD_LOCATION;?>
                        <div class="panel-body table-responsive">
                            <table  class="table datatable location-data" id="html_template">
                                <thead>
                                    <tr>
                                        <th class="td-width">Id</th>
                                        <th>Store ID</th>
                                        <th>Store E-Mail</th>
                                        <!--<th>Location Name</th>-->
                                        <th>Address</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php
                                            include_once FL_LOCATION;
                                            $location = new location();
                                            $location_data = $location->get_all_location( $user_id , 'DESC' );
                                            if( isset( $location_data ) && $location_data != '' ){
                                                
                                                if( isset( $location_data['in_location_id'] ) ){
                                                    $location_data = array( $location_data );
                                                }
                                                foreach( $location_data as $l_data ){
                                                    $store_email = $user->get_user_data_by_key( $l_data['in_manager_id'], 'st_email_id' );
                                                    ?>
                                                    <tr class="location_<?php echo $l_data['in_location_id']; ?>">
                                                        <td class="td-width">#<?php echo $l_data['in_location_id']; ?></td>
                                                        <td><?php echo $l_data['st_store_id']; ?></td>
                                                        <td><?php echo $store_email; ?></td>
                                                        <!--<td><?php // echo $l_data['st_location_name']; ?></td>-->
                                                        
                                                        <td class="cut_location_address"><?php echo $l_data['st_address']; ?></td>
                                                        <td class='edit_location' data-edit_location='<?php echo $l_data['in_location_id']; ?>'><i class='fa fa-edit btn btn-primary'></i></td>
                                                        <td class='delete_location' data-delete_location='<?php echo $l_data['in_location_id']; ?>'><i class='fa fa-times btn btn-danger'></i></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        ?>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once FL_LOGIN_FOOTER_INCLUDE;
?>
<script type='text/javascript' src="<?php echo ADMIN_JS_PLUGINS_PATH .'icheck/icheck.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'mcustomscrollbar/jquery.mCustomScrollbar.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'datatables/jquery.dataTables.min.js'; ?>"></script>  

<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=<?php echo GOOGLE_MAPS_API_KEY; ?>"></script>
<script type="text/javascript" src="<?php echo JS_PLUGINS_PATH; ?>location-picker/locationpicker.jquery.min.js"></script>

<script type="text/javascript" src="<?php echo JS_PATH; ?>location.js"></script>
<?php
include_once FL_LOGIN_FOOTER;
?>