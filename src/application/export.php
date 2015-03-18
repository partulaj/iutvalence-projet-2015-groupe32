<?php
// référence à la bibliothèque de fonctions
require_once 'include/PHPExcel/PHPExcel.php';
require_once 'include/PHPExcel/PHPExcel/IOFactory.php';
// création des objets de base et initialisation des informations d'entête
$classeur = new PHPExcel;
$classeur->getProperties()->setCreator("Annie Gagnon");
$classeur->setActiveSheetIndex(0);
$feuille=$classeur->getActiveSheet();
// ajout des données dans la feuille de calcul
$feuille->setTitle('Liste des groupes et leurs projets');
$feuille->setCellValueByColumnAndRow(0, 1, 'Les colonnes débutent à 0 et les lignes débutent à 1');
$feuille->SetCellValue('A2', 'Il est aussi possible d\'utiliser la notation LettreChiffre (ex : A2)');
// envoi du fichier au navigateur
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
header('Content-Disposition: attachment;filename="ListeProjets.xlsx"'); 
header('Cache-Control: max-age=0'); 
$writer = PHPExcel_IOFactory::createWriter($classeur, 'Excel2007'); 
$writer->save('php://output');
?>