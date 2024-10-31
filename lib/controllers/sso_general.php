<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
  if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

  global $saml_opts;
  $status = $this->get_saml_status();
  
  if (isset($_POST['submit']) &&  wp_verify_nonce($_POST['_wpnonce'],'sso_general') ) 
  {
    if(get_option('saaspass_saml_options'))
      $saml_opts = get_option('saaspass_saml_options');
    		
    $saml_opts['appkey'] = sanitize_html_class($_POST['appkey']);
    // Is the enable box checked, and is the plugin ready to be enabled?
    if(isset($_POST['enabled']) && $_POST['enabled'] == 'enabled')
    {
	  if( trim($saml_opts['appkey']) != '' )
//      if($status->num_errors === 0)
      {
        $saml_opts['enabled'] = true;
      }
      else
      {
        $saml_opts['enabled'] = false;
        echo '<div class="error settings-error"><p>Configure the SAASPASS AppKEY before enabling SAASPASS. Read the instructions for more help.</p></div>'."\n";
        echo '<script type="text/javascript">jQuery(\'.updated.settings-error\').remove();</script>';
      }
    }
    else
    {
      $saml_opts['enabled'] = false;
    }

    
    // Is the SSO Bypass Custom Query Changed?
    if(isset($_POST['bypass_query']) && $_POST['bypass_query'] != '' )
    {
      if(preg_match("/^[a-zA-Z0-9]+$/", $str) == 0)
       {
        // string only contain the a to z , A to Z, 0 to 9
        $saml_opts['sso_bypass_query'] = sanitize_html_class($_POST['bypass_query']);
      }
      else
      {
        $saml_opts['sso_bypass_query'] = 'true';
      }
    }
    else
    {
      $saml_opts['sso_bypass_query'] = 'true';
    }
      //Roles to block Changed
      if(isset($_POST["administrator"]))
      {
          $saml_opts['administrator'] = 'checked';
      }
      else {
          $saml_opts['administrator'] = '';
      }

      if(isset($_POST["editor"]))
      {
          $saml_opts['editor'] = 'checked';
      }
      else {
          $saml_opts['editor'] = '';
      }

      if(isset($_POST["author"]))
      {
          $saml_opts['author'] = 'checked';
      }
      else {
          $saml_opts['author'] = '';
      }

      if(isset($_POST["contributor"]))
      {
          $saml_opts['contributor'] = 'checked';
      }
      else {
          $saml_opts['contributor'] = '';
      }

      if(isset($_POST["subscriber"]))
      {
          $saml_opts['subscriber'] = 'checked';
      }
      else {
          $saml_opts['subscriber'] = '';
      }

      if(isset($_POST['disable_native']))
      {
        $saml_opts['disable_native'] = true;
        $saml_opts['administrator'] = "unchecked";
        $saml_opts['editor'] = "unchecked";
        $saml_opts['author'] = "unchecked";
        $saml_opts['contributor'] = "unchecked";
        $saml_opts['subscriber'] = "unchecked";
      }
      else
      {
        $saml_opts['disable_native'] = false;
      }

      // Is the Allow SSO Bypass box checked?
      if (isset($_POST['sso_bypass']) && $_POST['sso_bypass'] == 'yes' )
      {
          $saml_opts['sso_bypass'] = true;
          $saml_opts['administrator'] = "unchecked";
          $saml_opts['editor'] = "unchecked";
          $saml_opts['author'] = "unchecked";
          $saml_opts['contributor'] = "unchecked";
          $saml_opts['subscriber'] = "unchecked";
      }
      else
      {
          $saml_opts['sso_bypass'] = false;
      }
	
    update_option('saaspass_saml_options', $saml_opts);

	// Update settings
    //$this->settings->enable_cache();
    //$this->settings->set_appkey($_POST['appkey']);
	//$this->settings->disable_cache();
	  
  }

  
  if(get_option('saaspass_saml_options'))
  {
		$saml_opts = get_option('saaspass_saml_options');
  }
	
  $metadata['Consumer'] = wp_login_url();

  include(constant('SAMLAUTH_ROOT') . '/lib/views/sso_general.php');

?>
