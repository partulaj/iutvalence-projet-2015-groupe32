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
	
	public function AfficheMyEtudiants()
	{
		$res=array();
		$stmt = $this->pdo->query("SELECT * FROM `$this->table` INNER JOIN `Groupes` ON Etudiants.no_groupe = Groupes.no_groupe INNER JOIN `Projets` ON Groupes.no_groupe = Projets.no_groupe INNER JOIN `Enseignants` ON Projets.login_enseignant = Enseignants.login_enseignant");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class ($row);
		}
		return $res;
	}
		
}
?>