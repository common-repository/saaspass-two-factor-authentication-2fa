<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="wp-caption welcome-panel">
    <div class="wrap welcome-panel-content">
        <h1>SAASPASS Two Factor Authentication - 2FA</h1>
        <hr>
        <div class="wrap">
            <h3>How to set up SAASPASS</h3>
            <p> To protect your WordPress with SAASPASS, you need to create a WordPress application on <a href="http://www.saaspass.com">SAASPASS</a> and follow the instructions there.
                <br/> During the integration of WordPress application on SAASPASS, you will be asked to set the "WORDPRESS ACS URL" settings, for which use the following url:
                <br>
                <pre><code class="metadata-box"><?php echo esc_url($metadata['Consumer']);?></code></pre>
                <br>
            </p>
            <p>
                <span class="dashicons dashicons-lightbulb"></span> <strong>Tip:</strong> Our reccomendations for ecommerce sites:
                <ul style="margin-left: 40px">
                    <li type="square">Disable the default login page ( unchecked )</li>
                    <li type="square">Allow SSO Bypass ( unchecked )</li>
                    <li type="square">And check Administrator, Editor, Author and Contributor, leave Subscriber unchecked. ( Blocked Roles can only use SAASPASS Two Factor Authentication - 2FA as login method ).</li>
                </ul>
            </p>
            <form method="post">
                <?php wp_nonce_field( 'sso_general'); ?>
                <h3>Settings</h3>
                <hr>
                <fieldset class="options">
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row">
                                <label for="appkey">SAASPASS APPLICATION Key</label>
                            </th>
                            <td>
                                <input type="text" name="appkey" id="appkey" value="<?php echo $saml_opts['appkey']; ?>" size="40" />
                                <br>
                                <span class="description">You can get this from SAASPASS portal by following the integration instructions.</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="disable_native">Disable the default login page</label>
                            </th>
                            <td>
                                <?php $checked=( $saml_opts[ 'disable_native']) ? 'checked="checked"' : ''; ?>
                                <input type="checkbox" name="disable_native" id="disable_native" value="yes" <?php echo $checked; ?><!

                              <span class="setting-description">Disable WordPress default login page and force the use of SAASPASS Two Factor Authentication - 2FA. <br><br><!--Use <a href="--><?php //echo wp_login_url(); ?><!--?use_sso=--><?php //echo $saml_opts['sso_bypass_query'];?><!--">--><?php //echo wp_login_url(); ?><!--?use_sso=--><?php //echo $saml_opts['sso_bypass_query'];?><!--</a>.</span>-->
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="allow_sso_bypass">Allow SSO Bypass</label>
                            </th>
                            <td>
                                <?php $checked=( $saml_opts[ 'sso_bypass']) ? 'checked="checked"' : ''; ?>
                                <input type="checkbox" name="sso_bypass" id="sso_bypass" value="yes" <?php echo $checked; ?>>

                                <span class="setting-description">Allows WordPress users to login without the use of SAASPASS Two Factor Authentication - 2FA. <br><br>Use <a href="<?php echo wp_login_url(); ?>?bypass=<?php echo $saml_opts['sso_bypass_query'];?>"><?php echo wp_login_url(); ?>?bypass=<?php echo $saml_opts['sso_bypass_query'];?></a></span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="allow_sso_bypass">SSO Bypass Custom Query</label>
                            </th>
                            <td>
                                <span class="setting-description">bypass=</span> <input type="text" name="bypass_query" id="bypass_query" value="<?php echo $saml_opts['sso_bypass_query']; ?>" size="40" />
                                <br>
                                <span class="description">You can write your custom query for SSO bypass. String can only contain the a to z , A to Z, 0 to 9. (Default value is <span style="color: black;font-weight:bold;font-style:normal">true</span>) </span>
                            </td>
                        </tr>
                        <th scope="row">
                            <label for="roles_to_block">Roles to be blocked from native login</label>
                        </th>
                        <td>
                            <ul>
                                <li class="page_item"> <input type="checkbox" name="administrator" id="administrator" value="enabled" <?php echo $saml_opts['administrator'] ?>/> Administrator </li>
                                <li class="page_item"> <input type="checkbox" name="editor" id="editor" value="enabled" <?php echo $saml_opts['editor'] ?> /> Editor </li>
                                <li class="page_item"> <input type="checkbox" name="author" id="author" value="enabled" <?php echo $saml_opts['author'] ?> /> Author </li>
                                <li class="page_item"> <input type="checkbox" name="contributor" id="contributor" value="enabled"  <?php echo $saml_opts['contributor'] ?> /> Contributor </li>
                                <li class="page_item"> <input type="checkbox" name="subscriber" id="subscriber" value="enabled" <?php echo $saml_opts['subscriber'] ?> /> Subscriber </li>
                            </ul>
                            <span class="description"> Blocking role option is not available if bypass or disable default login page options are selected.</span>
                        </td>
                        <tr valign="top">
                            <th scope="row">
                                <label for="enabled"><strong>Enable SAASPASS authentication</strong></label>
                            </th>
                            <?php $checked=( $saml_opts[ 'enabled']) ? ' checked="checked"' : ''; ?>
                            <td>
                                <input type="checkbox" name="enabled" id="enabled" value="enabled" <?php echo $checked;?> />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p><span class="dashicons dashicons-lightbulb"></span> <strong>Tip:</strong> You can use a different browser (or a Google Chrome Incognito window) to test SAML authentication, while leaving this window open. If SAML logins don't work right away, you can use this window to troubleshoot.</p>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <hr>

                <div class="submit">
                    <input type="submit" name="submit" class="button button-primary button-hero load-customize hide-if-no-customize" value="Update Options" />
                </div>
            </form>
        </div>
    </div>
</div>