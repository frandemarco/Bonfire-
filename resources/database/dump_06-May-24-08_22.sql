-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: bonfire
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.22.04.1

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
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `announcements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `teacher_id` int DEFAULT NULL,
  `body` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `announcments_classes_id_fk` (`class_id`),
  KEY `announcments_classes_teacher_id_fk` (`teacher_id`),
  CONSTRAINT `announcments_classes_id_fk` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  CONSTRAINT `announcments_classes_teacher_id_fk` FOREIGN KEY (`teacher_id`) REFERENCES `classes` (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (1,10,51,'Class is canceled, blame Nick. ','Class Canceled','2024-04-29 08:26:29'),(2,10,51,'No longer cancelling class because I am awesome','Class not cancelled','2024-04-29 10:00:00'),(3,10,51,'Currently hating my life','I HATE MY LIFE','2024-04-29 10:59:00'),(4,10,51,'THIS IS MAKING ME HATE MYSELF MORE','I REALLY HATE MY LIFE','2024-04-29 10:00:00'),(5,10,51,'I WANNA TEST THE STABILITY OF THE DEAD STATE???','THis is another test','2024-04-29 12:37:05'),(6,10,51,'TESTING!!!!!!!!!!!!!!!!!!!!!!!!!!!','TESTING','2024-04-29 12:47:47'),(7,10,51,'TESTING!!!!!!!!!!!!','I HAVE TO TEST','2024-04-29 08:49:52'),(8,10,51,'WEEEEWOOOOOOO','WEEEEWOOOO','2024-04-29 09:23:39'),(9,11,51,'BREAKING NEWS PHP SUCKS','I HATE THIS PROGRAM','2024-04-29 21:16:32'),(10,11,51,'I GOTTA TEST DIS SHIT','TEST3','2024-04-29 21:19:18'),(11,11,51,'reeeeeeeee','reeeeeeeeeeeeeeeee','2024-04-29 21:19:31'),(12,11,51,'rreeeeeeeeeee','reeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee','2024-04-29 21:19:42');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assignments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assignment_name` varchar(255) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `class_id` int NOT NULL,
  `max_grade` int NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `column_name` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `class_id_idx` (`class_id`),
  CONSTRAINT `assignments_classes_id_fk` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignments`
--

LOCK TABLES `assignments` WRITE;
/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
INSERT INTO `assignments` VALUES (1,'test assignment',NULL,10,100,'This is a test Assignment','2024-04-30 23:59:00','homework',NULL);
/*!40000 ALTER TABLE `assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) NOT NULL,
  `teacher_id` int NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `term` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `teacher_id_idx` (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,'CSCI 185',1,'2024-03-11','2024-03-31','Spring 2024'),(2,'CSCI 330 ',1,'2024-01-22','2024-03-31','Spring 2024'),(3,'CSCI 345',1,'2024-03-12','2024-03-31','Spring 2024'),(4,'CSCI 345',1,'2024-03-12','2024-03-31','Spring 2024'),(5,'CSCI 345',1,'2024-03-12','2024-03-31','Spring 2024'),(6,'CSCI 345',1,'2024-03-12','2024-03-31','Spring 2024'),(7,'CSCI 345',1,'2024-03-12','2024-03-31','Spring 2024'),(8,'test123',1,'2024-04-22','2024-04-29','Spring'),(9,'Tester1',18,'2024-04-01','2024-04-26','Spring'),(10,'tester2',51,'2024-01-25','2024-05-27','Spring'),(11,'Tester3',51,'2024-04-01','2024-05-10','Spring');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `announcement_id` int NOT NULL,
  `user_id` int NOT NULL,
  `text` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `announcement_id` (`announcement_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `announcement_id` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,1,51,'TEST','2024-04-30 18:10:29'),(2,1,51,'Test2','2024-04-30 18:11:35');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `communication`
--

DROP TABLE IF EXISTS `communication`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `communication` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `message` int DEFAULT NULL,
  `chat_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `communication_users_id_fk` (`user_id`),
  CONSTRAINT `communication_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `communication`
--

LOCK TABLES `communication` WRITE;
/*!40000 ALTER TABLE `communication` DISABLE KEYS */;
/*!40000 ALTER TABLE `communication` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_grades`
--

DROP TABLE IF EXISTS `course_grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_grades` (
  `user_id` int NOT NULL,
  `class_id` int NOT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`class_id`),
  KEY `class_id_key` (`class_id`),
  CONSTRAINT `course_grades_classes_id_fk` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  CONSTRAINT `user_id_key` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_grades`
--

LOCK TABLES `course_grades` WRITE;
/*!40000 ALTER TABLE `course_grades` DISABLE KEYS */;
INSERT INTO `course_grades` VALUES (7,1,NULL,NULL),(7,2,NULL,NULL),(7,3,NULL,NULL),(7,4,NULL,NULL),(7,5,NULL,NULL),(7,6,NULL,NULL),(7,8,NULL,NULL),(7,9,NULL,NULL),(7,11,NULL,NULL),(9,9,NULL,NULL),(9,11,NULL,NULL),(15,9,NULL,NULL),(15,11,NULL,NULL),(20,11,NULL,NULL),(22,10,NULL,NULL),(23,10,NULL,NULL),(24,10,NULL,NULL),(25,10,NULL,NULL),(26,10,NULL,NULL),(38,11,NULL,NULL),(39,11,NULL,NULL),(40,11,NULL,NULL),(41,11,NULL,NULL),(42,11,NULL,NULL),(44,10,NULL,NULL),(47,9,NULL,NULL),(47,10,NULL,NULL),(49,1,NULL,NULL),(49,2,NULL,NULL),(49,3,NULL,NULL),(49,4,NULL,NULL),(49,5,NULL,NULL),(49,6,NULL,NULL),(49,9,NULL,NULL),(49,10,NULL,NULL),(49,11,NULL,NULL);
/*!40000 ALTER TABLE `course_grades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('student','teacher','admin') DEFAULT 'student',
  `sec1` varchar(255) DEFAULT NULL,
  `sec2` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Francis','teacher1@fake.com','$2y$10$9JlAjziGIhLuEV7QPRM7NOZw9t28IZtGSW8fPXfC3XlV78MRG.nMi','teacher',NULL,NULL,'Lanzo'),(2,'frank','email','$2y$10$SqRey/w26x0NzImHFOLvDe8hR04EDvFB5sanmQNhTUntKulG7rf9y','admin',NULL,NULL,'dem'),(7,'stu','student@email.com','$2y$10$QCMenLSjZA3O7NgHh7aDs.qoTUVnFFNYM7fJkY9kQMP3T.qUiR30m','student',NULL,NULL,'dent'),(8,'george','g@s.com','$2y$10$Ceo485m3pz8XdYSeNh2QBukOsKyvpcEV6a0L8BzrZyqxGOJBBfKVe','admin',NULL,NULL,'salayka'),(9,'s','s@s.com','$2y$10$jgRWcV1kb.Dk0yb1JBRLHe/LVB6cg654kslZ8/6JEMKXH7zhfjRbO','student',NULL,NULL,'s'),(14,'Mike','testemail@fake.com','$2y$10$ZwfRV29yh1WDZEtkEy31suQPLSk66nKmLnkprrTdK2J/0HkB72A0y','admin',NULL,NULL,'Angelo'),(15,'John','fake@fake.com','$2y$10$/HjEMr2H25UGhkn55Djpautw4M4TW0OyFPbIhJYGvwwIeBU.HoisW','student',NULL,NULL,'Doe'),(17,'Chuck','teacher2@fake.com','$2y$10$ww8DQHqSSwy6FstvlYg82OlgWuZbi7d2UuOUHzo0zF7hBMc3aeM7e','teacher',NULL,NULL,'Graziella'),(18,'Fred','teacher3@fake.com','$2y$10$X0Ld89.yOOOMwhEjci7Nx.3kmvhpw5S.Dax70Sf129WEjnZUi3CbS','teacher',NULL,NULL,'Ermin'),(19,'Arnold','teacher4@fake.com','','teacher',NULL,NULL,'Amir'),(20,'A','student1@fake.com',NULL,'student',NULL,NULL,NULL),(21,'B','student2@fake.com',NULL,'student',NULL,NULL,NULL),(22,'C','student3@fake.com',NULL,'student',NULL,NULL,NULL),(23,'D','student4@fake.com',NULL,'student',NULL,NULL,NULL),(24,'E','student5@fake.com',NULL,'student',NULL,NULL,NULL),(25,'F','student6@fake.com',NULL,'student',NULL,NULL,NULL),(26,'G','student7@fake.com',NULL,'student',NULL,NULL,NULL),(27,'H','student8@fake.com',NULL,'student',NULL,NULL,NULL),(28,'I','student9@fake.com',NULL,'student',NULL,NULL,NULL),(29,'J','student10@fake.com',NULL,'student',NULL,NULL,NULL),(30,'K','student11@fake.com',NULL,'student',NULL,NULL,NULL),(31,'L','student12@fake.com',NULL,'student',NULL,NULL,NULL),(32,'M','student13@fake.com',NULL,'student',NULL,NULL,NULL),(33,'N','student14@fake.com',NULL,'student',NULL,NULL,NULL),(34,'O','student15@fake.com',NULL,'student',NULL,NULL,NULL),(35,'P','student16@fake.com',NULL,'student',NULL,NULL,NULL),(36,'Q','student17@fake.com',NULL,'student',NULL,NULL,NULL),(37,'R','student18@fake.com',NULL,'student',NULL,NULL,NULL),(38,'S','student19@fake.com',NULL,'student',NULL,NULL,NULL),(39,'T','student20@fake.com',NULL,'student',NULL,NULL,NULL),(40,'U','student21@fake.com',NULL,'student',NULL,NULL,NULL),(41,'V','student22@fake.com',NULL,'student',NULL,NULL,NULL),(42,'W','student23@fake.com',NULL,'student',NULL,NULL,NULL),(43,'X','student24@fake.com',NULL,'student',NULL,NULL,NULL),(44,'Y','student25@fake.com',NULL,'student',NULL,NULL,NULL),(47,'Stew','a@a.com','$2y$10$EDXBT1h3rux./ChB.X.8VOrYnobdWTlSEmL.YITHqmySMba8WM.7y','student',NULL,NULL,'Dent'),(49,'Silver','LordSilverThief2018@gmail.com','$2y$10$D9SWqQiTydgg/dsvWToCx.Zq37uHR4PZuQHN/VbFoCOyw1j6OjYCm','student',NULL,NULL,'Thief'),(50,'Nicholas','ncivil@nyit.edu','$2y$10$7UxjnRG.zrJoprCE39EWj.65oT2ouKGFVLoAP5o5Dnq291pVjp31C','admin',NULL,NULL,'Civil'),(51,'teacher','t2@t.com','$2y$10$HHM9uLTU8VLT6r7s2Sy8tOWSlt8Jvi7yGj.1sbYk.DKZz1B/R//0O','teacher',NULL,NULL,'test');
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

-- Dump completed on 2024-05-06  8:22:51
