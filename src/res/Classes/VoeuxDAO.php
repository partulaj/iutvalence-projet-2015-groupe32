<?php
class VoeuxDAO extends DAO {
	protected $table = "Voeux";
	protected $class = "Voeu";
	
	//recuperation des voeux enfonction du login de l'etudiant
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