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

if (isset($_POST['login']))
{
	//création du DAO
	$groupesDAO = new GroupesDAO(MaBD::getInstance());
	$etudiantsDAO = new UtilisateursDAO(MaBD::getInstance());
	//récupération des données
	$etudiant = $etudiantsDAO->getOne($_POST['login']);
	$groupe = $groupesDAO->getOne($_POST['no_groupe']);
	if($etudiant!=null)
	{
		$etudiant->no_groupe=$groupe->no_groupe;
		$etudiantsDAO->update($etudiant);
		if ($groupe->plein!=true) 
		{
			$groupe->plein=true;
			$groupesDAO->update($groupe);
		}
		echo json_encode(true);
	}
	else
	{
		echo json_encode("Aucun étudiant avec ce login n'a été trouvé dans la base de données");
	}
}
else
{
	echo json_encode("Veuillez saisir le login d'un étudiant a affecter");
}

?>