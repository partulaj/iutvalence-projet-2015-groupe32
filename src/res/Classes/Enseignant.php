<?php
class Enseignant extends TableObject {
	static public $keyFieldsNames = array('login_enseignant'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	public function afficheEnseignant()
	{
		echo 	"<div id='enseignant-box'>",
				$this->nom,"<br/>",
				$this->prenom,"<br/>",
				"</input type='submit' value='deconection'>",
				"</div>";
	}
	
	public function afficheMesProjets()
	{
		
		
		echo 	"<div id='etudiant-box'>",
		$this->nom,"<br/>",
		$this->prenom,"<br/>",
		$this->groupe,"<br/>",
		"</input type='submit' value='deconection'>",
		"</div>";
	}
	
	public function afficheGroupe()
	{
		echo 	"<div id='etudiant-box'>",
		$this->groupe,"<br/>",
		$this->nom,"<br/>",
		$this->prenom,"<br/>",
		"</input type='submit' value='deconection'>",
		"</div>";
	}
}
?>