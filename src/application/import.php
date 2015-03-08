<?php
//Ajout de PHPExcel
require_once '../ressources/phpexcel/PHPExcel/IOFactory.php';

// Tableau de paramètres de la page
$param ['erreur'] = false;
$param['reussi'] = false;
$param ['message'] = null;

//Création du DAO
$etudiantsDAO = new EtudiantsDAO(MaBD::getInstance());

//Définition des variables globales
define('TARGET', './doc/'); // Repertoire cible
define('MAX_SIZE', 1000000); // Taille max en octets du fichier
$tabExt = array('xls','xlm','xlsx');


if(!empty($_POST))
{
    // On verifie si le champ est rempli
	if( !empty($_FILES['fichier']['name']) )
	{
        // Recuperation de l'extension du fichier
		$extension = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
        // On verifie l'extension du fichier
		if(in_array(strtolower($extension),$tabExt))
		{
        	 // Parcours du tableau d'erreurs
			if(isset($_FILES['fichier']['error']) && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
			{
				//On récupère la date pour le nom du fichier
				$dateBrut = new DateTime();
				$date = $dateBrut->format('Y-m-d');
                // On renomme le fichier
				$nomFichier = $date.'.'. $extension;
                // Si c'est OK, on teste l'upload
				if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomFichier))
				{
					//Création de variables
					$array=array();
					$ligne=array();
					$res = array();
					
					$objPHPExcel = PHPExcel_IOFactory::load(TARGET.$nomFichier);	// Chargement du fichier Excel
					$sheet = $objPHPExcel->getSheet(0);		//On prend la 1ère page

					// On parcours les ligne du fichier
					foreach($sheet->getRowIterator() as $row) 
					{
   						// On parcours les cellules de la ligne
						foreach ($row->getCellIterator() as $cell) {
							$ligne[]=$cell->getValue();		//On stocke la valeur de la cellule dans une ligne
						}
						$array[]=$ligne;	//On ajoute la ligne au tableau
						$ligne=array();		//On réinitialise la ligne
					}
					//On parcours le tableau pour insérer dans la BD
					for ($i=0; $i < count($array) ; $i++) { 
						if ($array[$i][5]!="0") {
							$ajac=true;
						}
						else
						{
							$ajac=false;
						}
						$res[$i]= array( 
							"login_etudiant" => $array[$i][0],
							"nom_etudiant"=>$array[$i][1],
							"prenom_etudiant"=>$array[$i][2],
							"mdp_etudiant"=>$array[$i][3],
							"mail_etudiant"=>$array[$i][4],
							"no_groupe"=>null,
							"nb_voeux"=>0,
							"ajac"=>$ajac);
						$etudiant = new Etudiant($res[$i]);
						$etudiantsDAO->insert($etudiant);
					}
					echo '</table>';
					$param['reussi'] = true;
					$param ['message'] = "Les étudiants ont bien étaient insérés";

				}
				else
				{
					$param ['erreur'] = true;
					$param ['message'] = "Problème lors de l'upload";
				}
			}
			else
			{
				$param ['erreur'] = true;
				$param ['message'] = "Une erreur interne a empêché l'uplaod du fichier";
			}
		}
		else
		{
			$param ['erreur'] = true;
			$param ['message'] = "Le fichier n'est pas un fichier Excel";
		}
	}
	else
	{
		$param ['erreur'] = true;
		$param ['message'] = "Veuillez remplir le formulaire";
	}
	$etudiantsDAO = new EtudiantsDAO(MaBD::getInstance());
}
?>