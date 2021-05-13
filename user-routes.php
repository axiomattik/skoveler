<?php

function setup_user_routes($router) {

	$router->add( 'GET', '/login', function() {
		global $user;
		if ( $user->get_role() == "guest" ) {
			require 'templates/header.php';
			require 'templates/login.php';
			require 'templates/footer.php';
		} else {
			http_response_code(303);
			header('Location: /');
		}
	} );


	$router->add( 'POST', '/login', function() {
		global $user;

		verify_nonce();

		$success = $user->login(
			sanitize_text($_POST["username"]),
			// pw doesn't need to be sanitized--it's going straight to hash
			$_POST["password"],
		);

		if ( ! $success ) {
			http_response_code(401);
			echo "Error: unrecognised username or wrong password";
			die;
		}

		http_response_code(303);
		header('Location: /');

	} );


	$router->add( 'POST', '/logout', function() {
		global $user;

		verify_nonce();

		$success = $user->logout();
		if ( ! $success ) {
			http_response_code(401);
			die;
		}

		http_response_code(303);
		header('Location: /');
	} );

	
	$router->add( 'POST', '/register', function() {
		global $user;

		verify_nonce();

		if ( $user->get_role() != "guest" ) {
			$error = "Error: this user already has an account";

		} else {
			$error = $user->register(
				sanitize_text($_POST["username"]),
				$_POST["password"],
			);
		}

		if ( $error ) {
			http_response_code(403);
			echo $error;
			die;
		}

		http_response_code(303);
		header('Location: /');

	});

	
	$router->add( 'GET', '/password', function() {
		global $user;
		require 'templates/header.php';
		require 'templates/password.php';
		require 'templates/footer.php';
	});


	
	$router->add( 'POST', '/password', function() {
		global $user;

		verify_nonce();

		$old = $_POST["old"];
		$new = $_POST["new"];
		$new_confirm = $_POST["new-confirm"];

		if ( ! $user->login($user->get_username(), $old) ) {
			http_response_code(401);
			echo $user->get_username() . " " . $old;
			echo "<br>";
			echo "Error: unauthorized";
			die;
		}

		if ( $new != $new_confirm ) {
			http_response_code(400);
			echo "Error: passwords do not match";
			die;
		}

		if ( ! validate_password($new) ) {
			http_response_code(400);
			echo "Error: not a valid password";
			die;
		}

		$user->set_password($new);

		http_response_code(203);

	});



}

/*

/*
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

*/


