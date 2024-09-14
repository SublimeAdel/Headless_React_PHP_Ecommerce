-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2024 at 11:46 AM
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
-- Database: `productsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `SKU` varchar(512) NOT NULL,
  `name` varchar(512) NOT NULL,
  `price` float NOT NULL,
  `type` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`SKU`, `name`, `price`, `type`) VALUES
('Book18', 'Crime and Punishment', 65.99, 'Book'),
('Book252', 'The Great Gatsby', 39, 'Book'),
('book5699', 'SNK Manga', 16, 'Book'),
('Book89', '1Q84', 64.99, 'Book'),
('Book982', 'Norwegian Woods', 29, 'Book'),
('Book996', 'After Dark', 22.99, 'Book'),
('Book997', 'Sputnik Sweetheart', 27.99, 'Book'),
('book999', '1984', 64.99, 'Book'),
('DVD001', 'SnK Season 1', 19.9899, 'DVD'),
('DVD002', 'SnK Season 2', 24.99, 'DVD'),
('fur561', 'chair', 50, 'Furniture'),
('fur669', 'couch', 79, 'Furniture'),
('Furn6266', 'Recliner', 100, 'Furniture'),
('Furn991', 'Desk', 650, 'Furniture');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`SKU`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
