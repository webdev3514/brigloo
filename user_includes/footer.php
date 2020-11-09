
        </div>
        <!-- END PAGE CONTAINER -->
       <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>  
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="<?php echo VW_LOGOUT; ?>" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

    <?php if( !isset($load_js) ) { ?>
        <script type="text/javascript" src="<?php echo ADMIN_JS_PATH; ?>plugins.js"></script>
        <script type="text/javascript" src="<?php echo ADMIN_JS_PATH; ?>actions.js"></script>
    <?php } ?>
    
    <script>
    </script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
    </body>
</html>
