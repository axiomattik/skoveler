<?php

class NovelsDB extends SQLite3 {
	function __construct($path) {
		$this->open($path);
	}

	function _parse_value($val) {
		switch ( gettype( $val ) ) {

			case "boolean":
				if ( $val ) {
					return 1;
				} else {
					return 2;
				}
				break;

			case "integer":
			case "double":
				return strval($val);

			case "string":
				return "\"$val\"";

			default:
				throw new Exception("unsupported type");
		}


	}


	function _parse_values( $arr ) {
		$result = array();
		foreach ( $arr as $val ) {
			array_push($result, $this->_parse_value($val));
		}
		return $result;
	}


	function insert($table, $values) {
		$fields = implode(',', array_keys($values));
		$value_placeholders = implode(",", array_map(function($s) {
			return ":$s";
		}, array_keys($values)));
		$sql = "INSERT INTO $table ($fields) VALUES ($value_placeholders);";

		$stmt = $this->prepare($sql);
		foreach ($values as $field => $value) {
			$stmt->bindValue(":$field", $value);
		}

		return $stmt->execute();
	}


	function select($table, $columns="*", $constraints=null) {
		$rows = array();
		if ( gettype( $columns ) == "array" ) {
			$columns = implode( ',', $columns );
		}
		$sql = "SELECT $columns FROM $table";
		if ( ! is_null( $constraints ) ) {
			$sql .= " WHERE $constraints";
		}
		$sql .= ";";
		$results = $this->query($sql);
		if ( ! $results ) return false;
		while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
			array_push($rows, $row);
		}
		return $rows;
	}


	function update($table, $values, $constraints=null) {
		$assignments = implode(",", array_map(function($s) {
			return "$s = :$s";
		}, array_keys($values)));

		$sql = "UPDATE $table SET $assignments";
		if ( ! is_null( $constraints ) ) {
			$sql .= " WHERE $constraints";
		}

		$stmt = $this->prepare($sql);
		foreach( $values as $field => $value ) {
			$stmt->bindValue(":$field", $value);
		}

		return $stmt->execute();

	}


	function delete($table, $constraints) {
		$sql = "DELETE FROM $table WHERE $constraints;";
		return $this->exec($sql);
	}


	function store_nonce($key, $nonce) {
		return $this->insert(
			"nonce",
			array(
				"key" => $key,
				"value" => $nonce
			)
		);
	}


	function get_nonce($key, $nonce) {
		$retrieved_nonce = $this->select(
			"nonce", 
			"*", 
			"key = \"$key\" AND value = \"$nonce\""
		);
		if ( ! $retrieved_nonce ) return false;
		return $retrieved_nonce[0];
	}


	function delete_nonce($key, $nonce) {
		return $this->delete(
			"nonce",
			"key = \"$key\" AND value = \"$nonce\"",
		);
	}


	function add_user($key) {
		$this->insert("account", array("key" => $key));
		return $this->get_user("key = \"$key\"");
	}


	function get_user($constraints) {
		$users = $this->select("account", "*", $constraints);
		if ( ! $users ) return false;
		return $users[0];
	}


	function update_user($key, $values) {
		return $this->update(
			"account",
			$values,
			"key = \"$key\""
		);
	}


	function add_key($userid, $key) {
		$this->update(
			"account", 
			array("key" => $key),
			"id = $userid"
		);
	}

	function delete_key($key) {
		return $this->update(
			"account",
			array("key" => ""),
			"key = \"$key\""
		);
	}



	function get_users() {
		return $this->select("account");
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

