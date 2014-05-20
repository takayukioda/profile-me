<?php
require_once 'bootstrap.php';

$db = dbconnect();

if (isset($_SESSION['auth']['loggedin'])) {
	return header('Location: /');
}

if (! isset($_SESSION['auth']['user'])) {
	$userid = $_SESSION['auth']['userid'];
	$stmt = $db->prepare("SELECT * FROM `users` WHERE `id` = '?' LIMIT 1;");
	$stmt->execute(array($userid));
	$user = $stmt->fetchObject();

	if ($user === false) {
		return header('Location: /version1/signin.php');
	}

	$user->password = null;
	$_SESSION['auth'] = array(
		'user' => $user,
		'loggedin' => true,
	);
}
