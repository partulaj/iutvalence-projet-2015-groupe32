<?php
class ProjetsDAO extends DAO {
	protected $table = "Projets";
	protected $class = "Projet";
	
	
	//fonction qui permet de recuperer la liste des projets associé à l'enseingnant actuel
	public function getAllMyProjects($login)
	{
		$res=array();
		$stmt = $this->pdo->prepare("SELECT * FROM Projets WHERE Projets.login_enseignant = ?");
		$stmt->execute(array($login));
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class ($row);
		}
		return $res;
	}	
	
	public function afficheProjetsRow()
	{
		echo "<tr><td>$this->nom_projet</td><td>$this->contexte</td><td>$this->objectif</td><td>$this->contrainte</td><td>$this->details</td></tr>";
	}
	
}
?>