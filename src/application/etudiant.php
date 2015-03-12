<?php
/**
 * Page d'accueil des étudiants 
 * @package application
 * @author Audrey, Jérémie
 * @version 1.3
 */
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
$tachesDAO = new TachesDAO(MaBD::getInstance());

//On vérifie que l'utilisateur est connecté 
if (!isset($_SESSION['etu']->login_etudiant))
{
	header("Location:index.php");
	exit();
}

//On lance l'affectation automatique
$affectationProjet=$projetDAO->getAll();
foreach ($affectationProjet as $projetAAffecter)
{
	$projetAAffecter->initAffectationAuto();
}

//Enregistrement du ou des voeux
if (isset($_POST['enregistrer']))
{
	// Si l'étudiant à + de 5 voeux on affiche un message d'erreur
	if ($_SESSION['etu']->nb_voeux == 5)
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
			$search= array($tabVoeux[$i],$_SESSION['etu']->login_etudiant);
			if($voeuxDAO->getOne($search)!=null)
			{
				$param['erreur']=true;
				$param['message']="Vous ne pouvez pas faire 2 fois le même voeu";
				break;
			}

			if ($_SESSION['etu']->nb_voeux == 5)
			{
				$param['erreur']=true;
				$param['message']="Vous avez atteint le nombres maximum de voeux";
			}
			else
			{
				if ($tabPriorite[$i]!=0)//si le voeu a une priorité différente de 0 on l'ajoute 
				{
					$num = $_SESSION['etu']->nb_voeux+1;
					$dateBrut = new DateTime();
					$date = $dateBrut->format('Y-m-d');
					$prioriteVoeu = $tabPriorite[$i];
					$projet = $tabVoeux[$i];
					$etudiant = $_SESSION['etu']->login_etudiant;
					$voeu = new Voeu (array("date"=>$date,"priorite"=>$prioriteVoeu,"no_projet"=>$projet,"login_etudiant"=>$etudiant));
					$voeuxDAO->insert($voeu);
					$_SESSION['etu']->nb_voeux = $num;//on ajoute un au nombre de voeu de l'étudiant
					$etudiantDAO->update($_SESSION['etu']);
				}
			}
		}
	}
}

//Supression d'un voeu
if (isset($_POST['supprimer_voeux']))
{
	$search = array($_POST['voeuToEdit'],$_SESSION['etu']->login_etudiant);
	$voeuSupp = $voeuxDAO->getOne($search);
	$voeuxDAO->delete($voeuSupp);
	$_SESSION['etu']->nb_voeux = $_SESSION['etu']->nb_voeux-1;
	$etudiantDAO->update($_SESSION['etu']);
}

//Modification d'un voeu
if (isset($_POST['modifier_voeux']))
{
	$search = array($_POST['voeuToEdit'],$_SESSION['etu']->login_etudiant);
	$voeuMod = $voeuxDAO->getOne($search);
	$voeuMod->priorite = $_POST['prioriteVoeuEdit'];
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
/**
 * Foncion qui récupère les voeux et les affiche dans un tableau
 * @author Jérémie
 * @version 1.0
 */
function afficheVoeux()
{
	global $voeuxDAO;
	$lesVoeux = $voeuxDAO->getAllVoeuEtudiant($_SESSION['etu']->login_etudiant);
	foreach($lesVoeux as $voeux)
	{
		$voeux->afficheVoeu();
	}
}

//Fonction qui recupaire et affiche les taches du projet associer à l'etudiant
function afficheToutesLesTaches()
{
	global $tachesDAO;
	$lesTaches = $tachesDAO->getAllTacheEtudiant($_SESSION['etu']->no_projet);
	foreach($lesTaches as $tache)
	{
		$tache->afficheTache();
	}
}
/*
//Ajout d'une tache à la liste de tache
if (isset($_POST['ajouterTache']))
{
	
	$nom_tache = $_POST['nomTache'];
	$avancement = $_POST['avencement'] ; 
	$no_projet = $_SESSION['etu']->no_projet;
	$login_etudiant = $_SESSION['etu']->login_etudiant;
	$id_tache_mere = "0"; // a modifier
	
	$tache = new Taches(array(
			"no_tache" => DAO::UNKNOWN_ID,
			"nom_tache" => $nom_tache,
			"avancement" => $avancement,
			"no_projet" => $no_projet,
			"login_etudiant" => $login_etudiant,
			"no_tache_mere" => $id_tache_mere
	) );
	$tachesDAO->insert(tache);
}

//Modification d'une tache
if (isset($_POST['modification_tache']))
{
}

//suppression d'une tache
if (isset($_POST['suppression_tache']))
{
}
*/
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Etudiant</title>
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
	<body class="brown lighten-5">
		<?php 
		$_SESSION['etu']->afficheNavBar();
		?>
		<div class="container brown lighten-5">
			<div class="card">
				<div class="row">
					<div class="col s12">
						<a class="btn-floating btn-large waves-effect waves-light red arrow-link slide-link">
							<i class="mdi-hardware-keyboard-arrow-down"></i>
						</a>
						<h5>Liste des Projets</h5>
						<p>Choisissez jusqu'a 5 projets parmis la liste des projets proposé en dessou</p>
					</div>
				</div>
				<form class="hide" method="post" action="">
					<table class="responsive-table bordered striped ">
						<tr>
							<th>Numero de projet</th>
							<th>Nom du Projet</th>
							<th>Tuteur</th>
							<th>Priorité du voeu</th>
							<th>Fiche du Projet</th>
						</tr> 
						<?php afficheProjet(); ?>
					</table><br/>
					<div class="centre">
						<button type="submit" name="enregistrer" class="btn light-blue darken-2">
							<span class="icon-ok"></span> Enregistrer
						</button>
					</div>
				</form>
			</div>

			<div class="card">
				<div class="row">
					<div class="col s12">
						<a class="btn-floating btn-large waves-effect waves-light red arrow-link slide-link">
							<i class="mdi-hardware-keyboard-arrow-down"></i>
						</a>
						<h5>Recapitulatif des voeux choisi:</h5>
						<p>Voici la liste des voeux que vous avez fait ordonner par priorité</p>
					</div>
				</div>
				<table class="responsive-table bordered striped centered hide">
					<tr>
						<th>Numero de projet</th>
						<th>Nom du projet</th>
						<th>Tuteur</th>
						<th>Priorité du voeu</th>
					</tr>
					<?php afficheVoeux();?>
				</table>
			</div>
		</div>
		<div class="row">
			<h5>Mon Projet</h5>
			<form>
				<?php //afficheToutesLesTaches(); ?>
				<form action="" method="post">
					<div class="input-field"> 
						<label for="nomTache">Nom de la tache</label>
						<input type="text" name="nomTache" required>
					</div>
					<div class="input-field">
						<label for="avencement">Nombre representent l'avancement</label>
						<input type="text" name="avencement" required>
					</div>
					<div class="">
						<button type="submit" name="ajouterTache" class="btn">
							<span class=""></span> Ajouter une tache
						</button>
					</div>
				</form>
			</form>
		</div>
		
		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
		<script src="../ressources/js/ourJS.js"></script>
		<?php 
		if ($param['erreur']!=false)
		{
			echo 	"<script>toast('",$param['message'],"', 4000)</script>";
		}
		if ($param['reussi']==true)
		{
			echo 	"<script>toast('",$param['message'],"', 4000)</script>";
		}
		?>
	</body>
	</html>
