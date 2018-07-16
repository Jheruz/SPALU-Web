-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2018 at 03:56 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `studentperformance`
--
CREATE DATABASE `studentperformance` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `studentperformance`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `backup_archive`
--

CREATE TABLE IF NOT EXISTS `backup_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentno` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL,
  `profid` int(11) NOT NULL,
  `subjectcode` varchar(50) NOT NULL,
  `subjectdescription` varchar(100) NOT NULL,
  `ay` varchar(50) NOT NULL,
  `sem` varchar(10) NOT NULL,
  `prelim` float NOT NULL,
  `midterm` float NOT NULL,
  `finals` float NOT NULL,
  `average` float NOT NULL,
  `equivalent` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `backup_finals_grade`
--

CREATE TABLE IF NOT EXISTS `backup_finals_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profid` int(11) NOT NULL,
  `studentno` varchar(50) NOT NULL,
  `subjectcode` varchar(50) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `caption` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `grade` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `backup_grade_category`
--

CREATE TABLE IF NOT EXISTS `backup_grade_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profid` int(11) NOT NULL,
  `subjectcode` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `term` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `backup_grade_percentage`
--

CREATE TABLE IF NOT EXISTS `backup_grade_percentage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `percent` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `backup_gradetosubmit`
--

CREATE TABLE IF NOT EXISTS `backup_gradetosubmit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profid` int(11) NOT NULL,
  `subjectcode` varchar(50) NOT NULL,
  `studentno` varchar(50) NOT NULL,
  `prelim` float NOT NULL,
  `midterm` float NOT NULL,
  `finals` float NOT NULL,
  `average` float NOT NULL,
  `remarks` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `backup_last_update`
--

CREATE TABLE IF NOT EXISTS `backup_last_update` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profid` int(11) NOT NULL,
  `date` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `backup_midterm_grade`
--

CREATE TABLE IF NOT EXISTS `backup_midterm_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profid` int(11) NOT NULL,
  `studentno` varchar(50) NOT NULL,
  `subjectcode` varchar(50) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `caption` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `grade` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `backup_notification`
--

CREATE TABLE IF NOT EXISTS `backup_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profid` int(11) NOT NULL,
  `studentno` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `subjectcode` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `tag` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `backup_passing_grade`
--

CREATE TABLE IF NOT EXISTS `backup_passing_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profid` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `backup_prelim_grade`
--

CREATE TABLE IF NOT EXISTS `backup_prelim_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profid` int(11) NOT NULL,
  `studentno` varchar(50) NOT NULL,
  `subjectcode` varchar(50) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `caption` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `grade` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `backup_raw_score`
--

CREATE TABLE IF NOT EXISTS `backup_raw_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profid` int(11) NOT NULL,
  `gradeid` int(11) NOT NULL,
  `rawscore` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `backup_syncdate`
--

CREATE TABLE IF NOT EXISTS `backup_syncdate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profid` int(11) NOT NULL,
  `date` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `backup_syncdate`
--

INSERT INTO `backup_syncdate` (`id`, `profid`, `date`) VALUES
(1, 4, '01/30/2018');

-- --------------------------------------------------------

--
-- Table structure for table `backup_term`
--

CREATE TABLE IF NOT EXISTS `backup_term` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profid` int(11) NOT NULL,
  `subjectcode` varchar(50) NOT NULL,
  `currentterm` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `department_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `code`, `department_name`) VALUES
(1, 'TVL/ICT', ''),
(2, 'BSIT', ''),
(3, 'BSIT', '');

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE IF NOT EXISTS `records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(10) NOT NULL,
  `academic_year` varchar(20) NOT NULL,
  `no` int(11) NOT NULL,
  `units` tinyint(2) NOT NULL,
  `day` varchar(10) NOT NULL,
  `time` varchar(30) NOT NULL,
  `room` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`id`, `semester`, `academic_year`, `no`, `units`, `day`, `time`, `room`) VALUES
(1, '1st', '2017-2018', 890, 2, 'WTh', '4:00-7:00', 'CL 1'),
(2, '1st', '2017-2018', 1024, 4, 'MW', '10:00-12:00', 'CL 3'),
(3, '1st', '2017-2018', 640, 4, 'TTh', '10:00-12:00', 'CL 1'),
(4, '1st', '2017-2018', 824, 3, 'M/ W', '3:00-5:00/ 1:00-4:00', 'NB 303/ CL 3'),
(5, '1st', '2017-2018', 806, 3, 'M/ T', '7:00-10:00/ 1:00-3:00', 'CL 3/ NB 303'),
(6, '1st', '2017-2018', 1024, 4, 'MW', '10:00-12:00', 'CL 3'),
(7, '1st', '2017-2018', 824, 3, 'M/ W', '3:00-5:00/ 1:00-4:00', 'NB 303/ CL 3'),
(8, '1st', '2017-2018', 815, 3, 'T/ Th', '7:00-10:00/ 1:00-3:00', 'CL 3/ NB 304');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `academic_year` varchar(50) NOT NULL,
  `sem` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `academic_year`, `sem`) VALUES
(1, '2017-2018', '1st');

-- --------------------------------------------------------

--
-- Table structure for table `student_grade`
--

CREATE TABLE IF NOT EXISTS `student_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Sem` varchar(30) NOT NULL,
  `AY` varchar(50) NOT NULL,
  `Prof_ID` int(11) NOT NULL,
  `Subject_Code` varchar(50) NOT NULL,
  `Student_No` varchar(50) NOT NULL,
  `Prelim` int(11) NOT NULL,
  `Midterm` int(11) NOT NULL,
  `Finals` int(11) NOT NULL,
  `Average` float NOT NULL,
  `Remarks` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `student_information`
--

CREATE TABLE IF NOT EXISTS `student_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Student_No` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `Course` varchar(50) NOT NULL,
  `Year` varchar(50) NOT NULL,
  `Prof_ID` int(11) NOT NULL,
  `Class_Code` varchar(20) NOT NULL,
  `Sem` varchar(50) NOT NULL,
  `AY` varchar(50) NOT NULL,
  `stat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `student_information`
