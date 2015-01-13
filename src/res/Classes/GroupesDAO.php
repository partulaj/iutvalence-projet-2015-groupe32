<?php
class GroupesDAO extends DAO {
	protected $table = "Groupes";
	protected $class = "Groupe";
	
	public function getAllGroupe()
	{
		$res=array();
		$stmt = $this->pdo->query("SELECT no_groupe,nom_etudiant,prenom_etudiant FROM $this->table");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class ($row);
		}
		return $res;
	}
	
	public function getGroupeOfThisProject($no_projet)
	{
		$res=array();
		$stmt = $this->pdo->query("SELECT name_etudiant,prenom_etudiant FROM $this->table WHERE Groupe.no_projet = $no_projet");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class ($row);
		}
		return $res;
		
		
	}
}
?>