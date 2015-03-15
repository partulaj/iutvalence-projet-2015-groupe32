<?php
/**
 * Script de modification d'une tache
 * @package application/ajax
 * @author Jérémie
 * @version 0.4
 */
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

if (isset($_POST)) 
{
	//création des DAO
	$tachesDAO = new TachesDAO ( MaBD::getInstance () );
	$realisesDAO = new RealisesDAO ( MaBD::getInstance () );

	//récupération des données
	$num = $_POST['no_tache'];
	$nom = $_POST['nom_tache'];
	$etat = $_POST['etat_tache'];
	$ordre = $_POST['ordre_tache'];
	$etudiants = $_POST['etudiants'];
	$change = $_POST['change'];
	$groupe = $_POST['no_groupe'];

	//modification de la tache
	$editTache = new Tache(array(	
		"no_tache"=>$num,
		"nom_tache"=>$nom,
		"etat_tache"=>$etat,
		"ordre_tache"=>$ordre,
		"no_groupe"	=> $groupe));

	//validation des modifications de la tache
	$tachesDAO->update($editTache);

	//modification de la répartition de la tache
	if (!empty($etudiants))
	{
		for ($i=0; $i <count($etudiants) ; $i++) 
		{ 
			$search = array($editTache,$etudiants[$i]);
			$realise=$realisesDAO->getOne($search);
			if ($realise==null and !empty($change[$i])) 
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
	echo json_encode(true);
}
else
{
	echo json_encode('Désolée une erreur est survenu si celle-ci persiste veuillez la signaler');
}
?>