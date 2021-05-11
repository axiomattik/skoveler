<?php

class Router {
	private $routes;


	function __construct() {
		$this->routes = array();
	}

	
	function _parse_query_params(&$params) {
		// takes an array as reference to fill with any parameters from the request path
		// returns path string stripped of query parameters
		$path = $_SERVER['REQUEST_URI'];
		$query_index = strpos( $path, "?" );
		if ( ! $query_index ) return $path;

		$query = substr( $path, $query_index+1 );
		foreach ( explode('&', $query) as $pair ) {
			$arr = explode( '=', $pair );
			$params[$arr[0]] = $arr[1];
		}

		$path = substr( $path, 0, $query_index );
		return $path;
	}


	function _matches($path, $pattern, &$vars) {
		// returns true if $path matches $pattern and fills $vars with path variables
		// otherwise, returns false
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



	function add($method, $path, $callback) {
		// adds a new route using $method at $path 
		// $path can contain named variables encapsulated in {}
		// e.g. /user/{id}
		// $callback should accept two arrays 
		// to accept any path variables or query parameters
		if ( ! array_key_exists( $method, $this->routes ) ) {
			$this->routes[$method] = array();
		}
		$this->routes[$method][$path] = $callback;
	}


	function run() {
		$callback = null;

		$method = $_SERVER['REQUEST_METHOD']; // GET, POST, etc.
		$vars = array(); // stores path variables
		$params = array(); // stores query parameters

		// parse query parameters and store them in $params
		// and remove the query string (if any) from $path
		$path = $this->_parse_query_params($params);

		// try to find a match to $path
		// if successful, path variables are stored in $vars
		foreach ( $this->routes[$method] as $pattern => $cb) {
			if ( $this->_matches( $path, $pattern, $vars ) ) {
				$callback = $cb;
				break;
			}
		}

		// check for unfound route
		if ( is_null( $callback ) ) {
			$action = function() {
				http_response_code(404);
				require_once 'templates/404.php';
			};
		}

		// perform callback
		$callback($vars, $params);
	}
}


