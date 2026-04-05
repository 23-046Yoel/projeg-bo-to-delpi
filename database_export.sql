
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `account_balances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_balances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `account_balances` WRITE;
/*!40000 ALTER TABLE `account_balances` DISABLE KEYS */;
/*!40000 ALTER TABLE `account_balances` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `beneficiaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `beneficiaries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
  `sppg_id` bigint unsigned DEFAULT NULL,
  `marga` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posyandu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `beneficiary_group_id` bigint unsigned DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `beneficiaries_sppg_id_foreign` (`sppg_id`),
  KEY `beneficiaries_beneficiary_group_id_foreign` (`beneficiary_group_id`),
  CONSTRAINT `beneficiaries_beneficiary_group_id_foreign` FOREIGN KEY (`beneficiary_group_id`) REFERENCES `beneficiary_groups` (`id`) ON DELETE SET NULL,
  CONSTRAINT `beneficiaries_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `beneficiaries` WRITE;
/*!40000 ALTER TABLE `beneficiaries` DISABLE KEYS */;
/*!40000 ALTER TABLE `beneficiaries` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `beneficiary_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `beneficiary_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `total_beneficiaries` int NOT NULL DEFAULT '0',
  `sppg_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `beneficiary_groups_sppg_id_foreign` (`sppg_id`),
  CONSTRAINT `beneficiary_groups_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `beneficiary_groups` WRITE;
/*!40000 ALTER TABLE `beneficiary_groups` DISABLE KEYS */;
INSERT INTO `beneficiary_groups` VALUES (1,'SD Negeri 096780 Kampung Tape','Kampung Tape',3.00715610,99.09849350,0,2,'2026-03-15 04:26:04','2026-03-15 04:26:04'),(2,'SD Min Karangsari','Karangsari',3.00450580,99.10061400,0,2,'2026-03-15 04:26:04','2026-03-15 04:26:04'),(3,'SD NEGERI 091262 KARANG SARI','Karang Sari',3.00633840,99.10685930,0,2,'2026-03-15 04:26:04','2026-03-15 04:26:04'),(4,'Titik Lokasi 1 (3°00\'28.6\"N 99°06\'32.5\"E)','3°00\'28.6\"N 99°06\'32.5\"E',3.00793900,99.10904000,0,2,'2026-03-15 04:26:04','2026-03-15 04:26:04'),(5,'Sekolah Satria Budi','Satria Budi',3.01205830,99.11370610,0,2,'2026-03-15 04:26:04','2026-03-15 04:26:04'),(6,'SD NEGERI 097806','SDN 097806',3.01419290,99.11419420,0,2,'2026-03-15 04:26:04','2026-03-15 04:26:04'),(7,'SMP Negeri 1 Gunung Maligas','Gunung Maligas',3.02061290,99.12097030,0,2,'2026-03-15 04:26:04','2026-03-15 04:26:04'),(8,'Yayasan Pendidikan Al Fikry','Al Fikry',3.02919380,99.12278910,0,2,'2026-03-15 04:26:04','2026-03-15 04:26:04'),(9,'Titik Lokasi 2 (3°00\'34.1\"N 99°06\'42.6\"E)','3°00\'34.1\"N 99°06\'42.6\"E',3.00947800,99.11182200,0,2,'2026-03-15 04:26:04','2026-03-15 04:26:04'),(10,'Titik Lokasi 3 (3°00\'26.4\"N 99°06\'45.5\"E)','3°00\'26.4\"N 99°06\'45.5\"E',3.00732000,99.11262900,0,2,'2026-03-15 04:26:04','2026-03-15 04:26:04'),(11,'SD Negeri 095560 Karang Sari','Karang Sari',3.00635990,99.11186320,0,2,'2026-03-15 04:26:04','2026-03-15 04:26:04'),(12,'SD Margosono','SD Margosono',2.96900000,99.16000000,0,1,'2026-03-18 04:49:26','2026-03-18 05:27:50'),(13,'SMPN 3 Tanah Jawa','SMPN 3 Tanah Jawa',2.97000000,99.18000000,0,1,'2026-03-18 04:49:26','2026-03-18 05:27:51'),(14,'SD AFD C Balimbingan','SD AFD C Balimbingan',2.97100000,99.16500000,0,1,'2026-03-18 04:49:26','2026-03-18 05:27:51'),(15,'SD Maligas Tongah','SD Maligas Tongah',2.97300000,99.16200000,0,1,'2026-03-18 04:49:26','2026-03-18 05:27:51'),(16,'B3 Nagori Balimbingan','B3 Nagori Balimbingan',2.97200000,99.17000000,0,1,'2026-03-18 04:49:26','2026-03-18 05:27:51'),(17,'SD Bajadolok','SD Bajadolok',2.96500000,99.18500000,0,1,'2026-03-18 04:49:26','2026-03-18 05:27:51'),(18,'TK, SD, SMP dan SMA Nusantara','TK, SD, SMP dan SMA Nusantara',2.96800000,99.17200000,0,1,'2026-03-18 04:49:26','2026-03-18 05:27:51'),(19,'SMPN 2 Tanah Jawa','SMPN 2 Tanah Jawa',2.97500000,99.15500000,0,1,'2026-03-18 04:49:26','2026-03-18 05:27:51');
/*!40000 ALTER TABLE `beneficiary_groups` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `dish_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dish_menu` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint unsigned DEFAULT NULL,
  `dish_id` bigint unsigned DEFAULT NULL,
  `portions` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dish_menu_menu_id_foreign` (`menu_id`),
  KEY `dish_menu_dish_id_foreign` (`dish_id`),
  CONSTRAINT `dish_menu_dish_id_foreign` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dish_menu_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `dish_menu` WRITE;
/*!40000 ALTER TABLE `dish_menu` DISABLE KEYS */;
INSERT INTO `dish_menu` VALUES (1,2,1,2300,'2026-03-18 04:22:34','2026-03-18 04:22:34'),(2,2,2,2300,'2026-03-18 04:22:34','2026-03-18 04:22:34'),(3,2,3,2300,'2026-03-18 04:22:34','2026-03-18 04:22:34'),(4,2,7,2300,'2026-03-18 04:22:34','2026-03-18 04:22:34'),(5,2,4,2300,'2026-03-18 04:22:34','2026-03-18 04:22:34'),(6,3,1,2300,'2026-03-18 04:25:19','2026-03-18 04:25:19'),(7,3,5,2300,'2026-03-18 04:25:19','2026-03-18 04:25:19'),(8,3,7,2300,'2026-03-18 04:25:19','2026-03-18 04:25:19'),(9,3,4,2300,'2026-03-18 04:25:19','2026-03-18 04:25:19');
/*!40000 ALTER TABLE `dish_menu` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `dishes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dishes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dishes_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `dishes` WRITE;
/*!40000 ALTER TABLE `dishes` DISABLE KEYS */;
INSERT INTO `dishes` VALUES (1,'Nasi Putih',NULL,'2026-02-20 08:40:11','2026-02-20 08:40:11'),(2,'Ayam Goreng Tepung',NULL,'2026-02-20 08:40:11','2026-02-20 08:40:11'),(3,'Capcay',NULL,'2026-02-20 08:40:11','2026-02-20 08:40:11'),(4,'Pepaya',NULL,'2026-02-20 08:40:11','2026-02-20 08:40:11'),(5,'Ikan Nila Goreng',NULL,'2026-02-20 08:40:11','2026-02-20 08:40:11'),(6,'Ikan Lele',NULL,'2026-02-20 08:40:11','2026-02-20 08:40:11'),(7,'Tahu Goreng',NULL,'2026-02-20 08:40:11','2026-02-20 08:40:11'),(8,'Tempe Goreng',NULL,'2026-02-20 08:40:11','2026-02-20 08:40:11'),(9,'Telur semur',NULL,'2026-03-25 10:49:16','2026-03-25 10:49:16');
/*!40000 ALTER TABLE `dishes` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `distribution_routes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distribution_routes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `assistant_id` bigint unsigned NOT NULL,
  `driver_id` bigint unsigned NOT NULL,
  `sppg_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `status` enum('planned','active','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'planned',
  `departure_time` timestamp NULL DEFAULT NULL,
  `departure_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `distribution_routes_assistant_id_foreign` (`assistant_id`),
  KEY `distribution_routes_driver_id_foreign` (`driver_id`),
  KEY `distribution_routes_sppg_id_foreign` (`sppg_id`),
  CONSTRAINT `distribution_routes_assistant_id_foreign` FOREIGN KEY (`assistant_id`) REFERENCES `users` (`id`),
  CONSTRAINT `distribution_routes_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`),
  CONSTRAINT `distribution_routes_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `distribution_routes` WRITE;
/*!40000 ALTER TABLE `distribution_routes` DISABLE KEYS */;
INSERT INTO `distribution_routes` VALUES (3,3,1,1,'2026-03-18','planned',NULL,NULL,'2026-03-18 04:49:26','2026-03-18 04:49:26'),(4,5,4,1,'2026-03-18','planned',NULL,NULL,'2026-03-18 04:49:26','2026-03-18 04:49:26'),(5,3,1,1,'2026-03-18','planned',NULL,NULL,'2026-03-18 05:27:50','2026-03-18 05:27:50'),(6,5,4,1,'2026-03-18','planned',NULL,NULL,'2026-03-18 05:27:51','2026-03-18 05:27:51');
/*!40000 ALTER TABLE `distribution_routes` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `distribution_stops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distribution_stops` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `distribution_route_id` bigint unsigned NOT NULL,
  `beneficiary_id` bigint unsigned NOT NULL,
  `quantity` int unsigned NOT NULL DEFAULT '1',
  `order` int NOT NULL,
  `status` enum('pending','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `arrival_time` timestamp NULL DEFAULT NULL,
  `handover_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `handover_doc_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `distribution_stops_distribution_route_id_foreign` (`distribution_route_id`),
  KEY `distribution_stops_beneficiary_id_foreign` (`beneficiary_id`),
  CONSTRAINT `distribution_stops_beneficiary_id_foreign` FOREIGN KEY (`beneficiary_id`) REFERENCES `beneficiary_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `distribution_stops_distribution_route_id_foreign` FOREIGN KEY (`distribution_route_id`) REFERENCES `distribution_routes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `distribution_stops` WRITE;
/*!40000 ALTER TABLE `distribution_stops` DISABLE KEYS */;
INSERT INTO `distribution_stops` VALUES (1,3,12,1,1,'pending','2026-03-18 01:45:00',NULL,NULL,'2026-03-18 04:49:26','2026-03-18 04:49:26'),(2,3,13,1,2,'pending','2026-03-18 01:45:00',NULL,NULL,'2026-03-18 04:49:26','2026-03-18 04:49:26'),(3,3,14,1,3,'pending','2026-03-18 01:45:00',NULL,NULL,'2026-03-18 04:49:26','2026-03-18 04:49:26'),(4,3,15,1,4,'pending','2026-03-18 01:45:00',NULL,NULL,'2026-03-18 04:49:26','2026-03-18 04:49:26'),(5,3,16,1,5,'pending','2026-03-18 03:45:00',NULL,NULL,'2026-03-18 04:49:26','2026-03-18 04:49:26'),(6,4,17,1,1,'pending','2026-03-18 02:30:00',NULL,NULL,'2026-03-18 04:49:26','2026-03-18 04:49:26'),(7,4,18,1,2,'pending','2026-03-18 02:30:00',NULL,NULL,'2026-03-18 04:49:26','2026-03-18 04:49:26'),(8,4,19,1,3,'pending','2026-03-18 03:20:00',NULL,NULL,'2026-03-18 04:49:26','2026-03-18 04:49:26'),(9,5,12,1,1,'pending','2026-03-18 01:45:00',NULL,NULL,'2026-03-18 05:27:50','2026-03-18 05:27:50'),(10,5,13,1,2,'pending','2026-03-18 01:45:00',NULL,NULL,'2026-03-18 05:27:51','2026-03-18 05:27:51'),(11,5,14,1,3,'pending','2026-03-18 01:45:00',NULL,NULL,'2026-03-18 05:27:51','2026-03-18 05:27:51'),(12,5,15,1,4,'pending','2026-03-18 01:45:00',NULL,NULL,'2026-03-18 05:27:51','2026-03-18 05:27:51'),(13,5,16,1,5,'pending','2026-03-18 03:45:00',NULL,NULL,'2026-03-18 05:27:51','2026-03-18 05:27:51'),(14,6,17,1,1,'pending','2026-03-18 02:30:00',NULL,NULL,'2026-03-18 05:27:51','2026-03-18 05:27:51'),(15,6,18,1,2,'pending','2026-03-18 02:30:00',NULL,NULL,'2026-03-18 05:27:51','2026-03-18 05:27:51'),(16,6,19,1,3,'pending','2026-03-18 03:20:00',NULL,NULL,'2026-03-18 05:27:51','2026-03-18 05:27:51');
/*!40000 ALTER TABLE `distribution_stops` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `material_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `material_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `material_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sppg_id` bigint unsigned DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aroma` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temperature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `storage_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_logs_material_id_foreign` (`material_id`),
  KEY `material_logs_sppg_id_foreign` (`sppg_id`),
  CONSTRAINT `material_logs_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  CONSTRAINT `material_logs_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `material_logs` WRITE;
/*!40000 ALTER TABLE `material_logs` DISABLE KEYS */;
INSERT INTO `material_logs` VALUES (1,2,'in',7000000.00,'2026-02-23','2026-02-23 07:18:20','2026-02-23 07:18:20',NULL,NULL,NULL,NULL,NULL),(2,4,'out',80000.00,'2026-02-23','2026-02-23 07:24:28','2026-02-23 07:24:28',NULL,NULL,NULL,NULL,NULL),(3,3,'out',90000.00,'2026-02-23','2026-02-23 07:27:43','2026-02-23 07:27:43',NULL,NULL,NULL,NULL,NULL),(4,5,'in',900000.00,'2026-02-23','2026-02-23 07:31:17','2026-02-23 07:31:17',NULL,NULL,NULL,NULL,NULL),(5,2,'in',1000.00,'2026-02-23','2026-02-23 08:10:08','2026-02-23 08:10:08',NULL,NULL,NULL,NULL,NULL),(6,3,'out',7000.00,'2026-02-23','2026-02-23 08:28:23','2026-02-23 08:28:23',NULL,NULL,NULL,NULL,NULL),(7,4,'out',20000.00,'2026-02-23','2026-02-23 08:50:57','2026-02-23 08:50:57',NULL,NULL,NULL,NULL,NULL),(8,5,'out',90000.00,'2026-02-23','2026-02-23 09:26:29','2026-02-23 09:26:29',NULL,NULL,NULL,NULL,NULL),(9,5,'out',90000.00,'2026-02-23','2026-02-23 09:26:31','2026-02-23 09:26:31',NULL,NULL,NULL,NULL,NULL),(10,2,'out',800000.00,'2026-02-23','2026-02-23 10:33:47','2026-02-23 10:33:47',NULL,NULL,NULL,NULL,NULL),(11,5,'out',900000.00,'2026-02-24','2026-02-23 18:48:35','2026-02-23 18:48:35',NULL,NULL,NULL,NULL,NULL),(12,3,'in',700000.00,'2026-02-24','2026-02-23 18:49:26','2026-02-23 18:49:26',NULL,NULL,NULL,NULL,NULL),(13,3,'in',700000.00,'2026-02-24','2026-02-23 19:06:34','2026-02-23 19:06:34',NULL,NULL,NULL,NULL,NULL),(14,12,'out',45000.00,'2026-02-24','2026-02-23 19:13:32','2026-02-23 19:13:32',NULL,NULL,NULL,NULL,NULL),(15,1,'out',900000.00,'2026-02-25','2026-02-24 23:27:55','2026-02-24 23:27:55',NULL,NULL,NULL,NULL,NULL),(16,7,'in',909090.00,'2026-02-25','2026-02-24 23:28:22','2026-02-24 23:28:22',NULL,NULL,NULL,NULL,NULL),(17,5,'out',9000.00,'2026-03-01','2026-03-01 16:55:26','2026-03-01 16:55:26',NULL,NULL,NULL,NULL,NULL),(18,8,'out',9000.00,'2026-03-11','2026-03-11 08:04:04','2026-03-11 08:04:04',NULL,NULL,NULL,NULL,NULL),(19,9,'in',700.00,'2026-03-16','2026-03-16 02:05:30','2026-03-16 02:05:30',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `material_logs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `material_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `material_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sppg_id` bigint unsigned NOT NULL,
  `material_id` bigint unsigned NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `source_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `temperature_received` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prep_completed_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_requests_sppg_id_foreign` (`sppg_id`),
  KEY `material_requests_material_id_foreign` (`material_id`),
  CONSTRAINT `material_requests_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  CONSTRAINT `material_requests_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `material_requests` WRITE;
/*!40000 ALTER TABLE `material_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `material_requests` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'raw',
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `stock` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sppg_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materials_sppg_id_foreign` (`sppg_id`),
  CONSTRAINT `materials_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `materials` WRITE;
/*!40000 ALTER TABLE `materials` DISABLE KEYS */;
INSERT INTO `materials` VALUES (1,'beras','raw',NULL,0.00,-900000.00,'2026-02-20 08:40:11','2026-02-24 23:27:55',NULL),(2,'ayam','raw',NULL,0.00,6201000.00,'2026-02-20 08:40:11','2026-02-23 10:33:48',NULL),(3,'tepung tapioka','raw',NULL,0.00,1303000.00,'2026-02-20 08:40:11','2026-02-23 19:06:34',NULL),(4,'garam','raw',NULL,0.00,-100000.00,'2026-02-20 08:40:11','2026-02-23 08:50:57',NULL),(5,'buncis','raw',NULL,0.00,-189000.00,'2026-02-20 08:40:11','2026-03-01 16:55:26',NULL),(6,'bunga kol','raw',NULL,0.00,0.00,'2026-02-20 08:40:11','2026-02-20 08:40:11',NULL),(7,'wortel','raw',NULL,0.00,909090.00,'2026-02-20 08:40:11','2026-02-24 23:28:22',NULL),(8,'Pepaya','raw',NULL,0.00,-9000.00,'2026-02-20 08:40:11','2026-03-11 08:04:04',NULL),(9,'Nila','raw',NULL,0.00,700.00,'2026-02-20 08:40:11','2026-03-16 02:05:30',NULL),(10,'Lele','raw',NULL,0.00,0.00,'2026-02-20 08:40:11','2026-02-20 08:40:11',NULL),(11,'tahu','raw',NULL,0.00,0.00,'2026-02-20 08:40:11','2026-02-20 08:40:11',NULL),(12,'tempe','raw',NULL,0.00,-45000.00,'2026-02-20 08:40:11','2026-02-23 19:13:32',NULL),(13,'Telor','raw','Buah',1900.00,0.00,'2026-03-25 10:53:45','2026-03-25 10:53:45',NULL);
/*!40000 ALTER TABLE `materials` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `mbg_distributions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mbg_distributions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `beneficiary_id` bigint unsigned NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `distributed_at` timestamp NOT NULL,
  `sppg_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mbg_distributions_beneficiary_id_foreign` (`beneficiary_id`),
  KEY `mbg_distributions_sppg_id_foreign` (`sppg_id`),
  CONSTRAINT `mbg_distributions_beneficiary_id_foreign` FOREIGN KEY (`beneficiary_id`) REFERENCES `beneficiaries` (`id`),
  CONSTRAINT `mbg_distributions_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `mbg_distributions` WRITE;
/*!40000 ALTER TABLE `mbg_distributions` DISABLE KEYS */;
/*!40000 ALTER TABLE `mbg_distributions` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `sppg_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menus_sppg_id_foreign` (`sppg_id`),
  CONSTRAINT `menus_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'2026-03-06',NULL,NULL,'2026-03-06 09:27:24','2026-03-06 09:27:24'),(2,'2026-03-18',NULL,NULL,'2026-03-18 04:22:34','2026-03-18 04:22:34'),(3,'2026-03-18',NULL,NULL,'2026-03-18 04:25:19','2026-03-18 04:25:19');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2026_02_20_060323_create_suppliers_table',2),(6,'2026_02_20_060325_create_beneficiaries_table',2),(7,'2026_02_20_060326_create_materials_table',2),(8,'2026_02_20_060328_create_material_logs_table',2),(9,'2026_02_20_060329_create_payments_table',2),(10,'2026_02_20_063826_create_sppgs_table',3),(11,'2026_02_20_063827_create_mbg_distributions_table',3),(12,'2026_02_20_063847_enhance_tables_for_bot_and_sppg',3),(13,'2026_02_20_064434_add_phone_to_users_table',4),(14,'2026_02_20_072951_create_menus_table',5),(15,'2026_02_20_153858_create_dishes_table',6),(16,'2026_02_20_153859_create_recipes_table',6),(17,'2026_02_20_153900_create_orders_table',6),(18,'2026_02_20_153901_create_order_items_table',6),(19,'2026_02_20_154041_enhance_material_logs_and_payments_for_mbg_specs',7),(20,'2026_02_20_154213_create_dish_menu_table',7),(21,'2026_02_20_154954_create_material_requests_table',7),(22,'2026_02_20_154955_refine_financial_ledger_table',7),(23,'2026_02_20_155051_create_account_balances_table',7),(24,'2026_02_25_153026_set_admin_role_for_master_users',8),(25,'2026_02_26_063233_create_volunteer_attendances_table',9),(26,'2026_02_27_073258_add_phone_to_sppgs_table',10),(27,'2026_03_04_130631_add_details_to_materials_table',11),(28,'2026_03_04_131536_add_gender_and_guardian_phone_to_beneficiaries_table',12),(29,'2026_03_05_093804_make_content_nullable_in_menus_table',13),(30,'2026_03_05_100357_remove_grammage_from_materials_table',14),(32,'2026_03_05_101207_create_distribution_routes_table',15),(34,'2026_03_06_100000_create_beneficiary_groups_table',16),(35,'2026_03_06_100001_update_beneficiaries_add_group_and_details',16),(36,'2026_03_05_101217_create_distribution_stops_table',17),(37,'2026_03_06_160000_add_missing_columns_to_dish_menu_table',18),(38,'2026_03_13_133702_add_geofence_to_sppgs_table',19),(39,'2026_03_13_133707_add_sppg_id_to_volunteer_attendances_table',19),(40,'2026_03_15_112241_add_coordinates_to_beneficiary_groups_table',20),(41,'2026_03_18_113433_add_description_to_dishes_table',21),(42,'2026_03_18_115525_add_quantity_to_distribution_stops_table',22),(43,'2026_03_30_041743_add_code_to_sppgs_table',23);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `material_id` bigint unsigned NOT NULL,
  `requested_quantity` decimal(15,4) NOT NULL,
  `received_quantity` decimal(15,4) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_material_id_foreign` (`material_id`),
  CONSTRAINT `order_items_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,1,125.0000,NULL,'kg',14750.00,'2026-03-01 09:53:52','2026-03-01 09:53:52'),(2,1,5,200.0000,NULL,'kg',245000.00,'2026-03-01 09:53:52','2026-03-01 09:53:52'),(3,2,1,125.0000,NULL,'kg',14750.00,'2026-03-01 09:53:53','2026-03-01 09:53:53'),(4,2,5,200.0000,NULL,'kg',245000.00,'2026-03-01 09:53:53','2026-03-01 09:53:53');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sppg_id` bigint unsigned DEFAULT NULL,
  `supplier_id` bigint unsigned NOT NULL,
  `order_date` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_sppg_id_foreign` (`sppg_id`),
  KEY `orders_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `orders_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`),
  CONSTRAINT `orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,NULL,2,'2026-03-01','pending',0.00,NULL,'2026-03-01 09:53:52','2026-03-01 09:53:52'),(2,NULL,2,'2026-03-01','pending',0.00,NULL,'2026-03-01 09:53:53','2026-03-01 09:53:53');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES ('silverius1008@gmail.com','$2y$12$HPRAPBdmFURIGjBmitDMHOY.2diQnbKjVuKbwRkkN2VssJjUCF.z.','2026-02-22 04:35:42'),('yoelflemming8@gmail.com','$2y$12$CWpJgzYWS7mM1pz.ro/9o.wGJj00Al6fE5RWNZ8WFKtqjeovsyzGe','2026-02-22 05:14:57');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `beneficiary_id` bigint unsigned NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `amount_in` decimal(15,2) NOT NULL DEFAULT '0.00',
  `amount_out` decimal(15,2) NOT NULL DEFAULT '0.00',
  `balance_after` decimal(15,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sppg_id` bigint unsigned DEFAULT NULL,
  `transaction_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proof_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_beneficiary_id_foreign` (`beneficiary_id`),
  KEY `payments_sppg_id_foreign` (`sppg_id`),
  CONSTRAINT `payments_beneficiary_id_foreign` FOREIGN KEY (`beneficiary_id`) REFERENCES `beneficiaries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `recipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recipes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `dish_id` bigint unsigned NOT NULL,
  `material_id` bigint unsigned NOT NULL,
  `quantity` decimal(10,4) NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recipes_dish_id_foreign` (`dish_id`),
  KEY `recipes_material_id_foreign` (`material_id`),
  CONSTRAINT `recipes_dish_id_foreign` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `recipes_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `recipes` WRITE;
/*!40000 ALTER TABLE `recipes` DISABLE KEYS */;
INSERT INTO `recipes` VALUES (1,1,1,0.0600,'kg',NULL,'2026-02-20 08:40:11','2026-02-20 08:55:38'),(2,2,2,0.1000,'kg','10 porsi/kg','2026-02-20 08:40:11','2026-02-20 08:55:38'),(3,2,3,0.0300,'kg','33 porsi/kg','2026-02-20 08:40:11','2026-02-20 08:55:38'),(4,2,4,0.0020,'kg','500 porsi/kg','2026-02-20 08:40:11','2026-02-20 08:55:38'),(5,3,5,0.0300,'kg','33 porsi/kg','2026-02-20 08:40:11','2026-02-20 08:55:38'),(6,3,6,0.0300,'kg','33 porsi/kg','2026-02-20 08:40:11','2026-02-20 08:55:38'),(7,3,7,0.0300,'kg','33 porsi/kg','2026-02-20 08:40:11','2026-02-20 08:55:38'),(8,4,8,0.0500,'buah','1 pepaya dipotong 20','2026-02-20 08:40:11','2026-02-20 08:55:38'),(9,5,9,0.0830,'kg','6 ekor / kg; 2 porsi /ekor','2026-02-20 08:40:11','2026-02-20 08:55:38'),(10,6,10,0.1000,'kg','10 ekor/kg','2026-02-20 08:40:11','2026-02-20 08:55:38'),(11,7,11,1.0000,'buah','1 buah tahu/porsi','2026-02-20 08:40:11','2026-02-20 08:55:38'),(12,8,12,0.2000,'buah','5 porsi/1 tempe','2026-02-20 08:40:11','2026-02-20 08:55:38'),(13,9,4,0.0300,'gr',NULL,'2026-03-25 10:52:47','2026-03-25 10:52:47'),(14,9,13,1.0000,'Buah',NULL,'2026-03-25 10:54:11','2026-03-25 10:54:11');
/*!40000 ALTER TABLE `recipes` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `sppgs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sppgs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `sppgs` WRITE;
/*!40000 ALTER TABLE `sppgs` DISABLE KEYS */;
INSERT INTO `sppgs` VALUES (1,NULL,'SPPG Dolok Batu Nanggar','Eka Imam Fadli','082166791406','Debora Oktavine Gracia Sinaga','082273832503','Masdalena','085270493144','082166791406','Balimbingan II',2.96980000,99.16780000,100,'2026-03-13 06:38:18','2026-03-29 21:40:02'),(2,NULL,'SPPG Karang Rejo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Karang Rejo, 3°00\'36.3\"N 99°06\'42.4\"E',3.01009100,99.11177600,100,'2026-03-13 06:38:18','2026-03-15 04:26:04'),(3,'BQQ4FHOV','SPPG Karangrejo','Daud Jaya Pane','081396517800','Evlin Anariska Sebayang','081260154491','Deary Yosephine Sembiring','081340399290','081396517800',NULL,NULL,NULL,100,'2026-03-29 21:40:02','2026-03-29 21:40:02'),(4,'MEUZONOK','SPPG Balimbingan II','Abdi Septian','082161772172','Agita Sebayang','082217053980','Meylinda','088260013607','082161772172',NULL,NULL,NULL,100,'2026-03-29 21:40:02','2026-03-29 21:40:02');
/*!40000 ALTER TABLE `sppgs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `village` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sppg_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `suppliers_sppg_id_foreign` (`sppg_id`),
  CONSTRAINT `suppliers_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Yoel','sampang','085768610448','beras',0.00,'2026-02-20 00:19:58','2026-02-20 00:19:58',NULL),(2,'Ansiva Indonesia','dolok hataran','082273051823','roti, sembako,',0.00,'2026-03-01 09:45:32','2026-03-01 09:45:32',NULL);
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sppg_id` bigint unsigned DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  KEY `users_sppg_id_foreign` (`sppg_id`),
  CONSTRAINT `users_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Yoel Flemming','yoelflemming8@gmail.com',NULL,'$2y$12$V9dByKpMBLnYQ4eE9O6hC.e4rbEaXbbFoEagTB45qv84Z5E1SvXAW',NULL,'2026-02-19 23:11:50','2026-02-28 17:05:39',NULL,'admin','6285767610448'),(3,'Antoinette Kemmer','mosciski.bonnie@example.net','2026-02-25 22:58:52','$2y$04$8yxTE.yKbJBIZrHZzgdfbe0ed5LrDORY04TrpjVh6c.6Omvcne.ZC','1hNgzgRqov','2026-02-25 22:58:52','2026-02-28 17:05:39',NULL,'admin','6281324687114'),(4,'Ardella Collier','dkessler@example.net','2026-02-25 22:58:57','$2y$04$8yxTE.yKbJBIZrHZzgdfbe0ed5LrDORY04TrpjVh6c.6Omvcne.ZC','RyhV2c2qz8','2026-02-25 22:58:57','2026-02-28 17:05:39',NULL,'admin','6281260873610'),(5,'Prof. Jan Emmerich','naomie.kunde@example.com','2026-02-25 22:59:24','$2y$04$hfgw1WgCamOb/oPI4vxWcuL7wzlHsP8bTWFkySvkChn7iE2I4/5Ky','y0d1eJGOOy','2026-02-25 22:59:24','2026-02-28 17:05:39',NULL,'admin',NULL),(6,'Pablo Crooks','rkuphal@example.org','2026-02-25 22:59:25','$2y$04$hfgw1WgCamOb/oPI4vxWcuL7wzlHsP8bTWFkySvkChn7iE2I4/5Ky','885fcfKjNh','2026-02-25 22:59:25','2026-02-28 17:05:39',NULL,'admin',NULL),(7,'Johnnie Lang','kutch.raquel@example.com','2026-02-25 23:15:10','$2y$04$X1mH5FcL3jQ7YOXfB6uuceWMNgTTkP6yMNxAJJj1oxTf0p1sxAAu6','nlUkWCNWbZ','2026-02-25 23:15:10','2026-02-28 17:05:39',NULL,'admin',NULL),(8,'Bernie Waelchi','neal05@example.net','2026-02-25 23:15:11','$2y$04$X1mH5FcL3jQ7YOXfB6uuceWMNgTTkP6yMNxAJJj1oxTf0p1sxAAu6','2xQRC9hugR','2026-02-25 23:15:11','2026-02-28 17:05:39',NULL,'admin',NULL),(9,'Liliane Padberg','collier.kristian@example.net','2026-02-25 23:18:04','$2y$04$lhkmu/qfKbc8.UXwGWCEAupbpkW/Xcwf8NLti5.a5NSd.HfvV9Mfy','hYFLjbgNvl','2026-02-25 23:18:04','2026-02-28 17:05:39',NULL,'admin',NULL),(10,'Deshaun Hansen','trudie.kuhic@example.net','2026-02-25 23:18:04','$2y$04$lhkmu/qfKbc8.UXwGWCEAupbpkW/Xcwf8NLti5.a5NSd.HfvV9Mfy','QF3Gnbeyq8','2026-02-25 23:18:04','2026-02-28 17:05:39',NULL,'admin',NULL),(11,'Nama Relawan','nama.relawan@example.com',NULL,'$2y$12$Z96gToP4Xg03lqi1TckP7O8.DLNfd9RqwOPSCixVz4YaDyrzomo0q',NULL,'2026-03-14 01:37:57','2026-03-14 01:37:57',1,'volunteer',NULL),(12,'Lestari Dhamayanti','lestari.dhamayanti@example.com',NULL,'$2y$12$tZzHiQwXDnFRV4a1H9f1lOo9otRNeeYq0fcLplOO0dR6n3768f0pG',NULL,'2026-03-14 01:38:27','2026-03-14 01:38:27',1,'volunteer',NULL),(13,'Fitriana','fitriana@example.com',NULL,'$2y$12$rmpJaWCNZmzbwYAlWb6vmu9a7JfH8PLjQJOQDqG.HF5NPOD3RDO0q',NULL,'2026-03-14 01:38:28','2026-03-14 01:38:28',1,'volunteer',NULL),(14,'Lenni Jumira Dewi','lenni.jumira.dewi@example.com',NULL,'$2y$12$uhhUZaf0WxXTaGQotz/.mOQ8pr666jMyhWMjfbdiT/auSNMPCUldq',NULL,'2026-03-14 01:38:28','2026-03-14 01:38:28',1,'volunteer',NULL),(15,'Murniati','murniati@example.com',NULL,'$2y$12$TwXNheqF3Z9KKisKJx6SM.n2Ik7Z3DWQIPHoMh3luWpqPZ11gdIb6',NULL,'2026-03-14 01:38:29','2026-03-14 01:38:29',1,'volunteer',NULL),(16,'Norma Yunita','norma.yunita@example.com',NULL,'$2y$12$rWOgRGZzbFKBuhoqKf.WzejDMcn8.ZUnzgcHI3ydnmuuhFcjTOnhy',NULL,'2026-03-14 01:38:30','2026-03-14 01:38:30',1,'volunteer',NULL),(17,'Ria Misjayana','ria.misjayana@example.com',NULL,'$2y$12$BRZd1yVGRpdJqaKnwwac0.Vh5qTiVwjcAdISR1sFZEh9PPed5eHRS',NULL,'2026-03-14 01:38:30','2026-03-14 01:38:30',1,'volunteer',NULL),(18,'Sri Rahayu','sri.rahayu@example.com',NULL,'$2y$12$uQDJvrS8wz9RhckweD/BPeP7pV1YzfWeNtlpXnWmcyYI5/C1M4J/y',NULL,'2026-03-14 01:38:31','2026-03-14 01:38:31',1,'volunteer',NULL),(19,'Wilda Rizky Aulia','wilda.rizky.aulia@example.com',NULL,'$2y$12$jbPf.XolOSzqG.1uy4jOP.pceJn2MUNvUKeakqNZZwxvZwrehxgYe',NULL,'2026-03-14 01:38:31','2026-03-14 01:38:31',1,'volunteer',NULL),(20,'Tino','tino@example.com',NULL,'$2y$12$VWVysHJuePFEizmyJHcD9ebYKrGXXJjgAykTSSN.Nvxz9yjKDRlDe',NULL,'2026-03-14 01:38:32','2026-03-14 01:38:32',1,'volunteer',NULL),(21,'Dewi Mariam','dewi.mariam@example.com',NULL,'$2y$12$VMQh8ez3KtmdsoBI66Kdt.1dyblP3K484b8bD3axowZgZtmrlj0L6',NULL,'2026-03-14 01:38:33','2026-03-14 01:38:33',1,'volunteer',NULL),(22,'Ghubayani Pardede','ghubayani.pardede@example.com',NULL,'$2y$12$LgATso/IvZeVHrdI/Avb1e1BdXqPM69nhiPPeIELk16Bl4QG.xq3i',NULL,'2026-03-14 01:38:33','2026-03-14 01:38:33',1,'volunteer',NULL),(23,'Nila Kusuma','nila.kusuma@example.com',NULL,'$2y$12$6dQv2CpT6ixtM3WUlZ4U8.DhgJcuqdeo0yL/F2l.cWZMxmBh/wMzm',NULL,'2026-03-14 01:38:34','2026-03-14 01:38:34',1,'volunteer',NULL),(24,'Parti Alima','parti.alima@example.com',NULL,'$2y$12$OyeposLRDg1ZykSAkVjzv.FYxFAuwvl.v0twMnBTUK4EozYnpYxUe',NULL,'2026-03-14 01:38:34','2026-03-14 01:38:34',1,'volunteer',NULL),(25,'Siti Sendari','siti.sendari@example.com',NULL,'$2y$12$W2Wmxt3IeUyyeP2EqDma9.WqvOFTvB1RY3dLAKZKJgiHTZPwDsrAu',NULL,'2026-03-14 01:38:35','2026-03-14 01:38:35',1,'volunteer',NULL),(26,'Supia','supia@example.com',NULL,'$2y$12$BHKMqVlR.1aQIFhn0J/6cug1N5O.3y2Mb3njCEX2aaCjgN.cjjTb.',NULL,'2026-03-14 01:38:35','2026-03-14 01:38:35',1,'volunteer',NULL),(27,'Triana Murni','triana.murni@example.com',NULL,'$2y$12$ofyorhU96Zj4MIzrKI5WBuOFnPbuvFVYX5faZWQXbltypwo32i.4S',NULL,'2026-03-14 01:38:36','2026-03-14 01:38:36',1,'volunteer',NULL),(28,'Johendri Damanik','johendri.damanik@example.com',NULL,'$2y$12$Rk9/VgaLdy6/pXImIgY7TOiz7zt6AqqktBn.OMCfp8brxZXJcONBu',NULL,'2026-03-14 01:38:36','2026-03-14 01:38:36',1,'volunteer',NULL),(29,'Bella Cahaya','bella.cahaya@example.com',NULL,'$2y$12$6zdewcXh8DSvWbq/qojwXeGPNvq/BlCd06WvRLxl.DFy.dQ.1zwxS',NULL,'2026-03-14 01:38:37','2026-03-14 01:38:37',1,'volunteer',NULL),(30,'Luvi Hazah Rindiani','luvi.hazah.rindiani@example.com',NULL,'$2y$12$XF8einLoemTlQ3bLgE5INOBZv8Av8UADuO04DtTyR51HH9dz1C4wW',NULL,'2026-03-14 01:38:38','2026-03-14 01:38:38',1,'volunteer',NULL),(31,'Marwiyah','marwiyah@example.com',NULL,'$2y$12$mJcjphce8ciTsINST0jknOievFSPZGcY.mTsB9h5O32OCC6VCPZey',NULL,'2026-03-14 01:38:38','2026-03-14 01:38:38',1,'volunteer',NULL),(32,'Nasita','nasita@example.com',NULL,'$2y$12$yse7AmMXUNRWC8kyvt0FA.vgYnWaO55PHRNPs./EZcXi0Fp6s.fJq',NULL,'2026-03-14 01:38:39','2026-03-14 01:38:39',1,'volunteer',NULL),(33,'Nur Asma Ambulani','nur.asma.ambulani@example.com',NULL,'$2y$12$Qi14fq88Y0QmPXCXsxTSme9jvh7zLP8yEMwVPmpLmkZTcWcoVm8Ti',NULL,'2026-03-14 01:38:40','2026-03-14 01:38:40',1,'volunteer',NULL),(34,'Pinky Chairani','pinky.chairani@example.com',NULL,'$2y$12$wxOS9rF/YtCj4ZSFggc57eRASRb4kotAn3LTidQlZIOpJ5VW6lQq.',NULL,'2026-03-14 01:38:40','2026-03-14 01:38:40',1,'volunteer',NULL),(35,'Rumida','rumida@example.com',NULL,'$2y$12$PDEk1dx2XC0Sr4hCHn1Al.PKvPGMvl/c0rfWfbI6qAektSZDU/otG',NULL,'2026-03-14 01:38:41','2026-03-14 01:38:41',1,'volunteer',NULL),(36,'Salma Wardah Lubis','salma.wardah.lubis@example.com',NULL,'$2y$12$0jC5djsCDBp3Lg.luN1M1.7JdoXaxbFO3tKpfRqJ4nlze0W6CnP86',NULL,'2026-03-14 01:38:41','2026-03-14 01:38:41',1,'volunteer',NULL),(37,'Sunenti','sunenti@example.com',NULL,'$2y$12$Nl0UwAltaJUlyoBaYsojR.iunI2hqO1TmlOBYy.LKktcP6g0Eg23i',NULL,'2026-03-14 01:38:42','2026-03-14 01:38:42',1,'volunteer',NULL),(38,'Umi Saida','umi.saida@example.com',NULL,'$2y$12$VKkCDZk6KZfpoy6evEy5HOULBTia.eu/17NQhS8kVs65jaEcw5awi',NULL,'2026-03-14 01:38:42','2026-03-14 01:38:42',1,'volunteer',NULL),(39,'Irvan Hasudungan Silalahi','irvan.hasudungan.silalahi@example.com',NULL,'$2y$12$UxoscP2pxgoWla8RISd7ae6Rgs6PEWEjx8CPq/In0kOFRM/ZbZTvi',NULL,'2026-03-14 01:38:43','2026-03-14 01:38:43',1,'volunteer',NULL),(40,'Henry Hamonongan Siahaan','henry.hamonongan.siahaan@example.com',NULL,'$2y$12$cCN.3uknOqIIBSRgYCAmnurZwQIGGQT7iAOJ1N7kO8Os9/fY0SQBC',NULL,'2026-03-14 01:38:43','2026-03-14 01:38:43',1,'volunteer',NULL),(41,'Roji Saputra','roji.saputra@example.com',NULL,'$2y$12$G24MtGIMCPh3DLA1RAcaku4pO6RvMTtM00eAM7VnzheGe/qixUTti',NULL,'2026-03-14 01:38:44','2026-03-14 01:38:44',1,'volunteer',NULL),(42,'Ridho','ridho@example.com',NULL,'$2y$12$mUT3ErnUC8A/v2RMZ.A9q.AISdnOFf3RKL2HwuFxQvCWjnJtvPCiy',NULL,'2026-03-14 01:38:44','2026-03-14 01:38:44',1,'volunteer',NULL),(43,'Bidol Tambunan','bidol.tambunan@example.com',NULL,'$2y$12$PlyHyEcESOprD/LTeVwL/ewrmFdVgI2X6h4g4gw6lZK8F5kpxCMXK',NULL,'2026-03-14 01:38:45','2026-03-14 01:38:45',1,'volunteer',NULL),(44,'Evi Tamala Sari','evi.tamala.sari@example.com',NULL,'$2y$12$6PBhL1BfUviCGHuwjHLYsOkSXRRR6ajEb16BK/U.sG577hvMWWZTe',NULL,'2026-03-14 01:38:46','2026-03-14 01:38:46',1,'volunteer',NULL),(45,'Ika Nurlia','ika.nurlia@example.com',NULL,'$2y$12$ItmsxU4hw4ZATV52DzVdcev77kGx1se4Sk3ZcBm35CIf1aVrTuZ12',NULL,'2026-03-14 01:38:46','2026-03-14 01:38:46',1,'volunteer',NULL),(46,'Lailatul Mardiah','lailatul.mardiah@example.com',NULL,'$2y$12$6yRiZTo8UT6qHq60dZ/vOepjxjgy9O7JSlsZ1fEgBeJMGz/wHc3Sq',NULL,'2026-03-14 01:38:47','2026-03-14 01:38:47',1,'volunteer',NULL),(47,'Marsaulina Simanjuntak','marsaulina.simanjuntak@example.com',NULL,'$2y$12$KtlGeQu33QkHjoj9vFDZVeKQHNFSKQgMfeyxClZ29741cR0wPmKm6',NULL,'2026-03-14 01:38:47','2026-03-14 01:38:47',1,'volunteer',NULL),(48,'Musina','musina@example.com',NULL,'$2y$12$yixoZp2t233EbtQU0TJLPuk6MWVo.mTWkXbbrUh9c5UYeL2JWYUWm',NULL,'2026-03-14 01:38:48','2026-03-14 01:38:48',1,'volunteer',NULL),(49,'Rimma Ida Mei Silalahi','rimma.ida.mei.silalahi@example.com',NULL,'$2y$12$uwymMTlMWHkHeEeynMI5K.vm4BN8G4xbPgIl85jd579fecyfWonle',NULL,'2026-03-14 01:38:48','2026-03-14 01:38:48',1,'volunteer',NULL),(50,'Sartika','sartika@example.com',NULL,'$2y$12$qMO/J98ff90Dtf89O95J9u59PYqdXZw8qFPqZO1sWkNo/7sKdl4aW',NULL,'2026-03-14 01:38:49','2026-03-14 01:38:49',1,'volunteer',NULL),(51,'Vety Lestari','vety.lestari@example.com',NULL,'$2y$12$3MW3xB79iVQ9SEPouHKP4.joqv6r.4DImnxD/S9vdLFopFK1uZk/S',NULL,'2026-03-14 01:38:49','2026-03-14 01:38:49',1,'volunteer',NULL),(52,'Arsoyo','arsoyo@example.com',NULL,'$2y$12$jp8SWEtMOvCe.JizgACK/.FAVRvloEvLwEht5h/R1KiWDrq//074O',NULL,'2026-03-14 01:38:50','2026-03-14 01:38:50',1,'volunteer',NULL),(53,'Surobin','surobin@example.com',NULL,'$2y$12$2JMumSKFIF7JvCJMwyF/8OM.LK9QHEjdPyTT/7REIE.KpOVu4mBW.',NULL,'2026-03-14 01:38:51','2026-03-14 01:38:51',1,'volunteer',NULL),(54,'Masiati','masiati@example.com',NULL,'$2y$12$3Bm92d4emDfHKWdA2bE2eOiDq73/cF7isi379TDUhrrHBbxw.cIN.',NULL,'2026-03-14 01:38:51','2026-03-14 01:38:51',1,'volunteer',NULL),(55,'Marlina Samosir','marlina.samosir@example.com',NULL,'$2y$12$WGT6p/lsRn/FyfI/OIoNFusIevi.goFrxvxA/g3E2RhPhwWuSv14S',NULL,'2026-03-14 01:38:52','2026-03-14 01:38:52',1,'volunteer',NULL),(56,'Endang Mustika','endang.mustika@example.com',NULL,'$2y$12$pB9Lg3FtfzzfNjEH50E/sea0pk2k5jvcA2WoTMWKigSYpNQiqsdFa',NULL,'2026-03-14 01:38:52','2026-03-14 01:38:52',1,'volunteer',NULL),(57,'Awan','awan@example.com',NULL,'$2y$12$DhfHtZJcZsP3z.2qI70nBuKW6X572ZLpkmcwiq1jt9eOMvhNho4uO',NULL,'2026-03-14 01:38:53','2026-03-14 01:38:53',1,'volunteer',NULL),(58,'Halimah Tusa\'diyah','halimah.tusa\'diyah@example.com',NULL,'$2y$12$/gfPt8eKhPlnvUbx5x55Oez1oIPRvD/i89OBOZTyHloBGxUhRYSsi',NULL,'2026-03-14 01:38:53','2026-03-14 01:38:53',1,'volunteer',NULL),(59,'Lestari Dharmayanti','lestari.dharmayanti@example.com',NULL,'$2y$12$0cNXiHVU1qz4oBC2thEeE.1kFWe/tMb2MuqlTdulqIzMO3r5dVMhS',NULL,'2026-03-14 01:38:54','2026-03-14 01:38:54',2,'volunteer',NULL),(60,'Daud Jaya Pane','daud.jaya.pane@example.com',NULL,'$2y$12$0SXgEFmRvVJWhRokWyQGCOZ71oRCkp6Y1dkZ.CbJdzRyP7Z3pNsfO',NULL,'2026-03-14 01:38:54','2026-03-14 01:38:54',2,'volunteer',NULL),(61,'Evlin Anariska Sebayang','evlin.anariska.sebayang@example.com',NULL,'$2y$12$16GaUI5lWO.xTmjhln0d/eAX0mEnW99Zc18ea7jMdCllzHWx..06K',NULL,'2026-03-14 01:38:55','2026-03-14 01:38:55',2,'volunteer',NULL),(62,'Deary Yosephine Sembiring','deary.yosephine.sembiring@example.com',NULL,'$2y$12$lpgDUqeHRXNGy1yiYvNN3.gv6vYNIwCNW5BfJ97DMfLKqtx2T3W6C',NULL,'2026-03-14 01:38:56','2026-03-14 01:38:56',2,'volunteer',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `volunteer_attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `volunteer_attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `sppg_id` bigint unsigned DEFAULT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in',
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `volunteer_attendances_user_id_foreign` (`user_id`),
  KEY `volunteer_attendances_sppg_id_foreign` (`sppg_id`),
  CONSTRAINT `volunteer_attendances_sppg_id_foreign` FOREIGN KEY (`sppg_id`) REFERENCES `sppgs` (`id`) ON DELETE SET NULL,
  CONSTRAINT `volunteer_attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `volunteer_attendances` WRITE;
/*!40000 ALTER TABLE `volunteer_attendances` DISABLE KEYS */;
INSERT INTO `volunteer_attendances` VALUES (1,1,NULL,-7.12390700,112.71623720,'in',NULL,'2026-02-27 06:06:46','2026-02-27 06:06:46'),(2,1,NULL,-7.12390880,112.71622810,'in',NULL,'2026-02-28 07:46:40','2026-02-28 07:46:40'),(3,1,NULL,-7.12390520,112.71623170,'in',NULL,'2026-03-05 08:37:05','2026-03-05 08:37:05'),(4,1,NULL,-7.12395390,112.71622470,'in',NULL,'2026-03-14 00:56:10','2026-03-14 00:56:10'),(5,12,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:27','2026-03-14 01:38:27'),(6,13,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:28','2026-03-14 01:38:28'),(7,14,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:29','2026-03-14 01:38:29'),(8,15,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:29','2026-03-14 01:38:29'),(9,16,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:30','2026-03-14 01:38:30'),(10,17,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:30','2026-03-14 01:38:30'),(11,18,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:31','2026-03-14 01:38:31'),(12,19,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:31','2026-03-14 01:38:31'),(13,20,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:32','2026-03-14 01:38:32'),(14,21,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:33','2026-03-14 01:38:33'),(15,22,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:33','2026-03-14 01:38:33'),(16,23,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:34','2026-03-14 01:38:34'),(17,24,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:34','2026-03-14 01:38:34'),(18,25,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:35','2026-03-14 01:38:35'),(19,26,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:35','2026-03-14 01:38:35'),(20,27,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:36','2026-03-14 01:38:36'),(21,28,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:36','2026-03-14 01:38:36'),(22,29,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:37','2026-03-14 01:38:37'),(23,30,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:38','2026-03-14 01:38:38'),(24,31,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:38','2026-03-14 01:38:38'),(25,32,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:39','2026-03-14 01:38:39'),(26,33,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:40','2026-03-14 01:38:40'),(27,34,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:40','2026-03-14 01:38:40'),(28,35,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:41','2026-03-14 01:38:41'),(29,36,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:41','2026-03-14 01:38:41'),(30,37,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:42','2026-03-14 01:38:42'),(31,38,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:42','2026-03-14 01:38:42'),(32,39,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:43','2026-03-14 01:38:43'),(33,40,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:43','2026-03-14 01:38:43'),(34,41,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:44','2026-03-14 01:38:44'),(35,42,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:44','2026-03-14 01:38:44'),(36,43,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:45','2026-03-14 01:38:45'),(37,44,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:46','2026-03-14 01:38:46'),(38,45,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:46','2026-03-14 01:38:46'),(39,46,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:47','2026-03-14 01:38:47'),(40,47,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:47','2026-03-14 01:38:47'),(41,48,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:48','2026-03-14 01:38:48'),(42,49,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:48','2026-03-14 01:38:48'),(43,50,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:49','2026-03-14 01:38:49'),(44,51,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:49','2026-03-14 01:38:49'),(45,52,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:50','2026-03-14 01:38:50'),(46,53,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:51','2026-03-14 01:38:51'),(47,54,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:51','2026-03-14 01:38:51'),(48,55,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:52','2026-03-14 01:38:52'),(49,56,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:52','2026-03-14 01:38:52'),(50,57,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:53','2026-03-14 01:38:53'),(51,58,1,-2.97300000,104.76400000,'Hadir','Sumatera Utara','2026-03-14 01:38:53','2026-03-14 01:38:53'),(52,59,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(53,13,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(54,14,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(55,15,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(56,16,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(57,17,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(58,18,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(59,19,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(60,21,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(61,20,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(62,22,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(63,23,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(64,24,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(65,25,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(66,26,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(67,27,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(68,28,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(69,29,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(70,30,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(71,31,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(72,32,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(73,33,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(74,34,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(75,35,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(76,36,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(77,37,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(78,38,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(79,39,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(80,40,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(81,41,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(82,42,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(83,43,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(84,44,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(85,45,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(86,46,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(87,47,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(88,48,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(89,49,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(90,50,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(91,51,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(92,54,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(93,52,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(94,53,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(95,57,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(96,55,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(97,56,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(98,58,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(99,60,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:54','2026-03-14 01:38:54'),(100,61,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:55','2026-03-14 01:38:55'),(101,62,2,-2.97400000,104.76500000,'Hadir','Sumatera Utara','2026-03-14 01:38:56','2026-03-14 01:38:56');
/*!40000 ALTER TABLE `volunteer_attendances` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

