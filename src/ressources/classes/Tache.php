<?php
class Tache extends TableObject {
	static public $keyFieldsNames = array('no_tache'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;
	
	/**
	 * fonction qui affiche le nom, l'avencement (par une barre) et les soutaches associé de la tache du projet
	 * 
	 */
	public function afficheTache() {
		
		echo "<div class='progress'>
				<div class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='$this->avancement' aria-valuemax='100' style='width: $this->$avancement%;'>
				", $this->avancement,"%
				</div>
			</div> 
			<input id='tache_1'  type='text' readonly='' value=", $this->nom_tache,">
			<div class='interaction'>
				<button type='submit' name='modifier_Tache' class='btn'>
						<span class=''></span>
				</button>
				<button type='submit' name='supprimer_tache' class='btn'>
						<span class=''></span>
				</button>
				<button type='submit' name='ajouter_sousTache' class='btn'>
						<span class=''></span>
				</button>
			</div>";
	}
	
}
?>