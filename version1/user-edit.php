<?php
require_once 'bootstrap.php';
require_once 'auth-check.php';
$db = dbconnect();

$mail = $_POST['mail'];
$profile = $_POST['profile'];
$facebook = $_POST['facebook'];
$twitter = $_POST['twitter'];
$github = $_POST['github'];

$is_valid = true;
if (empty($_POST['mail'])) {
	$_SESSION['error']['mail'] = "mail address is empty";
	$is_valid = false;
}
if (! $is_valid) {
	$_SESSION['update_status'] = '<span class="info-failed">Update Failed</span>';
	return header('Location: settings.php');
}

$userid = $_SESSION['auth']['userid'];
try {
	$db->beginTransaction();
	$stmt = $db->prepare("UPDATE `users` SET `mail` = :mail, `profile` = :profile WHERE `id` = :id");
	$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
	$stmt->bindValue(':profile', $profile, PDO::PARAM_STR);
	$stmt->bindValue(':id', $userid, PDO::PARAM_INT);
	$stmt->execute();
	$db->commit();

} catch (PDOException $e) {
	$db->rollback();
	$_SESSION['update_status'] = '<span class="info-failed">Update Failed</span>';
	return header('Location: settings.php');
}

$stmt = $db->prepare("SELECT * FROM `users` WHERE `id` = ? LIMIT 1;");
$stmt->execute(array($userid));
$user = $stmt->fetchObject();
$_SESSION['auth']['user'] = $user;

$_SESSION['update_status'] = '<span class="info-succeed">Updated Successfully</span>';
return header('Location: profile.php');
