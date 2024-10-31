<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class SAML2_Response_Exception_UnencryptedAssertionFoundException extends \RuntimeException implements
    SAML2_Exception_Throwable
{
}
