<?php
/**
 * Page d'accueil des enseignants 
 * @package application
 * @author Ihab, Jérémie
 * @version 1.1
 */
//Autochargement des classes via un Autoloader
require_once "../ressources/classes/MyAutoloader.php";
session_start ();

// On vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user']) or $_SESSION ['user']->estEtudiant())
{
	header ( "Location:index.php" );
	exit ();
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">

	<title>Enseignant</title>
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
	<body class=" brown lighten-5">
		<?php
		$_SESSION ['user']->afficheNavBar ();
		?>
		<div class="container brown lighten-5">
<<<<<<< HEAD
<<<<<<< HEAD
			<div class="card">
				<div class="row">
					<div class="col s12">
						<a class="btn-floating btn-large waves-effect waves-light red arrow-link slide-link">
							<i class="mdi-hardware-keyboard-arrow-down"></i>
						</a>
						<h5>Mes Projets</h5>
					</div>
				</div>
				<div class="hide">
					<div class="row">
						<div class="col s12">
							<table class="responsive-table bordered striped centered col s12">
								<tr>
									<th>Numéro de Projet</th>
									<th>Nom du Projet</th>
									<th><button type="submit" name="editer" class="btn light-blue darken-2"><span class="icon-save-floppy"></span></button></th>
								</tr>
								<?php
								$_SESSION['ens']->afficheMesProjets();
								?>
							</table>
						</div>
						<div class="col s12">
							<div class="centre">
								<br/>
								<a class="btn-floating btn-large waves-effect waves-light green slide-link">
									<i class="mdi-content-add"></i>
								</a>
							</div>
						</div>
						<div class="hide col s12">
							<form action="" method="post">
								<div class="input-field"> 
									<label for="projet_name">Nom du Projet</label>
									<input type="text" name="projet_name" required>
								</div>
								<div class="input-field">
									<label for="nb_min">Nombre d'étudiants minimum</label>
									<input type="text" name="nb_min" required>
								</div>
								<div class="input-field">
									<label for="nb_max">Nombre d'étudiants maximum</label>
									<input type="text" name="nb_max" required>
								</div>
								<div class="input-field">
									<label for="contexte">Contexte</label>
									<textarea class="materialize-textarea" name="contexte" required></textarea>
								</div>
								<div class="input-field">
									<label for="objectif">Objectif</label>
									<textarea class="materialize-textarea" name="objectif" required></textarea>
								</div>
								<div class="input-field">
									<label for="contrainte">Contraintes</label>
									<textarea class="materialize-textarea" name="contrainte" required></textarea>
								</div>
								<div class="input-field">
									<label for="details">Détails</label>
									<textarea class="materialize-textarea" name="details" required></textarea>
								</div>
								<div class="input-field">
									<label for="nom_groupe">Nom Groupe</label>
									<input type="text" name="nom_groupe" required>
								</div>
								<div class="centre">
									<button type="submit" name="new_projet" class="btn light-blue darken-2">
										<span class="icon-save-floppy"></span> Enregistrer le nouveau Projet
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
=======
		<?php 
		$_SESSION['user']->afficheAccueil();
		?>
=======
			<?php 
			$_SESSION['user']->afficheAccueil();
			?>
>>>>>>> refs/heads/jeremie
		</div>
>>>>>>> refs/remotes/origin/jeremie

	<!--Import javascript-->
	<?php
	require_once("../ressources/js/javascript.php");
	?>

	</body>
	</html>
