<?php
require_once "secrets.php";

$db = NULL;

function db_connect() {
	global $db, $db_dsn, $db_user, $db_pass;
	if(is_null($db)) {
		$db = new PDO($db_dsn, $db_user, $db_pass);
	}
}

function dbquery(string $sql, mixed ...$data) : PDOStatement {
	global $db;
	db_connect();
	$stmt = $db->prepare($sql);
	$stmt->execute($data);
	return $stmt;
}