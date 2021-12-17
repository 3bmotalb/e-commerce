-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2021 at 03:02 PM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `php_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
`id` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `itemid`, `quantity`, `userid`, `date`) VALUES
(41, 8, 2, 2, '2021-12-17 07:14:03'),
(44, 4, 3, 2, '2021-12-17 07:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
`catid` int(11) NOT NULL,
  `catname` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`catid`, `catname`, `status`) VALUES
(2, 'Labtop', 1),
(3, 'Mobile', 1),
(4, 'Case', 1);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
`itemid` int(11) NOT NULL,
  `itemname` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(50) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `last_mod` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `discount` varchar(50) NOT NULL,
  `likes` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `catid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemid`, `itemname`, `description`, `price`, `brand`, `image`, `date`, `last_mod`, `status`, `discount`, `likes`, `quantity`, `catid`) VALUES
(2, 'Dell inspiron', 'Processor: 10th Generation Intel®Core™ i7 -10750H(12MB Cache, up to 5.0 GHz, 6 cores) RAM:8GB Hard Disk: 512GB SSD Graphics Card:NVIDIA GeForce GTX1650 4GB Color: Black', '10000', 'Dell', '848156409_dell-inspiron-15-5000-15.jpg', '2021-12-15', '2021-12-15', 1, '1000', 8, 0, 2),
(3, 'Dell G3 3500', 'Processor: 10th Generation Intel®Core™ i7 -10750H(12MB Cache, up to 5.0 GHz, 6 cores) RAM:8GB Hard Disk: 512GB SSD Graphics Card:NVIDIA GeForce GTX1650 4GB Color: Black', '15000', 'Dell', '1017572531_zd980.jpg', '2021-12-15', '2021-12-15', 1, '0', 16, 0, 2),
(4, 'Apple iPhone 13', 'SIM Card: Single SIM (Nano-SIM) Screen: 6.1 inches , 1170 x 2532 pixels RAM: 4GB Internal memory: 128GB Camera: Primary: Dual: 12MP + 12MP / Secondary: : 12MP + 12MP Color: Midnight', '9000', 'Apple', '1172960294_photoshoptemplates_for_accessories_5_.jpg', '2021-12-15', '2021-12-15', 1, '500', 100, 0, 3),
(5, 'HP Laptop 15-dw3044ne', 'Processor:Intel® Pentium Gold 7505 (up to 3.5 GHz with Intel® Turbo Boost Technology, 4 MB L3 cache, 2 cores) RAM: 4GB Hard Disk: 1TB Graphics Card:Intel® UHD Graphics Color: Chalkboard gray', '15000', 'Hp', '552657166_zh199-09q (1).jpg', '2021-12-15', '2021-12-15', 1, '300', 0, 0, 2),
(6, 'Apple iPhone 13 ', 'SIM Card: Single SIM (Nano-SIM) Screen: 6.1 inches , 1170 x 2532 pixels RAM: 4GB Internal memory: 128GB Camera: Primary: Dual: 12MP + 12MP / Secondary: : 12MP + 12MP Color: Midnight', '20000', 'Apple', '424465490_photoshoptemplates_for_accessories_5_.jpg', '2021-12-15', '2021-12-17', 0, '1000', 0, 0, 3),
(7, 'pc', 'pc', '9000', 'pc', '89549136_pc-specialist-vortex-minerva-xt-r-gaming-pc.jpg', '2021-12-15', '2021-12-15', 1, '0', 0, 0, 4),
(8, 'dell gamin', 'gming', '6000', 'dell', '575851297_dell-inspiron-5675-gaming-pc-recon-blue.jpg', '2021-12-15', '2021-12-15', 1, '0', 0, 0, 4),
(9, 'acer', '', '15000', 'acer', '1013441480_large-acer-aspire-gx-781-gaming-pc.jpg', '2021-12-15', '2021-12-17', 1, '1000', 1, 5, 4),
(10, 'ipad', '', '9000', 'Apple', '771430743_large-apple-10-5-ipad-pro-64-gb-space-grey-2017.jpg', '2021-12-15', '2021-12-17', 1, '7000', 1, 10, 3),
(11, 'MSI MDRN14', 'Processor:10th Generation Intel® Core™ i3-10110U 4M Cache, up to 4.10 GHz Ram :4 GB  Hard Disk: 256GBSSD Graphics Card:Intel UHD Graphics  Color :Black', '20000', 'MSI', '195665509_zm932.jpg', '2021-12-17', '2021-12-17', 1, '1000', 0, 20, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`userid` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `groupid` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `Username`, `Password`, `email`, `fullname`, `address`, `contact`, `image`, `status`, `date`, `groupid`) VALUES
(1, 'mohamed', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', 'mm@mm', 'Mohamed Gamal', 'll', '01021097569', '', 1, '2021-12-13', 1),
(2, 'mmmm', 'ab874467a7d1ff5fc71a4ade87dc0e098b458aae', 'mm@mmmm', 'mohamed', '26st shoubra', '01021097569', '500287489_male2.png', 1, '2021-12-13', 0),
(4, 'mm', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', 'admin@admin.com', 'admin', '', '', '78403905_profile.jpg', 0, '2021-12-15', 1),
(5, 'vvvv', '79ef7f87b4d8e6190ffd850c7caca6feebd26d68', 'mmgamal131@gmail.com', 'vvvv', '', '', '153408300_', 0, '2021-12-17', 0),
(6, 'aaaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', 'aaa@gmail.com', 'Mohamed Gamal', 'aaaaa', '0000', '926818505_', 0, '2021-12-17', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`), ADD KEY `ietm_1` (`itemid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
 ADD PRIMARY KEY (`itemid`), ADD KEY `cat_1` (`catid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`userid`), ADD UNIQUE KEY `Username` (`Username`), ADD UNIQUE KEY `id` (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
MODIFY `catid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
MODIFY `itemid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
ADD CONSTRAINT `ietm_1` FOREIGN KEY (`itemid`) REFERENCES `item` (`itemid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
ADD CONSTRAINT `cat_1` FOREIGN KEY (`catid`) REFERENCES `category` (`catid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
