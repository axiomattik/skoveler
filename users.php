<?php

class User {
	public $key;
	public $username;
	public $email;
	public $role;


	function __construct($key) {
		global $db;
		$retrieved_user = $db->get_user("key = \"$this->key\"");
		if ( ! $retrieved_user ) {
			$retrieved_user = $db->add_user($key);
		}

		$this->key = $key;
		$this->username = $retrieved_user["username"];
		$this->email = $retrieved_user["email"];
		$this->role = $retrieved_user["role"];
	}


	function set_username($username) {
		global $db;
		$db->update_user(array(
			"username" => $username
		));
		$this->username = $username;
	}


	function set_email($email) {
		global $db;
		$db->update_user(array(
			"email" => $email
		));
		$this->email = $email;
	}


	function set_role($role) {
		global $db;
		return $db->update_user(array(
			"role" => $role
		));
		$this->role = $role;
	}


	function set_key($key) {
		global $db;
		$db->update_user(array(
			"key" => $key
		));
		$this->key = $key;
	}


	function set_password($password) {
		global $db;
		$passhash = password_hash($password, PASSWORD_DEFAULT);
		$db->update_user(array(
			"passhash" => $passhash
		));
	}


	function update($values) {
		global $db;
		$db->update_user($this->key, $values);
		$this->__construct($this->key);
	}
}


function set_secret($key) {
	setcookie("secret", $key, array(
		"secure" => true,
		"httponly" => true,
		"samesite" => "Strict",
	));
}


function delete_secret() {
	setcookie("secret", "", 1);
}


function create_guest() {
	global $db;
	$key = generate_key(32);
	set_secret($key);
	return $key;
}


function get_user() {
	if ( ! isset($_COOKIE["secret"]) ) {
		$key = create_guest();
	} else {
		$key = $_COOKIE["secret"];
	}
	return new User($key);
}


add_route('GET', '/user/{username}', function($query_params, $path_vars) {
	// if target user is current user, render user's settings
	$user = get_user();
	if ( $user->username == $path_vars["username"] ) {
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
	global $db;

	if ( ! verify_nonce( $_POST["nonce"] ) ) {
		http_response_code(403);
		echo "Error: could not verify nonce";
		die;
	}

	$username = sanitize_email($_POST["username"]);
	$password = $_POST["password"];

	$user = $db->get_user("username = \"$username\"");

	if ( ! password_verify($password, $user["passhash"]) ) {
		http_response_code(401);
		echo "Error: invalid email or password";
		die;
	}

	set_secret($user["key"]);
	http_response_code(303);
	header('Location: /');

} );


add_route('POST', '/logout', function($query_params, $path_vars) {
	if ( ! isset( $_COOKIE["secret"] ) ) {
		http_response_code(401);
		die;
	}
	delete_secret();
	http_response_code(303);
	header('Location: /');
} );


add_route('POST', '/create-account', function($query_params) {
	global $db;

	if ( ! verify_nonce( $_POST["nonce"] ) ) {
		http_response_code(403);
		echo "Error: could not verify nonce";
		die;
	}

	$username = sanitize_email($_POST["username"]);
	$password = $_POST["password"];
	$passhash = password_hash($password, PASSWORD_DEFAULT);

	if ( ! validate_username($username) ) {
		http_response_code(403);
		echo "Error: invalid username";
		die;
	}

	if ( ! validate_password($password) ) {
		http_response_code(403);
		echo "Error: invalid password";
		die;
	}

	if ( $db->get_user("username = \"$username\"") ) {
		http_response_code(403);
		echo "Error: username already exists";
		die;
	}

	$user = get_user($_COOKIE["secret"]);

	$user->update(array(
		"username" => $username,
		"passhash" => $passhash,
		"role" => "user"
	));

	http_response_code(303);
	header('Location: /');
});

