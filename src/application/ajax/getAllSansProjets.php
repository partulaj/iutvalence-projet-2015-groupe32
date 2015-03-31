<?php

/**
 * Sceript de récupération des étudiants sans projets
 * @package application/ajax
 * @author Jérémie
 * @version 0.4
 */
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

//création du DAO
$etudiantsDAO = new UtilisateursDAO(MaBD::getInstance());

//récupération des étudiants sans projet
$etudiants = $etudiantsDAO->getAll("WHERE role='etudiant' and ISNULL(no_groupe)");

//création du tableau à retourner
$res = array();

//remplissage du tableau de résultat
foreach ($etudiants as $etudiant) 
{
	$res[]=array(	"nom"=>$etudiant->nom,
					"prenom"=>$etudiant->prenom,
					"mail"=>$etudiant->mail);
}
echo json_encode($res);
?>