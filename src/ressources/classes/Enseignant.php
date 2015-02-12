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
		<nav class='navbar navbar-inverse'>
			<div class='container-fluid'>
				<div class='navbar-header'>
					<a class='navbar-brand' href='#'><span class='icon-workshirt'></span>  $this->nom_enseignant $this->prenom_enseignant</a>
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
		</nav>
		";
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
	
	//////////////// A modifié ////////////////
	/*
	 * la requête doit être préparé
	 * les requêtes sont dans les classes DAO
	 */
	//Envoi un mail au groupe selectionné
	public function mailToGroupOfThisProject($groupe, $subject, $message)
	{	
		foreach ($row as $etudiant)
		{
			mail($etudiant->mail_etudiant, $subject, $message);
		}
	}
}
?>