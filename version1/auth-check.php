<?php
require_once 'bootstrap.php';
$db = dbconnect();

if (! $_SESSION['auth']['loggedin']) {
	unset($db);
	return header('Location: signin.php');
}

if (! isset($_SESSION['auth']['userid'])) {
	unset($db);
	return header('Location: signin.php');
}

if (! isset($_SESSION['auth']['user'])) {
	$userid = $_SESSION['auth']['userid'];
	$stmt = $db->prepare("SELECT * FROM `users` WHERE `id` = ? LIMIT 1;");
	$stmt->execute(array($userid));
	$user = $stmt->fetchObject();

	if ($user === false) {
		unset($db);
		return header('Location: index.php');
	}

	$user->password = null;
	$_SESSION['auth'] = array(
		'userid' => $userid,
		'user' => $user,
		'loggedin' => true,
	);
}

unset($db);
