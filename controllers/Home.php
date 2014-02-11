<?php if(!defined('ENVIRONMENT')) die('Direct access not allowed');

class Home_Controller extends PHPBF_Controller{
	public function __construct(&$config){
		parent::__construct($config);
	}

	public function index(){
		return $this->blabla();
	}

	public function blabla($str = ''){
		// echo '<pre>';
		// var_dump($this);
		// exit;
		$this->load->view('home-blabla', array('str' => $str));
	}
}