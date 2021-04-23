<?php

if ( ! file_exists( "novels.db" ) ) {
	echo "database not found";
	die();
}

class NovelsDB extends SQLite3 {
	function __construct() {
		$this->open('novels.db');
	}

	function get_novel( $id ) {
		$stmt = $this->prepare('SELECT * FROM novel WHERE id=:id');
		$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
		$result = $stmt->execute();
		return $result->fetchArray();
	}
}

