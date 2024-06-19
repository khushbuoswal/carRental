-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 01, 2024 at 04:52 PM
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
-- Database: `car_site`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `driver_license` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `name`, `email`, `phone`, `driver_license`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(1, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-04-29', '2024-05-02', 'unconfirmed', '2024-05-29 22:38:33'),
(2, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-04-29', '2024-05-02', 'unconfirmed', '2024-05-29 22:39:31'),
(3, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-06', '2024-05-08', 'unconfirmed', '2024-05-29 22:39:56'),
(4, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-06', '2024-05-08', 'unconfirmed', '2024-05-29 22:55:54'),
(5, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-06', '2024-05-14', 'unconfirmed', '2024-05-29 22:56:54'),
(6, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-06', '2024-05-10', 'unconfirmed', '2024-05-29 23:01:33'),
(7, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-13', '2024-05-22', 'unconfirmed', '2024-05-29 23:05:21'),
(8, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-27', '2024-05-28', 'confirmed', '2024-05-29 23:16:18'),
(9, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-06', '2024-05-16', 'confirmed', '2024-05-29 23:35:52'),
(10, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-13', '2024-05-16', 'confirmed', '2024-05-30 00:09:14'),
(11, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-13', '2024-05-16', 'confirmed', '2024-05-30 00:41:59'),
(12, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-13', '2024-05-15', 'confirmed', '2024-05-30 00:46:05'),
(13, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-06', '2024-05-09', 'unconfirmed', '2024-05-30 01:21:29'),
(14, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-06', '2024-05-15', 'confirmed', '2024-05-30 01:55:01'),
(15, 'khushbu', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-13', '2024-05-15', 'confirmed', '2024-05-30 02:20:34'),
(16, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-06', '2024-05-09', 'confirmed', '2024-05-30 03:20:09'),
(17, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-13', '2024-05-15', 'confirmed', '2024-05-30 12:40:38'),
(18, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-13', '2024-05-15', 'unconfirmed', '2024-05-30 14:21:59'),
(19, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-13', '2024-05-15', 'confirmed', '2024-05-30 14:30:01'),
(20, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '045', 'Yes', '2024-06-01', '2024-06-02', 'unconfirmed', '2024-05-31 02:22:24'),
(21, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'No', '2024-05-06', '2024-05-16', 'unconfirmed', '2024-05-31 02:25:38'),
(22, 'khu', 'khushbuoswal13@gmail.com', '0490922435', 'Yes', '2024-05-06', '2024-05-08', 'unconfirmed', '2024-05-31 04:41:02'),
(23, '', '', '', '', '2024-05-13', '2024-05-16', 'unconfirmed', '2024-05-31 08:00:04'),
(24, '', '', '', '', '2024-05-30', '2024-06-01', 'unconfirmed', '2024-05-31 08:00:59'),
(25, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'yes', '2024-05-31', '2024-06-01', 'confirmed', '2024-05-31 13:59:13'),
(26, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'no', '2024-06-03', '2024-06-05', 'unconfirmed', '2024-06-01 01:22:11'),
(27, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'no', '2024-06-10', '2024-06-12', 'unconfirmed', '2024-06-01 01:26:21'),
(28, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'yes', '2024-06-03', '2024-06-06', 'unconfirmed', '2024-06-01 01:38:13'),
(29, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'yes', '2024-06-10', '2024-06-12', 'confirmed', '2024-06-01 01:42:33'),
(30, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'yes', '2024-06-10', '2024-06-12', 'confirmed', '2024-06-01 01:51:43'),
(31, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'yes', '2024-06-10', '2024-06-12', 'unconfirmed', '2024-06-01 01:58:23'),
(32, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'yes', '2024-06-03', '2024-06-06', 'confirmed', '2024-06-01 14:05:43'),
(33, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'yes', '2024-06-10', '2024-06-12', 'unconfirmed', '2024-06-01 14:14:37'),
(34, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'yes', '2024-06-10', '2024-06-12', 'confirmed', '2024-06-01 14:15:17'),
(35, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'yes', '2024-06-03', '2024-06-06', 'unconfirmed', '2024-06-01 14:40:24'),
(36, 'Khushbu Oswal', 'khushbuoswal13@gmail.com', '0490922435', 'yes', '2024-06-10', '2024-06-14', 'confirmed', '2024-06-01 14:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_name`, `product_price`, `quantity`, `created_at`) VALUES
(1, 2, 'Toyota Camry 2013', 120.00, 2, '2024-05-29 22:39:31'),
(2, 3, 'Nissan Maxima 2020', 125.00, 2, '2024-05-29 22:39:56'),
(3, 4, 'Honda Accord 2017', 100.00, 2, '2024-05-29 22:55:54'),
(4, 5, 'Subaru Forester 2019', 85.00, 2, '2024-05-29 22:56:54'),
(5, 6, 'Toyota Corolla 2020', 110.00, 2, '2024-05-29 23:01:33'),
(6, 7, 'Ford Escape 2018', 90.00, 2, '2024-05-29 23:05:21'),
(7, 8, 'Nissan Sentra 2020', 100.00, 2, '2024-05-29 23:16:18'),
(8, 9, 'Nissan Maxima 2020', 125.00, 3, '2024-05-29 23:35:52'),
(9, 10, 'Ford Edge 2018', 110.00, 3, '2024-05-30 00:09:14'),
(10, 11, 'Subaru Outback 2018', 90.00, 2, '2024-05-30 00:41:59'),
(11, 12, 'Subaru Crosstrek 2019', 95.00, 2, '2024-05-30 00:46:05'),
(12, 13, 'Toyota Camry 2013', 120.00, 5, '2024-05-30 01:21:29'),
(13, 14, 'Toyota Camry 2013', 120.00, 1, '2024-05-30 01:55:01'),
(14, 15, 'Honda Accord 2017', 100.00, 1, '2024-05-30 02:20:34'),
(15, 16, 'Toyota Camry 2013', 120.00, 2, '2024-05-30 03:20:09'),
(16, 17, 'Honda Accord 2017', 100.00, 2, '2024-05-30 12:40:38'),
(17, 18, 'Honda Accord 2017', 100.00, 1, '2024-05-30 14:21:59'),
(18, 19, 'Toyota Camry 2013', 120.00, 3, '2024-05-30 14:30:01'),
(19, 20, 'Volkswagen Golf 2020', 85.00, 2, '2024-05-31 02:22:24'),
(20, 21, 'Jeep Grand Cherokee 2017', 110.00, 2, '2024-05-31 02:25:38'),
(21, 22, 'Ford Fusion 2018', 90.00, 2, '2024-05-31 04:41:02'),
(22, 23, 'Toyota Corolla Hatchback 2021', 75.00, 2, '2024-05-31 08:00:04'),
(23, 24, 'Volkswagen Golf 2020', 85.00, 2, '2024-05-31 08:00:59'),
(24, 25, 'Volkswagen Golf 2020', 85.00, 1, '2024-05-31 13:59:13'),
(25, 26, 'Honda Civic 2020', 110.00, 2, '2024-06-01 01:22:11'),
(26, 27, 'Ford Fusion 2018', 90.00, 2, '2024-06-01 01:26:21'),
(27, 28, 'Ford Fusion 2018', 90.00, 1, '2024-06-01 01:38:13'),
(28, 29, 'Honda Civic 2020', 110.00, 2, '2024-06-01 01:42:33'),
(29, 30, 'Ford Fusion 2018', 90.00, 2, '2024-06-01 01:51:43'),
(30, 31, 'Hyundai Sonata 2017', 100.00, 2, '2024-06-01 01:58:23'),
(31, 32, 'Hyundai Sonata 2017', 100.00, 3, '2024-06-01 14:05:43'),
(32, 33, 'Toyota Camry 2013', 120.00, 3, '2024-06-01 14:14:37'),
(33, 34, 'Honda Accord 2017', 100.00, 2, '2024-06-01 14:15:17'),
(34, 35, 'Nissan Altima 2016', 95.00, 3, '2024-06-01 14:40:24'),
(35, 36, 'Volkswagen Golf 2020', 85.00, 3, '2024-06-01 14:41:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
