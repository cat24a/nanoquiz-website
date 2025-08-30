<?php
if($_SERVER["REQUEST_METHOD"] === "POST") {

	if(!isset($_POST["license"])) die("Brak wymaganej zgody.");
	if(!isset($_POST["name"])) die("Brak nazwy quizu.");
	if(!isset($_POST["author"])) die("Brak autora.");
	$isbn = isset($_POST["isbn"]) ? $_POST["isbn"] : NULL;
	if(!empty($isbn)) {
		if(!preg_match('/\d{13}/', $isbn)) die("Nieprawidłowy ISBN.");
		if(($isbn[0] + 3 * $isbn[1] + $isbn[2] + 3 * $isbn[3] + $isbn[4] + 3 * $isbn[5] + $isbn[6] + 3 * $isbn[7] + $isbn[8] + 3 * $isbn[9] + $isbn[10] + 3 * $isbn[11] + $isbn[12]) % 10 !== 0) die("Nieprawidłowy ISBN.");
	} else $isbn = NULL;
	$chapter = isset($_POST["chapter"]) ? $_POST["chapter"] : NULL;
	if(empty($chapter)) $chapter = NULL;
	if(!is_null($chapter) && !is_numeric($chapter)) die("Rozdział powinien być liczbą.");
	$subchapter = isset($_POST["subchapter"]) ? $_POST["subchapter"] : NULL;
	if(empty($subchapter)) $subchapter = NULL;
	if(!is_null($subchapter) && !is_numeric($subchapter)) die("Podrozdział powinien być liczbą.");

	if(!isset($_FILES["file"])) die("Brak pliku.");
	if($_FILES["file"]["error"] != 0) die("Błąd wczytywania pliku.");
	if($_FILES["file"]["size"] > 50_000) die("Plik jest za duży.");
	if($_FILES["file"]["size"] < 200) die("Plik jest za mały.");
	$content = file_get_contents($_FILES["file"]["tmp_name"]);
	if($content === false) die("Błąd serwera podczas przetwarzania pliku.");
	require_once "../../util/db.php";
	dbquery("INSERT INTO `quiz`(`name`, `author`, `isbn`, `chapter`, `subchapter`, `content`) VALUES (?,?,?,?,?,?)", $_POST["name"], $_POST["author"], $isbn, $chapter, $subchapter, $content);
	$id = $db->lastInsertId();
	header("Location: /quiz.php?id=" . $id);
	die();
}
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
		<form method="post" enctype="multipart/form-data">
			<h1>Dodawanie quizu do Repozytorium NanoQuiz</h1>
			<table>
				<tr>
					<td>Nazwa:</td>
					<td><input type="text" name="name" required /></td>
				</tr>
				<tr>
					<td>Autor:</td>
					<td><input type="text" name="author" required /></td>
				</tr>
				<tr>
					<td>ISBN podręcznika:</td>
					<td>
						<input
							type="text"
							name="isbn"
							pattern="\d{13}"
							inputmode="numeric"
						/>
					</td>
				</tr>
				<tr>
					<td>Rozdział:</td>
					<td><input type="number" name="chapter" /></td>
				</tr>
				<tr>
					<td>Podrozdział:</td>
					<td><input type="number" name="subchapter" /></td>
				</tr>
				<tr>
					<td>Plik z quizem:</td>
					<td><input type="file" name="file" required /></td>
				</tr>
			</table>
			<input type="checkbox" name="license" id="license" required />
			<label for="license">
				Zgadzam się na udostepnianie mojego quizu oraz podanych na tej
				stronie danych wszystkim użytkownikom platformy na warunkach
				<a
					href="https://creativecommons.org/licenses/by/4.0/"
					target="_blank"
				>
					licencji „Creative Commons Attribution 4.0 International”.
				</a>
			</label>
			<br />
			<button>Udostępnij quiz!</button>
		</form>
	</body>
</html>
