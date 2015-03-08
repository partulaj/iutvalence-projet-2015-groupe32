<?php
class Groupe extends TableObject {
	//Nombre maximum de groupe pour un projet
	const NB_GROUPE_MAX = 2;

	static public $keyFieldsNames = array('no_groupe'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;
	
	/**
	 * Fonction d'affichage d'un groupe sous forme d'option html
	 *
	 * @author Jérémie
	 * @version 0.2
	 */
	public function toOption()
	{
		$DAOtemporaire = new ProjetsDAO(MaBD::getInstance());
		$projet = $DAOtemporaire->getOne($this->no_projet);
		echo "<option value='$this->no_groupe'> Groupe $this->no_groupe - $projet->nom_projet</option>";
	}

	/**
	 * Fonction qui retourne la liste des membres du groupe
	 * Fonction qui permet d'afficher la liste des memebres du groupes avec une checkbox unique(id)
	 * @author Jérémie
	 * @version 0.2
	 */
	public function listMembers($no_tache=null)
	{
		$DAOtemporaire = new EtudiantsDAO(MaBD::getInstance());
		$etudiants = $DAOtemporaire->getAll("WHERE no_groupe='$this->no_groupe'");
		foreach ($etudiants as $etudiant) 
		{
			$etudiant->toCheckBox($no_tache);
		} 
	}

	/**
	 * Fonction qui affiche un groupe sus forme d'interface de gestion 
	 * @author Jérémie
	 * @version 0.2
	 */
	public function managmentInterface()
	{
		$DAOtemporaire = new TachesDAO(MaBD::getInstance());
		$taches = $DAOtemporaire->getAll("WHERE no_groupe = '$this->no_groupe' ORDER BY ordre_tache");
		echo "
		<div class='card'>
			<div class='row'>
				<div class='col s12'>
					<a class='btn-floating btn-large waves-effect waves-light red arrow-link slide-link'>
						<i class='mdi-hardware-keyboard-arrow-down'></i>
					</a>
					<h5>Gestion des tâches</h5>
					<p>Modifier, ajouter ou supprimer des tâches</p>
				</div>
			</div>
			<table class='responsive-table bordered striped centered hide'>
				<tr>
					<th>Tache</th>
					<th>Etat</th>
					<th>Personne(s) en Charge</th>
					<th>Ordre de la tache</th>
					<th>Action</th>
				</tr>";
				foreach ($taches as $tache) 
				{
					$tache->toTableRow();	
				}
				$newTache = new Tache(array(	
					"no_tache"=>DAO::UNKNOWN_ID,
					"nom_tache"=>null,
					"etat_tache"=>null,
					"ordre_tache"=>null,
					"login_etudiant"=>null,
					"no_groupe"	=> $this->no_groupe							
					));
				$newTache->toAddingTableRow();
				echo"
			</table>
		</div>
		";
	}
}
?>