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

ALTER TABLE `user`
 ADD PRIMARY KEY (`Id`), ADD UNIQUE KEY `Email` (`Email`), ADD UNIQUE KEY `Username` (`Username`);

ALTER TABLE `user`
MODIFY `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;

