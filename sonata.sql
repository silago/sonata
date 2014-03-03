-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 28, 2014 at 05:26 PM
-- Server version: 5.5.35-MariaDB-log
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sonata`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `link` varchar(300) NOT NULL,
  `logo` varchar(120) NOT NULL,
  `descript` text NOT NULL,
  `show_on_main` int(2) unsigned NOT NULL DEFAULT '0',
  `show` int(2) unsigned NOT NULL DEFAULT '1',
  `position` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `position` (`position`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `title`, `link`, `logo`, `descript`, `show_on_main`, `show`, `position`) VALUES
(1, 'Samsung', 'http://samsung.ru', 'Samsung.jpg', '', 0, 1, NULL),
(2, 'LG', 'http://lg.ru', 'LG.png', '', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `catalog`
--

CREATE TABLE IF NOT EXISTS `catalog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ownerId` int(10) unsigned NOT NULL,
  `title` tinytext NOT NULL,
  `photo` tinytext NOT NULL,
  `redirect` tinytext,
  `smallText` text,
  `fullText` longtext,
  `techInformation` text,
  `addedPhoto` text,
  `assignParam1` tinytext,
  `assignParam2` tinytext,
  `assignParam3` tinytext,
  `assignParam4` tinytext,
  `price` tinytext,
  `lang` tinytext,
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  `titleup` text,
  `mk` text,
  `md` text,
  `hi` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cataloggroups`
--

CREATE TABLE IF NOT EXISTS `cataloggroups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ownerId` int(10) unsigned NOT NULL DEFAULT '0',
  `title` tinytext NOT NULL,
  `pageTitle` tinytext NOT NULL,
  `photo` tinytext NOT NULL,
  `template` tinytext NOT NULL,
  `navigationShow` enum('y','n') NOT NULL DEFAULT 'y',
  `navigationMainTitle` tinytext NOT NULL,
  `md` tinytext NOT NULL,
  `mk` tinytext NOT NULL,
  `lang` tinytext,
  `position` int(10) unsigned DEFAULT NULL,
  `redirect` tinytext,
  `descript` text,
  `title_nav` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `category` tinytext,
  `type` tinytext,
  `name` tinytext,
  `value` text,
  `description` text,
  `lang` tinytext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`category`, `type`, `name`, `value`, `description`, `lang`) VALUES
('main', 'api', 'projectTitle', 'New', 'Название сайта (title)', 'ru'),
('modules', 'news', 'defaultTemplate', 'inner.html', NULL, 'ru'),
('modules', 'news', 'md', '', NULL, 'ru'),
('modules', 'news', 'mk', '', NULL, 'ru'),
('modules', 'news', 'commentNews', 'true', NULL, 'ru'),
('modules', 'news', 'commentNewsPreMod', 'true', NULL, 'ru'),
('modules', 'page', 'defaultTemplate', 'inner.html', NULL, 'ru'),
('modules', 'page', 'md', '', NULL, 'ru'),
('modules', 'page', 'mk', '', NULL, 'ru'),
('modules', 'fb', 'defaultTemplate', 'inner.html', NULL, 'ru'),
('modules', 'fb', 'md', '', NULL, 'ru'),
('modules', 'fb', 'mk', '', NULL, 'ru'),
('modules', 'fb', 'sendEmailTo', 'test@mail.ru', NULL, 'ru'),
('modules', 'fb', 'fromEmail', 'test@mail.ru', NULL, 'ru'),
('main', 'api', 'HeaderContacts', '<span>confShow(headerContacts)</span>', 'Контакты в шапке', 'ru'),
('main', 'api', 'copyrights', '<a href="http://in-site.ru" target="_blank">Разработка сайтов</a> - In-site', 'In-site&copy;', 'ru'),
('modules', 'faq', 'defaultTemplate', '', NULL, 'ru'),
('modules', 'faq', 'md', '', NULL, 'ru'),
('modules', 'faq', 'mk', '', NULL, 'ru'),
('modules', 'gallery', 'defaultTemplate', '', NULL, 'ru'),
('modules', 'gallery', 'md', '', NULL, 'ru'),
('modules', 'gallery', 'mk', '', NULL, 'ru'),
('modules', 'gallery', 'uploadImageGroupDir', 'userfiles/gallery/group/', NULL, 'ru'),
('modules', 'gallery', 'uploadImageThumbDir', 'userfiles/gallery/thumb/', NULL, 'ru'),
('modules', 'gallery', 'uploadImagePreviewDir', 'userfiles/gallery/mid/', NULL, 'ru'),
('modules', 'gallery', 'uploadImageBigDir', 'userfiles/gallery/big/', NULL, 'ru'),
('modules', 'gallery', 'limitsImageGroup', '180 180', NULL, 'ru'),
('modules', 'gallery', 'limitsImageThumb', '150 150', NULL, 'ru'),
('modules', 'gallery', 'limitsImageBig', '1024 768', NULL, 'ru'),
('modules', 'gallery', 'adminListColumns', '4', NULL, 'ru'),
('modules', 'catalog', 'addPhotoBigHeight', '800', NULL, 'ru'),
('modules', 'catalog', 'addPhotoBigWidth', '1100', NULL, 'ru'),
('modules', 'catalog', 'addPhotoSmallHeight', '100', NULL, 'ru'),
('modules', 'catalog', 'addPhotoSmallWidth', '100', NULL, 'ru'),
('modules', 'catalog', 'bigMaxWidth', '800', NULL, 'ru'),
('modules', 'catalog', 'bigMaxHegiht', '1100', NULL, 'ru'),
('modules', 'catalog', 'notSoBigMaxHegiht', '300', NULL, 'ru'),
('modules', 'catalog', 'notSoBigMaxWidth', '180', NULL, 'ru'),
('modules', 'catalog', 'groupImageMaxHeight', '1100', NULL, 'ru'),
('modules', 'catalog', 'groupImageMaxWidth', '1100', NULL, 'ru'),
('modules', 'catalog', 'mk', '', NULL, 'ru'),
('modules', 'catalog', 'waterMark', '', NULL, 'ru'),
('modules', 'catalog', 'defaultTemplate', 'item.html', NULL, 'ru'),
('modules', 'catalog', 'md', '', NULL, 'ru'),
('modules', 'brands', 'logoDir', 'userfiles/image/brand/', NULL, 'ru'),
('modules', 'brands', 'logoWidth', '130', NULL, 'ru'),
('modules', 'brands', 'logoHeight', '60', NULL, 'ru'),
('modules', 'catalog', 'countOfItems', '200000', NULL, 'ru'),
('modules', 'security', 'userType', 'Отображать поля для Физических лиц', NULL, 'ru'),
('modules', 'basket', 'defTemplate', 'catalog.html', NULL, 'ru'),
('modules', 'basket', 'MD', '', NULL, 'ru'),
('modules', 'basket', 'MK', '', NULL, 'ru'),
('modules', 'basket', 'MT', '', NULL, 'ru'),
('modules', 'basket', 'useCountOfItems', 'Нет', NULL, 'ru'),
('modules', 'basket', 'countOfItems', 'Количества товаров в позициях', NULL, 'ru'),
('modules', 'orders', 'defTemplate', 'basket.html', NULL, 'ru'),
('modules', 'security', 'defTemplate', 'basket.html', NULL, 'ru'),
('modules', 'security', 'userType', 'Отображать поля для Физических лиц', NULL, 'ru'),
('modules', 'catalog', 'groupsTemplate', 'catalog.html', NULL, 'ru'),
('modules', 'catalog', 'itemsTemplate', 'catalog.html', NULL, 'ru'),
('modules', 'catalog', 'mainShow', 'Новинки', NULL, 'ru'),
('modules', 'catalog', 'md', '', NULL, 'ru'),
('modules', 'catalog', 'mk', '', NULL, 'ru'),
('modules', 'catalog', 'mt', '', NULL, 'ru'),
('modules', 'fb', 'defTemplate', 'item.html', NULL, 'ru'),
('modules', 'fb', 'MD', '', NULL, 'ru'),
('modules', 'fb', 'MK', '', NULL, 'ru'),
('modules', 'fb', 'MT', '', NULL, 'ru'),
('modules', 'fb', 'emailFrom', 'kvmang@yahoo.com', NULL, 'ru'),
('modules', 'fb', 'emailTo', 'kvmang@yahoo.com', NULL, 'ru'),
('modules', 'fb', 'MD', '', NULL, 'ru'),
('modules', 'fb', 'MK', '', NULL, 'ru'),
('modules', 'fb', 'MT', '', NULL, 'ru'),
('modules', 'fb', 'MD', '', NULL, 'ru'),
('modules', 'fb', 'MK', '', NULL, 'ru'),
('modules', 'fb', 'MT', '', NULL, 'ru'),
('modules', 'fb', 'MD', '', NULL, 'ru'),
('modules', 'fb', 'MK', '', NULL, 'ru'),
('modules', 'fb', 'MT', '', NULL, 'ru'),
('modules', 'fb', 'MD', '', NULL, 'ru'),
('modules', 'fb', 'MK', '', NULL, 'ru'),
('modules', 'fb', 'MT', '', NULL, 'ru'),
('modules', 'fb', 'MD', '', NULL, 'ru'),
('modules', 'fb', 'MK', '', NULL, 'ru'),
('modules', 'fb', 'MT', '', NULL, 'ru'),
('modules', 'basket', 'MD', '', NULL, 'ru'),
('modules', 'basket', 'MK', '', NULL, 'ru'),
('modules', 'basket', 'MT', '', NULL, 'ru'),
('modules', 'catalog', 'groupsTemplate', 'catalog.html', NULL, 'ru'),
('modules', 'catalog', 'itemsTemplate', 'catalog.html', NULL, 'ru'),
('modules', 'catalog', 'mainShow', 'Новинки', NULL, 'ru'),
('modules', 'catalog', 'md', '', NULL, 'ru'),
('modules', 'catalog', 'mk', '', NULL, 'ru'),
('modules', 'catalog', 'mt', '', NULL, 'ru'),
('modules', 'catalog', 'groupsTemplate', 'catalog.html', NULL, 'ru'),
('modules', 'catalog', 'itemsTemplate', 'catalog.html', NULL, 'ru'),
('modules', 'catalog', 'mainShow', 'Новинки', NULL, 'ru'),
('modules', 'catalog', 'md', '', NULL, 'ru'),
('modules', 'catalog', 'mk', '', NULL, 'ru'),
('modules', 'catalog', 'mt', '', NULL, 'ru'),
('modules', 'basket', 'MD', '', NULL, 'ru'),
('modules', 'basket', 'MK', '', NULL, 'ru'),
('modules', 'basket', 'MT', '', NULL, 'ru'),
('modules', 'slider', 'uploadImageDir', 'userfiles/image/slider/', NULL, 'ru'),
('modules', 'slider', 'limitsImage', '754 350', NULL, 'ru'),
('modules', 'slider', 'imagequality', '100', NULL, 'ru');

-- --------------------------------------------------------

--
-- Table structure for table `countriesCcTable`
--

