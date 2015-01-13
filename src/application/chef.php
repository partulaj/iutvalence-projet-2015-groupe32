<?php
session_start();

//Chargement des classes php
function __autoload($class) { require_once "../res/Classes/$class.php"; }

if (!isset($_SESSION['moi']))
{
  header("Location:index.php");
  exit();
}

$etudiantsDAO = new EtudiantsDAO(MaBD::getInstance());
$etudiantsSansProjets = $etudiantsDAO->getAllWithoutProjects();

function afficheTab($array)
{
  for($i=0;$i<count($array);$i++) 
  {
    $array[$i]->afficheEtudiantBox();
  }
}

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chef de projet</title>

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
    <h1>Chef de projet</h1>
    <section>
      <article>
        <table>
        <?php
          afficheTab($etudiantsSansProjets);
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