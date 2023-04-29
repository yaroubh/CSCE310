-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2023 at 05:54 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `User_ID` int(10) UNSIGNED NOT NULL,
  `Speciality` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`User_ID`, `Speciality`) VALUES
(6, 'Site Reliability');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `Booking_NO` int(10) UNSIGNED NOT NULL,
  `Room_ID` int(10) UNSIGNED NOT NULL,
  `User_ID` int(10) UNSIGNED NOT NULL,
  `Start_Date` datetime NOT NULL,
  `End_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `User_ID` int(10) UNSIGNED NOT NULL,
  `Booking_NO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`User_ID`, `Booking_NO`) VALUES
(2, NULL),
(15, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `User_ID` int(10) UNSIGNED NOT NULL,
  `Hotel_ID` int(10) UNSIGNED NOT NULL,
  `Employee_JobType` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`User_ID`, `Hotel_ID`, `Employee_JobType`) VALUES
(3, 1, 'Receptionist'),
(4, 1, 'Receptionist'),
(5, 2, 'Receptionist'),
(6, 1, 'Administrator'),
(7, 1, 'Service_Worker'),
(8, 1, 'Service_Worker'),
(9, 2, 'Service_Worker'),
(10, 2, 'Service_Worker');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `Hotel_ID` int(10) UNSIGNED NOT NULL,
  `Hotel_Name` varchar(45) NOT NULL,
  `Hotel_City` varchar(45) NOT NULL,
  `Hotel_State` varchar(45) NOT NULL,
  `Hotel_Country` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`Hotel_ID`, `Hotel_Name`, `Hotel_City`, `Hotel_State`, `Hotel_Country`) VALUES
(1, 'BCS Hotel', 'BCS', 'Texas', 'United States'),
(2, 'Magico', 'Monte Cristo', 'Livorno', 'Italy');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_service`
--

CREATE TABLE `hotel_service` (
  `Service_ID` int(10) UNSIGNED NOT NULL,
  `Booking_NO` int(10) UNSIGNED NOT NULL,
  `ST_ID` int(10) UNSIGNED NOT NULL,
  `Service_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receptionist`
--

CREATE TABLE `receptionist` (
  `User_ID` int(10) UNSIGNED NOT NULL,
  `Shift_Start_Time` time NOT NULL,
  `Shift_End_Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receptionist`
--

INSERT INTO `receptionist` (`User_ID`, `Shift_Start_Time`, `Shift_End_Time`) VALUES
(3, '08:00:00', '20:00:00'),
(4, '20:00:00', '08:00:00'),
(5, '00:00:00', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `Review_ID` int(10) UNSIGNED NOT NULL,
  `Hotel_ID` int(10) UNSIGNED NOT NULL,
  `User_ID` int(10) UNSIGNED NOT NULL,
  `Rating` int(2) UNSIGNED NOT NULL,
  `Description` varchar(300) NOT NULL,
  `Review_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`Review_ID`, `Hotel_ID`, `User_ID`, `Rating`, `Description`, `Review_Date`) VALUES
(2, 2, 2, 5, 'Such a wonderful experience. The family loved.', '2022-05-12 13:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `Room_ID` int(10) UNSIGNED NOT NULL,
  `Hotel_ID` int(10) UNSIGNED NOT NULL,
  `Room_Num` int(5) UNSIGNED NOT NULL,
  `Price` float UNSIGNED NOT NULL,
  `Capacity` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`Room_ID`, `Hotel_ID`, `Room_Num`, `Price`, `Capacity`) VALUES
