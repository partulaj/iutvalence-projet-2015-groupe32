<?php
/**
 * Script de modification d'une tache
 * @package application/ajax
 * @author J�r�mie
 * @version 0.4
 */
//Autochargement des classes via un Autoloader
require_once "../ressources/classes/MyAutoloader.php";

	//cr�ation des DAO
	$tachesDAO = new TachesDAO ( MaBD::getInstance () );

	//r�cup�ration des donn�es
	$tache = $tachesDAO->getOne(2);
	echo json_encode($tache);

?>