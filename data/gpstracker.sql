-- phpMyAdmin SQL Dump
-- version 4.0.10.15
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 21, 2016 at 05:47 AM
-- Server version: 5.5.46
-- PHP Version: 5.6.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gpstracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `clientlogin`
--

CREATE TABLE IF NOT EXISTS `clientlogin` (
  `username` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clientlogin`
--

INSERT INTO `clientlogin` (`username`, `firstname`, `lastname`, `password`) VALUES
('aabdulla', 'Aman', 'Abdulla', 'password'),
('croscoe', 'Carson', 'Roscoe', 'password'),
('mwillems', 'Micah', 'Willems', 'password'),
('slee', 'Spenser', 'Lee', 'password'),
('tyu', 'Thomas', 'Yu', 'password');

-- --------------------------------------------------------

--
-- Table structure for table `clientposition`
--

CREATE TABLE IF NOT EXISTS `clientposition` (
  `username` varchar(30) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(15) NOT NULL,
  `deviceName` varchar(64) NOT NULL,
  `deviceId` varchar(64) NOT NULL,
  `latitude` double(7,4) DEFAULT NULL,
  `longitude` double(7,4) DEFAULT NULL,
  PRIMARY KEY (`username`,`datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clientposition`
--

INSERT INTO `clientposition` (`username`, `datetime`, `ip`, `deviceName`, `deviceId`, `latitude`, `longitude`) VALUES
('aabdulla', '2016-02-01 09:03:00', '', '', '', 48.5000, -122.5000),
('croscoe', '2016-02-01 09:03:00', '', '', '', 49.0000, -122.0000),
('mwillems', '2016-02-01 09:04:00', '', '', '', 48.5000, -122.0000),
('mwillems', '2016-03-21 05:42:02', '142.232.163.46', 'Nexus 6P', '5ae7f3222743908a', 49.2498, -123.0016),
('mwillems', '2016-03-21 05:42:07', '142.232.163.46', 'Nexus 6P', '5ae7f3222743908a', 49.2498, -123.0016),
('mwillems', '2016-03-21 05:42:28', '142.232.163.46', 'Nexus 6P', '5ae7f3222743908a', 49.2498, -123.0016),
('slee', '2016-03-21 05:20:26', '142.232.163.46', 'Nexus 6P', '5ae7f3222743908a', 49.2498, -123.0016),
('slee', '2016-03-21 05:38:21', '142.232.163.46', 'Nexus 6P', '5ae7f3222743908a', 49.2498, -123.0016),
('slee', '2016-03-21 05:44:08', '142.232.163.46', 'Nexus 6P', '5ae7f3222743908a', 49.2498, -123.0016),
('tyu', '2016-02-01 09:04:00', '', '', '', 48.0000, -123.0000);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
