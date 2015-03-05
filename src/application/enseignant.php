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
if (isset($_POST['new_projet'])) {
	$groupesDAO = new GroupesDAO ( MaBD::getInstance () );
	
	$name_project = trim ( $_POST ['projet_name'] );
	$nb_min = trim ( $_POST ['nb_min'] );
	$nb_max = trim ( $_POST ['nb_max'] );
	$contexte = trim ( $_POST ['contexte'] );
	$objectif = trim ( $_POST ['objectif'] );
	$contrainte = trim ( $_POST ['contrainte'] );
	$details = trim ( $_POST ['details'] );
	$nom_groupe = trim($_POST['nom_groupe']);

	$newProjet = new Projet(array(
		"no_projet" => DAO::UNKNOWN_ID,
		"nom_projet" => $name_project,
		"nb_etu_min" => $nb_min,
		"nb_etu_max" => $nb_max,
		"contexte" => $contexte,
		"objectif" => $objectif,
		"contrainte" => $contrainte,
		"details" => $details,
		"login_enseignant" => $_SESSION['ens']->login_enseignant
		) );
	$projetsDAO->insert($newProjet);
	var_dump($newProjet);
	$newGroupe = new Groupe (array (
		"no_projet" => $newProjet->no_projet,
		"nom_groupe" => $_POST['nom_groupe'] 
		) );
	$groupesDAO->insert($newGroupe);

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
		$_SESSION ['ens']->afficheNavBar ();
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
									<th><button type="submit" name="editer" class="icon-edit-floppy"><button type="submit" name="tableau" class="icon-calendar-floppy"><button type="submit" name="mail" class="icon-message-new"></th>
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

			<div class="card">
				<div class="row">
					<div class="col s12">
						<a class="btn-floating btn-large waves-effect waves-light red arrow-link slide-link">
							<i class="mdi-hardware-keyboard-arrow-down"></i>
						</a>
						<h5>Envoyer un mail au groupe du projet</h5>
					</div>
				</div>
				<form class="hide" action="" method="post">
					<label for="projet">Projet</label>
					<select name="projet">
						<option value="" disabled selected>Choose your option</option>
						<option value="1">Option 1</option>
						<option value="2">Option 2</option>
						<option value="3">Option 3</option>
					</select>
					<div class="input-field">
						<label for="sujet">Sujet</label>
						<input type="text" name="sujet" class="form-control" required>
					</div>
					<div class="input-field">
						<label for="message">Message</label>
						<textarea class="materialize-textarea" name="message" required></textarea>
					</div>
					<div class="centre">
						<button type="submit" name="envoi" class="btn light-blue darken-2">
							<span class="mdi-communication-email"></span> Envoyer
						</button>
					</div>
				</form>
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