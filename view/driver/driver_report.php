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
                            <div class="table-responsive">
                                    
                                <table id="driver_list_report" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Diver Name</th>
                                            <th>Number Of Routes Completed</th>
                                            <th>Date Range</th>
                                            <th>Total Time Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr>
                                            <th class="brigloo_data_filter"></th>
                                            <th class="brigloo_data_filter"></th>
                                            <th class="brigloo_data_filter"></th>
                                            <th class="brigloo_data_filter"></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                            <tr class="job_<?php echo $value['in_job_id']; ?>">
                                                <td><?php echo $driver_name;?></td>
                                                <td><?php echo $value['location_count'];?></td>
                                                <td class="pickup_date_range"><?php echo date( "m-d-Y", strtotime( $value['dt_pickup'] ) );?></td>
                                                <td class="pickup_amount"><?php echo isset( $value['fl_driver_pickup_amt'] ) && $value['fl_driver_pickup_amt'] > 0 ?  " $" . $value['fl_driver_pickup_amt'] : 0; ?></td>
                                                <td><button class="btn btn-success view_driver_detail action" data-user_id="<?php echo $value['in_user_id']; ?>" data-driver_id="<?php echo $value['in_driver_id']; ?>" name="view_driver_detail" onclick="routeDetails('<?php echo $value['in_driver_id']; ?>')">View</button></td>
                                            </tr>

                                                <table id="driver_route_"<?php echo $value['in_driver_id']; ?> class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Position</th>
                                                            <th>Office</th>
                                                            <th>Age</th>
                                                            <th>Start date</th>
                                                            <th>Salary</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Tiger Nixon</td>
                                                            <td>System Architect</td>
                                                            <td>Edinburgh</td>
                                                            <td>61</td>
                                                            <td>2011/04/25</td>
                                                            <td>$320,800</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Garrett Winters</td>
                                                            <td>Accountant</td>
                                                            <td>Tokyo</td>
                                                            <td>63</td>
                                                            <td>2011/07/25</td>
                                                            <td>$170,750</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ashton Cox</td>
                                                            <td>Junior Technical Author</td>
                                                            <td>San Francisco</td>
                                                            <td>66</td>
                                                            <td>2009/01/12</td>
                                                            <td>$86,000</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Cedric Kelly</td>
                                                            <td>Senior Javascript Developer</td>
                                                            <td>Edinburgh</td>
                                                            <td>22</td>
                                                            <td>2012/03/29</td>
                                                            <td>$433,060</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Airi Satou</td>
                                                            <td>Accountant</td>
                                                            <td>Tokyo</td>
                                                            <td>33</td>
                                                            <td>2008/11/28</td>
                                                            <td>$162,700</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Brielle Williamson</td>
                                                            <td>Integration Specialist</td>
                                                            <td>New York</td>
                                                            <td>61</td>
                                                            <td>2012/12/02</td>
                                                            <td>$372,000</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Herrod Chandler</td>
                                                            <td>Sales Assistant</td>
                                                            <td>San Francisco</td>
                                                            <td>59</td>
                                                            <td>2012/08/06</td>
                                                            <td>$137,500</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Rhona Davidson</td>
                                                            <td>Integration Specialist</td>
                                                            <td>Tokyo</td>
                                                            <td>55</td>
                                                            <td>2010/10/14</td>
                                                            <td>$327,900</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Lael Greer</td>
                                                            <td>Systems Administrator</td>
                                                            <td>London</td>
                                                            <td>21</td>
                                                            <td>2009/02/27</td>
                                                            <td>$103,500</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jonas Alexander</td>
                                                            <td>Developer</td>
                                                            <td>San Francisco</td>
                                                            <td>30</td>
                                                            <td>2010/07/14</td>
                                                            <td>$86,500</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Shad Decker</td>
                                                            <td>Regional Director</td>
                                                            <td>Edinburgh</td>
                                                            <td>51</td>
                                                            <td>2008/11/13</td>
                                                            <td>$183,000</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Michael Bruce</td>
                                                            <td>Javascript Developer</td>
                                                            <td>Singapore</td>
                                                            <td>29</td>
                                                            <td>2011/06/27</td>
                                                            <td>$183,000</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Donna Snider</td>
                                                            <td>Customer Support</td>
                                                            <td>New York</td>
                                                            <td>27</td>
                                                            <td>2011/01/25</td>
                                                            <td>$112,000</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Position</th>
                                                            <th>Office</th>
                                                            <th>Age</th>
                                                            <th>Start date</th>
                                                            <th>Salary</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Diver Name</th>
                                            <th>Number Of Routes Completed</th>
                                            <th>Date Range</th>
                                            <th>Total Time Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>

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
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
    
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                        if( jQuery( column.header() ).hasClass( "brigloo_data_filter" ) ){
                            jQuery( column.header() ).append( select );
                        }
    
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    });
                });
            },
            "deferRender": true,
            "columnDefs": [ 
                { targets: 'action', orderable: false },
                { targets: 'action', searchable: false }
            ]
        });

        // $(document).on("click",".view_driver_detail",function() {
        //     alert("hiii");
        //     $('#driver_route_'+driver_id).DataTable( {
        //         "order": [[ 3, "desc" ]]
        //     } );
        // });

        function routeDetails( driver_id="" ){
            alert("hiii");
            $('#driver_route_'+driver_id).DataTable( {
                "order": [[ 3, "desc" ]]
            } );
        }

    });
    
</script>