<?php
class Enseignant extends TableObject {
	static public $keyFieldsNames = array('login_enseignant'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	public function afficheEnseignant()
	{
		echo 	"<div id='enseignant-box'>
				$this->nom<br/>
				$this->prenom<br/>
				<form method='post' action='index.php'><input type='submit' name='deconnexion' value='Se déconnecter'></form>
				</div>";
	}
}
?>