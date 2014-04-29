-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Genereertijd: 29 apr 2014 om 13:31
-- Serverversie: 5.6.14
-- PHP-versie: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `scadsy_bay_wes`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=205 ;

--
-- Gegevens worden uitgevoerd voor tabel `actions`
--

INSERT INTO `actions` (`id`, `module_id`, `name`, `controller`) VALUES
(185, 183, 'disable', 'manage_modules'),
(184, 183, 'enable', 'manage_modules'),
(183, 183, 'index', 'manage_modules'),
(186, 183, 'install', 'manage_modules'),
(189, 183, 'permissions', 'manage_modules'),
(190, 183, 'permission_edit', 'manage_modules'),
(188, 183, 'save_modules', 'manage_modules'),
(187, 183, 'uninstall', 'manage_modules'),
(195, 186, 'index', 'login'),
(197, 186, 'index', 'registration'),
(196, 186, 'logout', 'login'),
(202, 189, 'index', 'dashboard'),
(203, 190, 'index', 'updates'),
(204, 190, 'install', 'updates');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `classes_students`
--

CREATE TABLE IF NOT EXISTS `classes_students` (
  `student` int(11) NOT NULL,
  `class` varchar(100) NOT NULL,
  PRIMARY KEY (`student`,`class`),
  KEY `FK_STUDENT_CLASS_CLASS` (`class`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `classes_subjects`
--

CREATE TABLE IF NOT EXISTS `classes_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `subject` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `enrollments`
--

CREATE TABLE IF NOT EXISTS `enrollments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `student` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ethnicities`
--

CREATE TABLE IF NOT EXISTS `ethnicities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `ethnicities`
--

INSERT INTO `ethnicities` (`id`, `name`) VALUES
(1, 'Black, Non-Hispanic'),
(2, 'White, Non-Hispanic');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `grades`
--

CREATE TABLE IF NOT EXISTS `grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Gegevens worden uitgevoerd voor tabel `grades`
--

INSERT INTO `grades` (`id`, `name`) VALUES
(1, 'Grade 1'),
(10, 'Grade 10'),
(11, 'Grade 11'),
(12, 'Grade 12'),
(2, 'Grade 2'),
(3, 'Grade 3'),
(4, 'Grade 4'),
(5, 'Grade 5'),
(6, 'Grade 6'),
(7, 'Grade 7'),
(8, 'Grade 8'),
(9, 'Grade 9');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `UK_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Gegevens worden uitgevoerd voor tabel `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'parent'),
(3, 'student'),
(4, 'teacher');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `languages`
--

INSERT INTO `languages` (`id`, `name`) VALUES
(1, 'African'),
(2, 'English');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=191 ;

--
-- Gegevens worden uitgevoerd voor tabel `modules`
--

INSERT INTO `modules` (`id`, `directory`, `name`, `uri`, `description`, `version`, `author`, `author_uri`, `status`) VALUES
(183, 'module', 'Module', '', 'This module allows the school-admin to manage the modules inside the schoolsystem.', ' 1.0\r', '', '', 'enabled'),
(186, 'user', 'User', '', 'Handling user-information, login and logout', ' 1.0\r', 'Kevin Driessen', 'http://kevindriessen.nl', 'enabled'),
(189, 'dashboard', 'Dashboard', '', 'This module enables the dashboard system.', ' 1.0\r', '-', '-', 'enabled'),
(190, 'update', 'Update Module', 'http://seoduct.com/update_module/', 'This is the update module. This module allowes you to let SCADSY update when there is a new version available. This way you don''t have to manually keep track of all the new versions. This plugin also allows plugins to be updated.', ' 1.0\r', 'Bob van den Berge', 'http://www.seoduct.com/', 'enabled');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `parents`
--

CREATE TABLE IF NOT EXISTS `parents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `parents_students`
--

CREATE TABLE IF NOT EXISTS `parents_students` (
  `student_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`student_id`,`parent_id`),
  KEY `FK_STUDENT_PARENT_PARENT` (`parent_id`),
  KEY `student_id` (`student_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Gegevens worden uitgevoerd voor tabel `permissions`
--

INSERT INTO `permissions` (`id`, `action_id`, `allowed`, `group_id`) VALUES
(8, 183, 1, 1),
(9, 184, 1, 1),
(10, 185, 1, 1),
(11, 186, 1, 1),
(12, 187, 1, 1),
(13, 188, 1, 1),
(14, 189, 1, 1),
(15, 190, 1, 1),
(22, 195, 1, 1),
(23, 196, 1, 1),
(24, 197, 1, 1),
(34, 202, 1, 1),
(35, 203, 1, 1),
(36, 204, 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `schools`
--

CREATE TABLE IF NOT EXISTS `schools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ceeb` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL,
  `city` varchar(150) NOT NULL,
  `state` varchar(150) NOT NULL,
  `zipcode` varchar(20) NOT NULL,
  `phone_number` varchar(40) NOT NULL,
  `principal` varchar(200) NOT NULL,
  `base_grading_scale` double NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_ceeb` (`ceeb`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
-- Tabelstructuur voor tabel `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alternate_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `grade_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UK_user_id` (`user_id`),
  KEY `grade_id` (`grade_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `grade_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_name` (`name`),
  KEY `grade_id` (`grade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `updates`
--

CREATE TABLE IF NOT EXISTS `updates` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(5) unsigned NOT NULL,
  `last_checked` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `has_update` tinyint(1) NOT NULL DEFAULT '0',
  `to_version` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`module_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Gegevens worden uitgevoerd voor tabel `updates`
--

INSERT INTO `updates` (`id`, `module_id`, `last_checked`, `has_update`, `to_version`) VALUES
(7, 0, '2014-04-29 11:28:20', 0, NULL),
(1, 183, '2014-04-29 11:28:20', 0, NULL),
(2, 186, '2014-04-29 11:28:20', 0, NULL),
(3, 187, '2014-04-29 11:28:20', 0, NULL),
(4, 188, '2014-04-29 11:28:20', 0, NULL),
(5, 189, '2014-04-29 11:28:20', 0, NULL),
(6, 190, '2014-04-29 11:28:20', 0, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` enum('Mr','Mrs','Ms') NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(40) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `status` enum('enabled','disabled') NOT NULL,
  `ethnicity_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_username` (`username`),
  KEY `ethnicity_id` (`ethnicity_id`),
  KEY `language_id` (`language_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Gegevens worden uitgevoerd voor tabel `users`
--

INSERT INTO `users` (`id`, `title`, `first_name`, `middle_name`, `last_name`, `username`, `password`, `email`, `phone_number`, `date_of_birth`, `gender`, `status`, `ethnicity_id`, `language_id`, `group_id`) VALUES
(5, 'Mr', 'admin', 'admin', 'admin', '{USERNAME}', '{PASSWORD}', '{EMAIL}', '234234234', '2014-03-19', 'male', 'enabled', NULL, NULL, 1);

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `FK_module_action_module` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `classes_subjects`
--
ALTER TABLE `classes_subjects`
  ADD CONSTRAINT `FK_class_subject_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `FK_ENROLEMENT_INFORMATION_STUDENT_ID` FOREIGN KEY (`student`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `FK_PARENT_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `parents_students`
--
ALTER TABLE `parents_students`
  ADD CONSTRAINT `FK_PARENTS_STUDENTS_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PARENTS_STUDENTS_student_id` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `FK_PERMISSIONS_action_id` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PERMISSIONS_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `FK_STUDENTS_grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_STUDENTS_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `FK_SUBJECTS_grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_USERS_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USERS_etnicity_id` FOREIGN KEY (`ethnicity_id`) REFERENCES `ethnicities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USERS_language_id` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
