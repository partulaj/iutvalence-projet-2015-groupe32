<?php
/**
 * Script de récupération des étudiants sans voeu
 * @package application/ajax
 * @author Jérémie
 * @version 0.4
 */
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

//création du DAO
$etudiantsDAO = new EtudiantsDAO(MaBD::getInstance());

//récupération des étudiants sans Voeux
$etudiants = $etudiantsDAO->getAll("WHERE no_groupe IS NULL AND login_etudiant NOT IN(SELECT login_etudiant FROM Voeux)");

//création du tableau à retourner
$res = array();

//remplissage du tableau de résultat
foreach ($etudiants as $etudiant) 
{
	$res[]=array(	"nom_etudiant"=>$etudiant->nom_etudiant,
					"prenom_etudiant"=>$etudiant->prenom_etudiant,
					"mail_etudiant"=>$etudiant->mail_etudiant);
}
echo json_encode($res);
?>