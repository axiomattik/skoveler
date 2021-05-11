<form action="update-user" method="post">
	<label>username: </label>
	<input type="text" value="<?php echo $user->username; ?>">

	<label>email: </label>
	<input type="text" value="<?php echo $user->email; ?>">

	<a href="/change-password">change password</a>

	<input type="submit" value="update">
</form>
