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
    
?>
<!-- PAGE CONTENT -->
<div class="page-content">

    <!-- START X-NAVIGATION VERTICAL -->
    <?php  include_once FL_LOGIN_SUB_HEADER;?> 
    <!-- END X-NAVIGATION VERTICAL -->    


    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <!-- START WIDGETS -->                    
        <div class="row">
            <div class="col-md-12">
                    <!-- START DATATABLE EXPORT -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">User List</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="user_list" class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th class="id_column">Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email Id</th>
                                            <th>User Role</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        global $mydb;
                                        $all_userdata = $user->get_admin_user_list();
                                        if( isset( $all_userdata ) ){
                                            if( isset( $all_userdata['in_user_id'] ) ){
                                                $all_userdata = array( $all_userdata );
                                            }
                                            foreach( $all_userdata as $key => $value ){
                                                $user_signup_attempt = $user->get_user_meta( $value['in_user_id'], 'user_signup_attempt', TRUE ); 
                                                $admin_user_reject_attempt = $user->get_user_meta( $value['in_user_id'], 'admin_user_reject_attempt', TRUE ); 
                                            ?>
                                            <tr class="user_<?php echo $value['in_user_id']; ?>">
                                                <td class="rep_<?php echo $value['in_user_id']; ?>">
                                                    <?php
                                                    if ( $value['in_is_approve'] == "" || $value['in_is_approve'] == '0' ){
                                                    ?>
                                                    <div class="button-wrap">
                                                        <a href="#" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-success user_approve" title="Approve"><i class="fa fa-check"></i></a>
                                                        <a href="" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-danger user_reject" title="Reject"><i class="fa fa-times"></i></a>                                      
                                                        <a href="" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-danger vw_user_info" title="View Details"><i class="fa fa-eye"></i></a>                                    
                                                    </div>
                                                    <?php        
                                                    } else if( $value['in_is_approve'] == 1 ){
                                                        ?>
                                                        <div class="button-wrap">
                                                            <?php
                                                            echo '<button type="button" class="btn btn-success" title="Approved"><i class="fa fa-check"></i></button>';     
                                                            ?>
                                                            <a href="" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-danger user_delete" title="Delete"><i class="fa fa-trash-o"></i></a>
                                                            <?php if( $value['in_is_active'] == -2 ){ ?>
                                                            <a href="" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-danger user_enable" title="Enable"><i class="fa fa-thumbs-o-up"></i></a>
                                                            <?php } else{ ?>
                                                            <a href="" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-danger user_disable" title="Disable"><i class="fa fa-thumbs-o-down"></i></a>
                                                            <?php } ?>
                                                            <a href="" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-danger vw_user_info" title="View Details"><i class="fa fa-eye"></i></a> 
                                                            
                                                        </div>
                                                        <?php
                                                    } else if ( $value['in_is_approve'] == '-2' ){
                                                        if ( $admin_user_reject_attempt != $user_signup_attempt ){
                                                        ?>
                                                        <div class="button-wrap">
                                                            <a href="#" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-success user_approve" title="Approve"><i class="fa fa-check"></i></a>
                                                            <a href="" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-danger user_reject" title="Reject"><i class="fa fa-times"></i></a>  
                                                            <a href="" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-danger vw_user_info" title="View Details"><i class="fa fa-eye"></i></a>                                    
                                                        </div>
                                                        <?php
                                                        }else{
                                                            ?>
                                                            <div class="button-wrap">
                                                            <?php
                                                                echo '<button type="button" class="btn btn-danger"><i class="fa fa-times" title="Rejected"></i></button>';
                                                            ?>
                                                                <a href="" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-danger vw_user_info" title="View Details"><i class="fa fa-eye"></i></a> 
                                                                
                                                            </div>
                                                            <?php
                                                        }
                                                    } else if ( $value['in_is_approve'] == '-1' ){
                                                        if ( $admin_user_reject_attempt != $user_signup_attempt ){
                                                    ?>
                                                    <div class="button-wrap">
                                                        <a href="#" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-success user_approve" title="Approve"><i class="fa fa-check"></i></a>
                                                        <a href="" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-danger user_reject" title="Reject"><i class="fa fa-times"></i></a> 
                                                        <a href="" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-danger vw_user_info" title="View Details"><i class="fa fa-eye"></i></a>                                           
                                                    </div>
                                                    <?php
                                                        }else{
                                                            ?>
                                                            <div class="button-wrap">
                                                            <?php
                                                                echo '<button type="button" class="btn btn-danger"><i class="fa fa-times" title="Rejected"></i></button>';
                                                            ?>
                                                                <a href="" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-danger vw_user_info" title="View Details"><i class="fa fa-eye"></i></a>                        
                                                            </div>
                                                            <?php
                                                        }
                                                    } else if ( $value['in_is_approve'] == '-3' ){
                                                        ?>
                                                        <div class="button-wrap">
                                                        <?php
                                                            echo '<button type="button" class="btn btn-danger"><i class="fa fa-times" title="Rejected"></i></button>';
                                                        ?>
                                                            <a href="" data-id="<?php echo $value['in_user_id']; ?>" class="btn btn-danger vw_user_info" title="View Details"><i class="fa fa-eye"></i></a>                        
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="id_column"><?php echo $value['in_user_id'];?></td>
                                                <td><?php echo $value['st_first_name'];?></td>
                                                <td><?php echo $value['st_last_name'];?></td>
                                                <td><?php echo $value['st_email_id'];?></td>
                                                <td><?php echo isset( $value['st_user_type'] ) && $value['st_user_type'] == "driver"  ? "Driver" : "Business Owner";?></td>
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

                    <!-- END DATATABLE EXPORT --> 
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="user_view_detail" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">View Details</h4>
            </div>
            <div class="modal-body">
                <div class="page-content-wrap" style="margin-top:20px;">
                    <div class="row">
                        <div class="col-md-12 user_data_add">
                            
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
$( '#user_list' ).DataTable({
    "order": [[ 1, "desc" ]]
});
</script>