<!--<!DOCTYPE html>-->
<html>
    <head>
        <?php require_once FL_USER_HEADER_INCLUDE; ?>
        <title><?php echo isset( $page_title ) ? $page_title : 'Cop Express'; ?></title>
        <meta charset="UTF-8" />
        <meta name="HandheldFriendly" content="true">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link type="image/x-icon" rel="shortcut icon" href="<?php echo IMAGES_URL; ?>brigloo.ico" />

    </head>
    <body class="show-body">
        <div id="wrapper"><!--header start -->
            <header id="header" class="header">
                <div class="top-header">
                    <div class="container">
                        <a class="call" href="tel:+260-710-2005 ">+260-710-2005</a>
                        <ul class="social-header"> 
                            <li><a href="https://www.facebook.com/" target='_blank'><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="https://plus.google.com/discover" target='_blank'><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                            <li><a href="https://www.linkedin.com" target='_blank'><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href="https://twitter.com" target='_blank'><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="bottom-header">
                    <div class="container">
                        <a href="<?php echo BASE_URL; ?>" class="logo">
                            <img src="<?php echo IMAGES_URL; ?>/logo-new.png" alt="logo">
                        </a>
                        <div class="menu-login-seach">
                            <ul class="menu-header"> 
                                <li <?php  if(basename(trim($_SERVER['PHP_SELF'])) == 'index.php'){ ?> class="active" <?php } ?>><a href="<?php echo BASE_URL; ?>">Home</a></li>
                                <li <?php  if(basename(trim($_SERVER['PHP_SELF'])) == 'driver_registration.php'){ ?> class="active" <?php } ?>><a href="<?php echo VW_DRIVER_REGISTRATION; ?>">Driver Sign Up</a></li>
                                <li <?php  if(basename(trim($_SERVER['PHP_SELF'])) == 'bo_registration.php'){ ?> class="active" <?php } ?>><a href="<?php echo VW_BO_REGISTRATION; ?>">Business Sign Up</a></li>
                            </ul>
                            <a class="login <?php  if(basename(trim($_SERVER['PHP_SELF'])) == 'login.php'){ ?> active <?php } ?>" href="<?php echo VW_LOGIN; ?>">Log in</a>
                        </div>
                        <div id="nav-icon2" class="toggle-menu">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>		
            </header>
            <!--header over -->
<!--            <header class="header-section">
                <div class="container">
                    <div class="header-logo">
                        <a href="<?php echo BASE_URL; ?>">Cop Express</a>
                    </div>
                    <?php 
//                        if ( !session_id() ) {
//                            session_start();
//                        }
//                        if( !isset( $_SESSION['user_id'] ) ){
                    ?>
                        <div class="header-menu">
                            <ul class="ul-menu">

                                <li <?php //  if(basename(trim($_SERVER['PHP_SELF'])) == 'login.php'){ ?> class="active" <?php // } ?>><a href="<?php // echo VW_LOGIN; ?>">Login</a></li>
                                <li <?php //  if(basename(trim($_SERVER['PHP_SELF'])) == 'driver_registration.php'){ ?> class="active" <?php // } ?>><a href="<?php // echo VW_DRIVER_REGISTRATION; ?>">Driver Signup</a></li>
                                <li <?php //  if(basename(trim($_SERVER['PHP_SELF'])) == 'bo_registration.php'){ ?> class="active" <?php // } ?>><a href="<?php // echo VW_BO_REGISTRATION; ?>">Business Owner Signup</a></li>
                            </ul>
                        </div>
                        <?php // } ?>
                    <div id="nav-icon2" class="toggle-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </header>-->
            
                
        
