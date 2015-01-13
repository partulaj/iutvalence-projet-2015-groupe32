<?php
class EtudiantsDAO extends DAO {
	protected $table = "Etudiants";
	protected $class = "Etudiant";

	// Fonction qui retourne tous les étudiants non affecté à un groupe (qui n'on pas de projet)
	public function getAllWithoutProjects()
	{
		global $class,$table;
		$res=array();
		$stmt = $this->pdo->query("SELECT * FROM $table WHERE no_groupe IS NULL");
		if ($stmt==null) 
		{
			return null;
		}
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
		{
			$res[] = new $class ($row);
		}
		return $res;
	}
}
?>