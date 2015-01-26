<?php
class Chef extends TableObject {
	static public $keyFieldsNames = array('login_chef'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	//Fonction qui affiche la barre de navigation du chef des projet
	public function afficheNavBar()
	{
		echo "<div class='row'>
				<div class='navbar navbar-inverse' role='navigation'>
					<div class='navbar-header'>
						<a class='navbar-brand' href='#'><span class='icon-chef'></span> $this->nom_chef $this->prenom_chef</a>
					</div>
					<div class='collapse navbar-collapse'>
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
							<li class='btn-danger'>
								<a href='javascript:document.formDeDeconnexion.submit();' >
									<span class='glyphicon glyphicon-off'></span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>";
	}
	
	//Fonction d'envoi de mail aux étudiants sans projet
	public function mailToSansProjets($array, $subject, $message)
	{
		foreach ($array as $etudiant)
		{
			mail($etudiant->mail_etudiant, $subject, $message);
		}
	}
	
}
?>