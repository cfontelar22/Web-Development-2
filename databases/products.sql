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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `id`, `price`, `stock_quantity`, `category_id`, `created_at`, `updated_at`, `image_id`) VALUES
(89, 'EVGA SuperNOVA 650 G5 650W', 'Modular power supply for compact builds', NULL, 89.99, 26, 63, '2023-11-27 17:51:13', '2023-11-27 17:51:13', NULL),
(93, 'Intel Core i7-12700K', '8-core CPU for gaming and multitasking', NULL, 499.99, 45, 86, '2023-11-27 18:16:25', '2023-12-07 00:15:42', NULL),
(120, 'AMD Radeon RX 6800 XT', 'High-performance GPU for gaming and graphics work', NULL, 699.99, 12, 103, '2023-12-05 05:25:17', '2023-12-05 05:25:17', NULL),
(121, 'Noctua NH-D15', 'Dual-tower CPU cooler for excellent cooling performance', NULL, 89.99, 17, 104, '2023-12-05 05:28:15', '2023-12-05 05:28:15', NULL),
(122, 'Seasonic FOCUS GX-750 750W', 'Quiet and reliable power supply for gaming', NULL, 109.99, 18, 63, '2023-12-05 05:29:24', '2023-12-05 05:29:24', NULL),
(123, 'Corsair Vengeance LPX 16GB DDR4', 'High-performance RAM for gaming', NULL, 89.99, 40, 107, '2023-12-05 05:33:26', '2023-12-05 05:33:26', NULL),
(124, 'Crucial Ballistix 32GB DDR4', 'DDR4 RAM for multitasking and content creation', NULL, 149.99, 25, 107, '2023-12-05 05:34:07', '2023-12-05 05:34:07', NULL),
(125, 'AMD Ryzen 9 5900X', 'Powerful CPU from AMD', NULL, 549.99, 40, 86, '2023-12-05 05:37:31', '2023-12-05 05:37:31', NULL),
(126, 'ASUS ROG Strix Z590-E Gaming', 'High-end gaming motherboard', NULL, 349.99, 30, 88, '2023-12-05 05:43:38', '2023-12-05 05:43:38', NULL),
(127, 'MSI B450 TOMAHAWK MAX', 'Mid-range motherboard with good features', NULL, 129.99, 20, 88, '2023-12-05 05:45:59', '2023-12-05 05:45:59', NULL),
(128, 'NZXT Kraken X63 RGB', 'All-in-one liquid cooler with RGB pump', NULL, 159.99, 10, 104, '2023-12-05 05:47:14', '2023-12-05 05:47:14', NULL),
(202, 'NVIDIA GeForce RTX 3080', 'Powerful GPU for gaming and content creation', NULL, 799.99, 18, 103, '2023-12-08 05:45:53', '2023-12-08 05:45:53', NULL),
(203, 'Thermaltake Toughpower GF1 750W', 'Gold-rated power supply for gaming rigs', NULL, 99.99, 17, 63, '2023-12-08 05:46:57', '2023-12-08 05:46:57', NULL),
(204, 'Arctic P12 PWM PST Value Pack', 'Budget-friendly PWM case fans', NULL, 29.99, 25, 104, '2023-12-08 05:48:11', '2023-12-08 05:48:11', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
