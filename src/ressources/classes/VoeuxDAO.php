<<<<<<< HEAD
<?php
class VoeuxDAO extends DAO {
	protected $table = "Voeux";
	protected $class = "Voeu";
	
	
	/**
	 * Fonction qui récupère tous les voeux d'un étudiant
	 * Fonction qui permet de récupérer tous les voeux de l'étudiant dont le login est passé en paramètre.
	 * @param $login : le login d'un étudiant
	 * @author Jérémie
	 * @version 1.0
	 */
	public function getAllVoeuEtudiant($login)
	{
		$res = array();
		$stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE login_etudiant = ? ORDER BY priorite");
		$stmt->execute(array($login));
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class($row);
		}
		return $res;
	}
	
	/**
	 * Fonction qui efface tous les voeux d'un étudiant
	 * Fonction qui permet d'effacer tous les voeux d'un étudiant dont le login est passé en paramètre.
	 * @param $login : le login d'un étudiant
	 * @author Jérémie
	 * @version 1.0
	 */
	public function deleteAllMyWish($login)
	{
		$stmt=$this->pdo->prepare("DELETE FROM Voeux WHERE login_etudiant = ?");
		$stmt->execute(array($login));
	}

	/**
	 * Fonction qui efface tous les voeux associé à un projet
	 * Fonction qui permet d'effacer tous les voeux d'un projet dont le numéro est passé en paramètre.
	 * @param $no_projet : le numéro d'un projet
	 * @author Jérémie
	 * @version 0.2
	 */
	public function deleteAllWishForThisProject($no_projet)
	{
		$stmt=$this->pdo->prepare("DELETE FROM Voeux WHERE no_projet = ?");
		$stmt->execute(array($no_projet));
	}
}
=======
<?php
class VoeuxDAO extends DAO {
	protected $table = "Voeux";
	protected $class = "Voeu";
	
	/**
	 * Fonction qui récupère tous les voeux d'un étudiant
	 * Fonction qui permet de récupérer tous les voeux de l'étudiant dont le login est passé en paramètre.
	 * @param $login : le login d'un étudiant
	 * @author Jérémie
	 * @version 1.0
	 */
	public function getAllVoeuEtudiant($login)
	{
		$res = array();
		$stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE login_etudiant = ? ORDER BY priorite");
		$stmt->execute(array($login));
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class($row);
		}
		return $res;
	}
	
	/**
	 * Fonction qui efface tous les voeux d'un étudiant
	 * Fonction qui permet d'effacer tous les voeux d'un étudiant dont le login est passé en paramètre.
	 * @param $login : le login d'un étudiant
	 * @author Jérémie
	 * @version 1.0
	 */
	public function deleteAllMyWish($login)
	{
		$stmt=$this->pdo->prepare("DELETE FROM Voeux WHERE login_etudiant = ?");
		$stmt->execute(array($login));
	}

	/**
	 * Fonction qui efface tous les voeux associé à un projet
	 * Fonction qui permet d'effacer tous les voeux d'un projet dont le numéro est passé en paramètre.
	 * @param $no_projet : le numéro d'un projet
	 * @author Jérémie
	 * @version 0.2
	 */
	public function deleteAllWishForThisProject($no_projet)
	{
		$stmt=$this->pdo->prepare("DELETE FROM Voeux WHERE no_projet = ?");
		$stmt->execute(array($no_projet));
	}
}
>>>>>>> refs/remotes/origin/jeremie
?>
