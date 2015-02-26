<?php
class TachesDAO extends DAO {
	protected $table = "Taches";
	protected $class = "Tache";
	
	/**
	 * fonction qui recupaire toute les taches d'un projet en fonction de son numero de projet
	 * @param unknown $login
	 * @return multitype:unknown
	 */
	public function getAllTacheEtudiant($projet)
	{
		$res = array();
		$stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE no_projet = ? ORDER BY no_tache");
		$stmt->execute(array($projet));
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class($row);
		}
		return $res;
	}
}
?>