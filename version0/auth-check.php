<?php
require_once 'bootstrap.php';
$database_connection = get_connection_to_database();

if (! $_SESSION['auth']['loggedin']) {
	// もしログインした記録が無ければサインインページへ飛ばす
	unset($database_connection);
	return header('Location: signin.php');
}

if (! isset($_SESSION['auth']['user_id'])) {
	// もしユーザーIDが無ければサインインページへ飛ばす
	unset($database_connection);
	return header('Location: signin.php');
}

unset($database_connection);
