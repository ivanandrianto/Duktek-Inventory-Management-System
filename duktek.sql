-- MySQL dump 10.16  Distrib 10.1.10-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: duktek
-- ------------------------------------------------------
-- Server version	10.1.10-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'Ivan Andrianto','andrianto.ivan@yahoo.co.id','$2y$10$g2YGmBIN8mVVEzU0y8vylum/d4/aiUrr9szZJPy3ggi56eop9hOMy','ZxpMnncaPLZLYNQw7FiC0sqecZjfVLmmxIDjuxVEspcWxENesIX4mMKqw9ZO','2016-01-31 00:39:53','2016-01-31 09:06:09');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_barang` int(10) unsigned NOT NULL,
  `waktu_booking_mulai` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `waktu_booking_selesai` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_pembooking` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `booking_id_barang_foreign` (`id_barang`),
  CONSTRAINT `booking_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `peralatan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking`
--

LOCK TABLES `booking` WRITE;
/*!40000 ALTER TABLE `booking` DISABLE KEYS */;
INSERT INTO `booking` VALUES (2,1,'2016-02-01 02:31:59','2016-02-11 02:42:40',13513039,'2016-02-10 19:42:40','2016-02-10 19:42:40');
/*!40000 ALTER TABLE `booking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2016_02_08_170427_create_peralatan_table',1),('2016_02_08_170447_create_pengguna_table',1),('2016_02_08_170500_create_transaksi_table',1),('2016_02_08_170517_create_booking_table',1),('2016_02_08_170529_create_perbaikan_table',1),('2016_02_09_160144_create_pengguna_table',2),('2016_02_09_160506_create_transaksi_table',3),('2016_02_09_160827_create_pengguna_table',4),('2016_02_09_160828_create_transaksi_table',4),('2016_02_09_160829_create_booking_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengguna`
--

DROP TABLE IF EXISTS `pengguna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengguna` (
  `id` int(10) unsigned NOT NULL,
  `nama` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8_unicode_ci NOT NULL,
  `no_telp` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `jenis` enum('Dosen','Mahasiswa','Karyawan') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY `pengguna_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengguna`
--

LOCK TABLES `pengguna` WRITE;
/*!40000 ALTER TABLE `pengguna` DISABLE KEYS */;
INSERT INTO `pengguna` VALUES (1,'a','b','0','Mahasiswa','2016-02-13 09:57:09','2016-02-13 09:57:09'),(2,'aaa','b','0','Mahasiswa','2016-02-13 09:58:52','2016-02-13 10:52:39'),(3,'a','b','0','Mahasiswa','2016-02-13 09:59:06','2016-02-13 09:59:06'),(4,'a','b','0','Mahasiswa','2016-02-13 10:00:56','2016-02-13 10:00:56'),(5,'a','b','0','Mahasiswa','2016-02-13 10:01:14','2016-02-13 10:01:14'),(6,'a','b','0','Mahasiswa','2016-02-13 10:01:33','2016-02-13 10:01:33'),(7,'a','b','0','Mahasiswa','2016-02-13 10:01:43','2016-02-13 10:01:43'),(8,'a','b','0','Mahasiswa','2016-02-13 10:08:03','2016-02-13 10:08:03'),(9,'a','b','0','Mahasiswa','2016-02-13 10:08:20','2016-02-13 10:08:20'),(11,'a','b','0','Mahasiswa','2016-02-13 10:12:04','2016-02-13 10:12:04'),(12,'a','b','c','Mahasiswa','2016-02-13 10:12:24','2016-02-13 10:12:24'),(13,'a','b','0','Mahasiswa','2016-02-13 10:15:42','2016-02-13 10:15:42'),(14,'a','b','c','Mahasiswa','2016-02-13 10:18:57','2016-02-13 10:18:57'),(15,'a','b','0','Mahasiswa','2016-02-13 10:19:21','2016-02-13 10:19:21'),(16,'a','b','08385','Mahasiswa','2016-02-13 10:31:26','2016-02-13 10:31:26'),(135,'Chibi','M','08','Mahasiswa','2016-02-13 21:36:31','2016-02-13 21:36:31'),(1351,'Chibi2','MJP','083857','Mahasiswa','2016-02-13 21:37:20','2016-02-13 21:37:20'),(13513039,'Ivan','MJP','083','Mahasiswa','2016-02-13 01:20:27','2016-02-13 01:20:27'),(135130390,'i','m','0','Mahasiswa','2016-02-13 09:50:28','2016-02-13 09:50:28'),(135130391,'a','b','0','Mahasiswa','2016-02-13 09:55:18','2016-02-13 09:55:18'),(1351303900,'a','b','0','Mahasiswa','2016-02-13 09:55:29','2016-02-13 09:55:29');
/*!40000 ALTER TABLE `pengguna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peralatan`
--

DROP TABLE IF EXISTS `peralatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peralatan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Rusak','Perbaikan','Baik') COLLATE utf8_unicode_ci NOT NULL,
  `ketersediaan` enum('Tersedia','Sedang Digunakan') COLLATE utf8_unicode_ci NOT NULL,
  `lokasi` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `jenis` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `peralatan_id_unique` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peralatan`
--

LOCK TABLES `peralatan` WRITE;
/*!40000 ALTER TABLE `peralatan` DISABLE KEYS */;
INSERT INTO `peralatan` VALUES (1,'SSSSSS','Baik','Tersedia','Saritem','Tools','2016-02-08 10:37:43','2016-02-09 13:01:17'),(2,'Sampah3','','Tersedia','Saritem3','Tools3','2016-02-08 12:28:34','2016-02-08 12:28:34'),(3,'A','','','C','B','2016-02-08 12:31:49','2016-02-08 12:31:49'),(5,'Q','Rusak','Sedang Digunakan','E','W','2016-02-08 12:33:57','2016-02-08 12:33:57'),(6,'A','Rusak','Sedang Digunakan','D','S','2016-02-08 12:35:58','2016-02-08 12:35:58'),(8,'zaaaaaa','Rusak','Tersedia','c','x','2016-02-13 10:54:45','2016-02-13 10:54:45'),(9,'zaaaaaa','Rusak','Tersedia','c','x','2016-02-13 10:55:03','2016-02-13 10:55:03'),(10,'aaaaaa','Baik','Tersedia','cc','bb','2016-02-13 11:18:57','2016-02-13 11:18:57');
/*!40000 ALTER TABLE `peralatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perbaikan`
--

DROP TABLE IF EXISTS `perbaikan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perbaikan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_barang` int(10) unsigned NOT NULL,
  `waktu_mulai` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `waktu_selesai` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `duarsi` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `perbaikan_id_unique` (`id`),
  KEY `perbaikan_id_barang_foreign` (`id_barang`),
  CONSTRAINT `perbaikan_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `peralatan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perbaikan`
