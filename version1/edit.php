<?php require_once 'bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf8" />
	<title>ProfileMe::Signup</title>
	<link rel="stylesheet" href="css/common.css"/>
</head>
<body>
	<form method="post" action="user-edit.php">
		<span class="invalid"><?php echo $_SESSION['error']['already'];?></span>
		<table>
		<tr>
		<th>名前:</th>
		<td><input name="username" type="text"/></td>
		</tr>
		<tr>
		<th>メールアドレス:</th>
		<td><input name="mail" type="text"/></td>
		</tr>
		<tr>
		<th>パスワード:</th>
		<td><input name="passwd" type="password"/></td>
		</tr>
    <tr><th>自己PR</th></tr>
    <tr><td><textarea name="self-pr" ></textarea></td></tr>
		</table>
		<input type="submit" value="Submit" />
	</form>
</body>
</html>
<?php unset($_SESSION['error']); ?>
