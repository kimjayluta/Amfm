-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2018 at 02:39 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amfm`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(255) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `acct_type` enum('admin','developer','lending','client') NOT NULL DEFAULT 'client',
  `bin_active` tinyint(1) NOT NULL DEFAULT '0',
  `uni_active` tinyint(1) NOT NULL DEFAULT '0',
  `hash_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `pass`, `acct_type`, `bin_active`, `uni_active`, `hash_id`) VALUES
(1, 'jimboy1', 'snitch1', 'client', 1, 0, 'j1'),
(2, 'jimboy2', 'snitch2', 'client', 1, 0, 'j2'),
(3, 'jimboy3', 'snitch3', 'client', 1, 0, 'j3'),
(4, 'jimboy4', 'snitch4', 'client', 1, 0, 'j4'),
(5, 'jimboy5', 'snitch5', 'client', 1, 0, 'j5'),
(6, 'jimboy6', 'snitch6', 'client', 1, 0, 'j6'),
(7, 'jimboy7', 'snitch7', 'client', 1, 0, 'j7'),
(63, 'llupRisingll', 'mnycnajrad', 'client', 1, 0, '4048dda5ab392192924f3f2864bc08ca1539696121'),
(64, 'admin', 'admin', 'client', 0, 0, '5048dda5ab392192924f3f2864bc08ca1539696121'),
(65, 'test', 'test', 'client', 0, 0, '6048dda5ab392192924f3f2864bc08ca1539696121');

-- --------------------------------------------------------

--
-- Table structure for table `account_info`
--

