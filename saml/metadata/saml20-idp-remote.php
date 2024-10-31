<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * SAASPASS IdP. 
 */

$blog_id = (string)get_current_blog_id();
$saml_opts = get_option('saaspass_saml_options');
 
$metadata['https://www.saaspass.com/idp/'. $saml_opts['appkey']] = array( // saaspass
	'name' => 'SAASPASS_IdP',
	'description'          => 'SAASPASS IdP for WordPress.',

	'SingleSignOnService'  => 'https://www.saaspass.com/sd/loginSAML/' . $saml_opts['appkey'], // saaspass
	'certFingerprint'      => '6db9925ee892e76149d9103fc9f6164ae8f09b81'   // saaspass

);
