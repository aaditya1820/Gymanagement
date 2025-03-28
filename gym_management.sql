-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 11:20 AM
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
-- Database: `gym_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `a_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `attendance_status` enum('Present','Absent') NOT NULL,
  `attendance_date` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`a_id`, `name`, `attendance_status`, `attendance_date`) VALUES
(20, 'Aaditya', 'Present', '2024-11-21'),
(21, 'Arpi Patel', 'Present', '2024-11-21'),
(22, 'Bhumika Patel', 'Absent', '2024-11-21'),
(23, 'Aaditya', 'Absent', '2024-11-21'),
(25, 'Arpi Patel', 'Absent', '2024-11-21'),
(27, 'Yash Patel', 'Absent', '2024-11-24'),
(28, 'Aaditya Patel', 'Present', '2024-11-29'),
(29, 'Aaditya Patel', 'Present', '2024-11-29'),
(30, 'Aaditya Patel', 'Absent', '2024-11-29'),
(31, 'Aaditya Patel', 'Present', '2024-11-30'),
(32, 'Bhumika Patel', 'Absent', '2024-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_billing`
--

CREATE TABLE `tbl_billing` (
  `bill_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `trainer_charges` decimal(10,2) DEFAULT NULL,
  `package_charges` decimal(10,2) DEFAULT NULL,
  `plan_charges` decimal(10,2) DEFAULT NULL,
  `gym_charges` decimal(10,2) DEFAULT NULL,
  `gst_rate` decimal(5,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_billing`
--

INSERT INTO `tbl_billing` (`bill_id`, `user_id`, `trainer_id`, `package_id`, `plan_id`, `trainer_charges`, `package_charges`, `plan_charges`, `gym_charges`, `gst_rate`, `total_amount`, `payment_status`, `payment_date`) VALUES
(23, 18, 19, 17, 18, 3500.00, 2500.00, NULL, 12000.00, 18.00, 21240.00, 'Pending', NULL),
(24, 26, 19, 18, 25, 3500.00, 3000.00, NULL, 12000.00, 18.00, 21830.00, 'Pending', NULL),
(25, 28, 25, 23, 24, 4200.00, 5500.00, NULL, 12000.00, 18.00, 25606.00, 'Pending', NULL),
(26, 29, 21, 18, 24, 5000.00, 3000.00, NULL, 12000.00, 18.00, 23600.00, 'Pending', NULL),
(27, 28, 19, 17, 24, 1.00, 1.00, NULL, 1.00, 18.00, 3.54, 'Paid', '2024-11-29 13:21:21'),
(28, 28, 19, 17, 24, 1.00, 1.00, NULL, 1.00, 18.00, 3.54, 'Paid', '2024-11-29 13:27:49'),
(29, 28, 19, 17, 24, 1.00, 1.00, NULL, 1.00, 18.00, 3.54, 'Pending', NULL),
(30, 28, 19, 17, 24, 1.00, 1.00, NULL, 1.00, 18.00, 3.54, 'Pending', NULL),
(31, 28, 19, 17, 25, 1.00, 1.00, NULL, 12000.00, 18.00, 14162.36, 'Pending', NULL),
(32, 28, 19, 18, 24, 1.00, 3000.00, NULL, 11000.00, 18.00, 16521.18, 'Pending', NULL),
(33, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(34, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(35, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(36, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(37, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(38, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(39, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(40, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(41, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(42, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(43, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(44, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(45, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(46, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(47, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(48, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(49, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(50, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(51, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(52, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(53, 29, 21, 17, 24, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(54, 28, 22, 17, 25, 5000.00, 1.00, NULL, 12000.00, 18.00, 20061.18, 'Pending', NULL),
(55, 28, 21, 18, 25, 5000.00, 3000.00, NULL, 12000.00, 18.00, 23600.00, 'Pending', NULL),
(56, 28, 19, 18, 25, 1.00, 3000.00, NULL, 12000.00, 18.00, 17701.18, 'Pending', NULL),
(57, 29, 23, 17, 25, 7000.00, 1.00, NULL, 100.00, 18.00, 8379.18, 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_packages`
--

CREATE TABLE `tbl_packages` (
  `package_id` int(11) NOT NULL,
  `package_name` varchar(100) NOT NULL,
  `charges` decimal(10,2) DEFAULT NULL,
  `duration` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_packages`
--

INSERT INTO `tbl_packages` (`package_id`, `package_name`, `charges`, `duration`) VALUES
(17, 'fatloss', 1.00, '20'),
(18, 'cardio', 3000.00, '30'),
(21, 'legs', 3050.00, '35'),
(22, 'back', 2500.00, '20'),
(23, 'yoga', 5500.00, '50'),
(24, 'legs', 3999.00, '6');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_plans`
--

CREATE TABLE `tbl_plans` (
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_plans`
--

INSERT INTO `tbl_plans` (`plan_id`, `plan_name`, `start_date`, `end_date`) VALUES
(24, 'monthly', '2024-11-29', '2024-12-29'),
(25, 'quarterly', '2024-11-29', '2025-05-29'),
(26, 'yearly', '2024-11-29', '2025-11-29'),
(27, 'membership', '2024-11-29', '2026-11-29'),
(28, 'Diet Plan', '2024-12-01', '2025-06-01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_register`
--

CREATE TABLE `tbl_register` (
  `reg_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_register`
--

INSERT INTO `tbl_register` (`reg_id`, `email`, `password`, `name`, `age`, `registration_date`) VALUES
(22, '22bmiit188@gmail.com', '5a967e2e54e7fe795b93c5a5d27813cd', 'Aaditya Patel', 21, '2024-11-29 06:44:27'),
(23, 'manisha@gmail.com', '2a7d535ad179d861e6abe177027c4fbb', 'Manisha', 46, '2024-11-29 06:48:17'),
(24, 'arpi1096@gmail.com', 'cf4dd5731f8bb1c5b281be2d2f9434b7', 'Arpi Patel', 23, '2024-11-29 06:51:06'),
(25, 'bhumika.patel@utu.ac.in', '31262963120733133a140364c89c5d3f', 'Bhumika Patel', 48, '2024-11-29 06:57:53'),
(26, 'yashpatel@gmail.com', '675fb8c57a259d1ba9c30ac998132ef3', 'Yash Patel', 25, '2024-11-29 07:03:06'),
(27, 'dhruv@gmail.com', '1b5ec7894bc29710c7a9122cd32e1bb1', 'Dhruv', 22, '2024-11-30 04:23:17'),
(28, 'ansh@gmail.com', '2cdfd792ccf5dbe5721831e5fca62ffa', 'Ansh Goti', 20, '2024-11-30 06:50:01'),
(29, '22bmiit213@gmail.com', 'ab9a535ab01a81d51a4f9b47e03a21be', 'Khushi', 21, '2024-11-30 08:21:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trainers`
--

CREATE TABLE `tbl_trainers` (
  `trainer_id` int(11) NOT NULL,
  `trainer_name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `charges` decimal(10,2) NOT NULL,
  `contact` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_trainers`
--

INSERT INTO `tbl_trainers` (`trainer_id`, `trainer_name`, `age`, `specialization`, `charges`, `contact`) VALUES
(19, 'Yash Patel', 24, 'Cardiologist', 1.00, '9826162775'),
(21, 'Ankit Jariwala', 40, 'professional trainer', 5000.00, '8571211545'),
(22, 'Kashish Patel', 25, 'Yoga', 5000.00, '6355784262'),
(23, 'Sanjay Jain', 36, 'Body Building', 7000.00, '9624361185'),
(24, 'Disha Yadav', 27, 'Cardiologist', 2600.00, '7048561078'),
(25, 'Amit Patel', 45, 'Arobics', 4200.00, '9825163286'),
(26, 'Ansh', 25, 'Personal Trainer', 5000.00, '9104485925'),
(28, 'meet', 27, 'body building', 2000.00, '6235641512');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `height` float NOT NULL,
  `weight` float NOT NULL,
  `bloodgroup` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `contact_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `name`, `email`, `age`, `height`, `weight`, `bloodgroup`, `address`, `contact_number`) VALUES
(28, 'Aaditya Patel', '22bmiit188@gmail.com', 21, 5.9, 90, 'O+', 'Satyam', '9925076665'),
(29, 'Manisha Patel', 'Manisha@gmail.com', 46, 5.2, 56, 'O+', 'Surat', '9925006965'),
(30, 'Arpi Patel', 'arpi1096@gmail.com', 23, 5.3, 57, 'a+', 'Satyam B', '9925076965'),
(31, 'Bhumika Patel', 'bhumika.patel@utu.ac.in', 46, 5.3, 90, 'a+', 'Adajan', '9099242362'),
(32, 'Yash Patel', 'yashpatel@gmail.com', 23, 6.2, 95, 'o+', 'Pal Gam\r\n', '9375790917');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `tbl_billing`
--
ALTER TABLE `tbl_billing`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `tbl_packages`
--
ALTER TABLE `tbl_packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `tbl_plans`
--
ALTER TABLE `tbl_plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `tbl_register`
--
ALTER TABLE `tbl_register`
  ADD PRIMARY KEY (`reg_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_trainers`
--
ALTER TABLE `tbl_trainers`
  ADD PRIMARY KEY (`trainer_id`),
  ADD UNIQUE KEY `contact` (`contact`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tbl_billing`
--
ALTER TABLE `tbl_billing`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tbl_packages`
--
ALTER TABLE `tbl_packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_plans`
--
ALTER TABLE `tbl_plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_register`
--
ALTER TABLE `tbl_register`
  MODIFY `reg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_trainers`
--
ALTER TABLE `tbl_trainers`
  MODIFY `trainer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
