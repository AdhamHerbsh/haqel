-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 08:30 AM
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
-- Database: `haqel`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `ID` int(11) NOT NULL,
  `BUSINESS_NAME` varchar(255) NOT NULL,
  `BUSINESS_EMAIL` varchar(255) DEFAULT NULL,
  `BUSINESS_TYPE` enum('farm','provider') DEFAULT NULL,
  `COVERAGE_AREAS` varchar(255) DEFAULT NULL,
  `BUSINESS_SEGMENT` varchar(255) DEFAULT NULL,
  `COMMERCIAL_REGISTER_FILE` varchar(255) NOT NULL,
  `USER_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`ID`, `BUSINESS_NAME`, `BUSINESS_EMAIL`, `BUSINESS_TYPE`, `COVERAGE_AREAS`, `BUSINESS_SEGMENT`, `COMMERCIAL_REGISTER_FILE`, `USER_ID`) VALUES
(1, 'ALWADY', 'wady@gmail.com', NULL, NULL, 'hypermarket', '../files/accounts/retailers/ALWADY-TEST.pdf', 1000),
(2, 'Taha Store', NULL, 'provider', 'Al Dammam', NULL, '../files/accounts/wholesalers/TahaStore-TEST.pdf', 1001);

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `CID` int(11) NOT NULL,
  `CSENDER` int(11) NOT NULL,
  `CRECEIVER` int(11) NOT NULL,
  `CSONUMBER` varchar(255) NOT NULL,
  `CMESSAGE` varchar(4000) NOT NULL,
  `CDATE` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`CID`, `CSENDER`, `CRECEIVER`, `CSONUMBER`, `CMESSAGE`, `CDATE`) VALUES
(1, 1000, 1001, 'SORD675db53380e58', 'Ya Omar', '2024-12-14 17:25:34'),
(2, 1001, 1000, 'SORD675db53380e58', 'sadasd', '2024-12-14 17:36:07'),
(3, 1001, 1000, 'SORD675db53380e58', 'KK', '2024-12-14 17:44:14'),
(4, 1000, 1001, 'SORD675db53380e58', 'KKK', '2024-12-14 17:45:11'),
(5, 1000, 1001, 'SORD675db53380e58', '', '2024-12-14 17:45:31'),
(6, 1000, 1001, 'SORD675db53380e58', '', '2024-12-14 17:45:36'),
(7, 1000, 1001, 'SORD675db53380e58', 'Hello', '2024-12-14 17:48:35'),
(8, 1000, 1001, 'SORD675db53380e58', 'JJ', '2024-12-14 17:49:56'),
(9, 1000, 1001, 'SORD675db53380e58', 'Ya Omar', '2024-12-14 17:55:11'),
(10, 1000, 1001, 'SORD675db53380e58', 'Ya Omar', '2024-12-14 17:56:51'),
(11, 1000, 1001, 'SORD675db53380e58', 'HIII', '2024-12-14 17:58:23'),
(12, 1000, 1001, 'SORD675db53380e58', 'Hii', '2024-12-14 18:01:42'),
(13, 1000, 1001, 'SORD675db53380e58', 'sadasd', '2024-12-14 18:02:23'),
(14, 1000, 1001, 'SORD675db53380e58', 'Jo', '2024-12-14 18:03:02'),
(15, 1000, 1001, 'SORD675db53380e58', 'DD', '2024-12-14 18:03:27'),
(16, 1000, 1001, 'SORD675db53380e58', 'Ya Omar', '2024-12-14 18:04:39'),
(17, 1001, 1000, 'SORD675db53380e58', 'OK', '2024-12-14 18:06:30'),
(18, 1001, 1000, 'SORD675db53380e58', 'Hi', '2024-12-14 18:06:58'),
(19, 1000, 1001, 'SORD675db53380e58', 'HIII', '2024-12-14 18:09:20'),
(20, 1001, 1000, 'SORD675db53380e58', 'Ya Omar', '2024-12-14 18:09:30'),
(21, 1000, 1001, 'SORD675db53380e58', 'asd', '2024-12-14 18:14:44'),
(22, 1000, 1001, 'SORD675db53380e58', 'sadasd', '2024-12-14 18:22:37'),
(23, 1000, 1001, 'SORD675db53380e58', 'asd', '2024-12-14 18:22:48'),
(24, 1000, 1001, 'SORD675db53380e58', 'Ya Omar', '2024-12-14 18:24:05'),
(25, 1000, 1001, 'SORD675db53380e58', 'Ya Omar', '2024-12-14 18:24:09'),
(26, 1000, 1001, 'SORD675db53380e58', 'Ji', '2024-12-14 18:36:11'),
(27, 1000, 1001, 'SORD675db53380e58', 'أه', '2024-12-14 18:45:44'),
(28, 1000, 1001, 'SORD675db53380e58', 'HIII', '2024-12-14 18:51:21'),
(29, 1000, 1001, 'SORD675db53380e58', 'Ya Omar', '2024-12-14 18:52:17'),
(30, 1001, 1000, 'SORD675db53380e58', 'HIII', '2024-12-14 18:52:23'),
(31, 1001, 1000, 'SORD675db53380e58', 'JJJJJ', '2024-12-14 18:52:30'),
(32, 1000, 1001, 'SORD675db53380e58', 'Howowow', '2024-12-14 18:52:37'),
(33, 1000, 1001, 'SORD675c1f92864c1', 'Hi', '2024-12-14 22:55:34'),
(34, 1001, 1000, 'SORD675c1f92864c1', 'Hello', '2024-12-14 22:57:15');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OID` int(11) NOT NULL,
  `ONUMBER` varchar(255) NOT NULL,
  `OTYPE` enum('standard','special') NOT NULL,
  `ODATE` date NOT NULL DEFAULT current_timestamp(),
  `OSTATUS` enum('unapproved','approved','finished','closed') NOT NULL,
  `OSTAGE` enum('','shipping','delivery','receive','done') NOT NULL,
  `OPAYMETHOD` enum('cash','later','credit') NOT NULL,
  `ODELIVERY` enum('logistic_shipping','personal_recevice') NOT NULL,
  `OSCHEDULE` enum('day','week','month') NOT NULL,
  `ODAYS` varchar(4000) NOT NULL,
  `OTOTALPRICE` float NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `WS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTATUS`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OSCHEDULE`, `ODAYS`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
(1, 'ORD675c1df721241', 'standard', '2024-12-13', 'closed', 'done', 'later', 'logistic_shipping', 'week', 'one-time', 200, 1000, 1001),
(2, 'ORD675c77fbd0133', 'standard', '2024-12-13', 'approved', 'done', 'cash', 'personal_recevice', 'day', 'wensday, friday', 250, 1000, 1001);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `OIID` int(11) NOT NULL,
  `OIPID` int(11) NOT NULL,
  `OIOID` int(11) NOT NULL,
  `OIQUANTITY` int(11) NOT NULL,
  `OIPRICE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
