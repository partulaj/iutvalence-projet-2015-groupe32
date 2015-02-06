<?php
class ProjetsDAO extends DAO {
	protected $table = "Projets";
	protected $class = "Projet";
	
	
	/**
	 * Fonction qui récupère tous les projet d'un enseignant
	 * Fonction qui permet de récupérer tous les projets d'un enseignant dont le login est passé en paramètre
	 * @param $login : le login d'un enseignant
	 * @return $res : un tableau de projet
	 * @author Jérémie
	 * @version 1.0
	 */
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