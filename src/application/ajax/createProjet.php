<?php

/**
 * Sceript de création d'un projet
 * @package application/ajax
 * @author Jérémie
 * @version 0.2
 */
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

$projetsDAO = new ProjetsDAO ( MaBD::getInstance () );
$groupesDAO = new GroupesDAO ( MaBD::getInstance () );

if (isset($_POST)) {
	$name_project = trim ( $_POST ['project_name'] );
	$nb_min = trim ( $_POST ['nb_min'] );
	$nb_max = trim ( $_POST ['nb_max'] );
	$contexte = trim ( $_POST ['contexte'] );
	$objectif = trim ( $_POST ['objectif'] );
	$contrainte = trim ( $_POST ['contrainte'] );
	$details = trim ( $_POST ['details'] );

	$newProjet = new Projet(array(
		"no_projet" => DAO::UNKNOWN_ID,
		"nom_projet" => $name_project,
		"nb_etu_min" => $nb_min,
		"nb_etu_max" => $nb_max,
		"contexte" => $contexte,
		"objectif" => $objectif,
		"contrainte" => $contrainte,
		"details" => $details,
		"login_enseignant" => $_SESSION['user']->login_enseignant
		) );
	$projetsDAO->insert($newProjet);
	
	if (empty($_POST['nb_groupes'])==false)
	{
		for ($i=0; $i < Groupe::NB_GROUPE_MAX; $i++) 
		{ 
			$newGroupe = new Groupe (array (
				"plein"=>null,
				"no_projet" => $newProjet->no_projet,
				"no_groupe" => DAO::UNKNOWN_ID
				) );
			$groupesDAO->insert($newGroupe);
		}
	}
	else
	{
		$newGroupe = new Groupe (array (
			"plein"=>null,
			"no_projet" => $newProjet->no_projet,
			"no_groupe" => DAO::UNKNOWN_ID
			) );
		$groupesDAO->insert($newGroupe);		
	}
}

?>