(1, 6, 1, 10, 20),
(2, 23, 2, 5, 50);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `PID` int(11) NOT NULL,
  `PNAME` varchar(255) NOT NULL,
  `PCATEGORY` varchar(255) NOT NULL,
  `PPRICE` decimal(10,2) NOT NULL,
  `PSTATUS` enum('available','unavailable') DEFAULT 'available',
  `PKEYWORDS` text DEFAULT NULL,
  `PQUANTITY` int(11) NOT NULL,
  `PDESCRIPTION` text DEFAULT NULL,
  `PIMAGE` varchar(255) DEFAULT NULL,
  `USER_ID` int(11) NOT NULL,
  `CREATED_DATE` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`PID`, `PNAME`, `PCATEGORY`, `PPRICE`, `PSTATUS`, `PKEYWORDS`, `PQUANTITY`, `PDESCRIPTION`, `PIMAGE`, `USER_ID`, `CREATED_DATE`) VALUES
(6, 'apple', 'fruits', 20.00, 'available', '0', 10, '0', 'assets/img/fruits/apple.png', 1001, '2024-12-08 12:05:06'),
(23, 'mango', 'fruits', 50.00, 'unavailable', 'Yellow Semi-Green ', 1, 'Mango Organic From India', 'assets/img/fruits/mango.png', 1001, '2024-12-08 19:47:12'),
(24, 'onion', 'vegetables', 5.00, 'available', 'Big Solid', 10, 'Organic', 'assets/img/vegetables/onion.png', 1001, '2024-12-08 20:28:01');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `RID` int(11) NOT NULL,
  `RATE` int(11) NOT NULL,
  `MESSAGE` varchar(4000) NOT NULL,
  `RDATE` timestamp NOT NULL DEFAULT current_timestamp(),
  `OID` int(11) NOT NULL,
  `WS_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`RID`, `RATE`, `MESSAGE`, `RDATE`, `OID`, `WS_ID`, `USER_ID`) VALUES
(3, 5, 'Thanks', '2024-12-14 11:56:54', 1, 1001, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `special_orders`
--

CREATE TABLE `special_orders` (
  `SOID` int(11) NOT NULL,
  `SONUMBER` varchar(255) NOT NULL,
  `SOTYPE` varchar(50) NOT NULL,
  `SOSTATUS` enum('unapproved','approved','applied','finished','closed') DEFAULT NULL,
  `PNAME` varchar(100) NOT NULL,
  `PCATEGORY` varchar(50) NOT NULL,
  `PPRICE` decimal(10,2) NOT NULL,
  `SOQUANTITY` int(11) NOT NULL,
  `SORECEIVEDDATE` date NOT NULL,
  `SOSCHEDULEOPTION` enum('day','week','month') NOT NULL,
  `SODESCRIPTION` text DEFAULT NULL,
  `SOTOTALPRICE` float NOT NULL,
  `SODATE` timestamp NOT NULL DEFAULT current_timestamp(),
  `CONTRACT_FILE` varchar(4000) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `WS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `special_orders`
