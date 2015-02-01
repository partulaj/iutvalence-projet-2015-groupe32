<?php
class EnseignantsDAO extends DAO {
	protected $table = "Enseignants";
	protected $class = "Enseignant";
	
	public function getAllEnseignant()
	{
		$res=array();
		$stmt = $this->pdo->query("SELECT * FROM $this->table");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class ($row);
		}
		return $res;
			
	}
	
	
	

}
?>