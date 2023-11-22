-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2023 at 05:12 PM
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
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `stock_quantity`, `category_id`) VALUES
(1, 'Intel Core i9-11900K', 'High-performance CPU from Intel', 599.99, 50, 1),
(2, 'AMD Ryzen 9 5900X', 'Powerful CPU from AMD', 549.99, 40, 1),
(3, 'Intel Core i7-12700K', '8-core CPU for gaming and multitasking', 449.99, 35, 1),
(4, 'AMD Ryzen 7 5800X', 'Octa-core processor for high-end performance', 399.99, 30, 1),
(5, 'Intel Core i5-12600K', '6-core CPU with strong gaming capabilities', 299.99, 25, 1),
(6, 'ASUS ROG Strix Z590-E Gaming', 'High-end gaming motherboard', 349.99, 30, 2),
(7, 'MSI B450 TOMAHAWK MAX', 'Mid-range motherboard with good features', 129.99, 20, 2),
(8, 'GIGABYTE X570 AORUS PRO WIFI', 'Feature-rich motherboard for content creation', 279.99, 25, 2),
(9, 'ASRock B550M PRO4', 'Budget-friendly micro-ATX motherboard', 89.99, 15, 2),
(10, 'MSI MPG B550 GAMING PLUS', 'ATX motherboard with RGB lighting', 159.99, 18, 2),
(11, 'Corsair Vengeance LPX 16GB DDR4', 'High-performance RAM for gaming', 89.99, 40, 3),
(12, 'Crucial Ballistix 32GB DDR4', 'DDR4 RAM for multitasking and content creation', 149.99, 25, 3),
(13, 'G.SKILL Ripjaws V 64GB DDR4', 'Large capacity RAM for professional workloads', 239.99, 20, 3),
(14, 'HyperX Fury 8GB DDR4', 'Entry-level DDR4 RAM for budget builds', 49.99, 30, 3),
(15, 'Team T-FORCE DARK Z 16GB DDR4', 'Sleek and efficient DDR4 RAM', 69.99, 35, 3),
(16, 'Samsung 970 EVO Plus 1TB NVMe SSD', 'High-speed NVMe SSD for fast storage', 169.99, 15, 4),
(17, 'WD Blue 2TB HDD', 'Cost-effective HDD for mass storage', 64.99, 25, 4),
(18, 'Crucial MX500 500GB SATA SSD', 'Reliable SATA SSD for general use', 89.99, 20, 4),
(19, 'Seagate Barracuda 4TB HDD', 'Large capacity HDD for data storage', 99.99, 18, 4),
(20, 'ADATA XPG SX8200 Pro 512GB NVMe SSD', 'NVMe SSD with high endurance', 119.99, 22, 4),
(21, 'NVIDIA GeForce RTX 3080', 'Powerful GPU for gaming and content creation', 799.99, 10, 5),
(22, 'AMD Radeon RX 6800 XT', 'High-performance GPU for gaming and graphics work', 699.99, 12, 5),
(23, 'EVGA GeForce GTX 1660 SUPER', 'Budget-friendly GPU for entry-level gaming', 249.99, 15, 5),
(24, 'ZOTAC GAMING GeForce RTX 3060', 'Mid-range GPU with ray tracing support', 349.99, 18, 5),
(25, 'ASUS TUF Gaming GeForce GTX 1650', 'Entry-level GPU for casual gaming', 149.99, 20, 5),
(26, 'Corsair RM850x 850W', 'High-efficiency power supply for gaming PCs', 129.99, 15, 6),
(27, 'EVGA SuperNOVA 650 G5 650W', 'Modular power supply for compact builds', 89.99, 20, 6),
(28, 'Seasonic FOCUS GX-750 750W', 'Quiet and reliable power supply for gaming', 109.99, 18, 6),
(29, 'NZXT C650 650W', 'Compact power supply with sleeved cables', 79.99, 22, 6),
(30, 'Thermaltake Toughpower GF1 750W', 'Gold-rated power supply for gaming rigs', 99.99, 17, 6),
(31, 'Noctua NH-D15', 'Dual-tower CPU cooler for excellent cooling performance', 89.99, 12, 7),
(32, 'Cooler Master Hyper 212 RGB', 'Popular air cooler with RGB lighting', 49.99, 15, 7),
(33, 'NZXT Kraken X63 RGB', 'All-in-one liquid cooler with RGB pump', 159.99, 10, 7),
(34, 'Corsair LL120 RGB Case Fans', 'High-performance RGB case fans for airflow', 39.99, 20, 7),
(35, 'Arctic P12 PWM PST Value Pack', 'Budget-friendly PWM case fans', 29.99, 25, 7),
(36, 'Intel Gigabit CT PCI-E Network Adapter', 'Reliable NIC for wired network connectivity', 34.99, 30, 8),
(37, 'TP-Link Archer T6E AC1300 PCIe Wireless Adapter', 'Wireless NIC for high-speed Wi-Fi', 29.99, 25, 8),
(38, 'ASUS PCE-AC88 AC3100 PCIe Adapter', 'High-performance wireless NIC with multiple antennas', 79.99, 18, 8),
(39, 'Netgear Nighthawk AX8 AX6000 Wi-Fi 6 Adapter', 'Wi-Fi 6 NIC for next-gen wireless connectivity', 129.99, 15, 8),
(40, 'Rosewill 10/100/1000Mbps Gigabit PCI Express PCIe Network Adapter', 'Gigabit NIC for fast and reliable wired networking', 19.99, 22, 8),
(41, 'Logitech G Pro X Mechanical Gaming Keyboard', 'Customizable mechanical keyboard and swappable switches', 149.99, 18, 9),
(42, 'Razer Naga Trinity Gaming Mouse', 'Versatile gaming mouse with customizable side plates', 99.99, 22, 9),
(43, 'Corsair Dark Core RGB/SE Wired/Wireless Gaming Mouse', 'Wireless gaming mouse with customizable RGB lighting', 79.99, 25, 9),
(44, 'SteelSeries QcK Gaming Surface', 'Large gaming mousepad for precise control', 19.99, 30, 9),
(45, 'HyperX Alloy FPS Pro Mechanical Gaming Keyboard', 'Compact mechanical keyboard for FPS gaming', 69.99, 28, 9),
(46, 'LG UltraGear 27\" 4K UHD IPS Gaming Monitor', '4K UHD gaming monitor with IPS panel', 499.99, 15, 10),
(47, 'Alienware AW3418DW 34\" UltraWide QHD Nano IPS Monitor', 'UltraWide monitor with Nano IPS technology', 799.99, 10, 10),
(48, 'ASUS VG278QR 27\" Full HD 165Hz Gaming Monitor', 'Full HD gaming monitor with high refresh rate', 249.99, 18, 10),
(49, 'Acer R240HY bidx 23.8\" IPS HDMI Monitor', 'Affordable IPS monitor for general use', 129.99, 22, 10),
(50, 'Samsung Odyssey G7 32\" QHD 240Hz Curved Gaming Monitor', 'Curved gaming monitor with high refresh rate', 699.99, 12, 10),
(51, 'HP OfficeJet Pro 9015 All-in-One Printer', 'All-in-one printer for home office use', 229.99, 15, 11),
(52, 'Epson WorkForce ES-400 Document Scanner', 'Compact document scanner for efficient digitization', 329.99, 10, 11),
(53, 'Canon PIXMA TS8320 Wireless Inkjet All-in-One Printer', 'Wireless inkjet printer with versatile features', 149.99, 20, 11),
(54, 'Arlo Pro 3 Wireless Security Camera System', 'Wire-free security camera system with 2K HDR', 499.99, 8, 12),
(55, 'Nest Hello Video Doorbell', 'Smart video doorbell with facial recognition', 229.99, 12, 12),
(56, 'SimpliSafe 8-Piece Wireless Home Security System', 'Comprehensive wireless home security solution', 299.99, 10, 12),
(57, 'Ring Alarm 5-Piece Kit (2nd Gen)', 'DIY home security system with optional professional monitoring', 199.99, 15, 12),
(58, 'August Wi-Fi Smart Lock', 'Smart lock for keyless home entry', 199.99, 18, 12),
(59, 'Ubiquiti UniFi Dream Machine', 'All-in-one network solution with security gateway', 299.99, 10, 13),
(60, 'TP-Link 24-Port Gigabit Ethernet Unmanaged Switch', 'High-performance unmanaged switch for network expansion', 129.99, 15, 13),
(61, 'Monoprice SlimRun Cat6A Ethernet Patch Cable', 'Slim and flexible Cat6A patch cable for structured cabling', 12.99, 25, 13),
(62, 'Cisco Catalyst 2960X-48TS-L Ethernet Switch', 'Enterprise-grade Ethernet switch for business networks', 599.99, 8, 13),
(63, 'Netgear Orbi Whole Home Mesh Wi-Fi System', 'Mesh Wi-Fi system for seamless whole-home coverage', 349.99, 12, 13),
(64, 'Amazon Web Services (AWS) Cloud Services', 'Scalable and secure cloud computing services', 99.99, 50, 14),
(65, 'VMware Silver Peak SD-WAN', 'Software-defined wide-area network for optimized connectivity', 49.99, 40, 14),
(66, 'Western Digital Technologies Hybrid Cloud Storage', 'Hybrid cloud storage for flexible data management', 79.99, 35, 14),
(67, 'Microsoft 365 Business Clockwise Package', 'Integrated business productivity tools and cloud services', 19.99, 30, 14),
(68, 'Cisco Webex Collaboration Suite', 'Collaboration tools for seamless communication and teamwork', 29.99, 25, 14);

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
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
