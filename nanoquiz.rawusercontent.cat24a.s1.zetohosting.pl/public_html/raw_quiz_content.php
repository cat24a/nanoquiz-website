<?php
header("Content-Type: text/plain");
if(!isset($_GET["id"])) die();
if(!is_numeric($_GET["id"])) die();

require_once "../../nanoquiz.1z4.de/util/db.php";
$query = dbquery("SELECT `content` FROM `quiz` WHERE `id`=?", $_GET["id"]);
$data = $query->fetchColumn();
if($data === false) die();

echo htmlspecialchars($data);

dbquery("UPDATE `quiz` SET `downloads`=`downloads`+1 WHERE `id`=?", $_GET["id"]);