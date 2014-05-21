<?php require_once 'bootstrap.php'; ?>
<?php
$userid = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$userid = $_GET['id'];
} else if (isset($_SESSION['auth']['userid'])) {
	$userid = $_SESSION['auth']['userid'];
}
if ($userid === null) return header('Location: index.php');
$db = dbconnect();
$stmt = $db->prepare("SELECT * FROM `users` WHERE `id` = ? LIMIT 1;");
$stmt->execute(array($userid));
$user = $stmt->fetchObject();

if ($user === false) {
	return header('Location: profile-notfound.php');
}
?>
<html lang="ja">
<head>
<meta charset="utf-8" />
<title>Profile.Me::Singin</title>
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
<div class="profile-container clearfix">
<h1><?php echo $user->username;?></h1>
<div class="social-container clearfix">
<ul>
<li>Facebook</li>
<li>Twitter</li>
<li>GitHub</li>
</ul>
</div><!-- .social-container -->
<div class="profile-text">
<?php echo $user->profile; ?>
</div><!-- .profile-text -->
</div><!-- .profile-container" -->
</div><!-- .container -->
<footer>
<p>
	<a href="index.php">HOME</a>
	<span class="separator">&nbsp;</span>
	<a href="#">Follow Us on Twitter</span>
</p>
</footer>
</body>
</html>
