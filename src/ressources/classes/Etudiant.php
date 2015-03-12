<?php
class Etudiant extends TableObject {
	static public $keyFieldsNames = array('login_etudiant'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	


	/**
	 * Fonction d'affichage de la barre de navigation
	 * Fonction qui permet l'affichage d'une barre de navigation responsive (Bootstrap) avec le nom et le prénom de l'étudiant ainsi que l'onglet actif
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
					<span class='icon-student-school'></span>
					$this->nom_etudiant $this->prenom_etudiant
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

	/**
	 * Fonction qui permet de voir si l'étudiant à un voeux avec une priorité plus importante
	 * Fonction qui regarde parmi tous les voeux de l'étudiant si celui-ci à un voeu avec une priorité plus importante que celui pour le projet dont le numéro est passé en paramètre
	 * $num = un numéro de projet
	 * @author Jérémie
	 * @version 1.2
	 */
	public function aUnMeilleurVoeu($num)
	{
		$DAOtemporaire = new VoeuxDAO(MaBD::getInstance());
		$voeux = $DAOtemporaire->getAllVoeuEtudiant($this->login_etudiant);
		$voeu = $DAOtemporaire->getOne(array($num,$this->login_etudiant));
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
	 * Fonction qui permet d'afficher un étudiant dans une ligne d'un tableua
	 * Fonction qui permet d'afficher un étudiant sous forme d'une ligne d'un tableau. Ligne avec 3 colonnes : le nom de l'étudiant, le prénom de l'étudiant, un lien pour lui envoyer un mail
	 * @author Jérémie
	 * @version 1.0
	 */
	public function toTableRow()
	{
		echo '<tr><td>',$this->nom_etudiant,'</td><td>',$this->prenom_etudiant,'</td><td><a href="mailto:',$this->mail_etudiant,'">Lui écrire</a></td></tr>';
	}
	
	/**
	 * 
	 */
	public function toListElement()
	{
		echo "<li>$this->nom_etudiant $this->prenom_etudiant</li>";
	}

}
?>