-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2023 at 08:17 AM
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
-- Database: `airbooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `flight_infor`
--

CREATE TABLE `flight_infor` (
  `flight_id` int(11) NOT NULL,
  `starting_location` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `flight_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight_infor`
--

INSERT INTO `flight_infor` (`flight_id`, `starting_location`, `destination`, `flight_time`) VALUES
(3, 'Ha Noi', 'Ho Chi Minh', '2023-05-03 16:10:00'),
(7, 'Ha Noi', 'Ho Chi Minh', '2023-04-30 16:15:00'),
(10, 'Ha Noi', 'Hai Phong', '2023-04-28 16:17:00'),
(13, 'Ha Noi', 'Da Lat', '2023-04-22 10:06:19'),
(23, 'Ha Noi', 'Nghe An', '2023-04-30 16:27:00'),
(27, 'Ha Noi', 'Da Nang', '2023-05-21 00:45:00'),

(4, 'Ho Chi Minh', 'Ha Noi', '2023-05-03 16:10:00'),
(11, 'Ho Chi Minh', 'Ha Noi', '2023-05-06 01:05:00'),
(14, 'Ho Chi Minh', 'Da Nang', '2023-05-06 01:05:00'),
(17, 'Ho Chi Minh', 'Hai Phong', '2023-05-12 06:38:53'),
(25, 'Ho Chi Minh', 'Da Nang', '2023-05-04 12:20:00'),
(28, 'Ho Chi Minh', 'Hai Phong', '2023-05-14 01:51:00'),

(16, 'Da Lat', 'Nghe An', '2023-05-06 00:54:00'),
(5, 'Da Lat', 'Da Nang', '2023-04-30 16:15:00'),
(6, 'Da Lat', 'Ho Chi Minh', '2023-04-28 16:17:00'),
(8, 'Da Lat', 'Ha Noi', '2023-05-06 01:05:00'),

(9, 'Hai Phong', 'Da Lat', '2023-04-22 10:06:19'),
(12, 'Hai Phong', 'Ha Noi', '2023-05-06 01:05:00'),
(15, 'Hai Phong', 'Nghe An', '2023-05-06 00:54:00'),
(18, 'Hai Phong', 'Ho Chi Minh', '2023-05-12 06:38:53'),
(19, 'Hai Phong', 'Nghe An', '2023-04-30 16:27:00'),

(30, 'Nghe An', 'Na Noi', '2023-05-06 00:54:00'),
(31, 'Nghe An', 'Ho Chi Minh', '2023-04-30 16:15:00'),
(32, 'Nghe An', 'Ho Chi Minh', '2023-04-28 16:17:00'),
(33, 'Nghe An', 'Ha Noi', '2023-05-06 01:05:00'),

(26, 'Da Nang', 'Ha Noi', '2023-05-04 15:56:00'),
(20, 'Da Nang', 'Ha Noi', '2023-05-04 12:20:00'),
(21, 'Da Nang', 'Ho Chi Minh', '2023-05-04 15:56:00'),
(22, 'Da Nang', 'Nghe An', '2023-05-21 00:45:00'),
(24, 'Da Nang', 'Hai Phong', '2023-05-14 01:51:00'),

(29, 'Da Nang', 'Ho Chi Minh', '2023-05-18 01:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `flight_ticket`
--

CREATE TABLE `flight_ticket` (
  `ticket_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT 'Customer',
  `ticket_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight_ticket`
--

