<?php 
require_once '../../config/config.php';
require_once '../config/admin_config.php';
if( !isset( $_SESSION['user_id'] ) && !isset( $_SESSION['user_type'] ) ){
    header( "location:" . BASE_URL );
} else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] != "admin"  ){	
    header( "location:" . BASE_URL );
}
include_once FL_LOGIN_HEADER;
include_once FL_LOGIN_SIDEBAR;

include_once FL_USER;
$user = new user();
include_once FL_GROUP;
$group = new group();  
include_once FL_LOCATION;
$location = new location();
?>
<div class="page-content">
    <?php  include_once FL_LOGIN_SUB_HEADER;?> 
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title" style="text-transform: capitalize">Create Group</h3>
                        <button class="btn btn-success" id="create_group"  style="float: right;" >Create Group</button>
                    </div>
                    <?php
                    $group_data = $group->get_all_group( );
                    if( isset( $group_data ) && $group_data != '' ){
                        if( isset( $group_data['in_group_id'] ) ){
                            $group_data = array( $group_data );
                        }
                        foreach( $group_data as $g_data ){
                        ?>
                            <div class="admin-main-report-list">
                                <div class="bo-list">
                                    <div class="bo-box">
                                        <div class="bo-item">
                                            <p>Group Name:
                                                <label><?php echo  $g_data['st_group_name']; ?></label>
                                            </p>
                                        </div>
                                    </div>
                                    <a class=" btn btn-success edit_group" data-group_id="<?php  echo $g_data['in_group_id']; ?>" href="#">Edit</a>
                                    <a data-toggle="collapse" data-target="#group_<?php  echo $g_data['in_group_id']; ?>"  class=" btn btn-success report_open" data-job_id="<?php  echo $g_data['in_group_id']; ?>" href="#">Open</a>
                                </div>
                                <div class="panel-body collapse" id="group_<?php  echo $g_data['in_group_id']; ?>">
                                    <div class="table-responsive">
                                        <table id="group_report_<?php echo $g_data['in_group_id']; ?>" class="table  group_report">
                                            <thead>
                                                <tr>
                                                    <th class="td-width">Location ID</th>
                                                    <!--<th>Location Name</th>-->
                                                    <th>Location Address</th>
                                                    <th>Business Owner</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $location_data = $location->get_location_data_by( 'in_group_id', $g_data['in_group_id'] );
                                                    if( isset( $location_data ) && $location_data != "" || $location_data > 0 ){
                                                        if( isset( $location_data['in_location_id'] ) ){
                                                            $location_data = array( $location_data );
                                                        }
                                                        foreach( $location_data as $loc_k => $loc_v ){
                                                           $bo_name = $user->get_user_data_by_key( $loc_v['in_user_id'] , 'st_first_name' );
                                                            ?>
                                                            <tr class="group_loc_<?php echo $loc_v['in_location_id']; ?>">
                                                                <td class="td-width"><?php echo $loc_v['in_location_id']; ?></td>
<!--                                                                <td><?php // echo $loc_v['st_location_name']; ?></td>-->
                                                                <td class="cut_location_address"><?php echo $loc_v['st_address']; ?></td>
                                                                <td><?php echo $bo_name; ?></td>
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
                            <?php
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
                        
</div>

<div class="modal fade" id="create_loc_group" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title add-edit-group-title">Create Group</h4>
            </div>
            <div class="modal-body">
                <div class="page-content-wrap" style="margin-top:20px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissable location-success hide-el" style="display: none;">

                                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                <span class="location-msg"></span>

                            </div>

                            <div class="alert alert-danger alert-dismissable location-failed hide-el" style="display: none;">

                                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                                <span class="location-msg"></span>

                            </div>
                            <form id="frm_create_group" name="frm_create_group" method="post" role="form" class="form-horizontal" action="">                            
                                <div class="">
                                    <div class="form-group">
                                        <label class="col-md-3" for="txt_group_name">Group Name<span class="required-feild">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="txt_group_name" name="txt_group_name" placeholder="Group Name" />
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
<!--                                    <div class="form-group assign_driver" >
                                        <label class="col-md-3">Business owner:</label>
                                        <div class="col-md-9">
                                            <?php //$user_data = $user->search_user_by_type( 'business_owner', '' );?>
                                            <select class="select" id="select_bo" name="select_bo" >
                                                    <?php 
                                                    //if( isset( $user_data ) ){
                                                        ?>
                                                    <option value="0">---Select business owner name--</option> 
                                                    <?php
                                                        //foreach ( $user_data as $key => $value ) { ?>
                                                            <option  value="<?php //echo $value['in_user_id']; ?>"><?php //echo $value['st_first_name']; ?></option>
                                                    <?php //}
                                                    //}
                                                    ?>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <label class="col-md-3 st_location_name">Location Address<span class="required-feild">*</span></label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" id="txt_location_name"  name="txt_location_name" placeholder="Location Address" >
                                        </div>
                                    </div>
                                    <div>
                                        <table  class="table" id="select_loc_bo">
                                            <thead>
                                                <tr>
                                                    <th  class="id_width"></th>
                                                    <th>ID</th>
                                                    <!--<th>Location Name</th>-->
                                                    <th>Address</th>
                                                    <th>BO name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <table  class="table" id="selected_loc_bo">
                                            <thead>
                                                <tr>
                                                    <th  class="id_width"></th>
                                                    <th>ID</th>
                                                    <!--<th>Location Name</th>-->
                                                    <th>Address</th>
                                                    <th>BO name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="arr_location_id">
                                        <input type="hidden" name="arr_location_id" id="arr_location_id" />
                                        <input type="hidden" name="edit_group_id" id="edit_group_id" />
                                    </div>
                                </div>
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary loader" type="submit">Submit</button>
                                </div>                                                                
                            </form>
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
<?php
include_once FL_LOGIN_FOOTER;
?>
<script>
$( '.group_report' ).DataTable({
    "order": [[ 0, "desc" ]]
});
</script>