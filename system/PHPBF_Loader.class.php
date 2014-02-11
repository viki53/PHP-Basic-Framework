<?php if(!defined('ENVIRONMENT')) die('Direct access not allowed');

class PHPBF_Loader{
	private $config;

	public function __construct(&$config){
		$this->config = &$config;
	}

	public function view($name, $vars = null){
		if(is_file('views/'.$name.'.php')){
			if(is_array($vars))
				extract($vars);
			$config = &$this->config;
			include('views/'.$name.'.php');
		}
		return false;
	}
}