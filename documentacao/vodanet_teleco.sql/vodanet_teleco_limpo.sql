-- phpMyAdmin SQL Dump
-- version 2.11.2.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Jun 18, 2008 as 01:59 PM
-- Versão do Servidor: 5.0.41
-- Versão do PHP: 5.0.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `vodanet_teleco`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atendimento`
--

CREATE TABLE `atendimento` (
  `id` mediumint(9) NOT NULL auto_increment,
  `idChamado` int(11) NOT NULL,
  `dt_entrada` date NOT NULL,
  `hr_entrada` time NOT NULL,
  `dt_saida` date NOT NULL,
  `hr_saida` time NOT NULL,
  `dt_entrada_atend` date NOT NULL,
  `hr_entrada_atend` time NOT NULL,
  `dt_saida_atend` date NOT NULL,
  `hr_saida_atend` time NOT NULL,
  `status` varchar(25) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=58840 ;

--
-- Estrutura da tabela `cablechange`
--

CREATE TABLE `cablechange` (
  `idEstacao` int(5) NOT NULL default '0',
  `CNL` text collate latin1_general_ci NOT NULL,
  `operador` text collate latin1_general_ci NOT NULL,
  `UF` text collate latin1_general_ci NOT NULL,
  `localidade` text collate latin1_general_ci NOT NULL,
  `idTecnico` int(10) NOT NULL default '0',
  `idOpNoc` int(5) NOT NULL default '0',
  `observacao` varchar(255) collate latin1_general_ci NOT NULL default '',
  `data` date NOT NULL default '0000-00-00',
  `hora` time NOT NULL default '00:00:00',
  `status` varchar(55) collate latin1_general_ci NOT NULL default 'NAO',
  PRIMARY KEY  (`idEstacao`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


--
-- Estrutura da tabela `chamado`
--

CREATE TABLE `chamado` (
  `idChamado` int(10) unsigned NOT NULL auto_increment,
  `idTecnico` int(4) NOT NULL default '0',
  `idEstacao` int(5) NOT NULL default '0',
  `tipo` text collate latin1_general_ci,
  `status` text collate latin1_general_ci NOT NULL,
  `dtSolicitacao` date default NULL,
  `hrSolicitacao` time default NULL,
  `motivoAcionamento` text collate latin1_general_ci NOT NULL,
  `motivoVisita` text collate latin1_general_ci,
  `idTecSolicitante` text collate latin1_general_ci NOT NULL,
  `solicitante` text collate latin1_general_ci,
  `telSolicitante` text collate latin1_general_ci,
  `nroBA` int(10) unsigned default NULL,
  `dtVencimentoBA` text collate latin1_general_ci,
  `hrVencimentoBA` text collate latin1_general_ci,
  `servicoExecutado` text collate latin1_general_ci,
  `materialUtilizado` text collate latin1_general_ci,
  `pendencias` text collate latin1_general_ci,
  `dtInicio` text collate latin1_general_ci,
  `hrInicio` text collate latin1_general_ci,
  `dtFim` text collate latin1_general_ci,
  `hrFim` text collate latin1_general_ci,
  `origem` text collate latin1_general_ci,
  `distanciaIda` text collate latin1_general_ci,
  `dtSaidaIda` text collate latin1_general_ci,
  `hrSaidaIda` text collate latin1_general_ci,
  `dtChegadaIda` text collate latin1_general_ci,
  `hrChegadaIda` text collate latin1_general_ci,
  `obsIda` text collate latin1_general_ci NOT NULL,
  `destino` text collate latin1_general_ci,
  `dtSaidaVolta` text collate latin1_general_ci,
  `hrSaidaVolta` text collate latin1_general_ci,
  `dtChegadaVolta` text collate latin1_general_ci,
  `hrChegadaVolta` text collate latin1_general_ci,
  `obsVolta` text collate latin1_general_ci,
  `distanciaVolta` text collate latin1_general_ci,
  `prioridade` int(11) NOT NULL,
  `andamento` varchar(75) collate latin1_general_ci NOT NULL default '-',
  `fileBA` mediumtext collate latin1_general_ci NOT NULL,
  `descInterno` text collate latin1_general_ci NOT NULL,
  `idTecnicoNOC` int(11) NOT NULL,
  `tipoBA` varchar(120) collate latin1_general_ci NOT NULL,
  `id_com_fim` int(11) NOT NULL,
  `atd_com` varchar(10) collate latin1_general_ci NOT NULL,
  `finalizadoComo` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`idChamado`),
  KEY `idEstacao` (`idEstacao`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=63789 ;


--
-- Estrutura da tabela `contato`
--

CREATE TABLE `contato` (
  `idContato` int(10) unsigned NOT NULL auto_increment,
  `nome` text collate latin1_general_ci NOT NULL,
  `empresa` text collate latin1_general_ci NOT NULL,
  `local` text collate latin1_general_ci NOT NULL,
  `setor` text collate latin1_general_ci NOT NULL,
  `email1` text collate latin1_general_ci NOT NULL,
  `email2` text collate latin1_general_ci NOT NULL,
  `celular` text collate latin1_general_ci NOT NULL,
  `telFixo` text collate latin1_general_ci NOT NULL,
  `telOutro` text collate latin1_general_ci NOT NULL,
  `nextel` text collate latin1_general_ci NOT NULL,
  `skype` text collate latin1_general_ci NOT NULL,
  `obs` mediumtext collate latin1_general_ci NOT NULL,
  `status` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`idContato`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=259 ;

--
-- Estrutura da tabela `equipamento`
--

CREATE TABLE `equipamento` (
  `idEquipamento` int(8) NOT NULL auto_increment,
  `idEquipamentoTipo` int(3) NOT NULL default '0',
  `nroSerie` text NOT NULL,
  `invoice` text NOT NULL,
  `dtCadastro` date NOT NULL default '0000-00-00',
  `hrCadastro` time NOT NULL default '00:00:00',
  `status` text NOT NULL,
  `idTecCadastro` int(5) NOT NULL default '0',
  PRIMARY KEY  (`idEquipamento`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5847 ;


--
-- Estrutura da tabela `equipamentotipo`
--

CREATE TABLE `equipamentotipo` (
  `idEquipamentoTipo` int(3) NOT NULL auto_increment,
  `texto` text NOT NULL,
  `equipamento` text NOT NULL,
  `tipo` text NOT NULL,
  PRIMARY KEY  (`idEquipamentoTipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;


