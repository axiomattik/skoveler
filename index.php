<?php

require_once 'vendor/autoload.php';
require 'database.php';

$db = new NovelsDB();
$novel = $db->get_novel(1);

echo "<h1>Skoveler</h1>";
echo php_sapi_name();
echo "<h2>" . $novel['title'] . "</h2>";
echo "<h2>" . $novel['author'] . "</h2>";

$db->close();

require 'router.php';
require 'rest-api.php';

function f() {
	echo "Hello, router!";
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
