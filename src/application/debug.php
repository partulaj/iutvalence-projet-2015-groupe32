<?php
/**
 * Modèle de page php pour le projet
 * @package application
 */
//Autochargement des classes via un Autoloader
require_once "../ressources/classes/MyAutoloader.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">

	<title>Modele de page</title>
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
		<h1>Modele de page</h1>

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


	<div class="card container">
		<div class="row">
			<div class="col s12">
				<ul class="tabs">
					<li class="tab col s3"><a class="active amber-text" href="#all" onclick="refreshAll()">Tous les Etudiants</a></li>
					<li class="tab col s3"><a class="amber-text" href="#sp" onClick="refreshSP()">Sans Projet</a></li>
					<li class="tab col s3"><a class="amber-text" href="#sv" onClick="refreshSV()">Sans Voeux</a></li>
					<li class="tab col s3"><a class="amber-text" href="#se" onClick="refreshSE()">Supprimer étudiants</a></li>
				</ul>
			</div>
			<div id="all" class="col s12">'
				<div class="hidden-element-block">
					<div class="center">
						<a class="waves-effect waves-grey btn-flat slide-link col s12">Changement de Groupe</a>
					</div>
					<div class="row hide">
						<div class="input-field col s5">
							<label for="switchEtu1">Etudiant 1</label>
							<input type="text" id="switchEtu1">
						</div>
						<div class="input-field col s2 centre">
							<button class="btn-floating btn-large waves-effect waves-light indigo" onClick="switchGroup()"><i class="mdi-av-loop"></i></button>
						</div>
						<div class="input-field col s5">
							<label for="switchEtu2">Etudiant 2</label>
							<input type="text" id="switchEtu2">
						</div>
					</div>
				</div>
				<div class="hidden-element-block">
					<div class="center">
						<a class="waves-effect waves-grey btn-flat slide-link col s12">Affecter un Etudiant</a>
					</div>
					<div class="row hide">
						<div class="input-field col s5">
							<label for="affecterEtu">Etudiant</label>
							<input type="text" id="affecterEtu">
						</div>
						<div class="input-field col s2 centre">
							<button class="btn-floating btn-large waves-effect waves-light indigo" onClick="affecterEtu()"><i class="mdi-action-trending-neutral"></i></button>
						</div>
						<div class="input-field col s5">
							<select onChange="groupe=this.value">
								<option value="" disabled selected>Choisir un Groupe</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div id="sp" class="col s12"></div>
			<div id="sv" class="col s12"></div>
			<div id="se" class="col s12">
				<ul id="list-etudiants" class="collection">
				</ul>
				<div class="centre">
					<button class="btn waves-effect waves-light red" onclick="delStudent()"><i class="mdi-action-delete"></i>Supprimer les étudiants</button>
				</div>
			</div>
		</div>
	</div>
	</body>
	</html>
