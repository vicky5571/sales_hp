-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2024 at 04:54 PM
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
-- Database: `sales_hp`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Redmi Note 9 Pro 6/64'),
(2, 'Samsung Galaxy'),
(3, 'Xiaomi Pad 5'),
(4, 'Ipad'),
(5, 'Tab Samsung A7'),
(6, 'Realme X2 Pro'),
(12, 'Iphone 11 64GB'),
(13, 'Iphone XR'),
(14, 'Nokia'),
(15, 'Iphone 12'),
(16, 'Redmi 14C');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `buy_price` decimal(10,2) NOT NULL,
  `srp` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_name`, `color`, `quantity`, `buy_price`, `srp`, `category_id`, `date`) VALUES
(6, 'Redmi Note 9 Pro 6/64', 'Black', 3, 1000000.00, 1100000.00, 1, '2024-06-30'),
(7, 'Samsung Galaxy', 'Black', 3, 1000000.00, 1100000.00, 2, '2024-06-30'),
(8, 'Tab Samsung A7', 'Green', 1, 4000000.00, 4100000.00, 5, '2024-07-11'),
(9, 'Realme X2 Pro', 'Green', 2, 4000000.00, 4100000.00, 6, '2024-07-13'),
(13, 'Ipad', 'Blue', 0, 1100000.00, 1200000.00, 4, '2024-07-14'),
(14, 'Redmi Note 9 Pro 6/64', 'Blue', 1, 1100000.00, 1200000.00, 1, '2024-07-14'),
(15, 'Iphone XR', 'Biru', 0, 4500000.00, 4600000.00, 13, '2024-07-15'),
(16, 'Nokia', 'Black', 0, 2000000.00, 2500000.00, 14, '2024-07-15'),
(17, 'Iphone 12', 'hitam', 1, 6000000.00, 6500000.00, 15, '2024-07-15'),
(18, 'Redmi Note 9 Pro 6/64', 'hitam', 2, 6000000.00, 6500000.00, 1, '2024-07-08'),
(19, 'Redmi 14C', 'hitam', 2, 6000000.00, 6500000.00, 16, '2024-07-11');

-- --------------------------------------------------------

--
-- Table structure for table `product_units`
--

CREATE TABLE `product_units` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `imei` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_units`
--

INSERT INTO `product_units` (`id`, `product_id`, `imei`) VALUES
(3, 7, '143234'),
(4, 7, '321423'),
(5, 8, '234567'),
(6, 8, '123123'),
(7, 9, '231312'),
(8, 9, '412343'),
(21, 7, '557167'),
(24, 6, '123874'),
(25, 6, '812283'),
(29, 14, ' 781923'),
(34, 17, '311233');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `profit` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `imei` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `sale_price`, `quantity`, `total_price`, `profit`, `date`, `imei`) VALUES
(3, 7, 4000000.00, 1, 4000000.00, NULL, '2024-06-30', ''),
(4, 6, 1100000.00, 1, 1100000.00, NULL, '2024-06-30', ''),
(5, 8, 4200000.00, 2, 8400000.00, 400000.00, '2024-07-11', ''),
(6, 9, 4000000.00, 1, 4000000.00, 0.00, '2024-07-14', '567432'),
(18, 6, 2300000.00, 1, 2300000.00, 1300000.00, '2024-07-14', ''),
(19, 13, 2300000.00, 1, 2300000.00, 1200000.00, '2024-07-14', ''),
(20, 13, 4000000.00, 1, 4000000.00, 2900000.00, '2024-07-14', ''),
(22, 13, 4000000.00, 1, 4000000.00, 2900000.00, '2024-07-14', ''),
(23, 13, 4000000.00, 1, 4000000.00, 2900000.00, '2024-07-14', ''),
(25, 6, 4000000.00, 1, 4000000.00, 3000000.00, '2024-07-14', ''),
(26, 6, 1100000.00, 1, 1100000.00, 100000.00, '2024-07-14', ''),
(28, 6, 4000000.00, 1, 4000000.00, 3000000.00, '2024-07-14', '768967'),
(29, 14, 4000000.00, 1, 4000000.00, 2900000.00, '2024-07-14', '719268'),
(30, 15, 4800000.00, 1, 4800000.00, 300000.00, '2024-07-15', '765112'),
(31, 15, 7000000.00, 1, 7000000.00, 2500000.00, '2024-07-15', '9108283'),
(32, 16, 2600000.00, 1, 2600000.00, 600000.00, '2024-07-15', '12345'),
(33, 17, 7000000.00, 1, 7000000.00, 1000000.00, '2024-07-15', '2323878'),
(34, 17, 7500000.00, 1, 7500000.00, 1500000.00, '2024-07-15', '453234');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`) VALUES
(3, 'Vicky', 'vicky1', '$2y$10$i7GyZrXL6eWU6qf38xR7YOIfAuLGpZcH6TXGUNGW60qNd.zNhXSjq', 1),
(4, 'Vicky Admin', 'vicky2', '$2y$10$duwinqaZ/KhFbA2V.T5ADei5bRfHkIGADXnnS0URucYQkLbn23v7G', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_units`
--
ALTER TABLE `product_units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `imei` (`imei`) USING HASH,
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_units`
--
ALTER TABLE `product_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_units`
--
ALTER TABLE `product_units`
  ADD CONSTRAINT `product_units_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
