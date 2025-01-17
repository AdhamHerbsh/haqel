-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 05:15 PM
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
  `BUSINESS_SEGMENT` varchar(255) DEFAULT NULL,
  `COMMERCIAL_REGISTER_FILE` varchar(255) DEFAULT NULL,
  `USER_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`ID`, `BUSINESS_NAME`, `BUSINESS_EMAIL`, `BUSINESS_TYPE`, `BUSINESS_SEGMENT`, `COMMERCIAL_REGISTER_FILE`, `USER_ID`) VALUES
(1, 'ALWADY', 'wady@gmail.com', NULL, 'hypermarket', '../files/accounts/retailers/ALWADY-TEST.pdf', 1000),
(2, 'Taha Store', NULL, 'provider', NULL, '../files/accounts/wholesalers/TahaStore-TEST.pdf', 1001),
(3, 'Mohamed Group', 'mogo@gmail.com', NULL, 'juice', '../files/accounts/retailers/Mohamed Group-TEST 2.pdf', 1002),
(4, 'Z Store', NULL, 'provider', NULL, '../files/accounts/wholesalers/Z Store-TEST 2.pdf', 1003),
(5, 'POP STORE', 'sop@gm.gm', NULL, 'caffe', '../files/accounts/retailers/POP STORE-TEST 2.pdf', 1004),
(7, 'Twest', NULL, 'farm', NULL, NULL, 1006),
(8, 'KEMOO STORE', NULL, 'provider', NULL, '../files/accounts/wholesalers/KOKOKO-1735129360_TEST.pdf', 1007);

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `CID` int(11) NOT NULL,
  `CSENDER` int(11) NOT NULL,
  `CRECEIVER` int(11) NOT NULL,
  `CSOID` varchar(255) NOT NULL,
  `CMESSAGE` varchar(4000) NOT NULL,
  `CDATE` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`CID`, `CSENDER`, `CRECEIVER`, `CSOID`, `CMESSAGE`, `CDATE`) VALUES
(53, 1000, 1001, '20', 'HI', '2024-12-28 18:43:13'),
(54, 1001, 1000, '20', 'Hi', '2024-12-28 18:43:21'),
(55, 1000, 1001, '10001001', 'Hu', '2024-12-28 19:22:06'),
(56, 1004, 1001, '10041001', 'Hiii', '2024-12-28 19:34:33'),
(57, 1004, 1007, '22', 'Hii', '2024-12-31 09:32:07'),
(58, 1007, 1004, '22', 'Hello', '2024-12-31 09:32:21'),
(59, 1000, 1001, '10001001', 'asd', '2024-12-31 10:04:55'),
(60, 1000, 1003, '10001003', 'asd', '2024-12-31 10:04:59'),
(61, 1000, 1003, '10001003', 'asd', '2024-12-31 10:05:10'),
(62, 1000, 1003, '25', 'Hi', '2025-01-01 14:12:31'),
(63, 1000, 1003, '25', 'What is the status order', '2025-01-01 14:12:41'),
(64, 1003, 1000, '25', 'Is Good', '2025-01-01 14:13:09');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OID` int(11) NOT NULL,
  `ONUMBER` varchar(255) NOT NULL,
  `OTYPE` enum('standard','special') NOT NULL,
  `ODATE` date NOT NULL DEFAULT current_timestamp(),
  `OSTAGE` enum('','shipping','delivery','receive','received') NOT NULL,
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

