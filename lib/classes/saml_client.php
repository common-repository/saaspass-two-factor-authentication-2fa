<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class SAML_Client
{
  private $saml;
  private $opt;
  private $saml_opts;
  public $flag;// = false;
  
  function __construct()
  {
    $this->settings = new SAML_Settings();

    require_once(constant('SAMLAUTH_ROOT') . '/saml/lib/_autoload.php');
        if( $this->settings->get_enabled() )
        {
            $this->saml = new SimpleSAML_Auth_Simple((string)get_current_blog_id());
            
            add_action('wp_authenticate',array($this,'authenticate'));
            add_action('wp_logout',array($this,'logout'));
            add_action('login_form', array($this, 'modify_login_form'));
            add_filter('authenticate', array($this,'my_authenticate'), 30, 4 );
        }

        
  }

  /**
   *  Authenticates the user using SAML
   *
   *  @return void
   */
  public function authenticate()
  {
      $this->saml_opts = get_option('saaspass_saml_options');
    if( isset($_GET['loggedout']) && $_GET['loggedout'] == 'true' )
    {
      header('Location: ' . get_option('siteurl'));
      exit(); 
    }//($this->settings->get_allow_sso_bypass() == true  &&
    elseif ( ( isset($_GET['use_sso']) && $_GET['use_sso'] == 'true' ) || ( isset($_POST['use_sso']) && $_POST['use_sso'] == 'true')  || isset($_POST['SAMLRequest']) || isset($_POST['SAMLResponse']) )
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
        }//
        $redirect_url = (array_key_exists('redirect_to', $_GET)) ? wp_login_url( $_GET['redirect_to']) : wp_login_url().'?use_sso=true';
        if (array_key_exists('SAMLRequest', $_POST) || array_key_exists('SAMLResponse', $_POST) ) {
            require(constant('SAMLAUTH_ROOT') . '/saml/modules/saml/www/sp/saml2-acs.php');
        }
        $this->saml->requireAuth( array('ReturnTo' => $redirect_url ) );
        $attrs = $this->saml->getAttributes();
        if (array_key_exists('username', $attrs)) {
            $username = $attrs['username'][0];
            if (get_user_by('login', $username)) {

                $this->simulate_signon($username);
            } else {
                if (isset($_SERVER['HTTP_COOKIE'])) {
                    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                    foreach ($cookies as $cookie) {
                        $parts = explode('=', $cookie);
                        $name = trim($parts[0]);
                        setcookie($name, '', time() - 1000);
                        setcookie($name, '', time() - 1000, '/');
                    }
                }
                wp_die('User not found!<br><br><a class="button" href="' . get_option('siteurl') . '/wp-login.php">Go to Login Page</a>', 'SAASPASS SAML Error');
            }
        } else {
            die('A username was not provided.');
        }
    }
    elseif ( $this->saml_opts['sso_bypass'] == true && isset($_GET['bypass']) && $_GET['bypass'] == $this->getCustomQuery() ) {

    }
    else {
    //Native Login - do nothing
        $saml_opts = get_option('saaspass_saml_options');
        if ( $saml_opts['disable_native'] == true )
        {
            wp_redirect(wp_login_url().'?use_sso=true');
        }

    }
  }

  /**
   * Sends the user to the SAML Logout URL (using SLO if available) and then redirects to the site homepage
   *
   * @return void
   */
  public function logout()
  {
    $this->saml->logout( get_option('siteurl') );
  }

  /**
   * Runs about halfway through the login form. If we're bypassing SSO, we need to add a field to the form
   *
   * @return void
   */
  public function modify_login_form() {
    if( array_key_exists('use_sso', $_GET) && $_GET['use_sso'] == $this->getCustomQuery() && $this->settings->get_allow_sso_bypass() == true ) {
        echo '<input type="hidden" name="bypass" value="' . $this->getCustomQuery() . '">' . "\n";
    }

     echo '<a style="margin-left:0px;padding:0px;" href="'.wp_login_url().'?use_sso=true"> <img src="'. content_url().'/plugins/saaspass-two-factor-authentication-2fa/lib/classes/img/button.png" /></a>';
  }
  /**
   * Authenticates the user with WordPress using wp_signon()
   *
   * @param string $username The user to log in as.
   * @return void
   */
  private function simulate_signon($username)
  {
    $user = get_user_by('login', $username);
    wp_set_auth_cookie($user->ID);

    if( array_key_exists('redirect_to', $_GET) )
    {
      wp_redirect( $_GET['redirect_to'] );
    }
    else
    {
      wp_redirect(get_admin_url());
    }
    exit();
  }

  public function show_password_fields($show_password_fields) {
    return false;
  }

  public function disable_function() {
    die('Disabled');
  }

    /**
     * @return Custom sso query
     */
    public function getCustomQuery()
  {
    if(get_option('saaspass_saml_options'))
       $saml_opts = get_option('saaspass_saml_options');
    return $saml_opts['sso_bypass_query'];
  }

    public function uncheckAllRoles() {
        $saml_opts['administrator'] = "unchecked";
        $saml_opts['editor'] = "unchecked";
        $saml_opts['author'] = "unchecked";
        $saml_opts['contributor'] = "unchecked";
        $saml_opts['subscriber'] = "unchecked";
    }

    /**
     * Create Roles to be blocked from native login
     * @return array
     */

   public function getBlockedRolesArray()
  {
      if(get_option('saaspass_saml_options'))
        $saml_opts = get_option('saaspass_saml_options');
        $roles = array();
        if( $saml_opts['administrator'] == "checked" ) {
            array_push($roles, "administrator");
            $saml_opts['sso_bypass'] = false;
            $saml_opts['disable_native'] = false;
        }
        if( $saml_opts['editor'] == "checked" ) {
            array_push($roles, "editor");
            $saml_opts['sso_bypass'] = false;
            $saml_opts['disable_native'] = false;
        }
        if( $saml_opts['contributor'] == "checked" ) {
            array_push($roles, "contributor");
            $saml_opts['sso_bypass'] = false;
            $saml_opts['disable_native'] = false;
        }
        if( $saml_opts['author'] == "checked" ) {
            array_push($roles, "author");
            $saml_opts['sso_bypass'] = false;
            $saml_opts['disable_native'] = false;
        }
        if( $saml_opts['subscriber'] == "checked" ) {
            array_push($roles, "subscriber");
            $saml_opts['sso_bypass'] = false;
            $saml_opts['disable_native'] = false;
        }

        return ($roles);
    }


    /**
     * Prohibit Login for blocked roles
     * @param $user
     * @param $username
     * @param $password
     * @return WP_Error
     */
  public function my_authenticate($user , $username, $password )
  {
      $saml_opts = get_option('saaspass_saml_options');
      if ($saml_opts['enabled'] == true && $this->flag != true ) {
          if ($user instanceof WP_User) {
              $roles_to_block = $this->getBlockedRolesArray();
              foreach ($roles_to_block as $role_to_block) {
                  if (user_can($user, $role_to_block)) {
                      return new WP_Error(1, 'Login is prohibited');
                  }
              }
          }
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              if (empty($username) || empty($password)) {
                  wp_redirect(wp_login_url());
              }
              $new_user = get_user_by('login', $username);
          }
          return $user;
      }
  }

} // End of Class SamlAuth
