-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 18, 2013 at 02:22 PM
-- Server version: 5.5.29
-- PHP Version: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `mmatica`
--

-- --------------------------------------------------------

--
-- Table structure for table `flashes`
--

CREATE TABLE IF NOT EXISTS `flashes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `data` text,
  `date` int(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Stores system info' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `flashes`
--

INSERT INTO `flashes` (`id`, `user_id`, `data`, `date`) VALUES
(1, 1, 'a:1:{s:6:"errors";a:1:{i:0;s:72:"Невозможно отправить письмо на этот Email";}}', 1363187127),
(2, 1, 'a:1:{s:7:"success";a:1:{i:0;s:67:"Пароль удачно изменен и выслан на Email";}}', 1363187141),
(3, 1, 'a:1:{s:7:"success";a:1:{i:0;s:67:"Пароль удачно изменен и выслан на Email";}}', 1363187250),
(4, 9, 'a:1:{s:6:"errors";a:1:{i:0;s:90:"Изображение не удалось сохранить, попробуйте еще";}}', 1363272435);

-- --------------------------------------------------------

--
-- Table structure for table `loginza`
--

CREATE TABLE IF NOT EXISTS `loginza` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identity` varchar(250) NOT NULL,
  `provider` varchar(250) NOT NULL,
  `dt_create` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `loginza`
--

INSERT INTO `loginza` (`id`, `identity`, `provider`, `dt_create`, `user_id`) VALUES
(3, 'http://vk.com/id9774650', 'http://vk.com/', 1363272435, 9);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msg` text NOT NULL,
  `date` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `statics`
--

CREATE TABLE IF NOT EXISTS `statics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `time_create` int(11) NOT NULL,
  `time_update` int(11) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE IF NOT EXISTS `storage` (
  `name` varchar(50) NOT NULL,
  `value` varchar(250) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order` int(11) NOT NULL,
  `description` text NOT NULL,
  `address` varchar(250) NOT NULL,
  `price` varchar(50) NOT NULL,
  `date` int(11) NOT NULL,
  `status` enum('fake','posted','request','process','complete','paid') NOT NULL,
  `lat` varchar(50) DEFAULT NULL,
  `lng` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4035 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(64) DEFAULT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `avatar` tinyint(1) DEFAULT NULL,
  `city` varchar(250) NOT NULL,
  `birthday` varchar(50) DEFAULT NULL,
  `whatdo` enum('school','student','work','another') NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(250) NOT NULL,
  `model` varchar(50) NOT NULL,
  `os` enum('android','ios','windows','another') NOT NULL,
  `pay` enum('mobile','ym','wm','qiwi','card') NOT NULL,
  `ym_purse` varchar(50) NOT NULL,
  `wm_purse` varchar(50) NOT NULL,
  `qiwi_purse` varchar(50) NOT NULL,
  `vk_page` varchar(250) NOT NULL,
  `operator_name` varchar(50) NOT NULL,
  `card_number` varchar(50) NOT NULL,
  `expiration_mon` int(2) DEFAULT NULL,
  `expiration_year` int(4) DEFAULT NULL,
  `role` enum('admin','login') NOT NULL,
  `is_loginza` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `hash` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `avatar`, `city`, `birthday`, `whatdo`, `mobile`, `email`, `model`, `os`, `pay`, `ym_purse`, `wm_purse`, `qiwi_purse`, `vk_page`, `operator_name`, `card_number`, `expiration_mon`, `expiration_year`, `role`, `is_loginza`, `deleted`, `hash`) VALUES
(1, 'admin', '160477360fdd0f2b5825a2ef039d37fe79be91e6e29d2e77a561242b07103358', 'Имя', 'Фами', NULL, '', '0000-01-24', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 'admin', 1, 0, ''),
(10, 'user10', '747cd227be2c7cdb80f76b241d9230b56f98ff3e81932074640d92517eb73404', 'Sergey', '', 1, '', '18-01-1990', 'work', '', 'truller@mail.ru', '', '', 'mobile', '', '', '', '', '', '', 0, 0, 'login', 0, 0, ''),
(9, 'user9', NULL, 'Sergey', 'Moroko', 1, '', '1990-01-18', '', '', 'morokosv@gmail.com', '', '', '', '', '', '', '', '', '', 0, 0, 'admin', 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `user_tokens`
--

INSERT INTO `user_tokens` (`id`, `user_id`, `user_agent`, `token`, `type`, `created`, `expires`) VALUES
(21, 1, 'd38981f9d908b607038777e8f0ba65deadabc3b6', 'de3a34aff3c009aea75d34ed4628676955400bb8', '', 1362670015, 1363879615),
(23, 4, '3436bcb34c7fd95b33a5800388906d53c89d82bf', '8bd60658cc61652d389a8471774ee7750f29d301', '', 1363187267, 1364396867),
(24, 7, '43eed23922a4bff99d7076f69755271510a6d714', '32ab2edc6bc3d1ca9e0f6e98612ea6f44e9688b7', '', 1363256210, 1364465810),
(41, 10, '43eed23922a4bff99d7076f69755271510a6d714', '30d01230cca85ad44a255db4d9e347fb08f65123', '', 1363609020, 1364818620);
