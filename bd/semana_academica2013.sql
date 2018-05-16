-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 19-Set-2014 às 19:51
-- Versão do servidor: 5.5.36
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `semana_academica2013`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE IF NOT EXISTS `aluno` (
  `matricula` varchar(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `curso` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`matricula`),
  UNIQUE KEY `matricula_UNIQUE` (`matricula`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno_minicurso`
--

CREATE TABLE IF NOT EXISTS `aluno_minicurso` (
  `aluno_matricula` varchar(11) NOT NULL,
  `minicurso_codigo` int(11) NOT NULL,
  `presenca` int(1) DEFAULT '0',
  PRIMARY KEY (`aluno_matricula`,`minicurso_codigo`),
  KEY `fk_aluno_has_minicurso_minicurso1` (`minicurso_codigo`),
  KEY `fk_aluno_has_minicurso_aluno1` (`aluno_matricula`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno_palestra`
--

CREATE TABLE IF NOT EXISTS `aluno_palestra` (
  `aluno_matricula` varchar(11) NOT NULL,
  `palestra_codigo` int(11) NOT NULL,
  `presenca` int(1) DEFAULT '0',
  PRIMARY KEY (`aluno_matricula`,`palestra_codigo`),
  KEY `fk_aluno_has_palestra_palestra1` (`palestra_codigo`),
  KEY `fk_aluno_has_palestra_aluno1` (`aluno_matricula`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `minicurso`
--

CREATE TABLE IF NOT EXISTS `minicurso` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `local` varchar(45) DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `responsavel` varchar(45) DEFAULT NULL,
  `vagas` int(11) DEFAULT NULL,
  `situacao` int(1) DEFAULT '1' COMMENT 'Situação do minicurso 1 - Disponível, 2 - Indisponível',
  `carga_horaria` float DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `palestra`
--

CREATE TABLE IF NOT EXISTS `palestra` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `tema` varchar(45) DEFAULT NULL,
  `palestrante` varchar(45) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `empresa` varchar(45) DEFAULT NULL,
  `vagas` int(11) DEFAULT NULL,
  `local` varchar(20) DEFAULT NULL,
  `situacao` int(1) DEFAULT '1',
  `carga_horaria` float DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `aluno_minicurso`
--
ALTER TABLE `aluno_minicurso`
  ADD CONSTRAINT `fk_aluno_has_minicurso_aluno1` FOREIGN KEY (`aluno_matricula`) REFERENCES `aluno` (`matricula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_aluno_has_minicurso_minicurso1` FOREIGN KEY (`minicurso_codigo`) REFERENCES `minicurso` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `aluno_palestra`
--
ALTER TABLE `aluno_palestra`
  ADD CONSTRAINT `fk_aluno_has_palestra_aluno1` FOREIGN KEY (`aluno_matricula`) REFERENCES `aluno` (`matricula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_aluno_has_palestra_palestra1` FOREIGN KEY (`palestra_codigo`) REFERENCES `palestra` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
