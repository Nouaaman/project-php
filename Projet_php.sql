-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : ven. 07 jan. 2022 à 10:07
-- Version du serveur : 5.7.34
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Projet_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `Answer`
--

CREATE TABLE `Answer` (
  `id` int(2) NOT NULL,
  `label` varchar(50) NOT NULL,
  `id_question` int(75) NOT NULL,
  `isValid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Answer`
--

INSERT INTO `Answer` (`id`, `label`, `id_question`, `isValid`) VALUES
(14, 'Autant en Emporte le Vent', 2, 1),
(16, 'Avengers : End Game', 2, 0),
(24, 'Rabat', 1, 1),
(25, 'Marakesh', 1, 0),
(28, 'Infinity war', 2, 0),
(33, 'Manu Macron', 8, 1),
(34, 'Zinedine Zidane', 8, 0),
(35, 'Superman', 9, 1),
(36, 'Goku', 9, 0),
(37, 'Tom Hanks', 10, 0),
(38, 'Jean Gabin', 10, 1),
(39, 'GOT', 11, 1),
(40, 'Vikings', 11, 0),
(41, 'Breaking Bad', 11, 0),
(42, 'Prison Break', 11, 0),
(44, 'France', 12, 0),
(45, 'USA', 12, 0),
(46, 'Chine', 12, 1),
(47, 'Italie', 12, 0),
(48, 'il voit rouge', 13, 0),
(49, 'Il ne sait pas nager', 13, 0),
(50, 'Il voit en noir et blanc', 13, 1),
(51, 'Mme Irma', 14, 0),
(52, 'Monsieur Parmentier', 14, 1),
(53, 'Un Belge', 14, 0),
(54, 'Une rose', 15, 0),
(55, 'Un sac plastique', 15, 1),
(56, 'Michelle', 16, 1),
(57, 'The Ball', 16, 0),
(58, 'A Game', 16, 0),
(59, 'Gandhi', 17, 0),
(60, 'Teresa', 17, 0),
(61, 'Simone Veil', 17, 1),
(62, 'Marron', 18, 1),
(63, 'Rouge sombre', 18, 0),
(64, 'Rouge clair', 18, 0),
(65, 'Rouge', 18, 0),
(66, 'Le chanteur de jazz', 19, 1),
(67, 'Hollywood revue of 1929', 19, 0),
(68, 'Broadway Melody', 19, 0),
(69, 'Les West et les East', 20, 0),
(70, 'Les Jets et les Sharks', 20, 1),
(71, 'Les Beats et les Tbirds', 20, 0),
(72, 'Oscar', 21, 0),
(73, 'Gaspard', 21, 0),
(74, 'Cesar', 21, 1),
(75, 'Jean Gabin', 22, 1),
(76, 'Lino Ventura', 22, 0),
(77, 'Belmondo', 22, 0),
(78, 'Delon', 22, 0),
(79, 'Ingrid Bergman', 23, 1),
(80, 'Lauren Bacall', 23, 0),
(81, 'Mary Astor', 23, 0),
(82, 'La Palme', 24, 1),
(83, 'Le Lion', 24, 0),
(84, 'Le Ourse', 24, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Question`
--

CREATE TABLE `Question` (
  `id` int(2) NOT NULL,
  `label` varchar(75) NOT NULL,
  `level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Question`
--

INSERT INTO `Question` (`id`, `label`, `level`) VALUES
(1, 'Quelle est la capitale du Maroc ?', 4),
(2, 'Quel est le plus gros succès ?', 3),
(8, 'Qui est le président de la France ?', 1),
(9, 'Qui est le plus fort ?', 6),
(10, 'Qui est le meilleur acteur ?', 1),
(11, 'Quelle est la meilleur série ?', 2),
(12, 'Quel pays a inventé les pâtes ?', 2),
(13, 'Quelle est la particularité du taureau ?', 3),
(14, 'Qui a importé la pomme de Terre en Europe ?', 4),
(15, 'Lequel de ces objets flotte ?', 1),
(16, 'Quel titre les Beatles ont-ils chantés ?', 3),
(17, 'Qui a permis l\'avortement ?', 1),
(18, 'Quelle est la couleur du sang ?', 5),
(19, 'Quel est le nom du premier vrai film musical ?', 6),
(20, 'Comment s\'appelle les deux bandes rivales dans « West Side Story »?', 5),
(21, 'En France, que peut recevoir un film ?', 1),
(22, 'De qui vient la célèbre réplique T\'as de beaux yeux tu sais ?', 3),
(23, 'Qui est la partenaire de Humphrey Bogart dans Casablanca ?', 4),
(24, 'Quelle récompense est attribuée au festival de Cannes ?', 2);

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `id` int(2) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `email` varchar(40) NOT NULL,
  `roles` varchar(10) NOT NULL DEFAULT 'user',
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `createdAt` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `User`
--

INSERT INTO `User` (`id`, `username`, `password`, `email`, `roles`, `firstName`, `lastName`, `createdAt`) VALUES
(9, 'AudHep', 'aqwzsx', 'audreyhepburn@gmail.com', 'admin', 'Audrey', 'Hepburn', '2021-12-14'),
(12, 'Gabin', 'azerty', 'gabin@gmail.com', 'user', 'Jean', 'Gabin', '2021-12-16'),
(13, 'Bebel', 'azerty', 'gamereceipteur@gmail.com', 'user', 'Belmondo', 'Jean-paul', '2021-12-20'),
(18, 'Spider-man', 'arai', 'parker@gmail.com', 'user', 'Peter', 'Parker', '2021-12-22'),
(19, 'AlexyCha', 'azerty', 'alexychalopin@gmail.com', 'admin', 'Alexy', 'Cha', '2022-01-05'),
(20, 'Nouaam', 'azerty', 'Nouaman@gmail.com', 'admin', 'Nouaaman', 'Roudane', '2022-01-05');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Answer`
--
ALTER TABLE `Answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question` (`id_question`);

--
-- Index pour la table `Question`
--
ALTER TABLE `Question`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Answer`
--
ALTER TABLE `Answer`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT pour la table `Question`
--
ALTER TABLE `Question`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Answer`
--
ALTER TABLE `Answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`id_question`) REFERENCES `Question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
