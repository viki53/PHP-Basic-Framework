<?php

/* 
	Define your environment here, to change the app behaviour regarding errors and other feedbacks
*/

define('ENVIRONMENT', 'development');
// define('ENVIRONMENT', 'production');





/*
	---------------------------------
	|								|
	|								|
	|	YOU MAY STOP EDITING HERE	|
	|								|
	|								|
	---------------------------------
*/






define('PHPBF_INDEX', pathinfo(__FILE__, PATHINFO_BASENAME));
define('PHPBF_ROOT', str_replace(PHPBF_INDEX, '', __FILE__));


function __autoload($class_name) {
	if(is_file('classes/'.$class_name.'.class.php'))
		require_once 'classes/'.$class_name.'.class.php';
	elseif(is_file('system/'.$class_name.'.class.php'))
		require_once 'system/'.$class_name.'.class.php';
	else
		throw new Exception('Class '.$class_name.' cannot be found. Please check again.');
}

$PHPBF = new PHPBF();

$PHPBF->loadController();
