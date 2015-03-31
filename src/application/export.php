<?php
// chargement des classes via l'Autoloader
require_once '../ressources/classes/MyAutoloader.php';
// initialisation des informations d'entête
header('Content-Encoding: UTF-8');
header("Content-Type: text/csv");
header("Content-disposition:attachment; filename=Liste_des_projets.csv");

// Création des DAO
$projetsDAO = new ProjetsDAO(MaBD::getInstance());
$groupesDAO = new GroupesDAO(MaBD::getInstance());
$utilisateursDAO = new UtilisateursDAO(MaBD::getInstance());

$separateur = ";";
$lignes = array();
$groupes =$groupesDAO->getAll();
foreach ($groupes as $groupe) 
{
	$projet = $projetsDAO->getOne($groupe->no_projet);
	$etudiants = $utilisateursDAO->getAll("WHERE role='etudiant' AND no_groupe = $groupe->no_groupe");
	$enseignant = $utilisateursDAO->getOne($projet->login);

	$champ1 = $projet->nom_projet;
	$champ2 = $groupe->no_groupe;
	$champ3 = "";
	foreach ($etudiants as $etudiant) 
	{
		$champ3 = $champ3.$etudiant->nom." ".$etudiant->prenom."/";
	}
	$champ4 = $enseignant->nom." ".$enseignant->prenom;

	$lignes[]=$champ1.$separateur.$champ2.$separateur.$champ3.$separateur.$champ4;
}

// Affichage de la ligne de titre, terminée par un retour chariot
$outputCsv = "Nom Projet".$separateur."Numéro Groupe".$separateur."Etudiant".$separateur."Tuteur"."\r\n";

// Affichage du contenu du tableau
foreach ($lignes as $ligne) 
{
	$outputCsv .= $ligne."\r\n";
}
$outputCsv = utf8_decode($outputCsv);
echo $outputCsv;
?>