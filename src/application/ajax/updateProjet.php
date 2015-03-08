<?php
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

$projetsDAO = new ProjetsDAO(MaBD::getInstance());

if (isset($_POST)) 
{
	$projet = $projetsDAO->getOne($_POST['no_projet']);
	$no_projet = $projet->no_projet;
	$name_project = trim ( $_POST ['project_name'] );
	$nb_min = trim ( $_POST ['nb_min'] );
	$nb_max = trim ( $_POST ['nb_max'] );
	$contexte = trim ( $_POST ['contexte'] );
	$objectif = trim ( $_POST ['objectif'] );
	$contrainte = trim ( $_POST ['contrainte'] );
	$details = trim ( $_POST ['details'] );
	$projet = new Projet(array(
		"no_projet" =>$no_projet,
		"nom_projet" => $name_project,
		"nb_etu_min" => $nb_min,
		"nb_etu_max" => $nb_max,
		"contexte" => $contexte,
		"objectif" => $objectif,
		"contrainte" => $contrainte,
		"details" => $details,
		"login_enseignant" => $_SESSION['user']->login_enseignant
		));
	$projetsDAO->update($projet);
}
?>