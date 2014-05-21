<?php
require_once 'bootstrap.php';
$db = dbconnect();

$is_valid = true;
if (empty($_POST['username'])) {
	$_SESSION['error']['username'] = "User name is empty";
	$is_valid = false;
}
if (empty($_POST['mail'])) {
	$_SESSION['error']['mail'] = "mail address is empty";
	$is_valid = false;
}
if (empty($_POST['password'])) {
	$_SESSION['error']['password'] = "empty password is not permitted";
	$is_valid = false;
}

$username = $_POST['username'];
$mail = $_POST['mail'];
$password = hash('sha256', $_POST['password']);


$query = sprintf("SELECT COUNT(*) FROM `users` WHERE `mail` = '%s';", $mail);
$users = $db->query($query);
if ($users->fetchColumn() > 0) {
	$_SESSION['error']['already'] = 'mail address is already used';
	$is_valid = false;
}

if (! $is_valid) return header('Location: index.php');

$stmt = $db->prepare(
	'INSERT INTO `users` (`username`, `mail`, `password`, `created_at`, `updated_at`) ' .
	'VALUES (:name, :mail, :pass, NOW(), NOW());');
$stmt->bindValue(':name', $username, PDO::PARAM_STR);
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->bindValue(':pass', $password, PDO::PARAM_STR);

try {
	$stmt->execute();
	$userid = $db->lastInsertId();
} catch (PDOException $e) {
	echo $e->getMessage();
	die();
}

$_SESSION['auth'] = array(
	'loggedin' => true,
	'userid' => $userid,
);
header("Location: settings.php");
