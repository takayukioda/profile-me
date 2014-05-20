<?php require_once 'bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf8" />
	<title>ProfileMe::Signin</title>
	<link rel="stylesheet" href="css/common.css"/>
</head>
<body>
	<form method="post" action="user-create.php">
		<span class="invalid"><?php echo $_SESSION['error']['already'];?></span>
		<table>
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
