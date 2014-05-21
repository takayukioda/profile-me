<?php
require_once 'bootstrap.php';

$db = dbconnect();
if (isset($_SESSION['auth']['loggedin'])) {
	return header('Location: profile.php');
}

$userid = $_SESSION['auth']['userid'];
$stmt = $db->prepare("SELECT * FROM `users` WHERE `id` = '?' LIMIT 1;");
$stmt->execute(array($userid));
$user = $stmt->fetchObject();

if ($user === false) {
	return header('Location: index.php');
}

$user->password = null;
$_SESSION['auth'] = array(
	'userid' => $userid,
	'user' => $user,
	'loggedin' => true,
);

return header('Location: profile.php');
