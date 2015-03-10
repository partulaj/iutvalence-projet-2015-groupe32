<?php

/**
 * Script de supression d'une tache
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
	$num = $_POST['no_tache'];
	$nom = $_POST['nom_tache'];
	$etat = $_POST['etat_tache'];
	$ordre = $_POST['ordre_tache'];
	$etudiants = $_POST['etudiants'];
	for ($i=0; $i <count($etudiants) ; $i++) 
	{ 
		$search=array($num,$etudiants[$i]);
		$realise = $realisesDAO->getOne($search);
		if ($realise!=null) 
		{
			$realisesDAO->delete($realise);
		}
	}
	$tacheDel= $tachesDAO->getOne($num);
	$tachesDAO->delete($tacheDel);

}
?>