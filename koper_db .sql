-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.13.0.7147
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for koper_db
CREATE DATABASE IF NOT EXISTS `koper_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `koper_db`;

-- Dumping structure for table koper_db.detail_pesanan
CREATE TABLE IF NOT EXISTS `detail_pesanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pesanan_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `nama_produk` varchar(200) NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pesanan_id` (`pesanan_id`),
  KEY `produk_id` (`produk_id`),
  CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`),
  CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table koper_db.detail_pesanan: ~0 rows (approximately)

-- Dumping structure for table koper_db.kategori
CREATE TABLE IF NOT EXISTS `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `ikon` varchar(50) DEFAULT 'fas fa-suitcase',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table koper_db.kategori: ~5 rows (approximately)
INSERT INTO `kategori` (`id`, `nama`, `slug`, `ikon`, `created_at`) VALUES
	(1, 'Koper Kabin', 'kabin', 'fas fa-plane', '2026-04-30 14:15:12'),
	(2, 'Koper Medium', 'medium', 'fas fa-suitcase', '2026-04-30 14:15:12'),
	(3, 'Koper Besar', 'besar', 'fas fa-suitcase-rolling', '2026-04-30 14:15:12'),
	(4, 'Koper Set', 'set', 'fas fa-layer-group', '2026-04-30 14:15:12'),
	(5, 'Aksesoris', 'aksesoris', 'fas fa-tag', '2026-04-30 14:15:12');

-- Dumping structure for table koper_db.kontak
CREATE TABLE IF NOT EXISTS `kontak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subjek` varchar(200) DEFAULT NULL,
  `pesan` text NOT NULL,
  `sudah_dibaca` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table koper_db.kontak: ~3 rows (approximately)
INSERT INTO `kontak` (`id`, `nama`, `email`, `subjek`, `pesan`, `sudah_dibaca`, `created_at`) VALUES
	(1, 'siap', 'oke@gmail.com', 'Pertanyaan Produk', 'siapsiap', 0, '2026-05-01 02:58:12'),
	(2, 'siap', 'oke@gmail.com', 'Pertanyaan Produk', 'asdasd', 0, '2026-05-01 08:58:55'),
	(3, 'jojo', 'jojo@gmail.com', 'Pertanyaan Produk', 'kenapa ya begini', 0, '2026-05-01 10:01:56');

-- Dumping structure for table koper_db.pelanggan
CREATE TABLE IF NOT EXISTS `pelanggan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table koper_db.pelanggan: ~0 rows (approximately)

-- Dumping structure for table koper_db.pesanan
CREATE TABLE IF NOT EXISTS `pesanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pesanan` varchar(20) NOT NULL,
  `pelanggan_id` int(11) DEFAULT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `email_pemesan` varchar(150) NOT NULL,
  `telepon_pemesan` varchar(20) NOT NULL,
  `alamat_kirim` text NOT NULL,
  `kota_kirim` varchar(100) NOT NULL,
  `provinsi_kirim` varchar(100) NOT NULL,
  `kode_pos_kirim` varchar(10) DEFAULT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `ongkos_kirim` decimal(12,2) DEFAULT 0.00,
  `total_bayar` decimal(12,2) NOT NULL,
  `metode_bayar` varchar(50) DEFAULT NULL,
  `status` enum('pending','dikonfirmasi','diproses','dikirim','selesai','dibatalkan') DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_pesanan` (`kode_pesanan`),
  KEY `pelanggan_id` (`pelanggan_id`),
  CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table koper_db.pesanan: ~0 rows (approximately)

-- Dumping structure for table koper_db.produk
CREATE TABLE IF NOT EXISTS `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(12,2) NOT NULL,
  `harga_coret` decimal(12,2) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `berat` varchar(50) DEFAULT NULL,
  `dimensi` varchar(100) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `warna` varchar(200) DEFAULT NULL,
  `garansi` varchar(100) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT 'default.jpg',
  `rating` decimal(3,2) DEFAULT 5.00,
  `terjual` int(11) DEFAULT 0,
  `featured` tinyint(1) DEFAULT 0,
  `aktif` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `link_produk` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `kategori_id` (`kategori_id`),
  CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table koper_db.produk: ~9 rows (approximately)
