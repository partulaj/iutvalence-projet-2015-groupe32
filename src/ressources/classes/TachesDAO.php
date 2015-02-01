<?php
class TachesDAO extends DAO {
	protected $table = "Taches";
	protected $class = "Tache";
	
	public function AddTaches()
	{
		$stmt = $this->pdo->query("INSERT INTO $this->table ('no_tache','nom_tache','avancement','no_projet','login_etudiant') VALUES (' ',' ',' ',' ',' ')");
		
		
	}
	
	public function SetTaches($nom_tache)
	{
		
		
	}
}
?>