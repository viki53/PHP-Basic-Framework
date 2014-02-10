<?php if(!defined('ENVIRONMENT')) die('Direct access not allowed');

class PHPBF{
	private static $config;
	public static function loadConfig(){
		$config = new PHPBF_Config();
		$config->load();
		return $config;
	}

	public static function getPathToLoad(&$config){
		$urls = $config->get('urls');

		$called_url = substr(isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/', 1);

		if($called_url === ''){
			return array($urls->default_controller);
		}
		else{
			foreach($urls->rewrite as $pattern => $replacement){
				if($path = preg_replace('#^'.$pattern.'$#i', $replacement, $called_url)){
					return explode('/', $path);
				}
			}
			return explode('/', $called_url);
		}

		return $path;
	}

	public static function loadController(&$config){
		$config_urls = $config->get('urls');
		$path = self::getPathToLoad($config);

		if(!empty($path[0]))
			$controller_name = $path[0];
		else
			$controller_name = $config_urls->default_controller;

		$controller_name = implode('_', array_map('ucwords', explode('_', $controller_name)));

		$controller_class = $controller_name.'_Controller';
		
		if(!empty($path[1]))
			$controller_function = $path[1];
		else
			$controller_function = $config_urls->default_controller_function;

		if(!empty($path[2]))
			$controller_parameters = array_slice($path, 2);
		else
			$controller_parameters = array();

		require_once('controllers/'.ucwords($controller_name).'.php');
		$controller = new $controller_class($config);

		error_log('Calling '.$controller_name.'->'.$controller_function.'() with '.sizeof($controller_parameters).' parameters');
		call_user_func_array(array($controller, $controller_function), $controller_parameters);
	}
}