INSERT INTO `produk` (`id`, `kategori_id`, `nama`, `slug`, `deskripsi`, `harga`, `harga_coret`, `stok`, `berat`, `dimensi`, `material`, `warna`, `garansi`, `gambar`, `rating`, `terjual`, `featured`, `aktif`, `created_at`, `link_produk`) VALUES
	(1, 1, 'Koper Pro 20" Kabin', 'luxetravel-pro-20-kabin', 'Koper kabin premium dengan teknologi TSA Lock terbaru. Desain sleek dengan material Polycarbonate ringan namun sangat kuat. Cocok untuk perjalanan bisnis maupun liburan singkat.', 1250000.00, NULL, 50, '2.8 kg', '55x35x22 cm', 'Polycarbonate ABS', 'Navy Blue, Silver, Black, Red', '1 Tahun Garansi Resmi', 'koper4.png', 4.80, 234, 1, 1, '2026-04-30 14:15:12', 'https://shopee.co.id/'),
	(2, 1, 'AeroLite Spinner 20" Kabin', 'aerolite-spinner-20-kabin', 'Koper kabin ultra-ringan dengan 4 roda 360° spinner. Dilengkapi TSA Combination Lock dan kompartemen organizer yang luas.', 875000.00, NULL, 35, '2.3 kg', '54x34x21 cm', 'ABS Hardshell', 'Rose Gold, Mint Green, Navy', '6 Bulan Garansi', 'kabin2.svg', 4.60, 189, 1, 1, '2026-04-30 14:15:12', 'https://shopee.co.id/'),
	(3, 2, 'LuxeTravel Pro 24" Medium', 'luxetravel-pro-24-medium', 'Koper medium serbaguna dengan kapasitas besar. Dilengkapi expander 15% untuk oleh-oleh berlebih. Roda double spinner anti-gores untuk berbagai medan.', 1650000.00, NULL, 40, '3.5 kg', '65x45x27 cm', 'Polycarbonate', 'Champagne Gold, Midnight Blue, Charcoal', '1 Tahun Garansi Resmi', 'koper_besar.png', 4.90, 312, 1, 1, '2026-04-30 14:15:12', 'https://shopee.co.id/'),
	(4, 2, 'Explorer Series 24" Medium', 'explorer-series-24-medium', 'Koper medium dengan desain tekstur berlian yang elegan. Anti-scratch premium surface. Dilengkapi divider internal dan shoe bag.', 1150000.00, NULL, 45, '3.2 kg', '64x44x26 cm', 'ABS + PC Blend', 'Diamond Silver, Bronze, Black', '1 Tahun Garansi', 'medium2.svg', 4.70, 156, 0, 1, '2026-04-30 14:15:12', 'https://shopee.co.id/'),
	(5, 3, 'LuxeTravel Pro 28" Besar', 'luxetravel-pro-28-besar', 'Koper besar untuk perjalanan panjang. Kapasitas 110L dengan sistem packing yang terorganisir. TSA Lock + kunci kombinasi tambahan.', 2100000.00, NULL, 30, '4.2 kg', '75x50x30 cm', 'Polycarbonate Premium', 'Navy Royal, Burgundy, Space Gray', '2 Tahun Garansi Resmi', 'besar1.svg', 4.90, 428, 1, 1, '2026-04-30 14:15:12', 'https://shopee.co.id/'),
	(6, 3, 'MaxCapacity 28" Besar', 'maxcapacity-28-besar', 'Koper besar kapasitas jumbo 120L. Ideal untuk family trip atau perjalanan panjang. Roda ganda anti-gores dengan pegangan aluminium teleskopik.', 1450000.00, NULL, 25, '4.8 kg', '77x51x31 cm', 'ABS Hard Case', 'Ivory White, Steel Blue, Black', '1 Tahun Garansi', 'besar2.svg', 4.50, 98, 0, 1, '2026-04-30 14:15:12', 'https://id.shp.ee/L7NixxRj'),
	(7, 4, 'LuxeTravel Set 3in1 (20"+24"+28")', 'luxetravel-set-3in1', 'Paket lengkap 3 koper premium dalam satu set. Desain matching dengan material Polycarbonate ringan. Hemat hingga 40% dibanding beli satuan.', 4500000.00, NULL, 20, '10.5 kg', 'Set 3 Koper', 'Polycarbonate ABS', 'Navy Blue, Silver Set, Black Set', '1 Tahun Garansi Resmi per koper', 'set1.svg', 5.00, 87, 1, 1, '2026-04-30 14:15:12', 'https://shopee.co.id/'),
	(8, 5, 'Koper Cover Protector', 'koper-cover-protector', 'Pelindung koper anti-gores dan anti-air. Material spandex elastis, mudah dipasang dan dilepas. Tersedia untuk semua ukuran koper.', 120000.00, NULL, 100, '0.2 kg', 'S/M/L/XL', 'Spandex Premium', 'Berbagai motif dan warna', NULL, 'aksesoris1.svg', 4.40, 543, 0, 1, '2026-04-30 14:15:12', 'https://shopee.co.id/'),
	(9, 5, 'TSA Kunci Gembok Kombinasi', 'tsa-kunci-gembok-kombinasi', 'Gembok TSA approved dengan 3-digit kombinasi. Aman untuk penerbangan internasional. Material zinc alloy tahan karat.', 85000.00, NULL, 150, '0.08 kg', '3.5x3x1.2 cm', 'Zinc Alloy', 'Silver, Emas, Hitam', NULL, 'aksesoris2.svg', 4.60, 892, 0, 1, '2026-04-30 14:15:12', 'https://shopee.co.id/');

