-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2025 at 12:20 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pwg`
--

-- --------------------------------------------------------

--
-- Table structure for table `generated_passwords`
--

CREATE TABLE `generated_passwords` (
  `id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `generated_passwords`
--

INSERT INTO `generated_passwords` (`id`, `password`, `created_at`, `user_id`) VALUES
(1, '$2y$10$AKSXa6TrfBZRg2M4HF8RHusbw3Xsbc2b0MqtpF.//9kD98w7c10ei', '2025-01-26 21:19:41', 1),
(2, 'QMz&T)!7!{2c6>!', '2025-01-26 21:23:03', 9);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_level` int(11) NOT NULL,
  `nama_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `nama_level`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_level` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `id_level`, `created_at`, `updated_at`) VALUES
(1, '1', '$2y$10$XXQ3O1rHI1jH0tp8c2567.Sbdqj5Ifm31sqGR8r2uvvVtduppzL3G', '1@gmail.com', 1, '2025-01-26 19:53:41', '2025-01-27 09:37:12'),
(9, '2', '$2y$10$c.hXNpD/TxmaKK.76W9HR.qBOMUX1y9cFHGGHCOWqJFyW.jU52dzS', '2@gmail.com', 2, '2025-01-27 06:32:40', '2025-01-27 09:51:57'),
(10, '3', '$2y$10$dz14/.7UiOwN7afRYNVa2u1HP4tnyFXCUWhNCm0lzK55wWzRTfJty', '3@gmail.com', 2, '2025-01-27 06:32:49', '2025-01-27 09:51:59'),
(11, '4', '$2y$10$7rdurXRNvjJ13kKRPEzDo.ZMsS3I8Sug9uQSAKBG0Mt73vXiu55QW', '4@gmail.com', 2, '2025-01-27 06:32:54', '2025-01-27 09:52:01'),
(12, '5', '$2y$10$HpX/ONU8gW8QhnU36r59Tu89rWhVnvPPp7ZM3qesSdJDuPkOfS6ea', '5@gmail.com', 1, '2025-01-27 06:32:59', '2025-01-27 09:52:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `generated_passwords`
--
ALTER TABLE `generated_passwords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_level` (`id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `generated_passwords`
--
ALTER TABLE `generated_passwords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
