<?php
class Enseignant extends TableObject {
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
					<li><a href='sass.html'>Sass</a></li>
					<li><a href='components.html'>Components</a></li>
					<li><a class='navbar-link' href='javascript:document.formDeDeconnexion.submit();'><span class='icon-off'></span></a></li>
				</ul>
				<ul class='side-nav' id='mobile-demo'>
					<li><a href='sass.html'>Sass</span></a></li>
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
	
	/**
	 * Fonction qui envoie un mail à tous les étudiants s'un groupe
	 * Fonction qui permet d'envoyer un message à tous les étudiants d'un groupe
	 * @param $no_groupe : le numéro d'un groupe
	 * @param $subject : le sujet du message
	 * @param $message : le message
	 * @author Ihab, Jérémie
	 */
	public function mailToThisGroup($no_groupe, $subject, $message)
	{	
		$DAOtemporaire = new EtudiantsDAO(MaBD::getInstance());
		$etuGroupe = $DAOtemporaire->getAllWithThisProject($no_groupe);
		foreach ($etuGroupe as $etudiant)
		{
			mail($etudiant->mail_etudiant, $subject, $message);
		}
	}
}
?>