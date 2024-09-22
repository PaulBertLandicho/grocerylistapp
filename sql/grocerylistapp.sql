-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2024 at 07:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grocerylistapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `order_date`) VALUES
(8, NULL, NULL, 1, '2024-09-07 07:10:10'),
(156, NULL, NULL, 2, '2024-09-17 03:38:43'),
(186, 5, 27, 1, '2024-09-17 10:18:41'),
(187, 5, 28, 1, '2024-09-17 10:18:44'),
(223, 2, 62, 1, '2024-09-19 17:12:05');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(0, ''),
(1, 'Fruits'),
(2, 'Protein'),
(3, 'Snack'),
(4, 'Beverage'),
(5, 'Seafood'),
(6, 'Baking'),
(7, 'Vegetables');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(5, '0', '38', '2024-09-09 00:08:54'),
(6, '0', '41', '2024-09-09 04:45:56'),
(7, '0', '39', '2024-09-09 06:24:04'),
(8, '0', '40', '2024-09-09 08:24:03'),
(9, '4', '42', '2024-09-09 16:44:02'),
(47, '2', '4', '2024-09-13 09:14:43'),
(54, '2', '14', '2024-09-16 05:12:23'),
(55, '2', '15', '2024-09-17 07:01:46'),
(109, '5', '21', '2024-09-17 10:16:24'),
(110, '5', '24', '2024-09-17 10:16:26'),
(112, '5', '28', '2024-09-17 10:18:05'),
(114, '5', '18', '2024-09-17 10:32:27'),
(141, '2', '29', '2024-09-18 16:28:11'),
(142, '2', '33', '2024-09-18 16:28:16'),
(143, '2', '34', '2024-09-18 17:45:23'),
(144, '2', '29', '2024-09-18 17:45:25'),
(145, '2', '33', '2024-09-18 17:45:26'),
(164, '2', '57', '2024-09-19 17:11:52');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL DEFAULT 'Unknown',
  `image` varchar(255) DEFAULT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1,
  `purchased` tinyint(1) DEFAULT 0,
  `store` varchar(255) NOT NULL DEFAULT 'Unknown'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `category_id`, `brand`, `image`, `weight`, `available`, `purchased`, `store`) VALUES
(40, 'Mineral Water', 25.00, 4, 'Absolute', 'uploads/water.jfif', '350ml', 1, 0, 'FK Mart'),
(42, 'Naked Whey', 130.00, 2, 'protein', 'uploads/protein.jfif', '250ml', 1, 0, 'Robenson'),
(44, 'Coke', 95.00, 4, 'Coca-cola', 'uploads/coke_1.25L_1200x.webp', '1.25 L', 1, 0, 'FK Mart'),
(45, 'Bulad', 75.00, 5, 'Unknown', 'uploads/bulad.jfif', '1kg', 1, 0, 'Bularan-saray'),
(46, 'Tamban', 100.00, 5, 'Unknown', 'uploads/tamban.jpg', '1kg', 1, 0, 'Supermarket'),
(47, 'Pure Protein', 250.00, 2, 'Protein', 'uploads/pure protein.webp', '574g', 1, 0, 'Robenson'),
(48, 'Cheezy', 23.00, 3, 'leslie', 'uploads/Cheezy-Corn-Crunch-Snack-70g--500x500-product_popup_500x500.webp', '70g', 1, 0, 'FK Mart'),
(50, 'Shakoy', 10.00, 6, 'Unknown', 'uploads/shakoy.jfif', '1kg', 1, 0, 'Madelicious '),
(51, 'Donut', 45.00, 6, 'Unknown', 'uploads/donut.jfif', '28g ', 1, 0, 'Dunkin Donuts'),
(53, 'Carrots', 30.00, 7, 'Unknown', 'uploads/carrots.jfif', '1kg', 1, 0, 'Supermarket'),
(54, 'Eggplant', 20.00, 7, 'Unknown', 'uploads/eggplant.png.jfif', '1kg', 1, 0, 'Supermarket'),
(56, 'Watemelon', 80.00, 1, 'unkown', 'uploads/watermelon.jfif', '1kg', 1, 0, 'Supermarket'),
(57, 'Banana', 45.00, 1, 'Unknown', 'uploads/banana.jfif', '1kg', 1, 0, 'Supermarket'),
(58, 'Biscuit', 12.00, 3, 'Rebisco', 'uploads/biscuit.jfif', '32g', 1, 0, 'FK Mart'),
(59, 'Red Horse', 130.00, 4, 'San Miguel Pale Pilsen', 'uploads/redhorse.jfif', '500ml', 1, 0, 'FK Mart'),
(62, 'Apple', 30.00, 1, 'Unknown', 'uploads/apple.jpg', '1kg', 1, 0, 'FK Mart');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT 'defaultprofile.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `profile_picture`) VALUES
(2, 'PaulBert', 'landicho@gmail', '$2y$10$BGK657gPH.8PiVACUqyUWeGDJ1z6c1vFlG5YupVP15tsMa6pbK1v.', 'profile_2.jpg'),
(5, 'romarc', 'romarc@gmail.com', '$2y$10$A5y9cq8jS7vPWNlzO7tYUeQtd2tHtjL7ESxZkzX4W2o8O3.jll9qe', 'defaultprofile.jpg'),
--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
