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

add_route('GET', '/', f);

do_route();
