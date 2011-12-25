-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: bm22.webservidor.net
-- Tempo de Geração: 25/12/2011 às 16h25min
-- Versão do Servidor: 5.1.57
-- Versão do PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `mmetas_db01`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `metas2012`
--

CREATE TABLE IF NOT EXISTS `metas2012` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave` varchar(128) NOT NULL,
  `userid` varchar(128) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `userlink` varchar(200) DEFAULT NULL,
  `meta` text,
  `data` datetime DEFAULT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
