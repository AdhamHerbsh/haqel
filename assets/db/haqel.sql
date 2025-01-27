-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for haqel
CREATE DATABASE IF NOT EXISTS `haqel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `haqel`;

-- Dumping structure for table haqel.account
CREATE TABLE IF NOT EXISTS `account` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `BUSINESS_NAME` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `BUSINESS_EMAIL` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `BUSINESS_TYPE` enum('farm','provider') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `BUSINESS_SEGMENT` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `COMMERCIAL_REGISTER_FILE` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `USER_ID` int NOT NULL,
  `RATE` int DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table haqel.account: ~7 rows (approximately)
INSERT IGNORE INTO `account` (`ID`, `BUSINESS_NAME`, `BUSINESS_EMAIL`, `BUSINESS_TYPE`, `BUSINESS_SEGMENT`, `COMMERCIAL_REGISTER_FILE`, `USER_ID`, `RATE`) VALUES
	(1, 'ALWADY', 'wady@gmail.com', NULL, 'hypermarket', '../files/accounts/retailers/ALWADY-TEST.pdf', 1000, 0);
INSERT IGNORE INTO `account` (`ID`, `BUSINESS_NAME`, `BUSINESS_EMAIL`, `BUSINESS_TYPE`, `BUSINESS_SEGMENT`, `COMMERCIAL_REGISTER_FILE`, `USER_ID`, `RATE`) VALUES
	(2, 'Taha Store', NULL, 'provider', NULL, '../files/accounts/wholesalers/TahaStore-TEST.pdf', 1001, 4);
INSERT IGNORE INTO `account` (`ID`, `BUSINESS_NAME`, `BUSINESS_EMAIL`, `BUSINESS_TYPE`, `BUSINESS_SEGMENT`, `COMMERCIAL_REGISTER_FILE`, `USER_ID`, `RATE`) VALUES
	(3, 'Mohamed Group', 'mogo@gmail.com', NULL, 'juice', '../files/accounts/retailers/Mohamed Group-TEST 2.pdf', 1002, 0);
INSERT IGNORE INTO `account` (`ID`, `BUSINESS_NAME`, `BUSINESS_EMAIL`, `BUSINESS_TYPE`, `BUSINESS_SEGMENT`, `COMMERCIAL_REGISTER_FILE`, `USER_ID`, `RATE`) VALUES
	(4, 'Z Store', NULL, 'provider', NULL, '../files/accounts/wholesalers/Z Store-TEST 2.pdf', 1003, 0);
INSERT IGNORE INTO `account` (`ID`, `BUSINESS_NAME`, `BUSINESS_EMAIL`, `BUSINESS_TYPE`, `BUSINESS_SEGMENT`, `COMMERCIAL_REGISTER_FILE`, `USER_ID`, `RATE`) VALUES
	(5, 'POP STORE', 'sop@gm.gm', NULL, 'caffe', '../files/accounts/retailers/POP STORE-TEST 2.pdf', 1004, 0);
INSERT IGNORE INTO `account` (`ID`, `BUSINESS_NAME`, `BUSINESS_EMAIL`, `BUSINESS_TYPE`, `BUSINESS_SEGMENT`, `COMMERCIAL_REGISTER_FILE`, `USER_ID`, `RATE`) VALUES
	(7, 'Twest', NULL, 'farm', NULL, NULL, 1006, 0);
INSERT IGNORE INTO `account` (`ID`, `BUSINESS_NAME`, `BUSINESS_EMAIL`, `BUSINESS_TYPE`, `BUSINESS_SEGMENT`, `COMMERCIAL_REGISTER_FILE`, `USER_ID`, `RATE`) VALUES
	(8, 'KEMOO STORE', NULL, 'provider', NULL, '../files/accounts/wholesalers/KOKOKO-1735129360_TEST.pdf', 1007, 0);

-- Dumping structure for table haqel.chats
CREATE TABLE IF NOT EXISTS `chats` (
  `CID` int NOT NULL AUTO_INCREMENT,
  `CSENDER` int NOT NULL,
  `CRECEIVER` int NOT NULL,
  `CSOID` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `CMESSAGE` varchar(4000) COLLATE utf8mb4_general_ci NOT NULL,
  `CDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`CID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table haqel.chats: ~11 rows (approximately)
INSERT IGNORE INTO `chats` (`CID`, `CSENDER`, `CRECEIVER`, `CSOID`, `CMESSAGE`, `CDATE`) VALUES
	(1, 1000, 1001, '10001001', 'Ya Omar', '2025-01-20 15:44:16');
INSERT IGNORE INTO `chats` (`CID`, `CSENDER`, `CRECEIVER`, `CSOID`, `CMESSAGE`, `CDATE`) VALUES
	(2, 1000, 1001, '10001001', 'Ya Omar', '2025-01-20 15:44:33');
INSERT IGNORE INTO `chats` (`CID`, `CSENDER`, `CRECEIVER`, `CSOID`, `CMESSAGE`, `CDATE`) VALUES
	(3, 1000, 1001, '10001001', 'Ya Omar', '2025-01-20 15:44:35');
INSERT IGNORE INTO `chats` (`CID`, `CSENDER`, `CRECEIVER`, `CSOID`, `CMESSAGE`, `CDATE`) VALUES
	(4, 1000, 1003, '10001003', 'Ya Omar', '2025-01-20 15:45:18');
INSERT IGNORE INTO `chats` (`CID`, `CSENDER`, `CRECEIVER`, `CSOID`, `CMESSAGE`, `CDATE`) VALUES
	(5, 1000, 1003, '10001003', 'Ya Omar', '2025-01-20 15:46:12');
INSERT IGNORE INTO `chats` (`CID`, `CSENDER`, `CRECEIVER`, `CSOID`, `CMESSAGE`, `CDATE`) VALUES
	(6, 1000, 1003, '10001003', 'Ya Omar', '2025-01-20 15:46:21');
INSERT IGNORE INTO `chats` (`CID`, `CSENDER`, `CRECEIVER`, `CSOID`, `CMESSAGE`, `CDATE`) VALUES
	(7, 1000, 1003, '10001003', 'ad', '2025-01-20 15:47:29');
INSERT IGNORE INTO `chats` (`CID`, `CSENDER`, `CRECEIVER`, `CSOID`, `CMESSAGE`, `CDATE`) VALUES
	(8, 1000, 1003, '10001003', 'asd', '2025-01-20 15:47:32');
INSERT IGNORE INTO `chats` (`CID`, `CSENDER`, `CRECEIVER`, `CSOID`, `CMESSAGE`, `CDATE`) VALUES
	(9, 1003, 1000, '10001003', 'FF', '2025-01-20 15:47:41');
INSERT IGNORE INTO `chats` (`CID`, `CSENDER`, `CRECEIVER`, `CSOID`, `CMESSAGE`, `CDATE`) VALUES
	(10, 1000, 1003, '10001003', 'Ya Omar', '2025-01-20 15:47:50');
INSERT IGNORE INTO `chats` (`CID`, `CSENDER`, `CRECEIVER`, `CSOID`, `CMESSAGE`, `CDATE`) VALUES
	(11, 1000, 1003, '10001003', 'Ya Omar', '2025-01-20 15:47:55');

-- Dumping structure for table haqel.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `OID` int NOT NULL AUTO_INCREMENT,
  `ONUMBER` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `OTYPE` enum('standard','special') COLLATE utf8mb4_general_ci NOT NULL,
  `ODATE` date NOT NULL,
  `OSTAGE` enum('','shipping','delivery','receive','received') COLLATE utf8mb4_general_ci NOT NULL,
  `OPAYMETHOD` enum('cash','later','credit') COLLATE utf8mb4_general_ci NOT NULL,
  `ODELIVERY` enum('logistic_shipping','personal_recevice') COLLATE utf8mb4_general_ci NOT NULL,
  `OTOTALPRICE` float NOT NULL,
  `USER_ID` int NOT NULL,
  `WS_ID` int NOT NULL,
  PRIMARY KEY (`OID`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table haqel.orders: ~14 rows (approximately)
INSERT IGNORE INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
	(35, 'ORD678d366dd2fca', 'standard', '2025-01-19', 'received', 'cash', 'logistic_shipping', 20, 1000, 1001);
INSERT IGNORE INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
	(36, 'ORD678d368436593', 'standard', '2025-01-19', 'received', 'cash', 'logistic_shipping', 100, 1000, 1001);
INSERT IGNORE INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
	(38, 'ORD678d36f242fdd', 'standard', '2025-01-19', 'shipping', 'cash', 'logistic_shipping', 580, 1000, 1001);
INSERT IGNORE INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
	(39, 'ORD678d7f61828aa', 'standard', '2025-01-19', 'shipping', 'cash', 'logistic_shipping', 2910, 1000, 1003);
INSERT IGNORE INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
	(40, 'ORD678d830dca219', 'standard', '2025-01-19', 'shipping', 'cash', 'logistic_shipping', 20, 1000, 1001);
INSERT IGNORE INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
	(41, 'ORD678d8339699e5', 'standard', '2025-01-19', 'shipping', 'cash', 'logistic_shipping', 20, 1000, 1001);
INSERT IGNORE INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
	(42, 'ORD678d834e9c0ba', 'standard', '2025-01-19', 'received', 'cash', 'logistic_shipping', 100, 1000, 1001);
INSERT IGNORE INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
	(43, 'ORD678d8fef527c7', 'standard', '2025-01-19', 'shipping', 'cash', 'logistic_shipping', 1000, 1000, 1001);
INSERT IGNORE INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
	(44, 'ORD678d901e8c931', 'standard', '2025-01-19', 'shipping', 'cash', 'logistic_shipping', 860, 1000, 1001);
INSERT IGNORE INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
	(45, 'ORD678d90a174c66', 'standard', '2025-01-19', 'shipping', 'cash', 'logistic_shipping', 100, 1000, 1001);
INSERT IGNORE INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
	(46, 'ORD678d9107103b0', 'standard', '2025-01-19', 'shipping', 'cash', 'logistic_shipping', 20, 1000, 1001);
INSERT IGNORE INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
	(47, 'ORD678d911b2d12f', 'standard', '2025-01-19', 'shipping', 'cash', 'logistic_shipping', 20, 1000, 1001);
INSERT IGNORE INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
	(48, 'ORD678da42c3da7b', 'standard', '2025-01-20', 'received', 'cash', 'logistic_shipping', 400, 1000, 1001);
INSERT IGNORE INTO `orders` (`OID`, `ONUMBER`, `OTYPE`, `ODATE`, `OSTAGE`, `OPAYMETHOD`, `ODELIVERY`, `OTOTALPRICE`, `USER_ID`, `WS_ID`) VALUES
	(49, 'ORD678da5ef9ac9d', 'standard', '2025-01-20', 'received', 'cash', 'logistic_shipping', 1000, 1000, 1001);

-- Dumping structure for table haqel.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `OIID` int NOT NULL AUTO_INCREMENT,
  `OIPID` int NOT NULL,
  `OIOID` int NOT NULL,
  `OIQUANTITY` int NOT NULL,
  `OIPRICE` int NOT NULL,
  PRIMARY KEY (`OIID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table haqel.order_items: ~14 rows (approximately)
