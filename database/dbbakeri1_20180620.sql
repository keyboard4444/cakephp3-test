-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: Jun 19, 2018 at 04:48 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbbakeri1`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `body` text,
  `rating` int(2) UNSIGNED DEFAULT NULL,
  `published` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `contact_id`, `title`, `slug`, `body`, `rating`, `published`, `created`, `modified`) VALUES
(1, 1, 1, 'First Post', 'first-post', 'This is the first post.', 5, 1, '2018-05-03 22:49:37', '2018-05-03 22:49:37'),
(2, 1, 1, 'HELLO WORLD 1', 'hellow-world-1', 'this is a test', 4, 1, '2018-05-05 00:00:00', '2018-05-05 00:00:00'),
(3, 1, 1, 'HELLO WORLD 2', 'hellow-world-2', 'this is a test', 3, 1, '2018-05-05 00:00:00', '2018-05-05 00:00:00'),
(4, 1, 2, 'HELLO WORLD 3', 'hellow-world-3', 'this is a test', 2, 1, '2018-05-05 00:00:00', '2018-05-05 00:00:00'),
(5, 1, 2, 'HELLO WORLD 4', 'hellow-world-4', 'this is a test', 1, 1, '2018-05-05 00:00:00', '2018-05-05 00:00:00'),
(6, 1, 2, 'HELLO WORLD 5', 'hellow-world-5', 'this is a test', 5, 1, '2018-05-05 00:00:00', '2018-05-05 00:00:00'),
(7, 1, 4, 'HELLO WORLD 6', 'hellow-world-6', 'this is a test', 5, 1, '2018-05-05 00:00:00', '2018-05-05 00:00:00'),
(8, 1, 4, 'HELLO WORLD 7', 'hellow-world-7', 'this is a test', 4, 1, '2018-05-05 00:00:00', '2018-05-05 00:00:00'),
(9, 1, 4, 'HELLO WORLD 8', 'hellow-world-8', 'this is a test', 3, 1, '2018-05-05 00:00:00', '2018-05-05 00:00:00'),
(10, 1, 4, 'HELLO WORLD 9', 'hellow-world-9', 'this is a test', 3, 1, '2018-05-05 00:00:00', '2018-05-05 00:00:00'),
(11, 1, 4, 'HELLO WORLD 10', 'hellow-world-10', 'this is a test', 3, 1, '2018-05-05 00:00:00', '2018-05-05 00:00:00'),
(12, 1, 2, 'HELLO WORLD 11', 'hellow-world-11', 'this is a test', 3, 1, '2018-05-05 00:00:00', '2018-05-05 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `articles_tags`
--

CREATE TABLE `articles_tags` (
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `age` int(3) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `age`, `user_id`) VALUES
(1, 'abu', 10, 1),
(2, 'ali', 20, 1),
(4, 'Raju', 40, 2);

-- --------------------------------------------------------

--
-- Table structure for table `log_entry`
--

CREATE TABLE `log_entry` (
  `id` int(10) UNSIGNED NOT NULL,
  `level` varchar(100) DEFAULT NULL,
  `message` text,
  `context` text,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_entry`
--

INSERT INTO `log_entry` (`id`, `level`, `message`, `context`, `created`) VALUES
(18, 'alert', 'This is a JOJO 55', '', '2018-06-19 16:47:07'),
(19, 'alert', 'This is a JOJO 66', '', '2018-06-19 16:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created`, `modified`) VALUES
(1, 'cakephp@example.com', 'sekret', '2018-05-03 22:49:37', '2018-05-03 22:49:37'),
(2, 'abu@asd.com', '1234', '2018-05-01 00:00:00', '2018-05-01 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `user_key` (`user_id`);

--
-- Indexes for table `articles_tags`
--
ALTER TABLE `articles_tags`
  ADD PRIMARY KEY (`article_id`,`tag_id`),
  ADD KEY `tag_key` (`tag_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_entry`
--
ALTER TABLE `log_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `log_entry`
--
ALTER TABLE `log_entry`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `user_key` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `articles_tags`
--
ALTER TABLE `articles_tags`
  ADD CONSTRAINT `article_key` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `tag_key` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
