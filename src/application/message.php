<?php
/**
 * Modèle de page php pour le projet
 * @package application
 */
//Autochargement des classes via un Autoloader
require_once "../ressources/classes/MyAutoloader.php";
session_start();

if (! isset ( $_SESSION ['user'])) {
	header ( "Location:index.php" );
	exit ();
}

if (isset($_POST['envoi'])) 
{	
	$sujet = $_POST['sujet'];
	$message = $_POST['message'];

	if (isset($_POST['groupe'])) 
	{
		if ($_POST['no_groupe']=="sans_projet")
		{
			$chef = new Chef($_SESSION['user']->getAllFields());
			$chef->mailToSansProjets($subject, $message);
		}
		elseif ($_POST['no_groupe']=="tous") 
		{
			$chef = new Chef($_SESSION['user']->getAllFields());
			$chef->mailToAll($subject, $message);
		}
		else 
		{
			$_SESSION['user']->mailToThisGroup($_POST['no_groupe'], $sujet, $message);
			echo "Envoie du mail";
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
		$_SESSION['user']->mailToChef(Utilisateur::DEFAULT_CHEF,$sujet,$message);
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
		<?php 
		$_SESSION['user']->afficheNavBar("mdi-communication-email","Message");
		?>

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
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script type="text/javascript" src="../materialize/js/materialize.js"></script>
		<script type="text/javascript" src="../ressources/autosize/autosize.js"></script>
		<script src="../ressources/js/init.js"></script>
		<script src="../ressources/js/etudiant.js"></script>
		<script src="../ressources/js/tache.js"></script>
		<script src="../ressources/js/voeu.js"></script>
		<script src="../ressources/js/projet.js"></script>
		<script src="../ressources/js/easteregg.js"></script>

	</body>
	</html>
