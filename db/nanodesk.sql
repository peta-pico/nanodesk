-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Gegenereerd op: 15 dec 2015 om 02:39
-- Serverversie: 5.6.25
-- PHP-versie: 5.6.11

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
-- Tabelstructuur voor tabel `logins`
--

CREATE TABLE IF NOT EXISTS `logins` (
  `uid` varchar(54) NOT NULL,
  `sid` varchar(54) NOT NULL,
  `ip` text NOT NULL,
  `datum` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `logins`
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
('1', 'db0215f070361daff1199fa5ed9caa33', '::1', '2015-12-15 01:10:59');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `papers`
--

CREATE TABLE IF NOT EXISTS `papers` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `doi` text NOT NULL,
  `doi2` text NOT NULL,
  `doi_option` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `papers`
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
(12, '2015-12-15 02:36:12', 1, 'http://', 'http://', 'Confirms');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users2`
--

CREATE TABLE IF NOT EXISTS `users2` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(54) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users2`
--

INSERT INTO `users2` (`id`, `date`, `email`, `password`, `username`) VALUES
(1, '2015-12-14 00:00:00', 'test@test.com', '4028a0e356acc947fcd2bfbf00cef11e128d484a', 'Test Account 1');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `papers`
--
ALTER TABLE `papers`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users2`
--
ALTER TABLE `users2`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `papers`
--
ALTER TABLE `papers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT voor een tabel `users2`
--
ALTER TABLE `users2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