(1, 1, 101, 72.66, 3),
(2, 1, 102, 46.28, 9),
(3, 1, 103, 38.82, 2),
(4, 1, 104, 17.93, 3),
(5, 1, 105, 16.76, 9),
(6, 1, 106, 45.96, 1),
(7, 1, 201, 62.71, 8),
(8, 1, 202, 29.51, 8),
(9, 1, 203, 3.38, 1),
(10, 1, 204, 96.68, 4),
(11, 1, 205, 93.91, 5),
(12, 1, 206, 46.65, 8),
(13, 1, 207, 62.11, 6),
(14, 1, 208, 33.67, 4),
(15, 1, 209, 54.01, 5),
(16, 1, 210, 36.2, 3),
(17, 1, 211, 30.78, 7),
(18, 1, 212, 6.19, 1),
(19, 1, 213, 56.39, 4),
(20, 1, 214, 80.33, 2),
(21, 1, 215, 62.39, 5),
(22, 1, 216, 81.93, 6),
(23, 1, 217, 32.24, 8),
(24, 1, 218, 20.03, 6),
(25, 1, 219, 54.11, 7),
(26, 1, 220, 36.33, 3),
(27, 1, 221, 37.92, 3),
(28, 1, 222, 34.78, 6),
(29, 1, 223, 90.65, 1),
(30, 1, 224, 20.86, 3),
(31, 2, 101, 64.56, 4),
(32, 2, 201, 58.22, 4),
(33, 2, 301, 57.93, 7),
(34, 2, 302, 18.7, 4),
(35, 2, 303, 36.73, 7),
(36, 2, 304, 42.11, 7),
(37, 2, 305, 23.8, 5),
(38, 2, 306, 31.67, 8),
(39, 2, 307, 6.57, 4),
(40, 2, 308, 4.58, 5),
(41, 2, 309, 96.14, 8),
(42, 2, 310, 46.62, 6),
(43, 2, 311, 26.35, 8),
(44, 2, 312, 61.21, 9),
(45, 2, 313, 82.26, 1),
(46, 2, 314, 93.77, 6),
(47, 2, 315, 31.66, 6),
(48, 2, 316, 54.26, 3),
(49, 2, 317, 33, 9),
(50, 2, 318, 16.89, 2),
(51, 2, 319, 62.27, 2),
(52, 2, 320, 13.23, 3),
(53, 2, 401, 70.2, 8),
(54, 2, 402, 64.2, 7),
(55, 2, 403, 10.48, 8),
(56, 2, 404, 33.02, 9),
(57, 2, 405, 16.64, 7),
(58, 2, 406, 30.17, 9),
(59, 2, 407, 30.89, 2),
(60, 2, 408, 81.01, 7),
(61, 2, 409, 59.21, 9),
(62, 2, 410, 72.06, 9),
(63, 2, 411, 30.47, 1),
(64, 2, 412, 24.43, 9),
(65, 2, 413, 55.69, 3),
(66, 2, 414, 13.1, 8),
(67, 2, 415, 27.28, 7),
(68, 2, 416, 32.5, 7),
(69, 2, 417, 29.9, 3),
(70, 2, 418, 45.24, 9),
(71, 2, 419, 81.44, 2),
(72, 2, 420, 20.21, 6),
(73, 2, 421, 52.63, 5),
(74, 2, 422, 25.91, 5);

-- --------------------------------------------------------

--
-- Table structure for table `service_assignment`
--

