<?php
require_once 'bootstrap.php';
$db = dbconnect();

$username = $_POST['username'];
$mail = $_POST['mail'];
$passwd = hash('sha256', $_POST['passwd']);

$is_valid = true;
if (empty($username)) {
	$_SESSION['error']['username'] = "User name is empty";
	$is_valid = false;
}
if (empty($mail)) {
	$_SESSION['error']['mail'] = "mail address is empty";
	$is_valid = false;
}
if (empty($passwd)) {
	$_SESSION['error']['passwd'] = "empty password is not permitted";
	$is_valid = false;
}

$query = sprintf("SELECT COUNT(*) FROM `users` WHERE `mail` = '%s';", $mail);
$users = $db->query($query);
if ($users->fetchColumn() > 0) {
	$_SESSION['error']['already'] = 'mail address is already used';
	$is_valid = false;
}

if (! $is_valid) return header('Location: /version1/signup.php');

$stmt = $db->prepare(
	'INSERT INTO `users` (`username`, `mail`, `password`, `created_at`, `updated_at`) ' .
	'VALUES (:name, :mail, :pass, NOW(), NOW());');

$stmt->bindValue(':name', $username, PDO::PARAM_STR);
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->bindValue(':pass', $passwd, PDO::PARAM_STR);
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

header("Location: /version1/edit.php?id={$userid}");
