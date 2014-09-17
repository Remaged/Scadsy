-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 17 sep 2014 om 12:01
-- Serverversie: 5.6.16
-- PHP-versie: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `scadsy`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `controller` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_module_id_AND_name_AND_controller` (`module_id`,`name`,`controller`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=304 ;

--
-- Gegevens worden geëxporteerd voor tabel `actions`
--

INSERT INTO `actions` (`id`, `module_id`, `name`, `controller`) VALUES
(242, 200, 'add', 'manage_users'),
(240, 200, 'delete', 'manage_users'),
(232, 200, 'disable', 'manage_modules'),
(243, 200, 'edit', 'manage_users'),
(231, 200, 'enable', 'manage_modules'),
(227, 200, 'index', 'login'),
(229, 200, 'index', 'manage_groups'),
(230, 200, 'index', 'manage_modules'),
(237, 200, 'index', 'manage_permissions'),
(239, 200, 'index', 'manage_users'),
(233, 200, 'install', 'manage_modules'),
(228, 200, 'logout', 'login'),
(238, 200, 'permission_edit', 'manage_permissions'),
(235, 200, 'refresh', 'manage_modules'),
(244, 200, 'save', 'manage_users'),
(236, 200, 'save_modules', 'manage_modules'),
(234, 200, 'uninstall', 'manage_modules'),
(241, 200, 'userlist', 'manage_users'),
(281, 211, 'check', 'monitor'),
(284, 211, 'overview', 'monitor'),
(283, 211, 'register_attendance', 'monitor'),
(282, 211, 'students', 'monitor'),
(285, 211, 'widget', 'monitor'),
(287, 212, 'exampleWidget', 'dashboard'),
(286, 212, 'index', 'dashboard');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=125 ;

--
-- Gegevens worden geëxporteerd voor tabel `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'parent'),
(3, 'student'),
(88, 'teacher'),
(5, 'user');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `groups_groups`
--

CREATE TABLE IF NOT EXISTS `groups_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_group_id` int(11) DEFAULT NULL,
  `parent_group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_parent_group_id_AND_child_group_id` (`child_group_id`,`parent_group_id`),
  KEY `parent_group_id` (`parent_group_id`),
  KEY `child_group_id` (`child_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=136 ;

--
-- Gegevens worden geëxporteerd voor tabel `groups_groups`
--

INSERT INTO `groups_groups` (`id`, `child_group_id`, `parent_group_id`) VALUES
(23, 1, 5),
(25, 2, 5),
(24, 3, 5),
(132, 88, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `groups_users`
--

CREATE TABLE IF NOT EXISTS `groups_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_group_id_AND_user_id` (`group_id`,`user_id`),
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=348 ;

--
-- Gegevens worden geëxporteerd voor tabel `groups_users`
--

INSERT INTO `groups_users` (`id`, `group_id`, `user_id`) VALUES
(1, 1, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `directory` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `uri` varchar(200) DEFAULT NULL,
  `description` text,
  `version` varchar(20) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `author_uri` varchar(200) DEFAULT NULL,
  `status` enum('not_installed','enabled','disabled') NOT NULL DEFAULT 'not_installed',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_directory` (`directory`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=217 ;

--
-- Gegevens worden geëxporteerd voor tabel `modules`
--

INSERT INTO `modules` (`id`, `directory`, `name`, `uri`, `description`, `version`, `author`, `author_uri`, `status`) VALUES
(200, 'base', 'Base', '', 'This module enables school-management for modules, permissions, groups, users', ' 1.0\r', 'Kevin Driessen, Bob van den Berge', '-', 'enabled'),
(211, 'attendance', 'Attendance', '', 'This module enables schools to register student attendance', ' 1.0\r', 'Bob van den Berge', '-', 'not_installed'),
(212, 'dashboard', 'Dashboard', '', 'This module enables the dashboard system.', ' 1.0\r', 'Bob van den Berge', '-', 'enabled');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_id` int(11) DEFAULT NULL,
  `allowed` tinyint(1) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_action_id_AND_group_id` (`action_id`,`group_id`),
  KEY `group_id` (`group_id`),
  KEY `action_id` (`action_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=481 ;

--
-- Gegevens worden geëxporteerd voor tabel `permissions`
--

INSERT INTO `permissions` (`id`, `action_id`, `allowed`, `group_id`) VALUES
(27, NULL, 1, 1),
(364, 227, 1, 1),
(365, 228, 1, 1),
(366, 229, 1, 1),
(367, 230, 1, 1),
(368, 231, 1, 1),
(369, 232, 1, 1),
(370, 233, 1, 1),
(371, 234, 1, 1),
(372, 235, 1, 1),
(373, 236, 1, 1),
(374, 237, 1, 1),
(375, 238, 1, 1),
(376, 239, 1, 1),
(377, 240, 1, 1),
(378, 241, 1, 1),
(379, 242, 1, 1),
(380, 243, 1, 1),
(381, 244, 1, 1),
(400, 227, 1, NULL),
(401, 227, 1, 88),
(405, 227, 1, 2),
(406, 227, 1, 3),
(407, 227, 1, 5),
(426, 281, 1, 1),
(427, 281, 1, NULL),
(428, 281, 1, 88),
(429, 281, 1, 2),
(430, 281, 1, 3),
(431, 281, 1, 5),
(432, 282, 1, 1),
(433, 282, 1, NULL),
(434, 282, 1, 88),
(435, 282, 1, 2),
(436, 282, 1, 3),
(437, 282, 1, 5),
(438, 283, 1, 1),
(439, 283, 1, NULL),
(440, 283, 1, 88),
(441, 283, 1, 2),
(442, 283, 1, 3),
(443, 283, 1, 5),
(444, 284, 1, 1),
(445, 284, 1, NULL),
(446, 284, 1, 88),
(447, 284, 1, 2),
(448, 284, 1, 3),
(449, 284, 1, 5),
(450, 285, 1, 1),
(451, 285, 1, NULL),
(452, 285, 1, 88),
(453, 285, 1, 2),
(454, 285, 1, 3),
(455, 285, 1, 5),
(456, 286, 1, 1),
(457, 287, 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(40) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female') NOT NULL,
  `status` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=301 ;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `email`, `phone_number`, `date_of_birth`, `gender`, `status`) VALUES
(5, '{FIRST_NAME}', '{LAST_NAME}', '{USERNAME}', '{PASSWORD}', '{EMAIL}', '{PHONE_NUMBER}', '{DATE_OF_BIRTH}', '{GENDER}', 'enabled');

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `FK_module_action_module` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `groups_groups`
--
ALTER TABLE `groups_groups`
  ADD CONSTRAINT `FK_GROUPS_GROUPS_group_id` FOREIGN KEY (`child_group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_GROUPS_GROUPS_related_group_id` FOREIGN KEY (`parent_group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `groups_users`
--
ALTER TABLE `groups_users`
  ADD CONSTRAINT `FK_GROUPS_USERS_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_GROUPS_USERS_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `FK_PERMISSIONS_action_id` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PERMISSIONS_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
