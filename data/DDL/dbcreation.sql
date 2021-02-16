-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2021 at 09:32 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- sessionssession_id
-- Database: `tickets`
--

-- --------------------------------------------------------

--
-- Table structure for table `process_forms`
--

--
-- Dumping data for table `process_forms`
--

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_token` varchar(190) NOT NULL,
  `session_expires` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sessions`
--

-- --------------------------------------------------------

--
-- Table structure for table `submitted_process`
--

--
-- Dumping data for table `submitted_process`
--

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `team_id` int(11) NOT NULL,
  `team_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`team_id`, `team_name`) VALUES
(1, 'Information Technology');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `ticket_summary` text NOT NULL,
  `ticket_details` text DEFAULT NULL,
  `ticket_status` int(11) NOT NULL DEFAULT 1,
  `ticket_is_complete` tinyint(1) NOT NULL DEFAULT 0,
  `ticket_creator` int(11) DEFAULT NULL,
  `ticket_team_owner` int(11) DEFAULT NULL,
  `ticket_technician_owner` int(11) DEFAULT NULL,
  `ticket_creation_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

-- --------------------------------------------------------

--
-- Table structure for table `ticket_status`
--

CREATE TABLE `ticket_status` (
  `status_id` int(11) NOT NULL,
  `status_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket_status`
--

-- --------------------------------------------------------

--
-- Table structure for table `ticket_update`
--

CREATE TABLE `ticket_update` (
  `update_id` int(11) NOT NULL,
  `update_ticket_id` int(11) NOT NULL,
  `update_details` text NOT NULL,
  `update_owner` int(11) NOT NULL,
  `update_is_public` tinyint(1) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket_update`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_login_name` varchar(190) NOT NULL,
  `user_password` text NOT NULL,
  `user_first_name` text NOT NULL,
  `user_last_name` text NOT NULL,
  `user_is_technician` tinyint(1) NOT NULL DEFAULT 0,
  `user_is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_login_name`, `user_password`, `user_first_name`, `user_last_name`, `user_is_technician`, `user_is_admin`) VALUES
(1, 'testadmin', '$2y$10$3tTy.ab3N33j6GZvvWy6b.T4ThNVZC//80xNm1eS4RrYuWRlDYTHW', 'Admin', 'Administrator', 1, 1),
(2, 'testtechnician', '$2y$10$vEa1e/X6NbKUjyExgIdeZOCv6p7hAc64B7Xy1MQwvm7cAVyQ2D6si', 'Tech', 'Tester', 1, 0),
(3, 'testuser', '$2y$10$vjjBAqgFm2vHNPY5IFk2NeqKGsJTJOMSwT5PDbxqKQFOF2kWI1i8q', 'Test', 'User', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `process_forms`
--
--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD UNIQUE KEY `session_token` (`session_token`) USING HASH,
  ADD KEY `sessions_ibfk_1` (`user_id`);

--
-- Indexes for table `submitted_process`
--

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `tickets_ibfk_4` (`ticket_status`),
  ADD KEY `tickets_ibfk_1` (`ticket_creator`),
  ADD KEY `tickets_ibfk_3` (`ticket_technician_owner`),
  ADD KEY `tickets_ibfk_2` (`ticket_team_owner`);

--
-- Indexes for table `ticket_status`
--
ALTER TABLE `ticket_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `ticket_update`
--
ALTER TABLE `ticket_update`
  ADD PRIMARY KEY (`update_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_login_name` (`user_login_name`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `process_forms`
--

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `submitted_process`
--
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `ticket_status`
--
ALTER TABLE `ticket_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `ticket_update`
--
ALTER TABLE `ticket_update`
  MODIFY `update_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `submitted_process`
--
--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`ticket_creator`) REFERENCES `users` (`user_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`ticket_team_owner`) REFERENCES `team` (`team_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`ticket_technician_owner`) REFERENCES `users` (`user_id`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
