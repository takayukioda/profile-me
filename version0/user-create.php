<?php
require_once 'bootstrap.php';
$database_connection = get_connection_to_database();

// there_are_no_errors が true であれば問題無し。false であればエラー発生
$there_are_no_errors = true;

// 以下の "if (empty" で始まる3つのブロックは必須項目が空でないかの判定
if (empty($_POST['username'])) {
	// usernameは必須項目なので、空の場合はエラーメッセージを保存
	$_SESSION['error']['username'] = "User name is empty";
	$there_are_no_errors = false;
}
if (empty($_POST['mail'])) {
	// mailは必須項目なので、空の場合はエラーメッセージを保存
	$_SESSION['error']['mail'] = "mail address is empty";
	$there_are_no_errors = false;
}
if (empty($_POST['password'])) {
	// passwordは必須項目なので、空の場合はエラーメッセージを保存
	$_SESSION['error']['password'] = "empty password is not permitted";
	$there_are_no_errors = false;
}

// 
$username = $_POST['username'];
$mail = $_POST['mail'];
// パスワードをそのまま(平文で)データベースに保存するのは良くないので、 sha256 と呼ばれる方式でハッシュ化
$password = hash('sha256', $_POST['password']);


$query_to_ask_whether_same_mailaddress_exists = sprintf("SELECT * FROM `users` WHERE `mail` = '%s';", $mail);
$result = mysqli_query($database_connection, $query_to_ask_whether_same_mailaddress_exists);
if (mysqli_num_rows($result) > 0) {
	// 返ってきたユーザーデータが存在する(1つ以上値が返ってきた)
	// => 同じメールアドレスは登録できないのでエラーを返す
	$_SESSION['error']['already'] = 'mail address is already used';
	$there_are_no_errors = false;
}

// エラーが発生していたら index.php へ戻る
if (! $there_are_no_errors) return header('Location: index.php');
$query_to_insert_new_data_to_users_table = sprintf(
	"INSERT INTO `users` (`username`, `mail`, `password`, `created_at`, `updated_at`) VALUES ('%s', '%s', '%s', NOW(), NOW());",
	$username, $mail, $password);

$execute_result = mysqli_query($database_connection, $query_to_insert_new_data_to_users_table);
if ($execute_result === false) {
	// 関数の結果がfalseの場合は失敗なので強制終了
	die('Something went wrong during Insertation');
}
// 直近のqueryで作られたIDを取得
// => 今作ったユーザーのIDが取得できる
$user_id = mysqli_insert_id($database_connection);

$query_to_get_user_who_match_the_mail_and_password_combination = sprintf(
"SELECT * FROM `users` WHERE `mail` = '%s' AND `password` = '%s' LIMIT 1;", $mail, $password);
$execute_result = mysqli_query($database_connection, $query_to_get_user_who_match_the_mail_and_password_combination);
$user = mysqli_fetch_assoc($execute_result);
$user['password'] = null;


$_SESSION['auth'] = array(
	'loggedin' => true,
	'user_id' => $user_id,
	'user' => $user,
);

header("Location: settings.php");
