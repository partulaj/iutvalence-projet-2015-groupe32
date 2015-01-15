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

if (isset($_POST['deconnexion']))
{
	session_destroy();
}
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
			<div class="container">
				<h1>Accueil</h1>
				<div class="row">
					<div class="centre col-xs-12">
						<h3>Identification</h3>
					</div>
				</div>
				
				<article>
					<form action="" method="post" id="connexion">

						<?php

					//Affichage d'un message
						if ($param['erreur']==true)
						{
							echo 	"<div class='row'>
										<p class='erreur doublecentre'>",$param['message'],"</p>
									</div>";
						}
						?>

						<div class="row">
							<div class="form-group">
								<label class="control-label">Login</label>
								<input type="text" name="login" class="form-control input-index">
								<span class="cache glyphicon glyphicon-remove form-control-feedback"></span>
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label class="control-label">Mot de passe</label>
								<input type="password" name="mdp" class="form-control">
								<span class="cache glyphicon glyphicon-remove form-control-feedback"></span>
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<div class="centre">
									<button type="submit" name="connection" class="btn btn-primary">
										<span class="glyphicon glyphicon-user"></span> Connexion
									</button>
								</div>
							</div>
						</div>

					</form>
				</article>
			</div>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="../dist/js/bootstrap.min.js"></script>
		<script src="../res/js/ourJS.js"></script>
	</body>
	</html>
