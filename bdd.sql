-- phpMyAdmin SQL Dump
-- version OVH
-- http://www.phpmyadmin.net
--
-- Client: mysql51-51.perso
-- Généré le : Mar 31 Janvier 2012 à 17:03
-- Version du serveur: 5.1.49
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `mydevhoumdh`
--

-- --------------------------------------------------------

--
-- Structure de la table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `Id` int(255) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) COLLATE latin1_bin NOT NULL,
  `Clot_prec` decimal(5,2) NOT NULL DEFAULT '0.00',
  `Price` decimal(5,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_bin AUTO_INCREMENT=41 ;

--
-- Contenu de la table `actions`
--

INSERT INTO `actions` (`Id`, `Nom`, `Clot_prec`, `Price`) VALUES
(1, 'ACCOR', '19.92', '22.99'),
(2, 'AIR LIQUIDE', '97.43', '96.19'),
(3, 'ALCATEL-LUCENT', '1.30', '1.35'),
(4, 'ALSTOM', '24.03', '28.97'),
(5, 'ARCELORMITTAL', '15.06', '15.42'),
(6, 'AXA', '10.30', '11.57'),
(7, 'BNP PARIBAS ACT.A', '30.78', '32.62'),
(8, 'BOUYGUES', '24.64', '23.70'),
(9, 'CAP GEMINI', '25.20', '27.78'),
(10, 'CARREFOUR', '17.88', '17.34'),
(11, 'CREDIT AGRICOLE', '4.35', '4.70'),
(12, 'DANONE', '49.12', '47.11'),
(13, 'EADS', '24.42', '25.60'),
(14, 'EDF', '19.02', '17.57'),
(15, 'ESSILOR INTL.', '55.33', '55.98'),
(16, 'FRANCE TELECOM', '12.10', '11.46'),
(17, 'GDF SUEZ', '21.28', '20.72'),
(18, 'L&#039;OREAL', '81.06', '81.29'),
(19, 'LAFARGE', '27.99', '31.08'),
(20, 'LEGRAND', '24.98', '26.14'),
(21, 'LVMH', '112.25', '123.25'),
(22, 'MICHELIN', '47.41', '52.34'),
(23, 'PERNOD RICARD', '71.65', '73.18'),
(24, 'PEUGEOT', '13.01', '14.08'),
(25, 'PPR', '113.60', '120.25'),
(26, 'PUBLICIS GROUPE SA', '35.89', '38.26'),
(27, 'RENAULT', '28.10', '32.66'),
(28, 'SAFRAN', '23.45', '23.57'),
(29, 'SAINT GOBAIN', '30.32', '34.06'),
(30, 'SANOFI', '56.67', '56.97'),
(31, 'SCHNEIDER ELECTRIC', '41.88', '47.18'),
(32, 'SOCIETE GENERALE', '17.28', '20.27'),
(33, 'STMICROELECTRONICS', '4.94', '5.08'),
(34, 'TECHNIP', '73.34', '71.86'),
(35, 'TOTAL', '39.96', '40.43'),
(36, 'UNIBAIL-RODAMCO', '136.95', '146.55'),
(37, 'VALLOUREC', '51.69', '51.38'),
(38, 'VEOLIA ENVIRON.', '8.73', '8.62'),
(39, 'VINCI', '34.36', '35.52'),
(40, 'VIVENDI', '17.08', '17.12');

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `Id` int(55) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `admin`
--

INSERT INTO `admin` (`Id`, `Nom`, `Password`) VALUES
(1, 'Florian', '56910c52ed70539e3ce0391edeb6d339');

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE IF NOT EXISTS `historique` (
  `Id` int(255) NOT NULL AUTO_INCREMENT,
  `Date` datetime NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Sens` varchar(255) NOT NULL,
  `Quantite` int(5) NOT NULL,
  `PU` float(5,2) NOT NULL,
  `Total` float(8,2) NOT NULL,
  `Joueur` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `historique`
--

INSERT INTO `historique` (`Id`, `Date`, `Nom`, `Sens`, `Quantite`, `PU`, `Total`, `Joueur`) VALUES
(1, '2012-01-02 16:38:06', 'AIR LIQUIDE', 'Vente', 1, 97.43, 97.43, 'Florian'),
(2, '2012-01-03 16:40:38', 'AIR LIQUIDE', 'Vente', 3, 97.37, 292.11, 'Florian'),
(3, '2003-01-12 00:00:00', 'ALCATEL-LUCENT', 'Achat', 2, 1.32, 17.64, 'Florian'),
(4, '2012-01-03 17:03:41', 'ALCATEL-LUCENT', 'Vente', 1, 1.32, 1.32, 'Florian'),
(5, '2012-01-03 17:04:38', 'CARREFOUR', 'Achat', 3, 18.20, 69.60, 'Florian'),
(6, '2012-01-19 14:53:15', 'EDF', 'Achat', 2, 17.40, 39.80, 'Florian'),
(7, '2012-01-19 14:55:03', 'ARCELORMITTAL', 'Achat', 6, 16.24, 102.44, 'Florian'),
(8, '2012-01-19 15:23:34', 'CARREFOUR', 'Vente', 1, 17.19, 17.19, 'Florian'),
(9, '2012-01-19 15:23:42', 'ACCOR', 'Achat', 3, 22.66, 72.98, 'Florian'),
(10, '2012-01-19 15:24:33', 'ACCOR', 'Achat', 3, 22.66, 72.98, 'Florian'),
(11, '2012-01-19 15:33:05', 'AIR LIQUIDE', 'Achat', 20, 98.65, 1978.00, 'xav'),
(12, '2012-01-26 17:19:44', 'AXA', 'Achat', 70, 12.06, 849.20, 'xav');

-- --------------------------------------------------------

--
-- Structure de la table `joueurs`
--

CREATE TABLE IF NOT EXISTS `joueurs` (
  `Id` int(255) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Argent` double(9,2) NOT NULL DEFAULT '100000.00',
  `Argent_pot` double(10,2) NOT NULL DEFAULT '0.00',
  `Emprunt` double(9,2) NOT NULL DEFAULT '0.00',
  `Emprunt_remb` float(5,2) NOT NULL DEFAULT '0.00',
  `E-mail` varchar(255) COLLATE latin1_bin NOT NULL,
  `Admin` int(2) NOT NULL DEFAULT '0',
  `Etat` int(11) NOT NULL DEFAULT '1',
  `ACCOR` float NOT NULL,
  `ACCOR_quantite` int(10) NOT NULL,
  `AIR LIQUIDE` float NOT NULL,
  `AIR LIQUIDE_quantite` int(10) NOT NULL,
  `ALCATEL-LUCENT` float NOT NULL,
  `ALCATEL-LUCENT_quantite` int(10) NOT NULL,
  `ALSTOM` float NOT NULL,
  `ALSTOM_quantite` int(10) NOT NULL,
  `ARCELORMITTAL` float NOT NULL,
  `ARCELORMITTAL_quantite` int(10) NOT NULL,
  `AXA` float NOT NULL,
  `AXA_quantite` int(10) NOT NULL,
  `BNP PARIBAS ACT.A` float NOT NULL,
  `BNP PARIBAS ACT.A_quantite` int(10) NOT NULL,
  `BOUYGUES` float NOT NULL,
  `BOUYGUES_quantite` int(10) NOT NULL,
  `CAP GEMINI` float NOT NULL,
  `CAP GEMINI_quantite` int(10) NOT NULL,
  `CARREFOUR` float NOT NULL,
  `CARREFOUR_quantite` int(10) NOT NULL,
  `CREDIT AGRICOLE` float NOT NULL,
  `CREDIT AGRICOLE_quantite` int(10) NOT NULL,
  `DANONE` float NOT NULL,
  `DANONE_quantite` int(10) NOT NULL,
  `EADS` float NOT NULL,
  `EADS_quantite` int(10) NOT NULL,
  `EDF` float NOT NULL,
  `EDF_quantite` int(10) NOT NULL,
  `ESSILOR INTL.` float NOT NULL,
  `ESSILOR INTL._quantite` int(10) NOT NULL,
  `FRANCE TELECOM` float NOT NULL,
  `FRANCE TELECOM_quantite` int(10) NOT NULL,
  `GDF SUEZ` float NOT NULL,
  `GDF SUEZ_quantite` int(10) NOT NULL,
  `L&#039;OREAL` float NOT NULL,
  `L&#039;OREAL_quantite` int(10) NOT NULL,
  `LAFARGE` float NOT NULL,
  `LAFARGE_quantite` int(10) NOT NULL,
  `LEGRAND` int(10) NOT NULL,
  `LEGRAND_quantite` float NOT NULL,
  `LVMH` float NOT NULL,
  `LVMH_quantite` int(10) NOT NULL,
  `MICHELIN` float NOT NULL,
  `MICHELIN_quantite` int(10) NOT NULL,
  `PERNOD RICARD` float NOT NULL,
  `PERNOD RICARD_quantite` int(10) NOT NULL,
  `PEUGEOT` float NOT NULL,
  `PEUGEOT_quantite` int(10) NOT NULL,
  `PPR` float NOT NULL,
  `PPR_quantite` int(10) NOT NULL,
  `PUBLICIS GROUPE SA` int(10) NOT NULL,
  `PUBLICIS GROUPE SA_quantite` float NOT NULL,
  `RENAULT` float NOT NULL,
  `RENAULT_quantite` int(10) NOT NULL,
  `SAFRAN` int(10) NOT NULL,
  `SAFRAN_quantite` float NOT NULL,
  `SAINT GOBAIN` float NOT NULL,
  `SAINT GOBAIN_quantite` int(10) NOT NULL,
  `SANOFI` float NOT NULL,
  `SANOFI_quantite` int(10) NOT NULL,
  `SCHNEIDER ELECTRIC` float NOT NULL,
  `SCHNEIDER ELECTRIC_quantite` int(10) NOT NULL,
  `SOCIETE GENERALE` float NOT NULL,
  `SOCIETE GENERALE_quantite` int(10) NOT NULL,
  `STMICROELECTRONICS` float NOT NULL,
  `STMICROELECTRONICS_quantite` int(10) NOT NULL,
  `TECHNIP` float NOT NULL,
  `TECHNIP_quantite` int(10) NOT NULL,
  `TOTAL` float NOT NULL,
  `TOTAL_quantite` int(10) NOT NULL,
  `UNIBAIL-RODAMCO` float NOT NULL,
  `UNIBAIL-RODAMCO_quantite` int(10) NOT NULL,
  `VALLOUREC` float NOT NULL,
  `VALLOUREC_quantite` int(10) NOT NULL,
  `VEOLIA ENVIRON.` float NOT NULL,
  `VEOLIA ENVIRON._quantite` int(10) NOT NULL,
  `VINCI` float NOT NULL,
  `VINCI_quantite` int(10) NOT NULL,
  `VIVENDI` float NOT NULL,
  `VIVENDI_quantite` int(10) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_bin AUTO_INCREMENT=14 ;

--
-- Contenu de la table `joueurs`
--

INSERT INTO `joueurs` (`Id`, `Nom`, `Password`, `Argent`, `Argent_pot`, `Emprunt`, `Emprunt_remb`, `E-mail`, `Admin`, `Etat`, `ACCOR`, `ACCOR_quantite`, `AIR LIQUIDE`, `AIR LIQUIDE_quantite`, `ALCATEL-LUCENT`, `ALCATEL-LUCENT_quantite`, `ALSTOM`, `ALSTOM_quantite`, `ARCELORMITTAL`, `ARCELORMITTAL_quantite`, `AXA`, `AXA_quantite`, `BNP PARIBAS ACT.A`, `BNP PARIBAS ACT.A_quantite`, `BOUYGUES`, `BOUYGUES_quantite`, `CAP GEMINI`, `CAP GEMINI_quantite`, `CARREFOUR`, `CARREFOUR_quantite`, `CREDIT AGRICOLE`, `CREDIT AGRICOLE_quantite`, `DANONE`, `DANONE_quantite`, `EADS`, `EADS_quantite`, `EDF`, `EDF_quantite`, `ESSILOR INTL.`, `ESSILOR INTL._quantite`, `FRANCE TELECOM`, `FRANCE TELECOM_quantite`, `GDF SUEZ`, `GDF SUEZ_quantite`, `L&#039;OREAL`, `L&#039;OREAL_quantite`, `LAFARGE`, `LAFARGE_quantite`, `LEGRAND`, `LEGRAND_quantite`, `LVMH`, `LVMH_quantite`, `MICHELIN`, `MICHELIN_quantite`, `PERNOD RICARD`, `PERNOD RICARD_quantite`, `PEUGEOT`, `PEUGEOT_quantite`, `PPR`, `PPR_quantite`, `PUBLICIS GROUPE SA`, `PUBLICIS GROUPE SA_quantite`, `RENAULT`, `RENAULT_quantite`, `SAFRAN`, `SAFRAN_quantite`, `SAINT GOBAIN`, `SAINT GOBAIN_quantite`, `SANOFI`, `SANOFI_quantite`, `SCHNEIDER ELECTRIC`, `SCHNEIDER ELECTRIC_quantite`, `SOCIETE GENERALE`, `SOCIETE GENERALE_quantite`, `STMICROELECTRONICS`, `STMICROELECTRONICS_quantite`, `TECHNIP`, `TECHNIP_quantite`, `TOTAL`, `TOTAL_quantite`, `UNIBAIL-RODAMCO`, `UNIBAIL-RODAMCO_quantite`, `VALLOUREC`, `VALLOUREC_quantite`, `VEOLIA ENVIRON.`, `VEOLIA ENVIRON._quantite`, `VINCI`, `VINCI_quantite`, `VIVENDI`, `VIVENDI_quantite`) VALUES
(9, 'Florian', '56910c52ed70539e3ce0391edeb6d339', 775.04, 1218.84, 3105.00, 0.00, 'florian148854@free.fr', 1, 0, 22.66, 8, 97.43, 1, 1.32, 1, 0, 0, 16.24, 6, 0, 0, 0, 0, 0, 0, 0, 0, 18.2, 2, 0, 0, 0, 0, 0, 0, 17.4, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'test', 'af1f7768512630c61ea1ad8ec1f08d9b', 20000.00, 0.00, 0.00, 0.00, 'test', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'Zozor', '56910c52ed70539e3ce0391edeb6d339', 20000.00, 0.00, 0.00, 0.00, 'florian@de.fr', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'de', '6e0e60901c6130dc0e04bedee0623d65', 20000.00, 0.00, 0.00, 0.00, 'deded@de.de', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'xav', '0f5366b3b19afc3184d23bc73d8cd311', 17172.80, 19943.00, 0.00, 0.00, 'xlemoine@escem.fr', 0, 0, 0, 0, 98.65, 20, 0, 0, 0, 0, 0, 0, 12.06, 70, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `Id` int(255) NOT NULL AUTO_INCREMENT,
  `Expediteur` varchar(255) NOT NULL,
  `Destinataire` varchar(255) NOT NULL,
  `Objet` varchar(55) NOT NULL,
  `Message` varchar(255) NOT NULL,
  `Etat` int(2) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastupdate` bigint(99) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `configuration`
--

INSERT INTO `configuration` (`id`, `lastupdate`) VALUES
(1, 0);

