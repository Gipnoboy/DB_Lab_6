-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 08, 2023 at 08:02 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL,
  `CustomerName` varchar(100) DEFAULT NULL,
  `CustomerSurname` varchar(100) DEFAULT NULL,
  `CustomerEmail` varchar(100) DEFAULT NULL,
  `CustomerPhone` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `CustomerName`, `CustomerSurname`, `CustomerEmail`, `CustomerPhone`) VALUES
(1, 'Вася', 'Овальний', 'VasiaOvalnyi@gmail.com', '+380996742389'),
(2, 'Jacob', 'Круглий', 'SaniaCircle@ukr.net', '+380669803256');

-- --------------------------------------------------------

--
-- Table structure for table `distributors`
--

CREATE TABLE `distributors` (
  `DistributorID` int(11) NOT NULL,
  `DistributorName` varchar(100) DEFAULT NULL,
  `DistributorEmail` varchar(100) DEFAULT NULL,
  `DistributorPhone` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `distributors`
--

INSERT INTO `distributors` (`DistributorID`, `DistributorName`, `DistributorEmail`, `DistributorPhone`) VALUES
(1, 'CalmMom', 'calm_mom@cm.com', '324567'),
(2, 'FastRunner', 'fust_runner@gmail.com', '453213');

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `MedicineID` int(11) NOT NULL,
  `MedicineName` varchar(100) DEFAULT NULL,
  `MedicinePrice` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`MedicineID`, `MedicineName`, `MedicinePrice`) VALUES
(1, 'Агнесті', '360'),
(2, 'джас плюс', '300'),
(4, 'Валеріанка', '100');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `DistributorID` int(11) DEFAULT NULL,
  `PharmasistID` int(11) DEFAULT NULL,
  `MedicineID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `DistributorID`, `PharmasistID`, `MedicineID`, `Quantity`, `Total`) VALUES
(1, 2, 5, 4, 7, 2313),
(3, 2, 5, 1, 5, 1800);

-- --------------------------------------------------------

--
-- Table structure for table `pharmasists`
--

CREATE TABLE `pharmasists` (
  `PharmasistID` int(11) NOT NULL,
  `PharmasistName` varchar(100) DEFAULT NULL,
  `PharmasistSurname` varchar(100) DEFAULT NULL,
  `PharmasistEmail` varchar(100) DEFAULT NULL,
  `PharmasistPhone` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pharmasists`
--

INSERT INTO `pharmasists` (`PharmasistID`, `PharmasistName`, `PharmasistSurname`, `PharmasistEmail`, `PharmasistPhone`) VALUES
(1, 'Катя', '*відсутнє*', 'katiaNoname@gmail.com', '+3801239876'),
(2, 'Федір', 'Маїло', 'FidiaFidia@gmail.com', '+380508051339'),
(3, 'Артем', 'Зеленський', 'AR@gmail.com', '+380324234'),
(5, 'Валиль', 'Гага', 'dadaga@gmail.com', '+380324234');

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `ReceiptID` int(11) NOT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `PharmasistID` int(11) DEFAULT NULL,
  `MedicineID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`ReceiptID`, `CustomerID`, `PharmasistID`, `MedicineID`, `Quantity`, `Total`) VALUES
(1, 1, 1, 1, 1, 120),
(2, 2, 2, 2, 1, 600),
(3, NULL, NULL, 1, 5, 1800),
(4, NULL, NULL, 1, 5, 1800),
(6, 2, 5, 4, 7, 2313),
(7, 1, NULL, 1, 5, 1800);

-- --------------------------------------------------------

--
-- Table structure for table `storage_`
--

CREATE TABLE `storage_` (
  `PlaceInStorage` int(11) NOT NULL,
  `MedicineID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `storage_`
--

INSERT INTO `storage_` (`PlaceInStorage`, `MedicineID`, `Quantity`) VALUES
(1, 1, 3),
(2, 2, 7),
(3, NULL, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `distributors`
--
ALTER TABLE `distributors`
  ADD PRIMARY KEY (`DistributorID`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`MedicineID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `DistributorID` (`DistributorID`),
  ADD KEY `PharmasistID` (`PharmasistID`),
  ADD KEY `MedicineID` (`MedicineID`);

--
-- Indexes for table `pharmasists`
--
ALTER TABLE `pharmasists`
  ADD PRIMARY KEY (`PharmasistID`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`ReceiptID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `PharmasistID` (`PharmasistID`),
  ADD KEY `MedicineID` (`MedicineID`);

--
-- Indexes for table `storage_`
--
ALTER TABLE `storage_`
  ADD PRIMARY KEY (`PlaceInStorage`),
  ADD KEY `MedicineID` (`MedicineID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `distributors`
--
ALTER TABLE `distributors`
  MODIFY `DistributorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `MedicineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pharmasists`
--
ALTER TABLE `pharmasists`
  MODIFY `PharmasistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `ReceiptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `storage_`
--
ALTER TABLE `storage_`
  MODIFY `PlaceInStorage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `receipts`
--
ALTER TABLE `receipts`
  ADD CONSTRAINT `receipts_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`),
  ADD CONSTRAINT `receipts_ibfk_2` FOREIGN KEY (`PharmasistID`) REFERENCES `pharmasists` (`PharmasistID`),
  ADD CONSTRAINT `receipts_ibfk_3` FOREIGN KEY (`MedicineID`) REFERENCES `medicines` (`MedicineID`);

--
-- Constraints for table `storage_`
--
ALTER TABLE `storage_`
  ADD CONSTRAINT `storage__ibfk_1` FOREIGN KEY (`MedicineID`) REFERENCES `medicines` (`MedicineID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
