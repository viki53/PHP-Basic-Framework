<?php if(!defined('ENVIRONMENT')) die('Direct access not allowed');

class Listenable_Object {
	private $properties = array();
	private $events_listeners = array();
	private $db_wrapper = NULL;

	public function __construct($properties = array(), $db_wrapper = NULL) {
		$this->properties = $properties;
		$this->db_wrapper = $db_wrapper;
	}

	public function set($key, $val) {
		$old_value = isset($this->properties[$key]) ? $this->properties[$key] : NULL;

		$this->properties[$key] = $val;

		$this->trigger('set', array('property' => $key, 'old_value' => $old_value, 'new_value' => $val));

		return $this;
	}

	public function get($key) {
		return isset($this->properties[$key]) ? $this->properties[$key] : NULL;
	}

	public function bind($event, $listener) {
		if(!isset($this->events_listeners[$event])) {
			$this->events_listeners[$event] = array();
		}

		$key = array_search($listener, $this->events_listeners[$event]);

		if($key !== false && isset($this->events_listeners[$event][$key])) {
			$this->events_listeners[$event][$key] = $listener;
		}
		else {
			array_push($this->events_listeners[$event], $listener);
		}

		return $this;
	}

	public function unbind($event, $listener = NULL) {
		if(empty($this->events_listeners[$event])) {
			return $this;
		}

		if($listener === NULL) {
			$this->events_listeners[$event] = array();
			return $this;
		}

		$key = array_search($listener, $this->events_listeners[$event]);

		if($key !== false && isset($this->events_listeners[$event][$key])) {
			array_splice($this->events_listeners[$event], $key, 1);
		}

		return $this;
	}

	public function trigger($event, $args = array()) {
		if(!isset($this->events_listeners[$event])) {
			return $this;
		}

		foreach($this->events_listeners[$event] as $key => &$listener) {
			call_user_func($this->events_listeners[$event][$key], $this, $args);
		}
		
		return $this;
	}

	public function saveToDb($table_name) {
		if(!empty($this->db_wrapper)) {
			return false;
		}

		$this->trigger('before_save', array('support' => 'database'));

		$res = $this->db_wrapper->insert($table_name, $this->properties);

		$this->trigger('saved', array('support' => 'database'));

		return $res;
	}

	public function saveToFile($file_name) {
		if(!empty($this->db_wrapper)) {
			return false;
		}

		$this->trigger('before_save', array('support' => 'file'));

		$res = file_put_contents($file_name, $this->__toString());
		// $res = file_put_contents($file_name, serialize($this));

		$this->trigger('saved', array('support' => 'file'));

		return $res;
	}

	public function __toString() {
		return json_encode($this->properties);
	}
}