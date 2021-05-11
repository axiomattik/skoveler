<?php

add_route('GET', '/user/{username}', function($query_params, $path_vars) {
	global $user;
	// if target user is current user, render user's settings

	if ( $user->get_username() == $path_vars["username"] ) {
		require 'templates/header.php';
		require 'templates/profile-public.php';
		require 'templates/profile-private.php';
		require 'templates/footer.php';
		die;
	}

	// otherwise, check current user is authorised to view target user's profile
	$target_user = get_user("username = " . $path_vars["username"]);

	function unauthorized() {
		http_response_code(401);
		echo "Error: not authorized to view this user";
		die;
	}

	// guests cannot view other user's profiles
	if ($user->role == "guest") unauthorized();

	// check target user exists
	if ( ! $target_user ) unauthorized();

	// if the current user is an admin or the target user's profile is public
	// then the current user is authorised
	if ( ! 
		( $user->role == "admin" ) | 
		( $target_user->is_public == true ) ) {
		unauthorized();
	}

	$user = $target_user;
	require 'templates/header.php';
	require 'templates/profile-public.php';
	require 'templates/footer.php';
} );


add_route( 'GET', '/login', function() {
	require 'templates/login.php';
} );


add_route( 'POST', '/login', function() {
	global $user;

	verify_nonce();

	$success = $user->login(
		sanitize_text($_POST["username"]);
		// pw doesn't need to be sanitized--it's going straight to hash
		$_POST["password"]; 
	);

	if ( ! $success ) {
		http_response_code(401);
		echo "Error: invalid email or password";
		die;
	}

	http_response_code(303);
	header('Location: /');

} );


add_route('POST', '/logout', function($query_params, $path_vars) {
	global $user;
	$success = $user->logout();
	if ( ! $success ) {
		http_response_code(401);
		die;
	}
	http_response_code(303);
	header('Location: /');
} );


add_route('POST', '/create-account', function($query_params) {
	global $user;

	verify_nonce();

	$error = $user->register(
		sanitize_text($_POST["username"]);
		$_POST["password"];
	);

	if ( $error ) {
		http_response_code(403);
		echo $error;
		die;
	}

	http_response_code(303);
	header('Location: /');

});


