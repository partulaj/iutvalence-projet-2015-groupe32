<?php
class Chef extends TableObject {
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
		<nav class='navbar navbar-inverse'>
			<div class='container-fluid'>
				<div class='navbar-header'>
					<a class='navbar-brand' href='#'><span class='icon-chef'></span> $this->nom_chef $this->prenom_chef</a>
				</div>
				<ul class='nav navbar-nav'>
					<li class='active'>
						<a href='#'><span class='glyphicon glyphicon-home'></span> Accueil</a>
					</li>
					<li>
						<a href='#'><span class='glyphicon glyphicon-envelope'></span> Message</a>
					</li>
				</ul>
				<ul class='nav navbar-nav navbar-right'>
					<form name='formDeDeconnexion' method='post' action='index.php'>
						<input type='hidden' name='deconnexion' value='deconnexion'>
					</form>
					<li class='btn-danger'><a href='javascript:document.formDeDeconnexion.submit();' ><span class='glyphicon glyphicon-off'></span></a></li>
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