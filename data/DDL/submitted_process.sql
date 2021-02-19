-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2021 at 08:00 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helpdesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `submitted_process`
--

CREATE TABLE `submitted_process` (
  `submitted_process_id` int(11) NOT NULL,
  `process_form_id` int(11) NOT NULL,
  `submitted_process_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`submitted_process_response`)),
  `submitted_process_creator` int(11) NOT NULL,
  `process_status` int(11) NOT NULL,
  `process_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `submitted_process`
--

INSERT INTO `submitted_process` (`submitted_process_id`, `process_form_id`, `submitted_process_response`, `submitted_process_creator`, `process_status`, `process_created`) VALUES
(4, 1, '{\"firstname\":\"test\",\"lastname\":\"test23445\",\"managername\":\"test5\",\"department\":\"test\",\"jobtitle\":\"test434\",\"submit\":\"Update\"}', 10, 0, '2021-02-19 06:32:40'),
(5, 1, '{\"firstname\":\"Matthew\",\"lastname\":\"Caloger\",\"managername\":\"Younan Younan\",\"department\":\"ITS\",\"jobtitle\":\"IT Support Specialist\",\"submit\":\"Update\"}', 10, 0, '2021-02-19 06:53:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `submitted_process`
--
ALTER TABLE `submitted_process`
  ADD PRIMARY KEY (`submitted_process_id`),
  ADD KEY `process_form_id` (`process_form_id`),
  ADD KEY `submitted_process_creator` (`submitted_process_creator`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `submitted_process`
--
ALTER TABLE `submitted_process`
  MODIFY `submitted_process_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `submitted_process`
--
ALTER TABLE `submitted_process`
  ADD CONSTRAINT `submitted_process_ibfk_1` FOREIGN KEY (`process_form_id`) REFERENCES `process_forms` (`process_id`),
  ADD CONSTRAINT `submitted_process_ibfk_2` FOREIGN KEY (`submitted_process_creator`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
