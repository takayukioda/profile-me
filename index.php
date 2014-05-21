<html lang="ja">
<head>
<meta charset="utf-8" />
<title>Profile.Me::Signup</title>
<link rel="stylesheet" href="normalize.css" />
<link rel="stylesheet" href="common.css" />
</head>
<body>
<header class="clearfix">
<span class="header-title pull-left">Logo.here</span>
<div class="sign-action pull-right"><a href="/signin.php">Sign in</a></div>
</header>
<div class="container center">
<div class="title">
<h1>Logo.here</h1>
<p>Make it easier for Geeks to introfuce youself</p>
</div><!-- .title -->
<form action="user-create.php" method="post">
	<div class="form-block">
	<label for="form-nickname">nickname</label>
	<input type="text" name="nickname" id="form-nickname" placeholder="taka"/>
	</div>
	<div class="form-block">
	<label for="form-mail">Email Address</label>
	<input type="email" name="mail" id="form-mail" placeholder="taka@profile.me"/>
	</div>
	<div class="form-block">
	<label for="form-password">Password</label>
	<input type="password" name="password" id="form-password"/>
	</div>
	<input type="submit" value="join">
</form>
</div><!-- .container -->
<footer>
<p>
	<a href="/">HOME</a>
	<span class="separator">&nbsp;</span>
	<a href="#">Follow Us on Twitter</span>
</p>
</footer>
</body>
</html>
