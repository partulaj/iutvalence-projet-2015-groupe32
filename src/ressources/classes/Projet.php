<?php
class Projet extends TableObject {
	static public $keyFieldsNames = array('no_projet'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;

	//Fonction d'affichage d'un Projet
	public function afficheHtml()
	{
		$DAOtemporaire = new EnseignantsDAO(MaBD::getInstance());
		$enseignant = $DAOtemporaire->getOne($this->login_enseignant);
		echo    "<tr>
					<td class='col-xs-1'>
						<input type='hidden' name='projets[]' value='$this->no_projet'>
						$this->no_projet 
					</td>
					<td class='col-xs-3'> $this->nom_projet</td>
					<td class='col-xs-3'>",$enseignant->nom_enseignant," ",$enseignant->prenom_enseignant,"</td>
					<td class='col-xs-5'>
						<div class='input-group'>
							<input id='projets_$this->no_projet' type='text' name='priorite[]' value='0' class='form-control' readonly>
							<span class='input-group-btn'>
						    	<button onclick='inputNumberAdd(\"projets_$this->no_projet\")' class='btn btn-success' type='button'><span class='glyphicon glyphicon-chevron-up'></span></button>
								<button onclick='inputNumberSub(\"projets_$this->no_projet\")' class='btn btn-warning' type='button'><span class='glyphicon glyphicon-chevron-down'></span></button>
    						</span>
    					</div>
					</td>
				</tr>";
	}

////////////////////A déplacer vers Enseignant ////////////////////

	//Fonction qui permet d'afficher les projets du professeur
	public function afficheMesProjets()
	{
		$ProjetDAO = new ProjetsDAO(MaBD::getInstance());
		$EtudiantDAO = new EtudiantsDAO(MaBD::getInstance());
		$etudiants = $EtudiantDAO->getAll();
		//$etudiants = $EtudiantDAO->getAllWithThisProject($this->no_groupe);
		//<td class='col-xs-3'>",$etudiants->afficheMesEtudiants(),"</td>
		$projets = $ProjetDAO->getAllMyProjects($this->login_enseignant);
		
		echo "<tr>
				<td class='col-xs-1'> $this->no_projet</td>
				<td class='col-xs-2'> $this->nom_projet</td>
			  </tr>";	
	}
	
	//Fonction qui vérifie qu'il y ai suffisament d'élèves pour lancer l'affectation automatique
	public function initAffectationAuto()
	{
		$res = array();
		$DAOtemporaire = new EtudiantsDAO(MaBD::getInstance());
		$etudiantsATrier = $DAOtemporaire->getAllWithThisWish($this->no_projet);
		for ($i=0;$i>count($etudiantsATrier);$i++)
		{
			if ($etudiantsATrier[$i]->aUnMeilleurVoeu($this->no_projet)==false)
			{
				$res[]=$etudiantsATrier[$i];
			}
		}
		if (count($res)-1>=$this->nb_etu_max)
		{
			$this->affectationAuto($res);
		}
	}
	
	
	private function affectationAuto($tab)
	{
		$DAOtemporaire = new EtudiantsDAO(MaBD::getInstance());
		for($i=0;$i<$this->nb_etu_max;$i++)
		{
			$tab[$i]->no_groupe=$this->no_groupe;
			$DAOtemporaire->update($tab[$i]);
			$DAOtemporaire->deleteAllMyWish($tab[$i]->login_etudiant);
		}
	}
}
?>