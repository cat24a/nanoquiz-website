<?php
if(!isset($_GET["id"])) die();
if(!is_numeric($_GET["id"])) die();

require_once "../../util/db.php";
$query = dbquery("SELECT `name`, `author`, `isbn`, `chapter`, `subchapter`, `content`, `downloads` FROM `quiz` WHERE `id`=?", $_GET["id"]);
$data = $query->fetch();
if($data === false) die("Nie znaleziono quizu.");
?>
<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>NanoQuiz Repo</title>
		<link rel="stylesheet" href="/style.css" />
	</head>
	<body>
		<?php require "../../util/navbar.php"; ?>
		<h1>Quiz użytkownika</h1>
		<table>
			<tr>
				<td>Nazwa:</td>
				<td><?=htmlspecialchars($data["name"])?></td>
			</tr>
			<tr>
				<td>Autor:</td>
				<td><?=htmlspecialchars($data["author"])?></td>
			</tr>
			<tr>
				<td>ISBN podręcznika:</td>
				<td><?=$data["isbn"]?></td>
			</tr>
			<tr>
				<td>Rozdział:</td>
				<td><?=$data["chapter"]?></td>
			</tr>
			<tr>
				<td>Podrozdział:</td>
				<td><?=$data["subchapter"]?></td>
			</tr>
			<tr>
				<td>Liczba pobrań:</td>
				<td><?=$data["downloads"]?></td>
			</tr>
			<tr>
				<td>Licencja:</td>
				<td>
					<a
						href="https://creativecommons.org/licenses/by/4.0/"
						target="_blank"
					>
						Creative Commons Attribution 4.0 International
					</a>
				</td>
			</tr>
			<tr>
				<td>Pobieranie:</td>
				<td><a href="https://rawusercontent.cat24a.s1.zetohosting.pl/nanoquiz/raw_quiz_content.php?id=<?=$_GET["id"]?>" download="<?=preg_replace("/[^A-Za-z0-9 ]/", '', $data["name"])?>.nq2.txt">pobierz</a></td>
			</tr>
		</table>
		<h2>Zawartość:</h2>
		<pre><?=htmlspecialchars($data["content"])?></pre>
	</body>
</html>
