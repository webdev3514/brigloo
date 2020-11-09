
<!-- START PRELOADS -->
<audio id="audio-alert" src="<?php echo ADMIN_URL; ?>audio/alert.mp3" preload="auto"></audio>
<audio id="audio-fail" src="<?php echo ADMIN_URL; ?>audio/fail.mp3" preload="auto"></audio>
<!-- END PRELOADS -->                 

<!-- START SCRIPTS -->
<!-- START PLUGINS -->
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH; ?>jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH; ?>jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH; ?>bootstrap/bootstrap.min.js"></script>
<script src="<?php echo ADMIN_JS_PLUGINS_PATH; ?>jQuery-autocomplete-multiselect/src/jquery.autocomplete.multiselect.js"></script>   
<script type='text/javascript' src="<?php echo ADMIN_JS_PLUGINS_PATH .'validationengine/languages/jquery.validationEngine-en.js'; ?>"></script>
<script type='text/javascript' src="<?php echo ADMIN_JS_PLUGINS_PATH .'validationengine/jquery.validationEngine.js'; ?>"></script>  
<script type='text/javascript' src="<?php echo ADMIN_JS_PLUGINS_PATH .'bootstrap/bootstrap-select.js' ; ?>"></script>
<script type='text/javascript' src="<?php echo ADMIN_JS_PLUGINS_PATH .'bootstrap/bootstrap-datepicker.js'; ?>"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>sweetalert-dev.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>sweetalert.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>common.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>user.js"></script>
<?php 
$request_url = isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] != 'off' ? 'https' . '://' .  $_SERVER[ 'HTTP_HOST' ] : 'http' . '://' . $_SERVER[ 'HTTP_HOST' ];
$querystring_url = explode ( '?', $request_url . $_SERVER['REQUEST_URI'] );
if( $request_url . $_SERVER['REQUEST_URI'] == VW_ADMIN_PICK_LIST ){
?>
<script type='text/javascript' src="<?php echo ADMIN_JS_PLUGINS_PATH .'icheck/icheck.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'mcustomscrollbar/jquery.mCustomScrollbar.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_PLUGINS_PATH .'datatables/jquery.dataTables.min.js'; ?>"></script>  
<script type='text/javascript' src="<?php echo ADMIN_JS_PLUGINS_PATH .'bootstrap/bootstrap-select.js' ; ?>"></script><script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=<?php echo GOOGLE_MAPS_API_KEY; ?>"></script>
<script type="text/javascript" src="<?php echo JS_PLUGINS_PATH; ?>location-picker/locationpicker.jquery.min.js"></script>
<?php
}
?>
<script type="text/javascript" src="<?php echo ADMIN_JS_PATH; ?>general.js"></script>   
    
<!-- END PLUGINS -->

<!-- THIS PAGE PLUGINS -->

<!-- END PAGE PLUGINS -->         
