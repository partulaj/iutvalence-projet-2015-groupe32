<?php
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

$voeuxDAO = new VoeuxDAO(MaBD::getInstance());
$etudiantsDAO = new EtudiantsDAO(MaBD::getInstance());

if (isset($_POST) and isset ( $_SESSION ['user'])) 
{
	$num = $_SESSION['user']->nb_voeux+1;
	$dateBrut = new DateTime();
	$date = $dateBrut->format('Y-m-d');
	$priorite = $_POST['priorite'];
	$projet = $_POST['no_projet'];
	$etudiant = $_SESSION['user'];
	$voeu = new Voeu (array("date"=>$date,"priorite"=>$priorite,"no_projet"=>$projet,"login_etudiant"=>$etudiant->login_etudiant));
	$voeuxDAO->insert($voeu);
	$etudiant->nb_voeux = $num;//on ajoute un au nombre de voeu de l'étudiant
	$etudiantsDAO->update($etudiant);
}
?>