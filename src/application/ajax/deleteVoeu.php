<?php
/**
 * Script de supression d'un voeu
 * @package application/ajax
 * @author Jérémie
 * @version 0.4
 */
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

if (isset($_POST))
{
	//crétion des DAO
	$voeuxDAO= new VoeuxDAO(MaBD::getInstance());
	$etudiantsDAO = new EtudiantsDAO(MaBD::getInstance());

	//création d'une cl de recherche
	$search = array($_POST['no_projet'],$_POST['login']);

	//récupération de l'objet chercher
	$voeuSupp = $voeuxDAO->getOne($search);

	//supression du voeu
	$voeuxDAO->delete($voeuSupp);

	//décrémentation du nombre de voeux de l'étudiant
	$_SESSION['user']->nb_voeux = $_SESSION['user']->nb_voeux-1;

	//mise à jour de l'étudiant
	$etudiantsDAO->update($_SESSION['user']);
	echo json_encode(true);
}
else
{
	echo json_encode('Désolée une erreur est survenu si celle-ci persiste veuillez la signaler');
}
?>