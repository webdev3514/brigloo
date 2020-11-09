
            <!--footer -->
            <footer id="footer" class="section-gapping">
                <div class="container">
                    <a href="#" class="footer-logo">
                            <img src="<?php echo IMAGES_URL; ?>footer_logo-new.png" alt="footer-logo">
                    </a>
                    
                    <div class="quick-menu">
                        <h2>Quick Links</h2>
                        <ul class="ul-footer">
                            <li <?php  if(basename(trim($_SERVER['PHP_SELF'])) == 'index.php'){ ?> class="active" <?php } ?>><a href="<?php echo BASE_URL; ?>">Home</a></li>
                            <li  <?php  if(basename(trim($_SERVER['PHP_SELF'])) == 'index.php'){ ?> class="active" <?php } ?>><a href="<?php echo BASE_URL; ?>#what-brigloo" class="about-link">About us</a></li>
                            <li <?php  if(basename(trim($_SERVER['PHP_SELF'])) == 'driver_registration.php'){ ?> class="active" <?php } ?>><a href="<?php echo VW_DRIVER_REGISTRATION; ?>">Driver</a></li>
                            <li <?php  if(basename(trim($_SERVER['PHP_SELF'])) == 'contact.php'){ ?> class="active" <?php } ?>><a href="<?php echo VW_CONTACT; ?>">Contact</a></li>
                            
                            
                        </ul>
                    </div>
                </div>
                <div class="copyright-section">
                    <div class="container">
                     <p class="copyright">
                         © 2019 <a href="<?php echo BASE_URL; ?>">Cop Express. </a>All Rights Reserved.</p>
                     </div>
                 </div>
            </footer>
            <!--footer -->
        </div>
    </body>
</html>