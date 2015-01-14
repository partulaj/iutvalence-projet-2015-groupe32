<?php
session_start();

//Tableau de parammètres de la page
$param['erreur']=false;
$param['message']=null;

//Chargement des classes php
function __autoload($class) { require_once "../res/Classes/$class.php"; }


$enseignantDAO = new EnseignantsDAO(MaBD::getInstance());
$etudiantDAO = new EtudiantsDAO(MaBD::getInstance());
$projetsDAO = new ProjetsDAO(MaBD::getInstance());


if(!isset($_SESSION['moi']))
{
  header("Location:index.php");
  exit();
}

function afficheMesProjets()
{
	global $projetsDAO;
	$mesProjets = $projetsDAO->getAllMyProjects($_SESSION['moi']->login_enseignant);
	
	echo "<tr><th>Sujet</th><th>Contexte</th><th>Objectif</th><th>Contrainte</th><th>Details</th></tr>";
	foreach ($mesProjets as $projets)
	{
		$projets->afficheProjetsRow();
	}
}

function afficheMesEtudiants($array)
{
	echo "<tr><th>Nom Etudiant</th><th>Prénom</th></tr>";
	foreach ($array as $etudiant)
	{
		$etudiant->afficheMyEtudiants();
	}
}

if (isset($_POST['envoi']))
{
	$message=trim($_POST['message']);
	$sujet=trim($_POST['sujet']);
	$_SESSION['moi']->mailToGroupOfThisProject($groupe,$sujet,$message);
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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <h1>Enseignant</h1>
     <?php 
    $_SESSION['moi']->afficheEnseignant();  
    ?>
    <section>
      <article id= "enseignant-mail">
      <h2>Envoyer un mail au groupe du projet</h2>
      <form action="" method="post">
      		<input type="text" name="sujet" placeholder="Sujet" required><br/>
      		<textarea rows="5" cols="50" name="message" placeholder="Message"></textarea><br/>
      		<input type="submit" name="envoi" value="Envoyer un message au groupe du projet">
      	</form>
        <table class="table table-bordered table-striped table-condensed">
        <?php
          afficheMesProjets();
        ?>
        </table>
        </article>
    </section>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>