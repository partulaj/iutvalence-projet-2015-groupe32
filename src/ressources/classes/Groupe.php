<?php
class Groupe extends TableObject {
	static public $keyFieldsNames = array('nom_groupe','no_projet'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
}
?>