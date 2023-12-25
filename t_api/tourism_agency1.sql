-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2023 at 03:33 PM
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
-- Database: `tourism_agency1`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(50) NOT NULL,
  `user_id` int(30) NOT NULL,
  `tour_id` int(20) NOT NULL,
  `booking_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int(50) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`) VALUES
(1, 'Jordan'),
(2, 'Palestine');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `rating` int(10) NOT NULL,
  `comments` text NOT NULL,
  `user_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `rating`, `comments`, `user_id`) VALUES
(5, 4, 'Enjoyed the tour!', 33),
(6, 4, 'Great product! I am satisfied with my purchase.', 33),
(7, 4, 'Enjoyed the tour !', 33),
(8, 4, 'Enjoyed the tour !', 33);

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

CREATE TABLE `tour` (
  `id` int(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `destination_id` int(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` varchar(255) NOT NULL,
  `seats` int(100) NOT NULL,
  `tour_guide_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour`
--

INSERT INTO `tour` (`id`, `name`, `image`, `date`, `destination_id`, `description`, `price`, `seats`, `tour_guide_id`) VALUES
(1, 'petra', 'petra', '0000-00-00', 1, 'gfgvbhjnmk,l;.,cvvvvbbbbnbb', '30', 18, 35),
(5, 'aqabaa', 'aqabaa', '2023-12-05', 1, 'gfgvbhjnmk,l;.,cvvvvbbbbnbb', '30', 20, 35),
(6, 'Tour Name', 'tour', '2023-12-31', 1, 'Tour description', '100', 50, 35),
(7, 'Tour Name', '', '2023-12-31', 1, 'Tour description', '100', 50, 35),
(8, 'Tour Name', '', '2023-12-31', 1, 'Tour description', '100', 50, 35),
(9, 'Tour Name', '', '2023-12-31', 1, 'Tour description', '100', 50, 35),
(10, 'Tour Name', '', '2023-12-31', 1, 'Tour description', '100', 50, 35),
(11, 'Tour Name', '', '2023-12-31', 2, 'Tour description', '100', 50, 35),
(12, ' Adventure Tour', '', '2023-12-15', 2, 'Experience an adrenaline-packed adventure tour with breathtaking views.', '150', 20, 42),
(13, 'Exciting Adventure Tour', '../src/41.png', '2023-12-15', 1, 'Experience an adrenaline-packed adventure tour with breathtaking views.', '150', 20, 42),
(14, 'Exciting Adventure Tour', '../src/41.png', '2023-12-15', 1, 'Experience an adrenaline-packed adventure tour with breathtaking views.', '150', 20, 42),
(16, 'amman', 'src/41.png', '2023-12-31', 1, 'ggggggggggggggggggggggg', '20', 30, 35),
(17, 'Awesome Tour', 'src/41.png', '2023-12-31', 1, 'An amazing tour experience', '100', 50, 35),
(18, 'Awesome Tour', 'src/41.png', '2023-12-29', 1, 'An amazing tour experience', '100', 50, 35),
(19, 'amman', NULL, '0000-00-00', 1, 'uiyfiyif', '333', 20, 35);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT 'users'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone_number`, `password`, `role`) VALUES
(32, 'john_doe', 'john.doe@example.com', '1234567890', '$2y$10$5uTJ1ge3gop3Mv3my3wSK.gc1A9NYkvDHZyUqitEYTPKwR4T14KoC', 'users'),
(33, 'fthi', 'fathi@example.com', '111111', '$2y$10$WN8hN9kw9giBoys.6wPbSOXwwBkWnUqXs0l7NmuEaIqukc5zuEe3e', 'users'),
(34, 'mira', 'mira@gmail.com', '111111', '$2y$10$XRxbwChV0e6YgNzFyEgoyuwUIN.tXnqz1j7Uj6N2TOSUrbnO1P4yq', 'admin'),
(35, 'meme', 'meme@gmail.com', '111111', '$2y$10$VdebuuveNvVp8CHdFbjdTOoXV/fTrgUcRbW81ddwbIPnNba92sdJG', 'tour guide'),
(37, 'danaoe', 'dgtfoe@example.com', '1234567890', '$2y$10$HzvQ2BiwolKr5IDGD3A7XeYcdA.tWV3WPFpC/8L7Xaok.itM4z65W', 'users'),
(38, 'dddjoe', 'dgtfoe@example.com', '1gfhjh234567890', '$2y$10$WeUjl32o0f7b/g9rG4w77O3KLrUdj3lwYzhy53U38Mufhh1kFIcPK', 'users'),
(39, 'reem', 'reem@example.com', '1gfhjh234567890', '$2y$10$5RD/rEsUwvGAUl/h3cGIjeNRNcEeAdoD85nvD4BeBLvtJbSttH6Y6', 'users'),
(41, 'Jire ', 'jire@example.com', '1111111111', '$2y$10$D4F7DsgMRzwMY4.LNytXLOzJsxu04EjQKtrPV/JSfT6BHymkAknnu', 'users'),
(42, 'Joore ', 'joore@example.com', '1111111111', '$2y$10$qxhJfLRFI5.65voGimOtpOeoj4aHyurPf5nh60CHiIoj57D7j2e9a', 'tour guide');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destination_id` (`destination_id`),
  ADD KEY `tour_guide_id` (`tour_guide_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tour`
--
ALTER TABLE `tour`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tour`
--
ALTER TABLE `tour`
  ADD CONSTRAINT `gg` FOREIGN KEY (`tour_guide_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tour_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
