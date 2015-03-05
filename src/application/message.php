<?php
/**
 * Modèle de page php pour le projet
 * @package application
 */
session_start();

//Tableau de parammètres de la page
$param['erreur']=false;
$param['reussi']=false;
$param['message']=null;

// Chargement des classes php
function __autoload($class) {require_once "../ressources/classes/$class.php";}

if (! isset ( $_SESSION ['user'])) {
	header ( "Location:index.php" );
	exit ();
}

if (isset($_POST['envoi'])) 
{
	echo "<pre>";
	var_dump($_POST);
	echo "</pre>";
	
	$sujet = $_POST['sujet'];
	$message = $_POST['message'];

	if (isset($_POST['groupe'])) 
	{
		if ($_POST['no_groupe']=="sans_projet")
		{
			$chef = new Chef($_SESSION['user']->getAllFields());
			$chef->mailToSansProjets($subject, $message);
		}
		else 
		{
			if ($_SESSION['user']->estEtudiant())
			{
				$_SESSION['user']->mailToThisGroup($_SESSION['user']->no_groupe, $sujet, $message);
			}
			else 
			{
				$_SESSION['user']->mailToThisGroup($_POST['no_groupe'], $sujet, $message);
			}
		}
	}
	if (isset($_POST['tuteur']))
	{
		$groupesDAO = new GroupesDAO(MaBD::getInstance());
		$groupe = $groupesDAO->getOne($_POST['no_groupe']);
		$_SESSION['user']->mailToTuteur($groupe->no_projet,$sujet,$message);
	}
	if (isset($_POST['chef']))
	{
		
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">

	<title>Message</title>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css" media="screen,projection" />
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
		<div class="navbar-fixed">
			<nav>
				<div class="nav-wrapper deep-purple ">
					<div class="col s12">
						<a href="#" class="brand-logo"><span class="mdi-communication-email"></span>Message</a>
						<a href='#' data-activates='mobile-demo' class='button-collapse'> <i
							class='mdi-navigation-menu'></i>
						</a>
						<ul id="nav-mobile" class="right hide-on-med-and-down">
							<?php
							if ($_SESSION['user']->estEtudiant())  
								echo "<li><a class='navbar-link' href='etudiant.php'><span class='mdi-navigation-arrow-back'></span> Retour</a></li>";
							if ($_SESSION['user']->estEnseignant())  
								echo "<li><a class='navbar-link' href='enseignant.php'><span class='mdi-navigation-arrow-back'></span> Retour</a></li>";
							if ($_SESSION['user']->estChef())  
								echo "<li><a class='navbar-link' href='chef.php'><span class='mdi-navigation-arrow-back'></span> Retour</a></li>";
							?>
						</ul>
						<ul class='side-nav' id='mobile-demo'>
							<?php
							if ($_SESSION['user']->estEtudiant())  
								echo "<li><a class='navbar-link' href='etudiant.php'><span class='mdi-navigation-arrow-back'></span> Retour</a></li>";
							if ($_SESSION['user']->estEnseignant())  
								echo "<li><a class='navbar-link' href='enseignant.php'><span class='mdi-navigation-arrow-back'></span> Retour</a></li>";
							if ($_SESSION['user']->estChef())  
								echo "<li><a class='navbar-link' href='chef.php'><span class='mdi-navigation-arrow-back'></span> Retour</a></li>";
							?>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="container brown lighten-5">
			<div class="card">
				<div class="row">
					<div class="col s12">
						<h5>Envoyer un message</h5>
					</div>
					<div class="col s12">
						<?php 
						if (isset($_SESSION['user']))
						{
							$_SESSION['user']->afficheMail();
						}
						?>
					</div>
				</div>
			</div>
		</div>

		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
		<script src="../ressources/js/ourJS.js"></script>
	</body>
	</html>