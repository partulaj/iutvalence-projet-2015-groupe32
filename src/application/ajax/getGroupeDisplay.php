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
$groupesDAO = new GroupesDAO(MaBD::getInstance());
if (isset($_GET))
{
	$groupe = $groupesDAO->getOne($_GET['no_groupe']);
	$groupe->managmentInterface();
}

?>