CREATE TABLE IF NOT EXISTS `countriesCcTable` (
  `ci` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `cc` char(2) NOT NULL DEFAULT '',
  `cn` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`ci`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=241 ;

--
-- Dumping data for table `countriesCcTable`
--

INSERT INTO `countriesCcTable` (`ci`, `cc`, `cn`) VALUES
(1, 'AU', 'Australia\n'),
(2, 'MY', 'Malaysia\n'),
(3, 'KR', 'Korea'),
(4, 'CN', 'China\n'),
(5, 'JP', 'Japan\n'),
(6, 'IN', 'India\n'),
(7, 'TW', 'Taiwan\n'),
(8, 'HK', 'Hong Kong\n'),
(9, 'TH', 'Thailand\n'),
(10, 'VN', 'Vietnam\n'),
(11, 'FR', 'France\n'),
(12, 'IT', 'Italy\n'),
(13, 'AE', 'United Arab Emirates\n'),
(14, 'IL', 'Israel\n'),
(15, 'SE', 'Sweden\n'),
(16, 'KZ', 'Kazakhstan\n'),
(17, 'PT', 'Portugal\n'),
(18, 'GR', 'Greece\n'),
(19, 'SA', 'Saudi Arabia\n'),
(20, 'RU', 'Russian Federation\n'),
(21, 'GB', 'United Kingdom\n'),
(22, 'DK', 'Denmark\n'),
(23, 'US', 'United States\n'),
(24, 'CA', 'Canada\n'),
(25, 'MX', 'Mexico\n'),
(26, 'BM', 'Bermuda\n'),
(27, 'PR', 'Puerto Rico\n'),
(28, 'VI', 'Virgin Islands'),
(29, 'DE', 'Germany\n'),
(30, 'IR', 'Iran'),
(31, 'BO', 'Bolivia\n'),
(32, 'MS', 'Montserrat\n'),
(33, 'NL', 'Netherlands\n'),
(34, 'AP', 'Asia/Pacific Region\n'),
(35, 'SG', 'Singapore\n'),
(36, 'ES', 'Spain\n'),
(37, 'BS', 'Bahamas\n'),
(38, 'VC', 'Saint Vincent and the Grenadines\n'),
(39, 'CL', 'Chile\n'),
(40, 'NC', 'New Caledonia\n'),
(41, 'AR', 'Argentina\n'),
(42, 'DM', 'Dominica\n'),
(43, 'NP', 'Nepal\n'),
(44, 'PH', 'Philippines\n'),
(45, 'ID', 'Indonesia\n'),
(46, 'PK', 'Pakistan\n'),
(47, 'TK', 'Tokelau\n'),
(48, 'NZ', 'New Zealand\n'),
(49, 'KH', 'Cambodia\n'),
(50, 'MO', 'Macau\n'),
(51, 'PG', 'Papua New Guinea\n'),
(52, 'MV', 'Maldives\n'),
(53, 'AF', 'Afghanistan\n'),
(54, 'BD', 'Bangladesh\n'),
(55, 'IE', 'Ireland\n'),
(56, 'BE', 'Belgium\n'),
(57, 'BZ', 'Belize\n'),
(58, 'BR', 'Brazil\n'),
(59, 'CH', 'Switzerland\n'),
(60, 'ZA', 'South Africa\n'),
(61, 'EG', 'Egypt\n'),
(62, 'NG', 'Nigeria\n'),
(63, 'TZ', 'Tanzania'),
(64, 'ZM', 'Zambia\n'),
(65, 'SN', 'Senegal\n'),
(66, 'NA', 'Namibia\n'),
(67, 'CI', 'Cote D''Ivoire\n'),
(68, 'GH', 'Ghana\n'),
(69, 'SD', 'Sudan\n'),
(70, 'CM', 'Cameroon\n'),
(71, 'MW', 'Malawi\n'),
(72, 'AO', 'Angola\n'),
(73, 'KE', 'Kenya\n'),
(74, 'GA', 'Gabon\n'),
(75, 'ML', 'Mali\n'),
(76, 'BJ', 'Benin\n'),
(77, 'MG', 'Madagascar\n'),
(78, 'TD', 'Chad\n'),
(79, 'BW', 'Botswana\n'),
(80, 'LY', 'Libyan Arab Jamahiriya\n'),
(81, 'CV', 'Cape Verde\n'),
(82, 'RW', 'Rwanda\n'),
(83, 'MZ', 'Mozambique\n'),
(84, 'GM', 'Gambia\n'),
(85, 'LS', 'Lesotho\n'),
(86, 'MU', 'Mauritius\n'),
(87, 'CG', 'Congo\n'),
(88, 'UG', 'Uganda\n'),
(89, 'BF', 'Burkina Faso\n'),
(90, 'SL', 'Sierra Leone\n'),
(91, 'SO', 'Somalia\n'),
(92, 'ZW', 'Zimbabwe\n'),
(93, 'CD', 'Congo'),
(94, 'NE', 'Niger\n'),
(95, 'CF', 'Central African Republic\n'),
(96, 'SZ', 'Swaziland\n'),
(97, 'TG', 'Togo\n'),
(98, 'GN', 'Guinea\n'),
(99, 'LR', 'Liberia\n'),
(100, 'SC', 'Seychelles\n'),
(101, 'MA', 'Morocco\n'),
(102, 'DZ', 'Algeria\n'),
(103, 'MR', 'Mauritania\n'),
(104, 'DJ', 'Djibouti\n'),
(105, 'A2', 'Satellite Provider\n'),
(106, 'KM', 'Comoros\n'),
(107, 'RE', 'Reunion\n'),
(108, 'GQ', 'Equatorial Guinea\n'),
(109, 'TN', 'Tunisia\n'),
(110, 'TR', 'Turkey\n'),
(111, 'AT', 'Austria\n'),
(112, 'PL', 'Poland\n'),
(113, 'LV', 'Latvia\n'),
(114, 'UA', 'Ukraine\n'),
(115, 'BY', 'Belarus\n'),
(116, 'CZ', 'Czech Republic\n'),
(117, 'PS', 'Palestinian Territory'),
(118, 'IS', 'Iceland\n'),
(119, 'CY', 'Cyprus\n'),
(120, 'HU', 'Hungary\n'),
(121, 'SK', 'Slovakia\n'),
(122, 'MK', 'Macedonia\n'),
(123, 'LU', 'Luxembourg\n'),
(124, 'NO', 'Norway\n'),
(125, 'EE', 'Estonia\n'),
(126, 'FI', 'Finland\n'),
(127, 'JO', 'Jordan\n'),
(128, 'AZ', 'Azerbaijan\n'),
(129, 'RS', 'Serbia\n'),
(130, 'BG', 'Bulgaria\n'),
(131, 'OM', 'Oman\n'),
(132, 'RO', 'Romania\n'),
(133, 'BH', 'Bahrain\n'),
(134, 'GE', 'Georgia\n'),
(135, 'SY', 'Syrian Arab Republic\n'),
(136, 'MT', 'Malta\n'),
(137, 'AM', 'Armenia\n'),
(138, 'AL', 'Albania\n'),
(139, 'SI', 'Slovenia\n'),
(140, 'EU', 'Europe\n'),
(141, 'PA', 'Panama\n'),
(142, 'BN', 'Brunei Darussalam\n'),
(143, 'LK', 'Sri Lanka\n'),
(144, 'ME', 'Montenegro\n'),
(145, 'TJ', 'Tajikistan\n'),
(146, 'IQ', 'Iraq\n'),
(147, 'LB', 'Lebanon\n'),
(148, 'MD', 'Moldova'),
(149, 'BA', 'Bosnia and Herzegovina\n'),
(150, 'KW', 'Kuwait\n'),
(151, 'AX', 'Aland Islands\n'),
(152, 'LT', 'Lithuania\n'),
(153, 'AG', 'Antigua and Barbuda\n'),
(154, 'SM', 'San Marino\n'),
(155, 'FK', 'Falkland Islands (Malvinas)\n'),
(156, 'UZ', 'Uzbekistan\n'),
(157, 'MC', 'Monaco\n'),
(158, 'HT', 'Haiti\n'),
(159, 'GU', 'Guam\n'),
(160, 'JM', 'Jamaica\n'),
(161, 'UM', 'United States Minor Outlying Islands\n'),
(162, 'FM', 'Micronesia'),
(163, 'EC', 'Ecuador\n'),
(164, 'CO', 'Colombia\n'),
(165, 'PE', 'Peru\n'),
(166, 'KY', 'Cayman Islands\n'),
(167, 'HN', 'Honduras\n'),
(168, 'AN', 'Netherlands Antilles\n'),
(169, 'YE', 'Yemen\n'),
(170, 'VG', 'Virgin Islands'),
(171, 'NI', 'Nicaragua\n'),
(172, 'DO', 'Dominican Republic\n'),
(173, 'GD', 'Grenada\n'),
(174, 'GT', 'Guatemala\n'),
(175, 'CR', 'Costa Rica\n'),
(176, 'SV', 'El Salvador\n'),
(177, 'VE', 'Venezuela\n'),
(178, 'BB', 'Barbados\n'),
(179, 'TT', 'Trinidad and Tobago\n'),
(180, 'BV', 'Bouvet Island\n'),
(181, 'MH', 'Marshall Islands\n'),
(182, 'CK', 'Cook Islands\n'),
(183, 'GI', 'Gibraltar\n'),
(184, 'PY', 'Paraguay\n'),
(185, 'A1', 'Anonymous Proxy\n'),
(186, 'WS', 'Samoa\n'),
(187, 'KN', 'Saint Kitts and Nevis\n'),
(188, 'FJ', 'Fiji\n'),
(189, 'UY', 'Uruguay\n'),
(190, 'MP', 'Northern Mariana Islands\n'),
(191, 'PW', 'Palau\n'),
(192, 'QA', 'Qatar\n'),
(193, 'AS', 'American Samoa\n'),
(194, 'TC', 'Turks and Caicos Islands\n'),
(195, 'LC', 'Saint Lucia\n'),
(196, 'MN', 'Mongolia\n'),
(197, 'VA', 'Holy See (Vatican City State)\n'),
(198, 'LA', 'Lao People''s Democratic Republic\n'),
(199, 'AW', 'Aruba\n'),
(200, 'GY', 'Guyana\n'),
(201, 'SR', 'Suriname\n'),
(202, 'IM', 'Isle of Man\n'),
(203, 'VU', 'Vanuatu\n'),
(204, 'HR', 'Croatia\n'),
(205, 'KP', 'Korea'),
(206, 'AI', 'Anguilla\n'),
(207, 'PM', 'Saint Pierre and Miquelon\n'),
(208, 'GP', 'Guadeloupe\n'),
(209, 'MF', 'Saint Martin\n'),
(210, 'GG', 'Guernsey\n'),
(211, 'BI', 'Burundi\n'),
(212, 'TM', 'Turkmenistan\n'),
(213, 'KG', 'Kyrgyzstan\n'),
(214, 'MM', 'Myanmar\n'),
(215, 'BT', 'Bhutan\n'),
(216, 'LI', 'Liechtenstein\n'),
(217, 'FO', 'Faroe Islands\n'),
(218, 'ET', 'Ethiopia\n'),
(219, 'MQ', 'Martinique\n'),
(220, 'JE', 'Jersey\n'),
(221, 'AD', 'Andorra\n'),
(222, 'AQ', 'Antarctica\n'),
(223, 'IO', 'British Indian Ocean Territory\n'),
(224, 'GL', 'Greenland\n'),
(225, 'GW', 'Guinea-Bissau\n'),
(226, 'ER', 'Eritrea\n'),
(227, 'WF', 'Wallis and Futuna\n'),
(228, 'PF', 'French Polynesia\n'),
(229, 'CU', 'Cuba\n'),
(230, 'TO', 'Tonga\n'),
(231, 'TL', 'Timor-Leste\n'),
(232, 'ST', 'Sao Tome and Principe\n'),
(233, 'GF', 'French Guiana\n'),
(234, 'SB', 'Solomon Islands\n'),
(235, 'TV', 'Tuvalu\n'),
(236, 'KI', 'Kiribati\n'),
(237, 'NU', 'Niue\n'),
(238, 'NF', 'Norfolk Island\n'),
(239, 'NR', 'Nauru\n'),
(240, 'YT', 'Mayotte\n');

-- --------------------------------------------------------

--
-- Table structure for table `countriesLongIpTable`
--

CREATE TABLE IF NOT EXISTS `countriesLongIpTable` (
  `start` int(10) unsigned NOT NULL DEFAULT '0',
  `end` int(10) unsigned NOT NULL DEFAULT '0',
  `ci` tinyint(3) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `date` date DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT NULL,
  `lang` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_groups`
--

CREATE TABLE IF NOT EXISTS `gallery_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `owner` int(11) NOT NULL DEFAULT '0',
  `thumb` tinytext NOT NULL,
  `template` tinytext NOT NULL,
  `navigation_show` enum('y','n') NOT NULL,
  `navigation_title` tinytext NOT NULL,
  `md` tinytext,
  `mk` tinytext,
  `lang` tinytext NOT NULL,
  `position` int(10) unsigned NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE IF NOT EXISTS `gallery_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `owner` int(10) unsigned DEFAULT '0',
  `filename` tinytext NOT NULL,
  `description` tinytext NOT NULL,
  `md` tinytext,
  `mk` tinytext,
  `views` int(10) unsigned DEFAULT '0',
  `lang` tinytext NOT NULL,
  `position` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `title`) VALUES
(1, 'Горизонтальное меню'),
(2, 'Покупателям'),
(4, 'Мой профиль'),
(5, 'Left');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `order` int(10) NOT NULL,
  `title` text NOT NULL,
  `uri` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=343 ;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `item_id`, `parent_id`, `order`, `title`, `uri`) VALUES
(122, 2, 4, 0, 2, 'Возврат и обмен', '/vozvrat-i-obmen/'),
(123, 2, 5, 0, 3, 'Полезные статьи', '/poleznye-stati/'),
(121, 2, 2, 0, 1, 'Доставка и оплата', '/dostavka-i-oplata/'),
(120, 2, 1, 0, 0, 'Ваш размер', '/tablitsy-razmerov/'),
(59, 4, 1, 0, 0, 'Авторизация', '/login/'),
(60, 4, 2, 0, 1, 'Создать учетную запись', '/register/'),
(284, 1, 2, 0, 1, 'О компании', '/o-kompanii/'),
(285, 1, 30, 0, 2, 'Доставка и оплата', '/dostavka-i-oplata/'),
(283, 1, 31, 0, 0, 'Главная', '/glavnaja/'),
(286, 1, 32, 0, 3, 'Гарантия', '/garantija/'),
(287, 1, 33, 0, 4, 'Вакансии', '/vakansii/'),
(288, 1, 5, 0, 5, 'Контакты', '/kontakty/'),
(335, 5, 20, 18, 1, 'SAMSUNG', '/group26'),
(334, 5, 19, 18, 0, 'LG', '/group25'),
(333, 5, 18, 1, 2, 'Музыкальный ценрт', '/group24'),
(332, 5, 17, 14, 2, 'SAMSUNG', '/group23'),
(331, 5, 16, 14, 1, 'PHILIPS', '/group22'),
(330, 5, 15, 14, 0, 'LG', '/group21'),
(329, 5, 14, 1, 1, 'Домашний кинотеатр', '/group20'),
(328, 5, 13, 3, 9, 'SUPRA', '/group19'),
(327, 5, 12, 3, 8, 'SONY', '/group18'),
(326, 5, 11, 3, 7, 'SAMSUNG', '/group17'),
(325, 5, 10, 3, 6, 'PIONEER', '/group16'),
(324, 5, 9, 3, 5, 'PHILIPS', '/group15'),
(323, 5, 8, 3, 4, 'MYSTERI', '/group14'),
(322, 5, 7, 3, 3, 'LG', '/group13'),
(321, 5, 6, 3, 2, 'FUSION', '/group12'),
(320, 5, 5, 3, 1, 'ERISSON', '/group11'),
(319, 5, 4, 3, 0, 'BBK', '/group10'),
(318, 5, 3, 2, 0, 'DVD+Караоке', '/group9'),
(317, 5, 2, 1, 0, 'DVD', '/group8'),
(316, 5, 1, 0, 0, 'Аудио видео', '/group1'),
(336, 5, 21, 1, 3, 'Радио часы', '/group27'),
(337, 5, 22, 21, 0, 'ERISSON		', '/group28'),
(338, 5, 23, 21, 1, 'HYUNDAI		', '/group29'),
(339, 5, 24, 21, 2, 'PHILIPS', '/group30'),
(340, 5, 25, 21, 3, 'PHILIPS', '/group31'),
(341, 5, 26, 21, 4, 'SUPRA', '/group32'),
(342, 5, 27, 21, 5, 'VITEK		', '/group33');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ownerId` int(10) unsigned NOT NULL DEFAULT '0',
  `title` tinytext,
  `uri` text NOT NULL,
  `date` date NOT NULL DEFAULT '1970-01-01',
  `template` tinytext,
  `navigationShow` enum('y','n') DEFAULT NULL,
  `navigationMainTitle` tinytext,
  `smallText` text,
  `fullText` text NOT NULL,
  `md` tinytext,
  `mk` tinytext,
  `lang` tinytext,
  `pageTitle` tinytext,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `ownerId`, `title`, `uri`, `date`, `template`, `navigationShow`, `navigationMainTitle`, `smallText`, `fullText`, `md`, `mk`, `lang`, `pageTitle`, `status`) VALUES
(1, 1, 'Весь  май 2013 г.  – при покупке в подарок дисконтная карта!', 'aktsija-1', '2013-04-01', '', NULL, NULL, '<p>Весь май 2013 г. &ndash; при покупке в подарок дисконтная карта &laquo;Белая нерпа&raquo;-5%, &laquo;Золотая нерпа&raquo;&ndash; 15%. <a class="akciya" href="/images/akciya.jpg"> <img src="/images/akciya_min.jpg" alt="" /> </a></p>', '<p>Весь май 2013 г. &ndash; при покупке в подарок дисконтная карта &laquo;Белая нерпа&raquo;-5%, &laquo;Золотая нерпа&raquo;&ndash; 15%. <a class="akciya" href="/images/akciya.jpg"> <img src="/images/akciya_min.jpg" alt="" /> </a></p>', '', '', NULL, '', 1),
(2, 2, 'Весь  май 2013 г.  – при покупке в подарок дисконтная карта!', 'ves-maj-2013-g-pri-pokupke-v-podarok', '2013-04-01', '', NULL, NULL, '<p>Весь май 2013 г. &ndash; при покупке в подарок дисконтная карта &laquo;Белая нерпа&raquo;-5%, &laquo;Золотая нерпа&raquo;&ndash; 15%.</p>', '<p>Весь май 2013 г. &ndash; при покупке в подарок дисконтная карта &laquo;Белая нерпа&raquo;-5%, &laquo;Золотая нерпа&raquo;&ndash; 15%. <a class="akciya" href="/images/akciya.jpg"> <img src="/images/akciya_min.jpg" alt="" /> </a></p>', '', '', NULL, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `newsComments`
--

CREATE TABLE IF NOT EXISTS `newsComments` (
  `commentId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ownerId` int(10) unsigned NOT NULL DEFAULT '0',
  `autorName` tinytext,
  `emailAddress` tinytext,
  `text` text,
  `addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`commentId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `newsgroups`
--

CREATE TABLE IF NOT EXISTS `newsgroups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ownerId` int(10) unsigned NOT NULL DEFAULT '0',
  `title` tinytext,
  `uri` tinytext NOT NULL,
  `template` tinytext,
  `navigationShow` enum('y','n') DEFAULT 'y',
  `navigationMainTitle` tinytext,
  `lang` tinytext,
  `position` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `newsgroups`
--

INSERT INTO `newsgroups` (`id`, `ownerId`, `title`, `uri`, `template`, `navigationShow`, `navigationMainTitle`, `lang`, `position`) VALUES
(1, 0, 'Акции', 'aktsii', '', 'y', NULL, NULL, 1),
(2, 0, 'Новости', 'novosti', '', 'y', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `opinions`
--

CREATE TABLE IF NOT EXISTS `opinions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fio` tinytext NOT NULL,
  `org` tinytext,
  `opinionText` text NOT NULL,
  `postedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `approved` enum('y','n','b') DEFAULT 'n',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ownerId` int(10) unsigned NOT NULL DEFAULT '0',
  `title` tinytext,
  `uri` tinytext,
  `template` tinytext,
  `navigationShow` enum('y','n') DEFAULT 'y',
  `navigationTitle` tinytext,
  `redirect` tinytext,
  `text` longtext,
  `md` text,
  `mk` text,
  `lang` tinytext,
  `pageTitle` tinytext,
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  `photo` tinytext,
  `image` varchar(255) DEFAULT NULL,
  `onmain` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `ownerId`, `title`, `uri`, `template`, `navigationShow`, `navigationTitle`, `redirect`, `text`, `md`, `mk`, `lang`, `pageTitle`, `position`, `photo`, `image`, `onmain`) VALUES
(1, 0, 'Главная', 'glavnaja', 'index.html', 'y', NULL, '/catalog/', '<div id="banner0" class="banner"><img class="sale" src="/images/sale.png" alt="sale" />\r\n<div><a href="/"> <img title="banner-1" src="/upload/index/1.jpg" alt="banner-1" /> </a></div>\r\n<div>&nbsp;</div>\r\n<div class="banner_text_main">LG <span> 84 </span> ULTRA HDTV</div>\r\n</div>\r\n<div id="banner1" class="banner">\r\n<div><a href="/"> <img title="banner-2" src="/upload/index/2.jpg" alt="banner-2" /> </a></div>\r\n<div class="banner_text">Стиральная машина</div>\r\n</div>\r\n<div id="banner2" class="banner">\r\n<div><a href="/"> <img title="banner-3" src="/upload/index/3.jpg" alt="banner-3" /> </a></div>\r\n<div class="banner_text">Стиральная машина</div>\r\n</div>', '', '', NULL, '', 0, NULL, '1393399571_mzemy3u.jpg', 1),
(2, 0, 'О компании', 'o-kompanii', '', 'y', NULL, '', '<p>Наша компания &laquo;<strong>Техно Дом</strong>&raquo; - За пятнадцать лет работы на рынке бытовой техники завоевала безусловное доверие и уважение клиентов, репутацию надежного партнера среди ведущих производителей бытовой техники.</p>\r\n<p><span style="text-decoration: underline;"><strong>Принципы работы компании:</strong></span> высокий уровень обслуживания, качество товаров, доступность для покупателей.</p>\r\n<p>Компания &laquo;Техно Дом&raquo; создана для Вас, и работает для Вас. Наша компания работает на рынке Восточной Сибири с начала 1998 года. За это время мы смогли добиться лидирующих позиций среди магазинов бытовой техники и электроники. В нашем ассортименте присутствует любая бытовая техника от чайников до холодильников. Всего наш магазин насчитывает более 6000 товаров разных направлений.</p>\r\n<p>В нашей компании свой мощный логистический центр, обеспечивающий постоянное наличие товара в магазинах и на складах. При имущество нашей компании это собственные автомобили обеспечивающее быструю и качественную доставку купленной у нас техники потребителям.</p>\r\n<p>Мы ценим и любим наших Покупателей, и делаем всё, чтобы Вы были довольны сделанными у нас покупками, и наша техника служила Вам долгие - долгие годы, принося радость и удовольствие.</p>', '', '', NULL, '', 1, NULL, NULL, 0),
(4, 0, 'Доставка и оплата', 'dostavka-i-oplata', '', 'y', NULL, '', '<h2>Доставка</h2>\r\n<p>Купите бытовую технику в нашем интернет-магазине &ndash; и Вам не придется ждать две-три недели доставки заказанного товара. Мы привезем Вам товар НЕ ПОЗДНЕЕ*, чем через 24 часа с момента оформления заказа, благодаря развитой системе складов и эффективной логистике доставки товара.</p>\r\n<p>Наш оператор после получения Вашего заказа свяжется с Вами и уточнит срочность, время, адрес доставки и способы оплаты товара.</p>\r\n<p>Мы БЕСПЛАТНО привезем Вам, БЕСПЛАТНО поднимем на нужный этаж и занесем в Вашу квартиру.</p>\r\n<p><strong> После прибытия экспедитора вам необходимо: </strong></p>\r\n<ul>\r\n<li>Проверить коробку на наличие повреждений. Если упаковка не нарушена (нет следов вскрытия, повреждений и т.п.) &ndash; открыть коробку, осмотреть товар, проверить комплектность.</li>\r\n</ul>\r\n<p>и только после этого расписаться в накладной, в заявке и на товарном чеке. Это будет подтверждением того, что вам доставили товар надлежащего качества .</p>\r\n<p><strong> Вместе с заказом вы получите комплект документов: </strong></p>\r\n<ul>\r\n<li>Для частных лиц &ndash; товарный чек.</li>\r\n<li>Для юридических лиц &ndash; оригинал счета, товарную накладную, счет-фактуру.</li>\r\n<li>Гарантийный талон. На весь ассортимент интернет-магазина распространяется гарантия в соответствии с Законом о правах потребителя и ГК РФ. В гарантийном талоне, который вы получаете с товаром в комплекте документов, указаны: срок гарантийного обслуживания, случаи, не подлежащие гарантийному обслуживанию, адрес и телефон гарантийной мастерской.</li>\r\n</ul>\r\n<p><strong> Стоимость доставки товара: </strong></p>\r\n<ol>\r\n<li>Доставка товара по городу Иркутску - бесплатно.</li>\r\n<li>Доставка по городу Ангарску составляет 700 рублей.</li>\r\n<li>Доставка по городу Шелехову составляет 500 рублей.</li>\r\n<li>Также Вы можете забрать свой товар в центре выдачи.</li>\r\n</ol>\r\n<p><strong> Время работы службы доставки: </strong></p>\r\n<p>Доставка осуществляется в будние дни и в субботу в часы с 10-00 до 22-00</p>\r\n<h2>Оплата</h2>\r\n<p><strong>Оплату выбранных товаров можно произвести следующими способами:</strong></p>\r\n<p><strong>1. Оплата наличными курьеру (самый распространенный способ оплаты):</strong></p>\r\n<p>Для Вас это самый безопасный вариант оплаты, оплата происходит только после получения и проверки товара.</p>\r\n<p><strong>2. Оплата с помощью пластиковой карты:</strong></p>\r\n<p>Так-же Вы можете оплатить бытовую технику с помощью пластиковой карты Visa , Maestro и любой другой картой .Наш Курьер привезёт с собой мобильный терминал и Вы при получении оплатите покупку через банковский терминал</p>\r\n<p><strong>3. Оплата по счету для юридических лиц:</strong></p>\r\n<p>Этот способ оплаты подходит для юридических лиц. Мы предоставляем всю необходимую документацию (Торг12, Счет-фактура). Обращаем Ваше внимание, что при получении товара наш курьер потребует от получателя доверенность, будьте внимательны.</p>\r\n<p><strong>4. Оформить товар в кредит:</strong></p>\r\n<p>Оформить товар в кредит вы сможете в наших магазинах через банки.</p>\r\n<p><strong>1. Банк Русский Стандарт</strong><br /> Генеральная лицензия Банка России № 2289<br /> выдана бессрочно 19 июля 2001 года<br /> Горячие линии банка:<br /> 8 800 200 6 200 - Звонок по России бесплатный.</p>\r\n<p><strong>2. ОАО &laquo;АЛЬФА-БАНК&raquo;</strong><br /> Генеральная лицензия на осуществление банковских операций № 1326 от 05 марта 2012 г.<br /> Горячие линии банка:<br /> 8 800 200 00 00 - Звонок по России бесплатный.<br /> 8 495 78 888 78</p>\r\n<p><strong>3.ОТП Банк</strong><br /> Генеральная лицензия Банка России № 2766 от 4 марта 2008 г.<br /> +7 (495) 775-4-775 8 800 100-55-55</p>', '', '', NULL, '', 3, NULL, NULL, 0),
(5, 0, 'Контакты', 'kontakty', '', 'y', NULL, '', '<p><strong> <span style="text-decoration: underline;"> Адрес: </span> </strong></p>\r\n<p>664007 г. Иркутск, Октябрьской Революции 1, ТЦ &laquo;Электрон&raquo; пав №46</p>\r\n<p><strong> <span style="text-decoration: underline;"> Схема проезда: </span> </strong></p>\r\n<p><a id="firmsonmap_biglink" href="http://maps.2gis.ru/#/?history=project/irkutsk/center/104.29553772716,52.293905909699/zoom/16/state/widget/id/1548640653056357/firms/1548640653056357"> Перейти к большой карте </a></p>\r\n<script charset="utf-8" type="text/javascript" src="http://firmsonmap.api.2gis.ru/js/DGWidgetLoader.js">// <![CDATA[\r\n\r\n// ]]></script>\r\n<script charset="utf-8" type="text/javascript">// <![CDATA[\r\nnew DGWidgetLoader({\r\n        "borderColor": "#a3a3a3",\r\n        "width": "735",\r\n        "height": "500",\r\n        "wid": "2878300aea9ddc020840dbfdb10a1d7a",\r\n        "pos": {\r\n            "lon": "104.29553772716",\r\n            "lat": "52.293905909699",\r\n            "zoom": "16"\r\n        },\r\n        "opt": {\r\n            "ref": "hidden",\r\n            "card": ["name", "contacts", "schedule", "payings"],\r\n            "city": "irkutsk"\r\n        },\r\n        "org": [{\r\n            "id": "1548640653056357"\r\n        }]\r\n    });\r\n// ]]></script>\r\n<noscript style="color: #c00; font-size: 16px; font-weight: bold;">\r\n    Виджет карты использует JavaScript. Включите его в настройках вашего браузера.\r\n</noscript>', '', '', NULL, '', 5, NULL, NULL, 0),
(16, 0, 'Гарантия', 'garantija', '', 'y', NULL, '', '', '', '', NULL, '', 4, NULL, NULL, 0),
(17, 0, 'Вакансии', 'vakansii', '', 'y', NULL, '', '', '', '', NULL, '', 5, NULL, NULL, 0),
(14, 9, 'Такие разные белые блузки', 'takie-raznye-belye-bluzki', '', 'y', NULL, '', '<h1>Такие разные белые блузки</h1>\r\n<p style="font-weight: bold;">В год Белого зайца дизайнеры уделили особое внимание палочке-выручалочке в гардеробе современных женщин &ndash; белой блузке. Актуальные сегодня модели отличаются необычным кроем, интересными деталями и декоративными элементами.</p>\r\n<p style="font-weight: bold;">Неслучайно белая блузка год от года вдохновляет мир моды. Она не требует от владелицы ни определенного возраста (хотя, несомненно, делает женщину визуально моложе!), ни точеной фигуры. Такую блузку можно носить как с джинсами и леггинсами, так и с деловым костюмом, надевать в офис или на свидание. А главное &ndash; всего несколько аксессуаров способны превратить дневной вариант в вечерний. Предлагаю совершить экскурсию в мир белой блузки. Европейская мода предлагает множество моделей на выбор, узнайте среди них те, что подходят именно вам!</p>\r\n<p>В сезоне весна-лето 2011 актуальным становится <strong> большой круглый вырез и рукава три четверти. </strong> Кромка рукавов и низа также слегка закруглена. Ансамбль хорошо дополнить броским аксессуаром &ndash; ремнем на бедрах. И больше никаких излишних деталей!</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/1.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p>Прекрасный вариант для романтической прогулки - <strong> удлиненная приталенная блузка </strong> с акцентом на слегка расширенный рукав три четверти, сборки чуть ниже лифа и фантазийный вырез. Дополнят образ серебряные аксессуары.</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/2.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p>И снова в центре внимания &ndash; манжеты и пуговицы на планке. Но эта модель носит более игривый характер благодаря <strong> рюшам на воротнике. </strong></p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/3.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p>Такую блузку можно смело носить с обычными прямыми брюками, а вашу женственность подчеркнет сочетание <strong> отрезной кокетки, воротника-стойки и воланов </strong> по обе стороны от воротника и планки.</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/4.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p>Для торжественного случая подойдет эта <strong> приталенная блузка с романтичной отделкой </strong> вдоль застежки и стоячего воротника.</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/5.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p>Не забывайте об аксессуарах! Блузка со <strong> слегка закругленным низом, с небольшой драпировкой в виде складок </strong> вдоль планки до талии нуждается в ремне и бусах, чтобы подчеркнуть вашу индивидуальность.</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/6.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p>Роскошным женщинам иногда достаточно лишь небольшой детали, чтобы оттенить свою красоту. Здесь таким акцентом служит <strong> вставка в виде небольших горизонтальных складок </strong> вдоль планки.</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/7.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p>Полоска может быть очень дразнящей в сочетании <strong> &laquo;белая блузка - вставки из слегка прозрачной ткани&raquo;. </strong> Бусы лишь усилят эффект.</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/8.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p>Белая блузка в прозрачную полоску может иметь и вполне деловой вид, если скроена <strong> в стиле мужской рубашки. </strong> А неформальность ей всегда можно придать с помощью бижутерии.</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/9.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p>Оригинально <strong> расположенные вокруг планки воланы </strong> придадут вам праздничный вид во время офисных будней. А правильно подобранные аксессуары не оставят вас незамеченной даже для самой взыскательной публики.</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/10.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p>В этой уникальной блузке с акцентом на <strong> необычные рукава </strong> вы будете неотразимы! Главное правило: при таком объемном верхе низ должен быть максимально облегающим.</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/11.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p><strong> Отделка из сатина </strong> на внутренней стороне воротника и манжетах придаст белой блузке особую элегантность, особенно если вы подберете пояс в тон.</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/12.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p>Пример тонко выверенного контраста: двухслойный <strong> волан, отделанный черной сатиновой узкой лентой и черные маленькие пуговицы </strong> по-новому подчеркнут белую блузку и ее обладательницу.</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/13.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p><strong> Вышивка с цветочными мотивами, открытый рубашечный воротник, отделка </strong> слегка закругленного нижнего края, манжет, воротника и плеч придают блузке женственный шарм. Если дополнить ее белыми брюками и дорогими аксессуарами, получится новое воплощение морского стиля.</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/14.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p>Акцент в этой белой блузке сделан на <strong> трехъярусный воротник и манжеты с контрастной строчкой. </strong> Джеки О она бы понравилась!</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/15.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p>Пример удачной игры на контрасте &ndash; <strong> стильный рисунок и необычно расположенные пуговицы </strong> на планке. Можно дополнить это уравнение и другими черными акцентами.</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/16.jpg" alt="image" /></h3>\r\n<p>&nbsp;</p>\r\n<p><strong> Мода 80-х с отделкой </strong> в виде воротников, манжет, жабо, кокилье обретает второе рождение в этой блузке. Пусть ей составят компанию аксессуары &ndash; контрастный пояс и бижутерия.</p>\r\n<h3><img style="display: block; margin-left: auto; margin-right: auto;" src="/images/articles/17.jpg" alt="image" /></h3>', '', '', NULL, '', 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pagesArch`
--

CREATE TABLE IF NOT EXISTS `pagesArch` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ownerId` int(10) unsigned NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shop_basket`
--

CREATE TABLE IF NOT EXISTS `shop_basket` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` tinytext NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `session_id` text NOT NULL,
  `parent_group_id` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `price_old` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `is_hit` tinyint(1) NOT NULL,
  `is_new` tinyint(1) NOT NULL,
  `uri` tinytext NOT NULL,
  `thumb` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `shop_basket`
--

INSERT INTO `shop_basket` (`id`, `item_id`, `user_id`, `session_id`, `parent_group_id`, `name`, `price_old`, `price`, `quantity`, `is_hit`, `is_new`, `uri`, `thumb`) VALUES
(13, '913593fe-266a-11e3-805a-3085a9ad2002', 23, '', '71430fc4-2673-11e3-805a-3085a9ad2002', 'Телевизор LG -28LN450U', '0.00', '5000.00', 2, 0, 0, 'item545', ''),
(14, '913593fe-266a-11e3-805a-3085a9ad2002', 18, '', '71430fc4-2673-11e3-805a-3085a9ad2002', 'Телевизор LG -28LN450U', '0.00', '5000.00', 1, 0, 0, 'item545', ''),
(11, '913593fe-266a-11e3-805a-3085a9ad2002', 22, '', '71430fc4-2673-11e3-805a-3085a9ad2002', 'Телевизор LG -28LN450U', '0.00', '5000.00', 1, 0, 0, 'item545', ''),
(22, '9ef1d6ef-2bda-11e3-805a-3085a9ad2002', 24, '', 'd75de78c-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Philips - BDP 5100/51', '0.00', '1000.00', 1, 0, 0, 'item38', '');

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
  `status` set('hidden','main') NOT NULL,
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

INSERT INTO `shop_groups` (`id`, `group_id`, `parent_group_id`, `name`, `image`, `thumb`, `uri`, `description`, `status`, `position`, `md`, `mk`, `title`) VALUES
(1, 'f2e7e3e3-2cac-11e3-b4cb-3085a9ad2002', '0', 'Аудио видео', '/upload/catalog/images/mouse-1.jpg', '/upload/thumbnails/l1_bW91c2UtMS5qcGc.jpg', 'group1', 'фыв', 'main', 0, '', '', ''),
(2, 'f7d8ffc2-2bca-11e3-805a-3085a9ad2002', '0', '3D Blu-Ray плеер', '', '', 'group2', '<p>&nbsp;</p>\r\n<p>&nbsp;</p>', 'main', 1, '', '', ''),
(3, 'f7d8ffef-2bca-11e3-805a-3085a9ad2002', 'f7d8ffc2-2bca-11e3-805a-3085a9ad2002', 'LG', '', '', 'group3', '', 'main', 2, '', '', ''),
(4, '9ef1d6e8-2bda-11e3-805a-3085a9ad2002', 'f7d8ffc2-2bca-11e3-805a-3085a9ad2002', 'PHILIPS', '', '', 'group4', '', 'main', 4, '', '', ''),
(5, '32f8a535-2be6-11e3-805a-3085a9ad2002', 'f7d8ffc2-2bca-11e3-805a-3085a9ad2002', 'SAMSUNG', '', '', 'group5', '', 'main', 6, '', '', ''),
(6, '32f8a546-2be6-11e3-805a-3085a9ad2002', 'f7d8ffc2-2bca-11e3-805a-3085a9ad2002', 'SONI', '', '', 'group6', '', 'main', 8, '', '', ''),
(7, 'd75de791-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc2-2bca-11e3-805a-3085a9ad2002', 'TOSHIBA', '', '', 'group7', '', 'main', 10, '', '', ''),
(8, 'f0caf53e-2b2f-11e3-8ef3-3085a9ad2002', 'f2e7e3e3-2cac-11e3-b4cb-3085a9ad2002', 'DVD', '', '', 'group8', '', 'main', 13, '', '', ''),
(9, 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'f0caf53e-2b2f-11e3-8ef3-3085a9ad2002', 'DVD+Караоке', '', '', 'group9', '', 'main', 14, '', '', ''),
(10, 'f0caf541-2b2f-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'BBK', '', '', 'group10', '', 'main', 15, '', '', ''),
(11, 'd75de788-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'ERISSON', '', '', 'group11', '', 'main', 17, '', '', ''),
(12, 'd75de789-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'FUSION', '', '', 'group12', '', 'main', 19, '', '', ''),
(13, 'd75de78a-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'LG', '', '', 'group13', '', 'main', 21, '', '', ''),
(14, 'd75de78b-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'MYSTERI', '', '', 'group14', '', 'main', 23, '', '', ''),
(15, 'd75de78c-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'PHILIPS', '', '', 'group15', '', 'main', 25, '', '', ''),
(16, 'd75de78d-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'PIONEER', '', '', 'group16', '', 'main', 27, '', '', ''),
(17, 'd75de78e-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'SAMSUNG', '', '', 'group17', '', 'main', 29, '', '', ''),
(18, 'd75de78f-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'SONY', '', '', 'group18', '', 'main', 31, '', '', ''),
(19, 'd75de790-2b3d-11e3-8ef3-3085a9ad2002', 'f7d8ffc1-2bca-11e3-805a-3085a9ad2002', 'SUPRA', '', '', 'group19', '', 'main', 33, '', '', ''),
(20, '32f8a553-2be6-11e3-805a-3085a9ad2002', 'f2e7e3e3-2cac-11e3-b4cb-3085a9ad2002', 'Домашний кинотеатр', '', '', 'group20', '', 'main', 37, '', '', ''),
(21, '32f8a554-2be6-11e3-805a-3085a9ad2002', '32f8a553-2be6-11e3-805a-3085a9ad2002', 'LG', '', '', 'group21', '', 'main', 38, '', '', ''),
(22, '32f8a556-2be6-11e3-805a-3085a9ad2002', '32f8a553-2be6-11e3-805a-3085a9ad2002', 'PHILIPS', '', '', 'group22', '', 'main', 40, '', '', ''),
(23, '32f8a555-2be6-11e3-805a-3085a9ad2002', '32f8a553-2be6-11e3-805a-3085a9ad2002', 'SAMSUNG', '', '', 'group23', '', 'main', 42, '', '', ''),
(24, '2af4bd3b-2bfc-11e3-805a-3085a9ad2002', 'f2e7e3e3-2cac-11e3-b4cb-3085a9ad2002', 'Музыкальный ценрт', '', '', 'group24', '', 'main', 45, '', '', ''),
(25, '2af4bd3c-2bfc-11e3-805a-3085a9ad2002', '2af4bd3b-2bfc-11e3-805a-3085a9ad2002', 'LG', '', '', 'group25', '', 'main', 46, '', '', ''),
(26, '2af4bd3d-2bfc-11e3-805a-3085a9ad2002', '2af4bd3b-2bfc-11e3-805a-3085a9ad2002', 'SAMSUNG', '', '', 'group26', '', 'main', 48, '', '', ''),
(27, '3ae00f38-323d-11e3-85c9-3085a9ad2002', 'f2e7e3e3-2cac-11e3-b4cb-3085a9ad2002', 'Радио часы', '', '', 'group27', '', 'main', 51, '', '', ''),
(28, '3ae00f39-323d-11e3-85c9-3085a9ad2002', '3ae00f38-323d-11e3-85c9-3085a9ad2002', 'ERISSON		', '', '', 'group28', '', 'main', 52, '', '', ''),
(29, '3ae00f3a-323d-11e3-85c9-3085a9ad2002', '3ae00f38-323d-11e3-85c9-3085a9ad2002', 'HYUNDAI		', '', '', 'group29', '', 'main', 54, '', '', ''),
(30, '3ae00f3b-323d-11e3-85c9-3085a9ad2002', '3ae00f38-323d-11e3-85c9-3085a9ad2002', 'PHILIPS', '', '', 'group30', '', 'main', 56, '', '', ''),
(31, 'c5f78ac2-3244-11e3-85c9-3085a9ad2002', '3ae00f38-323d-11e3-85c9-3085a9ad2002', 'PHILIPS', '', '', 'group31', '', 'main', 58, '', '', ''),
(32, '3ae00f3c-323d-11e3-85c9-3085a9ad2002', '3ae00f38-323d-11e3-85c9-3085a9ad2002', 'SUPRA', '', '', 'group32', '', 'main', 60, '', '', ''),
(33, '3ae00f3d-323d-11e3-85c9-3085a9ad2002', '3ae00f38-323d-11e3-85c9-3085a9ad2002', 'VITEK		', '', '', 'group33', '', 'main', 62, '', '', ''),
(34, '3696657c-314e-11e3-a2d2-3085a9ad2002', '0', 'Массажёры', '', '', 'group34', '', '', 66, '', '', ''),
(35, '3696657d-314e-11e3-a2d2-3085a9ad2002', '3696657c-314e-11e3-a2d2-3085a9ad2002', 'SCARLETT', '', '', 'group35', '', '', 67, '', '', ''),
(36, '44927af8-315d-11e3-a2d2-3085a9ad2002', '3696657c-314e-11e3-a2d2-3085a9ad2002', 'Ves', '', '', 'group36', '', '', 69, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `shop_itemfiles`
--

CREATE TABLE IF NOT EXISTS `shop_itemfiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` tinytext NOT NULL,
  `filename` tinytext NOT NULL,
  `description` tinytext NOT NULL,
  `filetype` tinytext NOT NULL,
  PRIMARY KEY (`item_id`(70),`filename`(255)),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shop_itemimages`
--

CREATE TABLE IF NOT EXISTS `shop_itemimages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` tinytext NOT NULL,
  `filename` tinytext NOT NULL,
  `thumb` tinytext NOT NULL,
  `description` tinytext NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`item_id`(50),`filename`(255)),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=94 ;

--
-- Dumping data for table `shop_itemimages`
--

INSERT INTO `shop_itemimages` (`id`, `item_id`, `filename`, `thumb`, `description`, `position`) VALUES
(1, '2af4bd3e-2bfc-11e3-805a-3085a9ad2002', 'import_files/2a/2af4bd3e-2bfc-11e3-805a-3085a9ad2002_5db77cef-2c90-11e3-b4cb-3085a9ad2002.jpeg', '', '', 0),
(2, '2af4bd3e-2bfc-11e3-805a-3085a9ad2002', 'import_files/2a/2af4bd3e-2bfc-11e3-805a-3085a9ad2002_2af4bd40-2bfc-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(3, 'eac5a9c1-2bc6-11e3-a234-3085a9ad2002', 'import_files/ea/eac5a9c1-2bc6-11e3-a234-3085a9ad2002_eac5a9c3-2bc6-11e3-a234-3085a9ad2002.jpeg', '', '', 0),
(4, 'eac5a9be-2bc6-11e3-a234-3085a9ad2002', 'import_files/ea/eac5a9be-2bc6-11e3-a234-3085a9ad2002_eac5a9c0-2bc6-11e3-a234-3085a9ad2002.jpeg', '', '', 0),
(5, 'f7d8ffbe-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8ffbe-2bca-11e3-805a-3085a9ad2002_f7d8ffc0-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(6, 'eac5a9c4-2bc6-11e3-a234-3085a9ad2002', 'import_files/ea/eac5a9c4-2bc6-11e3-a234-3085a9ad2002_eac5a9c6-2bc6-11e3-a234-3085a9ad2002.jpeg', '', '', 0),
(7, 'eac5a9c7-2bc6-11e3-a234-3085a9ad2002', 'import_files/ea/eac5a9c7-2bc6-11e3-a234-3085a9ad2002_eac5a9c9-2bc6-11e3-a234-3085a9ad2002.jpeg', '', '', 0),
(8, 'f7d8ffb5-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8ffb5-2bca-11e3-805a-3085a9ad2002_f7d8ffb7-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(9, 'f0caf53f-2b2f-11e3-8ef3-3085a9ad2002', 'import_files/f0/f0caf53f-2b2f-11e3-8ef3-3085a9ad2002_d75de787-2b3d-11e3-8ef3-3085a9ad2002.jpeg', '', '', 0),
(10, 'f7d8ffb8-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8ffb8-2bca-11e3-805a-3085a9ad2002_f7d8ffba-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(11, 'f7d8ffbb-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8ffbb-2bca-11e3-805a-3085a9ad2002_f7d8ffbd-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(12, 'f7d8ffc3-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8ffc3-2bca-11e3-805a-3085a9ad2002_f7d8ffc5-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(13, 'f7d8ffc6-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8ffc6-2bca-11e3-805a-3085a9ad2002_f7d8ffc8-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(14, 'f7d8ffc9-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8ffc9-2bca-11e3-805a-3085a9ad2002_f7d8ffcb-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(15, 'f7d8ffcc-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8ffcc-2bca-11e3-805a-3085a9ad2002_f7d8ffce-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(16, 'f7d8ffcf-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8ffcf-2bca-11e3-805a-3085a9ad2002_f7d8ffd1-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(17, 'f7d8ffd2-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8ffd2-2bca-11e3-805a-3085a9ad2002_f7d8ffd4-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(18, 'f7d8ffd7-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8ffd7-2bca-11e3-805a-3085a9ad2002_f7d8ffd9-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(19, 'f7d8ffda-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8ffda-2bca-11e3-805a-3085a9ad2002_f7d8ffdc-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(20, 'f7d8ffdd-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8ffdd-2bca-11e3-805a-3085a9ad2002_f7d8ffdf-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(21, 'f7d8ffe0-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8ffe0-2bca-11e3-805a-3085a9ad2002_f7d8ffe2-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(22, 'f7d8fff1-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8fff1-2bca-11e3-805a-3085a9ad2002_f7d8fff3-2bca-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(23, 'f7d8fff4-2bca-11e3-805a-3085a9ad2002', 'import_files/f7/f7d8fff4-2bca-11e3-805a-3085a9ad2002_9ef1d6bd-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(24, '9ef1d6be-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6be-2bda-11e3-805a-3085a9ad2002_9ef1d6c0-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(25, '9ef1d6c1-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6c1-2bda-11e3-805a-3085a9ad2002_9ef1d6c3-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(26, '9ef1d6c4-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6c4-2bda-11e3-805a-3085a9ad2002_9ef1d6c6-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(27, '9ef1d6c7-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6c7-2bda-11e3-805a-3085a9ad2002_9ef1d6c9-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(28, '9ef1d6ca-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6ca-2bda-11e3-805a-3085a9ad2002_9ef1d6cd-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(29, '9ef1d6ce-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6ce-2bda-11e3-805a-3085a9ad2002_9ef1d6d0-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(30, '9ef1d6d1-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6d1-2bda-11e3-805a-3085a9ad2002_9ef1d6d3-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(31, '9ef1d6d4-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6d4-2bda-11e3-805a-3085a9ad2002_9ef1d6d6-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(32, '9ef1d6d7-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6d7-2bda-11e3-805a-3085a9ad2002_9ef1d6d9-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(33, '9ef1d6dc-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6dc-2bda-11e3-805a-3085a9ad2002_9ef1d6de-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(34, '9ef1d6e9-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6e9-2bda-11e3-805a-3085a9ad2002_9ef1d6eb-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(35, '9ef1d6ec-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6ec-2bda-11e3-805a-3085a9ad2002_9ef1d6ee-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(36, '9ef1d6f2-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6f2-2bda-11e3-805a-3085a9ad2002_9ef1d6f4-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(37, '9ef1d6e5-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6e5-2bda-11e3-805a-3085a9ad2002_9ef1d6e7-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(38, '9ef1d6ef-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6ef-2bda-11e3-805a-3085a9ad2002_9ef1d6f1-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(39, '9ef1d6f8-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6f8-2bda-11e3-805a-3085a9ad2002_9ef1d6fa-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(40, '9ef1d6f5-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6f5-2bda-11e3-805a-3085a9ad2002_9ef1d6f7-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(41, '9ef1d6fb-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6fb-2bda-11e3-805a-3085a9ad2002_32f8a52b-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(42, '6ed93b96-3f6e-11e3-a1f8-3085a9ad2002', 'import_files/6e/6ed93b96-3f6e-11e3-a1f8-3085a9ad2002_6ed93b98-3f6e-11e3-a1f8-3085a9ad2002.jpeg', '', '', 0),
(43, '9ef1d6df-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6df-2bda-11e3-805a-3085a9ad2002_9ef1d6e1-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(44, '32f8a52c-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a52c-2be6-11e3-805a-3085a9ad2002_32f8a52e-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(45, '32f8a52f-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a52f-2be6-11e3-805a-3085a9ad2002_32f8a531-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(46, '32f8a539-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a539-2be6-11e3-805a-3085a9ad2002_32f8a53b-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(47, '32f8a532-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a532-2be6-11e3-805a-3085a9ad2002_32f8a534-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(48, '32f8a536-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a536-2be6-11e3-805a-3085a9ad2002_32f8a538-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(49, '32f8a542-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a542-2be6-11e3-805a-3085a9ad2002_32f8a544-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(50, '32f8a53c-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a53c-2be6-11e3-805a-3085a9ad2002_32f8a53e-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(51, '32f8a53f-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a53f-2be6-11e3-805a-3085a9ad2002_32f8a541-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(52, '32f8a547-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a547-2be6-11e3-805a-3085a9ad2002_32f8a549-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(53, '32f8a54a-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a54a-2be6-11e3-805a-3085a9ad2002_32f8a54c-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(54, '32f8a54d-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a54d-2be6-11e3-805a-3085a9ad2002_32f8a54f-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(55, '32f8a550-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a550-2be6-11e3-805a-3085a9ad2002_32f8a552-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(56, '9ef1d6e2-2bda-11e3-805a-3085a9ad2002', 'import_files/9e/9ef1d6e2-2bda-11e3-805a-3085a9ad2002_9ef1d6e4-2bda-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(57, '32f8a566-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a566-2be6-11e3-805a-3085a9ad2002_32f8a568-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(58, '2af4bd2c-2bfc-11e3-805a-3085a9ad2002', 'import_files/2a/2af4bd2c-2bfc-11e3-805a-3085a9ad2002_2af4bd2e-2bfc-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(59, '2af4bd2f-2bfc-11e3-805a-3085a9ad2002', 'import_files/2a/2af4bd2f-2bfc-11e3-805a-3085a9ad2002_2af4bd31-2bfc-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(60, '2af4bd36-2bfc-11e3-805a-3085a9ad2002', 'import_files/2a/2af4bd36-2bfc-11e3-805a-3085a9ad2002_2af4bd38-2bfc-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(61, '2af4bd33-2bfc-11e3-805a-3085a9ad2002', 'import_files/2a/2af4bd33-2bfc-11e3-805a-3085a9ad2002_2af4bd35-2bfc-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(62, '32f8a557-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a557-2be6-11e3-805a-3085a9ad2002_32f8a559-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(63, '32f8a560-2be6-11e3-805a-3085a9ad2002', 'import_files/32/32f8a560-2be6-11e3-805a-3085a9ad2002_32f8a562-2be6-11e3-805a-3085a9ad2002.jpeg', '', '', 0),
(64, '44927af5-315d-11e3-a2d2-3085a9ad2002', 'import_files/44/44927af5-315d-11e3-a2d2-3085a9ad2002_44927af7-315d-11e3-a2d2-3085a9ad2002.jpeg', '', '', 0),
(65, '3696657e-314e-11e3-a2d2-3085a9ad2002', 'import_files/36/3696657e-314e-11e3-a2d2-3085a9ad2002_44927aee-315d-11e3-a2d2-3085a9ad2002.jpeg', '', '', 0),
(66, '44927aef-315d-11e3-a2d2-3085a9ad2002', 'import_files/44/44927aef-315d-11e3-a2d2-3085a9ad2002_44927af1-315d-11e3-a2d2-3085a9ad2002.jpeg', '', '', 0),
(67, '44927af2-315d-11e3-a2d2-3085a9ad2002', 'import_files/44/44927af2-315d-11e3-a2d2-3085a9ad2002_44927af4-315d-11e3-a2d2-3085a9ad2002.jpeg', '', '', 0),
(68, '5db77ccb-2c90-11e3-b4cb-3085a9ad2002', 'import_files/5d/5db77ccb-2c90-11e3-b4cb-3085a9ad2002_5db77ccd-2c90-11e3-b4cb-3085a9ad2002.jpeg', '', '', 0),
(69, '5db77ce4-2c90-11e3-b4cb-3085a9ad2002', 'import_files/5d/5db77ce4-2c90-11e3-b4cb-3085a9ad2002_5db77ce6-2c90-11e3-b4cb-3085a9ad2002.jpeg', '', '', 0),
(70, '5db77ce7-2c90-11e3-b4cb-3085a9ad2002', 'import_files/5d/5db77ce7-2c90-11e3-b4cb-3085a9ad2002_5db77ce9-2c90-11e3-b4cb-3085a9ad2002.jpeg', '', '', 0),
(71, '5db77ceb-2c90-11e3-b4cb-3085a9ad2002', 'import_files/5d/5db77ceb-2c90-11e3-b4cb-3085a9ad2002_5db77ced-2c90-11e3-b4cb-3085a9ad2002.jpeg', '', '', 0),
(72, '3ae00f3e-323d-11e3-85c9-3085a9ad2002', 'import_files/3a/3ae00f3e-323d-11e3-85c9-3085a9ad2002_3ae00f40-323d-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(73, '3ae00f41-323d-11e3-85c9-3085a9ad2002', 'import_files/3a/3ae00f41-323d-11e3-85c9-3085a9ad2002_3ae00f43-323d-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(74, '3ae00f47-323d-11e3-85c9-3085a9ad2002', 'import_files/3a/3ae00f47-323d-11e3-85c9-3085a9ad2002_3ae00f49-323d-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(75, '3ae00f44-323d-11e3-85c9-3085a9ad2002', 'import_files/3a/3ae00f44-323d-11e3-85c9-3085a9ad2002_3ae00f46-323d-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(76, '3ae00f4a-323d-11e3-85c9-3085a9ad2002', 'import_files/3a/3ae00f4a-323d-11e3-85c9-3085a9ad2002_3ae00f4c-323d-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(77, '3ae00f4d-323d-11e3-85c9-3085a9ad2002', 'import_files/3a/3ae00f4d-323d-11e3-85c9-3085a9ad2002_c5f78ab6-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(78, 'c5f78ac3-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78ac3-3244-11e3-85c9-3085a9ad2002_c5f78ac5-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(79, 'c5f78abd-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78abd-3244-11e3-85c9-3085a9ad2002_c5f78abf-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(80, 'c5f78ac6-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78ac6-3244-11e3-85c9-3085a9ad2002_c5f78ac8-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(81, 'c5f78ac9-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78ac9-3244-11e3-85c9-3085a9ad2002_c5f78acb-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(82, 'c5f78acc-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78acc-3244-11e3-85c9-3085a9ad2002_c5f78ace-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(83, 'c5f78acf-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78acf-3244-11e3-85c9-3085a9ad2002_c5f78ad1-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(84, 'c5f78ad2-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78ad2-3244-11e3-85c9-3085a9ad2002_c5f78ad4-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(85, 'c5f78ad5-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78ad5-3244-11e3-85c9-3085a9ad2002_c5f78ad7-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(86, 'c5f78ad8-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78ad8-3244-11e3-85c9-3085a9ad2002_c5f78ada-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(87, 'c5f78adb-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78adb-3244-11e3-85c9-3085a9ad2002_c5f78add-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(88, 'c5f78ade-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78ade-3244-11e3-85c9-3085a9ad2002_c5f78ae0-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(89, 'c5f78ae1-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78ae1-3244-11e3-85c9-3085a9ad2002_c5f78ae3-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(90, 'c5f78ae4-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78ae4-3244-11e3-85c9-3085a9ad2002_c5f78ae6-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(91, 'c5f78ae7-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78ae7-3244-11e3-85c9-3085a9ad2002_c5f78ae9-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(92, 'c5f78ab7-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78ab7-3244-11e3-85c9-3085a9ad2002_c5f78ab9-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0),
(93, 'c5f78aba-3244-11e3-85c9-3085a9ad2002', 'import_files/c5/c5f78aba-3244-11e3-85c9-3085a9ad2002_c5f78abc-3244-11e3-85c9-3085a9ad2002.jpeg', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shop_itemproperties`
--

CREATE TABLE IF NOT EXISTS `shop_itemproperties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prop_id` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`prop_id`(255)),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=202 ;

--
-- Dumping data for table `shop_itemproperties`
--

INSERT INTO `shop_itemproperties` (`id`, `prop_id`, `name`) VALUES
(1, '2af4bd42-2bfc-11e3-805a-3085a9ad2002', 'Объем морозильной камеры'),
(2, '2af4bd43-2bfc-11e3-805a-3085a9ad2002', 'Возможность перевешивания двери'),
(3, '69f93efd-37b8-11e3-80d4-3085a9ad2002', 'Габариты  (ШхГхВ)'),
(4, 'b0284ff5-404a-11e3-823e-3085a9ad2002', 'Объем масла'),
(5, 'b0284ff7-404a-11e3-823e-3085a9ad2002', 'Съемная чаша'),
(6, 'b0284ff9-404a-11e3-823e-3085a9ad2002', 'Приготовление фондю'),
(7, 'b0284ffc-404a-11e3-823e-3085a9ad2002', 'Мощность'),
(8, 'b0284ffe-404a-11e3-823e-3085a9ad2002', 'Управление'),
(9, 'b0285000-404a-11e3-823e-3085a9ad2002', 'Вместимость картофельных ломтиков'),
(10, 'b0285005-404a-11e3-823e-3085a9ad2002', 'Фильтр против запаха'),
(11, 'b0285007-404a-11e3-823e-3085a9ad2002', 'Таймер'),
(12, 'b028500f-404a-11e3-823e-3085a9ad2002', 'Тип'),
(13, 'b0285011-404a-11e3-823e-3085a9ad2002', 'Мощность'),
(14, 'ded5c732-4059-11e3-823e-3085a9ad2002', 'Количество режимов'),
(15, 'ded5c734-4059-11e3-823e-3085a9ad2002', 'Длина сетевого шнура'),
(16, 'ded5c736-4059-11e3-823e-3085a9ad2002', 'Покрытие насадок'),
(17, 'ded5c738-4059-11e3-823e-3085a9ad2002', 'Комплектация'),
(18, 'd5c46c05-3d12-11e3-8395-3085a9ad2002', 'Терморегулятор'),
(19, 'd5c46c07-3d12-11e3-8395-3085a9ad2002', 'Дополнительная информация'),
(20, 'd5c46c22-3d12-11e3-8395-3085a9ad2002', 'Дисплей'),
(21, 'd5c46c24-3d12-11e3-8395-3085a9ad2002', 'Терморегулятор'),
(22, 'd5c46c26-3d12-11e3-8395-3085a9ad2002', 'Терморегулятор'),
(23, 'd5c46c28-3d12-11e3-8395-3085a9ad2002', 'Дополнительная информация'),
(24, 'd5c46c2a-3d12-11e3-8395-3085a9ad2002', 'Терморегулятор'),
(25, 'd5c46c2c-3d12-11e3-8395-3085a9ad2002', 'Дисплей'),
(26, 'd5c46c2e-3d12-11e3-8395-3085a9ad2002', 'Терморегулятор'),
(27, 'd5c46c30-3d12-11e3-8395-3085a9ad2002', 'Безопасность'),
(28, 'd5c46c32-3d12-11e3-8395-3085a9ad2002', 'Терморегулятор'),
(29, 'd5c46c34-3d12-11e3-8395-3085a9ad2002', 'Дисплей'),
(30, 'd5c46c36-3d12-11e3-8395-3085a9ad2002', 'Дополнительная информация'),
(31, 'd5c46c38-3d12-11e3-8395-3085a9ad2002', 'Терморегулятор'),
(32, 'd5c46c3b-3d12-11e3-8395-3085a9ad2002', 'Рисунок на корпусе'),
(33, 'd5c46c3d-3d12-11e3-8395-3085a9ad2002', 'Безопасность'),
(34, '2fd15acb-3d48-11e3-8395-3085a9ad2002', 'Терморегулятор'),
(35, '2fd15acd-3d48-11e3-8395-3085a9ad2002', 'Дополнительная информация'),
(36, '2fd15acf-3d48-11e3-8395-3085a9ad2002', 'Дисплей'),
(37, '014556f8-2737-11e3-8496-3085a9ad2002', 'Тип '),
(38, '014556fa-2737-11e3-8496-3085a9ad2002', 'Диагональ'),
(39, '014556ff-2737-11e3-8496-3085a9ad2002', 'Формат экрана'),
(40, '01455703-2737-11e3-8496-3085a9ad2002', 'Функция 3D'),
(41, '01455707-2737-11e3-8496-3085a9ad2002', 'SMART TV'),
(42, '0145570c-2737-11e3-8496-3085a9ad2002', 'Производитель'),
(43, 'c579b10f-39f5-11e3-851a-3085a9ad2002', 'Тип загрузки'),
(44, 'c579b110-39f5-11e3-851a-3085a9ad2002', 'Cкорость отжима (об/мин)'),
(45, 'c579b111-39f5-11e3-851a-3085a9ad2002', 'Цвет'),
(46, 'c579b112-39f5-11e3-851a-3085a9ad2002', 'Цвет дверцы'),
(47, 'c579b113-39f5-11e3-851a-3085a9ad2002', 'Дисплей'),
(48, 'c579b114-39f5-11e3-851a-3085a9ad2002', 'Защита от протечек (Aqua-Lock)'),
(49, 'c579b115-39f5-11e3-851a-3085a9ad2002', 'Блокировка от детей'),
(50, 'c579b116-39f5-11e3-851a-3085a9ad2002', 'Класс эффективности стирки'),
(51, 'c579b117-39f5-11e3-851a-3085a9ad2002', 'Максимальная загрузка белья'),
(52, 'c579b118-39f5-11e3-851a-3085a9ad2002', 'Сушка'),
(53, 'c579b119-39f5-11e3-851a-3085a9ad2002', 'Функция пара'),
(54, 'c579b11a-39f5-11e3-851a-3085a9ad2002', 'Прямой привод двигателя'),
(55, 'c579b141-39f5-11e3-851a-3085a9ad2002', '6 M'),
(56, 'c579b144-39f5-11e3-851a-3085a9ad2002', 'Смарт'),
(57, 'c579b14b-39f5-11e3-851a-3085a9ad2002', 'EcoBubble'),
(58, '6ed93b68-3f6e-11e3-a1f8-3085a9ad2002', 'Производитель'),
(59, '6ed93b6a-3f6e-11e3-a1f8-3085a9ad2002', 'Загрузка'),
(60, '6ed93b6c-3f6e-11e3-a1f8-3085a9ad2002', 'Цвет'),
(61, '6ed93b6e-3f6e-11e3-a1f8-3085a9ad2002', 'Скорость отжима'),
(62, '6ed93b70-3f6e-11e3-a1f8-3085a9ad2002', 'ВхШхГ'),
(63, '6ed93b7a-3f6e-11e3-a1f8-3085a9ad2002', 'Мощность'),
(64, '6ed93b7c-3f6e-11e3-a1f8-3085a9ad2002', 'Максимальный вес выпечки'),
(65, '6ed93b7e-3f6e-11e3-a1f8-3085a9ad2002', 'Регулировка веса выпечки'),
(66, '6ed93b80-3f6e-11e3-a1f8-3085a9ad2002', 'Форма выпечки'),
(67, '6ed93b82-3f6e-11e3-a1f8-3085a9ad2002', 'Таймер'),
(68, '6ed93b84-3f6e-11e3-a1f8-3085a9ad2002', 'Поддержание температуры'),
(69, '6ed93b86-3f6e-11e3-a1f8-3085a9ad2002', 'Количество программ выпечки'),
(70, '6ed93b88-3f6e-11e3-a1f8-3085a9ad2002', 'Замес теста'),
(71, '6ed93b8a-3f6e-11e3-a1f8-3085a9ad2002', 'Ускоренная выпечка'),
(72, '6ed93b8c-3f6e-11e3-a1f8-3085a9ad2002', 'Число тестомешателей'),
(73, '6ed93b8e-3f6e-11e3-a1f8-3085a9ad2002', 'Подсветка дисплея'),
(74, '6ed93b90-3f6e-11e3-a1f8-3085a9ad2002', 'Съемная крышка'),
(75, '6ed93b92-3f6e-11e3-a1f8-3085a9ad2002', 'Диспенсер'),
(76, 'c9c0fc23-3ac2-11e3-a27f-3085a9ad2002', 'Управление'),
(77, 'c9c0fc25-3ac2-11e3-a27f-3085a9ad2002', 'Количество компрессоров'),
(78, 'c9c0fc28-3ac2-11e3-a27f-3085a9ad2002', 'Количество камер'),
(79, 'c9c0fc2b-3ac2-11e3-a27f-3085a9ad2002', 'Количество дверей'),
(80, 'c9c0fc2e-3ac2-11e3-a27f-3085a9ad2002', 'Расположение'),
(81, 'c9c0fc55-3ac2-11e3-a27f-3085a9ad2002', 'Дисплей'),
(82, '60700843-3ae9-11e3-a27f-3085a9ad2002', 'Расположение морозильной камеры'),
(83, '0dff13ae-3152-11e3-a2d2-3085a9ad2002', 'Двухкамерный'),
(84, 'a407efbb-36eb-11e3-a3ba-3085a9ad2002', 'Размеры (ВхШхГ)'),
(85, 'a407efbd-36eb-11e3-a3ba-3085a9ad2002', 'Максимальная загрузка'),
(86, 'a407efc1-36eb-11e3-a3ba-3085a9ad2002', 'Класс мойки'),
(87, 'a407efc3-36eb-11e3-a3ba-3085a9ad2002', 'Класс сушки'),
(88, 'a407efc5-36eb-11e3-a3ba-3085a9ad2002', 'Класс энергопотребления'),
(89, 'a407efc6-36eb-11e3-a3ba-3085a9ad2002', 'Класс энергопотребления'),
(90, 'a407efc8-36eb-11e3-a3ba-3085a9ad2002', 'Расход воды'),
(91, 'a407efcb-36eb-11e3-a3ba-3085a9ad2002', 'Дисплей'),
(92, 'a407efce-36eb-11e3-a3ba-3085a9ad2002', 'Количество программ мойки'),
(93, '6901eddb-36ff-11e3-a3ba-3085a9ad2002', 'Быстрая мойка'),
(94, '6901edde-36ff-11e3-a3ba-3085a9ad2002', 'Экономичная мойка'),
(95, '6901ede1-36ff-11e3-a3ba-3085a9ad2002', 'Интенсивная мойка'),
(96, '6901ede4-36ff-11e3-a3ba-3085a9ad2002', 'Стандартная программа'),
(97, '6901ede5-36ff-11e3-a3ba-3085a9ad2002', 'Стандартная программа'),
(98, '6901ede8-36ff-11e3-a3ba-3085a9ad2002', 'Предварительное ополаскивание'),
(99, '6901edeb-36ff-11e3-a3ba-3085a9ad2002', 'Половинная загрузка'),
(100, '6901edef-36ff-11e3-a3ba-3085a9ad2002', 'Сигнал окончания мойки'),
(101, '6901edf2-36ff-11e3-a3ba-3085a9ad2002', 'Сушилка'),
(102, '6901edf6-36ff-11e3-a3ba-3085a9ad2002', 'Защита от протечек'),
(103, '6901edf9-36ff-11e3-a3ba-3085a9ad2002', 'Защита от детей'),
(104, '6901edfc-36ff-11e3-a3ba-3085a9ad2002', 'Таймер отсрочки запуска'),
(105, '6901edff-36ff-11e3-a3ba-3085a9ad2002', 'Индикатор наличия соли/ополаскивателя'),
(106, '6901ee04-36ff-11e3-a3ba-3085a9ad2002', 'Расположение'),
(107, 'e7c59cb9-297e-11e3-aa52-3085a9ad2002', 'Wi-Fi'),
(108, 'c057dbc3-3b7e-11e3-b146-3085a9ad2002', 'Антибактериальное покрытие'),
(109, 'c057dbc5-3b7e-11e3-b146-3085a9ad2002', 'Антибактериальное покрытие'),
(110, 'c057dbcc-3b7e-11e3-b146-3085a9ad2002', 'Расположение морозильной камеры'),
(111, 'c057dbce-3b7e-11e3-b146-3085a9ad2002', 'Генератор льда'),
(112, 'c057dbd8-3b7e-11e3-b146-3085a9ad2002', 'Система подачи холодной воды'),
(113, 'c057dbde-3b7e-11e3-b146-3085a9ad2002', 'Зона свежести'),
(114, 'c057dbe1-3b7e-11e3-b146-3085a9ad2002', 'Зона свежести'),
(115, 'c057dbe9-3b7e-11e3-b146-3085a9ad2002', 'Система подачи холодной воды'),
(116, 'e0d617d9-3ba1-11e3-b146-3085a9ad2002', 'Тип'),
(117, 'e0d617db-3ba1-11e3-b146-3085a9ad2002', 'Число скоростей'),
(118, 'e0d617de-3ba1-11e3-b146-3085a9ad2002', 'Питание'),
(119, 'e0d617e1-3ba1-11e3-b146-3085a9ad2002', 'Использование с применением пены'),
(120, 'e0d617e4-3ba1-11e3-b146-3085a9ad2002', 'Количество пинцетов'),
(121, 'e0d617e6-3ba1-11e3-b146-3085a9ad2002', 'Подсветка'),
(122, 'e0d617e9-3ba1-11e3-b146-3085a9ad2002', 'В комплекте'),
(123, 'e0d617eb-3ba1-11e3-b146-3085a9ad2002', 'Промывка насадки под водой'),
(124, 'e0d617ee-3ba1-11e3-b146-3085a9ad2002', 'Насадки'),
(125, 'e0d617f7-3ba1-11e3-b146-3085a9ad2002', 'Эпиляционная система из 3 роторных головок'),
(126, '1ad02233-3bb9-11e3-b146-3085a9ad2002', 'Варочная панель'),
(127, '1ad02235-3bb9-11e3-b146-3085a9ad2002', 'Духовка'),
(128, '1ad02237-3bb9-11e3-b146-3085a9ad2002', 'Размеры (ШхГхВ)'),
(129, '1ad02239-3bb9-11e3-b146-3085a9ad2002', 'Объем духовки'),
(130, '1ad0223b-3bb9-11e3-b146-3085a9ad2002', 'Дверца'),
(131, '1ad0223d-3bb9-11e3-b146-3085a9ad2002', 'Гриль'),
(132, '1ad0223f-3bb9-11e3-b146-3085a9ad2002', 'Конвекция'),
(133, '1ad02242-3bb9-11e3-b146-3085a9ad2002', 'Количество стекол дверцы духовки'),
(134, '1ad02245-3bb9-11e3-b146-3085a9ad2002', 'Подсветка'),
(135, '1ad02248-3bb9-11e3-b146-3085a9ad2002', 'Рабочая поверхность'),
(136, '1ad0224a-3bb9-11e3-b146-3085a9ad2002', 'Количество конфорок'),
(137, '1ad0224c-3bb9-11e3-b146-3085a9ad2002', 'Газ-контроль конфорок'),
(138, '1ad0224e-3bb9-11e3-b146-3085a9ad2002', 'Ящик для посуды'),
(139, '1ad02251-3bb9-11e3-b146-3085a9ad2002', 'Цвет'),
(140, '1ad02257-3bb9-11e3-b146-3085a9ad2002', 'Варочная панель'),
(141, '1ad02259-3bb9-11e3-b146-3085a9ad2002', 'Электроподжиг '),
(142, '1ad0225d-3bb9-11e3-b146-3085a9ad2002', 'Газ-контроль духовки'),
(143, '1ad0225f-3bb9-11e3-b146-3085a9ad2002', 'Конвекция'),
(144, '1ad02261-3bb9-11e3-b146-3085a9ad2002', 'Духовка'),
(145, '1ad02263-3bb9-11e3-b146-3085a9ad2002', 'Размеры (ШхГхВ)'),
(146, '5db77cce-2c90-11e3-b4cb-3085a9ad2002', 'Материал полок'),
(147, '5db77ccf-2c90-11e3-b4cb-3085a9ad2002', 'Тип'),
(148, '5db77cd0-2c90-11e3-b4cb-3085a9ad2002', 'Общий объем '),
(149, '5db77cd2-2c90-11e3-b4cb-3085a9ad2002', 'Объем холодильной камеры'),
(150, '5db77cd3-2c90-11e3-b4cb-3085a9ad2002', 'Цвет'),
(151, '5db77cf6-2c90-11e3-b4cb-3085a9ad2002', 'Морозильная камера'),
(152, '5db77cf7-2c90-11e3-b4cb-3085a9ad2002', 'Габариты (ШxГxВ)'),
(153, '5db77cf8-2c90-11e3-b4cb-3085a9ad2002', 'Размораживание холодильной камеры'),
(154, '5db77cf9-2c90-11e3-b4cb-3085a9ad2002', 'Размораживание морозильной камеры'),
(155, 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'цвет'),
(156, 'e301bbf8-3c4b-11e3-b555-3085a9ad2002', 'Объем духовки'),
(157, 'e301bbfe-3c4b-11e3-b555-3085a9ad2002', 'Размеры (ШхГхВ)'),
(158, 'e301bbff-3c4b-11e3-b555-3085a9ad2002', 'Духовка'),
(159, 'e301bc00-3c4b-11e3-b555-3085a9ad2002', 'Объем духовки'),
(160, 'e301bc08-3c4b-11e3-b555-3085a9ad2002', 'Конвекция'),
(161, 'e301bc0f-3c4b-11e3-b555-3085a9ad2002', 'Дисплей'),
(162, 'e301bc17-3c4b-11e3-b555-3085a9ad2002', 'Дисплей'),
(163, 'e301bc24-3c4b-11e3-b555-3085a9ad2002', 'Тип'),
(164, 'e301bc26-3c4b-11e3-b555-3085a9ad2002', 'Объём'),
(165, 'e301bc28-3c4b-11e3-b555-3085a9ad2002', 'Мощность'),
(166, 'e301bc2a-3c4b-11e3-b555-3085a9ad2002', 'Насос'),
(167, 'e301bc2c-3c4b-11e3-b555-3085a9ad2002', 'Размер (ШхВхГ)'),
(168, 'e301bc2d-3c4b-11e3-b555-3085a9ad2002', 'Индикатор уровня воды'),
(169, 'e301bc2e-3c4b-11e3-b555-3085a9ad2002', 'Отключение при закипании'),
(170, 'e301bc2f-3c4b-11e3-b555-3085a9ad2002', 'Цвет'),
(171, 'ebd14731-3c69-11e3-b555-3085a9ad2002', 'Тип'),
(172, 'ebd14733-3c69-11e3-b555-3085a9ad2002', 'Объем'),
(173, 'ebd14735-3c69-11e3-b555-3085a9ad2002', 'Мощность'),
(174, 'ebd14737-3c69-11e3-b555-3085a9ad2002', 'Материал корпуса'),
(175, 'ebd14739-3c69-11e3-b555-3085a9ad2002', 'Фильтр'),
(176, 'ebd1473c-3c69-11e3-b555-3085a9ad2002', 'Индикатор уровня воды'),
(177, 'ebd1473f-3c69-11e3-b555-3085a9ad2002', 'Подсветка воды при работе'),
(178, 'ebd14742-3c69-11e3-b555-3085a9ad2002', 'Покрытие нагревательного элемента'),
(179, 'ebd14744-3c69-11e3-b555-3085a9ad2002', 'Индикация включения'),
(180, 'ebd1474c-3c69-11e3-b555-3085a9ad2002', 'Нагревательный элемент'),
(181, 'facde499-4100-11e3-bd6f-3085a9ad2002', 'Тип'),
(182, 'facde49b-4100-11e3-bd6f-3085a9ad2002', 'Масштабирование до разрешения HDTV'),
(183, 'facde49d-4100-11e3-bd6f-3085a9ad2002', 'Караоке'),
(184, 'facde49f-4100-11e3-bd6f-3085a9ad2002', 'Поддерживаемые носители'),
(185, 'facde4a1-4100-11e3-bd6f-3085a9ad2002', 'Поддерживаемые форматы'),
(186, 'facde4a3-4100-11e3-bd6f-3085a9ad2002', 'Выходы'),
(187, 'facde4a5-4100-11e3-bd6f-3085a9ad2002', 'Цвет'),
(188, 'facde4a7-4100-11e3-bd6f-3085a9ad2002', 'Доступ в интернет'),
(189, 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'Тип'),
(190, 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'Выходы'),
(191, 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'Поддерживаемые носители'),
(192, 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'Поддерживаемые форматы'),
(193, 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'Караоке'),
(194, 'facde4cf-4100-11e3-bd6f-3085a9ad2002', 'Суммарная вых. мощность АС'),
(195, 'd79d748c-4115-11e3-bd6f-3085a9ad2002', 'Тип'),
(196, 'd79d748e-4115-11e3-bd6f-3085a9ad2002', 'Мощность'),
(197, 'd79d7490-4115-11e3-bd6f-3085a9ad2002', 'Складная ручка'),
(198, 'd79d7493-4115-11e3-bd6f-3085a9ad2002', 'В комплекте'),
(199, 'd79d7495-4115-11e3-bd6f-3085a9ad2002', 'Длина сетевого шнура'),
(200, 'd79d7497-4115-11e3-bd6f-3085a9ad2002', 'Цвет'),
(201, 'd79d74a8-4115-11e3-bd6f-3085a9ad2002', 'Количество режимов');

-- --------------------------------------------------------

--
-- Table structure for table `shop_items`
--

CREATE TABLE IF NOT EXISTS `shop_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` tinytext NOT NULL,
  `owner_id` tinytext NOT NULL,
  `article` tinytext NOT NULL,
  `parent_group_id` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  `small_desc` text,
  `price_old` decimal(10,2) NOT NULL,
  `remains` int(10) NOT NULL DEFAULT '0',
  `is_hit` tinyint(1) NOT NULL,
  `is_new` tinyint(1) NOT NULL,
  `uri` tinytext NOT NULL,
  `md` tinytext NOT NULL,
  `mk` tinytext NOT NULL,
  `title` tinytext NOT NULL,
  `inprice` tinyint(1) NOT NULL,
  PRIMARY KEY (`item_id`(255)),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=94 ;

--
-- Dumping data for table `shop_items`
--

INSERT INTO `shop_items` (`id`, `item_id`, `owner_id`, `article`, `parent_group_id`, `name`, `description`, `small_desc`, `price_old`, `remains`, `is_hit`, `is_new`, `uri`, `md`, `mk`, `title`, `inprice`) VALUES
(1, '2af4bd3e-2bfc-11e3-805a-3085a9ad2002', '0', '', '2af4bd3d-2bfc-11e3-805a-3085a9ad2002', ' Samsung MМ- E330	', '', ' Samsung MМ- E330	', '1000000.00', 4, 0, 1, 'item1', '', '', '', 0),
(2, 'eac5a9c1-2bc6-11e3-a234-3085a9ad2002', '0', '', 'f0caf541-2b2f-11e3-8ef3-3085a9ad2002', 'DVD Bbk DV - 522SI', '', '', '0.00', 0, 0, 0, 'item2', '', '', '', 0),
(3, 'eac5a9be-2bc6-11e3-a234-3085a9ad2002', '0', '', 'f0caf541-2b2f-11e3-8ef3-3085a9ad2002', 'DVD Bbk DV -438SI', '', '', '0.00', 1, 0, 0, 'item3', '', '', '', 0),
(4, 'f7d8ffbe-2bca-11e3-805a-3085a9ad2002', '0', '', 'f0caf541-2b2f-11e3-8ef3-3085a9ad2002', 'DVD Bbk DVK - 1100X', '', '', '0.00', 3, 0, 0, 'item4', '', '', '', 0),
(5, 'eac5a9c4-2bc6-11e3-a234-3085a9ad2002', '0', '', 'f0caf541-2b2f-11e3-8ef3-3085a9ad2002', 'DVD Bbk DVP - 153SI', '', '', '0.00', 0, 0, 0, 'item5', '', '', '', 0),
(6, 'eac5a9c7-2bc6-11e3-a234-3085a9ad2002', '0', '', 'f0caf541-2b2f-11e3-8ef3-3085a9ad2002', 'DVD Bbk DVP - 154SI', '', '', '0.00', 2, 0, 0, 'item6', '', '', '', 0),
(7, 'f7d8ffb5-2bca-11e3-805a-3085a9ad2002', '0', '', 'f0caf541-2b2f-11e3-8ef3-3085a9ad2002', 'DVD Bbk DVP - 155SI', '', '', '0.00', 3, 0, 0, 'item7', '', '', '', 0),
(8, 'f0caf53f-2b2f-11e3-8ef3-3085a9ad2002', '0', '', 'f0caf541-2b2f-11e3-8ef3-3085a9ad2002', 'DVD Bbk DVP - 157SI', '', '', '0.00', 4, 0, 0, 'item8', '', '', '', 0),
(9, 'f7d8ffb8-2bca-11e3-805a-3085a9ad2002', '0', '', 'f0caf541-2b2f-11e3-8ef3-3085a9ad2002', 'DVD Bbk DVP - 159SI', '', '', '0.00', 1, 0, 0, 'item9', '', '', '', 0),
(10, 'f7d8ffbb-2bca-11e3-805a-3085a9ad2002', '0', '', 'f0caf541-2b2f-11e3-8ef3-3085a9ad2002', 'DVD Bbk DVP - 457SI', '', '', '0.00', 4, 0, 0, 'item10', '', '', '', 0),
(11, 'f7d8ffc3-2bca-11e3-805a-3085a9ad2002', '0', '', 'd75de788-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Erisson-DVD1115', '', '', '0.00', 3, 0, 0, 'item11', '', '', '', 0),
(12, 'f7d8ffc6-2bca-11e3-805a-3085a9ad2002', '0', '', 'd75de788-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Erisson-DVD1140', '', '', '0.00', 3, 0, 0, 'item12', '', '', '', 0),
(13, 'f7d8ffc9-2bca-11e3-805a-3085a9ad2002', '0', '', 'd75de789-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Fusion FD-U148X', '', '', '0.00', 4, 0, 0, 'item13', '', '', '', 0),
(14, 'f7d8ffcc-2bca-11e3-805a-3085a9ad2002', '0', '', 'd75de789-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Fusion FD-U157X', '', '', '0.00', 2, 0, 0, 'item14', '', '', '', 0),
(15, 'f7d8ffcf-2bca-11e3-805a-3085a9ad2002', '0', '', 'd75de789-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Fusion FD-U163X', '', '', '0.00', 4, 0, 0, 'item15', '', '', '', 0),
(16, 'f7d8ffd2-2bca-11e3-805a-3085a9ad2002', '0', '', 'f7d8ffef-2bca-11e3-805a-3085a9ad2002', 'DVD LG BD620  BLU-RAY', '', '', '0.00', 3, 0, 0, 'item16', '', '', '', 0),
(17, 'f7d8ffd7-2bca-11e3-805a-3085a9ad2002', '0', '', 'f7d8ffef-2bca-11e3-805a-3085a9ad2002', 'DVD LG BD650K  BLU-RAY', '', '', '0.00', 4, 0, 0, 'item17', '', '', '', 0),
(18, 'f7d8ffda-2bca-11e3-805a-3085a9ad2002', '0', '', 'f7d8ffef-2bca-11e3-805a-3085a9ad2002', 'DVD LG BD660K  BLU-RAY', '', '', '0.00', 4, 0, 0, 'item18', '', '', '', 0),
(19, 'f7d8ffdd-2bca-11e3-805a-3085a9ad2002', '0', '', 'f7d8ffef-2bca-11e3-805a-3085a9ad2002', 'DVD LG BD670 BLU-RAY', '', '', '0.00', 3, 0, 0, 'item19', '', '', '', 0),
(20, 'f7d8ffe0-2bca-11e3-805a-3085a9ad2002', '0', '', 'f7d8ffef-2bca-11e3-805a-3085a9ad2002', 'DVD LG BP325', '', '', '0.00', 3, 0, 0, 'item20', '', '', '', 0),
(21, 'f7d8fff1-2bca-11e3-805a-3085a9ad2002', '0', '', 'f7d8ffef-2bca-11e3-805a-3085a9ad2002', 'DVD LG BP420К', '', '', '0.00', 3, 0, 0, 'item21', '', '', '', 0),
(22, 'f7d8fff4-2bca-11e3-805a-3085a9ad2002', '0', '', 'f7d8ffef-2bca-11e3-805a-3085a9ad2002', 'DVD LG BP620', '', '', '0.00', 4, 0, 0, 'item22', '', '', '', 0),
(23, '9ef1d6be-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78a-2b3d-11e3-8ef3-3085a9ad2002', 'DVD LG DKS3000 DVD+Караоке', '', '', '0.00', 3, 0, 0, 'item23', '', '', '', 0),
(24, '9ef1d6c1-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78a-2b3d-11e3-8ef3-3085a9ad2002', 'DVD LG DKS9500H DVD+Караоке', '', '', '0.00', 3, 0, 0, 'item24', '', '', '', 0),
(25, '9ef1d6c4-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78a-2b3d-11e3-8ef3-3085a9ad2002', 'DVD LG DP - 122', '', '', '0.00', 3, 0, 0, 'item25', '', '', '', 0),
(26, '9ef1d6c7-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78a-2b3d-11e3-8ef3-3085a9ad2002', 'DVD LG DVX - 632K', '', '', '0.00', 4, 0, 0, 'item26', '', '', '', 0),
(27, '9ef1d6ca-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78b-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Mystery MDV - 621U', '', '', '0.00', 3, 0, 0, 'item27', '', '', '', 0),
(28, '9ef1d6ce-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78b-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Mystery MDV - 726U', '', '', '0.00', 3, 0, 0, 'item28', '', '', '', 0),
(29, '9ef1d6d1-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78b-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Mystery MDV - 727U', '', '', '0.00', 3, 0, 0, 'item29', '', '', '', 0),
(30, '9ef1d6d4-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78b-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Mystery MDV - 728U', '', '', '0.00', 2, 0, 0, 'item30', '', '', '', 0),
(31, '9ef1d6d7-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78b-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Mystery MDV - 729U', '', '', '0.00', 4, 0, 0, 'item31', '', '', '', 0),
(32, '9ef1d6da-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78b-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Mystery MDV - 729U', '', '', '0.00', 3, 0, 0, 'item32', '', '', '', 0),
(33, '9ef1d6dc-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78b-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Mystery MDV - 732U', '', '', '0.00', 3, 0, 0, 'item33', '', '', '', 0),
(34, '9ef1d6e9-2bda-11e3-805a-3085a9ad2002', '0', '', '9ef1d6e8-2bda-11e3-805a-3085a9ad2002', 'DVD Philips - BDP 2600/51', '', '', '0.00', 4, 0, 0, 'item34', '', '', '', 0),
(35, '9ef1d6ec-2bda-11e3-805a-3085a9ad2002', '0', '', '9ef1d6e8-2bda-11e3-805a-3085a9ad2002', 'DVD Philips - BDP 3000/51', '', '', '0.00', 3, 0, 0, 'item35', '', '', '', 0),
(36, '9ef1d6f2-2bda-11e3-805a-3085a9ad2002', '0', '', '9ef1d6e8-2bda-11e3-805a-3085a9ad2002', 'DVD Philips - BDP 3385K/51', '', '', '0.00', 2, 0, 0, 'item36', '', '', '', 0),
(37, '9ef1d6e5-2bda-11e3-805a-3085a9ad2002', '0', '', '9ef1d6e8-2bda-11e3-805a-3085a9ad2002', 'DVD Philips - BDP 5100/51', '', '', '0.00', 3, 0, 0, 'item37', '', '', '', 0),
(38, '9ef1d6ef-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78c-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Philips - BDP 5100/51', '', '', '0.00', 2, 0, 0, 'item38', '', '', '', 0),
(39, '9ef1d6f8-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78c-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Philips - DVP3110K /51', '', '', '0.00', 3, 0, 0, 'item39', '', '', '', 0),
(40, '9ef1d6f5-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78c-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Philips - DVP3310К/51', '', '', '0.00', 2, 0, 0, 'item40', '', '', '', 0),
(41, '9ef1d6fb-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78c-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Philips - DVP3650/51', '', '', '0.00', 2, 0, 0, 'item41', '', '', '', 0),
(42, '6ed93b96-3f6e-11e3-a1f8-3085a9ad2002', '0', '', 'd75de78d-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Pioneer DV - 2020', '', '', '0.00', 0, 0, 0, 'item42', '', '', '', 0),
(43, '9ef1d6df-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de78d-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Pioneer DV - 2240', '', '', '0.00', 3, 0, 0, 'item43', '', '', '', 0),
(44, '32f8a52c-2be6-11e3-805a-3085a9ad2002', '0', '', '32f8a535-2be6-11e3-805a-3085a9ad2002', 'DVD Samsung - BD - E5300', '', '', '0.00', 3, 0, 0, 'item44', '', '', '', 0),
(45, '32f8a52f-2be6-11e3-805a-3085a9ad2002', '0', '', '32f8a535-2be6-11e3-805a-3085a9ad2002', 'DVD Samsung - BD - E5500', '', '', '0.00', 2, 0, 0, 'item45', '', '', '', 0),
(46, '32f8a539-2be6-11e3-805a-3085a9ad2002', '0', '', 'd75de78e-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Samsung C550', '', '', '0.00', 3, 0, 0, 'item46', '', '', '', 0),
(47, '32f8a532-2be6-11e3-805a-3085a9ad2002', '0', '', 'd75de78e-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Samsung E350/RU', '', '', '0.00', 4, 0, 0, 'item47', '', '', '', 0),
(48, '32f8a536-2be6-11e3-805a-3085a9ad2002', '0', '', 'd75de78e-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Samsung F1080/XER', '', '', '0.00', 2, 0, 0, 'item48', '', '', '', 0),
(49, '32f8a542-2be6-11e3-805a-3085a9ad2002', '0', '', '32f8a546-2be6-11e3-805a-3085a9ad2002', 'DVD Soni BDP - S350', '', '', '0.00', 3, 0, 0, 'item49', '', '', '', 0),
(50, '32f8a53c-2be6-11e3-805a-3085a9ad2002', '0', '', 'd75de78f-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Soni DVP - SR120', '', '', '0.00', 3, 0, 0, 'item50', '', '', '', 0),
(51, '32f8a53f-2be6-11e3-805a-3085a9ad2002', '0', '', 'd75de78f-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Soni DVP - SR450', '', '', '0.00', 3, 0, 0, 'item51', '', '', '', 0),
(52, '32f8a547-2be6-11e3-805a-3085a9ad2002', '0', '', 'd75de790-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Supra DVS-013X', '', '', '0.00', 2, 0, 0, 'item52', '', '', '', 0),
(53, '32f8a54a-2be6-11e3-805a-3085a9ad2002', '0', '', 'd75de790-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Supra DVS-055XK', '', '', '0.00', 3, 0, 0, 'item53', '', '', '', 0),
(54, '32f8a54d-2be6-11e3-805a-3085a9ad2002', '0', '', 'd75de790-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Supra DVS-065XK', '', '', '0.00', 3, 0, 0, 'item54', '', '', '', 0),
(55, '32f8a550-2be6-11e3-805a-3085a9ad2002', '0', '', 'd75de790-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Supra DVS-102X', '', '', '0.00', 3, 0, 0, 'item55', '', '', '', 0),
(56, '9ef1d6e2-2bda-11e3-805a-3085a9ad2002', '0', '', 'd75de791-2b3d-11e3-8ef3-3085a9ad2002', 'DVD Toshiba - BDX2000', '', '', '0.00', 4, 0, 0, 'item56', '', '', '', 0),
(57, '32f8a566-2be6-11e3-805a-3085a9ad2002', '0', '', '32f8a556-2be6-11e3-805a-3085a9ad2002', 'Дом.кинотеатр  Philips HTS 3593	', '', '', '0.00', 4, 0, 0, 'item57', '', '', '', 0),
(58, '2af4bd2c-2bfc-11e3-805a-3085a9ad2002', '0', '', '32f8a555-2be6-11e3-805a-3085a9ad2002', 'Дом.кинотеатр  Samsung HT-E350K	', '', '', '0.00', 3, 0, 0, 'item58', '', '', '', 0),
(59, '2af4bd2f-2bfc-11e3-805a-3085a9ad2002', '0', '', '32f8a555-2be6-11e3-805a-3085a9ad2002', 'Дом.кинотеатр  Samsung HT-E3550	', '', '', '0.00', 3, 0, 0, 'item59', '', '', '', 0),
(60, '2af4bd36-2bfc-11e3-805a-3085a9ad2002', '0', '', '32f8a555-2be6-11e3-805a-3085a9ad2002', 'Дом.кинотеатр  Samsung HT-E6750WK	', '', '', '0.00', 3, 0, 0, 'item60', '', '', '', 0),
(61, '2af4bd33-2bfc-11e3-805a-3085a9ad2002', '0', '', '32f8a555-2be6-11e3-805a-3085a9ad2002', 'Дом.кинотеатр  Samsung HT-E8000	', '', '', '0.00', 3, 0, 0, 'item61', '', '', '', 0),
(62, '32f8a557-2be6-11e3-805a-3085a9ad2002', '0', '', '32f8a554-2be6-11e3-805a-3085a9ad2002', 'Домашний кинотеатр LG ВН-4430Р	', '', '', '0.00', 3, 0, 0, 'item62', '', '', '', 0),
(63, '32f8a560-2be6-11e3-805a-3085a9ad2002', '0', '', '32f8a554-2be6-11e3-805a-3085a9ad2002', 'Домашний кинотеатр LG ВН-4530Т	', '', '', '0.00', 4, 0, 0, 'item63', '', '', '', 0),
(64, '44927af5-315d-11e3-a2d2-3085a9ad2002', '0', '', '44927af8-315d-11e3-a2d2-3085a9ad2002', 'Массажер  Ves 3000', '', '', '0.00', 0, 0, 0, 'item64', '', '', '', 0),
(65, '3696657e-314e-11e3-a2d2-3085a9ad2002', '0', '', '3696657d-314e-11e3-a2d2-3085a9ad2002', 'Массажер Scarlet 201	', '', '', '0.00', 0, 0, 0, 'item65', '', '', '', 0),
(66, '44927aef-315d-11e3-a2d2-3085a9ad2002', '0', '', '3696657d-314e-11e3-a2d2-3085a9ad2002', 'Массажер Scarlet 202', '', '', '0.00', 0, 0, 0, 'item66', '', '', '', 0),
(67, '44927af2-315d-11e3-a2d2-3085a9ad2002', '0', '', '3696657d-314e-11e3-a2d2-3085a9ad2002', 'Массажер Scarlet 205', '', '', '0.00', 0, 0, 0, 'item67', '', '', '', 0),
(68, '5db77ccb-2c90-11e3-b4cb-3085a9ad2002', '0', '', '2af4bd3c-2bfc-11e3-805a-3085a9ad2002', 'Музыкальный центр LG LM - DM - 2520K', '', '', '0.00', 3, 0, 0, 'item68', '', '', '', 0),
(69, '5db77ce4-2c90-11e3-b4cb-3085a9ad2002', '0', '', '2af4bd3c-2bfc-11e3-805a-3085a9ad2002', 'Музыкальный центр LG LM - DM - 2820', '', '', '0.00', 4, 0, 0, 'item69', '', '', '', 0),
(70, '5db77ce7-2c90-11e3-b4cb-3085a9ad2002', '0', '', '2af4bd3c-2bfc-11e3-805a-3085a9ad2002', 'Музыкальный центр LG XA - 14', '', '', '0.00', 3, 0, 0, 'item70', '', '', '', 0),
(71, '5db77ceb-2c90-11e3-b4cb-3085a9ad2002', '0', '', '2af4bd3c-2bfc-11e3-805a-3085a9ad2002', 'Музыкальный центр LG XB - 16', '', '', '0.00', 3, 0, 0, 'item71', '', '', '', 0),
(72, '3ae00f3e-323d-11e3-85c9-3085a9ad2002', '0', '', '3ae00f39-323d-11e3-85c9-3085a9ad2002', 'радио часы ERISSON RC-2202A	', '', '', '0.00', 0, 0, 0, 'item72', '', '', '', 0),
(73, '3ae00f41-323d-11e3-85c9-3085a9ad2002', '0', '', '3ae00f39-323d-11e3-85c9-3085a9ad2002', 'радио часы ERISSON RC-2255	', '', '', '0.00', 0, 0, 0, 'item73', '', '', '', 0),
(74, '3ae00f47-323d-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3a-323d-11e3-85c9-3085a9ad2002', 'Радио часы Hyundai H-1516	', '', '', '0.00', 0, 0, 0, 'item74', '', '', '', 0),
(75, '3ae00f44-323d-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3a-323d-11e3-85c9-3085a9ad2002', 'Радио часы Hyundai H-1518	', '', '', '0.00', 0, 0, 0, 'item75', '', '', '', 0),
(76, '3ae00f4a-323d-11e3-85c9-3085a9ad2002', '0', '', 'c5f78ac2-3244-11e3-85c9-3085a9ad2002', 'радио часы Philips AJ 3115/12	', '', '', '0.00', 0, 0, 0, 'item76', '', '', '', 0),
(77, '3ae00f4d-323d-11e3-85c9-3085a9ad2002', '0', '', 'c5f78ac2-3244-11e3-85c9-3085a9ad2002', 'радио часы Philips AJ 3121/12	', '', '', '0.00', 0, 0, 0, 'item77', '', '', '', 0),
(78, 'c5f78ac3-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3c-323d-11e3-85c9-3085a9ad2002', 'Радио часы SUPRA 26FM	', '', '', '0.00', 0, 0, 0, 'item78', '', '', '', 0),
(79, 'c5f78abd-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3c-323d-11e3-85c9-3085a9ad2002', 'Радио часы SUPRA 32FM	', '', '', '0.00', 0, 0, 0, 'item79', '', '', '', 0),
(80, 'c5f78ac6-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3d-323d-11e3-85c9-3085a9ad2002', 'радио часы vitek - 3509	', '', '', '0.00', 0, 0, 0, 'item80', '', '', '', 0),
(81, 'c5f78ac9-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3d-323d-11e3-85c9-3085a9ad2002', 'радио часы vitek - 3510	', '', '', '0.00', 0, 0, 0, 'item81', '', '', '', 0),
(82, 'c5f78acc-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3d-323d-11e3-85c9-3085a9ad2002', 'радио часы vitek - 3511	', '', '', '0.00', 0, 0, 0, 'item82', '', '', '', 0),
(83, 'c5f78acf-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3d-323d-11e3-85c9-3085a9ad2002', 'радио часы vitek - 3515	', '', '', '0.00', 0, 0, 0, 'item83', '', '', '', 0),
(84, 'c5f78ad2-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3d-323d-11e3-85c9-3085a9ad2002', 'радио часы vitek - 3519	', '', '', '0.00', 0, 0, 0, 'item84', '', '', '', 0),
(85, 'c5f78ad5-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3d-323d-11e3-85c9-3085a9ad2002', 'радио часы vitek - 3520', '', '', '0.00', 0, 0, 0, 'item85', '', '', '', 0),
(86, 'c5f78ad8-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3d-323d-11e3-85c9-3085a9ad2002', 'радио часы vitek - 3523', '', '', '0.00', 0, 0, 0, 'item86', '', '', '', 0),
(87, 'c5f78adb-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3d-323d-11e3-85c9-3085a9ad2002', 'радио часы vitek - 3527', '', '', '0.00', 0, 0, 0, 'item87', '', '', '', 0),
(88, 'c5f78ade-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3d-323d-11e3-85c9-3085a9ad2002', 'радио часы vitek - 3539', '', '', '0.00', 0, 0, 0, 'item88', '', '', '', 0),
(89, 'c5f78ae1-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3d-323d-11e3-85c9-3085a9ad2002', 'радио часы vitek - 3543', '', '', '0.00', 0, 0, 0, 'item89', '', '', '', 0),
(90, 'c5f78ae4-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3d-323d-11e3-85c9-3085a9ad2002', 'радио часы vitek - 4052', '', '', '0.00', 0, 0, 0, 'item90', '', '', '', 0),
(91, 'c5f78ae7-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3d-323d-11e3-85c9-3085a9ad2002', 'радио часы vitek - 6601', '', '', '0.00', 0, 0, 0, 'item91', '', '', '', 0),
(92, 'c5f78ab7-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3b-323d-11e3-85c9-3085a9ad2002', 'радио-будильник Philips AJ 3123/12	', '', '', '0.00', 0, 0, 0, 'item92', '', '', '', 0),
(93, 'c5f78aba-3244-11e3-85c9-3085a9ad2002', '0', '', '3ae00f3b-323d-11e3-85c9-3085a9ad2002', 'радио-будильник Philips AJ 3551/12	', '', '', '0.00', 0, 0, 0, 'item93', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shop_orders`
--

CREATE TABLE IF NOT EXISTS `shop_orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` tinytext NOT NULL,
  `name` text NOT NULL,
  `surname` text NOT NULL,
  `patronymic` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_org` int(11) NOT NULL,
  `town_id` int(11) NOT NULL,
  `shipment_id` int(11) NOT NULL,
  `payment_id` text NOT NULL,
  `summ` decimal(10,2) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `date` datetime NOT NULL,
  `data` longtext NOT NULL,
  `order_data` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `shop_orders`
--

INSERT INTO `shop_orders` (`id`, `email`, `name`, `surname`, `patronymic`, `user_id`, `user_org`, `town_id`, `shipment_id`, `payment_id`, `summ`, `state`, `date`, `data`, `order_data`) VALUES
(1, 'yorkshp@gmail.com', 'Юрий', 'Шпынёв', 'Борисович', 19, 0, 0, 1, 'cashpayment', '0.00', 0, '2013-07-05 11:14:21', '{"discountType":"","discountValue":"","sname":"1","town2":"","ddate2":"","adrr":"","ddate":"","pname":"cashpayment","comment":"\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t"}', '{"0":{"item_id":"uv0puyc8-zuvl-3f5t-h155-ytzyzcz2lenz","parent_group_id":"kuk35mfx-vg9s-xvtr-muyo-1xvrdir5aknk","name":"\\u0420\\u0443\\u0431\\u0438\\u043d, \\u0442\\u0435\\u043b\\u0435\\u0432\\u0438\\u0437\\u043e\\u0440 \\u043d\\u043e\\u0432\\u043e\\u0433\\u043e \\u043f\\u043e\\u043a\\u043e\\u043b\\u0435\\u043d\\u0438\\u044f","price":"39000.00","quantity":"1","uri":"ru","thumb":"","total":"39 000.00"},"1":{"item_id":"pnpkrdjl-kvdr-fulj-liab-7mgjx5rny2vk","parent_group_id":"yfeo2agf-h5bh-z7s6-l5em-vb9k4ayvuj5t","name":"3D \\u0422\\u0435\\u043b\\u0435\\u0432\\u0438\\u0437\\u043e\\u0440 \\u0421\\u0430\\u043c\\u0441\\u0443\\u043d\\u0433","price":"60000.00","quantity":"2","uri":"3d-televizor-samsung","thumb":"","total":"120 000.00"},"sprice":"0.00","total":"159 000.00","cost":"159 000.00"}'),
(2, 'yorkshp@gmail.com', 'Юрий', 'Шпынёв', 'Борисович', 19, 1, 0, 1, 'cashpayment', '0.00', 0, '2013-07-05 11:14:23', '{"discountType":"","discountValue":"","sname":"1","town2":"","ddate2":"","adrr":"","ddate":"","pname":"cashpayment","comment":"\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t"}', '{"sprice":"0.00","total":"0.00","cost":"0.00"}'),
(3, 'yorkshp@gmail.com', 'Юрий', 'Шпынёв', 'Борисович', 19, 1, 0, 1, 'cashpayment', '0.00', 0, '2013-07-05 11:14:24', '{"discountType":"","discountValue":"","sname":"1","town2":"","ddate2":"","adrr":"","ddate":"","pname":"cashpayment","comment":"\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t"}', '{"sprice":"0.00","total":"0.00","cost":"0.00"}'),
(4, 'yorkshp@gmail.com', 'Юрий', 'Шпынёв', 'Борисович', 19, 1, 0, 1, 'cashpayment', '0.00', 0, '2013-07-05 11:14:25', '{"discountType":"","discountValue":"","sname":"1","town2":"","ddate2":"","adrr":"","ddate":"","pname":"cashpayment","comment":"\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t"}', '{"sprice":"0.00","total":"0.00","cost":"0.00"}'),
(5, 'yorkshp@gmail.com', 'Юрий', 'Шпынёв', 'Борисович', 19, 1, 0, 1, 'cashpayment', '0.00', 0, '2013-07-05 11:14:26', '{"discountType":"","discountValue":"","sname":"1","town2":"","ddate2":"","adrr":"","ddate":"","pname":"cashpayment","comment":"\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t"}', '{"sprice":"0.00","total":"0.00","cost":"0.00"}'),
(6, 'yorkshp@gmail.com', 'Юрий', 'Шпынёв', 'Борисович', 19, 1, 0, 1, 'cashpayment', '0.00', 0, '2013-07-05 11:14:27', '{"discountType":"","discountValue":"","sname":"1","town2":"","ddate2":"","adrr":"","ddate":"","pname":"cashpayment","comment":"\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t"}', '{"sprice":"0.00","total":"0.00","cost":"0.00"}'),
(7, 'd123@123d.ru', 'ww', 'qqq', 'eee', 21, 0, 0, 1, 'billpayment', '0.00', 0, '2013-10-23 16:05:22', '{"discountType":"","discountValue":"","sname":"1","town2":"","ddate2":"","adrr":"","ddate":"","pname":"billpayment","comment":"\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t"}', '{"0":{"item_id":"913593fe-266a-11e3-805a-3085a9ad2002","parent_group_id":"71430fc4-2673-11e3-805a-3085a9ad2002","name":"\\u0422\\u0435\\u043b\\u0435\\u0432\\u0438\\u0437\\u043e\\u0440 LG -28LN450U","price":"5000.00","quantity":"1","uri":"item545","thumb":"","total":"5 000.00"},"sprice":"0.00","total":"5 000.00","cost":"5 000.00"}'),
(8, 'd123@123d.ru', 'ww', 'qqq', 'eee', 21, 1, 0, 1, 'billpayment', '0.00', 0, '2013-10-23 16:41:59', '{"discountType":"","discountValue":"","sname":"1","town2":"","ddate2":"","adrr":"","ddate":"","pname":"billpayment","comment":"\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t"}', '{"0":{"item_id":"913593fe-266a-11e3-805a-3085a9ad2002","parent_group_id":"71430fc4-2673-11e3-805a-3085a9ad2002","name":"\\u0422\\u0435\\u043b\\u0435\\u0432\\u0438\\u0437\\u043e\\u0440 LG -28LN450U","price":"5000.00","quantity":"35","uri":"item545","thumb":"","total":"175 000.00"},"sprice":"0.00","total":"175 000.00","cost":"175 000.00"}');

-- --------------------------------------------------------

--
-- Table structure for table `shop_org`
--

CREATE TABLE IF NOT EXISTS `shop_org` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `inn` tinytext NOT NULL,
  KEY `id_user` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shop_owner`
--

CREATE TABLE IF NOT EXISTS `shop_owner` (
  `name` tinytext NOT NULL,
  `reprise` tinytext NOT NULL,
  `inn` tinytext NOT NULL,
  `kpp` tinytext NOT NULL,
  `bank` tinytext NOT NULL,
  `bik` tinytext NOT NULL,
  `rcount` tinytext NOT NULL,
  `korr` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shop_owner`
--

INSERT INTO `shop_owner` (`name`, `reprise`, `inn`, `kpp`, `bank`, `bik`, `rcount`, `korr`) VALUES
('ИП Юркова Ирина Анатольевна ', '', '381019592841', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `shop_prices`
--

CREATE TABLE IF NOT EXISTS `shop_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` tinytext NOT NULL,
  `pricetype_id` tinytext NOT NULL,
  `value` decimal(10,2) NOT NULL,
  PRIMARY KEY (`item_id`(100),`pricetype_id`(100),`value`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=94 ;

--
-- Dumping data for table `shop_prices`
--

INSERT INTO `shop_prices` (`id`, `item_id`, `pricetype_id`, `value`) VALUES
(1, '2af4bd3e-2bfc-11e3-805a-3085a9ad2002', '0', '1000.00'),
(2, 'eac5a9c1-2bc6-11e3-a234-3085a9ad2002', '0', '1000.00'),
(3, 'eac5a9be-2bc6-11e3-a234-3085a9ad2002', '0', '1000.00'),
(4, 'f7d8ffbe-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(5, 'eac5a9c4-2bc6-11e3-a234-3085a9ad2002', '0', '1000.00'),
(6, 'eac5a9c7-2bc6-11e3-a234-3085a9ad2002', '0', '1000.00'),
(7, 'f7d8ffb5-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(8, 'f0caf53f-2b2f-11e3-8ef3-3085a9ad2002', '0', '1000.00'),
(9, 'f7d8ffb8-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(10, 'f7d8ffbb-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(11, 'f7d8ffc3-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(12, 'f7d8ffc6-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(13, 'f7d8ffc9-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(14, 'f7d8ffcc-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(15, 'f7d8ffcf-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(16, 'f7d8ffd2-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(17, 'f7d8ffd7-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(18, 'f7d8ffda-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(19, 'f7d8ffdd-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(20, 'f7d8ffe0-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(21, 'f7d8fff1-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(22, 'f7d8fff4-2bca-11e3-805a-3085a9ad2002', '0', '1000.00'),
(23, '9ef1d6be-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(24, '9ef1d6c1-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(25, '9ef1d6c4-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(26, '9ef1d6c7-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(27, '9ef1d6ca-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(28, '9ef1d6ce-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(29, '9ef1d6d1-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(30, '9ef1d6d4-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(31, '9ef1d6d7-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(32, '9ef1d6da-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(33, '9ef1d6dc-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(34, '9ef1d6e9-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(35, '9ef1d6ec-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(36, '9ef1d6f2-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(37, '9ef1d6e5-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(38, '9ef1d6ef-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(39, '9ef1d6f8-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(40, '9ef1d6f5-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(41, '9ef1d6fb-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(42, '6ed93b96-3f6e-11e3-a1f8-3085a9ad2002', '0', '1000.00'),
(43, '9ef1d6df-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(44, '32f8a52c-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(45, '32f8a52f-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(46, '32f8a539-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(47, '32f8a532-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(48, '32f8a536-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(49, '32f8a542-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(50, '32f8a53c-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(51, '32f8a53f-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(52, '32f8a547-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(53, '32f8a54a-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(54, '32f8a54d-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(55, '32f8a550-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(56, '9ef1d6e2-2bda-11e3-805a-3085a9ad2002', '0', '1000.00'),
(57, '32f8a566-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(58, '2af4bd2c-2bfc-11e3-805a-3085a9ad2002', '0', '1000.00'),
(59, '2af4bd2f-2bfc-11e3-805a-3085a9ad2002', '0', '1000.00'),
(60, '2af4bd36-2bfc-11e3-805a-3085a9ad2002', '0', '1000.00'),
(61, '2af4bd33-2bfc-11e3-805a-3085a9ad2002', '0', '1000.00'),
(62, '32f8a557-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(63, '32f8a560-2be6-11e3-805a-3085a9ad2002', '0', '1000.00'),
(64, '44927af5-315d-11e3-a2d2-3085a9ad2002', '0', '1000.00'),
(65, '3696657e-314e-11e3-a2d2-3085a9ad2002', '0', '1000.00'),
(66, '44927aef-315d-11e3-a2d2-3085a9ad2002', '0', '1000.00'),
(67, '44927af2-315d-11e3-a2d2-3085a9ad2002', '0', '1000.00'),
(68, '5db77ccb-2c90-11e3-b4cb-3085a9ad2002', '0', '1000.00'),
(69, '5db77ce4-2c90-11e3-b4cb-3085a9ad2002', '0', '1000.00'),
(70, '5db77ce7-2c90-11e3-b4cb-3085a9ad2002', '0', '1000.00'),
(71, '5db77ceb-2c90-11e3-b4cb-3085a9ad2002', '0', '1000.00'),
(72, '3ae00f3e-323d-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(73, '3ae00f41-323d-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(74, '3ae00f47-323d-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(75, '3ae00f44-323d-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(76, '3ae00f4a-323d-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(77, '3ae00f4d-323d-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(78, 'c5f78ac3-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(79, 'c5f78abd-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(80, 'c5f78ac6-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(81, 'c5f78ac9-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(82, 'c5f78acc-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(83, 'c5f78acf-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(84, 'c5f78ad2-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(85, 'c5f78ad5-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(86, 'c5f78ad8-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(87, 'c5f78adb-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(88, 'c5f78ade-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(89, 'c5f78ae1-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(90, 'c5f78ae4-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(91, 'c5f78ae7-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(92, 'c5f78ab7-3244-11e3-85c9-3085a9ad2002', '0', '1000.00'),
(93, 'c5f78aba-3244-11e3-85c9-3085a9ad2002', '0', '1000.00');

-- --------------------------------------------------------

--
-- Table structure for table `shop_pricestypes`
--

CREATE TABLE IF NOT EXISTS `shop_pricestypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pricetype_id` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`pricetype_id`(255)),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shop_props_assign`
--

CREATE TABLE IF NOT EXISTS `shop_props_assign` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` tinytext NOT NULL,
  `prop_id` tinytext NOT NULL,
  `prop_val_id` tinytext NOT NULL,
  PRIMARY KEY (`item_id`(100),`prop_id`(100),`prop_val_id`(100)),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=299 ;

--
-- Dumping data for table `shop_props_assign`
--

INSERT INTO `shop_props_assign` (`id`, `item_id`, `prop_id`, `prop_val_id`) VALUES
(1, '2af4bd3e-2bfc-11e3-805a-3085a9ad2002', '2af4bd42-2bfc-11e3-805a-3085a9ad2002', '5db77ce2-2c90-11e3-b4cb-3085a9ad2002'),
(2, '2af4bd3e-2bfc-11e3-805a-3085a9ad2002', '5db77cd0-2c90-11e3-b4cb-3085a9ad2002', '5db77cdb-2c90-11e3-b4cb-3085a9ad2002'),
(3, '2af4bd3e-2bfc-11e3-805a-3085a9ad2002', '5db77cd2-2c90-11e3-b4cb-3085a9ad2002', '5db77ce3-2c90-11e3-b4cb-3085a9ad2002'),
(4, '2af4bd3e-2bfc-11e3-805a-3085a9ad2002', '5db77cd3-2c90-11e3-b4cb-3085a9ad2002', '5db77cea-2c90-11e3-b4cb-3085a9ad2002'),
(5, 'eac5a9c4-2bc6-11e3-a234-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(6, 'eac5a9c4-2bc6-11e3-a234-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(7, 'eac5a9c4-2bc6-11e3-a234-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4b6-4100-11e3-bd6f-3085a9ad2002'),
(8, 'eac5a9c4-2bc6-11e3-a234-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(9, 'eac5a9c4-2bc6-11e3-a234-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(10, 'eac5a9c4-2bc6-11e3-a234-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4bc-4100-11e3-bd6f-3085a9ad2002'),
(11, 'eac5a9c7-2bc6-11e3-a234-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4bd-4100-11e3-bd6f-3085a9ad2002'),
(12, 'eac5a9c7-2bc6-11e3-a234-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(13, 'eac5a9c7-2bc6-11e3-a234-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4b6-4100-11e3-bd6f-3085a9ad2002'),
(14, 'eac5a9c7-2bc6-11e3-a234-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(15, 'eac5a9c7-2bc6-11e3-a234-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(16, 'eac5a9c7-2bc6-11e3-a234-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4bc-4100-11e3-bd6f-3085a9ad2002'),
(17, 'f7d8ffb5-2bca-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(18, 'f7d8ffb5-2bca-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(19, 'f7d8ffb5-2bca-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4b6-4100-11e3-bd6f-3085a9ad2002'),
(20, 'f7d8ffb5-2bca-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(21, 'f7d8ffb5-2bca-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(22, 'f7d8ffb5-2bca-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4bc-4100-11e3-bd6f-3085a9ad2002'),
(23, 'f0caf53f-2b2f-11e3-8ef3-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4bd-4100-11e3-bd6f-3085a9ad2002'),
(24, 'f0caf53f-2b2f-11e3-8ef3-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(25, 'f0caf53f-2b2f-11e3-8ef3-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4b6-4100-11e3-bd6f-3085a9ad2002'),
(26, 'f0caf53f-2b2f-11e3-8ef3-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(27, 'f0caf53f-2b2f-11e3-8ef3-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(28, 'f0caf53f-2b2f-11e3-8ef3-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(29, 'f7d8ffb8-2bca-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(30, 'f7d8ffb8-2bca-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(31, 'f7d8ffb8-2bca-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4b6-4100-11e3-bd6f-3085a9ad2002'),
(32, 'f7d8ffb8-2bca-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(33, 'f7d8ffb8-2bca-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(34, 'f7d8ffb8-2bca-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4bc-4100-11e3-bd6f-3085a9ad2002'),
(35, 'f7d8ffbb-2bca-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(36, 'f7d8ffbb-2bca-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(37, 'f7d8ffbb-2bca-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4bf-4100-11e3-bd6f-3085a9ad2002'),
(38, 'f7d8ffbb-2bca-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(39, 'f7d8ffbb-2bca-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(40, 'f7d8ffbb-2bca-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4bc-4100-11e3-bd6f-3085a9ad2002'),
(41, 'f7d8ffc9-2bca-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(42, 'f7d8ffc9-2bca-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(43, 'f7d8ffc9-2bca-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4c0-4100-11e3-bd6f-3085a9ad2002'),
(44, 'f7d8ffc9-2bca-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4c1-4100-11e3-bd6f-3085a9ad2002'),
(45, 'f7d8ffc9-2bca-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4c2-4100-11e3-bd6f-3085a9ad2002'),
(46, 'f7d8ffc9-2bca-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(47, 'f7d8ffcc-2bca-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(48, 'f7d8ffcc-2bca-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(49, 'f7d8ffcc-2bca-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4c0-4100-11e3-bd6f-3085a9ad2002'),
(50, 'f7d8ffcc-2bca-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(51, 'f7d8ffcc-2bca-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4c2-4100-11e3-bd6f-3085a9ad2002'),
(52, 'f7d8ffcc-2bca-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(53, 'f7d8ffcf-2bca-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(54, 'f7d8ffcf-2bca-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(55, 'f7d8ffcf-2bca-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4c3-4100-11e3-bd6f-3085a9ad2002'),
(56, 'f7d8ffcf-2bca-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4c4-4100-11e3-bd6f-3085a9ad2002'),
(57, 'f7d8ffcf-2bca-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4c5-4100-11e3-bd6f-3085a9ad2002'),
(58, 'f7d8ffcf-2bca-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(59, 'f7d8ffd2-2bca-11e3-805a-3085a9ad2002', 'facde499-4100-11e3-bd6f-3085a9ad2002', 'facde49a-4100-11e3-bd6f-3085a9ad2002'),
(60, 'f7d8ffd2-2bca-11e3-805a-3085a9ad2002', 'facde49b-4100-11e3-bd6f-3085a9ad2002', 'facde49c-4100-11e3-bd6f-3085a9ad2002'),
(61, 'f7d8ffd2-2bca-11e3-805a-3085a9ad2002', 'facde49d-4100-11e3-bd6f-3085a9ad2002', 'facde49e-4100-11e3-bd6f-3085a9ad2002'),
(62, 'f7d8ffd2-2bca-11e3-805a-3085a9ad2002', 'facde49f-4100-11e3-bd6f-3085a9ad2002', 'facde4a0-4100-11e3-bd6f-3085a9ad2002'),
(63, 'f7d8ffd2-2bca-11e3-805a-3085a9ad2002', 'facde4a1-4100-11e3-bd6f-3085a9ad2002', 'facde4a2-4100-11e3-bd6f-3085a9ad2002'),
(64, 'f7d8ffd2-2bca-11e3-805a-3085a9ad2002', 'facde4a3-4100-11e3-bd6f-3085a9ad2002', 'facde4a4-4100-11e3-bd6f-3085a9ad2002'),
(65, 'f7d8ffd2-2bca-11e3-805a-3085a9ad2002', 'facde4a5-4100-11e3-bd6f-3085a9ad2002', 'facde4a6-4100-11e3-bd6f-3085a9ad2002'),
(66, 'f7d8ffd2-2bca-11e3-805a-3085a9ad2002', 'facde4a7-4100-11e3-bd6f-3085a9ad2002', 'facde4a9-4100-11e3-bd6f-3085a9ad2002'),
(67, 'f7d8ffd7-2bca-11e3-805a-3085a9ad2002', 'facde499-4100-11e3-bd6f-3085a9ad2002', 'facde49a-4100-11e3-bd6f-3085a9ad2002'),
(68, 'f7d8ffd7-2bca-11e3-805a-3085a9ad2002', 'facde49b-4100-11e3-bd6f-3085a9ad2002', 'facde49c-4100-11e3-bd6f-3085a9ad2002'),
(69, 'f7d8ffd7-2bca-11e3-805a-3085a9ad2002', 'facde49d-4100-11e3-bd6f-3085a9ad2002', 'facde49e-4100-11e3-bd6f-3085a9ad2002'),
(70, 'f7d8ffd7-2bca-11e3-805a-3085a9ad2002', 'facde49f-4100-11e3-bd6f-3085a9ad2002', 'facde4ab-4100-11e3-bd6f-3085a9ad2002'),
(71, 'f7d8ffd7-2bca-11e3-805a-3085a9ad2002', 'facde4a1-4100-11e3-bd6f-3085a9ad2002', 'facde4a2-4100-11e3-bd6f-3085a9ad2002'),
(72, 'f7d8ffd7-2bca-11e3-805a-3085a9ad2002', 'facde4a3-4100-11e3-bd6f-3085a9ad2002', 'facde4aa-4100-11e3-bd6f-3085a9ad2002'),
(73, 'f7d8ffd7-2bca-11e3-805a-3085a9ad2002', 'facde4a5-4100-11e3-bd6f-3085a9ad2002', 'facde4a6-4100-11e3-bd6f-3085a9ad2002'),
(74, 'f7d8ffd7-2bca-11e3-805a-3085a9ad2002', 'facde4a7-4100-11e3-bd6f-3085a9ad2002', 'facde4a8-4100-11e3-bd6f-3085a9ad2002'),
(75, 'f7d8ffda-2bca-11e3-805a-3085a9ad2002', 'facde499-4100-11e3-bd6f-3085a9ad2002', 'facde49a-4100-11e3-bd6f-3085a9ad2002'),
(76, 'f7d8ffda-2bca-11e3-805a-3085a9ad2002', 'facde49b-4100-11e3-bd6f-3085a9ad2002', 'facde49c-4100-11e3-bd6f-3085a9ad2002'),
(77, 'f7d8ffda-2bca-11e3-805a-3085a9ad2002', 'facde49d-4100-11e3-bd6f-3085a9ad2002', 'facde49e-4100-11e3-bd6f-3085a9ad2002'),
(78, 'f7d8ffda-2bca-11e3-805a-3085a9ad2002', 'facde49f-4100-11e3-bd6f-3085a9ad2002', 'facde4ab-4100-11e3-bd6f-3085a9ad2002'),
(79, 'f7d8ffda-2bca-11e3-805a-3085a9ad2002', 'facde4a1-4100-11e3-bd6f-3085a9ad2002', 'facde4a2-4100-11e3-bd6f-3085a9ad2002'),
(80, 'f7d8ffda-2bca-11e3-805a-3085a9ad2002', 'facde4a3-4100-11e3-bd6f-3085a9ad2002', 'facde4aa-4100-11e3-bd6f-3085a9ad2002'),
(81, 'f7d8ffda-2bca-11e3-805a-3085a9ad2002', 'facde4a5-4100-11e3-bd6f-3085a9ad2002', 'facde4a6-4100-11e3-bd6f-3085a9ad2002'),
(82, 'f7d8ffda-2bca-11e3-805a-3085a9ad2002', 'facde4a7-4100-11e3-bd6f-3085a9ad2002', 'facde4a8-4100-11e3-bd6f-3085a9ad2002'),
(83, 'f7d8ffdd-2bca-11e3-805a-3085a9ad2002', 'facde499-4100-11e3-bd6f-3085a9ad2002', 'facde49a-4100-11e3-bd6f-3085a9ad2002'),
(84, 'f7d8ffdd-2bca-11e3-805a-3085a9ad2002', 'facde49b-4100-11e3-bd6f-3085a9ad2002', 'facde49c-4100-11e3-bd6f-3085a9ad2002'),
(85, 'f7d8ffdd-2bca-11e3-805a-3085a9ad2002', 'facde49d-4100-11e3-bd6f-3085a9ad2002', 'facde4ac-4100-11e3-bd6f-3085a9ad2002'),
(86, 'f7d8ffdd-2bca-11e3-805a-3085a9ad2002', 'facde49f-4100-11e3-bd6f-3085a9ad2002', 'facde4ab-4100-11e3-bd6f-3085a9ad2002'),
(87, 'f7d8ffdd-2bca-11e3-805a-3085a9ad2002', 'facde4a1-4100-11e3-bd6f-3085a9ad2002', 'facde4a2-4100-11e3-bd6f-3085a9ad2002'),
(88, 'f7d8ffdd-2bca-11e3-805a-3085a9ad2002', 'facde4a3-4100-11e3-bd6f-3085a9ad2002', 'facde4aa-4100-11e3-bd6f-3085a9ad2002'),
(89, 'f7d8ffdd-2bca-11e3-805a-3085a9ad2002', 'facde4a5-4100-11e3-bd6f-3085a9ad2002', 'facde4a6-4100-11e3-bd6f-3085a9ad2002'),
(90, 'f7d8ffdd-2bca-11e3-805a-3085a9ad2002', 'facde4a7-4100-11e3-bd6f-3085a9ad2002', 'facde4a8-4100-11e3-bd6f-3085a9ad2002'),
(91, 'f7d8ffe0-2bca-11e3-805a-3085a9ad2002', 'facde499-4100-11e3-bd6f-3085a9ad2002', 'facde49a-4100-11e3-bd6f-3085a9ad2002'),
(92, 'f7d8ffe0-2bca-11e3-805a-3085a9ad2002', 'facde49b-4100-11e3-bd6f-3085a9ad2002', 'facde49c-4100-11e3-bd6f-3085a9ad2002'),
(93, 'f7d8ffe0-2bca-11e3-805a-3085a9ad2002', 'facde49d-4100-11e3-bd6f-3085a9ad2002', 'facde4ac-4100-11e3-bd6f-3085a9ad2002'),
(94, 'f7d8ffe0-2bca-11e3-805a-3085a9ad2002', 'facde49f-4100-11e3-bd6f-3085a9ad2002', 'facde4ab-4100-11e3-bd6f-3085a9ad2002'),
(95, 'f7d8ffe0-2bca-11e3-805a-3085a9ad2002', 'facde4a1-4100-11e3-bd6f-3085a9ad2002', 'facde4ae-4100-11e3-bd6f-3085a9ad2002'),
(96, 'f7d8ffe0-2bca-11e3-805a-3085a9ad2002', 'facde4a3-4100-11e3-bd6f-3085a9ad2002', 'facde4ad-4100-11e3-bd6f-3085a9ad2002'),
(97, 'f7d8ffe0-2bca-11e3-805a-3085a9ad2002', 'facde4a5-4100-11e3-bd6f-3085a9ad2002', 'facde4a6-4100-11e3-bd6f-3085a9ad2002'),
(98, 'f7d8ffe0-2bca-11e3-805a-3085a9ad2002', 'facde4a7-4100-11e3-bd6f-3085a9ad2002', 'facde4a9-4100-11e3-bd6f-3085a9ad2002'),
(99, 'f7d8fff1-2bca-11e3-805a-3085a9ad2002', 'facde499-4100-11e3-bd6f-3085a9ad2002', 'facde49a-4100-11e3-bd6f-3085a9ad2002'),
(100, 'f7d8fff1-2bca-11e3-805a-3085a9ad2002', 'facde49b-4100-11e3-bd6f-3085a9ad2002', 'facde49c-4100-11e3-bd6f-3085a9ad2002'),
(101, 'f7d8fff1-2bca-11e3-805a-3085a9ad2002', 'facde49d-4100-11e3-bd6f-3085a9ad2002', 'facde49e-4100-11e3-bd6f-3085a9ad2002'),
(102, 'f7d8fff1-2bca-11e3-805a-3085a9ad2002', 'facde49f-4100-11e3-bd6f-3085a9ad2002', 'facde4ab-4100-11e3-bd6f-3085a9ad2002'),
(103, 'f7d8fff1-2bca-11e3-805a-3085a9ad2002', 'facde4a1-4100-11e3-bd6f-3085a9ad2002', 'facde4a2-4100-11e3-bd6f-3085a9ad2002'),
(104, 'f7d8fff1-2bca-11e3-805a-3085a9ad2002', 'facde4a3-4100-11e3-bd6f-3085a9ad2002', 'facde4aa-4100-11e3-bd6f-3085a9ad2002'),
(105, 'f7d8fff1-2bca-11e3-805a-3085a9ad2002', 'facde4a5-4100-11e3-bd6f-3085a9ad2002', 'facde4a6-4100-11e3-bd6f-3085a9ad2002'),
(106, 'f7d8fff1-2bca-11e3-805a-3085a9ad2002', 'facde4a7-4100-11e3-bd6f-3085a9ad2002', 'facde4a8-4100-11e3-bd6f-3085a9ad2002'),
(107, 'f7d8fff4-2bca-11e3-805a-3085a9ad2002', 'facde499-4100-11e3-bd6f-3085a9ad2002', 'facde49a-4100-11e3-bd6f-3085a9ad2002'),
(108, 'f7d8fff4-2bca-11e3-805a-3085a9ad2002', 'facde49b-4100-11e3-bd6f-3085a9ad2002', 'facde4af-4100-11e3-bd6f-3085a9ad2002'),
(109, 'f7d8fff4-2bca-11e3-805a-3085a9ad2002', 'facde49d-4100-11e3-bd6f-3085a9ad2002', 'facde4ac-4100-11e3-bd6f-3085a9ad2002'),
(110, 'f7d8fff4-2bca-11e3-805a-3085a9ad2002', 'facde49f-4100-11e3-bd6f-3085a9ad2002', 'facde4ab-4100-11e3-bd6f-3085a9ad2002'),
(111, 'f7d8fff4-2bca-11e3-805a-3085a9ad2002', 'facde4a1-4100-11e3-bd6f-3085a9ad2002', 'facde4a2-4100-11e3-bd6f-3085a9ad2002'),
(112, 'f7d8fff4-2bca-11e3-805a-3085a9ad2002', 'facde4a3-4100-11e3-bd6f-3085a9ad2002', 'facde4aa-4100-11e3-bd6f-3085a9ad2002'),
(113, 'f7d8fff4-2bca-11e3-805a-3085a9ad2002', 'facde4a5-4100-11e3-bd6f-3085a9ad2002', 'facde4a6-4100-11e3-bd6f-3085a9ad2002'),
(114, 'f7d8fff4-2bca-11e3-805a-3085a9ad2002', 'facde4a7-4100-11e3-bd6f-3085a9ad2002', 'facde4a8-4100-11e3-bd6f-3085a9ad2002'),
(115, '9ef1d6be-2bda-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(116, '9ef1d6be-2bda-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(117, '9ef1d6be-2bda-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4bf-4100-11e3-bd6f-3085a9ad2002'),
(118, '9ef1d6be-2bda-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4c1-4100-11e3-bd6f-3085a9ad2002'),
(119, '9ef1d6be-2bda-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(120, '9ef1d6be-2bda-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4c6-4100-11e3-bd6f-3085a9ad2002'),
(121, '9ef1d6c1-2bda-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(122, '9ef1d6c1-2bda-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(123, '9ef1d6c1-2bda-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4c7-4100-11e3-bd6f-3085a9ad2002'),
(124, '9ef1d6c1-2bda-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(125, '9ef1d6c1-2bda-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4c8-4100-11e3-bd6f-3085a9ad2002'),
(126, '9ef1d6c1-2bda-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4c6-4100-11e3-bd6f-3085a9ad2002'),
(127, '9ef1d6c4-2bda-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(128, '9ef1d6c4-2bda-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(129, '9ef1d6c4-2bda-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4c9-4100-11e3-bd6f-3085a9ad2002'),
(130, '9ef1d6c4-2bda-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4c4-4100-11e3-bd6f-3085a9ad2002'),
(131, '9ef1d6c4-2bda-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ca-4100-11e3-bd6f-3085a9ad2002'),
(132, '9ef1d6c4-2bda-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(133, '9ef1d6c7-2bda-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(134, '9ef1d6c7-2bda-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(135, '9ef1d6c7-2bda-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4c3-4100-11e3-bd6f-3085a9ad2002'),
(136, '9ef1d6c7-2bda-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(137, '9ef1d6c7-2bda-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4cb-4100-11e3-bd6f-3085a9ad2002'),
(138, '9ef1d6c7-2bda-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(139, '9ef1d6ca-2bda-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4bd-4100-11e3-bd6f-3085a9ad2002'),
(140, '9ef1d6ca-2bda-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(141, '9ef1d6ca-2bda-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4b6-4100-11e3-bd6f-3085a9ad2002'),
(142, '9ef1d6ca-2bda-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(143, '9ef1d6ca-2bda-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(144, '9ef1d6ca-2bda-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(145, '9ef1d6ce-2bda-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(146, '9ef1d6ce-2bda-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(147, '9ef1d6ce-2bda-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4b6-4100-11e3-bd6f-3085a9ad2002'),
(148, '9ef1d6ce-2bda-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(149, '9ef1d6ce-2bda-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(150, '9ef1d6ce-2bda-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4bc-4100-11e3-bd6f-3085a9ad2002'),
(151, '9ef1d6d1-2bda-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(152, '9ef1d6d1-2bda-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(153, '9ef1d6d1-2bda-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4c0-4100-11e3-bd6f-3085a9ad2002'),
(154, '9ef1d6d1-2bda-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(155, '9ef1d6d1-2bda-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(156, '9ef1d6d1-2bda-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(157, '9ef1d6d4-2bda-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(158, '9ef1d6d4-2bda-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(159, '9ef1d6d4-2bda-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4c0-4100-11e3-bd6f-3085a9ad2002'),
(160, '9ef1d6d4-2bda-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(161, '9ef1d6d4-2bda-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(162, '9ef1d6d4-2bda-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4bc-4100-11e3-bd6f-3085a9ad2002'),
(163, '9ef1d6d7-2bda-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(164, '9ef1d6d7-2bda-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(165, '9ef1d6d7-2bda-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4c0-4100-11e3-bd6f-3085a9ad2002'),
(166, '9ef1d6d7-2bda-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(167, '9ef1d6d7-2bda-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(168, '9ef1d6d7-2bda-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4c6-4100-11e3-bd6f-3085a9ad2002'),
(169, '9ef1d6dc-2bda-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(170, '9ef1d6dc-2bda-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(171, '9ef1d6dc-2bda-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4b6-4100-11e3-bd6f-3085a9ad2002'),
(172, '9ef1d6dc-2bda-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(173, '9ef1d6dc-2bda-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(174, '9ef1d6dc-2bda-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(175, '9ef1d6e9-2bda-11e3-805a-3085a9ad2002', 'facde499-4100-11e3-bd6f-3085a9ad2002', 'facde49a-4100-11e3-bd6f-3085a9ad2002'),
(176, '9ef1d6e9-2bda-11e3-805a-3085a9ad2002', 'facde49b-4100-11e3-bd6f-3085a9ad2002', 'facde49c-4100-11e3-bd6f-3085a9ad2002'),
(177, '9ef1d6e9-2bda-11e3-805a-3085a9ad2002', 'facde49d-4100-11e3-bd6f-3085a9ad2002', 'facde4ac-4100-11e3-bd6f-3085a9ad2002'),
(178, '9ef1d6e9-2bda-11e3-805a-3085a9ad2002', 'facde49f-4100-11e3-bd6f-3085a9ad2002', 'facde4a0-4100-11e3-bd6f-3085a9ad2002'),
(179, '9ef1d6e9-2bda-11e3-805a-3085a9ad2002', 'facde4a1-4100-11e3-bd6f-3085a9ad2002', 'facde4ae-4100-11e3-bd6f-3085a9ad2002'),
(180, '9ef1d6e9-2bda-11e3-805a-3085a9ad2002', 'facde4a3-4100-11e3-bd6f-3085a9ad2002', 'facde4ad-4100-11e3-bd6f-3085a9ad2002'),
(181, '9ef1d6e9-2bda-11e3-805a-3085a9ad2002', 'facde4a5-4100-11e3-bd6f-3085a9ad2002', 'facde4a6-4100-11e3-bd6f-3085a9ad2002'),
(182, '9ef1d6e9-2bda-11e3-805a-3085a9ad2002', 'facde4a7-4100-11e3-bd6f-3085a9ad2002', 'facde4a8-4100-11e3-bd6f-3085a9ad2002'),
(183, '9ef1d6f2-2bda-11e3-805a-3085a9ad2002', 'facde499-4100-11e3-bd6f-3085a9ad2002', 'facde49a-4100-11e3-bd6f-3085a9ad2002'),
(184, '9ef1d6f2-2bda-11e3-805a-3085a9ad2002', 'facde49b-4100-11e3-bd6f-3085a9ad2002', 'facde49c-4100-11e3-bd6f-3085a9ad2002'),
(185, '9ef1d6f2-2bda-11e3-805a-3085a9ad2002', 'facde49d-4100-11e3-bd6f-3085a9ad2002', 'facde4b0-4100-11e3-bd6f-3085a9ad2002'),
(186, '9ef1d6f2-2bda-11e3-805a-3085a9ad2002', 'facde49f-4100-11e3-bd6f-3085a9ad2002', 'facde4ab-4100-11e3-bd6f-3085a9ad2002'),
(187, '9ef1d6f2-2bda-11e3-805a-3085a9ad2002', 'facde4a1-4100-11e3-bd6f-3085a9ad2002', 'facde4a2-4100-11e3-bd6f-3085a9ad2002'),
(188, '9ef1d6f2-2bda-11e3-805a-3085a9ad2002', 'facde4a3-4100-11e3-bd6f-3085a9ad2002', 'facde4aa-4100-11e3-bd6f-3085a9ad2002'),
(189, '9ef1d6f2-2bda-11e3-805a-3085a9ad2002', 'facde4a5-4100-11e3-bd6f-3085a9ad2002', 'facde4a6-4100-11e3-bd6f-3085a9ad2002'),
(190, '9ef1d6f2-2bda-11e3-805a-3085a9ad2002', 'facde4a7-4100-11e3-bd6f-3085a9ad2002', 'facde4a8-4100-11e3-bd6f-3085a9ad2002'),
(191, '9ef1d6e5-2bda-11e3-805a-3085a9ad2002', 'facde499-4100-11e3-bd6f-3085a9ad2002', 'facde49a-4100-11e3-bd6f-3085a9ad2002'),
(192, '9ef1d6e5-2bda-11e3-805a-3085a9ad2002', 'facde49b-4100-11e3-bd6f-3085a9ad2002', 'facde49c-4100-11e3-bd6f-3085a9ad2002'),
(193, '9ef1d6e5-2bda-11e3-805a-3085a9ad2002', 'facde49d-4100-11e3-bd6f-3085a9ad2002', 'facde4ac-4100-11e3-bd6f-3085a9ad2002'),
(194, '9ef1d6e5-2bda-11e3-805a-3085a9ad2002', 'facde49f-4100-11e3-bd6f-3085a9ad2002', 'facde4a0-4100-11e3-bd6f-3085a9ad2002'),
(195, '9ef1d6e5-2bda-11e3-805a-3085a9ad2002', 'facde4a1-4100-11e3-bd6f-3085a9ad2002', 'facde4a2-4100-11e3-bd6f-3085a9ad2002'),
(196, '9ef1d6e5-2bda-11e3-805a-3085a9ad2002', 'facde4a3-4100-11e3-bd6f-3085a9ad2002', 'facde4aa-4100-11e3-bd6f-3085a9ad2002'),
(197, '9ef1d6e5-2bda-11e3-805a-3085a9ad2002', 'facde4a5-4100-11e3-bd6f-3085a9ad2002', 'facde4a6-4100-11e3-bd6f-3085a9ad2002'),
(198, '9ef1d6e5-2bda-11e3-805a-3085a9ad2002', 'facde4a7-4100-11e3-bd6f-3085a9ad2002', 'facde4a8-4100-11e3-bd6f-3085a9ad2002'),
(199, '9ef1d6f5-2bda-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(200, '9ef1d6f5-2bda-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(201, '9ef1d6f5-2bda-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4b6-4100-11e3-bd6f-3085a9ad2002'),
(202, '9ef1d6f5-2bda-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(203, '9ef1d6f5-2bda-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(204, '9ef1d6f5-2bda-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4bc-4100-11e3-bd6f-3085a9ad2002'),
(205, '9ef1d6fb-2bda-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(206, '9ef1d6fb-2bda-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(207, '9ef1d6fb-2bda-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4b6-4100-11e3-bd6f-3085a9ad2002'),
(208, '9ef1d6fb-2bda-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(209, '9ef1d6fb-2bda-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4cb-4100-11e3-bd6f-3085a9ad2002'),
(210, '9ef1d6fb-2bda-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(211, '6ed93b96-3f6e-11e3-a1f8-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(212, '6ed93b96-3f6e-11e3-a1f8-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(213, '6ed93b96-3f6e-11e3-a1f8-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4b6-4100-11e3-bd6f-3085a9ad2002'),
(214, '6ed93b96-3f6e-11e3-a1f8-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(215, '6ed93b96-3f6e-11e3-a1f8-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(216, '6ed93b96-3f6e-11e3-a1f8-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(217, '9ef1d6df-2bda-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(218, '9ef1d6df-2bda-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(219, '9ef1d6df-2bda-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4b6-4100-11e3-bd6f-3085a9ad2002'),
(220, '9ef1d6df-2bda-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(221, '9ef1d6df-2bda-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4cb-4100-11e3-bd6f-3085a9ad2002'),
(222, '9ef1d6df-2bda-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(223, '32f8a52c-2be6-11e3-805a-3085a9ad2002', 'facde499-4100-11e3-bd6f-3085a9ad2002', 'facde49a-4100-11e3-bd6f-3085a9ad2002'),
(224, '32f8a52c-2be6-11e3-805a-3085a9ad2002', 'facde49b-4100-11e3-bd6f-3085a9ad2002', 'facde4af-4100-11e3-bd6f-3085a9ad2002'),
(225, '32f8a52c-2be6-11e3-805a-3085a9ad2002', 'facde49d-4100-11e3-bd6f-3085a9ad2002', 'facde4ac-4100-11e3-bd6f-3085a9ad2002'),
(226, '32f8a52c-2be6-11e3-805a-3085a9ad2002', 'facde49f-4100-11e3-bd6f-3085a9ad2002', 'facde4a0-4100-11e3-bd6f-3085a9ad2002'),
(227, '32f8a52c-2be6-11e3-805a-3085a9ad2002', 'facde4a1-4100-11e3-bd6f-3085a9ad2002', 'facde4ae-4100-11e3-bd6f-3085a9ad2002'),
(228, '32f8a52c-2be6-11e3-805a-3085a9ad2002', 'facde4a3-4100-11e3-bd6f-3085a9ad2002', 'facde4ad-4100-11e3-bd6f-3085a9ad2002'),
(229, '32f8a52c-2be6-11e3-805a-3085a9ad2002', 'facde4a5-4100-11e3-bd6f-3085a9ad2002', 'facde4a6-4100-11e3-bd6f-3085a9ad2002'),
(230, '32f8a52c-2be6-11e3-805a-3085a9ad2002', 'facde4a7-4100-11e3-bd6f-3085a9ad2002', 'facde4a9-4100-11e3-bd6f-3085a9ad2002'),
(231, '32f8a52f-2be6-11e3-805a-3085a9ad2002', 'facde499-4100-11e3-bd6f-3085a9ad2002', 'facde49a-4100-11e3-bd6f-3085a9ad2002'),
(232, '32f8a52f-2be6-11e3-805a-3085a9ad2002', 'facde49b-4100-11e3-bd6f-3085a9ad2002', 'facde49c-4100-11e3-bd6f-3085a9ad2002'),
(233, '32f8a52f-2be6-11e3-805a-3085a9ad2002', 'facde49d-4100-11e3-bd6f-3085a9ad2002', 'facde4ac-4100-11e3-bd6f-3085a9ad2002'),
(234, '32f8a52f-2be6-11e3-805a-3085a9ad2002', 'facde49f-4100-11e3-bd6f-3085a9ad2002', 'facde4ab-4100-11e3-bd6f-3085a9ad2002'),
(235, '32f8a52f-2be6-11e3-805a-3085a9ad2002', 'facde4a1-4100-11e3-bd6f-3085a9ad2002', 'facde4ae-4100-11e3-bd6f-3085a9ad2002'),
(236, '32f8a52f-2be6-11e3-805a-3085a9ad2002', 'facde4a3-4100-11e3-bd6f-3085a9ad2002', 'facde4ad-4100-11e3-bd6f-3085a9ad2002'),
(237, '32f8a52f-2be6-11e3-805a-3085a9ad2002', 'facde4a5-4100-11e3-bd6f-3085a9ad2002', 'facde4a6-4100-11e3-bd6f-3085a9ad2002'),
(238, '32f8a52f-2be6-11e3-805a-3085a9ad2002', 'facde4a7-4100-11e3-bd6f-3085a9ad2002', 'facde4a8-4100-11e3-bd6f-3085a9ad2002'),
(239, '32f8a53c-2be6-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(240, '32f8a53c-2be6-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(241, '32f8a53c-2be6-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4b6-4100-11e3-bd6f-3085a9ad2002'),
(242, '32f8a53c-2be6-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(243, '32f8a53c-2be6-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4cc-4100-11e3-bd6f-3085a9ad2002'),
(244, '32f8a53c-2be6-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(245, '32f8a53f-2be6-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(246, '32f8a53f-2be6-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(247, '32f8a53f-2be6-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4b6-4100-11e3-bd6f-3085a9ad2002'),
(248, '32f8a53f-2be6-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4c1-4100-11e3-bd6f-3085a9ad2002'),
(249, '32f8a53f-2be6-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4cc-4100-11e3-bd6f-3085a9ad2002'),
(250, '32f8a53f-2be6-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4c6-4100-11e3-bd6f-3085a9ad2002'),
(251, '32f8a547-2be6-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4cd-4100-11e3-bd6f-3085a9ad2002'),
(252, '32f8a547-2be6-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(253, '32f8a547-2be6-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4c0-4100-11e3-bd6f-3085a9ad2002'),
(254, '32f8a547-2be6-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(255, '32f8a547-2be6-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(256, '32f8a547-2be6-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(257, '32f8a54a-2be6-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(258, '32f8a54a-2be6-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(259, '32f8a54a-2be6-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4ce-4100-11e3-bd6f-3085a9ad2002'),
(260, '32f8a54a-2be6-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(261, '32f8a54a-2be6-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(262, '32f8a54a-2be6-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4c6-4100-11e3-bd6f-3085a9ad2002'),
(263, '32f8a54d-2be6-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(264, '32f8a54d-2be6-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(265, '32f8a54d-2be6-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4ce-4100-11e3-bd6f-3085a9ad2002'),
(266, '32f8a54d-2be6-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(267, '32f8a54d-2be6-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(268, '32f8a54d-2be6-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4c6-4100-11e3-bd6f-3085a9ad2002'),
(269, '32f8a550-2be6-11e3-805a-3085a9ad2002', 'f2e7e3e4-2cac-11e3-b4cb-3085a9ad2002', 'facde4b2-4100-11e3-bd6f-3085a9ad2002'),
(270, '32f8a550-2be6-11e3-805a-3085a9ad2002', 'facde4b3-4100-11e3-bd6f-3085a9ad2002', 'facde4b4-4100-11e3-bd6f-3085a9ad2002'),
(271, '32f8a550-2be6-11e3-805a-3085a9ad2002', 'facde4b5-4100-11e3-bd6f-3085a9ad2002', 'facde4c0-4100-11e3-bd6f-3085a9ad2002'),
(272, '32f8a550-2be6-11e3-805a-3085a9ad2002', 'facde4b7-4100-11e3-bd6f-3085a9ad2002', 'facde4b8-4100-11e3-bd6f-3085a9ad2002'),
(273, '32f8a550-2be6-11e3-805a-3085a9ad2002', 'facde4b9-4100-11e3-bd6f-3085a9ad2002', 'facde4ba-4100-11e3-bd6f-3085a9ad2002'),
(274, '32f8a550-2be6-11e3-805a-3085a9ad2002', 'facde4bb-4100-11e3-bd6f-3085a9ad2002', 'facde4be-4100-11e3-bd6f-3085a9ad2002'),
(275, '9ef1d6e2-2bda-11e3-805a-3085a9ad2002', 'facde499-4100-11e3-bd6f-3085a9ad2002', 'facde49a-4100-11e3-bd6f-3085a9ad2002'),
(276, '9ef1d6e2-2bda-11e3-805a-3085a9ad2002', 'facde49b-4100-11e3-bd6f-3085a9ad2002', 'facde49c-4100-11e3-bd6f-3085a9ad2002'),
(277, '9ef1d6e2-2bda-11e3-805a-3085a9ad2002', 'facde49d-4100-11e3-bd6f-3085a9ad2002', 'facde4ac-4100-11e3-bd6f-3085a9ad2002'),
(278, '9ef1d6e2-2bda-11e3-805a-3085a9ad2002', 'facde49f-4100-11e3-bd6f-3085a9ad2002', 'facde4a0-4100-11e3-bd6f-3085a9ad2002'),
(279, '9ef1d6e2-2bda-11e3-805a-3085a9ad2002', 'facde4a1-4100-11e3-bd6f-3085a9ad2002', 'facde4b1-4100-11e3-bd6f-3085a9ad2002'),
(280, '9ef1d6e2-2bda-11e3-805a-3085a9ad2002', 'facde4a3-4100-11e3-bd6f-3085a9ad2002', 'facde4aa-4100-11e3-bd6f-3085a9ad2002'),
(281, '9ef1d6e2-2bda-11e3-805a-3085a9ad2002', 'facde4a5-4100-11e3-bd6f-3085a9ad2002', 'facde4a6-4100-11e3-bd6f-3085a9ad2002'),
(282, '9ef1d6e2-2bda-11e3-805a-3085a9ad2002', 'facde4a7-4100-11e3-bd6f-3085a9ad2002', 'facde4a8-4100-11e3-bd6f-3085a9ad2002'),
(283, '5db77ccb-2c90-11e3-b4cb-3085a9ad2002', '2af4bd42-2bfc-11e3-805a-3085a9ad2002', '5db77ce2-2c90-11e3-b4cb-3085a9ad2002'),
(284, '5db77ccb-2c90-11e3-b4cb-3085a9ad2002', '5db77cd0-2c90-11e3-b4cb-3085a9ad2002', '5db77cda-2c90-11e3-b4cb-3085a9ad2002'),
(285, '5db77ccb-2c90-11e3-b4cb-3085a9ad2002', '5db77cd2-2c90-11e3-b4cb-3085a9ad2002', '5db77ce3-2c90-11e3-b4cb-3085a9ad2002'),
(286, '5db77ccb-2c90-11e3-b4cb-3085a9ad2002', '5db77cd3-2c90-11e3-b4cb-3085a9ad2002', '5db77cde-2c90-11e3-b4cb-3085a9ad2002'),
(287, '5db77ce4-2c90-11e3-b4cb-3085a9ad2002', '2af4bd42-2bfc-11e3-805a-3085a9ad2002', '5db77ce2-2c90-11e3-b4cb-3085a9ad2002'),
(288, '5db77ce4-2c90-11e3-b4cb-3085a9ad2002', '5db77cd0-2c90-11e3-b4cb-3085a9ad2002', '5db77cdb-2c90-11e3-b4cb-3085a9ad2002'),
(289, '5db77ce4-2c90-11e3-b4cb-3085a9ad2002', '5db77cd2-2c90-11e3-b4cb-3085a9ad2002', '5db77ce3-2c90-11e3-b4cb-3085a9ad2002'),
(290, '5db77ce4-2c90-11e3-b4cb-3085a9ad2002', '5db77cd3-2c90-11e3-b4cb-3085a9ad2002', '5db77cde-2c90-11e3-b4cb-3085a9ad2002'),
(291, '5db77ce7-2c90-11e3-b4cb-3085a9ad2002', '2af4bd42-2bfc-11e3-805a-3085a9ad2002', '5db77ce2-2c90-11e3-b4cb-3085a9ad2002'),
(292, '5db77ce7-2c90-11e3-b4cb-3085a9ad2002', '5db77cd0-2c90-11e3-b4cb-3085a9ad2002', '5db77cdb-2c90-11e3-b4cb-3085a9ad2002'),
(293, '5db77ce7-2c90-11e3-b4cb-3085a9ad2002', '5db77cd2-2c90-11e3-b4cb-3085a9ad2002', '5db77ce3-2c90-11e3-b4cb-3085a9ad2002'),
(294, '5db77ce7-2c90-11e3-b4cb-3085a9ad2002', '5db77cd3-2c90-11e3-b4cb-3085a9ad2002', '5db77cea-2c90-11e3-b4cb-3085a9ad2002'),
(295, '5db77ceb-2c90-11e3-b4cb-3085a9ad2002', '2af4bd42-2bfc-11e3-805a-3085a9ad2002', '5db77ce2-2c90-11e3-b4cb-3085a9ad2002'),
(296, '5db77ceb-2c90-11e3-b4cb-3085a9ad2002', '5db77cd0-2c90-11e3-b4cb-3085a9ad2002', '5db77cdb-2c90-11e3-b4cb-3085a9ad2002'),
(297, '5db77ceb-2c90-11e3-b4cb-3085a9ad2002', '5db77cd2-2c90-11e3-b4cb-3085a9ad2002', '5db77ce3-2c90-11e3-b4cb-3085a9ad2002'),
(298, '5db77ceb-2c90-11e3-b4cb-3085a9ad2002', '5db77cd3-2c90-11e3-b4cb-3085a9ad2002', '5db77cee-2c90-11e3-b4cb-3085a9ad2002');

-- --------------------------------------------------------

--
-- Table structure for table `shop_prop_values`
--

CREATE TABLE IF NOT EXISTS `shop_prop_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value_id` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`value_id`(255)),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `shop_prop_values`
--

INSERT INTO `shop_prop_values` (`id`, `value_id`, `name`) VALUES
(1, '5db77ce2-2c90-11e3-b4cb-3085a9ad2002', '95 л'),
(2, '5db77cda-2c90-11e3-b4cb-3085a9ad2002', '318 л'),
(3, '5db77cdb-2c90-11e3-b4cb-3085a9ad2002', '-'),
(4, '5db77ce3-2c90-11e3-b4cb-3085a9ad2002', '223 л'),
(5, '5db77cde-2c90-11e3-b4cb-3085a9ad2002', 'бежевый'),
(6, '5db77cea-2c90-11e3-b4cb-3085a9ad2002', 'серебристый'),
(7, '5db77cee-2c90-11e3-b4cb-3085a9ad2002', 'чёрный'),
(8, 'facde4b2-4100-11e3-bd6f-3085a9ad2002', 'черный'),
(9, 'facde4bd-4100-11e3-bd6f-3085a9ad2002', 'черный, тёмно-серый'),
(10, 'facde4cd-4100-11e3-bd6f-3085a9ad2002', 'серебристый'),
(11, 'facde49a-4100-11e3-bd6f-3085a9ad2002', 'Blu-ray-плеер'),
(12, 'facde49c-4100-11e3-bd6f-3085a9ad2002', 'есть'),
(13, 'facde4af-4100-11e3-bd6f-3085a9ad2002', 'нет'),
(14, 'facde49e-4100-11e3-bd6f-3085a9ad2002', 'есть, два микрофонных входа'),
(15, 'facde4ac-4100-11e3-bd6f-3085a9ad2002', 'нет'),
(16, 'facde4b0-4100-11e3-bd6f-3085a9ad2002', 'есть'),
(17, 'facde4a0-4100-11e3-bd6f-3085a9ad2002', 'BD (Blu-ray Disc), BD-R, BD-Re, DVD, DVD R, DVD RW'),
(18, 'facde4ab-4100-11e3-bd6f-3085a9ad2002', 'BD (Blu-ray Disc), Blu-Ray 3D, BD-R, BD-Re, DVD, D'),
(19, 'facde4a2-4100-11e3-bd6f-3085a9ad2002', 'MP3, WMA, MKV, AVCHD, H.264, MPEG4, DivX, XviD, JP'),
(20, 'facde4ae-4100-11e3-bd6f-3085a9ad2002', 'MP3, WMA, MKV, AVCHD, VC-1, MPEG4, DivX, DivX HD,'),
(21, 'facde4b1-4100-11e3-bd6f-3085a9ad2002', 'MP3, WMA, AVCHD, MPEG4, DivX, JPEG'),
(22, 'facde4a4-4100-11e3-bd6f-3085a9ad2002', 'композитный, HDMI, аудио стерео'),
(23, 'facde4aa-4100-11e3-bd6f-3085a9ad2002', 'композитный, HDMI, аудио стерео, аудио оптический'),
(24, 'facde4ad-4100-11e3-bd6f-3085a9ad2002', 'HDMI, аудио коаксиальный'),
(25, 'facde4a6-4100-11e3-bd6f-3085a9ad2002', 'чёрный'),
(26, 'facde4a8-4100-11e3-bd6f-3085a9ad2002', 'есть'),
(27, 'facde4a9-4100-11e3-bd6f-3085a9ad2002', 'нет'),
(28, 'facde4b4-4100-11e3-bd6f-3085a9ad2002', 'DVD-плеер'),
(29, 'facde4b6-4100-11e3-bd6f-3085a9ad2002', 'композитный, аудио стерео, аудио коаксиальный'),
(30, 'facde4bf-4100-11e3-bd6f-3085a9ad2002', 'композитный, SCART, аудио стерео, аудио коаксиальн'),
(31, 'facde4c0-4100-11e3-bd6f-3085a9ad2002', 'композитный, S-video, компонентный, аудио стерео,'),
(32, 'facde4c3-4100-11e3-bd6f-3085a9ad2002', '-'),
(33, 'facde4c7-4100-11e3-bd6f-3085a9ad2002', 'композитный, компонентный, SCART, HDMI, аудио стер'),
(34, 'facde4c9-4100-11e3-bd6f-3085a9ad2002', 'композитный, компонентный'),
(35, 'facde4ce-4100-11e3-bd6f-3085a9ad2002', 'композитный, S-video, компонентный, SCART, аудио с'),
(36, 'facde4b8-4100-11e3-bd6f-3085a9ad2002', 'DVD, DVD R, DVD RW, CD, CD-R, CD-RW'),
(37, 'facde4c1-4100-11e3-bd6f-3085a9ad2002', 'DVD, DVD RW, CD, CD-RW'),
(38, 'facde4c4-4100-11e3-bd6f-3085a9ad2002', 'DVD, CD'),
(39, 'facde4ba-4100-11e3-bd6f-3085a9ad2002', 'MP3, WMA, MPEG4, DivX, XviD, VideoCD, SVCD, HDCD,'),
(40, 'facde4c2-4100-11e3-bd6f-3085a9ad2002', 'MP3, WMA, MPEG4, DivX, XviD, SVCD, HDCD, JPEG'),
(41, 'facde4c5-4100-11e3-bd6f-3085a9ad2002', 'VideoCD, SVCD, HDCD'),
(42, 'facde4c8-4100-11e3-bd6f-3085a9ad2002', 'MP3, WMA, DivX, JPEG, Picture CD'),
(43, 'facde4ca-4100-11e3-bd6f-3085a9ad2002', 'MP3, MPEG4, JPEG'),
(44, 'facde4cb-4100-11e3-bd6f-3085a9ad2002', 'MP3, WMA, MPEG4, DivX, JPEG'),
(45, 'facde4cc-4100-11e3-bd6f-3085a9ad2002', 'MP3, WMA, MPEG4, VideoCD, SVCD, JPEG'),
(46, 'facde4bc-4100-11e3-bd6f-3085a9ad2002', 'есть, один микрофонный вход'),
(47, 'facde4be-4100-11e3-bd6f-3085a9ad2002', 'нет'),
(48, 'facde4c6-4100-11e3-bd6f-3085a9ad2002', 'есть, два микрофонных входа');

-- --------------------------------------------------------

--
-- Table structure for table `shop_shipmentstypes`
--

CREATE TABLE IF NOT EXISTS `shop_shipmentstypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sname` text NOT NULL,
  `sprice` decimal(10,2) NOT NULL,
  `payment` longtext NOT NULL,
  `speriod` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `shop_shipmentstypes`
--

INSERT INTO `shop_shipmentstypes` (`id`, `sname`, `sprice`, `payment`, `speriod`) VALUES
(1, 'Самовывоз', '0.00', 'cashpayment:::billpayment', ''),
(2, 'Курьером', '0.00', 'cashpayment:::billpayment', '2 дня');

-- --------------------------------------------------------

--
-- Table structure for table `shop_towns`
--

CREATE TABLE IF NOT EXISTS `shop_towns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tname` text NOT NULL,
  `shipment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `shop_towns`
--

INSERT INTO `shop_towns` (`id`, `tname`, `shipment`) VALUES
(1, 'г. Иркутск ул.Советская,27', '1:::2'),
(2, 'г. Улан-Удэ', '1:::2');

-- --------------------------------------------------------

--
-- Table structure for table `shop_users`
--

CREATE TABLE IF NOT EXISTS `shop_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` tinytext NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` text NOT NULL,
  `surname` text NOT NULL,
  `patronymic` text NOT NULL,
  `reg_date` datetime NOT NULL,
  `org` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `data` longtext NOT NULL,
  `seed` longtext NOT NULL,
  `phone` varchar(256) DEFAULT NULL,
  `addr` varchar(255) DEFAULT NULL,
  `discount` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `shop_users`
--

INSERT INTO `shop_users` (`id`, `email`, `password`, `name`, `surname`, `patronymic`, `reg_date`, `org`, `org_id`, `state`, `data`, `seed`, `phone`, `addr`, `discount`) VALUES
(15, 'andrey1@in-site.ru', '911cdc7f4873627d959cf8d65003efa7', 'Андрей', 'Бер', 'Геннадьевич', '2013-04-19 15:03:23', 1, 0, 0, '[]', 'bdbb8099c3075f610165ef64eda830f6', '89025675101', '', ''),
(14, 'Yara-2002@mail.ru', '036c09aee6cc6028feac25cdd1f8ed29', 'Людмила', '9', '', '2013-04-19 09:41:21', 1, 0, 0, '{"discountType":"\\u0414\\u0438\\u0441\\u043a\\u043e\\u043d\\u0442\\u043d\\u0430\\u044f \\u043a\\u0430\\u0440\\u0442\\u0430","discountValue":"","sname":"2","town2":"","ddate2":"","adrr":"\\u0420\\u0430\\u0434\\u0443\\u0436\\u043d\\u044b\\u0439,","ddate":"20 \\u0410\\u043f\\u0440 2013","pname":"cashpayment","comment":"\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t"}', 'ffdd6cf04cacc04d70790b5073c35e0e', '', NULL, ''),
(8, 'andrey@in-site.ru', '529b2504809564e90d9ddfcf914f9e7d', 'Андрей', 'Бер', 'Геннадьевич', '2013-04-15 12:25:09', 1, 0, 0, '{"sname":"2","town2":"","ddate2":"16 \\u0410\\u043f\\u0440 2013","time1":"09:00 - 13:00","adrr":"\\u0411\\u0430\\u0440\\u0440\\u0438\\u043a\\u0430\\u0434 53","pname":"cashpayment"}', 'c53081c17e0683b1bdbce46b140de237', NULL, NULL, ''),
(9, 'irksann@mail.ru', '698d51a19d8a121ce581499d7b701668', 'Mi', 'San', 'mk', '2013-04-15 14:16:02', 1, 0, 0, '{"sname":"1","town2":"\\u0413\\u043e\\u0440\\u043e\\u0434 \\u0438 \\u0443\\u043b\\u0438\\u0446\\u0430","ddate2":"","time1":"13:00 - 21:00","adrr":"","pname":"cashpayment"}', '', '12', NULL, ''),
(10, 'vlp_gold@mail.ru', '70ba659b424731183c10dd8b207a7202', 'Людмила', 'Викторовская', 'Петровна', '2013-04-15 15:08:38', 1, 0, 0, '{"sname":"2","town2":"","ddate2":"16 \\u0410\\u043f\\u0440 2013","time1":"09:00 - 13:00","adrr":"\\u041a\\u0438\\u0435\\u0432\\u0441\\u043a\\u0430\\u044f,19","pname":"cashpayment"}', 'f696fa5f89f317c5aa4b050fdf4503bc', NULL, NULL, ''),
(13, 'nerpa_irk@mail.ru', '9d518815947a9addd509731a831d6137', 'Наталья', 'Сендецкая', 'Юрьевна', '2013-04-15 23:05:19', 1, 0, 0, '{"sname":"1","town2":"\\u0433. \\u0418\\u0440\\u043a\\u0443\\u0442\\u0441\\u043a \\u0443\\u043b.\\u0421\\u043e\\u0432\\u0435\\u0442\\u0441\\u043a\\u0430\\u044f,27","ddate2":"17 \\u0410\\u043f\\u0440 2013","adrr":"","ddate":"","pname":"cashpayment"}', '2f4fdecb1f03f5825f0acb01cd94322a', '', NULL, ''),
(16, 'andrey2@in-site.ru', '911cdc7f4873627d959cf8d65003efa7', 'Андрей', 'Бер', 'Геннадьевич', '2013-04-22 14:21:03', 0, 0, 0, '[]', 'f9d9eeed096b7d0ea1200ba2036c848b', '89025765100', NULL, ''),
(17, 'test@in-site.ru', '098f6bcd4621d373cade4e832627b4f6', 'test', 'test', 'test', '2013-04-22 14:37:04', 0, 0, 0, '', '', 'test', NULL, ''),
(25, 'silago@inbox.ru', 'e10adc3949ba59abbe56e057f20f883e', 'Сигизмунд', 'Иванов', 'Лазаревич', '2013-10-30 14:29:04', 0, 0, 0, '[]', 'ddc53c32ca82f5fe0b35fb6dba2e7ff6', '23145', NULL, ''),
(26, 'aran.Noldor@yandex.ru', '4297f44b13955235245b2497399d7a93', '123', '123', '123', '2013-12-02 13:58:00', 0, 0, 0, '[]', '0a6ece8964cb1b9b30cb07dafbf7a564', '12312311231', NULL, ''),
(19, 'yorkshp@gmail.com', 'ed855309f887fda2c7d40b1dcec548a8', 'Юрий', 'Шпынёв', 'Борисович', '2013-07-05 09:31:03', 1, 0, 0, '{"discountType":"","discountValue":"","sname":"1","town2":"","ddate2":"","adrr":"","ddate":"","pname":"cashpayment","comment":"\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t"}', '731733103d84a9253b788dda788c597a', '79041415353', NULL, ''),
(20, 'dsdfg@fd.rt', 'd9aeba5e7bcdacec33d2504cfcbfc33b', 'авы', 'авы', 'ыва', '2013-09-09 12:10:02', 0, 0, 0, '[]', '3fa2b83b3c0580f16e0894556c90640c', '43242', NULL, ''),
(21, 'd123@123d.ru', '4297f44b13955235245b2497399d7a93', 'ww', 'qqq', 'eee', '2013-10-21 17:00:57', 1, 0, 0, '{"discountType":"","discountValue":"","sname":"1","town2":"","ddate2":"","adrr":"","ddate":"","pname":"billpayment","comment":"\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t\\t"}', '', '321321', NULL, ''),
(24, 'silago.nevermind@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'asdasdasd', 'asdasdasd', 'asdasdasd', '2013-10-30 14:19:34', 0, 0, 0, '[]', '7914023c45e956e3351f635b5ba95e7a', '223344', NULL, ''),
(23, 'test@test.te', '36a65c76ba6fd7ea70f8ffb3d8d9984c', 'Сигизмунд', 'Иванов', 'Лазаревич', '2013-10-23 16:22:19', 0, 0, 0, '[]', '', NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `image` varchar(30) NOT NULL,
  `owner` int(1) unsigned NOT NULL,
  `caption` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `image` (`image`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `name`, `image`, `owner`, `caption`) VALUES
(2, '111', '1367828415_rdbcrtn.jpg', 0, 'якот'),
(3, '222', '1367828430_kyxiv1y.jpg', 0, 'cat2');

-- --------------------------------------------------------

--
-- Table structure for table `statBr`
--

CREATE TABLE IF NOT EXISTS `statBr` (
  `dt` date NOT NULL DEFAULT '0000-00-00',
  `br` tinytext,
  `count` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `statCountries`
--

CREATE TABLE IF NOT EXISTS `statCountries` (
  `dt` date NOT NULL DEFAULT '0000-00-00',
  `countryString` tinytext,
  `count` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `statIpAddr`
--

CREATE TABLE IF NOT EXISTS `statIpAddr` (
  `dt` date NOT NULL DEFAULT '0000-00-00',
  `ip` tinytext,
  `count` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `statJs`
--

CREATE TABLE IF NOT EXISTS `statJs` (
  `dt` date NOT NULL DEFAULT '0000-00-00',
  `js` enum('Y','N') DEFAULT NULL,
  `count` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `statNowAndPoints`
--

CREATE TABLE IF NOT EXISTS `statNowAndPoints` (
  `dt` date NOT NULL DEFAULT '0000-00-00',
  `lastActionTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `joinPoint` tinytext,
  `quitPoint` tinytext,
  `session` tinytext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `statRef`
--

CREATE TABLE IF NOT EXISTS `statRef` (
  `dt` date NOT NULL DEFAULT '0000-00-00',
  `ref` tinytext,
  `count` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `statRefDomain`
--

CREATE TABLE IF NOT EXISTS `statRefDomain` (
  `dt` date NOT NULL DEFAULT '0000-00-00',
  `refDomain` tinytext,
  `count` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `statResolution`
--

CREATE TABLE IF NOT EXISTS `statResolution` (
  `dt` date NOT NULL DEFAULT '0000-00-00',
  `resolution` tinytext,
  `count` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `statSearchWord`
--

CREATE TABLE IF NOT EXISTS `statSearchWord` (
  `dt` date NOT NULL DEFAULT '0000-00-00',
  `searchWord` tinytext,
  `count` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `statSum`
--

CREATE TABLE IF NOT EXISTS `statSum` (
  `dt` date NOT NULL DEFAULT '0000-00-00',
  `hits` int(11) DEFAULT NULL,
  `hosts` int(11) DEFAULT NULL,
  `visitors` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(1, 'Samsung'),
(2, 'LG'),
(3, 'Indesit'),
(4, 'Philips'),
(5, 'Sony'),
(6, 'BBK'),
(7, 'Erisson'),
(8, 'Fusion'),
(9, 'Mystery'),
(10, 'Panasonic'),
(11, 'Pioneer'),
(12, 'Supra'),
(13, 'Toschiba'),
(14, 'ОКЕАН'),
(15, 'Bosch'),
(16, 'Braun'),
(17, 'Electrolux'),
(18, 'Kenwood'),
(19, 'Moulinex'),
(20, 'Zanussi'),
(21, 'Optima'),
(22, 'Бирюса'),
(23, 'Rika'),
(24, 'Polaris'),
(25, 'Sakura'),
(26, 'Scarlett'),
(27, 'Tefal'),
(28, 'Vitek'),
(29, 'Vitesse'),
(30, 'Sinbo'),
(31, 'Saturn'),
(32, 'Beko'),
(33, 'Gorenje'),
(34, 'Hansa'),
(35, 'Hotpoint-Ariston'),
(36, 'Ignis'),
(37, 'S-Allianse'),
(38, 'Siemens'),
(39, 'Whirlpool'),
(40, 'Luxell'),
(41, 'Renova'),
(42, 'Саратов'),
(43, 'Дарина'),
(44, 'Slavda'),
(45, 'Kumtel'),
(46, 'Delonghi'),
(47, 'Holder'),
(48, 'Proffix'),
(49, 'Resonans'),
(50, 'Vobix'),
(51, 'Ultramounts'),
(52, 'Maxwell'),
(53, 'Roventa'),
(54, 'Remington'),
(55, 'Daewoo'),
(56, 'Marta'),
(57, 'Thomas'),
(58, 'Vestel'),
(59, 'Фея'),
(60, 'Liebherr'),
(61, 'Атлант'),
(62, 'De Luxe'),
(63, 'Лысьва');

-- --------------------------------------------------------

--
-- Table structure for table `tag_item`
--

CREATE TABLE IF NOT EXISTS `tag_item` (
  `id_tag` int(11) NOT NULL,
  `id_item` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tag_item`
--

INSERT INTO `tag_item` (`id_tag`, `id_item`) VALUES
(1, 'pnpkrdjl-kvdr-fulj-liab-7mgjx5rny2vk'),
(1, 'tlk6xcsd-ozfd-bnkn-mc9i-5rv2rtvktgst'),
(1, 'ff64dmlj-mubd-vcy6-097h-9xg3vckddavm'),
(2, 'ih0e0oxa-iiai-54bp-jcd9-scnicikokmmu'),
(0, 'uv0puyc8-zuvl-3f5t-h155-ytzyzcz2lenz'),
(0, 'fvjoyy4n-2nyk-7gnp-536r-yfbhihbp5jl0'),
(0, '2af4bd3e-2bfc-11e3-805a-3085a9ad2002');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `date` datetime NOT NULL,
  `text` text NOT NULL,
  `rating` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `owner_id`, `user_id`, `name`, `date`, `text`, `rating`) VALUES
(1, '7bfbff35-7732-11e2-8482-00c0df031420', 9, 'Отзыв', '2013-04-19 12:56:29', 'Отзыв 1', 5),
(2, '7bfbff35-7732-11e2-8482-00c0df031420', 12, 'Отзыв2', '2013-04-19 12:56:37', 'Отзыв 2', 5),
(3, '7bfbff35-7732-11e2-8482-00c0df031420', 14, 'Отзыв3', '2013-04-19 12:56:43', 'Отзыв 3', 5),
(4, '7bfbff35-7732-11e2-8482-00c0df031420', 9, '', '2013-04-19 14:37:55', 'Отзыв 4', 0),
(5, '7bfbff3e-7732-11e2-8482-00c0df031420', 9, '', '2013-04-19 14:54:36', 'Отзыв 1', 0),
(6, '7bfbff3e-7732-11e2-8482-00c0df031420', 9, '', '2013-04-19 14:59:15', 'Отзыв 2', 0),
(7, '7bfbff3e-7732-11e2-8482-00c0df031420', 9, '', '2013-04-19 15:02:59', 'Отзыв 3', 0),
(8, '0', 9, '', '2013-04-19 16:34:12', 'Отзыв о магазине 1', 5),
(9, '0', 9, '', '2013-04-19 16:34:17', 'Отзыв о магазине 2', 5),
(10, '0', 9, '', '2013-04-19 16:34:21', 'Отзыв о магазине 3', 5),
(11, '0', 12, '', '2013-04-19 16:34:58', 'Повседневный образ не обязательно должен быть скучным, банальным и неброским, сделайте его ярким и впечатляющим, добавив в свой гардероб стильные женские рубашки и туники. Именно они сделают Ваш внешний вид элегантным и благородным, при этом сохранив его соблазнительность и женственность.', 5),
(12, '0', 13, '', '2013-04-19 16:36:44', 'Повседневный образ не обязательно должен быть ярким и впечатляющим, сделайте его скучным, банальным и неброским, добавив в свой гардероб женские рубашки и туники. Именно они сделают Ваш внешний вид беспечным и обыденным, при этом сохранив его апельсин.', 5),
(13, '7bfbff35-7732-11e2-8482-00c0df031420', 9, '', '2013-04-19 17:13:24', 'Отзыв 5', 0),
(14, '0', 9, '', '2013-04-22 10:29:00', 'Отзыв о магазине 4', 0),
(15, '0', 16, '', '2013-04-22 14:22:03', 'Это мой отзыв', 0),
(16, '7bfbff35-7732-11e2-8482-00c0df031420', 16, '', '2013-04-22 14:23:16', 'Мои отзыв', 0),
(17, '7bfbff35-7732-11e2-8482-00c0df031420', 9, '', '2013-04-22 16:15:59', 'отзыв', 0),
(18, '0', 9, '', '2013-04-22 16:39:05', 'Отзывв', 0);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials_rating`
--

CREATE TABLE IF NOT EXISTS `testimonials_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `testimonial_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_v2`
--

CREATE TABLE IF NOT EXISTS `users_v2` (
  `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fio` tinytext,
  `login` tinytext,
  `password` tinytext,
  `email` tinytext,
  `accessRights` enum('0','1','2') DEFAULT '0',
  `accessModules` text,
  `lastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `regTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `addedBy` tinytext,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users_v2`
--

INSERT INTO `users_v2` (`userId`, `fio`, `login`, `password`, `email`, `accessRights`, `accessModules`, `lastLogin`, `regTime`, `addedBy`) VALUES
(1, 'Administrator', 'admin', '$1$VpIcEhas$6/cP1QtrvitAxHZla.3.J1', 'admin@test.mail.ru', '1', '', '2012-10-30 00:18:38', '2012-04-01 10:37:24', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
