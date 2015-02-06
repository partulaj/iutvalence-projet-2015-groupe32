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
						<div class='input-group'>
							<input id='voeux_$this->no_projet' type='text' name='prioriteVoeuEdit' value='$this->priorité' class='form-control' readonly>
							<span class='input-group-btn'>
						    	<button onclick='inputNumberAdd(\"voeux_$this->no_projet\")' class='btn btn-success' type='button'><span class='glyphicon glyphicon-chevron-up'></span></button>
								<button onclick='inputNumberSub(\"voeux_$this->no_projet\")' class='btn btn-warning' type='button'><span class='glyphicon glyphicon-chevron-down'></span></button>
    						</span>
    					</div> 
					</td>
					<td>
					<button type='submit' name='modifier_voeux' class='btn btn-warning'>
						<span class='glyphicon glyphicon-floppy-open'></span>  
					</button>
					<button type='submit' name='supprimer_voeux' class='btn btn-danger'>
						<span class='glyphicon glyphicon-remove'></span>
					</button>
					</td>
				</form>
				</tr>";
	}
}
?>