<?php
session_start();

//Tableau de parammètres de la page
$param['erreur']=false;
$param['message']=null;

//Chargement des classes php
function __autoload($class) { require_once "../res/Classes/$class.php"; }

$etudiantsDAO = new EtudiantsDAO(MaBD::getInstance());
$enseignantsDAO = new EnseignantsDAO(MaBD::getInstance());
$chefsDAO = new ChefsDAO(MaBD::getInstance());

if (isset($_POST['connection']))
{
	// On enlève les espace en début et fin 
	$login=trim($_POST['login']);
	$mdp=trim($_POST['mdp']);

	// Redirection si l'utilisateur est un Etudiant
	$moi=$etudiantsDAO->getOne($login);
	if (($moi!=null) and ($moi->mdp_etudiant==$mdp))
	{
		$_SESSION['moi']=$moi;
		header("Location:etudiant.php");
		exit();	
	}

	// Redirection si l'utilisateur est un Enseignant	
	$moi=$enseignantsDAO->getOne($login);
	if (($moi!=null) and ($moi->mdp_enseignant==$mdp))
	{
		$_SESSION['moi']=$moi;
		header("Location:enseignant.php");
		exit();	
	}

	// Redirection si l'utilisateur est le Chef des projets
	$moi=$chefsDAO->getOne($login);
	if (($moi!=null) and ($moi->mdp_chef==$mdp))
	{
		$_SESSION['moi']=$moi;
		header("Location:chef.php");
		exit();	
	}

	// Message d'erreur en cas d'utilisateur introuvable ou mod de passe invalide
	else
	{
		$param['erreur']=true;
		$param['message']="Login ou mot de passe invalide";
	}
}


?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accueil</title>

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
    <h1>Accueil</h1>
	<article>
		<h2>Identification</h2>
		<form action="" method="post">
			<?php
				if ($param['erreur']==true)
				{
					echo "<p class='erreur'>",$param['message'],"</p>";
				}
			?>
			<label>Login</label>
			<input type="text" name="login"><br/>
			<label>Mot de passe</label>
			<input type="password" name="mdp"><br/>
			<input type="submit" name="connection" value="Se connecter">
		</form>
	</article>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