CREATE TABLE `service_assignment` (
  `SA_ID` int(10) UNSIGNED NOT NULL,
  `Service_ID` int(10) UNSIGNED NOT NULL,
  `User_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_type`
--

CREATE TABLE `service_type` (
  `ST_ID` int(10) UNSIGNED NOT NULL,
  `Service_Type` varchar(45) NOT NULL,
  `Price` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_worker`
--

CREATE TABLE `service_worker` (
  `User_ID` int(10) UNSIGNED NOT NULL,
  `Role` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_worker`
--

INSERT INTO `service_worker` (`User_ID`, `Role`) VALUES
(7, 'Janitor'),
(8, 'Plumber'),
(9, 'Janitor'),
(10, 'Electrician');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(10) UNSIGNED NOT NULL,
  `FName` varchar(45) NOT NULL,
  `LName` varchar(45) NOT NULL,
  `Phone_NO` int(10) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `User_Type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `FName`, `LName`, `Phone_NO`, `Email`, `Username`, `Password`, `User_Type`) VALUES
(2, 'Bob', 'Bobby', 123456789, 'BobbyBob@tamu.edu', 'Bob2', 'Bobby2', 'Customer'),
(3, 'Joe', 'Bobby', 1112222, 'BobbyBob@tamu.edu', 'Bob3', 'Bobby3', 'Employee'),
(4, 'Robby', 'Roe', 2147483647, 'RowRowRob@tamu.edu', 'RobRoe', 'Robby3', 'Employee'),
(5, 'Yoyo', 'Jojo', 2147483647, 'YYJJ@tamu.edu', 'YY55', '55JJ', 'Employee'),
(6, 'Tian', 'Tiap', 2147483647, 'adminTNTP@tamu.edu', 'Admin', 'Totally_Not_The_Password', 'Employee'),
(7, 'Lorali', 'Jones', 1113333, 'Lorali1@tamu.edu', 'Loarli1', 'LP1', 'Employee'),
(8, 'Loralil', 'Jones', 1113334, 'Lorali2@tamu.edu', 'Loarli2', 'LP2', 'Employee'),
(9, 'Loralia', 'Jones', 1113335, 'Lorali3@tamu.edu', 'Loarli3', 'LP3', 'Employee'),
(10, 'Loralip', 'Jones', 1113336, 'Lorali4@tamu.edu', 'Loarli4', 'LP4', 'Employee'),
(15, 'Sam', 'Sammy', 1234567899, 'Sammy@tamu.edu', 'Sammy1', '1Sammy', 'Customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`Booking_NO`),
  ADD KEY `Room_ID` (`Room_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`User_ID`),
  ADD KEY `Booking_NO` (`Booking_NO`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`User_ID`),
  ADD KEY `Hotel_ID` (`Hotel_ID`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`Hotel_ID`);

--
-- Indexes for table `hotel_service`
--
ALTER TABLE `hotel_service`
  ADD PRIMARY KEY (`Service_ID`),
  ADD KEY `Booking_NO` (`Booking_NO`),
  ADD KEY `ST_ID` (`ST_ID`);

--
-- Indexes for table `receptionist`
--
ALTER TABLE `receptionist`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`Review_ID`),
  ADD KEY `Hotel_ID` (`Hotel_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`Room_ID`),
  ADD KEY `Hotel_ID` (`Hotel_ID`);

--
-- Indexes for table `service_assignment`
--
ALTER TABLE `service_assignment`
  ADD PRIMARY KEY (`SA_ID`),
  ADD KEY `Service_ID` (`Service_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `service_type`
--
ALTER TABLE `service_type`
  ADD PRIMARY KEY (`ST_ID`);

--
-- Indexes for table `service_worker`
--
ALTER TABLE `service_worker`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `User_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `Booking_NO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `User_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `User_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `Hotel_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hotel_service`
--
ALTER TABLE `hotel_service`
  MODIFY `Service_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `receptionist`
--
ALTER TABLE `receptionist`
  MODIFY `User_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `Review_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `Room_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `service_assignment`
--
ALTER TABLE `service_assignment`
  MODIFY `SA_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_type`
--
ALTER TABLE `service_type`
  MODIFY `ST_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_worker`
--
ALTER TABLE `service_worker`
  MODIFY `User_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `employees` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`Room_ID`) REFERENCES `room` (`Room_ID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `customer` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_ibfk_2` FOREIGN KEY (`Booking_NO`) REFERENCES `booking` (`Booking_NO`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`Hotel_ID`) REFERENCES `hotel` (`Hotel_ID`),
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `hotel_service`
--
ALTER TABLE `hotel_service`
  ADD CONSTRAINT `hotel_service_ibfk_1` FOREIGN KEY (`Booking_NO`) REFERENCES `booking` (`Booking_NO`) ON DELETE CASCADE,
  ADD CONSTRAINT `hotel_service_ibfk_2` FOREIGN KEY (`ST_ID`) REFERENCES `service_type` (`ST_ID`);

--
-- Constraints for table `receptionist`
--
ALTER TABLE `receptionist`
  ADD CONSTRAINT `receptionist_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `employees` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`Hotel_ID`) REFERENCES `hotel` (`Hotel_ID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `customer` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`Hotel_ID`) REFERENCES `hotel` (`Hotel_ID`);

--
-- Constraints for table `service_assignment`
--
ALTER TABLE `service_assignment`
  ADD CONSTRAINT `service_assignment_ibfk_1` FOREIGN KEY (`Service_ID`) REFERENCES `hotel_service` (`Service_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_assignment_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `employees` (`User_ID`);

--
-- Constraints for table `service_worker`
--
ALTER TABLE `service_worker`
  ADD CONSTRAINT `service_worker_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `employees` (`User_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
