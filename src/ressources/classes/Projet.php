<?php
/**
 * Classe représentent un projet tutoré
 * @author Jérémie
 * @package ressources/classes
 */
class Projet extends TableObject {
	public static $keyFieldsNames = array ('no_projet');
	public $hasAutoIncrementedKey = true;
	
	/**
	 * Fonction qui lance l'affectation automatique ci le nombre d'étudiant est suffisant
	 * Fonction qui déclenche l'affectation automatique si le nombres d'étudiant n'ayant pas de voeux plus prioritaire est supérieur ou égale au nombre d'étudiants maximale sur le projet
	 *
	 * @author Jérémie
	 * @version 1.2
	 */
	public function initAffectationAuto() 
	{
		$res = array ();
		$DAOtemporaire = new UtilisateursDAO ( MaBD::getInstance () );
		$etudiantsATrier = $DAOtemporaire->getAllWithThisWish ( $this->no_projet );
		$nb_ajac=0;
		foreach ( $etudiantsATrier as $etudiant ) {
			$etudiant = new Etudiant ($etudiant->getAllFields());
			if ($etudiant->aUnMeilleurVoeu ( $this->no_projet ) == false) 
			{

				if ($etudiant->ajac==true) 
				{
					if ($nb_ajac<2) 
					{
						$res [] = $etudiant;
						$nb_ajac++;
					}	
				}
				else
				{
					$res [] = $etudiant;
				}
			}
		}
		if (count ($res) >= $this->nb_etu_max) 
		{
			$this->affectationAuto ( $res );
		}
	}
	
	/**
	 * Fonction qui affecte automatiquement les étudiant au projet
	 * Fonction qui permet d'affecter les étudiant au projet en cours ($this)
	 * @param $tab :un tableau d'étudiants
	 * @author Jérémie
	 * @version 1.0
	 */
	private function affectationAuto($tab) 
	{
		MaBD::getInstance()->beginTransaction();
		$DAOtemporaire = new UtilisateursDAO ( MaBD::getInstance () );
		$DAOtemporaire2 = new VoeuxDAO ( MaBD::getInstance () );
		$DAOtemporaire3 = new ProjetsDAO ( MaBD::getInstance () );
		$DAOtemporaire4 = new GroupesDAO(MaBD::getInstance());

		$groupes = $DAOtemporaire4->getAll("WHERE no_projet='$this->no_projet'");
		foreach ($groupes as $groupe)
		{
			if ($groupe->plein==false and !empty($tab) and count($tab)>= $this->nb_etu_max)
			{
				$i=0;
				while ($i<$this->nb_etu_max)
				{	
					$etudiant = $tab[0];			
					$etudiant->no_groupe = $groupe->no_groupe;
					$DAOtemporaire->update ($etudiant);
					$DAOtemporaire2->deleteAllMyWish ($etudiant->login );
					unset($tab[0]);
					$tab = array_values($tab);
					$i++;
				}
				$groupe->plein=true;
				$DAOtemporaire4->update($groupe);
			}
		}		
		$groupes = $DAOtemporaire4->getAll("WHERE no_projet='$this->no_projet'");
		foreach ($groupes as $groupe)
		{
			if ($groupe->plein==true)
			{
				$this->affecter=1;
			}
			else 
			{
				$this->affecter=0;
				break;
			}
		}
		if($this->affecter==1)
		{
			$DAOtemporaire3->update ( $this );
			$DAOtemporaire2->deleteAllWishForThisProject ( $this );
		}
		MaBD::getInstance()->commit();
	}

	public function toOption()
	{
		echo '<option value="',$this->no_projet,'">',$this->nom_projet,'</option>';
	}

	/**
	 * Fonction qui affiche un projet sous forme de ligne pour les étudiants
	 * Fonction qui permet d'afficher un projet sous la forme d'une ligne de tableau html avec un bouton qui ouvre une 
	 * modal pour l'ajouter à la liste des voeux
	 * @author Ihab, Jérémie
	 * @version 0.4
	 */
	public function toTableRowForStudents() 
	{
		$DAOtemporaire = new UtilisateursDAO ( MaBD::getInstance () );
		$enseignant = $DAOtemporaire->getOne ( $this->login );
		echo '
		<tr>
			<td>', $this->no_projet,'</td>
			<td>', $this->nom_projet,'</td>
			<td>',$enseignant->nom,' ',$enseignant->prenom,'</td>
			<td>
				<button class="btn light-blue modal-trigger" href="#projet',$this->no_projet,'">En savoir plus</button>

				<div id="projet',$this->no_projet,'" class="modal modal-fixed-footer">
					<div class="modal-content">
						<h4>',$this->nom_projet,'</h4><h6>Projet pour ',$this->nb_etu_min,' à ',$this->nb_etu_max,' étudiants</h6>
						<span class="card-title black-text">Contexte</span>
						<p>',nl2br($this->contexte),'</p>
						<span class="card-title black-text">Objectif</span>
						<p>',nl2br($this->objectif),'</p>
						<span class="card-title black-text">Contrainte</span>
						<p>',nl2br($this->contrainte),'</p>
						<span class="card-title black-text">Details</span>
						<p>',nl2br($this->details),'</p>
					</div>
					<div class="modal-footer">
						<div class="modal-container">
							<div class="row">
								<div class="offset-l1 col s2">
									<p>Priorité<p>
									</div>
									<div class="col l3">
										<p class="range-field">
											<input id="priorite',$this->no_projet,'" type="range" name="priorite',$this->no_projet,'" min="1" max="3" value="0">
										</p>
									</div>
									<div class="col l6">
										<button href="#"  class="waves-effect waves-red btn-flat modal-action modal-close">Annuler</button>
										<button onClick="ajoutVoeu(',$this->no_projet,')" class="waves-effect waves-green btn-flat modal-action modal-close">Ajouter</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</td>
		</tr>';
	}

