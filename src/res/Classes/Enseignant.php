<?php
class Enseignant extends TableObject {
	static public $keyFieldsNames = array('login_enseignant'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	public function afficheEnseignant()
	{
		echo 	"<div id='enseignant-box'>
				$this->nom_enseignant<br/>
				$this->prenom_enseignant<br/>
				<form method='post' action='index.php'><input type='submit' name='deconnexion' value='Se déconnecter'></form>
				</div>";
	}
	
	//Envoi un mail au groupe selectionné
	public function mailToGroupOfThisProject($groupe, $subject, $message)
	{	
		$res=array();
		$stmt = $this->pdo->query("SELECT no_etudiant,mail_etudiant FROM $etudiant WHERE $etudiant->no_groupe = $groupe->no_groupe");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class ($row);
		}
		return $res;
		foreach ($row as $etudiant)
		{
			mail($etudiant->mail_etudiant, $subject, $message);
		}
	}
}
?>