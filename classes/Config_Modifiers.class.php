<?php if(!defined('ENVIRONMENT')) die('Direct access not allowed');

class Config_Modifiers{
	static public function set_user_language($config){
		if(empty($config->language) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
			preg_match_all("/([[:alpha:]]{1,8})(-([[:alpha:]|-]{1,8}))?"."(\s*;\s*q\s*=\s*(1\.0{0,3}|0\.\d{0,3}))?\s*(,|$)/i", $_SERVER['HTTP_ACCEPT_LANGUAGE'], $accepted_languages, PREG_SET_ORDER);

			foreach($accepted_languages as $l){
				if(is_file(strtolower($l[1]).'.html')){
					$config->language = strtolower($l[1]);
					break;
				}
			}
		}
	}
}