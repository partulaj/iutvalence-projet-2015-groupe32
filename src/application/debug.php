<?php
/**
 * Modèle de page php pour le projet
 * @package application
 */

// Chargement des classes php
function __autoload($class) {
	require_once "../ressources/classes/$class.php";
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">

	<title>Modele de page</title>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet"
	href="../materialize/css/materialize.min.css" media="screen,projection" />
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
		<ul id="dropdown1" class="dropdown-content">
			<li><a href="projet.php">Projet</a></li>
			<li><a href="message.php">Message</a></li>
			<li><a href="voeux.php">Voeux</a></li>
		</ul>
		<nav>
			<div class="nav-wrapper light-blue">
				<a href="#!" class="brand-logo">Logo</a>
				<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
				<ul class="right hide-on-med-and-down">
					<li>
						<a class="dropdown-button" href="#!" data-activates="dropdown1">
							Menu<i class="mdi-navigation-arrow-drop-down right"></i>
						</a>
					</li>
					<li>
						<a class='navbar-link' href='javascript:document.formDeDeconnexion.submit();'>
							<span class='icon-off'></span>
						</a>
					</li>
				</ul>
				<ul class="side-nav" id="mobile-demo">
					<li><a href="projet.php">Projet</a></li>
					<li><a href="message.php">Message</a></li>
					<li><a href="voeux.php">Voeux</a></li>
					<li>
						<a class='navbar-link' href='javascript:document.formDeDeconnexion.submit();'>
							<span class='icon-off'></span>
						</a>
					</li>
				</ul>
			</div>
		</nav>
		<!--Import jQuery before materialize.js-->
		<script type="text/javascript"
		src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript"
		src="../materialize/js/materialize.min.js"></script>
		<script src="../ressources/js/ourJS.js"></script>
	</body>
	</html>