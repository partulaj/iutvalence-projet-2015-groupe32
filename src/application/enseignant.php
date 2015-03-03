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
if (! isset ( $_SESSION ['user']->login_enseignant )) {
	header ( "Location:index.php" );
	exit ();
}

// Ajout d'un projet
if (isset($_POST['new_projet'])) {
	$groupesDAO = new GroupesDAO ( MaBD::getInstance () );
	
	$name_project = trim ( $_POST ['projet_name'] );
	$nb_min = trim ( $_POST ['nb_min'] );
	$nb_max = trim ( $_POST ['nb_max'] );
	$contexte = trim ( $_POST ['contexte'] );
	$objectif = trim ( $_POST ['objectif'] );
	$contrainte = trim ( $_POST ['contrainte'] );
	$details = trim ( $_POST ['details'] );

	$newProjet = new Projet(array(
		"no_projet" => DAO::UNKNOWN_ID,
		"nom_projet" => $name_project,
		"nb_etu_min" => $nb_min,
		"nb_etu_max" => $nb_max,
		"contexte" => $contexte,
		"objectif" => $objectif,
		"contrainte" => $contrainte,
		"details" => $details,
		"login_enseignant" => $_SESSION['user']->login_enseignant
		) );
	$projetsDAO->insert($newProjet);
	var_dump($newProjet);
	if (isset($_POST['nb_groupes']))
	{
		for ($i=0; $i < Groupe::NB_GROUPE_MAX; $i++) 
		{ 
			$newGroupe = new Groupe (array (
				"no_projet" => $newProjet->no_projet,
				"no_groupe" => DAO::UNKNOWN_ID
				) );
			$groupesDAO->insert($newGroupe);
		}
	}
	else
	{
		$newGroupe = new Groupe (array (
			"no_projet" => $newProjet->no_projet,
			"no_groupe" => DAO::UNKNOWN_ID
			) );
		$groupesDAO->insert($newGroupe);		
	}
	$param['reussi']=true;
	$param['message']="Votre projet à bien été créé";
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
								</tr>
								<?php
								$_SESSION['user']->afficheMesProjets();
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
								<div class="switch">
									<label>
										1 Groupe
										<input type="checkbox" name="nb_groupes">
										<span class="lever"></span>
										2 Groupes
									</label>
								</div>
								<br/>
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

			<!--Import jQuery before materialize.js-->
			<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
			<script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
			<script src="../ressources/js/ourJS.js"></script>
			<?php 
			if ($param['reussi']==true)
			{
				echo 	"<script>toast('",$param['message'],"', 4000)</script>";
			}
			?>
		</body>
		</html>