<?php

/**
 * Script de création d'un projet
 * @package application/ajax
 * @author Jérémie
 * @version 0.4
 */
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

if (isset($_POST['no_projet'])) 
{
	//on stocke le numéro du projet à supprimer
	$num = $_POST['no_projet'];

	//on créer les DAO
	$projetsDAO = new ProjetsDAO (MaBD::getInstance ());
	$groupesDAO = new GroupesDAO (MaBD::getInstance ());
	
	//on récupère le projet et les groupes
	$projet=$projetsDAO->getOne($num);
	$groupes=$groupesDAO->getAll("WHERE no_projet=$num");

	//on vérifie que les groupes sont vides
	foreach ($groupes as $groupe) 
	{
		if ($groupe->plein==true) 
		{
			echo json_encode("Vous ne pouvez pas supprimer un projet si un groupe est affecté à celui-ci");
			return;
		}
	}

	//suppression des groupes et du projet
	foreach ($groupes as $groupe) 
	{
		$groupesDAO->delete($groupe);
	}
	$projetsDAO->delete($projet);
	echo json_encode(true);
}
else
{
	echo json_encode('Désolée une erreur est survenu si celle-ci persiste veuillez la signaler');
}

?>