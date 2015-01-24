<?php
class Etudiant extends TableObject {
	static public $keyFieldsNames = array('login_etudiant'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	//Fonction qui affiche le nom et prénom
	public function afficheNP()
	{
		echo 	$this->nom_etudiant," ",$this->prenom_etudiant;
	}

	//Fonction qui affiche le bouton de déconnexion
	public function afficheDeconnexionButton()
	{
		echo "<form method='post' action='index.php'><button type='submit' name='deconnexion' class='btn btn-danger'><span class='glyphicon glyphicon-off'></span> </a></form>";
	}

	//Méthode qui affiche un etudiant sous forme de ligne
	public function afficheEtudiantRow()
	{
		echo '<tr><td>',$this->nom_etudiant,'</td><td>',$this->prenom_etudiant,'</td><td><a href="mailto:',$this->mail_etudiant,'">Lui écrire</a></td></tr>';
	}

	///////////////// Documentation à ajouté /////////////////
	public function afficheMesEtudiants()
	{
		echo '<tr><td>',$this->nom_etudiant,'</td><td>',$this->prenom_etudiant,'</td><td>';
	}
}
?>