-- MySQL dump 10.13  Distrib 8.4.5, for macos14.7 (x86_64)
--
-- Host: 127.0.0.1    Database: abs
-- ------------------------------------------------------
-- Server version	8.4.5

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

--
-- Table structure for table `attendance_locations`
--

DROP TABLE IF EXISTS `attendance_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendance_locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(15,12) NOT NULL,
  `longitude` decimal(15,12) NOT NULL,
  `radius_meters` int NOT NULL DEFAULT '100',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance_locations`
--

LOCK TABLES `attendance_locations` WRITE;
/*!40000 ALTER TABLE `attendance_locations` DISABLE KEYS */;
INSERT INTO `attendance_locations` VALUES (1,'sekolah',-6.562994582429,110.860592426399,500,1,1,'sekolah -6.5629887489653065, 110.86059288248293','2025-07-02 02:17:23','2025-07-02 08:31:58'),(2,'Main School Building',-6.200000000000,106.816666000000,100,1,1,'Primary attendance location for the school','2025-07-02 10:09:52','2025-07-02 10:09:52'),(3,'School Sports Field',-6.200500000000,106.817000000000,50,1,0,'Sports field area for physical education classes','2025-07-02 10:09:52','2025-07-02 10:09:52');
/*!40000 ALTER TABLE `attendance_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `check_in_location` json DEFAULT NULL,
  `check_in_location_valid` tinyint(1) NOT NULL DEFAULT '0',
  `check_out_location` json DEFAULT NULL,
  `check_out_location_valid` tinyint(1) NOT NULL DEFAULT '0',
  `check_in_device_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_out_device_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_holiday` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendances_user_id_date_unique` (`user_id`,`date`),
  CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel_cache_spatie.permission.cache','a:3:{s:5:\"alias\";a:0:{}s:11:\"permissions\";a:0:{}s:5:\"roles\";a:0:{}}',1751529276),('laravel_cache_system_setting_default_language','s:2:\"id\";',1751477474);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_rooms`
--

DROP TABLE IF EXISTS `class_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class_rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_rooms`
--

LOCK TABLES `class_rooms` WRITE;
/*!40000 ALTER TABLE `class_rooms` DISABLE KEYS */;
INSERT INTO `class_rooms` VALUES (1,'7A',30,'7A','2025-05-18 02:46:16','2025-05-18 02:46:16'),(2,'10 IPA 1',30,'Building A, Floor 1','2025-07-01 21:11:00','2025-07-01 21:11:00'),(3,'10 IPA 2',30,'Building A, Floor 1','2025-07-01 21:11:00','2025-07-01 21:11:00'),(4,'10 IPS 1',32,'Building A, Floor 2','2025-07-01 21:11:00','2025-07-01 21:11:00'),(5,'10 IPS 2',32,'Building A, Floor 2','2025-07-01 21:11:00','2025-07-01 21:11:00'),(6,'11 IPA 1',30,'Building B, Floor 1','2025-07-01 21:11:00','2025-07-01 21:11:00'),(7,'11 IPA 2',30,'Building B, Floor 1','2025-07-01 21:11:00','2025-07-01 21:11:00'),(8,'11 IPS 1',32,'Building B, Floor 2','2025-07-01 21:11:00','2025-07-01 21:11:00'),(9,'11 IPS 2',32,'Building B, Floor 2','2025-07-01 21:11:00','2025-07-01 21:11:00'),(10,'12 IPA 1',30,'Building C, Floor 1','2025-07-01 21:11:00','2025-07-01 21:11:00'),(11,'12 IPA 2',30,'Building C, Floor 1','2025-07-01 21:11:00','2025-07-01 21:11:00'),(12,'12 IPS 1',32,'Building C, Floor 2','2025-07-01 21:11:00','2025-07-01 21:11:00'),(13,'12 IPS 2',32,'Building C, Floor 2','2025-07-01 21:11:00','2025-07-01 21:11:00');
/*!40000 ALTER TABLE `class_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_schedules`
--

DROP TABLE IF EXISTS `class_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class_schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subject_id` bigint unsigned NOT NULL,
  `class_room_id` bigint unsigned NOT NULL,
  `teacher_id` bigint unsigned NOT NULL,
  `day_of_week` int NOT NULL COMMENT '1-7 representing Monday-Sunday',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `schedule_room_time_unique` (`class_room_id`,`day_of_week`,`start_time`),
  UNIQUE KEY `schedule_teacher_time_unique` (`teacher_id`,`day_of_week`,`start_time`),
  KEY `class_schedules_subject_id_foreign` (`subject_id`),
  CONSTRAINT `class_schedules_class_room_id_foreign` FOREIGN KEY (`class_room_id`) REFERENCES `class_rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_schedules_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_schedules_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_schedules`
--

LOCK TABLES `class_schedules` WRITE;
/*!40000 ALTER TABLE `class_schedules` DISABLE KEYS */;
INSERT INTO `class_schedules` VALUES (1,1,1,2,1,'08:00:00','09:15:00',1,'2025-05-18 02:46:49','2025-05-18 02:46:49'),(2,16,2,2,3,'16:20:00','20:00:00',1,'2025-07-02 02:18:47','2025-07-02 02:18:47');
/*!40000 ALTER TABLE `class_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `device_registrations`
--

DROP TABLE IF EXISTS `device_registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `device_registrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `device_identifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_details` json NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_used_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `device_registrations_device_identifier_unique` (`device_identifier`),
  KEY `device_registrations_user_id_foreign` (`user_id`),
  KEY `device_registrations_approved_by_foreign` (`approved_by`),
  CONSTRAINT `device_registrations_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  CONSTRAINT `device_registrations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `device_registrations`
--

LOCK TABLES `device_registrations` WRITE;
/*!40000 ALTER TABLE `device_registrations` DISABLE KEYS */;
INSERT INTO `device_registrations` VALUES (1,6,'e07b4a5e297d1c604591b18ec16fc0b7d60cbe35a4919678b3be0691c9fe09a3','{\"ip_address\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.1.1 Safari/605.1.15\", \"accept_encoding\": \"gzip, deflate\", \"accept_language\": \"en-GB,en-US;q=0.9,en;q=0.8\"}',1,'2025-07-02 06:52:21','2025-07-02 06:52:21',NULL,NULL,'2025-07-02 06:52:21','2025-07-02 06:52:21');
/*!40000 ALTER TABLE `device_registrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

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

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `holidays` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `date` date NOT NULL,
  `is_recurring` tinyint(1) NOT NULL DEFAULT '0',
  `is_national_holiday` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `holidays_date_title_unique` (`date`,`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holidays`
--

LOCK TABLES `holidays` WRITE;
/*!40000 ALTER TABLE `holidays` DISABLE KEYS */;
/*!40000 ALTER TABLE `holidays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_05_18_060758_create_attendances_table',1),(5,'2025_05_18_060803_create_schedules_table',1),(6,'2025_05_18_060809_create_device_registrations_table',1),(7,'2025_05_18_060814_create_holidays_table',1),(8,'2025_05_18_061743_create_personal_access_tokens_table',1),(9,'2025_05_18_062616_create_permission_tables',1),(10,'2025_05_18_063008_create_notifications_table',1),(11,'2025_05_18_063538_create_subjects_table',1),(12,'2025_05_18_063726_create_class_rooms_table',1),(13,'2025_05_18_064608_create_subjects_table',1),(14,'2025_05_18_064608_create_teacher_profiles_table',1),(15,'2025_05_18_064812_create_teacher_profiles_table',1),(16,'2025_05_18_065306_create_teacher_subjects_table',1),(17,'2025_05_18_065336_create_holidays_table',1),(18,'2025_05_18_070959_create_class_schedules_table',1),(19,'2025_05_18_074959_add_columns_to_subjects_table',1),(20,'2025_05_18_075137_create_teacher_profiles_table_fixed',1),(29,'2025_05_18_075617_recreate_holidays_table',2),(30,'2025_05_18_093749_add_qualification_column_to_teacher_profiles_table',2),(31,'2025_05_18_100000_create_students_table',2),(32,'2025_05_18_100001_create_teaching_sessions_table',2),(33,'2025_05_18_100002_create_student_attendances_table',2),(34,'2025_05_18_100003_create_attendance_locations_table',2),(35,'2025_05_18_100004_create_system_settings_table',2),(36,'2025_05_18_100005_update_attendances_table',2),(37,'2025_07_02_142900_increase_attendance_locations_precision',3),(38,'2025_07_02_153120_increase_attendance_locations_precision',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

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

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',6,'teacher-web','b14b7ea5b5ac3c4c65941e8bc7700152cd5ef03e7fbef35aaa36eef15505ed79','[\"*\"]',NULL,NULL,'2025-07-02 06:52:21','2025-07-02 06:52:21'),(2,'App\\Models\\User',6,'teacher-web','bea10319c137bbfc5c3fc7f227d3957e99626cc74a86f323dbc8ccf69b7ebcc4','[\"*\"]',NULL,NULL,'2025-07-02 07:03:37','2025-07-02 07:03:37'),(3,'App\\Models\\User',6,'teacher-web','a4ccdf6c24d2182720cfd23b00629a3732eba89995f83be5dec770b90cbf4757','[\"*\"]',NULL,NULL,'2025-07-02 07:09:30','2025-07-02 07:09:30'),(4,'App\\Models\\User',6,'teacher-web','980bc3d5c9e235df14fcb873efc6bd702b105a40f0824fe5c53fecd4a1a55589','[\"*\"]',NULL,NULL,'2025-07-02 07:24:22','2025-07-02 07:24:22'),(5,'App\\Models\\User',6,'teacher-web','3b6fb91f3be1fa72f745f66cd467db6e7d45d07cfd0a8d995376419d01873a06','[\"*\"]',NULL,NULL,'2025-07-02 07:26:51','2025-07-02 07:26:51'),(6,'App\\Models\\User',6,'teacher-web','101099a88b02002bd57cb137c5bd49150d8c7b8056da7d7ed8fc3a93d80032a5','[\"*\"]',NULL,NULL,'2025-07-02 07:30:26','2025-07-02 07:30:26'),(7,'App\\Models\\User',6,'teacher-web','916ccecec7cbaf40370cfd23e09b11868f7124d0561a74145acbbf443c7660f1','[\"*\"]',NULL,NULL,'2025-07-02 07:41:16','2025-07-02 07:41:16'),(8,'App\\Models\\User',6,'teacher-web','eeea7ee885ed8d7ed3f3f2487373d4e4c29dcab956a2a6aca3222f3a470528aa','[\"*\"]',NULL,NULL,'2025-07-02 07:42:13','2025-07-02 07:42:13'),(9,'App\\Models\\User',6,'teacher-web','9ba0b602b9378447eb2db220595aa5300ac80bb7cb63036e5d6dfce4501ad6d5','[\"*\"]',NULL,NULL,'2025-07-02 08:34:50','2025-07-02 08:34:50'),(10,'App\\Models\\User',6,'teacher-web','9fed1f97e709335ef03a294dac6c9160807cbd0da4eccf975eecff0fde03cb0a','[\"*\"]',NULL,NULL,'2025-07-02 08:35:05','2025-07-02 08:35:05');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `day_of_week` int NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_exception` tinyint(1) NOT NULL DEFAULT '0',
  `exception_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_schedule` (`user_id`,`day_of_week`,`is_exception`,`exception_date`),
  CONSTRAINT `schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (2,2,2,'08:00:00','16:00:00',1,0,NULL,'2025-05-18 02:36:24','2025-05-18 02:36:24'),(3,2,3,'08:00:00','16:00:00',1,0,NULL,'2025-05-18 02:36:24','2025-05-18 02:36:24'),(4,2,4,'08:00:00','16:00:00',1,0,NULL,'2025-05-18 02:36:24','2025-05-18 02:36:24'),(5,2,5,'08:00:00','16:00:00',1,0,NULL,'2025-05-18 02:36:24','2025-05-18 02:36:24'),(6,3,1,'08:00:00','16:00:00',1,0,NULL,'2025-05-18 02:36:24','2025-05-18 02:36:24'),(7,3,2,'08:00:00','16:00:00',1,0,NULL,'2025-05-18 02:36:24','2025-05-18 02:36:24'),(8,3,3,'08:00:00','16:00:00',1,0,NULL,'2025-05-18 02:36:24','2025-05-18 02:36:24'),(9,3,4,'08:00:00','16:00:00',1,0,NULL,'2025-05-18 02:36:24','2025-05-18 02:36:24'),(10,3,5,'08:00:00','16:00:00',1,0,NULL,'2025-05-18 02:36:24','2025-05-18 02:36:24');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('05djBml8oR2z2uuI54hgiDfLGDf7Hwc8PbLNXArB',6,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.1.1 Safari/605.1.15','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiR21HOGVOTktIVXNtR09qaGRBdFhYMWJKMWsydmN1ZDhrTE1xWE1LYiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMDoiaHR0cDovL2Ficy50ZXN0L2d1cnUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMzoiaHR0cDovL2Ficy50ZXN0L3RlYWNoZXIvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NjtzOjEzOiJ0ZWFjaGVyX3Rva2VuIjtzOjUwOiIxfEE5WUFaVjBpT3o2ZTFrOUpQbUI1emphMkI5OThIMkM5TGIxS3EyaWYwNGJjN2JmZCI7fQ==',1751466610),('26xJ7mAo3t9lUUEDlWFOKy2fKjGP2Uf7Y677qiis',NULL,'127.0.0.1','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWjlZUk5JRjN3SWdnNG1QbWFhYWJtRVc5YXE4V0dHbGNPS2ZrSXpUbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9hYTM4LTE0MC0yMTMtMTczLTcxLm5ncm9rLWZyZWUuYXBwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1751467825),('6GnOVKkFZs3IAvMN6nEyO0xZ4W1JUx0i1eZ0YYBP',NULL,'127.0.0.1','curl/8.7.1','YTo0OntzOjY6Il90b2tlbiI7czo0MDoicVl2eWNjelpXQ05waUNDaEJ4c25ReGRxRU82TVFFYlpGTjZ0T2JMRyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo2MDoiaHR0cDovL2FhMzgtMTQwLTIxMy0xNzMtNzEubmdyb2stZnJlZS5hcHAvdGVhY2hlci9hdHRlbmRhbmNlIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly9hYTM4LTE0MC0yMTMtMTczLTcxLm5ncm9rLWZyZWUuYXBwL3RlYWNoZXIvYXR0ZW5kYW5jZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1751469195),('9ev1NQKIz5M2HUYHx765Xsrj82skDKAdi3ITZ7Y4',1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo3OntzOjY6Il90b2tlbiI7czo0MDoiblBOR1JVMm9oNjh5QlA4WHBpRVlxeXJGZjlTNUpLb2dQN0lLWmpsNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9hYnMudGVzdC9hZG1pbi90ZWFjaGVyLXByb2ZpbGVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJGRBMXhVWEZpTDJ6NmNvbDM4enZ2c09NaXBLM3NoZ0VLZFBlM2svNWQuczgvSUFWaG5hN3V5IjtzOjg6ImZpbGFtZW50IjthOjA6e31zOjY6InRhYmxlcyI7YToyOntzOjQxOiI0YjAxOWQ2OTQ2ZWUyNjhiNTg3ZDlkMTkzYmU3YmU3YV9wZXJfcGFnZSI7czoyOiI1MCI7czo0ODoiZDIzODNkOGRlMjc2YTI3YzhlMzkzNWQ5ZGE5YTk1ZTJfdG9nZ2xlZF9jb2x1bW5zIjthOjI6e3M6MTA6ImNyZWF0ZWRfYXQiO2I6MTtzOjEwOiJ1cGRhdGVkX2F0IjtiOjE7fX19',1751472342),('aaGJxoZ6qwSdBqZUGt4hBwXTiEsMfvzGeDwAgbEq',6,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.1.1 Safari/605.1.15','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVjNOTlFSUDMzOThybWllbGhmVTltVDdoQ3FERHY1Ujl2RUtjYnh6SyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTk6Imh0dHA6Ly9hYTM4LTE0MC0yMTMtMTczLTcxLm5ncm9rLWZyZWUuYXBwL3RlYWNoZXIvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NjtzOjEzOiJ0ZWFjaGVyX3Rva2VuIjtzOjUwOiI2fHJCOGhDM3pLWkhZeUZ3Y2lWT3g1YlV4Sk9wSlRiYnZlVHZFY1F1Y2IyZmUwNDdjNSI7fQ==',1751469251),('doHBTeM1w38oEnIYcBEngTP1zW13pmyvN2GiD5Lr',6,'127.0.0.1','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYWRyTWthY1hybW00eWt0b0FHZnhjNXkyZGRKdFVIdVJ4WmNkS2x6VSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly9hYTM4LTE0MC0yMTMtMTczLTcxLm5ncm9rLWZyZWUuYXBwL3RlYWNoZXIvYXR0ZW5kYW5jZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7czoxMzoidGVhY2hlcl90b2tlbiI7czo1MDoiM3xvS00weUhBeDJlbkxTTE1HaWJSd1RnYWtNNG5GUWZvcGs0UThhT1RCOTU0NWU0NmQiO30=',1751467873),('eTL0bl7XnI7tfRuZkKqH8wfrNHsZXudgqULNkLEX',6,'192.168.43.17','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVkxmQWt6WmtjamxJYVVOejh5aUVSY2Q2cDZLOHJ3NTNTTVJuQzByTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xOTIuMTY4LjQzLjM4OjgwMDAvdGVhY2hlci9hdHRlbmRhbmNlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NjtzOjEzOiJ0ZWFjaGVyX3Rva2VuIjtzOjUwOiIyfGd6ZjBiWFp2UkxqakozcHZQMXUyandMZndGcEl4RjI1VmhMOEZFNHZlYjMxNjVhNiI7fQ==',1751465017),('gj1cx75R00DDQ9Iv2EyU2VeqNos5XsjFq8zmzk29',6,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.1.1 Safari/605.1.15','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiWnVoUnREUkdUeDFWTkhiaG9DOUJiZ3B0Z0l6UDZ1UFhoTmx2eDE1VSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo2MDoiaHR0cDovL2FhMzgtMTQwLTIxMy0xNzMtNzEubmdyb2stZnJlZS5hcHAvdGVhY2hlci9hdHRlbmRhbmNlIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly9hYTM4LTE0MC0yMTMtMTczLTcxLm5ncm9rLWZyZWUuYXBwL3RlYWNoZXIvYXR0ZW5kYW5jZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7czoxMzoidGVhY2hlcl90b2tlbiI7czo1MDoiN3xBMmlLUkhncThyUUxscG5EUVpBdTk4SURpdDBja0h5SjVablVWdmxvZGY2ZjJlZDgiO30=',1751467277),('HWBQKt7VRC6MjYKpjXpKZGdKBiNRid9X9llQk4kM',6,'127.0.0.1','Mozilla/5.0 (Android 15; Mobile; rv:140.0) Gecko/140.0 Firefox/140.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRE1VZ0VseGhQaUZ5UnJtTWxuUnVUalpaQkJPSUlvVWRTSmdmVlFYUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly9hYTM4LTE0MC0yMTMtMTczLTcxLm5ncm9rLWZyZWUuYXBwL3RlYWNoZXIvYXR0ZW5kYW5jZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7czoxMzoidGVhY2hlcl90b2tlbiI7czo1MDoiNXx1bEE4UTVZaHFJajhTWTMzZ1lYbXh3NHVxTGwyQUFLTlA4ZGU5dFJsZmJlMmZiNjkiO30=',1751466411),('ii5xuv1falzbRiKo0RKneg90nf1yed0llm0WsQZv',NULL,'127.0.0.1','curl/8.7.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoibTI2a1dtSnV1aGdhNDVwNXcyekZKRUZUT1F1T0RBQzZsUTZGVUx2QyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHA6Ly9hYTM4LTE0MC0yMTMtMTczLTcxLm5ncm9rLWZyZWUuYXBwL2luY3JlYXNlLXJhZGl1cy8yMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1751467169),('J0n925Z2IAEVtBrrxsSjXTXCQnUSQ7A9iGwpwu9Y',6,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNGhHY2NWMmpqVVhBZzVhTGs5MjVRdGJ6NG16RnlaSDNDQU1QZmlVTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly9hYTM4LTE0MC0yMTMtMTczLTcxLm5ncm9rLWZyZWUuYXBwL3RlYWNoZXIvYXR0ZW5kYW5jZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7czoxMzoidGVhY2hlcl90b2tlbiI7czo1MToiMTB8Zld6YzU3UmVYTW01Y3lzdUNjOEQwd2tiTXdMWFhoVVhtWUNrcHRsRGQ3N2U3ZDc0Ijt9',1751470722),('khj2BuapwO19ON28gi4M3R6dJKXrWpypnCXekucf',6,'127.0.0.1','Mozilla/5.0 (Android 15; Mobile; rv:140.0) Gecko/140.0 Firefox/140.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTUZPdVJ5RXVsWVFKVTZXSmU3YWNCQW5FR0d2ZFpYQ2hTdVlXcEJ5SCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly9hYTM4LTE0MC0yMTMtMTczLTcxLm5ncm9rLWZyZWUuYXBwL3RlYWNoZXIvYXR0ZW5kYW5jZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7czoxMzoidGVhY2hlcl90b2tlbiI7czo1MDoiNHxCUFZrS2t1UHJCSWN0OWZmazJOUnNUa1AxWUdkcTFEUjB5bkdjNVNWZGI5MzI5MzQiO30=',1751466263),('o1EFEUGNfcgodjL3FfXtIDcETVY6e0IkaBgkFQxM',NULL,'192.168.43.38','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.1.1 Safari/605.1.15','YTozOntzOjY6Il90b2tlbiI7czo0MDoiV2Vva0RqeUZvQkRSRWg5a2JXRE1mR0NmVHZRbHpZdFpHZFVRdDJpeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xOTIuMTY4LjQzLjM4OjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1751464923),('RCv0xL2qbOIS9j7yjNIUDq8k72L9wrC0Ctketg8R',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUk1rOVpuV0R6RHZhdk1lejJQeG10WDdqYW85T0FVWXd2c3FlOUxZMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9hYTM4LTE0MC0yMTMtMTczLTcxLm5ncm9rLWZyZWUuYXBwIjt9fQ==',1751469185),('s8VgCeZ5jywl9TM1PFZReAELsctWhUmiNkdppJwZ',NULL,'127.0.0.1','curl/8.7.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoibTZrWXNidWQ3U0dZQ3FiZVdYUnJOd2R2N2hhV1o3NUJJTzF2amJBNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTAzOiJodHRwOi8vYWEzOC0xNDAtMjEzLTE3My03MS5uZ3Jvay1mcmVlLmFwcC9zZXQtc2Nob29sLWxvY2F0aW9uLy02LjU2Mjk5NDU4MjQyOTI0OC8xMTAuODYwNTkyNDI2Mzk4OTgvNTAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1751470318),('UEZ74E4mhkSkVf6kcyu2OkwRvsS5wGBrESxPwWeh',NULL,'127.0.0.1','curl/8.7.1','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaHdSM1FTeFdBZG83M080MUxTTFBOTndwM0diSmhTdkR0VFFyU2FkcCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo2MDoiaHR0cDovL2FhMzgtMTQwLTIxMy0xNzMtNzEubmdyb2stZnJlZS5hcHAvdGVhY2hlci9hdHRlbmRhbmNlIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly9hYTM4LTE0MC0yMTMtMTczLTcxLm5ncm9rLWZyZWUuYXBwL3RlYWNoZXIvYXR0ZW5kYW5jZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1751470650),('VcQ2Hgv8e4fEhEu90GUyDaf7qBUijK3nkcMAs8ht',NULL,'127.0.0.1','curl/8.7.1','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR1lCWG9TUUV1bkZIYUt6QlZMMjBJTnRhdFJBamlVUkYwWkFEamJLUCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1OToiaHR0cDovL2FhMzgtMTQwLTIxMy0xNzMtNzEubmdyb2stZnJlZS5hcHAvdGVhY2hlci9kYXNoYm9hcmQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1OToiaHR0cDovL2FhMzgtMTQwLTIxMy0xNzMtNzEubmdyb2stZnJlZS5hcHAvdGVhY2hlci9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1751469308),('yRLZwh0VOg7KR5XxVD0o0sdbg7DiQTOtpUNB2XUW',NULL,'127.0.0.1','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoib3ZERHNlSTV0Q2FOdW1NUHhybTZXS3B3QkJMVk1IQktMNHdCM29TdSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo2MDoiaHR0cDovL2FhMzgtMTQwLTIxMy0xNzMtNzEubmdyb2stZnJlZS5hcHAvdGVhY2hlci9hdHRlbmRhbmNlIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9hYTM4LTE0MC0yMTMtMTczLTcxLm5ncm9rLWZyZWUuYXBwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1751475494);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_attendances`
--

DROP TABLE IF EXISTS `student_attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `teaching_session_id` bigint unsigned NOT NULL,
  `student_id` bigint unsigned NOT NULL,
  `status` enum('present','sick','absent_with_permission','absent_without_permission') COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_attendances_teaching_session_id_student_id_unique` (`teaching_session_id`,`student_id`),
  KEY `student_attendances_student_id_foreign` (`student_id`),
  CONSTRAINT `student_attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_attendances_teaching_session_id_foreign` FOREIGN KEY (`teaching_session_id`) REFERENCES `teaching_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_attendances`
--

LOCK TABLES `student_attendances` WRITE;
/*!40000 ALTER TABLE `student_attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_room_id` bigint unsigned NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `parent_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_student_id_unique` (`student_id`),
  KEY `students_class_room_id_foreign` (`class_room_id`),
  CONSTRAINT `students_class_room_id_foreign` FOREIGN KEY (`class_room_id`) REFERENCES `class_rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=350 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,'MHBTN0001','Capa Halim M.Kom.','septi.wastuti@student.school.com','0911 5576 117',1,'2008-01-08','male','Ds. S. Parman No. 411, Payakumbuh 30218, Sumsel','Ulya Sudiati','(+62) 514 5861 2132',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(2,'MHBTN0002','Alika Puspasari','hilda.utami@student.school.com','(+62) 439 5228 849',1,'2007-10-30','female','Ki. Babadan No. 583, Tidore Kepulauan 28087, Sulbar','Cakrawala Jailani','023 0148 8461',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(3,'MHBTN0003','Limar Sihotang S.H.','wahyu.nababan@student.school.com','(+62) 20 6408 251',1,'2007-08-31','female','Ki. Sugiyopranoto No. 612, Depok 25484, Sumut','Gabriella Pratiwi','(+62) 553 5883 549',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(4,'MHBTN0004','Lanjar Luwar Simbolon M.M.','bakijan.prasetya@student.school.com','0407 0172 1832',1,'2009-02-22','male','Psr. Kalimalang No. 659, Bukittinggi 70512, Jambi','Kasiran Marpaung S.E.I','(+62) 414 2792 6603',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(5,'MHBTN0005','Bakiono Drajat Widodo M.Farm','yulia.hariyah@student.school.com','0455 9164 025',1,'2008-04-04','male','Kpg. Dr. Junjunan No. 823, Tidore Kepulauan 87288, NTB','Kamila Febi Permata S.Kom','020 7555 385',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(6,'MHBTN0006','Daniswara Radika Hutapea','darmanto.nainggolan@student.school.com','0889 4016 9092',1,'2007-09-09','female','Dk. Raya Ujungberung No. 895, Medan 10314, Papua','Agnes Lailasari','(+62) 21 0994 081',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(7,'MHBTN0007','Cinta Mutia Nuraini S.E.','cinta.zahra.novitasari.s.pd@student.school.com','0960 3338 3668',1,'2007-10-30','female','Kpg. Juanda No. 266, Tanjung Pinang 72534, Jateng','Luis Manullang','(+62) 464 6877 295',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(8,'MHBTN0008','Laila Mandasari','wulan.laksita@student.school.com','0744 2866 4834',1,'2008-01-11','female','Dk. Merdeka No. 57, Pariaman 73492, Babel','Dacin Gunarto','(+62) 970 8028 976',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(9,'MHBTN0009','Jabal Narpati','vivi.kania.anggraini.s.farm@student.school.com','(+62) 654 9485 3294',1,'2009-02-27','female','Dk. Suryo No. 269, Parepare 48181, Sumbar','Oman Hakim','(+62) 730 7743 846',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(10,'MHBTN0010','Teddy Megantara S.Kom','elisa.rahayu@student.school.com','0823 0371 249',1,'2008-08-09','female','Ds. Panjaitan No. 698, Banjarmasin 47853, Sumut','Maimunah Puspita S.Gz','0675 1861 1616',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(11,'MHBTN0011','Mahfud Narpati','gangsar.waskita@student.school.com','0755 4780 5691',1,'2007-12-11','female','Dk. Cikapayang No. 730, Lubuklinggau 57297, Sulsel','Harja Gangsa Nashiruddin S.Kom','(+62) 533 0970 451',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(12,'MHBTN0012','Ridwan Santoso','hamima.ayu.hartati.m.farm@student.school.com','(+62) 325 0601 3302',1,'2007-11-10','female','Ds. Kebangkitan Nasional No. 475, Binjai 23320, Kaltim','Malik Prasasta','0275 4980 1517',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(13,'MHBTN0013','Dina Nurul Winarsih','gabriella.kania.puspita@student.school.com','(+62) 241 0776 001',1,'2009-03-29','female','Ki. Lumban Tobing No. 134, Kediri 69229, Sultra','Ibun Nalar Maulana S.Gz','(+62) 223 6840 8672',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(14,'MHBTN0014','Usman Hutasoit','cawisadi.kuncara.mahendra@student.school.com','(+62) 415 9059 294',1,'2007-07-05','female','Jln. R.E. Martadinata No. 102, Pangkal Pinang 93029, Kalsel','Balangga Salahudin','0856 3364 685',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(15,'MHBTN0015','Endah Zamira Pratiwi','latika.puspa.permata@student.school.com','0666 7264 065',1,'2008-05-22','female','Dk. Mahakam No. 967, Batam 43449, DIY','Hartaka Firmansyah','0599 6246 428',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(16,'MHBTN0016','Jasmin Usamah','yoga.kurniawan@student.school.com','0903 8407 027',1,'2008-11-23','male','Gg. Warga No. 335, Banjarmasin 96486, Aceh','Hani Padmasari','0871 897 695',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(17,'MHBTN0017','Rahmi Purwanti','kusuma.taswir.anggriawan.m.kom.@student.school.com','0436 5348 9034',1,'2010-01-06','female','Jr. Salatiga No. 15, Palangka Raya 41691, Maluku','Tri Santoso','(+62) 763 6965 203',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(18,'MHBTN0018','Laila Yuliarti','puti.usyi.anggraini@student.school.com','(+62) 546 3368 558',1,'2009-09-06','female','Ki. Imam No. 254, Bengkulu 38834, Sumbar','Dalimin Sitompul','(+62) 782 7717 9343',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(19,'MHBTN0019','Bella Halima Pertiwi S.Psi','jasmin.najwa.halimah@student.school.com','(+62) 281 4703 245',1,'2009-04-14','female','Dk. Hasanuddin No. 111, Tanjungbalai 97583, Sumsel','Aurora Novitasari','(+62) 809 0422 8707',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(20,'MHBTN0020','Vanya Cornelia Hartati S.Pd','bagus.lasmono.irawan.s.ip@student.school.com','(+62) 29 6263 8955',1,'2008-09-12','male','Gg. Yap Tjwan Bing No. 761, Sungai Penuh 37042, Aceh','Gading Saragih S.E.','0345 6114 356',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(21,'MHBTN0021','Zulaikha Wulandari','karna.timbul.winarno.s.ip@student.school.com','(+62) 356 8499 7210',1,'2008-02-18','female','Psr. Imam No. 812, Balikpapan 39390, Kaltara','Violet Anggraini','(+62) 514 2521 4229',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(22,'MHBTN0022','Cakrawangsa Ardianto','ismail.hakim@student.school.com','(+62) 240 5413 670',1,'2007-08-27','female','Jln. Wora Wari No. 326, Magelang 70174, Sumbar','Ade Purwanti','(+62) 648 5684 8243',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(23,'MHBTN0023','Pia Yolanda','tasdik.samosir@student.school.com','0248 6331 1146',1,'2008-08-07','female','Psr. Ciwastra No. 221, Lubuklinggau 80596, Riau','Jaka Siregar S.Pt','0672 1592 286',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(24,'MHBTN0024','Bella Salimah Winarsih S.H.','xanana.simbolon@student.school.com','(+62) 21 0308 4518',1,'2009-02-04','female','Psr. Reksoninten No. 823, Sabang 99822, Jatim','Cinthia Syahrini Wulandari S.Gz','(+62) 923 7116 8274',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(25,'MHBTN0025','Clara Wahyuni','ajeng.yunita.fujiati.s.farm@student.school.com','(+62) 955 2096 9986',1,'2010-06-01','male','Jln. Rajawali Timur No. 627, Bima 88001, Kalbar','Vera Dina Kusmawati S.Farm','(+62) 948 1887 8577',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(26,'MHBTN0026','Maimunah Farida','puspa.yolanda.s.i.kom@student.school.com','0277 5703 2133',1,'2008-12-18','male','Kpg. Banda No. 721, Banjar 46530, Jabar','Darijan Sitorus','0529 5936 1418',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(27,'MHBTN0027','Saadat Kurniawan','wulan.faizah.utami@student.school.com','0208 8883 751',1,'2009-12-16','male','Gg. Rajawali Barat No. 984, Palembang 36160, Kalteng','Karman Latif Anggriawan','0717 1348 9274',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(28,'MHBTN0028','Budi Adinata Pradipta S.Pt','wira.rajasa@student.school.com','0284 6514 909',1,'2009-08-01','male','Kpg. Baabur Royan No. 681, Ambon 89703, NTB','Zaenab Hasanah','0937 4479 756',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(29,'MHBTN0029','Harto Prasetya S.Sos','asmuni.cakrawala.prasasta.s.e.i@student.school.com','0533 0294 6622',2,'2007-07-26','female','Psr. Yap Tjwan Bing No. 963, Administrasi Jakarta Barat 26861, Kalbar','Vicky Karen Safitri M.M.','0834 5013 2920',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(30,'MHBTN0030','Cornelia Puji Yuniar','luluh.dongoran@student.school.com','0234 5745 7322',2,'2009-05-20','female','Psr. Bambu No. 78, Singkawang 55273, Bengkulu','Wira Damanik','(+62) 219 8964 668',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(31,'MHBTN0031','Silvia Wahyuni','jamal.hutapea@student.school.com','(+62) 28 1697 961',2,'2009-02-12','female','Jln. Rajawali Barat No. 710, Gorontalo 99759, Jambi','Emin Tamba','(+62) 548 2775 525',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(32,'MHBTN0032','Oni Rahimah','kunthara.viman.kuswoyo@student.school.com','025 7905 630',2,'2009-07-10','male','Ds. Acordion No. 69, Pematangsiantar 12530, Papua','Uda Waskita','0240 8815 2453',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(33,'MHBTN0033','Hesti Nasyiah','carla.mila.purnawati@student.school.com','(+62) 740 2868 5562',2,'2007-09-23','male','Kpg. Babakan No. 947, Manado 41632, Sultra','Vino Ramadan S.IP','0581 6623 1798',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(34,'MHBTN0034','Edi Samsul Putra','rahmi.carla.hasanah.s.e.i@student.school.com','(+62) 678 8082 1272',2,'2010-01-15','female','Jln. Babah No. 841, Pekanbaru 42224, Kalsel','Jaiman Kadir Mandala S.Psi','(+62) 618 3742 498',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(35,'MHBTN0035','Oni Aryani','leo.hasan.sihotang@student.school.com','0642 1369 155',2,'2009-11-17','female','Psr. Yos No. 744, Tangerang Selatan 83954, Kalsel','Galak Uwais M.TI.','(+62) 427 1073 2998',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(36,'MHBTN0036','Gatot Narpati','ibun.estiono.siregar.s.h.@student.school.com','0883 7638 5209',2,'2009-04-21','female','Gg. Sutarjo No. 600, Bogor 54164, NTB','Tantri Padmasari','0901 8987 4736',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(37,'MHBTN0037','Anggabaya Januar','hesti.hasanah@student.school.com','(+62) 592 2006 9482',2,'2009-10-15','female','Jln. Sutoyo No. 425, Bau-Bau 78300, Kaltara','Paramita Rahayu M.M.','0828 9995 8931',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(38,'MHBTN0038','Eko Dacin Habibi','irsad.dariati.ardianto@student.school.com','0526 5841 751',2,'2008-01-10','female','Dk. Monginsidi No. 252, Kotamobagu 23669, Kalteng','Amelia Safitri','(+62) 470 4054 6508',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(39,'MHBTN0039','Kunthara Ganjaran Sinaga','zulfa.kartika.sudiati@student.school.com','0833 9797 274',2,'2009-11-01','female','Kpg. Laksamana No. 223, Pekanbaru 45410, Aceh','Ani Nuraini','0662 8544 307',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(40,'MHBTN0040','Zalindra Kusmawati','vanesa.rahimah.s.psi@student.school.com','(+62) 938 9464 6987',2,'2008-02-18','male','Dk. Ters. Kiaracondong No. 756, Tanjungbalai 59174, Pabar','Atmaja Marbun M.TI.','(+62) 322 2533 6964',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(41,'MHBTN0041','Aris Permadi S.Ked','gambira.mangunsong@student.school.com','(+62) 614 2489 7274',2,'2010-03-16','female','Gg. Peta No. 87, Batam 86477, Bali','Simon Prabowo S.Sos','0679 4605 148',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(42,'MHBTN0042','Prima Suwarno','ida.handayani@student.school.com','0819 5576 016',2,'2007-07-09','female','Dk. Abdul. Muis No. 680, Jambi 27639, Gorontalo','Gabriella Ifa Mulyani S.I.Kom','0856 7311 137',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(43,'MHBTN0043','Titin Puspasari','laswi.dagel.ardianto@student.school.com','0282 6027 214',2,'2009-01-06','male','Ki. Suharso No. 232, Bandar Lampung 33609, Kaltara','Silvia Aryani','0253 6321 449',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(44,'MHBTN0044','Panji Wacana','radika.mansur.s.kom@student.school.com','(+62) 372 5186 112',2,'2009-08-24','male','Dk. Taman No. 607, Banjarmasin 86448, Gorontalo','Cornelia Wahyuni','0852 612 630',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(45,'MHBTN0045','Danu Saefullah','dartono.cemeti.napitupulu@student.school.com','(+62) 555 9746 784',2,'2009-08-21','male','Kpg. Rajawali Barat No. 144, Jayapura 16871, Kepri','Ratna Palastri','0993 2036 732',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(46,'MHBTN0046','Lukman Mustofa Setiawan S.Psi','kezia.purnawati@student.school.com','(+62) 515 5508 4086',2,'2007-11-01','female','Kpg. Zamrud No. 975, Madiun 73809, Sumut','Yunita Wastuti','0817 9971 3946',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(47,'MHBTN0047','Elma Palastri','cinthia.mayasari.s.e.i@student.school.com','0973 8102 882',2,'2009-10-23','male','Dk. Yap Tjwan Bing No. 417, Malang 85913, Sulut','Samiah Kamaria Agustina','(+62) 808 6146 086',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(48,'MHBTN0048','Gamanto Tamba','unjani.pratiwi@student.school.com','(+62) 786 2023 4864',2,'2008-04-22','male','Kpg. Kalimantan No. 283, Sukabumi 82910, Bali','Rina Hassanah M.M.','0839 4541 921',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(49,'MHBTN0049','Luwar Ardianto M.TI.','mariadi.mangunsong@student.school.com','(+62) 379 4656 216',2,'2007-10-03','female','Jln. Wahidin Sudirohusodo No. 777, Denpasar 13894, Sumut','Mahfud Simbolon S.E.I','0800 8932 523',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(50,'MHBTN0050','Darijan Siregar S.E.','asirwada.prasasta@student.school.com','0598 7431 382',2,'2008-11-23','female','Jln. Umalas No. 823, Mataram 22803, Kalteng','Artawan Gangsar Nugroho','(+62) 28 0517 7984',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(51,'MHBTN0051','Ina Oktaviani','cakrajiya.megantara@student.school.com','0372 2446 1374',2,'2007-07-15','male','Ds. Babah No. 827, Sorong 64738, Malut','Syahrini Nadia Wulandari','0842 866 246',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(52,'MHBTN0052','Utama Wasita','nalar.kenari.prayoga@student.school.com','028 0512 732',2,'2008-09-27','male','Psr. Abdul. Muis No. 315, Balikpapan 60513, NTT','Jais Tamba','0608 1312 767',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(53,'MHBTN0053','Yuliana Hastuti','mulyono.kurniawan@student.school.com','(+62) 553 6126 087',2,'2010-03-01','male','Jr. Moch. Ramdan No. 149, Solok 18491, Jabar','Melinda Pertiwi','0533 7611 733',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(54,'MHBTN0054','Opan Gaduh Dabukke S.E.','gandewa.setiawan@student.school.com','(+62) 649 3197 559',3,'2009-10-21','male','Jr. Casablanca No. 629, Bengkulu 17372, Bali','Ciaobella Sadina Prastuti','(+62) 948 4725 1571',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(55,'MHBTN0055','Artawan Siregar','bakda.daliman.pradana@student.school.com','0504 0503 2127',3,'2009-11-11','female','Ds. Adisumarmo No. 891, Kotamobagu 62340, Jateng','Emil Siregar','0391 0655 6743',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(56,'MHBTN0056','Elvina Cornelia Wulandari S.T.','yance.hasanah@student.school.com','(+62) 950 5478 718',3,'2010-03-02','male','Psr. Sukajadi No. 477, Bukittinggi 97058, DIY','Dewi Farida','0407 6773 285',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(57,'MHBTN0057','Raina Mardhiyah S.IP','dinda.purnawati.m.kom.@student.school.com','(+62) 399 0690 976',3,'2007-12-06','female','Gg. Salak No. 408, Tasikmalaya 88911, Jambi','Nasrullah Dabukke','0927 3202 6281',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(58,'MHBTN0058','Tami Prastuti','safina.safitri@student.school.com','0587 1749 725',3,'2008-12-03','male','Jln. Camar No. 639, Payakumbuh 67195, Jambi','Jamil Saptono','0532 9801 4446',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(59,'MHBTN0059','Taufik Mahesa Prasetyo M.TI.','yuni.wulandari@student.school.com','0740 9878 201',3,'2009-09-22','male','Dk. Sutami No. 44, Pontianak 11637, Maluku','Among Setiawan','0283 6881 5866',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(60,'MHBTN0060','Raihan Prasetya','rika.yulia.yuniar@student.school.com','0902 5008 318',3,'2010-02-01','male','Jr. Wahidin Sudirohusodo No. 727, Sukabumi 80431, Sulut','Najwa Zulaikha Melani S.IP','(+62) 308 5068 288',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(61,'MHBTN0061','Murti Saptono','jais.budiyanto@student.school.com','(+62) 865 0233 490',3,'2009-02-11','male','Gg. BKR No. 6, Jambi 88126, Sumsel','Virman Ramadan','(+62) 816 602 527',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(62,'MHBTN0062','Kenzie Setiawan','zelaya.fujiati@student.school.com','0310 6178 059',3,'2007-08-20','female','Kpg. Monginsidi No. 957, Tidore Kepulauan 76963, Sultra','Bancar Hutapea','0828 400 814',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(63,'MHBTN0063','Dina Oktaviani','asmadi.uwais@student.school.com','(+62) 452 5572 820',3,'2010-05-08','female','Jr. Bagis Utama No. 758, Sukabumi 45381, Kepri','Karen Agustina','(+62) 774 6971 6581',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(64,'MHBTN0064','Kardi Sihotang','timbul.prasetya@student.school.com','0524 8487 7429',3,'2009-02-25','female','Gg. Muwardi No. 553, Kupang 44610, Sumsel','Ida Palastri','(+62) 816 5942 3105',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(65,'MHBTN0065','Eli Uyainah','nabila.purwanti@student.school.com','0609 8005 8219',3,'2009-03-05','female','Dk. Dahlia No. 95, Probolinggo 86817, Sumut','Betania Irma Purwanti','0740 0840 1190',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(66,'MHBTN0066','Diah Zamira Safitri S.Psi','salsabila.cornelia.widiastuti.s.e.@student.school.com','(+62) 573 5851 334',3,'2010-03-22','male','Kpg. Hasanuddin No. 490, Mojokerto 49120, Jabar','Martani Kamidin Siregar M.TI.','0458 3213 7852',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(67,'MHBTN0067','Jamalia Nadine Nuraini S.Sos','kezia.nuraini@student.school.com','(+62) 21 1459 022',3,'2008-02-10','female','Gg. B.Agam Dlm No. 10, Malang 11670, Sulut','Shakila Utami S.Farm','(+62) 22 3369 1189',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(68,'MHBTN0068','Diah Yuniar','yoga.utama@student.school.com','(+62) 573 2264 0732',3,'2008-07-20','female','Gg. Bara No. 173, Banjar 75987, Sulut','Pardi Dongoran S.Gz','0814 9540 2405',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(69,'MHBTN0069','Ratih Intan Purwanti M.TI.','ega.habibi@student.school.com','(+62) 393 4593 139',3,'2010-02-21','female','Gg. Labu No. 578, Sorong 58950, Bali','Catur Okto Sirait','0335 6981 353',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(70,'MHBTN0070','Kuncara Mitra Hutapea S.IP','nasim.maulana.s.e.i@student.school.com','(+62) 918 9180 316',3,'2009-09-01','male','Jln. Tambun No. 317, Jambi 38283, Aceh','Vanesa Hastuti','(+62) 495 7357 085',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(71,'MHBTN0071','Rangga Saefullah','jaga.simon.suryono.m.kom.@student.school.com','0559 2306 2306',3,'2009-02-13','female','Kpg. Batako No. 506, Ambon 45619, Banten','Jamalia Rahimah','0718 2610 496',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(72,'MHBTN0072','Hendri Firgantoro','ayu.yuniar@student.school.com','(+62) 25 0578 2144',3,'2008-09-04','male','Dk. Gremet No. 79, Padangsidempuan 65834, Kalteng','Cinthia Andriani S.Farm','0672 5362 1663',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(73,'MHBTN0073','Okta Lembah Ramadan','jayeng.sitompul@student.school.com','(+62) 775 3696 5923',3,'2010-03-27','female','Dk. Pelajar Pejuang 45 No. 671, Lubuklinggau 90004, Jabar','Mursita Emas Mahendra','0894 880 814',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(74,'MHBTN0074','Kacung Jailani','cindy.nasyidah@student.school.com','0626 5314 088',3,'2009-10-16','female','Gg. Yohanes No. 79, Kendari 29793, Kalbar','Ilsa Lestari','0358 7196 024',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(75,'MHBTN0075','Violet Keisha Hasanah','irma.andriani@student.school.com','0722 8681 152',3,'2008-02-04','female','Ki. Jayawijaya No. 796, Jambi 96324, DIY','Mala Hassanah S.Kom','0372 2671 6785',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(76,'MHBTN0076','Kiandra Halimah','shania.karimah.puspasari@student.school.com','0988 3858 008',3,'2009-12-19','male','Ds. Dipenogoro No. 430, Sawahlunto 91719, Jatim','Gangsa Karsa Kusumo M.Farm','(+62) 571 2971 7572',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(77,'MHBTN0077','Caket Ganda Nababan M.Ak','marsudi.harimurti.habibi@student.school.com','0246 1912 3213',3,'2010-03-09','female','Dk. Bayan No. 779, Sawahlunto 17300, Pabar','Alika Dian Suartini','(+62) 24 5283 560',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(78,'MHBTN0078','Zamira Susanti','elma.suryatmi.m.ak@student.school.com','0984 5596 984',3,'2008-12-02','male','Jln. Elang No. 699, Sawahlunto 44023, Riau','Belinda Yuniar','0427 0947 959',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(79,'MHBTN0079','Tedi Natsir','clara.nurdiyanti@student.school.com','0788 8784 233',4,'2007-12-21','female','Dk. Bakin No. 619, Langsa 74312, Pabar','Raharja Adhiarja Haryanto','0824 2169 9770',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(80,'MHBTN0080','Vanya Unjani Suryatmi','cakrawala.sirait.m.farm@student.school.com','0208 0556 7493',4,'2007-11-29','male','Jr. Achmad Yani No. 924, Yogyakarta 47692, Kalbar','Yance Rahmawati M.Kom.','(+62) 548 7718 2049',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(81,'MHBTN0081','Najam Hidayat M.Kom.','garan.hidayat@student.school.com','0450 8653 444',4,'2009-01-01','female','Ki. Bayan No. 988, Bandung 91992, Kepri','Mustika Hakim','(+62) 25 8238 8882',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(82,'MHBTN0082','Hamzah Ramadan M.Farm','amelia.permata@student.school.com','(+62) 21 4820 355',4,'2008-10-30','female','Ds. Basmol Raya No. 674, Tangerang 90493, Jatim','Tami Maryati','0751 5204 188',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(83,'MHBTN0083','Hasta Nashiruddin M.M.','natalia.nasyiah@student.school.com','0270 0512 601',4,'2009-06-06','female','Dk. Antapani Lama No. 488, Administrasi Jakarta Pusat 52432, Kalteng','Hani Yuliarti','0765 2860 1215',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(84,'MHBTN0084','Kajen Karsa Wijaya','zelaya.samiah.zulaika@student.school.com','(+62) 20 8777 388',4,'2008-01-04','female','Jln. Pasirkoja No. 545, Lhokseumawe 33228, Kalteng','Indra Cahyadi Gunarto','027 4879 180',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(85,'MHBTN0085','Ellis Ulya Yuliarti S.Gz','ulya.laila.hasanah@student.school.com','(+62) 894 479 019',4,'2007-07-26','male','Psr. Jend. Sudirman No. 462, Sibolga 93205, Gorontalo','Kasiyah Padmasari','0759 6494 438',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(86,'MHBTN0086','Respati Napitupulu S.Kom','kezia.hafshah.wastuti@student.school.com','0930 8457 417',4,'2009-07-29','female','Psr. Surapati No. 407, Prabumulih 59156, Sumut','Aris Hutasoit','0525 7954 312',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(87,'MHBTN0087','Yuliana Farida','bakiadi.hasan.prasetya@student.school.com','(+62) 695 1827 779',4,'2008-02-10','male','Dk. Halim No. 199, Sukabumi 16919, Sulut','Kambali Adriansyah','0347 4178 652',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(88,'MHBTN0088','Paulin Nurdiyanti','jessica.rahmi.andriani.s.pt@student.school.com','0368 0033 5376',4,'2009-01-11','male','Gg. Eka No. 737, Madiun 76667, Kalteng','Gabriella Wulandari S.H.','0406 2907 694',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(89,'MHBTN0089','Prayitna Marbun','pranata.sakti.pradana@student.school.com','(+62) 296 9252 2233',4,'2010-01-21','female','Dk. Bappenas No. 904, Lhokseumawe 33076, NTB','Ilsa Suartini','0376 8640 830',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(90,'MHBTN0090','Julia Mandasari S.Sos','bala.maryadi@student.school.com','(+62) 662 1472 4469',4,'2010-04-28','female','Jr. Lumban Tobing No. 877, Pekanbaru 43853, Babel','Galuh Danuja Setiawan','(+62) 588 7727 585',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(91,'MHBTN0091','Vivi Kusmawati','bella.wijayanti@student.school.com','(+62) 853 9453 638',4,'2010-06-23','male','Gg. R.E. Martadinata No. 56, Balikpapan 48621, Sultra','Kawaca Naradi Wasita','(+62) 270 2164 266',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(92,'MHBTN0092','Jumari Habibi','ganjaran.nababan.m.kom.@student.school.com','0915 0515 5497',4,'2007-09-23','male','Jln. Flores No. 581, Cirebon 46129, Kaltara','Widya Kusmawati S.T.','(+62) 699 4450 303',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(93,'MHBTN0093','Hamzah Habibi','fitriani.nuraini.m.ak@student.school.com','0738 8535 6663',4,'2010-03-10','female','Jln. Gajah Mada No. 318, Madiun 93110, Jatim','Hamima Haryanti S.I.Kom','0248 0195 9359',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(94,'MHBTN0094','Irsad Mandala','ian.maryadi@student.school.com','0874 8059 8455',4,'2009-02-10','female','Jr. Tentara Pelajar No. 314, Bengkulu 66789, Sumbar','Yani Hassanah','0624 8272 861',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(95,'MHBTN0095','Wardaya Firmansyah','harjo.latupono@student.school.com','0819 8523 412',4,'2009-11-20','female','Dk. K.H. Maskur No. 253, Batu 90752, Bengkulu','Novi Hariyah','022 6473 008',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(96,'MHBTN0096','Dian Mayasari','kayla.nasyiah.s.farm@student.school.com','023 6234 006',4,'2008-11-10','female','Kpg. Lada No. 290, Banjarmasin 78180, Sulteng','Kani Melani','0615 0546 4614',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(97,'MHBTN0097','Liman Haryanto','ifa.anita.aryani@student.school.com','0350 0489 3386',4,'2008-09-16','female','Kpg. Muwardi No. 114, Langsa 53126, Sulbar','Nadine Tira Mulyani','(+62) 968 7198 7911',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(98,'MHBTN0098','Putri Zulaika','alambana.saputra@student.school.com','(+62) 840 1139 796',4,'2007-07-29','male','Dk. Sentot Alibasa No. 617, Balikpapan 29487, Kalsel','Jarwi Narpati M.Pd','(+62) 791 5729 7495',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(99,'MHBTN0099','Tina Nuraini S.Farm','ajiman.situmorang@student.school.com','(+62) 666 5142 010',4,'2009-02-02','female','Jr. Pacuan Kuda No. 942, Tasikmalaya 42661, Kalsel','Dasa Atmaja Saptono M.Ak','(+62) 918 7764 2663',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(100,'MHBTN0100','Tira Kamaria Hassanah','victoria.lestari@student.school.com','(+62) 619 3233 5126',4,'2007-08-23','male','Dk. Yos No. 828, Bandar Lampung 15325, NTT','Ella Oktaviani','0738 8637 436',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(101,'MHBTN0101','Icha Kusmawati','hadi.kurniawan@student.school.com','020 2660 7772',4,'2008-12-25','male','Ds. Sumpah Pemuda No. 369, Banjarmasin 67766, Sumut','Martani Pradana','0398 4488 340',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(102,'MHBTN0102','Genta Andriani M.M.','ellis.zalindra.kuswandari.s.t.@student.school.com','(+62) 24 3234 718',4,'2007-07-25','male','Jln. Industri No. 638, Metro 36111, Jatim','Rachel Halimah M.Kom.','0858 9772 915',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(103,'MHBTN0103','Taufik Halim','nasab.damanik@student.school.com','0545 9995 320',4,'2009-08-28','female','Dk. Kyai Mojo No. 897, Bekasi 90407, Lampung','Galur Prabowo','(+62) 856 543 656',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(104,'MHBTN0104','Daryani Ramadan','lantar.siregar@student.school.com','(+62) 504 4665 690',4,'2009-05-18','male','Gg. Bank Dagang Negara No. 902, Sorong 72159, Gorontalo','Candrakanta Megantara','(+62) 880 6920 4108',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(105,'MHBTN0105','Balamantri Asmadi Firgantoro S.Ked','laras.suryatmi.s.e.i@student.school.com','0781 7900 3591',4,'2007-07-10','male','Ki. Dipenogoro No. 8, Batu 39597, Aceh','Intan Permata','0568 1810 033',1,'2025-07-01 21:16:37','2025-07-01 21:16:37'),(106,'MHBTN0106','Kamila Ratih Laksmiwati S.Ked','indra.pratama@student.school.com','0239 7771 241',4,'2009-05-05','female','Psr. Acordion No. 88, Bandung 17025, Bali','Luhung Firgantoro','0421 2538 031',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(107,'MHBTN0107','Ami Pratiwi','yessi.nuraini@student.school.com','029 4441 7862',4,'2008-12-23','female','Gg. Suryo Pranoto No. 5, Administrasi Jakarta Barat 63543, Kalsel','Wardaya Prasasta','0406 3566 135',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(108,'MHBTN0108','Jais Samosir','luis.dongoran@student.school.com','0629 2514 418',5,'2010-05-18','male','Kpg. Umalas No. 382, Pekanbaru 46215, Lampung','Ulva Ida Palastri M.Ak','0455 9104 3367',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(109,'MHBTN0109','Najwa Haryanti','rahmat.permadi@student.school.com','0604 0761 0567',5,'2009-06-16','female','Jln. Wahidin No. 684, Serang 21802, Sumut','Puspa Yuliana Nasyidah S.E.I','(+62) 388 3832 2592',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(110,'MHBTN0110','Amelia Lalita Yolanda M.Pd','pranata.ganep.najmudin@student.school.com','(+62) 415 9638 870',5,'2008-06-18','male','Ki. Untung Suropati No. 771, Banjar 25373, Sulsel','Janet Malika Yulianti','(+62) 332 0155 8191',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(111,'MHBTN0111','Balijan Wasita S.H.','banawa.gandewa.siregar@student.school.com','(+62) 611 4060 541',5,'2010-01-15','female','Jln. Abdul Muis No. 350, Batu 71122, Sumsel','Yuni Novitasari','(+62) 273 8348 7728',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(112,'MHBTN0112','Radit Jailani','emong.narpati@student.school.com','(+62) 948 6242 4744',5,'2010-05-09','female','Ds. Agus Salim No. 346, Banjarbaru 79520, Riau','Viktor Sihotang','(+62) 345 7259 4672',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(113,'MHBTN0113','Zelaya Citra Rahimah','karsa.tarihoran.s.pt@student.school.com','0657 6923 789',5,'2008-11-09','female','Jln. Jaksa No. 52, Surakarta 36426, Sulut','Umi Fitriani Winarsih S.T.','024 6004 5599',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(114,'MHBTN0114','Kusuma Saragih','wakiman.yahya.pradana.s.ip@student.school.com','(+62) 338 5740 953',5,'2009-05-22','female','Ds. Radio No. 872, Lubuklinggau 78661, Sulteng','Mustika Dodo Dabukke S.Kom','0597 1354 0891',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(115,'MHBTN0115','Victoria Amalia Mulyani S.E.I','tasdik.saefullah.s.ked@student.school.com','(+62) 849 986 407',5,'2008-02-03','female','Dk. Dago No. 724, Administrasi Jakarta Timur 30194, Pabar','Kenari Lazuardi','0789 1291 094',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(116,'MHBTN0116','Maya Winarsih S.Ked','nurul.oktaviani@student.school.com','0351 6244 201',5,'2008-12-21','male','Ki. Sutarjo No. 25, Surakarta 45515, Jabar','Lukita Wasita','0861 8570 0358',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(117,'MHBTN0117','Heru Mahendra','mustika.simbolon@student.school.com','0451 7119 9688',5,'2008-10-01','male','Jr. Bayan No. 146, Surabaya 82049, Gorontalo','Prabawa Halim','0701 2448 6433',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(118,'MHBTN0118','Calista Yuniar','praba.rajasa@student.school.com','(+62) 667 6654 9602',5,'2009-10-27','female','Jln. Nanas No. 100, Magelang 79145, Sumsel','Budi Prakasa','0893 1809 200',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(119,'MHBTN0119','Makuta Pradipta S.Sos','tugiman.najmudin@student.school.com','0858 9538 050',5,'2010-06-28','male','Ki. Daan No. 632, Tomohon 66582, Sumut','Leo Habibi S.Pt','0264 6821 5281',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(120,'MHBTN0120','Usman Pradana','cakrawangsa.gilang.mustofa@student.school.com','0743 1103 0410',5,'2010-06-24','male','Dk. Imam Bonjol No. 931, Manado 33873, Sumbar','Uchita Riyanti','(+62) 212 4119 1664',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(121,'MHBTN0121','Embuh Iswahyudi','salsabila.hasanah@student.school.com','0946 2465 2257',5,'2008-06-17','male','Kpg. Gedebage Selatan No. 419, Jambi 87877, Bali','Elma Usamah','0974 4264 070',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(122,'MHBTN0122','Winda Betania Hastuti','nova.samiah.zulaika.m.pd@student.school.com','(+62) 549 7817 149',5,'2007-10-05','female','Ds. Sentot Alibasa No. 902, Serang 44188, Gorontalo','Prasetyo Gaiman Mustofa S.Sos','(+62) 578 8309 195',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(123,'MHBTN0123','Margana Hutapea','legawa.haryanto@student.school.com','0860 6784 387',5,'2008-06-27','female','Psr. Babadak No. 430, Sorong 38488, NTT','Nurul Ani Mandasari','0930 6312 350',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(124,'MHBTN0124','Bakiadi Gangsa Gunarto S.Sos','wakiman.sakti.rajata.s.pd@student.school.com','024 0018 764',5,'2009-09-29','male','Kpg. Pahlawan No. 296, Tegal 93367, Bengkulu','Sabri Januar S.Psi','(+62) 330 4862 326',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(125,'MHBTN0125','Febi Puspasari','rachel.nadine.melani@student.school.com','(+62) 268 9762 3137',5,'2007-10-04','male','Kpg. Nanas No. 407, Semarang 86741, Aceh','Dian Wastuti','0700 4435 6400',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(126,'MHBTN0126','Dian Palastri','diana.sudiati@student.school.com','(+62) 890 5850 8771',5,'2009-01-11','female','Kpg. Dipatiukur No. 957, Jayapura 60777, Sultra','Putri Hassanah','0365 5129 4976',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(127,'MHBTN0127','Cawisono Okta Hidayat','hari.jaka.thamrin@student.school.com','(+62) 817 207 406',5,'2008-01-27','female','Jr. Untung Suropati No. 86, Subulussalam 44204, Sulteng','Sakura Yulianti','(+62) 891 2640 7229',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(128,'MHBTN0128','Tami Wahyuni','carla.laksmiwati@student.school.com','0824 0935 8196',5,'2008-04-09','female','Jr. Lembong No. 567, Serang 12892, Sumsel','Irma Fujiati S.Gz','(+62) 25 4643 777',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(129,'MHBTN0129','Unjani Yolanda S.H.','anggabaya.wahyudin@student.school.com','(+62) 359 0627 5377',5,'2010-04-13','female','Ki. Ki Hajar Dewantara No. 820, Tegal 60322, Kepri','Irwan Firmansyah','0548 2237 6286',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(130,'MHBTN0130','Dalimin Sitompul','irma.novitasari.m.farm@student.school.com','(+62) 874 430 177',5,'2008-04-30','female','Gg. Sukajadi No. 614, Administrasi Jakarta Timur 75928, Sultra','Unggul Rajasa','0266 7468 3870',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(131,'MHBTN0131','Jaya Marbun M.Pd','puti.novitasari@student.school.com','0682 6733 578',5,'2008-01-11','male','Jln. Cemara No. 786, Pagar Alam 62089, Jambi','Fathonah Yuniar','(+62) 447 0041 843',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(132,'MHBTN0132','Dinda Zulaika','samiah.restu.nuraini.m.ak@student.school.com','(+62) 461 0125 358',5,'2010-03-11','female','Kpg. Ciwastra No. 850, Bengkulu 99158, Jabar','Uchita Salimah Safitri','0862 7735 8938',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(133,'MHBTN0133','Nardi Ramadan M.Ak','catur.rajata@student.school.com','(+62) 369 6676 2397',5,'2008-04-08','male','Ki. Nakula No. 95, Solok 16136, Banten','Amelia Farida','(+62) 856 7042 799',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(134,'MHBTN0134','Raden Iswahyudi S.I.Kom','dasa.galiono.zulkarnain.s.e.i@student.school.com','0450 2446 5892',6,'2007-07-28','female','Gg. Wahid No. 731, Prabumulih 80049, Papua','Pangeran Saptono S.Sos','0623 9792 0988',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(135,'MHBTN0135','Ellis Hassanah','luwar.mursinin.natsir@student.school.com','0472 5547 6727',6,'2008-06-30','male','Ds. Rajawali No. 513, Palu 43097, Bengkulu','Anggabaya Saptono','0806 2947 5848',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(136,'MHBTN0136','Qori Puspasari','purwa.kemba.prabowo@student.school.com','025 2766 099',6,'2007-11-14','male','Gg. Diponegoro No. 928, Banjarmasin 39290, Maluku','Edison Warta Iswahyudi S.Pd','0535 4981 9901',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(137,'MHBTN0137','Natalia Humaira Aryani S.Pd','najwa.yulianti@student.school.com','0641 7974 8001',6,'2007-10-31','female','Kpg. Kebonjati No. 206, Manado 95865, NTT','Icha Farida','0309 1424 020',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(138,'MHBTN0138','Nadia Winda Andriani M.Kom.','oni.gasti.purnawati@student.school.com','0784 1050 5775',6,'2009-02-07','female','Psr. Orang No. 546, Palu 58861, NTT','Karen Halimah','(+62) 983 5640 5448',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(139,'MHBTN0139','Cecep Simbolon','estiono.simbolon@student.school.com','(+62) 714 5305 7652',6,'2009-04-27','male','Psr. Mahakam No. 807, Tomohon 36444, Kalteng','Jefri Cemplunk Putra','0815 608 626',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(140,'MHBTN0140','Cindy Fujiati S.E.I','asirwanda.widodo@student.school.com','0670 5770 2203',6,'2008-05-08','male','Psr. Qrisdoren No. 426, Cimahi 66047, Kalteng','Ghaliyati Yuliarti S.Pd','(+62) 958 5017 450',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(141,'MHBTN0141','Padmi Salimah Suryatmi','lembah.saefullah.s.kom@student.school.com','0734 9271 202',6,'2008-09-14','female','Ds. Casablanca No. 513, Pagar Alam 38040, NTB','Gilda Laksmiwati S.Pt','(+62) 945 4683 838',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(142,'MHBTN0142','Nabila Mardhiyah','tiara.agnes.widiastuti@student.school.com','(+62) 634 7188 4931',6,'2009-04-09','female','Ki. Abdul Muis No. 436, Cimahi 28061, Jateng','Ibun Saka Wasita','(+62) 260 4107 8030',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(143,'MHBTN0143','Aisyah Usamah','ida.titin.purwanti@student.school.com','0899 908 200',6,'2009-03-14','male','Jln. Yosodipuro No. 541, Administrasi Jakarta Utara 94727, NTB','Tari Eka Laksmiwati S.Kom','0744 5322 6453',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(144,'MHBTN0144','Umaya Karman Rajasa','kezia.haryanti@student.school.com','0922 9413 7624',6,'2007-08-05','male','Ds. Abdul No. 243, Mojokerto 25550, Maluku','Mahmud Wasita M.Ak','0842 212 263',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(145,'MHBTN0145','Najwa Lailasari','padma.alika.astuti@student.school.com','023 7544 335',6,'2009-02-06','female','Jr. Baja No. 368, Palu 90799, Kaltara','Sabrina Astuti','0706 8974 158',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(146,'MHBTN0146','Tari Palastri','ivan.jefri.prasetya@student.school.com','(+62) 850 1065 177',6,'2008-06-27','male','Ds. Lembong No. 80, Kupang 21926, Sumsel','Kamaria Lailasari','0255 6639 7313',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(147,'MHBTN0147','Galuh Damanik','calista.eva.hastuti.s.h.@student.school.com','(+62) 447 4525 536',6,'2008-10-30','male','Jln. Yap Tjwan Bing No. 885, Palu 32817, Sulbar','Agnes Usada','0428 6057 3179',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(148,'MHBTN0148','Alambana Sabri Winarno','luwes.arsipatra.megantara.s.pt@student.school.com','0299 7359 192',6,'2007-07-10','male','Ds. Labu No. 699, Prabumulih 94659, DKI','Clara Purnawati M.Ak','020 4661 4320',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(149,'MHBTN0149','Maida Mandasari','tasdik.gandewa.prakasa@student.school.com','(+62) 929 8071 623',6,'2007-07-19','male','Kpg. Daan No. 867, Administrasi Jakarta Utara 87187, Riau','Viktor Pranowo','(+62) 820 1091 849',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(150,'MHBTN0150','Putri Nurdiyanti','anita.ajeng.novitasari.s.pd@student.school.com','0375 5944 499',6,'2009-11-24','male','Gg. R.M. Said No. 459, Langsa 87315, Kalteng','Kenes Simanjuntak','(+62) 286 3849 145',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(151,'MHBTN0151','Salwa Vicky Yuniar','rizki.latupono.m.ak@student.school.com','(+62) 24 9071 3475',6,'2008-06-28','female','Ds. Teuku Umar No. 665, Lubuklinggau 41649, Sulut','Yance Wastuti','0202 1467 708',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(152,'MHBTN0152','Martaka Putra','asirwanda.firgantoro@student.school.com','028 9963 3373',6,'2008-09-08','male','Jln. Ekonomi No. 329, Cilegon 53316, Bali','Harsanto Hidayanto M.Ak','0684 1932 2392',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(153,'MHBTN0153','Vanesa Carla Handayani','gilda.yuliarti@student.school.com','0271 2655 675',6,'2008-10-04','female','Ki. Nanas No. 738, Prabumulih 30683, Papua','Zahra Ella Andriani','(+62) 558 6425 8815',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(154,'MHBTN0154','Wirda Uchita Farida S.Sos','gaduh.kadir.waluyo.m.farm@student.school.com','0602 2730 7968',6,'2009-09-23','female','Dk. Industri No. 944, Pasuruan 49994, Sultra','Rahmi Ophelia Purwanti','0859 8599 580',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(155,'MHBTN0155','Najwa Laksita','bagya.ramadan.m.ak@student.school.com','(+62) 24 0714 8479',6,'2008-11-20','male','Ki. Panjaitan No. 856, Administrasi Jakarta Utara 78761, Babel','Amalia Farida','0399 2674 7934',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(156,'MHBTN0156','Mila Yuniar M.Farm','tari.hastuti@student.school.com','0388 5736 652',6,'2009-08-14','male','Psr. Ciwastra No. 224, Cimahi 63965, Riau','Belinda Diah Yolanda','0762 9249 858',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(157,'MHBTN0157','Almira Sarah Susanti S.Pd','qori.kania.anggraini.m.pd@student.school.com','(+62) 25 6002 311',6,'2007-08-20','female','Gg. Tambun No. 486, Tidore Kepulauan 71846, Kalteng','Cayadi Prasetya S.Farm','028 2876 4368',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(158,'MHBTN0158','Umaya Elon Hardiansyah M.Pd','laras.prastuti@student.school.com','(+62) 219 5225 243',6,'2008-03-21','female','Kpg. Bass No. 886, Kendari 12192, Jambi','Asirwada Gangsar Saputra','0952 8151 181',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(159,'MHBTN0159','Olivia Palastri S.Ked','icha.usada.m.ak@student.school.com','027 7477 589',6,'2007-09-19','male','Kpg. Aceh No. 852, Bandung 86979, Lampung','Farhunnisa Usamah','(+62) 467 6034 8277',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(160,'MHBTN0160','Anita Ade Novitasari','unjani.hastuti.s.gz@student.school.com','(+62) 575 6077 8527',7,'2009-06-17','female','Jr. Urip Sumoharjo No. 859, Bukittinggi 67647, Lampung','Sabri Kusumo','022 3999 7647',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(161,'MHBTN0161','Prayoga Edward Maryadi','jaya.dabukke@student.school.com','(+62) 643 1560 724',7,'2010-05-31','male','Kpg. Bahagia  No. 328, Medan 40451, Bali','Citra Nabila Hastuti S.IP','(+62) 23 0342 4519',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(162,'MHBTN0162','Nyana Waluyo','zaenab.kusmawati@student.school.com','0704 9722 5873',7,'2007-10-24','female','Jln. Ciumbuleuit No. 573, Banjarmasin 56270, Jabar','Jasmin Hartati','(+62) 624 6016 999',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(163,'MHBTN0163','Sarah Rahayu','putri.maryati.s.pd@student.school.com','(+62) 409 3993 074',7,'2008-01-06','female','Gg. Pasteur No. 393, Jayapura 72705, Papua','Azalea Zulaikha Uyainah M.Pd','0790 1241 5067',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(164,'MHBTN0164','Amalia Anggraini','martani.ade.maheswara@student.school.com','0664 3827 2585',7,'2007-11-18','male','Psr. Kusmanto No. 256, Salatiga 57643, Sulsel','Titin Handayani M.Farm','0233 9529 802',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(165,'MHBTN0165','Jamal Prabowo','cinta.puspasari@student.school.com','0220 0594 8877',7,'2008-12-03','female','Gg. Balikpapan No. 783, Cirebon 49058, Sumsel','Tri Alambana Suryono S.H.','(+62) 28 8022 1980',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(166,'MHBTN0166','Jail Catur Saragih','makara.salahudin@student.school.com','0288 6364 655',7,'2009-08-20','male','Dk. Jamika No. 59, Palu 46490, Aceh','Kasiran Sitompul S.Pd','(+62) 595 3896 021',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(167,'MHBTN0167','Zulaikha Najwa Hariyah','cengkal.teddy.sitorus@student.school.com','(+62) 377 6975 220',7,'2008-01-31','male','Psr. Bappenas No. 482, Administrasi Jakarta Barat 15677, Jambi','Nardi Emin Mansur','0914 2259 6725',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(168,'MHBTN0168','Rahman Nashiruddin','luwes.habibi@student.school.com','(+62) 810 704 532',7,'2008-10-21','female','Dk. Suniaraja No. 619, Tasikmalaya 49953, Jabar','Ratih Suartini','023 6754 307',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(169,'MHBTN0169','Dalima Pertiwi','embuh.utama@student.school.com','(+62) 721 0010 785',7,'2007-11-03','female','Ds. Warga No. 852, Manado 97051, Jabar','Hairyanto Dongoran','0410 0970 0818',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(170,'MHBTN0170','Dagel Hakim','yoga.napitupulu@student.school.com','(+62) 545 8237 241',7,'2010-01-06','female','Ki. Eka No. 810, Bukittinggi 74013, Bali','Cinta Palastri S.Gz','0860 4144 5857',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(171,'MHBTN0171','Cindy Puspa Usada','yance.nasyidah@student.school.com','0625 1606 6905',7,'2008-01-14','female','Psr. Merdeka No. 388, Pariaman 53809, Kaltara','Gamanto Hidayat S.Kom','(+62) 859 6774 1460',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(172,'MHBTN0172','Harimurti Nyana Wasita','gilda.nurdiyanti.s.psi@student.school.com','0952 1307 2315',7,'2009-04-05','male','Ds. Jamika No. 744, Tangerang Selatan 81732, Kalsel','Nilam Dinda Padmasari','(+62) 22 0211 562',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(173,'MHBTN0173','Unggul Iswahyudi','carla.novitasari@student.school.com','022 0178 6261',7,'2008-03-07','male','Jr. Sutarto No. 605, Pekanbaru 28950, Riau','Salsabila Prastuti M.Pd','0254 3713 2686',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(174,'MHBTN0174','Yosef Nainggolan','abyasa.wahyudin@student.school.com','(+62) 601 1001 484',7,'2007-07-09','male','Ds. Dipatiukur No. 720, Pekanbaru 93342, DKI','Mahmud Pratama M.Farm','(+62) 826 8558 2655',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(175,'MHBTN0175','Gasti Wulandari M.Kom.','siska.gina.widiastuti@student.school.com','0555 4001 6686',7,'2007-08-26','male','Gg. Ciumbuleuit No. 439, Administrasi Jakarta Timur 75297, Kepri','Zelaya Juli Usamah','(+62) 421 7423 2091',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(176,'MHBTN0176','Olivia Raina Sudiati','nurul.laila.usamah.s.h.@student.school.com','0394 3009 067',7,'2007-08-16','female','Jln. Ters. Pasir Koja No. 754, Banjarmasin 39893, Lampung','Lembah Rusman Marpaung','(+62) 264 9850 247',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(177,'MHBTN0177','Jaswadi Mangunsong','yulia.kartika.handayani@student.school.com','0347 1977 3389',7,'2008-10-05','female','Jr. Bagas Pati No. 752, Bima 29288, Bali','Titin Padmasari','(+62) 850 9770 406',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(178,'MHBTN0178','Cici Hastuti','fitriani.wirda.wastuti@student.school.com','0313 6044 196',7,'2008-08-15','male','Ds. Bahagia  No. 587, Medan 81459, DKI','Bagya Prima Widodo S.E.I','028 8136 8908',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(179,'MHBTN0179','Cakrabuana Kasiran Manullang','kamaria.zulfa.hassanah.s.gz@student.school.com','0613 9467 450',7,'2009-01-19','male','Psr. Ronggowarsito No. 646, Banjarmasin 87590, Jabar','Sabrina Winda Haryanti','(+62) 377 4228 968',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(180,'MHBTN0180','Aditya Sihotang M.Ak','kania.wahyuni@student.school.com','(+62) 635 3305 069',7,'2009-07-06','male','Dk. Tangkuban Perahu No. 983, Palembang 17239, Malut','Dacin Permadi','(+62) 714 4724 4643',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(181,'MHBTN0181','Dina Anggraini','zulaikha.aryani.m.pd@student.school.com','0510 7561 010',7,'2009-04-16','male','Ki. Babakan No. 509, Administrasi Jakarta Pusat 47851, Maluku','Yuni Pertiwi','(+62) 453 3774 7897',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(182,'MHBTN0182','Gabriella Eli Padmasari M.Pd','sadina.sudiati@student.school.com','(+62) 909 6805 2886',7,'2009-10-12','male','Ki. Asia Afrika No. 3, Pangkal Pinang 76161, DKI','Paramita Farhunnisa Maryati M.Pd','(+62) 765 2716 537',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(183,'MHBTN0183','Hasim Saefullah S.Pt','kamaria.riyanti@student.school.com','0292 8259 978',7,'2008-05-28','female','Ds. Uluwatu No. 19, Padangsidempuan 49784, Sumsel','Laras Prastuti S.Kom','0730 1339 598',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(184,'MHBTN0184','Fitriani Wani Prastuti S.Pd','ratih.vicky.zulaika@student.school.com','0250 2511 978',7,'2009-01-27','male','Dk. Yoga No. 870, Pasuruan 76573, Bengkulu','Karsana Hasim Santoso M.M.','(+62) 459 1954 3484',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(185,'MHBTN0185','Yuliana Padmasari','oskar.respati.habibi@student.school.com','(+62) 212 9238 8985',7,'2010-04-06','female','Gg. Supomo No. 882, Administrasi Jakarta Selatan 28236, Bali','Hilda Aryani','0670 1875 2348',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(186,'MHBTN0186','Gawati Kuswandari','maria.hariyah@student.school.com','(+62) 345 5912 1353',7,'2008-03-22','male','Ki. Gatot Subroto No. 818, Ternate 43757, NTB','Jefri Mangunsong','0715 7056 0212',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(187,'MHBTN0187','Gabriella Salsabila Wahyuni','gara.adriansyah.s.pt@student.school.com','(+62) 917 9986 4454',7,'2008-11-24','female','Psr. BKR No. 694, Subulussalam 83544, Kepri','Ibrahim Zulkarnain','0750 0999 804',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(188,'MHBTN0188','Marsito Sinaga S.IP','laras.farida@student.school.com','(+62) 923 2888 136',7,'2007-07-22','female','Dk. Nangka No. 901, Gorontalo 62206, NTB','Kezia Shania Fujiati','(+62) 388 4000 952',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(189,'MHBTN0189','Ulya Sudiati','wirda.karen.fujiati@student.school.com','(+62) 648 7300 4388',8,'2009-11-21','male','Ds. Banal No. 530, Sawahlunto 26457, Sumut','Tiara Ella Prastuti','(+62) 780 6297 4417',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(190,'MHBTN0190','Purwadi Wijaya','anggabaya.balapati.saputra@student.school.com','0266 8194 172',8,'2008-03-15','male','Kpg. Katamso No. 48, Ternate 72376, Bengkulu','Bakda Kasim Mustofa','0392 2751 634',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(191,'MHBTN0191','Syahrini Laksita','wahyu.opan.hutapea@student.school.com','0950 0939 423',8,'2008-02-15','male','Gg. Wahid Hasyim No. 783, Yogyakarta 80969, Jateng','Bakiadi Suryono','0288 7979 569',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(192,'MHBTN0192','Betania Genta Yuliarti S.Ked','dimas.kenzie.wijaya.m.farm@student.school.com','0703 6261 0196',8,'2007-07-19','male','Gg. Yoga No. 858, Denpasar 54432, Jabar','Cengkal Nugroho','0767 7597 2003',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(193,'MHBTN0193','Lili Fujiati','dinda.widiastuti@student.school.com','(+62) 933 5853 560',8,'2009-08-05','female','Jr. Ters. Kiaracondong No. 44, Serang 60751, Kalbar','Najib Thamrin','(+62) 306 7016 6085',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(194,'MHBTN0194','Raina Fujiati','vicky.rahimah.s.farm@student.school.com','(+62) 914 9512 6332',8,'2008-09-25','female','Psr. Laksamana No. 284, Bandar Lampung 89272, DIY','Titin Kusmawati S.H.','(+62) 901 3100 6636',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(195,'MHBTN0195','Saiful Lega Hutapea S.Farm','asmadi.raden.adriansyah@student.school.com','0474 2342 966',8,'2007-10-14','female','Ki. Pelajar Pejuang 45 No. 752, Jambi 33890, Kaltara','Diah Nadine Sudiati','0992 5646 2203',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(196,'MHBTN0196','Calista Laksmiwati S.E.','harjaya.hakim@student.school.com','0465 5137 1674',8,'2010-01-15','female','Gg. Wahidin No. 177, Mataram 12189, Jabar','Kamidin Asmianto Pradana S.Pt','(+62) 555 0462 146',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(197,'MHBTN0197','Zulaikha Paulin Riyanti','novi.rika.maryati@student.school.com','(+62) 918 5489 688',8,'2009-11-19','male','Kpg. Thamrin No. 373, Tangerang Selatan 94244, Sultra','Keisha Winda Fujiati','(+62) 743 7009 0002',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(198,'MHBTN0198','Gangsa Jais Kuswoyo','pangestu.utama@student.school.com','0808 912 193',8,'2010-04-05','female','Ki. M.T. Haryono No. 560, Balikpapan 28852, Kaltara','Cornelia Sudiati','0610 9744 352',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(199,'MHBTN0199','Mila Zulaika','mahfud.pangestu@student.school.com','(+62) 784 1674 5816',8,'2009-07-20','female','Ki. Jaksa No. 563, Bima 70240, Sumut','Carla Mutia Susanti S.Gz','(+62) 973 0378 3077',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(200,'MHBTN0200','Ayu Uli Nuraini','sari.palastri@student.school.com','0553 4136 328',8,'2009-11-24','male','Jln. Sutami No. 675, Ambon 49334, NTB','Gina Permata','0932 2135 1217',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(201,'MHBTN0201','Oskar Jefri Tampubolon M.Ak','janet.hasanah@student.school.com','(+62) 686 0392 4826',8,'2008-01-21','male','Dk. Pelajar Pejuang 45 No. 508, Pontianak 18607, Sulteng','Ella Rahimah','(+62) 886 9666 185',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(202,'MHBTN0202','Murti Prasasta','respati.edi.habibi@student.school.com','0727 0822 902',8,'2008-05-26','male','Kpg. Bara No. 751, Banjar 60894, NTT','Karma Maheswara','(+62) 531 7551 0858',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(203,'MHBTN0203','Yuni Faizah Kusmawati S.E.','iriana.cornelia.susanti@student.school.com','(+62) 20 0903 7547',8,'2009-09-02','male','Dk. Uluwatu No. 210, Pekalongan 27100, DIY','Oskar Wahyudin S.IP','0855 674 438',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(204,'MHBTN0204','Bakiman Cawuk Iswahyudi M.TI.','hairyanto.waskita.m.farm@student.school.com','(+62) 934 4350 5618',8,'2010-06-09','male','Dk. Juanda No. 805, Bukittinggi 83499, NTT','Ratih Victoria Rahayu','(+62) 817 9568 883',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(205,'MHBTN0205','Zalindra Pratiwi','zalindra.hariyah.s.e.@student.school.com','(+62) 202 6916 4711',8,'2008-01-05','male','Dk. Soekarno Hatta No. 234, Tasikmalaya 68283, Lampung','Putri Haryanti','(+62) 844 399 868',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(206,'MHBTN0206','Danuja Adriansyah','maras.maulana@student.school.com','(+62) 562 6635 051',8,'2009-05-16','male','Ki. Sumpah Pemuda No. 489, Pekanbaru 32040, Babel','Belinda Winarsih','(+62) 868 944 658',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(207,'MHBTN0207','Michelle Uyainah S.E.I','wulan.fujiati.s.kom@student.school.com','0360 5295 457',8,'2008-11-26','male','Gg. Diponegoro No. 770, Tanjungbalai 57194, Kalsel','Hafshah Titin Anggraini','0991 6095 188',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(208,'MHBTN0208','Harsanto Jail Siregar','asmadi.saptono.s.i.kom@student.school.com','027 0518 3035',8,'2010-03-19','male','Jr. Rajawali No. 496, Surakarta 55136, Banten','Maryanto Unggul Marbun M.Ak','(+62) 968 1285 633',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(209,'MHBTN0209','Jelita Ratna Utami M.Ak','almira.sudiati@student.school.com','0236 2262 155',8,'2007-07-10','male','Jr. Pacuan Kuda No. 601, Kediri 91428, Malut','Yani Dina Hariyah S.Kom','0893 9374 3140',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(210,'MHBTN0210','Novi Puspita','anastasia.winarsih.m.pd@student.school.com','0731 0841 222',8,'2008-10-17','female','Ki. Supono No. 941, Bitung 88187, NTT','Kani Suci Hartati','(+62) 251 3590 3440',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(211,'MHBTN0211','Karna Kuswoyo S.Farm','tami.almira.hasanah.m.farm@student.school.com','0889 0347 0950',8,'2008-03-14','female','Dk. Badak No. 520, Pariaman 93103, Maluku','Asmuni Thamrin M.TI.','(+62) 863 064 555',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(212,'MHBTN0212','Hamima Permata S.E.','eva.uyainah@student.school.com','0820 434 712',8,'2007-12-30','male','Ki. Banal No. 17, Gunungsitoli 75996, Kalsel','Jessica Purwanti','0465 0172 7318',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(213,'MHBTN0213','Yulia Syahrini Riyanti S.E.','wulan.suryatmi@student.school.com','0877 574 851',8,'2009-09-22','female','Psr. Lumban Tobing No. 105, Salatiga 83491, DIY','Eko Narpati','(+62) 713 6576 928',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(214,'MHBTN0214','Darmana Mandala','amelia.wulandari.s.i.kom@student.school.com','0978 2782 6910',9,'2008-01-25','female','Psr. Camar No. 910, Probolinggo 78553, Maluku','Kemba Putu Januar','0911 2506 545',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(215,'MHBTN0215','Unjani Usada S.I.Kom','harimurti.bancar.saragih@student.school.com','(+62) 366 0459 317',9,'2009-01-12','male','Kpg. Kebonjati No. 832, Ternate 22328, Sumsel','Salimah Nadine Nasyidah','(+62) 297 5125 0862',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(216,'MHBTN0216','Teddy Warta Rajata','rosman.natsir.s.sos@student.school.com','(+62) 457 6649 9851',9,'2009-05-26','male','Ki. Madrasah No. 893, Administrasi Jakarta Timur 94674, DKI','Rina Andriani','0781 1363 182',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(217,'MHBTN0217','Puti Shania Lestari','farhunnisa.laksmiwati@student.school.com','0299 8265 8546',9,'2008-01-10','female','Jr. Pacuan Kuda No. 801, Kediri 11839, Kepri','Galih Latif Samosir S.T.','(+62) 626 0897 009',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(218,'MHBTN0218','Lukman Pranowo','dirja.wisnu.prasetya.s.psi@student.school.com','(+62) 615 4639 838',9,'2008-11-27','female','Jln. Villa No. 640, Makassar 84104, Sultra','Violet Wulandari S.E.','024 1740 7963',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(219,'MHBTN0219','Intan Lestari','salwa.nurdiyanti@student.school.com','(+62) 909 1717 5043',9,'2008-07-27','male','Jr. Haji No. 490, Sabang 81089, Kalbar','Prakosa Irfan Mahendra S.Pt','(+62) 721 5801 207',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(220,'MHBTN0220','Vanesa Pudjiastuti','cinthia.septi.laksmiwati@student.school.com','0338 5485 9045',9,'2009-12-11','female','Dk. Wahid No. 334, Dumai 46192, Sumbar','Tasnim Tirta Mustofa','(+62) 688 9952 738',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(221,'MHBTN0221','Wira Winarno','daru.budiman@student.school.com','0399 8317 553',9,'2008-09-29','male','Gg. Kyai Mojo No. 754, Pariaman 85635, Gorontalo','Danang Marpaung','(+62) 507 4690 0226',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(222,'MHBTN0222','Ian Umaya Putra','samiah.wulandari@student.school.com','0637 7122 9475',9,'2007-10-14','female','Jln. Bagonwoto  No. 681, Bengkulu 21657, Kalteng','Kasusra Kuncara Hidayat','0867 1337 6873',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(223,'MHBTN0223','Zahra Hasanah','yoga.tamba@student.school.com','(+62) 271 0350 7734',9,'2008-12-28','male','Jr. Dewi Sartika No. 312, Bima 54803, Jatim','Cakrabirawa Dacin Permadi S.I.Kom','(+62) 763 5032 177',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(224,'MHBTN0224','Azalea Agnes Farida S.Ked','banawi.hutapea@student.school.com','(+62) 577 0551 854',9,'2009-03-25','female','Dk. Sugiyopranoto No. 887, Administrasi Jakarta Barat 69014, Sumsel','Kurnia Kacung Suwarno M.TI.','0412 8793 7483',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(225,'MHBTN0225','Prabawa Kemba Sitorus S.IP','kamidin.arsipatra.prabowo.m.kom.@student.school.com','(+62) 373 9704 2688',9,'2010-05-20','female','Ki. Acordion No. 782, Tasikmalaya 23410, Papua','Diana Amalia Hartati','(+62) 244 0117 8161',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(226,'MHBTN0226','Vanya Nuraini','oni.nurdiyanti.s.i.kom@student.school.com','(+62) 349 6035 2247',9,'2008-04-26','male','Gg. Hayam Wuruk No. 751, Padangsidempuan 92013, NTT','Ratna Maida Suartini S.H.','0357 9018 2478',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(227,'MHBTN0227','Jelita Winarsih M.M.','ghani.mansur@student.school.com','0212 6900 3870',9,'2009-01-22','male','Psr. Antapani Lama No. 916, Ambon 74229, Jabar','Cagak Hidayat','(+62) 413 3596 338',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(228,'MHBTN0228','Paramita Melani','kayla.mala.halimah@student.school.com','0840 7230 599',9,'2009-06-18','male','Jr. Ujung No. 231, Blitar 24293, NTT','Banawi Bahuwirya Samosir','026 0739 114',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(229,'MHBTN0229','Gabriella Haryanti S.Pd','raden.kurniawan@student.school.com','0445 5866 5983',9,'2008-09-27','female','Kpg. Cikutra Timur No. 927, Bandung 87668, Sumsel','Cakrabuana Elvin Wijaya','0809 382 072',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(230,'MHBTN0230','Muhammad Kurniawan','paramita.astuti@student.school.com','(+62) 431 0404 094',9,'2008-08-15','male','Jln. Bagas Pati No. 244, Solok 16628, Malut','Reksa Lega Siregar S.Farm','0662 2871 787',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(231,'MHBTN0231','Siti Rahayu Hartati S.E.I','gilang.karja.firgantoro@student.school.com','028 3239 394',9,'2008-05-11','male','Jln. Jakarta No. 125, Mojokerto 97494, Bengkulu','Mala Astuti','0664 5404 241',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(232,'MHBTN0232','Kezia Pratiwi S.Pt','farhunnisa.zaenab.kuswandari@student.school.com','0817 192 057',9,'2008-08-17','male','Ds. Basket No. 847, Medan 44081, NTT','Darsirah Nardi Situmorang S.Sos','(+62) 826 0161 437',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(233,'MHBTN0233','Jamil Gaman Budiman M.Ak','usyi.yolanda@student.school.com','0538 7850 607',9,'2008-05-28','male','Dk. Industri No. 72, Bitung 16144, DKI','Elvina Safitri','(+62) 253 1606 155',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(234,'MHBTN0234','Nalar Dodo Kurniawan','lutfan.budiyanto@student.school.com','(+62) 595 2041 5643',9,'2009-01-14','male','Jr. Batako No. 449, Cilegon 54197, NTT','Irma Diana Susanti S.T.','0807 1942 3285',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(235,'MHBTN0235','Wirda Yolanda','oni.novitasari.m.m.@student.school.com','(+62) 734 6726 4874',9,'2007-11-23','female','Psr. Merdeka No. 426, Singkawang 73232, Kaltara','Salsabila Lestari','(+62) 845 486 242',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(236,'MHBTN0236','Jessica Carla Nuraini S.Kom','ibrani.napitupulu.s.kom@student.school.com','(+62) 278 5856 1636',9,'2008-06-01','female','Jr. Moch. Toha No. 554, Padang 73254, Sulteng','Balangga Cemeti Gunawan S.Farm','(+62) 663 8091 027',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(237,'MHBTN0237','Zalindra Rahimah','puti.lestari@student.school.com','0841 4714 1520',9,'2007-07-07','female','Gg. Baja Raya No. 348, Cirebon 17132, Kaltim','Faizah Puspita S.H.','0886 0486 1856',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(238,'MHBTN0238','Kemal Suwarno S.Psi','maya.rahimah@student.school.com','0877 233 331',9,'2010-05-09','female','Dk. Sumpah Pemuda No. 411, Padang 87293, Sulut','Yoga Tampubolon','0666 6525 009',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(239,'MHBTN0239','Balapati Hadi Widodo M.Ak','teddy.ramadan@student.school.com','0712 5317 485',9,'2010-01-29','male','Psr. Juanda No. 399, Pematangsiantar 33846, Jatim','Artanto Lamar Marpaung','(+62) 23 9731 6464',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(240,'MHBTN0240','Ana Sudiati','ridwan.prasetya.suwarno.s.psi@student.school.com','023 3559 396',9,'2007-08-04','male','Kpg. Radio No. 490, Pagar Alam 21243, Banten','Rudi Simbolon','(+62) 704 4019 315',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(241,'MHBTN0241','Belinda Oktaviani M.Farm','reksa.damanik@student.school.com','0661 6509 6186',9,'2010-05-24','male','Dk. Yosodipuro No. 531, Pariaman 10195, Sulsel','Prabowo Warsa Prasasta S.Psi','0503 1136 3903',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(242,'MHBTN0242','Simon Laswi Budiyanto S.H.','vicky.agustina@student.school.com','0513 2744 9258',10,'2009-01-01','female','Jln. Rajawali No. 895, Dumai 21264, Sulsel','Caket Nashiruddin','0242 5944 694',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(243,'MHBTN0243','Baktiadi Rafi Uwais S.I.Kom','fathonah.namaga@student.school.com','0525 2343 407',10,'2009-09-08','female','Dk. Cikutra Timur No. 825, Bontang 30015, Bengkulu','Luluh Dagel Sitompul','0481 2000 1035',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(244,'MHBTN0244','Himawan Situmorang','hasta.harjasa.gunarto@student.school.com','(+62) 982 6694 192',10,'2007-08-29','male','Jln. Bagis Utama No. 919, Administrasi Jakarta Pusat 12787, Papua','Makara Suryono S.E.','021 9813 2210',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(245,'MHBTN0245','Fathonah Paulin Usada','martana.suwarno@student.school.com','0983 2874 279',10,'2008-10-08','female','Ki. Orang No. 805, Langsa 45007, NTB','Prabu Narpati S.Sos','0686 3220 153',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(246,'MHBTN0246','Opung Hutapea S.I.Kom','cahyo.bala.pangestu.m.ak@student.school.com','(+62) 604 9438 4745',10,'2010-04-20','male','Gg. Basoka Raya No. 403, Langsa 61383, Riau','Wira Maheswara','0514 7483 6950',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(247,'MHBTN0247','Raina Kusmawati','viman.sitompul@student.school.com','(+62) 21 9670 0413',10,'2008-02-28','female','Psr. Nakula No. 631, Bima 17962, Bali','Aurora Oni Mandasari','(+62) 854 797 539',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(248,'MHBTN0248','Surya Irawan','maida.aurora.hasanah@student.school.com','0494 7705 1652',10,'2009-01-21','female','Ds. Labu No. 152, Depok 92314, NTT','Jasmin Juli Padmasari','(+62) 743 0553 108',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(249,'MHBTN0249','Ade Marbun','safina.puspita.s.e.i@student.school.com','(+62) 211 2440 0980',10,'2010-05-24','female','Ds. Jagakarsa No. 495, Yogyakarta 94506, Sumsel','Yunita Nasyidah','029 4665 8271',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(250,'MHBTN0250','Cawisono Arta Prasetya S.T.','raina.haryanti@student.school.com','(+62) 324 7987 754',10,'2010-01-17','male','Kpg. Baan No. 64, Serang 94032, Malut','Vicky Agustina','(+62) 647 3169 6070',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(251,'MHBTN0251','Banawi Saptono','ratih.oktaviani.s.pt@student.school.com','(+62) 409 8533 095',10,'2008-06-14','male','Gg. Dipenogoro No. 512, Ambon 14653, Kalsel','Endra Waluyo','0490 3592 8144',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(252,'MHBTN0252','Tina Wastuti','amelia.ilsa.sudiati@student.school.com','0266 8213 301',10,'2009-08-22','female','Psr. Bah Jaya No. 468, Jayapura 62343, Sumut','Banara Mangunsong S.Gz','(+62) 514 7067 0699',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(253,'MHBTN0253','Hesti Lidya Kuswandari','embuh.cakrawala.sihombing.m.kom.@student.school.com','(+62) 899 419 914',10,'2008-08-19','male','Jr. Kali No. 793, Singkawang 88761, Kalteng','Suci Puspasari M.TI.','(+62) 568 0197 3847',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(254,'MHBTN0254','Ridwan Wibisono','vera.usamah.m.m.@student.school.com','0704 5278 976',10,'2008-12-30','female','Jln. Ki Hajar Dewantara No. 216, Ternate 23087, Pabar','Ibrahim Widodo M.M.','(+62) 590 2058 4165',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(255,'MHBTN0255','Dimaz Uwais','jessica.rahmi.puspasari.s.farm@student.school.com','(+62) 896 8352 7169',10,'2007-10-31','female','Gg. Pasteur No. 538, Pekanbaru 78856, Sulsel','Putri Agustina','(+62) 24 7919 403',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(256,'MHBTN0256','Sadina Fujiati','rina.utami@student.school.com','(+62) 273 5241 059',10,'2010-01-01','female','Kpg. Yoga No. 110, Surakarta 74510, Sulbar','Silvia Mayasari','0574 0080 486',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(257,'MHBTN0257','Gamblang Hutagalung','jayeng.situmorang@student.school.com','0489 3151 5904',10,'2008-07-11','female','Psr. W.R. Supratman No. 338, Prabumulih 53555, Banten','Argono Suryono M.TI.','(+62) 751 6411 3108',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(258,'MHBTN0258','Lintang Maryati S.IP','tiara.fujiati@student.school.com','0270 1362 1624',10,'2008-04-16','male','Dk. Sutarjo No. 936, Payakumbuh 29032, Jateng','Maimunah Mala Laksmiwati','0601 8343 3796',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(259,'MHBTN0259','Cinthia Purwanti M.TI.','yahya.saragih.s.t.@student.school.com','0262 7211 0826',10,'2008-08-07','male','Psr. Ir. H. Juanda No. 688, Depok 68163, DKI','Gabriella Yuni Laksita S.Ked','(+62) 619 9080 976',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(260,'MHBTN0260','Kalim Nababan','jasmin.clara.padmasari.m.m.@student.school.com','(+62) 372 1226 734',10,'2008-04-04','male','Psr. Suniaraja No. 687, Padang 59742, Lampung','Erik Pangestu','(+62) 344 5259 548',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(261,'MHBTN0261','Aswani Tampubolon','rahmi.suryatmi@student.school.com','(+62) 688 8298 606',10,'2009-09-09','female','Dk. Batako No. 502, Sawahlunto 68821, NTB','Kajen Damar Suryono M.Farm','0623 1547 4240',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(262,'MHBTN0262','Kalim Anggriawan S.Pd','dariati.sirait@student.school.com','(+62) 898 1301 6454',10,'2009-08-26','male','Jln. Salatiga No. 863, Dumai 97979, Papua','Olga Ramadan','(+62) 690 5362 158',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(263,'MHBTN0263','Janet Dalima Purwanti S.Pt','septi.purnawati@student.school.com','(+62) 919 4779 7679',10,'2008-10-03','female','Gg. Yogyakarta No. 597, Gunungsitoli 63002, Sulteng','Martana Prakasa','(+62) 951 3645 8469',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(264,'MHBTN0264','Makuta Waskita S.I.Kom','paris.padmasari.s.i.kom@student.school.com','(+62) 826 8456 792',10,'2008-10-24','male','Kpg. Basmol Raya No. 655, Blitar 21764, Kalbar','Devi Nasyidah','(+62) 849 206 201',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(265,'MHBTN0265','Ilsa Ilsa Pratiwi S.Farm','bahuwirya.harto.narpati.s.sos@student.school.com','(+62) 770 4069 5721',10,'2009-07-11','female','Jln. Ahmad Dahlan No. 755, Lubuklinggau 14932, Lampung','Icha Wahyuni','(+62) 22 8817 8052',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(266,'MHBTN0266','Ulva Nuraini S.Psi','titi.pudjiastuti@student.school.com','(+62) 442 2916 0554',10,'2009-03-17','male','Dk. B.Agam 1 No. 532, Gunungsitoli 10804, DIY','Patricia Yuniar','0982 6688 996',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(267,'MHBTN0267','Putri Hesti Utami S.E.','aswani.sihombing.s.gz@student.school.com','(+62) 810 8088 364',10,'2009-05-06','female','Gg. Suryo No. 612, Ambon 69850, Sultra','Viktor Waluyo','(+62) 788 8275 933',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(268,'MHBTN0268','Zelaya Zulfa Oktaviani','ayu.widiastuti@student.school.com','0885 3701 884',10,'2008-06-30','male','Dk. Juanda No. 465, Bitung 35139, Jambi','Putri Utami','0796 2513 6733',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(269,'MHBTN0269','Dian Safina Winarsih','kartika.puspita@student.school.com','(+62) 705 6301 481',11,'2008-12-06','male','Psr. Bayan No. 103, Administrasi Jakarta Timur 30106, Kalsel','Bella Yolanda','0687 6737 8552',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(270,'MHBTN0270','Ikin Salahudin','jasmin.olivia.nasyiah.s.pt@student.school.com','(+62) 314 3054 6262',11,'2007-07-28','female','Jr. Sentot Alibasa No. 715, Tidore Kepulauan 17173, Sulbar','Uda Sihotang','0777 5693 435',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(271,'MHBTN0271','Pangestu Manullang','ellis.wulandari.s.psi@student.school.com','(+62) 579 0498 1365',11,'2009-07-11','male','Psr. Kusmanto No. 935, Banda Aceh 99219, Jatim','Padmi Wani Maryati','0838 731 138',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(272,'MHBTN0272','Paiman Lazuardi','saiful.uwais@student.school.com','(+62) 439 0433 533',11,'2008-03-12','male','Gg. Bakhita No. 29, Administrasi Jakarta Selatan 43522, Jabar','Jatmiko Winarno','(+62) 729 3002 9662',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(273,'MHBTN0273','Gamblang Nugroho','nadine.rachel.permata@student.school.com','0805 6879 9747',11,'2007-08-13','female','Dk. Juanda No. 206, Bukittinggi 47807, Sultra','Eman Siregar S.Farm','022 9630 4785',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(274,'MHBTN0274','Kasusra Tri Iswahyudi S.Gz','lili.yulianti.m.kom.@student.school.com','(+62) 366 1554 1035',11,'2007-10-15','female','Gg. Rajawali Barat No. 897, Sawahlunto 48758, Kaltara','Galih Najmudin','0834 2363 5450',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(275,'MHBTN0275','Kawaya Jaka Simbolon','karimah.sudiati.s.gz@student.school.com','(+62) 871 9480 049',11,'2009-12-20','female','Ki. Diponegoro No. 219, Tebing Tinggi 10787, Sulut','Atmaja Samosir','0539 5489 9604',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(276,'MHBTN0276','Genta Kusmawati','cinta.prastuti@student.school.com','0244 9286 8602',11,'2009-07-10','female','Ki. Lada No. 703, Bogor 38404, NTB','Indra Catur Dongoran','(+62) 784 4108 885',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(277,'MHBTN0277','Rina Yolanda','ifa.novitasari@student.school.com','025 8145 393',11,'2010-04-26','male','Jr. Balikpapan No. 610, Probolinggo 13384, Kalbar','Balamantri Kajen Prasasta S.H.','0825 0731 2619',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(278,'MHBTN0278','Victoria Fathonah Kusmawati','gantar.tampubolon@student.school.com','0755 1036 5331',11,'2009-07-25','male','Jln. Madrasah No. 611, Padang 57576, Gorontalo','Kawaca Sirait','(+62) 715 8270 261',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(279,'MHBTN0279','Zulfa Farah Widiastuti S.Kom','lurhur.purwanto.santoso@student.school.com','0502 9332 415',11,'2009-12-03','male','Ki. Asia Afrika No. 104, Malang 48475, Kalsel','Hesti Rahimah','0218 5730 7778',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(280,'MHBTN0280','Tasdik Hidayat','jono.utama.mandala.s.farm@student.school.com','(+62) 590 1945 104',11,'2009-01-11','female','Dk. Gremet No. 178, Depok 25457, Babel','Saka Sihombing','(+62) 818 6942 4139',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(281,'MHBTN0281','Harjasa Simbolon','teddy.suwarno@student.school.com','(+62) 742 0605 3119',11,'2008-05-13','female','Psr. Gardujati No. 140, Tanjung Pinang 33431, Jambi','Zalindra Yuliarti','0508 3004 4045',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(282,'MHBTN0282','Dimas Narpati','najam.setiawan.m.pd@student.school.com','0201 2706 681',11,'2009-10-31','female','Ki. Jamika No. 110, Tanjung Pinang 91800, Pabar','Bahuwarna Ardianto S.Pd','0576 7195 0289',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(283,'MHBTN0283','Syahrini Shakila Purnawati','irnanto.hidayanto.m.ak@student.school.com','0242 6675 0824',11,'2009-06-14','female','Psr. Tambak No. 118, Kendari 59700, Kalbar','Jane Gasti Nasyidah S.Kom','(+62) 244 8541 764',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(284,'MHBTN0284','Lintang Kani Utami','lasmono.vino.utama@student.school.com','(+62) 397 0201 4895',11,'2009-11-10','male','Jr. Kalimalang No. 263, Bekasi 85677, DIY','Patricia Queen Pudjiastuti S.E.','(+62) 21 1319 787',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(285,'MHBTN0285','Yahya Dongoran','ilsa.namaga.s.i.kom@student.school.com','(+62) 23 5486 011',11,'2009-05-21','female','Dk. Bagas Pati No. 111, Serang 70389, Kepri','Hendri Saragih','0416 9514 2771',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(286,'MHBTN0286','Iriana Padmasari','aisyah.mardhiyah@student.school.com','0564 0413 197',11,'2010-05-18','female','Ds. K.H. Wahid Hasyim (Kopo) No. 789, Administrasi Jakarta Selatan 47946, NTT','Tania Maryati','(+62) 818 8571 567',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(287,'MHBTN0287','Hani Lalita Yolanda','sari.tami.laksita@student.school.com','(+62) 27 4135 211',11,'2009-11-24','female','Ds. Ciwastra No. 629, Payakumbuh 95267, Sumut','Embuh Eja Anggriawan','0844 4198 4821',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(288,'MHBTN0288','Asirwanda Lazuardi','mariadi.gunawan@student.school.com','(+62) 872 114 801',11,'2010-02-19','female','Jln. Baya Kali Bungur No. 787, Denpasar 69143, Papua','Hilda Padma Permata S.Pd','(+62) 896 7933 365',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(289,'MHBTN0289','Victoria Wulandari','lintang.ratih.hariyah.s.t.@student.school.com','(+62) 469 1373 8000',11,'2009-05-21','female','Ki. Basoka Raya No. 702, Bima 48960, Jambi','Ivan Pradipta','0565 5416 632',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(290,'MHBTN0290','Yance Violet Hasanah','patricia.hartati@student.school.com','(+62) 577 2687 648',11,'2010-04-18','male','Jr. Banceng Pondok No. 616, Mojokerto 60349, Maluku','Julia Maryati','(+62) 352 3786 826',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(291,'MHBTN0291','Hardana Samsul Mandala M.Farm','muni.waskita@student.school.com','022 1705 451',11,'2010-03-14','male','Psr. Warga No. 152, Solok 95602, Pabar','Kuncara Wacana','0896 4256 563',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(292,'MHBTN0292','Natalia Wahyuni S.I.Kom','widya.purwanti@student.school.com','(+62) 506 4563 532',11,'2008-07-30','female','Jln. Jakarta No. 701, Surakarta 90627, Gorontalo','Prayoga Liman Prayoga','(+62) 24 5437 917',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(293,'MHBTN0293','Ika Winarsih','luhung.umaya.rajasa.s.kom@student.school.com','0609 4485 3314',11,'2008-07-24','male','Dk. Imam Bonjol No. 256, Bukittinggi 75838, Sumbar','Prayoga Vino Damanik','0342 3849 9658',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(294,'MHBTN0294','Siska Rahimah','clara.amalia.astuti@student.school.com','020 5539 4522',11,'2007-12-15','female','Kpg. Bayam No. 908, Ternate 75318, Lampung','Daniswara Setiawan','0821 0582 8311',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(295,'MHBTN0295','Zaenab Kuswandari','danang.marbun@student.school.com','(+62) 434 8546 272',12,'2009-05-11','male','Ds. Baya Kali Bungur No. 571, Bukittinggi 30013, Gorontalo','Lili Cindy Novitasari S.Sos','0818 7837 199',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(296,'MHBTN0296','Victoria Chelsea Nasyiah','kanda.wibowo.s.h.@student.school.com','0881 345 484',12,'2008-02-23','female','Jr. Untung Suropati No. 32, Malang 35328, NTB','Bagya Wibowo S.Psi','(+62) 573 9799 2681',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(297,'MHBTN0297','Jagaraga Ridwan Nugroho','jamil.gamanto.megantara.s.t.@student.school.com','0700 4438 6235',12,'2008-04-24','female','Jln. Basuki Rahmat  No. 116, Malang 65077, DKI','Usyi Mandasari S.I.Kom','0672 4092 918',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(298,'MHBTN0298','Puput Aurora Wastuti S.I.Kom','dartono.utama@student.school.com','0850 2154 216',12,'2010-03-04','male','Jr. Abdul. Muis No. 785, Gorontalo 93689, Sumut','Soleh Firgantoro','028 1735 957',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(299,'MHBTN0299','Farhunnisa Namaga S.Pd','citra.oktaviani.m.kom.@student.school.com','0881 7593 5758',12,'2008-11-26','male','Kpg. Untung Suropati No. 398, Kotamobagu 94724, Gorontalo','Daryani Laswi Budiman M.Farm','020 2189 992',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(300,'MHBTN0300','Asmianto Wahyudin','karta.kardi.wahyudin.s.farm@student.school.com','024 5586 4006',12,'2008-08-16','male','Gg. Peta No. 391, Kediri 11111, Sumut','Jaka Wibowo','0479 5293 362',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(301,'MHBTN0301','Rahmi Mardhiyah S.Ked','jabal.wardaya.marbun.m.farm@student.school.com','(+62) 957 2348 1435',12,'2007-10-04','female','Jr. Pasteur No. 785, Tebing Tinggi 98004, Sulteng','Jati Elvin Wibowo S.Psi','025 9242 2711',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(302,'MHBTN0302','Bala Kemal Maryadi S.T.','radit.ardianto@student.school.com','(+62) 473 9040 9454',12,'2009-10-22','female','Gg. Bak Air No. 179, Bukittinggi 40845, Kalsel','Johan Habibi','0374 7323 272',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(303,'MHBTN0303','Ika Salimah Usamah M.Farm','ajeng.purwanti@student.school.com','0272 0020 011',12,'2008-11-09','male','Dk. B.Agam Dlm No. 805, Bogor 63143, Bengkulu','Bahuwirya Nashiruddin','0852 1030 8393',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(304,'MHBTN0304','Fitria Zaenab Hartati','karna.dwi.gunarto.s.kom@student.school.com','0248 2810 291',12,'2010-04-28','male','Kpg. HOS. Cjokroaminoto (Pasirkaliki) No. 371, Bontang 22811, Riau','Mumpuni Hendri Utama S.Sos','0361 6495 181',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(305,'MHBTN0305','Carla Humaira Lailasari S.Pd','anggabaya.firmansyah@student.school.com','(+62) 909 9286 6464',12,'2008-03-27','female','Dk. Bappenas No. 955, Administrasi Jakarta Utara 39339, Sumbar','Samiah Clara Laksita S.T.','(+62) 641 1500 4614',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(306,'MHBTN0306','Perkasa Hidayat','cinthia.rahmi.sudiati@student.school.com','(+62) 965 1661 3288',12,'2007-12-13','male','Ki. Antapani Lama No. 341, Metro 19284, Bali','Jagaraga Hidayat M.M.','0301 0347 0796',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(307,'MHBTN0307','Perkasa Muni Damanik S.E.I','maman.jailani@student.school.com','0799 3200 259',12,'2010-01-07','male','Dk. Hang No. 773, Subulussalam 39250, Banten','Puti Kusmawati','0403 6818 848',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(308,'MHBTN0308','Paulin Safitri','zahra.mandasari@student.school.com','0234 6262 718',12,'2009-03-05','female','Ki. Ekonomi No. 499, Tual 15883, Sulut','Hadi Natsir','(+62) 241 5711 1406',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(309,'MHBTN0309','Mala Unjani Mayasari','darijan.tampubolon.s.t.@student.school.com','0572 4054 532',12,'2008-07-02','male','Psr. Bak Air No. 26, Manado 88132, NTB','Harimurti Gada Sirait','(+62) 589 0001 7491',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(310,'MHBTN0310','Rahmi Hassanah','yulia.mayasari@student.school.com','0704 6322 3708',12,'2008-08-25','female','Ki. Asia Afrika No. 324, Pontianak 34488, Jateng','Siti Lestari M.Ak','0758 0116 4578',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(311,'MHBTN0311','Gambira Januar','dirja.prakasa.m.kom.@student.school.com','(+62) 29 1269 701',12,'2008-08-26','male','Psr. Bahagia No. 177, Bandung 23772, Kepri','Radit Rafi Wasita','(+62) 652 4221 3576',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(312,'MHBTN0312','Catur Pradipta','kasusra.siregar.s.t.@student.school.com','(+62) 406 6671 076',12,'2009-08-30','female','Ds. Jend. Sudirman No. 231, Dumai 37899, Sulut','Najib Hidayat','(+62) 439 9050 508',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(313,'MHBTN0313','Rika Yolanda','wani.wani.astuti@student.school.com','(+62) 355 0305 3936',12,'2008-04-06','female','Jln. Bakau Griya Utama No. 191, Mojokerto 54338, Malut','Radika Jais Pradana','0452 2633 421',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(314,'MHBTN0314','Reza Hardiansyah','virman.widodo@student.school.com','0632 4097 1854',12,'2009-11-18','female','Dk. Ters. Pasir Koja No. 48, Madiun 84297, Jambi','Mulya Viktor Suryono','(+62) 225 2011 773',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(315,'MHBTN0315','Ida Astuti','dwi.marbun@student.school.com','(+62) 673 3452 407',12,'2007-10-10','female','Dk. Diponegoro No. 98, Salatiga 20627, Sulbar','Asmadi Danu Irawan','(+62) 501 6643 500',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(316,'MHBTN0316','Syahrini Diana Suryatmi M.M.','aris.tampubolon@student.school.com','0971 4069 2241',12,'2007-10-27','female','Jr. Madrasah No. 866, Metro 59517, Kalsel','Sakti Tirta Marpaung','0607 2148 757',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(317,'MHBTN0317','Bakiono Heru Zulkarnain S.Kom','kawaca.pangestu@student.school.com','0929 5537 272',12,'2009-01-07','male','Jln. Abdul No. 274, Pontianak 65933, Sumbar','Malika Prastuti','0887 2972 2714',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(318,'MHBTN0318','Dinda Melani','gantar.siregar@student.school.com','(+62) 908 6241 1800',12,'2009-01-02','male','Psr. R.E. Martadinata No. 938, Kediri 32305, Lampung','Cawisono Purwa Siregar','024 8578 348',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(319,'MHBTN0319','Among Langgeng Ramadan S.Farm','gina.hassanah.m.farm@student.school.com','0396 6438 3882',12,'2008-06-09','male','Ds. Sadang Serang No. 194, Tanjung Pinang 30969, Lampung','Emil Suryono','(+62) 212 8823 0697',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(320,'MHBTN0320','Melinda Rahmi Uyainah','balijan.santoso.s.e.@student.school.com','(+62) 279 4277 0884',12,'2010-05-23','female','Kpg. Basoka No. 957, Tual 85695, Malut','Lintang Padmasari','(+62) 558 1975 186',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(321,'MHBTN0321','Yessi Yuniar','kayla.ghaliyati.andriani.s.farm@student.school.com','0238 6466 162',13,'2009-10-01','female','Ds. Urip Sumoharjo No. 644, Pariaman 55816, Sulsel','Rafi Halim','(+62) 21 8216 7402',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(322,'MHBTN0322','Ophelia Agustina S.Ked','janet.suci.kuswandari.s.pt@student.school.com','0315 5817 087',13,'2008-12-18','male','Ds. Baya Kali Bungur No. 901, Tanjung Pinang 77660, Sumbar','Puspa Vera Farida M.TI.','(+62) 785 1893 9932',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(323,'MHBTN0323','Cinthia Lailasari','dian.devi.palastri.m.kom.@student.school.com','0742 2264 371',13,'2008-10-17','female','Dk. Otista No. 771, Tomohon 33781, Aceh','Dasa Manullang','(+62) 595 5865 555',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(324,'MHBTN0324','Jaga Manah Firgantoro S.T.','kamila.hasanah.m.ak@student.school.com','(+62) 479 0034 6110',13,'2008-09-10','female','Ki. Perintis Kemerdekaan No. 678, Denpasar 58259, Jambi','Queen Nurdiyanti M.Ak','(+62) 368 0778 6645',1,'2025-07-01 21:16:38','2025-07-01 21:16:38'),(325,'MHBTN0325','Hamima Victoria Wastuti S.IP','vera.mayasari@student.school.com','(+62) 709 0564 275',13,'2008-04-11','male','Ki. Untung Suropati No. 10, Bandar Lampung 59159, Sulteng','Vanesa Rahimah S.Farm','(+62) 27 4196 461',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(326,'MHBTN0326','Irwan Taswir Wasita','lukita.kusumo@student.school.com','0516 1654 999',13,'2009-01-07','male','Psr. Sudirman No. 973, Tomohon 75924, Bali','Natalia Novitasari','024 9329 5116',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(327,'MHBTN0327','Mulya Slamet Prayoga S.T.','eva.pratiwi.m.kom.@student.school.com','(+62) 24 3814 1495',13,'2008-09-20','male','Ds. Elang No. 581, Bogor 18080, Sultra','Kardi Anggriawan','(+62) 332 9746 1542',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(328,'MHBTN0328','Paris Kayla Prastuti S.Psi','restu.mila.haryanti.s.pt@student.school.com','(+62) 518 7915 811',13,'2010-02-28','male','Psr. Bakti No. 647, Mataram 24989, Sumbar','Jaeman Prakasa','0592 6237 7666',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(329,'MHBTN0329','Caraka Firgantoro','febi.rina.widiastuti@student.school.com','0666 4660 7132',13,'2010-01-02','female','Ki. Kebangkitan Nasional No. 913, Batam 21939, Bali','Lasmono Lazuardi','029 5555 4141',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(330,'MHBTN0330','Capa Bambang Marbun','victoria.zulaika@student.school.com','(+62) 360 5658 442',13,'2010-03-18','male','Ds. Bakau No. 694, Batu 86762, NTT','Lili Rahayu','0702 3514 837',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(331,'MHBTN0331','Jarwadi Hutapea','gabriella.hassanah@student.school.com','(+62) 329 4264 8619',13,'2009-01-14','male','Ki. Qrisdoren No. 394, Palopo 88665, DIY','Yuni Nuraini','0650 7343 1621',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(332,'MHBTN0332','Cakrajiya Widodo','marsito.cemani.ramadan@student.school.com','(+62) 897 7034 613',13,'2008-11-05','female','Jr. Kali No. 498, Palopo 79105, Riau','Caket Ramadan M.M.','0651 3805 454',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(333,'MHBTN0333','Vino Budiyanto','kawaya.ega.simanjuntak.s.ked@student.school.com','0912 7528 949',13,'2008-12-05','male','Ki. Baja Raya No. 166, Batam 61266, Jateng','Ivan Utama','(+62) 667 3355 720',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(334,'MHBTN0334','Zulfa Anggraini','umar.cawuk.latupono.s.ip@student.school.com','0209 6037 324',13,'2008-06-17','male','Ds. Mahakam No. 811, Mataram 57096, Bali','Syahrini Hana Haryanti','(+62) 441 2590 7020',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(335,'MHBTN0335','Salimah Aryani','oliva.wahyuni.s.gz@student.school.com','(+62) 795 7814 364',13,'2007-10-23','female','Kpg. Badak No. 428, Dumai 48927, Sulbar','Kajen Pangestu','(+62) 383 1476 6939',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(336,'MHBTN0336','Ega Pradana','cecep.sirait@student.school.com','0937 4543 4547',13,'2008-01-22','female','Gg. Yoga No. 528, Metro 51957, Maluku','Wawan Maryadi','0319 8712 2590',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(337,'MHBTN0337','Carla Lalita Rahmawati S.E.','ganep.kawaca.pradipta@student.school.com','0637 8381 2920',13,'2008-10-31','female','Kpg. Bacang No. 380, Batu 49037, Babel','Kacung Habibi','(+62) 327 5883 313',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(338,'MHBTN0338','Asman Suryono','enteng.thamrin@student.school.com','0867 028 972',13,'2008-04-07','male','Ds. Tubagus Ismail No. 23, Administrasi Jakarta Timur 37903, Kalteng','Zizi Handayani S.E.','0943 9068 574',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(339,'MHBTN0339','Sadina Padmasari','ganda.mandala@student.school.com','0531 2613 7627',13,'2008-01-11','male','Psr. Cikutra Timur No. 623, Yogyakarta 46921, DKI','Anita Hariyah','0706 5322 287',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(340,'MHBTN0340','Tira Farah Fujiati','opan.cengkal.marpaung@student.school.com','0950 2973 463',13,'2009-02-09','male','Ds. Baung No. 986, Gorontalo 81101, Sulsel','Warsa Maulana S.Kom','0658 9129 7331',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(341,'MHBTN0341','Faizah Kamaria Nasyiah','capa.pranawa.mandala.s.sos@student.school.com','(+62) 283 7713 7696',13,'2010-02-07','female','Dk. Mahakam No. 212, Subulussalam 86823, Sultra','Janet Hasanah S.Pt','(+62) 343 0724 8309',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(342,'MHBTN0342','Yani Hariyah S.Gz','vanesa.utami@student.school.com','(+62) 22 9864 3072',13,'2009-07-25','male','Kpg. Wahidin No. 897, Depok 35967, Kalteng','Nugraha Pradipta','0440 7187 1645',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(343,'MHBTN0343','Hartana Dariati Prabowo M.Pd','najwa.mandasari@student.school.com','0847 547 224',13,'2008-02-12','female','Dk. Sugiono No. 252, Tanjungbalai 34780, Papua','Cahyanto Jailani','0202 4615 991',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(344,'MHBTN0344','Galiono Prasetyo M.Ak','dimaz.danang.sinaga@student.school.com','(+62) 461 4146 4664',13,'2009-10-17','male','Ds. Bayan No. 685, Surakarta 45774, Sulsel','Wadi Wahyudin','(+62) 643 6431 668',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(345,'MHBTN0345','Viman Situmorang S.Ked','ana.hariyah@student.school.com','0840 766 643',13,'2007-09-26','male','Psr. Bakhita No. 445, Samarinda 53767, Jateng','Yosef Makara Dongoran','0837 2643 9809',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(346,'MHBTN0346','Lala Yolanda','gabriella.puspita@student.school.com','(+62) 710 7105 641',13,'2008-10-22','female','Ki. Basuki Rahmat  No. 834, Palangka Raya 63029, Kalteng','Dian Keisha Hassanah','0387 3456 3225',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(347,'MHBTN0347','Zamira Malika Andriani S.Gz','sakura.oktaviani@student.school.com','(+62) 582 2388 161',13,'2010-06-11','male','Jln. Tentara Pelajar No. 3, Sungai Penuh 88405, Sumbar','Lintang Nilam Mardhiyah','0889 2360 075',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(348,'MHBTN0348','Gaiman Saputra','nyana.saragih.s.kom@student.school.com','(+62) 811 1738 786',13,'2008-12-28','male','Jln. Haji No. 264, Padang 79489, Jateng','Rina Wastuti','(+62) 505 5955 4612',1,'2025-07-01 21:16:39','2025-07-01 21:16:39'),(349,'MHBTN0349','Lidya Rahmawati','tirta.rudi.permadi.m.farm@student.school.com','(+62) 491 0593 6139',13,'2008-05-12','female','Psr. Bappenas No. 9, Binjai 53858, Lampung','Martaka Maulana','(+62) 419 4610 379',1,'2025-07-01 21:16:39','2025-07-01 21:16:39');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,'MTK',NULL,'2025-05-18 02:46:25','2025-05-18 02:46:25'),(2,'Bahasa Indonesia','Indonesian Language','2025-05-18 20:10:41','2025-07-01 21:11:00'),(3,'Matematika','Mathematics','2025-07-01 21:11:00','2025-07-01 21:11:00'),(4,'Bahasa Inggris','English Language','2025-07-01 21:11:00','2025-07-01 21:11:00'),(5,'Fisika','Physics','2025-07-01 21:11:00','2025-07-01 21:11:00'),(6,'Kimia','Chemistry','2025-07-01 21:11:00','2025-07-01 21:11:00'),(7,'Biologi','Biology','2025-07-01 21:11:00','2025-07-01 21:11:00'),(8,'Sejarah','History','2025-07-01 21:11:00','2025-07-01 21:11:00'),(9,'Geografi','Geography','2025-07-01 21:11:00','2025-07-01 21:11:00'),(10,'Ekonomi','Economics','2025-07-01 21:11:00','2025-07-01 21:11:00'),(11,'Sosiologi','Sociology','2025-07-01 21:11:00','2025-07-01 21:11:00'),(12,'Pendidikan Jasmani','Physical Education','2025-07-01 21:11:00','2025-07-01 21:11:00'),(13,'Seni Budaya','Arts and Culture','2025-07-01 21:11:00','2025-07-01 21:11:00'),(14,'Pendidikan Agama','Religious Education','2025-07-01 21:11:00','2025-07-01 21:11:00'),(15,'PKn','Civic Education','2025-07-01 21:11:00','2025-07-01 21:11:00'),(16,'TIK','Information Technology','2025-07-01 21:11:00','2025-07-01 21:11:00');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `system_settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
INSERT INTO `system_settings` VALUES (1,'default_language','id','string','localization','Default system language','2025-07-01 21:37:23','2025-07-01 21:37:23');
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher_profiles`
--

DROP TABLE IF EXISTS `teacher_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teacher_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `education` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specialization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teacher_profiles_user_id_foreign` (`user_id`),
  CONSTRAINT `teacher_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher_profiles`
--

LOCK TABLES `teacher_profiles` WRITE;
/*!40000 ALTER TABLE `teacher_profiles` DISABLE KEYS */;
INSERT INTO `teacher_profiles` VALUES (1,2,NULL,NULL,'hy',NULL,'ruby xp',NULL,'2025-05-18 02:48:03','2025-05-18 02:48:03'),(2,5,'S2 Matematika',NULL,'Experienced teacher specializing in Mathematics Education',NULL,'Mathematics Education',NULL,'2025-07-01 21:11:01','2025-07-01 21:11:01'),(3,6,'S1 Pendidikan Bahasa Indonesia',NULL,'Experienced teacher specializing in Indonesian Language Education',NULL,'Indonesian Language Education',NULL,'2025-07-01 21:11:01','2025-07-01 21:11:01'),(4,7,'Master of Education',NULL,'Experienced teacher specializing in English Language Teaching',NULL,'English Language Teaching',NULL,'2025-07-01 21:11:02','2025-07-01 21:11:02'),(5,8,'S2 Fisika',NULL,'Experienced teacher specializing in Physics Education',NULL,'Physics Education',NULL,'2025-07-01 21:11:02','2025-07-01 21:11:02'),(6,9,'S1 Pendidikan Kimia',NULL,'Experienced teacher specializing in Chemistry Education',NULL,'Chemistry Education',NULL,'2025-07-01 21:11:03','2025-07-01 21:11:03'),(7,10,'S1 Pendidikan Biologi',NULL,'Experienced teacher specializing in Biology Education',NULL,'Biology Education',NULL,'2025-07-01 21:11:03','2025-07-01 21:11:03'),(8,11,'S1 Pendidikan Sejarah',NULL,'Experienced teacher specializing in History Education',NULL,'History Education',NULL,'2025-07-01 21:11:04','2025-07-01 21:11:04'),(9,12,'S1 Pendidikan Geografi',NULL,'Experienced teacher specializing in Geography Education',NULL,'Geography Education',NULL,'2025-07-01 21:11:04','2025-07-01 21:11:04');
/*!40000 ALTER TABLE `teacher_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher_subjects`
--

DROP TABLE IF EXISTS `teacher_subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teacher_subjects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `teacher_profile_id` bigint unsigned NOT NULL,
  `subject_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teacher_subjects_teacher_profile_id_subject_id_unique` (`teacher_profile_id`,`subject_id`),
  KEY `teacher_subjects_subject_id_foreign` (`subject_id`),
  CONSTRAINT `teacher_subjects_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `teacher_subjects_teacher_profile_id_foreign` FOREIGN KEY (`teacher_profile_id`) REFERENCES `teacher_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher_subjects`
--

LOCK TABLES `teacher_subjects` WRITE;
/*!40000 ALTER TABLE `teacher_subjects` DISABLE KEYS */;
INSERT INTO `teacher_subjects` VALUES (1,1,1,NULL,NULL),(2,2,3,NULL,NULL),(3,3,2,NULL,NULL),(4,4,4,NULL,NULL),(5,5,5,NULL,NULL),(6,6,6,NULL,NULL),(7,7,7,NULL,NULL),(8,8,8,NULL,NULL),(9,9,9,NULL,NULL),(10,1,16,NULL,NULL);
/*!40000 ALTER TABLE `teacher_subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teaching_sessions`
--

DROP TABLE IF EXISTS `teaching_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teaching_sessions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint unsigned NOT NULL,
  `subject_id` bigint unsigned NOT NULL,
  `class_room_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `start_location` json DEFAULT NULL,
  `end_location` json DEFAULT NULL,
  `start_location_valid` tinyint(1) NOT NULL DEFAULT '0',
  `end_location_valid` tinyint(1) NOT NULL DEFAULT '0',
  `start_device_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_device_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teaching_sessions_teacher_id_foreign` (`teacher_id`),
  KEY `teaching_sessions_subject_id_foreign` (`subject_id`),
  KEY `teaching_sessions_class_room_id_foreign` (`class_room_id`),
  CONSTRAINT `teaching_sessions_class_room_id_foreign` FOREIGN KEY (`class_room_id`) REFERENCES `class_rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `teaching_sessions_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `teaching_sessions_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teaching_sessions`
--

LOCK TABLES `teaching_sessions` WRITE;
/*!40000 ALTER TABLE `teaching_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `teaching_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','teacher') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'teacher',
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `device_info` json DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin@example.com',NULL,'$2y$12$dA1xUXFiL2z6col38zvvsOMipK3shgEKdPe3k/5d.s8/IAVhna7uy','admin',NULL,1,NULL,NULL,'2025-05-18 02:36:24','2025-05-18 02:36:24'),(2,'Sabil','teacher1@example.com',NULL,'$2y$12$IOXCj80mRRhb1eFbHZ0BXeSA4XJkltIODA2MXe7Luh1qruVpkJ0U2','teacher','08123456789',1,NULL,NULL,'2025-05-18 02:36:24','2025-05-18 02:47:40'),(3,'Jane Smith','teacher2@example.com',NULL,'$2y$12$EoqetuZDzpuKZOyiinCuCev9yS1XRAhShIcw9MQX1/0WGTCl67Lqi','teacher','08198765432',1,NULL,NULL,'2025-05-18 02:36:24','2025-05-18 02:36:24'),(4,'System Administrator','admin@attendance.com',NULL,'$2y$12$W0CbWhT9TKmwKopiuFJWxOwoWsikZwOX0HacCrU4YbE7253LlAgzm','admin','+62812345678901',1,NULL,NULL,'2025-07-01 21:11:00','2025-07-02 10:09:38'),(5,'Dr. Ahmad Fauzi','ahmad.fauzi@school.com',NULL,'$2y$12$OO/p9mzvhgDWvLJO4jZ4x.gzQzP7TBu6o6GlqOuVf7sp2Yq7msDIS','teacher','+6281234567001',1,NULL,NULL,'2025-07-01 21:11:01','2025-07-01 21:11:01'),(6,'Sari Dewi, S.Pd','sari.dewi@school.com',NULL,'$2y$12$MsbHDJiOg/JmMD/QZ2cwuesHutIfV561xVFKBY.z1WhTdVhbFFxoO','teacher','+6281234567002',1,NULL,NULL,'2025-07-01 21:11:01','2025-07-01 21:11:01'),(7,'John Smith, M.Ed','john.smith@school.com',NULL,'$2y$12$vLnGw3KJB.ozBcfZnu1i7.znDhurkR8RaXmIK8YOIjs6Ba9ae1Ss2','teacher','+6281234567003',1,NULL,NULL,'2025-07-01 21:11:02','2025-07-01 21:11:02'),(8,'Dr. Budi Santoso','budi.santoso@school.com',NULL,'$2y$12$oRFTuq7eiuxnT2RqtLxPgOismsNiiSKmEhwliSd2bWgElvBy4zLDO','teacher','+6281234567004',1,NULL,NULL,'2025-07-01 21:11:02','2025-07-02 00:40:57'),(9,'Maya Sari, S.Pd','maya.sari@school.com',NULL,'$2y$12$CQeNMvJ5NrN0R1/DebuvD.xS.u/f1IdfgeTU8rqDj1oUekqsOOnf.','teacher','+6281234567005',1,NULL,NULL,'2025-07-01 21:11:03','2025-07-01 21:11:03'),(10,'Rina Handayani, S.Pd','rina.handayani@school.com',NULL,'$2y$12$Qj1h3TtL/xjmH4KCXd4.uuNNMzvv.Xd7HqBjGQakwd9kKmJFN0lSe','teacher','+6281234567006',1,NULL,NULL,'2025-07-01 21:11:03','2025-07-01 21:11:03'),(11,'Agus Prakoso, S.Pd','agus.prakoso@school.com',NULL,'$2y$12$wzDrO6.unsOQo47u1SrgQ.f.NP.7wXfT65WAZ5NNxBv6TjA8.kEWW','teacher','+6281234567007',1,NULL,NULL,'2025-07-01 21:11:04','2025-07-01 21:11:04'),(12,'Lisa Permata, S.Pd','lisa.permata@school.com',NULL,'$2y$12$N/VKZRzfzFEdy9J/F1MTFOn/Mp.gsDq9OaNWSsDXOGwBSnzlD7yYW','teacher','+6281234567008',1,NULL,NULL,'2025-07-01 21:11:04','2025-07-01 21:11:04');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'abs'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-03  0:09:54
