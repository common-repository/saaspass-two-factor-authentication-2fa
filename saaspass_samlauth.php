<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Plugin Name: SAASPASS Two Factor Authentication - 2FA
Plugin URI: https://www.saaspass.com
Description: Authenticate users via SAASPASS.
Version: 1.0.4
Author: SAASPASS
Author URI: https://www.saaspass.com
*/

define('SAMLAUTH_ROOT',dirname(__FILE__));
define('SAMLAUTH_URL',plugins_url() . '/' . basename( dirname(__FILE__) ) );
define('SAMLAUTH_MD_URL', constant('SAMLAUTH_URL') . '/saml/www/module.php/saml/sp/metadata.php/' . get_current_blog_id() );


// Things needed everywhere
require_once( constant('SAMLAUTH_ROOT') . '/lib/classes/saml_settings.php' );
require_once( constant('SAMLAUTH_ROOT') . '/lib/classes/saml_client.php' );

$SAML_Client = new SAML_Client();

// WordPress action hooks
add_action('lost_password', array($SAML_Client,'disable_function'));
add_action('retrieve_password', array($SAML_Client,'disable_function'));
add_action('password_reset', array($SAML_Client,'disable_function'));
add_filter('show_password_fields', array($SAML_Client,'show_password_fields'));


// Things needed only by the admin portal
if( is_admin() )
{
  require_once( constant('SAMLAUTH_ROOT') . '/lib/classes/saml_admin.php' );
  $SAML_Admin = new SAML_Admin();
}

// end of file
