-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2024 at 06:35 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pantrian`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int NOT NULL,
  `brand_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `deskripsi`) VALUES
(1, 'Yamaha', ''),
(2, 'Honda', 'YAKIN');

-- --------------------------------------------------------

--
-- Table structure for table `montors`
--

CREATE TABLE `montors` (
  `id` int NOT NULL,
  `mtr_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `brand_id` int NOT NULL,
  `img` text COLLATE utf8mb4_general_ci NOT NULL,
  `harga` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `montors`
--

INSERT INTO `montors` (`id`, `mtr_name`, `brand_id`, `img`, `harga`, `deskripsi`) VALUES
(9, 'PCX', 1, 'Screenshot 2023-09-17 184128.png', '100000', 't');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int NOT NULL,
  `tag` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `perm_desc` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `tag`, `perm_desc`) VALUES
(1, 'USRA', 'Add Users'),
(2, 'USRE', 'Edit Users'),
(3, 'USRV', 'View Users'),
(4, 'USRD', 'Delete Users'),
(5, 'RLA', 'Add Roles'),
(6, 'RLE', 'Edit Roles'),
(7, 'RLV', 'View Roles'),
(8, 'RLD', 'Delete Roles'),
(9, 'VWDSB', 'View Dashboard'),
(10, 'VWBRD', 'View Brands'),
(11, 'EDBRD', 'Edit Brand'),
(12, 'ABRD', 'Add Brands'),
(13, 'DBRD', 'Delete Brand'),
(14, 'VWSLS', 'View Sales'),
(15, 'ASLS', 'Add Sales'),
(16, 'ESLS', 'Edit Sales'),
(17, 'DSLS', 'Delete Sales');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `role` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'Administrator'),
(4, 'HRD');

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `id` int NOT NULL,
  `role_id` int NOT NULL,
  `perm_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `perm_id`) VALUES
(1, 4, 1),
(2, 4, 2),
(3, 4, 3),
(4, 4, 4),
(5, 4, 5),
(6, 4, 6),
(7, 4, 7),
(8, 4, 8),
(69, 1, 1),
(70, 1, 2),
(71, 1, 3),
(72, 1, 4),
(73, 1, 5),
(74, 1, 6),
(75, 1, 7),
(76, 1, 8),
(77, 1, 9),
(78, 1, 10),
(79, 1, 11),
(80, 1, 12),
(81, 1, 13),
(82, 1, 14),
(83, 1, 15),
(84, 1, 16),
(85, 1, 17);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `montor_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `payment` text COLLATE utf8mb4_general_ci NOT NULL,
  `nomerhp` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `name`, `montor_id`, `user_id`, `payment`, `nomerhp`, `alamat`, `status`, `created_at`) VALUES
(4, 'nayarf', 9, NULL, 'ONLINE', '081348150488', 'kademangan', 1, '2024-06-19 00:40:48');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomerhp` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `montor` text COLLATE utf8mb4_general_ci,
  `user_id` int DEFAULT NULL,
  `service_type` int NOT NULL,
  `status` int NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `total` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `codeq` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `nama`, `nomerhp`, `montor`, `user_id`, `service_type`, `status`, `deskripsi`, `total`, `codeq`, `created_at`) VALUES
(1, 'Ardiansyah', '081348150488', 'Montor', NULL, 1, 2, 'sadasdadasd', '200000', 'ADSS!!!@321231', '2024-06-19 00:44:33'),
(2, 'Google', '081348150488', 'Montor', NULL, 1, 1, 'gjrfhg', '656', 'ADSS!!!@32123112', '2024-06-19 00:44:33'),
(3, NULL, NULL, NULL, NULL, 2, 0, NULL, NULL, 'Q20240618163541', '2024-06-19 00:44:33'),
(4, NULL, NULL, NULL, NULL, 2, 0, NULL, NULL, 'Q163609', '2024-06-19 00:44:33'),
(5, NULL, NULL, NULL, 1, 2, 1, NULL, NULL, 'Q163615', '2024-06-19 00:44:33'),
(6, NULL, NULL, NULL, NULL, 2, 0, NULL, NULL, 'Q171256', '2024-06-19 00:44:33'),
(7, NULL, NULL, NULL, 1, 2, 1, NULL, NULL, 'Q171258', '2024-06-19 00:44:33'),
(8, 'Google', '081348150488', 'Montor', NULL, 1, 1, 'weqeqwe', '656123123', 'ADSSe', '2024-06-19 00:52:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role_id`) VALUES
(1, 'admin', 'admin2@admin.com', '$2y$10$wtKneu7gdRu.AeIGLeiJpeqRG7t10czzpw/vrlhvaXN6n2skiMUBe', 1),
(2, 'Viodio22xx', 'lmaio@gmail.com', '$2y$10$5x.9I5f3c6KZ7y5wFY.xkumxydaS7j2J6Z0aYcYJuGn8wQhfzMdqm', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `montors`
--
ALTER TABLE `montors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `montors`
--
ALTER TABLE `montors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
