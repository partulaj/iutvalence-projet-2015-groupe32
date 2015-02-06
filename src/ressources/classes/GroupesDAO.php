<?php
class GroupesDAO extends DAO {
	protected $table = "Groupes";
	protected $class = "Groupe";

	/**
	 * Fonction qui renvoie le Groupe associé au projet
	 * Fonction qui permet de récupérer les groupes associé au projet (si il y en a plusieurs par exemple les robots ePuk) dont on passe le numéro en paramètre
	 * @param $no_projet : un numéro de projet
	 * @return $res : un tableau de Groupe
	 * @author Ihab
	 * @version 1.0
	 */
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