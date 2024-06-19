-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 19, 2024 at 10:53 AM
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
(1, 'Yamaha', 'Yamaha Motor Company adalah perusahaan Jepang yang terkenal dengan produk sepeda motor dan kendaraan lainnya.'),
(2, 'Honda', 'Honda Motor Co., Ltd. adalah produsen sepeda motor terbesar di dunia dan dikenal dengan inovasi serta kualitas produknya.'),
(3, 'Suzuki', 'Suzuki Motor Corporation adalah perusahaan multinasional Jepang yang memproduksi sepeda motor, mobil, dan berbagai mesin lainnya.'),
(4, 'Kawasaki', 'Kawasaki Heavy Industries, Ltd. adalah produsen sepeda motor dan peralatan industri yang berbasis di Jepang.'),
(5, 'Ducati', 'Ducati Motor Holding S.p.A. adalah produsen sepeda motor Italia yang terkenal dengan desain dan performa tinggi.'),
(6, 'Harley-Davidson', 'Harley-Davidson, Inc. adalah produsen sepeda motor asal Amerika Serikat yang terkenal dengan motornya yang khas dan bertenaga besar.'),
(7, 'BMW', 'BMW Motorrad adalah divisi sepeda motor dari BMW AG, perusahaan Jerman yang terkenal dengan sepeda motor premium dan teknologi canggih.'),
(8, 'KTM', 'KTM AG adalah produsen sepeda motor asal Austria yang dikenal dengan sepeda motor sport dan off-road.'),
(9, 'Aprilia', 'Aprilia adalah produsen sepeda motor Italia yang terkenal dengan sepeda motor sport dan balap.'),
(10, 'Royal Enfield', 'Royal Enfield adalah produsen sepeda motor asal India yang terkenal dengan sepeda motor klasik dan ikonik.');

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
(1, 'Yamaha Vixion', 1, 'https://example.com/images/yamaha_vixion.jpg', '25000000', ''),
(2, 'Honda Beat', 2, 'https://example.com/images/honda_beat.jpg', '16000000', ''),
(3, 'Suzuki Satria', 3, 'https://example.com/images/suzuki_satria.jpg', '23000000', ''),
(4, 'Kawasaki Ninja', 4, 'https://example.com/images/kawasaki_ninja.jpg', '40000000', ''),
(5, 'Yamaha NMax', 1, 'https://example.com/images/yamaha_nmax.jpg', '28000000', ''),
(6, 'Honda CBR', 2, 'https://example.com/images/honda_cbr.jpg', '36000000', ''),
(7, 'Suzuki GSX-R150', 3, 'https://example.com/images/suzuki_gsx-r150.jpg', '29000000', ''),
(8, 'Kawasaki Z250', 4, 'https://example.com/images/kawasaki_z250.jpg', '48000000', ''),
(9, 'Yamaha Aerox', 1, 'https://example.com/images/yamaha_aerox.jpg', '27000000', ''),
(10, 'Honda Scoopy', 2, 'https://example.com/images/honda_scoopy.jpg', '19000000', '');

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
(1, 'Administrator');

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
(133, 1, 27);

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
(1, 'Andi', 5, NULL, 'ONLINE', '081234567891', 'Jl. Merdeka No.1', 1, '2024-06-19 15:27:41'),
(2, 'Budi', 2, NULL, 'ONLINE', '082234567892', 'Jl. Sudirman No.2', 1, '2024-06-19 15:27:41'),
(3, 'Citra', 8, NULL, 'ONLINE', '083234567893', 'Jl. Gatot Subroto No.3', 1, '2024-06-19 15:27:41'),
(4, 'Dewi', 4, NULL, 'ONLINE', '084234567894', 'Jl. Ahmad Yani No.4', 1, '2024-06-19 15:27:41'),
(5, 'Eka', 1, NULL, 'ONLINE', '085234567895', 'Jl. Diponegoro No.5', 1, '2024-06-19 15:27:41'),
(6, 'Fajar', 10, NULL, 'ONLINE', '086234567896', 'Jl. Gajah Mada No.6', 1, '2024-06-19 15:27:41'),
(7, 'Gilang', 7, NULL, 'ONLINE', '087234567897', 'Jl. Pattimura No.7', 1, '2024-06-19 15:27:41'),
(8, 'Hendra', 3, NULL, 'ONLINE', '088234567898', 'Jl. Thamrin No.8', 1, '2024-06-19 15:27:41'),
(9, 'Ika', 6, NULL, 'ONLINE', '089234567899', 'Jl. MH. Thamrin No.9', 1, '2024-06-19 15:27:41'),
(10, 'Joko', 9, NULL, 'ONLINE', '080234567890', 'Jl. Sisingamangaraja No.10', 1, '2024-06-19 15:27:41');

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
(1, 'Andi', '081234567891', 'Yamaha Vixion', 1, 1, 1, 'Service lengkap dan ganti oli', '300000', 'CODE1234', '2024-06-19 15:35:51'),
(2, 'Budi', '082234567892', 'Honda Beat', 2, 1, 1, 'Ganti ban belakang dan cek tekanan angin', '150000', 'CODE2345', '2024-06-19 15:35:51'),
(3, 'Citra', '083234567893', 'Suzuki Satria', 3, 1, 1, 'Pemeriksaan mesin dan tune-up', '250000', 'CODE3456', '2024-06-19 15:35:51'),
(4, 'Dewi', '084234567894', 'Kawasaki Ninja', 4, 1, 1, 'Ganti oli mesin dan filter', '100000', 'CODE4567', '2024-06-19 15:35:51'),
(5, 'Eka', '085234567895', 'Yamaha NMax', 5, 1, 1, 'Ganti ban depan dan balancing', '200000', 'CODE5678', '2024-06-19 15:35:51'),
(6, 'Fajar', '086234567896', 'Honda CBR', 6, 1, 1, 'Service berkala dan pemeriksaan rem', '350000', 'CODE6789', '2024-06-19 15:35:51'),
(7, 'Gilang', '087234567897', 'Suzuki GSX-R150', 7, 1, 1, 'Ganti oli mesin dan pemeriksaan umum', '120000', 'CODE7890', '2024-06-19 15:35:51'),
(8, 'Hendra', '088234567898', 'Kawasaki Z250', 8, 1, 1, 'Service lengkap dan ganti busi', '400000', 'CODE8901', '2024-06-19 15:35:51'),
(9, 'Ika', '089234567899', 'Yamaha Aerox', 9, 1, 1, 'Ganti ban dan balancing', '180000', 'CODE9012', '2024-06-19 15:35:51'),
(10, 'Joko', '080234567890', 'Honda Scoopy', 10, 1, 1, 'Ganti oli dan pemeriksaan rem', '110000', 'CODE0123', '2024-06-19 15:35:51'),
(11, NULL, NULL, NULL, 1, 2, 555, NULL, NULL, 'Q103835', '2024-06-19 15:38:36'),
(12, NULL, NULL, NULL, NULL, 2, 0, NULL, NULL, 'Q103835', '2024-06-19 15:38:35');

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
(1, 'admin', 'admin2@admin.com', '$2y$10$wtKneu7gdRu.AeIGLeiJpeqRG7t10czzpw/vrlhvaXN6n2skiMUBe', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `montors`
--
ALTER TABLE `montors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