INSERT IGNORE INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
	(5, 32, 35, 1, 20);
INSERT IGNORE INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
	(6, 33, 36, 1, 100);
INSERT IGNORE INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
	(8, 32, 38, 29, 20);
INSERT IGNORE INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
	(9, 36, 39, 97, 30);
INSERT IGNORE INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
	(10, 32, 40, 1, 20);
INSERT IGNORE INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
	(11, 32, 41, 1, 20);
INSERT IGNORE INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
	(12, 32, 42, 5, 20);
INSERT IGNORE INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
	(13, 32, 43, 50, 20);
INSERT IGNORE INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
	(14, 32, 44, 43, 20);
INSERT IGNORE INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
	(15, 32, 45, 5, 20);
INSERT IGNORE INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
	(16, 32, 46, 1, 20);
INSERT IGNORE INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
	(17, 32, 47, 1, 20);
INSERT IGNORE INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
	(18, 1, 48, 2, 200);
INSERT IGNORE INTO `order_items` (`OIID`, `OIPID`, `OIOID`, `OIQUANTITY`, `OIPRICE`) VALUES
	(19, 1, 49, 5, 200);

-- Dumping structure for table haqel.products
CREATE TABLE IF NOT EXISTS `products` (
  `PID` int NOT NULL AUTO_INCREMENT,
  `PNAME` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `PCATEGORY` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `PCOUNTRY` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `PPRICE` decimal(10,2) NOT NULL,
  `PSTATUS` enum('available','unavailable') COLLATE utf8mb4_general_ci DEFAULT 'available',
  `PKEYWORDS` text COLLATE utf8mb4_general_ci,
  `PQUANTITY` int NOT NULL,
  `PDESCRIPTION` text COLLATE utf8mb4_general_ci,
  `PIMAGE` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `USER_ID` int NOT NULL,
  `CREATED_DATE` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`PID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table haqel.products: ~6 rows (approximately)
INSERT IGNORE INTO `products` (`PID`, `PNAME`, `PCATEGORY`, `PCOUNTRY`, `PPRICE`, `PSTATUS`, `PKEYWORDS`, `PQUANTITY`, `PDESCRIPTION`, `PIMAGE`, `USER_ID`, `CREATED_DATE`) VALUES
	(1, 'watermelon', 'fruits', 'Albania', 200.00, 'available', 'Big', 93, 'Watermelon Desc', 'assets/img/fruits/watermelon.png', 1001, '2025-01-20 02:47:50');
INSERT IGNORE INTO `products` (`PID`, `PNAME`, `PCATEGORY`, `PCOUNTRY`, `PPRICE`, `PSTATUS`, `PKEYWORDS`, `PQUANTITY`, `PDESCRIPTION`, `PIMAGE`, `USER_ID`, `CREATED_DATE`) VALUES
	(32, 'apple', 'fruits', 'Saudi Arabia', 20.00, 'available', 'Good Organic', 3, 'Product Description', 'assets/img/fruits/apple.png', 1001, '2024-12-24 17:05:21');
INSERT IGNORE INTO `products` (`PID`, `PNAME`, `PCATEGORY`, `PCOUNTRY`, `PPRICE`, `PSTATUS`, `PKEYWORDS`, `PQUANTITY`, `PDESCRIPTION`, `PIMAGE`, `USER_ID`, `CREATED_DATE`) VALUES
	(33, 'cilantro', 'vegetables', 'Albania', 100.00, 'unavailable', 'Delicuse', 0, 'Product Description', 'assets/img/vegetables/cilantro.png', 1001, '2024-12-24 19:39:42');
INSERT IGNORE INTO `products` (`PID`, `PNAME`, `PCATEGORY`, `PCOUNTRY`, `PPRICE`, `PSTATUS`, `PKEYWORDS`, `PQUANTITY`, `PDESCRIPTION`, `PIMAGE`, `USER_ID`, `CREATED_DATE`) VALUES
	(34, 'banana', 'fruits', 'South Sudan', 50.00, 'unavailable', 'Yellow Good', 0, 'Banana Product Description', 'assets/img/fruits/banana.png', 1003, '2024-12-28 14:20:20');
INSERT IGNORE INTO `products` (`PID`, `PNAME`, `PCATEGORY`, `PCOUNTRY`, `PPRICE`, `PSTATUS`, `PKEYWORDS`, `PQUANTITY`, `PDESCRIPTION`, `PIMAGE`, `USER_ID`, `CREATED_DATE`) VALUES
	(35, 'pomegranate', 'fruits', 'Saudi Arabia', 10.00, 'unavailable', 'Good', 0, 'ssss', 'assets/img/fruits/pomegranate.png', 1003, '2024-12-28 14:24:40');
INSERT IGNORE INTO `products` (`PID`, `PNAME`, `PCATEGORY`, `PCOUNTRY`, `PPRICE`, `PSTATUS`, `PKEYWORDS`, `PQUANTITY`, `PDESCRIPTION`, `PIMAGE`, `USER_ID`, `CREATED_DATE`) VALUES
	(36, 'apple', 'fruits', 'Afghanistan', 30.00, 'unavailable', 'Good', 0, 'loprwem', 'assets/img/fruits/apple.png', 1003, '2024-12-28 14:29:34');

-- Dumping structure for table haqel.requests
CREATE TABLE IF NOT EXISTS `requests` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `RSOID` int NOT NULL,
  `RDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `RCONTRACT_FILE` varchar(4000) COLLATE utf8mb4_general_ci NOT NULL,
  `RSTATUS` enum('applied','rejected','unapplied') COLLATE utf8mb4_general_ci NOT NULL,
  `WS_ID` int NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table haqel.requests: ~10 rows (approximately)
INSERT IGNORE INTO `requests` (`ID`, `RSOID`, `RDATE`, `RCONTRACT_FILE`, `RSTATUS`, `WS_ID`) VALUES
	(3, 27, '2025-01-20 11:34:24', '../files/contracts/wholesalers/SORD678a79f7c8120-TEST.pdf', 'applied', 1001);
INSERT IGNORE INTO `requests` (`ID`, `RSOID`, `RDATE`, `RCONTRACT_FILE`, `RSTATUS`, `WS_ID`) VALUES
	(4, 28, '2025-01-20 11:48:33', '../files/contracts/wholesalers/SORD678ca89566c00-TEST.pdf', 'applied', 1001);
INSERT IGNORE INTO `requests` (`ID`, `RSOID`, `RDATE`, `RCONTRACT_FILE`, `RSTATUS`, `WS_ID`) VALUES
	(5, 29, '2025-01-20 14:10:41', '../files/contracts/wholesalers/SORD678e385380b48-TEST.pdf', 'unapplied', 1001);
INSERT IGNORE INTO `requests` (`ID`, `RSOID`, `RDATE`, `RCONTRACT_FILE`, `RSTATUS`, `WS_ID`) VALUES
	(15, 20, '2024-12-28 18:42:38', '../files/contracts/wholesalers/SORD6770465ecc4e7-TEST.pdf', 'applied', 1001);
INSERT IGNORE INTO `requests` (`ID`, `RSOID`, `RDATE`, `RCONTRACT_FILE`, `RSTATUS`, `WS_ID`) VALUES
	(17, 22, '2024-12-31 09:25:41', '../files/contracts/wholesalers/SORD677052c23f333-TEST.pdf', 'unapplied', 1001);
INSERT IGNORE INTO `requests` (`ID`, `RSOID`, `RDATE`, `RCONTRACT_FILE`, `RSTATUS`, `WS_ID`) VALUES
	(18, 21, '2024-12-31 09:28:36', '../files/contracts/wholesalers/SORD67704b2601ac0-TEST.pdf', 'unapplied', 1001);
INSERT IGNORE INTO `requests` (`ID`, `RSOID`, `RDATE`, `RCONTRACT_FILE`, `RSTATUS`, `WS_ID`) VALUES
	(19, 22, '2024-12-31 09:31:27', '../files/contracts/wholesalers/SORD677052c23f333-TEST.pdf', 'applied', 1007);
INSERT IGNORE INTO `requests` (`ID`, `RSOID`, `RDATE`, `RCONTRACT_FILE`, `RSTATUS`, `WS_ID`) VALUES
	(20, 21, '2024-12-31 09:43:28', '../files/contracts/wholesalers/SORD67704b2601ac0-TEST.pdf', 'applied', 1007);
INSERT IGNORE INTO `requests` (`ID`, `RSOID`, `RDATE`, `RCONTRACT_FILE`, `RSTATUS`, `WS_ID`) VALUES
	(21, 23, '2024-12-31 10:04:21', '../files/contracts/wholesalers/SORD6773c1825b064-TEST.pdf', 'applied', 1003);
INSERT IGNORE INTO `requests` (`ID`, `RSOID`, `RDATE`, `RCONTRACT_FILE`, `RSTATUS`, `WS_ID`) VALUES
	(23, 25, '2025-01-01 14:11:49', '../files/contracts/wholesalers/SORD67754cdb9e622-TEST.pdf', 'applied', 1003);

-- Dumping structure for table haqel.reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `RID` int NOT NULL AUTO_INCREMENT,
  `RATE` int NOT NULL,
  `MESSAGE` varchar(4000) COLLATE utf8mb4_general_ci NOT NULL,
  `RDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `OID` int NOT NULL,
  `WS_ID` int NOT NULL,
  `USER_ID` int NOT NULL,
  PRIMARY KEY (`RID`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table haqel.reviews: ~5 rows (approximately)
INSERT IGNORE INTO `reviews` (`RID`, `RATE`, `MESSAGE`, `RDATE`, `OID`, `WS_ID`, `USER_ID`) VALUES
	(21, 5, 'Nice', '2025-01-20 00:05:25', 48, 1001, 1000);
INSERT IGNORE INTO `reviews` (`RID`, `RATE`, `MESSAGE`, `RDATE`, `OID`, `WS_ID`, `USER_ID`) VALUES
	(22, 5, 'FFF', '2025-01-20 00:11:20', 35, 1001, 1000);
INSERT IGNORE INTO `reviews` (`RID`, `RATE`, `MESSAGE`, `RDATE`, `OID`, `WS_ID`, `USER_ID`) VALUES
	(23, 5, 'GG', '2025-01-20 00:11:45', 36, 1001, 1000);
INSERT IGNORE INTO `reviews` (`RID`, `RATE`, `MESSAGE`, `RDATE`, `OID`, `WS_ID`, `USER_ID`) VALUES
	(24, 5, 'FF', '2025-01-20 00:12:41', 49, 1001, 1000);
INSERT IGNORE INTO `reviews` (`RID`, `RATE`, `MESSAGE`, `RDATE`, `OID`, `WS_ID`, `USER_ID`) VALUES
	(25, 1, 'DD', '2025-01-20 00:14:25', 42, 1001, 1000);

-- Dumping structure for table haqel.special_orders
CREATE TABLE IF NOT EXISTS `special_orders` (
  `SOID` int NOT NULL AUTO_INCREMENT,
  `SONUMBER` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `SOTYPE` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `SOSTATUS` enum('unapproved','approved','applied','finished','closed') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PNAME` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `PCATEGORY` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `PPRICE` decimal(10,2) NOT NULL,
  `SOQUANTITY` int NOT NULL,
  `SOSTARTDATE` date NOT NULL,
  `SOENDDATE` date NOT NULL,
  `SOSCHEDULEOPTION` enum('day','week','onetime') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `SODAYS` varchar(4000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `SODESCRIPTION` text COLLATE utf8mb4_general_ci,
  `SOTOTALPRICE` float NOT NULL,
  `SODATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CONTRACT_FILE` varchar(4000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `USER_ID` int NOT NULL,
  `WS_ID` int DEFAULT NULL,
  PRIMARY KEY (`SOID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table haqel.special_orders: ~4 rows (approximately)
INSERT IGNORE INTO `special_orders` (`SOID`, `SONUMBER`, `SOTYPE`, `SOSTATUS`, `PNAME`, `PCATEGORY`, `PPRICE`, `SOQUANTITY`, `SOSTARTDATE`, `SOENDDATE`, `SOSCHEDULEOPTION`, `SODAYS`, `SODESCRIPTION`, `SOTOTALPRICE`, `SODATE`, `CONTRACT_FILE`, `USER_ID`, `WS_ID`) VALUES
	(26, 'SORD678a78585b0a4', 'special', 'unapproved', 'apple', 'fruits', 120.00, 120, '2025-01-17', '2025-02-08', 'week', 'sunday, thrusday', 'Special Order Description', 14400, '2025-01-17 15:33:44', NULL, 1000, NULL);
INSERT IGNORE INTO `special_orders` (`SOID`, `SONUMBER`, `SOTYPE`, `SOSTATUS`, `PNAME`, `PCATEGORY`, `PPRICE`, `SOQUANTITY`, `SOSTARTDATE`, `SOENDDATE`, `SOSCHEDULEOPTION`, `SODAYS`, `SODESCRIPTION`, `SOTOTALPRICE`, `SODATE`, `CONTRACT_FILE`, `USER_ID`, `WS_ID`) VALUES
	(27, 'SORD678a79f7c8120', 'special', 'finished', 'green-papper', 'vegetables', 30.00, 13, '2025-01-24', '2025-02-08', 'week', 'saturday, wensday', 'Special Order Description', 390, '2025-01-17 15:40:39', 'applied-SORD678a79f7c8120-TEST 2.pdf', 1000, 1001);
INSERT IGNORE INTO `special_orders` (`SOID`, `SONUMBER`, `SOTYPE`, `SOSTATUS`, `PNAME`, `PCATEGORY`, `PPRICE`, `SOQUANTITY`, `SOSTARTDATE`, `SOENDDATE`, `SOSCHEDULEOPTION`, `SODAYS`, `SODESCRIPTION`, `SOTOTALPRICE`, `SODATE`, `CONTRACT_FILE`, `USER_ID`, `WS_ID`) VALUES
	(28, 'SORD678ca89566c00', 'special', 'applied', 'watermelon', 'fruits', 5000.00, 20, '2025-01-20', '2025-02-20', 'onetime', '', 'Special Order Description', 100000, '2025-01-19 07:24:05', 'applied-SORD678ca89566c00-TEST 2.pdf', 1000, 1001);
INSERT IGNORE INTO `special_orders` (`SOID`, `SONUMBER`, `SOTYPE`, `SOSTATUS`, `PNAME`, `PCATEGORY`, `PPRICE`, `SOQUANTITY`, `SOSTARTDATE`, `SOENDDATE`, `SOSCHEDULEOPTION`, `SODAYS`, `SODESCRIPTION`, `SOTOTALPRICE`, `SODATE`, `CONTRACT_FILE`, `USER_ID`, `WS_ID`) VALUES
	(29, 'SORD678e385380b48', 'special', 'unapproved', 'mango', 'fruits', 30.00, 10, '2025-01-20', '2025-01-25', 'week', 'sunday, friday', 'Special Order', 300, '2025-01-20 11:49:39', NULL, 1000, NULL);

-- Dumping structure for table haqel.users
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `PASSWORD` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `FNAME` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `LNAME` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `PHONE` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `USER_TYPE` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `CREATED_DATE` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table haqel.users: ~8 rows (approximately)
INSERT IGNORE INTO `users` (`ID`, `USERNAME`, `PASSWORD`, `FNAME`, `LNAME`, `PHONE`, `USER_TYPE`, `CREATED_DATE`) VALUES
	(999, 'admin@admin.com', '$2y$10$ZTjLzAv7GFUY8dKPFZpn3OEEGgGg1BiB/L/LRpwJLXylD09XZmMaa', 'admin', 'admin', '123456', 'admin', '2024-12-02');
INSERT IGNORE INTO `users` (`ID`, `USERNAME`, `PASSWORD`, `FNAME`, `LNAME`, `PHONE`, `USER_TYPE`, `CREATED_DATE`) VALUES
	(1000, 'adham@gmail.com', '$2y$10$NpeMMUJNAV/U6FM.4VtUCOYFNoqHCIKQeEzNCltYwsd3TjSMNx9fG', 'adham', 'mohamed', '123456789', 'retailer', '2024-12-13');
INSERT IGNORE INTO `users` (`ID`, `USERNAME`, `PASSWORD`, `FNAME`, `LNAME`, `PHONE`, `USER_TYPE`, `CREATED_DATE`) VALUES
	(1001, 'omarthhh@gmail.com', '$2y$10$b6MmakMLColLs9.j3HQ4K.bUMcWGzISeBmX2Og20Hvrm//.6woCom', 'Omar', 'Taha', '0123456789', 'wholesaler', '2024-12-13');
INSERT IGNORE INTO `users` (`ID`, `USERNAME`, `PASSWORD`, `FNAME`, `LNAME`, `PHONE`, `USER_TYPE`, `CREATED_DATE`) VALUES
	(1002, 'mohww@gmail.com', '$2y$10$emnC/nPwNdfEeXrpuk3gOOnXKnbD1XlU1.xKBoKPtldTqNi9QNzvW', 'Mohamed', 'Kareem', '123456789', 'retailer', '2024-12-15');
INSERT IGNORE INTO `users` (`ID`, `USERNAME`, `PASSWORD`, `FNAME`, `LNAME`, `PHONE`, `USER_TYPE`, `CREATED_DATE`) VALUES
	(1003, 'momm@gmail.com', '$2y$10$fBZ88qDCZDmPixQPbERQVOvslKqkEl1f4zNg6f9F46YlLBa.6H0iC', 'Mostafa', 'Mamdouh', '123456789', 'wholesaler', '2024-12-15');
INSERT IGNORE INTO `users` (`ID`, `USERNAME`, `PASSWORD`, `FNAME`, `LNAME`, `PHONE`, `USER_TYPE`, `CREATED_DATE`) VALUES
	(1004, 'po2@gmail.com', '$2y$10$dB8eQ67phPyluJHsHa8IbeWrqT.8TJu/FiivxLGeJ5a64YPAZfDJi', 'POP', 'MOM', '123456', 'retailer', '2024-12-16');
INSERT IGNORE INTO `users` (`ID`, `USERNAME`, `PASSWORD`, `FNAME`, `LNAME`, `PHONE`, `USER_TYPE`, `CREATED_DATE`) VALUES
	(1006, 't@t.com', '$2y$10$r/VFKtK/GsVCSgWJChmH2evpHAKtbMpoYge/RReC90r4NGfLK3Lva', 'Test', 'Test', '123456789', 'wholesaler', '2024-12-21');
INSERT IGNORE INTO `users` (`ID`, `USERNAME`, `PASSWORD`, `FNAME`, `LNAME`, `PHONE`, `USER_TYPE`, `CREATED_DATE`) VALUES
	(1007, 'kariem@gmail.com', '$2y$10$P9uUVg8YVqcnHvLZHsqamuJzMdZ0Noj2KsZWhMPj0ySYYXHctVw6a', 'Kariem', 'Mohamed', '2999299', 'wholesaler', '2024-12-24');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
