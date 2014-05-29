<?php
// socketはデフォルトは空
$socket = '';
if (PHP_OS === 'Darwin') {
	// MacOSXはLinuxとは違う所にあったりするので個別に設定
	$socket = '/opt/local/var/run/mysql5/mysqld.sock';
}
$dbconfig =  array(
	'username' => 'profileme',
	'hostname' => 'localhost',
	'password' => 'profile',
	'database' => 'profileme',
	'socket' => $socket,
	'port' => 3306,
);
function get_connection_to_database ()
{
	$dblink = mysqli_connect(
		$dbconfig['hostname'],
		$dbconfig['username'],
		$dbconfig['password'],
		$dbconfig['database']
		$dbconfig['port'],
		$dbconfig['socket'],
	);

	if (! $dblink) {
		// databaseへのリンクが空の場合はエラーなのでエラーを表示して強制終了
		$error_message = sprintf('Connect Error (%s) %s', mysqli_connect_errno(), mysqli_connect_error());
		die($error_message);
	}

	// ここまで到達している => 強制終了していない => $dblinkがあるのでそれを渡してあげる
	return $dblink;
}
