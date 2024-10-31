<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

Class SAML_Admin
{
  private $settings;

  function __construct()
  {
    $this->settings = new SAML_Settings();
    add_action('init',array($this,'admin_menus'));
  }

  function admin_menus()
  {
	add_action('admin_menu', array($this,'admin_submenus'));
  }

  function admin_submenus()
  {
	add_submenu_page('options-general.php', 'SAASPASS Two Factor Authentication - 2FA', 'SAASPASS Two Factor Authentication - 2FA', 'administrator', 'sso_general.php', array($this,'sso_general'));
  }

  /*
  * Function Get SAML Status
  *   Evaluates SAML configuration for basic sanity
  *
  *
  * @param void
  *
  * @return Object
  */
  public function get_saml_status()
  {
    $return = new stdClass;
      $return->html = "";
      $return->num_warnings = 0;
      $return->num_errors = 0;

    $status = array(
        'saaspass_settings' => array(
          'error'   => 'You need to provide your SAASPASS Appkey. Please follow the instructions below on how to get it.',
          'warning' => '',
          'ok'      => 'You have provided SAASPASS Appkey.',
        )
    );

    $status_html = array(
      'error'   => array(
        '<tr class="red"><td><i class="icon-remove icon-large"></i></td><td>',
        '</td></tr>'
      ),
      'warning' => array(
        '<tr class="yellow"><td><i class="icon-warning-sign icon-large"></i></td><td>',
        '</td></tr>'
      ),
      'ok'      => array(
        '<tr class="green"><td><i class="icon-ok icon-large"></i></td><td>',
        '</td></tr>'
      )
    );

    $return->html .= '<table class="saml_status">'."\n";

    if( trim($this->settings->get_appkey('appkey')) == '' )
    {
      $return->html .= $status_html['error'][0] . $status['saaspass_settings']['error'] . $status_html['error'][1];
      $return->num_errors++;
    }
    else
    {
      $return->html .= $status_html['ok'][0] . $status['saaspass_settings']['ok'] . $status_html['ok'][1];
    }

    $return->html .= '</table>'."\n";

    return $return;
  }

  public function sso_general(){
    include(constant('SAMLAUTH_ROOT') . '/lib/controllers/' . __FUNCTION__ . '.php');
  }

}

// End of file saml_admin.php