	/**
	 * Fonction qui affiche un projet sous forme dde ligne pour les enseignants
	 * Fonction qui permet d'afficher un projet sous forme de ligne html avec une modal pour modifier le projet, 
	 * un bouton pour accéder à l'interface d'administration du projet et un bouton pour afficher la liste des 
	 * étudiants interessé par ce projet 
	 * @author Jérémie
	 * @version 0.6
	 */
	public function toTableRowForTeachers()
	{
		$DAOtemporaire = new VoeuxDAO(MaBD::getInstance());
		$voeux = $DAOtemporaire->getAll("WHERE no_projet=$this->no_projet");
		echo 
		'
		<tr class="row">
			<td id="projet',$this->no_projet,'"> ',$this->nom_projet,'</td>
			<td><p>',nl2br($this->objectif),'</p></td>
			<td>
				<button class="btn light-blue modal-trigger" href="#editprojet',$this->no_projet,'">Modifier</button>
				
				<div id="editprojet',$this->no_projet,'" class="modal">
					<div class="modal-content">
						<h4>Modification de ',$this->nom_projet,'</h4>
						<div class="input-field"> 
							<label for="projet_name',$this->no_projet,'">Nom du Projet</label>
							<input type="text" id="project_name',$this->no_projet,'" name="project_name" value="',htmlspecialchars($this->nom_projet),'" >
						</div>
						<div class="row">
							<div class="input-field col s6">
								<input id="nb_min',$this->no_projet,'" name="nb_min" value="',$this->nb_etu_min,'" type="number" max="4" min="3" required/>
							</div>
							<div class="input-field col s6">
								<input id="nb_max',$this->no_projet,'" name="nb_max" value="',$this->nb_etu_max,'" type="number" max="6" min="3"required/>
							</div>
						</div>
						<div class="input-field ">
							<label for="contexte',$this->no_projet,'">Contexte</label>
							<textarea class="materialize-textarea" id="contexte',$this->no_projet,'" name="contexte" >',$this->contexte,'</textarea>
						</div>
						<div class="input-field">
							<label for="objectif',$this->no_projet,'">Objectif</label>
							<textarea class="materialize-textarea" id="objectif',$this->no_projet,'" name="objectif" >',$this->objectif,'</textarea>
						</div>
						<div class="input-field">
							<label for="contrainte$this->no_projet">Contraintes</label>
							<textarea class="materialize-textarea" id="contrainte',$this->no_projet,'" name="contrainte" >',$this->contrainte,'</textarea>
						</div>
						<div class="input-field">
							<label for="details$this->no_projet">Détails</label>
							<textarea class="materialize-textarea" id="details',$this->no_projet,'" name="details" >',$this->details,'</textarea>
						</div>
						<br/>
					</div>
					<div class="modal-footer">
						<button href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Annuler</button>
						<button onClick="editProject(',$this->no_projet,')" name="edit_projet" class="waves-effect waves-green btn-flat modal-action modal-close"><span class="icon-save-floppy"></span> Enregistrer</button>
						<button onClick="delProject(',$this->no_projet,')" name="del_projet" class="waves-effect waves-green btn-flat modal-action modal-close"><span class="mdi-action-delete"></span> Supprimer</button>
					</div>
				</div>
			</td>
		</tr>';

		if ($this->affecter==false and !empty($voeux))
		{
			echo'
			<tr class="hidden-element-block">
				<td colspan="3">
					<a class="waves-effect waves-grey btn-flat slide-link">Etudiant interessé</a>
					<ul class="collection hide">
						';
						foreach ($voeux as $voeu) 
						{
							$voeu->toListElem();	
						}
						echo'
					</ul>
				</td>
			</tr>
			';
		}
	}
}
?>
