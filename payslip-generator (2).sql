-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2025 at 09:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `payslip-generator`
--

-- --------------------------------------------------------

--
-- Table structure for table `employeedatapayroll`
--

CREATE TABLE `employeedatapayroll` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `rateNbc594` float DEFAULT NULL,
  `nbcDiff594` float DEFAULT NULL,
  `increment` float DEFAULT NULL,
  `grossSalary` float DEFAULT NULL,
  `absent` float DEFAULT NULL,
  `days` float DEFAULT NULL,
  `hours` float DEFAULT NULL,
  `minutes` float DEFAULT NULL,
  `deductedGrossSalary` float DEFAULT NULL,
  `withHoldingTax` float DEFAULT NULL,
  `totalGsisDeds` float DEFAULT NULL,
  `totalPagibigDeds` float DEFAULT NULL,
  `philHealthEmployeeShare` float DEFAULT NULL,
  `totalOtherDeds` float DEFAULT NULL,
  `totalDeds` float DEFAULT NULL,
  `pay1st` float DEFAULT NULL,
  `pay2nd` float DEFAULT NULL,
  `rtIns` float DEFAULT NULL,
  `employeesCompensation` float DEFAULT NULL,
  `philHealthGovernmentShare` float DEFAULT NULL,
  `pagibig` float DEFAULT NULL,
  `netSalary` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employeedatapayroll`
--

INSERT INTO `employeedatapayroll` (`id`, `name`, `position`, `rateNbc594`, `nbcDiff594`, `increment`, `grossSalary`, `absent`, `days`, `hours`, `minutes`, `deductedGrossSalary`, `withHoldingTax`, `totalGsisDeds`, `totalPagibigDeds`, `philHealthEmployeeShare`, `totalOtherDeds`, `totalDeds`, `pay1st`, `pay2nd`, `rtIns`, `employeesCompensation`, `philHealthGovernmentShare`, `pagibig`, `netSalary`, `created_at`) VALUES
(1, 'Angkua, Harris M.', 'Student Assistant', 5456, 456, 4654, 654, 654, 654, 654, 564, 654, 654, 654, 654, 654, 654, 5645, 4, 654, 564, 654, 654, 654, 654, '2025-10-04 06:37:42'),
(2, 'Joshua Garcia', 'Actor', 1, 21, 1, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 2, 12, 12, 12, 12, 1, 21, 21, 21, '2025-10-04 06:42:30');

-- --------------------------------------------------------

--
-- Table structure for table `employeedataremittance`
--

CREATE TABLE `employeedataremittance` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `witholdingTax` float DEFAULT NULL,
  `personalLifeRet` float DEFAULT NULL,
  `gsisSalaryLoan` float DEFAULT NULL,
  `gsisPolicyLoan` float DEFAULT NULL,
  `gfal` float DEFAULT NULL,
  `cpl` float DEFAULT NULL,
  `mpl` float DEFAULT NULL,
  `mplLite` float DEFAULT NULL,
  `emergencyLoan` float DEFAULT NULL,
  `totalGsisDeds` float DEFAULT NULL,
  `pagibigFundCont` float DEFAULT NULL,
  `pagibig2` float DEFAULT NULL,
  `multiPurpLoan` float DEFAULT NULL,
  `pagibigCalamityLoan` float DEFAULT NULL,
  `totalPagibigDeds` float DEFAULT NULL,
  `philHealth` float DEFAULT NULL,
  `disallowance` float DEFAULT NULL,
  `landbankSalaryLoan` float DEFAULT NULL,
  `earistCreditCoop` float DEFAULT NULL,
  `feu` float DEFAULT NULL,
  `mtslaSalaryLoan` float DEFAULT NULL,
  `esla` float DEFAULT NULL,
  `totalOtherDeds` float DEFAULT NULL,
  `totalDeds` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employeedataremittance`
--

