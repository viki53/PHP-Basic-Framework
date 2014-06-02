<?php if(!defined('ENVIRONMENT')) die('Direct access not allowed');

class PHPBF_Loader{
	private $PHPBF;

	public function __construct(){
		$this->PHPBF = &get_PHPBF();
	}

	public function view($view_name, $vars = null){
		if(is_file('views/'.$view_name.'.php')){
			if(is_array($vars))
				extract($vars);
			$config = &$this->PHPBF->config;
			include('views/'.$view_name.'.php');
		}
		return false;
	}

	public function model($model_name, $config = null){
		$model_name = implode('_', array_map('ucwords', explode('_', $model_name)));

		if(isset($this->{$model_name})){
			return;
		}

		if(is_file('models/'.$model_name.'.php')){
			include_once('models/'.$model_name.'.php');

			$this->{$model_name} = new $model_name();
		}
		return false;
	}
}