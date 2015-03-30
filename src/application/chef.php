<?php
/**
 * Page d'accueil du chef des projet tutorés
 * @package application
 * @author Jérémie
 * @version 1.3
 */
//Autochargement des classes via un Autoloader
require_once "../ressources/classes/MyAutoloader.php";
session_start ();

// On vérifie que l'utilisateur est connecté
if (! isset ( $_SESSION ['user']->login_chef )) {
	header ( "Location:index.php" );
	exit ();
}

$etudiantsDAO = new EtudiantsDAO ( MaBD::getInstance () );
// Ajout du module d'importation
require_once "./import.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">

	<title>Chef</title>
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
	<body class="brown lighten-5">
		<?php
		$_SESSION ['user']->afficheNavBar ();
		?>
		<div class="container brown lighten-5">
			<?php
			$_SESSION['user']->afficheAccueil();
			?>
			<div class="card hidden-element-block">
				<div class="row">
					<div class="col s12">
						<a class="btn-floating btn-large waves-effect waves-light red arrow-link slide-link">
							<i class="mdi-hardware-keyboard-arrow-down"></i>
						</a>
						<h5>Importation des Etudiants</h5>
						<p>Veuillez mettre un fichier excel (xls, xlm, xslx) à importer </p>
					</div>
				</div>
				<div class="row hide">
					<form class="col s12" enctype="multipart/form-data" method="post" action="">
						<div class="file-field input-field">
							<input class="file-path validate" type="text" />
							<div class="btn light-blue">
								<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
								<span>File</span><input name="fichier" type="file" id="fichier_a_uploader" />
							</div>
						</div>
						<div class="centre">	
							<button type="submit" name="submit" class="btn light-blue">
								<span class="glyphicon glyphicon-open"></span> Importer
							</button>
						</div>
					</form>
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

		<?php 
		if ($param['reussi']==true)
		{
			echo "<script>toast('",$param['message'],"', 4000)</script>";
		}
		if ($param['erreur']==true) 
		{
			echo 	"<script>toast('",$param['message'],"', 4000)</script>";
		}
		?>
	</body>
	</html>
