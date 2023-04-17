-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2023 at 01:43 AM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `User_ID` int(10) UNSIGNED NOT NULL,
  `Booking_NO` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receptionist`
--

CREATE TABLE `receptionist` (
  `User_ID` int(10) UNSIGNED NOT NULL,
  `Shift_Start_Time` time NOT NULL,
  `Shift_End_Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`Room_ID`, `Hotel_ID`, `Room_Num`, `Price`, `Capacity`) VALUES
(1, 1, 101, 38.2, 9),
(2, 1, 102, 24.01, 9),
(3, 1, 103, 84.46, 6),
(4, 1, 104, 99.56, 1),
(5, 1, 105, 22.43, 6),
(6, 1, 106, 95.34, 5),
(7, 1, 107, 42.2, 2),
(8, 1, 201, 45.74, 6),
(9, 1, 202, 21.69, 6),
(10, 1, 203, 87.68, 4),
(11, 1, 204, 65.8, 1),
(12, 1, 205, 22.43, 1),
(13, 1, 206, 37.46, 6),
(14, 1, 207, 79.15, 7),
(15, 1, 208, 51.79, 4),
(16, 1, 209, 11.95, 8),
(17, 1, 210, 97.07, 9),
(18, 1, 211, 54.59, 8),
(19, 1, 212, 45.13, 1),
(20, 1, 213, 28.78, 2),
(21, 1, 214, 39.56, 3),
(22, 1, 215, 23.09, 4),
(23, 1, 216, 63.48, 4),
(24, 1, 217, 1.35, 8),
(25, 1, 218, 28.62, 9),
(26, 1, 219, 71.82, 9),
(27, 1, 220, 3.44, 3),
(28, 1, 301, 93.29, 8),
(29, 1, 302, 64.54, 4),
(30, 1, 303, 17.45, 4),
(31, 1, 304, 79.99, 7),
(32, 1, 305, 20.07, 7),
(33, 1, 306, 3.6, 8),
(34, 1, 307, 60.29, 8),
(35, 1, 308, 8.1, 1),
(36, 1, 309, 15.7, 4),
(37, 1, 310, 0.54, 8),
(38, 1, 311, 65.19, 1),
(39, 1, 312, 32.83, 7),
(40, 1, 313, 61.12, 5),
(41, 1, 314, 58.23, 2),
(42, 1, 315, 48.86, 7),
(43, 1, 316, 85.65, 3),
(44, 1, 317, 50.54, 9),
(45, 1, 318, 83.4, 7),
(46, 1, 401, 98.37, 9),
(47, 1, 402, 21.46, 3),
(48, 1, 403, 22.48, 8),
(49, 1, 404, 15.56, 4),
(50, 1, 405, 72.01, 9),
(51, 1, 406, 69.03, 9),
(52, 1, 407, 42.67, 5),
(53, 1, 408, 98.11, 1),
(54, 1, 409, 79.51, 9),
(55, 1, 410, 17.44, 9),
(56, 1, 411, 28.5, 9),
(57, 1, 501, 67.12, 7),
(58, 1, 502, 75.73, 8),
(59, 1, 503, 47.64, 4),
(60, 1, 504, 24.33, 4),
(61, 1, 505, 49.46, 1),
(62, 2, 101, 66.87, 5),
(63, 2, 102, 76.24, 9),
(64, 2, 201, 72.88, 7),
(65, 2, 202, 84.5, 1),
(66, 2, 203, 72.4, 8),
(67, 2, 204, 19.98, 9),
(68, 2, 205, 46.24, 9);

-- --------------------------------------------------------

--
-- Table structure for table `service_assignment`
--

CREATE TABLE `service_assignment` (
  `SA_ID` int(10) UNSIGNED NOT NULL,
  `Service_ID` int(10) UNSIGNED NOT NULL,
  `User_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_type`
--

CREATE TABLE `service_type` (
  `ST_ID` int(10) UNSIGNED NOT NULL,
  `Service_Type` varchar(45) NOT NULL,
  `Price` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_worker`
--

CREATE TABLE `service_worker` (
  `User_ID` int(10) UNSIGNED NOT NULL,
  `Role` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  MODIFY `Review_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `Room_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

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
