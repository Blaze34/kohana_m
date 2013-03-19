CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `categories` (`id`, `name`, `sort`, `parent_id`) VALUES
(1, 'Категория 1', 1, NULL),
(2, 'Категория 2', 2, NULL),
(3, 'Категория 3', 3, NULL),
(4, 'Категория 1.1', 1, 1),
(5, 'Категория 1.2', 2, 1),
(6, 'Категория 1.3', 3, 1),
(7, 'Категория 1.4', 4, 1),
(8, 'Категория 1.5', 5, 1),
(9, 'Категория 1.6', 6, 1),
(10, 'Категория 2.1', 1, 2),
(11, 'Категория 2.3', 3, 2),
(12, 'Категория 2.4', 4, 2),
(13, 'Категория 3.5', 5, 3),
(14, 'Категория 3.6', 6, 4);

CREATE TABLE IF NOT EXISTS `materials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `video` varchar(50) DEFAULT NULL,
  `start` int(10) unsigned DEFAULT NULL,
  `end` int(10) unsigned DEFAULT NULL,
  `file` varchar(50) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `rating` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;