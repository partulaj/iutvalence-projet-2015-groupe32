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


if (isset($_POST)) 
{
	//récupération des données
	$name_project = trim ( $_POST ['project_name'] );
	$nb_min = trim ( $_POST ['nb_min'] );
	$nb_max = trim ( $_POST ['nb_max'] );
	$contexte = trim ( $_POST ['contexte'] );
	$objectif = trim ( $_POST ['objectif'] );
	$contrainte = trim ( $_POST ['contrainte'] );
	$details = trim ( $_POST ['details'] );

	//vérification des champs obligatoire
	if(!empty($name_project) and !empty($contexte) and !empty($objectif) and !empty($contrainte) and !empty($details))
	{
		//création des DAO
		$projetsDAO = new ProjetsDAO ( MaBD::getInstance () );
		$groupesDAO = new GroupesDAO ( MaBD::getInstance () );

		//création du nouveau projet
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
		//insertion du nouveau projet
		$projetsDAO->insert($newProjet);

		//créationn du ou des groupes
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
		echo json_encode(true);
	}
	else
	{
		echo json_encode("Veuillez remplir tous les champs");
	}	
}
else
{
	echo json_encode('Désolée une erreur est survenu si celle-ci persiste veuillez la signaler');
}

?>