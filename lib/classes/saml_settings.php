<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

Class SAML_Settings
{
  private $wp_option;
  private $current_version;
  private $cache;
  private $settings;

  function __construct()
  {
    $this->wp_option = 'saaspass_saml_options';
    $this->current_version = '1.0.0';
    $this->cache = false;
    $this->_get_settings();
  }

  /**
   * Get the "enabled" setting
   *
   * @return bool
   */
  public function get_enabled()
  {
    return (bool) $this->settings['enabled'];
  }

  public function get_appkey()
  {
    return (string) $this->settings['appkey'];
  }

  /**
   * Get the "allow_sso_bypass" setting
   *
   * @return bool
   */
  public function get_allow_sso_bypass()
  {
    return (bool) $this->settings['sso_bypass'];
  }
    /**
   * Get the "allow_sso_bypass" setting
   *
   * @param string $value The new custom query to bypass_sso
   * @return bool
   */
  public function set_sso_bypass_custom_quesry($value='true')
  {
    $this->settings['sso_bypass_query'] = 'true';//$value;
    $this->_set_settings();
  }

  /**
   * Sets whether to enable SAML authentication
   *
   * @param bool $value The new value
   * @return void
   */
  public function set_enabled($value)
  {
    if( is_bool($value) )
    {
      $this->settings['enabled'] = $value;
      $this->_set_settings();
    }
  }

  /**
   * Sets the IdP Entity ID
   *
   * @param string $value The new Entity ID
   * @return void
   */
  public function set_appkey($value)
  {
    if( is_string($value) )
    {
      $this->settings['appkey'] = $value;
      $this->_set_settings();
    }
  }

  /**
   * Prevents use of ::_set_settings()
   *
   * @return void
   */
  public function enable_cache()
  {
    $this->cache = true;
  }

  /**
   * Saves settings and sets cache to false
   *
   * @return void
   */
  public function disable_cache()
  {
    $this->cache = false;
    $this->_set_settings();
  }

  /**
   * Retrieves settings from the database; performs upgrades or sets defaults as necessary
   *
   * @return void
   */
  private function _get_settings()
  {
    $wp_option = get_option($this->wp_option);

    if( is_array($wp_option) )
    {
      $this->settings = $wp_option;
      if( $this->_upgrade_settings() )
      {
        $this->_set_settings();
      }
    }
    else
    {
      $this->settings = $this->_use_defaults();
      $this->_set_settings();
    }
  }


  /**
   * Writes settings to the database\
   *
   * @return bool true if settings are written to DB, false otherwise
   */
  private function _set_settings()
  {
    if($this->cache === false)
    {
      update_option($this->wp_option, $this->settings);
      return true;
    }
    else
    {
      return false;
    }
  }

  /**
   * Returns an array of default settings for the database. Typically used on first run.
   *
   * @return array the array of settings
   */
  private function _use_defaults()
  {
    $defaults = array(
      'option_version' => $this->current_version,
      'enabled' => false,
      'allow_sso_bypass' => false,
	  'appkey' => '', 
    );

    return($defaults);
  }

  /**
   * Upgrades the settings array to the latest version
   *
   * @return bool true if changes were made, false otherwise
   */
  private function _upgrade_settings()
  {
    $changed = false;
    return($changed);
  }
}
// End of file saml_settings.php
