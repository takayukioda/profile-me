<html lang="ja">
<head>
<meta charset="utf-8" />
<title>Profile.Me::Settings</title>
<link rel="stylesheet" href="normalize.css" />
<link rel="stylesheet" href="common.css" />
</head>
<body>
<header class="clearfix">
<span class="header-title pull-left">Logo.here</span>
<nav class="pull-left">
<ul>
	<li><a href="/profile.php">My Profile</a></li>
	<li><a href="/settings.php">Settings</a></li>
</ul>
</nav>
<div class="sign-action pull-right"><a href="/signout.php">Sign out</a></div>
</header>
<div class="container">
<h1>Settings</h1>
<h2>Takayuki Oda</h1>
<form action="user-edit.php" method="post" enctype="multipart/form-data">
	<div class="form-block">
	<label for="form-nickname">nickname</label>
	<input type="text" name="nickname" id="form-nickname" value="<?= $user->name; ?>"/>
	</div>
	<div class="form-block">
	<label for="form-mail">Email Address</label>
	<input type="email" name="mail" id="form-mail" value="<?= $user->mail; ?>"/>
	</div>
	<div class="form-block">
	<label for="form-profile">Profile</label>
	<textarea name="profile" id="form-profile" cols="80" rows="5"><?= $user->profile; ?></textarea>
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
	<div class="form-block">
	<label for="form-background">Background Image</label>
	<input type="file" name="background" id="form-background"/>
	</div>
	<input type="submit" value="join">
</form>
</div><!-- .container -->
<footer>
<p>
	<a href="/">HOME</a>
	<span class="separator">&nbsp;</span>
	<a href="#">Follow Us on Twitter</span>
	<span class="separator">&nbsp;</span>
</p>
</footer>
</body>
</html>
