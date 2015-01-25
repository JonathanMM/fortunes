-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Client :  mysql51-34.perso
-- Généré le :  Dim 25 Janvier 2015 à 18:26
-- Version du serveur :  5.1.73-2+squeeze+build1+1-log
-- Version de PHP :  5.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `noclemain`
--

-- --------------------------------------------------------

--
-- Structure de la table `fortunes_fortunes`
--

CREATE TABLE IF NOT EXISTS `fortunes_fortunes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(256) NOT NULL,
  `contenu` longtext NOT NULL,
  `date` int(11) NOT NULL,
  `proprio` tinyint(1) NOT NULL DEFAULT '0',
  `code` varchar(64) NOT NULL,
  `plus` int(11) unsigned NOT NULL DEFAULT '0',
  `moins` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

-- --------------------------------------------------------

--
-- Structure de la table `fortunes_membre`
--

CREATE TABLE IF NOT EXISTS `fortunes_membre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(256) NOT NULL,
  `mdp` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `fortunes_votes`
--

CREATE TABLE IF NOT EXISTS `fortunes_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_fortune` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  `type` int(1) NOT NULL COMMENT '1 : plus, 2 : moins',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
