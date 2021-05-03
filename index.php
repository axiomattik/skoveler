<?php
/* serve static files in development */
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|svg)$/', $_SERVER["REQUEST_URI"])) {
	return false;    // serve the requested resource as-is.
}

require_once 'vendor/autoload.php';
require_once 'db/database.php';
require_once 'sanitize-validate.php';
require_once 'router.php';
require_once 'users.php';
require_once 'rest-api.php';

$db = new NovelsDB("./db/novels.db");

function f() {
	require 'templates/header.php';
	echo "Hello, router!";
	require 'templates/footer.php';
}

function g() {
	echo "test";
}

add_route('GET', '/', 'f');
add_route('GET', '/test', 'g');
add_route('GET', '/test/{id}', function($query_params, $path_vars) {
	echo "\n";
	print_r( $path_vars );
	echo "\n";
} );

do_route();
