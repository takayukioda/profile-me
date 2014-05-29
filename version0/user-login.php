<?php
require_once 'bootstrap.php';

$database_connection = get_connection_to_database();
if (isset($_SESSION['auth']['loggedin'])) {
	return header('Location: profile.php');
}

$mail = $_POST['mail'];
$password = hash('sha256', $_POST['password']);

$query_to_get_user_who_match_the_mail_and_password_combination = sprintf(
"SELECT * FROM `users` WHERE `mail` = '%s' AND `password` = '%s' LIMIT 1;", $mail, $password);
$execute_result = mysqli_query($database_connection, $query_to_get_user_who_match_the_mail_and_password_combination);

if ($execute_result === false) {
	return header('Location: index.php');
}

$user = mysqli_fetch_assoc($execute_result);
$user->password = null;

$_SESSION['auth'] = array(
	'userid' => $user->id,
	'user' => $user,
	'loggedin' => true,
);

return header('Location: profile.php');
