-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Genereertijd: 25 mrt 2014 om 09:38
-- Serverversie: 5.6.14
-- PHP-versie: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `{DB_NAME}`
--
CREATE DATABASE IF NOT EXISTS `{DB_NAME}` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `{DB_NAME}`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `class_subject`
--

CREATE TABLE IF NOT EXISTS `class_subject` (
  `class` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  PRIMARY KEY (`class`,`subject`),
  KEY `FK_CLASS_SUBJECT_SUBJECT` (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `enrollment_information`
--

CREATE TABLE IF NOT EXISTS `enrollment_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `student` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ethnicity`
--

CREATE TABLE IF NOT EXISTS `ethnicity` (
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`name`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `ethnicity`
--

INSERT INTO `ethnicity` (`name`) VALUES
('Black, Non-Hispanic'),
('White, Non-Hispanic');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `grade`
--

CREATE TABLE IF NOT EXISTS `grade` (
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `grade`
--

INSERT INTO `grade` (`name`) VALUES
('Grade 1'),
('Grade 2');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`name`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `group`
--

INSERT INTO `group` (`name`) VALUES
('admin'),
('parent'),
('student'),
('teacher');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`name`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `language`
--

INSERT INTO `language` (`name`) VALUES
('Dutch'),
('English');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `directory` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `uri` varchar(200) DEFAULT NULL,
  `description` text,
  `version` varchar(20) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `author_uri` varchar(200) DEFAULT NULL,
  `status` enum('enabled','disabled') NOT NULL DEFAULT 'disabled',
  PRIMARY KEY (`directory`),
  KEY `directory` (`directory`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `module`
--

INSERT INTO `module` (`directory`, `name`, `uri`, `description`, `version`, `author`, `author_uri`, `status`) VALUES
('attendance', ' Attendance monitor\r', ' http://seoduct.com/attendance_monitor/\r', ' This module allows teachers to monitor the attendance of students\r', ' 1.0\r', ' Bob van den Berge\r', ' http://www.seoduct.com/\r', 'disabled'),
('module', ' Module Manager\r', ' http://seoduct.com/module_manager/\r', ' This is a module manager.\r', ' 1.0', ' Bob van den Berge\r', ' http://www.seoduct.com/\r', 'enabled'),
('user', 'user', NULL, NULL, NULL, NULL, NULL, 'enabled'),
('welcome', 'welcome', NULL, NULL, NULL, NULL, NULL, 'enabled');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `module_action`
--

CREATE TABLE IF NOT EXISTS `module_action` (
  `name` varchar(100) NOT NULL,
  `module` varchar(100) NOT NULL,
  `controller` varchar(100) NOT NULL,
  PRIMARY KEY (`name`,`module`,`controller`),
  KEY `module` (`module`),
  KEY `controller` (`controller`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `module_action`
--

INSERT INTO `module_action` (`name`, `module`, `controller`) VALUES
('index', 'attendance', 'attendance'),
('index', 'attendance', 'scheme'),
('something', 'attendance', 'scheme'),
('index', 'module', 'module'),
('permissions', 'module', 'module'),
('index', 'user', 'login'),
('index', 'user', 'registration'),
('logout', 'user', 'login'),
('index', 'welcome', 'welcome');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `module_permission`
--

CREATE TABLE IF NOT EXISTS `module_permission` (
  `module` varchar(100) NOT NULL,
  `group` varchar(100) NOT NULL,
  PRIMARY KEY (`module`,`group`),
  KEY `FK_MODULE_PERMISSION_GROUP` (`group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `module_permission`
--

INSERT INTO `module_permission` (`module`, `group`) VALUES
('attendance', 'admin'),
('attendance', 'teacher');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `parent`
--

CREATE TABLE IF NOT EXISTS `parent` (
  `user` int(11) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `allowed` tinyint(1) NOT NULL,
  `module_action_name` varchar(100) NOT NULL,
  `module_action_module` varchar(100) NOT NULL,
  `module_action_controller` varchar(100) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  PRIMARY KEY (`module_action_name`,`module_action_module`,`module_action_controller`,`group_name`),
  KEY `FK_PERMISSION_MODULE_ACTION_MODULE` (`module_action_module`),
  KEY `FK_PERMISSION_GROUP` (`group_name`),
  KEY `FK_PERMISSION_MODULE_ACTION_CONTROLLER` (`module_action_controller`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `permission`
--

INSERT INTO `permission` (`allowed`, `module_action_name`, `module_action_module`, `module_action_controller`, `group_name`) VALUES
(1, 'index', 'attendance', 'attendance', 'admin'),
(1, 'index', 'attendance', 'scheme', 'admin'),
(1, 'index', 'module', 'module', 'admin'),
(0, 'index', 'module', 'module', 'student'),
(0, 'index', 'module', 'module', 'teacher'),
(1, 'index', 'user', 'login', 'admin'),
(1, 'index', 'user', 'login', 'parent'),
(1, 'index', 'user', 'login', 'school'),
(1, 'index', 'user', 'login', 'student'),
(1, 'index', 'user', 'login', 'teacher'),
(1, 'index', 'user', 'registration', 'admin'),
(0, 'index', 'user', 'registration', 'student'),
(0, 'index', 'user', 'registration', 'teacher'),
(1, 'index', 'welcome', 'welcome', 'admin'),
(1, 'index', 'welcome', 'welcome', 'parent'),
(1, 'index', 'welcome', 'welcome', 'school'),
(1, 'index', 'welcome', 'welcome', 'student'),
(1, 'index', 'welcome', 'welcome', 'teacher'),
(1, 'logout', 'user', 'login', 'admin'),
(1, 'logout', 'user', 'login', 'parent'),
(1, 'logout', 'user', 'login', 'school'),
(1, 'logout', 'user', 'login', 'student'),
(1, 'logout', 'user', 'login', 'teacher'),
(1, 'permissions', 'module', 'module', 'admin'),
(0, 'permissions', 'module', 'module', 'student'),
(0, 'permissions', 'module', 'module', 'teacher'),
(1, 'something', 'attendance', 'scheme', 'admin');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `school`
--

CREATE TABLE IF NOT EXISTS `school` (
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
  PRIMARY KEY (`ceeb`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

--
-- Gegevens worden uitgevoerd voor tabel `sessions`
--

INSERT INTO `sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('1277cb2199d92622e12cf4117ebe96ff', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36', 1395732476, ''),
('3183e572b152565a6e1c41fdfffdfd95', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36', 1395650582, 'a:1:{s:2:"id";s:1:"7";}'),
('56dd7f043e19940bd3731d119e33b185', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36', 1395647560, ''),
('5a3e7dbb0621f6ef474eefe0837558c0', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36', 1395651184, 'a:1:{s:9:"user_data";s:0:"";}'),
('eb61fa2a268b85453ad55c548d81e0d4', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36', 1395732453, '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alternate_id` int(11) DEFAULT NULL,
  `user` int(11) NOT NULL,
  `grade` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `grade` (`grade`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `student_class`
--

CREATE TABLE IF NOT EXISTS `student_class` (
  `student` int(11) NOT NULL,
  `class` varchar(100) NOT NULL,
  PRIMARY KEY (`student`,`class`),
  KEY `FK_STUDENT_CLASS_CLASS` (`class`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `student_parent`
--

CREATE TABLE IF NOT EXISTS `student_parent` (
  `student` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  PRIMARY KEY (`student`,`parent`),
  KEY `FK_STUDENT_PARENT_PARENT` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `name` varchar(100) NOT NULL,
  `grade` varchar(100) NOT NULL,
  PRIMARY KEY (`name`,`grade`),
  KEY `FK_COURSE_GRADE` (`grade`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
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
  `ethnicity` varchar(100) DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `group_key` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ethnicity` (`ethnicity`),
  KEY `language` (`language`),
  KEY `group` (`group_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Gegevens worden uitgevoerd voor tabel `user`
--

INSERT INTO `user` (`id`, `title`, `first_name`, `middle_name`, `last_name`, `username`, `password`, `email`, `phone_number`, `date_of_birth`, `gender`, `status`, `ethnicity`, `language`, `group_key`) VALUES
(5, 'Mr', 'admin', 'admin', 'admin', 'admin', '$2y$10$PlsdDXIY/PFCYklE0772auZd00At0fbjl0SZQclLFW31rfTsHzh82', 'bob@seoduct.com', '234234234', '2014-03-19', 'male', 'enabled', NULL, NULL, 'admin');

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `class_subject`
--
ALTER TABLE `class_subject`
  ADD CONSTRAINT `FK_CLASS_SUBJECT_CLASS` FOREIGN KEY (`class`) REFERENCES `class` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CLASS_SUBJECT_SUBJECT` FOREIGN KEY (`subject`) REFERENCES `subject` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `enrollment_information`
--
ALTER TABLE `enrollment_information`
  ADD CONSTRAINT `FK_ENROLEMENT_INFORMATION_STUDENT_ID` FOREIGN KEY (`student`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `module_action`
--
ALTER TABLE `module_action`
  ADD CONSTRAINT `FK_MODULE_ACTION_MODULE` FOREIGN KEY (`module`) REFERENCES `module` (`directory`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `module_permission`
--
ALTER TABLE `module_permission`
  ADD CONSTRAINT `FK_MODULE_PERMISSION_GROUP` FOREIGN KEY (`group`) REFERENCES `group` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_MODULE_PERMISSION_MODULE` FOREIGN KEY (`module`) REFERENCES `module` (`directory`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `parent`
--
ALTER TABLE `parent`
  ADD CONSTRAINT `FK_PARENT_USER_ID` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `FK_PERMISSION_GROUP` FOREIGN KEY (`group_name`) REFERENCES `group` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PERMISSION_MODULE_ACTION_MODULE` FOREIGN KEY (`module_action_module`) REFERENCES `module_action` (`module`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PERMISSION_MODULE_ACTION_NAME` FOREIGN KEY (`module_action_name`) REFERENCES `module_action` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PERMISSION_MODULE_ACTION_CONTROLLER` FOREIGN KEY (`module_action_controller`) REFERENCES `module_action` (`controller`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_STUDENT_GRADE` FOREIGN KEY (`grade`) REFERENCES `grade` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_STUDENT_USER` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `student_class`
--
ALTER TABLE `student_class`
  ADD CONSTRAINT `FK_STUDENT_CLASS_CLASS` FOREIGN KEY (`class`) REFERENCES `class` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_STUDENT_CLASS_STUDENT` FOREIGN KEY (`student`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `student_parent`
--
ALTER TABLE `student_parent`
  ADD CONSTRAINT `FK_STUDENT_PARENT_PARENT` FOREIGN KEY (`parent`) REFERENCES `parent` (`user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_STUDENT_PARENT_STUDENT` FOREIGN KEY (`student`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `FK_COURSE_GRADE` FOREIGN KEY (`grade`) REFERENCES `grade` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_USER_ETHNICITY` FOREIGN KEY (`ethnicity`) REFERENCES `ethnicity` (`name`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USER_GROUP` FOREIGN KEY (`group_key`) REFERENCES `group` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USER_LANGUAGE` FOREIGN KEY (`language`) REFERENCES `language` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
