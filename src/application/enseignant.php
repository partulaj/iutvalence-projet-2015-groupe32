<?php
/**
 * Page d'accueil des enseignants 
 * @package application
 * @author Ihab, Jérémie
 * @version 1.1
 */
session_start ();

// Tableau de parammètres de la page
$param ['erreur'] = false;
$param['reussi'] = false;
$param ['message'] = null;

/**
 * Fonction de chargement automatique des classes
 */
function __autoload($class) {
	require_once "../ressources/classes/$class.php";
}

// Création des DAO
$enseignantDAO = new EnseignantsDAO ( MaBD::getInstance () );
$etudiantDAO = new EtudiantsDAO ( MaBD::getInstance () );
$projetsDAO = new ProjetsDAO ( MaBD::getInstance () );

// On vérifie que l'utilisateur est connecté
if (! isset ( $_SESSION ['ens'] )) {
	header ( "Location:index.php" );
	exit ();
}

// Envoie d'un message au élèves du groupe
if (isset ( $_POST ['envoi'] )) {
	$message = trim ( $_POST ['message'] );
	$sujet = trim ( $_POST ['sujet'] );
	$_SESSION ['ens']->mailToGroupOfThisProject ( $groupe, $sujet, $message );
}

// Ajout d'un projet
if (isset ( $_POST ['new_projet'] )) {
	$groupesDAO = new GroupesDAO ( MaBD::getInstance () );
	
	$name_project = trim ( $_POST ['projet_name'] );
	$nb_min = trim ( $_POST ['nb_min'] );
	$nb_max = trim ( $_POST ['nb_max'] );
	$contexte = trim ( $_POST ['contexte'] );
	$objectif = trim ( $_POST ['objectif'] );
	$contrainte = trim ( $_POST ['contrainte'] );
	$details = trim ( $_POST ['details'] );
	
	$newGroupe = new Groupe ( array (
			"no_groupe" => DAO::UNKNOWN_ID 
	) );
	$groupesDAO->insert($newGroupe);
	$newProjet = new Projet ( array (
			"no_projet" => DAO::UNKNOWN_ID,
			"nom_projet" => $name_project,
			"nb_etu_min" => $nb_min,
			"nb_etu_max" => $nb_max,
			"contexte" => $contexte,
			"objectif" => $objectif,
			"contrainte" => $contrainte,
			"details" => $details,
			"login_enseignant" => $_SESSION['ens']->login_enseignant,
			"no_groupe" => $newGroupe->no_groupe
	) );
	$projetsDAO->insert($newProjet);
	$param['reussi']=true;
	$param['message']="Votre projet à bien été créé";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Enseignant</title>

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
		$_SESSION ['ens']->afficheNavBar ();
		?>
	<div class="container">
		<div class="row">
			<h2>Mes Projets</h2>
			<?php 
			if ($param['reussi']==true)
			{
				echo "<div class='alert alert-success'>",$param['message'],"</div>";
			}
			?>
		</div>
		<div class="row">
			<table class="table table-bordered table-striped table-condensed">
					<?php
					$_SESSION['ens']->afficheMesProjets();
					?>
				</table>
		</div>
		<div class="centre">
			<button type="submit" class="btn btn-primary btn-primary"
				onclick="DisplayFormVisible();">
				<span class="glyphicon glyphicon-folder-open"></span> Créer un
				Projet
			</button>
		</div>
		<div id="formDiv">
			<form action="" method="post">
				<div class="form-group">
					<br /> <input type="text" name="projet_name"
						placeholder="Nom Projet" class="form-control" required><br /> <input
						type="text" name="nb_min" placeholder="Nombre minimal"
						class="form-control" required><br /> <input type="text"
						name="nb_max" placeholder="Nombre maximum" class="form-control"
						required><br />
					<textarea rows="5" cols="25" name="contexte" placeholder="Contexte"
						class="form-control"></textarea>
					<br />
					<textarea rows="5" cols="25" name="objectif" placeholder="Objectif"
						class="form-control"></textarea>
					<br />
					<textarea rows="5" cols="25" name="contrainte"
						placeholder="Contraintes" class="form-control"></textarea>
					<br />
					<textarea rows="5" cols="25" name="details" placeholder="Details"
						class="form-control"></textarea>
					<br />
					<div class="centre">
						<button type="submit" name="new_projet"
							class="btn btn-primary btn-success">
							<span class="icon-save-floppy"></span> Enregistrer le nouveau
							Projet
						</button>
					</div>
				</div>
			</form>
		</div>
		<div class="row">
			<h2>Envoyer un mail au groupe du projet</h2>
		</div>
    		<FORM>
    			<SELECT name="nom" size="1">
    			<OPTION selected>nom d'un groupe
    			</SELECT>
    		</FORM>
		
		<div class="row">
			<form action="" method="post">
				<div class="form-group">
					<input type="text" name="sujet" placeholder="Sujet"
						class="form-control" required><br />
					<textarea rows="5" cols="50" name="message" placeholder="Message"
						class="form-control"></textarea>
					<br />
					<div class="centre">
						<button type="submit" name="envoi" class="btn btn-primary">
							<span class="glyphicon glyphicon-envelope"></span> Envoyer
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- jQuery -->
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- JavaScript -->
	<script src="../dist/js/bootstrap.min.js"></script>
	<script src="../ressources/js/ourJS.js"></script>
</body>
</html>