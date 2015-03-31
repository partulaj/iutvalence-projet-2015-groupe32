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

	//création d'une cl de recherche
	$search = array($_POST['no_projet'],$_POST['login']);

	//récupération de l'objet chercher
	$voeuSupp = $voeuxDAO->getOne($search);

	//supression du voeu
	$voeuxDAO->delete($voeuSupp);

	echo json_encode(true);
}
else
{
	echo json_encode('Désolé une erreur est survenue si celle-ci persiste veuillez la signaler');
}
?>