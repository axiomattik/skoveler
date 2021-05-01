<?php

$base_uri = "/api/v1";

function _respond($data) {
	header("Content-Type: application/json");
	http_response_code(200);
	echo json_encode($data);
}

add_route('GET', $base_uri . "/novels", function() {
	global $db;
	_respond($db->get_novel(1));
	return;
	$data = array(
		'field' => 'value',
	);
	_respond( $data );
});

add_route('GET', $base_uri . "/novels/{slug}", function($slug) {
	echo "GET /api/v1/novels/$slug";
});
