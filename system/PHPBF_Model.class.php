<?php if(!defined('ENVIRONMENT')) die('Direct access not allowed');

class PHPBF_Model{
	private $PHPBF;

	public function __construct(){
		$this->PHPBF = &get_PHPBF();
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