<?php
session_start();

//Tableau de parammètres de la page
$param['erreur']=false;
$param['message']=null;

//Chargement des classes php
function __autoload($class) { require_once "../res/Classes/$class.php"; }

//Création des DAO
$projetDAO = new ProjetsDAO(MaBD::getInstance());
$etudiantDAO = new EtudiantsDAO(MaBD::getInstance());
$voeuxDAO = new VoeuxDAO(MaBD::getInstance());

//On vérifie que l'utilisateur est connecté 
if (!isset($_SESSION['moi']))
{
	header("Location:index.php");
	exit();
}

//Enregistrement du ou des voeux
/*
 * vérifier le fonctionnement
 * finir l'implémentation de l'attribut nb_voeux
 */
if (isset($_POST['enregistrer']))
{
	// Si l'étudiant à + de 5 voeux on affiche un message d'erreur
	if ($_SESSION['moi']->nb_voeux == 5)
	{
		$param['erreur']=true;
		$param['message']="Vous ne pouvez pas faire plus de 5 voeux, si vous voulez ajouter un voeux il vous faut d'abord en enlever un";
	}
	else 
	{
		$tabVoeux = $_POST['voeux'];
		$tabPriorite = $_POST['priorite'];
		$_SESSION['moi']->nb_voeux = $_SESSION['moi']->nb_voeux + 1;
		for ($i=0; $i<count($_POST)-1; $i++)
		{
			if ($_SESSION['moi']->nb_voeux == 5)
			{
				$param['erreur']=true;
				$param['message']="Vous avez atteint le nombres maximum de voeux";
			}
			else
			{
				$num = $_SESSION['moi']->nb_voeux;
				$dateBrut = new DateTime();
				$date = $dateBrut->format('Y-m-d');
				$prioriteVoeu = $tabPriorite[$i];
				$projet = $tabVoeux[$i];
				$etudiant = $_SESSION['moi']->login_etudiant;
				$voeu = new Voeu (array("no_voeu"=>$num,"date"=>$date,"priorité"=>$prioriteVoeu,"no_projet"=>$projet,"login_etudiant"=>$etudiant));
				$voeuxDAO->insert($voeu);
				echo "insert";
				$etudiantDAO->update($_SESSION['moi']);
				echo "update";
			}
		}
	}
}

//Fonction d'affichage des projet 
function afficheProjet()
{
	global $projetDAO;
	$lesProjets = $projetDAO->getAll(); // à changer pour ne pas afficher les projets déjà affectés
	foreach ($lesProjets as $projet)
	{
		$projet->afficheHtml();
	}
}

//Fonction d'affichage des voeux 
function afficheVoeux()
{
	global $voeuxDAO;
	$lesVoeux = $voeuxDAO->getAllVoeuEtudiant($_SESSION['moi']->login_etudiant);
	
	foreach($lesVoeux as $voeux)
	{
		$voeux->afficheVoeu();
	}
}

echo '<?xml version="1.0" encoding="ISO-8859-1" ?>';
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Etudiant</title>

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
					<h1>Etudiant</h1>
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
				<h3>Liste des projets</h3>
				<p>Choisissez 5 projets parmis la liste si dessous et régler la priorité que vous souhaitez leur affecter entre 1 et 3:</p>
			</div>
			<div class="row">
				<form method="post" action="">
					<table class="table table-bordered table-striped table-condensed">
						<tr>
							<th>Numero de projet</th>
							<th>Nom du Projet</th>
							<th>Tuteur</th>
							<th>Priorité du voeu</th>
						</tr> 
						<?php afficheProjet(); ?>
					</table>
					<div class="centre">
						<button type="submit" name="enregistrer" class="btn btn-success">
							<span class="glyphicon glyphicon-ok"></span> Enregistrer
						</button>
					</div>
				</form>
			</div>
				<div class="row">
					<h3>Recapitulatif des voeux choisi:</h3>
				</div>
				<div class="row">
					<table class="table table-bordered table-striped table-condensed">
						<tr>
							<th>Numero de voeux</th>
							<th>Numero de projet</th>
						</tr>
						<?php afficheVoeux();?>
					</table>
				</div>
			</div>
			<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
			<!-- Include all compiled plugins (below), or include individual files as needed -->
			<script src="js/bootstrap.min.js"></script>
			<script src="../res/js/ourJS.js"></script>
	</body>
</html>