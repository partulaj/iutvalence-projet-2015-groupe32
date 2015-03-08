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
	public function initAffectationAuto() {
		$res = array ();
		$DAOtemporaire = new EtudiantsDAO ( MaBD::getInstance () );
		$etudiantsATrier = $DAOtemporaire->getAllWithThisWish ( $this->no_projet );
		foreach ( $etudiantsATrier as $etudiant ) {
			if ($etudiant->aUnMeilleurVoeu ( $this->no_projet ) == false) {
				$res [] = $etudiant;
			}
		}
		if (count ( $res ) >= $this->nb_etu_max) {
			$this->affectationAuto ( $res );
		}
	}
	
	/**
	 * Fonction qui affecte automatiquement les étudiant au projet
	 * Fonction qui permet d'affecter les étudiant au projet en cours ($this)
	 * @param $tab :un tableau d'étudiants
	 * @author Jérémie
	 * @version 0.6
	 */
	private function affectationAuto($tab) {
		MaBD::getInstance()->beginTransaction();
		$DAOtemporaire = new EtudiantsDAO ( MaBD::getInstance () );
		$DAOtemporaire2 = new VoeuxDAO ( MaBD::getInstance () );
		$DAOtemporaire3 = new ProjetsDAO ( MaBD::getInstance () );
		$DAOtemporaire4 = new GroupesDAO(MaBD::getInstance());
		
		$groupes = $DAOtemporaire4->getAll("WHERE no_projet='$this->no_projet'");
		foreach ($groupes as $groupe)
		{
			if ($groupe->plein==false and !empty($tab))
			{
				$i=0;
				while ($i<$this->nb_etu_max)
				{	
					$etudiant = $tab[0];			
					$etudiant->no_groupe = $groupe->no_groupe;
					$DAOtemporaire->update ($etudiant );
					$DAOtemporaire2->deleteAllMyWish ($etudiant->login_etudiant );
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

	/**
	 * Fonction qui affiche un projet sous forme de ligne pour les étudiants
	 * Fonction qui permet d'afficher un projet sous la forme d'une ligne de tableau html avec un bouton qui ouvre une 
	 * modal pour l'ajouter à la liste des voeux
	 * @author Ihab, Jérémie
	 * @version 0.4
	 */
	public function toTableRowForStudents() 
	{
		$DAOtemporaire = new EnseignantsDAO ( MaBD::getInstance () );
		$enseignant = $DAOtemporaire->getOne ( $this->login_enseignant );
		echo "
		<tr>
			<td> $this->no_projet</td>
			<td> $this->nom_projet</td>
			<td>
				<button class='btn light-blue modal-trigger' href='#projet$this->no_projet'>En savoir plus</button>

				<div id='projet$this->no_projet' class='modal modal-fixed-footer'>
					<div class='modal-content'>
						<h4>$this->nom_projet</h4><h6>Projet pour $this->nb_etu_min à $this->nb_etu_max étudiants</h6>
						<span class='card-title black-text'>Contexte</span>
						<p>$this->contexte</p>
						<span class='card-title black-text'>Objectif</span>
						<p>$this->objectif</p>
						<span class='card-title black-text'>Contrainte</span>
						<p>$this->contrainte</p>
						<span class='card-title black-text'>Details</span>
						<p>$this->details</p>
					</div>
					<div class='modal-footer'>
						<div class='modal-container'>
							<div class='row'>
								<div class='offset-l1 col s2'>
									<p>Priorité<p>
									</div>
									<div class='col l3'>
										<p class='range-field'>
											<input id='priorite$this->no_projet' type='range' name='priorite$this->no_projet' min='1' max='3' value='0'>
										</p>
									</div>
									<div class='col l6'>
										<button href='#'  class='waves-effect waves-red btn-flat modal-action modal-close'>Annuler</button>
										<button onClick='ajoutVoeu(\"$this->no_projet\")' class='waves-effect waves-green btn-flat modal-action modal-close'>Ajouter</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</td>
		</tr>";
	}

	/**
	 * Fonction qui affiche un projet sous forme dde ligne pour les enseignants
	 * Fonction qui permet d'afficher un projet sous forme de ligne html avec une modal pour modifier le projet 
	 * et un bouton pour accéder à l'interface d'administration du projet
	 * @author Jérémie
	 * @version 0.2
	 */
	public function toTableRowForTeachers()
	{
		echo 
		"
		<tr>
			<td id='projet$this->no_projet'> $this->nom_projet</td>
			<td>
				<button class='btn light-blue modal-trigger' href='#editprojet$this->no_projet'>Modifier</button>
				<div id='editprojet$this->no_projet' class='modal'>
					<div class='modal-content'>
						<h4>Modification de $this->nom_projet</h4>
						<div class='input-field'> 
							<label for='projet_name$this->no_projet'>Nom du Projet</label>
							<input type='text' id='project_name$this->no_projet' name='project_name' value='$this->nom_projet' >
						</div>
						<div class='input-field'>
							<label for='nb_min$this->no_projet'>Nombre d'étudiants minimum</label>
							<input type='text' id='nb_min$this->no_projet' name='nb_min' value='$this->nb_etu_min'>
						</div>
						<div class='input-field'>
							<label for='nb_max$this->no_projet'>Nombre d'étudiants maximum</label>
							<input type='text' id='nb_max$this->no_projet' name='nb_max' value='$this->nb_etu_max'>
						</div>
						<div class='input-field'>
							<label for='contexte$this->no_projet'>Contexte</label>
							<textarea class='materialize-textarea' id='contexte$this->no_projet' name='contexte' >$this->contexte</textarea>
						</div>
						<div class='input-field'>
							<label for='objectif$this->no_projet'>Objectif</label>
							<textarea class='materialize-textarea' id='objectif$this->no_projet' name='objectif' >$this->objectif</textarea>
						</div>
						<div class='input-field'>
							<label for='contrainte$this->no_projet'>Contraintes</label>
							<textarea class='materialize-textarea' id='contrainte$this->no_projet' name='contrainte' >$this->contrainte</textarea>
						</div>
						<div class='input-field'>
							<label for='details$this->no_projet'>Détails</label>
							<textarea class='materialize-textarea' id='details$this->no_projet' name='details' >$this->details</textarea>
						</div>
						<br/>
					</div>
					<div class='modal-footer'>
						<button href='#' class='waves-effect waves-green btn-flat modal-action modal-close'>Annuler</button>
						<button onClick='editProject(\"$this->no_projet\")' name='edit_projet' class='waves-effect waves-green btn-flat modal-action modal-close'><span class='icon-save-floppy'></span> Enregistrer les Modifications</button>
					</div>
				</div>
			</td>
			<td>		
				<form name='formProjet$this->no_projet' method='post' action='gestionProjet.php'>
					<input type='hidden' name='projet' value='$this->no_projet'>
				</form>
				<button class='btn light-blue' onClick='javascript:document.formProjet$this->no_projet.submit();'>Administrer le Projet</button>
			</td>
		</tr>
		";
	}
}
?>
