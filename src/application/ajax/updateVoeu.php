<?php
/**
 * Script de modification d'un voeu
 * @package application/ajax
 * @author Jérémie
 * @version 0.4
 */
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

if (isset($_POST))
{
	//création du DAO
	$voeuxDAO = new VoeuxDAO(MaBD::getInstance());

	//création de la clé de recherche
	$search = array($_POST['no_projet'],$_POST['login']);

	//récupération de l'objat chercher
	$voeuMod = $voeuxDAO->getOne($search);

	//modification de l'objet
	$voeuMod->priorite = $_POST['priorite'];

	//validation des modifications
	$voeuxDAO->update($voeuMod);
	echo json_encode(true);
}
else
{
	echo json_encode('Désolé une erreur est survenue si celle-ci persiste veuillez la signaler');
}
?>