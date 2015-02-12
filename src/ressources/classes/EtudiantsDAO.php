<?php
class EtudiantsDAO extends DAO {
	protected $table = "Etudiants";
	protected $class = "Etudiant";

	/**
	 * Fonction qui récupère tous les étudiants sans projet
	 * Fonction qui permet de récupérer un tableau contenant tous les étudiants qui n'on pas encore de projet
	 * @author Jérémie
	 * @version 1.0
	 */
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
	
	/**
	 * Fonction qui récupère tous les étudiants d'un projet
	 * Fonction qui permet de récupérer tous les étudiants d'un projet que l'on passe en paramètre
	 * @param $projets : un Projet
	 * @return $res : un tableau d'étudiants
	 * @author Ihab, Jérémie
	 * @version 1.2
	 */
	public function getAllWithThisProject($no_groupe)
	{	
		$res=array();
		$stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE no_groupe = ?");
		$stmt ->execute(array($no_groupe));
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class ($row);
		}
		return $res;
	}
	
	/**
	 * Fonction qui retourne tous les étudiant qui ont fait un voeu sur un certain projet
	 * Fonction qui permet de récupérer tous les étudiants qui ont fait un voeu sur le projet dont le numéro est passé en paramètre
	 * @param $num : un numéro de projet
	 * @return $res : un tableau d'étudiants
	 * @author Jérémie
	 * @version 1.0
	 */
	public function getAllWithThisWish($num)
	{
		$res = array();
		$stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE login_etudiant IN (SELECT login_etudiant FROM Voeux WHERE no_projet = ? ORDER BY date)");
		$stmt->execute(array($num));
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class ($row);
		}
		return $res;
	}
	
}
?>