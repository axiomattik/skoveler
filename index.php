<?php

/*
require 'database.php';

$db = new NovelsDB();
$novel = $db->get_novel(1);

echo "<h1>Skoveler</h1>";
echo "<h2>" . $novel['title'] . "</h2>";
echo "<h2>" . $novel['author'] . "</h2>";

$db->close();
*/

require 'router.php';

function f() {
	echo "Hello, router!";
}

function g() {
	echo "test";
}

add_route('GET', '/', 'f');
add_route('GET', '/test', 'g');

do_route();
