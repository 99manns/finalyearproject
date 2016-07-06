-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2015 at 11:19 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
`CompanyID` int(11) NOT NULL,
  `APIkey` varchar(36) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `Name` varchar(1000) NOT NULL,
  `Telephone` varchar(500) NOT NULL,
  `delted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--
-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
`ItemID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `vendingmachineID` int(11) NOT NULL,
  `OfferID` int(11) DEFAULT NULL,
  `PurchasePrice` decimal(10,0) NOT NULL,
  `SalePrice` decimal(10,0) NOT NULL,
  `AddedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
`LocationID` int(11) NOT NULL,
  `AddressLine` varchar(10000) NOT NULL,
  `TownCity` varchar(10000) NOT NULL,
  `Country` varchar(10000) NOT NULL,
  `delted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--


-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE IF NOT EXISTS `offer` (
`OfferID` int(11) NOT NULL,
  `Name` varchar(1000) NOT NULL,
  `Description` varchar(10000) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `CompanyID` int(11) NOT NULL,
  `StartDate` datetime DEFAULT NULL,
  `EndDate` datetime DEFAULT NULL,
  `Quanitity` int(11) DEFAULT NULL,
  `Discount` decimal(10,2) DEFAULT NULL,
  `delted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offer`
--


- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
`PermissionID` int(11) NOT NULL,
  `Name` varchar(1000) NOT NULL,
  `Admin` tinyint(1) NOT NULL,
  `delted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permission`
--


-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
`ProductID` int(11) NOT NULL,
  `Name` varchar(1000) NOT NULL,
  `Description` varchar(10000) NOT NULL,
  `CompanyID` int(11) NOT NULL,
  `Image` varchar(10000) NOT NULL,
  `delted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--


-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
`StockID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `RetailPrice` decimal(10,2) NOT NULL,
  `Quanitity` int(11) NOT NULL,
  `vendingmachineID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`UserID` int(11) NOT NULL,
  `FirstName` varchar(500) NOT NULL,
  `LastName` varchar(500) NOT NULL,
  `Email` varchar(5000) NOT NULL,
  `PermissionID` int(11) NOT NULL,
  `delted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--


-- --------------------------------------------------------

--
-- Table structure for table `vendingmachine`
--

CREATE TABLE IF NOT EXISTS `vendingmachine` (
`vendingmachineID` int(11) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `CompanyID` int(11) NOT NULL,
  `Name` varchar(1000) NOT NULL,
  `delted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendingmachine`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
 ADD PRIMARY KEY (`CompanyID`), ADD UNIQUE KEY `APIkey` (`APIkey`), ADD KEY `company_ibfk_1` (`LocationID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
 ADD PRIMARY KEY (`ItemID`), ADD KEY `item_ibfk_2` (`vendingmachineID`), ADD KEY `item_ibfk_1` (`UserID`), ADD KEY `item_ibfk_3` (`ProductID`), ADD KEY `item_ibfk_4` (`OfferID`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
 ADD PRIMARY KEY (`LocationID`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
 ADD PRIMARY KEY (`OfferID`), ADD KEY `offer_ibfk_1` (`CompanyID`), ADD KEY `offer_ibfk_2` (`ProductID`), ADD KEY `offer_ibfk_3` (`UserID`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
 ADD PRIMARY KEY (`PermissionID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
 ADD PRIMARY KEY (`ProductID`), ADD KEY `product_ibfk_1` (`CompanyID`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
 ADD PRIMARY KEY (`StockID`), ADD KEY `stock_ibfk_1` (`ProductID`), ADD KEY `stock_ibfk_2` (`vendingmachineID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `vendingmachine`
--
ALTER TABLE `vendingmachine`
 ADD PRIMARY KEY (`vendingmachineID`), ADD KEY `CompanyID` (`CompanyID`), ADD KEY `vendingmachine_ibfk_2` (`LocationID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
MODIFY `CompanyID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
MODIFY `LocationID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
MODIFY `OfferID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
MODIFY `PermissionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
MODIFY `StockID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vendingmachine`
--
ALTER TABLE `vendingmachine`
MODIFY `vendingmachineID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
