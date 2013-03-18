-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 14 2013 г., 16:25
-- Версия сервера: 5.5.29
-- Версия PHP: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `chat`
--

-- --------------------------------------------------------

--
-- Структура таблицы `flashes`
--

CREATE TABLE IF NOT EXISTS `flashes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `data` text,
  `date` int(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Stores system info' AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `flashes`
--

INSERT INTO `flashes` (`id`, `user_id`, `data`, `date`) VALUES
(1, 1, 'a:1:{s:6:"errors";a:1:{i:0;s:72:"Невозможно отправить письмо на этот Email";}}', 1363187127),
(2, 1, 'a:1:{s:7:"success";a:1:{i:0;s:67:"Пароль удачно изменен и выслан на Email";}}', 1363187141),
(3, 1, 'a:1:{s:7:"success";a:1:{i:0;s:67:"Пароль удачно изменен и выслан на Email";}}', 1363187250);

-- --------------------------------------------------------

--
-- Структура таблицы `loginza`
--

CREATE TABLE IF NOT EXISTS `loginza` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identity` varchar(250) NOT NULL,
  `provider` varchar(250) NOT NULL,
  `dt_create` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Структура таблицы `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msg` text NOT NULL,
  `date` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Структура таблицы `storage`
--

CREATE TABLE IF NOT EXISTS `storage` (
  `name` varchar(50) NOT NULL,
  `value` varchar(250) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Структура таблицы `tasks`
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

--
-- Структура таблицы `users`
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `avatar`, `city`, `birthday`, `whatdo`, `mobile`, `email`, `model`, `os`, `pay`, `ym_purse`, `wm_purse`, `qiwi_purse`, `vk_page`, `operator_name`, `card_number`, `expiration_mon`, `expiration_year`, `role`, `is_loginza`, `deleted`, `hash`) VALUES
(1, 'admin', '160477360fdd0f2b5825a2ef039d37fe79be91e6e29d2e77a561242b07103358', 'Имя', 'Фами', NULL, '', '0000-01-24', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 'admin', 1, 0, ''),
(5, 'user5', '918fd9b0784233f265c13c6e057b622f81fcc41ad2605addc4e0d7a7016f8a91', 'Мое Имя', 'Моя Фамилия', NULL, 'Город', '', '', '', '30aveny-blaze@mail.ru', '', '', 'wm', '', '', '', '', '', '', 0, 0, 'login', 0, 0, ''),
(4, 'TyG', '161b11abbbe7f73d8e17f95ca2f0137d81d8e66834bf21f34a0d4a2b3f2fedc6', 'Имямоё', 'Фами', NULL, '', '01-02-1988', 'work', '', 'user10@user.uu', 'айфон', '', 'ym', '123123123', '', '', 'https://vk.com/123123', '', '', 0, 0, 'login', 0, 0, '689f1fcd64abf9c745e920eb1996e6f5bc371dd6'),
(6, 'user6', '76e567341c856a22004a00f56c0510d7d52716e3d329111430d79b6794036947', 'Name', 'Surname', NULL, 'City', '01-02-1977', 'work', '', 'user100@user.uu', 'nokia', '', 'wm', '', '12312312', '', '', '', '', NULL, NULL, 'login', 0, 0, ''),
(7, 'qwe', '918fd9b0784233f265c13c6e057b622f81fcc41ad2605addc4e0d7a7016f8a91', 'aaa', 'bbb', NULL, '', '', '', '', 'test@m.ru', '', '', 'wm', '', '', '', '', '', '', 0, 0, 'admin', 0, 0, ''),
(8, '[Bl@ze_aka_Amadeo]', '918fd9b0784233f265c13c6e057b622f81fcc41ad2605addc4e0d7a7016f8a91', 'Виктор', 'Гулый', 1, '', '1988-09-18', '', '', '30avenyamadeo@gmail.com', '', '', '', '', '', '', '', '', '', 0, 0, 'login', 1, 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `user_tokens`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `user_tokens`
--

INSERT INTO `user_tokens` (`id`, `user_id`, `user_agent`, `token`, `type`, `created`, `expires`) VALUES
(21, 1, 'd38981f9d908b607038777e8f0ba65deadabc3b6', 'de3a34aff3c009aea75d34ed4628676955400bb8', '', 1362670015, 1363879615),
(23, 4, '3436bcb34c7fd95b33a5800388906d53c89d82bf', '8bd60658cc61652d389a8471774ee7750f29d301', '', 1363187267, 1364396867),
(24, 7, '43eed23922a4bff99d7076f69755271510a6d714', '32ab2edc6bc3d1ca9e0f6e98612ea6f44e9688b7', '', 1363256210, 1364465810);
