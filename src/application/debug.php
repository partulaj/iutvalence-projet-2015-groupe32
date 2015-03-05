<?php
/**
 * Modèle de page php pour le projet
 * @package application
 */

// Chargement des classes php
function __autoload($class) {
	require_once "../ressources/classes/$class.php";
}

/**
 * Fonction qui lance l'affectation automatique ci le nombre d'étudiant est suffisant
 * Fonction qui déclenche l'affectation automatique si le nombres d'étudiant n'ayant pas de voeux plus prioritaire est supérieur ou égale au nombre d'étudiants maximale sur le projet
 *
 * @author Jérémie
 * @version 1.2
 */
  function initAffectationAuto() {
	$res = array ();
	$DAOtemporaire = new EtudiantsDAO ( MaBD::getInstance () );
	$DAOtemporaire2 = new ProjetsDAO(MaBD::getInstance());
	$groupe = $DAOtemporaire2->getOne("1");
	$etudiantsATrier = $DAOtemporaire->getAllWithThisWish ("1");
	foreach ( $etudiantsATrier as $etudiant ) {
		if ($etudiant->aUnMeilleurVoeu ( "1" ) == false) {
			$res [] = $etudiant;
		}
	}
	if (count ( $res ) >= $groupe->nb_etu_max) {
		affectationAuto ( $res );
	}
}

function affectationAuto($tab) {
	//MaBD::getInstance()->beginTransaction();
	$DAOtemporaire = new EtudiantsDAO ( MaBD::getInstance () );
	$DAOtemporaire2 = new VoeuxDAO ( MaBD::getInstance () );
	$DAOtemporaire3 = new ProjetsDAO ( MaBD::getInstance () );
	$DAOtemporaire4 = new GroupesDAO(MaBD::getInstance());

	$groupes = $DAOtemporaire4->getAll("WHERE no_projet='1'");
	foreach ($groupes as $groupe)
	{
		echo "groupe N°",$groupe->no_groupe,"<br/>";
		if ($groupe->plein==false)
		{
			echo "Le groupe n'est pas plein","<br/>";
			echo "<pre>";
			print_r($tab);
			echo "</pre>";
			while ($i<2)
			for($i=0; $i<count($tab);)
			{
				$tab[$i]->no_groupe = $groupe->no_groupe;
				//$DAOtemporaire->update ( $tab[$i] );
				//$DAOtemporaire2->deleteAllMyWish ( $tab[$i]->login_etudiant );
				echo $tab[$i]->login_etudiant," à bien était ajouté au groupe N°",$groupe->no_groupe,"<br/>";
				unset($tab[$i]);
				echo $tab[$i];
				$tab = array_values($tab);
			}
			echo "update du groupe","<br/>";
			echo "<pre>";
			print_r($tab);
			echo "</pre>";
			//$groupe->plein=true;
			//$DAOtemporaire4->update($groupe);
		}
	}

	$groupes = $DAOtemporaire4->getAll("WHERE no_projet='1'");
	foreach ($groupes as $groupe)
	{
		if ($groupe->plein==true)
		{
			$projet->affecter=1;
		}
		else
		{
			$projet->affecter=0;
			break;
		}
	}
	if($this->affecter==1)
	{
		echo "Update du projet et effacement des voeux","<br/>";
		//$DAOtemporaire3->update ( $this );
		//$DAOtemporaire2->deleteAllWishForThisProject ( $this );
	}
	//MaBD::getInstance()->commit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">

<title>Modele de page</title>
<!--Let browser know website is optimized for mobile-->
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet"
	href="../materialize/css/materialize.min.css" media="screen,projection" />
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
<body>
	<h1>Modele de page</h1>
	<?php 
	initAffectationAuto();
	?>
	<!--Import jQuery before materialize.js-->
	<script type="text/javascript"
		src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript"
		src="../materialize/js/materialize.min.js"></script>
	<script src="../ressources/js/ourJS.js"></script>
</body>
</html>