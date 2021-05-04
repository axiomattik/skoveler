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

add_route('GET', '/', function() {
	require 'templates/header.php';
	require 'templates/index.php';
	require 'templates/footer.php';
});

do_route();