CREATE TABLE `account_info` (
  `id` int(255) UNSIGNED NOT NULL,
  `fn` varchar(255) NOT NULL,
  `ln` varchar(255) NOT NULL,
  `ad` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `cn` varchar(255) NOT NULL,
  `accnt_id` int(255) UNSIGNED NOT NULL,
  `bdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_info`
--

INSERT INTO `account_info` (`id`, `fn`, `ln`, `ad`, `email`, `photo`, `cn`, `accnt_id`, `bdate`) VALUES
(13, 'Luis Edward', 'Miranda', 'Sipocot, Camarines Sur', 'luisedward.miranda@gmail.com', NULL, '09292709026', 63, '2018-10-15'),
(14, 'Jimmy Allan', 'Monserate', 'Zone 3, Baranggay Tambang Tinambac, 4426 Camarines Sur', 'monseratejimmyallan@gmail.com', '', ' 0999-7995-757/+852-5217-1401', 1, '2018-10-15'),
(15, 'Jimmy Allan', 'Monserate', 'Zone 3, Baranggay Tambang Tinambac, 4426 Camarines Sur', 'monseratejimmyallan@gmail.com', '', ' 0999-7995-757/+852-5217-1401', 2, '2018-10-15'),
(16, 'Jimmy Allan', 'Monserate', 'Zone 3, Baranggay Tambang Tinambac, 4426 Camarines Sur', 'monseratejimmyallan@gmail.com', '', ' 0999-7995-757/+852-5217-1401', 3, '2018-10-15'),
(17, 'Jimmy Allan', 'Monserate', 'Zone 3, Baranggay Tambang Tinambac, 4426 Camarines Sur', 'monseratejimmyallan@gmail.com', '', ' 0999-7995-757/+852-5217-1401', 4, '2018-10-15'),
(18, 'Jimmy Allan', 'Monserate', 'Zone 3, Baranggay Tambang Tinambac, 4426 Camarines Sur', 'monseratejimmyallan@gmail.com', '', ' 0999-7995-757/+852-5217-1401', 5, '2018-10-15'),
(19, 'Jimmy Allan', 'Monserate', 'Zone 3, Baranggay Tambang Tinambac, 4426 Camarines Sur', 'monseratejimmyallan@gmail.com', '', ' 0999-7995-757/+852-5217-1401', 6, '2018-10-15'),
(20, 'Jimmy Allan', 'Monserate', 'Zone 3, Baranggay Tambang Tinambac, 4426 Camarines Sur', 'monseratejimmyallan@gmail.com', '', ' 0999-7995-757/+852-5217-1401', 7, '2018-10-15');

-- --------------------------------------------------------

--
-- Table structure for table `binpath`
--

CREATE TABLE `binpath` (
  `anc` int(255) UNSIGNED NOT NULL,
  `desc` int(255) UNSIGNED NOT NULL,
  `lside` tinyint(1) NOT NULL DEFAULT '1',
  `parent` int(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `binpath`
--

INSERT INTO `binpath` (`anc`, `desc`, `lside`, `parent`) VALUES
(1, 1, 1, 1),
(1, 2, 1, 1),
(1, 3, 1, 1),
(1, 4, 1, 2),
(1, 5, 1, 2),
(1, 6, 1, 3),
(1, 7, 1, 3),
(2, 2, 1, 1),
(2, 4, 1, 2),
(2, 5, 1, 2),
(3, 3, 1, 1),
(3, 6, 1, 3),
(3, 7, 1, 3),
(4, 4, 1, 2),
(5, 5, 1, 2),
(6, 6, 1, 3),
(7, 7, 1, 3),
(63, 63, 1, 6),
(63, 64, 0, 63),
(63, 65, 1, 64),
(64, 64, 0, 63),
(64, 65, 1, 64),
(65, 65, 1, 64);

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `id` int(255) UNSIGNED NOT NULL,
  `monthly` date NOT NULL,
  `total_earn` int(255) UNSIGNED NOT NULL,
  `ref_id` int(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pending_binpath`
--

CREATE TABLE `pending_binpath` (
  `id` int(255) UNSIGNED NOT NULL,
  `invitee_id` int(255) UNSIGNED NOT NULL,
  `invitor_id` int(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pending_binpath`
--

INSERT INTO `pending_binpath` (`id`, `invitee_id`, `invitor_id`) VALUES
(2, 63, 7);

-- --------------------------------------------------------

--
-- Table structure for table `pending_requests`
--

CREATE TABLE `pending_requests` (
  `id` int(255) UNSIGNED NOT NULL,
  `user_id` int(255) UNSIGNED NOT NULL,
  `parent_id` int(255) UNSIGNED NOT NULL,
  `type` enum('binary','unilevel') DEFAULT 'binary'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unipath`
--

CREATE TABLE `unipath` (
  `anc` int(255) UNSIGNED NOT NULL,
  `desc` int(255) UNSIGNED NOT NULL,
  `parent` int(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uni_packg`
--

CREATE TABLE `uni_packg` (
  `tid` int(255) UNSIGNED NOT NULL,
  `packg_type` enum('b','s','g','d','v','p') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `account_info`
--
ALTER TABLE `account_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accnt_id` (`accnt_id`);

--
-- Indexes for table `binpath`
--
ALTER TABLE `binpath`
  ADD PRIMARY KEY (`anc`,`desc`) USING BTREE,
  ADD KEY `desc` (`desc`);

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ref_id` (`ref_id`);

--
-- Indexes for table `pending_binpath`
--
ALTER TABLE `pending_binpath`
  ADD PRIMARY KEY (`id`,`invitee_id`,`invitor_id`) USING BTREE,
  ADD KEY `invitee_id` (`invitee_id`),
  ADD KEY `invitor_id` (`invitor_id`);

--
-- Indexes for table `pending_requests`
--
ALTER TABLE `pending_requests`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_id_2` (`parent_id`);

--
-- Indexes for table `unipath`
--
ALTER TABLE `unipath`
  ADD PRIMARY KEY (`anc`,`desc`),
  ADD KEY `desc` (`desc`);

--
-- Indexes for table `uni_packg`
--
ALTER TABLE `uni_packg`
  ADD PRIMARY KEY (`tid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `account_info`
--
ALTER TABLE `account_info`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pending_binpath`
--
ALTER TABLE `pending_binpath`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pending_requests`
--
ALTER TABLE `pending_requests`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_info`
--
ALTER TABLE `account_info`
  ADD CONSTRAINT `account_info_ibfk_1` FOREIGN KEY (`accnt_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `binpath`
--
ALTER TABLE `binpath`
  ADD CONSTRAINT `binpath_ibfk_1` FOREIGN KEY (`anc`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `binpath_ibfk_2` FOREIGN KEY (`desc`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `earnings`
--
ALTER TABLE `earnings`
  ADD CONSTRAINT `earnings_ibfk_1` FOREIGN KEY (`ref_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pending_binpath`
--
ALTER TABLE `pending_binpath`
  ADD CONSTRAINT `pending_binpath_ibfk_1` FOREIGN KEY (`invitee_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `pending_binpath_ibfk_2` FOREIGN KEY (`invitor_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `pending_requests`
--
ALTER TABLE `pending_requests`
  ADD CONSTRAINT `pending_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pending_requests_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `unipath`
--
ALTER TABLE `unipath`
  ADD CONSTRAINT `unipath_ibfk_1` FOREIGN KEY (`anc`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `unipath_ibfk_2` FOREIGN KEY (`desc`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `uni_packg`
--
ALTER TABLE `uni_packg`
  ADD CONSTRAINT `uni_packg_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `pending_requests` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
