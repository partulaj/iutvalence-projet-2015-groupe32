<?php
class Enseignant extends Utilisateur {
	static public $keyFieldsNames = array('login_enseignant'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	/**
	 * Fonction d'affichage de la barre de navigation
	 * Fonction qui permet d'afficher une barre de navigation responsive (Bootstrap) avec le nom et le prénom de l'enseignant ainsi que l'onglet actif.
	 * @author Jérémie
	 * @version 1.0
	 */
	public function afficheNavBar()
	{
		echo "
		<nav>
			<form name='formDeDeconnexion' method='post' action='index.php'>
				<input type='hidden' name='deconnexion' value='deconnexion'>
			</form>
			<div class='nav-wrapper light-blue darken-2'>
				<a href='#'' class='brand-logo'>
					<i class='icon-student-school'></i>
					$this->nom_enseignant $this->prenom_enseignant
				</a>
				<a href='#' data-activates='mobile-demo' class='button-collapse'>
					<i class='mdi-navigation-menu'></i>
				</a>
				<ul id='nav-mobile' class='right hide-on-med-and-down'>
					<li><a href='message.php'>Message</a></li>
					<li><a href='components.html'>Components</a></li>
					<li><a class='navbar-link' href='javascript:document.formDeDeconnexion.submit();'><span class='icon-off'></span></a></li>
				</ul>
				<ul class='side-nav' id='mobile-demo'>
					<li><a href='message.php'>Message</a></li>
					<li><a href='components.html'>Components</a></li>
					<li><a class='navbar-link' href='javascript:document.formDeDeconnexion.submit();'><span class='icon-off'></span></a></li>
				</ul>
			</div>
		</nav>";
	}
	
	public function afficheMesProjets()
	{
		$DAOtemporaire = new ProjetsDAO(MaBD::getInstance());
		$mesProjets = $DAOtemporaire->getAllMyProjects($this->login_enseignant);
		foreach ($mesProjets as $projet)
		{
			$projet->toTableRow();
		}
	}
	
	public function afficheMail()
	{
		echo "
				<form action='' method='post'>
							<h6>Destinataire</h6>
							
							<select name='no_groupe'>";
		$this->allMyGroupsToOptions();											
		echo				"</select>
							<input type='hidden' id='groupe' value='true' />

							<div class='input-field'>
								<label for='sujet'>Sujet</label> <input type='text' name='sujet' id='sujet' required>
							</div>
							<div class='input-field'>
								<label for='message'>Message</label>
								<textarea class='materialize-textarea' name='message' required></textarea>
							</div>
							<div class='input-field'>
								<div class='centre'>
									<button type='submit' name='envoi'class='btn light-blue darken-2'>
										<span class='mdi-communication-email'></span> Envoyer
									</button>
								</div>
							</div>
						</form>
				";
	}
	
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
	
	public function allMyGroupsToOptions()
	{
		$tab = $this->allMyGroups();
		foreach ($tab as $groupe)
		{
			$groupe->toOption();
		}
	}
}
?>