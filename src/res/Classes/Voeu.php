<?php
class Voeu extends TableObject {
	static public $keyFieldsNames = array('no_voeu','login_etudiant'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;	
	
	//Fonction d'affichage d'un voeux
	public function afficheVoeu()
	{
		$DAOtemporaire = new ProjetsDAO(MaBD::getInstance());
		$projet=$DAOtemporaire->getOne($this->no_projet);
		echo "<tr>
				<form method='post' action=''>
					<td class='col-xs-1'>
						<input type='hidden' name='voeuToEdit' value='$this->no_voeu'> 
						$this->no_voeu 
					</td>
					<td class='col-xs-1'> 
						$this->no_projet
					</td>
					<td>
						
					</td>
					<td class='col-xs-3'>
						<div class='input-group'>
							<input id='voeux_$this->no_projet' type='text' name='prioriteVoeuEdit' value='$this->priorité' class='form-control' readonly>
							<span class='input-group-btn'>
						    	<button onclick='inputNumberAdd(\"voeux_$this->no_projet\")' class='btn btn-success' type='button'><span class='glyphicon glyphicon-chevron-up'></span></button>
								<button onclick='inputNumberSub(\"voeux_$this->no_projet\")' class='btn btn-warning' type='button'><span class='glyphicon glyphicon-chevron-down'></span></button>
    						</span>
    					</div> 
					</td>
					<td>
					<button type='submit' name='modifier_voeux' class='btn btn-warning'>
						<span class='glyphicon glyphicon-floppy-open'></span>  
					</button>
					<button type='submit' name='supprimer_voeux' class='btn btn-danger'>
						<span class='glyphicon glyphicon-remove'></span>
					</button>
					</td>
				</form>
				</tr>";
	}
}
?>