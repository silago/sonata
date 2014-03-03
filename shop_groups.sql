-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Feb 24, 2014 at 05:26 PM
-- Server version: 5.1.66-0+squeeze1-log
-- PHP Version: 5.3.3-7+squeeze14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `insite_tehdom`
--

-- --------------------------------------------------------

--
-- Table structure for table `shop_groups`
--

CREATE TABLE IF NOT EXISTS `shop_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` tinytext NOT NULL,
  `parent_group_id` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `image` tinytext NOT NULL,
  `thumb` tinytext NOT NULL,
  `uri` tinytext NOT NULL,
  `description` text NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `position` int(10) NOT NULL,
  `md` tinytext NOT NULL,
  `mk` tinytext NOT NULL,
  `title` tinytext NOT NULL,
  PRIMARY KEY (`group_id`(255)),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `shop_groups`
--

INSERT INTO `shop_groups` (`id`, `group_id`, `parent_group_id`, `name`, `image`, `thumb`, `uri`, `description`, `hidden`, `position`, `md`, `mk`, `title`) VALUES
(1, 'f2e7e3e3-2cac-11e3-b4cb-3085a9ad2002', '0', 'Аудио видео', '', '', 'group1', '', 0, 0, '', '', ''),
(2, 'f7d8ffc2-2bca-11e3-805a-3085a9ad2002', 'f2e7e3e3-2cac-11e3-b4cb-3085a9ad2002', '3D Blu-Ray плеер', '', '', 'group2', '', 0, 1, '', '', ''),
(3, 'f7d8ffef-2bca-11e3-805a-3085a9ad2002', 'f7d8ffc2-2bca-11e3-805a-3085a9ad2002', 'LG', '', '', 'group3', '', 0, 2, '', '', ''),
(4, '9ef1d6e8-2bda-11e3-805a-3085a9ad2002', 'f7d8ffc2-2bca-11e3-805a-3085a9ad2002', 'PHILIPS', '', '', 'group4', '', 0, 4, '', '', ''),
(5, '32f8a535-2be6-11e3-805a-3085a9ad2002', 'f7d8ffc2-2bca-11e3-805a-3085a9ad2002', 'SAMSUNG', '', '', 'group5', '', 0, 6, '', '', ''),
(6, '32f8a546-2be6-11e3-805a-3085a9ad2002', 'f7d8ffc2-2bca-11e3-805a-3085a9ad2002', 'SONI', '', '', 'group6', '', 0, 8, '', '', ''),
(7, 'd75de791-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc2-2bca-11e3-805a-3085a9ad2002', 'TOSHIBA', '', '', 'group7', '', 0, 10, '', '', ''),
(8, 'f0caf53e-2b2f-11e3-8ef3-3085a9ad2002', 'f2e7e3e3-2cac-11e3-b4cb-3085a9ad2002', 'DVD', '', '', 'group8', '', 0, 13, '', '', ''),
(9, 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'f0caf53e-2b2f-11e3-8ef3-3085a9ad2002', 'DVD+Караоке', '', '', 'group9', '', 0, 14, '', '', ''),
(10, 'f0caf541-2b2f-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'BBK', '', '', 'group10', '', 0, 15, '', '', ''),
(11, 'd75de788-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'ERISSON', '', '', 'group11', '', 0, 17, '', '', ''),
(12, 'd75de789-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'FUSION', '', '', 'group12', '', 0, 19, '', '', ''),
(13, 'd75de78a-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'LG', '', '', 'group13', '', 0, 21, '', '', ''),
(14, 'd75de78b-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'MYSTERI', '', '', 'group14', '', 0, 23, '', '', ''),
(15, 'd75de78c-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'PHILIPS', '', '', 'group15', '', 0, 25, '', '', ''),
(16, 'd75de78d-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'PIONEER', '', '', 'group16', '', 0, 27, '', '', ''),
(17, 'd75de78e-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'SAMSUNG', '', '', 'group17', '', 0, 29, '', '', ''),
(18, 'd75de78f-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'SONY', '', '', 'group18', '', 0, 31, '', '', ''),
(19, 'd75de790-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'SUPRA', '', '', 'group19', '', 0, 33, '', '', ''),
(20, '32f8a553-2be6-11e3-805a-3085a9ad2002', 'f2e7e3e3-2cac-11e3-b4cb-3085a9ad2002', 'Домашний кинотеатр', '', '', 'group20', '', 0, 37, '', '', ''),
(21, '32f8a554-2be6-11e3-805a-3085a9ad2002', '32f8a553-2be6-11e3-805a-3085a9ad2002', 'LG', '', '', 'group21', '', 0, 38, '', '', ''),
(22, '32f8a556-2be6-11e3-805a-3085a9ad2002', '32f8a553-2be6-11e3-805a-3085a9ad2002', 'PHILIPS', '', '', 'group22', '', 0, 40, '', '', ''),
(23, '32f8a555-2be6-11e3-805a-3085a9ad2002', '32f8a553-2be6-11e3-805a-3085a9ad2002', 'SAMSUNG', '', '', 'group23', '', 0, 42, '', '', ''),
(24, '2af4bd3b-2bfc-11e3-805a-3085a9ad2002', 'f2e7e3e3-2cac-11e3-b4cb-3085a9ad2002', 'Музыкальный ценрт', '', '', 'group24', '', 0, 45, '', '', ''),
(25, '2af4bd3c-2bfc-11e3-805a-3085a9ad2002', '2af4bd3b-2bfc-11e3-805a-3085a9ad2002', 'LG', '', '', 'group25', '', 0, 46, '', '', ''),
(26, '2af4bd3d-2bfc-11e3-805a-3085a9ad2002', '2af4bd3b-2bfc-11e3-805a-3085a9ad2002', 'SAMSUNG', '', '', 'group26', '', 0, 48, '', '', ''),
(27, '3ae00f38-323d-11e3-85c9-3085a9ad2002', 'f2e7e3e3-2cac-11e3-b4cb-3085a9ad2002', 'Радио часы', '', '', 'group27', '', 0, 51, '', '', ''),
(28, '3ae00f39-323d-11e3-85c9-3085a9ad2002', '3ae00f38-323d-11e3-85c9-3085a9ad2002', 'ERISSON		', '', '', 'group28', '', 0, 52, '', '', ''),
(29, '3ae00f3a-323d-11e3-85c9-3085a9ad2002', '3ae00f38-323d-11e3-85c9-3085a9ad2002', 'HYUNDAI		', '', '', 'group29', '', 0, 54, '', '', ''),
(30, '3ae00f3b-323d-11e3-85c9-3085a9ad2002', '3ae00f38-323d-11e3-85c9-3085a9ad2002', 'PHILIPS', '', '', 'group30', '', 0, 56, '', '', ''),
(31, 'c5f78ac2-3244-11e3-85c9-3085a9ad2002', '3ae00f38-323d-11e3-85c9-3085a9ad2002', 'PHILIPS', '', '', 'group31', '', 0, 58, '', '', ''),
(32, '3ae00f3c-323d-11e3-85c9-3085a9ad2002', '3ae00f38-323d-11e3-85c9-3085a9ad2002', 'SUPRA', '', '', 'group32', '', 0, 60, '', '', ''),
(33, '3ae00f3d-323d-11e3-85c9-3085a9ad2002', '3ae00f38-323d-11e3-85c9-3085a9ad2002', 'VITEK		', '', '', 'group33', '', 0, 62, '', '', ''),
(34, '3696657c-314e-11e3-a2d2-3085a9ad2002', '0', 'Массажёры', '', '', 'group34', '', 0, 66, '', '', ''),
(35, '3696657d-314e-11e3-a2d2-3085a9ad2002', '3696657c-314e-11e3-a2d2-3085a9ad2002', 'SCARLETT', '', '', 'group35', '', 0, 67, '', '', ''),
(36, '44927af8-315d-11e3-a2d2-3085a9ad2002', '3696657c-314e-11e3-a2d2-3085a9ad2002', 'Ves', '', '', 'group36', '', 0, 69, '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
