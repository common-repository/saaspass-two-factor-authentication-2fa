<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

interface SAML2_Response_Validation_ConstraintValidator
{
    public function validate(SAML2_Response $response, SAML2_Response_Validation_Result $result);
}