-- Dumping structure for table koper_db.ulasan
CREATE TABLE IF NOT EXISTS `ulasan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produk_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `komentar` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `produk_id` (`produk_id`),
  CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table koper_db.ulasan: ~8 rows (approximately)
INSERT INTO `ulasan` (`id`, `produk_id`, `nama`, `rating`, `komentar`, `created_at`) VALUES
	(1, 1, 'Budi Santoso', 5, 'Koper ini luar biasa! Ringan, kuat, dan tampilannya mewah. Sudah dipakai ke Eropa dan kondisinya masih bagus. Highly recommended!', '2026-04-30 14:15:12'),
	(2, 1, 'Sari Dewi', 5, 'Beli untuk keperluan bisnis, sangat puas. Muat banyak tapi tetap ringan. TSA Lock-nya juga mudah digunakan.', '2026-04-30 14:15:12'),
	(3, 3, 'Ahmad Fauzi', 5, 'Koper medium terbaik yang pernah saya punya. Harga sebanding dengan kualitas. Roda putarnya halus banget.', '2026-04-30 14:15:12'),
	(4, 5, 'Rina Kusuma', 5, 'Ini koper impian saya! Beli set 3in1 sangat worth it. Kualitas premium, desain elegan. Siap untuk keliling dunia!', '2026-04-30 14:15:12'),
	(5, 7, 'Doni Pratama', 5, 'Set koper terlengkap dan terbaik. Harga hemat, kualitas premium. Pengiriman juga cepat dan packaging aman.', '2026-04-30 14:15:12'),
	(6, 4, 'YASPI', 5, 'yy', '2026-05-01 03:59:51'),
	(7, 5, 'jojo', 5, 'bagus blabla', '2026-05-01 09:59:13'),
	(8, 8, 'siapa ya', 4, 'asdasd', '2026-05-01 10:00:04');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
