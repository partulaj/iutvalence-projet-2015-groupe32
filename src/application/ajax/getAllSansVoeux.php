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
$etudiantsDAO = new UtilisateursDAO(MaBD::getInstance());

//récupération des étudiants sans Voeux
$etudiants = $etudiantsDAO->getAll("WHERE role='etudiant' AND no_groupe IS NULL AND login NOT IN(SELECT login FROM Voeux)");

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