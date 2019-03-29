-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 29, 2019 at 06:11 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clcmo_sys_rapida`
--

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

DROP TABLE IF EXISTS `classroom`;
CREATE TABLE IF NOT EXISTS `classroom` (
  `id_cla` int(11) NOT NULL AUTO_INCREMENT,
  `start_semester` int(1) NOT NULL,
  `start_year` year(4) NOT NULL,
  `id_cou` int(11) NOT NULL,
  `status_cla` int(1) NOT NULL,
  `start_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_semesters` int(11) NOT NULL,
  `students` int(11) NOT NULL,
  PRIMARY KEY (`id_cla`),
  KEY `id_cur` (`id_cou`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`id_cla`, `start_semester`, `start_year`, `id_cou`, `status_cla`, `start_date`, `total_semesters`, `students`) VALUES
(1, 1, 2019, 1, 1, '2019-02-07 07:40:00', 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id_cou` int(11) NOT NULL AUTO_INCREMENT,
  `name_cou` varchar(50) NOT NULL,
  `status_cou` int(1) NOT NULL DEFAULT '1',
  `type_cou` int(1) NOT NULL DEFAULT '1',
  `period` varchar(1) NOT NULL,
  PRIMARY KEY (`id_cou`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id_cou`, `name_cou`, `status_cou`, `type_cou`, `period`) VALUES
(1, 'Ensino Médio e Administração', 1, 1, ''),
(2, 'Ensino Médio e Logistica', 1, 1, ''),
(3, 'Ensino Médio e Contabilidade', 1, 1, ''),
(4, 'Desenvolvimento de Sistemas', 1, 2, ''),
(5, 'Recursos Humanos', 1, 2, ''),
(6, 'Enfermagem', 1, 2, ''),
(8, 'Segurança do Trabalho', 1, 2, ''),
(9, 'Jogos Digitais', 2, 2, ''),
(10, 'Paleontologia', 2, 2, ''),
(11, 'Culinária', 2, 2, ''),
(12, 'Informática', 2, 2, ''),
(13, 'Ensino Médio e Ciências Contábeis', 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `disciplines`
--

DROP TABLE IF EXISTS `disciplines`;
CREATE TABLE IF NOT EXISTS `disciplines` (
  `id_dis` int(11) NOT NULL AUTO_INCREMENT,
  `name_dis` varchar(50) NOT NULL,
  `id_cou` int(11) NOT NULL,
  `id_tea` int(11) NOT NULL,
  `period` varchar(1) NOT NULL,
  `classroom` varchar(25) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `status_dis` int(1) NOT NULL,
  PRIMARY KEY (`id_dis`),
  KEY `fk_cur` (`id_cou`),
  KEY `fk_pro` (`id_tea`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `disciplines`
--

INSERT INTO `disciplines` (`id_dis`, `name_dis`, `id_cou`, `id_tea`, `period`, `classroom`, `time_start`, `time_end`, `status_dis`) VALUES
(1, 'Teorias da Administração I', 1, 1, 'M', 'Sala 1', '07:40:00', '09:15:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id_fun` int(11) NOT NULL AUTO_INCREMENT,
  `area_fun` varchar(25) NOT NULL,
  `id_usu` int(11) NOT NULL,
  `status_fun` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_fun`),
  KEY `id_usu` (`id_usu`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id_fun`, `area_fun`, `id_usu`, `status_fun`) VALUES
(1, 'Informática', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifies`
--

DROP TABLE IF EXISTS `notifies`;
CREATE TABLE IF NOT EXISTS `notifies` (
  `id_not` int(11) NOT NULL AUTO_INCREMENT,
  `name_not` varchar(200) NOT NULL,
  `type_not` int(1) NOT NULL,
  `id_use` int(11) NOT NULL,
  `date_not` datetime DEFAULT NULL,
  `status_not` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_not`),
  KEY `id_usu` (`id_use`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifies`
--

INSERT INTO `notifies` (`id_not`, `name_not`, `type_not`, `id_use`, `date_not`, `status_not`) VALUES
(1, 'Declaração de Matrícula', 1, 1, '2019-02-05 19:50:00', 1),
(2, 'Declaração de Matrícula', 1, 1, '2019-02-05 19:50:00', 1),
(3, 'Passe PEC', 1, 1, '2019-03-14 20:52:25', 1),
(4, 'Passe PEC', 1, 1, '2019-03-14 20:52:37', 1),
(5, 'Passe BOM', 1, 1, '2019-03-14 20:54:22', 1),
(6, 'Passe BOM', 1, 1, '2019-03-14 21:39:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parents-students`
--

DROP TABLE IF EXISTS `parents-students`;
CREATE TABLE IF NOT EXISTS `parents-students` (
  `id_res` int(11) NOT NULL AUTO_INCREMENT,
  `id_alu` int(11) NOT NULL,
  `nome_res` varchar(200) NOT NULL,
  `cpf_res` varchar(14) NOT NULL,
  `rg_res` varchar(12) NOT NULL,
  `tel_res` varchar(10) NOT NULL,
  PRIMARY KEY (`id_res`),
  KEY `id_alu` (`id_alu`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `id_stu` int(11) NOT NULL AUTO_INCREMENT,
  `id_use` int(11) NOT NULL,
  `id_cla` int(11) NOT NULL,
  PRIMARY KEY (`id_stu`),
  KEY `id_usu` (`id_use`),
  KEY `id_tur` (`id_cla`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id_stu`, `id_use`, `id_cla`) VALUES
(1, 1, 1),
(2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE IF NOT EXISTS `teachers` (
  `id_tea` int(11) NOT NULL AUTO_INCREMENT,
  `id_use` int(11) NOT NULL,
  `area_tea` varchar(25) NOT NULL,
  `status_tea` int(1) NOT NULL,
  PRIMARY KEY (`id_tea`),
  KEY `fk_usu` (`id_use`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id_tea`, `id_use`, `area_tea`, `status_tea`) VALUES
(1, 4, 'Administração', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_use` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type_use` int(1) UNSIGNED NOT NULL DEFAULT '1',
  `status_use` int(1) NOT NULL DEFAULT '1',
  `signup_date` datetime NOT NULL,
  `name_use` varchar(50) NOT NULL,
  `login` varchar(25) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `photo` varchar(50) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `neighborhood` varchar(200) DEFAULT NULL,
  `city` varchar(300) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `rg` varchar(12) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `birthday_date` date DEFAULT NULL,
  PRIMARY KEY (`id_use`),
  UNIQUE KEY `login` (`login`),
  KEY `nivel` (`type_use`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_use`, `type_use`, `status_use`, `signup_date`, `name_use`, `login`, `password`, `email`, `photo`, `cep`, `address`, `number`, `neighborhood`, `city`, `state`, `rg`, `cpf`, `phone`, `birthday_date`) VALUES
(1, 2, 1, '2019-03-11 19:40:00', 'Administrador Teste', 'admin', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 'admin@demo.com.br', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 1, '2019-03-11 19:40:00', 'Usuário Teste', 'demo', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'demo@demo.com.br', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 1, '2019-03-11 19:40:00', 'Rosana Yuri', 'rosana_yuri', 'fe703d258c7ef5f50b71e06565a65aa07194907f', 'rosana@demo.com.br', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 3, 1, '2019-03-11 19:40:00', 'Anderson Silva', 'prof_anderson', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'anderson@demo.com.br', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, 1, '2019-03-11 19:40:00', 'Camila Leite', 'clcmo', 'fe703d258c7ef5f50b71e06565a65aa07194907f', 'camila.leite.oliveira@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
