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

	<title>Chef</title>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css"  media="screen,projection"/>
	<!-- Web Hosting Hub Glyph-->
	<link rel="stylesheet" href="../whhg/css/whhg.css">
	<!-- Style Personnel -->
	<link href="../ressources/css/style.css" rel="stylesheet">
	<link rel="import" href="../ressources/component.html">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	  <![endif]-->
	</head>
	<body class="brown lighten-5">
		<?php 
		$_SESSION['chef']->afficheNavBar();
		?>
		<div class="container brown lighten-5">		
			<div class="card">
				<div class="row">
					<div class="col s12">
						<a class="btn-floating btn-large waves-effect waves-light red arrow-link slide-link">
							<i class="mdi-hardware-keyboard-arrow-down"></i>
						</a>
						<h5>Envoyer un mail aux Sans Projet</h5>
						<p>Saisissez le sujet et le contenu du mail que vous souhaiter envoyer au étudiants Sans Projet</p>
					</div>
				</div>
				<div class="hide col s12">
					<form action="" method="post">
						<div class="input-field">
							<label for="sujet">Sujet</label>
							<input type="text" name="sujet" required>
						</div>
						<div class="input-field">
							<label for="message">Message</label>
							<textarea class="materialize-textarea" name="message" required></textarea>
						</div>
						<div class="input-field">
							<div class="centre">
								<button type="submit" name="envoi" class="btn light-blue darken-2">
									<span class="mdi-communication-email"></span> Envoyer
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="card">
				<div class="row">
					<div class="col s12">
						<a class="btn-floating btn-large waves-effect waves-light red arrow-link slide-link">
							<i class="mdi-hardware-keyboard-arrow-down"></i>
						</a>
						<h5>Liste des étudiants Sans Projet</h5>
						<p>Voici la liste des étudiants qui 'nont pas encore de projet</p>
					</div>
				</div>
				<div class="col s12 hide">
					<table class="responsive-table bordered hoverable">
						<tr>
							<th>Nom</th>
							<th>Prénom</th>
						</tr>
						<?php
						afficheTab($etudiantsSansProjets);
						?>
					</table>
				</div>
			</div>

			<div class="row">
				<h4>Importation des étudiants</h4>
				<form enctype="multipart/form-data" method="post" action="">
					<div class="file-field input-field">
						<input class="file-path validate" type="text"/>
						<div class="btn light-blue darken-2">
							<span>File</span>
							<input type="file" name="fichier_import"/>
						</div>
					</div>
					<div class=""
					<button type="submit" class="btn light-blue darken-2">
						<span class="glyphicon glyphicon-open"></span> Importer
					</button>
				</div>
			</form>
		</div>

		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
		<script src="../ressources/js/ourJS.js"></script>
	</body>
	</html>
