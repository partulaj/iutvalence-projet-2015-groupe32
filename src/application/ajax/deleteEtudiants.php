<?php
/**
 * Script de suppression des étudiants
 * @package application/ajax
 * @author Jérémie
 * @version 0.4
 */
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

if (isset($_POST['array']))
{
	//création du DAO
	$etudiantsDAO = new UtilisateursDAO(MaBD::getInstance());
	//récupération des données
	$etudiantsASupprimer = $_POST['array'];
	foreach ($etudiantsASupprimer as $login) 
	{
		//récupération de l'étudiant
		$etudiantASupprimer = $etudiantsDAO->getOne($login);
		//suppression de l'étudiant
		$etudiantsDAO->delete($etudiantASupprimer);
	}
	echo json_encode(true);
}
else
{
	echo json_encode("Veuillez sélectionner des étudiants à supprimer");
}

?>