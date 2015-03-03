<?php
class Groupe extends TableObject {
	//Nombre maximum de groupe pour un projet
	const NB_GROUPE_MAX = 2;

	static public $keyFieldsNames = array('no_groupe'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;
	
	public function toOption()
	{
		$DAOtemporaire = new ProjetsDAO(MaBD::getInstance());
		$projet = $DAOtemporaire->getOne($this->no_projet);
		echo "<option value='$this->no_groupe'> Groupe $this->no_groupe - $projet->nom_projet</option>";
	}
}
?>