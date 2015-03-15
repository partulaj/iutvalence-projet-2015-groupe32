CREATE TABLE Chefs
(
login_chef varchar(20) NOT NULL PRIMARY KEY,
nom_chef varchar(20),
prenom_chef varchar(20),
mdp_chef varchar(50),
mail_chef varchar(150)
)ENGINE=INNODB;

CREATE TABLE Enseignants
(
login_enseignant varchar(20) NOT NULL PRIMARY KEY,
nom_enseignant varchar(20),
prenom_enseignant varchar(20),
mdp_enseignant varchar(50),
mail_enseignant varchar(150)
)ENGINE=INNODB;

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
login_enseignant varchar(20),
affecter boolean DEFAULT false,
FOREIGN KEY (login_enseignant) REFERENCES Enseignants(login_enseignant)
)ENGINE=INNODB;

CREATE TABLE Groupes
(
no_groupe integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
no_projet integer NOT NULL,
plein boolean DEFAULT 0,
FOREIGN KEY (no_projet) REFERENCES Projets(no_projet)
)ENGINE=INNODB;

CREATE TABLE Etudiants
(
login_etudiant varchar(20) NOT NULL PRIMARY KEY,
nom_etudiant varchar(20),
prenom_etudiant varchar(20),
mdp_etudiant varchar(50),
mail_etudiant varchar(150),
no_groupe integer DEFAULT null,
nb_voeux integer DEFAULT 0,
ajac boolean,
classement integer UNIQUE,
FOREIGN KEY (no_groupe) REFERENCES Groupes(no_groupe)
)ENGINE=INNODB;

CREATE TABLE Voeux
(
no_projet integer,
login_etudiant varchar(20),
date date NOT NULL,
priorite integer NOT NULL,
PRIMARY KEY (no_projet,login_etudiant),
FOREIGN KEY (no_projet) REFERENCES Projets(no_projet) ON DELETE CASCADE,
FOREIGN KEY (login_etudiant) REFERENCES Etudiants(login_etudiant)
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
login_etudiant varchar(20),
PRIMARY KEY (no_tache,login_etudiant),
FOREIGN KEY (no_tache) REFERENCES Taches(no_tache) ON DELETE CASCADE,
FOREIGN KEY (login_etudiant) REFERENCES Etudiants(login_etudiant)
)ENGINE=INNODB;

INSERT INTO Enseignants VALUES ('ens1','Hatake','Kakashi','ens1','');
INSERT INTO Enseignants VALUES ('ens2','Uchiha','Madara','ens2','');
INSERT INTO Enseignants VALUES ('ens3','Sarutobi','Asuma','ens3','');
INSERT INTO Enseignants VALUES ('ens4','Senju','Tobirama','ens4','');
INSERT INTO Enseignants VALUES ('ens5','Yuhi','Kurenai','ens5','');

INSERT INTO Etudiants(login_etudiant,nom_etudiant,prenom_etudiant,mdp_etudiant,mail_etudiant,classement) VALUES ('etu1','Dragneel','Natsu','etu1','','14');
INSERT INTO Etudiants(login_etudiant,nom_etudiant,prenom_etudiant,mdp_etudiant,mail_etudiant,classement) VALUES ('etu2','Strauss','Elfman','etu2','','13');
INSERT INTO Etudiants(login_etudiant,nom_etudiant,prenom_etudiant,mdp_etudiant,mail_etudiant,classement) VALUES ('etu3','Strauss','Lisanna','etu3','','6');
INSERT INTO Etudiants(login_etudiant,nom_etudiant,prenom_etudiant,mdp_etudiant,mail_etudiant,classement) VALUES ('etu4','Strauss','Mirajane','etu4','','7');
INSERT INTO Etudiants(login_etudiant,nom_etudiant,prenom_etudiant,mdp_etudiant,mail_etudiant,classement) VALUES ('etu5','Heartfilia','Lucy','etu5','','8');
INSERT INTO Etudiants(login_etudiant,nom_etudiant,prenom_etudiant,mdp_etudiant,mail_etudiant,classement) VALUES ('etu6','Scarlet','Erza','etu6','','9');
INSERT INTO Etudiants(login_etudiant,nom_etudiant,prenom_etudiant,mdp_etudiant,mail_etudiant,classement) VALUES ('etu7','Alberona','Kana','etu7','','10');
INSERT INTO Etudiants(login_etudiant,nom_etudiant,prenom_etudiant,mdp_etudiant,mail_etudiant,classement) VALUES ('etu8','Vermillon','Maevis','etu8','','5');
INSERT INTO Etudiants(login_etudiant,nom_etudiant,prenom_etudiant,mdp_etudiant,mail_etudiant,classement) VALUES ('etu9','Fullbuster','Grey','etu9','','12');
INSERT INTO Etudiants(login_etudiant,nom_etudiant,prenom_etudiant,mdp_etudiant,mail_etudiant,classement) VALUES ('etu10','Lockser','Juvia','etu10','','11');

INSERT INTO Chefs VALUES ('chef1','Franz','Hopper','chef1','');