INSERT INTO `flight_ticket` (`ticket_id`, `flight_id`, `username`, `ticket_type`) VALUES
(1, 13, 'nguyenAvan', 3),
(2, 14, 'admin', 2),
(3, 17, 'admin', 3),
(4, 14, 'admin', 3),
(5, 17, 'admin', 10),
(6, 14, 'admin', 10),
(7, 3, NULL, 10),
(9, 16, NULL, 8),
(10, 28, NULL, 2),
(11, 16, NULL, 8),
(12, 27, NULL, 8),
(13, 27, NULL, 8),
(15, 27, NULL, 2),
(16, 29, NULL, 10),
(17, 27, NULL, 2),
(18, 16, NULL, 10),
(19, 27, NULL, 2),
(20, 14, NULL, 10),
(22, 17, NULL, 2),
(23, 11, NULL, 8),
(25, 11, NULL, 8),
(26, 14, NULL, 8),
(27, 27, 'admin', 2),
(28, 27, NULL, 2),
(29, 7, 'admin', 10),
(30, 7, NULL, 10),
(40, 3, 'nguyenAvan', 9),
(41, 11, 'nguyenAvan', 2),
(42, 3, 'admin', 8),
(43, 28, NULL, 2),
(44, 16, NULL, 8),
(45, 27, NULL, 8),
(46, 27, NULL, 8),
(47, 27, NULL, 2),
(48, 29, NULL, 10),
(49, 27, NULL, 2),
(50, 16, NULL, 10),
(51, 27, NULL, 2),
(52, 14, NULL, 10),
(53, 17, NULL, 2),
(54, 11, NULL, 8),
(55, 11, NULL, 8),
(56, 14, NULL, 8),
(57, 29, 'admin', 10),
(58, 25, 'admin', 8);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_type`
--

CREATE TABLE `ticket_type` (
  `type_id` int(11) NOT NULL,
  `type_class` varchar(100) NOT NULL,
  `flight_type` varchar(100) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_type`
--

INSERT INTO `ticket_type` (`type_id`, `type_class`, `flight_type`, `price`) VALUES
(2, 'Economy', 'Round-trip', 599),
(3, 'Economy', 'One-way', 299),
(8, 'Business', 'One-way', 1299),
(9, 'Business', 'Round-trip', 2999),
(10, 'Master', 'Round-trip', 4999);

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `username` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`username`, `firstname`, `lastname`, `password`, `email`, `telephone`, `role`) VALUES
('admin', 'Nhựt Anh', 'Trần', '$2y$10$UA6d8dqFhh5T1WWWNZGeDetmVrMw8rGwndxxQijdKfBdte8z4l9wm', 'trannhutanh654@gmail.com', '1234567890', 'admin'),
('nguyenAvan', 'Nguyen', 'Van A', '$2y$10$CCzLkbNU1b1NSOHWGsNOQ.JvD0xMUc.mVCeKas8NXDrkEZmPOom6q', 'nguyenvana123@email.com', '1234567890', ''),
('tranC', 'Tran ', 'Thi C', '$2y$10$nP7Nz/2aE54jpZiI1dpZauKuwkfGjxh5kjWR3EpcSE02htltpc5vG', 'example@gmail.com', '', ''),
('vanALe2', 'Le', 'Van A', '$2y$10$UibbngnrNfOaxzw2VMzd/O/aaNoFEeEdOO3B9i2qDVo8vf4uUKVAK', 'example3@gmail.com', '21321321334', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `flight_infor`
--
ALTER TABLE `flight_infor`
  ADD PRIMARY KEY (`flight_id`);

--
-- Indexes for table `flight_ticket`
--
ALTER TABLE `flight_ticket`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `FK_ticket_user` (`username`),
  ADD KEY `FK_ticket_flight` (`flight_id`),
  ADD KEY `FK_ticket_type` (`ticket_type`);

--
-- Indexes for table `ticket_type`
--
ALTER TABLE `ticket_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flight_infor`
--
ALTER TABLE `flight_infor`
  MODIFY `flight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `flight_ticket`
--
ALTER TABLE `flight_ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `ticket_type`
--
ALTER TABLE `ticket_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flight_ticket`
--
ALTER TABLE `flight_ticket`
  ADD CONSTRAINT `FK_ticket_flight` FOREIGN KEY (`flight_id`) REFERENCES `flight_infor` (`flight_id`),
  ADD CONSTRAINT `FK_ticket_type` FOREIGN KEY (`ticket_type`) REFERENCES `ticket_type` (`type_id`),
  ADD CONSTRAINT `FK_ticket_user` FOREIGN KEY (`username`) REFERENCES `user_account` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
