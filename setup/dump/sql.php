<?php
$tables[] = 'CREATE TABLE IF NOT EXISTS `#_attend` (
  `ID` varchar(50) NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `thread` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_boards` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `desc` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_changelog` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `by` int(10) unsigned NOT NULL,
  `related` int(10) unsigned NOT NULL,
  `value` varchar(140) COLLATE latin1_general_ci NOT NULL,
  `key` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `visible` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_comments` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `by` int(10) unsigned NOT NULL,
  `text` text COLLATE latin1_general_ci NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `cat_id` enum(\'picture\',\'clog\') COLLATE latin1_general_ci NOT NULL,
  `cat_item` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_fileCache` (
  `key` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  `size` int(10) unsigned NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_gallery` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `desc` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `by` int(10) unsigned NOT NULL,
  `cover` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_gallery_pics` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `added` int(10) unsigned NOT NULL,
  `gid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_pms` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `text` text COLLATE latin1_general_ci NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `new` tinyint(1) NOT NULL DEFAULT \'1\',
  `rID` int(10) unsigned NOT NULL,
  `sID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_posts` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `text` text NOT NULL,
  `thread` int(10) unsigned NOT NULL,
  `stp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_profiles` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `user` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_quotes` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `quote` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `by` int(10) unsigned NOT NULL,
  `who` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `where` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `added` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_sbox` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `text` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_settings` (
  `key` varchar(50) NOT NULL,
  `value` varchar(200) NOT NULL,
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_threads` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `title` varchar(200) NOT NULL,
  `stp` int(10) unsigned NOT NULL,
  `board` int(10) unsigned NOT NULL,
  `attendance` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_thumbs` (
  `file` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `size` int(10) unsigned NOT NULL,
  PRIMARY KEY (`file`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;';

$tables[] = 'CREATE TABLE IF NOT EXISTS `#_user` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `displayName` varchar(12) COLLATE latin1_general_ci NOT NULL,
  `name` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `lastAct` int(10) unsigned NOT NULL,
  `lastEdit` int(10) unsigned NOT NULL,
  `lastEditCat` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `language` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `template` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `status` varchar(140) COLLATE latin1_general_ci NOT NULL,
  `notify` int(10) unsigned NOT NULL,
  `signature` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `bday` date NOT NULL,
  `favMovie` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `favMusic` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `favFood` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `favPlace` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `favCar` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `favSports` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `favSportsclub` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `favHp1` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `favHp2` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `favHp3` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `icq` int(10) unsigned NOT NULL,
  `skype` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `msn` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `mobile` varchar(20) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;';
?>
