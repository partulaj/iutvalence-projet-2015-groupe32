<?php

/**
 * Script de changement de groupe d'un étudiant
 * @package application/ajax
 * @author Jérémie
 * @version 0.4
 */
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

if (isset($_POST['etudiant1']) and isset($_POST['etudiant2']))
{
	//création du DAO
	$etudiantsDAO = new EtudiantsDAO(MaBD::getInstance());

	//récupération des étudiants
	$etudiant1 = $etudiantsDAO->getOne($_POST['etudiant1']);
	$etudiant2 = $etudiantsDAO->getOne($_POST['etudiant2']);

	//vérification des étudiants
	if (!is_null($etudiant1->no_groupe) and !is_null($etudiant2->no_groupe)) 
	{
		//vérification des groupes
		if ($etudiant1->no_groupe!=$etudiant2->no_groupe) 
		{
			//modification des groupes
			$num = $etudiant1->no_groupe;
			$etudiant1->no_groupe = $etudiant2->no_groupe;
			$etudiant2->no_groupe = $num;
			
			//mise à jour des étudiants
			$etudiantsDAO->update($etudiant1);
			$etudiantsDAO->update($etudiant2);
			echo json_encode(true);
		}
		else
		{
			echo json_encode("Changement impossible car numéro de groupe identique");
		}
	}
	else
	{
		echo json_encode("Choisissez des étudiants affecté à un groupe");
	}
}
else
{
	echo json_encode("Veuillez saisir des login etudiant valide");
}
?>