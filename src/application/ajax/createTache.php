<?php

/**
 * Script de création de tache
 * @package application/ajax
 * @author Jérémie
 * @version 0.2
 */
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

$tachesDAO = new TachesDAO ( MaBD::getInstance () );
$realisesDAO = new RealisesDAO ( MaBD::getInstance () );

if (isset($_POST)) {
	$nom = $_POST['nom_tache'];
	$etat = $_POST['etat_tache'];
	$ordre = $_POST['ordre_tache'];
	$etudiants = $_POST['etudiants'];
	$groupe = $_POST['no_groupe'];
	$newTache = new Tache(array(	
		"no_tache"=>DAO::UNKNOWN_ID,
		"nom_tache"=>$nom,
		"etat_tache"=>$etat,
		"ordre_tache"=>$ordre,
		"no_groupe"	=> $groupe));
	$tachesDAO->insert($newTache);
	if (empty($etudiants)==false)
	{
		for ($i=0; $i <count($etudiants) ; $i++) 
		{ 
			if (empty($etudiants[$i])==false) 
			{
				$realise = new Realise (array(
					"no_tache"=>$newTache,
					"login_etudiant"=>$etudiants[$i]));
				$realisesDAO->insert($realise);
				$realise=null;
			}
		}
	}
}
?>