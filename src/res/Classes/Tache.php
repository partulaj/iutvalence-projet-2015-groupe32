<?php
class Tache extends TableObject {
	static public $keyFieldsNames = array('no_tache'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;
	
	public function afficheEtudiant()
	{
		echo 	"<div id='etudiant-box'>",
				$this->nom,"<br/>",
				$this->prenom,"<br/>",
				$this->groupe,"<br/>",
				"</div>";
	}
	
}
?>