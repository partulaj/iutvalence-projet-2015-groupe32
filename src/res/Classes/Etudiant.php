<?php
class Etudiant extends TableObject {
	static public $keyFieldsNames = array('login_etudiant'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	// Méthode qui affiche une boite d'authentification
	public function afficheEtudiantBox()
	{
		echo 	"<div id='etudiant-box'>"
				,$this->nom_etudiant,"<br/>"
				,$this->prenom_etudiant,"<br/>
				<form method='post' action='index.php'><input type='submit' name='deconnexion' value='Se déconnecter'></form>
				</div>";
	}

	// Méthode qui affiche un etudiant sous forme de ligne
	public function afficheEtudiantRow()
	{
		echo "<tr><td>",$this->nom_etudiant,"</td><td>",$this->prenom_etudiant,"</td><td><button href='",$this->mail_etudiant,"'></buttton></td></tr>";
	}
	
}
?>