--

INSERT INTO `student_information` (`id`, `Student_No`, `Name`, `Gender`, `Course`, `Year`, `Prof_ID`, `Class_Code`, `Sem`, `AY`, `stat`) VALUES
(1, 'SHS-161-0038', 'ALFORJA, DEITHER JOHN A.', 'Male', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(2, 'SHS-161-0029', 'IGNACIO, TERENZ IVHAN B.', 'Male', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(3, 'SHS-161-0116', 'JASARENO, JED JANDREI S.', 'Male', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(4, 'SHS-161-0160', 'LAT, ROJHON JUTER M.', 'Male', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(5, 'SHS-161-0117', 'LATEO, VINCENT G.', 'Male', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(6, 'SHS-161-0248', 'LIBERAL, JERVIN A.', 'Male', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(7, 'SHS-161-0243', 'MAGHIRANG, G-JAY N.', 'Male', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(8, 'SHS-161-0121', 'MORALES, JAMES C.', 'Male', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(9, 'SHS-161-0061', 'PAGDONSOLAN, JOSHUA P.', 'Male', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(10, 'SHS-161-0051', 'REYES, LORENZ MICO S.', 'Male', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(11, 'SHS-161-0185', 'SARMIENTO, CARLO L.', 'Male', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(12, 'SHS-161-0186', 'SORIANO, CHARLES JEFFERSON E.', 'Male', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(13, 'SHS-161-0030', 'VILLODRES, SERDOLLIV P.', 'Male', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(14, 'SHS-161-0098', 'VIRREY, KEN NICOLI C.', 'Male', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(15, 'SHS-161-0091', 'DELOS REYES, ERICA FAYE P.', 'Female', 'TVL/ICT', '12', 4, 'CP 3', '1st', '2017-2018', 0),
(16, '151-0840', 'ALMIROL, ALDRIN B.', 'Male', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(17, '151-0391', 'AWITAN, CHRISTIAN JAY O.', 'Male', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(18, '161-0194', 'CASTILLO, SILVES JOHN R.', 'Male', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(19, '151-0543', 'CIELO, JOHN JERWIN M.', 'Male', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(20, '151-0303', 'CRUZ, PRINCE ADAM T.', 'Male', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(21, '151-0882', 'DE LEON, JOJO A.', 'Male', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(22, '151-0375', 'DELA CRUZ, KENNETH BERT A.', 'Male', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(23, '151-0286', 'DEMEJER, KYLE S.', 'Male', 'BSIT', '2nd', 4, 'IT-3121', '1st', '2017-2018', 0),
(24, '151-0769', 'DIRECTO, ROD ANGELO JOSEPH M.', 'Male', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(25, '151-0520', 'MENDIORO, DICKYIAS V.', 'Male', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(26, '141-0652', 'MONECIA, MARVIN S.', 'Male', 'BSIT', '4th', 4, 'IT-3121', '1st', '2017-2018', 0),
(27, '151-0230', 'MORENO, JOHN KENNETH B.', 'Male', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(28, '141-0530', 'PACOMA, JOREN L.', 'Male', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(29, '131-0950', 'TRANILLA, LINDON MARCONI B.', 'Male', 'BSIT', '4th', 4, 'IT-3121', '1st', '2017-2018', 0),
(30, '151-1357', 'ADOLFO, JENIE T.', 'Female', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(31, '131-1101', 'AGUADO, MADEL M.', 'Female', 'BSIT', '4th', 4, 'IT-3121', '1st', '2017-2018', 0),
(32, '151-0313', 'ALMONTE, RICA O.', 'Female', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(33, '151-0911', 'ARSOLACIA, AIRA D.', 'Female', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(34, '151-0460', 'CORDON, RICA MAE A.', 'Female', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(35, '151-0560', 'DELA CRUZ, PEARL JOY R.', 'Female', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(36, '151-0565', 'ESTRADA, MARIA FE N.', 'Female', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(37, '151-1512', 'FAMPULME, APRILYN F.', 'Female', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(38, '151-0344', 'GUARTEL, CATHERINE L.', 'Female', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(39, '151-0265', 'JOLO, JUSTINE JOY V.', 'Female', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(40, '151-0372', 'MOLINA, CELINE O.', 'Female', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(41, '141-1207', 'NIALA, EDNA D.', 'Female', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(42, '151-0910', 'QUEBEC, AILLEN R.', 'Female', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(43, '141-0585', 'SALINAS, SHAIRA I.', 'Female', 'BSIT', '3rd', 4, 'IT-3121', '1st', '2017-2018', 0),
(44, '141-0376', 'ANGELES, VICTOR ABRAHAM A.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(45, '151-0289', 'BAGAYAN, DANREX A.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(46, '131-0096', 'BIGAL, ALEXISS D.', 'Male', 'BSIT', '4th', 5, 'IT-3121', '1st', '2017-2018', 0),
(47, '121-0313', 'BROZO, EDWARD S.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(48, '151-1347', 'CASIMIRO, REBMARK G.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(49, '151-0261', 'CLAUDEL, JERUZ E.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(50, '151-1343', 'DEL MUNDO, JEROME E.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(51, '151-0454', 'DIMACULANGAN, ARSENIO D.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(52, '141-0592', 'GARINGA, JEROME CRIS B.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(53, '151-1193', 'GEROSO, DENMARRK A.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(54, '151-0612', 'HIGUERRA, JOHN LERREY O.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(55, '131-0508', 'LASARA, MELVIN JOHN M.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(56, '151-0047', 'LOPEZ, CRISTIAN E.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(57, '141-1094', 'MACEDA, JAYSON S.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(58, '151-0448', 'MAYUGA, KYLE T.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(59, '141-0630', 'MOLIDOR, BRYAN T.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(60, '151-1190', 'MONFERO, JOHN CARLO A.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(61, '121-0047', 'OLIVETE, GENESIS S.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(62, '141-0151', 'ONIEZA, BENZ S.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(63, '151-0562', 'PADER, JAMES FRANCIS L.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(64, '151-1244', 'PE?ALOZA, JHUN MARTIN D.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(65, '151-0572', 'POMENTIL, MIKKO C.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(66, '151-1405', 'ROSEL, GINO L.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(67, '151-1406', 'SAN JOSE, KURT ROBIN A.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(68, '121-0324', 'VILLETA, TIRSO JR. A.', 'Male', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(69, '151-1253', 'AINZA, AILENE A.', 'Female', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(70, '151-0528', 'AQUINO, IRAKEY N.', 'Female', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(71, '151-0568', 'BALTAZAR, MA. ELLAINE L.', 'Female', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(72, '151-1228', 'DE LUNA, GHELIEZA M.', 'Female', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(73, '151-1388', 'DE LUNA, JENNALYN R.', 'Female', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(74, '151-0225', 'MONTEZA, PRINCESS JOY C.', 'Female', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(75, '151-1260', 'NEQUINTO, MARY JOY D.', 'Female', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(76, '151-0649', 'PACOMA, ERICKA L.', 'Female', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(77, '151-0331', 'PUNZALAN, PRINCESS BEA S.', 'Female', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(78, '141-0039', 'RAYA, GEMMA L.', 'Female', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(79, '141-1206', 'TEMPLO, DESIREE V.', 'Female', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0),
(80, '151-0254', 'VILLARANTE, MARJORIE L.', 'Female', 'BSIT', '3rd', 5, 'IT-3121', '1st', '2017-2018', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(50) NOT NULL,
  `No` int(11) NOT NULL,
  `Subject_Code` varchar(50) NOT NULL,
  `Subject_Description` varchar(50) NOT NULL,
  `ProfID` int(11) NOT NULL,
  `sem` varchar(50) NOT NULL,
  `ay` varchar(50) NOT NULL,
  `stat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `department`, `No`, `Subject_Code`, `Subject_Description`, `ProfID`, `sem`, `ay`, `stat`) VALUES
(1, 'TVL/ICT', 1024, 'CP 3', 'Computer Programming 3', 4, '1st', '2017-2018', 0),
(2, 'BSIT', 824, 'IT-3121', 'Network Management & Administration\n\n', 4, '1st', '2017-2018', 0),
(3, 'BSIT', 815, 'IT-3121', 'Network Management & Administration\n\n', 5, '1st', '2017-2018', 0);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_information`
--

CREATE TABLE IF NOT EXISTS `teacher_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `teacher_information`
--

INSERT INTO `teacher_information` (`id`, `First_Name`, `Last_Name`, `Username`, `Password`) VALUES
(4, 'Jerome', 'Dela Cruz', 'jerome', 'jerome'),
(5, 'Hannasheen Rikka', 'Soridor', 'hannasheen', 'hannasheen');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_submit_grade`
--

CREATE TABLE IF NOT EXISTS `teacher_submit_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sem` varchar(30) NOT NULL,
  `ay` varchar(50) NOT NULL,
  `profid` int(11) NOT NULL,
  `date` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
