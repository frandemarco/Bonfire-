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
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assignments` (
  `id` int NOT NULL,
  `assignment_name` varchar(255) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `class_id` int NOT NULL,
  `max_grade` int NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `class_id_idx` (`class_id`),
  CONSTRAINT `assignments_classes_id_fk` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignments`
--

LOCK TABLES `assignments` WRITE;
/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,'CSCI 185',1,'2024-03-11','2024-03-31','Spring 2024'),(2,'CSCI 330 ',1,'2024-01-22','2024-03-31','Spring 2024'),(3,'CSCI 345',1,'2024-03-12','2024-03-31','Spring 2024'),(4,'CSCI 345',1,'2024-03-12','2024-03-31','Spring 2024'),(5,'CSCI 345',1,'2024-03-12','2024-03-31','Spring 2024'),(6,'CSCI 345',1,'2024-03-12','2024-03-31','Spring 2024'),(7,'CSCI 345',1,'2024-03-12','2024-03-31','Spring 2024'),(8,'test123',1,'2024-04-22','2024-04-29','Spring');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
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
INSERT INTO `course_grades` VALUES (7,1,NULL,NULL),(7,2,NULL,NULL),(7,3,NULL,NULL),(7,4,NULL,NULL),(7,5,NULL,NULL),(7,6,NULL,NULL),(7,8,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Francis','teacher1@fake.com','$2y$10$9JlAjziGIhLuEV7QPRM7NOZw9t28IZtGSW8fPXfC3XlV78MRG.nMi','teacher',NULL,NULL,'Lanzo'),(6,'frank','email','$2y$10$SqRey/w26x0NzImHFOLvDe8hR04EDvFB5sanmQNhTUntKulG7rf9y','admin',NULL,NULL,'dem'),(7,'stu','student@email.com','$2y$10$QCMenLSjZA3O7NgHh7aDs.qoTUVnFFNYM7fJkY9kQMP3T.qUiR30m','student',NULL,NULL,'dent'),(8,'george','g@s.com','$2y$10$Ceo485m3pz8XdYSeNh2QBukOsKyvpcEV6a0L8BzrZyqxGOJBBfKVe','admin',NULL,NULL,'salayka'),(9,'s','s@s.com','$2y$10$jgRWcV1kb.Dk0yb1JBRLHe/LVB6cg654kslZ8/6JEMKXH7zhfjRbO','student',NULL,NULL,'s'),(14,'Mike','testemail@fake.com','$2y$10$ZwfRV29yh1WDZEtkEy31suQPLSk66nKmLnkprrTdK2J/0HkB72A0y','admin',NULL,NULL,'Angelo'),(15,'John','fake@fake.com','$2y$10$/HjEMr2H25UGhkn55Djpautw4M4TW0OyFPbIhJYGvwwIeBU.HoisW','student',NULL,NULL,'Doe'),(17,'Chuck','teacher2@fake.com','$2y$10$ww8DQHqSSwy6FstvlYg82OlgWuZbi7d2UuOUHzo0zF7hBMc3aeM7e','teacher',NULL,NULL,'Graziella'),(18,'Fred','teacher3@fake.com','$2y$10$X0Ld89.yOOOMwhEjci7Nx.3kmvhpw5S.Dax70Sf129WEjnZUi3CbS','teacher',NULL,NULL,'Ermin'),(19,'Arnold','teacher4@fake.com',NULL,'teacher',NULL,NULL,'Amir'),(20,'A','student1@fake.com',NULL,'student',NULL,NULL,NULL),(21,'B','student2@fake.com',NULL,'student',NULL,NULL,NULL),(22,'C','student3@fake.com',NULL,'student',NULL,NULL,NULL),(23,'D','student4@fake.com',NULL,'student',NULL,NULL,NULL),(24,'E','student5@fake.com',NULL,'student',NULL,NULL,NULL),(25,'F','student6@fake.com',NULL,'student',NULL,NULL,NULL),(26,'G','student7@fake.com',NULL,'student',NULL,NULL,NULL),(27,'H','student8@fake.com',NULL,'student',NULL,NULL,NULL),(28,'I','student9@fake.com',NULL,'student',NULL,NULL,NULL),(29,'J','student10@fake.com',NULL,'student',NULL,NULL,NULL),(30,'K','student11@fake.com',NULL,'student',NULL,NULL,NULL),(31,'L','student12@fake.com',NULL,'student',NULL,NULL,NULL),(32,'M','student13@fake.com',NULL,'student',NULL,NULL,NULL),(33,'N','student14@fake.com',NULL,'student',NULL,NULL,NULL),(34,'O','student15@fake.com',NULL,'student',NULL,NULL,NULL),(35,'P','student16@fake.com',NULL,'student',NULL,NULL,NULL),(36,'Q','student17@fake.com',NULL,'student',NULL,NULL,NULL),(37,'R','student18@fake.com',NULL,'student',NULL,NULL,NULL),(38,'S','student19@fake.com',NULL,'student',NULL,NULL,NULL),(39,'T','student20@fake.com',NULL,'student',NULL,NULL,NULL),(40,'U','student21@fake.com',NULL,'student',NULL,NULL,NULL),(41,'V','student22@fake.com',NULL,'student',NULL,NULL,NULL),(42,'W','student23@fake.com',NULL,'student',NULL,NULL,NULL),(43,'X','student24@fake.com',NULL,'student',NULL,NULL,NULL),(44,'Y','student25@fake.com',NULL,'student',NULL,NULL,NULL),(47,'Stew','a@a.com','$2y$10$EDXBT1h3rux./ChB.X.8VOrYnobdWTlSEmL.YITHqmySMba8WM.7y','student',NULL,NULL,'Dent');
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

-- Dump completed on 2024-04-15 10:43:02
