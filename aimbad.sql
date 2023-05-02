-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 02 Mai 2023 à 12:41
-- Version du serveur :  5.6.20-log
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `aimbad`
--

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`Id` int(10) unsigned NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Url` varchar(255) NOT NULL DEFAULT 'https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png',
  `Score` int(255) NOT NULL DEFAULT '0',
  `admin` int(255) NOT NULL DEFAULT '0',
  `Score_final` int(255) DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`Id`, `Username`, `Email`, `Password`, `Url`, `Score`, `admin`, `Score_final`) VALUES
(11, 'Guts', 'guts@berserk.orgsgf', '$2y$10$5Gsyc9blK26O.SB2e51k5OvxFRgTdPONqO5xT9KSLZ64JkpFj6DuW', 'https://avatars.githubusercontent.com/u/121417762?s=400&u=43b3cb43c12e7a45bad56ac9ad97ce0cf33bcd22&v=4', 38, 1, 139),
(18, ' ', 'admin@admin.comfds', '$2y$10$uwKu95JO9mKhWEOQyhhxgeDXqULTq3Rk807BbBIU7rGqLGfNI5ZLm', 'https://wallpaperaccess.com/full/3556942.jpg', 10, 0, 10),
(19, ' te', 'guts@berserk.orgeseeee', '$2y$10$BrenXXUBovwqoRMMSRKv8.aHgcrhsLY0pSvL.cJIjaqt/ot9OvjUW', 'https://wallpaperaccess.com/full/3556942.jpg', 0, 0, 0),
(20, ' ui', 'admin@admin.comfdskhu', '$2y$10$DsUaDx9f6GmFullQTxYO7eIMNgeuOqdisbAdg70ENZ1WpIBMVxiBm', 'https://wallpaperaccess.com/full/3556942.jpg', 0, 0, 0),
(21, ' uit', 'tonyshner@gmail.comtttttt', '$2y$10$.dkKYnZYkHJEklbQbDRn.OlVFcGni0xHmwX4mEucaa1.kWkLZqb66', 'https://wallpaperaccess.com/full/3556942.jpg', 0, 0, 0),
(22, '===', 'tonyshner@gmail.comtttfesesfesf', '$2y$10$b2wjHrc4nxQbRBCBbpInQeazIYYfCHCRSPT4m7PZQ9U2chcB8sxO2', 'https://wallpaperaccess.com/full/3556942.jpg', 0, 0, 0);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`Id`), ADD UNIQUE KEY `Email` (`Email`), ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
MODIFY `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
