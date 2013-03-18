-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 04, 2011 at 03:26 PM
-- Server version: 5.1.40
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `kohana`
--

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `statics`
--

INSERT INTO `statics` (`id`, `alias`, `title`, `body`, `time_create`, `time_update`) VALUES
(5, 'natasha', 'Наташа', '<div style="height:200px; width:250px; background-color:#f00;"> Text </div>', 0, 1301910863),
(6, 'test', 'Тест', 'uytuytuytuyt', 0, 0),
(7, 'sdf', 'Тест', 'uytuytuytuyt', 1301910847, NULL);
