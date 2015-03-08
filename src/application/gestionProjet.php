<?php
/**
 * Modèle de page php pour le projet
 * @package application
 */
//Autochargement des classes via un Autoloader
require_once "../ressources/classes/MyAutoloader.php";
session_start();

//On vérifie que la personne qui accède à la page est un utilisateur authentifié
if (!isset($_SESSION['user']->login_enseignant)) 
{
	header("Location:index.php");
	exit();
}

function afficheGestionProjet($no_projet)
{
	$groupesDAO = new GroupesDAO(MaBD::getInstance());
	$groupes = $groupesDAO->getAll("WHERE no_projet='$no_projet'");
	foreach ($groupes as $groupe) 
	{
		$groupe->managmentInterface();
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">

	<title>Interface de Gestion</title>
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
		<?php
		$_SESSION ['user']->afficheNavBar ();
		?>
		<div class="container brown lighten-5">
			<?php 
				if (isset($_POST)) 
				{
					afficheGestionProjet($_POST['projet']);
				}
			?>
		</div>

		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
		<script src="../ressources/js/ourJS.js"></script>
	</body>
	</html>