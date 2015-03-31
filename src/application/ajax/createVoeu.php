<?php

/**
 * Script de création d'un voeu
 * @package application/ajax
 * @author Jérémie
 * @version 0.4
 */
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

if (isset($_POST) and isset ( $_SESSION ['user'])) 
{
	//récupération des données
	$num = $_SESSION['user']->nb_voeux+1;
	$dateBrut = new DateTime();
	$date = $dateBrut->format('Y-m-d');
	$priorite = $_POST['priorite'];
	$projet = $_POST['no_projet'];
	$etudiant = $_SESSION['user'];

	//création des DAO
	$voeuxDAO = new VoeuxDAO(MaBD::getInstance());
	$etudiantsDAO = new UtilisateursDAO(MaBD::getInstance());

	//création du voeu
	$voeu = new Voeu (array("date"=>$date,"priorite"=>$priorite,"no_projet"=>$projet,"login"=>$etudiant->login));
	//insertion du voeu
	$voeuxDAO->insert($voeu);
	$etudiant->nb_voeux = $num;//on ajoute un au nombre de voeu de l'étudiant
	$etudiantsDAO->update($etudiant);//on met a jour l'etudiant
	echo json_encode(true);
}
else
{
	echo json_encode('Désolé une erreur est survenue si celle-ci persiste veuillez la signaler');
}
?>