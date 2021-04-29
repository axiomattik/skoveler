<?php

if ( ! file_exists( "novels.db" ) ) {
	echo "database not found";
	die();
}

class NovelsDB extends SQLite3 {
	function __construct() {
		$this->open('novels.db');
	}


	function add_user($name, $email, $passhash) {
		$stmt = $this->prepare(
			'INSERT INTO user(name, email, passhash) 
			VALUES (:name, :email, :passhash)' );
		$stmt->bindValue( ':name', $name, SQLITE3_TEXT );
		$stmt->bindValue( ':email', $email, SQLITE3_TEXT );
		$stmt->bindValue( ':passhash', $passhash, SQLITE3_TEXT );
		$stmt->execute();
	}


	function add_novel($userid, $title, $author, $is_public=0) {
		$stmt = $this->prepare(
			'INSERT INTO novel (title, author, is_public, userid) 
			VALUES (:title, :author, :is_public, :userid)' );
		$stmt->bindValue( ':title', $title, SQLITE3_TEXT );
		$stmt->bindValue( ':author', $author, SQLITE3_TEXT );
		$stmt->bindValue( ':is_public', $is_public, SQLITE3_INTEGER );
		$stmt->bindValue( ':userid', $userid, SQLITE3_INTEGER );
		$stmt->execute();
	}


	function add_chapter($novelid, $numeral, $title, $time, $setting, $precis, $synopsis, $notes, $color) {
		$stmt = $this->prepare(
			'INSERT INTO chapter (numeral, title, time, setting, precis, synopsis, notes, color, novelid)
			VALUES (:numeral, :title, :time, :setting, :precis, :synopsis, :notes, :color, :novelid)' );
		$stmt->bindValue( ':numeral', $numeral, SQLITE3_TEXT );
		$stmt->bindValue( ':title', $title, SQLITE3_TEXT );
		$stmt->bindValue( ':time', $time, SQLITE3_TEXT );
		$stmt->bindValue( ':setting', $setting, SQLITE3_TEXT );
		$stmt->bindValue( ':precis', $precis, SQLITE3_TEXT );
		$stmt->bindValue( ':synopsis', $synopsis, SQLITE3_TEXT );
		$stmt->bindValue( ':notes', $notes, SQLITE3_TEXT );
		$stmt->bindValue( ':color', $color, SQLITE3_TEXT );
		$stmt->bindValue( ':novelid', $novelid, SQLITE3_INTEGER);
		$stmt->execute();
	}


	function get_novel( $id ) {
		$stmt = $this->prepare('SELECT * FROM novel WHERE id=:id');
		$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
		$result = $stmt->execute();
		return $result->fetchArray();
	}
}

