<?php require_once 'bootstrap.php'; ?>
<html lang="ja">
<head>
<meta charset="utf-8" />
<title>Profile.Me::Signup</title>
<link rel="stylesheet" href="css/normalize.css" />
<link rel="stylesheet" href="css/common.css" />
</head>
<body>
<header class="clearfix">
<span class="header-title pull-left">Logo.here</span>
<div class="sign-action pull-right"><a href="signin.php">Sign in</a></div>
</header>
<div class="container center">
<div class="sign-container">
<div class="title">
<h1>Logo.here</h1>
<p>Make it easier for Geeks to introfuce youself</p>
</div><!-- .title -->
<form action="user-create.php" method="post">
	<div class="form-block">
	<label for="form-username">name <span class="invalid">
		<?php if (isset($_SESSION['error']['username'])) echo $_SESSION['error']['username'];?>
	</span> </label>
	<input type="text" name="username" id="form-username" placeholder="taka"/>
	</div>
	<div class="form-block">
	<label for="form-mail">Email Address <span class="invalid">
		<?php if (isset($_SESSION['error']['mail'])) echo $_SESSION['error']['mail'];?>
	</span></label>
	<input type="email" name="mail" id="form-mail" placeholder="taka@profile.me"/>
	</div>
	<div class="form-block">
	<label for="form-password">Password <span class="invalid">
		<?php if (isset($_SESSION['error']['password'])) echo $_SESSION['error']['password'];?>
	</span></label>
	<input type="password" name="password" id="form-password"/>
	</div>
	<input type="submit" value="join">
</form>
</div><!-- .sign-container -->
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
<?php unset($_SESSION['error']); ?>
