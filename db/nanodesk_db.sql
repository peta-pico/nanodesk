-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 26, 2016 at 10:13 AM
-- Server version: 5.5.31
-- PHP Version: 5.5.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nanodesk_db`
--

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
('2', 'fa330c4f14e4c7c8b2cba5a9f30e2e77', '90.145.61.214', '2016-05-11 12:06:42'),
('2', 'ff68ebdc014fa85aef06a496f2b22690', '77.175.191.56', '2016-05-18 23:29:31'),
('2', '882c5858df96ac3bec579f0258854e60', '77.175.191.56', '2016-05-19 17:54:42'),
('2', 'a36db28fbf1c32456f33c63a6beb3131', '77.175.191.56', '2016-05-19 23:46:19');

-- --------------------------------------------------------

--
-- Table structure for table `nanousers`
--

CREATE TABLE IF NOT EXISTS `nanousers` (
  `id` int(11) NOT NULL,
  `orcid_id` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(54) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nanousers`
--

INSERT INTO `nanousers` (`id`, `orcid_id`, `date`, `email`, `password`, `username`) VALUES
(1, '', '2015-12-14 00:00:00', 'test@test.com', '4028a0e356acc947fcd2bfbf00cef11e128d484a', 'Test Account 1'),
(2, '0000-0003-3734-6091', '2016-04-28 16:11:08', '', '', 'Mitchel Austin'),
(3, '0000-0002-1267-0234', '2016-04-29 11:15:05', '', '', 'Tobias Kuhn');

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `papers`
--

INSERT INTO `papers` (`id`, `date`, `user_id`, `doi`, `doi2`, `doi_option`) VALUES
(1, '2015-12-15 01:53:01', 1, '0', 'http://', 'Confirms'),
(2, '2015-12-15 01:55:57', 1, '0', 'http://', 'Confirms'),
(3, '2015-12-15 01:58:47', 1, '0', 'http://', 'Confirms'),
(4, '2015-12-15 02:02:27', 1, '0', 'http://', 'Confirms'),
(5, '2015-12-15 02:03:57', 1, '0', 'http://', 'Confirms'),
(6, '2015-12-15 02:04:01', 1, '0', 'http://', 'Confirms'),
(7, '2015-12-15 02:07:33', 1, '0', 'http://', 'Confirms'),
(8, '2015-12-15 02:08:27', 1, '0', 'http://', 'Confirms'),
(9, '2015-12-15 02:09:34', 1, '0', 'http://', 'Confirms'),
(10, '2015-12-15 02:10:32', 1, '0', 'http://', 'Confirms'),
(11, '2015-12-15 02:35:48', 1, '0', 'http://', 'Confirms'),
(12, '2015-12-15 02:36:12', 1, 'http://', 'http://', 'Confirms'),
(13, '2016-04-29 11:21:53', 3, 'http://dx.doi.org/10.1145/2531602.2531659', '', ''),
(14, '2016-05-11 13:44:52', 2, '10.1145/2531602.2531659', '', ''),
(15, '2016-05-11 13:45:15', 2, '10.1145/2531602.2531659', '', ''),
(16, '2016-05-11 13:45:21', 2, '10.1145/2531602.2531659', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nanousers`
--
ALTER TABLE `nanousers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `papers`
--
ALTER TABLE `papers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nanousers`
--
ALTER TABLE `nanousers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `papers`
--
ALTER TABLE `papers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
