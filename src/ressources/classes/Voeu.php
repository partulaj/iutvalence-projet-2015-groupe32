<?php

/**
 * Classe qui représente un voeu
 */
class Voeu extends TableObject {
	public static $keyFieldsNames = array ('no_projet','login_etudiant'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
<<<<<<< HEAD
	
	// Fonction d'affichage d'un voeux sous forme de ligne d'un tableau
=======

>>>>>>> refs/remotes/origin/jeremie
	/**
	 * Fonction qui permet d'afficher un voeu dans une ligne d'un tableau
	 * Fonction qui permet d'afficher un voeu sous la forme d'une ligne d'un tableau avec un bouton pour 
	 * modifier le voeu et un pour le supprimer
	 * @author Jérémie
	 * @version 1.2
	 */
	public function toTableRow() {
		$DAOtemporaire = new ProjetsDAO ( MaBD::getInstance () );
		$DAOtemporaire2 = new EnseignantsDAO ( MaBD::getInstance () );
		$projet = $DAOtemporaire->getOne ( $this->no_projet );
		$enseignant = $DAOtemporaire2->getOne($projet->login_enseignant);
		
<<<<<<< HEAD
		echo "<tr>
				<form method='post' action=''>
					<td class='col-xs-1'>
						<input type='hidden' name='voeuToEdit' value='$this->no_projet'> 
						$this->no_projet
					</td>
					<td>
						$projet->nom_projet
					</td>
					<td>
						$enseignant->nom_enseignant $enseignant->prenom_enseignant
					</td>
					<td class='col-xs-3'>
						<p class='range-field'>
							<input type='range' name='prioriteVoeuEdit' value='$this->priorite' min='1' max='3'>
    					</p> 
					</td>
					<td>
					<button type='submit' name='modifier_voeux' class='btn green accent-4'>
						<span class='mdi-image-edit'></span>  
					</button>
					<button type='submit' name='supprimer_voeux' class='btn red'>
						<span class='mdi-action-delete'></span>
					</button>
					</td>
				</form>
				</tr>";
=======
		echo "
		<tr>
			<td>
				$projet->nom_projet
			</td>
			<td>
				$enseignant->nom_enseignant $enseignant->prenom_enseignant
			</td>
			<td class='col-xs-3'>
				<p class='range-field'>
					<input type='range' id='priorite$this->no_projet' value='$this->priorite' min='1' max='3'>
				</p> 
			</td>
			<td>
				<button type='submit' onClick='editVoeu(\"$this->no_projet\",\"$this->login_etudiant\")' class='btn amber'>
					<span class='mdi-image-edit'></span>  
				</button>
				<button type='submit' onClick='delVoeu(\"$this->no_projet\",\"$this->login_etudiant\")' class='btn red'>
					<span class='mdi-action-delete'></span>
				</button>
			</td>
		</tr>";
	}

	/**
	 * Affiche le nom et prénom de l'étudiant ayant fait ce voeu
	 * @author Jérémie
	 * @version 0.2
	 */
	public function toListElem()
	{
		$DAOtemporaire = new EtudiantsDAO(MaBD::getInstance());
		$etudiant = $DAOtemporaire->getOne($this->login_etudiant);
		echo "
		<li class='collection-item'>
			$etudiant->nom_etudiant $etudiant->prenom_etudiant
		</li>
		";
>>>>>>> refs/remotes/origin/jeremie
	}
}
?>
