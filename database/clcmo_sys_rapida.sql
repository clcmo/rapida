-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 10, 2019 at 10:56 PM
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
  PRIMARY KEY (`id_cla`),
  KEY `fk_cla_cou` (`id_cou`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`id_cla`, `start_semester`, `start_year`, `id_cou`, `status_cla`, `start_date`, `total_semesters`) VALUES
(1, 1, 2019, 1, 1, '2019-02-07 07:40:00', 6);

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
  `classroom` varchar(25) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `status_dis` int(1) NOT NULL,
  PRIMARY KEY (`id_dis`),
  KEY `fk_dis_cou` (`id_cou`),
  KEY `fk_dis_tea` (`id_tea`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `disciplines`
--

INSERT INTO `disciplines` (`id_dis`, `name_dis`, `id_cou`, `id_tea`, `classroom`, `time_start`, `time_end`, `status_dis`) VALUES
(1, 'Teorias da Administração I', 1, 1, 'Sala 1', '07:40:00', '09:15:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id_emp` int(11) NOT NULL AUTO_INCREMENT,
  `area_emp` varchar(25) NOT NULL,
  `id_use` int(11) NOT NULL,
  `status_emp` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_emp`),
  KEY `fk_emp_use` (`id_use`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id_emp`, `area_emp`, `id_use`, `status_emp`) VALUES
(1, 'Informática', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `historic`
--

DROP TABLE IF EXISTS `historic`;
CREATE TABLE IF NOT EXISTS `historic` (
  `id_his` int(11) NOT NULL AUTO_INCREMENT,
  `id_stu` int(11) NOT NULL,
  `id_dis` int(11) NOT NULL,
  `n1` double NOT NULL,
  `n2` double NOT NULL,
  `mp` double NOT NULL,
  `fi` int(11) NOT NULL,
  `fa` int(11) NOT NULL,
  `f` int(11) NOT NULL,
  `calc` varchar(50) NOT NULL,
  `mf` double NOT NULL,
  `status_his` int(11) NOT NULL,
  PRIMARY KEY (`id_his`),
  KEY `fk_his_stu` (`id_stu`),
  KEY `fk_his_dis` (`id_dis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  KEY `fk_not_use` (`id_use`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

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
-- Table structure for table `parents`
--

DROP TABLE IF EXISTS `parents`;
CREATE TABLE IF NOT EXISTS `parents` (
  `id_par` int(11) NOT NULL AUTO_INCREMENT,
  `id_stu` int(11) NOT NULL,
  `name_par` varchar(200) NOT NULL,
  `cpf_par` varchar(14) NOT NULL,
  `rg_par` varchar(12) NOT NULL,
  `phone_par` varchar(10) NOT NULL,
  PRIMARY KEY (`id_par`),
  KEY `fk_par_stu` (`id_stu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  KEY `fk_stu_use` (`id_use`),
  KEY `fk_stu_cla` (`id_cla`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id_stu`, `id_use`, `id_cla`) VALUES
(1, 2, 1),
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
  KEY `fk_tea_use` (`id_use`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

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
  `id_use` int(11) NOT NULL AUTO_INCREMENT,
  `type_use` int(1) NOT NULL DEFAULT '1',
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_use`, `type_use`, `status_use`, `signup_date`, `name_use`, `login`, `password`, `email`, `photo`, `cep`, `address`, `number`, `neighborhood`, `city`, `state`, `rg`, `cpf`, `phone`, `birthday_date`) VALUES
(1, 2, 3, '2019-03-11 19:40:00', 'Administrador Teste', 'admin', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 'admin@demo.com.br', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 5, '2019-03-11 19:40:00', 'Usuário Teste', 'demo', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'demo@demo.com.br', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 5, '2019-03-11 19:40:00', 'Rosana Yuri', 'rosana_yuri', 'fe703d258c7ef5f50b71e06565a65aa07194907f', 'rosana@demo.com.br', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 3, 4, '2019-03-11 19:40:00', 'Anderson Silva', 'prof_anderson', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'anderson@demo.com.br', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, 5, '2019-03-11 19:40:00', 'Camila Leite', 'clcmo', 'fe703d258c7ef5f50b71e06565a65aa07194907f', 'camila.leite.oliveira@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classroom`
--
ALTER TABLE `classroom`
  ADD CONSTRAINT `classroom_ibfk_1` FOREIGN KEY (`id_cou`) REFERENCES `courses` (`id_cou`);

--
-- Constraints for table `disciplines`
--
ALTER TABLE `disciplines`
  ADD CONSTRAINT `disciplines_ibfk_1` FOREIGN KEY (`id_cou`) REFERENCES `courses` (`id_cou`),
  ADD CONSTRAINT `disciplines_ibfk_2` FOREIGN KEY (`id_tea`) REFERENCES `teachers` (`id_tea`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`id_use`) REFERENCES `users` (`id_use`);

--
-- Constraints for table `historic`
--
ALTER TABLE `historic`
  ADD CONSTRAINT `historic_ibfk_1` FOREIGN KEY (`id_stu`) REFERENCES `students` (`id_stu`),
  ADD CONSTRAINT `historic_ibfk_2` FOREIGN KEY (`id_dis`) REFERENCES `disciplines` (`id_dis`);

--
-- Constraints for table `notifies`
--
ALTER TABLE `notifies`
  ADD CONSTRAINT `notifies_ibfk_1` FOREIGN KEY (`id_use`) REFERENCES `users` (`id_use`);

--
-- Constraints for table `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `parents_ibfk_1` FOREIGN KEY (`id_stu`) REFERENCES `students` (`id_stu`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`id_use`) REFERENCES `users` (`id_use`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`id_cla`) REFERENCES `classroom` (`id_cla`);

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`id_use`) REFERENCES `users` (`id_use`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
