-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 08, 2015 at 03:30 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test123`
--

-- --------------------------------------------------------

--
-- Table structure for table `capital`
--

CREATE TABLE IF NOT EXISTS `capital` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `supplier` varchar(50) NOT NULL,
  `unitprice` bigint(10) NOT NULL,
  `bno` varchar(50) NOT NULL,
  `refno` varchar(50) NOT NULL,
  `manufacturer` varchar(50) NOT NULL,
  `warranty` varchar(30) NOT NULL,
  `pdate` date NOT NULL,
  `edate` date NOT NULL,
  `quantity` bigint(10) NOT NULL,
  `tamount` bigint(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bno` (`bno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `capital`
--

INSERT INTO `capital` (`id`, `name`, `category`, `description`, `supplier`, `unitprice`, `bno`, `refno`, `manufacturer`, `warranty`, `pdate`, `edate`, `quantity`, `tamount`, `status`, `remarks`) VALUES
(1, 'cro', 'asdf', 'adsfge', 'wrg', 50, 'har44', 'df4t', 'wga4', '2', '2015-06-03', '2015-06-03', 41, 2050, 'Available', '');

-- --------------------------------------------------------

--
-- Table structure for table `consumable`
--

CREATE TABLE IF NOT EXISTS `consumable` (
  `id` int(10) NOT NULL,
  `type` varchar(30) NOT NULL,
  `category` varchar(30) DEFAULT NULL,
  `subcat` varchar(30) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `quantity` bigint(10) NOT NULL,
  `price` bigint(10) NOT NULL,
  `pdate` date NOT NULL,
  `edate` date NOT NULL,
  `billno` varchar(50) NOT NULL,
  `supplier` varchar(30) DEFAULT NULL,
  `manufacturer` varchar(30) NOT NULL,
  `refno` varchar(50) DEFAULT NULL,
  `alert` bigint(10) NOT NULL,
  `specid` int(10) NOT NULL,
  `cq` bigint(10) NOT NULL,
  `f1` varchar(50) DEFAULT NULL,
  `f2` varchar(50) DEFAULT NULL,
  `f3` varchar(50) DEFAULT NULL,
  `f4` varchar(50) DEFAULT NULL,
  `f5` varchar(50) DEFAULT NULL,
  `f6` varchar(50) DEFAULT NULL,
  `f7` varchar(50) DEFAULT NULL,
  `f8` varchar(50) DEFAULT NULL,
  `f9` varchar(50) DEFAULT NULL,
  `f10` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `specid` (`specid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consumable`
--

INSERT INTO `consumable` (`id`, `type`, `category`, `subcat`, `description`, `quantity`, `price`, `pdate`, `edate`, `billno`, `supplier`, `manufacturer`, `refno`, `alert`, `specid`, `cq`, `f1`, `f2`, `f3`, `f4`, `f5`, `f6`, `f7`, `f8`, `f9`, `f10`) VALUES
(1, 'Resistor', 'newcat01', 'subcat01', 'fdsfalj', 5, 510, '2015-06-03', '2015-06-03', '64sdf', 'sdfl', 'lsdfj', 'sdflj232', 10, 1, 0, 'sdflj', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `consum_details`
--

CREATE TABLE IF NOT EXISTS `consum_details` (
  `id` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `price` bigint(15) NOT NULL,
  `quantity` bigint(15) NOT NULL,
  `pdate` date NOT NULL,
  `manufac` varchar(50) NOT NULL,
  `refno` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consum_details`
--

INSERT INTO `consum_details` (`id`, `cid`, `price`, `quantity`, `pdate`, `manufac`, `refno`) VALUES
(1, 1, 510, 50, '2015-06-03', 'lsdfj', 'sdflj232');

-- --------------------------------------------------------

--
-- Table structure for table `discussion`
--

CREATE TABLE IF NOT EXISTS `discussion` (
  `qno` int(10) NOT NULL,
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `suggestion` varchar(300) NOT NULL,
  PRIMARY KEY (`qno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
  `id` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `lab` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `name`, `lab`, `email`, `phone`) VALUES
('fac01', 'sambhu', 'Electronics Workshop', 'shanoo.roy@gmail.com', '8789798745'),
('fac02', 'manoj', 'Electronics Circuits Lab', 'man@gmail.com', '7412589635'),
('fac03', 'mohan', 'Integrated Circuits Lab', 'mohanpyare@hotmail.com', '7539518524'),
('fac04', 'shalini', 'Embedded Systems Lab', 'sha@gmail.com', '8523697415'),
('fac06', 'shanoo', 'zinx', 'shanoo.roy@gmail.com', '8891556182');

-- --------------------------------------------------------

--
-- Table structure for table `issue_capital`
--

CREATE TABLE IF NOT EXISTS `issue_capital` (
  `id` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `staffid` varchar(20) NOT NULL,
  `location` varchar(50) NOT NULL,
  `idate` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `labs`
--

CREATE TABLE IF NOT EXISTS `labs` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `labs`
--

INSERT INTO `labs` (`id`, `name`) VALUES
(1, 'Electronics Workshop'),
(2, 'Electronics Circuits Lab'),
(3, 'Integrated Circuits Lab'),
(4, 'Embedded Systems Lab'),
(5, 'Communication Lab'),
(6, 'Signal Processing and Communication Lab'),
(7, 'Digital Signal Processing Lab'),
(8, 'Simulation Lab'),
(9, 'Telecommunication Technology Lab'),
(10, 'DST-FIST Lab'),
(11, 'Microelectronics and VLSI Lab'),
(12, 'PSoC Lab'),
(13, 'zinx');

-- --------------------------------------------------------

--
-- Table structure for table `lab_det`
--

CREATE TABLE IF NOT EXISTS `lab_det` (
  `lab` varchar(50) NOT NULL,
  `fac_id` varchar(50) NOT NULL,
  `fac_in` varchar(50) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `staff_in` varchar(50) NOT NULL,
  PRIMARY KEY (`lab`,`fac_id`,`staff_id`),
  UNIQUE KEY `lab` (`lab`),
  UNIQUE KEY `fac_id` (`fac_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_det`
--

INSERT INTO `lab_det` (`lab`, `fac_id`, `fac_in`, `staff_id`, `staff_in`) VALUES
('Electronics Circuits Lab', 'fac02', 'manoj', 's02', 'prem'),
('Electronics Workshop', 'fac01', 'sambhu', 's01', 'sita'),
('Embedded Systems Lab', 'fac04', 'shalini', 's04', 'rakesh'),
('Integrated Circuits Lab', 'fac03', 'mohan', 's03', 'hamid');

-- --------------------------------------------------------

--
-- Table structure for table `lab_issue_consumable`
--

CREATE TABLE IF NOT EXISTS `lab_issue_consumable` (
  `id` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `uid` varchar(50) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `idate` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `uid` varchar(20) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`uid`, `pass`, `type`) VALUES
('admin', '123', 'Admin'),
('b120369ca', 'b120369ca', 'Student'),
('fac01', 'fac01', 'Faculty'),
('fac02', 'fac02', 'Faculty'),
('fac03', 'fac03', 'Faculty'),
('fac04', 'fac04', 'Faculty'),
('fac05', 'fac05', 'Faculty'),
('fac06', 'fac06', 'Faculty'),
('m120355ca', 'm120355ca', 'Student'),
('m120368ca', 'm120368ca', 'Student'),
('M120369CA', 'M120369CA', 'Student'),
('m120377ca', 'm120377ca', 'Student'),
('s01', 's01', 'Staff'),
('s02', 's02', 'Staff'),
('s03', 's03', 'Staff'),
('s04', 's04', 'Staff'),
('s05', 's05', 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `main_cat`
--

CREATE TABLE IF NOT EXISTS `main_cat` (
  `id` int(10) NOT NULL,
  `refno_maj` int(10) NOT NULL,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `refno_maj` (`refno_maj`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `main_cat`
--

INSERT INTO `main_cat` (`id`, `refno_maj`, `category`) VALUES
(1, 1, 'newcat01'),
(2, 1, 'newcat01');

-- --------------------------------------------------------

--
-- Table structure for table `major_cat`
--

CREATE TABLE IF NOT EXISTS `major_cat` (
  `id` int(10) NOT NULL,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `major_cat`
--

INSERT INTO `major_cat` (`id`, `category`) VALUES
(1, 'Resistor'),
(2, 'Capacitor'),
(3, 'Inductor'),
(4, 'Semi Conductor'),
(5, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `request_component`
--

CREATE TABLE IF NOT EXISTS `request_component` (
  `id` int(10) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `utype` varchar(20) NOT NULL,
  `pname` varchar(50) NOT NULL,
  `cname` varchar(50) NOT NULL,
  `ctype` varchar(30) NOT NULL,
  `gname` varchar(50) DEFAULT NULL,
  `des` varchar(150) NOT NULL,
  `quant` bigint(10) NOT NULL,
  `manu` varchar(50) DEFAULT NULL,
  `pno` varchar(50) DEFAULT NULL,
  `rby` varchar(50) NOT NULL,
  `rdate` varchar(30) NOT NULL,
  `status` varchar(20) NOT NULL,
  `refno` varchar(50) NOT NULL,
  PRIMARY KEY (`id`,`uid`,`utype`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_issue`
--

CREATE TABLE IF NOT EXISTS `request_issue` (
  `id` int(10) NOT NULL,
  `uid` varchar(50) NOT NULL,
  `utype` varchar(50) NOT NULL,
  `cid` int(10) NOT NULL,
  `quantity` bigint(10) NOT NULL,
  `pname` varchar(50) NOT NULL,
  `gname` varchar(50) NOT NULL,
  `rdate` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `specification`
--

CREATE TABLE IF NOT EXISTS `specification` (
  `id` int(10) NOT NULL,
  `category` varchar(50) NOT NULL,
  `f1` varchar(50) DEFAULT NULL,
  `f2` varchar(50) DEFAULT NULL,
  `f3` varchar(50) DEFAULT NULL,
  `f4` varchar(50) DEFAULT NULL,
  `f5` varchar(50) DEFAULT NULL,
  `f6` varchar(50) DEFAULT NULL,
  `f7` varchar(50) DEFAULT NULL,
  `f8` varchar(50) DEFAULT NULL,
  `f9` varchar(50) DEFAULT NULL,
  `f10` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specification`
--

INSERT INTO `specification` (`id`, `category`, `f1`, `f2`, `f3`, `f4`, `f5`, `f6`, `f7`, `f8`, `f9`, `f10`) VALUES
(1, 'Resistor', 'spec1', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `id` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `lab` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `lab`, `email`, `phone`) VALUES
('s01', 'sita', 'Electronics Workshop', 'sit@gmail.com', '7736123456'),
('s02', 'prem', 'Electronics Circuits Lab', 'prem@ibibo.com', '9874563210'),
('s03', 'hamid', 'Integrated Circuits Lab', 'hami@gmail.com', '9012345678'),
('s04', 'rakesh', 'Embedded Systems Lab', 'rakesh@gmail.com', '9567123456');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `roll` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `course` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  PRIMARY KEY (`roll`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`roll`, `name`, `course`, `email`, `phone`) VALUES
('b120369ca', 'sekhar', 'UG', 'seku@gmail.com', '7896541478'),
('m120355ca', 'rama', 'PG', 'rama@gmail.com', '8891556192'),
('m120368ca', 'purnendu', 'PG', 'shanoo.roy@gmail.com', '8891556192'),
('m120369ca', 'AMIT', 'PG', 'amitnaught@gmail.com', '8912345678'),
('m120377ca', 'niranjan', 'PG', 'niranjan3233@gmail.com', '8789798745');

-- --------------------------------------------------------

--
-- Table structure for table `sub_cat`
--

CREATE TABLE IF NOT EXISTS `sub_cat` (
  `id` int(10) NOT NULL,
  `refno_mn` int(10) NOT NULL,
  `refno_maj` int(10) NOT NULL,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `refno_mn` (`refno_mn`),
  KEY `refno_maj` (`refno_maj`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_cat`
--

INSERT INTO `sub_cat` (`id`, `refno_mn`, `refno_maj`, `category`) VALUES
(1, 1, 1, 'subcat01');

-- --------------------------------------------------------

--
-- Table structure for table `user_issue_consumable`
--

CREATE TABLE IF NOT EXISTS `user_issue_consumable` (
  `id` int(10) NOT NULL,
  `uid` varchar(50) NOT NULL,
  `utype` varchar(50) NOT NULL,
  `guide` varchar(50) NOT NULL,
  `cid` int(10) NOT NULL,
  `quantity` bigint(10) NOT NULL,
  `idate` varchar(20) NOT NULL,
  `rdate` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_issue_consumable`
--

INSERT INTO `user_issue_consumable` (`id`, `uid`, `utype`, `guide`, `cid`, `quantity`, `idate`, `rdate`) VALUES
(1, 'm120368ca', 'Student', 'sambhu', 1, 6, '03/06/2015', '15/06/2015'),
(2, 'm120368ca', 'Student', 'sambhu', 1, 40, '03/06/2015', '15/06/2015'),
(3, 'm120355ca', 'Student', 'shalini', 1, 1, '06/06/2015', '07/06/2015'),
(4, 'm120355ca', 'Student', 'manoj', 1, 10, '08/06/2015', '15/06/2015');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consum_details`
--
ALTER TABLE `consum_details`
  ADD CONSTRAINT `consum_details_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `consumable` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `issue_capital`
--
ALTER TABLE `issue_capital`
  ADD CONSTRAINT `issue_capital_ibfk_3` FOREIGN KEY (`cid`) REFERENCES `capital` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `main_cat`
--
ALTER TABLE `main_cat`
  ADD CONSTRAINT `main_cat_ibfk_1` FOREIGN KEY (`refno_maj`) REFERENCES `major_cat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_cat`
--
ALTER TABLE `sub_cat`
  ADD CONSTRAINT `sub_cat_ibfk_1` FOREIGN KEY (`refno_mn`) REFERENCES `main_cat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sub_cat_ibfk_2` FOREIGN KEY (`refno_maj`) REFERENCES `major_cat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
