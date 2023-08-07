-- MySQL dump 10.13  Distrib 8.0.33, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: inventory_system
-- ------------------------------------------------------
-- Server version	8.0.33-0ubuntu0.22.04.2

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
-- Current Database: `inventory_system`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `inventory_system` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `inventory_system`;

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `branches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branches`
--

LOCK TABLES `branches` WRITE;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` VALUES (1,'2023-05-05 07:33:16','2023-07-03 08:45:46',NULL,'Main Office 14','No 1 Nimo Street, Nkpor','1',1),(2,'2023-05-17 23:29:54','2023-07-03 08:46:51',NULL,'New Branch, Asaba','no 9 old, Asaba','1',1),(3,'2023-05-17 23:29:54','2023-05-17 23:29:54',NULL,'New Branch, EnuguAwka','no 9 old','1',1),(4,'2023-05-17 23:29:54','2023-07-03 08:49:19',NULL,'New Branch, Enugu','no 9 old, Enugu','1',1),(5,'2023-05-17 23:29:54','2023-05-17 23:29:54',NULL,'New Branch, Awka','no 9 old','1',1),(6,'2023-07-02 20:42:23','2023-07-02 22:29:00','2023-07-02 22:29:00','Ikenga','90 Old jjh Lagos Ibadan Lagos Ibadan','1',1),(7,'2023-07-02 20:44:49','2023-07-02 20:44:49',NULL,'Warehouse 4','kHHIi ggghh','1',1),(8,'2023-07-02 20:57:52','2023-07-03 08:22:40','2023-07-03 08:22:40','Hytr','klkl kksk Oppp','{\"name\":\"OKEKE CHINEMELU\",\"id\":\"1\"}',1);
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` tinytext COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin` bigint DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `registry_by_user` tinyint(1) DEFAULT '0',
  `subscript` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'2023-05-05 07:33:15','2023-05-05 07:33:15','Digital Plazas','No 1 Nimo Street, Nkpor','07026661376','storage/mQvktgPx8zQEvjyuDpCtM6v7JvW8SCvAfzjoFFVk.jpg','$',NULL,1,NULL,1,NULL);
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'2023-06-01 09:52:03','2023-06-09 09:47:11',NULL,'EMEKA CHIDIEBERE','07026661376','No 8 Enugu/Osha Old Road',1),(2,'2023-06-05 07:38:20','2023-06-09 09:53:08',NULL,'Malachy Odigwe','+2347068767407','RCC Estate',1),(3,'2023-06-07 00:38:40','2023-06-10 09:33:21',NULL,'Ogbonna CHIDIEBERE','+2347026661376','No 8 Enugu/Osha Old Road',1);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `employee` bigint DEFAULT NULL,
  `company_id` bigint DEFAULT NULL,
  `branch_id` bigint DEFAULT NULL,
  `registry_id` bigint DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `misc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` VALUES (1,'2023-06-18 11:02:34','2023-06-20 12:26:07','Fuel','snnd fo useh',2000.00,1,1,1,3,'expenses','Cash','','2023-06-20 12:26:07'),(2,'2023-06-18 11:28:36','2023-06-20 12:49:49','aerf',NULL,3455.00,1,1,1,3,'fund transfer to Company Account','Cheque','{\"acct_no\":\"000088877\",\"acct_name\":\"wrrr\",\"bank\":\"2334\"}','2023-06-20 12:49:49'),(3,'2023-06-19 10:08:57','2023-06-24 10:23:36','Transfer','{\"acct_no\":\"1900999009\",\"acct_name\":\"Ebuka Nwokolo\",\"bank\":\"Malachy Odigwe\"}',9000.00,1,1,1,3,'fund transfer to Individual','Bank',NULL,'2023-06-24 10:23:36'),(4,'2023-06-19 10:26:30','2023-06-20 12:24:37',NULL,NULL,NULL,1,1,1,3,'expenses',NULL,'\"\"','2023-06-20 12:24:37'),(5,'2023-06-19 10:32:01','2023-06-19 10:32:01','Sad','DFRR',3445.00,1,1,1,3,'expenses','Cash','\"\"',NULL),(6,'2023-06-19 10:33:06','2023-06-19 10:33:06','To Emeka','fund transfer to Individual 0984122(8484949)',9000.00,1,1,1,3,'fund Transfer','Bank','{\"acct_no\":\"8484949\",\"acct_name\":\"0984122\",\"bank\":\"4499404044\"}',NULL),(7,'2023-06-19 10:33:49','2023-06-24 10:23:30','3444','fund transfer to null null()',5677.00,1,1,1,3,'fund Transfer',NULL,'{\"acct_no\":null,\"acct_name\":null,\"bank\":null}','2023-06-24 10:23:30'),(8,'2023-06-20 10:24:29','2023-06-20 12:22:39','Hew','fund transfer to Company Account - Maytt (099898968)',90000.00,1,1,1,3,'fund transfer','Cheque','{\"acct_no\":\"099898968\",\"acct_name\":\"Maytt\",\"bank\":\"Creaa BBHGH\"}','2023-06-20 12:22:39'),(9,'2023-06-21 07:53:48','2023-06-21 07:53:48','gtrre','gtff',900.00,1,1,1,3,'expenses','Bank','\"\"',NULL);
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
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
-- Table structure for table `incomes`
--

DROP TABLE IF EXISTS `incomes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incomes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `employee` bigint DEFAULT NULL,
  `company_id` bigint DEFAULT NULL,
  `branch_id` bigint DEFAULT NULL,
  `registry_id` bigint DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `misc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incomes`
