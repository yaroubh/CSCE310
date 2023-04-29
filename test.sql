-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2023 at 06:39 AM
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
-- Stand-in structure for view `employee_view`
-- (See below for the actual view)
--
CREATE TABLE `employee_view` (
`FName` varchar(45)
,`LName` varchar(45)
,`Phone_No` int(10)
,`Email` varchar(60)
,`Username` varchar(45)
,`Password` varchar(45)
,`Employee_JobType` varchar(45)
);

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
-- Stand-in structure for view `hotel_view`
-- (See below for the actual view)
--
CREATE TABLE `hotel_view` (
`Hotel_Name` varchar(45)
,`Hotel_City` varchar(45)
,`Hotel_State` varchar(45)
,`Hotel_Country` varchar(45)
);

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
(1, 1, 101, 39.26, 7),
(2, 1, 201, 63.32, 3),
(3, 1, 202, 2.91, 2),
(4, 1, 203, 28.59, 1),
(5, 1, 204, 24.89, 6),
(6, 1, 205, 15.12, 3),
(7, 1, 206, 16.63, 1),
(8, 1, 207, 68.12, 4),
(9, 1, 208, 85.68, 3),
(10, 1, 209, 71.09, 7),
(11, 1, 210, 84.81, 1),
(12, 1, 211, 25.81, 5),
(13, 1, 212, 65.87, 9),
(14, 1, 213, 74.49, 7),
(15, 1, 214, 98.44, 1),
(16, 1, 215, 0.73, 5),
(17, 1, 216, 94.32, 7),
(18, 1, 217, 35.58, 5),
(19, 1, 218, 23.91, 5),
(20, 1, 219, 53.87, 7),
(21, 1, 220, 64.15, 8),
(22, 1, 221, 3.22, 2),
(23, 1, 222, 22.47, 1),
(24, 2, 101, 59.49, 3),
(25, 2, 102, 91.76, 2),
(26, 2, 103, 93.38, 9),
(27, 2, 104, 37.55, 3),
(28, 2, 105, 87.91, 6),
(29, 2, 106, 11.84, 2),
(30, 2, 107, 89.02, 5),
(31, 2, 108, 30.78, 6),
(32, 2, 109, 93.89, 5),
(33, 2, 110, 89.78, 8),
(34, 2, 111, 99.12, 9),
(35, 2, 112, 18.45, 8),
(36, 2, 113, 38.18, 3),
(37, 2, 114, 74.36, 9),
(38, 2, 115, 69.08, 9),
(39, 2, 116, 6.24, 5),
(40, 2, 117, 98.09, 1),
(41, 2, 118, 34.37, 9),
(42, 2, 119, 27.84, 2),
(43, 2, 120, 77.11, 6),
(44, 2, 121, 34.49, 6),
(45, 2, 122, 41.4, 1),
(46, 2, 123, 79.5, 4),
(47, 2, 201, 61.93, 4),
(48, 2, 202, 23.7, 4),
(49, 2, 203, 25.12, 2),
(50, 2, 204, 7.8, 4),
(51, 2, 205, 78.92, 6),
(52, 2, 206, 93.58, 1),
(53, 2, 207, 64.24, 5),
(54, 2, 208, 55.48, 7),
(55, 2, 209, 91.19, 4),
(56, 2, 210, 22.86, 2),
(57, 2, 211, 88.29, 5),
(58, 2, 212, 21.26, 4),
(59, 2, 213, 24.97, 8),
(60, 2, 301, 45.61, 7),
(61, 2, 302, 19.7, 5),
(62, 2, 303, 27.96, 9),
(63, 2, 304, 12.58, 7),
(64, 2, 305, 36.34, 7),
(65, 2, 306, 43.84, 7),
(66, 2, 307, 68.48, 1),
(67, 2, 308, 87.91, 8),
(68, 2, 309, 21.33, 1),
(69, 2, 401, 31.5, 7),
(70, 2, 402, 21.16, 3),
(71, 2, 403, 56.2, 2),
(72, 2, 404, 42.18, 1),
(73, 2, 405, 65.36, 5),
(74, 2, 406, 24.48, 4),
(75, 2, 407, 43.25, 4),
(76, 2, 408, 89.39, 9),
(77, 2, 409, 98.42, 6),
(78, 2, 410, 64.53, 3),
(79, 2, 411, 91.29, 3),
(80, 2, 501, 15.46, 4),
(81, 2, 502, 31.84, 3),
(82, 2, 503, 33.11, 5),
(83, 2, 504, 69.66, 3),
(84, 2, 505, 37.14, 3),
(85, 2, 506, 51.46, 7),
(86, 2, 507, 25.55, 4),
(87, 2, 508, 35.36, 6),
(88, 2, 509, 95.28, 5),
(89, 2, 510, 93.49, 3),
(90, 2, 511, 45.47, 7);

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

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_view`
-- (See below for the actual view)
--
CREATE TABLE `user_view` (
`FName` varchar(45)
,`LName` varchar(45)
,`Phone_No` int(10)
,`Email` varchar(60)
,`Username` varchar(45)
,`Password` varchar(45)
,`User_Type` varchar(30)
);

-- --------------------------------------------------------

--
-- Structure for view `employee_view`
--
DROP TABLE IF EXISTS `employee_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `employee_view`  AS SELECT `users`.`FName` AS `FName`, `users`.`LName` AS `LName`, `users`.`Phone_NO` AS `Phone_No`, `users`.`Email` AS `Email`, `users`.`Username` AS `Username`, `users`.`Password` AS `Password`, `employees`.`Employee_JobType` AS `Employee_JobType` FROM (`users` join `employees` on(`users`.`User_ID` = `employees`.`User_ID`))  ;

-- --------------------------------------------------------

--
-- Structure for view `hotel_view`
--
DROP TABLE IF EXISTS `hotel_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `hotel_view`  AS SELECT `hotel`.`Hotel_Name` AS `Hotel_Name`, `hotel`.`Hotel_City` AS `Hotel_City`, `hotel`.`Hotel_State` AS `Hotel_State`, `hotel`.`Hotel_Country` AS `Hotel_Country` FROM `hotel``hotel`  ;

-- --------------------------------------------------------

--
-- Structure for view `user_view`
--
DROP TABLE IF EXISTS `user_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_view`  AS SELECT `users`.`FName` AS `FName`, `users`.`LName` AS `LName`, `users`.`Phone_NO` AS `Phone_No`, `users`.`Email` AS `Email`, `users`.`Username` AS `Username`, `users`.`Password` AS `Password`, `users`.`User_Type` AS `User_Type` FROM `users``users`  ;

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
  MODIFY `Room_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

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
  ADD CONSTRAINT `customer_ibfk_2` FOREIGN KEY (`Booking_NO`) REFERENCES `booking` (`Booking_NO`),
  ADD CONSTRAINT `customer_ibfk_3` FOREIGN KEY (`Booking_NO`) REFERENCES `booking` (`Booking_NO`);

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
