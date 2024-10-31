<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Interface for triggering setter injection
 */
interface SAML2_Configuration_ServiceProviderAware
{
    public function setServiceProvider(SAML2_Configuration_ServiceProvider $serviceProvider);
}
