-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 10, 2026 at 05:23 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boto_delphi`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_balances`
--

CREATE TABLE `account_balances` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beneficiaries`
--

CREATE TABLE `beneficiaries` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `origin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `dob` date DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `allergies` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sppg_id` bigint UNSIGNED DEFAULT NULL,
  `marga` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posyandu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `beneficiary_group_id` bigint UNSIGNED DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `portion_large` int NOT NULL DEFAULT '0',
  `portion_small` int NOT NULL DEFAULT '0',
  `sppg_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beneficiary_groups`
--

CREATE TABLE `beneficiary_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `total_beneficiaries` int NOT NULL DEFAULT '0',
  `sppg_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `portion_large` int NOT NULL DEFAULT '0',
  `portion_small` int NOT NULL DEFAULT '0',
  `porsi_besar` int UNSIGNED DEFAULT NULL COMMENT 'Jumlah porsi besar (siswa/balita)',
  `porsi_kecil` int UNSIGNED DEFAULT NULL COMMENT 'Jumlah porsi kecil (guru/staff)',
  `count_siswa` int UNSIGNED DEFAULT '0',
  `count_guru` int UNSIGNED DEFAULT '0',
  `count_hamil` int UNSIGNED DEFAULT '0',
  `count_menyusui` int UNSIGNED DEFAULT '0',
  `count_balita` int UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `beneficiary_groups`
--

INSERT INTO `beneficiary_groups` (`id`, `name`, `location`, `latitude`, `longitude`, `total_beneficiaries`, `sppg_id`, `created_at`, `updated_at`, `type`, `portion_large`, `portion_small`, `porsi_besar`, `porsi_kecil`, `count_siswa`, `count_guru`, `count_hamil`, `count_menyusui`, `count_balita`) VALUES
(32, 'SD 095560 Karang Sari', 'Karang Sari, Gunung Maligas', NULL, NULL, 164, 2, '2026-04-08 23:06:14', '2026-04-08 23:06:14', 'sekolah', 0, 0, 154, 10, 154, 10, 0, 0, 0),
(33, 'SD 091262 Karang Sari', 'Karang Sari, Gunung Maligas', NULL, NULL, 228, 2, '2026-04-08 23:06:14', '2026-04-08 23:06:14', 'sekolah', 0, 0, 210, 18, 210, 18, 0, 0, 0),
(34, 'SDN 096780 Kampung Tape', 'Kampung Tape, Gunung Maligas', NULL, NULL, 175, 2, '2026-04-08 23:06:14', '2026-04-08 23:06:14', 'sekolah', 0, 0, 165, 10, 165, 10, 0, 0, 0),
(35, 'SMP N 1 MALIGAS', 'Gunung Maligas', NULL, NULL, 411, 2, '2026-04-08 23:06:14', '2026-04-08 23:06:14', 'sekolah', 0, 0, 385, 26, 385, 26, 0, 0, 0),
(36, 'MIS AL FIKRI', 'Gunung Maligas', NULL, NULL, 113, 2, '2026-04-08 23:06:14', '2026-04-08 23:06:14', 'sekolah', 0, 0, 101, 12, 101, 12, 0, 0, 0),
(37, 'MIN 1 SUMALUNGUN', 'Simalungun', NULL, NULL, 402, 2, '2026-04-08 23:06:14', '2026-04-08 23:06:14', 'sekolah', 0, 0, 371, 31, 371, 31, 0, 0, 0),
(38, 'PAUD/TK AL-RIDHO', 'Gunung Maligas', NULL, NULL, 64, 2, '2026-04-08 23:06:14', '2026-04-08 23:06:14', 'sekolah', 0, 0, 58, 6, 58, 6, 0, 0, 0),
(39, 'SMP SATRYA BUDI', 'Gunung Maligas', NULL, NULL, 194, 2, '2026-04-08 23:06:14', '2026-04-08 23:06:14', 'sekolah', 0, 0, 181, 13, 181, 13, 0, 0, 0),
(40, 'SDN 097806 KARANG SARI', 'Karang Sari, Gunung Maligas', NULL, NULL, 103, 2, '2026-04-08 23:06:14', '2026-04-08 23:06:14', 'sekolah', 0, 0, 94, 9, 94, 9, 0, 0, 0),
(41, 'YAYASAN MAS BINAUL IMAN KARANG REJO', 'Karang Rejo', NULL, NULL, 204, 2, '2026-04-08 23:06:14', '2026-04-08 23:06:14', 'sekolah', 0, 0, 180, 24, 180, 24, 0, 0, 0),
(42, 'MTS BINAUL IMAN KARANG REJO', 'Karang Rejo', NULL, NULL, 261, 2, '2026-04-08 23:06:14', '2026-04-08 23:06:14', 'sekolah', 0, 0, 240, 21, 240, 21, 0, 0, 0),
(43, 'B3 KARANG REJO', 'Karang Rejo', NULL, NULL, 200, 2, '2026-04-08 23:06:14', '2026-04-08 23:06:14', 'posyandu', 0, 0, 114, 86, 0, 0, 34, 80, 86);

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `name`, `phone`, `type`, `description`, `photo_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Yoel zx', '85767610448', 'Keterlambatan Pengiriman', 'qxdqwdw', NULL, 'Menunggu', '2026-04-04 22:20:49', '2026-04-04 22:20:49');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`id`, `name`, `description`, `youtube_url`, `thumbnail_url`, `created_at`, `updated_at`) VALUES
(1, 'Nasi Putih', NULL, NULL, NULL, '2026-02-20 08:40:11', '2026-02-20 08:40:11'),
(2, 'Ayam Goreng Tepung', NULL, NULL, NULL, '2026-02-20 08:40:11', '2026-02-20 08:40:11'),
(3, 'Capcay', NULL, NULL, NULL, '2026-02-20 08:40:11', '2026-02-20 08:40:11'),
(4, 'Pepaya', NULL, NULL, NULL, '2026-02-20 08:40:11', '2026-02-20 08:40:11'),
(5, 'Ikan Nila Goreng', NULL, NULL, NULL, '2026-02-20 08:40:11', '2026-02-20 08:40:11'),
(6, 'Ikan Lele', NULL, NULL, NULL, '2026-02-20 08:40:11', '2026-02-20 08:40:11'),
(7, 'Tahu Goreng', NULL, NULL, NULL, '2026-02-20 08:40:11', '2026-02-20 08:40:11'),
(8, 'Tempe Goreng', NULL, NULL, NULL, '2026-02-20 08:40:11', '2026-02-20 08:40:11'),
(9, 'Telur semur', NULL, NULL, NULL, '2026-03-25 10:49:16', '2026-03-25 10:49:16');

-- --------------------------------------------------------

--
-- Table structure for table `dish_menu`
--

