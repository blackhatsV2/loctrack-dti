/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.15-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: employee_locs
-- ------------------------------------------------------
-- Server version	10.11.15-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba','i:1;',1772591933),
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer','i:1772591933;',1772591933);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
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
-- Table structure for table `employee_locations`
--

DROP TABLE IF EXISTS `employee_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_locations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `employee_id_no` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `office` varchar(255) DEFAULT NULL,
  `employee_type` varchar(255) DEFAULT NULL,
  `recorded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_locations_user_id_foreign` (`user_id`),
  CONSTRAINT `employee_locations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=269 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_locations`
--

LOCK TABLES `employee_locations` WRITE;
/*!40000 ALTER TABLE `employee_locations` DISABLE KEYS */;
INSERT INTO `employee_locations` VALUES
(1,1,NULL,NULL,10.73018540,122.55911480,NULL,NULL,NULL,'2026-02-28 07:55:32','2026-02-28 07:55:32','2026-02-28 07:55:32'),
(2,1,NULL,NULL,10.73018540,122.55911480,NULL,NULL,NULL,'2026-02-28 07:55:34','2026-02-28 07:55:34','2026-02-28 07:55:34'),
(3,1,NULL,NULL,10.73018540,122.55911480,NULL,NULL,NULL,'2026-02-28 07:56:25','2026-02-28 07:56:25','2026-02-28 07:56:25'),
(4,1,NULL,NULL,10.73018540,122.55911480,NULL,NULL,NULL,'2026-02-28 07:56:27','2026-02-28 07:56:27','2026-02-28 07:56:27'),
(5,1,NULL,NULL,10.74828090,122.98012330,NULL,NULL,NULL,'2026-03-01 14:00:37','2026-03-01 14:00:37','2026-03-01 14:00:37'),
(6,1,NULL,NULL,10.74828090,122.98012330,NULL,NULL,NULL,'2026-03-01 14:00:38','2026-03-01 14:00:38','2026-03-01 14:00:38'),
(7,1,NULL,NULL,10.74828090,122.98012330,NULL,NULL,NULL,'2026-03-01 14:00:48','2026-03-01 14:00:48','2026-03-01 14:00:48'),
(8,1,NULL,NULL,10.74828090,122.98012330,NULL,NULL,NULL,'2026-03-01 14:00:50','2026-03-01 14:00:50','2026-03-01 14:00:50'),
(9,1,NULL,NULL,10.73018540,122.55911480,NULL,NULL,NULL,'2026-03-01 14:12:59','2026-03-01 14:12:59','2026-03-01 14:12:59'),
(10,2,'6-013','14, Osmeña, Sta. Filomena, Iloilo, Iloilo',10.68970140,122.51535920,'915602185','Regional Office','DTI6','2026-03-01 16:54:18','2026-03-01 16:50:26','2026-03-01 16:54:18'),
(11,3,'6-156','41, Mansaya, Lapuz, Iloilo City, Iloilo',10.70009500,122.58464010,'9173016657','Regional Office','DTI6','2026-03-01 16:54:18','2026-03-01 16:50:27','2026-03-01 16:54:18'),
(12,4,'6-045','Magbato, Lambunao, Iloilo',11.03388130,122.47078390,'9502045750','Negosyo Center','DTI6','2026-03-01 16:54:18','2026-03-01 16:50:27','2026-03-01 16:54:18'),
(13,5,'6-067','Blk. 4 Lot 1, Natures Village, Alijis, Bacolod City, Negros Occidental',10.63441150,122.95221790,'9279243860','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:19','2026-03-01 16:50:27','2026-03-01 16:54:19'),
(14,6,'6-162','Jalandoni Street, Brgy. Lady Of Lourdes, Jaro, Iloilo City, Iloilo',10.72319000,122.55684840,'9954997095','Regional Office','DTI6','2026-03-01 16:54:19','2026-03-01 16:50:28','2026-03-01 16:54:19'),
(15,7,'6-041','10, Liberation Road, San Agustin, Iloilo City, Iloilo',10.70011340,122.56343410,'9950841162','Regional Office','DTI6','2026-03-01 16:54:19','2026-03-01 16:50:28','2026-03-01 16:54:19'),
(16,8,'COS-IL-030','Batuan Ilaud, Oton, Iloilo',10.71889700,122.42832120,'9608584772','Jo/cos - Iloilo','DTI6','2026-03-01 16:54:20','2026-03-01 16:50:28','2026-03-01 16:54:20'),
(17,9,'6-027','Lot 6, Block 9, Ecc Villas, Alijis, Bacolod, Negros Occidental',10.66843730,122.97369000,'9228258782','Aklan Provincial Office','DTI6','2026-03-01 16:54:20','2026-03-01 16:50:29','2026-03-01 16:54:20'),
(18,10,'2024-ILO-004','Cabulo-an Sur, Oton, Iloilo',10.72401760,122.45626150,'9461097184','Jo/cos - Iloilo','DTI6','2026-03-01 16:54:21','2026-03-01 16:50:29','2026-03-01 16:54:21'),
(19,11,'6-053','Melliza St., Ilawod Poblacion, Zarraga, Iloilo',10.82136060,122.60998320,'9498051680','Iloilo Provincial Office','DTI6','2026-03-01 16:54:21','2026-03-01 16:50:29','2026-03-01 16:54:21'),
(20,12,'6-025','Arce Street, Poblacion, Pilar, Capiz',11.48478850,122.99587150,'(+63) 0916 277 8095 / (+63) 0919 949 1691','Capiz Provincial Office','DTI6','2026-03-01 16:54:21','2026-03-01 16:50:30','2026-03-01 16:54:21'),
(21,13,'COS6-002','Ulong, Guihaman, Leganes, Iloilo',10.78211690,122.58110610,'9503278365','Jo/cos','DTI6','2026-03-01 16:54:22','2026-03-01 16:50:30','2026-03-01 16:54:22'),
(22,14,'6-082','Brgy. Cagay, Roxas City, Capiz',11.56830090,122.73567330,'9498993956','Capiz Provincial Office','DTI6','2026-03-01 16:54:22','2026-03-01 16:50:31','2026-03-01 16:54:22'),
(23,15,'6-157','Progress Subdivision, Dulonan, Arevalo, Iloilo City, Iloilo',10.68529290,122.52737400,'9089357495','Regional Office','DTI6','2026-03-01 16:54:22','2026-03-01 16:50:31','2026-03-01 16:54:22'),
(24,16,'6-049','Blk 6b Lot 16, Regina Townhomes, Brgy. Singcang-airport, Bacolod City, Negros Occidental',10.65267120,122.92833320,'9205318564','Regional Office','DTI6','2026-03-01 16:54:23','2026-03-01 16:50:31','2026-03-01 16:54:23'),
(25,17,'6-069','Atabay, San Jose, Antique',10.75938630,121.94873310,'9954334374','Antique Provincial Office','DTI6','2026-03-01 16:54:23','2026-03-01 16:50:32','2026-03-01 16:54:23'),
(26,18,'6-019','Alimbo Iraya, Buenavisata, Nabas, Aklan',11.81862680,122.09123780,'9090405451','Aklan Provincial Office','DTI6','2026-03-01 16:54:23','2026-03-01 16:50:32','2026-03-01 16:54:23'),
(27,19,'6-158','3rd St., San Jose Subdivision, Tagbac Jaro, Iloilo City, Iloilo',10.76622320,122.58050890,'9164628939','Regional Office','DTI6','2026-03-01 16:54:24','2026-03-01 16:50:33','2026-03-01 16:54:24'),
(28,20,'C6-003','Milibili, Roxas City, Capiz',11.56204890,122.76612580,'9504876385','Capiz Provincial Office','DTI6','2026-03-01 16:54:24','2026-03-01 16:50:33','2026-03-01 16:54:24'),
(29,21,'6-071','Buenavista, Tubungan, Iloilo',10.77583730,122.29799530,'09560437748 / 09202613470','Regional Office','DTI6','2026-03-01 16:54:25','2026-03-01 16:50:33','2026-03-01 16:54:25'),
(30,22,'6-029','Blk 5lot 17, Accco Housing, Brgy. Alijis, Bacolod City, Negros Occidental',10.68160360,122.95562910,'9324295174','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:25','2026-03-01 16:50:34','2026-03-01 16:54:25'),
(31,23,'6-065','Corner Confesor Drive And San Agustin Street, Poblacion Zone V, Cabatuan, Iloilo',10.88098030,122.48133250,'9198154803','Regional Office','DTI6','2026-03-01 16:54:25','2026-03-01 16:50:34','2026-03-01 16:54:25'),
(32,24,'2023-004','Block 2, Lot 5 Brgy. San Rafael, Mandurriao, Farm Workers Subdivision, Iloilo City, Iloilo',10.70908540,122.54703770,'0922-833-3913','Ipophl','DTI6','2026-03-01 16:54:26','2026-03-01 16:50:34','2026-03-01 16:54:26'),
(33,25,'C6-145','Malublub, Badiangan, Iloilo',10.97417830,122.56838260,'9285417273','Regional Office','DTI6','2026-03-01 16:54:26','2026-03-01 16:50:35','2026-03-01 16:54:26'),
(34,26,'6-138','Block 11/ Lot 8, Ciudad De Iloilo, Calumpang, Molo, Iloilo City, Iloilo',10.68430670,122.53585990,'9094775983','Regional Office','DTI6','2026-03-01 16:54:26','2026-03-01 16:50:35','2026-03-01 16:54:26'),
(35,27,'6-077','Nanga, Guimbla, Iloilo',10.67777740,122.33767670,'9203968610','Regional Office','DTI6','2026-03-01 16:54:27','2026-03-01 16:50:36','2026-03-01 16:54:27'),
(36,28,'6-009','#32, Torreblanca, Calaparan, Arevallo, Guimbal, Iloilo',10.68091660,122.52808120,'909484397','Regional Office','DTI6','2026-03-01 16:54:27','2026-03-01 16:50:36','2026-03-01 16:54:27'),
(37,29,'6-037','Sitio Cansonsing, Rizal, Poblacion, San Enrique, Negros Occidental',10.41909920,122.84965230,'9554237256','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:27','2026-03-01 16:50:36','2026-03-01 16:54:27'),
(38,30,'6-083','Dayao, Roxas, Capiz',11.58825490,122.73507710,'9611708041','Guimaras Provincial Office','DTI6','2026-03-01 16:54:28','2026-03-01 16:50:37','2026-03-01 16:54:28'),
(39,31,'6-026','Zone 5, Ungka 1, Pavia, Iloilo',10.76220060,122.54151670,'09996553587 / 09454601772','Regional Office','DTI6','2026-03-01 16:54:28','2026-03-01 16:50:37','2026-03-01 16:54:28'),
(40,32,'COS-IL-001','Rizal, Jordan, Guimaras',10.66620110,122.59665490,'9993902066','Jo/cos - Iloilo','DTI6','2026-03-01 16:54:29','2026-03-01 16:50:38','2026-03-01 16:54:29'),
(41,33,'6-072','Funda-dalipe, San Jose, Antique',10.76240970,121.93308940,'9950590910','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:29','2026-03-01 16:50:38','2026-03-01 16:54:29'),
(42,34,'6-046','B5 L8, Ciudad De Iloilo, Calumpang, Molo, Iloilo',10.68430670,122.53585990,'9177946522','Iloilo Provincial Office','DTI6','2026-03-01 16:54:29','2026-03-01 16:50:38','2026-03-01 16:54:29'),
(43,35,'C6-040','Abilay Sur, Oton, Iloilo',10.72155810,122.50049750,'9178797009','Antique Provincial Office','DTI6','2026-03-01 16:54:30','2026-03-01 16:50:39','2026-03-01 16:54:30'),
(44,36,'C6-014','Bachao Sur, Kalibo, Aklan',11.68922410,122.36742800,'09286981673 / 09778468437','Aklan Provincial Office','DTI6','2026-03-01 16:54:30','2026-03-01 16:50:39','2026-03-01 16:54:30'),
(45,37,'6-038','Zone 5, San Isidro, Jaro, Iloilo City, Iloilo',10.73910880,122.55000140,'9177993986','Regional Office','DTI6','2026-03-01 16:54:30','2026-03-01 16:50:39','2026-03-01 16:54:30'),
(46,38,'6-043','Lot 19, Lawaan St., Graceville Subd., Tiza, Roxas City, Capiz',11.57428170,122.76320360,'9290874942','Capiz Provincial Office','DTI6','2026-03-01 16:54:31','2026-03-01 16:50:40','2026-03-01 16:54:31'),
(47,39,'6-087','Sitio Sumiga, Milibili, Roxas City, Capiz',11.56204890,122.76612580,'9778771000','Capiz Provincial Office','DTI6','2026-03-01 16:54:31','2026-03-01 16:50:40','2026-03-01 16:54:31'),
(48,40,'6-155','Orosa, Zone 12, Talisay City, Negros Occidental',10.73824410,122.97334300,'9460762242','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:32','2026-03-01 16:50:40','2026-03-01 16:54:32'),
(49,41,'6-070','2-231, Lopez Jaena, Ii, Pontevedra, Negros Occidental',10.35265910,122.92122650,'9175455927','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:32','2026-03-01 16:50:41','2026-03-01 16:54:32'),
(50,42,'DTICOSMONITORS-004','129, Jota Villa, Maria Cristina, Jaro, Iloilo City, Iloilo',10.72897690,122.55530400,'0929 7025 478 / 0995 6645 015','Jo/cos - Iloilo','DTI6','2026-03-01 16:54:32','2026-03-01 16:50:41','2026-03-01 16:54:32'),
(51,43,'C6-007','Block 16 Lot 14, Nha Mandurraio, Block 22, Iloilo City, Iloilo',10.72922210,122.54044870,'9154989709','Iloilo Provincial Office','DTI6','2026-03-01 16:54:33','2026-03-01 16:50:42','2026-03-01 16:54:33'),
(52,44,'COS6-006','Lot 10, Blk 8, Molave, Manuela Subdivision, Cagamutan Sur, Leganes, Iloilo',10.78862540,122.59609560,'9999447860','Jo/cos','DTI6','2026-03-01 16:54:33','2026-03-01 16:50:42','2026-03-01 16:54:33'),
(53,45,'6-154','Block 6 Lot 5, Eon Centannial Townhomes, Jibao-an, Pavia, Iloilo',10.75370050,122.51025780,'09189511403/09176248178','Antique Provincial Office','DTI6','2026-03-01 16:54:33','2026-03-01 16:50:42','2026-03-01 16:54:33'),
(54,46,'6-105','Lot 22 Block 5 Phase 3, Cookie Street, Celine Homes, Estefania, Bacolod City, Negros Occidental',10.67161170,122.98812490,'9438457623','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:34','2026-03-01 16:50:43','2026-03-01 16:54:34'),
(55,47,'6-128','Tabucan, Dumangas, Iloilo',10.82146430,122.70543090,'9162576049','Guimaras Provincial Office','DTI6','2026-03-01 16:54:34','2026-03-01 16:50:43','2026-03-01 16:54:34'),
(56,48,'6-050','Bacan, Banga, Aklan',11.63167320,122.33059180,'9509028888','Aklan Provincial Office','DTI6','2026-03-01 16:54:34','2026-03-01 16:50:43','2026-03-01 16:54:34'),
(57,49,'6-016','Sta. Clara, Oton, Iloilo',10.76321050,122.43823070,'9612436034','Regional Office','DTI6','2026-03-01 16:54:35','2026-03-01 16:50:44','2026-03-01 16:54:35'),
(58,50,'COS6-004','4-b, Zamora, Concepcion, Iloilo City, Iloilo',10.69599100,122.57833400,'9818098637','Jo/cos','DTI6','2026-03-01 16:54:35','2026-03-01 16:50:44','2026-03-01 16:54:35'),
(59,51,'6-060','Roosevelt, Poblacion, Tapaz, Capiz',11.26085800,122.53684280,'9636241960','Capiz Provincial Office','DTI6','2026-03-01 16:54:36','2026-03-01 16:50:45','2026-03-01 16:54:36'),
(60,52,'6-076','Alaguisoc, Jordan, Guimaras',10.61930390,122.59948170,'9514397883','Negosyo Center','DTI6','2026-03-01 16:54:36','2026-03-01 16:50:45','2026-03-01 16:54:36'),
(61,53,'6-031','Blk 49, Lot 8, Bolilao, Mandurriao, Iloilo City, Iloilo',10.71337150,122.55495050,'9209466013','Regional Office','DTI6','2026-03-01 16:54:36','2026-03-01 16:50:45','2026-03-01 16:54:36'),
(62,54,'2024-ILO-006','Zone 1, Santa Rosa, Iloilo City, Iloilo',10.71206490,122.57823510,'9950633872','Jo/cos - Iloilo','DTI6','2026-03-01 16:54:37','2026-03-01 16:50:46','2026-03-01 16:54:37'),
(63,55,'6-047','Block 12 Lot 20, Regent Pearl Subdivision, Alijis, Bacolod City, Negros Occidental',10.62677640,122.96229690,'9213426412','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:37','2026-03-01 16:50:46','2026-03-01 16:54:37'),
(64,56,'6-084','Kalibo, Aklan',11.68922410,122.36742800,'9292455147','','DTI6','2026-03-01 16:54:37','2026-03-01 16:50:46','2026-03-01 16:54:37'),
(65,57,'C6-004','Zone 4, Nabitasan, La Paz, Iloilo City, Iloilo',10.71409340,122.55862810,'9159872017','Iloilo Provincial Office','DTI6','2026-03-01 16:54:38','2026-03-01 16:50:47','2026-03-01 16:54:38'),
(66,58,'DTINCCOS-062','Magsaysay Village, Lapaz, Iloilo City, Iloilo',10.71132000,122.56202020,'9076144659','Jo/cos - Iloilo','DTI6','2026-03-01 16:54:38','2026-03-01 16:50:47','2026-03-01 16:54:38'),
(67,59,'6-134','016, General Luna St., Poblacion West, Oton, Iloilo',10.69248680,122.47502840,'09477684788/099546521342','Regional Office','DTI6','2026-03-01 16:54:38','2026-03-01 16:50:47','2026-03-01 16:54:38'),
(68,60,'6-014','PiÑa, Buenavista, Guimaras',10.64345740,122.64470010,'0916-2566-343','Iloilo Provincial Office','DTI6','2026-03-01 16:54:39','2026-03-01 16:50:48','2026-03-01 16:54:39'),
(69,61,'COS6-05','22a, Democracia, Ma. Cristina, Iloilo City, Iloilo',10.72976280,122.55562060,'9776869662','Jo/cos','DTI6','2026-03-01 16:54:39','2026-03-01 16:50:48','2026-03-01 16:54:39'),
(70,62,'6-008','Lot 8 Block 6, Sto. Domingo Subdivision, Arevalo, Iloilo City, Iloilo',10.73170100,122.55257530,'9399508636','Regional Office','DTI6','2026-03-01 16:54:40','2026-03-01 16:50:49','2026-03-01 16:54:40'),
(71,63,'6-007','Block 7 Lot 10, Augustine Grove, Sambag, Jaro,iloilo, Iloilo',10.73647650,122.53820110,'9176232585','Regional Office','DTI6','2026-03-01 16:54:40','2026-03-01 16:50:49','2026-03-01 16:54:40'),
(72,64,'6-068','Had. Ideal, Xiii, Victorias City, Negros Occidental',10.89308690,123.04497880,'9216520289','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:40','2026-03-01 16:50:49','2026-03-01 16:54:40'),
(73,65,'COS-IL-006','Block 01 Lot 56, Phase P, Parc Regency, Aganan, Pavia, Iloilo',10.75662350,122.52856060,'9750097349','Jo/cos - Iloilo','DTI6','2026-03-01 16:54:41','2026-03-01 16:50:50','2026-03-01 16:54:41'),
(74,66,'6-015','Alugmawa, Lambunao, Iloilo',11.10418220,122.51181480,'9303325798','Iloilo Provincial Office','DTI6','2026-03-01 16:54:41','2026-03-01 16:50:50','2026-03-01 16:54:41'),
(75,67,'6-057','#15, San Miguel, Iloilo',10.78236010,122.46370800,'9152640243','Regional Office','DTI6','2026-03-01 16:54:41','2026-03-01 16:50:50','2026-03-01 16:54:41'),
(76,68,'6-059','224, Sambag, Jaro, Iloilo',10.73465860,122.54080960,'9176249722','Regional Office','DTI6','2026-03-01 16:54:42','2026-03-01 16:50:51','2026-03-01 16:54:42'),
(77,69,'2024-ILO-005','Talacu-an, Leon, Iloilo',10.76914980,122.38725760,'6.39E+11','Jo/cos - Iloilo','DTI6','2026-03-01 16:54:42','2026-03-01 16:50:51','2026-03-01 16:54:42'),
(78,70,'6-063','Cabatac, Maasin, Iloilo',10.89433290,122.44247730,'9280344433','Regional Office','DTI6','2026-03-01 16:54:42','2026-03-01 16:50:52','2026-03-01 16:54:42'),
(79,71,'6-160','Block 3 Lot 20, Carmen J. Ledesma Village, Tacas, Jaro, Iloilo City, Iloilo',10.74756150,122.55640930,'9177052844','Regional Office','DTI6','2026-03-01 16:54:43','2026-03-01 16:50:52','2026-03-01 16:54:43'),
(80,72,'6-032','Supang, Buenavista, Guimaras',10.70666000,122.67012670,'9991572670','Regional Office','DTI6','2026-03-01 16:54:43','2026-03-01 16:50:52','2026-03-01 16:54:43'),
(81,73,'6-064','Block 19, Lot 7, Zone 1, Salas Real Subdivision, Quintin Salas, Jaro, Iloilo City, N/a',10.74173450,122.56233290,'9277720006','Regional Office','DTI6','2026-03-01 16:54:44','2026-03-01 16:50:53','2026-03-01 16:54:44'),
(82,74,'6-020','Block 1 Lot 4, Lessandra C, Jibao-an, Pavia, Iloilo',10.74733080,122.51445700,'9215365566','Regional Office','DTI6','2026-03-01 16:54:44','2026-03-01 16:50:53','2026-03-01 16:54:44'),
(83,75,'6-021','Bn349, Orbe St., Baybay Norte, Miagao, Iloilo',10.64078000,122.23841430,'9267497755','Regional Office','DTI6','2026-03-01 16:54:44','2026-03-01 16:50:53','2026-03-01 16:54:44'),
(84,76,'6-055','22, M.h.del Pilar Street, M.h. Del Pilar Jaro, Iloilo City, Iloilo',10.69924880,122.55040140,'9634465066','Regional Office','DTI6','2026-03-01 16:54:45','2026-03-01 16:50:54','2026-03-01 16:54:45'),
(85,77,'6-054','11, Tajanlangit St., Tacas, Miagao, Iloilo',10.64217100,122.23452790,'09177169395/09224318055','Regional Office','DTI6','2026-03-01 16:54:45','2026-03-01 16:50:54','2026-03-01 16:54:45'),
(86,78,'6-023','Purok 7, Funda-dalipe, San Jose De Buenavista, Antique',10.76245950,121.93313150,'9177063939','Antique Provincial Office','DTI6','2026-03-01 16:54:45','2026-03-01 16:50:54','2026-03-01 16:54:45'),
(87,79,'6-044','Purok 3, New Poblacion, Buenavista, Guimaras',10.70996590,122.64187450,'9151518702','Guimaras Provincial Office','DTI6','2026-03-01 16:54:46','2026-03-01 16:50:55','2026-03-01 16:54:46'),
(88,80,'6-119','Block 35, Lot 1, Tuna Street, Village 2, Pandac, Pavia, Iloilo',10.74772610,122.52878840,'9757465208','Capiz Provincial Office','DTI6','2026-03-01 16:54:46','2026-03-01 16:50:55','2026-03-01 16:54:46'),
(89,81,'6-143','0424, Luis Barrios St., Poblacion, Kalibo, Aklan',11.70977750,122.36542760,'09206214738/09955216057','Aklan Provincial Office','DTI6','2026-03-01 16:54:47','2026-03-01 16:50:56','2026-03-01 16:54:47'),
(90,82,'6-062','Rizal Street, Ilaya, Zarraga, Iloilo',10.82357010,122.60921450,'9183399368','Regional Office','DTI6','2026-03-01 16:54:47','2026-03-01 16:50:56','2026-03-01 16:54:47'),
(91,83,'6-006','Simon Ledesma, Simon Ledesma Jaro, Iloilo City, Iloilo',10.73038720,122.55636450,'9353222798','Regional Office','DTI6','2026-03-01 16:54:47','2026-03-01 16:50:56','2026-03-01 16:54:47'),
(92,84,'COS-IL-008','Balibagan Oeste, Sta. Barbara, Iloilo',10.80728470,122.51322940,'9519132844','Jo/cos - Iloilo','DTI6','2026-03-01 16:54:48','2026-03-01 16:50:57','2026-03-01 16:54:48'),
(93,85,'6-137','Block 21 Lot 5, 21st, Westwoods Subdivision, Dungon, Mandurriao, Iloilo City, Iloilo',10.73082590,122.53807600,'9176307647','Regional Office','DTI6','2026-03-01 16:54:48','2026-03-01 16:50:57','2026-03-01 16:54:48'),
(94,86,'COS-IL-004','Batuan Ilaud, Oton, Iloilo',10.71889700,122.42832120,'9485907196','Jo/cos - Iloilo','DTI6','2026-03-01 16:54:48','2026-03-01 16:50:57','2026-03-01 16:54:48'),
(95,87,'C6-037','Sta. Teresa, Jordan, Guimaras',10.59512950,122.55424350,'09066300203/09309725712','Guimaras Provincial Office','DTI6','2026-03-01 16:54:49','2026-03-01 16:50:58','2026-03-01 16:54:49'),
(96,88,'6-028','#1 Sunset Subdivision, Funda-dalipe, San Jose, Antique',10.76240970,121.93308940,'9557806424','Antique Provincial Office','DTI6','2026-03-01 16:54:49','2026-03-01 16:50:58','2026-03-01 16:54:49'),
(97,89,'6-121','1548, Zone 5, San Jose, San Miguel, Iloilo',10.76643240,122.49483840,'9088893834','Iloilo Provincial Office','DTI6','2026-03-01 16:54:49','2026-03-01 16:50:58','2026-03-01 16:54:49'),
(98,90,'6-079','Sitio Oring-oring, Barangay 8, San Jose, Antique',10.74890690,121.94126080,'9058156698','Antique Provincial Office','DTI6','2026-03-01 16:54:50','2026-03-01 16:50:59','2026-03-01 16:54:50'),
(99,91,'6-056','26-b, Calubihan, Jaro, Iloilo City, Iloilo',10.72093140,122.55194570,'9121370673','Regional Office','DTI6','2026-03-01 16:54:50','2026-03-01 16:50:59','2026-03-01 16:54:50'),
(100,92,'6-066','0409, L. Barrios Street, Poblacion, Kalibo, Aklan',11.71004970,122.36556070,'9338642262','Regional Office','DTI6','2026-03-01 16:54:51','2026-03-01 16:51:00','2026-03-01 16:54:51'),
(101,93,'6-010','604, Divinagracia Street, Brgy. Aguinaldo, La Paz, Iloilo City, Iloilo',10.70885110,122.57116580,'9984511714','Aklan Provincial Office','DTI6','2026-03-01 16:54:51','2026-03-01 16:51:00','2026-03-01 16:54:51'),
(102,94,'6-034','Bermejo Street, Barangay Zone 3, Cabatuan, Iloilo',10.82558710,122.53295030,'9462204754','Regional Office','DTI6','2026-03-01 16:54:51','2026-03-01 16:51:00','2026-03-01 16:54:51'),
(103,95,'6-024','Bungca, Barotac Nuevo, Iloilo',10.90321630,122.70966660,'9688571450','Regional Office','DTI6','2026-03-01 16:54:52','2026-03-01 16:51:01','2026-03-01 16:54:52'),
(104,96,'6-039','Ugsod, Banga, Aklan',11.63202370,122.31783790,'9272473485','Aklan Provincial Office','DTI6','2026-03-01 16:54:52','2026-03-01 16:51:01','2026-03-01 16:54:52'),
(105,97,'COS-IL-007','Buenavista Norte, Miagao, Iloilo',10.65109470,122.18453820,'9702067317','Jo/cos - Iloilo','DTI6','2026-03-01 16:54:53','2026-03-01 16:51:01','2026-03-01 16:54:53'),
(106,98,'COS-IL-002','Blk 3k, 2nd. St., Manuela Subdivision, Cagamutan Sur, Leganes, Iloilo',10.78862540,122.59609560,'9509448125','Jo/cos - Iloilo','DTI6','2026-03-01 16:54:53','2026-03-01 16:51:02','2026-03-01 16:54:53'),
(107,99,'6-036','Cubay Sur, Malay, Aklan',11.89995070,121.93166720,'9163371127','Aklan Provincial Office','DTI6','2026-03-01 16:54:53','2026-03-01 16:51:02','2026-03-01 16:54:53'),
(108,100,'6-042','Odiong, Sibalom, Antique',10.77769510,121.98285700,'9087946895','Antique Provincial Office','DTI6','2026-03-01 16:54:54','2026-03-01 16:51:03','2026-03-01 16:54:54'),
(109,101,'6-081','Hda. San Bernabe 2, Salvacion, Murcia, Negros Occidental',10.60783730,123.05357740,'0961-739-1828','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:54','2026-03-01 16:51:03','2026-03-01 16:54:54'),
(110,102,'6-052','Baldan, Teniente Benito, Tubungan, Iloilo',10.76655750,122.32492360,'9127992225','Iloilo Provincial Office','DTI6','2026-03-01 16:54:54','2026-03-01 16:51:03','2026-03-01 16:54:54'),
(111,103,'2024-ILO-007','Zone Ii, Tagsing, Santa Barbabra, Iloilo',10.82990240,122.53515270,'9560768971','Jo/cos - Iloilo','DTI6','2026-03-01 16:54:55','2026-03-01 16:51:04','2026-03-01 16:54:55'),
(112,104,'6-033','Lotn 12 Blk 4, Queen\'s Road, Imperial Homes Ii, Quintin Salas, Jaro Iloilo City, Iloilo',10.74180130,122.56224800,'6.19E+11','Iloilo Provincial Office','DTI6','2026-03-01 16:54:55','2026-03-01 16:51:04','2026-03-01 16:54:55'),
(113,105,'6-035','Block 85 Lot 7 & 9, Ana Ros Village, Brgy. Calahunan, Mandurriao, Iloilo City, Iloilo',10.71858830,122.52238000,'9257390212','Regional Office','DTI6','2026-03-01 16:54:56','2026-03-01 16:51:04','2026-03-01 16:54:56'),
(114,106,'6-131','Igbantang, Sta Teresa, Jordan, Guimaras',10.59512950,122.55424350,'9454762140','Guimaras Provincial Office','DTI6','2026-03-01 16:54:56','2026-03-01 16:51:05','2026-03-01 16:54:56'),
(115,107,'6-147','Tigbauan-leon Rd,, Cordova Norte, Tigbauan, Iloilo',10.73766710,122.40425140,'09222926310/09279509247','Iloilo Provincial Office','DTI6','2026-03-01 16:54:56','2026-03-01 16:51:05','2026-03-01 16:54:56'),
(116,108,'6-017','Casa Sofia, Crossing Seminary, Lawaan, Roxas, Capiz',11.55852530,122.75483640,'9060618445','Capiz Provincial Office','DTI6','2026-03-01 16:54:57','2026-03-01 16:51:06','2026-03-01 16:54:57'),
(117,109,'C6-009','De La Rama, Lag-asan, Bago, Negros Occidental',10.52991990,122.83912050,'9432490613','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:57','2026-03-01 16:51:06','2026-03-01 16:54:57'),
(118,110,'6-089','63-b, Guzman Street, Guzman Jesena, Mandurriao, Iloilo City, Iloilo',10.72442720,122.52946910,'9190011463','Iloilo Provincial Office','DTI6','2026-03-01 16:54:57','2026-03-01 16:51:06','2026-03-01 16:54:57'),
(119,111,'6-113','Block 9 Lot 29, Grandville 3 Subdivision, Mansilingan, Bacolod City, Negros Occidental',10.62440350,122.96982250,'9399159596','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:58','2026-03-01 16:51:07','2026-03-01 16:54:58'),
(120,112,'6-051','Block 35 Lot 2 And 4, Mallery Homes Subdivision, Barangay Rizal, Silay City, Negros Occidental',10.80763610,122.98612770,'9612041324','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:58','2026-03-01 16:51:07','2026-03-01 16:54:58'),
(121,113,'6-117','Block 10 Lot 6, Charito Heights Phase 2, Barangay Granada, Bacolod City, Negros Occidental',10.66869250,123.03720300,'(0915)4496866/(0968)8571063','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:58','2026-03-01 16:51:07','2026-03-01 16:54:58'),
(122,114,'6-012','Villa Julita, Badiang, San Jose De Buenavista, Antique',10.76711820,121.94588900,'9175198668','Antique Provincial Office','DTI6','2026-03-01 16:54:59','2026-03-01 16:51:08','2026-03-01 16:54:59'),
(123,115,'6-030','Prk. Santan, Villarosa St., Cansilayan, Murcia, Negros Occidental',10.57197970,123.00572610,'9937916377','Negros Occidental Provincial Office','DTI6','2026-03-01 16:54:59','2026-03-01 16:51:08','2026-03-01 16:54:59'),
(124,116,'6-078','Sto. Niño Sur, Arevalo Iloilo City, Iloilo',10.68366990,122.49908280,'9452549079','Regional Office','DTI6','2026-03-01 16:55:00','2026-03-01 16:51:08','2026-03-01 16:55:00'),
(125,117,'6-011','Proper, Santa Teresa, Jordan, Guimaras',10.59512950,122.55424350,'9185476245','Guimaras Provincial Office','DTI6','2026-03-01 16:55:00','2026-03-01 16:51:09','2026-03-01 16:55:00'),
(126,118,'','Sitio Alimbo Iraya, Buenavista, Nabas, Aklan',11.81862680,122.09123780,'(036) 268-3485','Aklan: Kalibo','NC Aklan','2026-03-01 16:55:01','2026-03-01 16:51:09','2026-03-01 16:55:01'),
(127,119,'','Bacan, Banga, Aklan',11.63167320,122.33059180,'09709320059 / 09453423459','Aklan: Kalibo','NC Aklan','2026-03-01 16:55:01','2026-03-01 16:51:10','2026-03-01 16:55:01'),
(128,120,'','D.Maagma, Poblacion, Kalibo, Aklan',11.70562470,122.36342740,'9613225131','Aklan: Kalibo','NC Aklan','2026-03-01 16:55:01','2026-03-01 16:51:10','2026-03-01 16:55:01'),
(129,121,'','Sitio Talangban, Camaligan, Batan Aklan',11.58950300,122.40687160,'9125268768','Aklan: Kalibo','NC Aklan','2026-03-01 16:55:02','2026-03-01 16:51:11','2026-03-01 16:55:02'),
(130,122,'','Purok 2 C. Laserna Street, Poblacion, Kalibo, Aklan',11.70676320,122.36345780,'9185653742','Aklan: Kalibo','NC Aklan','2026-03-01 16:55:02','2026-03-01 16:51:11','2026-03-01 16:55:02'),
(131,123,'','Ginictan, Altavas, Aklan',11.52354110,122.47078390,'9464488998','Aklan: Altavas','NC Aklan','2026-03-01 16:55:02','2026-03-01 16:51:11','2026-03-01 16:55:02'),
(132,124,'','Ondoy, Ibajay, Aklan',11.81851090,122.12208560,'9122190378','Aklan: Ibajay','NC Aklan','2026-03-01 16:55:03','2026-03-01 16:51:12','2026-03-01 16:55:03'),
(133,125,'','New Buswang,Kalibo,Aklan',11.71124910,122.38017600,'9562468199','Aklan: Lezo','NC Aklan','2026-03-01 16:55:03','2026-03-01 16:51:12','2026-03-01 16:55:03'),
(134,126,'','Rizal Street, Poblacion, Libacao, Aklan',11.41092510,122.28807260,'9567061878','Aklan: Libacao','NC Aklan','2026-03-01 16:55:04','2026-03-01 16:51:13','2026-03-01 16:55:04'),
(135,127,'','Centro Cayangwan, Makato, Aklan',11.69208020,122.28523740,'09942013074','Aklan: Makato','NC Aklan','2026-03-01 16:55:04','2026-03-01 16:51:13','2026-03-01 16:55:04'),
(136,128,'','Sitio Iwisan, Cabugao, Batan, Aklan',11.56278120,122.43901300,'09077007669','Aklan: Malay','NC Aklan','2026-03-01 16:55:04','2026-03-01 16:51:13','2026-03-01 16:55:04'),
(137,129,'','Tagas, Tangalan, Aklan',11.76680390,122.24553640,'9639713494','Aklan: Caticlan (Satellite office)','NC Aklan','2026-03-01 16:55:05','2026-03-01 16:51:14','2026-03-01 16:55:05'),
(138,130,'','Sitio Puntat Bukid, San Dimas, Malinao, Aklan',11.66860910,122.26397080,'9101616707','Aklan: Malinao','NC Aklan','2026-03-01 16:55:05','2026-03-01 16:51:14','2026-03-01 16:55:05'),
(139,131,'','Andagao, Kalibo, Aklan',11.70165630,122.37734330,'9300912288','Aklan: Balete','NC Aklan','2026-03-01 16:55:05','2026-03-01 16:51:14','2026-03-01 16:55:05'),
(140,132,'','Bay-ang, Batan, Aklan',11.59194920,122.44955470,'9101254554','Aklan: New Washington','NC Aklan','2026-03-01 16:55:06','2026-03-01 16:51:15','2026-03-01 16:55:06'),
(141,133,'','Bay-ang, Batan, Aklan',11.59194920,122.44955470,'9489375419','Aklan: Banga','NC Aklan','2026-03-01 16:55:06','2026-03-01 16:51:15','2026-03-01 16:55:06'),
(142,134,'','Sitio Centro, Toledo, Nabas, Aklan',11.84028590,122.05817620,'9638026255','Aklan: Nabas','NC Aklan','2026-03-01 16:55:06','2026-03-01 16:51:16','2026-03-01 16:55:06'),
(143,135,'','Panayakan, Tangalan, Aklan',11.76182670,122.22568030,'9611544886','Aklan: Tangalan','NC Aklan','2026-03-01 16:55:07','2026-03-01 16:51:16','2026-03-01 16:55:07'),
(144,136,'','Napnot, Madalag, Aklan',11.50884740,122.31925500,'9283396580','Aklan: Madalag','NC Aklan','2026-03-01 16:55:07','2026-03-01 16:51:16','2026-03-01 16:55:07'),
(145,137,'','Balusbos, Buruanga, Aklan',11.85597380,121.89325920,'9155037447','Aklan: Buruanga','NC Aklan','2026-03-01 16:55:08','2026-03-01 16:51:17','2026-03-01 16:55:08'),
(146,138,'','Datu Magsugod Street, Poblacion, Batan, Aklan',11.58450530,122.49908280,'9128018208','Aklan: Batan','NC Aklan','2026-03-01 16:55:08','2026-03-01 16:51:17','2026-03-01 16:55:08'),
(147,139,'','Binirayan, Brgy. 5, San Jose, Antique',10.74890690,121.94126080,'0916-8233-655/ 0927-819-6178','Antique: San Jose','NC Antique','2026-03-01 16:55:08','2026-03-01 16:51:17','2026-03-01 16:55:08'),
(148,140,'','Malabor, Tibiao, Antique',11.27888890,122.04681060,'0927-038-6389','Antique: San Jose','NC Antique','2026-03-01 16:55:09','2026-03-01 16:51:18','2026-03-01 16:55:09'),
(149,141,'','Poblacion 2, Hamtic, Antique',10.69573970,121.98214620,'0961-065-1272','Antique: Caluya','NC Antique','2026-03-01 16:55:09','2026-03-01 16:51:18','2026-03-01 16:55:09'),
(150,142,'','Centro Weste, Libertad, Antique',11.77203930,121.91459860,'0967-224-2594','Antique: Libertad','NC Antique','2026-03-01 16:55:09','2026-03-01 16:51:18','2026-03-01 16:55:09'),
(151,143,'','Purok 8, Aureliana, Patnongon, Antique',10.88432440,121.98996480,'0997-887-2636','Antique: Patnongon','NC Antique','2026-03-01 16:55:10','2026-03-01 16:51:19','2026-03-01 16:55:10'),
(152,144,'','Purok 1, Poblacion, Tibiao, Antique',12.66788930,123.98813930,'0976-003-1192','Antique: Tibiao','NC Antique','2026-03-01 16:55:10','2026-03-01 16:51:19','2026-03-01 16:55:10'),
(153,145,'','Ducado St., Ubos, Valderrama, Antique',11.01111170,122.13202370,'0935-927-8003','Antique: Valderrama','NC Antique','2026-03-01 16:55:11','2026-03-01 16:51:20','2026-03-01 16:55:11'),
(154,146,'','Callan, Sebaste, Antique',11.66335620,122.10045830,'0945-094-1554','Antique: Sebaste','NC Antique','2026-03-01 16:55:11','2026-03-01 16:51:20','2026-03-01 16:55:11'),
(155,147,'','Casay Viejo, Anini-y, Antique',10.44879210,121.99422930,'9058954025','Antique: Hamtic','NC Antique','2026-03-01 16:55:11','2026-03-01 16:51:20','2026-03-01 16:55:11'),
(156,148,'','Malacañang, Culasi, Antique',11.40561390,122.05675560,'0907-290-6545/0927-038-5892','Antique: Culasi','NC Antique','2026-03-01 16:55:12','2026-03-01 16:51:21','2026-03-01 16:55:12'),
(157,149,'','Esperanza 1st Sibalom, Antique',10.78334550,122.01667230,'09293253117/09351719958','Antique: Sibalom','NC Antique','2026-03-01 16:55:12','2026-03-01 16:51:21','2026-03-01 16:55:12'),
(158,150,'','Igpalge, Anini-y, Antique',10.46096360,121.98427860,'09480494559/ 09650523659','Antique: Anini-y','NC Antique','2026-03-01 16:55:12','2026-03-01 16:51:21','2026-03-01 16:55:12'),
(159,151,'','Purok 4, Aureliana, Patnongon, Antique',10.86545430,121.97148350,'0935-330-5633','Antique: Belison','NC Antique','2026-03-01 16:55:13','2026-03-01 16:51:22','2026-03-01 16:55:13'),
(160,152,'','Brgy. Ilaya, Bugasong, Antique',11.10163140,122.14054130,'0919-224-9290','Antique: Bugasong','NC Antique','2026-03-01 16:55:13','2026-03-01 16:51:22','2026-03-01 16:55:13'),
(161,153,'','Catmon, Sibalom, Antique',10.77773590,122.02549690,'9266253826','Antique: San Remegio','NC Antique','2026-03-01 16:55:13','2026-03-01 16:51:23','2026-03-01 16:55:13'),
(162,154,'','Poblacion, Barbaza, Antique',11.19380320,122.04254820,'0930-193-1526','Antique: Barbaza','NC Antique','2026-03-01 16:55:14','2026-03-01 16:51:23','2026-03-01 16:55:14'),
(163,155,'','Intao, Laua-an, Antique',11.15627660,122.04538980,'0916-157-9102/09938738900','Antique: Laua an','NC Antique','2026-03-01 16:55:14','2026-03-01 16:51:23','2026-03-01 16:55:14'),
(164,156,'','Paciencia, Tobias Fornier, Antique',10.50174840,121.92740030,'0921-5704792','Antique: Tobias Fornier','NC Antique','2026-03-01 16:55:15','2026-03-01 16:51:24','2026-03-01 16:55:15'),
(165,157,'','Bgry. Tiza, Roxas City, Capiz',11.57896580,122.76000120,'9290874942','Capiz: Roxas City','NC Capiz','2026-03-01 16:55:15','2026-03-01 16:51:24','2026-03-01 16:55:15'),
(166,158,'','Brgy. Baybay, Roxas City, Capiz',11.59956470,122.74354590,'9959454785','Capiz: Roxas City','NC Capiz','2026-03-01 16:55:15','2026-03-01 16:51:24','2026-03-01 16:55:15'),
(167,159,'','Brgy. Cagay, Roxas City, Capiz',11.56830090,122.73567330,'9151533160','Capiz: Roxas City','NC Capiz','2026-03-01 16:55:16','2026-03-01 16:51:25','2026-03-01 16:55:16'),
(168,160,'','Brgy. Cagay, Roxas City, Capiz',11.56830090,122.73567330,'9176553092','Capiz: Roxas City','NC Capiz','2026-03-01 16:55:16','2026-03-01 16:51:25','2026-03-01 16:55:16'),
(169,161,'','Brgy. Bato-Bato Mambusao, Capiz',11.42278040,122.60372180,'9564138647','Capiz: Mambusao','NC Capiz','2026-03-01 16:55:16','2026-03-01 16:51:25','2026-03-01 16:55:16'),
(170,162,'','Brgy. Sibaguan, Roxas City, Capiz',11.54653660,122.73923410,'9913249993','Capiz: Pontevedra','NC Capiz','2026-03-01 16:55:17','2026-03-01 16:51:26','2026-03-01 16:55:17'),
(171,163,'','Brgy. Bangonbangon Sigma Capiz',11.43273790,122.71249030,'9439138371','Capiz: Sigma','NC Capiz','2026-03-01 16:55:17','2026-03-01 16:51:26','2026-03-01 16:55:17'),
(172,164,'','Brgy. Bag-ong Barrio, Tapaz, Capiz',11.25373410,122.57368420,'9487468536','Capiz: Tapaz','NC Capiz','2026-03-01 16:55:17','2026-03-01 16:51:27','2026-03-01 16:55:17'),
(173,165,'','Brgy. Poblacion Proper,Mambusao,Capiz',11.43125730,122.59524150,'9661684372','Capiz: Dao','NC Capiz','2026-03-01 16:55:18','2026-03-01 16:51:27','2026-03-01 16:55:18'),
(174,166,'','Brgy. Lucero, Jamindan, Capiz',11.53152940,122.36203410,'9465560940','Capiz: Jamindan','NC Capiz','2026-03-01 16:55:18','2026-03-01 16:51:27','2026-03-01 16:55:18'),
(175,167,'','Poblacion, Sapian, Capiz',11.49633550,122.59948170,'9301161575','Capis: Sapian','NC Capiz','2026-03-01 16:55:19','2026-03-01 16:51:28','2026-03-01 16:55:19'),
(176,168,'','San Esteban Village Phase 1, Brgy. Rizal, Pontevedra, Capiz',12.66788930,123.98813930,'9764288184','Capiz: Pilar','NC Capiz','2026-03-01 16:55:19','2026-03-01 16:51:28','2026-03-01 16:55:19'),
(177,169,'','Brgy. Candual, Panay, Capiz',11.53199130,122.77882480,'9128222185','Capiz: Panit-an','NC Capiz','2026-03-01 16:55:19','2026-03-01 16:51:28','2026-03-01 16:55:19'),
(178,170,'','Brgy. Concepcion, Dumalag, Capiz',11.29986580,122.60796160,'9385674432','Capiz: Dumalag','NC Capiz','2026-03-01 16:55:20','2026-03-01 16:51:29','2026-03-01 16:55:20'),
(179,171,'','Brgy. Concepcion, Dumalag, Capiz',11.29986580,122.60796160,'9317665885','Capiz: Dumarao','NC Capiz','2026-03-01 16:55:20','2026-03-01 16:51:29','2026-03-01 16:55:20'),
(180,172,'','Brgy. Intampilan, Panitan, Capiz',11.48289000,122.76612580,'9485192545','Capiz: Ivisan','NC Capiz','2026-03-01 16:55:20','2026-03-01 16:51:30','2026-03-01 16:55:20'),
(181,173,'','Brgy. Poblacion, Dumalag, Capiz',11.30766250,122.62491950,'','Capiz: Maayon','NC Capiz','2026-03-01 16:55:21','2026-03-01 16:51:30','2026-03-01 16:55:21'),
(182,174,'','Oducado Compound, Brgy. Lawa-an, Roxas City, Capiz',11.55459500,122.75854260,'9480272478','Capiz: Cuartero','NC Capiz','2026-03-01 16:55:21','2026-03-01 16:51:30','2026-03-01 16:55:21'),
(183,175,'','Alaguisoc, Jordan, Guimaras',10.61930390,122.59948170,'09514397883','Guimaras: Jordan (DTI)','NC Guimaras','2026-03-01 16:55:21','2026-03-01 16:51:31','2026-03-01 16:55:21'),
(184,176,'','Calaya, Nueva Valencia, Guimaras',10.47371990,122.58817400,'09303148653','Guimaras: Jordan (DTI)','NC Guimaras','2026-03-01 16:55:22','2026-03-01 16:51:31','2026-03-01 16:55:22'),
(185,177,'','San Roque, Buenavista, Guimaras',10.68134830,122.65600160,'09474646589','Guimaras: Jordan (DTI)','NC Guimaras','2026-03-01 16:55:22','2026-03-01 16:51:31','2026-03-01 16:55:22'),
(186,178,'','Sitio Dagubdob Concordia, Sibunag, Guimaras',10.50083710,122.65035100,'09275902285','Guimaras: Jordan (DTI)','NC Guimaras','2026-03-01 16:55:23','2026-03-01 16:51:32','2026-03-01 16:55:23'),
(187,179,'','Buluangan, Jordan, Guimaras',10.56360510,122.55141550,'09100792865','Guimaras: Nueva Valencia','NC Guimaras','2026-03-01 16:55:23','2026-03-01 16:51:32','2026-03-01 16:55:23'),
(188,180,'','Poblacion, Jordan, Guimaras',10.64871240,122.59948170,'09305319847','Guimaras: Jordan (LGU)','NC Guimaras','2026-03-01 16:55:23','2026-03-01 16:51:32','2026-03-01 16:55:23'),
(189,181,'','San Miguel, Jordan, Guimaras',10.59121270,122.58817400,'9128127458','Guimaras: Buenavista','NC Guimaras','2026-03-01 16:55:24','2026-03-01 16:51:33','2026-03-01 16:55:24'),
(190,182,'','Sapal, San Lorenzo, Guimaras',10.55253370,122.64752560,'9075079085','Guimaras: San Lorenzo','NC Guimaras','2026-03-01 16:55:24','2026-03-01 16:51:33','2026-03-01 16:55:24'),
(191,183,'','Sabang, Sibunag, Guimaras',10.49659500,122.64470010,'9958066704','Guimaras: Sibunag','NC Guimaras','2026-03-01 16:55:24','2026-03-01 16:51:34','2026-03-01 16:55:24'),
(192,184,'','Brgy. Magbato, Lambunao, Iloilo',11.03320090,122.47326850,'09502045750','Iloilo: Iloilo City (DTI)','NC Iloilo','2026-03-01 16:55:25','2026-03-01 16:51:34','2026-03-01 16:55:25'),
(193,185,'','Brgy. Botong, Oton, Iloilo',10.69440990,122.43823070,'09608584772','Iloilo: Iloilo City (DTI)','NC Iloilo','2026-03-01 16:55:25','2026-03-01 16:51:34','2026-03-01 16:55:25'),
(194,186,'','Brgy. Buenavista Norte Miagao, Iloilo',10.65109470,122.18453820,'09702067317','Iloilo: Iloilo City (DTI)','NC Iloilo','2026-03-01 16:55:26','2026-03-01 16:51:35','2026-03-01 16:55:26'),
(195,187,'','Brgy. Aganan, Pavia, Iloilo',10.76671250,122.53444560,'9750097349','Iloilo: Iloilo City (DTI)','NC Iloilo','2026-03-01 16:55:26','2026-03-01 16:51:35','2026-03-01 16:55:26'),
(196,188,'','Magsaysay Village, La Paz, Iloilo City',10.71132000,122.56202020,'9166104916','Iloilo: City of Passi','NC Iloilo','2026-03-01 16:55:26','2026-03-01 16:51:35','2026-03-01 16:55:26'),
(197,189,'','Brgy. Tapikan, San Joaquin, Iloilo',10.61034380,122.16603320,'09063328810','Iloilo: Concepcion','NC Iloilo','2026-03-01 16:55:27','2026-03-01 16:51:36','2026-03-01 16:55:27'),
(198,190,'','Rizal, Jordan, Guimaras',10.66620110,122.59665490,'9993902066','Iloilo: Iloilo City (Provincial Capitol)','NC Iloilo','2026-03-01 16:55:27','2026-03-01 16:51:36','2026-03-01 16:55:27'),
(199,191,'','Brgy. Misi, Lambunao, Iloilo',11.05289330,122.45783070,'0998-3362-190','Iloilo: Lambunao','NC Iloilo','2026-03-01 16:55:27','2026-03-01 16:51:36','2026-03-01 16:55:27'),
(200,192,'','17 Quezon St., Miagao, Iloilo',10.64665900,122.23309630,'9553412009','Iloilo: Miagao','NC Iloilo','2026-03-01 16:55:28','2026-03-01 16:51:37','2026-03-01 16:55:28'),
(201,193,'','Cagbang, Oton',10.70125800,122.50615630,'09125143232','Iloilo: Oton','NC Iloilo','2026-03-01 16:55:28','2026-03-01 16:51:37','2026-03-01 16:55:28'),
(202,194,'','Deca 2 Ph 1 Blk 33 Lot 23 Jibao-an, Pavia, Iloilo',10.75462160,122.51181480,'0907-1427863','Iloilo: Pavia','NC Iloilo','2026-03-01 16:55:28','2026-03-01 16:51:38','2026-03-01 16:55:28'),
(203,195,'','Brgy. Cabolo-an Sur, Oton, Iloilo',10.74212200,122.48210440,'9505152724','Iloilo: San Miguel','NC Iloilo','2026-03-01 16:55:29','2026-03-01 16:51:38','2026-03-01 16:55:29'),
(204,196,'','Brgy. Bularan, Banate, Iloilo',11.00285780,122.82361130,'9064856463','Iloilo: Banate','NC Iloilo','2026-03-01 16:55:29','2026-03-01 16:51:38','2026-03-01 16:55:29'),
(205,197,'','Brgy. Apelo, Sara, Iloilo',11.24962520,122.97475120,'9929190471','Iloilo: Ajuy','NC Iloilo','2026-03-01 16:55:30','2026-03-01 16:51:39','2026-03-01 16:55:30'),
(206,198,'','183-E Brgy. Bonifacio Tanza, Iloilo City',10.69245040,122.55813190,'9388776538','Iloilo: Zarraga','NC Iloilo','2026-03-01 16:55:30','2026-03-01 16:51:39','2026-03-01 16:55:30'),
(207,199,'','Allera Street, Tigbauan, Iloilo',10.67296890,122.37703570,'9691346437','Iloilo: Guimbal','NC Iloilo','2026-03-01 16:55:30','2026-03-01 16:51:39','2026-03-01 16:55:30'),
(208,200,'','Brgy. Cagamutan Sur, Leganes, Iloilo',10.79339910,122.58958750,'9509448125','Iloilo: Barotac Nuevo','NC Iloilo','2026-03-01 16:55:31','2026-03-01 16:51:40','2026-03-01 16:55:31'),
(209,201,'','Brgy. Macatol, Pototan, Iloilo',10.97166880,122.63057150,'9501419897','Iloilo: Pototan','NC Iloilo','2026-03-01 16:55:31','2026-03-01 16:51:40','2026-03-01 16:55:31'),
(210,202,'','Bat-os, Tambaliza, Concepcion, Iloilo',11.27776070,123.16326650,'9814960156','Iloilo: Estancia','NC Iloilo','2026-03-01 16:55:31','2026-03-01 16:51:41','2026-03-01 16:55:31'),
(211,203,'','29 C Arguelles st. Jaro Iloilo City',10.72626090,122.55510610,'9073386987','Iloilo: Santa Barbara','NC Iloilo','2026-03-01 16:55:32','2026-03-01 16:51:41','2026-03-01 16:55:32'),
(212,204,'','Brgy. Baluyan Cabatuan, Iloilo',10.90821190,122.49226830,'9485049616','Iloilo: Cabatuan','NC Iloilo','2026-03-01 16:55:32','2026-03-01 16:51:41','2026-03-01 16:55:32'),
(213,205,'','Z-5 Molo Boulevard, Iloilo City',10.68826520,122.54929440,'9094343660','Iloilo: Leon','NC Iloilo','2026-03-01 16:55:32','2026-03-01 16:51:42','2026-03-01 16:55:32'),
(214,206,'','Brgy. Bliss Site, Dalid, Calinog, Iloilo',11.10972750,122.53232420,'9663151753','Iloilo: Calinog','NC Iloilo','2026-03-01 16:55:33','2026-03-01 16:51:42','2026-03-01 16:55:33'),
(215,207,'','Santiago, Barotac Viejo, Iloilo',11.05418550,122.90431800,'9278167436','Iloilo: Barotac Viejo','NC Iloilo','2026-03-01 16:55:33','2026-03-01 16:51:42','2026-03-01 16:55:33'),
(216,208,'','Villa Carolina, Arevalo, Iloilo City',10.68286350,122.51924110,'9489219929','Iloilo: Dingle','NC Iloilo','2026-03-01 16:55:34','2026-03-01 16:51:43','2026-03-01 16:55:34'),
(217,209,'','Brgy. Ubos Ilaya, Miagao Iloilo',10.64594810,122.23489970,'9298853031','Iloilo: San Joaquin','NC Iloilo','2026-03-01 16:55:34','2026-03-01 16:51:43','2026-03-01 16:55:34'),
(218,210,'','Brgy. Zerrudo, Sara, Iloilo',11.23195120,123.03142870,'9309378193','Iloilo: Sara','NC Iloilo','2026-03-01 16:55:34','2026-03-01 16:51:43','2026-03-01 16:55:34'),
(219,211,'','2nd St., Manuela Subd., Brgy. Cagamutan Sur, Leganes, Iloilo',10.78862540,122.59609560,'9397161100','Iloilo: Leganes','NC Iloilo','2026-03-01 16:55:35','2026-03-01 16:51:44','2026-03-01 16:55:35'),
(220,212,'','Brgy. Santa Monica, Oton, Iloilo',10.74435650,122.45238550,'9465250947','Iloilo: Tigbauan','NC Iloilo','2026-03-01 16:55:35','2026-03-01 16:51:44','2026-03-01 16:55:35'),
(221,213,'','Barangay Tabat, Tubungan, Iloilo',10.75376600,122.30791700,'9480478042','Iloilo: Tubungan','NC Iloilo','2026-03-01 16:55:35','2026-03-01 16:51:45','2026-03-01 16:55:35'),
(222,214,'','Brgy. Lambuyao Oton,Iloilo',10.69430490,122.48779870,'9457096850','ILOILO: Alimodian','NC Iloilo','2026-03-01 16:55:36','2026-03-01 16:51:45','2026-03-01 16:55:36'),
(223,215,'','Don T. Lutero Center, Janiuay, Iloilo',10.95054050,122.50456480,'9179023191','ILOILO: Janiuay','NC Iloilo','2026-03-01 16:55:36','2026-03-01 16:51:45','2026-03-01 16:55:36'),
(224,216,'','Brgy. Jardin Dumangas, Iloilo',10.81521890,122.71672570,'9187619301','ILOILO: Dumangas','NC Iloilo','2026-03-01 16:55:37','2026-03-01 16:51:46','2026-03-01 16:55:37'),
(225,217,'','Brgy. Poblacion, San Dionisio, Iloilo',11.27040090,123.09437340,'9162786299','ILOILO: San Dionisio','NC Iloilo','2026-03-01 16:55:37','2026-03-01 16:51:46','2026-03-01 16:55:37'),
(226,218,'','Brgy. Cubay, San Dionisio, Iloilo',11.34141070,123.09516640,'9811571495','ILOILO: Carles','NC Iloilo','2026-03-01 16:55:37','2026-03-01 16:51:46','2026-03-01 16:55:37'),
(227,219,'','Brgy. Singay, Mina, Iloilo',10.92467390,122.58110610,'9617954231','ILOILO: Mina','NC Iloilo','2026-03-01 16:55:38','2026-03-01 16:51:47','2026-03-01 16:55:38'),
(228,220,'','Brgy. Budiaue, Badiangan, Iloilo',10.96776440,122.54925200,'9165444758','ILOILO: Badiangan','NC Iloilo','2026-03-01 16:55:38','2026-03-01 16:51:47','2026-03-01 16:55:38'),
(229,221,'','Zone 4 Brgy. Daja, Maasin, Iloilo',10.91439490,122.43662350,'09506217131/09919648385','ILOILO: Maasin','NC Iloilo','2026-03-01 16:55:38','2026-03-01 16:51:47','2026-03-01 16:55:38'),
(230,222,'','Brgy. Baclayan, New Lucena, Iloilo',10.86883970,122.58534690,'09151773815/09511355216','ILOILO: New Lucena','NC Iloilo','2026-03-01 16:55:39','2026-03-01 16:51:48','2026-03-01 16:55:39'),
(231,223,'','Brgy. Balibagan Oeste, Sta. Barbara, Iloilo',10.80728470,122.51322940,'9519132844','ILOILO: Iloilo City (City Hall BRC)','NC Iloilo','2026-03-01 16:55:39','2026-03-01 16:51:48','2026-03-01 16:55:39'),
(232,224,'','Brgy. Gaub, Cabatuan, Iloilo',10.84509810,122.49483840,'9350367290','ILOILO: Bingawan','NC Iloilo','2026-03-01 16:55:39','2026-03-01 16:51:49','2026-03-01 16:55:39'),
(233,225,'','Brgy. Janipaan Olo Cabatuan, Iloiilo',10.92675160,122.51181480,'9514260469','ILOILO: Dueñas','NC Iloilo','2026-03-01 16:55:40','2026-03-01 16:51:49','2026-03-01 16:55:40'),
(234,226,'','Brgy. Tabunacan, Miagao, Iloilo',10.63835590,122.19376110,'9266524773','ILOILO: Igbaras','NC Iloilo','2026-03-01 16:55:40','2026-03-01 16:51:49','2026-03-01 16:55:40'),
(235,227,'','Brgy. Alinsolong, Batad, Iloilo',11.39796730,123.13655860,'9300350013','Iloilo: Batad','NC Iloilo','2026-03-01 16:55:41','2026-03-01 16:51:50','2026-03-01 16:55:41'),
(236,228,'','Brgy. Bagacay, San Rafael, Iloilo',11.17493680,122.86203430,'9095541949','Iloilo: San Enrique','NC Iloilo','2026-03-01 16:55:41','2026-03-01 16:51:50','2026-03-01 16:55:41'),
(237,229,'','Brgy. Nalumsan, Carles, Iloilo',11.49660790,123.08734080,'9307300283','Iloilo: Balasan','NC Iloilo','2026-03-01 16:55:41','2026-03-01 16:51:50','2026-03-01 16:55:41'),
(238,230,'','Brgy.Calaigang, San Rafael, Iloilo',11.18124540,122.85075570,'9486511378','Iloilo: San Rafael','NC Iloilo','2026-03-01 16:55:42','2026-03-01 16:51:51','2026-03-01 16:55:42'),
(239,231,'','San Juan St., Barangay 10, Bacolod City, Negros Occidental',10.67350950,122.94686510,'9481351612','Negros Occidental: Bacolod City (DTI)','NC Negros Occidental','2026-03-01 16:55:42','2026-03-01 16:51:51','2026-03-01 16:55:42'),
(240,232,'','Alunan Avenue, Brgy. 35, Bacolod City, Negros Occidental',10.66587360,122.93684270,'09293581534','Negros Occidental: Bacolod City (DTI)','NC Negros Occidental','2026-03-01 16:55:43','2026-03-01 16:51:52','2026-03-01 16:55:43'),
(241,233,'','Blk 51 Lot14 Deca Homes South, Brgy.Cabug, Bacolod City, Negros Occoidental',10.59549120,122.94867550,'9053070285','Negros Occidental: Bacolod City (DTI)','NC Negros Occidental','2026-03-01 16:55:43','2026-03-01 16:51:52','2026-03-01 16:55:43'),
(242,234,'','Blk 4 Lot 2 Villasor Subd., Brgy. Handumanan, Bacolod City, Negros Occidental',10.62833540,122.92886010,'9617393594','Negros Occidental: Bacolod City (Provincial Capitol)','NC Negros Occidental','2026-03-01 16:55:43','2026-03-01 16:51:52','2026-03-01 16:55:43'),
(243,235,'','Rafael Salas Dr, Brgy. Sampinit, Bago City, Negros Occidental',10.50340500,122.96630180,'9952615233','Negros Occidental: Bago City','NC Negros Occidental','2026-03-01 16:55:44','2026-03-01 16:51:53','2026-03-01 16:55:44'),
(244,236,'','Purok 2, Brgy. Linao, Kabankalan City, Negros Occidental',9.98324100,122.79152220,'9707424479','Negros Occidental: City of Kabankalan','NC Negros Occidental','2026-03-01 16:55:44','2026-03-01 16:51:53','2026-03-01 16:55:44'),
(245,237,'','Purok 11, Brgy. Poblacion, Cauayan, Negros Occidental',9.95325040,122.62209340,'09774904151/09385246385','Negros Occidental: City of Sipalay','NC Negros Occidental','2026-03-01 16:55:44','2026-03-01 16:51:53','2026-03-01 16:55:44'),
(246,238,'','Zone 4, VMC Site, Brgy. VI-A, Victorias City, 6119, Negros Occidental',10.90666130,123.07397750,'9196148981','Negros Occidental: City of Victorias','NC Negros Occidental','2026-03-01 16:55:45','2026-03-01 16:51:54','2026-03-01 16:55:45'),
(247,239,'','Relocation Site 1, Proper, Barangay Batuan, La Carlota City, Negros Occidental',10.44576690,122.90665720,'9924346416','Negros Occidental: La Carlota City','NC Negros Occidental','2026-03-01 16:55:45','2026-03-01 16:51:54','2026-03-01 16:55:45'),
(248,240,'','Julita Drive, Villa Julita Subdivision, Brgy. IV Pob., Himamaylan City, Negros Occidental',10.09667960,122.88458780,'9178965751/09262004283','Negros Occidental: Himamaylan','NC Negros Occidental','2026-03-01 16:55:45','2026-03-01 16:51:54','2026-03-01 16:55:45'),
(249,241,'','Purok 1, Brgy. Tiling Cauayan, Negros Occidental',12.66788930,123.98813930,'09278900903/09916779962','Negros Occidental: Cauayan','NC Negros Occidental','2026-03-01 16:55:46','2026-03-01 16:51:55','2026-03-01 16:55:46'),
(250,242,'','Purok 1, Brgy. 2 Poblacion, Hinoba-an, Negros Occidental',9.60049120,122.47209300,'9102728705','Negros Occidental: Hinobaan','NC Negros Occidental','2026-03-01 16:55:46','2026-03-01 16:51:55','2026-03-01 16:55:46'),
(251,243,'','Crossing Moises, Brgy. Camangcamang, Isabela, Negros Occidental',10.17177290,122.99367170,'9388900363','Negros Occidental: Isabela','NC Negros Occidental','2026-03-01 16:55:47','2026-03-01 16:51:56','2026-03-01 16:55:47'),
(252,244,'','Rizal St., Brgy. 3 (Pob.), San Carlos City, Negros Occidental',10.48250150,123.42133510,'9662365358','Negros Occidental: San Carlos City','NC Negros Occidental','2026-03-01 16:55:47','2026-03-01 16:51:56','2026-03-01 16:55:47'),
(253,245,'','Purok Golden Rosary, Brgy. Enclaro, Binalbagan, Negros Occ.',10.17700200,122.85831660,'9108064313','Negros Occidental: Binalbagan','NC Negros Occidental','2026-03-01 16:55:47','2026-03-01 16:51:56','2026-03-01 16:55:47'),
(254,246,'','Narra Heights, Brgy. Tinampa-an, Cadiz City, Negros Occidental',10.92634750,123.30932800,'0956 4014 666','Negros Occidental: Cadiz City','NC Negros Occidental','2026-03-01 16:55:48','2026-03-01 16:51:57','2026-03-01 16:55:48'),
(255,247,'','Varca St. Toril, Brgy. Balintawak, Escalante City, Neg. Occ.',10.83949930,123.49697070,'9392440680','Negros Occidental: Escalante City','NC Negros Occidental','2026-03-01 16:55:48','2026-03-01 16:51:57','2026-03-01 16:55:48'),
(256,248,'','Purok 1 Brgy. Palaka Valladolid, Negros Occidental',10.47496250,122.82185940,'9203993299','Negros Occidental: San Enrique','NC Negros Occidental','2026-03-01 16:55:48','2026-03-01 16:51:57','2026-03-01 16:55:48'),
(257,249,'','Purok Ipil-Ipil, Brgy. San Juan, Pontevedra, Negros Occidental',10.35265910,122.92122650,'9942523568','Negros Occidental: Pontevedra','NC Negros Occidental','2026-03-01 16:55:49','2026-03-01 16:51:58','2026-03-01 16:55:49'),
(258,250,'','Purok 1, Brgy. Magallon Cadre, Moises Padilla Negros Occidental',10.29018880,123.08452770,'9508950393','Negros Occidental: Talisay City','NC Negros Occidental','2026-03-01 16:55:49','2026-03-01 16:51:58','2026-03-01 16:55:49'),
(259,251,'','Purok Rambutan, Brgy. Bunga, Salvador Benedicto, Negros Occidental',10.54198060,123.25049130,'9851386054','Negros Occidental: Silay City','NC Negros Occidental','2026-03-01 16:55:50','2026-03-01 16:51:59','2026-03-01 16:55:50'),
(260,252,'','Barangay Buenavista, Calatrava, Negros Occidental. 6126',10.54738080,123.44115590,'9155812126','NEGROS OCCIDENTAL: Toboso','NC Negros Occidental','2026-03-01 16:55:50','2026-03-01 16:51:59','2026-03-01 16:55:50'),
(261,253,'','Blk 99 Lot 31, Phase 1, Cedric St., Celine Homes Subd., Brgy. Estefania, Bacolod City, Neg. Occ.',10.67096460,122.99446360,'09916774838/09474224195','NEGROS OCCIDENTAL: Valladolid','NC Negros Occidental','2026-03-01 16:55:50','2026-03-01 16:51:59','2026-03-01 16:55:50'),
(262,254,'','Lot 1 & 3 Blk. 5 San Esteban Phase 1, Brgy. Lag-asan, Bago City, Neg. Occ. 6101',17.32737060,120.45304560,'09154992277','NEGROS OCCIDENTAL: Pulupandan','NC Negros Occidental','2026-03-01 16:52:06','2026-03-01 16:52:00','2026-03-01 16:52:06'),
(263,255,'','Purok 6, Brgy. IX Daan Banwa, Victorias City, Negros Occidental',10.90576080,123.06624000,'09567415383','NEGROS OCCIDENTAL: Manapla','NC Negros Occidental','2026-03-01 16:52:06','2026-03-01 16:52:00','2026-03-01 16:52:06'),
(264,256,'','Sitio Bumba, Brgy. Calampisawan, Calatrava, Negros Occidental',10.61073900,123.48038890,'09667345842','NEGROS OCCIDENTAL: Calatrava','NC Negros Occidental','2026-03-01 16:52:07','2026-03-01 16:52:00','2026-03-01 16:52:07'),
(265,257,'','Purok Tan-ag, Brgy. Damsite, Murcia, Negros Occidental 6129, Philippines',10.55246360,123.00572610,'9153670443/09650250839','NEGROS OCCIDENTAL: Murcia','NC Negros Occidental','2026-03-01 16:52:07','2026-03-01 16:52:01','2026-03-01 16:52:07'),
(266,258,'','Purok Caimito, Brgy. Bunga Don Salvador Benedicto Negros Occidental',10.54198060,123.25049130,'9478453657','NEGROS OCCIDENTAL: Don Salvador Benedicto','NC Negros Occidental','2026-03-01 16:52:07','2026-03-01 16:52:01','2026-03-01 16:52:07'),
(267,259,'','Q. Manzano St., Purok Rose, Brgy. East, Candoni, Negros Occidental',9.82785530,122.64403380,'9971676498','NEGROS OCCIDENTAL: Candoni','NC Negros Occidental','2026-03-01 16:52:08','2026-03-01 16:52:01','2026-03-01 16:52:08'),
(268,260,NULL,NULL,14.56540000,121.02200000,NULL,NULL,NULL,'2026-03-01 18:57:01','2026-03-01 18:57:01','2026-03-01 18:57:01');
/*!40000 ALTER TABLE `employee_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
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
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
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
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_02_28_000001_create_employee_locations_table',2),
(5,'2026_03_02_000001_add_extended_fields_to_employee_locations_table',3),
(6,'2026_03_02_000002_add_is_admin_to_users_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
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
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
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
INSERT INTO `sessions` VALUES
('BJ9wAxrCXapYWpdk64PrrCHhQ3jhT5zfywKU1bzk',260,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZWJjem9zMXE4N0dNbXhHd2NxRjhHQkN3NGl4cERNaU5XYWM0SnlsNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI2MDt9',1772591874),
('IwHfDItcKjIgukAvGi6WH2WdPuuPaPfMELO0R5Le',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:148.0) Gecko/20100101 Firefox/148.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTHN4bXM3cmxHYjBSNUxMWHhEUTNlREQwM1Jqd3hYd2tZUGJCVnlFUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1772590174),
('KC56KlneipAtqd48EwfOuJKis0VmcAQy3ViSEfT2',NULL,'127.0.0.1','curl/8.15.0','YToyOntzOjY6Il90b2tlbiI7czo0MDoiMWhUeks3MXlXWmVHRGJTVVFaS015bEs3bVR2WlYzSDlITU03ZllaTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1772591450);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Admin User','admin@example.com',NULL,'$2y$12$TQbxs44G8ff6zCci/dAMU.quO20DWMi9bVLuPyZMlXYK0URU4nH8.',0,NULL,'2026-02-28 07:55:22','2026-02-28 07:55:22'),
(2,'Janice T. Abellar','janice.t.abellar.6-013@dti6.gov.ph',NULL,'$2y$12$2pXpYsDm70uON6rsHL5ct.sA73bcaf5RRzGJUWqOqsqAh34yLP69W',0,NULL,'2026-03-01 16:50:26','2026-03-01 16:50:26'),
(3,'Florenda Octoberiana C. Abian','florenda.octoberiana.c.abian.6-156@dti6.gov.ph',NULL,'$2y$12$U817pPg/igdsQRCLqxBLau5ukMuWg8EcXYLG2nSgnIyyvCh9bHHUW',0,NULL,'2026-03-01 16:50:27','2026-03-01 16:50:27'),
(4,'Charlene Joy A. Adeja','charlene.joy.a.adeja.6-045@dti6.gov.ph',NULL,'$2y$12$w8GL6Q9iZN4BQB46qIEkeOYubdPi/J2srA9Stg.TGuxJ7SNwWvexe',0,NULL,'2026-03-01 16:50:27','2026-03-01 16:50:27'),
(5,'Gabriel I. Advincula','gabriel.i.advincula.6-067@dti6.gov.ph',NULL,'$2y$12$ypDsTO6wMqhrRYG/RycoIOI4vvCv4F9AnTHN5hKynEFrKORBC8hDW',0,NULL,'2026-03-01 16:50:27','2026-03-01 16:50:27'),
(6,'Daniel S. Agan','daniel.s.agan.6-162@dti6.gov.ph',NULL,'$2y$12$6vfPd/il42VrKcU72OR7sea10jhAqtwOLuFWYpTyHOqXuA.kpjHkK',0,NULL,'2026-03-01 16:50:28','2026-03-01 16:50:28'),
(7,'Aurora Teresa J. Alisen','aurora.teresa.j.alisen.6-041@dti6.gov.ph',NULL,'$2y$12$.h5R7I8FZBcGuy/KlWogwuE4AsZ3.GSNdwcpV7OJ3OxoMA/ZmhUy2',0,NULL,'2026-03-01 16:50:28','2026-03-01 16:50:28'),
(8,'Mary Ann -. Alteros','mary.ann.alteros.cos-il-030@dti6.gov.ph',NULL,'$2y$12$LWUf/3rQfReLVmrJ6YxwLeUXq/Z6EVz75cdn9SzR8fSsaNK9ekfvC',0,NULL,'2026-03-01 16:50:28','2026-03-01 16:50:28'),
(9,'Romel L. Amihan','romel.l.amihan.6-027@dti6.gov.ph',NULL,'$2y$12$C74z5VsHn5YbAJBLEmzcpeUoO7f0dUo47TjBvno7S467L/MqOWewm',0,NULL,'2026-03-01 16:50:29','2026-03-01 16:50:29'),
(10,'He Jean C. Antonio','he.jean.c.antonio.2024-ilo-004@dti6.gov.ph',NULL,'$2y$12$LzvyOBr0q74HkVHLVPcTe.dus0enhrhXsa47XHtJkDAx6E/Gl17La',0,NULL,'2026-03-01 16:50:29','2026-03-01 16:50:29'),
(11,'Anelyn L. Apiag','anelyn.l.apiag.6-053@dti6.gov.ph',NULL,'$2y$12$LtNIyvwSn43xVM9eJ6Ynd.S8mdcUUutF/d8PYerBsjPTZYmNjl0eG',0,NULL,'2026-03-01 16:50:29','2026-03-01 16:50:29'),
(12,'Roxanne B. Arbatin','roxanne.b.arbatin.6-025@dti6.gov.ph',NULL,'$2y$12$n1EkPHQpUCrp9OgdfNas/.AeKSqZTmRCVe8LHMJzXl3gMY1FYasza',0,NULL,'2026-03-01 16:50:30','2026-03-01 16:50:30'),
(13,'May Ann S. Arca','may.ann.s.arca.cos6-002@dti6.gov.ph',NULL,'$2y$12$aaeEx9skvCVFjcQtEQkXn..ULQIHwKa3ZuPpVhQBn//s0QDfPwOQ.',0,NULL,'2026-03-01 16:50:30','2026-03-01 16:50:30'),
(14,'Merian A. Asas','merian.a.asas.6-082@dti6.gov.ph',NULL,'$2y$12$vNzwQ/0AMp7nevqn1RRlCuyTeICrdE2cOzGzJja26tZyuFjjkRnAi',0,NULL,'2026-03-01 16:50:31','2026-03-01 16:50:31'),
(15,'Maria Victoria D. Aspera','maria.victoria.d.aspera.6-157@dti6.gov.ph',NULL,'$2y$12$sNyySQE7cdQHjvAQ9k76uuz.Nd2jBFX1zD.5WU5IroPg8w9szfOma',0,NULL,'2026-03-01 16:50:31','2026-03-01 16:50:31'),
(16,'Mia A. Aujero','mia.a.aujero.6-049@dti6.gov.ph',NULL,'$2y$12$Xc/l4hu2lbZoaTlxoFvWK.Cs2819Zqv8m7MvHtGQnLA2MV5B5Ktju',0,NULL,'2026-03-01 16:50:31','2026-03-01 16:50:31'),
(17,'Ma. Bianka Lou M. Ayon','ma.bianka.lou.m.ayon.6-069@dti6.gov.ph',NULL,'$2y$12$XP0sRWUVSppZrf8LzIfGJujO1iwPCtNk4dgrJOkHbA0rmnzIUloVC',0,NULL,'2026-03-01 16:50:32','2026-03-01 16:50:32'),
(18,'Judy Ann P. Bandiola - Rendon N/a.','judy.ann.p.bandiola.rendon.na.6-019@dti6.gov.ph',NULL,'$2y$12$Ub5W/AAiKvblGRSHNGWvsOlb5/LPODnALR0b/jTqzLOvQzYOVW6em',0,NULL,'2026-03-01 16:50:32','2026-03-01 16:50:32'),
(19,'Ma. Aurora E. Bangcaya','ma.aurora.e.bangcaya.6-158@dti6.gov.ph',NULL,'$2y$12$zdeO41CnorGq6egXlv4R/uMqhWz6ekOeyZosWPcONSufVhqAs7SBW',0,NULL,'2026-03-01 16:50:33','2026-03-01 16:50:33'),
(20,'Rowena D. Barcelona','rowena.d.barcelona.c6-003@dti6.gov.ph',NULL,'$2y$12$ExCxj.XXYx6fTYGfaafcnutcnsApobgF3snbIsU3Ce1f/b0tDBmFu',0,NULL,'2026-03-01 16:50:33','2026-03-01 16:50:33'),
(21,'Ma. Rona T. Bartolay','ma.rona.t.bartolay.6-071@dti6.gov.ph',NULL,'$2y$12$lxsSBFGEVXNWYMuORre4PeIg3K8HLlqkeyoDsjMJVIf7RIvQC1EwC',0,NULL,'2026-03-01 16:50:33','2026-03-01 16:50:33'),
(22,'Frauleine B. Bautista','frauleine.b.bautista.6-029@dti6.gov.ph',NULL,'$2y$12$0JV.SHYgZGx1/TJI.Z7cduWr90HP1tOJkv8eBqMaVEWzHiPav735G',0,NULL,'2026-03-01 16:50:34','2026-03-01 16:50:34'),
(23,'Ma. Neipi Jane A. Bautista','ma.neipi.jane.a.bautista.6-065@dti6.gov.ph',NULL,'$2y$12$Hwr7IyjCakjyv4OjMDIjFeUC158an.aLx.Bk1Rj26TheBQW4Mfs/y',0,NULL,'2026-03-01 16:50:34','2026-03-01 16:50:34'),
(24,'Marianne T. Bebit','marianne.t.bebit.2023-004@dti6.gov.ph',NULL,'$2y$12$.y5qWeaFdPAN/utz8sflr.wLiEcxTPIxgya87keeXEg3CkyUBJxLK',0,NULL,'2026-03-01 16:50:34','2026-03-01 16:50:34'),
(25,'Verna A. Belegera','verna.a.belegera.c6-145@dti6.gov.ph',NULL,'$2y$12$ARXdd/gRNtSdHVfUCtZfYePVV0ptiurE30CQiwPnc6oxTxakBnSgi',0,NULL,'2026-03-01 16:50:35','2026-03-01 16:50:35'),
(26,'Grace M. Benedicto','grace.m.benedicto.6-138@dti6.gov.ph',NULL,'$2y$12$lxS7aPZV8s/xUFYANt1X/eyiGvkjuwfWaLetttesMs8FMQVKNcZ6O',0,NULL,'2026-03-01 16:50:35','2026-03-01 16:50:35'),
(27,'Jose Jonathan B. Benedicto','jose.jonathan.b.benedicto.6-077@dti6.gov.ph',NULL,'$2y$12$NUKc0CYYjsEa06kp.Stx2.i.fUkKqSp.ion7NMBqmC8M1dkOEm8jC',0,NULL,'2026-03-01 16:50:36','2026-03-01 16:50:36'),
(28,'Jomar B. Benedicto','jomar.b.benedicto.6-009@dti6.gov.ph',NULL,'$2y$12$pVtBQA2ABkWz9c8kl75W7eXX.U3.X8TVh9jw1AuVCjPH60aUqtx2e',0,NULL,'2026-03-01 16:50:36','2026-03-01 16:50:36'),
(29,'John Mchale C. Benid','john.mchale.c.benid.6-037@dti6.gov.ph',NULL,'$2y$12$R8iRZxS/wNhfFbThMWrYquCEQOSEIFcWEzw62zQvnXKYtrnlBpqNe',0,NULL,'2026-03-01 16:50:36','2026-03-01 16:50:36'),
(30,'Juvy D. Benliro','juvy.d.benliro.6-083@dti6.gov.ph',NULL,'$2y$12$YHttQiCkO6Yeb4x9aEHfZ.qMKCt2PfK/Q8usRB1lup3JIiiFCBqSy',0,NULL,'2026-03-01 16:50:37','2026-03-01 16:50:37'),
(31,'Mariecon A. Burla','mariecon.a.burla.6-026@dti6.gov.ph',NULL,'$2y$12$sbEnca27NCLGpew/FVAUM.nwkuW2O9mxVyDziuQwHxZ3c6Ra28DEy',0,NULL,'2026-03-01 16:50:37','2026-03-01 16:50:37'),
(32,'Sherlyn Y. Canales','sherlyn.y.canales.cos-il-001@dti6.gov.ph',NULL,'$2y$12$WRThSzc0/CJVQbMW/i/g9ug5mvcii1BvKPJ19MC//vFsoblSARABi',0,NULL,'2026-03-01 16:50:37','2026-03-01 16:50:37'),
(33,'Lynna Joy B. Cardinal','lynna.joy.b.cardinal.6-072@dti6.gov.ph',NULL,'$2y$12$NLej5LcFseT3z/G2CKfuq.9tN6QKSZDUYltcDF593QEv56ubXW91.',0,NULL,'2026-03-01 16:50:38','2026-03-01 16:50:38'),
(34,'Ma. Dorita D. Chavez','ma.dorita.d.chavez.6-046@dti6.gov.ph',NULL,'$2y$12$F7vlhIdy18LkqP3nSrRLIerkb7FofjiByuDsnVYFPmpjrWbvO0n6S',0,NULL,'2026-03-01 16:50:38','2026-03-01 16:50:38'),
(35,'Florielee S. Clavel','florielee.s.clavel.c6-040@dti6.gov.ph',NULL,'$2y$12$3Gd.27oaJpFi1LPGSi2HJ.pC8kNSEHMBoyWpP3taA6Kx3Nu5Z2APa',0,NULL,'2026-03-01 16:50:39','2026-03-01 16:50:39'),
(36,'Dicof D. Cofreros','dicof.d.cofreros.c6-014@dti6.gov.ph',NULL,'$2y$12$rqPJIf9USOOBvvpniyUSoOhP69eAY/.cM7tZ6h4ZgdMi3Nj3MLRRO',0,NULL,'2026-03-01 16:50:39','2026-03-01 16:50:39'),
(37,'Bemy John A. Collado','bemy.john.a.collado.6-038@dti6.gov.ph',NULL,'$2y$12$XRtBLnvrwDNgEjPPQsjTceKYB3C5DuVgFvvxcTANZW2TBjjwYFpn2',0,NULL,'2026-03-01 16:50:39','2026-03-01 16:50:39'),
(38,'Juan Carlos V. Corros','juan.carlos.v.corros.6-043@dti6.gov.ph',NULL,'$2y$12$pwGJFwGmBSUDBCBD2GlIdebA8ENUWFxAaToZMqi3zgbCTb1Rs0Ee6',0,NULL,'2026-03-01 16:50:40','2026-03-01 16:50:40'),
(39,'Ken Queenie R. CuÑada','ken.queenie.r.cunada.6-087@dti6.gov.ph',NULL,'$2y$12$AqvdkKEjL87xnylvEn8U.OKlFRuzKcvEtiYFXWiD3tlk.rycTqfy6',0,NULL,'2026-03-01 16:50:40','2026-03-01 16:50:40'),
(40,'Sheryl E. Dioteles','sheryl.e.dioteles.6-155@dti6.gov.ph',NULL,'$2y$12$RYxnTXtkGE7Xj683U1A3v.wnTuZ.74ei.DrpPytX.atbSnU3gpL2m',0,NULL,'2026-03-01 16:50:40','2026-03-01 16:50:40'),
(41,'Althone L. Dy','althone.l.dy.6-070@dti6.gov.ph',NULL,'$2y$12$NpnBj6HUoTnPodZ/InU5tu6YTEFQlpCYFPtf5to4Z4DP1bkzdhWEu',0,NULL,'2026-03-01 16:50:41','2026-03-01 16:50:41'),
(42,'Rheyzia Marie V. Elgario','rheyzia.marie.v.elgario.dticosmonitors-004@dti6.gov.ph',NULL,'$2y$12$v4c9sI3FdlX0yR3KcgX1uu9AZVnHvAeVdQZ/VZS6Y7mFJl5h1P./G',0,NULL,'2026-03-01 16:50:41','2026-03-01 16:50:41'),
(43,'Joy Anne S. Erazo','joy.anne.s.erazo.c6-007@dti6.gov.ph',NULL,'$2y$12$W4eyJpXG7e7k.XZsxUGAdOgN3iLILSApsv0Ic1vu7CQ0ML/pbNNe.',0,NULL,'2026-03-01 16:50:42','2026-03-01 16:50:42'),
(44,'Tathiana Bianca E. Espinal','tathiana.bianca.e.espinal.cos6-006@dti6.gov.ph',NULL,'$2y$12$EP3WaUOakwU3c96QVeNWVu4ELbnEdr7vFfifbtm0d5xrmMXjkeXMa',0,NULL,'2026-03-01 16:50:42','2026-03-01 16:50:42'),
(45,'Mutya D. Eusores','mutya.d.eusores.6-154@dti6.gov.ph',NULL,'$2y$12$jnFbfAO43Ziic9LYY6Qp.uWQZONp3H544Vl6gMD.cQJBd6nZkz8BO',0,NULL,'2026-03-01 16:50:42','2026-03-01 16:50:42'),
(46,'Rosie Y. Evangelista','rosie.y.evangelista.6-105@dti6.gov.ph',NULL,'$2y$12$kdbYzJm9AooGjzBxD4YG2OcmsWrW39x3rMv7rrF10BvV6yT.EoLoq',0,NULL,'2026-03-01 16:50:43','2026-03-01 16:50:43'),
(47,'Cheryl D. Fernandez','cheryl.d.fernandez.6-128@dti6.gov.ph',NULL,'$2y$12$.MASI9fnNBDkEAHW3Srt5eW.MBybGXV4zbz.BwZJ7KTSby5Fq0Wiy',0,NULL,'2026-03-01 16:50:43','2026-03-01 16:50:43'),
(48,'Dessa Anh T. Flores','dessa.anh.t.flores.6-050@dti6.gov.ph',NULL,'$2y$12$cYk7aSm9nviT8W1QK86/L.bJbKKODg4fWQBOvYmpGrEhAAF9BSNR2',0,NULL,'2026-03-01 16:50:43','2026-03-01 16:50:43'),
(49,'Ariane L. Fuentespina','ariane.l.fuentespina.6-016@dti6.gov.ph',NULL,'$2y$12$rgUARzVl3WHLJP./MsPUyeuWIhScIyJbRojG1z57OUpkzvayRQHEm',0,NULL,'2026-03-01 16:50:44','2026-03-01 16:50:44'),
(50,'Dan Alfrei C. Fuerte','dan.alfrei.c.fuerte.cos6-004@dti6.gov.ph',NULL,'$2y$12$8rxNTxD4EVOdAS.XlOx4Ze/dpP6Z8cnOSmV4OhkRd1QmEy3zmHkki',0,NULL,'2026-03-01 16:50:44','2026-03-01 16:50:44'),
(51,'Jenny Ann J. Gabucay N/a.','jenny.ann.j.gabucay.na.6-060@dti6.gov.ph',NULL,'$2y$12$ljQtaV1qsF.IhEEQA4Hua.XMqHbbAcnoZ1HqQamSv5aADzFM.SZfK',0,NULL,'2026-03-01 16:50:45','2026-03-01 16:50:45'),
(52,'Normel E. Galvan','normel.e.galvan.6-076@dti6.gov.ph',NULL,'$2y$12$/QgIhwQRDO1ERPddLrtXsesJ0PyIC8M8Mm5NJGdcdgEAOmLEN2wra',0,NULL,'2026-03-01 16:50:45','2026-03-01 16:50:45'),
(53,'Mary Jade R. Gonzales','mary.jade.r.gonzales.6-031@dti6.gov.ph',NULL,'$2y$12$HDe5T3k7Y87Yf13/ddUPrOS/LWzujWdonB6iWsdw03etDfyDwBvVW',0,NULL,'2026-03-01 16:50:45','2026-03-01 16:50:45'),
(54,'Grace Trisha T. Hisanan','grace.trisha.t.hisanan.2024-ilo-006@dti6.gov.ph',NULL,'$2y$12$JYDgPmef4OH6E0Z4wLplHumRn.1j7yLy.qjFetXGInM8Pit0rAZsi',0,NULL,'2026-03-01 16:50:46','2026-03-01 16:50:46'),
(55,'Reginald S. Hudierez','reginald.s.hudierez.6-047@dti6.gov.ph',NULL,'$2y$12$KtdHrhH1FHERAuZ9Xk0jGuXXPou1kl5KonBaeT5qPt1f9M7TGOqEi',0,NULL,'2026-03-01 16:50:46','2026-03-01 16:50:46'),
(56,'Gelimae I. Invina','gelimae.i.invina.6-084@dti6.gov.ph',NULL,'$2y$12$i.ZMga7/bPEyvoVR8V.6X.FW6WgJskb/R0W1IxL5CSJtICI9ip8xq',0,NULL,'2026-03-01 16:50:46','2026-03-01 16:50:46'),
(57,'Daryl Mae Lorene S. Jacar','daryl.mae.lorene.s.jacar.c6-004@dti6.gov.ph',NULL,'$2y$12$sy/1UfzMhZP3GU5j8bqTiO3zJWYCB/ymg0fNFAcHxn4hMafoIhPUK',0,NULL,'2026-03-01 16:50:47','2026-03-01 16:50:47'),
(58,'Ma. Rose C. Jayona','ma.rose.c.jayona.dtinccos-062@dti6.gov.ph',NULL,'$2y$12$udiUAovfeMrEBmfMJ2rD1eQURKfP4HDmALoOlTOS2oykGEaPhEOju',0,NULL,'2026-03-01 16:50:47','2026-03-01 16:50:47'),
(59,'Rhea B. Jocsing','rhea.b.jocsing.6-134@dti6.gov.ph',NULL,'$2y$12$1F6P3Ov3sCCRnoEE2ZTBlOid8PeXafm7oCQ2K.rV6r6H2V3iChxaK',0,NULL,'2026-03-01 16:50:47','2026-03-01 16:50:47'),
(60,'Shayne G. Jornadal','shayne.g.jornadal.6-014@dti6.gov.ph',NULL,'$2y$12$LzWxq3iSXrKiBY6AXcDWN.L8Uj3KJZkUiNqSoMEHNXaQXkRsZ2dzG',0,NULL,'2026-03-01 16:50:48','2026-03-01 16:50:48'),
(61,'Kristopher Gerard P. Jovero','kristopher.gerard.p.jovero.cos6-05@dti6.gov.ph',NULL,'$2y$12$yGt5ShJ8vJiE2bU/TWbz9.j/Q3ariW7ZF/D39TsEh1zD3MkuSM26W',0,NULL,'2026-03-01 16:50:48','2026-03-01 16:50:48'),
(62,'Judith G. Kelly','judith.g.kelly.6-008@dti6.gov.ph',NULL,'$2y$12$81G.FvT0TP0xmED1lTb8F.sOBxtA8hj1GHZNgmVmMxl9r.cCFcEgy',0,NULL,'2026-03-01 16:50:49','2026-03-01 16:50:49'),
(63,'Michelle C. Ladigohon','michelle.c.ladigohon.6-007@dti6.gov.ph',NULL,'$2y$12$OYmSb3dsZJRfc5Bn9llJceGgs5dS1EoPUX27uUNaZ/s.4dSCXE/lO',0,NULL,'2026-03-01 16:50:49','2026-03-01 16:50:49'),
(64,'Kristel Joyce L. Laudenorio','kristel.joyce.l.laudenorio.6-068@dti6.gov.ph',NULL,'$2y$12$lMZh1fYWD9xR5gi8A3kSoeWRlwyORl.MQ7IxyPB9oNfIRIYRpTL6C',0,NULL,'2026-03-01 16:50:49','2026-03-01 16:50:49'),
(65,'Catherine P. Layes','catherine.p.layes.cos-il-006@dti6.gov.ph',NULL,'$2y$12$aDbQesZldvQlFuwqAVsS4.4UFZzzWEO8SXNF89oae9mohWExatxiK',0,NULL,'2026-03-01 16:50:50','2026-03-01 16:50:50'),
(66,'Rhea Jepee L. Legario','rhea.jepee.l.legario.6-015@dti6.gov.ph',NULL,'$2y$12$Cvm5a4NiTcA7/MTCryrH7ufBWv2xmg6R.4Zdy8W/o2jJa7kwODWYC',0,NULL,'2026-03-01 16:50:50','2026-03-01 16:50:50'),
(67,'Glenda S. Loloy','glenda.s.loloy.6-057@dti6.gov.ph',NULL,'$2y$12$GSbCow98UZmPRCY0YQutP.iKgCnhRByeh9EoprPa9qYpj9hZzNgRu',0,NULL,'2026-03-01 16:50:50','2026-03-01 16:50:50'),
(68,'Pristine Ellaine D. Magdaug','pristine.ellaine.d.magdaug.6-059@dti6.gov.ph',NULL,'$2y$12$3ygpf8MydVIM.Y77MO2G2Ok0NfVSDHoKpAD02EM.hKZ6IDxwlnOkC',0,NULL,'2026-03-01 16:50:51','2026-03-01 16:50:51'),
(69,'Joseph Marc C. Maguad','joseph.marc.c.maguad.2024-ilo-005@dti6.gov.ph',NULL,'$2y$12$ct8uNb74gNGKW7znqdU6ueatPLo/doMErXUqqj1zb4Ek2tjp64fUq',0,NULL,'2026-03-01 16:50:51','2026-03-01 16:50:51'),
(70,'Rl G. Marco','rl.g.marco.6-063@dti6.gov.ph',NULL,'$2y$12$fMMA2lMCYSjMuTmeUwuc2OrSqhq/sY5M4gsth2oHotY6nmh8RGMEO',0,NULL,'2026-03-01 16:50:51','2026-03-01 16:50:51'),
(71,'Therese Grace J. Marla','therese.grace.j.marla.6-160@dti6.gov.ph',NULL,'$2y$12$na3f2gWIjiljmLitiOMqGufH81Vb6LN6woEZ.4j6daxTn8ic3tNq2',0,NULL,'2026-03-01 16:50:52','2026-03-01 16:50:52'),
(72,'Romil F. Maro','romil.f.maro.6-032@dti6.gov.ph',NULL,'$2y$12$6t6/lmRhk3AG.CixN3wD1ucqai34I4Fo3Nq.liQBvVTvPBFcU809y',0,NULL,'2026-03-01 16:50:52','2026-03-01 16:50:52'),
(73,'Lyndy Exzyle D. Miranda','lyndy.exzyle.d.miranda.6-064@dti6.gov.ph',NULL,'$2y$12$OncE3SZXRL.vn9db0e4f8u/.k8Wt/FXOD226BZDR8qY8HAKsHXCBy',0,NULL,'2026-03-01 16:50:53','2026-03-01 16:50:53'),
(74,'Jazer P. Miranda','jazer.p.miranda.6-020@dti6.gov.ph',NULL,'$2y$12$lAU2H3BwkE1wL/EIbuMpJuVQCHSNLqet668Ze9znPebeYwqfxB3Mi',0,NULL,'2026-03-01 16:50:53','2026-03-01 16:50:53'),
(75,'Johna Raf M. Montalvo','johna.raf.m.montalvo.6-021@dti6.gov.ph',NULL,'$2y$12$oCNFhkF7OLNCluf3kEvBWurNAbbw81aoH7tRaw91Kpc7zDYWeKXvy',0,NULL,'2026-03-01 16:50:53','2026-03-01 16:50:53'),
(76,'Jeanne Renee V. Nedula N/a.','jeanne.renee.v.nedula.na.6-055@dti6.gov.ph',NULL,'$2y$12$xndgYV80PTavTIQngWB1JOCf3vscURumTqyxchecS6CW.h2FrMoCO',0,NULL,'2026-03-01 16:50:54','2026-03-01 16:50:54'),
(77,'Rachel N. Nufable','rachel.n.nufable.6-054@dti6.gov.ph',NULL,'$2y$12$I/FBZb2KtfTmW5yx2NRCWOWUm31Kz0JgZDuM/HJ./.TvUv4xObhhy',0,NULL,'2026-03-01 16:50:54','2026-03-01 16:50:54'),
(78,'Arnel B. Oliveros','arnel.b.oliveros.6-023@dti6.gov.ph',NULL,'$2y$12$DinXGIXVE9vRq1eClVSQHefxOuhvQffL1V6TMBgrSCZM8AJUrGQl6',0,NULL,'2026-03-01 16:50:54','2026-03-01 16:50:54'),
(79,'Rejoice S. Orquia','rejoice.s.orquia.6-044@dti6.gov.ph',NULL,'$2y$12$ZtTOhtEU1p6q2.QFaok4aepHfom5Kp.XaSKiltNAoSZT0m.xWj2ea',0,NULL,'2026-03-01 16:50:55','2026-03-01 16:50:55'),
(80,'Honey Mae F. Osimco','honey.mae.f.osimco.6-119@dti6.gov.ph',NULL,'$2y$12$zoX1RLXjAuoHO6FXOcZoU.W83.HkC5FwPXstI9Imbvt3vL1bo9aM6',0,NULL,'2026-03-01 16:50:55','2026-03-01 16:50:55'),
(81,'Rosalie A. Panganiban','rosalie.a.panganiban.6-143@dti6.gov.ph',NULL,'$2y$12$ZNI1EiB8WVnZnACTzXy9x.fOxZgR3JlFmiaOwm2MI55OqvUqNtwmy',0,NULL,'2026-03-01 16:50:56','2026-03-01 16:50:56'),
(82,'Emily S. Pasaporte','emily.s.pasaporte.6-062@dti6.gov.ph',NULL,'$2y$12$Fljsqgj128ZqZVw7ZcgP9.tv0ONnHSZ8kwPVEKXabeN9wK4/znRUW',0,NULL,'2026-03-01 16:50:56','2026-03-01 16:50:56'),
(83,'Angelo G. Patrimonio','angelo.g.patrimonio.6-006@dti6.gov.ph',NULL,'$2y$12$kteGxCw7Y4F0euN3Ia9aYul0LxK6X.GCGrVAFDyPrQRjw3A0wB8zq',0,NULL,'2026-03-01 16:50:56','2026-03-01 16:50:56'),
(84,'Eden Grace A. Perez','eden.grace.a.perez.cos-il-008@dti6.gov.ph',NULL,'$2y$12$4cDVk4I4gu6DmYMJNnaYwed/xrZ1ilJK1O.VSdIhxfwZ8IJd0Qsra',0,NULL,'2026-03-01 16:50:57','2026-03-01 16:50:57'),
(85,'Jane Russel B. Prudente','jane.russel.b.prudente.6-137@dti6.gov.ph',NULL,'$2y$12$eWK9SlPNQQP3bhKyZz6I3uWQjYKiZkAhZZWmL8EI9fdrhgLlwnka6',0,NULL,'2026-03-01 16:50:57','2026-03-01 16:50:57'),
(86,'John Cris M. Puertas','john.cris.m.puertas.cos-il-004@dti6.gov.ph',NULL,'$2y$12$KxyPidZJTvFpfjYjqe7TXeVG/oOVT4PDpmd8WR9tceFupc.Xn9trO',0,NULL,'2026-03-01 16:50:57','2026-03-01 16:50:57'),
(87,'Marimae C. Pueyo','marimae.c.pueyo.c6-037@dti6.gov.ph',NULL,'$2y$12$nd2hNv71vY28aa3sA6VIH.AiYt41c4PJyY.lgabyiyGTXm7pNx1r2',0,NULL,'2026-03-01 16:50:58','2026-03-01 16:50:58'),
(88,'Sealbia Y. Quilino','sealbia.y.quilino.6-028@dti6.gov.ph',NULL,'$2y$12$fCoujZmlDoyHI4XHDzGWDOawEpd1l3Qes8JSsU11IzL.kgg2OLDz.',0,NULL,'2026-03-01 16:50:58','2026-03-01 16:50:58'),
(89,'Lakambini T. Regalado','lakambini.t.regalado.6-121@dti6.gov.ph',NULL,'$2y$12$q.SzVzpkxhRqlNId69koYOAn6Jy0K11siiPE/ZBFw5yPrkj48p6qC',0,NULL,'2026-03-01 16:50:58','2026-03-01 16:50:58'),
(90,'Billy B. Regondon','billy.b.regondon.6-079@dti6.gov.ph',NULL,'$2y$12$fY4Vc/dnbxUIEd6fqiXxne4fa2QGQPSoXMs5QLKvEPL25dFGvs2QC',0,NULL,'2026-03-01 16:50:59','2026-03-01 16:50:59'),
(91,'Andrea S. Reyes','andrea.s.reyes.6-056@dti6.gov.ph',NULL,'$2y$12$ZSMmyzifMblJncCKUscJ5esDpky.pPFsEUs4nt4efZd06wFofZlP.',0,NULL,'2026-03-01 16:50:59','2026-03-01 16:50:59'),
(92,'Belinda B. Roldan','belinda.b.roldan.6-066@dti6.gov.ph',NULL,'$2y$12$kv1440yDu4KW6USeklbL.eQBMgl0nGbNRYS8PzfvQ8lDXbgm1632O',0,NULL,'2026-03-01 16:51:00','2026-03-01 16:51:00'),
(93,'Pamela S. Roldan','pamela.s.roldan.6-010@dti6.gov.ph',NULL,'$2y$12$Jksd32VLnf.bImZYl6wJl.KIeem92EqfnW2QQxIFL3tgKu83SmXbS',0,NULL,'2026-03-01 16:51:00','2026-03-01 16:51:00'),
(94,'Ma. Kristine B. Rosaldes','ma.kristine.b.rosaldes.6-034@dti6.gov.ph',NULL,'$2y$12$V3tneu7kpBMEKThmlSYC3OGoFQS5DYedKWbIuzAmHhpGxUpU.4T5W',0,NULL,'2026-03-01 16:51:00','2026-03-01 16:51:00'),
(95,'Judy Mae M. Sajo','judy.mae.m.sajo.6-024@dti6.gov.ph',NULL,'$2y$12$dn3ItLpAb3CEAQxU.257A.xsBiK5smy7.lAPJWzE5Oi3430t5FmNa',0,NULL,'2026-03-01 16:51:01','2026-03-01 16:51:01'),
(96,'Iris Mae I. Sarabia','iris.mae.i.sarabia.6-039@dti6.gov.ph',NULL,'$2y$12$xZbRtFa9dNSug1HSX/C3muN3k3r3XX.FP4gHdn8NpJKj8AVDxn4be',0,NULL,'2026-03-01 16:51:01','2026-03-01 16:51:01'),
(97,'Wilma N. Semillano','wilma.n.semillano.cos-il-007@dti6.gov.ph',NULL,'$2y$12$28apNdGmZmsCxD8pq9MSwO1uSXzNPwT77nUNHIf0ND0giMRvZfBCO',0,NULL,'2026-03-01 16:51:01','2026-03-01 16:51:01'),
(98,'Leo L. Siwagan','leo.l.siwagan.cos-il-002@dti6.gov.ph',NULL,'$2y$12$6AzPCGL1MKmGmeRwY25YO.QisZdsLJTeYUUaxnrSUN9IAodatcgYe',0,NULL,'2026-03-01 16:51:02','2026-03-01 16:51:02'),
(99,'Amiel P. Sumait','amiel.p.sumait.6-036@dti6.gov.ph',NULL,'$2y$12$r5/gxAGWvjjwzXTBNOyDOuoDU7ESxqDFXIpHw3zLO.Ov1DD0VZmpu',0,NULL,'2026-03-01 16:51:02','2026-03-01 16:51:02'),
(100,'Jenny May B. Tabalanza','jenny.may.b.tabalanza.6-042@dti6.gov.ph',NULL,'$2y$12$lGbowjeatEEwstZlJvdymu5QHd/tN9DpimzzlNk9YwNVYykN78F2O',0,NULL,'2026-03-01 16:51:03','2026-03-01 16:51:03'),
(101,'Rohel P. Tabayay','rohel.p.tabayay.6-081@dti6.gov.ph',NULL,'$2y$12$kFRBRnyaXB6l82slJDWK.uLZeG9vBZI67jz2qSrw0.eWNv4u5wLAu',0,NULL,'2026-03-01 16:51:03','2026-03-01 16:51:03'),
(102,'Kent Novie T. Tacsagon','kent.novie.t.tacsagon.6-052@dti6.gov.ph',NULL,'$2y$12$tTb243WFBZPrEevwNU5b5Ok3SkDr2JOONqIuSZUyLqJogdSrLqOIC',0,NULL,'2026-03-01 16:51:03','2026-03-01 16:51:03'),
(103,'Elnar R. Talibong','elnar.r.talibong.2024-ilo-007@dti6.gov.ph',NULL,'$2y$12$.u5dylJlBR1hP3E1NrbjGOyr7W1V7CMKxOlij29xRY3QfK3qGfym6',0,NULL,'2026-03-01 16:51:04','2026-03-01 16:51:04'),
(104,'Ma. Dinda R. Tamayo','ma.dinda.r.tamayo.6-033@dti6.gov.ph',NULL,'$2y$12$Q.JYxEh2OHPAoaOBMVzj6e03tJaDgxWfKLa5UDfXCcxFgvEgBMEpG',0,NULL,'2026-03-01 16:51:04','2026-03-01 16:51:04'),
(105,'May Angeli V. Tayona','may.angeli.v.tayona.6-035@dti6.gov.ph',NULL,'$2y$12$n7iQZneVgYgXTiZUOCLrP.g0vt1VNUFCK/3C8Y.bgYVISI0rowojG',0,NULL,'2026-03-01 16:51:04','2026-03-01 16:51:04'),
(106,'Reynaldo T. Tejero','reynaldo.t.tejero.6-131@dti6.gov.ph',NULL,'$2y$12$e7YNuGmTJAj4XT71WxCZcuIgh4Sb0FEcVMZL5tXXIBkLds1.UlxrS',0,NULL,'2026-03-01 16:51:05','2026-03-01 16:51:05'),
(107,'Jonathan T. Tejida','jonathan.t.tejida.6-147@dti6.gov.ph',NULL,'$2y$12$skqITmZ/7d.e4SROKSSAqeuV5VYbJztOXODtDzlBO1JWSP8qpi.hW',0,NULL,'2026-03-01 16:51:05','2026-03-01 16:51:05'),
(108,'Marjorie F. Tendras','marjorie.f.tendras.6-017@dti6.gov.ph',NULL,'$2y$12$znXetFWhq7UVosORf7iwa.sh5RDBdLB3bPH5oZOWGgKY3QoCCE3LK',0,NULL,'2026-03-01 16:51:06','2026-03-01 16:51:06'),
(109,'Kher Jake Martin A. Trayco','kher.jake.martin.a.trayco.c6-009@dti6.gov.ph',NULL,'$2y$12$Sc1wYDU7hwc0hGJmUvyLQujwzJv8EgaJg8iTFD7uoTk3iapCjK38O',0,NULL,'2026-03-01 16:51:06','2026-03-01 16:51:06'),
(110,'Kurt Maurice S. Tugaff','kurt.maurice.s.tugaff.6-089@dti6.gov.ph',NULL,'$2y$12$0eM98f1Ng9fmLCIY7FvYJ.XyZ2ACqCk/9GBHDzoZiBW4I6kqAlKle',0,NULL,'2026-03-01 16:51:06','2026-03-01 16:51:06'),
(111,'Engiemar B. Tupas','engiemar.b.tupas.6-113@dti6.gov.ph',NULL,'$2y$12$AYtzrlnkCdqwumOvBqVwLOpPG2JYDkbP0AwQh5p5CdE/O1tp5gF8.',0,NULL,'2026-03-01 16:51:07','2026-03-01 16:51:07'),
(112,'Aisel Joyce M. Tupas','aisel.joyce.m.tupas.6-051@dti6.gov.ph',NULL,'$2y$12$IS4n7nDg608IqnLRPYoNYeJBYmGe/mrj28M7GAUuK/QSlyIbLBhly',0,NULL,'2026-03-01 16:51:07','2026-03-01 16:51:07'),
(113,'Gerin E. Vergara','gerin.e.vergara.6-117@dti6.gov.ph',NULL,'$2y$12$bTus9AI5KPCTQkT/BrA1i.5sTsYvKXkdn.TDcN.07FUTuOM59P1sq',0,NULL,'2026-03-01 16:51:07','2026-03-01 16:51:07'),
(114,'Gevi Kristina S. Villafuerte','gevi.kristina.s.villafuerte.6-012@dti6.gov.ph',NULL,'$2y$12$FXbkiK.NXptOkOf1Eunw4e40GECkIvL0dNv10bZu5wMxvlSr3WdLu',0,NULL,'2026-03-01 16:51:08','2026-03-01 16:51:08'),
(115,'Kenneth C. Villarosa','kenneth.c.villarosa.6-030@dti6.gov.ph',NULL,'$2y$12$sBNGLFwUiKhuQYUVOh0Slu1.2KkJQqOxfarhmHcjHrzVfmesp/jSO',0,NULL,'2026-03-01 16:51:08','2026-03-01 16:51:08'),
(116,'Rossel T. Virtuoso','rossel.t.virtuoso.6-078@dti6.gov.ph',NULL,'$2y$12$3idSh6eJ5eabTc0nkM2M1.Kzouz4k6pyxinS/ExVhdZHAATS0K4C6',0,NULL,'2026-03-01 16:51:08','2026-03-01 16:51:08'),
(117,'Nesgen Rhea C. Zerrudo','nesgen.rhea.c.zerrudo.6-011@dti6.gov.ph',NULL,'$2y$12$E4HolQu5TDhs/lYW.AGTDu2KQQ8X9pkSitg0eiFETW6VnAEw/4cj.',0,NULL,'2026-03-01 16:51:09','2026-03-01 16:51:09'),
(118,'Judy Ann P. Bandiola-Rendon','judy.ann.p.bandiola.rendon@dti6.gov.ph',NULL,'$2y$12$tXs0enAe97CnNx/bgj97vuotbu.lyDnp4kivT5AwK0V4NGv9YAPeK',0,NULL,'2026-03-01 16:51:09','2026-03-01 16:51:09'),
(119,'Euna Belle R. Ratay','euna.belle.r.ratay@dti6.gov.ph',NULL,'$2y$12$xakBBP4/E0ozg2TbcrsIDOOmvzkw0NmHdzas0ViIo8yZO.2bzeJoC',0,NULL,'2026-03-01 16:51:10','2026-03-01 16:51:10'),
(120,'Beda Josel D. Zaulda','beda.josel.d.zaulda@dti6.gov.ph',NULL,'$2y$12$FlgmU7Fy7fS//5fy98Fkh.WJzDDyp2rW.gnvZvJTnY/o7UpLxCS0a',0,NULL,'2026-03-01 16:51:10','2026-03-01 16:51:10'),
(121,'Christine Mae H. Jaurique','christine.mae.h.jaurique@dti6.gov.ph',NULL,'$2y$12$amyBDzAYVJ7PGTxhnk5hseh3f4nIE2.D4Tx.tP0KiGL50AZjiU4sO',0,NULL,'2026-03-01 16:51:11','2026-03-01 16:51:11'),
(122,'Lurijane B. Andrade','lurijane.b.andrade@dti6.gov.ph',NULL,'$2y$12$ucK7oogJx0lp.dftKYz5gevGOWNVQlyT8W7sgVKHGbhRllfIMADa6',0,NULL,'2026-03-01 16:51:11','2026-03-01 16:51:11'),
(123,'May Ann Gregorio','may.ann.gregorio@dti6.gov.ph',NULL,'$2y$12$EJ8c07FTo4JXsgWiIouf9eBjFELG1MpbkSxrxxmHJJXUudEYmegO.',0,NULL,'2026-03-01 16:51:11','2026-03-01 16:51:11'),
(124,'Jecel T. Pranuelas','jecel.t.pranuelas@dti6.gov.ph',NULL,'$2y$12$Jzmsue4MOii9KE2LOUcsUOJtp54mFPK7lK08V0GCE3bexmI.mPZUi',0,NULL,'2026-03-01 16:51:12','2026-03-01 16:51:12'),
(125,'Trisha Aura C. Alfaro','trisha.aura.c.alfaro@dti6.gov.ph',NULL,'$2y$12$/Q6Mq7FsEkbH6V.TrLzMBOoTkbm2tXAk4xtf41k5aYuUkzEGllKPm',0,NULL,'2026-03-01 16:51:12','2026-03-01 16:51:12'),
(126,'Queena Althea N. Villorente-Aguirre','queena.althea.n.villorente.aguirre@dti6.gov.ph',NULL,'$2y$12$wcuv5tWzfGotXPUsdrlwserE7yd6F07ONnzhSq3RzUYBPh25/Pzf.',0,NULL,'2026-03-01 16:51:13','2026-03-01 16:51:13'),
(127,'Zhasnay Nicole A. Iquiña','zhasnay.nicole.a.iquina@dti6.gov.ph',NULL,'$2y$12$eVxDrYg0VYvres0mf/Fmb.rxoHWU.aBaM08IpFXnFzY7rqnzceF4e',0,NULL,'2026-03-01 16:51:13','2026-03-01 16:51:13'),
(128,'Izrah Jane D. Custodio','izrah.jane.d.custodio@dti6.gov.ph',NULL,'$2y$12$.N5F1gUK05rXVEpUqr2mMu7KOZ42sswVLB4ghVkMN1pIYyulqQOPm',0,NULL,'2026-03-01 16:51:13','2026-03-01 16:51:13'),
(129,'Mica Marie A. Tala-oc','mica.marie.a.tala.oc@dti6.gov.ph',NULL,'$2y$12$xgNLDpQzZeiqAX0/YVwkxe4dB1xeePJsG2QVPntgjUzXmdXdChCmq',0,NULL,'2026-03-01 16:51:14','2026-03-01 16:51:14'),
(130,'DJ S. Tambong','dj.s.tambong@dti6.gov.ph',NULL,'$2y$12$E8ZIBKFHjzipS27y3g67EuexhZ3TcO9OoOKqFFd7nonZhw6is4CIm',0,NULL,'2026-03-01 16:51:14','2026-03-01 16:51:14'),
(131,'Shemaiah Queeny Shua A. Bautista','shemaiah.queeny.shua.a.bautista@dti6.gov.ph',NULL,'$2y$12$Sn/av4F8xFmrvGA3cXY.q.4u7IJBvz9B.ZQRxPuo1P54uvRJ3YuGy',0,NULL,'2026-03-01 16:51:14','2026-03-01 16:51:14'),
(132,'Zillah F. Alfaro','zillah.f.alfaro@dti6.gov.ph',NULL,'$2y$12$66AkhRfHzNyPoHOkdA1sb.2Vi7FNiZyFBwfXt0/bbHikgXcKKJlqG',0,NULL,'2026-03-01 16:51:15','2026-03-01 16:51:15'),
(133,'Roby Job V. Nabong','roby.job.v.nabong@dti6.gov.ph',NULL,'$2y$12$45rQw4mO2INeSQgcpgORMucGUNpkG.bw71S1n/Zxa1atn3YCDPm/C',0,NULL,'2026-03-01 16:51:15','2026-03-01 16:51:15'),
(134,'John Donel D. Tumbagahan','john.donel.d.tumbagahan@dti6.gov.ph',NULL,'$2y$12$nzwDhhtY4IpNb7g8Uxmfc.EhUdo/uZN4kamZ0t1bV4Ai0L/7UpXlG',0,NULL,'2026-03-01 16:51:16','2026-03-01 16:51:16'),
(135,'Rodene C. Panganiban','rodene.c.panganiban@dti6.gov.ph',NULL,'$2y$12$V2t.zavj0EbsOny2Rbs7yOANXVJ5l.Y/D7Z/Wojdpjy1jjnbMyRLG',0,NULL,'2026-03-01 16:51:16','2026-03-01 16:51:16'),
(136,'Renz Kenneth G. Agapito','renz.kenneth.g.agapito@dti6.gov.ph',NULL,'$2y$12$/aJVQ6Vjd2zmNNhlqfTHmeEEZo7I4px38SlROzxy9vV1bSPA98qju',0,NULL,'2026-03-01 16:51:16','2026-03-01 16:51:16'),
(137,'Keeny Lyn F. Dumalaog','keeny.lyn.f.dumalaog@dti6.gov.ph',NULL,'$2y$12$GHp4c.vUPEooSILHgN.SiOorSzWdFw52pmQt5bL6bfWRoUieZwMni',0,NULL,'2026-03-01 16:51:17','2026-03-01 16:51:17'),
(138,'Arnicole B. Luces','arnicole.b.luces@dti6.gov.ph',NULL,'$2y$12$S4ycKZEEvzpHzcSknbwt3uPjdR4LON530LSmUSbSq8gdATuSC/7ky',0,NULL,'2026-03-01 16:51:17','2026-03-01 16:51:17'),
(139,'Rhoda Valkyrie H. Aban','rhoda.valkyrie.h.aban@dti6.gov.ph',NULL,'$2y$12$Y4J55LzIjs4MVNqY.Wq48.9TJTBmDkBRYuqf7WdjXpNlUVp93rz3K',0,NULL,'2026-03-01 16:51:17','2026-03-01 16:51:17'),
(140,'Krizzia Marie S. Entrina','krizzia.marie.s.entrina@dti6.gov.ph',NULL,'$2y$12$X7LUZhe2.hKBRGySLyKaeuGxRgrEIq51wwG74G3I2Amuph4kzfPim',0,NULL,'2026-03-01 16:51:18','2026-03-01 16:51:18'),
(141,'Crispino Ross M. Lacatan','crispino.ross.m.lacatan@dti6.gov.ph',NULL,'$2y$12$Mo801hwoJ3.b97kBVNP6gevF9lT82frZGhBLDmdzzvfR/iSGUO2T2',0,NULL,'2026-03-01 16:51:18','2026-03-01 16:51:18'),
(142,'Kristel V. Unilongo','kristel.v.unilongo@dti6.gov.ph',NULL,'$2y$12$6Pg5UGEUiB437DrPhrlST.RPqbHKzzY4zLPgrpZ49dMVf/gbOmxP2',0,NULL,'2026-03-01 16:51:18','2026-03-01 16:51:18'),
(143,'Aimee B. Opeña','aimee.b.opena@dti6.gov.ph',NULL,'$2y$12$ypws3JD6CuRmOPDgMv4xk.mNGjZ/RKThi.dBk..rTFUINXpL8DTT.',0,NULL,'2026-03-01 16:51:19','2026-03-01 16:51:19'),
(144,'Prince M. Calawag','prince.m.calawag@dti6.gov.ph',NULL,'$2y$12$Z/gSOCaHlC5AG0OpvdmVx.VbLNqdwv7JnFNyz7TqfjPus5Sx3MK9K',0,NULL,'2026-03-01 16:51:19','2026-03-01 16:51:19'),
(145,'Clark Iven R. Espraguera','clark.iven.r.espraguera@dti6.gov.ph',NULL,'$2y$12$HaHmbNNYGPH/JkPDfw8kLefJiG1T89yoicaheyJakVEMkQcaeQBLC',0,NULL,'2026-03-01 16:51:20','2026-03-01 16:51:20'),
(146,'Hena Joy G. Riomalos','hena.joy.g.riomalos@dti6.gov.ph',NULL,'$2y$12$zJSIjPrg.dtIUxT3YysXrulctMRq0MM8kRVNJvwiq3TFKt6d9Sjuy',0,NULL,'2026-03-01 16:51:20','2026-03-01 16:51:20'),
(147,'Emily T. Maniba','emily.t.maniba@dti6.gov.ph',NULL,'$2y$12$y4ZdyWKLxkyP5AKRKQUsjuLvgWdZh3aSfucHpM4MzQ.gSoBv5L12W',0,NULL,'2026-03-01 16:51:20','2026-03-01 16:51:20'),
(148,'Mary Luz F. Salazar','mary.luz.f.salazar@dti6.gov.ph',NULL,'$2y$12$/h7QxgzU8AYtw8dby1D07eE0yGmH9ac8B0XDgF4hzMHtfjWs8RQk2',0,NULL,'2026-03-01 16:51:21','2026-03-01 16:51:21'),
(149,'Aaron G. Basañes','aaron.g.basanes@dti6.gov.ph',NULL,'$2y$12$w/4N9l0yYIzkQIayTfloFuyJay0Pto00sOF5b5Ow5r6QRrfITJee6',0,NULL,'2026-03-01 16:51:21','2026-03-01 16:51:21'),
(150,'Julie Ann Moquerio','julie.ann.moquerio@dti6.gov.ph',NULL,'$2y$12$8mzyNaVaEfC/hODwtX4KBOWZez5.ikUZ9r2WoAkPg3MhrclSUrvse',0,NULL,'2026-03-01 16:51:21','2026-03-01 16:51:21'),
(151,'Fritzie Mae N. Tandoy','fritzie.mae.n.tandoy@dti6.gov.ph',NULL,'$2y$12$zX9k81VR.OPL7mYsfzIHRO75Qz1DgAvGw9/K5STzNI/VWfDWbAWJe',0,NULL,'2026-03-01 16:51:22','2026-03-01 16:51:22'),
(152,'Jenny Vi Rizardo-Cabayao','jenny.vi.rizardo.cabayao@dti6.gov.ph',NULL,'$2y$12$8FgTO/LwjgKSsD6TcXfoQuOCcDY5CEralbbMSGc5u956jDZ/TnZcm',0,NULL,'2026-03-01 16:51:22','2026-03-01 16:51:22'),
(153,'Olive Mae A. Tumugdan','olive.mae.a.tumugdan@dti6.gov.ph',NULL,'$2y$12$PkmUiyPauCoZeuXYItT1R.nirxrE8vH234nPaDMIN4Tyz3cwg9kGu',0,NULL,'2026-03-01 16:51:23','2026-03-01 16:51:23'),
(154,'Cassandra E. Bulala','cassandra.e.bulala@dti6.gov.ph',NULL,'$2y$12$B6mlYdvGUOjE9Auj10MYduDT.oqDwT67XUOwFW3ZdEI7gl9Cx7qJm',0,NULL,'2026-03-01 16:51:23','2026-03-01 16:51:23'),
(155,'Noveliza L. Samulde','noveliza.l.samulde@dti6.gov.ph',NULL,'$2y$12$pAIOGY13qMHXiQrWH9fdDOban6THXP3F0zy353IZwMxUEdmXifYHq',0,NULL,'2026-03-01 16:51:23','2026-03-01 16:51:23'),
(156,'Nikko Jon T. Rubite','nikko.jon.t.rubite@dti6.gov.ph',NULL,'$2y$12$YGLzygu554Rv4Q.fX3IBFekOr4O30NGD6THCU6qeEHbmGtrGvSIPu',0,NULL,'2026-03-01 16:51:24','2026-03-01 16:51:24'),
(157,'Juan Carlos V. Corros','juan.carlos.v.corros@dti6.gov.ph',NULL,'$2y$12$H/y1ASbScYhQ8Csp62cLR.LUjxInq4J9DI4fh99fcBPtP1yr7qaZK',0,NULL,'2026-03-01 16:51:24','2026-03-01 16:51:24'),
(158,'Rudylyn Demandaco','rudylyn.demandaco@dti6.gov.ph',NULL,'$2y$12$BHN7DXiTl9kkkpYUR0g3vOgkQ45QEuwZX9QBoKKyMOQyIEzek4FfS',0,NULL,'2026-03-01 16:51:24','2026-03-01 16:51:24'),
(159,'Celeene Bautigas','celeene.bautigas@dti6.gov.ph',NULL,'$2y$12$pwL/ZPF7UC9921MkH3KzIerjCSWpK.yh0espb3.05zuT/Jv2kn.0O',0,NULL,'2026-03-01 16:51:25','2026-03-01 16:51:25'),
(160,'Jennifer Jore','jennifer.jore@dti6.gov.ph',NULL,'$2y$12$Uqq872wiKbrBDPRKNDsngevoAlANfwi7nNgz..vR2KuYZ4a35p1c2',0,NULL,'2026-03-01 16:51:25','2026-03-01 16:51:25'),
(161,'Diether B. Dela Torre','diether.b.dela.torre@dti6.gov.ph',NULL,'$2y$12$s7sCykpCitGSS9pcz7ihYOV1tMdkQp8uCQROMxLiFziAH44jVZDxK',0,NULL,'2026-03-01 16:51:25','2026-03-01 16:51:25'),
(162,'Shaina Jade A. Arcega','shaina.jade.a.arcega@dti6.gov.ph',NULL,'$2y$12$nEM3ICx9aPW3bOHY1tTUceEzQb2SIMq0bJbNCwEiIrguRw3p09FdS',0,NULL,'2026-03-01 16:51:26','2026-03-01 16:51:26'),
(163,'Raymund Q. Santuyo','raymund.q.santuyo@dti6.gov.ph',NULL,'$2y$12$vU4d/fZ39JRDuQUFfFZJduaGmW8iEcI8BaSX2TcTcRbmOlbd4mw/O',0,NULL,'2026-03-01 16:51:26','2026-03-01 16:51:26'),
(164,'Richie L. Losaria','richie.l.losaria@dti6.gov.ph',NULL,'$2y$12$odKP6oUWV4Bk4kkV/wm6beqhiWcgnUd0uxs6eTa.4AO3CPB9bo6pu',0,NULL,'2026-03-01 16:51:27','2026-03-01 16:51:27'),
(165,'Jesrel S. Ocampo','jesrel.s.ocampo@dti6.gov.ph',NULL,'$2y$12$QaMJN/bP4BRhCAIZqemEkedKPoz1INVm0jMirqcwtIdK7HEIoWknG',0,NULL,'2026-03-01 16:51:27','2026-03-01 16:51:27'),
(166,'Florie John I. Ucag','florie.john.i.ucag@dti6.gov.ph',NULL,'$2y$12$w4BAYAsJW/Yk5RM43xxstuWM0LdYWfrmVo5H8LzTU6ShD49Grekwe',0,NULL,'2026-03-01 16:51:27','2026-03-01 16:51:27'),
(167,'May Ann C. de Pedro','may.ann.c.de.pedro@dti6.gov.ph',NULL,'$2y$12$MLBFoiBZrn2J1SWoPOyltO.iBdheboOFkDy4/Wbbnd12P/gBwez2u',0,NULL,'2026-03-01 16:51:28','2026-03-01 16:51:28'),
(168,'Joseph R. Badoles','joseph.r.badoles@dti6.gov.ph',NULL,'$2y$12$d1YDQfU1lfNPi4HlkyT1VOFOBKYH7t.rbAhsKYnKYh30RdylcPGd2',0,NULL,'2026-03-01 16:51:28','2026-03-01 16:51:28'),
(169,'Ella Marie Escamilla','ella.marie.escamilla@dti6.gov.ph',NULL,'$2y$12$/zDk3A22b.Qe/5aeLZCM9e.MCcbNmQI9Nh7mPZ4OXM5Q6qdIXU.2C',0,NULL,'2026-03-01 16:51:28','2026-03-01 16:51:28'),
(170,'Liezel Joy Haberle Dellava','liezel.joy.haberle.dellava@dti6.gov.ph',NULL,'$2y$12$FNZjNx0uVjpoLKdMFNb4a.g2L6yRd3DOQte7P6MJEf8uSXxQErUa6',0,NULL,'2026-03-01 16:51:29','2026-03-01 16:51:29'),
(171,'Michelle F. Felasol','michelle.f.felasol@dti6.gov.ph',NULL,'$2y$12$x.B0/LJlNUnY7JSMOQiOc.UIx9I6Xo68YrOP4Rmsyow7J8o/QDbbq',0,NULL,'2026-03-01 16:51:29','2026-03-01 16:51:29'),
(172,'Camille H. Albaña','camille.h.albana@dti6.gov.ph',NULL,'$2y$12$RchuxkMAPwbUHd9EwbmUBOQhdEN4ZGK3hTAYm31ncxuPE.phErZwm',0,NULL,'2026-03-01 16:51:30','2026-03-01 16:51:30'),
(173,'Hugo Andreas Sebastian F. Almasol','hugo.andreas.sebastian.f.almasol@dti6.gov.ph',NULL,'$2y$12$sCFtOVDkzbKNqwqE7u.3FeKckuDpdTpPPkqa7E2.wzGYcHRT7cAoy',0,NULL,'2026-03-01 16:51:30','2026-03-01 16:51:30'),
(174,'Marny Bagamasbad','marny.bagamasbad@dti6.gov.ph',NULL,'$2y$12$C0RoQH6CKUwfIsttDYZDzugvxHs7fTymmQPaRh/IDTyXDglLTJkdi',0,NULL,'2026-03-01 16:51:30','2026-03-01 16:51:30'),
(175,'Normel E. Galvan','normel.e.galvan@dti6.gov.ph',NULL,'$2y$12$EpSy2uIO25IIT8WWDPB.S.iGK5DYaeMNAyBIQG4epN2JUqkUr2dsq',0,NULL,'2026-03-01 16:51:31','2026-03-01 16:51:31'),
(176,'Rosemarie G. Gajete','rosemarie.g.gajete@dti6.gov.ph',NULL,'$2y$12$BriT5segAs9.crCk5FQHS.1EyO1WbOn11.vk1/SIsaHSyeK.gRLX6',0,NULL,'2026-03-01 16:51:31','2026-03-01 16:51:31'),
(177,'Rhea G. Morada','rhea.g.morada@dti6.gov.ph',NULL,'$2y$12$o4HXqWbTFbyEP8hQpQ0xmuWyWWb5GqZC.Wu7acEMqSGsraboRfF7S',0,NULL,'2026-03-01 16:51:31','2026-03-01 16:51:31'),
(178,'Fe B. Tumangan','fe.b.tumangan@dti6.gov.ph',NULL,'$2y$12$P415Ulfr0wywjvY5orkJ3OZzpqVea5pz9KOfI5ur0GBM2H.1.JxCq',0,NULL,'2026-03-01 16:51:32','2026-03-01 16:51:32'),
(179,'Michelle G. Toledano','michelle.g.toledano@dti6.gov.ph',NULL,'$2y$12$YY.EJfUDp4i0AwUeE0Z/Fed8lIwHyTU2fsFl5Dq9ZHv6hxfpq3Gf6',0,NULL,'2026-03-01 16:51:32','2026-03-01 16:51:32'),
(180,'Glory Ann P. Ganancial','glory.ann.p.ganancial@dti6.gov.ph',NULL,'$2y$12$gsiGN7t2q8vuuAvFUid0h.PO8DVlPrSRfrGnDiN8TUvS09DMLrSv.',0,NULL,'2026-03-01 16:51:32','2026-03-01 16:51:32'),
(181,'Ruth G. Penuela','ruth.g.penuela@dti6.gov.ph',NULL,'$2y$12$gcQXYG5Pvc1rBmihg6OKFuF5l/gvBVyhIbHqBWc4QHrkhHSsaVzZi',0,NULL,'2026-03-01 16:51:33','2026-03-01 16:51:33'),
(182,'Ghea E. Rodriguez','ghea.e.rodriguez@dti6.gov.ph',NULL,'$2y$12$TnbrphdQjTOKE44pnx2puup/.DMbvzfNTnPw1kIkyoiaR.V12/KT.',0,NULL,'2026-03-01 16:51:33','2026-03-01 16:51:33'),
(183,'Jessa Marie P. Tibajares','jessa.marie.p.tibajares@dti6.gov.ph',NULL,'$2y$12$O2KldakyPBW7lzBQ1bV6DugKaXtomuRONKF1wusvZag4Nnly/WLUu',0,NULL,'2026-03-01 16:51:34','2026-03-01 16:51:34'),
(184,'Charlene Joy Altillero-Adeja','charlene.joy.altillero.adeja@dti6.gov.ph',NULL,'$2y$12$KjK3kzLRdncfxHNu6zfRC.6xpXQ6Bk4s9.NknHcein9rM430SU9tG',0,NULL,'2026-03-01 16:51:34','2026-03-01 16:51:34'),
(185,'Mary Ann Alteros','mary.ann.alteros@dti6.gov.ph',NULL,'$2y$12$eFCX5ZWj0waI8gRcxEBWM.9DZKGHMpmVPGbSFcFwg6Kzpp2gAbgsK',0,NULL,'2026-03-01 16:51:34','2026-03-01 16:51:34'),
(186,'Wilma N. Semillano','wilma.n.semillano@dti6.gov.ph',NULL,'$2y$12$PjNKNtLats9q6JKFnrHr/O359M4ava2h1LEkXsHrcbEoXvWrd/V9O',0,NULL,'2026-03-01 16:51:35','2026-03-01 16:51:35'),
(187,'Catherine P. Layes','catherine.p.layes@dti6.gov.ph',NULL,'$2y$12$p50kpBbRMEArqKajXkniceae.4OaRsGkLVLCL5d1Czpzt4mnasCyK',0,NULL,'2026-03-01 16:51:35','2026-03-01 16:51:35'),
(188,'Gerard Steven T. Montero','gerard.steven.t.montero@dti6.gov.ph',NULL,'$2y$12$uG/cRqqvz5O5Gsh1U6qsout7jrqt0ujT0jX2jPfkZtS..rZViupWy',0,NULL,'2026-03-01 16:51:35','2026-03-01 16:51:35'),
(189,'Queennie Hope S. Legaste','queennie.hope.s.legaste@dti6.gov.ph',NULL,'$2y$12$bPmR5UAaeQBIrSvIeVZDlekHZdu2XqsV8SbGdN3KN0q3gvaMOGlYu',0,NULL,'2026-03-01 16:51:36','2026-03-01 16:51:36'),
(190,'Sherlyn Y. Canales','sherlyn.y.canales@dti6.gov.ph',NULL,'$2y$12$JmLOEaSByoDKz3Yr.i8pPOYMIWRonJQdJIF7F3swZtfXRiBRbCKMa',0,NULL,'2026-03-01 16:51:36','2026-03-01 16:51:36'),
(191,'Daisy Joy T. Darroca','daisy.joy.t.darroca@dti6.gov.ph',NULL,'$2y$12$/0kdMPaPiiwgDfq3pQ1PJuVKwCYBMEFdYXPWYnG1kOUuw9SdYw6KS',0,NULL,'2026-03-01 16:51:36','2026-03-01 16:51:36'),
(192,'Jamie Anne V. Sermonia','jamie.anne.v.sermonia@dti6.gov.ph',NULL,'$2y$12$Qnt586AbraVB5ovj1Ixn1eEzUOOfOmPVZa99ajVxQytLzP34uol.S',0,NULL,'2026-03-01 16:51:37','2026-03-01 16:51:37'),
(193,'Era Jane G. Gonzales','era.jane.g.gonzales@dti6.gov.ph',NULL,'$2y$12$f4RedZbZzvNJKEbm7cHN.O28GbdXhWaiNvlssj5cHqTdUnsepmqla',0,NULL,'2026-03-01 16:51:37','2026-03-01 16:51:37'),
(194,'Myra Lee C. Panganiban','myra.lee.c.panganiban@dti6.gov.ph',NULL,'$2y$12$xCt1gdtpstaRtVm0SBS48.a9F28a3rZTn79.VWpglk/J.JJJcg9VC',0,NULL,'2026-03-01 16:51:38','2026-03-01 16:51:38'),
(195,'Marian B. Magno','marian.b.magno@dti6.gov.ph',NULL,'$2y$12$J1jZbQtCS6sYCSJVieSWouxzOg8Ie3oX6WN1Runzan5VXcF6P9Q3m',0,NULL,'2026-03-01 16:51:38','2026-03-01 16:51:38'),
(196,'Rosa Mae F. Cabangal','rosa.mae.f.cabangal@dti6.gov.ph',NULL,'$2y$12$beGZ8pzFLfZ/gcoUf66pdOXBSfk8Qdg1MICMn.VJI9l6OL94mXfba',0,NULL,'2026-03-01 16:51:38','2026-03-01 16:51:38'),
(197,'Liezene C. Vega','liezene.c.vega@dti6.gov.ph',NULL,'$2y$12$.TPCeBDhyz0OtyFCLoAb0OY0pRUxm.WnjGxBcaRn/QvZ8GMmOiUi.',0,NULL,'2026-03-01 16:51:39','2026-03-01 16:51:39'),
(198,'Krizzielle Mhae D. Dayon','krizzielle.mhae.d.dayon@dti6.gov.ph',NULL,'$2y$12$NqLbLqp0tNOsa4LVQ/0wFOchvVkYkrDav2hl8qGlqb7hWPPI3ywJ.',0,NULL,'2026-03-01 16:51:39','2026-03-01 16:51:39'),
(199,'Ram Ydnar Ely S. Tribulete','ram.ydnar.ely.s.tribulete@dti6.gov.ph',NULL,'$2y$12$0iLuyEbwvGO7JoREvwqoD.VqKJ.plfnSB1.TqcMFP4UnNmhL04hX2',0,NULL,'2026-03-01 16:51:39','2026-03-01 16:51:39'),
(200,'Leo L. Siwanag','leo.l.siwanag@dti6.gov.ph',NULL,'$2y$12$otTLJ.leB8a.jiA65KbP0uzuT.gZ3O4n..ktzpPORad1UqiOeA1U2',0,NULL,'2026-03-01 16:51:40','2026-03-01 16:51:40'),
(201,'Airesh Q. Castor','airesh.q.castor@dti6.gov.ph',NULL,'$2y$12$nHiV5OXJ0WbC.nc.83ynYOlVSIbnokz/dTMN9o865UhIVsQRUaTdu',0,NULL,'2026-03-01 16:51:40','2026-03-01 16:51:40'),
(202,'Trisha D. De Julian','trisha.d.de.julian@dti6.gov.ph',NULL,'$2y$12$2mBa9W52ySgrWmMI6uBd6OCkiPaivPb2CgfXdLwqpXQqGO3hIGMbG',0,NULL,'2026-03-01 16:51:41','2026-03-01 16:51:41'),
(203,'Scotch Mendel C. Gimoto','scotch.mendel.c.gimoto@dti6.gov.ph',NULL,'$2y$12$DUOHlY3WTywBNvV/uPs5SOSdIsLgeeSKfmZyTztQRl2LL8530izDa',0,NULL,'2026-03-01 16:51:41','2026-03-01 16:51:41'),
(204,'Claire M. Sobreguel','claire.m.sobreguel@dti6.gov.ph',NULL,'$2y$12$2yCSI4BGkvqyX2rSGkwxW.8uMN0MLvtYPPOnONNDR3Cd.KNWfkwXS',0,NULL,'2026-03-01 16:51:41','2026-03-01 16:51:41'),
(205,'Charie Joy T. Taganos','charie.joy.t.taganos@dti6.gov.ph',NULL,'$2y$12$jwTEDN/RMgvDm10D23TxB.dBE0Z4uuM0Irgfw8PbvxjhuqLtM0Q8G',0,NULL,'2026-03-01 16:51:42','2026-03-01 16:51:42'),
(206,'Jeryl C. Glory','jeryl.c.glory@dti6.gov.ph',NULL,'$2y$12$2LmalzX8GuY7WCDyOwuewuyWlwxVa1h9LyXlfcb0yKVOrWWGwvv5y',0,NULL,'2026-03-01 16:51:42','2026-03-01 16:51:42'),
(207,'Vic Alizon P. Morena','vic.alizon.p.morena@dti6.gov.ph',NULL,'$2y$12$g8Hg1vjEx0iCW49Tyv5DyuveUw.tAdjejSt8FCd7rXZrVr5WOpDsG',0,NULL,'2026-03-01 16:51:42','2026-03-01 16:51:42'),
(208,'Crisian Rex P. Casiple','crisian.rex.p.casiple@dti6.gov.ph',NULL,'$2y$12$PVTPxLQXeYgI2diC8Vv6yecG/ZAddx9pVnKTTVAVikqvKpoqeVy5y',0,NULL,'2026-03-01 16:51:43','2026-03-01 16:51:43'),
(209,'Stephanie E. Robles','stephanie.e.robles@dti6.gov.ph',NULL,'$2y$12$gs70UR3GpKmx33pjyWGK.e64vnW8KvgsbfSnGPT5L8/2AaWzku0Cm',0,NULL,'2026-03-01 16:51:43','2026-03-01 16:51:43'),
(210,'Ehvonne B. Cañete','ehvonne.b.canete@dti6.gov.ph',NULL,'$2y$12$J8GGubdHEQzLuvmlNVCdRuUCQMYoh6M5siql3e2WWc8kKh6z8tFdC',0,NULL,'2026-03-01 16:51:43','2026-03-01 16:51:43'),
(211,'Daniellee D. Hortillas','daniellee.d.hortillas@dti6.gov.ph',NULL,'$2y$12$k.8mqdhcfPRp83QZ4fB6qO11X8xXJ75iu.1vU01V//4yMReBrf0Ca',0,NULL,'2026-03-01 16:51:44','2026-03-01 16:51:44'),
(212,'Tasha Marie B. Mondia','tasha.marie.b.mondia@dti6.gov.ph',NULL,'$2y$12$wx/Ox/8PlC0uIgVd3ej1weATLFZqU7fNQxC2d46KJ41ovXPNqbkli',0,NULL,'2026-03-01 16:51:44','2026-03-01 16:51:44'),
(213,'Niño  Anthony V. Eder','nino.anthony.v.eder@dti6.gov.ph',NULL,'$2y$12$pNKIPJStELB7wJ5h3r8AseUCffRV.5Q1t/FsqlRzFXtjT3eFXRc2C',0,NULL,'2026-03-01 16:51:45','2026-03-01 16:51:45'),
(214,'Lady Joy M. Haro','lady.joy.m.haro@dti6.gov.ph',NULL,'$2y$12$9cethNKMcy8fHAyY2w2ZQ.6z5nmLUuKQe3SC9vcYBTf1pxct4isVm',0,NULL,'2026-03-01 16:51:45','2026-03-01 16:51:45'),
(215,'Albert C. Mabuhay','albert.c.mabuhay@dti6.gov.ph',NULL,'$2y$12$w6GVgxIaqWJKKdGFzeczUOxPxAISTnu.oXYKtDL0bLrfbVZ5HuUXC',0,NULL,'2026-03-01 16:51:45','2026-03-01 16:51:45'),
(216,'Genipearl Myrvic R. Paulino','genipearl.myrvic.r.paulino@dti6.gov.ph',NULL,'$2y$12$F0gKofRWtcdg.4ncnruL..TrDNe2vC8kqWewvkhkCcBIrZoJCKr6y',0,NULL,'2026-03-01 16:51:46','2026-03-01 16:51:46'),
(217,'Radzmy Philip J. Fernandez','radzmy.philip.j.fernandez@dti6.gov.ph',NULL,'$2y$12$R/2a.uop/kX00ohzV7F2POsr3OIDffTAG3hdZk6APSaRij2G7AI8q',0,NULL,'2026-03-01 16:51:46','2026-03-01 16:51:46'),
(218,'Disa B. Bretaña','disa.b.bretana@dti6.gov.ph',NULL,'$2y$12$tCQfbcFrbcyyUVJJ.WJ2G.T4sSMRFhNyoN5hMyEl0Smr7Ag5vvImO',0,NULL,'2026-03-01 16:51:46','2026-03-01 16:51:46'),
(219,'Janine D. Salanio','janine.d.salanio@dti6.gov.ph',NULL,'$2y$12$cx5dBIp8oTCGcjhYo65gnOOp8pISFNp.YvT8vR9fUh8lF9lP8gYku',0,NULL,'2026-03-01 16:51:47','2026-03-01 16:51:47'),
(220,'Hannah Grace L. Barrato','hannah.grace.l.barrato@dti6.gov.ph',NULL,'$2y$12$gulRil1.v78ZqKDIWGDX4u9XYHzVsv7tPhHAX0pJ/reY.y/kJ3n7m',0,NULL,'2026-03-01 16:51:47','2026-03-01 16:51:47'),
(221,'Rouella O. Suarez','rouella.o.suarez@dti6.gov.ph',NULL,'$2y$12$17NBd4iM5uIqgTkwNOqROOMRETxUR4mGNBa6WrQLDgMrbmhtmF.ga',0,NULL,'2026-03-01 16:51:47','2026-03-01 16:51:47'),
(222,'Joella M. Opina','joella.m.opina@dti6.gov.ph',NULL,'$2y$12$vPF86wxriOsslhXAeCMkR.Tb2qEPc8UgjhlNXS2ywajCxeZACmGH2',0,NULL,'2026-03-01 16:51:48','2026-03-01 16:51:48'),
(223,'Eden Grace A. Perez','eden.grace.a.perez@dti6.gov.ph',NULL,'$2y$12$BGz7rsOUHR13Fg.XcoslFeGvTPzqNW/x7cSsfn/E4HHTmYgBpeGFu',0,NULL,'2026-03-01 16:51:48','2026-03-01 16:51:48'),
(224,'Kitchie Jardeliza','kitchie.jardeliza@dti6.gov.ph',NULL,'$2y$12$dL7NrrMSzFqJ1Mb19tqb2OOfFANUMYo4.HHK..qjGVLCv7pJ6EnR.',0,NULL,'2026-03-01 16:51:49','2026-03-01 16:51:49'),
(225,'Francine B. Demasis','francine.b.demasis@dti6.gov.ph',NULL,'$2y$12$yU8f4IGbjhKw0k4649sDV.o4D8bRR3/YUbcLY7fBo2tg3Kz.jbHum',0,NULL,'2026-03-01 16:51:49','2026-03-01 16:51:49'),
(226,'Christian N. Torreflores','christian.n.torreflores@dti6.gov.ph',NULL,'$2y$12$pkQ6Nc.wDvfZc7G/HmZk9OkZJ72Bc3/mmPgdKaKPIGkF9K0OpbmGu',0,NULL,'2026-03-01 16:51:49','2026-03-01 16:51:49'),
(227,'Ruthchel M. Villanueva II','ruthchel.m.villanueva.ii@dti6.gov.ph',NULL,'$2y$12$7KXIyMrqd2dKpx1Ac.BqV./Rj/zrUDDHeZss.cHSx2lBeoMZR.ce2',0,NULL,'2026-03-01 16:51:50','2026-03-01 16:51:50'),
(228,'Claire B. Villaruel','claire.b.villaruel@dti6.gov.ph',NULL,'$2y$12$nCgQmnTpG3qAxiumwGXzCOgk2fMfIPL5mAR8C9y3dFwNpuVfLPhEa',0,NULL,'2026-03-01 16:51:50','2026-03-01 16:51:50'),
(229,'Jashen B. Eduque','jashen.b.eduque@dti6.gov.ph',NULL,'$2y$12$ngsbZTgKtEoOuBEVY3Y31.Gt68bPtyWAhp2EGVO4lNmFqhcQaOQfS',0,NULL,'2026-03-01 16:51:50','2026-03-01 16:51:50'),
(230,'Meriza B. Avanceña','meriza.b.avancena@dti6.gov.ph',NULL,'$2y$12$.p0o1aua0Llv23GugH6b/.lhf6S.GGPoyHLJOsfJG9God3zSr0seq',0,NULL,'2026-03-01 16:51:51','2026-03-01 16:51:51'),
(231,'Maybel R. Obcena','maybel.r.obcena@dti6.gov.ph',NULL,'$2y$12$2/ZO7dmG.UxDvdNq3w0zAOES/QDy.iLja0IA8MxQGW7Zw6TXDoY52',0,NULL,'2026-03-01 16:51:51','2026-03-01 16:51:51'),
(232,'Liza F. Ganchoon','liza.f.ganchoon@dti6.gov.ph',NULL,'$2y$12$1HVLWTLEjSRnp9H4rL5xnuw6RvKUhn6oy83cTd8LngTf6p/fujnfa',0,NULL,'2026-03-01 16:51:52','2026-03-01 16:51:52'),
(233,'Harklee D. Granada','harklee.d.granada@dti6.gov.ph',NULL,'$2y$12$jrdd7M68.WgtkEn2A/4YXe4fkLqA/gEBBZyhF3w3JzdYPuSSwng/2',0,NULL,'2026-03-01 16:51:52','2026-03-01 16:51:52'),
(234,'Jann Ronan E. Serfino','jann.ronan.e.serfino@dti6.gov.ph',NULL,'$2y$12$BjLa36/nz9pPkjOVwOkuUOhtZAQhwDZw9nbUC0Bn6b6CB8gFdR.d2',0,NULL,'2026-03-01 16:51:52','2026-03-01 16:51:52'),
(235,'Zarrah Jane Desbaro','zarrah.jane.desbaro@dti6.gov.ph',NULL,'$2y$12$JhQlSlQqv3hbGYD2aMoKquroGR7kY97bdo7XMv1TvzbjtwbEbgZ.C',0,NULL,'2026-03-01 16:51:53','2026-03-01 16:51:53'),
(236,'Victor Ed Anthony G. Alamon','victor.ed.anthony.g.alamon@dti6.gov.ph',NULL,'$2y$12$HhSETBgA80qJQXAb.06b0eRMSHhESQhbYuIG/s3ihxFfkW/yO8aGy',0,NULL,'2026-03-01 16:51:53','2026-03-01 16:51:53'),
(237,'Jermilyn U. Pollenza','jermilyn.u.pollenza@dti6.gov.ph',NULL,'$2y$12$boo/u6WLw1HNCMPfWTQqM.ZIWVVZ/Ri3NulWr8huJhiOIgy26Cdim',0,NULL,'2026-03-01 16:51:53','2026-03-01 16:51:53'),
(238,'Raquel C. Hernando','raquel.c.hernando@dti6.gov.ph',NULL,'$2y$12$Z1JYNIq0JAh13DQ59MKNhOa4JbzMdAfiPRyYXDLGLSvb.jP9LUOyC',0,NULL,'2026-03-01 16:51:54','2026-03-01 16:51:54'),
(239,'Mary Ann Raymundo Moran','mary.ann.raymundo.moran@dti6.gov.ph',NULL,'$2y$12$TVqPSh2EtbQTENyfSeg5uuk6YKmRy3dUoXGLAPjCVXFB8or.DZFVq',0,NULL,'2026-03-01 16:51:54','2026-03-01 16:51:54'),
(240,'Loreme Ongsuco Geaga','loreme.ongsuco.geaga@dti6.gov.ph',NULL,'$2y$12$R4eo3091BW0c6G/ojLyeFeWZSEpyKjsBC0lPbt6gfyioNI2bVWWqm',0,NULL,'2026-03-01 16:51:54','2026-03-01 16:51:54'),
(241,'Glynes L. Suarez','glynes.l.suarez@dti6.gov.ph',NULL,'$2y$12$pkWwLrOS7bE4nCsysvk8T.6IHS2sHVOy2l1eR740AZNKfRlwZ9Koe',0,NULL,'2026-03-01 16:51:55','2026-03-01 16:51:55'),
(242,'Kiara C. Lorezco','kiara.c.lorezco@dti6.gov.ph',NULL,'$2y$12$U8b.rxfkDivMmsXlj9ivVuBmmJWbkpwJuwXuSetzXZq3C4gAOkIJm',0,NULL,'2026-03-01 16:51:55','2026-03-01 16:51:55'),
(243,'Kimberly Fajardo','kimberly.fajardo@dti6.gov.ph',NULL,'$2y$12$Rs9Hj8vJt9WZfQsXB7GCx.YBfhqhx6Pp4rz5tZVbmspJA.C.N5XpC',0,NULL,'2026-03-01 16:51:56','2026-03-01 16:51:56'),
(244,'John Paul U. Montano','john.paul.u.montano@dti6.gov.ph',NULL,'$2y$12$b/LovMLpT8Mx8z887ORyHulDBz5/Cdh5P5r/5UiRwmRep8nrxB1N6',0,NULL,'2026-03-01 16:51:56','2026-03-01 16:51:56'),
(245,'Ma. Bernadette Clare F. Casidsid','ma.bernadette.clare.f.casidsid@dti6.gov.ph',NULL,'$2y$12$b789mbDw8BMUxI3Ba9ni3.f.eg33iB2MraLMZpx0PCRGXCJRwiikW',0,NULL,'2026-03-01 16:51:56','2026-03-01 16:51:56'),
(246,'Dexter S. Casumpang','dexter.s.casumpang@dti6.gov.ph',NULL,'$2y$12$cAfVkAO6V9vS8VoBcTYsLO/jl7lZfFMYUaijCJVpMaWhvml9IcyOO',0,NULL,'2026-03-01 16:51:57','2026-03-01 16:51:57'),
(247,'Lyka Joyce Obello','lyka.joyce.obello@dti6.gov.ph',NULL,'$2y$12$0k8wR3hSWRoTVTiW2g5HWepWIwnItAiiOxWuAv0F1cufcmgWpIraW',0,NULL,'2026-03-01 16:51:57','2026-03-01 16:51:57'),
(248,'Kenny Perylyn M. Abuyon','kenny.perylyn.m.abuyon@dti6.gov.ph',NULL,'$2y$12$mk3oR.AFbDeGCwV7ezi7BeZqv07WTUCfSDYhTOYGxujAFBhoua322',0,NULL,'2026-03-01 16:51:57','2026-03-01 16:51:57'),
(249,'Ariesha Monica U. Espinosa','ariesha.monica.u.espinosa@dti6.gov.ph',NULL,'$2y$12$EYAJPUVLEYavSfM10OZoK.ORT57fYXHmPtou5T.F3cIVbkWokgj3q',0,NULL,'2026-03-01 16:51:58','2026-03-01 16:51:58'),
(250,'Kathrine Bianca V. Laguna','kathrine.bianca.v.laguna@dti6.gov.ph',NULL,'$2y$12$WztPct2RXbZ2RLg0XDkZyueQCGhdqvTBYhHuoLFrmfe8Z9Am/9882',0,NULL,'2026-03-01 16:51:58','2026-03-01 16:51:58'),
(251,'Jamaica D. Unabia','jamaica.d.unabia@dti6.gov.ph',NULL,'$2y$12$rh1aqIpZODXeRgvPslTYAerhzsOtAop6nm9MT2h/CVR9WCaIqS0ri',0,NULL,'2026-03-01 16:51:59','2026-03-01 16:51:59'),
(252,'Kenneth D. Cubero','kenneth.d.cubero@dti6.gov.ph',NULL,'$2y$12$yCqnoMcGAtO/B60gMqVA/eieQsL46I4Revb8Oo2KstYBwWyuoshFK',0,NULL,'2026-03-01 16:51:59','2026-03-01 16:51:59'),
(253,'Dale Lewis Belarma','dale.lewis.belarma@dti6.gov.ph',NULL,'$2y$12$f8QGPCEszrZYqxWqm2iDjOrDgd9Sege190Pavrah8iy/yyO141gYu',0,NULL,'2026-03-01 16:51:59','2026-03-01 16:51:59'),
(254,'Karla Lu B. Delima','karla.lu.b.delima@dti6.gov.ph',NULL,'$2y$12$LRHJ1MMZ6pvh.sxtV1GHL.foY7aayq2.1XUzLlRE5PzX4KZ0fNdN6',0,NULL,'2026-03-01 16:52:00','2026-03-01 16:52:00'),
(255,'David John R. Rubido','david.john.r.rubido@dti6.gov.ph',NULL,'$2y$12$oBTlvXdCNB/YC/NZHj75LO5mnWRmU0AgzCKlt0.duPfN1u8xwG68C',0,NULL,'2026-03-01 16:52:00','2026-03-01 16:52:00'),
(256,'Symon Angelo C. Albino','symon.angelo.c.albino@dti6.gov.ph',NULL,'$2y$12$Q2ayoq8avIQRidukGDCaF.uGz6NtI6RHOE1xE34CPZXrnWvUv32BC',0,NULL,'2026-03-01 16:52:00','2026-03-01 16:52:00'),
(257,'Niño R. Embodo','nino.r.embodo@dti6.gov.ph',NULL,'$2y$12$7CJalONUh6q7HNiRooSfGeccvyT9/3eCpg8t9PNbLyTOmEdzEqZ5u',0,NULL,'2026-03-01 16:52:01','2026-03-01 16:52:01'),
(258,'Georitch Jude R. Bacarro','georitch.jude.r.bacarro@dti6.gov.ph',NULL,'$2y$12$ARVw57cy1imJidv8VslMV.A.1XMxtFZFoOkFHyW3m2WO6dmwhnV7u',0,NULL,'2026-03-01 16:52:01','2026-03-01 16:52:01'),
(259,'Jerwin B. Garcia','jerwin.b.garcia@dti6.gov.ph',NULL,'$2y$12$ilhVwarcN1HTgQoTSiBe5ObNKhvGKffnQBEvoNxdHwSZqw6TW7oUC',0,NULL,'2026-03-01 16:52:01','2026-03-01 16:52:01'),
(260,'DTI6 Admin','admin@dti6.gov.ph',NULL,'$2y$12$fEwYr3iqq4HQOE3Heqyj..Y2kh6ye3mZUg.uWFctrc6loRiFPIMzK',1,NULL,'2026-03-01 17:15:37','2026-03-01 17:15:37');
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

-- Dump completed on 2026-03-04 11:19:18
