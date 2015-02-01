<?php
class ProjetsDAO extends DAO {
	protected $table = "Projets";
	protected $class = "Projet";
	
	
	//fonction qui permet de recuperer la liste des projets associ� � l'enseingnant actuel
	public function getAllMyProjects($login)
	{
		$res=array();
		$stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE Projets.login_enseignant = ?");
		$stmt->execute(array($login));
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class ($row);
		}
		return $res;
	}	
	
}
?>