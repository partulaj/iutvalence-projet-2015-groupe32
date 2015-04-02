-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  gigondas
-- Généré le :  Jeu 02 Avril 2015 à 17:51
-- Version du serveur :  5.1.73-log
-- Version de PHP :  5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `pjtuto`
--

-- --------------------------------------------------------

--
-- Structure de la table `Groupes`
--

CREATE TABLE IF NOT EXISTS `Groupes` (
  `no_groupe` int(11) NOT NULL AUTO_INCREMENT,
  `no_projet` int(11) NOT NULL,
  `plein` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`no_groupe`),
  KEY `no_projet` (`no_projet`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `Groupes`
--

INSERT INTO `Groupes` (`no_groupe`, `no_projet`, `plein`) VALUES
(1, 1, NULL),
(2, 2, NULL),
(3, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Projets`
--

CREATE TABLE IF NOT EXISTS `Projets` (
  `no_projet` int(11) NOT NULL AUTO_INCREMENT,
  `nom_projet` varchar(100) DEFAULT NULL,
  `nb_etu_min` int(11) NOT NULL,
  `nb_etu_max` int(11) NOT NULL,
  `contexte` text,
  `objectif` text,
  `contrainte` text,
  `details` text,
  `login` varchar(20) DEFAULT NULL,
  `affecter` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`no_projet`),
  KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `Projets`
--

INSERT INTO `Projets` (`no_projet`, `nom_projet`, `nb_etu_min`, `nb_etu_max`, `contexte`, `objectif`, `contrainte`, `details`, `login`, `affecter`) VALUES
(1, 'Démo n°1', 3, 3, 'Démonstration du projet', '- objectif 1\n- objectif 2', 'Il faut que ça marche', 'c''est important !!!', 'ens1', 0),
(2, 'Démo n°2', 3, 3, 'Démonstration du projet', '- recherche dichotomique sur l''annuaire de la NASA pour trouver Mr. Dennis Ritchie\n- créer une nouvelle interface pour le LaTeX', 'Ne pas faire de fautes d''orthographe dans le rapport de projet', 'La recherche dichotomique devra être fait en Visual Basic', 'ens1', 0);

-- --------------------------------------------------------

--
-- Structure de la table `Realises`
--

CREATE TABLE IF NOT EXISTS `Realises` (
  `no_tache` int(11) NOT NULL DEFAULT '0',
  `login` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`no_tache`,`login`),
  KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Taches`
--

CREATE TABLE IF NOT EXISTS `Taches` (
  `no_tache` int(11) NOT NULL AUTO_INCREMENT,
  `nom_tache` varchar(50) DEFAULT NULL,
  `etat_tache` varchar(50) DEFAULT NULL,
  `ordre_tache` int(11) DEFAULT NULL,
  `no_groupe` int(11) DEFAULT NULL,
  PRIMARY KEY (`no_tache`),
  KEY `no_groupe` (`no_groupe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE IF NOT EXISTS `Utilisateurs` (
  `login` varchar(20) NOT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `mail` varchar(150) DEFAULT NULL,
  `no_groupe` int(11) DEFAULT NULL,
  `ajac` tinyint(1) DEFAULT NULL,
  `classement` int(11) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`login`),
  UNIQUE KEY `classement` (`classement`),
  KEY `no_groupe` (`no_groupe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Utilisateurs`
--

INSERT INTO `Utilisateurs` (`login`, `nom`, `prenom`, `mail`, `no_groupe`, `ajac`, `classement`, `role`) VALUES
('chef1', 'Hashirama', 'Senju', '', NULL, NULL, NULL, 'chef'),
('chef2', 'Uchiha', 'Madara', '', NULL, NULL, NULL, 'chef'),
('ens1', 'Hatake', 'Kakashi', '', NULL, NULL, NULL, 'enseignant'),
('ens2', 'Yuhi', 'Kurenai', '', NULL, NULL, NULL, 'enseignant'),
('etu1', 'Uzumaki', 'Naruto', '', NULL, NULL, 1, 'etudiant'),
('etu2', 'Haruto', 'Sakura', '', NULL, NULL, 2, 'etudiant'),
('etu3', 'Uchiha', 'Sasuke', '', NULL, NULL, 3, 'etudiant'),
('etu4', 'Hyuga', 'Hinata', '', NULL, NULL, 4, 'etudiant'),
('etu5', 'Yamanaka', 'Ino', '', NULL, NULL, 5, 'etudiant'),
('etu6', 'Rock', 'Lee', '', NULL, NULL, 6, 'etudiant'),
('etu7', 'Hyuga', 'Neji', '', NULL, NULL, 7, 'etudiant'),
('etu8', 'Uchiha', 'Salada', '', NULL, NULL, 8, 'etudiant'),
('etu9', 'Uzumaki', 'Boruto', '', NULL, NULL, 9, 'etudiant'),
('partulaj', 'Partula', 'Jérémie', '', NULL, NULL, 10, 'etudiant');

-- --------------------------------------------------------

--
-- Structure de la table `Voeux`
--

CREATE TABLE IF NOT EXISTS `Voeux` (
  `no_projet` int(11) NOT NULL DEFAULT '0',
  `login` varchar(20) NOT NULL DEFAULT '',
  `date` date NOT NULL,
  `priorite` int(11) NOT NULL,
  PRIMARY KEY (`no_projet`,`login`),
  KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Voeux`
--

INSERT INTO `Voeux` (`no_projet`, `login`, `date`, `priorite`) VALUES
(1, 'etu1', '2015-04-01', 3),
(1, 'etu2', '2015-04-02', 3),
(1, 'etu3', '2015-04-02', 3),
(1, 'etu4', '2015-04-02', 3),
(2, 'etu4', '2015-04-02', 2),
(2, 'etu5', '2015-04-02', 2),
(2, 'etu6', '2015-04-02', 2),
(2, 'etu7', '2015-04-02', 3),
(2, 'etu8', '2015-04-02', 3);
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Groupes`
--
ALTER TABLE `Groupes`
  ADD CONSTRAINT `Groupes_ibfk_1` FOREIGN KEY (`no_projet`) REFERENCES `Projets` (`no_projet`);

--
-- Contraintes pour la table `Projets`
--
ALTER TABLE `Projets`
  ADD CONSTRAINT `Projets_ibfk_1` FOREIGN KEY (`login`) REFERENCES `Utilisateurs` (`login`);

--
-- Contraintes pour la table `Realises`
--
ALTER TABLE `Realises`
  ADD CONSTRAINT `Realises_ibfk_1` FOREIGN KEY (`no_tache`) REFERENCES `Taches` (`no_tache`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Realises_ibfk_2` FOREIGN KEY (`login`) REFERENCES `Utilisateurs` (`login`);

--
-- Contraintes pour la table `Taches`
--
ALTER TABLE `Taches`
  ADD CONSTRAINT `Taches_ibfk_1` FOREIGN KEY (`no_groupe`) REFERENCES `Groupes` (`no_groupe`);

--
-- Contraintes pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD CONSTRAINT `Utilisateurs_ibfk_1` FOREIGN KEY (`no_groupe`) REFERENCES `Groupes` (`no_groupe`);

--
-- Contraintes pour la table `Voeux`
--
ALTER TABLE `Voeux`
  ADD CONSTRAINT `Voeux_ibfk_1` FOREIGN KEY (`no_projet`) REFERENCES `Projets` (`no_projet`) ON DELETE CASCADE,
  ADD CONSTRAINT `Voeux_ibfk_2` FOREIGN KEY (`login`) REFERENCES `Utilisateurs` (`login`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
