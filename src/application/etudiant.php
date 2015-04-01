<?php
/**
 * Page d'accueil des étudiants 
 * @package application
 * @author Audrey, Jérémie
 * @version 1.3
 */
//Autochargement des classes via un Autoloader
require_once "../ressources/classes/MyAutoloader.php";
session_start();

//Création des DAO
$projetDAO = new ProjetsDAO(MaBD::getInstance());
$etudiantsDAO = new UtilisateursDAO(MaBD::getInstance());

//On vérifie que l'utilisateur est connecté 

if (!isset($_SESSION['user']) or !$_SESSION['user']->estEtudiant())
{
	header("Location:index.php");
	exit();
}

//On lance l'affectation automatique
$affectationProjet=$projetDAO->getAll();
foreach ($affectationProjet as $projetAAffecter)
{
	$projetAAffecter->initAffectationAuto();
	$_SESSION['user']= new Etudiant ($etudiantsDAO->getOne($_SESSION['user']->login)->getAllFields());
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Etudiant</title>
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
		$_SESSION['user']->afficheNavBar();
		?>
		<div class="container brown lighten-5">
			<?php
			if ($_SESSION['user']->no_groupe!=null) 
			{
				$_SESSION['user']->afficheAccueil();
			}
			else
			{
				echo "
				<div class='card'>
					<div class='row'>
						<div class='col s12'>
							<h5 class='red-text'><i class='mdi-alert-warning'></i> Attention vous n'êtes pas encore affecté</h5>
							<p>Vous n'êtes pas encore affecté à un groupe, l'interface de gestion des tâches n'est 
							donc pas disponible pour le moment.<br/>
							Veuillez aller dans l'onglet Projet pour faire un ou plusieurs Voeux, ou attendre que 
							vous soyez affecté si cela est déjà fait.</p>
						</div>
					</div>
				</div>";
			}
			?>
		</div>

	<!--Import javascript-->
	<?php
	require_once("../ressources/js/javascript.php");
	?>

	</body>
	</html>
