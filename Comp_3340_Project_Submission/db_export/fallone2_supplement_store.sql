-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 02, 2025 at 08:45 PM
-- Server version: 10.4.34-MariaDB-log
-- PHP Version: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fallone2_supplement_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `user_id`, `product_name`, `product_price`, `quantity`) VALUES
(27, 1, 5, 'PROHD Brownie Flavour', 64.99, 6);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `shipping_address` text DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total`, `status`, `shipping_address`, `payment_method`) VALUES
(18, 5, '2025-08-02 11:47:09', 64.99, 'Pending', 'University of Windsor', 'Credit Card'),
(19, 5, '2025-08-02 11:59:12', 154.97, 'Pending', 'University of Windsor', 'Credit Card'),
(20, 5, '2025-08-02 13:14:41', 54.99, 'Pending', 'University of Windsor', 'Credit Card'),
(21, 5, '2025-08-02 14:05:44', 129.98, 'Pending', 'University of Windsor', 'Credit Card'),
(22, 5, '2025-08-02 14:21:46', 64.99, 'Pending', 'University of Windsor', 'Credit Card'),
(23, 5, '2025-08-02 14:27:23', 174.97, 'Pending', 'University of Windsor', 'Credit Card'),
(24, 5, '2025-08-02 14:44:02', 254.95, 'Pending', 'University of Windsor', 'Credit Card'),
(25, 4, '2025-08-02 18:23:19', 64.99, 'Pending', 'University of Windsor', 'Credit Card'),
(26, 4, '2025-08-02 18:24:48', 292.88, 'Pending', 'University of Windsor', 'Credit Card');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`) VALUES
(1, 4, 0, 'PROHD Brownie Flavour', 40, 64.99),
(2, 4, 0, 'Peach Flavour', 1, 49.99),
(3, 4, 0, 'Pineapple Flavour', 1, 59.99),
(4, 7, 1, 'PROHD Brownie Flavour', 3, 64.99),
(5, 8, 5, 'Blueraspberry', 9, 24.99),
(6, 9, 2, 'Pineapple Flavour', 1, 59.99),
(7, 10, 1, 'PROHD Brownie Flavour', 1, 64.99),
(8, 11, 1, 'PROHD Brownie Flavour', 1, 64.99),
(9, 12, 1, 'PROHD Brownie Flavour', 1, 64.99),
(10, 13, 1, 'PROHD Brownie Flavour', 2, 64.99),
(11, 14, 1, 'PROHD Brownie Flavour', 2, 64.99),
(12, 15, 1, 'PROHD Brownie Flavour', 1, 64.99),
(13, 16, 1, 'PROHD Brownie Flavour', 1, 64.99),
(14, 17, 1, 'PROHD Brownie Flavour', 1, 64.99),
(15, 18, 1, 'PROHD Brownie Flavour', 1, 64.99),
(16, 19, 1, 'PROHD Brownie Flavour', 2, 64.99),
(17, 19, 5, 'Blueraspberry', 1, 24.99),
(18, 20, 3, 'Raspberry Lemonade Flavour', 1, 54.99),
(19, 21, 1, 'PROHD Brownie Flavour', 2, 64.99),
(20, 22, 1, 'PROHD Brownie Flavour', 1, 64.99),
(21, 23, 1, 'PROHD Brownie Flavour', 1, 64.99),
(22, 23, 3, 'Raspberry Lemonade Flavour', 2, 54.99),
(23, 24, 1, 'PROHD Brownie Flavour', 1, 64.99),
(24, 24, 5, 'Blueraspberry', 1, 24.99),
(25, 24, 3, 'Watermelon Flavour', 3, 54.99),
(26, 25, 1, 'PROHD Brownie Flavour', 1, 64.99),
(27, 26, 7, 'Peanut Butter Cup', 1, 27.99),
(28, 26, 6, 'Lychee Flavour', 1, 64.99),
(29, 26, 17, 'NAC (60 servings)', 10, 19.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `image`) VALUES
(1, 'PROHD', '100% grass-fed whey isolate', 64.99, 'images/protein_powder/prohd_brownie.jpg'),
(2, 'Carb Powders', 'clean carb source for on the go', 59.99, 'images/carb_powder/carb_pineapple.jpg'),
(3, 'Intra Workout', 'Everything you need during you workout for optimal intensity', 54.99, 'images/intra_workout/rasplem.jpg'),
(4, 'EAAs', 'All of the essential amino acids your body needs', 49.99, 'images/eaas/peach.jpg'),
(5, 'L-Carnitine', 'Helping you burn fat for fuel', 24.99, 'images/carnitine/blueras.jpg'),
(6, 'Pre-workout', 'Providing ample energy and intention for your workout', 64.99, 'images/preworkout/strawmango.jpg'),
(7, 'Cream of Rice', 'Helping you stay on diet with great tasting, diet-friendly hot-cereal', 24.99, 'images/cor/cookiebutter.jpg'),
(8, 'Liver Support', 'For the maintenance of good-liver function', 74.95, 'images/liver.jpg'),
(9, 'Kidney Support', 'For the maintenance of good-kidney function', 79.95, 'images/kidney.jpg'),
(10, 'Glutamine', 'For increasing efficient workout recovery', 26.99, 'images/gluta.jpg'),
(11, 'Sleep Aid', 'Helping optimize sleep time and quality', 59.99, 'images/sleep.jpg'),
(12, 'Multivitamin', 'For the maintenance of overall health', 104.99, 'images/vita.jpg'),
(13, 'Omega-3', 'For supporting cardiovascular and cognitive function', 39.99, 'images/omega.jpg'),
(14, 'Citrus Bergamot', 'For improving cholesterol and triglycerides', 53.99, 'images/citrusberg.jpg'),
(15, 'Creatine', 'For supporting energy production and muscle growth', 54.99, 'images/creatine.jpg'),
(16, 'KSM-66', 'For reducing oxidative stress', 24.99, 'images/ksm.jpg'),
(17, 'NAC (N-acetyl L-cysteine)', 'For healthy support of liver and glutathione production', 19.99, 'images/nac.jpg'),
(18, 'Collagen', 'For promoting skin health', 39.99, 'images/collagen.jpg'),
(19, 'Probiotic', 'For promoting good gut-health', 49.99, 'images/probiotic.jpg'),
(20, 'Vitamin D-3', 'Helps promote optimal nutrient absorption', 24.99, 'images/d3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_versions`
--

CREATE TABLE `product_versions` (
  `version_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_versions`
--

INSERT INTO `product_versions` (`version_id`, `product_id`, `name`, `price`, `image`) VALUES
(1, 1, 'PROHD Brownie Flavour', 64.99, 'images/protein_powder/prohd_brownie.jpg'),
(2, 1, 'PROHD Birthday Cake Flavour', 64.99, 'images/protein_powder/prohd_cake.jpg'),
(3, 1, 'PROHD Mango Flavour', 64.99, 'images/protein_powder/prohd_mango.jpeg'),
(4, 2, 'Pineapple Flavour', 59.99, 'images/carb_powder/carb_pineapple.jpg'),
(5, 2, 'Peach Flavour', 59.99, 'images/carb_powder/carb_peach.jpg'),
(6, 3, 'Raspberry Lemonade Flavour', 54.99, 'images/intra_workout/rasplem.jpg'),
(7, 3, 'Watermelon Flavour', 54.99, 'images/intra_workout/watermelon.jpg'),
(8, 4, 'Peach Flavour', 49.99, 'images/eaas/peach.jpg'),
(9, 4, 'Unflavoured', 49.99, 'images/eaas/unflavoured.jpg'),
(10, 5, 'Blueraspberry', 24.99, 'images/carnitine/blueras.jpg'),
(11, 5, 'Fruit Punch', 24.99, 'images/carnitine/fruitpunch.jpg'),
(12, 6, 'Strawberry Mango Flavour', 64.99, 'images/preworkout/strawmango.jpg'),
(13, 6, 'Lychee Flavour', 64.99, 'images/preworkout/lychee.jpg'),
(14, 7, 'Cookie Butter', 27.99, 'images/cor/cookiebutter.jpg'),
(15, 7, 'Peanut Butter Cup', 27.99, 'images/cor/pbcup.jpg'),
(16, 8, 'Liver Support(60 servings)', 74.95, 'images/liver.jpg'),
(17, 8, 'Liver Support(120 servings)', 129.95, 'images/liver.jpg'),
(18, 9, 'Kidney Supplement(60 servings)', 79.95, 'images/kidney.jpg'),
(19, 9, 'Kidney Support(120 servings)', 134.95, 'images/kidney.jpg'),
(20, 10, 'Glutamine(30 servings)', 26.99, 'images/gluta.jpg'),
(21, 10, 'Glutamine(60 servings)', 26.99, 'images/gluta.jpg'),
(22, 11, 'Sleep Aid(60 servings)', 59.99, 'images/sleep.jpg'),
(23, 11, 'Sleep Aid(120 servings)', 99.99, 'images/sleep.jpg'),
(24, 12, 'Multivitamin(60 servings)', 104.99, 'images/vita.jpg'),
(25, 12, 'Sleep Aid(120 servings)', 199.99, 'images/vita.jpg'),
(26, 13, 'Omega-3(60 servings)', 39.99, 'images/omega.jpg'),
(27, 13, 'Omega-3(120 servings)', 72.99, 'images/omega.jpg'),
(28, 14, 'Citrus Bergamot(60 servings)', 53.99, 'images/citrusberg.jpg'),
(29, 14, 'Citrus Bergamot(120 servings)', 99.99, 'images/citrusberg.jpg'),
(30, 15, 'Creatine(75 servings)', 54.99, 'images/creatine.jpg'),
(31, 15, 'Creatine(150 servings)', 79.99, 'images/creatine.jpg'),
(32, 16, 'KSM-66(60 servings)', 24.99, 'images/ksm.jpg'),
(33, 16, 'KSM-66(120 servings)', 49.99, 'images/ksm.jpg'),
(34, 17, 'NAC (60 servings)', 19.99, 'images/nac.jpg'),
(35, 17, 'NAC (120 servings)', 39.99, 'images/nac.jpg'),
(36, 18, 'Collagen (30 servings)', 39.99, 'images/collagen.jpg'),
(37, 18, 'Collagen (60 servings)', 59.99, 'images/collagen.jpg'),
(38, 19, 'Probiotic (30 servings)', 39.99, 'images/probiotic.jpg'),
(39, 19, 'Probiotic (60 servings)', 69.99, 'images/probiotic.jpg'),
(40, 20, 'D3 (30 servings)', 39.99, 'images/d3.jpg'),
(41, 20, 'D3 (60 servings)', 39.99, 'images/d3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0,
  `disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `email`, `created_at`, `is_admin`, `disabled`) VALUES
(1, 'adrian', '$2y$10$mZAR2b.uVRgEeT3lonRIJevdGy/u0ubpgQRncGos9JIXFr/k7nmpO', NULL, '2025-07-31 20:06:23', 1, 0),
(4, 'liam', '$2y$10$zarRJBas8PIyQlEEWmTXqOb.3BzoYtPlJG8jqa/h/xBern93ZCrKa', NULL, '2025-07-31 20:07:35', 0, 0),
(5, 'adrianno', '$2y$10$MfSImhsKRYPYzNtUQ6whlef72FU53YKMRF8C053.608B2TLC1AMsK', NULL, '2025-08-02 01:08:43', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_versions`
--
ALTER TABLE `product_versions`
  ADD PRIMARY KEY (`version_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_versions`
--
ALTER TABLE `product_versions`
  MODIFY `version_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `product_versions`
--
ALTER TABLE `product_versions`
  ADD CONSTRAINT `product_versions_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
