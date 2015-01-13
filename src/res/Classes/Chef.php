<?php
class Chef extends TableObject {
	static public $keyFieldsNames = array('login_chef'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	public function afficheEtudiant()
	{
		echo 	"<div id='chef-box'>",
				$this->nom,"<br/>",
				$this->prenom,"<br/>",
				$this->groupe,"<br/>",
				"</input type='submit' value='deconection'>",
				"</div>";
	}
	
}
?>