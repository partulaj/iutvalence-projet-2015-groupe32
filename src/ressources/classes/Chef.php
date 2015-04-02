<?php
class Chef extends Enseignant {
/**
* Fonction d'affichage de la barre de navigation
* Fonction qui permet l'affichage d'une barre de navigation responsive personnalisé
* @author Jérémie
* @version 1.4
*/
public function afficheNavBar($icone=null, $titre=null)
{
	if ($icone==null)
	{
		$icone="icon-chef";
	}
	if ($titre==null)
	{
		$titre=" $this->nom $this->prenom";
	}
	echo '
	<ul id="dropdown1" class="dropdown-content">
		<li><a href="enseignant.php">Accueil</a></li>
		<li><a href="chef.php">Interface Chef</a></li>
		<li><a href="projet.php">Gérer mes Projets</a></li>
		<li><a href="reunion.php">Réunion</a></li>
		<li><a class="modal-trigger" href="#newprojet">Nouveau Projet</a></li>
		<li><a href="message.php">Message</a></li>
		<li><a href="projet_avancer.php">Projet Avancé</a></li>
	</ul>
	<nav>
		<form name="formDeDeconnexion" method="post" action="index.php">
			<input type="hidden" name="deconnexion" value="deconnexion">
		</form>
		<div class="nav-wrapper light-blue">
			<a href="#"" class="brand-logo"><span class="',$icone,'"></span>',$titre,'</a>
			<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
			<ul class="right hide-on-med-and-down">
				<li>
					<a class="dropdown-button" href="#!" data-activates="dropdown1">
						Menu de Navigation<i class="mdi-navigation-arrow-drop-down right"></i>
					</a>
				</li>
				<li>
					<a class="navbar-link" href="javascript:document.formDeDeconnexion.submit();">
						<span class="icon-off"></span>
					</a>
				</li>
			</ul>
			<ul class="side-nav" id="mobile-demo">
				<li><a href="enseignant.php">Accueil</a></li>
				<li><a href="chef.php">Interface Chef</a></li>
				<li><a href="projet.php">Gérer mes Projets</a></li>
				<li><a href="reunion.php">Réunion</a></li>
				<li><a class="modal-trigger" href="#newprojet">Nouveau Projet</a></li>
				<li><a href="message.php">Message</a></li>
				<li><a href="projet_avancer.php">Projet</a></li>
				<li>
					<a class="navbar-link" href="javascript:document.formDeDeconnexion.submit();">
						<span class="icon-off"></span>
					</a>
				</li>
			</ul>
		</div>
	</nav>
	';
	$this->NewProjectModal();
}
/**
* Fonction qui envoie un mail au élève sans projet
* Fonction qui permet au chef des projet d'envoyer un mail à tous les étudiants sans projet.
* @param $subject : sujet du mail
* @param	$message : message du mail
* @author Jérémie
* @version 1.0
*/
public function mailToSansProjets($subject, $message)
{
	$DAOtemporaire = new UtilisateursDAO(MaBD::getInstance());
	$etudiants = $DAOtemporaire->getAll("WHERE role='etudiant' AND ISNULL(no_groupe)");
	foreach ($etudiants as $etudiant)
	{
		mail($etudiant->mail, $subject, $message);
	}
}
/**
* Fonction qui envoie un mail à tous les étudiants
*
* @param $subject : sujet du mail
* @param	$message : message du mail
* @author Jérémie
* @version 1.0
*/
public function mailToAll($subject, $message)
{
	$DAOtemporaire = new UtilisateursDAO(MaBD::getInstance());
	$etudiants = $DAOtemporaire->getAll();
	foreach ($etudiants as $etudiant)
	{
		mail($etudiant->mail, $subject, $message);
	}
}
/**
* Fonction qui affiche le formulaire d'envoie de mail
* Fonction qui permet d'afficher un formulaire d'envoie de message spéciale pour le chef
* @author Jérémie
* @version 1.0
*/
public function afficheMail()
{
	echo '
	<form action="" method="post" >
		<h6>Destinataire</h6>
		<div class="row">
			<div class="input-field col l4">
				<select name="no_groupe">';
					$this->allGroupsToOptions();
					echo'
				</select>
			</div>
			<div class="input-field col l8">
				<input type="checkbox" id="groupe" />
				<label for="groupe">Groupe</label>
				<input type="checkbox" id="tuteur" />
				<label for="tuteur">Tuteur</label>
				<input type="checkbox" id="chef" />
				<label for="chef">Responsable des projets</label>
			</div>
		</div>
		<div class="input-field">
			<label for="sujet">Sujet</label> <input type="text" name="sujet" id="sujet" required>
		</div>
		<div class="input-field">
			<label for="message">Message</label>
			<textarea class="materialize-textarea" name="message" required></textarea>
		</div>
		<div class="input-field">
			<div class="centre">
				<button type="submit" name="envoi"class="btn light-blue">
					<span class="mdi-communication-email"></span> Envoyer
				</button>
			</div>
		</div>
	</form>
	';
}
/**
* Fonction qui récupère tous les groupes et les affiche dans un select
* Fonction qui permet de récupérer tous les groupes et de les afficher dans une liste déroulante avec une option
* supplémentaire pour les étudiants sans projet
* @author Jérémie
* @version 0.4
*/
public function allGroupsToOptions($messageOption=true)
{
	$DAOtemporaire = new GroupesDAO(MaBD::getInstance());
	$tab=$DAOtemporaire->getAll();
	if ($messageOption==true)
	{
		echo '
		<option value="tous">Tous les étudiants</option>
		<option value="sans_projet">Etudiants Sans Projet</option>';
	}
	foreach ($tab as $groupe)
	{
		$groupe->toOption();
	}
}
/**
* Fonction d'affichage des étudiant
* Fonction qui affiche le tableau des étudiants que l'on passe en paramètre
* $array : un tableau d'étudiants
*
* @author Jérémie
* @version 1.2
*/
public function afficheTab($array)
{
	echo '
	<table class="responsive-table bordered hoverable">
		<tr><th>Login</th><th>Nom</th><th>Prenom</th><th>Groupe</th><th>Mail</th></tr>';
		foreach ( $array as $row )
		{
			$row->toTableRow (true);
		}
		echo '
	</table>';
}
/**
* Fonction qui affiche la page d'accueil du chef des projet
* @author Jérémie
* @version 1.0
*/
public function afficheInterfaceChef()
{
	$DAOtemporaire = new UtilisateursDAO(MaBD::getInstance());
	echo '
	<div class="card">
		<div class="row">
			<div class="col s12">
				<ul class="tabs">
					<li class="tab col s3"><a class="active amber-text" href="#all" onclick="refreshAll()">Tous les Etudiants</a></li>
					<li class="tab col s3"><a class="amber-text" href="#sp" onClick="refreshSP()">Sans Projet</a></li>
					<li class="tab col s3"><a class="amber-text" href="#sv" onClick="refreshSV()">Sans Voeux</a></li>
					<li class="tab col s3"><a class="amber-text" href="#se" onClick="refreshSE()">Supprimer étudiants</a></li>
				</ul>
			</div>
			<div id="all" class="col s12">';
				$this->afficheTab($DAOtemporaire->getAll("WHERE role='etudiant' ORDER BY no_groupe"));
				echo
				'
				<div class="hidden-element-block">
					<div class="center">
						<a class="waves-effect waves-grey btn-flat slide-link col s12">Changement de Groupe</a>
					</div>
					<div class="row hide">
						<div class="input-field col s5">
							<label for="switchEtu1">Etudiant 1</label>
							<input type="text" id="switchEtu1">
						</div>
						<div class="input-field col s2 centre">
							<button class="btn-floating btn-large waves-effect waves-light indigo" onClick="switchGroup()"><i class="mdi-av-loop"></i></button>
						</div>
						<div class="input-field col s5">
							<label for="switchEtu2">Etudiant 2</label>
							<input type="text" id="switchEtu2">
						</div>
					</div>
				</div>
				<div class="hidden-element-block">
					<div class="center">
						<a class="waves-effect waves-grey btn-flat slide-link col s12">Affecter un Etudiant</a>
					</div>
					<div class="row hide">
						<div class="input-field col s5">
							<label for="affecterEtu">Etudiant</label>
							<input type="text" id="affecterEtu">
						</div>
						<div class="input-field col s2 centre">
							<button class="btn-floating btn-large waves-effect waves-light indigo" onClick="affecterEtu()"><i class="mdi-action-trending-neutral"></i></button>
						</div>
						<div class="input-field col s5">
							<select onChange="groupe=this.value">
								<option value="" disabled selected>Choisir un Groupe</option>';
								$this->allGroupsToOptions(false);
								echo'
							</select>
						</div>
					</div>
				</div>
			</div>
			<div id="sp" class="col s12"></div>
			<div id="sv" class="col s12"></div>
			<div id="se" class="col s12">
				<ul id="list-etudiants" class="collection">
				</ul>
				<div class="centre">
					<button class="btn waves-effect waves-light red" onclick="delStudent()"><i class="mdi-action-delete"></i>Supprimer les étudiants</button>
				</div>
			</div>
		</div>
	</div>
	';
}
/**
* Fonction qui affiche la liste des projets avec export possible
* @author Jérémie
* @version 1.0
*/
public function afficheProjetsAvancer()
{
	$DAOtemporaire = new ProjetsDAO(MaBD::getInstance());
	$projets = $DAOtemporaire->getAll();
	echo
	'
	<div class="card hidden-element-block">
		<div class="row">
			<div class="col s12">
				<a class="btn-floating btn-large waves-effect waves-light red arrow-link slide-link">
					<i class="mdi-hardware-keyboard-arrow-down"></i>
				</a>
				<h5>Liste des Projets</h5>
				<p>Voici la liste des Projets</p>
			</div>
		</div>
		<table class="responsive-table bordered striped centered hide">
			<tr>
				<th>Intitulé Projet</th>
				<th>Modifier</th>
				<th>Interface de Gestion</th>
			</tr>';
			foreach ($projets as $projet)
			{
				$projet->toTableRowForTeachers();
			}
			echo'
		</table>
		<div class="centre" style="padding-top:10px;">
			<a href="export.php"><button class="btn btn-large waves-effect waves-light indigo centre"><span>Exporter la liste</span></button></a>
		</div>
	</div>
	';
}
}
