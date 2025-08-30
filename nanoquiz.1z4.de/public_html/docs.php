<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Instrukcja obsługi NanoQuiz</title>
	<link rel="stylesheet" href="/style.css">
</head>
<body>
	<?php require "../util/navbar.php"; ?>
	<article>
		<?php
		if(is_file("../docs/" . $_SERVER["PATH_INFO"] . ".html")) {
			require "../docs/" . $_SERVER["PATH_INFO"] . ".html";
		} else {
			http_response_code(404);
			?>
			<p>404 Nie znaleziono pliku.</p>
			<?php
		}
		?>
	</article>
</body>
</html>