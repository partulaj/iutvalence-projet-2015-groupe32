<?php
/**
 * Modèle de page php pour le projet
 * @package application
 */
session_start();

// Tableau de paramètres de la page
$param ['erreur'] = false;
$param['reussi'] = false;
$param ['message'] = null;

//Chargement des classes php
function __autoload($class) { require_once "../ressources/classes/$class.php"; }

//On vérifie que la personne qui accède à la page est un utilisateur authentifié
if (!isset($_SESSION)) 
{
	header("Location:index.php");
}

//Création des DAO
$projetsDAO = new projetsDAO(MaBD::getInstance());

if (isset($_GET['no_projet'])) 
{
	$projet = $projetsDAO->getOne($_GET['no_projet']);
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">

	<title>Projet</title>
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
		<div class="navbar-fixed">
			<nav>
				<div class="nav-wrapper amber">
					<div class="col s12">
						<a href="#" class="brand-logo"><span class="mdi-action-book"></span>Projet</a>
						<a href='#' data-activates='mobile-demo' class='button-collapse'>
							<i class='mdi-navigation-menu'></i>
						</a>
						<ul id="nav-mobile" class="right hide-on-med-and-down">
							<?php
							if (isset($_SESSION['etu']))  
								echo "<li><a class='navbar-link' href='etudiant.php'><span class='mdi-navigation-arrow-back'></span> Retour</a></li>";
							if (isset($_SESSION['ens']))  
								echo "<li><a class='navbar-link' href='enseignant.php'><span class='mdi-navigation-arrow-back'></span> Retour</a></li>";
							if (isset($_SESSION['chef']))  
								echo "<li><a class='navbar-link' href='chef.php'><span class='mdi-navigation-arrow-back'></span> Retour</a></li>";
							?>
						</ul>
						<ul class='side-nav' id='mobile-demo'>
							<?php
							if (isset($_SESSION['etu']))  
								echo "<li><a class='navbar-link' href='etudiant.php'><span class='mdi-navigation-arrow-back'></span> Retour</a></li>";
							if (isset($_SESSION['ens']))  
								echo "<li><a class='navbar-link' href='enseignant.php'><span class='mdi-navigation-arrow-back'></span> Retour</a></li>";
							if (isset($_SESSION['chef']))  
								echo "<li><a class='navbar-link' href='chef.php'><span class='mdi-navigation-arrow-back'></span> Retour</a></li>";
							?>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="container">
			<?php
			if (isset($projet)) 
			{
				if (isset($_SESSION['etu'])) 
				{
					$projet->toStudentCards();				
				}
				if (isset($_SESSION['ens'])) 
				{
					$projet->toTeacherCards();
				}
			}
			?>
		</div>

		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
		<script src="../ressources/js/ourJS.js"></script>
	</body>
	</html>