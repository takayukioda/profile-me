<?php require_once 'bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf8" />
	<title>ProfileMe::Signup</title>
</head>
<body>
	<form method="post" action="user-create.php">
		<table>
		<tr>
		<th>名前:</th><td><input name="username" type="text"/></td>
		<th>メールアドレス:</th><td><input name="mail" type="text"/></td>
		<th>パスワード:</th><td><input name="passwd" type="password"/></td>
	</form>
</body>
</html>
