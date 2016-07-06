
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- company
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company`
(
    `CompanyID` INTEGER NOT NULL AUTO_INCREMENT,
    `APIkey` VARCHAR(36) NOT NULL,
    `LocationID` INTEGER NOT NULL,
    `Name` VARCHAR(1000) NOT NULL,
    `Telephone` VARCHAR(500) NOT NULL,
    `delted` TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (`CompanyID`),
    UNIQUE INDEX `APIkey` (`APIkey`),
    INDEX `company_ibfk_1` (`LocationID`),
    CONSTRAINT `clid`
        FOREIGN KEY (`LocationID`)
        REFERENCES `location` (`LocationID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- gender
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `gender`;

CREATE TABLE `gender`
(
    `GenderID` INTEGER NOT NULL AUTO_INCREMENT,
    `Name` VARCHAR(1000) NOT NULL,
    PRIMARY KEY (`GenderID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item`;

CREATE TABLE `item`
(
    `ItemID` INTEGER NOT NULL AUTO_INCREMENT,
    `ProductID` INTEGER NOT NULL,
    `UserID` INTEGER NOT NULL,
    `vendingmachineID` INTEGER NOT NULL,
    `OfferID` INTEGER,
    `PurchasePrice` DECIMAL NOT NULL,
    `SalePrice` DECIMAL NOT NULL,
    `AddedDate` DATETIME NOT NULL,
    PRIMARY KEY (`ItemID`),
    INDEX `item_ibfk_2` (`vendingmachineID`),
    INDEX `item_ibfk_1` (`UserID`),
    INDEX `item_ibfk_3` (`ProductID`),
    INDEX `item_ibfk_4` (`OfferID`),
    CONSTRAINT `iPrid`
        FOREIGN KEY (`ProductID`)
        REFERENCES `product` (`ProductID`),
    CONSTRAINT `ioid`
        FOREIGN KEY (`OfferID`)
        REFERENCES `offer` (`OfferID`),
    CONSTRAINT `ipid`
        FOREIGN KEY (`ProductID`)
        REFERENCES `product` (`ProductID`),
    CONSTRAINT `iuid`
        FOREIGN KEY (`UserID`)
        REFERENCES `user` (`UserID`),
    CONSTRAINT `ivid`
        FOREIGN KEY (`vendingmachineID`)
        REFERENCES `vendingmachine` (`vendingmachineID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- location
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `location`;

CREATE TABLE `location`
(
    `LocationID` INTEGER NOT NULL AUTO_INCREMENT,
    `AddressLine` VARCHAR(10000) NOT NULL,
    `TownCity` VARCHAR(10000) NOT NULL,
    `Country` VARCHAR(10000) NOT NULL,
    `delted` TINYINT(1) DEFAULT 0 NOT NULL,
    `Postcode` VARCHAR(1000),
    PRIMARY KEY (`LocationID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- offer
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `offer`;

CREATE TABLE `offer`
(
    `OfferID` INTEGER NOT NULL AUTO_INCREMENT,
    `Name` VARCHAR(1000) NOT NULL,
    `Description` VARCHAR(10000) NOT NULL,
    `ProductID` INTEGER,
    `UserID` INTEGER,
    `CompanyID` INTEGER NOT NULL,
    `StartDate` DATETIME,
    `EndDate` DATETIME,
    `Quanitity` INTEGER,
    `Discount` DECIMAL(10,2),
    `delted` TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (`OfferID`),
    INDEX `offer_ibfk_1` (`CompanyID`),
    INDEX `offer_ibfk_2` (`ProductID`),
    INDEX `offer_ibfk_3` (`UserID`),
    CONSTRAINT `ocid`
        FOREIGN KEY (`CompanyID`)
        REFERENCES `company` (`CompanyID`),
    CONSTRAINT `opid`
        FOREIGN KEY (`ProductID`)
        REFERENCES `product` (`ProductID`),
    CONSTRAINT `ouid`
        FOREIGN KEY (`UserID`)
        REFERENCES `user` (`UserID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- permission
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `permission`;

CREATE TABLE `permission`
(
    `PermissionID` INTEGER NOT NULL AUTO_INCREMENT,
    `Name` VARCHAR(1000) NOT NULL,
    `Admin` TINYINT(1) NOT NULL,
    `delted` TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (`PermissionID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- product
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product`
(
    `ProductID` INTEGER NOT NULL AUTO_INCREMENT,
    `Name` VARCHAR(1000) NOT NULL,
    `Description` VARCHAR(10000) NOT NULL,
    `CompanyID` INTEGER NOT NULL,
    `Image` VARCHAR(10000) NOT NULL,
    `delted` TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (`ProductID`),
    INDEX `product_ibfk_1` (`CompanyID`),
    CONSTRAINT `pcid`
        FOREIGN KEY (`CompanyID`)
        REFERENCES `company` (`CompanyID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- stock
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock`
(
    `StockID` INTEGER NOT NULL AUTO_INCREMENT,
    `ProductID` INTEGER NOT NULL,
    `RetailPrice` DECIMAL(10,2) NOT NULL,
    `Quanitity` INTEGER NOT NULL,
    `vendingmachineID` INTEGER NOT NULL,
    PRIMARY KEY (`StockID`),
    INDEX `stock_ibfk_1` (`ProductID`),
    INDEX `stock_ibfk_2` (`vendingmachineID`),
    CONSTRAINT `spid`
        FOREIGN KEY (`ProductID`)
        REFERENCES `product` (`ProductID`),
    CONSTRAINT `svid`
        FOREIGN KEY (`vendingmachineID`)
        REFERENCES `vendingmachine` (`vendingmachineID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `UserID` INTEGER NOT NULL AUTO_INCREMENT,
    `FirstName` VARCHAR(500) NOT NULL,
    `LastName` VARCHAR(500) NOT NULL,
    `Email` VARCHAR(5000) NOT NULL,
    `PermissionID` INTEGER NOT NULL,
    `delted` TINYINT(1) DEFAULT 0 NOT NULL,
    `GenderID` INTEGER NOT NULL,
    PRIMARY KEY (`UserID`),
    INDEX `uGenderID` (`GenderID`),
    INDEX `upid` (`PermissionID`),
    CONSTRAINT `uGenderID`
        FOREIGN KEY (`GenderID`)
        REFERENCES `gender` (`GenderID`),
    CONSTRAINT `upid`
        FOREIGN KEY (`PermissionID`)
        REFERENCES `permission` (`PermissionID`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- vendingmachine
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `vendingmachine`;

CREATE TABLE `vendingmachine`
(
    `vendingmachineID` INTEGER NOT NULL AUTO_INCREMENT,
    `LocationID` INTEGER NOT NULL,
    `CompanyID` INTEGER NOT NULL,
    `Name` VARCHAR(1000) NOT NULL,
    `delted` TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (`vendingmachineID`),
    INDEX `CompanyID` (`CompanyID`),
    INDEX `vendingmachine_ibfk_2` (`LocationID`),
    CONSTRAINT `vCid`
        FOREIGN KEY (`CompanyID`)
        REFERENCES `company` (`CompanyID`),
    CONSTRAINT `vlid`
        FOREIGN KEY (`LocationID`)
        REFERENCES `location` (`LocationID`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
