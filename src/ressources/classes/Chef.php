<?php
class Chef extends Utilisateur {
	static public $keyFieldsNames = array('login_chef'); // par défaut un seul champ
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
			$icone="icon-chef";
		}
		if ($titre==null) 
		{
			$titre=" $this->nom_chef $this->prenom_chef";
		}
		echo "
		<ul id='dropdown1' class='dropdown-content'>
			<li><a href='chef.php'>Accueil</a></li>
			<li><a href='message.php'>Message</a></li>
		</ul>
		<nav>
			<form name='formDeDeconnexion' method='post' action='index.php'>
				<input type='hidden' name='deconnexion' value='deconnexion'>
			</form>
			<div class='nav-wrapper light-blue'>
				<a href='#'' class='brand-logo'><span class='$icone'></span>$titre</a>
				<a href='#' data-activates='mobile-demo' class='button-collapse'><i class='mdi-navigation-menu'></i></a>
				<ul class='right hide-on-med-and-down'>
					<li>
						<a class='dropdown-button' href='#!' data-activates='dropdown1'>
							Menu de Navigation<i class='mdi-navigation-arrow-drop-down right'></i>
						</a>
					</li>
					<li>
						<a class='navbar-link' href='javascript:document.formDeDeconnexion.submit();'>
							<span class='icon-off'></span>
						</a>
					</li>
				</ul>
				<ul class='side-nav' id='mobile-demo'>
					<li><a href='chef.php'>Accueil</a></li>
					<li><a href='message.php'>Message</a></li>
					<li>
						<a class='navbar-link' href='javascript:document.formDeDeconnexion.submit();'>
							<span class='icon-off'></span>
						</a>
					</li>
				</ul>
			</div>
		</nav>	
		";
	}

	/**
	 * Fonction qui envoie un mail au élève sans projet
	 * Fonction qui permet au chef des projet d'envoyer un mail à tous les étudiants sans projet.
	 * @param 	$subject : sujet du mail
	 * @param	$message : message du mail
	 * @author Jérémie
	 * @version 1.0
	 */
	public function mailToSansProjets($subject, $message)
	{
		$DAOtemporaire = new EtudiantsDAO(MaBD::getInstance());
		$res = $DAOtemporaire->getAllWithoutProjects();
		foreach ($res as $etudiant)
		{
			mail($etudiant->mail_etudiant, $subject, $message);
		}
	}

	/**
	 * Fonction qui affiche le formulaire d'envoie de mail
	 * Fonction qui permet d'afficher un formulaire d'envoie de message spéciale pour le chef
	 * @author Jérémie
	 * @version 1.0
	 */
	public function afficheMail()
	{
		echo "
		<form action='' method='post' >
			<h6>Destinataire</h6>
			<div class='row'>
				<div class='input-field col l4'>
					<select name='no_groupe'>";
						$this->allGroupsToOptions();											
						echo				"
					</select>
				</div>			
				<div class='input-field col l8'>
					<input type='checkbox' id='groupe' />
					<label for='groupe'>Groupe</label>
					<input type='checkbox' id='tuteur' />
					<label for='tuteur'>Tuteur</label>
					<input type='checkbox' id='chef' />
					<label for='chef'>Responsable des projets</label>
				</div>
			</div>
			<div class='input-field'>
				<label for='sujet'>Sujet</label> <input type='text' name='sujet' id='sujet' required>
			</div>
			<div class='input-field'>
				<label for='message'>Message</label>
				<textarea class='materialize-textarea' name='message' required></textarea>
			</div>
			<div class='input-field'>
				<div class='centre'>
					<button type='submit' name='envoi'class='btn light-blue'>
						<span class='mdi-communication-email'></span> Envoyer
					</button>
				</div>
			</div>
		</form>
		";
	}

	/**
	 * Fonction qui récupère tous les groupes et les affiche dans un select
	 * Fonction qui permet de récupérer tous les groupes et de les afficher dans une liste déroulante avec une option 
	 * supplémentaire pour les étudiants sans projet
	 * @author Jérémie
	 * @version 0.2
	 */
	public function allGroupsToOptions()
	{
		$DAOtemporaire = new GroupesDAO(MaBD::getInstance());
		$tab=$DAOtemporaire->getAll();
		echo "<option value='sans_projet'>Etudiants Sans Projet</option>";
		foreach ($tab as $groupe)
		{
			$groupe->toOption();
		}
	}

}
?>