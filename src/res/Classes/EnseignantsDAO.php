<?php
class EnseignantsDAO extends DAO {
	protected $table = "Enseignants";
	protected $class = "Enseignant";
	
	public function getAllMyProject()
	{
		$table = "Projets";
		global $class,$table;
		$res=array();
		$stmt = $this->pdo->query("SELECT * FROM ");
		
	}
}
?>