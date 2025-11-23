-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 09:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatting_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `chat_type` enum('single','group') NOT NULL DEFAULT 'single',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `chat_type`, `created_at`) VALUES
(30, 'single', '2025-11-23 18:37:34');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `user_id`, `contact_id`, `created_at`) VALUES
(51, 8, 7, '2025-11-23 18:37:31'),
(62, 7, 8, '2025-11-23 19:41:14');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `chats_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivered_at` timestamp NULL DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `chats_id`, `sender_id`, `content`, `created_at`, `delivered_at`, `read_at`) VALUES
(56, 30, 8, 'hello', '2025-11-23 18:38:08', '2025-11-23 18:38:23', '2025-11-23 18:38:23'),
(57, 30, 7, 'im good how are you', '2025-11-23 18:38:32', '2025-11-23 18:39:15', '2025-11-23 18:39:15'),
(60, 30, 8, 'im good , how was your week', '2025-11-23 18:42:05', '2025-11-23 18:51:00', '2025-11-23 18:51:00'),
(62, 30, 7, 'it was good what about you', '2025-11-23 19:41:36', '2025-11-23 19:45:08', '2025-11-23 19:45:08'),
(63, 30, 7, 'hii', '2025-11-23 19:43:29', '2025-11-23 19:45:08', '2025-11-23 19:45:08'),
(64, 30, 8, 'hello again', '2025-11-23 19:45:30', '2025-11-23 19:47:20', '2025-11-23 19:47:20'),
(65, 30, 7, 'hello', '2025-11-23 19:47:30', '2025-11-23 19:56:23', '2025-11-23 19:56:23'),
(66, 30, 7, 'where are you', '2025-11-23 19:51:11', '2025-11-23 19:56:23', '2025-11-23 19:56:23'),
(67, 30, 8, 'im here', '2025-11-23 19:57:36', '2025-11-23 20:01:53', '2025-11-23 20:01:53'),
(68, 30, 7, 'okay', '2025-11-23 20:02:04', '2025-11-23 20:19:56', '2025-11-23 20:19:56'),
(69, 30, 7, 'hello', '2025-11-23 20:05:03', '2025-11-23 20:19:56', '2025-11-23 20:19:56'),
(70, 30, 8, 'hello', '2025-11-23 20:22:26', '2025-11-23 20:24:19', '2025-11-23 20:24:19'),
(71, 30, 8, 'wyd', '2025-11-23 20:24:07', '2025-11-23 20:24:19', '2025-11-23 20:24:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(7, 'joya', 'gergessjoya@gmail.com', '$2y$10$/uAs4HieoWFuR1yNjzpffOeKbY4bnIUhdTINCci644bsr0Nfa64vi', '2025-11-23 18:19:19'),
(8, 'joe', 'joe@gmail.com', '$2y$10$Ur7uIJEHbmvOOvy0b87sOu9WZGkHKEUWYGqPR/R9lx5w0Bfa48kfK', '2025-11-23 18:20:09');

-- --------------------------------------------------------

--
-- Table structure for table `users_chats`
--

CREATE TABLE `users_chats` (
  `id` int(11) NOT NULL,
  `chats_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_chats`
--

INSERT INTO `users_chats` (`id`, `chats_id`, `user_id`, `last_read_at`) VALUES
(36, 30, 8, NULL),
(37, 30, 7, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_contact` (`user_id`,`contact_id`),
  ADD KEY `contact_id` (`contact_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_id` (`chats_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users_chats`
--
ALTER TABLE `users_chats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_chat` (`chats_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users_chats`
--
ALTER TABLE `users_chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contacts_ibfk_2` FOREIGN KEY (`contact_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`chats_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_chats`
--
ALTER TABLE `users_chats`
  ADD CONSTRAINT `users_chats_ibfk_1` FOREIGN KEY (`chats_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_chats_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
