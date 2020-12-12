<?php
$SERVER_NAME = $_SERVER['SERVER_NAME'];
define( 'BASE_DIR', 'brigloo-dev' );
define( 'SITE_NAME', 'Cop Express' );
define( 'DIR_SEPERATOR', '/' );
define( 'CONFIG_DIR', 'config' );
define( 'BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . DIR_SEPERATOR . BASE_DIR . DIR_SEPERATOR   );
define( 'BASE_URL',  'https' . '://' . $_SERVER['SERVER_NAME'] . DIR_SEPERATOR . BASE_DIR . DIR_SEPERATOR );

define( 'HTTP_BASE_URL', 'http' . '://' . $_SERVER['SERVER_NAME'] . DIR_SEPERATOR . BASE_DIR );
define( 'FL_COMMON_CONFIG', BASE_PATH . DIR_SEPERATOR . CONFIG_DIR . DIR_SEPERATOR . 'common_config.php' );
require_once FL_COMMON_CONFIG;