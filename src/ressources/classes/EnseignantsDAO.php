<?php
class EnseignantsDAO extends DAO {
	protected $table = "Enseignants";
	protected $class = "Enseignant";
	
	/**
	 * Fonction qui renvoi la liste des etudiants (et leur mail) du groupe selectioné dans la liste déroulente
	 * @param unknown $groupe
	 * @param unknown $subject
	 * @return multitype:unknown
	 */
	public function aRenomer($groupe, $subject)
	{
		$res=array();
		$stmt = $this->pdo->query("SELECT no_etudiant, mail_etudiant FROM $etudiant WHERE $etudiant->no_groupe = $groupe->no_groupe");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class ($row);
		}
		return $res;
	}
}
?>