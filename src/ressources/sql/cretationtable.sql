CREATE TABLE Chefs
(
login_chef varchar(20) NOT NULL PRIMARY KEY,
nom_chef varchar(20),
prenom_chef varchar(20),
mdp_chef varchar(50),
mail_chef varchar(150)
);

CREATE TABLE Groupes
(
no_groupe integer NOT NULL PRIMARY KEY
);

CREATE TABLE Etudiants
(
login_etudiant varchar(20) NOT NULL PRIMARY KEY,
nom_etudiant varchar(20),
prenom_etudiant varchar(20),
mdp_etudiant varchar(50),
mail_etudiant varchar(150),
no_groupe integer,
nb_voeux integer DEFAULT 0,
FOREIGN KEY Etudiants(no_groupe) REFERENCES Groupes(no_groupe)
);

CREATE TABLE Enseignants
(
login_enseignant varchar(20) NOT NULL PRIMARY KEY,
nom_enseignant varchar(20),
prenom_enseignant varchar(20),
mdp_enseignant varchar(50),
mail_enseignant varchar(150)
);


CREATE TABLE Projets
(
no_projet serial NOT NULL PRIMARY KEY,
nom_projet varchar(50),
nb_etu_min integer NOT NULL,
nb_etu_max integer NOT NULL,
contexte text,
objectif text,
contrainte text,
details text,
login_enseignant varchar(20),
no_groupe integer,
FOREIGN KEY Projets(login_enseignant) REFERENCES Enseignants (login_enseignant),
FOREIGN KEY Projets2(no_groupe) REFERENCES Groupes (no_groupe)
);


CREATE TABLE Voeux
(
no_projet serial,
login_etudiant varchar(20),
date date NOT NULL,
priorité integer NOT NULL,
FOREIGN KEY Voeux(no_projet) REFERENCES Projets (no_projet),
FOREIGN KEY Voeux2(login_etudiant) REFERENCES Etudiants (login_etudiant),
PRIMARY KEY (no_projet,login_etudiant)
);


CREATE TABLE Taches
(
no_tache integer NOT NULL PRIMARY KEY,
nom_tache varchar(50),
avancement varchar(20),
no_projet serial,
login_etudiant varchar(20),
FOREIGN KEY Taches(no_projet) REFERENCES Projets (no_projet),
FOREIGN KEY Taches2(login_etudiant) REFERENCES Etudiants(login_etudiant)
);