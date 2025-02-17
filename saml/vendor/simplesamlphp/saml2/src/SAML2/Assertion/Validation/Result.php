<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Simple Result object
 */
class SAML2_Assertion_Validation_Result
{
    /**
     * @var array
     */
    private $errors = array();

    /**
     * @param $message
     */
    public function addError($message)
    {
        if (!is_string($message)) {
            throw SAML2_Exception_InvalidArgumentException::invalidType('string', $message);
        }

        $this->errors[] = $message;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
