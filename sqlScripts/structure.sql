-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 28, 2018 at 09:20 PM
-- Server version: 5.6.38
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `color_id` int(8) NOT NULL DEFAULT '0',
  `color_name` varchar(50) DEFAULT NULL,
  `color_code` char(6) DEFAULT NULL,
  `is_transparent` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `favorite_sets`
--

CREATE TABLE `favorite_sets` (
  `favorite_id` int(8) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `set_id` int(8) DEFAULT NULL,
  `comment` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `minifigs`
--

CREATE TABLE `minifigs` (
  `minifig_id` int(8) NOT NULL,
  `theme_id` int(8) DEFAULT NULL,
  `minifig_part_number` varchar(20) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `year_released` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `minifig_contents`
--

CREATE TABLE `minifig_contents` (
  `minifig_id` int(8) DEFAULT NULL,
  `part_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `part_number` varchar(50) NOT NULL DEFAULT '',
  `part_category_id` int(8) DEFAULT NULL,
  `part_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `part_categories`
--

CREATE TABLE `part_categories` (
  `part_category_id` int(11) NOT NULL,
  `part_category_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `part_images`
--

CREATE TABLE `part_images` (
  `color_id` int(8) DEFAULT NULL,
  `part_number` varchar(50) DEFAULT NULL,
  `image` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `passwords`
--

CREATE TABLE `passwords` (
  `user_id` int(10) DEFAULT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sets`
--

CREATE TABLE `sets` (
  `set_id` int(8) NOT NULL,
  `theme_id` int(8) DEFAULT NULL,
  `set_name` varchar(200) DEFAULT NULL,
  `set_num` varchar(20) DEFAULT NULL,
  `year_released` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `set_contents`
--

CREATE TABLE `set_contents` (
  `set_id` int(8) DEFAULT NULL,
  `color_id` int(8) DEFAULT NULL,
  `part_number` varchar(50) DEFAULT NULL,
  `quantity` tinyint(3) DEFAULT NULL,
  `is_spare_part` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `theme_id` int(8) NOT NULL DEFAULT '0',
  `theme_name` varchar(200) DEFAULT NULL,
  `theme_parent_id` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `favorite_sets`
--
ALTER TABLE `favorite_sets`
  ADD PRIMARY KEY (`favorite_id`),
  ADD UNIQUE KEY `unique_favorite_pair` (`favorite_id`,`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `set_id` (`set_id`);

--
-- Indexes for table `minifigs`
--
ALTER TABLE `minifigs`
  ADD PRIMARY KEY (`minifig_id`);

--
-- Indexes for table `minifig_contents`
--
ALTER TABLE `minifig_contents`
  ADD KEY `minifig_id` (`minifig_id`),
  ADD KEY `part_number` (`part_number`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`part_number`),
  ADD KEY `part_category_id` (`part_category_id`);

--
-- Indexes for table `part_categories`
--
ALTER TABLE `part_categories`
  ADD PRIMARY KEY (`part_category_id`);

--
-- Indexes for table `part_images`
--
ALTER TABLE `part_images`
  ADD KEY `color_id` (`color_id`),
  ADD KEY `part_number` (`part_number`);

--
-- Indexes for table `passwords`
--
ALTER TABLE `passwords`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sets`
--
ALTER TABLE `sets`
  ADD PRIMARY KEY (`set_id`),
  ADD KEY `theme_id` (`theme_id`);

--
-- Indexes for table `set_contents`
--
ALTER TABLE `set_contents`
  ADD KEY `color_id` (`color_id`),
  ADD KEY `part_number` (`part_number`),
  ADD KEY `set_id` (`set_id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`theme_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favorite_sets`
--
ALTER TABLE `favorite_sets`
  MODIFY `favorite_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `minifigs`
--
ALTER TABLE `minifigs`
  MODIFY `minifig_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10126;

--
-- AUTO_INCREMENT for table `part_categories`
--
ALTER TABLE `part_categories`
  MODIFY `part_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `sets`
--
ALTER TABLE `sets`
  MODIFY `set_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18709;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorite_sets`
--
ALTER TABLE `favorite_sets`
  ADD CONSTRAINT `favorite_sets_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `favorite_sets_ibfk_4` FOREIGN KEY (`set_id`) REFERENCES `sets` (`set_id`);

--
-- Constraints for table `minifig_contents`
--
ALTER TABLE `minifig_contents`
  ADD CONSTRAINT `minifig_contents_ibfk_1` FOREIGN KEY (`minifig_id`) REFERENCES `minifigs` (`minifig_id`),
  ADD CONSTRAINT `minifig_contents_ibfk_2` FOREIGN KEY (`part_number`) REFERENCES `parts` (`part_number`);

--
-- Constraints for table `parts`
--
ALTER TABLE `parts`
  ADD CONSTRAINT `parts_ibfk_1` FOREIGN KEY (`part_category_id`) REFERENCES `part_categories` (`part_category_id`);

--
-- Constraints for table `part_images`
--
ALTER TABLE `part_images`
  ADD CONSTRAINT `part_images_ibfk_2` FOREIGN KEY (`part_number`) REFERENCES `parts` (`part_number`);

--
-- Constraints for table `passwords`
--
ALTER TABLE `passwords`
  ADD CONSTRAINT `passwords_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `sets`
--
ALTER TABLE `sets`
  ADD CONSTRAINT `sets_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`theme_id`);

--
-- Constraints for table `set_contents`
--
ALTER TABLE `set_contents`
  ADD CONSTRAINT `set_contents_ibfk_3` FOREIGN KEY (`part_number`) REFERENCES `parts` (`part_number`),
  ADD CONSTRAINT `set_contents_ibfk_4` FOREIGN KEY (`set_id`) REFERENCES `sets` (`set_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
