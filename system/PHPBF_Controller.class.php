<?php if(!defined('ENVIRONMENT')) die('Direct access not allowed');

class PHPBF_Controller{
	protected $config;
	protected $load;

	public function __construct(&$config){
		$this->config = &$config;
		$this->load = new PHPBF_Loader($this->config);
	}
}