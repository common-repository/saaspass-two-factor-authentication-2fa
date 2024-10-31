<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Named exception
 */
class SAML2_Exception_RuntimeException extends RuntimeException implements SAML2_Exception_Throwable
{
}
