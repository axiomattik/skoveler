<?php

$routes = array(
	'GET' => array(),
	'HEAD' => array(),
	'POST' => array(),
	'PUT' => array(),
	'DELETE' => array(),
	'OPTIONS' => array(),
	'PATCH' => array()
);

function add_route($method, $path, $action) {
	global $routes;
	if ( ! array_key_exists( $method, $routes ) ) {
		$routes[$method] = array();
	}
	$routes[$method][$path] = $action;
}

function do_route() {
	global $routes;
	$method = $_SERVER['REQUEST_METHOD'];
	$path = $_SERVER['REQUEST_URI'];

	if ( ! array_key_exists( $method, $routes ) ) {
		throw new Exception("Unsupported HTTP method: $method");
	}

	if ( ! array_key_exists( $path, $routes[$method] ) ) {
		throw new Exception("Route not defined: $method $path");
	}

	$routes[$method][$path]();
}
