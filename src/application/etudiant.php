<?php
session_start();
print_r($_POST);
//Tableau de parammètres de la page
$param['erreur']=false;
$param['message']=null;

//Chargement des classes php
function __autoload($class) { require_once "../res/Classes/$class.php"; }

$projetDAO = new ProjetsDAO(MaBD::getInstance());
$etudiantDAO = new EtudiantsDAO(MaBD::getInstance());
$voeuxDAO = new VoeuxDAO(MaBD::getInstance());

 //On vérifie que l'utilisateur est connecté 
if (!isset($_SESSION['moi']))
{
	header("Location:index.php");
	exit();
}

echo '<?xml version="1.0" encoding="ISO-8859-1" ?>';

//on affiche la liste des projets
function afficheProjet()
{
	global $projetDAO;
	$lesProjets = $projetDAO->getAll(); // à changer pour ne pas afficher les projets déjà affectés
	foreach ($lesProjets as $projet)
	{
		$projet->afficheHtml();
	}
}

//on affiche la liste des voeux (allent de 0 à 5) 
function afficheVoeux()
{
	global $voeuxDAO;
	$lesVoeux = $voeuxDAO->getAllVoeuEtudiant($_SESSION['moi']->login_etudiant);
	//sort($lesVoeux, SORT_NUMERIC); //trie les voeux de façon ordonée
	foreach($lesVoeux as $voeux)
	{
		$voeux->afficheVoeu();
	}
}

if (isset($_POST))
{
	for ($i=1; $i < (count($_POST)+1)/2; $i++) { 
		if($_POST["priorite_$i"]!=0)
		{
			$num = $_SESSION['moi']->nb_voeux+1;
			if ($num<=5) 
			{
				$date = new DateTime();
				$priorite = $_POST["priorite_$i"];
				$projet = $_POST["voeux_$i"];
				$etudiant = $_SESSION['moi']->login_etudiant;
				$voeu = new Voeu ($num,$date,$priorite,$projet,$etudiant);
				$voeuxDAO->insert($voeu);
			}
		}
	}
}

//on enregistre les voeux dans la base de donnée
// if(isset($_POST['enregistrer']))
// {
// global $voeuxDAO, $projetDAO;
// 	$lesProjets = $projetDAO->getAll();
//	$lesVoeux = $voeuxDAO->getAllVoeuEtudiant($_SESSION['moi']->login_etudiant);
// 	$now = new DateTime();
// 	if(count($lesVoeux) > 5)
// 	{
// 		echo "ERREUR: vous avez déjà fait 5 voeux!" ;
// 	}
// 	esle
// 	{
// 		foreach($lesProjets as $projet) //pour tous les projets
// 		{
// 			if(isset($_POST["priorite"])) //si la priorité a été modifier on crée un voeu
// 			{
// 				$levoeu = new Voeu(array("no_voeu"=> DAO::UNKNOWN_ID, "date"=> $now->format('y-m-d'), "priorité"=>$_POST["priorite"], "no_projet"=>$_POST["noprojet"], "login_etudiant"=> $_SESSION['moi']->login_etudiant));
// 				$voeuxDAO->insert($levoeu);
// 			}
// 		}
// 	}

// }
/*
//on suprime le voeu
if(isset($_POST['suprimer'])) 
{
	global $voeuxDAO;
	$voeuxDAO->delete($no_voeux);
}
*/
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
						<h1>Chef de projet</h1>
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
					<p>Choisissez 5 projets parmis la liste si dessous et régler la priorité que vous souhaitez leur affecter ebtre 1 et 3:</p>
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
						<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Enregistrer</button>
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