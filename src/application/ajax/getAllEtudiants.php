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
$etudiantsDAO = new EtudiantsDAO(MaBD::getInstance());

//récupération des étudiants
$etudiants = $etudiantsDAO->getAll("ORDER BY no_groupe");

//création du tableau à retourner
$res = array();

//remplissage du tableau de résultat
foreach ($etudiants as $etudiant) 
{
	$res[]=array(	"login_etudiant"=>$etudiant->login_etudiant,
					"nom_etudiant"=>$etudiant->nom_etudiant,
					"prenom_etudiant"=>$etudiant->prenom_etudiant,
					"no_groupe"=>$etudiant->no_groupe,
					"mail_etudiant"=>$etudiant->mail_etudiant);
}
echo json_encode($res);
?>