<<<<<<< HEAD
<?php
class Tache extends TableObject {
	static public $keyFieldsNames = array('no_tache'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;
	
	
	/**
	 * fonction qui affiche le nom, l'avencement (par une barre) et les soutaches associé de la tache du projet
	 * 
	 */
	public function afficheTache() {
		
		echo "<div class='progress'>
				<div class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='$this->avancement' aria-valuemax='100' style='width: $this->$avancement%;'>
				", $this->avancement,"%
				</div>
			</div> 
			<input id='tache_1'  type='text' readonly='' value=", $this->nom_tache,">
			<div class='interaction'>
				<button type='submit' name='modifier_Tache' class='btn'>
						<span class=''></span>
				</button>
				<button type='submit' name='supprimer_tache' class='btn'>
						<span class=''></span>
				</button>
				<button type='submit' name='ajouter_sousTache' class='btn'>
						<span class=''></span>
				</button>
			</div>";
	}
	
}
=======
<?php
class Tache extends TableObject {
	static public $keyFieldsNames = array('no_tache'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;
	private $status = array("Non Commencé","En Cours", "Test", "Refractoring","Fini");

	/**
	 * Fonction qui affiche une tache sous forme de ligne Html
	 * Fonction qui permet d'afficher une tache sous forme d'une ligne Html permettant la modificaation et la supression
	 * de cette tache
	 * @author Jérémie
	 * @version 0.2
	 */
	public function toTableRow()
	{
		$DAOtemporaire = new GroupesDAO(MaBD::getInstance());
		$groupe = $DAOtemporaire->getOne($this->no_groupe);
		$classe="";
		switch ($this->etat_tache) {
			case 'Non Commencé':
				$classe="red lighten-4";
				break;
			
			case 'En Cours':
				$classe="orange lighten-4";
				break;

			case 'Test':
				$classe="teal lighten-4";
				break;

			case 'Refractoring':
				$classe="deep-purple lighten-4";
				break;

			case 'Fini':
				$classe="light-green lighten-4";
				break;
		}

		echo 
		'
		<tr class="',$classe,'">
			<td>
				<div class="input-field">
					<input type="text" id="nom_tache', $this->no_tache, '" value="',htmlspecialchars($this->nom_tache),'">
				</div>
			</td>
			<td>
				<div class="input-field">
					<select id="etat_tache', $this->no_tache, '">';
						$this->statusToOption();
						echo '
					</select>
				</div>
			</td>
			<td id="list_tache', $this->no_tache, '">';
				$groupe->listMembers($this->no_tache);
				echo '
			</td>
			<td>
				<div class="input-field">
					<input id="ordre_tache', $this->no_tache, '" type="number" max="10000" min="1" value="', $this->ordre_tache, '"/>
				</div>
			</td>
			<td>
				<button type="submit" onClick="editTask(', $this->no_tache, ', ', $this->no_groupe, ')" class="btn amber">
					<span class="mdi-image-edit"></span>  
				</button>
				<button type="submit" onClick="delTask(', $this->no_tache, ')" class="btn red">
					<span class="mdi-action-delete"></span>
				</button>
			</td>
		</tr>
		';
	}

	/**
	 * Fonction qui affiche une tache sous forme d'une ligne Html d'ajout de tache
	 * Fonction qui permet d'afficher une tache sous forme de ligne Html à remplir pour ajouter une tache
	 * @author Jérémie
	 * @version 0.2
	 */
	public function toAddingTableRow()
	{
		$DAOtemporaire = new GroupesDAO(MaBD::getInstance());
		$groupe = $DAOtemporaire->getOne($this->no_groupe);
		echo 
		'
		<tr>
			<td>
				<div class="input-field">
					<label for="nom_new_tache">Nom de la Tache</label>
					<input type="text" id="nom_new_tache">
				</div>
			</td>
			<td >
				<div class="input-field">
					<select id="etat_new_tache">';
						$this->statusToOption();
						echo '
					</select>
				</div>
			</td>
			<td id="list_new_tache">';
				$groupe->listMembers();
				echo '
			</td>
			<td>
				<div class="input-field">
					<input id="ordre_new_tache" type="number" max="10000" min="1" value="1"/>
				</div>
			</td>
			<td>
				<button type="submit" onClick="newTask(',$this->no_groupe,')" class="btn green accent-4">
					<span class="mdi-content-add"></span>
				</button>
			</td>
		</tr>
		';
	}

	/**
	 * Fonction qui affiche la liste des etat possible d'une tache 
	 * Fonction qui permet d'afficher la liste des etat possible d'une tache
	 * @author Jérémie
	 * @version 1.0
	 */
	public function statusToOption()
	{
		if ($this->etat_tache!=null)
		{
			echo '<option value="',$this->etat_tache,'"selected>',$this->etat_tache,'</option>';
			$current=$this->etat_tache;
		}
		else
		{
			$current=null;
		}
		foreach ($this->status as $etat) 
		{
			if ($etat!=$current) 
			{
				echo '<option value="',$etat,'">',$etat,'</option>';
			}
		}
	}
}
>>>>>>> refs/remotes/origin/jeremie
?>
