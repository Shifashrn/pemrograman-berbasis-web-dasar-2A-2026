-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 18, 2026 at 11:56 AM
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
-- Database: `campus_event1`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id_event` int NOT NULL,
  `nama_event` varchar(150) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal_event` date NOT NULL,
  `lokasi` varchar(150) NOT NULL,
  `kuota` int NOT NULL,
  `created_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id_event`, `nama_event`, `deskripsi`, `tanggal_event`, `lokasi`, `kuota`, `created_by`) VALUES
(1, 'Seminar Teknologi AI', 'Seminar tentang AI.', '2026-06-10', 'Aula Kampus A', 151, 1),
(2, 'Workshop Web Development', 'Belajar PHP & Tailwind.', '2026-06-12', 'Lab Komputer', 49, 1),
(3, 'Festival Musik Kampus', 'Acara musik mahasiswa.', '2026-06-20', 'Lapangan Utama', 299, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran_event`
--

CREATE TABLE `pendaftaran_event` (
  `id_daftar` int NOT NULL,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `tanggal_daftar` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('terdaftar','batal') DEFAULT 'terdaftar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pendaftaran_event`
--

INSERT INTO `pendaftaran_event` (`id_daftar`, `user_id`, `event_id`, `tanggal_daftar`, `status`) VALUES
(2, 2, 3, '2026-05-16 05:34:05', 'terdaftar'),
(3, 4, 1, '2026-05-16 05:53:32', 'terdaftar'),
(4, 4, 2, '2026-05-16 05:56:41', 'terdaftar'),
(5, 5, 3, '2026-05-17 14:12:05', 'terdaftar');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$luyJgJgKiy06.k9lYefVbeJ1uzuHjq4ZuDoXA0E3c3yZtIer4toj2', 'admin', '2026-05-16 05:45:55'),
(2, 'rara', 'raaaa@gmail.com', '$2y$10$lzA8K9P16OmPIv.emzDhFuuK4nLqqdMT3X4oWiMOz9J46XxCYY9jG', 'user', '2026-05-16 05:33:46'),
(4, 'tofa', 'mustofa@gmail.com', '$2y$10$AUJeqqGcUlZory/OjC3Tc.y4Gcads72/XjkQdmjaZBkUdSox2EKlq', 'user', '2026-05-16 05:52:45'),
(5, 'SHIFA SAHARANI ISTIAWAN', 'shifasaaahrn1@gmail.com', '$2y$10$2oFgPbXlJBycgRbRqovzW.Dyp0LEIlNFzpOtU3PawTQktJ7LVp6J.', 'user', '2026-05-17 13:27:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `pendaftaran_event`
--
ALTER TABLE `pendaftaran_event`
  ADD PRIMARY KEY (`id_daftar`),
  ADD UNIQUE KEY `unique_daftar` (`user_id`,`event_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id_event` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pendaftaran_event`
--
ALTER TABLE `pendaftaran_event`
  MODIFY `id_daftar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `pendaftaran_event`
--
ALTER TABLE `pendaftaran_event`
  ADD CONSTRAINT `pendaftaran_event_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftaran_event_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id_event`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
