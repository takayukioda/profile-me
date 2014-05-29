<?php require_once 'bootstrap.php'; ?>
<?php
$user_id = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$user_id = $_GET['id'];
} else if (isset($_SESSION['auth']['user_id'])) {
	$user_id = $_SESSION['auth']['user_id'];
}
if ($user_id === null) return header('Location: index.php');
$database_connection = get_connection_to_database();
$query_to_get_all_of_user_information_who_has_same_id_as = sprintf(
	"SELECT * FROM `users` WHERE `id` = %d LIMIT 1;", $user_id);
$execute_result = mysqli_query($database_connection, $query_to_get_all_of_user_information_who_has_same_id_as);
if ($execute_result === false) {
	// user id から情報が検索できなかった
	//  => profile not found ページへ飛ばす
	return header('Location: profile-notfound.php');
}
$user = mysqli_fetch_assoc($execute_result);
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
<h1><?php echo $user['username'];?></h1>
<div class="social-container clearfix">
<ul>
<li>Facebook(dummy)</li>
<li>Twitter(dummy)</li>
<li>GitHub(dummy)</li>
</ul>
</div><!-- .social-container -->
<div class="profile-text">
<?php echo $user['profile']; ?>
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
