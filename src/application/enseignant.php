<?php
session_start();

//Tableau de parammètres de la page
$param['erreur']=false;
$param['message']=null;

//Chargement des classes php
function __autoload($class) { require_once "../res/Classes/$class.php"; }

//Création des DAO
$enseignantDAO = new EnseignantsDAO(MaBD::getInstance());
$etudiantDAO = new EtudiantsDAO(MaBD::getInstance());
$projetsDAO = new ProjetsDAO(MaBD::getInstance());

//On vérifie que l'utilisateur est connecté
if(!isset($_SESSION['moi']))
{
	header("Location:index.php");
	exit();
}

//Fonction d'affichage des projets
function afficheLesProjets()
{
	global $projetsDAO;
	echo "<br/><tr><th>Numero</th><th>Sujet</th><th>Etudiants sur le projet</th></tr>";
	$mesProjets = $projetsDAO->getAllMyProjects($_SESSION['moi']->login_enseignant);
	foreach ($mesProjets as $projets)
	{
		$projets->afficheMesProjets();
	}
}

//Envoie d'un message au élèves du groupe
if (isset($_POST['envoi']))
{
	$message=trim($_POST['message']);
	$sujet=trim($_POST['sujet']);
	$_SESSION['moi']->mailToGroupOfThisProject($groupe,$sujet,$message);
}

//Ajout d'un projet
if (isset($_POST['Nouveau Projet']))
{
	$name_project=trim($_POST['projet_name']);
	$nb_min=trim($_POST['nb_min']);
	$nb_max=trim($_POST['nb_max']);
	$contexte=trim($_POST['contexte']);
	$objectif=trim($_POST['objectif']);
	$contraintes=trim($_POST['contraintes']);
	$details=trim($_POST['details']);
	
	/////////////// A modifié //////////////
	/*
	 * simplification par un simple insert
	 * création du groupe à faire avant
	 */
	$newGroupe = new Groupe(array("no_groupe" => DAO::UNKNOWN_ID));
	$newProjet = new Projet(array("nom_projet"=>$name_project,)); // à finir en fonction du nom des champs dans la BDD
	
	//$_SESSION['moi']->ajouterUnNouveauProjet($enseignant,$projet);
}

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Enseignants</title>
	
		<!-- Bootstrap -->
		<link href="../dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="../res/css/style.css" rel="stylesheet">
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<![endif]-->
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-xs-10">
					<h1>Enseignant</h1>
					<?php
					$_SESSION['moi']->afficheNP();
					?>
				</div>
				<div class="col-xs-2">
					<div class="doublecentre">
						<?php 
						$_SESSION['moi']->afficheDeconnexionButton();
						?>
					</div>
				</div>
			</div>
			<div class="row">
				<h2>Mes Projets</h2>
			</div>
			<div class="row">
				<table class="table table-bordered table-striped table-condensed">
					<?php
					afficheLesProjets();
					?>
				</table>
			</div>
			
			<input type="button" name="new_projet" value="Nouveau Projet" onclick="DisplayFormVisible();"><br/>
			<div id="formDiv">
				<form action="" method="post">
							<div class="form-group">
					<br/><input type="text" name="projet_name" placeholder="Nom Projet" class="form-control" required><br/>
					<input type="text" name="nb_min" placeholder="Nombre minimal" class="form-control" required><br/>
					<input type="text" name="nb_max" placeholder="Nom maximum" class="form-control" required><br/>
					<textarea rows="5" cols="25" name="contexte" placeholder="Contexte" class="form-control"></textarea><br/>
					<textarea rows="5" cols="25" name="objectif" placeholder="Objectif" class="form-control"></textarea><br/>
					<textarea rows="5" cols="25" name="contraintes" placeholder="Contraintes" class="form-control"></textarea><br/>
					<textarea rows="5" cols="25" name="details" placeholder="Details" class="form-control"></textarea><br/>
					<div class="centre">
						<button type="submit" name="new_projet" class="btn btn-primary btn-primary">
							<span class="glyphicon glyphicon-folder-open"></span> Nouveau Projet
						</button>
					</div>
					</div>
				</form>
			</div>
			<div class="row">
				<h2>Envoyer un mail au groupe du projet</h2>
			</div>
			<div class="row">
				<form action="" method="post">
							<div class="form-group">
					<input type="text" name="sujet" placeholder="Sujet" class="form-control" required><br/>
					<textarea rows="5" cols="50" name="message" placeholder="Message" class="form-control"></textarea><br/>
					<div class="centre">
						<button type="submit" name="envoi" class="btn btn-primary">
							<span class="glyphicon glyphicon-envelope"></span> Envoyer
						</button>
					</div>
					</div>
				</form>
			</div>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="../dist/js/bootstrap.min.js"></script>
		<script src="../res/js/ourJS.js"></script>
	</body>
</html>