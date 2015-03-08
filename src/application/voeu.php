<?php
/**
 * Modèle de page php pour le projet
 * @package application
 * @author Jérémie
 * @version 0.2
 */
//Autochargement des classes via un Autoloader
require_once "../ressources/classes/MyAutoloader.php";
session_start();

//On vérifie que l'utilisateur est connecté 
if (!isset($_SESSION['user']->login_etudiant))
{
	header("Location:index.php");
	exit();
}

/**
 * Foncion qui récupère les voeux et les affiche dans un tableau
 * @author Jérémie
 * @version 1.0
 */
function afficheVoeux()
{
	$voeuxDAO = new VoeuxDAO(MaBD::getInstance());
	$lesVoeux = $voeuxDAO->getAllVoeuEtudiant($_SESSION['user']->login_etudiant);
	echo	"
	<div class='card'>
		<div class='row'>
			<div class='col s12'>
				<h5>Vos Voeux</h5>
				<p>Voici les voeux que vous avez fait, vous pouvez les modifier ou les supprimer</p>
			</div>
		</div>
		<table class='responsive-table bordered striped centered'>
			<tr>
				<th>Numéro Projet</th>
				<th>Intitulé Projet</th>
				<th>Details</th>
			</tr>";
			foreach($lesVoeux as $voeux)
			{
				$voeux->toTableRow();
			}
			echo "	
		</table>
	</div>";
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">

	<title>Voeux</title>
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
		$_SESSION['user']->afficheNavBar(null,"Vos Voeux");
		?>
		<div class="container brown lighten-5">
			<?php
			afficheVoeux();
			?>
		</div>
		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
		<script src="../ressources/js/ourJS.js"></script>
	</body>
	</html>