<?php
class Model
{
	protected static $_connection = null;
	protected static $_table_name = null;
	protected static $_table_name_cached = array();
	protected static $_primary_key = array('id');
	protected static $_properties = array();
	protected static $_properties_cached = array();
	protected static $_is_new = true;
	protected $_data = array();
	protected $_original = array();
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
			$properties = static::properties();
			if (array_key_exists($prop, $properties)) {
				if (array_key_exists('type', $properties[$prop])) {
					switch ($properties[$prop]['type']) {
					case 'boolean':
						$value = (boolean) $value; break;
					case 'int':
						$value = (int) $value; break;
					case 'double':
						$value = (double) $value; break;
					case 'varchar': // fall-through
					case 'text':
						$value = (string) $value; break;
					default:
						$value = (string) $value; break;
					}
				}
				$this->_data[$prop] = $value;
			} else {
				$this->_custom_data[$prop] = $value;
			}
		}

		return $this;
	}

	public function __construct (array $data = array(), $new = true)
	{
		if ($this->connection() === null) {
			$this->connect();
		}

		if (! empty($this->_data)) {
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

	protected function connect ()
	{
		require_once 'config/database.php';
		if (class_exists('DatabaseConfig')) {
			$config = new DatabaseConfig();
			$config = $config->default;
			$pdo_config = array(
				PDO::ATTR_PERSISTENT => $config['pconnect'],
				PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
			);
			if (! empty($config['encoding'])) {
				$pdo_config[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES ' . $config['encoding'];
			}
			if (! empty($config['socket'])) {
				$dsn = "mysql:host={$config['hostname']};dbname={$config['database']};unix_socket={$config['socket']};";
			} else {
				$dsn = "mysql:host={$config['hostname']};dbname={$config['database']};port={$config['port']};";
			}
			try {
				$this->_connection = new PDO (
					$dsn,
					$config['username'],
					$config['password'],
					$pdo_config
				);
			} catch  (PDOException $e) {
				throw new \Exception ($e->getMessage());
			}
		}
	}

	public static function instance (array $data = array(), $new = true)
	{
		return new static($data, $new);
	}

	public static function primary_key ()
	{
		return static::$_primary_key;
	}

	public static function table ()
	{
		$class = get_called_class();
		if (property_exists($class, static::$_table_name_cached)) return static::$_table_name_cached[$class];
		if (property_exists($class, '_table_name')) {
			static::$_table_name_cached[$class] = $this->_table_name;
		} else {
			static::$_table_name_cached[$class] = strtolower($class);
		}
		return static::$_table_name_cached[$class];
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

	public function connection ()
	{
		$class = get_called_class();

		return property_exists($class, '_connection') ? static::$_connection : null;
	}

	public function is_changed ($prop)
	{
		$properties = static::properties();
		$property = (array) $property ?: array_keys($properties);
		foreach ($properties as $p) {
			if (! isset($properties[$p])) throw new \OutOfBoundsException("Unknown property {$p}");

			if (array_key_exists($p, $this->_original)) {
				if (array_key_exists('type', $properties) and $properties[$p]['type'] == 'int') {
					if ($this->{$p} != $this->_original[$p]) return true;
				} elseif ($this->{$p} !== $this->_original[$p]) {
					return true;
				}
			} elseif (array_key_exists($p, $this->_data)) {
				return true;
			}
		}

		return false;
	}

	protected function _update_original ($original = null) {
		$original = is_null($original) ? $this->_data : $original;
		$this->_original = $original;
	}
}
