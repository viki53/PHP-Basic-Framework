<?php if(!defined('ENVIRONMENT')) die('Direct access not allowed');

class Home_Controller extends PHPBF_Controller{
	public function __construct(&$config){
		parent::__construct($config);
	}

	public function blabla(){
		echo '<h1>Hello World!</h1>';
		echo '<h2>It works!</h2>';
		echo '<h3>Isn\'t that amazing?!</h3>';
	}
}