INSERT INTO `employeedataremittance` (`id`, `name`, `position`, `witholdingTax`, `personalLifeRet`, `gsisSalaryLoan`, `gsisPolicyLoan`, `gfal`, `cpl`, `mpl`, `mplLite`, `emergencyLoan`, `totalGsisDeds`, `pagibigFundCont`, `pagibig2`, `multiPurpLoan`, `pagibigCalamityLoan`, `totalPagibigDeds`, `philHealth`, `disallowance`, `landbankSalaryLoan`, `earistCreditCoop`, `feu`, `mtslaSalaryLoan`, `esla`, `totalOtherDeds`, `totalDeds`, `created_at`) VALUES
(1, 'Angkua, Harris M.', 'Student Assistant', 64, 54, 654, 64, 4, 654, 654, 654, 64, 65, 456, 46, 654, 654, 654, 65, 456, 465, 465, 465, 465, 465, 465, 4, '2025-10-04 06:37:42'),
(2, 'Joshua Garcia', 'Actor', 21, 2, 12, 12, 12, 12, 12, 12, 12, 1, 21, 21, 21, 21, 2, 21, 21, 21, 21, 21, 21, 21, 21, 21, '2025-10-04 06:42:30');

-- --------------------------------------------------------

--
-- Table structure for table `payslip_history`
--

