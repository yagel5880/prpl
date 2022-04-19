-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 19, 2022 at 08:13 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prpl`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `user_id` varchar(9) CHARACTER SET utf8 NOT NULL,
  `item_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `tag` varchar(10) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `item_id`, `status`, `tag`) VALUES
(1, '1234', 4, 'my', ''),
(2, '1234', 3, 'my', ''),
(3, '1234', 4, 'my', ''),
(4, '1234', 4, 'my', ''),
(5, '1234', 3, 'my', ''),
(6, '1234', 2, 'my', ''),
(7, '4321', 6, 'my', ''),
(8, '4321', 5, 'my', ''),
(9, '5678', 2, 'my', ''),
(10, '4321', 5, 'my', ''),
(11, '8765', 6, 'my', ''),
(12, '8765', 5, 'my', '');

-- --------------------------------------------------------

--
-- Table structure for table `ItemsList`
--

CREATE TABLE `ItemsList` (
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

CREATE TABLE `trade` (
  `id` int(11) NOT NULL,
  `user_id` varchar(9) CHARACTER SET utf8 NOT NULL,
  `item_id` int(11) NOT NULL,
  `tag` varchar(10) NOT NULL,
  `temp_user_id` varchar(9) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trade`
--

INSERT INTO `trade` (`id`, `user_id`, `item_id`, `tag`, `temp_user_id`) VALUES
(1, '4321', 1, 'bided', '1234'),
(2, '4321', 3, 'bided', '1234'),
(3, '4321', 2, 'bided', '1234'),
(4, '4321', 4, 'bided', '1234'),
(7, '1234', 5, 'trade', '4321'),
(8, '1234', 6, 'trade', '4321'),
(9, '5678', 8, 'traded', '4321'),
(10, '1234', 7, 'traded', '4321');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(9) CHARACTER SET utf8 NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `image` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `image`) VALUES
('1234', 'test', '../../upload/arrow_big.png'),
('4321', 'yagel', '../../upload/arrow_big.png'),
('5678', 'dan', '../../upload/arrow_big.png'),
('8765', 'meni', '../../upload/arrow_big.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ItemsList`
--
ALTER TABLE `ItemsList`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trade`
--
ALTER TABLE `trade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ItemsList`
--
ALTER TABLE `ItemsList`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `trade`
--
ALTER TABLE `trade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
