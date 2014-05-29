<?php
require_once 'bootstrap.php';
require_once 'auth-check.php';
$database_connection = get_connection_to_database();

$mail = $_POST['mail'];
$profile = $_POST['profile'];

$there_are_no_errors = true;
if (empty($_POST['mail'])) {
	$_SESSION['error']['mail'] = "mail address is empty";
	$there_are_no_errors = false;
}
if (! $there_are_no_errors) {
	$_SESSION['update_status'] = '<span class="info-failed">Update Failed</span>';
	return header('Location: settings.php');
}

$user_id = $_SESSION['auth']['user_id'];

$query_to_update_user_information_who_has_same_id_as = sprintf(
	"UPDATE `users` SET `mail` = '%s', `profile` = '%s' WHERE `id` = %d",
	$mail, $profile, $user_id);
$execute_result = mysqli_query($database_connection, $query_to_update_user_information_who_has_same_id_as);
if ($execute_result === false) {
	// 関数の結果がfalseの場合は失敗なのでエラーメッセージを作成してsettings.phpへ戻す
	$_SESSION['update_status'] = '<span class="info-failed">Update Failed</span>';
	return header('Location: settings.php');
}


$query_to_get_all_of_user_information_who_has_same_id_as = sprintf(
	"SELECT * FROM `users` WHERE `id` = %d LIMIT 1;", $user_id);
$execute_result = mysqli_query($database_connection, $query_to_get_all_of_user_information_who_has_same_id_as);
if ($execute_result === false) {
	// アップデートができていれば失敗するはずのない処理なので、エラーを吐いて強制終了
	die('Oops... Something went wrong!');
}
$user = mysqli_fetch_assoc($execute_result);

$_SESSION['auth']['user'] = $user;

$_SESSION['update_status'] = '<span class="info-succeed">Updated Successfully</span>';

return header('Location: profile.php');
