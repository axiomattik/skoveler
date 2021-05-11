<?php


function timestamp_age($timestamp) {
	// returns seconds that have passed since timestamp
	$then = new DateTime($timestamp);
	$now = new DateTime(gmdate("Y-m-d H:i:s"));
	$delta = (int)$now->format("U") - (int)$then->format("U");
	return $delta;
}


function generate_key($length) {
	$chars = "abcdefghijklmnopqrstuvwxyz123456789";
	$key = "";
	for ($i = 0; $i < $length; $i++) {
		$key .= $chars[random_int(0, strlen($chars)-1)];
	}
	return $key;
}


function do_nonce() {
	global $db;
	$key = $_COOKIE["secret"];
	$nonce = hash('sha512', generate_key(64));
	$db->store_nonce($key, $nonce);
	return $nonce;
}


function verify_nonce() {
	global $db;

	function reject() {
		http_response_code(403);
		echo "Error: could not verify nonce";
		die;
	}

	$nonce = $_POST["nonce"];
	if ( !$nonce ) reject();

	$key = $_COOKIE["secret"];
	$retrieved_nonce = $db->get_nonce($key, $nonce);

	if ( ! $retrieved_nonce ) reject();

	$age = timestamp_age($retrieved_nonce['created']);
	if ( $age < 1 || $age > 3600 ) {
		$db->delete_nonce($key, $nonce);
		reject();
	}

	$db->delete_nonce($key, $nonce);
	return true;
}


function sanitize_text($s, $exceptions="") {
	return preg_replace("/[^a-zA-Z0-9$exceptions]/", '', trim($s));
}


function sanitize_username($s) {
	// allow only alphanumeric, hyphens and underscores
	return preg_replace("/[^a-zA-Z0-9-_]/", '', trim($s));
}


function sanitize_email($s) {
	return filter_var($s, FILTER_SANITIZE_EMAIL);
}


function validate_username($s) {
	if ( strlen($s) == 0 ) return false;
	if ( strlen($s) > 254 ) return false;
	return true;
}


function validate_password($s) {
	if ( strlen($s) < 8 ) return false;
	return true;
}


function validate_email($s) {
	return filter_var($s, FILTER_VALIDATE_EMAIL);
}
