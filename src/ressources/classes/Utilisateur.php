<?php
class Utilisateur extends TableObject {
	
	const DEFAULT_CHEF = "chef1";
	
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
		$DAOtemporaire = new EtudiantsDAO(MaBD::getInstance());
		$etuGroupe = $DAOtemporaire->getAllWithThisProject($no_groupe);
		foreach ($etuGroupe as $etudiant)
		{
			mail($etudiant->mail_etudiant, $subject, $message);
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
		$DAOtemporaire2 = new EnseignantsDAO(MaBD::getInstance());
		$projet = $DAOtemporaire->getOne($no_projet);
		$enseignant = $DAOtemporaire2->getOne($projet->login_enseignant);
		mail($enseignant->mail_enseignant, $subject, $message);
	}

	/**
	 * Fonction qui envoie un mail au chef des projet tutorés
	 * Fonction qui permet d'envoyer un message au chef des projets tutorés
	 * @author Jérémie
	 * @version 1.0
	 */
	public function mailToChef($login_chef, $subject, $message)
	{
		$DAOtemporaire = new ChefsDAO(MaBD::getInstance());
		$chef= $DAOtemporaire->getOne($login_chef);
		mail($chef->mail_chef, $subject, $message);
	}

	/**
	 * Fonction définie dans les classe héritière
	 */
	public function afficheAccueil(){}

	/**
	 * Fonction définie dans les classe héritière
	 */
	public function afficheNavBar(){}

	/**
	 * Fonction définie dans les classe héritière
	 */
	public function afficheMail(){}

	/**
	 * Fonction pour savoir si l'utilisateur est un étudiant 
	 * @author Jérémie
	 * @version 0.2
	 */
	public function estEtudiant()
	{
		if (isset($this->login_etudiant))
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
		if (isset($this->login_enseignant))
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
		if (isset($this->login_chef))
		{
			return true;
		}
		return false;
	}
}
?>