<?php
/* serve static files in development */
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|svg)$/', $_SERVER["REQUEST_URI"])) {
	return false;    // serve the requested resource as-is.
}

require_once 'vendor/autoload.php';
require_once 'sanitize-validate.php';
require_once 'db/database.php';
require_once 'router.php';
require_once 'user.php';
require_once 'user-routes.php';
//require_once 'rest-api.php';

$db = new NovelsDB("./db/novels.db");
$router = new Router();
$user = new User();

$router->add('GET', '/', function() {
	global $user;
	require 'templates/header.php';
	require 'templates/index.php';
	echo "<pre>";
	echo "username: " . $user->get_username() . "\n";
	echo "email: " . $user->get_email() . "\n";
	echo "role: " . $user->get_role() . "\n";
	echo "key: " . $user->get_key() . "\n";
	echo "</pre>";
	require 'templates/footer.php';
});

setup_user_routes($router);

$router->run();
