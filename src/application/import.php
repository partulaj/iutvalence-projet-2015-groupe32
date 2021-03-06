<?php
//Ajout de PHPExcel
require_once '../ressources/phpexcel/PHPExcel/IOFactory.php';

// Tableau de paramètres de la page
$param ['erreur'] = false;
$param['reussi'] = false;
$param ['message'] = null;

//Création du DAO
$etudiantsDAO = new UtilisateursDAO(MaBD::getInstance());

//Définition des variables globales
define('TARGET', '../docs/'); // Repertoire cible
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
				$date = $dateBrut->format('d-m-Y');
                // On renomme le fichier
				$nomFichier = 'import du '.$date.'.'. $extension;
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
					for ($i=0; $i < count($array) ; $i++) 
					{ 
						//Pour le débogage
						//echo '<pre>',print_r($array),'</pre>';

						if (!empty($array[$i][0])) 
						{
							if ($array[$i][6]=="etudiant") 
							{
								$classement=$array[$i][5];
							}
							else
							{
								$classement=null;
							}
							$res[$i]= array( 
								"login" => $array[$i][0],
								"nom"=>$array[$i][1],
								"prenom"=>$array[$i][2],
								"mail"=>$array[$i][3],
								"no_groupe"=>null,
								"ajac"=>$array[$i][4],
								"classement"=>$classement,
								"role"=>$array[$i][6]);
							$utilisateur = new Utilisateur($res[$i]);
							$etudiantsDAO->insert($utilisateur);	
						}
					}
					$param['reussi'] = true;
					$param ['message'] = "Les utilisateurs ont bien étaient insérés";

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
	$utilisateursDAO = new UtilisateursDAO(MaBD::getInstance());
}
?>