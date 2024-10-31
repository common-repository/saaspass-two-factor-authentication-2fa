<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Named Exception for what the name describes. This should not occur, as it has to be
 * caught on the configuration side.
 */
class SAML2_Certificate_Exception_InvalidCertificateStructureException extends DomainException implements
    SAML2_Exception_Throwable
{
}
