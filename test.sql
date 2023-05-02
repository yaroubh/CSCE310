-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2023 at 01:11 AM
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
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `Booking_NO` int(10) UNSIGNED NOT NULL,
  `Room_ID` int(10) UNSIGNED NOT NULL,
  `User_ID` int(10) UNSIGNED NOT NULL,
  `Start_Date` datetime NOT NULL,
  `End_Date` datetime NOT NULL
) ;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`Booking_NO`, `Room_ID`, `User_ID`, `Start_Date`, `End_Date`) VALUES
(1, 1, 1, '2022-05-12 13:55:12', '2022-05-15 13:55:12'),
(2, 1, 2, '2022-05-17 10:10:10', '2022-05-19 10:10:10'),
(3, 2, 2, '2022-05-30 10:10:10', '2022-06-17 11:11:11');

--
-- Triggers `booking`
--
DELIMITER $$
CREATE TRIGGER `Solo_Booking` BEFORE INSERT ON `booking` FOR EACH ROW BEGIN
    IF EXISTS (SELECT * FROM Booking WHERE NEW.Room_ID = Booking.Room_ID AND (NEW.Start_Date <= Booking.End_Date AND Booking.Start_Date <= New.End_Date)) THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Dates should not overlap for the booking of the same room';
    END IF;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Solo_Booking_Update` BEFORE UPDATE ON `booking` FOR EACH ROW BEGIN
    IF EXISTS (SELECT * FROM Booking WHERE NEW.Room_ID = Booking.Room_ID AND NEW.Booking_NO != Booking.Booking_NO AND (NEW.Start_Date <= Booking.End_Date AND Booking.Start_Date <= New.End_Date)) THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Dates should not overlap for the booking of the same room';
    END IF;
    END
$$
DELIMITER ;

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
(2, 'Magico', 'Monte Cristo', 'Livorno', 'Italy'),
(3, 'Houstonia', 'Houston', 'Texas', 'United States');

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
(1, 1, 1, 4, 'Overall Good. Would come again', '2023-05-02 12:45:36'),
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
(1, 1, 101, 58.25, 1),
(2, 1, 102, 89.74, 8),
(3, 1, 103, 25.57, 5),
(4, 1, 104, 2.49, 5),
(5, 1, 105, 29.8, 7),
(6, 1, 106, 69.05, 5),
(7, 1, 107, 85.33, 3),
(8, 1, 108, 18.93, 3),
(9, 1, 109, 25.65, 9),
(10, 1, 110, 81.11, 2),
(11, 1, 111, 15.07, 9),
(12, 1, 112, 69.7, 3),
(13, 1, 113, 44.38, 7),
(14, 1, 114, 6.77, 2),
(15, 1, 115, 8.27, 7),
(16, 1, 116, 71.63, 5),
(17, 1, 117, 5.5, 1),
(18, 1, 118, 71.98, 5),
(19, 1, 119, 14.51, 1),
(20, 1, 120, 84.55, 3),
(21, 1, 201, 74.34, 5),
(22, 1, 202, 63.47, 9),
(23, 1, 203, 19.7, 8),
(24, 1, 204, 72.62, 9),
(25, 1, 205, 5.57, 1),
(26, 1, 206, 81.77, 6),
(27, 1, 207, 43.39, 4),
(28, 1, 208, 25.7, 7),
(29, 1, 209, 35.76, 2),
(30, 1, 301, 46.95, 5),
(31, 1, 302, 19.51, 7),
(32, 1, 303, 19.17, 9),
(33, 1, 304, 99.19, 7),
(34, 1, 305, 40.96, 6),
(35, 1, 306, 81.67, 5),
(36, 1, 307, 16.74, 4),
(37, 1, 308, 77.2, 6),
(38, 1, 309, 59.12, 6),
(39, 1, 310, 93.31, 5),
(40, 1, 311, 75.86, 4),
(41, 1, 312, 99.43, 3),
(42, 1, 313, 6.79, 3),
(43, 1, 314, 21.05, 2),
(44, 1, 315, 41.98, 7),
(45, 1, 316, 72.84, 6),
(46, 1, 317, 97.16, 1),
(47, 1, 318, 74.38, 4),
(48, 1, 319, 54.69, 1),
(49, 1, 320, 99.66, 6),
(50, 1, 321, 63.01, 4),
(51, 1, 322, 8.26, 9),
(52, 1, 323, 25.7, 6),
(53, 1, 324, 78.08, 4),
(54, 1, 325, 43.98, 4),
(55, 1, 401, 49.65, 2),
(56, 1, 402, 39.09, 2),
(57, 1, 403, 4.88, 5),
(58, 1, 404, 23.82, 4),
(59, 1, 405, 13.81, 1),
(60, 1, 406, 8.16, 7),
(61, 1, 407, 57.66, 8),
(62, 1, 408, 13.33, 1),
(63, 1, 409, 66.46, 3),
(64, 1, 410, 57.65, 1),
(65, 1, 411, 78.44, 8),
(66, 1, 412, 53.48, 9),
(67, 1, 413, 72.48, 6),
(68, 1, 414, 59.66, 8),
(69, 1, 415, 61.17, 7),
(70, 1, 416, 83.16, 5),
(71, 1, 417, 2.36, 4),
(72, 1, 418, 83.38, 5),
(73, 1, 419, 87.48, 1),
(74, 1, 420, 61.28, 7),
(75, 1, 421, 70.34, 8),
(76, 1, 422, 1.47, 1),
(77, 1, 423, 3.36, 9),
(78, 1, 424, 57.33, 8),
(79, 1, 425, 39.79, 8),
(80, 2, 101, 48.95, 5),
(81, 2, 102, 71.22, 9),
(82, 2, 103, 7.37, 5),
(83, 2, 104, 5.97, 2),
(84, 2, 105, 92.55, 5),
(85, 2, 106, 90.4, 3),
(86, 2, 107, 85.75, 1),
(87, 2, 201, 10.54, 4),
(88, 2, 202, 84.39, 8),
(89, 2, 203, 44.7, 2),
(90, 2, 204, 73.83, 6),
(91, 2, 205, 90.82, 6),
(92, 2, 206, 10.48, 7),
(93, 2, 207, 93.66, 9),
(94, 2, 208, 20.29, 3),
(95, 2, 209, 61.89, 9),
(96, 2, 210, 8.18, 7),
(97, 2, 211, 79.27, 3),
(98, 2, 212, 98.8, 8),
(99, 2, 213, 31.69, 4),
(100, 2, 214, 12.6, 1),
(101, 2, 215, 98.48, 1),
(102, 2, 216, 11.92, 5),
(103, 2, 217, 47.28, 8),
(104, 2, 218, 97.49, 7),
(105, 2, 219, 83.34, 3),
(106, 2, 220, 1.75, 1),
(107, 2, 301, 28.71, 9),
(108, 2, 302, 50.63, 9),
(109, 2, 303, 15.23, 7),
(110, 2, 304, 32.26, 1),
(111, 2, 305, 57.07, 1),
(112, 2, 306, 86.54, 5),
(113, 2, 307, 9.44, 4),
(114, 2, 308, 65.7, 3),
(115, 2, 309, 94.63, 5),
(116, 2, 310, 84.16, 2),
(117, 2, 311, 28.55, 3),
(118, 2, 312, 81.96, 7),
(119, 2, 313, 63.61, 4),
(120, 2, 314, 35.49, 1),
(121, 2, 315, 12.08, 4),
(122, 2, 316, 21.68, 4),
(123, 2, 317, 96.07, 8),
(124, 2, 318, 42.88, 8),
(125, 2, 319, 49.09, 5),
(126, 2, 320, 35.32, 6),
(127, 2, 321, 56.28, 6),
(128, 2, 322, 5.99, 2),
(129, 2, 401, 46.7, 3),
(130, 2, 402, 80.26, 2),
(131, 2, 403, 13.44, 8),
(132, 2, 404, 92.08, 5),
(133, 2, 405, 99.29, 7),
(134, 2, 406, 64.13, 9),
(135, 2, 407, 88.66, 4),
(136, 2, 408, 15.05, 9),
(137, 2, 409, 89.1, 3),
(138, 2, 410, 72.32, 2),
(139, 2, 411, 22.58, 7),
(140, 2, 412, 2.18, 8),
(141, 2, 413, 95.29, 6),
(142, 2, 414, 98.85, 3),
(143, 2, 415, 8.75, 4),
(144, 2, 416, 47.82, 8),
(145, 2, 417, 48.1, 2),
(146, 2, 418, 8.6, 4),
(147, 2, 419, 18.73, 5),
(148, 2, 420, 8.9, 3),
(149, 2, 421, 82.55, 3),
(150, 2, 422, 74.55, 6),
(151, 2, 423, 12.64, 9),
(152, 2, 424, 88.15, 8),
(153, 2, 501, 20.61, 9),
(154, 2, 502, 76.12, 4),
(155, 2, 503, 42.83, 4),
(156, 2, 504, 33.97, 9),
(157, 2, 505, 46.25, 1),
(158, 2, 506, 12.35, 6),
(159, 2, 507, 67.91, 9),
(160, 2, 508, 31.19, 5),
(161, 2, 509, 56.29, 4),
(162, 3, 101, 91.7, 2),
(163, 3, 102, 27.42, 4),
(164, 3, 103, 14.31, 7),
(165, 3, 104, 18.42, 7),
(166, 3, 105, 28.05, 9),
(167, 3, 201, 41.91, 9),
(168, 3, 202, 73.28, 9),
(169, 3, 203, 89.21, 5),
(170, 3, 204, 84.38, 4),
(171, 3, 205, 40.55, 7),
(172, 3, 206, 5.19, 1),
(173, 3, 207, 76.7, 1),
(174, 3, 208, 36.27, 7),
(175, 3, 209, 1.3, 1),
(176, 3, 210, 15.27, 2),
(177, 3, 301, 72.35, 1),
(178, 3, 302, 75.17, 2),
(179, 3, 303, 57.62, 5),
(180, 3, 304, 0.16, 8),
(181, 3, 305, 72.91, 6),
(182, 3, 306, 35.99, 2),
(183, 3, 307, 45, 5),
(184, 3, 308, 78.58, 1),
(185, 3, 309, 31.31, 3),
(186, 3, 310, 7.5, 8),
(187, 3, 311, 7.96, 9),
(188, 3, 312, 31.27, 7),
(189, 3, 313, 87.05, 3),
(190, 3, 314, 39.04, 3),
(191, 3, 315, 59.72, 4),
(192, 3, 316, 66.64, 7),
(193, 3, 317, 2.92, 1),
(194, 3, 318, 97.89, 7),
(195, 3, 319, 49.74, 6),
(196, 3, 320, 30.49, 3),
(197, 3, 321, 49.89, 6),
(198, 3, 322, 31.07, 4),
(199, 3, 401, 4.9, 6),
(200, 3, 402, 95.17, 8),
(201, 3, 403, 6.06, 9),
(202, 3, 404, 52.87, 5),
(203, 3, 405, 38.43, 9),
(204, 3, 406, 11.2, 3),
(205, 3, 407, 8.33, 3),
(206, 3, 408, 15.22, 9);

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
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`Booking_NO`),
  ADD KEY `Room_ID` (`Room_ID`),
  ADD KEY `User_ID` (`User_ID`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `Booking_NO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `User_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `Hotel_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hotel_service`
--
ALTER TABLE `hotel_service`
  MODIFY `Service_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `Review_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `Room_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`Room_ID`) REFERENCES `room` (`Room_ID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

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
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`Hotel_ID`) REFERENCES `hotel` (`Hotel_ID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