--

LOCK TABLES `perbaikan` WRITE;
/*!40000 ALTER TABLE `perbaikan` DISABLE KEYS */;
INSERT INTO `perbaikan` VALUES (1,1,'2016-02-09 08:38:48','2016-02-09 08:38:48',0,'2016-02-09 01:38:48','2016-02-09 01:38:48'),(2,1,'2016-01-01 17:00:00','2016-02-09 08:40:20',0,'2016-02-09 01:40:20','2016-02-09 01:40:20'),(3,1,'0000-00-00 00:00:00','2016-02-09 08:40:30',0,'2016-02-09 01:40:30','2016-02-09 01:40:30'),(4,1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'2016-02-09 01:41:40','2016-02-09 03:49:23'),(5,2,'2016-02-01 17:04:16','2016-02-01 10:10:52',0,'2016-02-09 03:02:31','2016-02-09 07:45:49'),(6,1,'2016-02-04 10:29:00','2016-02-06 08:29:42',0,'2016-02-09 08:13:09','2016-02-09 08:30:18');
/*!40000 ALTER TABLE `perbaikan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaksi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_barang` int(10) unsigned NOT NULL,
  `waktu_pinjam` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `waktu_rencana_kembali` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `waktu_kembali` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `duarsi` int(11) NOT NULL,
  `id_peminjam` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi`
--

LOCK TABLES `transaksi` WRITE;
/*!40000 ALTER TABLE `transaksi` DISABLE KEYS */;
INSERT INTO `transaksi` VALUES (1,1,'2016-01-31 19:13:06','0000-00-00 00:00:00','0000-00-00 00:00:00',0,13513039,'2016-02-09 12:13:18','2016-02-09 12:13:18'),(2,1,'2016-01-31 19:15:47','2016-02-01 19:15:47','0000-00-00 00:00:00',0,13513039,'2016-02-09 12:16:40','2016-02-09 12:16:40'),(3,1,'2016-01-31 19:17:47','2016-02-01 19:17:47','0000-00-00 00:00:00',0,13513039,'2016-02-09 12:20:06','2016-02-09 12:20:06'),(4,1,'2016-01-31 19:20:31','2016-02-01 19:20:31','0000-00-00 00:00:00',0,13513039,'2016-02-09 12:21:48','2016-02-09 12:21:48'),(5,1,'2016-01-31 19:22:32','2016-02-01 19:22:32','0000-00-00 00:00:00',0,13513039,'2016-02-09 12:23:45','2016-02-09 12:23:45'),(6,1,'2016-02-01 19:24:14','2016-02-02 19:24:14','0000-00-00 00:00:00',0,13513039,'2016-02-09 12:24:25','2016-02-09 12:24:25'),(7,1,'2016-02-01 19:25:21','2016-02-02 19:25:21','0000-00-00 00:00:00',0,13513039,'2016-02-09 12:25:37','2016-02-09 12:25:37'),(8,1,'2016-01-31 19:55:10','2016-02-01 19:55:10','0000-00-00 00:00:00',0,13513039,'2016-02-09 13:10:58','2016-02-09 13:10:58'),(9,1,'2016-02-01 20:27:40','2016-02-02 20:27:40','2016-02-02 20:29:04',0,13513039,'2016-02-09 13:28:59','2016-02-09 13:29:28');
/*!40000 ALTER TABLE `transaksi` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-14 11:49:09
