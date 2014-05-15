<?php

class Model
{
	protected static $_initialized = false;
	protected static $_connection = array();
	protected static $_table_name = null;
	protected static $_primary_key = array('id');
	protected static $_properties = array();
	protected static $_properties_cached = array();
	protected static $_is_new = true;
	protected $_data = array();
	protected $_original_data = array();
	protected $_custom_data = array();

	public function __isset ($prop)
	{
		if (array_key_exists($prop, static::properties())) return true;
		if (array_key_exists($prop, $this->_custom_data)) return true;

		return false;
	}

	public function & __get ($prop)
	{
		return $this->get($prop);
	}

	public function & get ($prop)
	{
		$result = null;
		if (array_key_exists($prop, static::properties())) {
			if (array_key_exists($prop, $this->_data)) {
				$result =& $this->_data[$prop];
			}
		} elseif (array_key_exists($prop, $this->_custom_data)) {
			$result =& $this->_data[$prop];
		}
		return $result;
	}

	public function __set ($prop, $value)
	{
		return $this->set($prop, $value);
	}

	public function set ($prop, $value = null) {
		if (is_array($prop)) {
			foreach ($prop as $p => $v) {
				$this->set($p, $v);
			}
		} else {
			if (func_num_args() < 2) throw new \InvalidArgumentException;
			if (in_array($prop, static::primary_key())) throw new \InvalidArgumentException;
			if (array_key_exists($prop, static::properties())) {
				$this->_data[$prop] = $value;
			} else {
				$this->_custom_data[$prop] = $value;
			}
		}

		return $this;
	}

	protected function __construct (array $data = array(), $new = true)
	{
		if (! empty($this->_data) {
			$data = array_merge($this->data, $data);
			$this->_data = array();
			$new = false;
		}
		$properties = $this->properties();
		foreach ($properties as $prop => $settings) {
			if (array_key_exists($prop, $data)) {
				$this->_data[$prop] = $data[$prop];
				unset($data[$prop]);
			} elseif ($new and array_key_exists('default', $settings)) {
				$this->_data[$prop] = $settings['default'];
			}
			$this->_custom_data = $data;
			
			if ($new === false) {
				$this->_update_original($this->_data);
				$this->_is_new = false;
			}
		}
	}

	public static function instance (array $data = array(), $new = true)
	{
		if (
		return new static($data, $new);
	}

	public static function primary_key ()
	{
		return static::$_primary_key;
	}

	public static function properties ()
	{
		$class = get_called_class();
		if (array_key_exists($class, static::$_properties_cached)) {
			return static::$_properties_cached[$class];
		}

		if (property_exists($class, '_properties')) {
			$properties = static::$_properties;
			foreach ($properties as $key => $prop) {
				if (is_string($prop)) {
					unset($properties[$key]);
					$properties[$prop] = array();
				}
			}
		}

		if (empty($properties)) {
			throw new \Exception;
		}

		static::$_properties_cached[$class] = $properties;
		return static::$_properties_cached[$class];
	}
}
