<?php require_once 'bootstrap.php'; ?>
<?php require_once 'auth-check.php'; ?>
<?php
$userid = $_SESSION['auth']['userid'];
$db = dbconnect();
$stmt = $db->prepare("SELECT * FROM `users` WHERE `id` = ? LIMIT 1;");
$stmt->execute(array($userid));
$user = $stmt->fetchObject();

if ($user === false) {
	return header('Location: index.php');
}
?>
<html lang="ja">
<head>
<meta charset="utf-8" />
<title>Profile.Me::Settings</title>
<link rel="stylesheet" href="css/normalize.css" />
<link rel="stylesheet" href="css/common.css" />
</head>
<body>
<header class="clearfix">
<span class="header-title pull-left">Logo.here</span>
<nav class="pull-left">
<ul>
	<li><a href="profile.php">My Profile</a></li>
	<li><a href="settings.php">Settings</a></li>
</ul>
</nav>
<div class="sign-action pull-right"><a href="user-logout.php">Sign out</a></div>
</header>
<div class="container">
<div class="settings-container">
<h1>Settings</h1>
<h2><?php echo $user->username;?></h2>
<form action="user-edit.php" method="post" enctype="multipart/form-data">
<?php if (isset($_SESSION['update_status'])) echo $_SESSION['update_status']; ?>
	<div style="display:block">
	<span class="label">nickname</span>
	<?php echo $user->username;?>
	</div>
	<div class="form-block">
	<label for="form-mail">Email Address</label>
	<input type="email" name="mail" id="form-mail" value="<?php echo $user->mail;?>"/>
	</div>
	<div class="form-block">
	<label for="form-profile">Profile</label>
	<textarea name="profile" id="form-profile" cols="50" rows="5"><?php echo $user->profile;?></textarea>
	</div>
	<div class="form-block">
	<label for="form-facebook">Facebook</label>
	<input type="text" name="facebook" id="form-facebook"/>
	</div>
	<div class="form-block">
	<label for="form-twitter">Twitter</label>
	<input type="text" name="twitter" id="form-twitter"/>
	</div>
	<div class="form-block">
	<label for="form-github">GitHub</label>
	<input type="text" name="github" id="form-github"/>
	</div>
<!--
	<div class="form-block">
	<label for="form-background">Background Image</label>
	<input type="file" name="background" id="form-background"/>
	</div>
-->
	<input type="submit" value="join">
</form>
</div><!-- .settings-container -->
</div><!-- .container -->
<footer>
<p>
	<a href="index.php">HOME</a>
	<span class="separator">&nbsp;</span>
	<a href="#">Follow Us on Twitter</span>
	<span class="separator">&nbsp;</span>
</p>
</footer>
</body>
</html>
<?php unset($_SESSION['update_status']);?>
