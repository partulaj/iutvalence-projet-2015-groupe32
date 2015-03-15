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
		"login_enseignant" => $_SESSION['user']->login_enseignant
		));

	//validation des modifications du projet 
	$projetsDAO->update($projet);
	echo json_encode(true);
}
else
{
	echo json_encode('Désolée une erreur est survenu si celle-ci persiste veuillez la signaler');
}
?>