CREATE TABLE `dish_menu` (
  `id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED DEFAULT NULL,
  `dish_id` bigint UNSIGNED DEFAULT NULL,
  `portions` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `distribution_routes`
--

CREATE TABLE `distribution_routes` (
  `id` bigint UNSIGNED NOT NULL,
  `assistant_id` bigint UNSIGNED NOT NULL,
  `driver_id` bigint UNSIGNED NOT NULL,
  `sppg_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('planned','active','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'planned',
  `departure_time` timestamp NULL DEFAULT NULL,
  `departure_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `distribution_routes`
--

INSERT INTO `distribution_routes` (`id`, `assistant_id`, `driver_id`, `sppg_id`, `date`, `status`, `departure_time`, `departure_photo`, `created_at`, `updated_at`) VALUES
(3, 3, 1, 1, '2026-03-18', 'planned', NULL, NULL, '2026-03-18 04:49:26', '2026-03-18 04:49:26'),
(4, 5, 4, 1, '2026-03-18', 'planned', NULL, NULL, '2026-03-18 04:49:26', '2026-03-18 04:49:26'),
(5, 3, 1, 1, '2026-03-18', 'planned', NULL, NULL, '2026-03-18 05:27:50', '2026-03-18 05:27:50'),
(6, 5, 4, 1, '2026-03-18', 'planned', NULL, NULL, '2026-03-18 05:27:51', '2026-03-18 05:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `distribution_stops`
--

CREATE TABLE `distribution_stops` (
  `id` bigint UNSIGNED NOT NULL,
  `distribution_route_id` bigint UNSIGNED NOT NULL,
  `beneficiary_id` bigint UNSIGNED NOT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `order` int NOT NULL,
  `status` enum('pending','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `arrival_time` timestamp NULL DEFAULT NULL,
  `handover_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `handover_doc_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'raw',
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `stock` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sppg_id` bigint UNSIGNED DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `code`, `name`, `type`, `unit`, `price`, `stock`, `created_at`, `updated_at`, `sppg_id`, `category`, `expiry_date`) VALUES
(1, NULL, 'beras', 'raw', NULL, 15000.00, -900000.00, '2026-02-20 08:40:11', '2026-04-04 23:14:15', NULL, NULL, NULL),
(2, 'BB-024', 'Ayam', 'raw', 'Kg', 38000.00, 6201000.00, '2026-02-20 08:40:11', '2026-04-05 06:53:58', NULL, NULL, NULL),
(3, NULL, 'tepung tapioka', 'raw', NULL, 1000.00, 1303000.00, '2026-02-20 08:40:11', '2026-04-04 23:14:15', NULL, NULL, NULL),
(4, NULL, 'garam', 'raw', NULL, 1000.00, -100000.00, '2026-02-20 08:40:11', '2026-04-04 23:14:15', NULL, NULL, NULL),
(5, 'BB-022', 'Buncis', 'raw', 'Kg', 30000.00, -189000.00, '2026-02-20 08:40:11', '2026-04-05 06:53:58', NULL, NULL, NULL),
(6, NULL, 'bunga kol', 'raw', NULL, 1000.00, 0.00, '2026-02-20 08:40:11', '2026-04-04 23:14:15', NULL, NULL, NULL),
(7, 'BB-059', 'Wortel', 'raw', 'Kg', 10500.00, 909090.00, '2026-02-20 08:40:11', '2026-04-05 06:53:58', NULL, NULL, NULL),
(8, 'BB-065', 'Pepaya', 'raw', 'Buah/Kg', 13500.00, -9000.00, '2026-02-20 08:40:11', '2026-04-05 06:53:58', NULL, NULL, NULL),
(9, NULL, 'Nila', 'raw', NULL, 35000.00, 700.00, '2026-02-20 08:40:11', '2026-04-04 23:14:15', NULL, NULL, NULL),
(10, NULL, 'Lele', 'raw', NULL, 28000.00, 0.00, '2026-02-20 08:40:11', '2026-04-04 23:14:15', NULL, NULL, NULL),
(11, 'BB-027', 'Tahu', 'raw', 'Pcs', 600.00, 0.00, '2026-02-20 08:40:11', '2026-04-05 06:53:58', NULL, NULL, NULL),
(12, 'BB-071', 'Tempe', 'raw', 'Pcs', 15000.00, -45000.00, '2026-02-20 08:40:11', '2026-04-05 06:53:58', NULL, NULL, NULL),
(13, NULL, 'Telor', 'raw', 'Buah', 1900.00, 0.00, '2026-03-25 10:53:45', '2026-03-25 10:53:45', NULL, NULL, NULL),
(14, 'BB-004', 'Kacang Bali', 'raw', 'Ball (10kg)', 46000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(15, 'BB-005', 'Plastik Bingkisan / Ikat (5bks)', 'raw', 'Ikat', 50000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(16, 'BB-006', 'Kabel T', 'raw', 'Bks', 12000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(17, 'BB-007', 'Kertas Label Nama', 'raw', 'Bks', 10000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(18, 'BB-008', 'Bolu Pandan', 'raw', 'Pcs', 25000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(19, 'BB-009', 'Susu UHT Prenagen 185ml', 'raw', 'Kotak', 10000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(20, 'BB-010', 'Susu 110ml', 'raw', 'Kotak', 4000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(21, 'BB-011', 'Plastik Klip 8x12', 'raw', 'Bks', 11000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(22, 'BB-012', 'Plastik Klip 13x8.7', 'raw', 'Bks', 11000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(23, 'BB-013', 'Ultra Milk Susu UHT 125ml', 'raw', 'Kotak', 5800.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(24, 'BB-014', 'Buah Pisang', 'raw', 'Sisir', 15000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(25, 'BB-015', 'Sari Kacang Hijau 100ml', 'raw', 'Kotak', 3000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(26, 'BB-016', 'Beras SPHP', 'raw', 'Sak (5kg)', 58000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(27, 'BB-017', 'Gula Pasir', 'raw', 'Kg', 22500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(28, 'BB-018', 'Tepung Roti', 'raw', 'Kg', 9000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(29, 'BB-019', 'Minyak Goreng (Minyak Kita)', 'raw', 'Liter', 15000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(30, 'BB-020', 'Telur Ayam / Telur', 'raw', 'Papan', 60000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(31, 'BB-021', 'Ketumbar Bubuk', 'raw', 'Kg/Bks', 75000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(32, 'BB-023', 'Apel Hijau', 'raw', 'Dus', 1100000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(33, 'BB-025', 'Bawang Merah', 'raw', 'Kg', 50000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(34, 'BB-026', 'Selada', 'raw', 'Kg', 29500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(35, 'BB-028', 'Maizena', 'raw', 'Bks', 21000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(36, 'BB-029', 'Ajinomoto', 'raw', 'Bks', 58750.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(37, 'BB-030', 'Saus Tomat', 'raw', 'Botol/Pouch', 21250.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(38, 'BB-031', 'Saus Cabe', 'raw', 'Botol/Pouch', 28750.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(39, 'BB-032', 'Royco', 'raw', 'Bks', 50000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(40, 'BB-033', 'Wijen Putih', 'raw', 'Kg/Bks', 62500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(41, 'BB-034', 'Sereh', 'raw', 'Ikat/Kg', 12000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(42, 'BB-035', 'Kentang', 'raw', 'Kg', 9000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(43, 'BB-036', 'Tepung Terigu Per Zak', 'raw', 'Zak', 360000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(44, 'BB-037', 'Air Abu', 'raw', 'Botol', 15000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(45, 'BB-038', 'Baking Soda', 'raw', 'Bks', 22500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(46, 'BB-039', 'Saos Sachet Per Dus', 'raw', 'Dus', 390000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(47, 'BB-040', 'Anggur', 'raw', 'Dus', 375000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(48, 'BB-041', 'Malkist', 'raw', 'Karton/Dus', 2677500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(49, 'BB-042', 'Ultra milk 200Ml Per Dus', 'raw', 'Dus', 165000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(50, 'BB-043', 'Ultra milk 125Ml Per Dus', 'raw', 'Dus', 220000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(51, 'BB-044', 'Susu Bendera Per Dus', 'raw', 'Dus', 135000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(52, 'BB-045', 'Indomilk Per Dus', 'raw', 'Dus', 150000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(53, 'BB-046', 'Frisian Flag UHT 110Ml Per Pack (isi 6)', 'raw', 'Pack', 25200.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(54, 'BB-047', 'Frisian Flag UHT 180Ml', 'raw', 'Kotak', 5500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(55, 'BB-048', 'Greenfields UHT 105Ml Per Pack (isi 4)', 'raw', 'Pack', 20250.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(56, 'BB-049', 'Plastik Bingkisan', 'raw', 'Bks', 10000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(57, 'BB-050', 'Roti Manis', 'raw', 'Pcs', 3500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(58, 'BB-051', 'Ayam Dada Manis', 'raw', 'Kg', 40000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(59, 'BB-052', 'Kemiri', 'raw', 'Kg', 75000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(60, 'BB-053', 'Tomat', 'raw', 'Kg', 11000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(61, 'BB-054', 'Daun Jeruk/Plastik', 'raw', 'Plastik', 70000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(62, 'BB-055', 'Daun Salam', 'raw', 'Kg', 24000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(63, 'BB-056', 'Jahe', 'raw', 'Kg', 30000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(64, 'BB-057', 'Kunyit', 'raw', 'Kg', 15000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(65, 'BB-058', 'Lengkuas', 'raw', 'Kg', 15500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(66, 'BB-060', 'Brokoli', 'raw', 'Kg', 28500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(67, 'BB-061', 'Kemangi/Ikat', 'raw', 'Ikat', 5500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(68, 'BB-062', 'Jeruk Nipis', 'raw', 'Kg', 25000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(69, 'BB-063', 'Minyak / Jerigen', 'raw', 'Jerigen', 592500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(70, 'BB-064', 'Cuka', 'raw', 'Botol', 16000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(71, 'BB-066', 'Timun', 'raw', 'Kg', 15000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(72, 'BB-067', 'Minyak / 2 Liter', 'raw', 'Pcs/Btl', 59500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(73, 'BB-068', 'Apel Merah / Dus', 'raw', 'Dus', 800000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(74, 'BB-069', 'Bunga Lawang / Bks', 'raw', 'Bks', 150000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(75, 'BB-070', 'Beras IR24', 'raw', 'Zak', 465000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(76, 'BB-072', 'Semangka', 'raw', 'Kg', 13000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(77, 'BB-073', 'Bawang Putih', 'raw', 'Kg', 33750.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(78, 'BB-074', 'Cabai / Cabe Merah', 'raw', 'Kg', 61500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(79, 'BB-075', 'Jeruk', 'raw', 'Kg', 15000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(80, 'BB-076', 'Bawang Bombay', 'raw', 'Kg', 37500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(81, 'BB-077', 'Nanas', 'raw', 'Buah/Kg', 24000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(82, 'BB-078', 'Janten', 'raw', 'Kg', 15000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(83, 'BB-079', 'Bumbu Ayam', 'raw', 'Bks', 25000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(84, 'BB-080', 'Kembang Kol', 'raw', 'Kg', 7000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(85, 'BB-081', 'Minyak Makan / Dus', 'raw', 'Dus', 303000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(86, 'BB-082', 'Minyak Makan / 1 Liter', 'raw', 'Liter', 27000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(87, 'BB-083', 'Cetakan Telur', 'raw', 'Set/Pcs', 127500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(88, 'BB-084', 'Susu Frisian Flag UHT / Dus', 'raw', 'Dus', 180000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(89, 'BB-085', 'Beras IR 64', 'raw', 'Zak', 465000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(90, 'BB-086', 'Garam Dolpin', 'raw', 'Dus', 15500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(91, 'BB-087', 'Saori Tiram', 'raw', 'Botol/Pcs', 60000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(92, 'BB-088', 'Bubuk Kunyit', 'raw', 'Bal', 27500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(93, 'BB-089', 'Tusuk Gigi', 'raw', 'Bks/Pack', 2500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(94, 'BB-090', 'Tepung Beras', 'raw', 'Dus', 9000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(95, 'BB-091', 'Tapioka', 'raw', 'Kg', 15000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(96, 'BB-092', 'Gula Merah', 'raw', 'Kg', 38500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(97, 'BB-093', 'Macam-macam Bumbu', 'raw', 'Paket', 125000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(98, 'BB-094', 'Mancis Panjang', 'raw', 'Pcs', 18750.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(99, 'BB-095', 'Tepung Sajiku', 'raw', 'Dus', 26250.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(100, 'BB-096', 'Nutrijell Coklat (24 Box)', 'raw', 'Dus', 975000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(101, 'BB-097', 'Nutrijell Coklat (4 Box)', 'raw', 'Pack', 40000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(102, 'BB-098', 'Swallow Coklat (25 Box)', 'raw', 'Pack', 57500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(103, 'BB-099', 'Gula 50 kg', 'raw', 'Zak', 1012500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(104, 'BB-100', 'Lada Putih Bubuk', 'raw', 'Kg/Pack', 187500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(105, 'BB-101', 'Sawi Putih', 'raw', 'Kg', 3750.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(106, 'BB-102', 'Melon', 'raw', 'Kg', 21000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(107, 'BB-103', 'Cup agar-agar', 'raw', 'Pcs/Slop', 2000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(108, 'BB-104', 'Daun Sop & Daun Bawang', 'raw', 'Ikat', 15000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(109, 'BB-105', 'Ikan Nila', 'raw', 'Kg', 38500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(110, 'BB-106', 'Labu Siam', 'raw', 'Kg', 81500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(111, 'BB-107', 'Teri Nasi', 'raw', 'Kg', 181250.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(112, 'BB-108', 'Kecap Manis 1 Jerigen', 'raw', 'Jerigen', 197500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(113, 'BB-109', 'Asam Jawa', 'raw', 'Bks/Kg', 7500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(114, 'BB-110', 'Ultramilk UHT Coklat', 'raw', 'Kotak', 5500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(115, 'BB-111', 'Susu Frisian Flag UHT Coklat', 'raw', 'Kotak', 5500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(116, 'BB-112', 'Telur (Butir)', 'raw', 'Butir', 2000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(117, 'BB-113', 'Plastik Telur', 'raw', 'Bks/Pack', 30000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(118, 'BB-114', 'Plastik Klip (Ball)', 'raw', 'Ball', 10000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(119, 'BB-115', 'Roti (Pack/Besar)', 'raw', 'Pack', 25000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(120, 'BB-116', 'Susu Dancow 110ml', 'raw', 'Kotak', 4000.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL),
(121, 'BB-117', 'Susu Oatside 200ml', 'raw', 'Kotak', 5500.00, 0.00, '2026-04-05 06:53:58', '2026-04-05 06:53:58', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `material_logs`
--

CREATE TABLE `material_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sppg_id` bigint UNSIGNED DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aroma` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temperature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `storage_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_logs`
--

INSERT INTO `material_logs` (`id`, `material_id`, `type`, `quantity`, `date`, `created_at`, `updated_at`, `sppg_id`, `color`, `aroma`, `temperature`, `storage_location`) VALUES
(1, 2, 'in', 7000000.00, '2026-02-23', '2026-02-23 07:18:20', '2026-02-23 07:18:20', NULL, NULL, NULL, NULL, NULL),
(2, 4, 'out', 80000.00, '2026-02-23', '2026-02-23 07:24:28', '2026-02-23 07:24:28', NULL, NULL, NULL, NULL, NULL),
(3, 3, 'out', 90000.00, '2026-02-23', '2026-02-23 07:27:43', '2026-02-23 07:27:43', NULL, NULL, NULL, NULL, NULL),
(4, 5, 'in', 900000.00, '2026-02-23', '2026-02-23 07:31:17', '2026-02-23 07:31:17', NULL, NULL, NULL, NULL, NULL),
(5, 2, 'in', 1000.00, '2026-02-23', '2026-02-23 08:10:08', '2026-02-23 08:10:08', NULL, NULL, NULL, NULL, NULL),
(6, 3, 'out', 7000.00, '2026-02-23', '2026-02-23 08:28:23', '2026-02-23 08:28:23', NULL, NULL, NULL, NULL, NULL),
(7, 4, 'out', 20000.00, '2026-02-23', '2026-02-23 08:50:57', '2026-02-23 08:50:57', NULL, NULL, NULL, NULL, NULL),
(8, 5, 'out', 90000.00, '2026-02-23', '2026-02-23 09:26:29', '2026-02-23 09:26:29', NULL, NULL, NULL, NULL, NULL),
(9, 5, 'out', 90000.00, '2026-02-23', '2026-02-23 09:26:31', '2026-02-23 09:26:31', NULL, NULL, NULL, NULL, NULL),
(10, 2, 'out', 800000.00, '2026-02-23', '2026-02-23 10:33:47', '2026-02-23 10:33:47', NULL, NULL, NULL, NULL, NULL),
(11, 5, 'out', 900000.00, '2026-02-24', '2026-02-23 18:48:35', '2026-02-23 18:48:35', NULL, NULL, NULL, NULL, NULL),
(12, 3, 'in', 700000.00, '2026-02-24', '2026-02-23 18:49:26', '2026-02-23 18:49:26', NULL, NULL, NULL, NULL, NULL),
(13, 3, 'in', 700000.00, '2026-02-24', '2026-02-23 19:06:34', '2026-02-23 19:06:34', NULL, NULL, NULL, NULL, NULL),
(14, 12, 'out', 45000.00, '2026-02-24', '2026-02-23 19:13:32', '2026-02-23 19:13:32', NULL, NULL, NULL, NULL, NULL),
(15, 1, 'out', 900000.00, '2026-02-25', '2026-02-24 23:27:55', '2026-02-24 23:27:55', NULL, NULL, NULL, NULL, NULL),
(16, 7, 'in', 909090.00, '2026-02-25', '2026-02-24 23:28:22', '2026-02-24 23:28:22', NULL, NULL, NULL, NULL, NULL),
(17, 5, 'out', 9000.00, '2026-03-01', '2026-03-01 16:55:26', '2026-03-01 16:55:26', NULL, NULL, NULL, NULL, NULL),
(18, 8, 'out', 9000.00, '2026-03-11', '2026-03-11 08:04:04', '2026-03-11 08:04:04', NULL, NULL, NULL, NULL, NULL),
(19, 9, 'in', 700.00, '2026-03-16', '2026-03-16 02:05:30', '2026-03-16 02:05:30', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `material_requests`
--

CREATE TABLE `material_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `sppg_id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `source_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `temperature_received` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prep_completed_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mbg_distributions`
--

CREATE TABLE `mbg_distributions` (
  `id` bigint UNSIGNED NOT NULL,
  `beneficiary_id` bigint UNSIGNED NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `distributed_at` timestamp NOT NULL,
  `sppg_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `karbo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `protein_hewani` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `protein_nabati` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sayur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pelengkap` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sppg_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `portion_count` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `date`, `content`, `karbo`, `protein_hewani`, `protein_nabati`, `sayur`, `buah`, `pelengkap`, `sppg_id`, `created_at`, `updated_at`, `portion_count`) VALUES
(28, '2026-04-13', 'nasi daun jeruk | ayam garlic | tempe karage | tumis sawi putih wortel | pisang | sambal bawang', 'nasi daun jeruk', 'ayam garlic', 'tempe karage', 'tumis sawi putih wortel', 'pisang', 'sambal bawang', 2, '2026-04-09 01:41:57', '2026-04-09 01:41:57', 0),
(29, '2026-04-14', 'nasi serai + teri nasi | telur balado | tahu goreng kremes | tumis buncis wortel | semangka', 'nasi serai + teri nasi', 'telur balado', 'tahu goreng kremes', 'tumis buncis wortel', 'semangka', NULL, 2, '2026-04-09 01:41:57', '2026-04-09 01:41:57', 0),
(30, '2026-04-15', 'nasi putih | ayam teriyaki | tumis kacang merah | kacang panjang dan wortel rebus | melon orens | taburan wijen (untuk ayam dan kacang)', 'nasi putih', 'ayam teriyaki', 'tumis kacang merah', 'kacang panjang dan wortel rebus', 'melon orens', 'taburan wijen (untuk ayam dan kacang)', 2, '2026-04-09 01:41:57', '2026-04-09 01:41:57', 0),
(31, '2026-04-16', 'nasi bunga telang | chicken katsu | tempe goreng | coleslaw salad (kol dan wortel) + mayonaise | jeruk | saus bbq ', 'nasi bunga telang', 'chicken katsu', 'tempe goreng', 'coleslaw salad (kol dan wortel) + mayonaise', 'jeruk', 'saus bbq ', 2, '2026-04-09 01:41:57', '2026-04-09 01:41:57', 0),
(32, '2026-04-17', 'nasi putih | bakso daging ayam kuah | keripik tempe (3 per porsi) | wortel + kol  | pepaya | sambal kecap', 'nasi putih', 'bakso daging ayam kuah', 'keripik tempe (3 per porsi)', 'wortel + kol ', 'pepaya', 'sambal kecap', 2, '2026-04-09 01:41:57', '2026-04-09 01:41:57', 0),
(33, '2026-04-18', 'roti manis | susu 105 ml (greenfields) | kacang bali daun jeruk | pisang', 'roti manis', 'susu 105 ml (greenfields)', 'kacang bali daun jeruk', NULL, 'pisang', NULL, 2, '2026-04-09 01:41:57', '2026-04-09 01:41:57', 0),
(34, '2026-04-20', 'nasi putih | telur semur | tempe goreng chrispy | tumis buncis wortel | salad buah (melon, buah naga, jelly+keju)', 'nasi putih', 'telur semur', 'tempe goreng chrispy', 'tumis buncis wortel', 'salad buah (melon, buah naga, jelly+keju)', NULL, 2, '2026-04-09 01:41:57', '2026-04-09 01:41:57', 0),
(35, '2026-04-21', 'nasi putih | ayam saus lada hitam | perkedel tempe | lalapan timun dan tomat | semangka', 'nasi putih', 'ayam saus lada hitam', 'perkedel tempe', 'lalapan timun dan tomat', 'semangka', NULL, 2, '2026-04-09 01:41:57', '2026-04-09 01:41:57', 0),
(36, '2026-04-22', 'nasi putih | sate ayam lilit (bakar/goreng) | tempe bacem | tumis kacang panjang+jagung pipil | melon orens | selada', 'nasi putih', 'sate ayam lilit (bakar/goreng)', 'tempe bacem', 'tumis kacang panjang+jagung pipil', 'melon orens', 'selada', 2, '2026-04-09 01:41:57', '2026-04-09 01:41:57', 0),
(37, '2026-04-23', 'nasi hainan | ayam saus rujak | tahu cabai garam  | tumis pakcoy bawang putih | pisang', 'nasi hainan', 'ayam saus rujak', 'tahu cabai garam ', 'tumis pakcoy bawang putih', 'pisang', NULL, 2, '2026-04-09 01:41:57', '2026-04-09 01:41:57', 0),
(38, '2026-04-24', 'nasi putih | ayam goreng | sup kacang merah + wortel | irisan kol (dimasukkan di sayur) | jeruk | sambal kecap', 'nasi putih', 'ayam goreng', 'sup kacang merah + wortel', 'irisan kol (dimasukkan di sayur)', 'jeruk', 'sambal kecap', 2, '2026-04-09 01:41:57', '2026-04-09 01:41:57', 0),
(39, '2026-04-25', 'roti manis | susu 105 ml (greenfields) | kacang bali daun jeruk | pisang', 'roti manis', 'susu 105 ml (greenfields)', 'kacang bali daun jeruk', NULL, 'pisang', NULL, 2, '2026-04-09 01:41:57', '2026-04-09 01:41:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_02_20_060323_create_suppliers_table', 2),
(6, '2026_02_20_060325_create_beneficiaries_table', 2),
(7, '2026_02_20_060326_create_materials_table', 2),
(8, '2026_02_20_060328_create_material_logs_table', 2),
(9, '2026_02_20_060329_create_payments_table', 2),
(10, '2026_02_20_063826_create_sppgs_table', 3),
(11, '2026_02_20_063827_create_mbg_distributions_table', 3),
(12, '2026_02_20_063847_enhance_tables_for_bot_and_sppg', 3),
(13, '2026_02_20_064434_add_phone_to_users_table', 4),
(14, '2026_02_20_072951_create_menus_table', 5),
(15, '2026_02_20_153858_create_dishes_table', 6),
(16, '2026_02_20_153859_create_recipes_table', 6),
(17, '2026_02_20_153900_create_orders_table', 6),
(18, '2026_02_20_153901_create_order_items_table', 6),
(19, '2026_02_20_154041_enhance_material_logs_and_payments_for_mbg_specs', 7),
(20, '2026_02_20_154213_create_dish_menu_table', 7),
(21, '2026_02_20_154954_create_material_requests_table', 7),
(22, '2026_02_20_154955_refine_financial_ledger_table', 7),
(23, '2026_02_20_155051_create_account_balances_table', 7),
(24, '2026_02_25_153026_set_admin_role_for_master_users', 8),
(25, '2026_02_26_063233_create_volunteer_attendances_table', 9),
(26, '2026_02_27_073258_add_phone_to_sppgs_table', 10),
(27, '2026_03_04_130631_add_details_to_materials_table', 11),
(28, '2026_03_04_131536_add_gender_and_guardian_phone_to_beneficiaries_table', 12),
(29, '2026_03_05_093804_make_content_nullable_in_menus_table', 13),
(30, '2026_03_05_100357_remove_grammage_from_materials_table', 14),
(32, '2026_03_05_101207_create_distribution_routes_table', 15),
(34, '2026_03_06_100000_create_beneficiary_groups_table', 16),
(35, '2026_03_06_100001_update_beneficiaries_add_group_and_details', 16),
(36, '2026_03_05_101217_create_distribution_stops_table', 17),
(37, '2026_03_06_160000_add_missing_columns_to_dish_menu_table', 18),
(38, '2026_03_13_133702_add_geofence_to_sppgs_table', 19),
(39, '2026_03_13_133707_add_sppg_id_to_volunteer_attendances_table', 19),
(40, '2026_03_15_112241_add_coordinates_to_beneficiary_groups_table', 20),
(41, '2026_03_18_113433_add_description_to_dishes_table', 21),
(42, '2026_03_18_115525_add_quantity_to_distribution_stops_table', 22),
(43, '2026_03_30_041743_add_code_to_sppgs_table', 23),
(44, '2026_04_03_092557_create_news_table', 24),
(45, '2026_04_03_092603_add_tutorial_fields_to_recipes_table', 24),
(46, '2026_04_03_092604_create_complaints_table', 24),
(47, '2026_04_05_000001_add_youtube_url_to_dishes_table', 25),
(48, '2026_04_05_134824_add_code_to_materials_table', 26),
(49, '2026_04_08_210003_update_tables_for_mbg_overhaul', 27),
(50, '2026_04_09_014329_update_tables_for_mbg_overhaul_v2', 27),
(51, '2026_04_09_014341_update_tables_for_mbg_overhaul_v2', 27),
(52, '2026_04_09_020553_update_news_table_for_transparency', 27),
(53, '2026_04_09_032032_add_portioning_to_beneficiary_groups', 28),
(54, '2026_04_09_060116_add_details_to_beneficiary_groups', 29),
(55, '2026_04_09_082940_add_nutrition_columns_to_menus_table', 30);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `published_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snippet` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sppg_id` bigint UNSIGNED DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `url`, `published_at`, `snippet`, `created_at`, `updated_at`, `sppg_id`, `image_path`) VALUES
(1, 'Artikel', 'https://bgn.go.id/news/artikel/', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(2, 'Klarifikasi Hoaks', 'https://bgn.go.id/news/klarifikasi-hoaks/', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(3, 'Pengumuman', 'https://bgn.go.id/news/pengumuman/', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(4, 'Berita', 'https://bgn.go.id/news/berita/', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(5, 'Siaran Pers', 'https://bgn.go.id/news/siaran-pers/', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(6, 'KEPALA BADAN GIZI NASIONAL', 'https://bgn.go.id/news/siaran-pers/siaran-pers-kepala-badan-gizi-nasional', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(7, 'WAKIL KEPALA BADAN GIZI NASIONAL', 'https://bgn.go.id/news/siaran-pers/siaran-pers-wakil-kepala-badan-gizi-nasional', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(8, 'DEPUTI DIALUR', 'https://bgn.go.id/news/siaran-pers/siaran-pers-deputi-dialur', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(9, 'DEPUTI PROKERMA', 'https://bgn.go.id/news/siaran-pers/siaran-pers-deputi-prokerma', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(10, 'DEPUTI SISTAKOL', 'https://bgn.go.id/news/siaran-pers/siaran-pers-deputi-sistakol', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(11, 'DEPUTI TAUWAS', 'https://bgn.go.id/news/siaran-pers/siaran-pers-deputi-tauwas', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(12, 'SEKRETARIAT UTAMA', 'https://bgn.go.id/news/siaran-pers/siaran-pers-sekretariat-utama', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(13, 'INSPEKTORAT UTAMA', 'https://bgn.go.id/news/siaran-pers/siaran-pers-inspektorat-utama', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(14, 'Foto', 'https://bgn.go.id/news/foto/', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(15, 'Video', 'https://bgn.go.id/news/video/', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(16, 'Infografis', 'https://bgn.go.id/news/infografis/', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(17, 'Investigasi', 'https://bgn.go.id/news/investigasi/', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(18, '6', 'https://bgn.go.id/news/foto/pemorsian-perdana-setelah-idul-fitri', '', 'BGN', '2026-04-03 03:38:56', '2026-04-03 03:38:57', NULL, NULL),
(19, '7', 'https://bgn.go.id/news/foto/mbg-perdana-usai-idul-fitri', '', 'BGN', '2026-04-03 03:38:56', '2026-04-03 03:38:57', NULL, NULL),
(20, '8', 'https://bgn.go.id/news/foto/mbg-perdana-di-batang', '', 'BGN', '2026-04-03 03:38:56', '2026-04-03 03:38:57', NULL, NULL),
(21, '9', 'https://bgn.go.id/news/foto/kepala-bgn-hadiri-entry-meeting-lkpp-ri-tahun-2025', '', 'BGN', '2026-04-03 03:38:56', '2026-04-03 03:38:57', NULL, NULL),
(22, 'Siswa Terima MBG Fresh 5 Hari, 3B dan Siswa di Daerah 3T Menu Kering', 'https://bgn.go.id/news/siaran-pers/siswa-terima-mbg-fresh-5-hari-3b-dan-siswa-di-daerah-3t-menu-kering', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(23, 'Halal Bihalal BGN', 'https://bgn.go.id/news/foto/halal-bihalal-bgn', '', '', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(24, 'BGN Kunjungi Diskominfo Kota Makassar Perkuat Sosialisasi MBG', 'https://bgn.go.id/news/artikel/bgn-kunjungi-diskominfo-kota-makassar-perkuat-sosialisasi-mbg', '', 'BGN • 2 April 2026', '2026-04-03 03:38:56', '2026-04-03 03:38:56', NULL, NULL),
(25, '5', 'https://bgn.go.id/news/artikel/wujudkan-ekonomi-inklusif-bgn-dorong-penyerapan-tenaga-kerja-lokal-di-makassar-untuk-program-mbg', '', 'BGN', '2026-04-03 03:38:56', '2026-04-03 03:38:57', NULL, NULL),
(26, '3', 'https://bgn.go.id/news/artikel/bgn-jajaki-sinergi-dengan-dpmptsp-kota-makassar-guna-perkuat-dukungan-hukum-program-mbg', '', 'BGN', '2026-04-03 03:38:56', '2026-04-03 03:38:57', NULL, NULL),
(27, '1', 'https://bgn.go.id/news/berita/bgn-tegaskan-prinsip-no-service-no-pay-insentif-sppg-bisa-langsung-dihentikan', '', 'BGN', '2026-04-03 03:38:56', '2026-04-03 03:38:57', NULL, NULL),
(28, '2', 'https://bgn.go.id/news/berita/perkuat-pengawasan-pangan-dari-timur-indonesia-bgn-sambangi-balai-besar-karantina-sulawesi-selatan', '', 'BGN', '2026-04-03 03:38:56', '2026-04-03 03:38:57', NULL, NULL),
(29, '4', 'https://bgn.go.id/news/artikel/demi-jamin-kualitas-makan-bergizi-bgn-dorong-digitalisasi-laboratorium-kesehatan-di-makassar', '', 'BGN', '2026-04-03 03:38:56', '2026-04-03 03:38:57', NULL, NULL),
(30, '10', 'https://bgn.go.id/news/artikel/pagi-ceria-di-sdn-pegangsaan-mbg-hidupkan-semangat-siswa-pasca-lebaran', '', 'BGN', '2026-04-03 03:38:57', '2026-04-03 03:38:57', NULL, NULL),
(31, 'Program MBG Bantu 3 Juta Anak Indonesia Dapatkan Gizi Seimbang', 'https://bgn.go.id/berita/mbg-3-juta-anak', '2026-04-05', 'Berita resmi Badan Gizi Nasional (BGN).', '2026-04-04 20:29:03', '2026-04-04 20:29:03', NULL, NULL),
(32, 'BGN Luncurkan Panduan Standar Menu Bergizi Nasional 2026', 'https://bgn.go.id/berita/panduan-menu-2026', '2026-04-05', 'Berita resmi Badan Gizi Nasional (BGN).', '2026-04-04 20:29:03', '2026-04-04 20:29:03', NULL, NULL),
(33, 'Petani Lokal Jadi Pahlawan Ketahanan Pangan Program MBG', 'https://bgn.go.id/berita/petani-lokal-mbg', '2026-04-05', 'Berita resmi Badan Gizi Nasional (BGN).', '2026-04-04 20:29:03', '2026-04-04 20:29:03', NULL, NULL),
(34, 'SPPG Bertambah: 500 Dapur Baru Siap Layani Daerah Terpencil', 'https://bgn.go.id/berita/sppg-500-dapur', '2026-04-05', 'Berita resmi Badan Gizi Nasional (BGN).', '2026-04-04 20:29:03', '2026-04-04 20:29:03', NULL, NULL),
(35, 'Transparansi Dana MBG: Setiap Rupiah Tercatat dan Dapat Diaudit', 'https://bgn.go.id/berita/transparansi-dana', '2026-04-05', 'Berita resmi Badan Gizi Nasional (BGN).', '2026-04-04 20:29:03', '2026-04-04 20:29:03', NULL, NULL),
(36, 'Kerjasama BGN dengan Universitas Gizi untuk Standarisasi Menu', 'https://bgn.go.id/berita/kerjasama-universitas', '2026-04-05', 'Berita resmi Badan Gizi Nasional (BGN).', '2026-04-04 20:29:03', '2026-04-04 20:29:03', NULL, NULL),
(37, 'Distribusi MBG Capai 10 Ribu Titik di Seluruh Indonesia', 'https://bgn.go.id/berita/distribusi-10ribu', '2026-04-05', 'Berita resmi Badan Gizi Nasional (BGN).', '2026-04-04 20:29:03', '2026-04-04 20:29:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `sppg_id` bigint UNSIGNED DEFAULT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `sppg_id`, `supplier_id`, `order_date`, `status`, `total_amount`, `notes`, `created_at`, `updated_at`) VALUES
(1, NULL, 2, '2026-03-01', 'pending', 0.00, NULL, '2026-03-01 09:53:52', '2026-03-01 09:53:52'),
(2, NULL, 2, '2026-03-01', 'pending', 0.00, NULL, '2026-03-01 09:53:53', '2026-03-01 09:53:53');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED NOT NULL,
  `requested_quantity` decimal(15,4) NOT NULL,
  `received_quantity` decimal(15,4) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `material_id`, `requested_quantity`, `received_quantity`, `unit`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 125.0000, NULL, 'kg', 14750.00, '2026-03-01 09:53:52', '2026-03-01 09:53:52'),
(2, 1, 5, 200.0000, NULL, 'kg', 245000.00, '2026-03-01 09:53:52', '2026-03-01 09:53:52'),
(3, 2, 1, 125.0000, NULL, 'kg', 14750.00, '2026-03-01 09:53:53', '2026-03-01 09:53:53'),
(4, 2, 5, 200.0000, NULL, 'kg', 245000.00, '2026-03-01 09:53:53', '2026-03-01 09:53:53');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('silverius1008@gmail.com', '$2y$12$HPRAPBdmFURIGjBmitDMHOY.2diQnbKjVuKbwRkkN2VssJjUCF.z.', '2026-02-22 04:35:42'),
('yoelflemming8@gmail.com', '$2y$12$CWpJgzYWS7mM1pz.ro/9o.wGJj00Al6fE5RWNZ8WFKtqjeovsyzGe', '2026-02-22 05:14:57');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `beneficiary_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `amount_in` decimal(15,2) NOT NULL DEFAULT '0.00',
  `amount_out` decimal(15,2) NOT NULL DEFAULT '0.00',
  `balance_after` decimal(15,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sppg_id` bigint UNSIGNED DEFAULT NULL,
  `transaction_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proof_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT '0.00',
  `proof_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` bigint UNSIGNED NOT NULL,
  `dish_id` bigint UNSIGNED NOT NULL,
  `material_id` bigint UNSIGNED NOT NULL,
  `quantity` decimal(10,4) NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `steps` json DEFAULT NULL,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `dish_id`, `material_id`, `quantity`, `unit`, `steps`, `youtube_url`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0.0600, 'kg', NULL, NULL, NULL, '2026-02-20 08:40:11', '2026-02-20 08:55:38'),
(2, 2, 2, 0.1000, 'kg', NULL, NULL, '10 porsi/kg', '2026-02-20 08:40:11', '2026-02-20 08:55:38'),
(3, 2, 3, 0.0300, 'kg', NULL, NULL, '33 porsi/kg', '2026-02-20 08:40:11', '2026-02-20 08:55:38'),
(4, 2, 4, 0.0020, 'kg', NULL, NULL, '500 porsi/kg', '2026-02-20 08:40:11', '2026-02-20 08:55:38'),
(5, 3, 5, 0.0300, 'kg', NULL, NULL, '33 porsi/kg', '2026-02-20 08:40:11', '2026-02-20 08:55:38'),
(6, 3, 6, 0.0300, 'kg', NULL, NULL, '33 porsi/kg', '2026-02-20 08:40:11', '2026-02-20 08:55:38'),
(7, 3, 7, 0.0300, 'kg', NULL, NULL, '33 porsi/kg', '2026-02-20 08:40:11', '2026-02-20 08:55:38'),
(8, 4, 8, 0.0500, 'buah', NULL, NULL, '1 pepaya dipotong 20', '2026-02-20 08:40:11', '2026-02-20 08:55:38'),
(9, 5, 9, 0.0830, 'kg', NULL, NULL, '6 ekor / kg; 2 porsi /ekor', '2026-02-20 08:40:11', '2026-02-20 08:55:38'),
(10, 6, 10, 0.1000, 'kg', NULL, NULL, '10 ekor/kg', '2026-02-20 08:40:11', '2026-02-20 08:55:38'),
(11, 7, 11, 1.0000, 'buah', NULL, NULL, '1 buah tahu/porsi', '2026-02-20 08:40:11', '2026-02-20 08:55:38'),
(12, 8, 12, 0.2000, 'buah', NULL, NULL, '5 porsi/1 tempe', '2026-02-20 08:40:11', '2026-02-20 08:55:38'),
(13, 9, 4, 0.0300, 'gr', NULL, NULL, NULL, '2026-03-25 10:52:47', '2026-03-25 10:52:47'),
(14, 9, 13, 1.0000, 'Buah', NULL, NULL, NULL, '2026-03-25 10:54:11', '2026-03-25 10:54:11');

-- --------------------------------------------------------

--
-- Table structure for table `sppgs`
--

CREATE TABLE `sppgs` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ka_sppg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_ka` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengawas_keuangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_keuangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengawas_gizi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_gizi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `radius` int NOT NULL DEFAULT '100',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sppgs`
--

INSERT INTO `sppgs` (`id`, `code`, `name`, `ka_sppg`, `phone_ka`, `pengawas_keuangan`, `phone_keuangan`, `pengawas_gizi`, `phone_gizi`, `phone`, `location`, `latitude`, `longitude`, `radius`, `created_at`, `updated_at`) VALUES
(1, NULL, 'SPPG Dolok Batu Nanggar', 'Eka Imam Fadli', '082166791406', 'Debora Oktavine Gracia Sinaga', '082273832503', 'Masdalena', '085270493144', '082166791406', 'Balimbingan II', 2.96980000, 99.16780000, 100, '2026-03-13 06:38:18', '2026-03-29 21:40:02'),
(2, NULL, 'SPPG Karang Rejo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Karang Rejo, 3°00\'36.3\"N 99°06\'42.4\"E', 3.01009100, 99.11177600, 100, '2026-03-13 06:38:18', '2026-03-15 04:26:04'),
(3, 'BQQ4FHOV', 'SPPG Karangrejo', 'Daud Jaya Pane', '081396517800', 'Evlin Anariska Sebayang', '081260154491', 'Deary Yosephine Sembiring', '081340399290', '081396517800', NULL, NULL, NULL, 100, '2026-03-29 21:40:02', '2026-03-29 21:40:02'),
(4, 'MEUZONOK', 'SPPG Balimbingan II', 'Abdi Septian', '082161772172', 'Agita Sebayang', '082217053980', 'Meylinda', '088260013607', '082161772172', NULL, NULL, NULL, 100, '2026-03-29 21:40:02', '2026-03-29 21:40:02');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `village` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sppg_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `village`, `phone`, `items`, `price`, `created_at`, `updated_at`, `sppg_id`) VALUES
(1, 'Yoel', 'sampang', '085768610448', 'beras', 0.00, '2026-02-20 00:19:58', '2026-02-20 00:19:58', NULL),
(2, 'Ansiva Indonesia', 'dolok hataran', '082273051823', 'roti, sembako,', 0.00, '2026-03-01 09:45:32', '2026-03-01 09:45:32', NULL),
(3, 'Test Supplier', 'Desa Test', '08123456789', 'Ayam, Beras', 0.00, '2026-04-05 02:29:21', '2026-04-05 02:29:21', 1),
(4, 'UD. Tani Subur', 'Sukamaju', '081234567890', 'Beras, Jagung, Kedelai, Sayuran Segar', 0.00, '2026-04-05 03:08:16', '2026-04-05 03:08:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sppg_id` bigint UNSIGNED DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `sppg_id`, `role`, `phone`) VALUES
(1, 'Yoel Flemming', 'yoelflemming8@gmail.com', NULL, '$2y$12$pghYfAxjkOf9PvStO99HS.YppRtkpS5hWVUnzC/iEC7w6amoZ29lG', NULL, '2026-02-19 23:11:50', '2026-03-31 23:27:28', NULL, 'admin', '6285767610448'),
(3, 'Antoinette Kemmer', 'mosciski.bonnie@example.net', '2026-02-25 22:58:52', '$2y$04$8yxTE.yKbJBIZrHZzgdfbe0ed5LrDORY04TrpjVh6c.6Omvcne.ZC', '1hNgzgRqov', '2026-02-25 22:58:52', '2026-02-28 17:05:39', NULL, 'admin', '6281324687114'),
(4, 'Ardella Collier', 'dkessler@example.net', '2026-02-25 22:58:57', '$2y$04$8yxTE.yKbJBIZrHZzgdfbe0ed5LrDORY04TrpjVh6c.6Omvcne.ZC', 'RyhV2c2qz8', '2026-02-25 22:58:57', '2026-02-28 17:05:39', NULL, 'admin', '6281260873610'),
(5, 'Prof. Jan Emmerich', 'naomie.kunde@example.com', '2026-02-25 22:59:24', '$2y$04$hfgw1WgCamOb/oPI4vxWcuL7wzlHsP8bTWFkySvkChn7iE2I4/5Ky', 'y0d1eJGOOy', '2026-02-25 22:59:24', '2026-02-28 17:05:39', NULL, 'admin', NULL),
(6, 'Pablo Crooks', 'rkuphal@example.org', '2026-02-25 22:59:25', '$2y$04$hfgw1WgCamOb/oPI4vxWcuL7wzlHsP8bTWFkySvkChn7iE2I4/5Ky', '885fcfKjNh', '2026-02-25 22:59:25', '2026-02-28 17:05:39', NULL, 'admin', NULL),
(7, 'Johnnie Lang', 'kutch.raquel@example.com', '2026-02-25 23:15:10', '$2y$04$X1mH5FcL3jQ7YOXfB6uuceWMNgTTkP6yMNxAJJj1oxTf0p1sxAAu6', 'nlUkWCNWbZ', '2026-02-25 23:15:10', '2026-02-28 17:05:39', NULL, 'admin', NULL),
(8, 'Bernie Waelchi', 'neal05@example.net', '2026-02-25 23:15:11', '$2y$04$X1mH5FcL3jQ7YOXfB6uuceWMNgTTkP6yMNxAJJj1oxTf0p1sxAAu6', '2xQRC9hugR', '2026-02-25 23:15:11', '2026-02-28 17:05:39', NULL, 'admin', NULL),
(9, 'Liliane Padberg', 'collier.kristian@example.net', '2026-02-25 23:18:04', '$2y$04$lhkmu/qfKbc8.UXwGWCEAupbpkW/Xcwf8NLti5.a5NSd.HfvV9Mfy', 'hYFLjbgNvl', '2026-02-25 23:18:04', '2026-02-28 17:05:39', NULL, 'admin', NULL),
(10, 'Deshaun Hansen', 'trudie.kuhic@example.net', '2026-02-25 23:18:04', '$2y$04$lhkmu/qfKbc8.UXwGWCEAupbpkW/Xcwf8NLti5.a5NSd.HfvV9Mfy', 'QF3Gnbeyq8', '2026-02-25 23:18:04', '2026-02-28 17:05:39', NULL, 'admin', NULL),
(11, 'Nama Relawan', 'nama.relawan@example.com', NULL, '$2y$12$Z96gToP4Xg03lqi1TckP7O8.DLNfd9RqwOPSCixVz4YaDyrzomo0q', NULL, '2026-03-14 01:37:57', '2026-03-14 01:37:57', 1, 'volunteer', NULL),
(12, 'Lestari Dhamayanti', 'lestari.dhamayanti@example.com', NULL, '$2y$12$tZzHiQwXDnFRV4a1H9f1lOo9otRNeeYq0fcLplOO0dR6n3768f0pG', NULL, '2026-03-14 01:38:27', '2026-03-14 01:38:27', 1, 'volunteer', NULL),
(13, 'Fitriana', 'fitriana@example.com', NULL, '$2y$12$rmpJaWCNZmzbwYAlWb6vmu9a7JfH8PLjQJOQDqG.HF5NPOD3RDO0q', NULL, '2026-03-14 01:38:28', '2026-04-05 19:51:02', 3, 'volunteer', '6283191283636'),
(14, 'Lenni Jumira Dewi', 'lenni.jumira.dewi@example.com', NULL, '$2y$12$uhhUZaf0WxXTaGQotz/.mOQ8pr666jMyhWMjfbdiT/auSNMPCUldq', NULL, '2026-03-14 01:38:28', '2026-04-05 19:51:02', 3, 'volunteer', '6283867884196'),
(15, 'Murniati', 'murniati@example.com', NULL, '$2y$12$TwXNheqF3Z9KKisKJx6SM.n2Ik7Z3DWQIPHoMh3luWpqPZ11gdIb6', NULL, '2026-03-14 01:38:29', '2026-04-05 19:51:02', 3, 'volunteer', '6283159982614'),
(16, 'Norma Yunita', 'norma.yunita@example.com', NULL, '$2y$12$rWOgRGZzbFKBuhoqKf.WzejDMcn8.ZUnzgcHI3ydnmuuhFcjTOnhy', NULL, '2026-03-14 01:38:30', '2026-04-05 19:51:02', 3, 'volunteer', '6281370825615'),
(17, 'Ria Misjayana', 'ria.misjayana@example.com', NULL, '$2y$12$BRZd1yVGRpdJqaKnwwac0.Vh5qTiVwjcAdISR1sFZEh9PPed5eHRS', NULL, '2026-03-14 01:38:30', '2026-04-05 19:51:02', 3, 'volunteer', '6285270316367'),
(18, 'Sri Rahayu', 'sri.rahayu@example.com', NULL, '$2y$12$uQDJvrS8wz9RhckweD/BPeP7pV1YzfWeNtlpXnWmcyYI5/C1M4J/y', NULL, '2026-03-14 01:38:31', '2026-04-05 19:51:02', 3, 'volunteer', '6285261040585'),
(19, 'Wilda Rizky Aulia', 'wilda.rizky.aulia@example.com', NULL, '$2y$12$jbPf.XolOSzqG.1uy4jOP.pceJn2MUNvUKeakqNZZwxvZwrehxgYe', NULL, '2026-03-14 01:38:31', '2026-04-05 19:51:02', 3, 'volunteer', '6285370069872'),
(20, 'Tino', 'tino@example.com', NULL, '$2y$12$VWVysHJuePFEizmyJHcD9ebYKrGXXJjgAykTSSN.Nvxz9yjKDRlDe', NULL, '2026-03-14 01:38:32', '2026-04-05 19:51:02', 3, 'volunteer', '6283137340845'),
(21, 'Dewi Mariam', 'dewi.mariam@example.com', NULL, '$2y$12$VMQh8ez3KtmdsoBI66Kdt.1dyblP3K484b8bD3axowZgZtmrlj0L6', NULL, '2026-03-14 01:38:33', '2026-04-05 19:51:02', 3, 'volunteer', '6283863016606'),
(22, 'Ghubayani Pardede', 'ghubayani.pardede@example.com', NULL, '$2y$12$LgATso/IvZeVHrdI/Avb1e1BdXqPM69nhiPPeIELk16Bl4QG.xq3i', NULL, '2026-03-14 01:38:33', '2026-04-05 19:51:02', 3, 'volunteer', '6282274402180'),
(23, 'Nila Kusuma', 'nila.kusuma@example.com', NULL, '$2y$12$6dQv2CpT6ixtM3WUlZ4U8.DhgJcuqdeo0yL/F2l.cWZMxmBh/wMzm', NULL, '2026-03-14 01:38:34', '2026-04-05 19:51:02', 3, 'volunteer', '6283845133897'),
(24, 'Parti Alima', 'parti.alima@example.com', NULL, '$2y$12$OyeposLRDg1ZykSAkVjzv.FYxFAuwvl.v0twMnBTUK4EozYnpYxUe', NULL, '2026-03-14 01:38:34', '2026-04-05 19:51:02', 3, 'volunteer', '6283894331841'),
(25, 'Siti Sendari', 'siti.sendari@example.com', NULL, '$2y$12$W2Wmxt3IeUyyeP2EqDma9.WqvOFTvB1RY3dLAKZKJgiHTZPwDsrAu', NULL, '2026-03-14 01:38:35', '2026-04-05 19:51:02', 3, 'volunteer', '6281262175265'),
(26, 'Supia', 'supia@example.com', NULL, '$2y$12$BHKMqVlR.1aQIFhn0J/6cug1N5O.3y2Mb3njCEX2aaCjgN.cjjTb.', NULL, '2026-03-14 01:38:35', '2026-04-05 19:51:02', 3, 'volunteer', '6283195468226'),
(27, 'Triana Murni', 'triana.murni@example.com', NULL, '$2y$12$ofyorhU96Zj4MIzrKI5WBuOFnPbuvFVYX5faZWQXbltypwo32i.4S', NULL, '2026-03-14 01:38:36', '2026-04-05 19:51:02', 3, 'volunteer', '6283879922762'),
(28, 'Johendri Damanik', 'johendri.damanik@example.com', NULL, '$2y$12$Rk9/VgaLdy6/pXImIgY7TOiz7zt6AqqktBn.OMCfp8brxZXJcONBu', NULL, '2026-03-14 01:38:36', '2026-04-05 19:51:02', 3, 'volunteer', '6282370330005'),
(29, 'Bella Cahaya', 'bella.cahaya@example.com', NULL, '$2y$12$6zdewcXh8DSvWbq/qojwXeGPNvq/BlCd06WvRLxl.DFy.dQ.1zwxS', NULL, '2026-03-14 01:38:37', '2026-04-05 19:51:02', 3, 'volunteer', '6283876895211'),
(30, 'Luvi Hazah Rindiani', 'luvi.hazah.rindiani@example.com', NULL, '$2y$12$XF8einLoemTlQ3bLgE5INOBZv8Av8UADuO04DtTyR51HH9dz1C4wW', NULL, '2026-03-14 01:38:38', '2026-04-05 19:51:02', 3, 'volunteer', '6287791053469'),
(31, 'Marwiyah', 'marwiyah@example.com', NULL, '$2y$12$mJcjphce8ciTsINST0jknOievFSPZGcY.mTsB9h5O32OCC6VCPZey', NULL, '2026-03-14 01:38:38', '2026-04-05 19:51:02', 3, 'volunteer', '6282171308422'),
(32, 'Nasita', 'nasita@example.com', NULL, '$2y$12$yse7AmMXUNRWC8kyvt0FA.vgYnWaO55PHRNPs./EZcXi0Fp6s.fJq', NULL, '2026-03-14 01:38:39', '2026-04-05 19:51:02', 3, 'volunteer', '6281916553521'),
(33, 'Nur Asma Ambulani', 'nur.asma.ambulani@example.com', NULL, '$2y$12$Qi14fq88Y0QmPXCXsxTSme9jvh7zLP8yEMwVPmpLmkZTcWcoVm8Ti', NULL, '2026-03-14 01:38:40', '2026-04-05 19:51:02', 3, 'volunteer', '6281263057147'),
(34, 'Pinky Chairani', 'pinky.chairani@example.com', NULL, '$2y$12$wxOS9rF/YtCj4ZSFggc57eRASRb4kotAn3LTidQlZIOpJ5VW6lQq.', NULL, '2026-03-14 01:38:40', '2026-03-14 01:38:40', 1, 'volunteer', NULL),
(35, 'Rumida', 'rumida@example.com', NULL, '$2y$12$PDEk1dx2XC0Sr4hCHn1Al.PKvPGMvl/c0rfWfbI6qAektSZDU/otG', NULL, '2026-03-14 01:38:41', '2026-04-05 19:51:02', 3, 'volunteer', '628137436676'),
(36, 'Salma Wardah Lubis', 'salma.wardah.lubis@example.com', NULL, '$2y$12$0jC5djsCDBp3Lg.luN1M1.7JdoXaxbFO3tKpfRqJ4nlze0W6CnP86', NULL, '2026-03-14 01:38:41', '2026-04-05 19:51:02', 3, 'volunteer', '6289519191027'),
(37, 'Sunenti', 'sunenti@example.com', NULL, '$2y$12$Nl0UwAltaJUlyoBaYsojR.iunI2hqO1TmlOBYy.LKktcP6g0Eg23i', NULL, '2026-03-14 01:38:42', '2026-04-05 19:51:02', 3, 'volunteer', '6285296835976'),
(38, 'Umi Saida', 'umi.saida@example.com', NULL, '$2y$12$VKkCDZk6KZfpoy6evEy5HOULBTia.eu/17NQhS8kVs65jaEcw5awi', NULL, '2026-03-14 01:38:42', '2026-03-14 01:38:42', 1, 'volunteer', NULL),
(39, 'Irvan Hasudungan Silalahi', 'irvan.hasudungan.silalahi@example.com', NULL, '$2y$12$UxoscP2pxgoWla8RISd7ae6Rgs6PEWEjx8CPq/In0kOFRM/ZbZTvi', NULL, '2026-03-14 01:38:43', '2026-04-05 19:51:02', 3, 'volunteer', '6282162999564'),
(40, 'Henry Hamonongan Siahaan', 'henry.hamonongan.siahaan@example.com', NULL, '$2y$12$cCN.3uknOqIIBSRgYCAmnurZwQIGGQT7iAOJ1N7kO8Os9/fY0SQBC', NULL, '2026-03-14 01:38:43', '2026-04-05 19:51:02', 3, 'volunteer', '6282272245693'),
(41, 'Roji Saputra', 'roji.saputra@example.com', NULL, '$2y$12$G24MtGIMCPh3DLA1RAcaku4pO6RvMTtM00eAM7VnzheGe/qixUTti', NULL, '2026-03-14 01:38:44', '2026-04-05 19:51:02', 3, 'volunteer', '6283155428836'),
(42, 'Ridho', 'ridho@example.com', NULL, '$2y$12$mUT3ErnUC8A/v2RMZ.A9q.AISdnOFf3RKL2HwuFxQvCWjnJtvPCiy', NULL, '2026-03-14 01:38:44', '2026-04-05 19:51:02', 3, 'volunteer', '6281226273024'),
(43, 'Bidol Tambunan', 'bidol.tambunan@example.com', NULL, '$2y$12$PlyHyEcESOprD/LTeVwL/ewrmFdVgI2X6h4g4gw6lZK8F5kpxCMXK', NULL, '2026-03-14 01:38:45', '2026-04-05 19:51:02', 3, 'volunteer', '6282273174847'),
(44, 'Evi Tamala Sari', 'evi.tamala.sari@example.com', NULL, '$2y$12$6PBhL1BfUviCGHuwjHLYsOkSXRRR6ajEb16BK/U.sG577hvMWWZTe', NULL, '2026-03-14 01:38:46', '2026-04-05 19:51:02', 3, 'volunteer', '6281264063618'),
(45, 'Ika Nurlia', 'ika.nurlia@example.com', NULL, '$2y$12$ItmsxU4hw4ZATV52DzVdcev77kGx1se4Sk3ZcBm35CIf1aVrTuZ12', NULL, '2026-03-14 01:38:46', '2026-04-05 19:51:02', 3, 'volunteer', '6285277552975'),
(46, 'Lailatul Mardiah', 'lailatul.mardiah@example.com', NULL, '$2y$12$6yRiZTo8UT6qHq60dZ/vOepjxjgy9O7JSlsZ1fEgBeJMGz/wHc3Sq', NULL, '2026-03-14 01:38:47', '2026-04-05 19:51:02', 3, 'volunteer', '6281260968703'),
(47, 'Marsaulina Simanjuntak', 'marsaulina.simanjuntak@example.com', NULL, '$2y$12$KtlGeQu33QkHjoj9vFDZVeKQHNFSKQgMfeyxClZ29741cR0wPmKm6', NULL, '2026-03-14 01:38:47', '2026-04-05 19:51:02', 3, 'volunteer', '6283115228687'),
(48, 'Musina', 'musina@example.com', NULL, '$2y$12$yixoZp2t233EbtQU0TJLPuk6MWVo.mTWkXbbrUh9c5UYeL2JWYUWm', NULL, '2026-03-14 01:38:48', '2026-04-05 19:51:02', 3, 'volunteer', '6283893361503'),
(49, 'Rimma Ida Mei Silalahi', 'rimma.ida.mei.silalahi@example.com', NULL, '$2y$12$uwymMTlMWHkHeEeynMI5K.vm4BN8G4xbPgIl85jd579fecyfWonle', NULL, '2026-03-14 01:38:48', '2026-04-05 19:51:02', 3, 'volunteer', '6281320567577'),
(50, 'Sartika', 'sartika@example.com', NULL, '$2y$12$qMO/J98ff90Dtf89O95J9u59PYqdXZw8qFPqZO1sWkNo/7sKdl4aW', NULL, '2026-03-14 01:38:49', '2026-04-05 19:51:02', 3, 'volunteer', '6282379715318'),
(51, 'Vety Lestari', 'vety.lestari@example.com', NULL, '$2y$12$3MW3xB79iVQ9SEPouHKP4.joqv6r.4DImnxD/S9vdLFopFK1uZk/S', NULL, '2026-03-14 01:38:49', '2026-04-05 19:51:02', 3, 'volunteer', '6283845660494'),
(52, 'Arsoyo', 'arsoyo@example.com', NULL, '$2y$12$jp8SWEtMOvCe.JizgACK/.FAVRvloEvLwEht5h/R1KiWDrq//074O', NULL, '2026-03-14 01:38:50', '2026-04-05 19:51:02', 3, 'volunteer', '6281377819383'),
(53, 'Surobin', 'surobin@example.com', NULL, '$2y$12$2JMumSKFIF7JvCJMwyF/8OM.LK9QHEjdPyTT/7REIE.KpOVu4mBW.', NULL, '2026-03-14 01:38:51', '2026-04-05 19:51:02', 3, 'volunteer', '6282294220115'),
(54, 'Masiati', 'masiati@example.com', NULL, '$2y$12$3Bm92d4emDfHKWdA2bE2eOiDq73/cF7isi379TDUhrrHBbxw.cIN.', NULL, '2026-03-14 01:38:51', '2026-03-14 01:38:51', 1, 'volunteer', NULL),
(55, 'Marlina Samosir', 'marlina.samosir@example.com', NULL, '$2y$12$WGT6p/lsRn/FyfI/OIoNFusIevi.goFrxvxA/g3E2RhPhwWuSv14S', NULL, '2026-03-14 01:38:52', '2026-04-05 19:51:02', 3, 'volunteer', '6281370494440'),
(56, 'Endang Mustika', 'endang.mustika@example.com', NULL, '$2y$12$pB9Lg3FtfzzfNjEH50E/sea0pk2k5jvcA2WoTMWKigSYpNQiqsdFa', NULL, '2026-03-14 01:38:52', '2026-04-05 19:51:02', 3, 'volunteer', '6282272839113'),
(57, 'Awan', 'awan@example.com', NULL, '$2y$12$DhfHtZJcZsP3z.2qI70nBuKW6X572ZLpkmcwiq1jt9eOMvhNho4uO', NULL, '2026-03-14 01:38:53', '2026-03-14 01:38:53', 1, 'volunteer', NULL),
(58, 'Halimah Tusa\'diyah', 'halimah.tusa\'diyah@example.com', NULL, '$2y$12$/gfPt8eKhPlnvUbx5x55Oez1oIPRvD/i89OBOZTyHloBGxUhRYSsi', NULL, '2026-03-14 01:38:53', '2026-03-14 01:38:53', 1, 'volunteer', NULL),
(59, 'Lestari Dharmayanti', 'lestari.dharmayanti@example.com', NULL, '$2y$12$0cNXiHVU1qz4oBC2thEeE.1kFWe/tMb2MuqlTdulqIzMO3r5dVMhS', NULL, '2026-03-14 01:38:54', '2026-03-14 01:38:54', 2, 'volunteer', NULL),
(60, 'Daud Jaya Pane', 'daud.jaya.pane@example.com', NULL, '$2y$12$0SXgEFmRvVJWhRokWyQGCOZ71oRCkp6Y1dkZ.CbJdzRyP7Z3pNsfO', NULL, '2026-03-14 01:38:54', '2026-03-14 01:38:54', 2, 'volunteer', NULL),
(61, 'Evlin Anariska Sebayang', 'evlin.anariska.sebayang@example.com', NULL, '$2y$12$16GaUI5lWO.xTmjhln0d/eAX0mEnW99Zc18ea7jMdCllzHWx..06K', NULL, '2026-03-14 01:38:55', '2026-03-14 01:38:55', 2, 'volunteer', NULL),
(62, 'Deary Yosephine Sembiring', 'deary.yosephine.sembiring@example.com', NULL, '$2y$12$lpgDUqeHRXNGy1yiYvNN3.gv6vYNIwCNW5BfJ97DMfLKqtx2T3W6C', NULL, '2026-03-14 01:38:56', '2026-03-14 01:38:56', 2, 'volunteer', NULL),
(63, 'Admin Utama', 'admin2@botodelpi.com', NULL, '$2y$12$OMcrtXT.yrzwraJ2kuQ4v.kESUYSm/DiZcSmmbQzzk8RrGU3YNiha', NULL, '2026-04-05 07:55:45', '2026-04-05 07:55:45', NULL, 'admin', '6285353325352'),
(64, 'Lestari Darmayanti', 'lestari-darmayanti@delphi.or.id', NULL, '$2y$12$7gru00oI1OVQSFIr359qcuthgA8/oMtTppIhyg3u5cqETrHauDDuC', NULL, '2026-04-05 19:39:51', '2026-04-05 19:51:02', 3, 'volunteer', '6283848562059'),
(65, 'Yusni Ade Yohana Saragih', 'yusni-ade-yohana-saragih@delphi.or.id', NULL, '$2y$12$2R06zy//nbTaAoIxtIDHme.XVRUoyfYJIkDez9c7VwrPPaNDOKbJe', NULL, '2026-04-05 19:39:52', '2026-04-05 19:51:02', 3, 'volunteer', '6282263486056'),
(66, 'Umi Saidah', 'umi-saidah@delphi.or.id', NULL, '$2y$12$.mdDxiK5xOOLAGMeJdq1MufKl/tBmHdD.dPRm7/hdX/YxgOpi7JNm', NULL, '2026-04-05 19:39:52', '2026-04-05 19:51:02', 3, 'volunteer', '6281263303118'),
(67, 'Hermawan Ahmad Susilo', 'hermawan-ahmad-susilo@delphi.or.id', NULL, '$2y$12$TQ0J8UgtW0EwGCD6bwIxZeuXzkAP6lp6yYnkQ5vdEpVMyw0ncixaW', NULL, '2026-04-05 19:39:52', '2026-04-05 19:51:02', 3, 'volunteer', '6281377016718'),
(68, 'Halimatusa\'diyah', 'halimatusadiyah@delphi.or.id', NULL, '$2y$12$nMP0BpRN8X3wJQohTyoOreHauN5kEbWI081BWLegaG7AAz1P7jEmu', NULL, '2026-04-05 19:39:53', '2026-04-05 19:51:02', 3, 'volunteer', '6282277386975');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_attendances`
--

CREATE TABLE `volunteer_attendances` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `sppg_id` bigint UNSIGNED DEFAULT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in',
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `volunteer_attendances`
--

INSERT INTO `volunteer_attendances` (`id`, `user_id`, `sppg_id`, `latitude`, `longitude`, `status`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, -7.12390700, 112.71623720, 'in', NULL, '2026-02-27 06:06:46', '2026-02-27 06:06:46'),
(2, 1, NULL, -7.12390880, 112.71622810, 'in', NULL, '2026-02-28 07:46:40', '2026-02-28 07:46:40'),
(3, 1, NULL, -7.12390520, 112.71623170, 'in', NULL, '2026-03-05 08:37:05', '2026-03-05 08:37:05'),
(4, 1, NULL, -7.12395390, 112.71622470, 'in', NULL, '2026-03-14 00:56:10', '2026-03-14 00:56:10'),
(5, 12, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:27', '2026-03-14 01:38:27'),
(6, 13, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:28', '2026-03-14 01:38:28'),
(7, 14, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:29', '2026-03-14 01:38:29'),
(8, 15, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:29', '2026-03-14 01:38:29'),
(9, 16, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:30', '2026-03-14 01:38:30'),
(10, 17, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:30', '2026-03-14 01:38:30'),
(11, 18, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:31', '2026-03-14 01:38:31'),
(12, 19, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:31', '2026-03-14 01:38:31'),
(13, 20, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:32', '2026-03-14 01:38:32'),
(14, 21, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:33', '2026-03-14 01:38:33'),
(15, 22, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:33', '2026-03-14 01:38:33'),
(16, 23, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:34', '2026-03-14 01:38:34'),
(17, 24, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:34', '2026-03-14 01:38:34'),
(18, 25, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:35', '2026-03-14 01:38:35'),
(19, 26, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:35', '2026-03-14 01:38:35'),
(20, 27, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:36', '2026-03-14 01:38:36'),
(21, 28, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:36', '2026-03-14 01:38:36'),
(22, 29, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:37', '2026-03-14 01:38:37'),
(23, 30, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:38', '2026-03-14 01:38:38'),
(24, 31, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:38', '2026-03-14 01:38:38'),
(25, 32, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:39', '2026-03-14 01:38:39'),
(26, 33, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:40', '2026-03-14 01:38:40'),
(27, 34, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:40', '2026-03-14 01:38:40'),
(28, 35, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:41', '2026-03-14 01:38:41'),
(29, 36, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:41', '2026-03-14 01:38:41'),
(30, 37, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:42', '2026-03-14 01:38:42'),
(31, 38, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:42', '2026-03-14 01:38:42'),
(32, 39, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:43', '2026-03-14 01:38:43'),
(33, 40, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:43', '2026-03-14 01:38:43'),
(34, 41, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:44', '2026-03-14 01:38:44'),
(35, 42, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:44', '2026-03-14 01:38:44'),
(36, 43, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:45', '2026-03-14 01:38:45'),
(37, 44, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:46', '2026-03-14 01:38:46'),
(38, 45, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:46', '2026-03-14 01:38:46'),
(39, 46, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:47', '2026-03-14 01:38:47'),
(40, 47, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:47', '2026-03-14 01:38:47'),
(41, 48, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:48', '2026-03-14 01:38:48'),
(42, 49, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:48', '2026-03-14 01:38:48'),
(43, 50, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:49', '2026-03-14 01:38:49'),
(44, 51, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:49', '2026-03-14 01:38:49'),
(45, 52, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:50', '2026-03-14 01:38:50'),
(46, 53, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:51', '2026-03-14 01:38:51'),
(47, 54, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:51', '2026-03-14 01:38:51'),
(48, 55, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:52', '2026-03-14 01:38:52'),
(49, 56, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:52', '2026-03-14 01:38:52'),
(50, 57, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:53', '2026-03-14 01:38:53'),
(51, 58, 1, -2.97300000, 104.76400000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:53', '2026-03-14 01:38:53'),
(52, 59, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(53, 13, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(54, 14, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(55, 15, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(56, 16, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(57, 17, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(58, 18, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(59, 19, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(60, 21, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(61, 20, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(62, 22, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(63, 23, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(64, 24, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(65, 25, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(66, 26, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(67, 27, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(68, 28, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(69, 29, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(70, 30, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(71, 31, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(72, 32, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(73, 33, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(74, 34, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(75, 35, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(76, 36, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(77, 37, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(78, 38, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(79, 39, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(80, 40, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(81, 41, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(82, 42, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(83, 43, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(84, 44, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(85, 45, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(86, 46, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(87, 47, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(88, 48, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(89, 49, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(90, 50, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(91, 51, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(92, 54, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(93, 52, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(94, 53, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(95, 57, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(96, 55, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(97, 56, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(98, 58, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(99, 60, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:54', '2026-03-14 01:38:54'),
(100, 61, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:55', '2026-03-14 01:38:55'),
(101, 62, 2, -2.97400000, 104.76500000, 'Hadir', 'Sumatera Utara', '2026-03-14 01:38:56', '2026-03-14 01:38:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_balances`
--
ALTER TABLE `account_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beneficiaries_sppg_id_foreign` (`sppg_id`),
  ADD KEY `beneficiaries_beneficiary_group_id_foreign` (`beneficiary_group_id`);

--
-- Indexes for table `beneficiary_groups`
--
ALTER TABLE `beneficiary_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beneficiary_groups_sppg_id_foreign` (`sppg_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dishes_name_unique` (`name`);

--
-- Indexes for table `dish_menu`
--
ALTER TABLE `dish_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dish_menu_menu_id_foreign` (`menu_id`),
  ADD KEY `dish_menu_dish_id_foreign` (`dish_id`);

--
-- Indexes for table `distribution_routes`
--
ALTER TABLE `distribution_routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `distribution_routes_assistant_id_foreign` (`assistant_id`),
  ADD KEY `distribution_routes_driver_id_foreign` (`driver_id`),
  ADD KEY `distribution_routes_sppg_id_foreign` (`sppg_id`);

--
-- Indexes for table `distribution_stops`
--
ALTER TABLE `distribution_stops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `distribution_stops_distribution_route_id_foreign` (`distribution_route_id`),
  ADD KEY `distribution_stops_beneficiary_id_foreign` (`beneficiary_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `materials_code_unique` (`code`),
  ADD KEY `materials_sppg_id_foreign` (`sppg_id`);

--
-- Indexes for table `material_logs`
--
ALTER TABLE `material_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_logs_material_id_foreign` (`material_id`),
  ADD KEY `material_logs_sppg_id_foreign` (`sppg_id`);

--
-- Indexes for table `material_requests`
--
ALTER TABLE `material_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_requests_sppg_id_foreign` (`sppg_id`),
  ADD KEY `material_requests_material_id_foreign` (`material_id`);

--
-- Indexes for table `mbg_distributions`
--
ALTER TABLE `mbg_distributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mbg_distributions_beneficiary_id_foreign` (`beneficiary_id`),
  ADD KEY `mbg_distributions_sppg_id_foreign` (`sppg_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_sppg_id_foreign` (`sppg_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_url_unique` (`url`),
  ADD KEY `news_sppg_id_foreign` (`sppg_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_sppg_id_foreign` (`sppg_id`),
  ADD KEY `orders_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_material_id_foreign` (`material_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_beneficiary_id_foreign` (`beneficiary_id`),
  ADD KEY `payments_sppg_id_foreign` (`sppg_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipes_dish_id_foreign` (`dish_id`),
  ADD KEY `recipes_material_id_foreign` (`material_id`);

--
-- Indexes for table `sppgs`
--
ALTER TABLE `sppgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_sppg_id_foreign` (`sppg_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_sppg_id_foreign` (`sppg_id`);

--
-- Indexes for table `volunteer_attendances`
--
ALTER TABLE `volunteer_attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `volunteer_attendances_user_id_foreign` (`user_id`),
  ADD KEY `volunteer_attendances_sppg_id_foreign` (`sppg_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_balances`
--
ALTER TABLE `account_balances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beneficiary_groups`
--
ALTER TABLE `beneficiary_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `dish_menu`
--
ALTER TABLE `dish_menu`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `distribution_routes`
--
ALTER TABLE `distribution_routes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `distribution_stops`
--
ALTER TABLE `distribution_stops`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `material_logs`
--
ALTER TABLE `material_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `material_requests`
--
ALTER TABLE `material_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mbg_distributions`
--
ALTER TABLE `mbg_distributions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sppgs`
--
ALTER TABLE `sppgs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `volunteer_attendances`
--
ALTER TABLE `volunteer_attendances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD CONSTRAINT `beneficiaries_beneficiary_group_id_foreign` FOREIGN KEY (`beneficiary_group_id`) REFERENCES `beneficiary_groups` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `beneficiaries_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`);

--
-- Constraints for table `beneficiary_groups`
--
ALTER TABLE `beneficiary_groups`
  ADD CONSTRAINT `beneficiary_groups_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dish_menu`
--
ALTER TABLE `dish_menu`
  ADD CONSTRAINT `dish_menu_dish_id_foreign` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dish_menu_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `distribution_routes`
--
ALTER TABLE `distribution_routes`
  ADD CONSTRAINT `distribution_routes_assistant_id_foreign` FOREIGN KEY (`assistant_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `distribution_routes_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `distribution_routes_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`);

--
-- Constraints for table `distribution_stops`
--
ALTER TABLE `distribution_stops`
  ADD CONSTRAINT `distribution_stops_beneficiary_id_foreign` FOREIGN KEY (`beneficiary_id`) REFERENCES `beneficiary_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `distribution_stops_distribution_route_id_foreign` FOREIGN KEY (`distribution_route_id`) REFERENCES `distribution_routes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`);

--
-- Constraints for table `material_logs`
--
ALTER TABLE `material_logs`
  ADD CONSTRAINT `material_logs_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_logs_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`);

--
-- Constraints for table `material_requests`
--
ALTER TABLE `material_requests`
  ADD CONSTRAINT `material_requests_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  ADD CONSTRAINT `material_requests_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`);

--
-- Constraints for table `mbg_distributions`
--
ALTER TABLE `mbg_distributions`
  ADD CONSTRAINT `mbg_distributions_beneficiary_id_foreign` FOREIGN KEY (`beneficiary_id`) REFERENCES `beneficiaries` (`id`),
  ADD CONSTRAINT `mbg_distributions_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`);

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`);

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`),
  ADD CONSTRAINT `orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_beneficiary_id_foreign` FOREIGN KEY (`beneficiary_id`) REFERENCES `beneficiaries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`);

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_dish_id_foreign` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipes_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`);

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`);

--
-- Constraints for table `volunteer_attendances`
--
ALTER TABLE `volunteer_attendances`
  ADD CONSTRAINT `volunteer_attendances_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `volunteer_attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
