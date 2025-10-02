<?php
$cathegories = [
	"Repozytorium" => [
		"Szukaj quizów" => "/repo/search.php",
		"Udostępnij quiz" => "/repo/create.php",
	],
	"O programie" => [
		"Wprowadzenie" => "/docs.php/about/introduction",
		"Kod źródłowy" => "/docs.php/about/source",
		"Kontakt" => "/docs.php/about/contact",
	],
	"Instalacja" => [
		"Instalacja javy" => "/docs.php/install/java",
		"Instalacja programu" => "/docs.php/install/nanoquiz",
	],
	"Tworzenie quizów" => [
		"Podstawy tworzenia quizów" => "/docs.php/creation/basic",
		"Sprawdzacze odpowiedzi" => "/docs.php/creation/answer_checkers",
		"Udostępnianie quizów" => "/docs.php/creation/sharing"
	],
];
?>
<nav data-nosnippet>
	<h2>NanoQuiz:<br>Java Edition</h3>
	<?php foreach($cathegories as $cathegory => $entries) { ?>
	<section>
		<h3><?=$cathegory?></h3>
		<?php foreach($entries as $label => $link) { ?>
			<a
				<?php if(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) === $link) { ?>
				class="active"
				<?php } ?>
				href="<?=$link?>"
			>
				<?=$label?>
			</a>
		<?php } ?>
	</section>
	<?php } ?>
</nav>