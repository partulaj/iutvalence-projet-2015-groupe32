CREATE TABLE Projets
(
no_projet integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
nom_projet varchar(100),
nb_etu_min integer NOT NULL,
nb_etu_max integer NOT NULL,
contexte text,
objectif text,
contrainte text,
details text,
login varchar(20),
affecter boolean DEFAULT false
)ENGINE=INNODB;

CREATE TABLE Groupes
(
no_groupe integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
no_projet integer NOT NULL,
plein boolean DEFAULT 0,
FOREIGN KEY (no_projet) REFERENCES Projets(no_projet)
)ENGINE=INNODB;

CREATE TABLE Utilisateurs
(
login varchar(20) NOT NULL PRIMARY KEY,
nom varchar(20),
prenom varchar(20),
mdp varchar(50),
mail varchar(150),
no_groupe integer DEFAULT null,
nb_voeux integer DEFAULT 0,
ajac boolean,
classement integer UNIQUE,
role varchar(20),
FOREIGN KEY (no_groupe) REFERENCES Groupes(no_groupe)
)ENGINE=INNODB;

CREATE TABLE Voeux
(
no_projet integer,
login varchar(20),
date date NOT NULL,
priorite integer NOT NULL,
PRIMARY KEY (no_projet,login),
FOREIGN KEY (no_projet) REFERENCES Projets(no_projet) ON DELETE CASCADE,
FOREIGN KEY (login) REFERENCES Utilisateurs(login)
)ENGINE=INNODB;

CREATE TABLE Taches
(
no_tache integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
nom_tache varchar(50),
etat_tache varchar(50),
ordre_tache integer,
no_groupe integer,
FOREIGN KEY (no_groupe) REFERENCES Groupes(no_groupe)
)ENGINE=INNODB;

CREATE TABLE Realises
(
no_tache integer,
login varchar(20),
PRIMARY KEY (no_tache,login),
FOREIGN KEY (no_tache) REFERENCES Taches(no_tache) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN KEY (login) REFERENCES Utilisateurs(login)
)ENGINE=INNODB;

ALTER TABLE Projets
ADD FOREIGN KEY (login)
REFERENCES Utilisateurs(login)