-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2016 at 02:00 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gpstracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `clientlogin`
--

CREATE TABLE `clientlogin` (
  `username` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
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

CREATE TABLE `clientposition` (
  `username` varchar(30) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(15) NOT NULL,
  `deviceName` varchar(64) NOT NULL,
  `deviceId` varchar(64) NOT NULL,
  `latitude` double(13,9) DEFAULT NULL,
  `longitude` double(13,9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clientposition`
--

INSERT INTO `clientposition` (`username`, `datetime`, `ip`, `deviceName`, `deviceId`, `latitude`, `longitude`) VALUES
('aabdulla', '2016-03-21 10:13:41', '96.49.6.113', 'Nexus 4', 'bf96379c9967f7d0', 49.162211000, -123.167920000),
('aabdulla', '2016-03-21 10:13:49', '96.49.6.113', 'Nexus 4', 'bf96379c9967f7d0', 49.151144000, -123.185989000),
('croscoe', '2016-03-21 10:13:59', '96.49.6.113', 'Nexus 4', 'bf96379c9967f7d0', 49.224628000, -123.150192000),
('croscoe', '2016-03-21 10:16:59', '96.49.6.113', 'Nexus 4', 'bf96379c9967f7d0', 49.202018000, -122.981901000),
('mwillems', '2016-03-21 05:42:02', '142.232.163.46', 'Nexus 6P', '5ae7f3222743908a', 49.249800000, -123.001600000),
('mwillems', '2016-03-21 05:42:07', '142.232.163.46', 'Nexus 6P', '5ae7f3222743908a', 49.249800000, -123.001600000),
('mwillems', '2016-03-21 05:42:28', '142.232.163.46', 'Nexus 6P', '5ae7f3222743908a', 49.249800000, -123.001600000),
('mwillems', '2016-03-21 08:29:47', '142.232.144.240', 'X5pro', '9d692660b5aa8728', 49.249800000, -123.001700000),
('slee', '2016-03-21 05:20:26', '142.232.163.46', 'Nexus 6P', '5ae7f3222743908a', 49.249800000, -123.001600000),
('slee', '2016-03-21 11:31:26', '96.49.6.113', 'Nexus 6P', '5ae7f3222743908a', 49.150000000, -123.100000000),
('slee', '2016-03-21 11:31:30', '96.49.6.113', 'Nexus 6P', '5ae7f3222743908a', 49.140526220, -123.192435310),
('tyu', '2016-03-21 06:56:03', '142.232.139.214', 'LG-D852', 'b353dc16a0da6184', 49.246694000, -122.999342000),
('tyu', '2016-03-21 08:17:04', '142.232.139.214', 'LG-D852', 'b353dc16a0da6184', 49.246430000, -123.008335000),
('tyu', '2016-03-21 08:17:16', '142.232.139.214', 'LG-D852', 'b353dc16a0da6184', 49.250100000, -123.001300000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientlogin`
--
ALTER TABLE `clientlogin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `clientposition`
--
ALTER TABLE `clientposition`
  ADD PRIMARY KEY (`username`,`datetime`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
