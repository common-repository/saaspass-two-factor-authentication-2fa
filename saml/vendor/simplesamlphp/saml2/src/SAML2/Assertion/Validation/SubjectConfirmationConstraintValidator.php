<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

interface SAML2_Assertion_Validation_SubjectConfirmationConstraintValidator
{
    public function validate(
        SAML2_XML_saml_SubjectConfirmation $subjectConfirmation,
        SAML2_Assertion_Validation_Result $result
    );
}
