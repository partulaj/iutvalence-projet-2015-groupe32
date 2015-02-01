<?php
class Enseignant extends TableObject {
	static public $keyFieldsNames = array('login_enseignant'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	//Fonction qui affiche le nom et prénom
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
	
	
	//Fonction qui affiche le bouton de déconnexion
	public function afficheDeconnexionButton()
	{
		echo "<form method='post' action='index.php'><button type='submit' name='deconnexion' class='btn btn-danger'><span class='glyphicon glyphicon-off'></span> </a></form>";
	}
	
	//////////////// A modifié ////////////////
	/*
	 * la requête doit être préparé
	 * les requêtes sont dans les classes DAO
	 */
	//Envoi un mail au groupe selectionné
	public function mailToGroupOfThisProject($groupe, $subject, $message)
	{	
		$res=array();
		$stmt = $this->pdo->query("SELECT no_etudiant,mail_etudiant FROM $etudiant WHERE $etudiant->no_groupe = $groupe->no_groupe");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
		{
			$res[] = new $this->class ($row);
		}
		return $res;
		foreach ($row as $etudiant)
		{
			mail($etudiant->mail_etudiant, $subject, $message);
		}
	}
}
?>