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

if (isset($_POST['login_etudiant']))
{
	//création du DAO
	$etudiantsDAO = new EtudiantsDAO(MaBD::getInstance());
	//récupération des données
	$etudiant = $etudiantsDAO->getOne($_POST['login_etudiant']);
	if($etudiant!=null)
	{
		$etudiant->no_groupe=$_POST['no_groupe'];
		$etudiantsDAO->update($etudiant);
		echo json_encode(true);
	}
	else
	{
		echo json_encode("Aucun étudiant avec ce login n'a était trouvé dans la base de données");
	}
}
else
{
	echo json_encode("Veuillez saisir le login d'un étudiant à affecté");
}

?>