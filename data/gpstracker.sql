-- phpMyAdmin SQL Dump
-- version 4.4.14.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 03, 2016 at 06:51 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockticker`
--

DROP TABLE IF EXISTS `clientlogin`;
DROP TABLE IF EXISTS `clientposition`;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE IF NOT EXISTS `clientlogin` (
    `username` VARCHAR(30) NOT NULL,
    `firstname` VARCHAR(30) NOT NULL,
    `lastname` VARCHAR(30) NOT NULL,
    `password` VARCHAR(30) NOT NULL,
    PRIMARY KEY(`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `players`
--

INSERT INTO `clientlogin` (`username`, `firstname`, `lastname`, `password`) VALUES
('mwillems','Micah','Willems', 'password'),
('croscoe','Carson', 'Roscoe', 'password'),
('tyu','Thomas','Yu', 'password'),
('aabdulla','Aman','Abdulla', 'password'),
('slee','Spenser','Lee', 'password');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE IF NOT EXISTS `clientposition` (
    `username` VARCHAR(30) NOT NULL,
    `datetime` varchar(19) NOT NULL,
    `latitude` DOUBLE(7,4) DEFAULT NULL,
    `longitude` DOUBLE(7,4) DEFAULT NULL,
    PRIMARY KEY(`username`, `datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stocks`
--

INSERT INTO `clientposition` (`username`, `datetime`, `latitude`, `longitude`) VALUES
('croscoe', '2016.02.01-09:03:00', 49, -122),
('aabdulla', '2016.02.01-09:03:00', 48.5, -122.5),
('tyu', '2016.02.01-09:04:00', 48, -123),
('mwillems', '2016.02.01-09:04:00', 48.5, -122),
('slee', '2016.02.01-09:01:00', 49, -123);
