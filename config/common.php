<?php
class common {    
    public $google_map_link = '';
    public $arr_exclude = array( "logout.php" );
    
    function __construct(){
    
    }

    function redirect( $location ){
        header( "location:" . $location );
        exit;
    }

    function check_admin_login(){
        if( !session_id() ){
            session_start();

        }
        if( !isset( $_SESSION['admin_user_id'] ) || $_SESSION['admin_user_id'] < 1 ){
            $this->redirect(ADMIN_URL . 'admin_login.php');
            return 0;
        } else {
            $this->redirect(ADMIN_URL);
            return 1;
        }
    }

    function check_user_login(){
        if( !session_id() ){
            session_start();
        }
        if( !isset( $_SESSION['user_id'] ) || $_SESSION['user_id'] < 1 ){
            header( "location:" . VW_LOGIN );
            exit;
            $this->redirect_to( VW_LOGIN );
            return 0;
        } else {
            if( isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 ){
               if( isset( $_SESSION['user_type'] ) ){
                    if ( $_SESSION['user_type'] == 'driver' ) {
                        $this->redirect_to( VW_DRIVER_HOME );
                        return 0;
                    } else if ( $_SESSION['user_type'] == 'business_owner' ) {
                        $this->redirect_to( VW_BO_HOME );
                        return 0;
                    }else if ( $response['st_user_type'] == 'admin') {
                       $this->redirect_to( BASE_URL . DIR_SEPERATOR . BACKEND_DIR . DIR_SEPERATOR . 'views/user_list.php' );
                        return 0;
                    }
                    return 0;
               }
            }
        }
    }

    function sanitize_input() {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = mysqli_real_escape_string( trim( $value ) );
        }
    }

    function include_extra_js( $extra_js, $path = "user" ){
        if( $path == "user" ) {
            $js_path = JS_PATH;
        } else {
            $js_path = ADMIN_JS_PATH;
        }
        $external_js = array(
            'google_maps' => $this->google_map_link
        );
        if( !empty( $extra_js ) && count( $extra_js ) > 0 ){
            $extra_js = array_unique( $extra_js );
            foreach ( $extra_js as $js ) {
                if( preg_match( '/^.*\.js$/', $js ) ){
                    echo '<script type="text/javascript" src="' . $js_path . $js . '"></script>';
                } else if( isset ( $external_js[$js] ) ){
                    echo '<script type="text/javascript" src="' . $external_js[$js] . '"></script>';
                }
            }
        }
    }

    function redirect_to( $url ){
        header( "location:" . $url );
        exit;
    }
    
    function is_profile_in_review_mode(){
        if( !session_id() ){
            session_start();
        }
        
        include_once FL_USER;
        $user = new user();
                
        $user_id = $_SESSION['user_id'];
        
        $user_data = $user->get_user_data( $user_id );
        $user_type = $_SESSION['user_type'];
        
        if( $user_data['in_is_active'] == 0 ) {
            include_once FL_BLOCKED_HEADER;
            echo '<div class="nothing-tmp" style="margin-top:20%">Your profile is in review mode</div>';
            include_once FL_BLOCKED_FOOTER;
            include_once FL_USER_FOOTER_INCLUDE;
            exit;
        }
        
    }

}