<?php

/**
 * Script de récupération des étudiants
 * @package application/ajax
 * @author Jérémie
 * @version 0.4
 */
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

if (isset($_POST['enseignant'])) 
{
	//récupération du login enseignant
	$login = $_POST['enseignant'];

	//création du DAO
	$projetsDAO = new ProjetsDAO(MaBD::getInstance());

	//récupération des étudiants
	$projets = $projetsDAO->getAll("WHERE login_enseignant = $login");

	//remplissage du tableau de résultat
	foreach ($projets as $projet) 
	{
		echo json_encode();
	}
}
?>