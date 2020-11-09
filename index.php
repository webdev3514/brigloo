<?php
session_start();
require_once 'config/config.php';
require_once 'backend/config/admin_config.php';
if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "business_owner"  ){	
    header( "location:" . VW_BO_HOME );
}else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "store_manager"  ){	
    header( "location:" . VW_SM_HOME );
}else if( isset( $_SESSION['user_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "driver"  ){	
    header( "location:" . VW_DRIVER_HOME );
}else if( isset( $_SESSION['admin_id'] ) && isset( $_SESSION['user_type'] ) &&  $_SESSION['user_type'] == "admin"  ){	
    header( "location:" . BACKEND_DIR );
}else{
    
}
include_once FL_USER_HEADER;
?>

        <div id="wrapper">
            <!--banner section-->
            <section class="banner-section">
                <div class="container">
                    <div class="banner-box">
                        <div class="banner-item">
                            <div class="banner-caption">
                                <h1>
                                        Redefining<br>
                                        Cash-<span class="caption-in">in</span>-Transit.
                                </h1>
                            </div>
                        </div>
                    </div>
                    <a id="hulk" href="#" class="top-bottom">
                        <img src="<?php echo IMAGES_URL; ?>flash-car.png" alt="logo">
                        <div class="dotted-wrap">
                            <span class="dotted"></span>
                            <span class="dotted"></span>
                            <span class="dotted"></span>
                            <span class="dotted"></span>
                        </div>
                    </a>
                </div>
            </section>
            <!--banner section-->

            <!--what-brigloo-->
            <section id="what-brigloo" class="what-brigloo">
                <div class="container">
                    <div class="wb-item kd-row">
                        <div class="wb-left kd-7">
                            <h1 class="title">
                                WHAT IS <strong>Cop Express ?</strong>
                                <div class="dotted-wrap">
                                        <span class="dotted"></span>
                                        <span class="dotted"></span>
                                </div>
                            </h1>
                            <p>
                                At Cop Express we help facilitate safe, flexible and affordable transportation of valuables. Our innovative approach to current nature of the business provides us with a rare opportunity to bring custom tailored transportation services that will adapt to and stay flexible with your cash flow and safe transportation needs.
                            </p>	
                        </div>
                        <div class="wb-right kd-5">
                            <img src="<?php echo IMAGES_URL; ?>first_vecto_what_is_brigloo.png" align="first_vecto_what_is_brigloo">
                        </div>
                    </div>
                    <div class="wb-item kd-row">
                        <div class="wb-left kd-7">
                            <h1 class="title">
                                <strong>WHY CHOOSE </strong> US ?
                                <div class="dotted-wrap">
                                    <span class="dotted"></span>
                                    <span class="dotted"></span>
                                </div>
                            </h1>
                            <p class="kd-right">
                                    We believe adapting and staying flexible with the community we serve is crucial to building long term trust and establishing strong relationships that will mutually benefit everyone involved. We might not have a legacy that spans decades but it doesn’t take a rocket surgeon to figure out that exceptional quality service at affordable prices is always in demand. Did we mention that Cop Express transportation providers are fully insured and the valuables are bonded as well? We don’t sacrifice security and peace of mind for sake of cutting costs.
                            </p>	
                        </div>
                        <div class="wb-right kd-5">
                            <img src="<?php echo IMAGES_URL; ?>why_chose_us_vector.png" align="why_chose_us_vector">
                        </div>
                    </div>		
                </div>
            </section>
            <!--what-brigloo-->

            <!-- Cop Express Effect -->
            <section id="brigloo-effect" class="brigloo-effect">
                <div class="container">
                        <h1 class="sub-title">Cop Express <a class="bottom-top top-bottom-car" id="myBtn" style="display: block;">
                                <img src="<?php echo IMAGES_URL; ?>flash-car.png" alt="logo">
                                <!--<div class="dotted-wrap">-->
                                <!--                                <span class="dotted"></span>-->
                                <!--                                <span class="dotted"></span>-->
                                <!--                                <span class="dotted"></span>-->
                                <!--                                <span class="dotted"></span>-->
                                <!--</div>-->
                </a>
                <span>EFFECT</span>
                </h1>
                    <ul class="ul-effect">
                        <li class="bg-price">
                            <span class="shadow"></span>
                            <h3>PRICING</h3>
                            <p>
                                    With Cop Express, it’s finally possible to receive affordable transportation services without sacrificing quality, privacy, flexibility and security.
                            </p>
                        </li>
                        <li class="black_li"></li>
                        <li class="bg-security">
                            <span class="shadow"></span>
                            <h3>SECURITY</h3>
                            <p>
                                    Highly trained and armed local law enforcement personnel with unlimited back-up support are capable of providing superior safety to your valuables, better than what the industry currently has to offer.
                            </p>
                        </li>
                        <li class="bg-min-risk">
                            <span class="shadow"></span>
                            <h3>MINIMIZED RISK</h3>
                            <p>
                                    We’re shaking things up a bit. Instead of bundling your valuables with too many other valuables, compounding the risk, we distribute the load among multiple transportations while delivering the low pricing structure we promise.
                            </p>
                        </li>
                        <li class="bg-flex">
                            <span class="shadow"></span>
                            <h3>FLEXIBILITY</h3>
                            <p>
                                    You have the power to apply and tailor our services to the nature of your business. Being able to choose routes, days and frequency of your transportation needs are only a few clicks away.
                            </p>
                        </li>
                        <li class="bg-profile">
                            <span class="shadow"></span>
                            <h3>LOW PROFILE</h3>
                            <p>
                                    Along with professionally trained and armed law enforcement personnel, comes the 'blend-in' factor of law enforcement vehicles patrolling the streets. Hijacking a visible cargo is possible with proper tools. Guessing where the cargo might be – that’s a different story.
                            </p>
                        </li>
                        <li class="black_li"></li>
                        <li class="bg-contracts">
                            <span class="shadow"></span>
                            <h3>NO CONTRACTS</h3>
                            <p>
                                    Instead of holding business partners ‘hostage’ with contracts, we believe in giving you the option to decide if Cop Express is worth doing business with. We’re confident we can keep you as our business partner by providing superior service, unbound by signed agreements.
                            </p>
                        </li>

                    </ul>
                </div>
            </section>		
            <!-- Cop Express Effect -->

            
        </div>

        <div class="page-loader">
            <div class="loader-wrapper">
                <a href="#" class="header-logo">
                    <img src="<?php echo IMAGES_URL; ?>gaadi.png" align="loader">
                </a>
            </div>
        </div>
    <?PHP 
        include_once FL_USER_FOOTER_INCLUDE;
        ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>custom1.js"></script>
        <?php
        include_once FL_USER_FOOTER;
    ?>
