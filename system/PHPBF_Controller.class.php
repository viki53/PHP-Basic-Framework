<?php if(!defined('ENVIRONMENT')) die('Direct access not allowed');

class PHPBF_Controller{
	protected $PHPBF;
	protected $config;
	protected $load;

	public function __construct(){
		$this->PHPBF = &get_PHPBF();
		$this->load = new PHPBF_Loader();
	}
}