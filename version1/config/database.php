<?php
$socket = '';
if (PHP_OS === 'Darwin') {
	$socket = '/opt/local/var/run/mysql5/mysqld.sock';
}
return array(
	'development' => array(
		'username' => 'profileme',
		'hostname' => 'localhost',
		'password' => 'profile',
		'database' => 'profileme',
		'socket' => $socket,
		'encoding' => 'utf8',
		'port' => 3306,
		'pconnect' => false,
	),
	'production' => array(
		'username' => 'root',
		'hostname' => 'localhost',
		'password' => 'root',
		'database' => 'root',
		'encoding' => 'utf8',
		'port' => 3306,
		'socket' => '',
		'pconnect' => false,
	)
);
