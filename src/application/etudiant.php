<?php
session_start();

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

function afficheProjet()
{
  global $projetDAO;
  $lesProjets = $projetDAO->getAll();
  foreach ($lesProjets as $projet)
  {
  	$projet->afficheHtml();
  }
}

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

if(isset($_POST['enregistrer']))
{
	global $voeuxDAO;
	$now = new DateTime();
	$levoeu = new Voeu(array("no_voeu"=> DAO::UNKNOWN_ID, "date"=> $now->format('y-m-d'), "priorité"=>$_POST["priorite"], "no_projet"=>$_POST["noprojet"], "login_etudiant"=> $_SESSION['moi']->login_etudiant));
	$voeuxDAO->insert($levoeu);
}
/*
if(isset($_POST['modifier']))
{
	global $voeuxDAO;
	$voeuxDAO->update($no_voeux);
}

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
        <h1>Projet etudiant</h1>
        <?php 
        $_SESSION['moi']->afficheEtudiantBox();
        ?>
        <h3>Choisissez 5 projets parmis la liste si dessous et ordoner les de 1 à 5 par ordre de priorité:</h3>
        <div class="row">
            <table class="table table-bordered table-striped table-condensed">
                <tr>
                    <th>Numero de projet</th>
                    <th>Nom du Projet</th>
                    <th>Tuteur</th>
                    <th>Priorité du voeu</th>
                </tr> 
                <?php afficheProjet(); ?>
            </table>
        </div>

        <h3>Recapitulatif des voeux choisi:</h3>
        <table>
            <tr><th>Numero de voeux</th><th>Numero de projet</th></tr>
            <?php afficheVoeux();?>
        </table>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="../res/js/ourJS.js"></script>
</body>
</html>