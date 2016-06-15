-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2016 at 10:15 AM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nanodesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `aidas`
--

CREATE TABLE IF NOT EXISTS `aidas` (
  `id` int(11) NOT NULL,
  `paper_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `aida_option` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aidas`
--

INSERT INTO `aidas` (`id`, `paper_id`, `date`, `aida_option`, `description`) VALUES
(1, 1, '2016-01-14 03:52:50', 'Confirms', 'a'),
(2, 1, '2016-01-14 03:52:50', 'Refutes', 'b'),
(3, 1, '2016-01-14 03:52:50', 'option 3', 'c'),
(4, 2, '2016-01-14 03:54:57', 'Confirms', 'aaa'),
(5, 2, '2016-01-14 03:54:57', 'Refutes', 'bb'),
(6, 2, '2016-01-14 03:54:57', 'option 3', 'ccc'),
(7, 2, '2016-01-14 03:55:55', 'option 3', 'ddddddd'),
(8, 2, '2016-01-14 03:56:07', 'Confirms', 'ee'),
(9, 2, '2016-01-14 03:56:07', 'Confirms', 'ffff'),
(10, 3, '2016-01-14 04:02:55', 'Confirms', 'a'),
(11, 3, '2016-01-14 04:02:55', 'Refutes', 'b'),
(12, 3, '2016-01-14 04:02:55', 'Refutes', 'c'),
(13, 3, '2016-01-14 04:02:55', 'option 3', 'x'),
(14, 3, '2016-01-14 04:20:03', 'option 3', 'z'),
(15, 4, '2016-01-15 04:54:32', 'Confirms', ''),
(16, 4, '2016-01-15 04:54:32', 'Confirms', ''),
(17, 4, '2016-01-15 04:54:32', 'Confirms', ''),
(18, 4, '2016-01-15 04:54:32', 'Confirms', ''),
(19, 5, '2016-01-15 12:44:04', 'Confirms', 'aa'),
(20, 5, '2016-01-15 12:44:04', 'Refutes', 'bb'),
(21, 5, '2016-01-15 12:44:04', 'Confirms', 'cc'),
(22, 6, '2016-02-08 14:45:08', 'Confirms', ''),
(23, 7, '2016-02-09 02:36:58', 'Confirms', ''),
(24, 9, '2016-02-09 02:42:38', 'Confirms', '1234'),
(25, 9, '2016-02-09 10:25:27', 'Confirms', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE IF NOT EXISTS `logins` (
  `uid` varchar(54) NOT NULL,
  `sid` varchar(54) NOT NULL,
  `ip` text NOT NULL,
  `datum` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`uid`, `sid`, `ip`, `datum`) VALUES
('1', 'efa6d7653800c4fc23526438ee74d41a', '::1', '2015-12-14 23:50:26'),
('1', '826b67b9b325727f1776b91053473303', '::1', '2015-12-14 23:58:06'),
('1', 'cf49d48e5db93ce984630f9e1ceb606a', '::1', '2015-12-15 00:41:12'),
('1', '8eea46c9f739d953dd6f8bf9b33ca237', '::1', '2015-12-15 00:44:37'),
('1', '47368507e1dde9929c4491949f97e816', '::1', '2015-12-15 00:45:22'),
('1', 'd197627cb3af35ba3c1b41f612f18e00', '::1', '2015-12-15 00:46:33'),
('1', 'c042182584cada95ef1ec03b3ffa7e29', '::1', '2015-12-15 00:47:30'),
('1', '7eeb9cd7b32eb54980f19de762daeaff', '::1', '2015-12-15 00:50:10'),
('1', 'd971271de3288f7a8494746d8933405c', '::1', '2015-12-15 00:51:40'),
('1', '1944da7286a111be0861bce88b00ef3a', '::1', '2015-12-15 00:53:24'),
('1', 'dbf146a336b7f87bce691c6b067b1e0a', '::1', '2015-12-15 00:54:16'),
('1', '4e0d382738e836fb768c565a5fead840', '::1', '2015-12-15 00:55:46'),
('1', '4d0051c54849dcbc76a90a387d5dda23', '::1', '2015-12-15 00:56:33'),
('1', '0c8e7420e42cb88819cc687349a6a1e9', '::1', '2015-12-15 00:56:54'),
('1', 'b1b5647e7bb646aff61a8895a2d6f08f', '::1', '2015-12-15 00:57:19'),
('1', '5e0b57b1434ab2584a0ab14d99f3b135', '::1', '2015-12-15 00:57:41'),
('1', '053d22d6a0492de329bfa7fe964f7abd', '::1', '2015-12-15 00:58:18'),
('1', '602e834f811da7c6e1e846ff66d32950', '::1', '2015-12-15 00:58:52'),
('1', 'd9695a6ea79b5661ad0996be5dca2b06', '::1', '2015-12-15 00:59:20'),
('1', 'a329fbbd1c89bf2d256b7da7a16fde4a', '::1', '2015-12-15 01:00:30'),
('1', 'b11b2a8a7d3caac594f04e1f748fe6e7', '::1', '2015-12-15 01:01:05'),
('1', 'fdf61574f3fdfe1d3bde76e67464ba69', '::1', '2015-12-15 01:01:55'),
('1', 'b0ae47b521d892c639f6234d71876888', '::1', '2015-12-15 01:02:12'),
('1', '404dbc2459d6406e418eaef7468e8731', '::1', '2015-12-15 01:02:38'),
('1', '21030cb0d6d8acb27edc928ff28a5dcc', '::1', '2015-12-15 01:04:12'),
('1', '05f454b3a819d97a38c548117394f82f', '::1', '2015-12-15 01:08:21'),
('1', '8d09100f2724381f24520b2ad579f1af', '::1', '2015-12-15 01:10:28'),
('1', 'db0215f070361daff1199fa5ed9caa33', '::1', '2015-12-15 01:10:59'),
('1', '280aa5f540c9030fbdbd0dd8a88a5907', '::1', '2015-12-15 11:13:26'),
('1', '5e8ccc4ee4d21b5fe66f5f087c47bff1', '::1', '2016-01-09 18:20:15'),
('1', '150236dec290b3819a5f03a9d4c5f43f', '::1', '2016-01-13 09:45:24'),
('1', 'f08dad01008021b857bfb463aa02f1c1', '::1', '2016-01-18 17:59:49'),
('1', 'd3ba4cbc1db53a7c26cbaadcaba5c818', '::1', '2016-01-18 17:59:57'),
('1', 'e2e8232644a9fac922dfd318321e783b', '::1', '2016-01-18 18:01:55'),
('1', '34e5e8c6850b37472a01cda7dfe33281', '::1', '2016-01-18 18:02:03'),
('1', 'f18006011d574cbcfdecfa37b06b0de4', '::1', '2016-01-18 18:05:32'),
('1', '27fbe5416a55fdc787c70a7bd3288206', '::1', '2016-02-17 20:56:08'),
('1', 'c5e763440d9ecf3d396696e654f9a2b9', '::1', '2016-02-25 16:41:08'),
('1', 'f8ed9c8755c070a1b7d46c3ae7aa2e0f', '::1', '2016-03-09 00:52:10'),
('1', '0926c2db365e824957e21b3d78c6358f', '::1', '2016-05-11 01:19:32');

-- --------------------------------------------------------

--
-- Table structure for table `papers`
--

CREATE TABLE IF NOT EXISTS `papers` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `doi` text NOT NULL,
  `doi2` text NOT NULL,
  `doi_option` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `papers`
--

INSERT INTO `papers` (`id`, `date`, `user_id`, `doi`, `doi2`, `doi_option`) VALUES
(1, '2016-01-14 03:52:50', 1, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(2, '2016-01-14 03:54:57', 1, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(3, '2016-01-14 04:02:55', 1, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(4, '2016-01-15 04:54:32', 1, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(5, '2016-01-15 12:44:04', 1, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(6, '2016-02-08 14:45:09', 1, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(7, '2016-02-09 02:36:58', 1, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(8, '2016-02-09 02:41:20', 1, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(9, '2016-02-09 02:42:27', 1, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(10, '2016-02-09 10:29:13', 1, 'http://dx.doi.org/10.3233/ISU-2010-0613', '', ''),
(11, '2016-02-09 10:46:06', 1, 'http://dx.doi.org/10.3233/ISU-2010-0613', '', ''),
(12, '2016-02-16 15:56:07', 1, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(13, '2016-02-17 15:42:44', 1, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(14, '2016-02-17 15:47:47', 1, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(15, '2016-02-17 15:48:59', 1, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(16, '2016-02-17 15:54:41', 1, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(17, '2016-02-17 21:00:09', 1, '10.1016/j.is.2009.08.003', '', ''),
(18, '2016-02-18 02:15:08', 1, '10.1145/2531602.2531659', '', ''),
(19, '2016-05-11 15:00:53', 1, '10.1145/2531602.2531659', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users2`
--

CREATE TABLE IF NOT EXISTS `users2` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `orcid` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(54) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users2`
--

INSERT INTO `users2` (`id`, `date`, `orcid`, `email`, `password`, `username`) VALUES
(1, '2015-12-14 00:00:00', '0000-0000-0000-0000', 'test@test.com', '4028a0e356acc947fcd2bfbf00cef11e128d484a', 'Test Account 1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aidas`
--
ALTER TABLE `aidas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `papers`
--
ALTER TABLE `papers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users2`
--
ALTER TABLE `users2`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aidas`
--
ALTER TABLE `aidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `papers`
--
ALTER TABLE `papers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `users2`
--
ALTER TABLE `users2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
