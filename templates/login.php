<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login</title>

</head>

<body>

	<h2>Login</h2>

	<form id="login-form" action="/login" method="post">
		<?php do_nonce(); ?>
		<input type="username" name="username">
		<input type="password" name="password">
		<input type="submit" value="Log In">
	</form>

	<hr>

	<h2>Create Account</h2>

	<form id="register-form" action="/register" method="post">
		<?php do_nonce(); ?>
		<input type="username" name="username">
		<input type="password" name="password">
		<input type="submit" value="Create Account">
	</form>

</body>

</html>

</body>

</html>
