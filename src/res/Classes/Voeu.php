<?php
class Voeu extends TableObject {
	static public $keyFieldsNames = array('no_voeu'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;	
	
	public function afficheVoeu()
	{
		echo "<td>", $this->no_voeu, 
		"</td><td>", $this->no_projet, "</td>";
	}
}
?>