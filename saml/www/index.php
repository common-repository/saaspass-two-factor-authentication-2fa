<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once('_include.php');

\SimpleSAML\Utils\HTTP::redirectTrustedURL(SimpleSAML_Module::getModuleURL('core/frontpage_welcome.php'));
