<?php
/**
 * Modèle de page php pour le projet
 * @package application
 */
//Autochargement des classes via un Autoloader
require_once "../ressources/classes/MyAutoloader.php";

				$dateBrut = new DateTime();
				$date = $dateBrut->format('l d F Y');
				echo "$date";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">

	<title>Page de test</title>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css"  media="screen,projection"/>
	<!-- Web Hosting Hub Glyph-->
	<link rel="stylesheet" href="../whhg/css/whhg.css">
	<!-- Style Personnel -->
	<link href="../ressources/css/style.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	  <![endif]-->
	</head>
	<body>
		<h1>Ici on fait les test</h1>
		<div class="container">
			<div class="row">
				<div class="card col s12">
					<form method="get" action="http://doodle.com/polls/wizard.html">
						<input type="hidden" name="type" value="date">
						<input type="hidden" name="locale" value="fr">
						<input type="hidden" name="name" value="Jérémie PARTULA">
						<input type="hidden" name="eMailAddress" value="test@yopmail.com">

						<div class="input-field">
							<label for="title">Titre de la réunion</label>
							<input type="text" name="title" id="title">
						</div>

						<div class="input-field">
							<label for="location">Lieux de la réunion</label>
							<input type="text" name="location" id="location">
						</div>

						<div class="input-field">
							<label for="description">Sujet(s) de la réunion</label>
							<textarea class="materialize-textarea" type="text" name="description" id="description"></textarea>
						</div>

						<input class="btn" type="submit" value="Demander réunion">
					</form>
				</div>
			</div>
		</div>

		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
		<script type="text/javascript" src="../ressources/autosize/autosize.js"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="../ressources/js/init.js"></script>
		<script src="../ressources/js/etudiant.js"></script>
		<script src="../ressources/js/tache.js"></script>
		<script src="../ressources/js/voeu.js"></script>
		<script src="../ressources/js/projet.js"></script>
		<script src="../ressources/js/easteregg.js"></script>
	</body>
	</html>
