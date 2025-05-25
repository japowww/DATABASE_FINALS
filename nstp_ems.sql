-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 09:06 PM
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
-- Database: `nstp_ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studentId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `course` varchar(150) NOT NULL,
  `yearLevel` int(4) NOT NULL,
  `address` varchar(200) NOT NULL,
  `birthDate` varchar(20) NOT NULL,
  `religion` varchar(30) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `component` enum('ROTC','CWTS') NOT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studentId`, `userId`, `course`, `yearLevel`, `address`, `birthDate`, `religion`, `gender`, `component`, `firstName`, `lastName`) VALUES
(10, 5, 'BSIT', 112, '221', '2025-05-06', 'cathilic', 'Male', 'CWTS', NULL, NULL),
(11, 9, 'BSIT', 2, '32', '2025-05-14', 'cathilic', 'Male', 'CWTS', NULL, NULL),
(12, 9, 'BSIT', 2, '32', '2025-05-14', 'cathilic', 'Male', 'CWTS', NULL, NULL),
(13, 9, 'BSIT', 222, 'adsasd', '2025-05-20', '234', 'Male', 'ROTC', NULL, NULL),
(14, 9, 'BSIT', 4, 'adsasd', '2025-05-20', '234', 'Male21', 'ROTC', NULL, NULL),
(23, 13, 'ICS', 1, '32', '2025-04-30', 'cathilic', 'Female', 'CWTS', NULL, NULL),
(24, 14, 'ICS', 3, 'manolo', '2025-06-12', 'catholic', 'Male', 'ROTC', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('admin','student') NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `firstName`, `lastName`, `email`, `password`, `role`) VALUES
(5, 'NSTPAdmin', 'NBSC', 'NSTPadmin@nbsc.edu.ph', '827ccb0eea8a706c4c34a16891f84e7b', 'student'),
(8, 'NSTPadmin', 'NBSC', 'NSTPadmin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'admin'),
(9, 'student', '1', 'student1@gmail.com', '202cb962ac59075b964b07152d234b70', 'student'),
(10, 'hi', 'hello', 'hi@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'student'),
(11, 'wer', '23', 'wer@gmail.com', '529ca8050a00180790cf88b63468826a', 'student'),
(12, 'ady', 'sales', 'ady@gmail.com', '8da99644eff51a6a988cdcf696886101', 'student'),
(13, 'aki', 'bayot', 'akiBayot@gmail.com', 'a661e868ca500b612ab70ed6bacc8bfe', 'student'),
(14, 'student', 'NBSC', 'student@gmail.com', '0987699ebfa838905d8f76b5980584b9', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`studentId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `studentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
