<?php
class Chef extends TableObject {
	static public $keyFieldsNames = array('login_chef'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	public function afficheChefBox()
	{
		echo 	"<div id='chef-box'>",
				$this->nom_chef,"<br/>",
				$this->prenom_chef,"<br/>
				<form method='post' action='index.php'><input type='submit' name='deconnexion' value='Se déconnecter'></form>",
				"</div>";
	}
	
	public function mailToSansProjet($liste, $subject, $message)
	{
		foreach ($liste as $etudiant)
		{
			mail($to, $subject, $message);
		}
	}
	
}
?>