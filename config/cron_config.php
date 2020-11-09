<?php
define( 'BASE_DIR', '' );
define( 'SITE_NAME', 'Cop Express' );
define( 'CONFIG_DIR', 'config' );
define( 'DIR_SEPERATOR', '/' );
define( 'SV_DOCUMENT_ROOT', '/home3/brigloo/production.brigloo.com' );
define( 'SV_SERVER_NAME', 'production.brigloo.com' );
define( 'BASE_PATH', SV_DOCUMENT_ROOT . DIR_SEPERATOR . BASE_DIR );
define( 'BASE_URL', 'https' . '://' . SV_SERVER_NAME . DIR_SEPERATOR . BASE_DIR . DIR_SEPERATOR );
define( 'FL_COMMON_CONFIG', BASE_PATH . DIR_SEPERATOR . CONFIG_DIR . DIR_SEPERATOR . 'common_config.php' );

define( 'HTTP_BASE_URL', 'http' . '://' . SV_SERVER_NAME . DIR_SEPERATOR . BASE_DIR . DIR_SEPERATOR );
require_once FL_COMMON_CONFIG;