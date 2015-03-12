<?php

/**
 * Classe qui représente un voeu
 */
class Voeu extends TableObject {
	public static $keyFieldsNames = array (
			'no_projet',
			'login_etudiant' 
	); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	// Fonction d'affichage d'un voeux sous forme de ligne d'un tableau
	
	/**
	 * Fonction qui permet d'afficher un voeu dans une ligne d'un tableau
	 * Fonction qui permet d'afficher un voeu sous la forme d'une ligne d'un tableau. Ligne avec 5 colonnes
	 * @author Jérémie
	 * @version 1.0
	 */
	public function afficheVoeu() {
		$DAOtemporaire = new ProjetsDAO ( MaBD::getInstance () );
		$DAOtemporaire2 = new EnseignantsDAO ( MaBD::getInstance () );
		$projet = $DAOtemporaire->getOne ( $this->no_projet );
		$enseignant = $DAOtemporaire2->getOne($projet->login_enseignant);
		
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
	}
}
?>