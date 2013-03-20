ALTER TABLE  `materials` CHANGE  `start`  `start` FLOAT UNSIGNED NULL DEFAULT NULL;

ALTER TABLE  `materials` CHANGE  `end`  `end` FLOAT UNSIGNED NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `materials_tags` (
  `material_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  KEY `material_id` (`material_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_tags_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
