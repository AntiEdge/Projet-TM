-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 12 mai 2020 à 16:37
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `test`
--

-- --------------------------------------------------------

--
-- Structure de la table `localisation`
--

DROP TABLE IF EXISTS `localisation`;
CREATE TABLE IF NOT EXISTS `localisation` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL,
  `type` varchar(20) NOT NULL,
  `lat` float(10,6) DEFAULT NULL,
  `lng` float(10,6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `localisation`
--

INSERT INTO `localisation` (`id`, `name`, `address`, `type`, `lat`, `lng`) VALUES
(1, 'Jordan Quicken', '2 Impasse de la Consule, boite 209, Hainaut, Mons 7000', 'prive', 50.455341, 3.978761),
(2, 'CHU Ambroise pare', 'Boulevard John Fitzgerald Kennedy, Mons', 'hopital', 50.457561, 3.963070),
(3, 'Test', '10 rue de la biche, 7000 mons', 'prive', 50.454597, 3.955991),
(4, 'test', '10 rue du hautbois, 7000 mons', 'prive', 50.452621, 3.954157),
(5, 'jean-pierre', '10 rue rachot, 7000 mons', 'prive', 50.463867, 3.960290),
(6, 'Patrick', '10 rue Spira', 'prive', 50.451752, 3.955520);

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `membre_id` int(11) NOT NULL AUTO_INCREMENT,
  `membre_pseudo` varchar(255) NOT NULL,
  `membre_mdp` varchar(255) NOT NULL,
  `membre_email` varchar(255) NOT NULL,
  `membre_date_inscription` date NOT NULL,
  PRIMARY KEY (`membre_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`membre_id`, `membre_pseudo`, `membre_mdp`, `membre_email`, `membre_date_inscription`) VALUES
(1, 'Antoine', '202cb962ac59075b964b07152d234b70', 'antoine.bouilliez@hotmail.com', '2020-04-29'),
(2, 'Falcon', '202cb962ac59075b964b07152d234b70', 'falcon@gmail.com', '2020-04-29'),
(3, 'rEmOleDoZo', '6a5b4d7eaecee4db464012a81c177187', 'remi.wadin@gmail.com', '2020-05-01'),
(4, 'Alex', '202cb962ac59075b964b07152d234b70', 'alex@gmail.com', '2020-05-02');

-- --------------------------------------------------------

--
-- Structure de la table `relation`
--

DROP TABLE IF EXISTS `relation`;
CREATE TABLE IF NOT EXISTS `relation` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_demandeur` int(255) NOT NULL,
  `id_receveur` int(255) NOT NULL,
  `statut` int(255) NOT NULL,
  `id_bloqueur` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tchat`
--

DROP TABLE IF EXISTS `tchat`;
CREATE TABLE IF NOT EXISTS `tchat` (
  `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pseudo` int(255) DEFAULT NULL,
  `id_receveur` int(255) DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_message` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
