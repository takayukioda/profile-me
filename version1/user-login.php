<?php
require_once 'bootstrap.php';

$db = dbconnect();
if (isset($_SESSION['auth']['loggedin'])) {
	return header('Location: profile.php');
}

$mail = $_POST['mail'];
$password = hash('sha256', $_POST['password']);

$stmt = $db->prepare("SELECT * FROM `users` WHERE `mail` = ? AND `password` = ? LIMIT 1;");
$stmt->execute(array($mail, $password));
$user = $stmt->fetchObject();

if ($user === false) {
	return header('Location: index.php');
}

$user->password = null;
$_SESSION['auth'] = array(
	'userid' => $user->id,
	'user' => $user,
	'loggedin' => true,
);

return header('Location: profile.php');
