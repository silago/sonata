-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 21 2013 г., 09:21
-- Версия сервера: 5.1.66-0+squeeze1
-- Версия PHP: 5.3.3-7+squeeze16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `corona`
--

-- --------------------------------------------------------

--
-- Структура таблицы `shop_groups`
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_itemfiles`
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
-- Структура таблицы `shop_itemimages`
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_itemproperties`
--

CREATE TABLE IF NOT EXISTS `shop_itemproperties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prop_id` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`prop_id`(255)),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_items`
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_item_chars`
--

CREATE TABLE IF NOT EXISTS `shop_item_chars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `value` tinytext NOT NULL,
  PRIMARY KEY (`item_id`(100),`name`(100),`value`(100)),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_item_sizes`
--

CREATE TABLE IF NOT EXISTS `shop_item_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_owner`
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

-- --------------------------------------------------------

--
-- Структура таблицы `shop_prices`
--

CREATE TABLE IF NOT EXISTS `shop_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` tinytext NOT NULL,
  `pricetype_id` tinytext NOT NULL,
  `value` decimal(10,2) NOT NULL,
  PRIMARY KEY (`item_id`(100),`pricetype_id`(100),`value`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_pricestypes`
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
-- Структура таблицы `shop_props_assign`
--

CREATE TABLE IF NOT EXISTS `shop_props_assign` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` tinytext NOT NULL,
  `prop_id` tinytext NOT NULL,
  `prop_val_id` tinytext NOT NULL,
  PRIMARY KEY (`item_id`(100),`prop_id`(100),`prop_val_id`(100)),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `shop_prop_values`
--

CREATE TABLE IF NOT EXISTS `shop_prop_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value_id` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`value_id`(255)),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
