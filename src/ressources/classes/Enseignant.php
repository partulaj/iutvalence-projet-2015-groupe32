<?php
class Enseignant extends Utilisateur {
	static public $keyFieldsNames = array('login_enseignant'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	/**
	 * Fonction d'affichage de la barre de navigation
	 * Fonction qui permet l'affichage d'une barre de navigation responsive personnalisé
	 * @author Jérémie
	 * @version 1.4
	 */
	public function afficheNavBar($icone=null, $titre=null)
	{
		if ($icone==null) 
		{
			$icone="icon-workshirt";
		}
		if ($titre==null) 
		{
			$titre="$this->nom_enseignant $this->prenom_enseignant";
		}
		echo '
		<ul id="dropdown1" class="dropdown-content">
			<li><a href="enseignant.php">Accueil</a></li>
			<li><a href="message.php">Message</a></li>
			<li><a href="projet.php">Gérer mes Projets</a></li>
			<li><a class="modal-trigger" href="#newprojet">Nouveau Projet</a></li>
		</ul>
		<nav>
			<form name="formDeDeconnexion" method="post" action="index.php">
				<input type="hidden" name="deconnexion" value="deconnexion">
			</form>
			<div class="nav-wrapper light-blue">
				<a href="#" class="brand-logo"><span class="',$icone,'"></span>',$titre,'</a>
				<a href="#"" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
				<ul class="right hide-on-med-and-down">
					<li>
						<a class="dropdown-button" href="#!" data-activates="dropdown1">
							Menu de Navigation<i class="mdi-navigation-arrow-drop-down right"></i>
						</a>
					</li>
					<li>
						<a class="navbar-link" href="javascript:document.formDeDeconnexion.submit();">
							<span class="icon-off"></span>
						</a>
					</li>
				</ul>
				<ul class="side-nav" id="mobile-demo">
					<li><a href="enseignant.php">Accueil</a></li>
					<li><a href="message.php">Message</a></li>
					<li><a href="projet.php">Gérer mes Projets</a></li>
					<li><a class="modal-trigger" href="#newprojet">Nouveau Projet</a></li>
					<li>
						<a class="navbar-link" href="javascript:document.formDeDeconnexion.submit();">
							<span class="icon-off"></span>
						</a>
					</li>
				</ul>
			</div>
		</nav>	
		';
		$this->NewProjectModal();
	}
	
	/**
	 * Fonction d'affichage de la fenêtre modal de création d'un nouveau projet
	 *
	 * @author Jérémie
	 * @version 0.4
	 */
	private function NewProjectModal()
	{
		echo '
		<div id="newprojet" class="modal">
			<div class="modal-content">
				<h4>Nouveau Projet</h4>
				<div class="input-field"> 
					<label for="projet_name">Nom du Projet</label>
					<input type="text" id="project_name" name="project_name" required>
				</div>
				<div class="row">
					<div class="input-field col s6">
						<input id="nb_min" type="number" max="4" min="3" value="3" required/>
					</div>
					<div class="input-field col s6">
						<input id="nb_max" type="number" max="6" min="3" value="3" required/>
					</div>
				</div>
				<div class="input-field">
					<label for="contexte">Contexte</label>
					<textarea class="materialize-textarea" id="contexte" name="contexte" ></textarea>
				</div>
				<div class="input-field">
					<label for="objectif">Objectif</label>
					<textarea class="materialize-textarea" id="objectif" name="objectif" ></textarea>
				</div>
				<div class="input-field">
					<label for="contrainte">Contraintes</label>
					<textarea class="materialize-textarea" id="contrainte" name="contrainte" ></textarea>
				</div>
				<div class="input-field">
					<label for="details">Détails</label>
					<textarea class="materialize-textarea" id="details" name="details" ></textarea>
				</div>
				<div class="switch">
					<label>
						1 Groupe
						<input type="checkbox" id="nb_groupes" name="nb_groupes">
						<span class="lever"></span>
						2 Groupes
					</label>
				</div>
				<br/>
			</div>
			<div class="modal-footer">
				<button href="#" class="waves-effect waves-red btn-flat modal-action modal-close">Annuler</button>
				<button onClick="newProject()" name="new_projet" class="waves-effect waves-green btn-flat modal-action modal-close"><span class="icon-save-floppy"></span> Enregistrer le nouveau Projet</button>
			</div>
		</div>
		';
	}
	
	/**
	 * Fonction qui affiche le formulaire d'envoie de mail
	 * Fonction qui permet d'afficher un formulaire d'envoie de message spéciale pour les enseignants
	 * @author Jérémie
	 * @version 1.0
	 */
	public function afficheMail()
	{
		echo '
		<form action="" method="post">
			<h6>Destinataire</h6>

			<select name="no_groupe">';
				$this->allMyGroupsToOptions();											
				echo '
			</select>
			<input type="hidden" id="groupe" name="groupe" value="true" />

			<div class="input-field">
				<label for="sujet">Sujet</label> <input type="text" name="sujet" id="sujet" required>
			</div>
			<div class="input-field">
				<label for="message">Message</label>
				<textarea class="materialize-textarea" name="message" required></textarea>
			</div>
			<div class="input-field">
				<div class="centre">
					<button type="submit" name="envoi"class="btn light-blue">
						<span class="mdi-communication-email"></span> Envoyer
					</button>
				</div>
			</div>
		</form>
		';
	}

	/**
	 * Fonction d'affichage de la page d'accueil d'un enseignant
	 *
	 * @author Jérémie
	 * @version 0.2
	 */
	public function afficheAccueil()
	{
		$DAOtemporaire = new ProjetsDAO(MaBD::getInstance());
		$projets = $DAOtemporaire->getAll("WHERE login_enseignant='$this->login_enseignant'");
		echo 
		'
		<div class="card">
			<div class="row">
				<div class="col s12">
					<h5>Vos Projets</h5>
					<p>Modifier ou administrer vos Projets</p>
				</div>
			</div>
			<table class="table bordered striped centered container">
				<tr>
					<th>Intitulé Projet</th>
					<th>Objectif</th>
					<th>Modifier</th>
				</tr>';
				foreach ($projets as $projet) 
				{
					$projet->toTableRowForTeachers();	
				}
				echo'
			</table>
		</div>
		';
	}

	/**
	 * Fonction qui récupère un tableau avec les groupes de l'enseignant
	 * 
	 * @author Jérémie
	 * @version 0.2
	 */
	public function allMyGroups()
	{
		$res = array();
		$resTemp = array();

		$DAOtemporaire = new ProjetsDAO(MaBD::getInstance());
		$DAOtemporaire2 =new GroupesDAO(MaBD::getInstance());
		$projets = $DAOtemporaire->getAll("WHERE login_enseignant='$this->login_enseignant'");
		foreach ($projets as $projet)
		{
			$resTemp=$DAOtemporaire2->getAll("WHERE no_projet=$projet->no_projet");
			foreach ($resTemp as $groupe)
			{
				$res[] = $groupe;
			}
		}
		return $res;
	}

	public function allMyGroupsFiltred()
	{
		$res = array();
		$resTemp = array();

		$DAOtemporaire = new ProjetsDAO(MaBD::getInstance());
		$DAOtemporaire2 =new GroupesDAO(MaBD::getInstance());
		$projets = $DAOtemporaire->getAll("WHERE login_enseignant='$this->login_enseignant'");
		foreach ($projets as $projet)
		{
			$resTemp=$DAOtemporaire2->getAll("WHERE no_projet=$projet->no_projet AND plein=TRUE");
			foreach ($resTemp as $groupe)
			{
				$res[] = $groupe;
			}
		}
		return $res;
	}

	/**
	 * Fonction d'affichage des groupes de l'enseignant dans un select
	 * 
	 * @author Jérémie
	 * @version 0.2
	 */
	public function allMyGroupsToOptions()
	{
		$tab = $this->allMyGroups();
		foreach ($tab as $groupe)
		{
			$groupe->toOption();
		}
	}

	public function allMyGroupsToOptionsFiltred()
	{
		$tab = $this->allMyGroupsFiltred();
		foreach ($tab as $groupe)
		{
			$groupe->toOption();
		}
	}

	public function afficheProjets()
	{

		echo 
		'
		<div class="card">
			<div class="row">
				<div class="col s12">
					<h5>Vos Projets</h5>
					<p>Choisissez le projet que vous souhaitez administrer</p>
				</div>
			</div>
			<select id="select-projet" onChange="selectChange(this.value)">
			<option value="" disabled selected>Choisir un Groupe</option>';
			$this->allMyGroupsToOptionsFiltred();
				echo
				'
			</select>
		</div>
		';
	}
}
?>