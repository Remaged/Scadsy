-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2014 at 09:44 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `scadsy_testschoola`
--
CREATE DATABASE IF NOT EXISTS `{DB_NAME}` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `{DB_NAME}`;

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `controller` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_module_id_AND_name_AND_controller` (`module_id`,`name`,`controller`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=199 ;

--
-- Dumping data for table `actions`
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
(196, 186, 'logout', 'login');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `classes_students`
--

CREATE TABLE IF NOT EXISTS `classes_students` (
  `student` int(11) NOT NULL,
  `class` varchar(100) NOT NULL,
  PRIMARY KEY (`student`,`class`),
  KEY `FK_STUDENT_CLASS_CLASS` (`class`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `classes_subjects`
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
-- Table structure for table `enrollments`
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
-- Table structure for table `ethnicities`
--

CREATE TABLE IF NOT EXISTS `ethnicities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ethnicities`
--

INSERT INTO `ethnicities` (`id`, `name`) VALUES
(1, 'Black, Non-Hispanic'),
(2, 'White, Non-Hispanic');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE IF NOT EXISTS `grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `grades`
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
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `UK_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'parent'),
(3, 'student'),
(4, 'teacher');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`) VALUES
(1, 'African'),
(2, 'English');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=188 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `directory`, `name`, `uri`, `description`, `version`, `author`, `author_uri`, `status`) VALUES
(183, 'module', 'Module', '', 'This module allows the school-admin to manage the modules inside the schoolsystem.', ' 1.0\r', '', '', 'enabled'),
(186, 'user', 'User', '', 'Handling user-information, login and logout', ' 1.0\r', 'Kevin Driessen', 'http://kevindriessen.nl', 'enabled'),
(187, 'welcome', 'Welcome', '', '', ' ', '', '', 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE IF NOT EXISTS `parents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `parents_students`
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
-- Table structure for table `permissions`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `permissions`
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
(24, 197, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
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
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('11787345dabff1bfc675754556242916', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36', 1398411780, 'a:2:{s:9:"user_data";s:0:"";s:2:"id";i:5;}');

-- --------------------------------------------------------

--
-- Table structure for table `students`
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
-- Table structure for table `subjects`
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
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `title`, `first_name`, `middle_name`, `last_name`, `username`, `password`, `email`, `phone_number`, `date_of_birth`, `gender`, `status`, `ethnicity_id`, `language_id`, `group_id`) VALUES
(5, 'Mr', 'admin', 'admin', 'admin', 'admin', '$2y$10$PlsdDXIY/PFCYklE0772auZd00At0fbjl0SZQclLFW31rfTsHzh82', 'admin@schools.scadsy.za.org', '234234234', '2014-03-19', 'male', 'enabled', NULL, NULL, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `FK_module_action_module` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classes_subjects`
--
ALTER TABLE `classes_subjects`
  ADD CONSTRAINT `FK_class_subject_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `FK_ENROLEMENT_INFORMATION_STUDENT_ID` FOREIGN KEY (`student`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `FK_PARENT_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parents_students`
--
ALTER TABLE `parents_students`
  ADD CONSTRAINT `FK_PARENTS_STUDENTS_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PARENTS_STUDENTS_student_id` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `FK_PERMISSIONS_action_id` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PERMISSIONS_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `FK_STUDENTS_grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_STUDENTS_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `FK_SUBJECTS_grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_USERS_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USERS_etnicity_id` FOREIGN KEY (`ethnicity_id`) REFERENCES `ethnicities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USERS_language_id` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
