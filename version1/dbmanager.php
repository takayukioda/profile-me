<?php
function dbconnect ()
{
	$included = include_once('config/database.php');
	if ($included === false) {
		$included = include_once('../config/database.php');
	}
	$config = $dbconfig['development'];
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
		$dsn = "mysql:host={$config['hostname']};dbname={$config['database']};";
	}
	try {
		return new PDO (
			$dsn,
			$config['username'],
			$config['password'],
			$pdo_config
		);
	} catch  (PDOException $e) {
		throw new \Exception ($e->getMessage());
	}
}
