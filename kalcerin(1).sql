-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2025 at 05:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kalcerin`
--

-- --------------------------------------------------------

--
-- Table structure for table `favorit`
--

CREATE TABLE `favorit` (
  `id` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `products_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorit`
--

INSERT INTO `favorit` (`id`, `id_pelanggan`, `products_id`) VALUES
(12, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `total` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Berhasil',
  `metode_pembayaran` varchar(20) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id_order`, `nama_pelanggan`, `email`, `total`, `status`, `metode_pembayaran`, `tanggal`) VALUES
(1, 'siapis', 'kiel123@gmail.com', 1099000, 'Berhasil', 'va', '2025-11-20 21:10:22'),
(2, 'Yehezkiel Hatoguan Siahaan', 'kiel123@gmail.com', 899000, 'Berhasil', 'va', '2025-11-20 21:13:54'),
(3, 'Kiel', 'kiel123@gmail.com', 3300000, 'Berhasil', 'va', '2025-11-20 21:55:06');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id_detail` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `warna` varchar(100) DEFAULT NULL,
  `ukuran` varchar(100) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `warna` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ukuran` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `brand`, `image`, `deskripsi`, `warna`, `ukuran`, `rating`, `stok`) VALUES
(1, 'Nike Air Force 1', 1729000, 'Nike', 'https://placehold.co/400x300/EAF2F8/333?text=Nike+Air', 'Sneakers klasik dengan desain ikonik dan bantalan empuk.', '[\"Putih\",\"Hitam\"]', '[40,41,42,43,44]', 4.8, 21),
(2, 'Adidas Ultraboost', 3300000, 'Adidas', 'https://placehold.co/400x300/E8F6F3/333?text=Adidas+Runner', 'Sepatu lari dengan teknologi Boost yang empuk dan responsif.', '[\"Hitam\",\"Abu-abu\"]', '[39,40,41,42,43]', 4.9, 29),
(3, 'Vans Old Skool', 1099000, 'Vans', 'https://placehold.co/400x300/FEF9E7/333?text=Vans+Classic', 'Sneakers klasik bergaya streetwear.', '[\"Hitam-White\", \"Navy\"]', '[38, 39, 40, 41, 42, 43]', 4.6, 20),
(4, 'Puma Suede Classic', 899000, 'Puma', 'https://placehold.co/400x300/FFF5E5/333?text=Puma+Suede', 'Sepatu suede klasik dengan tampilan elegan.', '[\"Merah\",\"Hitam\",\"Biru\"]', '[39,40,41,42]', 4.4, 100),
(5, 'Converse Chuck Taylor', 799000, 'Converse', 'https://placehold.co/400x300/F0F0F0/333?text=Converse+All+Star', 'Sneakers canvas legendaris yang cocok untuk segala gaya.', '[\"Putih\",\"Hitam\",\"Maroon\"]', '[38,39,40,41,42,43,44]', 4.7, 54),
(6, 'Reebok Classic Leather', 1299000, 'Reebok', 'https://placehold.co/400x300/EDEDED/333?text=Reebok+Classic', 'Sepatu retro dengan kulit premium yang nyaman.', '[\"Putih\",\"Hitam\"]', '[40,41,42,43]', 4.5, 60),
(7, 'Asics Gel-Kayano', 2499000, 'Asics', 'https://placehold.co/400x300/DFF0D8/333?text=Asics+Gel-Kayano', 'Sepatu running premium dengan teknologi Gel untuk kenyamanan maksimal.', '[\"Hitam\",\"Biru\"]', '[40,41,42,43,44]', 4.9, 65),
(8, 'New Balance 550', 2099000, 'New Balance', 'https://placehold.co/400x300/F5EEF8/333?text=New+Balance', 'Sneakers retro dengan desain bulky yang sedang tren.', '[\"Putih-Hijau\",\"Putih-Biru\"]', '[39,40,41,42,43]', 4.6, 71),
(16, 'Mills Ultras Dreamer', 230000, 'Mills', 'prod_691d3b24612679.23753931.png', 'Sepatu', '[\"Biru\",\"Merah\"]', '[38,39,40,41]', 4.8, 22);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_pelanggan` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `whatsapp` char(13) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_pelanggan`, `fullname`, `email`, `foto_profil`, `whatsapp`, `password`, `role`) VALUES
(1, 'Tsani', 'muhammadazarustsani@gmail.com', NULL, '085815899591', '$2y$10$GlsoYZKBye2YJEFqX4EPO.tY9NXVLuSrIzg2zEXEfaWb/IfkUnkh2', 'user'),
(2, 'Azharus Tsani', 'user1@gmail.com', NULL, '085815899591', '$2y$10$L4cfkv3TnpSewVOwtW2sQ.EMz7e1BXhlWCwJ7mC7r2pUMecR.8jXq', 'admin'),
(3, 'samuel', 'user2@gmail.com', NULL, '085815899591', '$2y$10$5quYlFn0fcTshWYb4trGHufo1Lygc7Rm5pZkpR/agGsq1IdVPwRvO', 'admin'),
(4, 'Kiel', 'user3@gmail.com', NULL, '085815899591', '$2y$10$hynXDjcK/uASarbUr96/SuPijWanQqy0s.W4yq9M6H4fT7wn72WbO', 'user'),
(5, 'Arkadian', 'user4@gmail.com', NULL, '085815899591', '$2y$10$Ceu4hCvSEXLkO5DN7iWDjOPoMLnghdeGPEgYuJYvTAxEKjSVeFeQu', 'user'),
(6, 'Noel Anggit', 'user5@gmail.com', NULL, '085815899591', '$2y$10$l89.frRmiue1EdN5hsfMRu4i40K3cpB1tD.6NEuR05alTj4tNmF8q', 'user'),
(7, 'noel', 'noel@gmail.com', NULL, '081326069359', '$2y$10$dJsnDXjdstgSHYKs2SgGVOT1KIGVS0K50GtRArO2O9Wet9KQLC1Om', 'user'),
(8, 'Yehezkiel Hatoguan Siahaan', 'kiel123@gmail.com', NULL, '081234567890', '$2y$10$mIE4k/3ETEuKjpuDXFw08.ITAlMCjJrH6j2ZLwncLg2Z8weI6iU4W', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favorit`
--
ALTER TABLE `favorit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_favorit` (`id_pelanggan`,`products_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_review` (`product_id`,`id_pelanggan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favorit`
--
ALTER TABLE `favorit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorit`
--
ALTER TABLE `favorit`
  ADD CONSTRAINT `favorit_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `user` (`id_pelanggan`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorit_ibfk_2` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `user` (`id_pelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
