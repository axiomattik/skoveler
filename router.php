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



function path_matches($path, $pattern, &$vars) {
	$path_parts = explode('/', $path);
	$pattern_parts = explode('/', $pattern);

	if ( count( $path_parts ) != count( $pattern_parts ) ) return false;

	for ($i = 0; $i < count( $path_parts ); $i++) {
		if ( strlen( $pattern_parts[$i] ) > 0 && $pattern_parts[$i][0] == "{" ) {
			$name = substr( $pattern_parts[$i], 1, strlen( $pattern_parts[$i] )-2 );
			$vars[$name] = $path_parts[$i];
		} elseif ( $path_parts[$i] != $pattern_parts[$i] ) {
			return false;
		}
	}

	return true;

}

function parse_query($query) {
	$params = array();
	foreach ( explode('&', $query) as $pair ) {
		$arr = explode( '=', $pair );
		$params[$arr[0]] = $arr[1];
	}
	return $params;
}

function add_route($method, $path, $action) {
	global $routes;
	if ( ! array_key_exists( $method, $routes ) ) {
		$routes[$method] = array();
	}
	$re_var = "/{(.*?)}/";
	$routes[$method][$path] = $action;
}

function do_route() {
	global $routes;
	$method = $_SERVER['REQUEST_METHOD'];
	$path = $_SERVER['REQUEST_URI'];
	
	$path_vars = array();
	$query_params = array();
	$action = null;

	// parse query parameters
	$query_index = strpos( $path, "?" );
	if ( $query_index ) {
		$query_params = parse_query( substr( $path, $query_index+1 ) );
		$path = substr( $path, 0, $query_index );
	}

	// match path to pattern and 
	// define action and path variables
	foreach ( $routes[$method] as $pattern => $action_func ) {
		if ( path_matches( $path, $pattern, $path_vars ) ) {
			$action = $action_func;
			break;
		}
	}

	// check for unfound route
	if ( is_null( $action ) ) {
		$action = function() {
			echo "404 Not Found";
		};
	}

	$action($query_params, $path_vars);

	// show test output
	/*
	echo "<pre>";
	echo "method: $method\n";
	echo "path: $path\n";
	echo "\nquery params: ";
	print_r($query_params);
	echo "\npath vars: ";
	print_r($path_vars);
	echo "\n\n";
	$action($query_params, $path_vars);
	echo "</pre>";
	*/


}
