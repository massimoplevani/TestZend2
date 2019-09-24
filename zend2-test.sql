-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Set 24, 2019 alle 21:52
-- Versione del server: 5.7.23
-- Versione PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zend2-test`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `polizza`
--

DROP TABLE IF EXISTS `polizza`;
CREATE TABLE IF NOT EXISTS `polizza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `IDUtente` int(10) UNSIGNED NOT NULL,
  `IDPolizza` int(11) NOT NULL,
  `NomePolizza` varchar(255) DEFAULT NULL,
  `Compagnia` varchar(255) NOT NULL,
  `IDTipoPolizza` int(11) NOT NULL,
  `Indirizzo` varchar(255) DEFAULT NULL,
  `Targa` varchar(255) DEFAULT NULL,
  `Modello` varchar(255) DEFAULT NULL,
  `Marca` varchar(255) DEFAULT NULL,
  `PremioPagato` int(11) DEFAULT NULL,
  `DataEmissione` date DEFAULT NULL,
  `DataScadenza` date DEFAULT NULL,
  `DataCreazione` datetime NOT NULL,
  `DataAggiornamento` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ref_utenti` (`IDUtente`),
  KEY `ref_idTipoPolizza` (`IDTipoPolizza`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `tipipolizza`
--

DROP TABLE IF EXISTS `tipipolizza`;
CREATE TABLE IF NOT EXISTS `tipipolizza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `tipipolizza`
--

INSERT INTO `tipipolizza` (`id`, `Nome`) VALUES
(1, 'Casa'),
(2, 'Auto');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

DROP TABLE IF EXISTS `utenti`;
CREATE TABLE IF NOT EXISTS `utenti` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) NOT NULL,
  `Cognome` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `DataCreazione` datetime NOT NULL,
  `DataAggiornamento` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `polizza`
--
ALTER TABLE `polizza`
  ADD CONSTRAINT `ref_idTipoPolizza` FOREIGN KEY (`IDTipoPolizza`) REFERENCES `tipipolizza` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ref_utenti` FOREIGN KEY (`IDUtente`) REFERENCES `utenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
