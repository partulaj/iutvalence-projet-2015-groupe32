<?php
class Projet extends TableObject {
	static public $keyFieldsNames = array('no_projet'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;

	public function afficheHtml()
	{
		echo "<li>", $this->no_projet , " ",$this->nom_projet, "</li>";
	}
}
?>