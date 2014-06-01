<?php if(!defined('ENVIRONMENT')) die('Direct access not allowed');

class Home_Controller extends PHPBF_Controller{
	public function __construct(&$config){
		parent::__construct($config);
	}

	public function index(){
		return $this->blabla();
	}

	public function blabla($str = ''){
		$obj = new Listenable_Object(array('id' => 1, 'name' => 'foo'));

		$obj->bind('before_save', function($o){ $o->set('name', 'bar'); });
		$obj->bind('saved', function($o){ echo '<p>Saved : '.$o.'</p>'; });

		$this->load->view('home-blabla', array('str' => $str, 'obj' => $obj));
	}
}