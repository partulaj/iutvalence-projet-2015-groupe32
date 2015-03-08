<?php
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

$voeuxDAO= new VoeuxDAO(MaBD::getInstance());
$etudiantsDAO = new EtudiantsDAO(MaBD::getInstance());

//Supression d'un voeu
if (isset($_POST))
{
	$search = array($_POST['no_projet'],$_POST['login']);
	$voeuSupp = $voeuxDAO->getOne($search);
	$voeuxDAO->delete($voeuSupp);
	$_SESSION['user']->nb_voeux = $_SESSION['user']->nb_voeux-1;
	$etudiantsDAO->update($_SESSION['user']);
}
?>