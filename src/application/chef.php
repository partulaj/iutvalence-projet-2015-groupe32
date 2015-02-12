<?php
/**
 * Page d'accueil du chef des projet tutorés
 * @package application
 * @author Jérémie
 * @version 1.1
 */
session_start();

/**
 * Fonction de chargement automatique des classes
 */
function __autoload($class) { require_once "../ressources/classes/$class.php"; }

//On vérifie que l'utilisateur est connecté
if (!isset($_SESSION['chef']))
{
	header("Location:index.php");
	exit();
}

$etudiantsDAO = new EtudiantsDAO(MaBD::getInstance());
$etudiantsSansProjets = $etudiantsDAO->getAllWithoutProjects();

/**
 * Fonction d'affichage des étudiant
 * Fonction qui affiche le tableau des étudiants que l'on passe en paramètre
 * $array : un tableau d'étudiants
 * @author Jérémie
 * @version 1.0
 */
function afficheTab($array)
{
	echo "<tr><th>Nom</th><th>Prénom</th></tr>";
	foreach ($array as $etudiant)
	{
		$etudiant->toTableRow();
	}
}

//Envoi d'un message au élèves sans projets
if (isset($_POST['envoi']))
{
	$message=trim($_POST['message']);
	$sujet=trim($_POST['sujet']);
	$_SESSION['chef']->mailToSansProjets($etudiantsSansProjets,$sujet,$message);
}

/*Import des étudiants via xml (à finir)*/
if (isset($_FILES['fichier_import'])) 
{
	if (is_uploaded_file($_FILES['fichier_import']['tmp_name'])==true) 
	{
		echo "File ",$_FILES['fichier_import']['name']," téléchargé avec succès.<br/>";
		$res = move_uploaded_file($_FILES['fichier_import']['tmp_name'],"./listeEtudiants.xml");
		if ($res==true) 
		{
			$xml=simplexml_load_file("./listeEtudiants.xml");
			print_r($xml);
			unlink("./listeEtudiants.xml");
		}
	}
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Chef</title>

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
		<?php 
		$_SESSION['chef']->afficheNavBar();
		?>
		<div class="container">			
			<div class="row">
				<h3>Envoyer un mail aux Sans Projet</h3>
			</div>

			<form action="" method="post">
				<div class="form-group">
					<input type="text" name="sujet" placeholder="Sujet" class="form-control" required><br/>
					<textarea class="form-control" name="message" placeholder="Message"></textarea>
				</div>
				<div class="form-group">
					<div class="centre">
						<button type="submit" name="envoi" class="btn btn-primary">
							<span class="glyphicon glyphicon-envelope"></span> Envoyer
						</button>
					</div>
				</div>
			</form>
			<div class="row">
				<h3>Liste des étudiants Sans Projet</h3>
			</div>
			<div clas="row">
				<table class="table table-bordered table-striped table-condensed">
					<?php

/**
 * Page d'accueil du chef des projet tutorés
 * @package application
 */

/**
 * Page d'accueil du chef des projet tutorés
 * @package application
 */
					afficheTab($etudiantsSansProjets);
					?>
				</table>
			</div>

			<div class="row">
				<h3>Importation des étudiants</h3>
				<form enctype="multipart/form-data" method="post" action="">
					<div class="form-group">
						<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
						<input type="file" name="fichier_import" class="form-control">
					</div>
					<div class="form-group centre">
						<button type="submit" class="btn btn-primary">
							<span class="glyphicon glyphicon-open"></span> Importer
						</button>
					</div>
				</form>
			</div>
		</div>
		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- JavaScript -->
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<script src="../ressources/js/ourJS.js"></script>
	</body>
	</html>
