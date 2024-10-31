<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$globalConfig = SimpleSAML_Configuration::getInstance();
$t = new SimpleSAML_XHTML_Template($globalConfig, 'saml:sp/wrong_authncontextclassref.tpl.php');
$t->show();
