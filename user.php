<?php

class User {

	public $key;

	private $username;
	private $email;
	private $role;


	function __construct($key=null) {
		global $db;

		$this->role = "guest"; // assume guest until proven otherwise

		// if $key is provided, create a User object identified by $key
		if ( ! is_null( $key ) ) {
			$this->key = $key;
			
		// otherwise either use the key stored in the cookie
		} else {
			if ( isset($_COOKIE["userkey"]) ) {
				$this->key = $_COOKIE["userkey"];
			} else {

			// or generate and store a new key to identify a guest account
			// add add a new guest user to db
				$this->key = generate_key(32);
				$this->_set_cookie();
				$db->add_user($this->key);
			}
		} 

		$retrieved_user = $db->get_user("key = \"$this->key\"");
		if ( ! $retrieved_user ) {
			$retrieved_user = $db->add_user($key);
		} else {
			$this->username = $retrieved_user["username"];
			$this->email = $retrieved_user["email"];
			$this->role = $retrieved_user["role"];
		}
	}


	function _set_cookie() {
		setcookie("userkey", $this->key, array(
			"secure" => true,
			"httponly" => true,
			"samesite" => "Strict",
		));
	}


	function _delete_cookie() {
		setcookie("userkey", "", 1);
	}


	function get_username() {
		return $this->username;
	}


	function get_email() {
		return $this->email();
	}


	function get_role() {
		return $this->role();
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


	function login($username, $password) {
		global $db;
		$user = $db->get_user("username = \"$username\"");
		if ( ! password_verify($password, $user["passhash"]) ) {
			return false;
		}
		$this->_set_cookie($user["key"]);
	}


	function logout() {
		if ( ! isset( $_COOKIE["userkey"] ) ) return false;
		$this->_delete_cookie();
		return true;
	}


	function register($username, $password, $role="user") {
		global $db;

		if ( ! validate_username($username) ) {
			return "Error: invalid username";
		}

		if ( ! validate_password($password) ) {
			return "Error: invalid password";
		}

		if ( $db->get_user("username = \"$username\"") ) {
			return "Error: username already exists";
		}

		$passhash = password_hash($password, PASSWORD_DEFAULT);

		$this->update(array(
			"username" => $username,
			"passhash" => $passhash,
			"role" => $role
		));
	}
}



