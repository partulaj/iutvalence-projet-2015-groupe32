<?php
class Utilisateur extends TableObject {
	static public $keyFieldsNames = array('login'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	const DEFAULT_CHEF = "chef1"; // a remplacer par le login du chef des projets

	/**
	 * Fonction qui envoie un mail à tous les étudiants s'un groupe
	 * Fonction qui permet d'envoyer un message à tous les étudiants d'un groupe
	 * @param $no_groupe : le numéro d'un groupe
	 * @param $subject : le sujet du message
	 * @param $message : le message
	 * @author Ihab, Jérémie
	 * @version 1.0
	 */
	public function mailToThisGroup($no_groupe, $subject, $message)
	{	
		$DAOtemporaire = new UtilisateursDAO(MaBD::getInstance());
		$etuGroupe = $DAOtemporaire->getAll("WHERE no_groupe = '$this->no_groupe'");
		foreach ($etuGroupe as $etudiant)
		{
			mail($etudiant->mail, $subject, $message);
		}
	}

	/**
	 * Fonction qui envoie un mail au tuteur d'un projet
	 * Fonction qui permet d'envoyer un message au tuteur d'un projet
	 * @param $no_projet : le numéro du projet
	 * @param $subject : le sujet du message
	 * @param $message : le message
	 * @author Jérémie
	 * @version 1.0
	 */
	public function mailToTuteur($no_projet, $subject, $message)
	{
		$DAOtemporaire = new ProjetsDAO(MaBD::getInstance());
		$DAOtemporaire2 = new UtilisateursDAO(MaBD::getInstance());
		$projet = $DAOtemporaire->getOne($no_projet);
		$enseignant = $DAOtemporaire2->getOne($projet->login);
		mail($enseignant->mail, $subject, $message);
	}

	/**
	 * Fonction qui envoie un mail au chef des projet tutorés
	 * Fonction qui permet d'envoyer un message au chef des projets tutorés
	 * @author Jérémie
	 * @version 1.0
	 */
	public function mailToChef($login, $subject, $message)
	{
		$DAOtemporaire = new UtilisateursDAO(MaBD::getInstance());
		$chef= $DAOtemporaire->getOne($login);
		mail($chef->mail, $subject, $message);
	}

	/**
	 * Fonction définie dans les classes héritière
	 */
	public function afficheAccueil(){}

	/**
	 * Fonction définie dans les classes héritière
	 */
	public function afficheNavBar(){}

	/**
	 * Fonction définie dans les classes héritière
	 */
	public function afficheMail(){}

	/**
	 * Fonction définie dans les classes héritière
	 */
	public function afficheProjets(){}

	/**
	 * Fonction définie dans les classes héritière
	 */
	public function afficheReunion(){} 

	/**
	 * Fonction pour savoir si l'utilisateur est un étudiant 
	 * @author Jérémie
	 * @version 0.2
	 */
	public function estEtudiant()
	{
		if ($this->role=="etudiant")
		{
			return true;
		}
		return false;
	}

	/**
	 * Fonction pour savoir si l'utilisateur est un enseignant 
	 * @author Jérémie
	 * @version 0.2
	 */	
	public function estEnseignant()
	{
		if ($this->role=="enseignant")
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Fonction pour savoir si l'utilisateur est un chef 
	 * @author Jérémie
	 * @version 0.2
	 */
	public function estChef()
	{
		if ($this->role=="chef")
		{
			return true;
		}
		return false;
	}

		/**
	 * Fonction qui permet d'afficher un étudiant dans une ligne d'un tableau
	 * Fonction qui permet d'afficher un étudiant sous forme d'une ligne d'un tableau. 
	 * Ligne avec 3 colonnes ou 4 (si $groupe=true): le nom de l'étudiant, le prénom de l'étudiant,
	 * un lien pour lui envoyer un mail et le numéro de groupe
	 * @author Jérémie
	 * @version 1.2
	 */
	public function toTableRow($groupe=false)
	{
		echo '
		<tr>
			<td>',$this->login,'</td>
			<td>',$this->nom,'</td>
			<td>',$this->prenom,'</td>';
			if ($groupe==true) 
			{
				echo '<td>',$this->no_groupe,'</td>';
			}
			echo '
			<td><a href="mailto:',$this->mail,'">Lui écrire</a></td>
		</tr>';
	}

	/**
	 * Fonction qui affiche une checkbox pour l'étudiant
	 * Fonction qui permet d'afficher une checkbox avec un id et comme valeur le login de l'étudiant ainsi que le 
	 * nom et prénom de celui-ci comme label.
	 * @author Jérémie
	 * @version 0.2
	 */
	public function toCheckBox($no_tache=null)
	{
		if ($no_tache==null) {
			echo '
			<input type="checkbox" id="',$this->login,'" value="',$this->login,'"/>
			<label for="',$this->login,'">',$this->nom,' ',$this->prenom,'</label><br/>';
		}
		else
		{
			$DAOtemporaire = new RealisesDAO(MaBD::getInstance());
			$search = array($no_tache,$this->login);
			$realise = $DAOtemporaire->getOne($search);
			if ($realise==null) 
			{
				echo '
				<input type="checkbox" id="',$this->login,$no_tache,'" value="',$this->login,'" ',$realise,'/>
				<label for="',$this->login,$no_tache,'">',$this->nom,' ',$this->prenom,'</label><br/>
				';
			}
			else
			{
				echo '  
				<input type="checkbox" id="',$this->login,$no_tache,'" value="',$this->login,'" checked="checked"/>
				<label for="',$this->login,$no_tache,'">',$this->nom,' ',$this->prenom,'</label><br/>
				';	
			}
		}
	}
}
?>