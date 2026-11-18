-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2026 at 09:49 AM
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
-- Database: `car_rental_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `year` smallint(6) NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  `color` varchar(30) NOT NULL,
  `category` enum('Economy','SUV','Luxury','Van','Pickup') NOT NULL DEFAULT 'Economy',
  `seats` tinyint(4) NOT NULL DEFAULT 5,
  `transmission` enum('Automatic','Manual') NOT NULL DEFAULT 'Automatic',
  `fuel` enum('Petrol','Diesel','Hybrid','Electric') NOT NULL DEFAULT 'Petrol',
  `price_per_day` decimal(10,2) NOT NULL,
  `status` enum('available','rented','maintenance') NOT NULL DEFAULT 'available',
  `description` varchar(255) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `year`, `plate_number`, `color`, `category`, `seats`, `transmission`, `fuel`, `price_per_day`, `status`, `description`, `added_by`, `created_at`) VALUES
(1, 'Toyota', 'Corolla', 2021, 'RAB 101 A', 'White', 'Economy', 5, 'Automatic', 'Petrol', 35.00, 'available', 'Reliable and fuel efficient city car.', 1, '2026-11-04 08:21:35'),
(2, 'Toyota', 'RAV4', 2022, 'RAC 202 B', 'Black', 'SUV', 5, 'Automatic', 'Hybrid', 70.00, 'available', 'Comfortable SUV for family trips.', 1, '2026-11-04 08:21:35'),
(3, 'Toyota', 'Land Cruiser V8', 2020, 'RAD 303 C', 'Silver', 'SUV', 7, 'Automatic', 'Diesel', 150.00, 'rented', 'Powerful 4x4 for rough roads and safaris.', 1, '2026-11-04 08:21:35'),
(4, 'Mercedes-Benz', 'E-Class', 2023, 'RAE 404 D', 'Grey', 'Luxury', 5, 'Automatic', 'Petrol', 180.00, 'available', 'Executive luxury sedan for business.', 1, '2026-11-04 08:21:35'),
(5, 'Hyundai', 'Accent', 2019, 'RAF 505 E', 'Red', 'Economy', 5, 'Manual', 'Petrol', 28.00, 'available', 'Budget friendly and easy to drive.', 1, '2026-11-04 08:21:35'),
(6, 'Toyota', 'Hiace', 2021, 'RAG 606 F', 'White', 'Van', 14, 'Manual', 'Diesel', 95.00, 'available', 'Spacious van for groups and tours.', NULL, '2026-11-04 08:21:35'),
(7, 'Ford', 'Ranger', 2022, 'RAH 707 G', 'Blue', 'Pickup', 5, 'Manual', 'Diesel', 85.00, 'maintenance', 'Strong double-cab pickup for work and travel.', NULL, '2026-11-04 08:21:35'),
(8, 'Nissan', 'X-Trail', 2021, 'RAJ 808 H', 'Green', 'SUV', 5, 'Automatic', 'Petrol', 65.00, 'available', 'Smooth ride with plenty of luggage space.', NULL, '2026-11-04 08:21:35'),
(9, 'BMW', '5 Series', 2023, 'RAK 909 J', 'Black', 'Luxury', 5, 'Automatic', 'Petrol', 190.00, 'rented', 'Premium comfort with sporty performance.', 1, '2026-11-04 08:21:35'),
(10, 'Suzuki', 'Swift', 2020, 'RAL 111 K', 'Orange', 'Economy', 5, 'Manual', 'Petrol', 30.00, 'available', 'Compact car, ideal for city driving.', NULL, '2026-11-04 08:21:35'),
(11, 'Tesla', 'Model 3', 2023, 'RAM 222 L', 'White', 'Luxury', 5, 'Automatic', 'Electric', 160.00, 'available', 'Fully electric, silent and modern.', 1, '2026-11-04 08:21:35'),
(12, 'Toyota', 'Hilux', 2021, 'RAN 333 M', 'Silver', 'Pickup', 5, 'Automatic', 'Diesel', 90.00, 'available', 'Tough and dependable pickup truck.', NULL, '2026-11-04 08:21:35'),
(13, 'Kia', 'Sportage', 2022, 'RAP 444 N', 'Red', 'SUV', 5, 'Automatic', 'Petrol', 60.00, 'available', 'Stylish crossover with modern features.', 1, '2026-11-04 08:21:35'),
(14, 'Volkswagen', 'Polo', 2019, 'RAR 555 P', 'Blue', 'Economy', 5, 'Manual', 'Petrol', 32.00, 'rented', 'Small, practical and economical.', NULL, '2026-11-04 08:21:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'System Administrator', 'Admin', 'admin@carrental.rw', '$2y$10$9.cJ6gitjytbv82RE0ttk.14nLx4e.JBDtOQx3W.QwO0.HDoDjjyG', 'admin', '2026-11-04 08:21:35'),
(3, 'IRANZI Jean de Dieu', 'Iranzi', 'iranzi@mail.com', '$2y$10$Kjm0t8HyTE8.YIAbsGzCvOmTb5YsdZZxlQrvpYGW8MTRk5FXus/Ra', 'customer', '2026-11-04 08:21:35'),
(4, 'AKAYEZU Achelle', 'Achelle', 'achelle@mail.com', '$2y$10$Kjm0t8HyTE8.YIAbsGzCvOmTb5YsdZZxlQrvpYGW8MTRk5FXus/Ra', 'customer', '2026-11-04 08:21:35'),
(5, 'UWIZEYE Belyse', 'Belyse', 'john@mail.com', '$2y$10$Kjm0t8HyTE8.YIAbsGzCvOmTb5YsdZZxlQrvpYGW8MTRk5FXus/Ra', 'customer', '2026-11-04 08:21:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plate_number` (`plate_number`),
  ADD KEY `added_by` (`added_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
