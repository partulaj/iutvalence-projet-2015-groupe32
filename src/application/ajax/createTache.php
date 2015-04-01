<?php
/**
 * Script de création de tache
 * @package application/ajax
 * @author Jérémie
 * @version 0.4
 */
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

if (isset($_POST)) 
{
	//récupération des données
	$nom = $_POST['nom_tache'];
	$etat = $_POST['etat_tache'];
	$ordre = $_POST['ordre_tache'];
	$etudiants = $_POST['etudiants'];
	$groupe = $_POST['no_groupe'];

	//vérification des données obligatoire
	if (!empty($nom)) 
	{
		//créaation des DAO
		$tachesDAO = new TachesDAO ( MaBD::getInstance () );
		$realisesDAO = new RealisesDAO ( MaBD::getInstance () );

		//création de la nouvelle tache
		$newTache = new Tache(array(	
			"no_tache"=>DAO::UNKNOWN_ID,
			"nom_tache"=>$nom,
			"etat_tache"=>$etat,
			"ordre_tache"=>$ordre,
			"no_groupe"	=> $groupe));

		//insertion de la nouvelle tache
		$tachesDAO->insert($newTache);

		//création de la répartition de la tache
		if (!empty($etudiants))
		{
			for ($i=0; $i <count($etudiants) ; $i++) 
			{ 
				if (!empty($etudiants[$i])) 
				{
					$realise = new Realise (array(
						"no_tache"=>$newTache,
						"login"=>$etudiants[$i]));
					$realisesDAO->insert($realise);
					$realise=null;
				}
			}
		}
		echo json_encode(true);
	}
	else
	{
		echo json_encode("Veuillez donner un nom  à cette tâche");
	}
}
else
{
	echo json_encode('Désolé une erreur est survenue si celle-ci persiste veuillez la signaler');
}
?>