INSERT INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OSCHEDULE`, `ODAYS`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
(20, 'ORD6772b16a947b0', 'standard', '2024-12-30', 'received', 'cash', 'personal_recevice', 'day', '', 20, 1000, 1001),
(21, 'ORD6772b16a95370', 'standard', '2024-12-30', 'received', 'cash', 'logistic_shipping', 'day', '', 50, 1000, 1003),
(22, 'ORD6773bfca3377c', 'standard', '2024-12-31', 'receive', 'cash', 'logistic_shipping', 'day', '', 20, 1000, 1001),
(23, 'ORD6773bfca34620', 'standard', '2024-12-31', 'received', 'cash', 'logistic_shipping', 'day', '', 50, 1000, 1003),
(24, 'ORD6773db9693bf1', 'standard', '2024-12-31', 'delivery', 'cash', 'logistic_shipping', 'day', '', 5200, 1000, 1001),
(25, 'ORD6773db9696609', 'standard', '2024-12-31', 'received', 'cash', 'logistic_shipping', 'day', '', 10000, 1000, 1003),
(26, 'ORD6774121a35808', 'standard', '2024-12-31', 'shipping', 'cash', 'logistic_shipping', 'day', '', 500, 1000, 1003),
(27, 'ORD67754c6cac1e2', 'standard', '2025-01-01', 'shipping', 'cash', 'logistic_shipping', 'day', '', 510, 1000, 1003),
(28, 'ORD67754dc1d8312', 'standard', '2025-01-01', 'received', 'cash', 'personal_recevice', 'day', '', 90, 1000, 1003),
(29, 'ORD67754e6e9f8d3', 'standard', '2025-01-01', 'shipping', 'cash', 'logistic_shipping', 'day', '', 100, 1000, 1003),
(30, 'ORD67754e6ea0591', 'standard', '2025-01-01', 'shipping', 'cash', 'logistic_shipping', 'day', '', 10000, 1000, 1001);

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
(33, 32, 20, 1, 20),
(34, 34, 21, 1, 50),
(35, 32, 22, 1, 20),
(36, 34, 23, 1, 50),
(37, 32, 24, 10, 20),
(38, 33, 24, 50, 100),
(39, 34, 25, 200, 50),
(40, 34, 26, 10, 50),
(41, 34, 27, 10, 50),
(42, 35, 27, 1, 10),
(43, 35, 28, 9, 10),
(44, 35, 29, 10, 10),
(45, 33, 30, 100, 100);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `PID` int(11) NOT NULL,
  `PNAME` varchar(255) NOT NULL,
  `PCATEGORY` varchar(255) NOT NULL,
  `PCOUNTRY` varchar(255) NOT NULL,
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

INSERT INTO `products` (`PID`, `PNAME`, `PCATEGORY`, `PCOUNTRY`, `PPRICE`, `PSTATUS`, `PKEYWORDS`, `PQUANTITY`, `PDESCRIPTION`, `PIMAGE`, `USER_ID`, `CREATED_DATE`) VALUES
(32, 'apple', 'fruits', 'Saudi Arabia', 20.00, 'unavailable', 'Good Organic', 0, 'Product Description', 'assets/img/fruits/apple.png', 1001, '2024-12-24 17:05:21'),
(33, 'cilantro', 'vegetables', 'Albania', 100.00, 'available', 'Delicuse', 100, 'Product Description', 'assets/img/vegetables/cilantro.png', 1001, '2024-12-24 19:39:42'),
(34, 'banana', 'fruits', 'South Sudan', 50.00, 'unavailable', 'Yellow Good', 0, 'Banana Product Description', 'assets/img/fruits/banana.png', 1003, '2024-12-28 14:20:20'),
(35, 'pomegranate', 'fruits', 'Saudi Arabia', 10.00, 'unavailable', 'Good', 0, 'ssss', 'assets/img/fruits/pomegranate.png', 1003, '2024-12-28 14:24:40'),
(36, 'apple', 'fruits', 'Afghanistan', 30.00, 'available', 'Good', 100, 'loprwem', 'assets/img/fruits/apple.png', 1003, '2024-12-28 14:29:34');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `ID` int(11) NOT NULL,
  `RSOID` int(11) NOT NULL,
  `RDATE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `RCONTRACT_FILE` varchar(4000) NOT NULL,
  `RSTATUS` enum('applied','rejected','unapplied') NOT NULL,
  `WS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`ID`, `RSOID`, `RDATE`, `RCONTRACT_FILE`, `RSTATUS`, `WS_ID`) VALUES
(15, 20, '2024-12-28 18:42:38', '../files/contracts/wholesalers/SORD6770465ecc4e7-TEST.pdf', 'applied', 1001),
(17, 22, '2024-12-31 09:25:41', '../files/contracts/wholesalers/SORD677052c23f333-TEST.pdf', 'unapplied', 1001),
(18, 21, '2024-12-31 09:28:36', '../files/contracts/wholesalers/SORD67704b2601ac0-TEST.pdf', 'unapplied', 1001),
(19, 22, '2024-12-31 09:31:27', '../files/contracts/wholesalers/SORD677052c23f333-TEST.pdf', 'applied', 1007),
(20, 21, '2024-12-31 09:43:28', '../files/contracts/wholesalers/SORD67704b2601ac0-TEST.pdf', 'applied', 1007),
(21, 23, '2024-12-31 10:04:21', '../files/contracts/wholesalers/SORD6773c1825b064-TEST.pdf', 'applied', 1003),
(23, 25, '2025-01-01 14:11:49', '../files/contracts/wholesalers/SORD67754cdb9e622-TEST.pdf', 'applied', 1003);

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
  `WS_ID` int(11) NOT NULL,
  `SODAYS` varchar(4000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `special_orders`
--

INSERT INTO `special_orders` (`SOID`, `SONUMBER`, `SOTYPE`, `SOSTATUS`, `PNAME`, `PCATEGORY`, `PPRICE`, `SOQUANTITY`, `SORECEIVEDDATE`, `SOSCHEDULEOPTION`, `SODESCRIPTION`, `SOTOTALPRICE`, `SODATE`, `CONTRACT_FILE`, `USER_ID`, `WS_ID`, `SODAYS`) VALUES
(20, 'SORD6770465ecc4e7', 'special', 'finished', 'apple', 'fruits', 100.00, 100, '2025-01-10', 'day', 'Order Desc', 10000, '2024-12-28 18:41:34', 'applied-SORD6770465ecc4e7-TEST 2.pdf', 1000, 1001, ''),
(21, 'SORD67704b2601ac0', 'special', 'finished', 'onion', 'vegetables', 20.00, 50, '2025-01-09', 'week', 'Special Order', 1000, '2024-12-28 19:01:58', 'applied-SORD67704b2601ac0-TEST 2.pdf', 1000, 1007, 'sunday, monday, thrusday'),
(22, 'SORD677052c23f333', 'special', 'finished', 'apple', 'fruits', 50.00, 50, '2025-01-15', 'day', 'Special Orders', 2500, '2024-12-28 19:34:26', 'applied-SORD677052c23f333-TEST 2.pdf', 1004, 1007, ''),
(23, 'SORD6773c1825b064', 'special', 'finished', 'mango', 'fruits', 20.00, 20, '2025-01-10', 'day', 'Special Order', 400, '2024-12-31 10:03:46', 'applied-SORD6773c1825b064-TEST 2.pdf', 1000, 1003, ''),
(24, 'SORD677407649075a', 'special', 'unapproved', 'mango', 'fruits', 50.00, 50, '2025-01-10', 'week', 'Special Order', 2500, '2024-12-31 15:01:56', '', 1000, 0, 'monday, thrusday'),
(25, 'SORD67754cdb9e622', 'special', 'finished', 'apple', 'fruits', 20.00, 20, '2025-01-29', 'day', 'Desc', 400, '2025-01-01 14:10:35', 'applied-SORD67754cdb9e622-TEST 2.pdf', 1000, 1003, '');

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
(1001, 'omarthhh@gmail.com', '$2y$10$b6MmakMLColLs9.j3HQ4K.bUMcWGzISeBmX2Og20Hvrm//.6woCom', 'Omar', 'Taha', '0123456789', 'wholesaler', '2024-12-13'),
(1002, 'mohww@gmail.com', '$2y$10$emnC/nPwNdfEeXrpuk3gOOnXKnbD1XlU1.xKBoKPtldTqNi9QNzvW', 'Mohamed', 'Kareem', '123456789', 'retailer', '2024-12-15'),
(1003, 'momm@gmail.com', '$2y$10$fBZ88qDCZDmPixQPbERQVOvslKqkEl1f4zNg6f9F46YlLBa.6H0iC', 'Mostafa', 'Mamdouh', '123456789', 'wholesaler', '2024-12-15'),
(1004, 'po2@gmail.com', '$2y$10$dB8eQ67phPyluJHsHa8IbeWrqT.8TJu/FiivxLGeJ5a64YPAZfDJi', 'POP', 'MOM', '123456', 'retailer', '2024-12-16'),
(1006, 't@t.com', '$2y$10$r/VFKtK/GsVCSgWJChmH2evpHAKtbMpoYge/RReC90r4NGfLK3Lva', 'Test', 'Test', '123456789', 'wholesaler', '2024-12-21'),
(1007, 'kariem@gmail.com', '$2y$10$P9uUVg8YVqcnHvLZHsqamuJzMdZ0Noj2KsZWhMPj0ySYYXHctVw6a', 'Kariem', 'Mohamed', '2999299', 'wholesaler', '2024-12-24');

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
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`ID`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `OIID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `PID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `RID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `special_orders`
--
ALTER TABLE `special_orders`
  MODIFY `SOID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1008;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
