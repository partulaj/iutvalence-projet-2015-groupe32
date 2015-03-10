<?php
/**
 * Modèle de page php pour le projet
 * @package application
 */
//Autochargement des classes via un Autoloader
require_once "../ressources/classes/MyAutoloader.php";
session_start();
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
	<body class="brown lighten-5">
		<div class="container brown lighten-5">
			<div class="card">
				<div class="row">
					<div class="col s12">
						<h5>Liste des étudiants Sans Projet</h5>
					</div>
				</div>
				<ul class="collection">
					<li class="collection-item avatar">
						<i class="mdi-social-school grey circle"></i>
						<span class="title">Title</span>
					</li>					
				</ul>
			</div>
		</div>

		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
		<script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
		<script src="../ressources/js/ourJS.js"></script>
		<script src="../ressources/js/jquery-color-min.js"></script>
		<script type="text/javascript">
			$(document).ready(function($) 
			{
				$(".avatar>i").click(function(event) 
				{
					$(this).toggle(function() {
						$(this).css('background-color', '#f44336');
						$(this).removeClass('red');
						$(this).switchClass("mdi-content-clear","mdi-social-school",1000);
						$(this).animate({backgroundColor:"#9e9e9e"},1000, function() {
							$(this).addClass('grey');
						});
					}, function() {
						$(this).css('background-color', '#9e9e9e');
						$(this).removeClass('grey');
						$(this).switchClass("mdi-social-school","mdi-content-clear",1000);
						$(this).animate({backgroundColor:"#f44336"},1000, function() {
							$(this).addClass('red');
						});
					});

				});
			});
		</script>
	</body>
	</html>