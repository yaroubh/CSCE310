-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2023 at 03:05 AM
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
(1, NULL),
(2, NULL);

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
(1, 1, 1, 4, 'Overall Good. Would come again', '2023-05-02 12:45:36');

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
(1, 1, 101, 82.12, 2),
(2, 1, 102, 13.93, 2),
(3, 1, 103, 43.03, 6),
(4, 1, 104, 68.25, 8),
(5, 1, 105, 56.06, 4),
(6, 1, 106, 24.78, 9),
(7, 1, 107, 55.6, 1),
(8, 1, 108, 4.68, 1),
(9, 1, 109, 63.16, 8),
(10, 1, 201, 13.83, 2),
(11, 1, 202, 30.02, 3),
(12, 1, 203, 30.05, 8),
(13, 1, 204, 34.74, 3),
(14, 1, 205, 89.98, 3),
(15, 1, 301, 81.28, 7),
(16, 1, 302, 20.29, 9),
(17, 1, 303, 40.7, 7),
(18, 1, 304, 74.32, 6),
(19, 1, 305, 82.42, 2),
(20, 1, 306, 84.71, 2),
(21, 1, 307, 6.63, 8),
(22, 1, 308, 52.83, 4),
(23, 1, 309, 38.24, 7),
(24, 1, 310, 16.27, 4),
(25, 1, 311, 75.09, 6),
(26, 1, 312, 75.98, 2),
(27, 1, 313, 89.65, 3),
(28, 1, 401, 61.61, 1),
(29, 1, 402, 28.46, 8),
(30, 1, 403, 35.95, 9),
(31, 1, 404, 11.36, 7),
(32, 1, 405, 10.17, 3),
(33, 1, 406, 35.89, 4),
(34, 1, 407, 88.66, 3),
(35, 1, 408, 30.5, 2),
(36, 1, 409, 24.86, 9),
(37, 1, 410, 14.07, 2),
(38, 1, 411, 23.42, 2),
(39, 1, 412, 79.9, 1),
(40, 1, 413, 49.34, 4),
(41, 1, 501, 18.53, 5),
(42, 1, 502, 43.83, 8),
(43, 1, 503, 81.77, 3),
(44, 1, 504, 0.36, 9),
(45, 1, 505, 87.27, 8),
(46, 1, 506, 66.61, 1),
(47, 1, 507, 52.13, 2),
(48, 1, 508, 26.3, 4),
(49, 1, 509, 34.72, 1),
(50, 1, 510, 60.7, 1),
(51, 1, 511, 81.61, 4),
(52, 1, 512, 52.93, 3),
(53, 1, 513, 62.34, 7),
(54, 1, 514, 49.73, 5),
(55, 1, 515, 36.92, 2),
(56, 1, 516, 97.17, 3),
(57, 1, 517, 34.81, 8),
(58, 1, 518, 65.14, 8),
(59, 1, 519, 15.77, 9),
(60, 1, 520, 3.25, 6),
(61, 1, 521, 64.99, 8),
(62, 1, 522, 53.57, 9),
(63, 2, 101, 27.76, 9),
(64, 2, 102, 84.31, 5),
(65, 2, 103, 31.31, 8),
(66, 2, 104, 58.59, 9),
(67, 2, 105, 71.65, 8),
(68, 2, 106, 50.2, 6),
(69, 2, 107, 43.14, 7),
(70, 2, 108, 12.44, 3),
(71, 2, 109, 35.73, 2),
(72, 2, 110, 36.89, 1),
(73, 2, 111, 54.72, 6),
(74, 2, 112, 18.02, 8),
(75, 2, 113, 8.97, 9),
(76, 2, 114, 35.69, 8),
(77, 2, 115, 66.77, 4),
(78, 2, 116, 83.42, 6),
(79, 2, 117, 92.72, 1),
(80, 2, 118, 21.8, 5),
(81, 2, 119, 6.1, 5),
(82, 2, 120, 73.07, 3),
(83, 2, 121, 75.03, 5),
(84, 2, 201, 57.68, 7),
(85, 2, 202, 99.3, 9),
(86, 2, 203, 92.07, 9),
(87, 2, 204, 19.74, 4),
(88, 2, 205, 67.56, 8),
(89, 2, 206, 91.53, 1),
(90, 2, 207, 81.71, 1),
(91, 2, 208, 60.66, 9),
(92, 2, 209, 27.26, 4),
(93, 2, 210, 20.7, 2),
(94, 2, 211, 91.74, 3),
(95, 2, 212, 69.65, 2),
(96, 2, 213, 12.15, 7),
(97, 2, 214, 2.88, 1),
(98, 2, 215, 64.7, 8),
(99, 2, 216, 67.38, 3),
(100, 2, 217, 39.29, 9),
(101, 2, 218, 29.87, 5),
(102, 2, 219, 68.27, 7),
(103, 2, 220, 48.28, 2);

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
(1, 'Sam', 'Sammy', 1234567890, 'Sam.Sammy@tamu.edu', 'Sammy1', '1Sammy', 'Customer'),
(2, 'Bob', 'Bobby', 123456789, 'BobbyBob@tamu.edu', 'Bob2', 'Bobby2', 'Customer'),
(3, 'Joe', 'Bobby', 1112222, 'BobbyBob@tamu.edu', 'Bob3', 'Bobby3', 'Employee'),
(4, 'Robby', 'Roe', 2147483647, 'RowRowRob@tamu.edu', 'RobRoe', 'Robby3', 'Employee'),
(5, 'Yoyo', 'Jojo', 2147483647, 'YYJJ@tamu.edu', 'YY55', '55JJ', 'Employee'),
(6, 'Tian', 'Tiap', 2147483647, 'adminTNTP@tamu.edu', 'Admin', 'Totally_Not_The_Password', 'Employee'),
(7, 'Lorali', 'Jones', 1113333, 'Lorali1@tamu.edu', 'Loarli1', 'LP1', 'Employee'),
(8, 'Loralil', 'Jones', 1113334, 'Lorali2@tamu.edu', 'Loarli2', 'LP2', 'Employee'),
(9, 'Loralia', 'Jones', 1113335, 'Lorali3@tamu.edu', 'Loarli3', 'LP3', 'Employee'),
(10, 'Loralip', 'Jones', 1113336, 'Lorali4@tamu.edu', 'Loarli4', 'LP4', 'Employee');

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
  ADD PRIMARY KEY (`User_ID`);

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
  MODIFY `User_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `User_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `Review_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `Room_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

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
  MODIFY `User_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `employees` (`User_ID`);

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`Room_ID`) REFERENCES `room` (`Room_ID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `customer` (`User_ID`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `customer_ibfk_2` FOREIGN KEY (`Booking_NO`) REFERENCES `booking` (`Booking_NO`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`Hotel_ID`) REFERENCES `hotel` (`Hotel_ID`),
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `hotel_service`
--
ALTER TABLE `hotel_service`
  ADD CONSTRAINT `hotel_service_ibfk_1` FOREIGN KEY (`Booking_NO`) REFERENCES `booking` (`Booking_NO`),
  ADD CONSTRAINT `hotel_service_ibfk_2` FOREIGN KEY (`ST_ID`) REFERENCES `service_type` (`ST_ID`);

--
-- Constraints for table `receptionist`
--
ALTER TABLE `receptionist`
  ADD CONSTRAINT `receptionist_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `employees` (`User_ID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`Hotel_ID`) REFERENCES `hotel` (`Hotel_ID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `customer` (`User_ID`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`Hotel_ID`) REFERENCES `hotel` (`Hotel_ID`);

--
-- Constraints for table `service_assignment`
--
ALTER TABLE `service_assignment`
  ADD CONSTRAINT `service_assignment_ibfk_1` FOREIGN KEY (`Service_ID`) REFERENCES `hotel_service` (`Service_ID`),
  ADD CONSTRAINT `service_assignment_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `employees` (`User_ID`);

--
-- Constraints for table `service_worker`
--
ALTER TABLE `service_worker`
  ADD CONSTRAINT `service_worker_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `employees` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
