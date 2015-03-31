<?php
/**
 * Page de connexion
 * @package application
 * @author Jérémie
 * @version 1.0
 */
//Autochargement des classes via un Autoloader
require_once "../ressources/classes/MyAutoloader.php";
require_once "../ressources/LDAPAuth/LDAPAuth.php";

session_start();

//Tableau de paramètres de la page
$param['erreur']=false;
$param['message']=null;



//Création des DAO
$etudiantsDAO = new EtudiantsDAO(MaBD::getInstance());
$enseignantsDAO = new EnseignantsDAO(MaBD::getInstance());
$chefsDAO = new ChefsDAO(MaBD::getInstance());

//Déconnexion
if (isset($_POST['deconnexion']))
{
	session_destroy();
}
if (isset($_SESSION['user'])) 
{
	if (isset($_SESSION['user']->login_etudiant)) 
	{
		header("Location:etudiant.php");
		exit();	
	}
	if (isset($_SESSION['user']->login_enseignant))
	{
		header("Location:enseignant.php");
		exit();	
	}
	if (isset($_SESSION['user']->login_chef)) 
	{
		header("Location:chef.php");
		exit();	
	}

}

//Connexion
if (isset($_POST['connexion']))
{
	// On enlève les espace en début et fin 
	$login=trim($_POST['login']);
	$mdp=trim($_POST['mdp']);
	//$info= LDAPAuthentification($login, $mdp);
	//if($info!=null)
	//{
		// Redirection si l'utilisateur est un Etudiant
		$moi=$etudiantsDAO->getOne($login);
		if ($moi!=null)
		{
			$_SESSION['user']=$moi;
			header("Location:etudiant.php");
			exit();	
		}

		// Redirection si l'utilisateur est un Enseignant	
		$moi=$enseignantsDAO->getOne($login);
		if ($moi!=null)
		{
			$_SESSION['user']=$moi;
			header("Location:enseignant.php");
			exit();	
		}

		// Redirection si l'utilisateur est le Chef des projets
		$moi=$chefsDAO->getOne($login);
		if ($moi!=null)
		{
			$_SESSION['user']=$moi;
			header("Location:chef.php");
			exit();	
		}
	//}
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
	<title>Accueil</title>
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
		<nav>
			<div class="nav-wrapper light-blue">
				<a href="#" class="brand-logo"><i class="mdi-action-home"></i>Accueil</a>
			</div>
		</nav>
		<div class="container brown lighten-5">
			<div class="card">
				<div class="row">
					<div class="centre col-xs-12">
						<h4>Identification</h4>
					</div>
				</div>
				<form action="" method="post" id="connexion">
					<div class="row">
						<div class="input-field col s12">
							<label for="login">Login</label>
							<input type="text" name="login" class="validate">
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<label for="mdp">Mot de passe</label>
							<input type="password" name="mdp" class="validate">
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<div class="centre">
								<button type="submit" name="connexion" class="waves-effect waves-light btn light-blue">
									<i class="mdi-action-account-circle"></i> Connexion
								</button>
							</div>
						</div>
					</div>
				</form>
		</div>
	</div>

<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script type="text/javascript" src="../materialize/js/materialize.js"></script>
		<script type="text/javascript" src="../ressources/autosize/autosize.js"></script>
		<script src="../ressources/js/init.js"></script>
		<script src="../ressources/js/etudiant.js"></script>
		<script src="../ressources/js/tache.js"></script>
		<script src="../ressources/js/voeu.js"></script>
		<script src="../ressources/js/projet.js"></script>
		<script src="../ressources/js/easteregg.js"></script>

	<?php
		//Affichage d'un message
	if ($param['erreur']==true)
	{
		echo 	"<script>toast('",$param['message'],"', 4000)</script>";
	}
	?>
</body>
</html>
