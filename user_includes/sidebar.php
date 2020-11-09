<!-- START PAGE SIDEBAR -->
<div class="page-sidebar">
<?php 
    include_once FL_PICKUP;
    $pickup = new pickup();
    include_once FL_LOCATION;
$location = new location();
    include_once FL_USER;
    $user = new user();
    global $mydb;
    $id = isset( $_SESSION['user_id'] ) &&  $_SESSION['user_id'] != '' ?  $_SESSION['user_id'] : '';
    $where = array(
        'in_user_id' => $id
    );
    $all_userdata = $mydb->get_all( TBL_USER, '*', $where );
?>
    <!-- START X-NAVIGATION -->
    <ul class="x-navigation brigloo-menu">
        <li class="xn-logo">
            <?php 
                if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "business_owner"  ){	
                    ?>
                        <a href="<?php echo VW_BO_HOME; ?>">Cop Express</a>
                    <?php
                } else if( isset( $_SESSION['admin_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "admin"  ){	
                    ?>
                        <a href="<?php echo VW_ADMIN_HOME; ?>">Cop Express</a>
                    <?php
                } else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "driver"  ){	
                    ?>
                        <a href="<?php echo VW_DRIVER_HOME; ?>">Cop Express</a>
                    <?php
                } else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "store_manager"  ){	
                    ?>
                        <a href="<?php echo VW_SM_HOME; ?>">Cop Express</a>
                    <?php
                }
            ?>
            
            <a href="#" class="x-navigation-control"></a>
        </li>                                                                      
        <li class="xn-title">Navigation</li>
        <?php 
        
            if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "business_owner"  ) {
                if( isset( $all_userdata['in_is_approve'] ) && $all_userdata['in_is_approve'] == 1 ){
                ?>
                    <li>
                        <a href="<?php echo VW_BO_HOME; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'home.php'){ echo 'login-active'; }?>"><span class="fa fa-desktop"></span><span class="xn-text">Home</span></a>
                    </li>                                        
                    <li>
                        <a href="<?php echo VW_BO_MYACCOUNT; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'my_account.php'){ echo 'login-active'; }?>"><span class="fa fa-user"></span><span class="xn-text">My Account</span></a>
                    </li>
                    <li>
                        <a href="<?php echo VW_MY_LOCATIONS; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'my_location.php'){ echo 'login-active'; }?>"><span class="fa fa-map-marker"></span><span class="xn-text">My Locations</span></a>
                    </li>
                    <li>
                        <a href="<?php echo VW_NEW_PICKUP; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'new_pickup.php'){ echo 'login-active'; }?>"><span class="fa fa-location-arrow"></span><span class="xn-text">Add Pick Up</span></a>
                    </li>
                    
                    <?php 
                    $pickup_count = 0;
                    $manager_ids = $location->get_location_data_by( 'in_user_id' , $id );
                    $arr_managerids = array();
                    if( isset( $manager_ids ) && $manager_ids > 0  ){
                        if( isset( $manager_ids['in_manager_id'] ) ){
                            $manager_ids = array( $manager_ids );
                        }
                        foreach( $manager_ids as $mk => $mv ){
                            array_push( $arr_managerids , $mv['in_manager_id'] );
                        }
                        $arr_manager_id = array_unique( $arr_managerids );
                        if( isset( $arr_manager_id ) && is_array( $arr_manager_id )){
                            $pickup_count = $pickup->get_pickups_pending_for_approve( $arr_manager_id ); 
                        }
                    }
                    
                    
                    
                    ?>
                    <li>
                        <a href="<?php echo VW_CHANGE_ORDERS; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'change_orders.php'){ echo 'login-active'; }?>"><span class="fa fa-rotate-left"></span><span class="xn-text">Change Orders ( <?php echo $pickup_count; ?> )</span></a>
                    </li>
                    <li>
                        <a href="<?php echo VW_RECURRING_LIST; ?>"  class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'recurring_list.php'){ echo 'login-active'; }?>"><span class="fa fa-retweet"></span><span class="xn-text">Recurring List</span></a>
                    </li>
                    <li>
                        <a href="<?php echo VW_SM_REGISTRATION; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'sm_registration.php'){ echo 'login-active'; }?>"><span class="fa fa-users"></span><span class="xn-text">Store Manager</span></a>
                    </li>
                    <!--<li>-->
                    <!--    <a href="<?php //echo VW_INTERRUPT_JOB; ?>"  class="<?php //if (basename( $_SERVER["PHP_SELF"]) == 'interrupt_jobs.php'){ echo 'login-active'; }?>"><span class="fa fa-dot-circle-o"></span><span class="xn-text">Modified Trips</span></a>-->
                    <!--</li>-->
                    
                    
                    <li>
                        <a href="<?php echo VW_BO_REPORT; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'bo_report.php'){ echo 'login-active'; }?>"><span class="fa fa-file"></span><span class="xn-text">Reports</span></a>
                    </li>
                <?php
                }else{
                    ?>
                    <li>
                        <a href="<?php echo VW_BO_HOME; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'home.php'){ echo 'login-active'; }?>"><span class="fa fa-desktop"></span><span class="xn-text">DASHBOARD</span></a>
                    </li>
                    <?php
                }
            } else if( isset( $_SESSION['admin_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "admin"  ){	
                ?>
                    <li>
                        
                        <a href="<?php echo VW_ADMIN_HOME; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'home.php'){ echo 'login-active'; }?>"><span class="fa fa-desktop"></span><span class="xn-text">Dashboard</span></a>
                    </li>                                        
                    <li>
                        <a href="<?php echo VW_ADMIN_USER_LIST; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'user_list.php'){ echo 'login-active'; }?>"><span class="fa fa-user"></span><span class="xn-text">User List</span></a>
                    </li>
                    <li>
                        <a href="<?php echo VW_ADMIN_GROUP_LIST; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'group_list.php'){ echo 'login-active'; }?>"><span class="fa fa-users"></span><span class="xn-text">Group List</span></a>
                    </li>
                    <?php 
                    $all_userdata = $pickup->get_admin_unassign_pickups( 'all' );
                    if( isset( $all_userdata ) && $all_userdata != '' ){
                        $count_unassign_pickup = count( $all_userdata );
                    }else{
                        $count_unassign_pickup = 0;
                    }
                    ?>
                    <li>
                        <a href="<?php echo VW_ADMIN_PICK_LIST; ?>"  class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'pickup_list.php'){ echo 'login-active'; }?>"><span class="fa fa-location-arrow"></span><span class="xn-text">Pick Up List ( <?php echo $count_unassign_pickup; ?> )</span></a>
                    </li>
                    <li>
                        <a href="<?php echo VW_ADMIN_DRIVER_PICKUP_AMT; ?>"  class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'driver_pickup_amt.php'){ echo 'login-active'; }?>"><span class="fa fa-dollar"></span><span class="xn-text">Driver Pick Up Amount</span></a>
                    </li>
                    <li>
                        <a href="<?php echo VW_ADMIN_GENERAL_SETTING; ?>"  class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'general_setting.php'){ echo 'login-active'; }?>"><span class="fa fa-cog"></span><span class="xn-text">Settings</span></a>
                    </li>
                    <!--<li>-->
                    <!--    <a href="<?php //echo VW_ADMIN_INTERRUPT_JOB; ?>"  class="<?php //if (basename( $_SERVER["PHP_SELF"]) == 'interrupt_jobs.php'){ echo 'login-active'; }?>"><span class="fa fa-dot-circle-o"></span><span class="xn-text">Modified Trips</span></a>-->
                    <!--</li>-->
                    <li>
                        <a href="<?php echo VW_ADMIN_REPORT; ?>"  class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'admin_report.php'){ echo 'login-active'; }?>"><span class="fa fa-file"></span><span class="xn-text">Reports</span></a>
                    </li>
                    <li>
                        <a href="<?php echo VW_ADMIN_ACTIVITY_LOG ; ?>"  class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'activity_logs.php'){ echo 'login-active'; }?>"><span class="fa fa-list-alt"></span><span class="xn-text">Activity log</span></a>
                    </li>
                <?php
            } else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "driver"  ){	
                if( isset( $all_userdata['in_is_approve'] ) && $all_userdata['in_is_approve'] == 1 ){
                ?>
                    <li>
                        <a href="<?php echo VW_DRIVER_HOME; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'home.php'){ echo 'login-active'; }?>"><span class="fa fa-desktop"></span><span class="xn-text">Home</span></a>
                    </li>                                        
                    <li>
                        <a href="<?php echo VW_DRIVER_MYACCOUNT; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'my_account.php'){ echo 'login-active'; }?>"><span class="fa fa-user"></span><span class="xn-text">My Account</span></a>
                    </li>
                    <?php
                        $driver_job = $pickup->get_pending_driver_jobs();
                        if( isset( $driver_job ) && $driver_job != '' ){
                            $driver_available_jobs_count = count( $driver_job ) ;
                        }else{
                            $driver_available_jobs_count = 0;
                        }
                        
                    ?>
                    <li>
                        <a href="<?php echo VW_DRIVER_PENDINGJOBS; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'pending_jobs.php'){ echo 'login-active'; }?>"><span class="fa fa-bell"></span><span class="xn-text">Available Jobs ( <?php echo $driver_available_jobs_count; ?> )</span></a>
                    </li>
                    <?php
                        $driver_job = $pickup->get_driver_jobs( $_SESSION['user_id'] );
                        if( isset( $driver_job ) && $driver_job != '' ){
                            $driver_my_jobs_count = count( $driver_job ) ;
                        }else{
                            $driver_my_jobs_count = 0;
                        }
                    ?>
                    <li>
                        <a href="<?php echo VW_DRIVER_MYJOBS; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'my_jobs.php'){ echo 'login-active'; }?>"><span class="fa fa-truck"></span><span class="xn-text">My Jobs ( <?php echo $driver_my_jobs_count; ?> )</span></a>
                    </li>
                    <li>
                        <a href="<?php echo VW_DRIVER_PICKUP_AMOUNT; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'driver_pickup_amt.php'){ echo 'login-active'; }?>"><span class="fa fa-dollar"></span><span class="xn-text">Driver Pick Up Amount</span></a>
                    </li>
                    
                   
                    <li>
                        <a href="<?php echo VW_DRIVER_REPORT; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'driver_report.php'){ echo 'login-active'; }?>"><span class="fa fa-file"></span><span class="xn-text">Reports</span></a>
                    </li>
                <?php
                }else{
                    ?>
                    <li>
                        <a href="<?php echo VW_DRIVER_HOME; ?>" class="<?php if (basename( $_SERVER["PHP_SELF"]) == 'home.php'){ echo 'login-active'; }?>"><span class="fa fa-desktop"></span><span class="xn-text">DASHBOARD</span></a>
                    </li>
                    <?php
                }
            }else if ( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "store_manager" ) {
                ?>
                    <li>
                        <a href="<?php echo VW_SM_HOME; ?>" class="<?php if ( basename( $_SERVER["PHP_SELF"]) == 'home.php'){ echo 'login-active'; }?>"><span class="fa fa-desktop"></span><span class="xn-text">Home</span></a>
                    </li>                                        
                    <li>
                        <a href="<?php echo VW_ADD_CHANGE_ORDER; ?>" class="<?php if ( basename( $_SERVER["PHP_SELF"]) == 'add_change_orders.php'){ echo 'login-active'; }?>"><span class="fa fa-rotate-left"></span><span class="xn-text">Change Orders</span></a>
                    </li>                                        
                <?php 
                
            }
        ?>
                                                
    </ul>
    <!-- END X-NAVIGATION -->
</div>
<!-- END PAGE SIDEBAR -->