CREATE TABLE `payslip_history` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `department` varchar(100) NOT NULL,
  `months` varchar(255) NOT NULL,
  `download_time` datetime DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payslip_history`
--

INSERT INTO `payslip_history` (`id`, `file_name`, `employee_name`, `department`, `months`, `download_time`, `user_id`) VALUES
(1, 'payslip_BUNGAY,_JULY_2025.pdf', 'bungay', 'ADMIN', 'JULY', '2025-08-19 09:10:15', 0),
(2, 'payslip_DITAN,_JUNE_2025.pdf', 'ditan', 'ADMIN', 'JUNE,JULY,AUGUST', '2025-08-19 09:11:23', 0),
(3, 'payslip_MORALES,_APRIL_2025.pdf', 'amparo', 'AUXILLIARY', 'APRIL,MAY', '2025-08-19 09:12:38', 0),
(4, 'payslip_MORALES,_APRIL_2025.pdf', 'amparo', 'AUXILLIARY', 'APRIL,MAY,JUNE', '2025-08-19 09:13:09', 0),
(5, 'payslip_MORALES,_MARCH_2025.pdf', 'amparo', 'AUXILLIARY', 'MARCH,APRIL,MAY', '2025-08-19 09:13:45', 0),
(6, 'payslip_POTOTOY,_APRIL_2025.pdf', 'poto', 'ADMIN', 'APRIL,MAY,JUNE', '2025-08-19 09:14:39', 0),
(7, 'payslip_HAPITA,_APRIL_2025.pdf', 'hapita', 'ADMIN', 'APRIL,MAY', '2025-08-19 09:17:38', 0),
(8, 'payslip_DITAN,_MAY_2025.pdf', 'ditan', 'ADMIN', 'MAY', '2025-08-19 09:28:38', 0),
(9, 'payslip_DITAN,_MAY_2025.pdf', 'ditan', 'ADMIN', 'MAY,JUNE', '2025-08-19 09:29:02', 0),
(10, 'payslip_BUNGAY,_MARCH_2025.pdf', 'bungay', 'ADMIN', 'MARCH', '2025-08-19 09:32:51', 0),
(11, 'payslip_BUNGAY,_MARCH_2025.pdf', 'bungay', 'ADMIN', 'MARCH,APRIL', '2025-08-19 09:33:06', 0),
(12, 'payslip_BUNGAY,_MARCH_2025.pdf', 'bungay', 'ADMIN', 'MARCH,APRIL', '2025-08-19 09:33:22', 0),
(13, 'payslip_BUNGAY,_MARCH_2025.pdf', 'bungay', 'ADMIN', 'MARCH,APRIL,MAY', '2025-08-19 09:33:44', 0),
(14, 'payslip_DITAN,_JULY_2025.pdf', 'ditan', 'ADMIN', 'JULY', '2025-08-19 09:39:31', 0),
(15, 'payslip_DITAN,_JULY_2025.pdf', 'ditan', 'ADMIN', 'JULY,AUGUST', '2025-08-19 09:40:30', 0),
(16, 'payslip_DITAN,_JUNE_2025.pdf', 'ditan', 'ADMIN', 'JUNE,JULY,AUGUST', '2025-08-19 09:40:55', 0),
(17, 'payslip_DITAN,_JUNE_2025.pdf', 'ditan', 'ADMIN', 'JUNE,JULY,AUGUST', '2025-08-19 09:54:15', 0),
(18, 'payslip_BUNGAY,_JUNE_2025.pdf', 'bungay', 'ADMIN', 'JUNE,JULY,AUGUST', '2025-08-19 09:55:00', 0),
(19, 'payslip_MORALES,_APRIL_2025.pdf', 'ampa', 'AUXILLIARY', 'APRIL,MAY,JUNE', '2025-08-19 09:55:33', 0),
(20, 'payslip_MORALES,_APRIL_2025.pdf', 'ampa', 'AUXILLIARY', 'APRIL', '2025-08-19 09:55:50', 0),
(21, 'payslip_MORALES,_APRIL_2025.pdf', 'ampa', 'AUXILLIARY', 'APRIL,MAY', '2025-08-19 09:56:10', 0),
(22, 'payslip_DITAN,_JULY_2025.pdf', 'ditan', 'ADMIN', 'JULY', '2025-08-19 12:48:28', 0),
(23, 'payslip_VALENZUELA,_JULY_2025.pdf', 'VALEN', 'ADMIN', 'JULY', '2025-08-20 08:39:11', 0),
(24, 'payslip_PEREIRA,_AUGUST_2025.pdf', 'pereira', 'CAFA', 'AUGUST', '2025-08-20 09:46:46', 0),
(25, 'payslip_PEREIRA,_AUGUST_2025.pdf', 'pereira', 'CAFA', 'AUGUST', '2025-08-20 09:47:00', 0),
(26, 'payslip_PEREIRA,_JULY_2025.pdf', 'pereira', 'CAFA', 'JULY,AUGUST', '2025-08-20 09:47:27', 0),
(27, 'payslip_SAKAINO,_APRIL_2025.pdf', 'SAKAI', 'ADMIN', 'APRIL,MAY,JUNE', '2025-08-22 09:38:57', 0),
(28, 'payslip_SAKAINO,_JULY_2025.pdf', 'SAKAI', 'ADMIN', 'JULY', '2025-08-22 09:39:24', 0),
(29, 'payslip_MARFIL,_JUNE_2025.pdf', 'marfil', 'EXTENSION', 'JUNE,JULY,AUGUST', '2025-08-22 13:44:58', 0),
(30, 'payslip_SANCHEZ,_AUGUST_2025.pdf', 'SANCHEZ', 'N EMPLOYEE 3', 'AUGUST', '2025-08-27 09:23:34', 0),
(31, 'payslip_SANCHEZ,_JULY_2025.pdf', 'SANCHEZ', 'N EMPLOYEE 3', 'JULY', '2025-08-27 09:24:20', 0),
(32, 'payslip_SANCHEZ,_JUNE_2025.pdf', 'SANCHEZ', 'N EMPLOYEE 3', 'JUNE', '2025-08-27 09:26:03', 0),
(33, 'payslip_PUEBLA,_JUNE_2025.pdf', 'puebla', 'N EMPLOYEE 3', 'JUNE,JULY,AUGUST', '2025-08-27 16:41:36', 0),
(34, 'payslip_COSTALES,_JULY_2025.pdf', 'COSTALES', 'CAS', 'JULY,AUGUST', '2025-08-28 08:17:36', 0),
(35, 'payslip_MADDAGAN,_JUNE_2025.pdf', 'madda', 'CIT', 'JUNE,JULY,AUGUST', '2025-08-28 13:15:17', 0),
(36, 'payslip_MADDAGAN,_MAY_2025.pdf', 'madda', 'CIT', 'MAY', '2025-08-28 13:18:13', 0),
(37, 'payslip_JAVIER,_JUNE_2025.pdf', 'javier', 'TEMPO', 'JUNE', '2025-08-28 14:28:47', 0),
(38, 'payslip_JAVIER,_JULY_2025.pdf', 'javier', 'TEMPO', 'JULY', '2025-08-28 14:32:49', 0),
(39, 'payslip_JAVIER,_AUGUST_2025.pdf', 'javier', 'TEMPO', 'AUGUST', '2025-08-28 14:35:12', 0),
(40, 'payslip_VALENZUELA,_JULY_2025.pdf', 'ARCHIE', 'ADMIN', 'JULY', '2025-08-29 15:03:42', 0),
(41, 'payslip_BARBARONA,_JUNE_2025.pdf', 'DANICA', 'ADMIN', 'JUNE,JULY,AUGUST', '2025-09-02 09:16:18', 0),
(42, 'payslip_NUÃ‘EZ,_JUNE_2025.pdf', 'CARLYN', 'CAS', 'JUNE,JULY,AUGUST', '2025-09-02 09:20:08', 0),
(43, 'payslip_DOCTOR,_AUGUST_2025.pdf', 'DOCTOR', 'CAS', 'AUGUST', '2025-09-02 13:03:51', 0),
(44, 'payslip_SONIO,_JUNE_2025.pdf', 'SONIO', 'CED', 'JUNE,JULY,AUGUST', '2025-09-02 14:21:34', 0),
(45, 'payslip_GOMEZ,_JULY_2025.pdf', 'GOMEZ', 'CED', 'JULY,AUGUST', '2025-09-02 14:33:00', 0),
(46, 'payslip_ISLA,_AUGUST_2025.pdf', 'isla', 'CIT', 'AUGUST', '2025-09-02 17:25:01', 0),
(47, 'payslip_SALTORIO,_JUNE_2025.pdf', 'SALT', 'RESEARCH', 'JUNE,JULY,AUGUST', '2025-09-03 11:39:07', 0),
(48, 'payslip_SALTORIO,_JUNE_2025.pdf', 'SALTORIO', 'RESEARCH', 'JUNE,JULY,AUGUST', '2025-09-03 11:51:48', 0),
(49, 'payslip_SALTORIO,_JUNE_2025.pdf', 'SALT', 'RESEARCH', 'JUNE,JULY,AUGUST', '2025-09-03 11:52:47', 0),
(50, 'payslip_SALTORIO,_JUNE_2025.pdf', 'SALT', 'RESEARCH', 'JUNE,JULY,AUGUST', '2025-09-03 11:56:24', 0),
(51, 'payslip_SALTORIO,_JUNE_2025.pdf', 'SALT', 'RESEARCH', 'JUNE,JULY,AUGUST', '2025-09-03 11:57:16', 0),
(52, 'payslip_JAVIER,_JUNE_2025.pdf', 'JAVIER', 'TEMPO', 'JUNE,JULY,AUGUST', '2025-09-03 11:59:15', 0),
(53, 'payslip_JAVIER,_JUNE_2025.pdf', 'JAVIER', 'TEMPO', 'JUNE,JULY,AUGUST', '2025-09-03 11:59:15', 0),
(54, 'payslip_JAVIER,_JUNE_2025.pdf', 'JAVIER', 'TEMPO', 'JUNE,JULY,AUGUST', '2025-09-03 12:00:47', 0),
(55, 'payslip_ASIS,_JUNE_2025.pdf', 'ASIS', 'N EMPLOYEE 3', 'JUNE,JULY,AUGUST', '2025-09-04 13:05:38', 0),
(56, 'payslip_CASTILLO,_JUNE_2025.pdf', 'CASTILLO', 'ADMIN', 'JUNE,JULY,AUGUST', '2025-09-04 13:51:35', 0),
(57, 'payslip_MANOGUID,_JUNE_2025.pdf', 'manoguid', 'N EMPLOYEE 3', 'JUNE,JULY,AUGUST', '2025-09-05 08:03:47', 0),
(58, 'payslip_TOBIAS,_AUGUST_2025.pdf', 'tobia', 'CIT', 'AUGUST', '2025-09-05 10:22:26', 0),
(59, 'payslip_SABATE,_JULY_2025.pdf', 'sabate', 'N EMPLOYEE 3', 'JULY,AUGUST', '2025-09-08 09:25:14', 0),
(60, 'payslip_ABAD,_JULY_2025.pdf', 'abad', 'N EMPLOYEE 3', 'JULY', '2025-09-08 11:27:00', 0),
(61, 'payslip_DOMINGO,_AUGUST_2025.pdf', 'GERLYN', 'EXTENSION', 'AUGUST', '2025-09-10 09:22:58', 0),
(62, 'payslip_SANTOS,_JUNE_2025.pdf', 'SANTOS', 'CBA', 'JUNE,JULY,AUGUST', '2025-09-10 11:44:17', 0),
(63, 'payslip_SANTOS,_JUNE_2025.pdf', 'SANTOS', 'CBA', 'JUNE,JULY', '2025-09-10 11:54:48', 0),
(64, 'payslip_MAMACLAY,_JULY_2025.pdf', 'mamaclay', 'N EMPLOYEE 3', 'JULY,AUGUST,SEPTEMBER', '2025-09-15 10:59:54', 0),
(65, 'payslip_SALAZAR,_JULY_2025.pdf', 'salazar', 'N EMPLOYEE 3', 'JULY,AUGUST,SEPTEMBER', '2025-09-15 11:00:52', 0),
(66, 'payslip_BORJA,_SEPTEMBER_2025.pdf', 'BORJA', 'TEMPO', 'SEPTEMBER', '2025-09-15 14:00:35', 0),
(67, 'payslip_DINEROS,_SEPTEMBER_2025.pdf', 'DINEROS', 'CBA', 'SEPTEMBER', '2025-09-15 14:07:17', 0),
(68, 'payslip_CAPILI,_SEPTEMBER_2025.pdf', 'CAPILI', 'CAS', 'SEPTEMBER', '2025-09-16 08:39:28', 0),
(69, 'payslip_OCHOTORENA,_AUGUST_2025.pdf', 'OCHO', 'CBA', 'AUGUST', '2025-09-16 08:43:35', 0),
(70, 'payslip_OCHOTORENA,_AUGUST_2025.pdf', 'OCHO', 'CBA', 'AUGUST', '2025-09-16 08:44:05', 0),
(71, 'payslip_OCHOTORENA,_AUGUST_2025.pdf', 'OCHO', 'CBA', 'AUGUST', '2025-09-16 08:44:22', 0),
(72, 'payslip_MADDAGAN,_JULY_2025.pdf', 'madda', 'CIT', 'JULY,AUGUST,SEPTEMBER', '2025-09-16 14:24:01', 0),
(73, 'payslip_MADDAGAN,_JULY_2025.pdf', 'madda', 'CIT', 'JULY,AUGUST,SEPTEMBER', '2025-09-16 14:25:34', 0),
(74, 'payslip_DUYAN,_SEPTEMBER_2025.pdf', 'DUYAN', 'AUXILLIARY', 'SEPTEMBER', '2025-09-17 10:11:35', 0),
(75, 'payslip_DUYAN,_JULY_2025.pdf', 'DUYAN', 'AUXILLIARY', 'JULY,AUGUST,SEPTEMBER', '2025-09-17 10:12:50', 0),
(76, 'payslip_MAMARADLO,_APRIL_2025.pdf', 'MAMA', 'ADMIN', 'APRIL,MAY,JUNE', '2025-09-17 10:14:13', 0),
(77, 'payslip_MAMARADLO,_MARCH_2025.pdf', 'MAMA', 'ADMIN', 'MARCH,APRIL,MAY', '2025-09-17 10:15:12', 0),
(78, 'payslip_MORALES,_MAY_2025.pdf', 'MORALES', 'AUXILLIARY', 'MAY,JUNE,JULY', '2025-09-17 10:15:42', 0),
(79, 'payslip_DITAN,_MAY_2025.pdf', 'DITAN', 'ADMIN', 'MAY,JUNE,JULY', '2025-09-17 10:16:08', 0),
(80, 'payslip_BUNGAY,_JULY_2025.pdf', 'BUNGAY', 'ADMIN', 'JULY,AUGUST,SEPTEMBER', '2025-09-17 10:16:52', 0),
(81, 'payslip_BUNGAY,_JULY_2025.pdf', 'BUNGAY', 'ADMIN', 'JULY', '2025-09-17 10:17:10', 0),
(82, 'payslip_PAGALING,_SEPTEMBER_2025.pdf', 'pagaling', 'CBA', 'SEPTEMBER', '2025-09-17 15:46:38', 0),
(83, 'payslip_PAGALING,_SEPTEMBER_2025.pdf', 'pagaling', 'CBA', 'SEPTEMBER', '2025-09-17 15:48:41', 0),
(84, 'payslip_PAGALING,_SEPTEMBER_2025.pdf', 'pagaling', 'CBA', 'SEPTEMBER', '2025-09-17 15:49:02', 0),
(85, 'payslip_PAGALING,_SEPTEMBER_2025.pdf', 'pagaling', 'CBA', 'SEPTEMBER', '2025-09-17 15:49:24', 0),
(86, 'payslip_PAGALING,_SEPTEMBER_2025.pdf', 'pagaling', 'CBA', 'SEPTEMBER', '2025-09-17 15:49:40', 0),
(87, 'payslip_PAGALING,_JULY_2025.pdf', 'pagaling', 'CBA', 'JULY,AUGUST,SEPTEMBER', '2025-09-17 15:50:20', 0),
(88, 'payslip_PAGALING,_JULY_2025.pdf', 'pagaling', 'CBA', 'JULY,AUGUST,SEPTEMBER', '2025-09-17 15:50:21', 0),
(89, 'payslip_PAGALING,_SEPTEMBER_2025.pdf', 'pagaling', 'CBA', 'SEPTEMBER', '2025-09-17 15:50:48', 0),
(90, 'payslip_PAGALING,_JULY_2025.pdf', 'pagaling', 'CBA', 'JULY,AUGUST,SEPTEMBER', '2025-09-17 15:51:03', 0),
(91, 'payslip_PAGALING,_JULY_2025.pdf', 'pagaling', 'CBA', 'JULY,AUGUST,SEPTEMBER', '2025-09-17 15:51:28', 0),
(92, 'payslip_PAGALING,_SEPTEMBER_2025.pdf', 'pagaling', 'CBA', 'SEPTEMBER', '2025-09-17 15:51:45', 0),
(93, 'payslip_SAN_JULY_2025.pdf', 'DHA', 'CAS', 'JULY,AUGUST,SEPTEMBER', '2025-09-17 16:31:34', 0),
(94, 'payslip_NIETO,_SEPTEMBER_2025.pdf', 'NIETO', 'CAS', 'SEPTEMBER', '2025-09-18 10:24:13', 0),
(95, 'payslip_MORACA,_SEPTEMBER_2025.pdf', 'MORACA', 'CAS', 'SEPTEMBER', '2025-09-18 10:24:52', 0),
(96, 'payslip_CAPUCAO,_SEPTEMBER_2025.pdf', 'CAPUCAO', 'CIT', 'SEPTEMBER', '2025-09-18 10:25:42', 0),
(97, 'payslip_OLIVEROS,_SEPTEMBER_2025.pdf', 'OLI', 'CAS', 'SEPTEMBER', '2025-09-18 10:26:33', 0),
(98, 'payslip_BALAYAN,_SEPTEMBER_2025.pdf', 'BALA', 'CAS', 'SEPTEMBER', '2025-09-18 10:27:33', 0),
(99, 'payslip_POBLETE,_JULY_2025.pdf', 'poblete', 'TEMPO', 'JULY,AUGUST,SEPTEMBER', '2025-09-18 11:27:07', 0),
(100, 'payslip_MADDAGAN,_JULY_2025.pdf', 'MADD', 'CIT', 'JULY,AUGUST,SEPTEMBER', '2025-09-18 13:54:03', 0),
(101, 'payslip_SANCHEZ,_JULY_2025.pdf', 'SANCHEZ', 'N EMPLOYEE 3', 'JULY,AUGUST,SEPTEMBER', '2025-09-18 15:04:46', 0),
(102, 'payslip_BUSA,_JULY_2025.pdf', 'BUSA', 'TEMPO', 'JULY,AUGUST,SEPTEMBER', '2025-09-18 16:22:47', 0),
(103, 'payslip_CRUZ,_JUNE_2025.pdf', 'cruz', 'CBA', 'JUNE,JULY,AUGUST', '2025-09-19 09:46:08', 0),
(104, 'payslip_CRUZ,_SEPTEMBER_2025.pdf', 'cruz', 'CBA', 'SEPTEMBER', '2025-09-19 09:47:06', 0),
(105, 'payslip_CRUZ,_SEPTEMBER_2025.pdf', 'cruz', 'CBA', 'SEPTEMBER', '2025-09-19 10:31:57', 0),
(106, 'payslip_CRUZ,_SEPTEMBER_2025.pdf', 'cruz', 'CBA', 'SEPTEMBER', '2025-09-19 10:31:57', 0),
(107, 'payslip_CRUZ,_SEPTEMBER_2025.pdf', 'cruz', 'CBA', 'SEPTEMBER', '2025-09-19 10:31:57', 0),
(108, 'payslip_AGNAS._SEPTEMBER_2025.pdf', 'AGNAS', 'ADMIN', 'SEPTEMBER', '2025-09-19 13:23:14', 0),
(109, 'payslip_BARAL,_AUGUST_2025.pdf', 'baral', 'CEN', 'AUGUST,SEPTEMBER', '2025-09-19 15:18:04', 0),
(110, 'payslip_BARAL,_AUGUST_2025.pdf', 'baral', 'CEN', 'AUGUST,SEPTEMBER', '2025-09-19 15:19:04', 0),
(111, 'payslip_BARAL,_AUGUST_2025.pdf', 'BARAL', 'CEN', 'AUGUST,SEPTEMBER', '2025-09-23 09:31:47', 0),
(112, 'payslip_OCHOTORENA,_SEPTEMBER_2025.pdf', 'ocho', 'CBA', 'SEPTEMBER', '2025-09-24 13:24:18', 0),
(113, 'payslip_CELESTIAL,_JULY_2025.pdf', 'celestial', 'CBA', 'JULY,AUGUST,SEPTEMBER', '2025-09-24 14:21:47', 0),
(114, 'payslip_REBLANDO,_JULY_2025.pdf', 'reblando', 'CIT', 'JULY,AUGUST,SEPTEMBER', '2025-09-24 15:55:55', 0),
(115, 'payslip_PURIFICACION,_JULY_2025.pdf', 'ABIGAIL', 'N EMPLOYEE 3', 'JULY,AUGUST,SEPTEMBER', '2025-09-25 13:27:30', 0),
(116, 'payslip_PURIFICACION,_APRIL_2025.pdf', 'ABIGAIL', 'N EMPLOYEE 3', 'APRIL,MAY,JUNE', '2025-09-25 13:31:21', 0),
(117, 'payslip_DE_APRIL_2025.pdf', 'DIGNA', 'ADMIN', 'APRIL,MAY,JUNE', '2025-09-25 13:34:07', 0),
(118, 'payslip_DE_JULY_2025.pdf', 'DIGNA', 'ADMIN', 'JULY,AUGUST,SEPTEMBER', '2025-09-25 13:34:21', 0),
(119, 'payslip_DE_JANUARY_2025.pdf', 'DIGNA', 'ADMIN', 'JANUARY,FEBRUARY,MARCH', '2025-09-25 13:41:43', 0),
(120, 'payslip_DE_JANUARY_2025.pdf', 'DIGNA', 'ADMIN', 'JANUARY,FEBRUARY,MARCH', '2025-09-25 13:42:48', 0),
(121, 'payslip_DE_JANUARY_2025.pdf', 'DIGNA', 'ADMIN', 'JANUARY,FEBRUARY,MARCH', '2025-09-25 13:46:55', 0),
(122, 'payslip_DE_JANUARY_2025.pdf', 'DIGNA', 'ADMIN', 'JANUARY,FEBRUARY,MARCH', '2025-09-25 13:48:39', 0),
(123, 'payslip_MORALES,_JULY_2025.pdf', 'amp', 'AUXILLIARY', 'JULY,AUGUST', '2025-09-29 09:09:53', 0),
(124, 'payslip_MORALES,_JULY_2025.pdf', 'amp', 'AUXILLIARY', 'JULY,AUGUST,SEPTEMBER', '2025-09-29 09:13:15', 0),
(125, 'payslip_MORALES,_APRIL_2025.pdf', 'amp', 'AUXILLIARY', 'APRIL,MAY,JUNE', '2025-09-29 09:14:19', 0),
(126, 'payslip_MORALES,_APRIL_2025.pdf', 'amp', 'AUXILLIARY', 'APRIL,MAY,JUNE', '2025-09-29 09:14:41', 0),
(127, 'payslip_MORALES,_JUNE_2025.pdf', 'amp', 'AUXILLIARY', 'JUNE,JULY,AUGUST', '2025-09-29 09:15:10', 0),
(128, 'payslip_MORALES,_JULY_2025.pdf', 'amp', 'AUXILLIARY', 'JULY,AUGUST,SEPTEMBER', '2025-09-29 09:15:53', 0),
(129, 'payslip_MORALES,_JUNE_2025.pdf', 'amp', 'AUXILLIARY', 'JUNE,JULY,AUGUST', '2025-09-29 09:16:19', 0),
(130, 'payslip_MORALES,_APRIL_2025.pdf', 'amp', 'AUXILLIARY', 'APRIL,MAY,JUNE', '2025-09-29 09:17:03', 0),
(131, 'payslip_MORALES,_JULY_2025.pdf', 'amp', 'AUXILLIARY', 'JULY,AUGUST,SEPTEMBER', '2025-09-29 09:17:22', 0),
(132, 'payslip_MORALES,_MAY_2025.pdf', 'amp', 'AUXILLIARY', 'MAY,JUNE,JULY', '2025-09-29 09:18:07', 0),
(133, 'payslip_MAMARADLO,_JUNE_2025.pdf', 'rog', 'ADMIN', 'JUNE,JULY,AUGUST', '2025-09-29 09:23:38', 0),
(134, 'payslip_MAMARADLO,_MAY_2025.pdf', 'rog', 'ADMIN', 'MAY,JUNE,JULY', '2025-09-29 09:24:10', 0),
(135, 'payslip_BAUTISTA,_SEPTEMBER_2025.pdf', 'BAUTIS', 'CEN', 'SEPTEMBER', '2025-09-29 13:54:56', 0),
(136, 'payslip_BAUTISTA,_SEPTEMBER_2025.pdf', 'BAUT', 'CEN', 'SEPTEMBER', '2025-09-29 14:07:04', 0),
(137, 'payslip_BAUTISTA,_SEPTEMBER_2025.pdf', 'BAUTI', 'CEN', 'SEPTEMBER', '2025-09-29 14:08:12', 0),
(138, 'payslip_BAUTISTA,_SEPTEMBER_2025.pdf', 'BAUT', 'CEN', 'SEPTEMBER', '2025-09-29 14:08:44', 0),
(139, 'payslip_BAUTISTA,_SEPTEMBER_2025.pdf', 'BAUT', 'CEN', 'SEPTEMBER', '2025-09-29 14:09:28', 0),
(140, 'payslip_BAUTISTA,_SEPTEMBER_2025.pdf', 'BAUT', 'CEN', 'SEPTEMBER', '2025-09-29 14:10:13', 0),
(141, 'payslip_MAMARADLO,_JULY_2025.pdf', 'rog', 'ADMIN', 'JULY,AUGUST,SEPTEMBER', '2025-09-29 16:23:39', 0),
(142, 'payslip_MORALES,_JUNE_2025.pdf', 'amp', 'AUXILLIARY', 'JUNE,JULY,AUGUST', '2025-09-29 16:25:06', 0),
(143, 'payslip_MORALES,_JUNE_2025.pdf', 'amp', 'AUXILLIARY', 'JUNE,JULY,AUGUST', '2025-09-29 16:25:07', 0),
(144, 'payslip_TINGGA,_JULY_2025.pdf', 'ting', 'CBA', 'JULY,AUGUST,SEPTEMBER', '2025-10-01 16:03:33', 0),
(145, 'payslip_TINGGA,_JULY_2025.pdf', 'tingga', 'CBA', 'JULY,AUGUST,SEPTEMBER', '2025-10-01 16:05:27', 0),
(146, 'payslip_NUÃ‘EZ,_JULY_2025.pdf', 'carlyn', 'CAS', 'JULY,AUGUST,SEPTEMBER', '2025-10-01 16:06:21', 0),
(147, 'payslip_BAUTISTA,_JULY_2025.pdf', 'bautis', 'CEN', 'JULY,AUGUST,SEPTEMBER', '2025-10-01 16:07:12', 0),
(148, 'payslip_BAUTISTA,_JULY_2025.pdf', 'baut', 'CEN', 'JULY,AUGUST,SEPTEMBER', '2025-10-01 16:10:43', 0),
(149, 'payslip_NUÃ‘EZ,_MARCH_2025.pdf', 'DINA', 'CAS', 'MARCH,APRIL,MAY', '2025-10-01 17:18:00', 0),
(150, 'payslip_NUÃ‘EZ,_JUNE_2025.pdf', 'DINA', 'CAS', 'JUNE,JULY,AUGUST', '2025-10-01 17:18:25', 0),
(151, 'payslip_NUÃ‘EZ,_JULY_2025.pdf', 'DINA', 'CAS', 'JULY,AUGUST,SEPTEMBER', '2025-10-01 17:26:37', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employeedatapayroll`
--
ALTER TABLE `employeedatapayroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employeedataremittance`
--
ALTER TABLE `employeedataremittance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payslip_history`
--
ALTER TABLE `payslip_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employeedatapayroll`
--
ALTER TABLE `employeedatapayroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employeedataremittance`
--
ALTER TABLE `employeedataremittance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payslip_history`
--
ALTER TABLE `payslip_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
