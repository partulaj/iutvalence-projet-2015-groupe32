<?php
session_start();

//pour le debug
//print_r($_POST);

//Chargement des classes php
function __autoload($class) { require_once "../ressources/classes/$class.php"; }

//Tableau de parammètres de la page
$param['erreur']=false;
$param['reussi']=false;
$param['message']=null;
//Création des DAO
$projetDAO = new ProjetsDAO(MaBD::getInstance());
$etudiantDAO = new EtudiantsDAO(MaBD::getInstance());
$voeuxDAO = new VoeuxDAO(MaBD::getInstance());

//On vérifie que l'utilisateur est connecté 
if (!isset($_SESSION['moi']->login_etudiant))
{
	header("Location:index.php");
	exit();
}

//
$affectationProjet=$projetDAO->getAll();
foreach ($affectationProjet as $projetAAffecter)
{
	$projetAAffecter->initAffectationAuto();
}

//Enregistrement du ou des voeux
if (isset($_POST['enregistrer']))
{
	// Si l'étudiant à + de 5 voeux on affiche un message d'erreur
	if ($_SESSION['moi']->nb_voeux == 5)
	{
		$param['erreur']=true;
		$param['message']="Vous ne pouvez pas faire plus de 5 voeux, si vous voulez ajouter un voeux il vous faut d'abord en enlever un";
		break;
	}
	
	else 
	{
		$tabVoeux = $_POST['projets'];//on récupère le tableau des voeux 
		$tabPriorite = $_POST['priorite'];//on récupère le tableau des priorités
		for ($i=0; $i<count($tabVoeux); $i++)
		{
			$search= array($tabVoeux[$i],$_SESSION['moi']->login_etudiant);
			if($voeuxDAO->getOne($search)!=null)
			{
				$param['erreur']=true;
				$param['message']="Vous ne pouvez pas faire 2 fois le même voeu";
				break;
			}

			if ($_SESSION['moi']->nb_voeux == 5)
			{
				$param['erreur']=true;
				$param['message']="Vous avez atteint le nombres maximum de voeux";
			}
			else
			{
				if ($tabPriorite[$i]!=0)//si le voeu a une priorité différente de 0 on l'ajoute 
				{
					$num = $_SESSION['moi']->nb_voeux+1;
					$dateBrut = new DateTime();
					$date = $dateBrut->format('Y-m-d');
					$prioriteVoeu = $tabPriorite[$i];
					$projet = $tabVoeux[$i];
					$etudiant = $_SESSION['moi']->login_etudiant;
					$voeu = new Voeu (array("date"=>$date,"priorité"=>$prioriteVoeu,"no_projet"=>$projet,"login_etudiant"=>$etudiant));
					$voeuxDAO->insert($voeu);
					$_SESSION['moi']->nb_voeux = $num;//on ajoute un au nombre de voeu de l'étudiant
					$etudiantDAO->update($_SESSION['moi']);
				}
			}
		}
	}
}

//Supression d'un voeu
if (isset($_POST['supprimer_voeux']))
{
	$search = array($_POST['voeuToEdit'],$_SESSION['moi']->login_etudiant);
	$voeuSupp = $voeuxDAO->getOne($search);
	$voeuxDAO->delete($voeuSupp);
	$_SESSION['moi']->nb_voeux = $_SESSION['moi']->nb_voeux-1;
	$etudiantDAO->update($_SESSION['moi']);
}

//Modification d'un voeu
if (isset($_POST['modifier_voeux']))
{
	$search = array($_POST['voeuToEdit'],$_SESSION['moi']->login_etudiant);
	$voeuMod = $voeuxDAO->getOne($search);
	$voeuMod->priorité = $_POST['prioriteVoeuEdit'];
	$voeuxDAO->update($voeuMod);
	$param['reussi']=true;
	$param['message']="La modification de vos voeux à bien était faites";
}

//Fonction d'affichage des projet 
function afficheProjet()
{
	global $projetDAO;
	$lesProjets = $projetDAO->getAll(); // à changer pour ne pas afficher les projets déjà affectés
	foreach ($lesProjets as $projet)
	{
		if ($projet->affecter==0)
		{
			$projet->afficheHtml();
		}
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

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Etudiant</title>

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
		$_SESSION['moi']->afficheNavBar();
		?>
		<div class="container">
			<div class="row">
				<?php 
				if ($param['erreur']!=false)
				{
					echo "<div class='alert alert-danger'>",$param['message'],"</div>";
				}
				if ($param['reussi']==true)
				{
					echo "<div class='alert alert-success'>",$param['message'],"</div>";
				}
				?>
				<div class="col-sm-6">
					<h3>Liste des projets</h3>
					<p>Choisissez 5 projets parmis la liste si dessous et régler la priorité que vous souhaitez leur affecter entre 1 et 3:</p>
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
				<div class="col-sm-6">
					<h3>Recapitulatif des voeux choisi:</h3>
					<p>Voici la liste des voeux que vous avez fait ordonner par priorité</p>
					<table class="table table-bordered table-striped table-condensed">
						<tr>
							<th>Numero de projet</th>
							<th>Nom du projet</th>
							<th>Tuteur</th>
						</tr>
						<?php afficheVoeux();?>
					</table>
				</div>
			</div>
		</div>
		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- JavaScript -->
		<script src="../dist/js/bootstrap.min.js"></script>
		<script src="../ressources/js/ourJS.js"></script>
	</body>
	</html>