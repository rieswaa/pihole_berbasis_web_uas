-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2025 at 09:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pi-hole_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `blacklist_domains`
--

CREATE TABLE `blacklist_domains` (
  `id` int(11) NOT NULL,
  `domain_name` varchar(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blacklist_domains`
--

INSERT INTO `blacklist_domains` (`id`, `domain_name`, `date_added`) VALUES
(1, 'godaddy.com', '2025-07-28 18:30:36');

-- --------------------------------------------------------

--
-- Table structure for table `dns_logs`
--

CREATE TABLE `dns_logs` (
  `id` int(11) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `status` enum('allowed','blocked') NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dns_logs`
--

INSERT INTO `dns_logs` (`id`, `domain`, `status`, `timestamp`) VALUES
(1, 'ads.google.com', 'blocked', '2025-07-29 12:30:15'),
(2, 'facebook.com', 'allowed', '2025-07-29 12:30:15'),
(3, 'youtube.com', 'allowed', '2025-07-29 12:30:15'),
(4, 'malware-site.com', 'blocked', '2025-07-29 12:30:15'),
(5, 'example.com', 'allowed', '2025-07-29 12:30:15'),
(6, 'lazada.com', 'allowed', '2025-07-30 17:31:44'),
(7, 'shoope.com', 'blocked', '2025-07-30 18:27:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Table structure for table `whitelist_domains`
--

CREATE TABLE `whitelist_domains` (
  `id` int(11) NOT NULL,
  `domain_name` varchar(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `whitelist_domains`
--

INSERT INTO `whitelist_domains` (`id`, `domain_name`, `date_added`) VALUES
(1, 'https://www.bing.com', '2025-07-28 18:32:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blacklist_domains`
--
ALTER TABLE `blacklist_domains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dns_logs`
--
ALTER TABLE `dns_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whitelist_domains`
--
ALTER TABLE `whitelist_domains`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blacklist_domains`
--
ALTER TABLE `blacklist_domains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dns_logs`
--
ALTER TABLE `dns_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `whitelist_domains`
--
ALTER TABLE `whitelist_domains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
