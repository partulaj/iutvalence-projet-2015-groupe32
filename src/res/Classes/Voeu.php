<?php
class Voeu extends TableObject {
	static public $keyFieldsNames = array('no_voeu','login_etudiant'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;	
	
	//Fonction d'affichage d'un voeux
	public function afficheVoeu()
	{
		echo "<tr>
				<form method='post' action=''>
					<td class='col-1'>
						<input type='hidden' name='voeuToDel' value='$this->no_voeu'> 
						$this->no_voeu 
					</td>
					<td class='col-2'> 
						$this->no_projet
					</td>
					<td> 
						<button type='submit' name='supprimer_voeux' class='btn btn-danger'>
							<span class='glyphicon glyphicon-remove'></span>
						</button>
					</td>
				</form>
				</tr>";
	}
}
?>