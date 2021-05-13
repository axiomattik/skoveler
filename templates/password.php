<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login</title>

</head>

<body>

	<h2>Change Password</h2>

	<form id="password-form" action="/password" method="post">
		<?php do_nonce(); ?>
		<input type="password" name="old">
		<input type="password" name="new">
		<input type="password" name="new-confirm">
		<input type="submit" value="Change Password">
	</form>

</body>

</html>

</body>

</html>
