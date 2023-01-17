-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 09, 2021 at 06:20 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projet`
--

-- --------------------------------------------------------

--
-- Table structure for table `argent`
--

DROP TABLE IF EXISTS `argent`;
CREATE TABLE IF NOT EXISTS `argent` (
  `argent` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `argent`
--

INSERT INTO `argent` (`argent`) VALUES
(1000);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Titre` varchar(255) NOT NULL,
  `Lieu` varchar(255) NOT NULL,
  `datedebut` date NOT NULL DEFAULT '2021-05-08',
  `datefin` date NOT NULL DEFAULT '2021-05-09',
  `Jeux` varchar(255) NOT NULL,
  `Descriptio` varchar(255) NOT NULL,
  `prix` varchar(255) NOT NULL,
  `nbr_participants` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`ID`, `Titre`, `Lieu`, `datedebut`, `datefin`, `Jeux`, `Descriptio`, `prix`, `nbr_participants`) VALUES
(40, 'Lan de test', 'CY211', '2021-06-16', '2021-06-17', 'LoL, Smash ', 'Tournoi ouvert Ã  tous.', 'aucun', 0),
(42, 'swagg de pou\'lan', 'CY211', '2021-06-18', '2021-06-19', 'Overwatch, Dead by Dayliight', 'dead by daylight n\'est pas compÃ©titf c\'est juste histoire de s\'amuser.', 'Du respect.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inscriptionsevents`
--

DROP TABLE IF EXISTS `inscriptionsevents`;
CREATE TABLE IF NOT EXISTS `inscriptionsevents` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `Eventitre` varchar(255) NOT NULL,
  `Pseudojoueur` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inscriptionsevents`
--

INSERT INTO `inscriptionsevents` (`id`, `Eventitre`, `Pseudojoueur`) VALUES
(34, 'e', 'Massdey'),
(33, 'EVENTEST', 'Massdey');

-- --------------------------------------------------------

--
-- Table structure for table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `descriptio` varchar(255) NOT NULL,
  `prix` int(11) NOT NULL,
  `nbrachats` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`id`, `titre`, `descriptio`, `prix`, `nbrachats`, `stock`) VALUES
(1, 'Amogus socks', 'Ceci est une chaussette en ref au jeu amogus.', 100, 8, 90),
(2, 'Casquette', 'Une casquette brodÃ©e CYGames', 20, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `Question` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `pseudo`, `Question`) VALUES
(40, 'Massdey', 'Comment ce site peut-il Ãªtre aussi qualitatif ?');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Prenom` varchar(255) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `roleutilisateur` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Sexe` varchar(255) NOT NULL,
  `DDN` date NOT NULL DEFAULT '2002-07-29',
  `Profession` varchar(255) NOT NULL,
  `ville_resid` varchar(255) NOT NULL,
  `adresse_comp` varchar(255) NOT NULL,
  `pfp` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=1862 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `Prenom`, `Nom`, `roleutilisateur`, `pseudo`, `email`, `password`, `Sexe`, `DDN`, `Profession`, `ville_resid`, `adresse_comp`, `pfp`) VALUES
(1854, 'Nino', 'Hamel', 'Admin', 'Filou', 'filou@gmail.com', '$2y$12$Qwr6ErT77DXSFwMXNiGoEu7XKcbOBqgXT8jpNb9IAHCg5rqustqwq', 'H', '2001-08-07', 'etudiant', 'cergy', 'cergy', ''),
(1855, 'Maxime', 'BACQ', 'Admin', 'Massdey', 'maxhd95@gmail.com', '$2y$12$pCc5D.HVJvaMW41d1sXVHOb9XrlUJkL6sPvwA8ahzjgNVHQ0urY5W', 'H', '2021-05-13', 'etudiant', 'azerzaer', 'zaer', '1855.jpg'),
(1861, 'Antone', 'BOGRAT', 'Admin', 'Jaroda ', 'jaroda@gmail.com', '$2y$12$1xtdGJ6CJOrPptaP5oxSn.OQMJ83r7jbDrTGarCqyDUw4pk9ZqZoO', 'H', '2002-03-05', 'etudiant', 'Villeparisis', '25 avenue du parc', 'default.png'),
(1860, 'ADMIN', 'ADMIN', 'Admin', 'ADMIN', 'admin@gmail.com', '$2y$12$uPRIBhdLAczPNPDTHBDOCufjDSljpfvqh0FcJq21og6cgg2NrEHMS', 'H', '2002-07-29', 'etudiant', 'ADMIN', '3 rue des ADMINS', 'default.png');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
