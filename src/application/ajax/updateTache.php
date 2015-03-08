<?php
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

$tachesDAO = new TachesDAO ( MaBD::getInstance () );
$realisesDAO = new RealisesDAO ( MaBD::getInstance () );

if (isset($_POST)) {
	$num = $_POST['no_tache'];
	$nom = $_POST['nom_tache'];
	$etat = $_POST['etat_tache'];
	$ordre = $_POST['ordre_tache'];
	$etudiants = $_POST['etudiants'];
	$change = $_POST['change'];
	$groupe = $_POST['no_groupe'];

	$editTache = new Tache(array(	
		"no_tache"=>$num,
		"nom_tache"=>$nom,
		"etat_tache"=>$etat,
		"ordre_tache"=>$ordre,
		"no_groupe"	=> $groupe));
	$tachesDAO->update($editTache);
	if (empty($etudiants)==false)
	{
		for ($i=0; $i <count($etudiants) ; $i++) 
		{ 
			$search = array($editTache,$etudiants[$i]);
			$realise=$realisesDAO->getOne($search);
			if ($realise==null and empty($change[$i])==false) 
			{
				$newRealise = new Realise(array(
					"no_tache"=>$num,
					"login_etudiant"=>$etudiants[$i]));
				$realisesDAO->insert($newRealise);
			}
			elseif($realise!=null)
			{
				if (empty($change[$i])==true) 
				{
					$realisesDAO->delete($realise);
				}
			}
		}
	}
}
?>