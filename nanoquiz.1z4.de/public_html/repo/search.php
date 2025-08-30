<?php

$keywords = isset($_GET["keywords"]) ? $_GET["keywords"] : "";
$isbn = isset($_GET["isbn"]) ? $_GET["isbn"] : "";
if(!empty($isbn)) {
	if(!preg_match('/\d{13}/', $isbn)) $error = "Nieprawidłowy ISBN";
	if(($isbn[0] + 3 * $isbn[1] + $isbn[2] + 3 * $isbn[3] + $isbn[4] + 3 * $isbn[5] + $isbn[6] + 3 * $isbn[7] + $isbn[8] + 3 * $isbn[9] + $isbn[10] + 3 * $isbn[11] + $isbn[12]) % 10 !== 0) $error = "Nieprawidłowy ISBN";
}
$chapter = isset($_GET["chapter"]) ? $_GET["chapter"] : "";
if(!is_numeric($chapter)) $chapter = NULL;
$subchapter = isset($_GET["subchapter"]) ? $_GET["subchapter"] : "";
if(!is_numeric($subchapter)) $subchapter = NULL;

require_once "../../util/db.php";

$query = dbquery("SELECT `id`, `name` FROM `quiz` WHERE (? IS NULL OR ?=`isbn`) AND (? IS NULL OR ?=`chapter`) AND (? IS NULL OR ?=`subchapter`) ORDER BY MATCH(`name`) AGAINST(?) DESC LIMIT 50", $isbn, $isbn, $chapter, $chapter, $subchapter, $subchapter, $keywords);

?>
<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Nanoquiz Repo</title>
		<link rel="stylesheet" href="/style.css" />
	</head>
	<body>
		<?php require "../../util/navbar.php"; ?>
		<?php if(isset($error)) { ?>
			<div class="error"><?=$error?></div>
		<?php } ?>
		<h1>Szukaj quizów w Repozytorium NanoQuiz</h1>
		<search>
			<form method="get">
				<table>
					<tr>
						<td>Słowa kluczowe:</td>
						<td><input type="text" name="keywords" /></td>
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
						<td colspan="2"><button>Szukaj</button></td>
					</tr>
				</table>
			</form>
		</search>
		<br />
		<br />
		<h2>Wyniki wyszukiwania:</h2>
		<ul>
			<?php while ($result = $query->fetch()) { ?>
				<li>
					<a href="/quiz.php?id=<?=$result["id"]?>">
						<?=htmlspecialchars($result["name"])?>
					</a>
				</li>
			<?php } ?>
		</ul>
	</body>
</html>
