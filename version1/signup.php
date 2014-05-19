<?php require_once 'bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf8" />
	<title>ProfileMe::Signup</title>
	<link rel="stylesheet" href="css/common.css"/>
</head>
<body>
	<form method="post" action="user-create.php">
		<span class="invalid"><?php echo $_SESSION['error']['already'];?></span>
		<table>
		<tr>
		<th>名前:<span class="invalid"><?php echo $_SESSION['error']['username'];?></span></th>
		<td><input name="username" type="text"/></td>
		</tr>
		<tr>
		<th>メールアドレス:<span class="invalid"><?php echo $_SESSION['error']['mail'];?></span></th>
		<td><input name="mail" type="text"/></td>
		</tr>
		<tr>
		<th>パスワード:<span class="invalid"><?php echo $_SESSION['error']['passwd'];?></span></th>
		<td><input name="passwd" type="password"/></td>
		</tr>
		</table>
		<input type="submit" value="Submit" />
	</form>
</body>
</html>
<?php unset($_SESSION['error']); ?>
