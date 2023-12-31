-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2023 at 07:50 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `svpbdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `role`) VALUES
(26, 'userjay', '$2y$10$HYepVhTc3TRUsHT9Hzw1Sej2ZgS6N8FZMaC2eBZlC5inQkpq86Dzm', 'user@gmail.com', 'user'),
(27, 'jc12', '$2y$10$u.e5Uu0FsCzN5H57VWmkO.r7nJ7DQRL61iyRY7XqZueKTrB//1UNe', 'jc@gmail.com', 'user'),
(28, 'jayz22', '$2y$10$aUUnYk9Rlp.FsUlWpD40l.RKYt40bZNF5vprtQ.XradXqbLsUfMoK', 'jayz@gc.com', 'user'),
(34, 'usertry11', '$2y$10$igYzfXws.qWlU1q0Gjh3z.0j8xBIuY3ajwOFBjiqQz91iEinksKuS', 'user', 'user'),
(35, 'jaytry', '$2y$10$1A8kKlRwzt7hPGmJlkIS4usFNfChIatXcS408AhFJXj4ipyPOUupe', 'jay', 'user'),
(36, 'jayjay', '$2y$10$ZSehGbrKp.N98eZDE7qFz.zpAnvxpbOFv7xIsl.RY/JCpBmLI.ORm', 'jay@gmail.com', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
