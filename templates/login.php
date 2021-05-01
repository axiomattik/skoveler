<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login</title>

<style>
form {
	display: flex;
	gap: 0.5rem;
	flex-direction: column;
	width: 20rem;
}

</style>

</head>

<body>

	<p>Current secret: <?php echo $_COOKIE["secret"]; ?></p>

	<h2>Login</h2>

	<form action="/login" method="post">
		<input type="hidden" name="nonce" value="<?php echo do_nonce() ?>">
		<input type="email" name="email">
		<input type="password" name="password">
		<input type="submit" value="Log in">
	</form>

	<hr>

	<h2>Register</h2>

	<form action="/register" method="post">
		<input type="hidden" name="nonce" value="<?php echo do_nonce() ?>">
		<input type="email" name="email">
		<input type="password" name="password">
		<input type="submit" value="Register">
	</form>

	<hr>

	<h2>Logout</h2>

	<form action="/logout" method="post">
		<input type="submit" value="Log Out">
	</form>


</body>

</html>

</body>

</html>
