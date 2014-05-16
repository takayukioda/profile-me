<?php

class DatabaseConfig
{
	const ENV = 'development';
	public $default = null;
	protected $template = array(
		'username' => 'root',
		'hostname' => 'localhost',
		'password' => 'root',
		'database' => 'root',
		'encoding' => 'utf8',
		'port' => 3306,
		'socket' => '',
		'pconnect' => false,
	);
	protected $production = array(
		'username' => '',
		'hostname' => '',
		'password' => '',
		'database' => '',
	);
	protected $development = array(
		'username' => 'profileme',
		'hostname' => 'localhost',
		'password' => 'profile',
		'database' => 'profileme',
		'socket' => '/opt/local/var/run/mysql5/mysqld.sock',
	);

	public function __construct ()
	{
		$env = static::ENV;
		if (property_exists(get_called_class(), $env)) {
			$this->default = array_merge($this->template, $this->{$env});
		} else {
			$this->default = $this->template;
		}
	}
}
