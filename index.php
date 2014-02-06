<?php
define('ENVIRONMENT', 'development');
// define('ENVIRONMENT', 'testing');
// define('ENVIRONMENT', 'production');

define('PHPBF_INDEX', pathinfo(__FILE__, PATHINFO_BASENAME));
define('PHPBF_ROOT', str_replace(PHPBF_INDEX, '', __FILE__));

require_once('system/PHPBF_Config.class.php');

$config = new PHPBF_Config();
$config->load();

echo '<pre>';
print_r($config->getAll());