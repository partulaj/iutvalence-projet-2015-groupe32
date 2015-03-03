<?php
class Chef extends Utilisateur {
	static public $keyFieldsNames = array('login_chef'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	/**
	 * Fonction d'affichage de la barre de navigation
	 * Fonction qui permet l'affichage d'une barre de navigation responsive (Bootstrap) avec le nom et le prénom du chef des projet ainsi que l'onglet actif
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
					<i class='icon-chef'></i>
					$this->nom_chef $this->prenom_chef
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
					<li><a href='message.php'>Message</span></a></li>
					<li><a href='components.html'>Components</a></li>
					<li><a class='navbar-link' href='javascript:document.formDeDeconnexion.submit();'><span class='icon-off'></span></a></li>
				</ul>
			</div>
		</nav>";
	}

	/**
	 * Fonction qui envoie un mail au élève sans projet
	 * Fonction qui permet au chef des projet d'envoyer un mail à tous les étudiants sans projet.
	 * @param 	$array : tableau des étudiants sans projet
	 * 			$subject : sujet du mail
	 * 			$message : message du mail
	 * @author Jérémie
	 * @version 1.0
	 */
	public function mailToSansProjets($array, $subject, $message)
	{
		foreach ($array as $etudiant)
		{
			mail($etudiant->mail_etudiant, $subject, $message);
		}
	}

}
?>