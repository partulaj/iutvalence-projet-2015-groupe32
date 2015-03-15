<?php

/**
 * Script de supression d'une tache
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
	$etudiants = $_POST['etudiants'];

	//supression de la tache
	$tacheDel= $tachesDAO->getOne($num);
	$tachesDAO->delete($tacheDel);
	echo json_encode(true);
}
else
{
	echo json_encode('Désolée une erreur est survenu si celle-ci persiste veuillez la signaler');
}
?>