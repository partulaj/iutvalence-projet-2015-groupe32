<?php
class Projet extends TableObject {
	static public $keyFieldsNames = array('no_projet'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;

	public function afficheHtml()
	{
		echo "<tr><td>", $this->no_projet , 
		"</td><td>", $this->nom_projet,
		"</td><td><form method='post' action=''>",
		"<input type='range' name='numVoeux' min='0' max='3' value='0' step='1'>",
		"</form></td></tr>";
	}
}
?>