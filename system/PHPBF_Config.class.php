<?php

class PHPBF_Config{
	private $file_name;
	// private $json_str;
	private $properties;

	public function __construct(){
		$this->load();
	}

	public function load(){
		$this->file_name = 'config-'.ENVIRONMENT.'.json';

		$json_str = @file_get_contents($this->file_name);

		if(empty($json_str)){
			return null;
		}

		$this->properties = @json_decode($json_str);

		if(empty($this->properties)){
			return null;
		}

		if(!is_file('app-errors.log')){
			file_put_contents('app-errors.log', '');
		}

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

		if(!$this->get('site_url')){
			$this->set('site_url', 'http://'.$_SERVER['HTTP_HOST'].($this->get('index_file') ? $_SERVER['SCRIPT_NAME'] : str_replace($this->get('index_file'), '', $_SERVER['SCRIPT_NAME'])));
		}

		if(!$this->get('path')){
			$this->set('path', PHPBF_ROOT);
		}

		if(isset($this->properties->config_modifiers)){
			if(is_string($this->properties->config_modifiers)){
				$this->properties->config_modifiers = explode(',', $this->properties->config_modifiers);
			}
			if(is_array($this->properties->config_modifiers) && sizeof($this->properties->config_modifiers) > 0){
				require_once(PHPBF_ROOT.'classes/Config_Modifiers.class.php');

				foreach($this->properties->config_modifiers as $modifier)
				Config_Modifiers::$modifier($this);
			}
		}

		return $this->properties;
	}

	public function get($key){
		if(isset($this->properties->{$key}))
			return $this->properties->{$key};
		return null;
	}

	public function getAll(){
		return $this->properties;
	}

	public function set($key, $value){
		if(isset($this->properties->{$key}))
			$this->properties->{$key} = $value;
	}
}