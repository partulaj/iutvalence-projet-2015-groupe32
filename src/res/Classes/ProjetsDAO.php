<?php
class ProjetsDAO extends DAO {
	protected $table = "Projets";
	protected $class = "Projet";
	
	
	//fonction qui permet de recuperer la liste des projets associé à l'enseingnant actuel
	public function getAllMyProject($login)
	{
		$nameProjet = $tableProjet->$this."nom_projet";
		$res=array();
		$stmt = $this->pdo->query("SELECT * FROM $this->table WHERE Projet.login_enseignant = $login");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class ($row);
		}
		return $res;
	}	
	
	public function AddProject()
	{
		
				
	}
}
?>