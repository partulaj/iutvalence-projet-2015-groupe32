<?php
/**
 * Script de modification d'un projet
 * @package application/ajax
 * @author Jérémie
 * @version 0.4
 */
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

if (isset($_POST)) 
{
	$projetsDAO = new ProjetsDAO(MaBD::getInstance());
	
	//récupération du projet à modifié
	$projet = $projetsDAO->getOne($_POST['no_projet']);

	//récupérationn des données saisies
	$no_projet = $projet->no_projet;
	$name_project = trim ( $_POST ['project_name'] );
	$nb_min = trim ( $_POST ['nb_min'] );
	$nb_max = trim ( $_POST ['nb_max'] );
	$contexte = trim ( $_POST ['contexte'] );
	$objectif = trim ( $_POST ['objectif'] );
	$contrainte = trim ( $_POST ['contrainte'] );
	$details = trim ( $_POST ['details'] );

	if(!empty($name_project) and !empty($contexte) and !empty($objectif) and !empty($contrainte) and !empty($details))
	{
	//modification du projet
		$projet = new Projet(array(
			"no_projet" =>$no_projet,
			"nom_projet" => $name_project,
			"nb_etu_min" => $nb_min,
			"nb_etu_max" => $nb_max,
			"contexte" => $contexte,
			"objectif" => $objectif,
			"contrainte" => $contrainte,
			"details" => $details,
			"login" => $_SESSION['user']->login
			));

	//validation des modifications du projet 
		$projetsDAO->update($projet);
		echo json_encode(true);
	}
	else
	{
		echo json_encode("Veuillez remplir tous les champs");
	}	
}
else
{
	echo json_encode('Désolé une erreur est survenue si celle-ci persiste veuillez la signaler');
}
?>