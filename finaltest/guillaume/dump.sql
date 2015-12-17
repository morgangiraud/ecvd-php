-- MySQL dump 10.13  Distrib 5.7.10, for osx10.10 (x86_64)
--
-- Host: localhost    Database: ecvchat
-- ------------------------------------------------------
-- Server version	5.7.10

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
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `extension` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (1,'logo.png','/Users/ecvdigital12/tmp/ecvd-php/finaltest/guillaume/chat/uploads/1450346937_','image/png'),(2,'logo.png','/Users/ecvdigital12/tmp/ecvd-php/finaltest/guillaume/chat/uploads/1450347032_','image/png'),(3,'logo.png','/Users/ecvdigital12/tmp/ecvd-php/finaltest/guillaume/chat/uploads/1450347057_','image/png'),(4,'logo.png','/Users/ecvdigital12/tmp/ecvd-php/finaltest/guillaume/chat/uploads/1450347064_','image/png'),(5,'logo.png','/Users/ecvdigital12/tmp/ecvd-php/finaltest/guillaume/chat/uploads/1450347083_','image/png'),(6,'logo.png','uploads/1450347199_','image/png'),(7,'logo.png','uploads/1450347215_','image/png'),(8,'logo.png','uploads/1450347220_','image/png'),(9,'logo.png','uploads/1450347279_','image/png'),(10,'logo.png','uploads/1450349775_','image/png'),(11,'logo.png','uploads/1450349927_','image/png'),(12,'logo.png','uploads/1450349937_','image/png'),(13,'logo.png','uploads/1450349975_','image/png'),(14,'logo.png','uploads/1450350005_','image/png'),(15,'Capture d’écran 2015-11-18 à 15.31.25.png','uploads/1450351205_','image/png');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,NULL,'2015-12-17 10:32:12',NULL),(2,'fhfhfgh','2015-12-17 10:32:47',NULL),(3,'hgf','2015-12-17 10:32:57',NULL),(4,'dfgfdg','2015-12-17 10:33:45',NULL),(5,'gfdgdfg','2015-12-17 10:33:51',NULL),(6,'gjh','2015-12-17 10:36:43',NULL),(7,'gj','2015-12-17 10:36:49',NULL),(8,'jlj','2015-12-17 10:37:14',NULL),(9,'ffdgfd','2015-12-17 10:37:52',NULL),(10,'gjhjg','2015-12-17 10:37:59',NULL),(11,'gfh','2015-12-17 10:38:54',NULL),(12,'hkhjkhjkhjkhjk','2015-12-17 10:49:26',2),(13,'hjkjhkjhkhjk','2015-12-17 10:49:27',2),(14,'hjkhjkjhkjh','2015-12-17 10:49:28',2),(15,'hjkjhkhjkhjk','2015-12-17 10:49:29',2),(16,'hjkjhkjhkjhk','2015-12-17 10:49:30',2),(17,'hkjhkhjkjhk','2015-12-17 10:49:31',2),(18,'hkjhkjhkhjk','2015-12-17 10:49:32',2),(19,'hkjhkjhkhk','2015-12-17 10:49:33',2),(20,'hkhjkhjkhj','2015-12-17 10:49:34',2),(21,'hkjhkhjkhkh','2015-12-17 10:49:35',2),(22,'hjkhjkhjkhk','2015-12-17 10:49:36',2),(23,'hjkjhkhjkhjkhjkhjkhjk','2015-12-17 10:49:38',2),(24,'dfgfdgd','2015-12-17 11:00:21',2),(25,'dfgdfg','2015-12-17 11:00:22',2),(26,'dfgdfgd','2015-12-17 11:00:22',2),(27,'dgfdgfd','2015-12-17 11:00:23',2),(28,'dfgdfg','2015-12-17 11:00:24',2),(29,'dgdfg','2015-12-17 11:00:24',2),(30,'fdgfd','2015-12-17 11:00:25',2),(31,'gdf','2015-12-17 11:00:25',2),(32,'g','2015-12-17 11:00:25',2),(33,'dfg','2015-12-17 11:00:25',2),(34,'df','2015-12-17 11:00:25',2),(35,'g','2015-12-17 11:00:25',2),(36,'df','2015-12-17 11:00:26',2),(37,'gd','2015-12-17 11:00:26',2),(38,'fg','2015-12-17 11:00:26',2),(39,'df','2015-12-17 11:00:26',2),(40,'g','2015-12-17 11:00:26',2),(41,'df','2015-12-17 11:00:26',2),(42,'gdf','2015-12-17 11:00:26',2),(43,'klklk','2015-12-17 11:06:50',2),(44,'hukhubkuyk','2015-12-17 11:06:51',2),(45,'uykuy','2015-12-17 11:06:51',2),(46,'kuy','2015-12-17 11:06:51',2),(47,'k','2015-12-17 11:06:51',2),(48,'uyk','2015-12-17 11:06:52',2),(49,'yu','2015-12-17 11:06:52',2),(50,'k','2015-12-17 11:06:52',2),(51,'yuk','2015-12-17 11:06:53',2),(52,'k','2015-12-17 11:06:56',2),(53,'Hello it\'s a message','2015-12-17 11:13:33',2),(54,'Hello, i hope it works well','2015-12-17 11:13:39',2),(55,'it seems','2015-12-17 11:13:46',2),(56,'kind of i think','2015-12-17 11:13:50',2),(57,'well','2015-12-17 11:13:51',2),(58,'real time','2015-12-17 11:13:53',2),(59,'almost','2015-12-17 11:13:54',2),(60,'yeah','2015-12-17 11:13:55',2),(61,'yeah','2015-12-17 11:13:57',2),(62,'hELLO','2015-12-17 11:19:08',3),(63,'I am eminem','2015-12-17 11:19:15',3),(64,'I am eminem','2015-12-17 11:19:19',3),(65,'sick','2015-12-17 11:19:47',3),(66,'alright','2015-12-17 11:19:49',3),(67,'my picture rocks','2015-12-17 11:20:13',3);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `photo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ff@ddd.fr','fff','$2y$10$VGbW.LTBoVrLAT1kzF9yYewxKvOahmd/U3GPQl1JPyEuBuwUv8RV2',0),(2,'webarranco@webarranco.fr','webarranco','$2y$10$hTE.Zsb6Fij5bVK4IsrZNuVCbF8t.k2dyURA9k9/rHO7Fayt9PhG.',14),(3,'eminem@webarranco.fr','eminem','$2y$10$Y0g2i.ObjQu9tPwT6biiJuBnl6x7CukZeGknbXeqeXj0LaQOXdsfe',15);
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

-- Dump completed on 2015-12-17 12:21:50
