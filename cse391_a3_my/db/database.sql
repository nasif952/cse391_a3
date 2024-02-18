CREATE DATABASE  IF NOT EXISTS `cse391_a3_my` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cse391_a3_my`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: cse391_a3_my
-- ------------------------------------------------------
-- Server version	8.0.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `email` varchar(45) NOT NULL,
  `password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointments` (
  `AppointmentID` int NOT NULL AUTO_INCREMENT,
  `ClientID` int DEFAULT NULL,
  `Mechanic` varchar(100) DEFAULT NULL,
  `TimeSlotID` int DEFAULT NULL,
  PRIMARY KEY (`AppointmentID`),
  KEY `TimeSlotID` (`TimeSlotID`),
  KEY `ClientID` (`ClientID`),
  CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`TimeSlotID`) REFERENCES `timeslots` (`TimeSlotID`),
  CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`ClientID`) REFERENCES `clients` (`ClientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointments`
--

LOCK TABLES `appointments` WRITE;
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `ClientID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `CarColor` varchar(50) DEFAULT NULL,
  `LicenseNumber` varchar(50) NOT NULL,
  `EngineNumber` varchar(50) NOT NULL,
  PRIMARY KEY (`ClientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mechanics`
--

DROP TABLE IF EXISTS `mechanics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mechanics` (
  `MechanicID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `MaxActiveCars` int NOT NULL,
  PRIMARY KEY (`MechanicID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mechanics`
--

LOCK TABLES `mechanics` WRITE;
/*!40000 ALTER TABLE `mechanics` DISABLE KEYS */;
INSERT INTO `mechanics` VALUES (1,'test1',5),(2,'test2',5),(3,'test3',5),(4,'test4',5),(5,'test5',5),(6,'test6',5),(7,'test7',5),(8,'test8',5),(9,'test9',5),(10,'test1',5),(11,'test2',5),(12,'test3',5),(13,'test4',5),(14,'test5',5);
/*!40000 ALTER TABLE `mechanics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timeslots`
--

DROP TABLE IF EXISTS `timeslots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `timeslots` (
  `TimeSlotID` int NOT NULL AUTO_INCREMENT,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `DayOfWeek` enum('Friday','Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday') NOT NULL,
  PRIMARY KEY (`TimeSlotID`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timeslots`
--

LOCK TABLES `timeslots` WRITE;
/*!40000 ALTER TABLE `timeslots` DISABLE KEYS */;
INSERT INTO `timeslots` VALUES (1,'10:00:00','11:00:00','Friday'),(2,'11:00:00','13:00:00','Friday'),(3,'13:00:00','14:00:00','Friday'),(4,'14:00:00','15:00:00','Friday'),(5,'16:00:00','17:00:00','Friday'),(6,'17:00:00','18:00:00','Friday'),(7,'10:00:00','11:00:00','Saturday'),(8,'11:00:00','13:00:00','Saturday'),(9,'13:00:00','14:00:00','Saturday'),(10,'14:00:00','15:00:00','Saturday'),(11,'16:00:00','17:00:00','Saturday'),(12,'17:00:00','18:00:00','Saturday'),(13,'10:00:00','11:00:00','Sunday'),(14,'11:00:00','13:00:00','Sunday'),(15,'13:00:00','14:00:00','Sunday'),(16,'14:00:00','15:00:00','Sunday'),(17,'16:00:00','17:00:00','Sunday'),(18,'17:00:00','18:00:00','Sunday'),(19,'10:00:00','11:00:00','Monday'),(20,'11:00:00','13:00:00','Monday'),(21,'13:00:00','14:00:00','Monday'),(22,'14:00:00','15:00:00','Monday'),(23,'16:00:00','17:00:00','Monday'),(24,'17:00:00','18:00:00','Monday'),(25,'10:00:00','11:00:00','Tuesday'),(26,'11:00:00','13:00:00','Tuesday'),(27,'13:00:00','14:00:00','Tuesday'),(28,'14:00:00','15:00:00','Tuesday'),(29,'16:00:00','17:00:00','Tuesday'),(30,'17:00:00','18:00:00','Tuesday'),(31,'10:00:00','11:00:00','Wednesday'),(32,'11:00:00','13:00:00','Wednesday'),(33,'13:00:00','14:00:00','Wednesday'),(34,'14:00:00','15:00:00','Wednesday'),(35,'16:00:00','17:00:00','Wednesday'),(36,'17:00:00','18:00:00','Wednesday'),(37,'10:00:00','11:00:00','Thursday'),(38,'11:00:00','13:00:00','Thursday'),(39,'13:00:00','14:00:00','Thursday'),(40,'14:00:00','15:00:00','Thursday'),(41,'16:00:00','17:00:00','Thursday'),(42,'17:00:00','18:00:00','Thursday');
/*!40000 ALTER TABLE `timeslots` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-17  1:24:14
