-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2022 at 11:48 PM
-- Server version: 5.5.31
-- PHP Version: 5.3.28

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yagelnew_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(9) CHARACTER SET utf8 NOT NULL,
  `item_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `tag` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `item_id`, `status`, `tag`) VALUES
(1, '1234', 6, 'my', ''),
(2, '4321', 1, 'my', ''),
(3, '4321', 1, 'my', ''),
(4, '1234', 5, 'my', ''),
(5, '1234', 3, 'my', ''),
(6, '4321', 4, 'my', ''),
(7, '4321', 3, 'my', '');

-- --------------------------------------------------------

--
-- Table structure for table `ItemsList`
--

CREATE TABLE IF NOT EXISTS `ItemsList` (
  `id` int(11) NOT NULL,
  `name` varchar(15) CHARACTER SET utf8 NOT NULL,
  `value` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ItemsList`
--

INSERT INTO `ItemsList` (`id`, `name`, `value`) VALUES
(1, 'Water', 1),
(2, 'Shirt', 3),
(3, 'Pants', 4),
(4, 'Dog', 5),
(5, 'Soup', 8),
(6, 'BE developer', 10);

-- --------------------------------------------------------

--
-- Table structure for table `trade`
--

CREATE TABLE IF NOT EXISTS `trade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(9) CHARACTER SET utf8 NOT NULL,
  `item_id` int(11) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `temp_user_id` varchar(9) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `trade`
--

INSERT INTO `trade` (`id`, `user_id`, `item_id`, `tag`, `temp_user_id`) VALUES
(1, '1234', 2, 'bided', '4321'),
(2, '1234', 3, 'bided', '4321'),
(3, '4321', 5, 'traded', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` varchar(9) NOT NULL,
  `name` varchar(55) CHARACTER SET utf8 NOT NULL,
  `image` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `image`) VALUES
('1234', 'yagel', '../../upload/images.png'),
('4321', 'dana', '../../upload/images_2.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
