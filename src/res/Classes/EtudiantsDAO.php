<?php
class EtudiantsDAO extends DAO {
	protected $table = "Etudiants";
	protected $class = "Etudiant";

	// Fonction qui retourne tous les étudiants non affecté à un groupe (qui n'on pas de projet)
	public function getAllWithoutProjects()
	{
		$res=array();
		$stmt = $this->pdo->query("SELECT * FROM $this->table WHERE no_groupe IS NULL");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) 
		{
			$res[] = new $this->class ($row);
		}
		return $res;
	}
	
	public function getAllWithThisProject($projets)
	{
		
		$res=array();
		$stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE no_groupe = $projets->no_groupe");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class ($row);
		}
		return $res;
	}
		
}
?>