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
include_once FL_LOCATION;
$location = new location();
include_once FL_PICKUP;
$pickup = new pickup();
include_once FL_ACTIVITY;
$activity = new activity(); 

?>
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo ADMIN_CSS_PATH; ?>buttons.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo ADMIN_CSS_PATH; ?>jquery.dataTables.min.css"/>

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
                        <h3 class="panel-title">All Driver List</h3>
                    </div>
                    
                    <div class="admin-main-report-list">
                        
                        <div class="panel-body">
                            <div class="div-responsive">
                                <?php
                                global $mydb;
                                $drivers = $mydb->get_all( TBL_DRIVER, '*', "", "");
                                if( isset( $drivers ) && $drivers != '' || $drivers != 0 ){
                                    if( isset( $drivers['in_driver_id'] ) ){
                                        $drivers = array( $drivers );
                                    }
                                    foreach( $drivers as $key => $value ){
                                        $driver_name = $user->get_user_data_by_key( $value['in_user_id'], 'st_first_name' );
                                        $driver_pickup= $pickup->get_driver_pickup_amt_list( $value['in_user_id'] );
                                        $in_license_no= $user->get_driver_data_by_key( $value['in_user_id'], 'in_license_no' ); 
                                    ?>
                                    <div class="driver_<?php echo $value['in_driver_id']; ?>">
                                        <div class="bo-list clo_<?php echo $value['in_driver_id']; ?>">
                                            <div class="bo-box">
                                                <div class="bo-item">
                                                    <p>Driver Name:
                                                        <label><?php echo $driver_name;?></label>
                                                    </p>
                                                </div>
                                                <div class="bo-item">
                                                    <p>License ID:
                                                        <label>#<?php echo $in_license_no; ?></label>
                                                    </p>
                                                </div>
                                                <button class="btn btn-success view_driver_detail action" data-user_id="<?php echo $value['in_user_id']; ?>" data-driver_id="<?php echo $value['in_driver_id']; ?>" name="view_driver_detail">View</button>
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

    $(document).ready(function() {
        
        $('#driver_list_report').DataTable( {
            // initComplete: function () {
            //     this.api().columns().every( function () {
            //         var column = this;
            //         var select = $('<select><option value=""></option></select>')
            //             .on( 'change', function () {
            //                 var val = $.fn.dataTable.util.escapeRegex(
            //                     $(this).val()
            //                 );
    
            //                 column
            //                     .search( val ? '^'+val+'$' : '', true, false )
            //                     .draw();
            //             } );

            //             if( jQuery( column.header() ).hasClass( "brigloo_data_filter" ) ){
            //                 jQuery( column.header() ).append( select );
            //             }
    
            //         column.data().unique().sort().each( function ( d, j ) {
            //             select.append( '<option value="'+d+'">'+d+'</option>' )
            //         });
            //     });
            // },
            // "deferRender": true,
            // "columnDefs": [ 
            //     { targets: 'action', orderable: false },
            //     { targets: 'action', searchable: false }
            // ]
        });

    });
    
</script>