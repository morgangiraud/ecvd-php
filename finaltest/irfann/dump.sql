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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'dfsg','2015-12-17 11:06:28',NULL),(2,'dsf','2015-12-17 11:06:29',NULL),(3,'c','2015-12-17 11:06:31',NULL),(4,'c','2015-12-17 11:11:32',NULL),(5,'c','2015-12-17 11:11:55',NULL),(6,'c','2015-12-17 11:12:01',NULL),(7,'c','2015-12-17 11:12:03',NULL),(8,'c','2015-12-17 11:12:04',NULL),(9,'c','2015-12-17 11:12:05',NULL),(10,'fdscbv','2015-12-17 11:12:08',NULL),(11,'fdscbv','2015-12-17 11:12:28',NULL),(12,'','2015-12-17 11:12:40',NULL),(13,'','2015-12-17 11:12:57',NULL),(14,'','2015-12-17 11:13:03',NULL),(15,'','2015-12-17 11:13:19',NULL),(16,'','2015-12-17 11:14:22',NULL),(17,'dsg','2015-12-17 11:15:14',NULL),(18,'dsf','2015-12-17 11:15:17',NULL),(19,'fds','2015-12-17 11:15:18',NULL),(20,'dsf','2015-12-17 11:15:19',NULL),(21,'cxv','2015-12-17 11:15:19',NULL),(22,'cxv','2015-12-17 11:15:59',NULL),(23,'fsd','2015-12-17 11:16:02',NULL),(24,'sf','2015-12-17 11:16:03',NULL),(25,'vx','2015-12-17 11:16:04',NULL),(26,'ez','2015-12-17 11:16:05',NULL),(27,'ez','2015-12-17 11:16:23',NULL),(28,'ez','2015-12-17 11:17:12',NULL),(29,'ez','2015-12-17 11:17:28',NULL),(30,'ez','2015-12-17 11:17:35',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'test@gmail.com','test','$2y$10$1Fg6.MvKf6/QZvBtmQqDneGID6DrDloeYUUxRPY1MrFeRhmRkhQ3K',NULL),(2,'test@gmail.com','test','$2y$10$T/gVEXT1IRl49DQCMAYwp.3EDhBB3DJHrjRukK8BtDD/rSdPqI9wC',NULL),(3,'test@gmail.com','test','$2y$10$aFS5WQTY0PLZfo7W8qYHHu1Pl9nYuCZ3Oy8XFhU1ulA6hP9rEKq0W',NULL),(4,'test@gmail.com','test','$2y$10$zVDb2davPlT9ptOYz1d0QuYR/H/dkJzAZWHAf0rIVNZYu5I.wRDvq',NULL),(5,'test@gmail.com','test','$2y$10$0fawLYMkf/4rLPgDeYYK6eyaHBrI65QoxEGdihFlJ.YX8nRXjh4.K',NULL),(6,'admin@gmail.com','admin','$2y$10$VyteneOZ3ESm5L2EOuGUReG7lydSbntDc84T1HX6KjXTfwJt1JRTS',NULL),(7,'bla@gmail.com','bla','$2y$10$8QAxMsPKRTkjYsQEfRBQD.2fUCsrYd0WEhE.8lbH8CQYXihn93rLC',NULL),(8,'co@co.co','co','$2y$10$7L/T9Y25QErPhe09Muj68.BwQkEB.Wt6iHRdoF3EBRCDQzsynPR8W',NULL),(9,'mdr@gmail.com','mdr','$2y$10$v33HeQ.JbT.y8rPxYx.bzeEyyqOCMh89vDSzyx4Sx7JrCnZuIfDJm',NULL);
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

-- Dump completed on 2015-12-17 12:18:58
