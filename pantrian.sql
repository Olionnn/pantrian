-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 19, 2024 at 05:01 AM
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
-- Database: `pantrian`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL
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
  `id` int(11) NOT NULL,
  `mtr_name` text NOT NULL,
  `brand_id` int(11) NOT NULL,
  `img` text NOT NULL,
  `harga` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL
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
  `id` int(11) NOT NULL,
  `tag` varchar(10) NOT NULL,
  `perm_desc` text NOT NULL
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
(17, 'DSLS', 'Delete Sales'),
(18, 'VWMTR', 'View Montor'),
(19, 'AMTR', 'Add Montor'),
(20, 'EMTR', 'Edit Montor'),
(21, 'DMTR', 'Delete Montor'),
(22, 'VWSQ', 'View Services'),
(23, 'ASQ', 'Add Services'),
(24, 'SSQ', 'Finsih Service'),
(25, 'ESQ', 'Edit Services'),
(26, 'BSQ', 'Cancel Services'),
(27, 'BSQ', 'Cancel Service');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` text NOT NULL
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
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `perm_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `perm_id`) VALUES
(107, 1, 1),
(108, 1, 2),
(109, 1, 3),
(110, 1, 4),
(111, 1, 5),
(112, 1, 6),
(113, 1, 7),
(114, 1, 8),
(115, 1, 9),
(116, 1, 10),
(117, 1, 11),
(118, 1, 12),
(119, 1, 13),
(120, 1, 14),
(121, 1, 15),
(122, 1, 16),
(123, 1, 17),
(124, 1, 18),
(125, 1, 19),
(126, 1, 20),
(127, 1, 21),
(128, 1, 22),
(129, 1, 23),
(130, 1, 24),
(131, 1, 25),
(132, 1, 26),
(133, 1, 27),
(140, 4, 1),
(141, 4, 2),
(142, 4, 3),
(143, 4, 4),
(144, 4, 5),
(145, 4, 6),
(146, 4, 8);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `montor_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment` text NOT NULL,
  `nomerhp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nomerhp` varchar(20) DEFAULT NULL,
  `montor` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `service_type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `codeq` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `nama`, `nomerhp`, `montor`, `user_id`, `service_type`, `status`, `deskripsi`, `total`, `codeq`, `created_at`) VALUES
(1, 'Ardiansyah', '081348150488', 'Montor', NULL, 1, 2, 'sadasdadasd', '200000', 'ADSS!!!@321231', '2024-06-19 00:44:33'),
(2, 'Google', '081348150488', 'Montor', NULL, 1, 1, 'gjrfhg', '656', 'ADSS!!!@32123112', '2024-06-19 00:44:33'),
(3, NULL, NULL, NULL, 1, 2, 1, NULL, NULL, 'Q20240618163541', '2024-06-19 08:43:03'),
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
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role_id`) VALUES
(1, 'admin', 'admin2@admin.com', '$2y$10$wtKneu7gdRu.AeIGLeiJpeqRG7t10czzpw/vrlhvaXN6n2skiMUBe', 1),
(4, 'Olionnn', 'admin2@admin.com', '$2y$10$f8zMTT/Nx7SQFvCyyVzpvuu8D2VGhHSjTpfYutsjTo8AUgMWcYR26', 4);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `montors`
--
ALTER TABLE `montors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
