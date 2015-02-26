<?php
class Tache extends TableObject {
	static public $keyFieldsNames = array('no_tache'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;
	
	/**
	 * fonction qui affiche le nom, l'avencement et les soutaches associé de la tache du projet
	 * 
	 */
	public function afficheTache() {
		
		echo "
				<button type='submit' name='modifier_Tache' class='btn'>
						<span class=''></span>
				</button>
				<button type='submit' name='supprimer_tache' class='btn'>
						<span class=''></span>
				</button>
				<button type='submit' name='ajouter_sousTache' class='btn'>
						<span class=''></span>
				</button>";
		
	}
	
}
?>