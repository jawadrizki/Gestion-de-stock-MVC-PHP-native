-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2016 at 10:07 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `app`
--

CREATE TABLE IF NOT EXISTS `app` (
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app`
--

INSERT INTO `app` (`password`) VALUES
('jawadrizki');

-- --------------------------------------------------------

--
-- Table structure for table `commandes`
--

CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `quantite` int(11) NOT NULL,
  `fournisseur` int(11) NOT NULL,
  `entite` int(11) NOT NULL,
  `date_expiration` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `commandes`
--

INSERT INTO `commandes` (`id`, `date`, `quantite`, `fournisseur`, `entite`, `date_expiration`) VALUES
(1, '2016-08-24', 1000, 1, 2, NULL),
(2, '2016-08-24', 20000, 2, 2, NULL),
(3, '2016-08-24', 120000, 1, 3, NULL),
(5, '2016-06-15', 480000, 2, 3, NULL),
(6, '2016-08-26', 500, 1, 5, '2016-08-26');

-- --------------------------------------------------------

--
-- Table structure for table `entites`
--

CREATE TABLE IF NOT EXISTS `entites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `entites`
--

INSERT INTO `entites` (`id`, `nom`) VALUES
(2, 'Feul'),
(3, 'Gazoil'),
(4, 'Essence');

-- --------------------------------------------------------

--
-- Table structure for table `fournisseurs`
--

CREATE TABLE IF NOT EXISTS `fournisseurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `nom`) VALUES
(1, 'PNA'),
(2, 'ATLAS SAHARA');

-- --------------------------------------------------------

--
-- Table structure for table `localstock`
--

CREATE TABLE IF NOT EXISTS `localstock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `entite` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `hauteur` float NOT NULL,
  `base_surface` float NOT NULL,
  `mv` float NOT NULL,
  `qte` float NOT NULL,
  `capacite` float NOT NULL,
  `stockmin` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `localstock`
--

INSERT INTO `localstock` (`id`, `type`, `entite`, `nom`, `hauteur`, `base_surface`, `mv`, `qte`, `capacite`, `stockmin`) VALUES
(6, 1, 2, 'BAC- A', 9.1, 730, 0.969, 3277.25, 6643, 1328.6),
(7, 1, 2, 'BAC- CENTRALE', 9.1, 730, 0.969, 80.4, 6643, 1328.6),
(8, 3, 4, 'Station Essence', 0, 0, 0, 1084, 3000, 0),
(9, 3, 3, 'ST_V', 0, 0, 0, 4900, 6000, 2000),
(10, 3, 3, 'ST_TL', 0, 0, 0, 7380, 10000, 4000),
(11, 1, 2, 'BAC-B', 9.1, 730, 0.969, 0, 6643, 1328.6);

-- --------------------------------------------------------

--
-- Table structure for table `mesures`
--

CREATE TABLE IF NOT EXISTS `mesures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mesure` double NOT NULL,
  `date` date NOT NULL,
  `localstock` int(11) NOT NULL,
  `consommation` float NOT NULL,
  `datec` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `mesures`
--

INSERT INTO `mesures` (`id`, `mesure`, `date`, `localstock`, `consommation`, `datec`) VALUES
(15, 4373.880921, '2016-08-22', 6, 527.959, '2016-08-21'),
(20, 3900, '2016-08-19', 10, 900, '2016-08-25'),
(21, 7800, '2016-08-22', 10, 3100, '2016-08-19'),
(23, 4157.92086, '2016-08-23', 6, 215.96, '2016-08-22'),
(24, 3954.1983, '2016-08-24', 6, 203.723, '2016-08-23'),
(25, 3824.04222, '2016-08-25', 6, 130.156, '2016-08-24'),
(26, 3277.24521, '2016-08-26', 6, 546.797, '2016-08-25'),
(28, 1084, '2016-08-29', 8, 0, '2016-08-29'),
(29, 700, '2016-08-24', 9, 800, '2016-08-29'),
(30, 300, '2016-08-25', 9, 400, '2016-08-24'),
(31, 4900, '2016-08-26', 9, 400, '2016-08-25'),
(32, 4700, '2016-08-24', 10, 3100, '2016-08-22'),
(33, 3000, '2016-08-25', 10, 1700, '2016-08-24'),
(34, 7380, '2016-08-26', 10, 620, '2016-08-25');

-- --------------------------------------------------------

--
-- Table structure for table `receptions`
--

CREATE TABLE IF NOT EXISTS `receptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` double NOT NULL,
  `date` date NOT NULL,
  `local` int(11) NOT NULL,
  `fournisseur` int(11) NOT NULL,
  `commande` int(11) NOT NULL,
  `deletable` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `receptions`
--

INSERT INTO `receptions` (`id`, `quantite`, `date`, `local`, `fournisseur`, `commande`, `deletable`) VALUES
(4, 228000, '2016-08-19', 10, 2, 5, 1),
(6, 7000, '2016-08-22', 10, 2, 5, 1),
(7, 5000, '2016-08-26', 9, 2, 5, 1),
(8, 5000, '2016-08-26', 10, 2, 5, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
