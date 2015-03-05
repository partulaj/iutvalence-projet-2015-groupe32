<?php
/**
 * Classe représentent un projet tutoré
 * @author Jérémie
 * @package ressources/classes
 */
class Projet extends TableObject {
	public static $keyFieldsNames = array (
		'no_projet' 
		);
	public $hasAutoIncrementedKey = true;
	
	/**
	 * Fonction qui affiche un projet dans une ligne d'un tableau
	 * Fonction qui permet d'afficher un projet sous forme de ligne d'un tableau.
	 * Ligne avec plusieurs colonnes.
	 *
	 * @author Jérémie
	 * @version 1.0
	 */
	public function afficheHtml() {
		$DAOtemporaire = new EnseignantsDAO ( MaBD::getInstance () );
		$enseignant = $DAOtemporaire->getOne ( $this->login_enseignant );
		echo "<tr>
		<td>
			<input type='hidden' name='projets[]' value='$this->no_projet'>
			$this->no_projet 
		</td>
		<td> $this->nom_projet</td>
		<td>", $enseignant->nom_enseignant, " ", $enseignant->prenom_enseignant, "</td>
		<td>
			<p class='range-field'>
				<input type='range' name='priorite[]' min='0' max='3' value='0'>
			</p>
		</td>
		<td>
			<a href='projet.php?no_projet=$this->no_projet'>En savoir plus</a>
		</td>
	</tr>";
}

	/**
	 * Fonction qui lance l'affectation automatique ci le nombre d'étudiant est suffisant
	 * Fonction qui déclenche l'affectation automatique si le nombres d'étudiant n'ayant pas de voeux plus prioritaire est supérieur ou égale au nombre d'étudiants maximale sur le projet
	 *
	 * @author Jérémie
	 * @version 1.2
	 */
	public function initAffectationAuto() {
		$res = array ();
		$DAOtemporaire = new EtudiantsDAO ( MaBD::getInstance () );
		$etudiantsATrier = $DAOtemporaire->getAllWithThisWish ( $this->no_projet );
		foreach ( $etudiantsATrier as $etudiant ) {
			if ($etudiant->aUnMeilleurVoeu ( $this->no_projet ) == false) {
				$res [] = $etudiant;
			}
		}
		if (count ( $res ) >= $this->nb_etu_max) {
			$this->affectationAuto ( $res );
		}
	}
	
	/**
	 * Fonction qui affecte automatiquement les étudiant au projet
	 * Fonction qui permet d'affecter les étudiant au projet en cours ($this)
	 * @param $tab :un tableau d'étudiants
	 * @author Jérémie
	 * @version 0.5
	 */
	private function affectationAuto($tab) {
		MaBD::getInstance()->beginTransaction();
		$DAOtemporaire = new EtudiantsDAO ( MaBD::getInstance () );
		$DAOtemporaire2 = new VoeuxDAO ( MaBD::getInstance () );
		$DAOtemporaire3 = new ProjetsDAO ( MaBD::getInstance () );
		$DAOtemporaire4 = new GroupesDAO(MaBD::getInstance());
		
		$groupes = $DAOtemporaire4->getAll("WHERE no_projet='$this->no_projet'");
		foreach ($groupes as $groupe)
		{
			if ($groupe->plein==false and !empty($tab))
			{
				$i=0;
				while ($i<$this->nb_etu_max)
				{	
					$etudiant = $tab[0];			
					$etudiant->no_groupe = $groupe->no_groupe;
					$DAOtemporaire->update ($etudiant );
					$DAOtemporaire2->deleteAllMyWish ($etudiant->login_etudiant );
					unset($tab[0]);
					$tab = array_values($tab);
					$i++;
				}
				$groupe->plein=true;
				$DAOtemporaire4->update($groupe);
			}
		}
		
		$groupes = $DAOtemporaire4->getAll("WHERE no_projet='$this->no_projet'");
		foreach ($groupes as $groupe)
		{
			if ($groupe->plein==true)
			{
				$this->affecter=1;
			}
			else 
			{
				$this->affecter=0;
				break;
			}
		}
		if($this->affecter==1)
		{
			$DAOtemporaire3->update ( $this );
			$DAOtemporaire2->deleteAllWishForThisProject ( $this );
		}
		MaBD::getInstance()->commit();
	}

	/**
	 * 
	 */
	public function toStudentCards()
	{
		echo 	"
		<div class='card col s12'>
			<span class='card-title black-text'>Contexte</span>
			<p>$this->contexte</p>
		</div>
		<div class='card col s12'>
			<span class='card-title black-text'>Objectif</span>
			<p class='col s12'>$this->objectif</p>
		</div>
		<div class='card col s12'>
			<span class='card-title black-text'>Contrainte</span>
			<p>$this->contrainte</p>
		</div>
		<div class='card col s12'>
			<span class='card-title black-text'>Details</span>
			<p>$this->details</p>
		</div>
		";
	}

	/**
	 * 
	 */
	public function toTeacherCards()
	{
		echo 	"
		<form action='' method='post'>
			<div class='card'>
				<span class='card-title black-text'>Informations du Projet</span>
				<div class='input-field'> 
					<label for='projet_name'>Nom du Projet</label>
					<input type='text' name='projet_name' value='$this->nom_projet' required>
				</div>
				<div class='input-field'>
					<label for='nb_min'>Nombre d'étudiants minimum</label>
					<input type='text' name='nb_min' value='$this->nb_etu_min' required>
				</div>
				<div class='input-field'>
					<label for='nb_max'>Nombre d'étudiants maximum</label>
					<input type='text' name='nb_max' value='$this->nb_etu_max' required>
				</div>
			</div>
			<div class='card'>
				<div class='input-field'>
					<label for='contexte'>Contexte</label>
					<textarea class='materialize-textarea' name='contexte' required>$this->contexte</textarea>
				</div>
			</div>
			<div class='card'>
				<div class='input-field'>
					<label for='objectif'>Objectif</label>
					<textarea class='materialize-textarea' name='objectif' required>$this->objectif</textarea>
				</div>
			</div>
			<div class='card'>
				<div class='input-field'>
					<label for='contrainte'>Contraintes</label>
					<textarea class='materialize-textarea' name='contrainte' required>$this->contrainte</textarea>
				</div>
			</div>
			<div class='card'>
				<div class='input-field'>
					<label for='details'>Détails</label>
					<textarea class='materialize-textarea' name='details' required>$this->details</textarea>
				</div>
			</div>
			<div class='centre'>
				<button type='submit' name='update_projet' class='btn light-blue darken-2'>
					<span class='icon-save-floppy'></span> Enregistrer les modifications
				</button>
			</div>
		</form>
		";
	}

	/**
	 * Fonction qui affiche un projet sous forme de ligne html
	 *
	 * @author Ihab, Jérémie
	 * @version 0.2
	 * @deprecated
	 */
	public function toTableRow() {
		echo "
		<tr>
			<td> $this->no_projet</td>
			<td> $this->nom_projet</td>
			<td><a href='projet.php?no_projet=$this->no_projet'>Editer le Projet</a></td>
		</tr>";
		}
	}
	?>
