<?php
class Etudiant extends Utilisateur {
	static public $keyFieldsNames = array('login'); // par défaut un seul champ
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
			$icone="icon-student-school";
		}
		if ($titre==null) 
		{
			$titre=" $this->nom $this->prenom";
		}
		echo '
		<ul id="dropdown1" class="dropdown-content">
			<li><a href="etudiant.php">Accueil</a></li>';
			if (is_null($this->no_groupe)) 
			{
				echo '
				<li><a href="projet.php">Projet</a></li>
				<li><a href="voeu.php">Voeux</a></li>';
			}
			if (!is_null($this->no_groupe)) 
			{
				echo '
				<li><a href="reunion.php">Réunion</a></li>
				';
			}
			echo '
			<li><a href="message.php">Message</a></li>
		</ul>
		<nav>
			<form name="formDeDeconnexion" method="post" action="index.php">
				<input type="hidden" name="deconnexion" value="deconnexion">
			</form>
			<div class="nav-wrapper light-blue">
				<a href="#"" class="brand-logo"><span class="',$icone,'"></span>',$titre,'</a>
				<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
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
					<li><a href="etudiant.php">Accueil</a></li>';
					if (is_null($this->no_groupe)) {
						echo '
						<li><a href="projet.php">Projet</a></li>
						<li><a href="voeu.php">Voeux</a></li>';
					}
					if (!is_null($this->no_groupe)) 
					{
						echo '
						<li><a href="reunion.php">Réunion</a></li>
						';
					}
					echo'
					<li><a href="message.php">Message</a></li>
					<li>
						<a class="navbar-link" href="javascript:document.formDeDeconnexion.submit();">
							<span class="icon-off"></span>
						</a>
					</li>
				</ul>
			</div>
		</nav>		
		';
	}

	/**
	 * Fonction qui permet de voir si l'étudiant à un voeux avec une priorité plus importante
	 * Fonction qui regarde parmi tous les voeux de l'étudiant si celui-ci à un voeu avec une priorité plus importante que celui pour le projet dont le numéro est passé en paramètre
	 * @param $num = un numéro de projet
	 * @author Jérémie
	 * @version 1.2
	 */
	public function aUnMeilleurVoeu($num)
	{
		$DAOtemporaire = new VoeuxDAO(MaBD::getInstance());
		$voeux = $DAOtemporaire->getAllVoeuEtudiant($this->login);
		$voeu = $DAOtemporaire->getOne(array($num,$this->login));
		foreach ($voeux as $voeuAComparer)
		{
			if ($voeuAComparer->priorite>$voeu->priorite)
			{
				return true;
			}
		}
		return false;
	}

	
	/**
	 * Fonction qui affiche le formulaire d'envoie de mail
	 * Fonction qui permet d'afficher un formulaire d'envoie de message spéciale pour les étudiants
	 * @author Jérémie
	 * @version 1.0
	 */
	public function afficheMail()
	{
		echo '
		<form action="" method="post">
			<h6>Destinataire</h6>
			<input type="hidden" value="',$this->no_groupe,'" name="no_groupe">
			<p>';
				if(!is_null($this->no_groupe))
				{
					echo
					'<input type="checkbox" name="groupe" id="groupe" />
					<label for="groupe">Groupe</label>
					<input type="checkbox" name="tuteur" id="tuteur" />
					<label for="tuteur">Tuteur</label>';
				}
				echo
				'<input type="checkbox" name="chef" id="chef" />
				<label for="chef">Responsable des projets</label>
			</p>

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
	 * Fonction d'affichage de la page d'accueil pour un étudiant
	 * Fonction qui permet d'afficher l'accueil avec l'interface de gestion des taches
	 * @author Jérémie
	 * @version 0.2
	 */
	public function afficheAccueil()
	{
		$DAOtemporaire = new TachesDAO(MaBD::getInstance());
		$taches = $DAOtemporaire->getAll("WHERE no_groupe = '$this->no_groupe' ORDER BY ordre_tache");
		echo '
		<div class="card">
			<div class="row">
				<div class="col s12">
					<h5>Gestion des tâches</h5>
					<p>Modifier, ajouter ou supprimer des tâches</p>
				</div>
			</div>
			<table class="responsive-table bordered centered">
				<tr>
					<th>Tache</th>
					<th>Etat</th>
					<th>Personne(s) en Charge</th>
					<th>Ordre de la tache</th>
					<th>Action</th>
				</tr>';
				foreach ($taches as $tache) 
				{
					$tache->toTableRow();	
				}
				$newTache = new Tache(array(	
					"no_tache"=>DAO::UNKNOWN_ID,
					"nom_tache"=>null,
					"etat_tache"=>null,
					"ordre_tache"=>null,
					"login"=>null,
					"no_groupe"	=> $this->no_groupe							
					));
				$newTache->toAddingTableRow();
				echo'
			</table>
		</div>
		';
	}


	/**
	 * Affichage de l'interface de choix du projet pour l'étudiant
	 * @author Jérémie
	 * @version 0.2
	 */
	function afficheProjets()
	{
		$projetsDAO = new ProjetsDAO(MaBD::getInstance());
		$login=$_SESSION['user']->login;
		$lesProjets = $projetsDAO->getAll("WHERE no_projet NOT IN (SELECT no_projet FROM Voeux WHERE login='$login')");
		echo'
		<div class="card">
			<div class="row">
				<div class="col s12">
					<h5>Liste des Projets</h5>
					<p>Choisissez les projets qui vous intéressent</p>
				</div>
			</div>
			<table class="responsive-table bordered striped centered">
				<tr>
					<th>Numéro Projet</th>
					<th>Intitulé Projet</th>
					<th>Details</th>
				</tr>
				';
				foreach ($lesProjets as $projet)
				{
					if ($projet->affecter==0)
					{
						$projet->toTableRowForStudents();
					}
				}
				echo '	
			</table>
		</div>';
	}

	/**
	 * Fonction d'affichage de l'interface pour demander une réunion pour les étudiants
	 * @author Jérémie
	 * @version 0.2
	 */
	public function afficheReunion()
	{
		echo '
		<div class="row">
			<div class="card col s12">
				<h5>Réunion</h5>
				<form method="get" action="http://doodle.com/polls/wizard.html">
					<input type="hidden" name="type" value="date">
					<input type="hidden" name="locale" value="fr">
					<input type="hidden" name="name" value="',$this->nom," ",$this->prenom,'">
					<input type="hidden" name="eMailAddress" value="',$this->mail,'">

					<div class="input-field">
						<label for="title">Titre de la réunion</label>
						<input type="text" name="title" id="title" required>
					</div>

					<div class="input-field">
						<label for="location">Lieu de la réunion</label>
						<input type="text" name="location" id="location" required>
					</div>

					<div class="input-field">
						<label for="description">Sujet(s) de la réunion</label>
						<textarea class="materialize-textarea" type="text" name="description" id="description" required></textarea>
					</div>

				<div class="centre">
					<input class="btn light-blue" type="submit" value="Demander réunion">
				</div>
			</form>
		</div>
		';
	}

}
?>