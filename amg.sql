-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 26 okt 2014 kl 17:38
-- Serverversion: 5.6.15-log
-- PHP-version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `amg`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `keywords`
--

CREATE TABLE IF NOT EXISTS `keywords` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'pk',
  `keyword` varchar(256) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `relevant` tinyint(1) NOT NULL,
  `jobcategoryid` int(11) NOT NULL COMMENT 'fk',
  PRIMARY KEY (`id`),
  KEY `keyword` (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `kommuner`
--

CREATE TABLE IF NOT EXISTS `kommuner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kommunid` int(10) unsigned NOT NULL,
  `namn` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `lanid` int(10) unsigned NOT NULL COMMENT 'fk',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kommunid_2` (`kommunid`),
  KEY `kommunid` (`kommunid`,`lanid`),
  KEY `namn` (`namn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1873 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `lan`
--

CREATE TABLE IF NOT EXISTS `lan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'pk',
  `lanid` int(10) unsigned NOT NULL,
  `namn` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lanid_2` (`lanid`),
  KEY `lanid` (`lanid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=111 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `platsannonser`
--

CREATE TABLE IF NOT EXISTS `platsannonser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'pk',
  `annonsid` int(10) unsigned NOT NULL,
  `annonsrubrik` varchar(256) NOT NULL,
  `annonstext` varchar(16384) NOT NULL,
  `yrkesbenamning` varchar(512) NOT NULL,
  `yrkesid` int(10) unsigned NOT NULL COMMENT 'fk',
  `publiceraddatum` datetime NOT NULL,
  `antalplatser` int(4) NOT NULL,
  `kommunnamn` varchar(40) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL COMMENT 'fk',
  `kommunid` int(10) unsigned NOT NULL COMMENT 'fk',
  `lanid` int(10) unsigned NOT NULL COMMENT 'fk',
  `yrkesgruppid` int(10) unsigned NOT NULL COMMENT 'fk',
  `yrkesomradeid` int(10) unsigned NOT NULL COMMENT 'fk',
  PRIMARY KEY (`id`),
  UNIQUE KEY `annonsid` (`annonsid`),
  KEY `kommunid` (`kommunid`,`lanid`,`yrkesgruppid`,`yrkesomradeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20387 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `scrapelog`
--

CREATE TABLE IF NOT EXISTS `scrapelog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'pk',
  `tablename` varchar(20) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `newrecords` int(10) unsigned DEFAULT NULL,
  `startedat` datetime NOT NULL,
  `finishedat` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `yrken`
--

CREATE TABLE IF NOT EXISTS `yrken` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'pk',
  `yrkeid` int(10) unsigned NOT NULL,
  `namn` varchar(60) NOT NULL,
  `yrkesgruppid` int(10) unsigned NOT NULL COMMENT 'fk',
  PRIMARY KEY (`id`),
  UNIQUE KEY `yrkeid` (`yrkeid`),
  KEY `namn` (`namn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6581 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `yrkesgrupper`
--

CREATE TABLE IF NOT EXISTS `yrkesgrupper` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `yrkesgruppid` int(10) unsigned NOT NULL,
  `namn` varchar(256) NOT NULL,
  `yrkesomradeid` int(10) unsigned NOT NULL COMMENT 'fk',
  PRIMARY KEY (`id`),
  UNIQUE KEY `yrkesgruppid_2` (`yrkesgruppid`),
  KEY `yrkesgruppid` (`yrkesgruppid`),
  KEY `yrkesomradeid` (`yrkesomradeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=801 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `yrkesomraden`
--

CREATE TABLE IF NOT EXISTS `yrkesomraden` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'pk',
  `yrkesomradeid` int(10) unsigned NOT NULL,
  `namn` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `yrkesomradeid_2` (`yrkesomradeid`),
  KEY `yrkesomradeid` (`yrkesomradeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
