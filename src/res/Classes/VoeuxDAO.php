<?php
class VoeuxDAO extends DAO {
	protected $table = "Voeux";
	protected $class = "Voeu";
	
	//fonction qui recupère les voeux de l'etudiant en fonction de son login
	public function getAllVoeuEtudiant($login)
	{
		$res = array();
		$stmt = $this->pdo->prepare("SELECT * FROM Voeux WHERE login_etudiant = ? ORDER BY priorité");
		$stmt->execute(array($login));
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new voeu($row);
		}
		return $res;
	}
}
?>