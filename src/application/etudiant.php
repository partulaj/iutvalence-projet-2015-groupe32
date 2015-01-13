<?php
session_start();

//Tableau de parammètres de la page
$param['erreur']=false;
$param['message']=null;

//Chargement des classes php
function __autoload($class) { require_once "../res/Classes/$class.php"; }

$projetDAO=new ProjetsDAO(MaBD::getInstance());
$etudiantDAO = new EtudiantsDAO(MaBD::getInstance());
$voeuxDAO = new VoeuxDAO(MaBD::getInstance());

if (!isset($_SESSION['moi']))
{
  header("Location:index.php");
  exit();
}

echo '<?xml version="1.0" encoding="ISO-8859-1" ?>';

function afficheProjet()
{
  global $projetDAO;
  $lesProjets=$projetDAO->getAll();
  foreach ($lesProjets as $projet)
  {
  	$projet->afficheHtml();
  }
}

function afficheVoeux()
{
	global $voeuxDAO;
	$lesVoeux = $voeuxDAO->getAllEtudiant();
	foreach($lesVoeux as $voeux)
	{
		$voeux->afficheVoeu();
	}
}

public function enregistrer($_POST['enregistrer'])
{
	
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
    <link href="../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <h1>Projet etudiant</h1>
  <?php 
    $_SESSION['moi']->afficheEtudiantBox();
  ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    
    <table>
    	<th>Numero de projet</th> <th>Nom du Projet</th> <th>Numero de voeux</th> 
    	<?php afficheProjet(); ?>
    </table>
    <form method='post' action=''>
	    <input type='submit' name='enregistrer' value='enregistrer' >
    </form>
    <h3>Recapitulatif des voeux choisi:</h3>
    <table>
    	<?php afficheVoeux();?>
    </table>
    
  </body>
</html>