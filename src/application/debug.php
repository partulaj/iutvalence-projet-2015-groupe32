<?php
/**
 * Script de modification d'une tache
 * @package application/ajax
 * @author Jérémie
 * @version 0.4
 */
//Autochargement des classes via un Autoloader
require_once "../ressources/classes/MyAutoloader.php";

	//création des DAO
	$tachesDAO = new TachesDAO ( MaBD::getInstance () );

	//récupération des données
	$tache = $tachesDAO->getOne(2);
	echo json_encode($tache);

?>