-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 28 Février 2020 à 11:55
-- Version du serveur :  10.1.9-MariaDB
-- Version de PHP :  5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `gestionvoiture`;
USE `gestionvoiture`;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gestionvoiture`
--

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `personne`
--

INSERT INTO `personne` (`id`, `nom`, `prenom`, `adresse`) VALUES
(1, 'RASOA   ', 'Mahery   ', 'Lot123 kkkk'),
(5, 'SAMILAVA ', 'Trou fdhdf ', 'lot trrr'),
(8, 'RABEAZ', 'Zanaka', 'Lot 78 ter x'),
(9, 'RASAOAZANANY   ', 'ZOKY dbe ', 'lot rar rtrt'),
(10, 'RGASIPKILOTE ', 'Harena ', 'Lot 45 67'),
(11, 'RASOLOJAONA', 'Andry', '123'),
(12, 'RASAMANIBAVY', 'Laity', 'lot 78 '),
(14, 'RASOARIJAONA ', 'Hahaha ', 'Lot 25 Ter Bemasoandro'),
(15, 'RASOA', 'ZANANY', '125'),
(16, 'RAZAKZ', 'Bozna', 'lot sdsgsd'),
(17, 'RASAKAMANGA ', 'Douzy', 'Lot 3fgd'),
(18, 'TEX', 'As', '89');

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `id` int(11) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL,
  `marque` varchar(20) NOT NULL,
  `idPers` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `voiture`
--

INSERT INTO `voiture` (`id`, `numero`, `type`, `marque`, `idPers`) VALUES
(1, '3744TAE', 'Peugeot', '405', 1),
(3, '7245TYZ', 'VolsWagen', 'Toareg', 8),
(4, '4785TGF', 'RASAAF', 'Allemend', 1),
(5, '4523TGD', 'RRRRRR', 'PPPPPP', 5),
(6, '1235DFG', 'PPPPPP', 'VVVVVV', 5),
(7, '1239TGH', 'AAAAAAAAA', 'bBBBBBBBBB', 8),
(8, '5412RXD', 'GGGGGGGG', 'pppppppppp', 5),
(9, '1213TGH', 'Peugeot', 'naganaga', 1),
(10, '2512TDF', '405', 'Peugeot', 8),
(11, '1230TYR', 'R25', 'Reunaul', 10),
(12, '1236THG', 'R12', 'Reunault', 11);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPers` (`idPers`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD CONSTRAINT `voiture_ibfk_1` FOREIGN KEY (`idPers`) REFERENCES `personne` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
