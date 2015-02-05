<?php
class VoeuxDAO extends DAO {
	protected $table = "Voeux";
	protected $class = "Voeu";
	
	//Fonction qui recupère les voeux de l'etudiant en fonction de son login

	/**
	 * Fonction qui récuppère tous les voeux d'un étudiant
	 * Fonction qui permet de récupérer tous les voeux de l'étudiant dont le login est passé en paramètre.
	 * $login : le login d'un étudiant
	 */
	public function getAllVoeuEtudiant($login)
	{
		$res = array();
		$stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE login_etudiant = ? ORDER BY priorité");
		$stmt->execute(array($login));
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class($row);
		}
		return $res;
	}
	
	//Fonction qui supprime tous les voeux d'un étudiant
	public function deleteAllMyWish($login)
	{
		$stmt=$this->pdo->prepare("DELETE FROM Voeux WHERE login_etudiant = ?");
		$stmt->execute(array($login));
	}

}
?>
