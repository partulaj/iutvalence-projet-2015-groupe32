<?php
/**
 * Modèle de page php pour le projet
 * @package application
 */

//Chargement des classes php
function __autoload($class) { require_once "../ressources/classes/$class.php"; }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Modele de page</title>

	<!-- Bootstrap -->
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- WebHostingHub Glyphs -->
	<link href="../whhg/css/whhg.css" rel="stylesheet">
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

		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- JavaScript -->
		<script src="../dist/js/bootstrap.min.js"></script>
		<script src="../ressources/js/ourJS.js"></script>
	</body>
	</html>