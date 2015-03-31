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

//création du DAO
$etudiantsDAO = new UtilisateursDAO(MaBD::getInstance());

//récupération des étudiants
$etudiants = $etudiantsDAO->getAll("WHERE role='etudiant' ORDER BY no_groupe");

//création du tableau à retourner
$res = array();

//remplissage du tableau de résultat
foreach ($etudiants as $etudiant) 
{
	$res[]=array(	"login"=>$etudiant->login,
					"nom"=>$etudiant->nom,
					"prenom"=>$etudiant->prenom,
					"no_groupe"=>$etudiant->no_groupe,
					"mail"=>$etudiant->mail);
}
echo json_encode($res);
?>