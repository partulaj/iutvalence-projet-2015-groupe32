<?php
//Autochargement des classes via un Autoloader
require_once "../../ressources/classes/MyAutoloader.php";
session_start();

$voeuxDAO = new VoeuxDAO(MaBD::getInstance());

if (isset($_POST))
{
	$search = array($_POST['no_projet'],$_POST['login']);
	$voeuMod = $voeuxDAO->getOne($search);
	$voeuMod->priorite = $_POST['priorite'];
	$voeuxDAO->update($voeuMod);
}
?>