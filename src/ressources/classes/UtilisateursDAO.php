<?php
class UtilisateursDAO extends DAO 
{
	protected $table = "Utilisateurs";
	protected $class = "Utilisateur";

	/**
	 * Fonction qui retourne tous les étudiant qui ont fait un voeu sur un certain projet
	 * Fonction qui permet de récupérer tous les étudiants qui ont fait un voeu sur le projet dont le numéro est passé en paramètre
	 * @param $num : un numéro de projet
	 * @return $res : un tableau d'étudiants
	 * @author Jérémie
	 * @version 1.4
	 */
	public function getAllWithThisWish($num)
	{
		$res = array();
		$stmt = $this->pdo->prepare("SELECT $this->table.* FROM $this->table NATURAL JOIN Voeux WHERE Voeux.no_projet=? ORDER BY date Asc, $this->table.classement");
		$stmt->execute(array($num));
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class ($row);
		}
		return $res;
	}
}
?>