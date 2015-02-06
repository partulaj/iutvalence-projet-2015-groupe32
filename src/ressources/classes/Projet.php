<?php
/**
 * Classe représentent un projet tutoré
 * @author Jérémie
 * @package ressources/classes
 */
class Projet extends TableObject {
	static public $keyFieldsNames = array('no_projet'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;

	/**
	 * Fonction qui affiche un projet dans une ligne d'un tableau
	 * Fonction qui permet d'afficher un projet sous forme de ligne d'un tableau. Ligne avec plusieurs colonnes.
	 * @author Jérémie
	 * @version 1.0
	 */
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
	
	/**
	 * Fonction qui lance l'affectation automatique ci le nombre d'étudiant est suffisant
	 * Fonction qui déclenche l'affectation automatique si le nombres d'étudiant n'ayant pas de voeux plus prioritaire est supérieur ou égale au nombre d'étudiants maximale sur le projet
	 * @author Jérémie
	 * @version 1.0
	 */
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
	
	/**
	 * Fonction qui affecte automatiquement les étudiant au projet
	 * Fonction qui permet d'affecter les étudiant au projet en cours ($this)
	 * @param $tab : un tableau d'étudiants
	 * @author Jérémie
	 * @todo
	 */
	private function affectationAuto($tab)
	{
		$DAOtemporaire = new EtudiantsDAO(MaBD::getInstance());
		$DAOtemporaire2 = new VoeuxDAO(MaBD::getInstance());
		$DAOtemporaire3 = new ProjetsDAO(MaBD::getInstance());
		for($i=0;$i<$this->nb_etu_max;$i++)
		{
			$tab[$i]->no_groupe=$this->no_groupe;
			$DAOtemporaire3->update($this);
			$DAOtemporaire2->deleteAllMyWish($tab[$i]);
			$DAOtemporaire->update($tab[$i]);
			$this->affecter=1;
		}
	}
}
?>
