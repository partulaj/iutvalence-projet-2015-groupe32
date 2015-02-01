<?php
class Etudiant extends TableObject {
	static public $keyFieldsNames = array('login_etudiant'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	//Fonction d'affichage de la barre de navigation
	public function afficheNavBar()
	{
		echo "
		<nav class='navbar navbar-inverse'>
			<div class='container-fluid'>
				<div class='navbar-header'>
					<a class='navbar-brand' href='#'><span class='icon-student-school'></span>  $this->nom_etudiant $this->prenom_etudiant</a>
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

	//Méthode qui permet de savoir si l'étudiant à un voeux plus prioritaire que celui passé en paramètre
	/*
	 * Renvoie : true si l'etudiant à un voeux plus prioritaire
	 *		     false si ce n'est pas le cas  
	 */
	public function aUnMeilleurVoeu($num)
	{
		$DAOtemporaire = new VoeuxDAO(MaBD::getInstance());
		$voeux = $DAOtemporaire->getAllVoeuEtudiant($this->login);
		$voeu = $DAOtemporaire->getOne(array($num,$this->login));
		foreach ($voeux as $voeuAComparer)
		{
			if ($voeuAComparer->priorité>$voeu->priorité)
			{
				return true;
			}
		}
		return false;
	}
	
	//Méthode qui affiche un etudiant sous forme de ligne d'un tableau
	public function afficheEtudiantRow()
	{
		echo '<tr><td>',$this->nom_etudiant,'</td><td>',$this->prenom_etudiant,'</td><td><a href="mailto:',$this->mail_etudiant,'">Lui écrire</a></td></tr>';
	}

	//Utilité à discuter
	/*
	public function afficheMesEtudiants()
	{
		echo '<tr><td>',$this->nom_etudiant,'</td><td>',$this->prenom_etudiant,'</td><td>';
	}*/	
}
?>