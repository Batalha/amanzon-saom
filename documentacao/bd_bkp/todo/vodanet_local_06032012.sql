-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 06/03/2012 às 14h45min
-- Versão do Servidor: 5.5.20
-- Versão do PHP: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `vodanet_online`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_equipamentos`
--

CREATE TABLE IF NOT EXISTS `tipo_equipamentos` (
  `idtipo_equipamentos` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(105) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idtipo_equipamentos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `tipo_equipamentos`
--

INSERT INTO `tipo_equipamentos` (`idtipo_equipamentos`, `nome`, `descricao`) VALUES
(1, 'SL 2000 80', 'SL2000 80 NOS WITHOUT POWER CABLE	'),
(2, 'SL 4033', 'ODU 2W'),
(3, 'SL 4035', NULL),
(4, 'SL 4033', '10480404020308070251');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
