<?php
class Chef extends TableObject {
	static public $keyFieldsNames = array('login_chef'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	//Fonction qui affiche le nom et prénom
	public function afficheNP()
	{
		echo 	$this->nom_chef," ",$this->prenom_chef;
	}

	//Fonction qui affiche le bouton de déconnexion
	public function afficheDeconnexionButton()
	{
		echo "<form method='post' action='index.php'><button type='submit' name='deconnexion' class='btn btn-danger'><span class='glyphicon glyphicon-off'></span> </a></form>";
	}
	
	//Fonction d'envoi de mail aux étudiants sans projet
	public function mailToSansProjets($array, $subject, $message)
	{
		foreach ($array as $etudiant)
		{
			mail($etudiant->mail_etudiant, $subject, $message);
		}
	}
	
}
?>