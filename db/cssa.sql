-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Client: localhost:3306
-- Généré le: Ven 08 Janvier 2016 à 18:34
-- Version du serveur: 10.0.23-MariaDB
-- Version de PHP: 5.4.31

USE cssa;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `aefsumca_aefsum`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `ArticleID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL COMMENT 'Auteur initial',
  `Title` varchar(255) NOT NULL,
  `Lead` varchar(255) NOT NULL,
  `Introduction` varchar(255) NOT NULL,
  `Content` mediumtext NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ArticleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`ArticleID`, `UserID`, `Title`, `Lead`, `Introduction`, `Content`, `Image`, `Creation`) VALUES
(1, 1, 'Une nouvelle', 'Introduction de la nouvelle', 'Salut tout le monde !&nbsp;\nbienvenueausitewebdel''AEFSUM!\n&nbsp;', '<p>Salut tout le monde !&nbsp;</p>\n<p>bienvenueausitewebdel''AEFSUM!</p>\n<p>&nbsp;</p>', NULL, '2014-06-03 22:35:27');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `ContactID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `Message` mediumtext NOT NULL,
  `Sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IP` varchar(48) NOT NULL,
  `New` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ContactID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `contact`
--

INSERT INTO `contact` (`ContactID`, `Name`, `Email`, `Subject`, `Message`, `Sent`, `IP`, `New`) VALUES
(2, 'Yann Landry', 'yann.landry.94@gmail.com', 'Sujet du message', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a turpis at neque semper dignissim. Donec placerat, dolor eu consequat convallis, mi leo lobortis purus, et viverra justo sem eu diam. Quisque et elit commodo tortor placerat pellentesque. Nulla quis lorem in ipsum tincidunt molestie vitae ut sem. Aenean velit arcu, porttitor varius tempus ut, rhoncus eget lorem. Aliquam erat volutpat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.\n\nUt venenatis condimentum laoreet. Phasellus fermentum odio in est eleifend vehicula. Cras tincidunt sem sit amet laoreet laoreet. Mauris ut nisl massa. Cras eget nisi a libero varius ultrices ut ac risus. Sed et lacus eget nisl faucibus blandit id eget turpis. Aenean vitae adipiscing nisi, ut facilisis turpis. Donec ligula purus, condimentum eu venenatis et, aliquam in sapien. Nullam vel felis ut sapien accumsan laoreet et at orci.', '2014-06-03 22:49:17', '142.166.175.216', 0);

-- --------------------------------------------------------

--
-- Structure de la table `menu_items`
--

CREATE TABLE IF NOT EXISTS `menu_items` (
  `MenuItemID` int(11) NOT NULL AUTO_INCREMENT,
  `Position` int(11) NOT NULL DEFAULT '0',
  `Text` varchar(32) NOT NULL,
  `Link` varchar(255) NOT NULL,
  PRIMARY KEY (`MenuItemID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `menu_items`
--

INSERT INTO `menu_items` (`MenuItemID`, `Position`, `Text`, `Link`) VALUES
(1, 0, 'Nouvelles', '/nouvelles'),
(2, 2, 'Contact', '/contact'),
(3, 1, 'Événements', '/evenements'),
(4, 3, 'Une page', '/une/page');

-- --------------------------------------------------------

--
-- Structure de la table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `PageID` int(11) NOT NULL AUTO_INCREMENT,
  `Slug` varchar(255) DEFAULT NULL,
  `Title` varchar(255) NOT NULL,
  `Lead` varchar(255) NOT NULL,
  `Content` mediumtext NOT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PageID`),
  UNIQUE KEY `PageSlug` (`Slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `pages`
--

INSERT INTO `pages` (`PageID`, `Slug`, `Title`, `Lead`, `Content`, `LastUpdate`) VALUES
(1, 'une/page', 'Une page', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a turpis at neque semper dignissim. Donec placerat, dolor eu consequat convallis, mi leo lobortis purus, et viverra justo sem eu diam. Quisque et elit commodo tortor placerat pellentesque. Nulla quis lorem in ipsum tincidunt molestie vitae ut sem. Aenean velit arcu, porttitor varius tempus ut, rhoncus eget lorem. Aliquam erat volutpat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>\n<p>Ut venenatis condimentum laoreet. Phasellus fermentum odio in est eleifend vehicula. Cras tincidunt sem sit amet laoreet laoreet. Mauris ut nisl massa. Cras eget nisi a libero varius ultrices ut ac risus. Sed et lacus eget nisl faucibus blandit id eget turpis. Aenean vitae adipiscing nisi, ut facilisis turpis. Donec ligula purus, condimentum eu venenatis et, aliquam in sapien. Nullam vel felis ut sapien accumsan laoreet et at orci.</p>', '2014-06-03 22:43:37');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(16) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `PasswordPreSalt` varchar(32) NOT NULL,
  `PasswordPostSalt` varchar(32) NOT NULL,
  `UsualName` varchar(255) NOT NULL,
  `IsAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `Creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `PasswordPreSalt`, `PasswordPostSalt`, `UsualName`, `IsAdmin`, `Creation`) VALUES
(1, 'admin', '38319d575125d0930608b68ed7951eb3a29f1a1b09976407d61c4aede06133c12f7283c616877c833f09cd30732b8f90bf1dabd6ecfb57d091e1417171a89fb0', 'QLr{x_J@,%_0ep1]', '~s{[3^d6Pg3uYcPX4f\\CrlL\\', 'Yann Landry', 1, '2013-11-14 01:56:05');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
