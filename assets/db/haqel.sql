-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2024 at 02:48 PM
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
  `id` int(11) NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `business_email` varchar(255) DEFAULT NULL,
  `business_type` enum('farm','provider') DEFAULT NULL,
  `coverage_areas` varchar(255) DEFAULT NULL,
  `business_segment` varchar(255) DEFAULT NULL,
  `commercial_register_file` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `business_name`, `business_email`, `business_type`, `coverage_areas`, `business_segment`, `commercial_register_file`, `user_id`) VALUES
(1, 'LLLLL', 'POP@POP.OP', NULL, NULL, 'restaurant', '../files/accounts/retailers/LLLLL-1733222609_pledge4m.pdf', 4),
(2, 'WOW', NULL, 'provider', 'Rayid', NULL, '../files/accounts/wholesalers/WOW-AfriInnovate_business_plan.pdf', 5),
(3, 'KOOK', NULL, 'provider', 'EEEE', NULL, '../files/accounts/wholesalers/KOOK-pledge4m.pdf', 1001);

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
(6, 'apple', 'fruits', 20.00, 'available', '0', 10, '0', 'assets/img/fruits/apple.png', 5, '2024-12-08 12:05:06'),
(23, 'mango', 'fruits', 50.00, 'available', 'Yellow Semi-Green ', 100, 'Mango Organic From India', 'assets/img/fruits/mango.png', 5, '2024-12-08 19:47:12'),
(24, 'onion', 'vegetables', 5.00, 'available', 'Big Solid', 10, 'Organic', 'assets/img/vegetables/onion.png', 5, '2024-12-08 20:28:01');

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
(1, 'adham@gmail.com', '$2y$10$zNr/NmA0oc.VsTvSUtm90Of7aLGzCWh4qTnuChksCojY/o.9HJW0q', 'Adham', 'Mohamed', '12345678', 'wholesaler', '2024-12-01'),
(4, 're@re.re', '$2y$10$ZT5Om1iZDs5jExIu1da73eT9ham6OXOyHjRqaJ4t1PZ/GX.az4KEW', 'Retailer', 'AccountAccountttt', 'AccountAccountgg', 'retailer', '2024-12-02'),
(5, 'wh@wh.wh', '$2y$10$mC5hWMoGyaJqrCszm/HrK.mO8UUkdLefM6ywbqkPFxEKY0UGNiqmm', 'Wholesaler', 'Account', '123456', 'wholesaler', '2024-12-02'),
(999, 'admin@admin.com', '$2y$10$ZTjLzAv7GFUY8dKPFZpn3OEEGgGg1BiB/L/LRpwJLXylD09XZmMaa', 'admin', 'admin', '123456', 'admin', '0000-00-00'),
(1000, 'TT@TT.TT', '$2y$10$g432hN/DjnCePWwvk4gLN.f9YfPwzaJWwg95CGnMjjaHIAA0ZMvNy', 'TT', 'MM', '123456', 'wholesaler', '2024-12-03'),
(1001, 'TT@TL.TT', '$2y$10$XeOYpBoqem6PXqd5AS1dm.ANgbcK369gyr87rSLMZlqThCMzYuNbS', 'LLLL', 'LPLPLLOPI', '5566', 'wholesaler', '2024-12-03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`PID`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `PID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
