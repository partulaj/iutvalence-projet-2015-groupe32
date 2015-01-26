<?php
class Etudiant extends TableObject {
	static public $keyFieldsNames = array('login_etudiant'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	//Fonction qui affiche le nom et prénom
	public function afficheNavBar()
	{
		echo "		<div class='row'>
						<div class='navbar navbar-inverse' role='navigation'>
							<div class='navbar-header'>
								<a class='navbar-brand' href='#'><span class='icon-student-school'></span>  $this->nom_etudiant $this->prenom_etudiant</a>
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
								<li class='btn-danger'><a href='javascript:document.formDeDeconnexion.submit();' ><span class='glyphicon glyphicon-off'></span></a></li>
								</ul>
							</div>
						</div>
					</div>";
	}


	//Méthode qui affiche un etudiant sous forme de ligne
	public function afficheEtudiantRow()
	{
		echo '<tr><td>',$this->nom_etudiant,'</td><td>',$this->prenom_etudiant,'</td><td><a href="mailto:',$this->mail_etudiant,'">Lui écrire</a></td></tr>';
	}

	///////////////// Documentation à ajouté /////////////////
	public function afficheMesEtudiants()
	{
		echo '<tr><td>',$this->nom_etudiant,'</td><td>',$this->prenom_etudiant,'</td><td>';
	}
}
?>