--
-- Estrutura da tabela `estacao`
--

CREATE TABLE `estacao` (
  `idEstacao` int(5) NOT NULL default '0',
  `CNL` text collate latin1_general_ci NOT NULL,
  `operador` text collate latin1_general_ci NOT NULL,
  `UF` text collate latin1_general_ci NOT NULL,
  `siglaMun` text collate latin1_general_ci NOT NULL,
  `municipio` text collate latin1_general_ci NOT NULL,
  `localidade` text collate latin1_general_ci NOT NULL,
  `atendimento` text collate latin1_general_ci NOT NULL,
  `planWeb` text collate latin1_general_ci NOT NULL,
  `SAP` text collate latin1_general_ci NOT NULL,
  `descricao` text collate latin1_general_ci NOT NULL,
  `qtdAss` text collate latin1_general_ci NOT NULL,
  `qtdTroncosAss` text collate latin1_general_ci NOT NULL,
  `qtdTroncosTup` text collate latin1_general_ci NOT NULL,
  `tipoSVM` text collate latin1_general_ci NOT NULL,
  `latitude` text collate latin1_general_ci NOT NULL,
  `longitude` text collate latin1_general_ci NOT NULL,
  `altitude` text collate latin1_general_ci NOT NULL,
  `tamAntena` text collate latin1_general_ci NOT NULL,
  `bucWatts` text collate latin1_general_ci NOT NULL,
  `tipoEnergia` text collate latin1_general_ci NOT NULL,
  `areaCode` text collate latin1_general_ci NOT NULL,
  `tariffArea` text collate latin1_general_ci NOT NULL,
  `digTable` text collate latin1_general_ci NOT NULL,
  `rangeOPX` text collate latin1_general_ci NOT NULL,
  `rangeSSW` text collate latin1_general_ci NOT NULL,
  `packetRetry` text collate latin1_general_ci NOT NULL,
  `host` text collate latin1_general_ci NOT NULL,
  `ipAddam` text collate latin1_general_ci NOT NULL,
  `ipSolante` text collate latin1_general_ci NOT NULL,
  `ipSSW` text collate latin1_general_ci NOT NULL,
  `ipDest` text collate latin1_general_ci NOT NULL,
  `udpPort` text collate latin1_general_ci NOT NULL,
  `tcpPort` text collate latin1_general_ci NOT NULL,
  `RTD` text collate latin1_general_ci NOT NULL,
  `azimute` text collate latin1_general_ci NOT NULL,
  `elevacao` text collate latin1_general_ci NOT NULL,
  `polarizacao` text collate latin1_general_ci NOT NULL,
  `elevacaoReal` text collate latin1_general_ci NOT NULL,
  `siteID` text collate latin1_general_ci NOT NULL,
  `tipoEstacao` text collate latin1_general_ci NOT NULL,
  `nodeID` text collate latin1_general_ci NOT NULL,
  `fowID` text collate latin1_general_ci NOT NULL,
  `tipoLNB` text collate latin1_general_ci NOT NULL,
  `freqFOW` text collate latin1_general_ci NOT NULL,
  `operModeBUC` text collate latin1_general_ci NOT NULL,
  `tipoBUC` text collate latin1_general_ci NOT NULL,
  `OriginCode` varchar(10) collate latin1_general_ci NOT NULL,
  `EstOuGtw` varchar(15) collate latin1_general_ci NOT NULL default 'estacao',
  `unidadeContagem` varchar(15) collate latin1_general_ci NOT NULL,
  `municipioConces` varchar(255) collate latin1_general_ci NOT NULL,
  `enderecoConces` varchar(255) collate latin1_general_ci NOT NULL,
  `identConces` varchar(255) collate latin1_general_ci NOT NULL,
  `nomeConces` varchar(255) collate latin1_general_ci NOT NULL,
  `telConces` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`idEstacao`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