--

INSERT INTO `special_orders` (`SOID`, `SONUMBER`, `SOTYPE`, `SOSTATUS`, `PNAME`, `PCATEGORY`, `PPRICE`, `SOQUANTITY`, `SORECEIVEDDATE`, `SOSCHEDULEOPTION`, `SODESCRIPTION`, `SOTOTALPRICE`, `SODATE`, `CONTRACT_FILE`, `USER_ID`, `WS_ID`) VALUES
(1, 'SORD675c1f92864c1', 'special', 'applied', 'apple', 'fruits', 20.00, 20, '2025-01-11', 'week', 'Special Order Description', 400, '2024-12-13 11:50:42', '../files/contracts/wholesalers/SORD675c1f92864c1-TEST.pdf', 1000, 1001),
(2, 'SORD675db53380e58', 'special', 'applied', 'watermelon', 'fruits', 100.00, 5, '2024-12-28', 'day', 'Special Product', 500, '2024-12-14 16:41:23', '../files/contracts/wholesalers/SORD675db53380e58-SORD675c1f92864c1-TEST.pdf', 1000, 1001);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `FNAME` varchar(50) NOT NULL,
  `LNAME` varchar(50) NOT NULL,
  `PHONE` varchar(20) NOT NULL,
  `USER_TYPE` varchar(50) NOT NULL,
  `CREATED_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `USERNAME`, `PASSWORD`, `FNAME`, `LNAME`, `PHONE`, `USER_TYPE`, `CREATED_DATE`) VALUES
(999, 'admin@admin.com', '$2y$10$ZTjLzAv7GFUY8dKPFZpn3OEEGgGg1BiB/L/LRpwJLXylD09XZmMaa', 'admin', 'admin', '123456', 'admin', '0000-00-00'),
(1000, 'adham@gmail.com', '$2y$10$NpeMMUJNAV/U6FM.4VtUCOYFNoqHCIKQeEzNCltYwsd3TjSMNx9fG', 'adham', 'mohamed', '123456789', 'retailer', '2024-12-13'),
(1001, 'omarthhh@gmail.com', '$2y$10$b6MmakMLColLs9.j3HQ4K.bUMcWGzISeBmX2Og20Hvrm//.6woCom', 'Omar', 'Taha', '0123456789', 'wholesaler', '2024-12-13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`CID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`OIID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`PID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`RID`);

--
-- Indexes for table `special_orders`
--
ALTER TABLE `special_orders`
  ADD PRIMARY KEY (`SOID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `OIID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `PID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `RID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `special_orders`
--
ALTER TABLE `special_orders`
  MODIFY `SOID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1002;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
