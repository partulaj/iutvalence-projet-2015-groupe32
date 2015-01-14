<?php
class Projet extends TableObject {
	static public $keyFieldsNames = array('no_projet'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;

	public function afficheHtml()
	{
		echo    "<tr>
					<td class='col-xs-1'>
						<form method='post' action=''>
						<input type='hidden' name='noprojet' value='$this->no_projet'>
						$this->no_projet 
					</td>
					<td class='col-xs-3'> $this->nom_projet</td>
					<td class='col-xs-3'>$this->login_enseignant</td>
					<td class='col-xs-5'>
						<div class='input-group'>
							<input id='voeux_$this->no_projet' type='text' name='priorite' value='0' class='form-control' readonly>
							<span class='input-group-btn'>
						    	<button onclick='inputNumberAdd(\"voeux_$this->no_projet\")' class='btn btn-success' type='button'><span class='glyphicon glyphicon-chevron-up'></span></button>
								<button onclick='inputNumberSub(\"voeux_$this->no_projet\")' class='btn btn-warning' type='button'><span class='glyphicon glyphicon-chevron-down'></span></button>
    						</span>
    					</div>
					</td>
				</tr>
				</form>";
	}
}
?>