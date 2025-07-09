-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2025 at 12:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `quantity`) VALUES
(11, 'Bluetooth Keyboard', 29.99, 80),
(12, 'USB-C Cable', 9.99, 200),
(13, 'Laptop Stand', 39.99, 50),
(14, 'Webcam HD', 49.99, 60),
(15, 'Noise Cancelling Headphones', 89.99, 40),
(16, 'Portable Charger', 25.99, 90),
(17, 'Smartwatch', 99.99, 30),
(18, 'LED Desk Lamp', 22.49, 70),
(19, 'Gaming Chair', 149.99, 20),
(20, 'External Hard Drive', 64.99, 55),
(21, 'Wireless Earbuds', 59.99, 85),
(22, 'Mechanical Keyboard', 74.99, 45),
(23, 'Monitor 24-inch', 129.99, 35),
(24, 'Graphic Tablet', 89.99, 25),
(25, 'Microphone USB', 34.99, 65),
(26, 'HDMI Cable', 6.99, 150),
(27, 'VR Headset', 199.99, 15),
(28, 'Smartphone Tripod', 18.99, 95),
(29, 'Screen Cleaner Kit', 7.99, 120),
(30, 'kite', 1.00, 1),
(31, 'google pixel 9', 800.00, 1),
(32, 'frtr', 4.00, 1),
(63, 'iPhone Charger Type-C 30W', 44.99, 2),
(64, 'Samsung Galaxy S23 Case', 19.99, 5),
(65, 'Bluetooth Wireless Earbuds', 39.99, 10),
(66, 'Portable Power Bank 10000mAh', 24.50, 8),
(67, 'Logitech Wireless Mouse M330', 29.99, 12),
(68, 'Gaming Keyboard RGB Mechanical', 59.99, 3),
(69, 'USB-C to HDMI Adapter', 17.25, 6),
(70, 'Noise Cancelling Headphones', 89.00, 4),
(71, 'Smartwatch Fitness Tracker', 74.99, 7),
(72, 'Laptop Stand Adjustable Aluminum', 35.90, 9),
(73, 'Wireless Router Dual Band', 65.00, 4),
(74, '32GB USB 3.0 Flash Drive', 12.00, 15),
(75, 'External Hard Drive 1TB', 59.90, 6),
(76, 'Canon Ink Cartridge Black XL', 25.75, 3),
(77, 'HDMI Cable 2M Gold Plated', 8.99, 10),
(78, 'Wireless Charging Pad', 21.00, 5),
(79, 'LED Desk Lamp with USB Port', 32.50, 2),
(80, 'Echo Dot 5th Gen Smart Speaker', 49.99, 3),
(81, 'Google Nest Mini', 39.99, 7),
(82, 'Smart Light Bulb RGB WiFi', 14.99, 10),
(83, 'Portable Projector 1080p', 120.00, 2),
(84, 'Fitness Tracker Band', 29.99, 6),
(85, 'Smart Plug WiFi Outlet', 11.99, 5),
(86, 'Noise-Isolating In-Ear Headphones', 18.50, 8),
(87, 'Webcam Full HD 1080p', 45.00, 4),
(88, 'Mechanical Gaming Mouse', 34.90, 6),
(89, 'Adjustable Monitor Arm', 59.00, 2),
(90, 'Surge Protector Power Strip', 27.99, 7),
(91, 'USB Hub 4-Port 3.0', 14.00, 9),
(92, 'Ethernet Cable Cat6 5M', 9.50, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
