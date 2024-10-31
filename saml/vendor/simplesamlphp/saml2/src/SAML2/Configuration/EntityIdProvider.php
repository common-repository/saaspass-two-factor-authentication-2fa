<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Interface SAML2_Configuration_EntityIdProvider
 */
interface SAML2_Configuration_EntityIdProvider
{
    /**
     * @return null|string
     */
    public function getEntityId();
}
