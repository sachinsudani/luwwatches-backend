-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2021 at 08:08 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luxwatches`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `imagePath` varchar(255) NOT NULL,
  `description` varchar(200) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `modifiedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `imagePath`, `description`, `isDeleted`, `modifiedAt`, `createdAt`) VALUES
(1, 'Men\'s Watches', 'bg-1.jpg', 'Explore our collection of classic men’s watches. The Prime Ambassador is designed to be extraordinary - a remarkable timepiece for leaders, innovators, and the exceptional men.', 0, '2021-10-03 23:17:23', '2021-09-28 06:34:49'),
(2, 'Women\'s Watches', 'bg-2.jpg', 'Shop our collection of women’s watches that complement your unique personality, while adding an elegant classical touch of luxurious expression to any outfit.', 0, '2021-10-03 23:18:03', '2021-09-28 06:35:15');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `modifiedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `logo`, `isDeleted`, `modifiedAt`, `createdAt`) VALUES
(1, 'TITAN', '', 0, '2021-09-28 06:36:26', '2021-09-28 06:36:26'),
(2, 'SONATA', '', 0, '2021-09-28 06:36:39', '2021-09-28 06:36:39'),
(3, 'ROLEX', '', 0, '2021-10-03 23:19:44', '2021-10-03 23:19:44'),
(4, 'RADO', '', 0, '2021-10-03 23:19:44', '2021-10-03 23:19:44'),
(5, 'HERITAGE', '', 0, '2021-10-03 23:22:05', '2021-10-03 23:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `statusID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `userId`, `createdAt`, `updateAt`, `statusID`) VALUES
(11, 3, '2021-10-09 04:09:37', '2021-10-09 04:09:37', 1),
(15, 2, '2021-12-15 03:09:53', '2021-12-15 05:18:58', 2),
(16, 2, '2021-12-15 05:35:00', '2021-12-15 05:40:42', 2),
(17, 2, '2021-12-15 05:42:52', '2021-12-15 05:43:04', 2),
(18, 2, '2021-12-15 05:45:55', '2021-12-15 05:46:01', 2),
(19, 2, '2021-12-15 05:46:49', '2021-12-15 05:47:10', 2),
(20, 2, '2021-12-15 05:48:15', '2021-12-15 05:49:07', 2),
(21, 2, '2021-12-15 05:48:36', '2021-12-15 05:49:07', 2),
(22, 2, '2021-12-15 05:51:39', '2021-12-15 05:51:48', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orderedproducts`
--

CREATE TABLE `orderedproducts` (
  `id` int(11) NOT NULL,
  `productId` int(11) DEFAULT NULL,
  `orderId` int(11) DEFAULT NULL,
  `qunatity` varchar(6) NOT NULL,
  `totalprice` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderedproducts`
--

INSERT INTO `orderedproducts` (`id`, `productId`, `orderId`, `qunatity`, `totalprice`) VALUES
(6, 1, 11, '4', '219996'),
(7, 2, 11, '4', '183996'),
(14, 2, 15, '4', '183996'),
(15, 5, 15, '1', '510000'),
(16, 1, 16, '1', '54999'),
(17, 3, 17, '1', '79000'),
(18, 5, 18, '1', '510000'),
(19, 3, 19, '1', '79000'),
(20, 8, 20, '1', '65000'),
(21, 1, 21, '1', '54999'),
(22, 2, 22, '1', '45999');

-- --------------------------------------------------------

--
-- Table structure for table `orderstatus`
--

CREATE TABLE `orderstatus` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderstatus`
--

INSERT INTO `orderstatus` (`id`, `name`) VALUES
(1, 'INCART'),
(2, 'PENDING'),
(3, 'DELIVERED');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `imagePath` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `companyId` int(11) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `modifiedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `imagePath`, `price`, `categoryId`, `companyId`, `isDeleted`, `modifiedAt`, `createdAt`) VALUES
(1, 'Heritage 1959', 'The Heritage 1959 is 9mm thick and 40mm in diameter, it fuses a classical concept with an explorative modern touch of luxury. Featuring a unique, minimalistic dial and embossed rose-gold indices, stamped with our trademark \"A\", and covered by genuine sapphire crystal glass.', '1.jpg', 54999, 2, 5, 0, '2021-10-03 23:30:59', '2021-09-28 06:37:30'),
(2, 'Heritage 1921', 'The Heritage 1921 is 9mm thick and 40mm in diameter, it\'s a perfectly sized timeless classic. Featuring a remarkable \"Clous de Paris\" guilloché pattern and elegant polished silver indices covered by genuine sapphire glass.', '2.jpg', 45999, 1, 5, 0, '2021-10-03 23:32:39', '2021-09-28 06:38:32'),
(3, 'Heritage 1863', 'The Heritage 1863 is 9mm thick and 40mm in diameter and makes a bold statement with its luxurious contrasting colors. Featuring bright rose-gold roman numerals, embossed indices, clasic baton hands, and a stunning sunray dial, covered by genuine sapphire glass.', '3.jpg', 79000, 1, 5, 0, '2021-10-03 23:36:05', '2021-09-28 07:17:15'),
(4, 'Sky-Dweller', 'The Oyster Perpetual Sky-Dweller in 18 ct Everose gold with an intense white dial and an Oysterflex bracelet.\r\n\r\nThis distinctive watch is characterized by its second time zone display on an off-centre disc on the dial. Furthermore, its innovative system for setting the functions, using the rotatable Ring Command bezel, is unique to Rolex. ', '4.jpg', 251999, 1, 3, 0, '2021-10-04 02:32:17', '2021-09-28 07:17:31'),
(5, 'Cellini Time', 'The Cellini Time in 18 ct Everose gold features a white dial, double bezel and a Leather strap.\r\n\r\nThe essence of a timeless classic, the Cellini Time displays simply the hours, minutes and seconds, as if nothing but the present were of importance.', '5.jpg', 510000, 1, 3, 0, '2021-10-04 06:20:33', '2021-09-28 07:18:15'),
(6, 'Edge Baseline Watch with Grey Dial & Blue Leather Strap', 'Shape Round Case \r\nMaterial Metal Dial Color Grey \r\nStrap Material Leather\r\nGlass Material Sapphire Crystal\r\nCase Thickness 4.1 mm\r\nLock Mechanism Buckle\r\nCase Length 42.55 mm', '6.jpg', 10000, 1, 1, 0, '2021-10-04 06:29:53', '2021-09-28 07:18:54'),
(7, 'Workwear Watch with Green Dial & Fabric Strap', 'Shape : Round\r\nMaterial : Metal\r\nCase Thickness : 7.7 mm\r\nCase Length : 48 mm\r\nCase Width : 41 mm\r\nStrap Color : Green\r\nGlass Material : Mineral Glass\r\nLock Mechanism : Buckle', '7.jpg', 40000, 1, 1, 0, '2021-10-05 02:29:27', '2021-09-28 07:18:54'),
(8, 'Open Heart Automatic Watch', 'Case Shape : Round Shape\r\nCase Material : Stainless Steel\r\nCase Thickness : 12.5 mm\r\nCase Length : 43.5 mm\r\nGlass Material : Mineral Glass\r\nLock Mechanism : Buckle\r\nStrap Color : Black', '8.jpg', 65000, 1, 1, 0, '2021-10-05 02:35:39', '2021-09-28 07:22:01'),
(9, 'Crystal from Raga Facet', 'Strap Material : Stainless Steel\r\nCase Material : Metal \r\nCase Thickness : 6 mm\r\nCase Length : 31 mm\r\nCase Width : 31 mm \r\nColor : Bicolour\r\nGlass Material : Mineral Glass\r\nLock Mechanism : Jewellery Clasp\r\nDial Color : Brown', '9.jpg', 20000, 2, 1, 0, '2021-10-05 05:36:37', '2021-09-28 07:22:01'),
(10, 'Kaveh from Deccan Treasures', 'Strap Material : Leather \r\nBrand : Nebula\r\nDial Color : White\r\nCase Shape : Round \r\nCase Thickness : 6.05 mm\r\nCase Length : 44.00 mm\r\nCase Width : 40 mm\r\nStrap Color : Black\r\nGlass Material : Sapphire Crystal\r\nLock Mechanism : Buckle\r\nCase Material : 18 Karat Gold', '10.jpg', 120000, 2, 1, 0, '2021-10-05 05:36:18', '2021-09-28 07:22:01'),
(11, 'Utsav Grey Dial Analog Watch', 'Strap Material : Leather \r\nCase Shape : Round Case\r\nMaterial : Metal \r\nCase Thickness : 9.90 mm\r\nCase Length : 47.00 mm\r\nCase Width : 40.00 mm', '11.jpg', 150000, 1, 2, 0, '2021-10-05 05:36:01', '2021-09-28 07:22:01'),
(12, 'Versatyle Black Dial Leather Strap Watch', 'Strap Material : Leather \r\nCase Shape : Round\r\nCase Material : Metal \r\nCase Width : 42.5 mm\r\nStrap Color : Black\r\nGlass Material : Mineral glass\r\nLock Mechanism : Buckle\r\nCase Length : 49.50 mm\r\nCase Thickness : 8.95 mm\r\nDial Color : Black', '12.jpg', 50000, 1, 2, 0, '2021-10-05 05:35:37', '2021-09-28 07:22:01'),
(13, 'Blush It Up With Silver Dial Stainless Steel Watch', 'Strap Material : Stainless steel \r\nColor : Silver\r\nCase Material : Metal\r\nCase Thickness : 7.60 mm\r\nCase Length : 43.60 mm\r\nCase Width : 36.70 mm\r\nStrap Color : Rose Gold\r\nGlass Material : Mineral glass\r\nLock Mechanism : Push type clasp', '13.jpg', 67000, 2, 2, 0, '2021-10-05 05:41:08', '2021-09-28 07:22:01'),
(14, 'RADO Captain Cook', 'Collection Captain Cook\r\nSeries N/A\r\nModel No R32504205\r\nMOVEMENT Automatic \r\nCASE SIZE 42 mm\r\nCASE SHAPE Round\r\nCASE MATERIAL Bronze\r\nGLASS MATERIAL Sapphire Crystal\r\nDIAL COLOUR Blue\r\nSTRAP MATERIAL Leather\r\nSTRAP COLOUR Blue\r\nCOUNTRY OF ORIGIN Switzerland', '14.jpg', 75000, 1, 4, 0, '2021-10-05 05:47:12', '2021-09-28 07:22:01'),
(15, 'Patravi', 'Series N/A\r\nModel No R32504205\r\nFEATURES Date \r\nMOVEMENT Automatic \r\nCASE SIZE 42 mm\r\nCASE SHAPE Round\r\nCASE MATERIAL Bronze\r\nGLASS MATERIAL Sapphire Crystal\r\nDIAL COLOUR Blue\r\nSTRAP MATERIAL Leather\r\nSTRAP COLOUR Blue\r\nCOUNTRY OF ORIGIN Switzerland\r\n', '15.jpg', 56000, 1, 4, 0, '2021-10-05 05:57:05', '2021-09-28 07:22:01'),
(16, 'Formula 1\r\n', 'Model No R30036732\r\nFEATURES Date\r\nMOVEMENT Automatic\r\nCASE SIZE 38 mm\r\nCASE SHAPE Round\r\nCASE MATERIAL Steel & Rose Gold PVD\r\nGLASS MATERIAL Sapphire Crystal\r\nDIAL COLOUR Black\r\nSTRAP MATERIAL Steel & Rose Gold PVD\r\nSTRAP COLOUR Black & Rose Gold \r\nEAN 7612819058320\r\nPRECIOUS STONE On Dial\r\nCOUNTRY OF ORIGIN Switzerland\r\n', '16.jpg', 90000, 2, 4, 0, '2021-10-05 06:02:36', '2021-09-28 07:22:01'),
(17, 'Centrix', 'Model No R30036732\r\nFEATURES Date\r\nMOVEMENT Automatic\r\nCASE SIZE 38 mm\r\nCASE SHAPE Round\r\nCASE MATERIAL Steel & Rose Gold PVD\r\nGLASS MATERIAL Sapphire Crystal\r\nDIAL COLOUR Black\r\nSTRAP MATERIAL Steel & Rose Gold PVD\r\nSTRAP COLOUR Black & Rose Gold \r\nPRECIOUS STONE On Dial\r\nCOUNTRY OF ORIGIN Switzerland', '17.jpg', 125000, 2, 4, 0, '2021-10-05 06:06:04', '2021-09-28 07:22:01'),
(18, 'Hyperchrome', 'Collection Hyperchrome\r\nModel No R30036732\r\nMOVEMENT Automatic\r\nCASE SIZE 38 mm\r\nCASE SHAPE Round\r\nCASE MATERIAL Steel & Rose Gold\r\nGLASS MATERIAL Sapphire Crystal\r\nDIAL COLOUR Black\r\nSTRAP MATERIAL Steel & Rose Gold \r\nSTRAP COLOUR Black & Rose Gold \r\nPRECIOUS STONE On Dial\r\nCOUNTRY OF ORIGIN Switzerland', '18.jpg', 251999, 1, 4, 0, '2021-10-05 06:09:54', '2021-10-05 06:09:54'),
(19, 'Stride Pro - Hybrid Smartwatch With Black Dial & Black Leather Strap', 'STRAP Material : Leather \r\nCase Shape : Round \r\nCase Material : Abs\r\nCase Length : 52 mm\r\nCase Width : 45.4 mm\r\nStrap Color : Black\r\nGlass Material : Acrylic\r\nLock Mechanism : Buckle\r\nColor : Black', '19.jpg', 175000, 1, 2, 0, '2021-10-05 06:33:43', '2021-10-05 06:33:43'),
(20, 'Onyx Black Dial Stainless Steel Watch', 'STRAP Material : Leather \r\nCase Shape : Round \r\nCase Material : Abs\r\nCase Length : 52 mm\r\nCase Width : 45.4 mm\r\nStrap Color : Black\r\nGlass Material : Acrylic\r\nLock Mechanism : Buckle\r\nColor : Black', '20.jpg', 150000, 2, 2, 0, '2021-10-05 06:33:43', '2021-10-05 06:33:43');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `modifiedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `quantity`, `productId`, `modifiedAt`, `createdAt`) VALUES
(1, 10, 1, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(2, 10, 2, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(3, 10, 3, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(4, 10, 4, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(5, 10, 5, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(6, 10, 6, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(7, 11, 7, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(8, 10, 8, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(9, 10, 9, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(10, 10, 10, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(11, 10, 11, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(12, 10, 12, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(13, 10, 13, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(14, 10, 14, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(15, 10, 15, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(16, 10, 16, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(17, 10, 17, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(18, 10, 18, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(19, 10, 19, '2021-10-05 17:55:25', '2021-10-05 17:55:25'),
(20, 10, 20, '2021-10-05 17:55:25', '2021-10-05 17:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `useraddress`
--

CREATE TABLE `useraddress` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `addressLine1` varchar(50) NOT NULL,
  `addressLine2` varchar(50) DEFAULT NULL,
  `city` varchar(30) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `country` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

CREATE TABLE `userdetails` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `contactNo` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `roles` varchar(10) NOT NULL DEFAULT 'user',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`id`, `username`, `password`, `name`, `contactNo`, `email`, `roles`, `createdAt`, `updatedAt`) VALUES
(1, 'raj', '$2y$10$88QFq40mOecg4riuiT95nujpx.vimOaL.k1.iKEefgRQZw4.Uf30K', 'Raj patel', '123456789', 'raj@gmail.com', 'admin', '2021-12-14 23:49:01', '2021-12-15 05:58:24'),
(2, 'parth', '$2y$10$dhqK2xwLv/yMGcTTibMn..iwoeKOCfRbE/giGEaxp.48N2y0hEM.C', 'parth', '245632105', 'parth@gmail.com', 'user', '2021-12-14 23:50:19', '2021-12-14 23:50:55'),
(3, 'bhavik', '$2y$10$MRMP/vkdoOlo6vlVL7uldeMrvOhbH9XcG62AXmwBFGgjKMDmk/Qei', 'bhavik Patel', '5648791320', 'abc@abc.com', 'user', '2021-12-15 01:27:46', '2021-12-15 01:27:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `statusID` (`statusID`);

--
-- Indexes for table `orderedproducts`
--
ALTER TABLE `orderedproducts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productId` (`productId`),
  ADD KEY `orderId` (`orderId`);

--
-- Indexes for table `orderstatus`
--
ALTER TABLE `orderstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FOREIGNCAT` (`categoryId`),
  ADD KEY `FOREIGNCOM` (`companyId`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FOREIGNPRO` (`productId`);

--
-- Indexes for table `useraddress`
--
ALTER TABLE `useraddress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_userConstraint` (`userId`);

--
-- Indexes for table `userdetails`
--
ALTER TABLE `userdetails`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orderedproducts`
--
ALTER TABLE `orderedproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orderstatus`
--
ALTER TABLE `orderstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `useraddress`
--
ALTER TABLE `useraddress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `userdetails` (`id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`statusID`) REFERENCES `orderstatus` (`id`);

--
-- Constraints for table `orderedproducts`
--
ALTER TABLE `orderedproducts`
  ADD CONSTRAINT `orderedproducts_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `orderedproducts_ibfk_2` FOREIGN KEY (`orderId`) REFERENCES `order` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FOREIGNCAT` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FOREIGNCOM` FOREIGN KEY (`companyId`) REFERENCES `company` (`id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `FOREIGNPRO` FOREIGN KEY (`productId`) REFERENCES `product` (`id`);

--
-- Constraints for table `useraddress`
--
ALTER TABLE `useraddress`
  ADD CONSTRAINT `fk_userConstraint` FOREIGN KEY (`userId`) REFERENCES `userdetails` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
