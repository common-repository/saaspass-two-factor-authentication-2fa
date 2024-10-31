<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//$saml_opts = get_option('saaspass_saml_options');
$blog_id = (string)get_current_blog_id();
$saml_opts = get_option('saaspass_saml_options');
$idpinitlandingurl = wp_login_url().'?use_sso=' . $saml_opts['sso_bypass_query']; //get_admin_url();


$config = array(

	// This is a authentication source which handles admin authentication.
	'admin' => array(
		// The default is to use core:AdminPassword, but it can be replaced with
		// any authentication source.

		'core:AdminPassword',
	),


	// An authentication source which can authenticate against both SAML 2.0
	// and Shibboleth 1.3 IdPs.

	$blog_id => array(
		'saml:SP',
		'NameIDPolicy' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
		// The entity ID of this SP.
		// Can be NULL/unset, in which case an entity ID is generated based on the metadata URL.
		'entityID' => wp_login_url(),//.'?use_sso=' . $saml_opts['sso_bypass_query'],
		// The entity ID of the IdP this should SP should contact.
		// Can be NULL/unset, in which case the user will be shown a list of available IdPs.
		'idp' => 'https://www.saaspass.com/idp/'. $saml_opts['appkey'] ,   // saaspass
		'RelayState' => wp_login_url()."?use_sso=true"// $idpinitlandingurl

	)

);
