-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: mydb
-- ------------------------------------------------------
-- Server version	9.1.0

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
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cars` (
  `id` int NOT NULL AUTO_INCREMENT,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `year` int NOT NULL,
  `license_plate` varchar(20) NOT NULL,
  `status` enum('Available','Rented','Maintenance') DEFAULT 'Available',
  PRIMARY KEY (`id`),
  UNIQUE KEY `license_plate` (`license_plate`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cars`
--

LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
INSERT INTO `cars` VALUES (8,'Dacia','Sandero',2018,'AB15698','Available'),(9,'Mercedes','Benz',2020,'AD45879','Available'),(10,'Clio','Patra',2005,'JK12354','Maintenance'),(11,'Renault','B5',2015,'KL12546','Available');
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `token` varchar(255) NOT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `personal_access_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,1,'3469a2e7642382dca7f3732db793c8364dc42fa5005cc9b5d217b746fb29ccfe',NULL,'2024-12-12 22:47:54'),(4,1,'0f97c7def9a99c89aef66646dc29be0f067a1216c67cc2f4f09aef65a22779a3',NULL,'2024-12-13 09:21:01'),(5,1,'cbe7243e308ace35c95d4dbefc309f2e91d0cf42579de4eb097f560ccaaa52bf',NULL,'2024-12-13 09:36:48'),(6,1,'d0e602db00e38f4777cc78b1442b635c1e9a150165da735dc9844d76227a41e8',NULL,'2024-12-13 09:38:33'),(7,1,'2e890d1e9ab0beef1032a8d5bb0270d507e2bb5e1c952329aa2bc268cf84dd6d',NULL,'2024-12-13 14:12:11'),(8,1,'cb867b477ebed39d319ea770413e3a837696dfe38ba78c26ea4eb72999c831c9',NULL,'2024-12-13 14:12:36'),(10,1,'7e1f31af618b32de268c3af89fa0a637c05113c87e5fd793410fb09e21cfd2d0',NULL,'2024-12-13 15:24:47'),(11,1,'f6b7e9bb4080f73231785f2beb11d62cc567faa95cc22e014388efd585970dc1',NULL,'2024-12-13 15:52:29'),(12,1,'854abeafa06a53fb6aa13289a144a776e3e752579f65a6899a6fcc76ffc872c2',NULL,'2024-12-26 09:11:33'),(13,2,'0ca5d4bcf01764365de536197975715ed266dc021d734a035f3a78015fc7f687',NULL,'2024-12-26 09:29:27'),(14,2,'30152bca5e855d2bae98c40040487615088fc67a765622b3baf3550f31465f2c',NULL,'2024-12-26 15:40:27');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rentalcontracts`
--

DROP TABLE IF EXISTS `rentalcontracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rentalcontracts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `car_id` int NOT NULL,
  `rental_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `ID_user` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`),
  KEY `rentalcontracts_ibfk_1` (`ID_user`),
  CONSTRAINT `rentalcontracts_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rentalcontracts_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rentalcontracts`
--

LOCK TABLES `rentalcontracts` WRITE;
/*!40000 ALTER TABLE `rentalcontracts` DISABLE KEYS */;
INSERT INTO `rentalcontracts` VALUES (9,8,'2024-12-12','2024-12-13',0.00,2),(11,8,'2024-12-27','2025-01-07',0.00,2),(12,9,'2024-12-30','2024-12-31',0.00,2);
/*!40000 ALTER TABLE `rentalcontracts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('user','admin') DEFAULT NULL,
  `phoneN` varchar(10) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Address` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'eee@gmail.com','$2y$10$WdXQxzU5hASfllkj13lHqeH2qwqeXnawVqWtSZ6Tju5YPQglzHy6C','ridachaanoun.ff.2@gmail.com','2024-12-12 11:42:14','admin',NULL,'2024-12-27 00:04:30',NULL),(2,'Anass','$2y$10$92u/JoOYsjtto1FWhJQw.e3fHWavq1oO7Rxzg5Iuoxalb.iK9SWWa','anas@gmail.com','2024-12-26 09:29:18','admin','0645878987','2024-12-27 22:19:59','123 Somewhere'),(4,'Anass B','$2y$12$lnesAPj0PfIiGugqwZ.PJu6Ec5puYCr4ietUALopSeeMrvKtzi1zW','a.b@gmail.com','2024-12-26 21:20:16','user','','2024-12-28 00:04:23','63 Unknown Street');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'mydb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-28 23:28:24
