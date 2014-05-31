<?php if(!defined('ENVIRONMENT')) die('Direct access not allowed');

class Listenable_Object{
	private properties = array();
	private events_listeners = array();

	public function __construct($properties = array()) {
		$this->properties = $properties;
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

	public function on($event, &$listener) {
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
			call_user_func($this->events_listeners[$event][$key], $args);
		}
		
		return $this;
	}

	public function __toString() {
		return json_encode($this->properties);
	}
}