--

LOCK TABLES `incomes` WRITE;
/*!40000 ALTER TABLE `incomes` DISABLE KEYS */;
INSERT INTO `incomes` VALUES (1,'2023-06-18 10:49:18','2023-06-18 10:49:18','asa','sdfff',23400.00,1,1,1,3,'other income','Bank','',NULL),(2,'2023-06-18 11:00:39','2023-06-18 11:00:39','Her','nnsjsj kmn,mm',78.00,1,1,1,3,'other income','Cheque','',NULL),(3,'2023-06-19 08:19:05','2023-06-19 08:19:05','oh','jjj',90.00,1,1,1,3,'other income','Cash','',NULL),(4,'2023-06-19 10:32:22','2023-06-19 10:32:22','Expe','addd dfkfkf',234.00,1,1,1,3,'other income','Cash','',NULL),(5,'2023-06-20 10:42:47','2023-06-21 00:40:23','hyt','hhhjh',89.00,1,1,1,3,'other income','Bank','','2023-06-21 00:40:23');
/*!40000 ALTER TABLE `incomes` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_02_04_163502_create_products_table',1),(6,'2023_02_04_163534_create_stocks_table',1),(7,'2023_02_04_163554_create_sales_table',1),(8,'2023_02_04_163929_create_customers_table',1),(9,'2023_02_05_050829_create_branches_table',1),(10,'2023_03_23_152027_create_companies_table',1),(11,'2023_04_26_114657_update_columns_sales_table',1),(12,'2023_05_05_043202_orders',1),(13,'2023_05_05_100638_create_product_prices_table',2),(15,'2023_06_10_104927_create_transactions_table',2),(16,'2023_06_10_105422_create_expenses_table',2),(17,'2023_06_10_105440_create_incomes_table',2),(18,'2023_06_11_135743_create_returns_table',2),(19,'2023_06_10_104621_create_registries_table',3),(20,'2023_06_27_161450_create_subscriptions_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `order_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'status 1 = ordered, 2 = paid, 3 = supplied',
  `user_id` bigint DEFAULT NULL COMMENT 'the sales personnel',
  `customer_id` bigint DEFAULT NULL COMMENT 'customer detail',
  `company_id` bigint DEFAULT NULL,
  `total` double(20,5) DEFAULT NULL,
  `amount_paid` double(20,5) DEFAULT NULL,
  `remainder` double(20,5) DEFAULT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `total_payable` double(20,5) DEFAULT NULL,
  `payments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'cash, card/pos, banktransfer',
  `branch_id` bigint DEFAULT NULL,
  `registry_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_no_unique` (`order_no`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (3,'2023-06-07 00:38:40','2023-06-07 00:38:40',NULL,'#1111686101920586','#2000','paid',1,3,1,30540.00000,30540.00000,0.00000,NULL,NULL,'{\"cash\":\"540\",\"bank\":\"30000\",\"pos\":null}',1,3),(4,'2023-06-07 00:43:14','2023-06-07 00:43:14',NULL,'#1111686102194216','#123000','paid',1,1,1,5650.00000,5600.00000,-0.85000,0.90,NULL,'{\"cash\":\"4700\",\"bank\":\"900\",\"pos\":null}',1,3),(5,'2023-06-07 10:25:44','2023-06-07 10:25:44',NULL,'#1111686137141095','#00990','paid',1,1,1,4980.00000,4980.00000,0.00000,NULL,NULL,'{\"cash\":\"4980\",\"bank\":null,\"pos\":null}',1,3),(6,'2023-06-08 14:39:26','2023-06-08 14:39:26',NULL,'#1111,686',NULL,'paid',1,3,1,4240.00000,12300.00000,-8060.00000,NULL,NULL,'{\"cash\":null,\"bank\":\"12300\",\"pos\":null}',1,3),(7,'2023-06-08 14:44:38','2023-06-08 14:44:38',NULL,'#11116862',NULL,'paid',1,1,1,5010.00000,5010.00000,0.00000,NULL,NULL,'{\"cash\":\"5010\",\"bank\":null,\"pos\":null}',1,3),(9,'2023-06-08 16:18:41','2023-06-08 16:18:41',NULL,'16862',NULL,'paid',1,3,1,660.00000,788.00000,-128.00000,NULL,NULL,'{\"cash\":null,\"bank\":\"788\",\"pos\":null}',1,3),(10,'2023-06-09 09:22:20','2023-06-09 09:22:20',NULL,'#11130613',NULL,'pending',1,3,1,10800.00000,0.00000,10800.00000,NULL,NULL,'{\"cash\":null,\"bank\":null,\"pos\":null}',1,3),(11,'2023-06-09 09:25:46','2023-06-09 09:25:46',NULL,'#11130634',NULL,'paid',1,3,1,2100.00000,2100.00000,0.00000,NULL,NULL,'{\"cash\":null,\"bank\":\"2100\",\"pos\":null}',1,3),(12,'2023-06-09 09:30:47','2023-06-09 09:30:47',NULL,'#11130664',NULL,'pending',1,1,1,430.00000,80.00000,345.70000,1.00,NULL,'{\"cash\":\"80\",\"bank\":null,\"pos\":null}',1,3),(13,'2023-06-09 09:36:40','2023-06-09 09:36:40',NULL,'#11130699',NULL,'pending',1,1,1,250.00000,0.00000,250.00000,NULL,NULL,'{\"cash\":null,\"bank\":null,\"pos\":null}',1,3),(14,'2023-06-09 09:37:53','2023-06-09 09:37:53',NULL,'#11130707',NULL,'pending',1,3,1,8240.00000,23.00000,8217.00000,NULL,NULL,'{\"cash\":null,\"bank\":\"23\",\"pos\":null}',1,3),(15,'2023-06-09 09:41:02','2023-06-09 09:41:02',NULL,'#11130726',NULL,'paid',1,1,1,990.00000,1000.00000,-10.00000,NULL,NULL,'{\"cash\":null,\"bank\":\"1000\",\"pos\":null}',1,3),(16,'2023-06-09 09:47:11','2023-06-09 09:47:11',NULL,'#11130763',NULL,'pending',1,1,1,140.00000,0.00000,138.60000,1.00,NULL,'{\"cash\":null,\"bank\":null,\"pos\":null}',1,3),(17,'2023-06-09 09:51:35','2023-06-09 09:51:35',NULL,'#11130789','#','pending',1,3,1,660.00000,0.00000,660.00000,0.00,NULL,'{\"cash\":null,\"bank\":null,\"pos\":null}',1,3),(18,'2023-06-09 09:52:01','2023-06-09 09:52:01',NULL,'#11130792','#','paid',1,3,1,420.00000,420.00000,0.00000,0.00,NULL,'{\"cash\":\"420\",\"bank\":null,\"pos\":null}',1,3),(19,'2023-06-09 09:53:08','2023-06-09 09:53:08',NULL,'#11130798','#','paid',1,2,1,11200.00000,11200.00000,0.00000,0.00,NULL,'{\"bank\":null,\"pos\":\"11200\"}',1,3),(20,'2023-06-09 10:03:20','2023-06-09 10:03:20',NULL,'#11130860','#','paid',1,3,1,3450.00000,3450.00000,0.00000,0.00,NULL,'{\"cash\":\"3450\",\"bank\":null,\"pos\":null}',1,3),(21,'2023-06-09 10:03:57','2023-06-09 10:03:57',NULL,'#11130863','#','pending',1,3,1,10800.00000,7800.00000,3000.00000,0.00,NULL,'{\"cash\":\"7800\",\"bank\":null,\"pos\":null}',1,3),(22,'2023-06-09 10:14:10','2023-06-09 10:14:10',NULL,'#11130925','#','paid',1,1,1,9660.00000,9660.00000,0.00000,0.00,NULL,'{\"cash\":null,\"bank\":null,\"pos\":\"9660\"}',1,3),(23,'2023-06-09 10:14:41','2023-06-09 10:14:41',NULL,'#11130928','#','pending',1,3,1,9660.00000,90.00000,9570.00000,0.00,NULL,'{\"cash\":null,\"bank\":null,\"pos\":\"90\"}',1,3),(24,'2023-06-10 09:33:21','2023-06-10 09:33:21',NULL,'#11139319','#','pending',1,3,1,1560.00000,890.00000,670.00000,0.00,NULL,'{\"cash\":null,\"bank\":\"890\",\"pos\":null}',1,3);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (19,'App\\Models\\User',1,'auth_token','74b492d71cb0b11c28e71f1eba7c6765ab227d5363b1572f96e44bb361a4e0a7','[\"*\"]','2023-07-03 09:32:16',NULL,'2023-06-02 12:57:20','2023-07-03 09:32:16');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_prices`
--

DROP TABLE IF EXISTS `product_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_prices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `costprice` double(15,2) DEFAULT NULL,
  `sellingprice` double(15,2) DEFAULT NULL,
  `product_id` bigint unsigned NOT NULL,
  `branch_id` bigint unsigned NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `brief_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `ended_by` bigint unsigned NOT NULL,
  `status` int DEFAULT NULL COMMENT '1 == active, 2 == suspended',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_prices`
--

LOCK TABLES `product_prices` WRITE;
/*!40000 ALTER TABLE `product_prices` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sellingprice` int DEFAULT NULL,
  `costprice` int DEFAULT NULL,
  `alert_level` int DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int DEFAULT NULL,
  `units` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'2023-05-05 07:59:24','2023-06-03 14:43:24',NULL,'Product 1','PRE-090',120,100,20,1,'public/products/7T0CqfDkPagEa75FRWqjWxU3LZtKdpOpVk1fGspV.jpg',2,'yards'),(2,'2023-05-05 08:39:41','2023-06-03 13:04:24',NULL,'Second','asd',30,10,10,1,'',1,'pcs'),(3,'2023-05-05 09:50:07','2023-06-01 13:13:43',NULL,'Second','asd',50,34,10,1,'',1,'pcs'),(4,'2023-05-05 11:23:13','2023-06-03 15:06:01',NULL,'Second 24','asd',200,10,10,1,NULL,1,'pcs'),(5,'2023-06-02 09:35:20','2023-06-03 13:10:45',NULL,'Second 212','asd',200,10,10,1,NULL,1,'pcs'),(6,'2023-06-02 09:38:00','2023-06-02 09:38:00',NULL,'Second','asd',50,34,10,1,'',1,'pcs'),(7,'2023-06-02 09:40:04','2023-06-03 15:01:04',NULL,'Second','asd',50,34,10,1,'public/products/rFdR03tShilElO7Hd3aTwWrFbGSkh82kydHmtsQH.jpg',1,'pcs'),(8,'2023-06-05 01:56:05','2023-06-05 01:56:05',NULL,'hgt','uyr',900,890,989,1,'public/products/kcuTHR79Q4b3E4IpRWPTJCKZ1G5c3j2205d8KPTI.jpg',NULL,'m');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registries`
--

DROP TABLE IF EXISTS `registries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_id` bigint DEFAULT NULL,
  `branch_id` bigint DEFAULT NULL,
  `cash_sales` double(8,2) DEFAULT NULL,
  `opened_by` bigint DEFAULT NULL,
  `closed_by` bigint DEFAULT NULL,
  `time_opened` datetime DEFAULT NULL,
  `time_closed` datetime DEFAULT NULL,
  `opening_amt` double(8,2) DEFAULT '0.00',
  `closing_amt` double(8,2) DEFAULT '0.00',
  `reg_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `total_exp` double(8,2) DEFAULT '0.00',
  `total_income` double(8,2) DEFAULT '0.00',
  `total_sales` double(8,2) DEFAULT '0.00',
  `bank_sales` double(8,2) DEFAULT '0.00',
  `cheque_sales` double(8,2) DEFAULT '0.00',
  `debts` double(8,2) DEFAULT '0.00',
  `receive_payments` double(8,2) DEFAULT '0.00',
  `returns` double(8,2) DEFAULT '0.00',
  `transfer` double(8,2) DEFAULT '0.00',
  `closing_note` double(8,2) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `opening_note` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expenses` float DEFAULT '0',
  `status` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registries`
--

LOCK TABLES `registries` WRITE;
/*!40000 ALTER TABLE `registries` DISABLE KEYS */;
INSERT INTO `registries` VALUES (1,'2023-06-27 06:53:25','2023-06-27 06:53:25',1,1,NULL,1,NULL,'2023-06-27 00:00:00',NULL,0.00,0.00,'#7852405',0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,NULL,NULL,'sdf',0,0),(2,'2023-06-27 07:24:46','2023-06-27 13:14:52',1,1,0.00,1,1,'2023-06-27 00:00:00','2023-06-27 08:25:23',1300.00,1300.00,'#7854286',0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,NULL,NULL,'hyt',0,1),(3,'2023-06-27 12:32:55','2023-06-27 13:16:50',1,1,NULL,1,NULL,'2023-06-30 00:00:00',NULL,1200.00,1200.00,'#7872775',0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,NULL,NULL,'Fraeeaera',0,0);
/*!40000 ALTER TABLE `registries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `returns`
--

DROP TABLE IF EXISTS `returns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `returns` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_id` bigint DEFAULT NULL,
  `company_id` bigint DEFAULT NULL,
  `branch_id` bigint DEFAULT NULL,
  `employee` bigint DEFAULT NULL,
  `approved_by` bigint DEFAULT NULL,
  `customer_id` bigint DEFAULT NULL,
  `order_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'goods returned and qty',
  `registry_id` bigint DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `returns`
--

LOCK TABLES `returns` WRITE;
/*!40000 ALTER TABLE `returns` DISABLE KEYS */;
/*!40000 ALTER TABLE `returns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `product_id` bigint DEFAULT NULL,
  `qty` double(13,4) DEFAULT NULL,
  `price` double(13,4) DEFAULT NULL,
  `cost_price` double(13,4) DEFAULT NULL,
  `order_id` bigint DEFAULT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint DEFAULT NULL,
  `branch_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (5,'2023-06-07 00:38:41','2023-06-07 00:38:41',NULL,5,90.0000,200.0000,10.0000,3,'#2000',1,1),(6,'2023-06-07 00:38:41','2023-06-07 00:38:41',NULL,3,90.0000,50.0000,34.0000,3,'#2000',1,1),(7,'2023-06-07 00:38:41','2023-06-07 00:38:41',NULL,1,67.0000,120.0000,100.0000,3,'#2000',1,1),(8,'2023-06-07 00:43:14','2023-06-07 00:43:14',NULL,6,90.0000,50.0000,34.0000,4,'#123000',1,1),(9,'2023-06-07 00:43:14','2023-06-07 00:43:14',NULL,7,23.0000,50.0000,34.0000,4,'#123000',1,1),(10,'2023-06-07 10:25:45','2023-06-07 10:25:45',NULL,2,10.0000,30.0000,10.0000,5,'#00990',1,1),(11,'2023-06-07 10:25:45','2023-06-07 10:25:45',NULL,3,12.0000,50.0000,34.0000,5,'#00990',1,1),(12,'2023-06-07 10:25:45','2023-06-07 10:25:45',NULL,1,34.0000,120.0000,100.0000,5,'#00990',1,1),(13,'2023-06-08 14:39:27','2023-06-08 14:39:27',NULL,1,12.0000,120.0000,100.0000,6,NULL,1,1),(14,'2023-06-08 14:39:27','2023-06-08 14:39:27',NULL,3,56.0000,50.0000,34.0000,6,NULL,1,1),(15,'2023-06-08 14:44:38','2023-06-08 14:44:38',NULL,1,23.0000,120.0000,100.0000,7,NULL,1,1),(16,'2023-06-08 14:44:38','2023-06-08 14:44:38',NULL,3,45.0000,50.0000,34.0000,7,NULL,1,1),(17,'2023-06-08 16:18:41','2023-06-08 16:18:41',NULL,1,4.0000,120.0000,100.0000,9,NULL,1,1),(18,'2023-06-08 16:18:41','2023-06-08 16:18:41',NULL,2,6.0000,30.0000,10.0000,9,NULL,1,1),(19,'2023-06-09 09:22:21','2023-06-09 09:22:21',NULL,1,90.0000,120.0000,100.0000,10,NULL,1,1),(20,'2023-06-09 09:25:46','2023-06-09 09:25:46',NULL,4,8.0000,200.0000,10.0000,11,NULL,1,1),(21,'2023-06-09 09:25:46','2023-06-09 09:25:46',NULL,3,10.0000,50.0000,34.0000,11,NULL,1,1),(22,'2023-06-09 09:30:48','2023-06-09 09:30:48',NULL,2,6.0000,30.0000,10.0000,12,NULL,1,1),(23,'2023-06-09 09:30:48','2023-06-09 09:30:48',NULL,3,5.0000,50.0000,34.0000,12,NULL,1,1),(24,'2023-06-09 09:36:40','2023-06-09 09:36:40',NULL,2,5.0000,30.0000,10.0000,13,NULL,1,1),(25,'2023-06-09 09:36:40','2023-06-09 09:36:40',NULL,3,2.0000,50.0000,34.0000,13,NULL,1,1),(26,'2023-06-09 09:37:53','2023-06-09 09:37:53',NULL,1,12.0000,120.0000,100.0000,14,NULL,1,1),(27,'2023-06-09 09:37:54','2023-06-09 09:37:54',NULL,4,34.0000,200.0000,10.0000,14,NULL,1,1),(28,'2023-06-09 09:41:02','2023-06-09 09:41:02',NULL,1,1.0000,120.0000,100.0000,15,NULL,1,1),(29,'2023-06-09 09:41:02','2023-06-09 09:41:02',NULL,4,3.0000,200.0000,10.0000,15,NULL,1,1),(30,'2023-06-09 09:41:03','2023-06-09 09:41:03',NULL,2,9.0000,30.0000,10.0000,15,NULL,1,1),(31,'2023-06-09 09:47:11','2023-06-09 09:47:11',NULL,2,3.0000,30.0000,10.0000,16,NULL,1,1),(32,'2023-06-09 09:47:12','2023-06-09 09:47:12',NULL,3,1.0000,50.0000,34.0000,16,NULL,1,1),(33,'2023-06-09 09:51:35','2023-06-09 09:51:35',NULL,2,9.0000,30.0000,10.0000,17,'#',1,1),(34,'2023-06-09 09:51:35','2023-06-09 09:51:35',NULL,1,2.0000,120.0000,100.0000,17,'#',1,1),(35,'2023-06-09 09:51:35','2023-06-09 09:51:35',NULL,3,3.0000,50.0000,34.0000,17,'#',1,1),(36,'2023-06-09 09:52:01','2023-06-09 09:52:01',NULL,2,2.0000,30.0000,10.0000,18,'#',1,1),(37,'2023-06-09 09:52:01','2023-06-09 09:52:01',NULL,1,3.0000,120.0000,100.0000,18,'#',1,1),(38,'2023-06-09 09:53:08','2023-06-09 09:53:08',NULL,1,90.0000,120.0000,100.0000,19,'#',1,1),(39,'2023-06-09 09:53:09','2023-06-09 09:53:09',NULL,4,2.0000,200.0000,10.0000,19,'#',1,1),(40,'2023-06-09 10:03:20','2023-06-09 10:03:20',NULL,1,23.0000,120.0000,100.0000,20,'#',1,1),(41,'2023-06-09 10:03:21','2023-06-09 10:03:21',NULL,2,8.0000,30.0000,10.0000,20,'#',1,1),(42,'2023-06-09 10:03:21','2023-06-09 10:03:21',NULL,3,9.0000,50.0000,34.0000,20,'#',1,1),(43,'2023-06-09 10:03:58','2023-06-09 10:03:58',NULL,1,90.0000,120.0000,100.0000,21,'#',1,1),(44,'2023-06-09 10:14:10','2023-06-09 10:14:10',NULL,1,80.0000,120.0000,100.0000,22,'#',1,1),(45,'2023-06-09 10:14:11','2023-06-09 10:14:11',NULL,2,2.0000,30.0000,10.0000,22,'#',1,1),(46,'2023-06-09 10:14:41','2023-06-09 10:14:41',NULL,1,80.0000,120.0000,100.0000,23,'#',1,1),(47,'2023-06-09 10:14:41','2023-06-09 10:14:41',NULL,2,2.0000,30.0000,10.0000,23,'#',1,1),(48,'2023-06-10 09:33:21','2023-06-10 09:33:21',NULL,1,12.0000,120.0000,100.0000,24,'#',1,1),(49,'2023-06-10 09:33:21','2023-06-10 09:33:21',NULL,2,4.0000,30.0000,10.0000,24,'#',1,1);
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stocks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `qty` double(13,4) DEFAULT NULL,
  `type` int DEFAULT NULL COMMENT '1 ==> stock, 2 ==> transfer, 3 ==> removal',
  `branch_id` bigint DEFAULT NULL,
  `company_id` bigint DEFAULT NULL,
  `registered_by` bigint DEFAULT NULL,
  `received_by` bigint DEFAULT NULL,
  `brief_note` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `stockId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from` bigint DEFAULT NULL COMMENT 'branch stock was transferred from',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES (1,'2023-05-05 08:01:28','2023-05-05 14:19:46','2023-05-05 14:19:46',1,8000.0000,1,1,1,1,NULL,NULL,1,'#120230505',NULL),(2,'2023-05-05 08:42:17','2023-05-05 08:42:17',NULL,2,70.0000,1,2,1,1,NULL,NULL,1,'#120230505',NULL),(3,'2023-05-05 08:42:17','2023-05-05 13:53:42',NULL,1,300.0000,1,2,1,1,NULL,'what',1,'#120230505',NULL),(4,'2023-05-05 08:43:41','2023-05-05 08:43:41',NULL,1,300.0000,1,1,1,1,NULL,NULL,1,'#120230505',NULL),(5,'2023-05-05 08:43:42','2023-05-05 08:43:42',NULL,2,70.0000,1,1,1,1,NULL,NULL,1,'#120230505',NULL),(6,'2023-05-05 08:49:42','2023-05-17 21:52:21',NULL,1,2000.0000,3,1,1,1,NULL,'reason',1,'#120230505',NULL),(7,'2023-05-05 10:05:34','2023-05-05 10:05:34',NULL,1,70.0000,1,2,1,1,NULL,NULL,1,'#120230505',NULL),(8,'2023-05-05 10:05:34','2023-05-05 10:05:34',NULL,2,80.0000,1,2,1,1,NULL,NULL,1,'#120230505',NULL),(9,'2023-05-05 11:54:35','2023-05-07 01:53:10',NULL,2,120.0000,1,1,1,1,NULL,'Fro loss',1,'#120230505',NULL),(10,'2023-05-05 14:25:40','2023-05-06 11:40:49','2023-05-06 11:40:49',1,800.0000,1,1,1,1,NULL,NULL,1,'#120230505',NULL),(11,'2023-05-05 14:25:40','2023-05-05 14:25:40',NULL,3,500.0000,1,1,1,1,NULL,NULL,1,'#120230505',NULL),(12,'2023-05-07 01:33:30','2023-05-07 01:33:30',NULL,4,-70.0000,1,1,1,1,NULL,NULL,1,'#120230507',NULL),(13,'2023-05-07 01:33:30','2023-05-12 11:17:58','2023-05-12 11:17:58',4,700.0000,2,2,1,1,NULL,'What is this',1,'#120230507',1),(14,'2023-05-12 10:54:22','2023-05-12 10:54:22',NULL,3,567.0000,1,2,1,1,NULL,'free',1,'#120230512',NULL),(15,'2023-05-12 10:54:22','2023-05-12 10:54:22',NULL,1,344.0000,1,2,1,1,NULL,'free',1,'#120230512',NULL),(16,'2023-05-12 10:55:45','2023-05-12 10:55:45',NULL,4,90.0000,1,3,1,1,NULL,'hyt',1,'#120230512',NULL),(17,'2023-05-12 10:57:39','2023-05-12 11:01:57','2023-05-12 11:01:57',2,0.0000,3,1,1,1,NULL,'treggg',1,'#120230512',NULL),(18,'2023-05-17 10:19:39','2023-05-17 10:19:39',NULL,1,-32.0000,1,1,1,1,NULL,'sew',3,'#120230517',NULL),(19,'2023-05-17 10:19:39','2023-05-17 10:19:39',NULL,1,32.0000,2,2,1,1,NULL,'sew',0,'#120230517',1),(20,'2023-05-17 10:19:39','2023-05-17 10:19:39',NULL,3,-56.0000,1,1,1,1,NULL,'sew',3,'#120230517',NULL),(21,'2023-05-17 10:19:39','2023-05-17 10:19:39',NULL,3,56.0000,2,2,1,1,NULL,'sew',0,'#120230517',1),(22,'2023-05-17 10:19:39','2023-05-17 10:19:39',NULL,2,-423.0000,1,1,1,1,NULL,'sew',3,'#120230517',NULL),(23,'2023-05-17 10:19:39','2023-05-17 10:19:39',NULL,2,423.0000,2,2,1,1,NULL,'sew',0,'#120230517',1),(24,'2023-05-17 10:19:40','2023-05-17 10:19:40',NULL,4,-34.0000,1,1,1,1,NULL,'sew',3,'#120230517',NULL),(25,'2023-05-17 10:19:40','2023-05-17 10:19:40',NULL,4,34.0000,2,2,1,1,NULL,'sew',0,'#120230517',1),(26,'2023-05-17 10:42:36','2023-05-17 21:45:22',NULL,2,567.0000,1,1,1,1,NULL,'Awaer Game',1,'#120230517',NULL),(27,'2023-05-17 11:03:28','2023-05-17 21:38:21','2023-05-17 21:38:21',2,12.0000,1,1,1,1,NULL,'waw',1,'#120230517',NULL),(28,'2023-05-17 11:03:29','2023-05-17 11:03:29',NULL,4,46.0000,1,1,1,1,NULL,'waw',1,'#120230517',NULL),(29,'2023-05-17 22:22:20','2023-05-17 22:22:20',NULL,2,-70.0000,1,1,1,1,NULL,'treansfer',3,'#0120230517000000',NULL),(30,'2023-05-17 22:22:20','2023-05-17 22:22:20',NULL,2,70.0000,2,2,1,1,NULL,'treansfer',0,'#0120230517000000',1),(31,'2023-05-21 15:01:43','2023-05-21 15:01:43',NULL,2,-889.0000,3,1,1,1,NULL,'frt',1,'#120230521',NULL),(32,'2023-06-01 12:14:41','2023-06-01 12:14:41',NULL,2,50.0000,1,3,1,1,NULL,'Haksu',1,'#120230601',NULL),(33,'2023-06-01 12:14:41','2023-06-01 12:14:41',NULL,1,20.0000,1,3,1,1,NULL,'Haksu',1,'#120230601',NULL),(34,'2023-06-01 12:27:20','2023-06-01 14:35:43',NULL,1,900.0000,1,3,1,1,NULL,'Haoo',1,'#120230601',NULL),(35,'2023-06-01 12:52:37','2023-06-01 12:52:37',NULL,1,-34.0000,1,2,1,1,NULL,'Made due to emergency',3,'#1202306011352',NULL),(36,'2023-06-01 12:52:37','2023-06-01 12:52:37',NULL,1,34.0000,2,4,1,1,NULL,'Made due to emergency',0,'#1202306011352',2),(37,'2023-06-01 12:52:37','2023-06-01 12:52:37',NULL,3,-56.0000,1,2,1,1,NULL,'Made due to emergency',3,'#1202306011352',NULL),(38,'2023-06-01 12:52:38','2023-06-01 12:52:38',NULL,3,56.0000,2,4,1,1,NULL,'Made due to emergency',0,'#1202306011352',2),(39,'2023-06-01 12:56:20','2023-06-01 12:56:20',NULL,1,-5.0000,3,1,1,1,NULL,'oh',1,'#120230601',NULL),(40,'2023-06-01 12:56:41','2023-06-01 12:56:41',NULL,2,-56.0000,3,1,1,1,NULL,'ha',1,'#120230601',NULL),(41,'2023-06-02 10:12:15','2023-06-02 10:12:15',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL),(42,'2023-06-02 10:16:28','2023-06-02 10:16:28',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL),(43,'2023-06-02 10:18:36','2023-06-02 10:18:36',NULL,1,70.0000,1,1,1,1,NULL,NULL,1,'#116857',NULL),(44,'2023-06-03 13:10:45','2023-06-03 13:10:45',NULL,5,40.0000,1,1,1,1,NULL,NULL,1,'#116858',NULL),(45,'2023-06-05 01:56:05','2023-06-07 00:17:55',NULL,8,20.0000,1,1,1,1,NULL,NULL,1,'#116859',NULL),(46,'2023-06-07 00:36:39','2023-06-07 00:36:39',NULL,2,200.0000,1,3,1,1,NULL,'Htre',1,'#116861',NULL),(47,'2023-06-08 14:39:27','2023-06-08 14:39:27',NULL,NULL,-12.0000,1,1,1,1,NULL,'sales',3,'#1202306081539',NULL),(48,'2023-06-08 14:39:27','2023-06-08 14:39:27',NULL,NULL,-56.0000,1,1,1,1,NULL,'sales',3,'#1202306081539',NULL),(49,'2023-06-08 14:44:38','2023-06-08 14:44:38',NULL,NULL,-23.0000,1,1,1,1,NULL,'sales',3,'#1202306081544',NULL),(50,'2023-06-08 14:44:39','2023-06-08 14:44:39',NULL,NULL,-45.0000,1,1,1,1,NULL,'sales',3,'#1202306081544',NULL),(51,'2023-06-08 14:50:32','2023-06-08 14:50:32',NULL,5,300.0000,1,1,1,1,NULL,NULL,1,'#116862',NULL),(52,'2023-06-08 16:18:41','2023-06-08 16:18:41',NULL,NULL,-4.0000,1,1,1,1,NULL,'sales',3,'#1202306081718',NULL),(53,'2023-06-08 16:18:41','2023-06-08 16:18:41',NULL,NULL,-6.0000,1,1,1,1,NULL,'sales',3,'#1202306081718',NULL),(54,'2023-06-09 09:22:21','2023-06-09 09:22:21',NULL,NULL,-90.0000,1,1,1,1,NULL,'sales',3,'#1202306091022',NULL),(55,'2023-06-09 09:25:46','2023-06-09 09:25:46',NULL,NULL,-8.0000,1,1,1,1,NULL,'sales',3,'#1202306091025',NULL),(56,'2023-06-09 09:25:47','2023-06-09 09:25:47',NULL,NULL,-10.0000,1,1,1,1,NULL,'sales',3,'#1202306091025',NULL),(57,'2023-06-09 09:30:48','2023-06-09 09:30:48',NULL,NULL,-6.0000,1,1,1,1,NULL,'sales',3,'#1202306091030',NULL),(58,'2023-06-09 09:30:48','2023-06-09 09:30:48',NULL,NULL,-5.0000,1,1,1,1,NULL,'sales',3,'#1202306091030',NULL),(59,'2023-06-09 09:36:40','2023-06-09 09:36:40',NULL,NULL,-5.0000,1,1,1,1,NULL,'sales',3,'#1202306091036',NULL),(60,'2023-06-09 09:36:40','2023-06-09 09:36:40',NULL,NULL,-2.0000,1,1,1,1,NULL,'sales',3,'#1202306091036',NULL),(61,'2023-06-09 09:37:54','2023-06-09 09:37:54',NULL,NULL,-12.0000,1,1,1,1,NULL,'sales',3,'#1202306091037',NULL),(62,'2023-06-09 09:37:54','2023-06-09 09:37:54',NULL,NULL,-34.0000,1,1,1,1,NULL,'sales',3,'#1202306091037',NULL),(63,'2023-06-09 09:41:02','2023-06-09 09:41:02',NULL,NULL,-1.0000,1,1,1,1,NULL,'sales',3,'#1202306091041',NULL),(64,'2023-06-09 09:41:02','2023-06-09 09:41:02',NULL,NULL,-3.0000,1,1,1,1,NULL,'sales',3,'#1202306091041',NULL),(65,'2023-06-09 09:41:03','2023-06-09 09:41:03',NULL,NULL,-9.0000,1,1,1,1,NULL,'sales',3,'#1202306091041',NULL),(66,'2023-06-09 09:47:12','2023-06-09 09:47:12',NULL,NULL,-3.0000,1,1,1,1,NULL,'sales',3,'#1202306091047',NULL),(67,'2023-06-09 09:47:12','2023-06-09 09:47:12',NULL,NULL,-1.0000,1,1,1,1,NULL,'sales',3,'#1202306091047',NULL),(68,'2023-06-09 09:51:35','2023-06-09 09:51:35',NULL,NULL,-9.0000,1,1,1,1,NULL,'sales',3,'#1202306091051',NULL),(69,'2023-06-09 09:51:35','2023-06-09 09:51:35',NULL,NULL,-2.0000,1,1,1,1,NULL,'sales',3,'#1202306091051',NULL),(70,'2023-06-09 09:51:35','2023-06-09 09:51:35',NULL,NULL,-3.0000,1,1,1,1,NULL,'sales',3,'#1202306091051',NULL),(71,'2023-06-09 09:52:01','2023-06-09 09:52:01',NULL,NULL,-2.0000,1,1,1,1,NULL,'sales',3,'#1202306091052',NULL),(72,'2023-06-09 09:52:02','2023-06-09 09:52:02',NULL,NULL,-3.0000,1,1,1,1,NULL,'sales',3,'#1202306091052',NULL),(73,'2023-06-09 09:53:09','2023-06-09 09:53:09',NULL,NULL,-90.0000,1,1,1,1,NULL,'sales',3,'#1202306091053',NULL),(74,'2023-06-09 09:53:09','2023-06-09 09:53:09',NULL,NULL,-2.0000,1,1,1,1,NULL,'sales',3,'#1202306091053',NULL),(75,'2023-06-09 10:03:21','2023-06-09 10:03:21',NULL,NULL,-23.0000,1,1,1,1,NULL,'sales',3,'#1202306091103',NULL),(76,'2023-06-09 10:03:21','2023-06-09 10:03:21',NULL,NULL,-8.0000,1,1,1,1,NULL,'sales',3,'#1202306091103',NULL),(77,'2023-06-09 10:03:21','2023-06-09 10:03:21',NULL,NULL,-9.0000,1,1,1,1,NULL,'sales',3,'#1202306091103',NULL),(78,'2023-06-09 10:03:58','2023-06-09 10:03:58',NULL,NULL,-90.0000,1,1,1,1,NULL,'sales',3,'#1202306091103',NULL),(79,'2023-06-09 10:14:10','2023-06-09 10:14:10',NULL,NULL,-80.0000,1,1,1,1,NULL,'sales',3,'#1202306091114',NULL),(80,'2023-06-09 10:14:11','2023-06-09 10:14:11',NULL,NULL,-2.0000,1,1,1,1,NULL,'sales',3,'#1202306091114',NULL),(81,'2023-06-09 10:14:41','2023-06-09 10:14:41',NULL,NULL,-80.0000,1,1,1,1,NULL,'sales',3,'#1202306091114',NULL),(82,'2023-06-09 10:14:41','2023-06-09 10:14:41',NULL,NULL,-2.0000,1,1,1,1,NULL,'sales',3,'#1202306091114',NULL),(83,'2023-06-15 16:51:56','2023-06-15 16:51:56',NULL,1,-4.0000,3,1,1,1,NULL,'gg',1,'#120230615',NULL),(84,'2023-06-15 16:51:56','2023-06-15 16:51:56',NULL,2,-9.0000,3,1,1,1,NULL,'gg',1,'#120230615',NULL),(85,'2023-06-15 16:53:40','2023-06-15 16:53:40',NULL,2,9.0000,1,1,1,1,NULL,'asre',1,'#116868',NULL),(86,'2023-06-15 16:53:41','2023-06-15 16:53:41',NULL,4,12.0000,1,1,1,1,NULL,'asre',1,'#116868',NULL),(87,'2023-06-15 16:53:41','2023-06-15 16:53:41',NULL,5,20.0000,1,1,1,1,NULL,'asre',1,'#116868',NULL),(88,'2023-06-15 16:54:29','2023-06-15 16:54:29',NULL,1,-8.0000,1,1,1,1,NULL,NULL,3,'#1202306151754',NULL),(89,'2023-06-15 16:54:29','2023-06-15 16:54:29',NULL,1,8.0000,2,2,1,1,NULL,NULL,0,'#1202306151754',1),(90,'2023-06-15 16:54:29','2023-06-15 16:54:29',NULL,4,-20.0000,1,1,1,1,NULL,NULL,3,'#1202306151754',NULL),(91,'2023-06-15 16:54:29','2023-06-15 16:54:29',NULL,4,20.0000,2,2,1,1,NULL,NULL,0,'#1202306151754',1);
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
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
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `company_id` bigint unsigned DEFAULT NULL,
  `branch_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'OKEKE CHINEMELU','frankokeke5@gmail.com','+2347026661376',NULL,'$2y$10$uave0myXtuYzTSq.RtXwP.Yg23GgKk/MWKH.zUjo5cpJe/PY/Yt3y',NULL,'2023-05-05 07:33:14','2023-05-05 07:33:16',NULL,1,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-07-03 22:19:02
