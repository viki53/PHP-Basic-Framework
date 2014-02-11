<?php

class PHPBF_Config{
	private $file_name;
	// private $json_str;
	private $json_object;

	public function __construct(){

	}

	public function load(){
		$this->file_name = 'config-'.ENVIRONMENT.'.json';

		$json_str = @file_get_contents($this->file_name);

		if(empty($json_str)){
			return null;
		}

		$this->json_object = @json_decode($json_str);

		if(empty($this->json_object)){
			return null;
		}

		if(!is_file('app-errors.log'))
			file_put_contents('app-errors.log', '');

		ini_set('error_log', 'app-errors.log');

		switch(ENVIRONMENT){
			case 'development':
				error_reporting(E_ALL);
				ini_set('display_errors', 1);
			break;

			case 'production':
			default:
				error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
				ini_set('display_errors', 0);
				ini_set('ignore_repeated_errors', 'On');
			break;
		}

		if(!$this->get('path'))
			$this->set('path', PHPBF_ROOT);

		if(isset($this->json_object->config_modifiers)){
			if(is_string($this->json_object->config_modifiers)){
				$this->json_object->config_modifiers = explode(',', $this->json_object->config_modifiers);
			}
			if(is_array($this->json_object->config_modifiers) && sizeof($this->json_object->config_modifiers) > 0){
				require_once(PHPBF_ROOT.'classes/Config_Modifiers.class.php');

				foreach($this->json_object->config_modifiers as $modifier)
				Config_Modifiers::$modifier($this);
			}
		}

		return $this->json_object;
	}

	public function get($key){
		if(isset($this->json_object->{$key}))
			return $this->json_object->{$key};
		return null;
	}

	public function getAll(){
		return $this->json_object;
	}

	public function set($key, $value){
		if(isset($this->json_object->{$key}))
			$this->json_object->{$key} = $value;
	}
}