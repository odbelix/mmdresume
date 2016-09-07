-- MySQL dump 10.13  Distrib 5.7.13, for Linux (x86_64)
--
-- Host: localhost    Database: resume
-- ------------------------------------------------------
-- Server version	5.7.13-0ubuntu0.16.04.2

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
-- Table structure for table `assigment`
--

DROP TABLE IF EXISTS `assigment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assigment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `teacher` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateassigment` date NOT NULL,
  `version` int(11) NOT NULL,
  `responsable` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7DE1FD5AB0F6A6D5` (`teacher`),
  KEY `IDX_7DE1FD5ABE04EA9` (`job_id`),
  KEY `IDX_7DE1FD5AA76ED395` (`user_id`),
  CONSTRAINT `FK_7DE1FD5AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`),
  CONSTRAINT `FK_7DE1FD5ABE04EA9` FOREIGN KEY (`job_id`) REFERENCES `job` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assigment`
--

LOCK TABLES `assigment` WRITE;
/*!40000 ALTER TABLE `assigment` DISABLE KEYS */;
INSERT INTO `assigment` VALUES (2,3,1,'1',NULL,'2016-08-16',1,'adominguez');
/*!40000 ALTER TABLE `assigment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `basic`
--

DROP TABLE IF EXISTS `basic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `basic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `basic`
--

LOCK TABLES `basic` WRITE;
/*!40000 ALTER TABLE `basic` DISABLE KEYS */;
INSERT INTO `basic` VALUES (1,'Educación Básica en Matemáticas'),(2,'Educación Básica en Artes Visuales'),(3,'Educación Básica en Ingles');
/*!40000 ALTER TABLE `basic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experience`
--

DROP TABLE IF EXISTS `experience`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_id` int(11) DEFAULT NULL,
  `workplace_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `detail` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `startdate` date NOT NULL,
  `enddate` date DEFAULT NULL,
  `other` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_590C103A9F87BD` (`title_id`),
  KEY `IDX_590C103AC25FB46` (`workplace_id`),
  KEY `IDX_590C103A76ED395` (`user_id`),
  CONSTRAINT `FK_590C103A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`),
  CONSTRAINT `FK_590C103A9F87BD` FOREIGN KEY (`title_id`) REFERENCES `title` (`id`),
  CONSTRAINT `FK_590C103AC25FB46` FOREIGN KEY (`workplace_id`) REFERENCES `workplace` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experience`
--

LOCK TABLES `experience` WRITE;
/*!40000 ALTER TABLE `experience` DISABLE KEYS */;
INSERT INTO `experience` VALUES (13,7,3,5,'Encargado de los Dos laboratorios de Computación del Colegio','2016-01-01',NULL,''),(14,10,1,4,'Psicologo laboral','2016-01-01',NULL,''),(16,13,1,1,'','2001-01-08','2016-08-31',''),(18,NULL,1,6,'Responsable de el stock del Gimnasio para deporte','2016-01-01','2016-08-01','');
/*!40000 ALTER TABLE `experience` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_user`
--

DROP TABLE IF EXISTS `fos_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `firstname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `momlastname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `celphone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rut` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usertype` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usertypeid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_user`
--

LOCK TABLES `fos_user` WRITE;
/*!40000 ALTER TABLE `fos_user` DISABLE KEYS */;
INSERT INTO `fos_user` VALUES (1,'mmoscosodcl','mmoscosodcl','manuel.moscoso.d@gmail.com','manuel.moscoso.d@gmail.com',1,'3gmw3wzmfhgk0sskg4sk840cg0okc4s','$2y$13$hF5ZwvmQWFzDFn/H6thnaemD/QEz0F1JplEm7H09IR26aR13BXXOu','2016-08-29 11:55:05',0,0,NULL,NULL,NULL,'a:1:{i:0;s:12:\"ROLE_TEACHER\";}',0,NULL,'Manuel','Alejandro','Moscoso','Dominguez','1986-06-27 00:00:00',NULL,'+56991245413','18 Sur 5 Poniente B#051 Villa Doña Javiera','Talca','Masculino','162991140','Educación Media en Matemáticas','Docentes',1),(2,'dev','dev','dev@dev.cl','dev@dev.cl',1,'6swm8ftplckc0g8k8kk44wkgwcc44o0','$2y$13$srQ40DDHE9DkKTgPKtfNZup3Yr97sTtIVed4ecWyVk4OiTmXh7o7S','2016-08-30 13:45:20',0,0,NULL,NULL,NULL,'a:1:{i:0;s:14:\"ROLE_DEVELOPER\";}',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'adominguez','adominguez','adominguez@correo.cl','adominguez@correo.cl',1,'56ivc5vvt2wwg8gckco0osow08444kc','$2y$13$Nv17AUSWvkWEfALHxC1XZO/Vh34t7.HSlskVRQQRYI9/OZrkzPJ6W','2016-08-30 16:44:00',0,0,NULL,NULL,NULL,'a:1:{i:0;s:12:\"ROLE_MONITOR\";}',0,NULL,'Alejandro','Manuel','Dominguez','Moscoso','1986-06-27 00:00:00','712681317','+56991245413','18 Sur 5 Poniente B#051 Villa Doña Javiera','Talca','Masculino',NULL,NULL,NULL,NULL),(4,'ddominguez','ddominguez','ddominguez@correo.cl','ddominguez@correo.cl',1,'ef80bh6u654cckcc08wsgwk00oosskg','$2y$13$kbvZRluDTcCWajqALJ.ISeKw/Ov/DecBFUcD6Ff/vNM7KZg07PlTK','2016-08-29 16:46:09',0,0,NULL,NULL,NULL,'a:1:{i:0;s:14:\"ROLE_ASSISTANT\";}',0,NULL,'Domitila','Del Carmen','Dominguez','Gonzalez','1954-09-03 00:00:00',NULL,'+56995797665','18 Sur 5 Poniente B#051 Villa Doña Javiera','Talca','Femenino','8192962-9','Psicologo','Profesional',5),(5,'ystappung','ystappung','ystappung@correo.cl','ystappung@correo.cl',1,'fyoiec8gpvk0s8ss4w844wk8ssccg04','$2y$13$gpYoX3gLx3FYE8mREG0JwOXqeF.vLTkyNfRyZbcjUbLoajZEmcZgy','2016-08-29 16:40:25',0,0,NULL,NULL,NULL,'a:1:{i:0;s:14:\"ROLE_ASSISTANT\";}',0,NULL,'Yazmina','Soledad','Stappung','Gonzalez','1988-01-11 00:00:00',NULL,'+569977067077','6 Norte 3642','Talca','Femenino','167305555','TECNICO NIVEL SUPERIOR EN ADMINISTRACION','Técnico de Nivel Superior',2),(6,'rtrinidad','rtrinidad','rtrinidad@correo.cl','rtrinidad@correo.cl',1,'mo3yf5otok08kg0w4sws4kwcw4osg8s','$2y$13$0cOyg423DPOHzE7KN0vcz.J0..mKz9.pHWRCU.P6P4DA7TCFwzUlC','2016-08-29 16:55:02',0,0,NULL,NULL,NULL,'a:1:{i:0;s:14:\"ROLE_ASSISTANT\";}',0,NULL,'Rocio','Trinidad','Moscoso','Stappung','2015-07-14 00:00:00','991245413','+56991245413','18 Sur 5 Poniente B#051 Villa Doña Javiera','Talca','Femenino','250410433',NULL,'Enseñanza media completa',4),(7,'royarsun','royarsun','royarsun@correo.cl','royarsun@correo.cl',1,'iyxs85q8l5w0sg4ksc0oc4ok408g0kk','$2y$13$9/tOWMzfNdvtTkE/djHntuSCDyi9wJBAxSDsq9kBL9paA8nP.juS6','2016-08-30 16:44:06',0,0,NULL,NULL,NULL,'a:1:{i:0;s:12:\"ROLE_MANAGER\";}',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,'test','test','test@test.cl','test@test.cl',1,'7trli5motssgggssocoosg48gs0040o','$2y$13$vzeP6/9VApyv2q6HyMair.0GN5bkUM5bFJHWRlLbgcGneeI97PTTG',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:12:\"ROLE_MONITOR\";}',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'mmoscosod','mmoscosod','mmoscoso@mobiquos.cl','mmoscoso@mobiquos.cl',1,'lmqke3g391ws0sos04wsc8c48wwss0s','$2y$13$U8hSB8cYuOwtUG507.yzgOxeKbaZcGVS7WFpLaK3vA51v3pZ73HZu',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:12:\"ROLE_MONITOR\";}',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `fos_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_id` int(11) DEFAULT NULL,
  `workplace_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `detail` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `other` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `idtitle` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_27BA704BA9F87BD` (`title_id`),
  KEY `IDX_27BA704BAC25FB46` (`workplace_id`),
  CONSTRAINT `FK_27BA704BA9F87BD` FOREIGN KEY (`title_id`) REFERENCES `title` (`id`),
  CONSTRAINT `FK_27BA704BAC25FB46` FOREIGN KEY (`workplace_id`) REFERENCES `workplace` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
INSERT INTO `history` VALUES (1,1,1,'Educación Básica en Artes Visuales','Educación Básica en Artes Visuales para alumnos de Primero a Cuarto Básico','',1,1,'2011-02-28','2013-12-31');
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `information`
--

DROP TABLE IF EXISTS `information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shortname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `responsable` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `signature` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `version` int(11) NOT NULL,
  `creationdate` date NOT NULL,
  `lastmodification` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2979188364082763` (`shortname`),
  UNIQUE KEY `UNIQ_297918832B36786B` (`title`),
  UNIQUE KEY `UNIQ_2979188352520D07` (`responsable`),
  UNIQUE KEY `UNIQ_29791883AE880141` (`signature`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `information`
--

LOCK TABLES `information` WRITE;
/*!40000 ALTER TABLE `information` DISABLE KEYS */;
INSERT INTO `information` VALUES (1,'welcome_text','Bienvenidos a la Plataforma CV de DAEMTALCA','Bienvenidos a la Plataforma CV de DAEMTALCA','Rafael Oyarsun','Director de Selección de Personal,',1,'2016-08-16','2016-08-16');
/*!40000 ALTER TABLE `information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `infotext`
--

DROP TABLE IF EXISTS `infotext`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `infotext` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shortname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `section` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `infotext`
--

LOCK TABLES `infotext` WRITE;
/*!40000 ALTER TABLE `infotext` DISABLE KEYS */;
INSERT INTO `infotext` VALUES (1,'infotext_profession','Profesion','INFO'),(2,'infotext_type','Tipo de Postulantes','INFO'),(3,'infotext_basic','Educación Básica','INFO'),(4,'infotext_workplace','Establecimientos','INFO'),(5,'infotext_speciality','Especialidad','INFO'),(6,'infotext_job','Trabajos','INFO');
/*!40000 ALTER TABLE `infotext` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job`
--

DROP TABLE IF EXISTS `job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profession_id` int(11) DEFAULT NULL,
  `workplace_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `detail` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `startjob` date NOT NULL,
  `endjob` date NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastusername` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastupdate` date DEFAULT NULL,
  `created` date DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `hours` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FBD8E0F8AC25FB46` (`workplace_id`),
  KEY `IDX_FBD8E0F8FDEF8996` (`profession_id`),
  CONSTRAINT `FK_FBD8E0F8AC25FB46` FOREIGN KEY (`workplace_id`) REFERENCES `workplace` (`id`),
  CONSTRAINT `FK_FBD8E0F8FDEF8996` FOREIGN KEY (`profession_id`) REFERENCES `profession` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job`
--

LOCK TABLES `job` WRITE;
/*!40000 ALTER TABLE `job` DISABLE KEYS */;
INSERT INTO `job` VALUES (3,10,1,'Reemplazo profesor de Enseñanza básica general','Reemplazo profesor de Enseñanza básica general Reemplazo profesor de Enseñanza básica general Reemplazo profesor de Enseñanza básica general Reemplazo profesor de Enseñanza básica general 3','2016-08-10','2016-11-16','dev','dev','2016-08-10','2016-08-10',5,22);
/*!40000 ALTER TABLE `job` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profession`
--

DROP TABLE IF EXISTS `profession`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profession` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usertype_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BA930D69592D702D` (`usertype_id`),
  CONSTRAINT `FK_BA930D69592D702D` FOREIGN KEY (`usertype_id`) REFERENCES `usertype` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profession`
--

LOCK TABLES `profession` WRITE;
/*!40000 ALTER TABLE `profession` DISABLE KEYS */;
INSERT INTO `profession` VALUES (2,'Educación Básica sin Mencion',1),(5,'Educación Media en Matemáticas',1),(6,'Educación Básica en Lenguaje y Comunicación',1),(7,'Educación Básica en Ciencias Naturales',1),(10,'Educación Básica en Filosofía ',1),(11,'Educación Básica en Religion',1),(12,'Psicologo',5),(16,'TECNICO NIVEL SUPERIOR EN ADMINISTRACION',2),(18,'TECNICO NIVEL SUPERIOR EN INFORMATICA',2),(19,'Técnico Nivel Medio En Administración',3),(21,'Técnico Nivel Medio En Contabilidad',3),(22,'Kinesiologo',5);
/*!40000 ALTER TABLE `profession` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `speciality`
--

DROP TABLE IF EXISTS `speciality`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `speciality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `speciality`
--

LOCK TABLES `speciality` WRITE;
/*!40000 ALTER TABLE `speciality` DISABLE KEYS */;
/*!40000 ALTER TABLE `speciality` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher_director`
--

DROP TABLE IF EXISTS `teacher_director`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teacher_director` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `startdate` date NOT NULL,
  `enddate` date DEFAULT NULL,
  `workplace_id` int(11) DEFAULT NULL,
  `other` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1F86607BAC25FB46` (`workplace_id`),
  KEY `IDX_1F86607BA76ED395` (`user_id`),
  CONSTRAINT `FK_1F86607BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`),
  CONSTRAINT `FK_1F86607BAC25FB46` FOREIGN KEY (`workplace_id`) REFERENCES `workplace` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher_director`
--

LOCK TABLES `teacher_director` WRITE;
/*!40000 ALTER TABLE `teacher_director` DISABLE KEYS */;
INSERT INTO `teacher_director` VALUES (5,'2016-08-02','2016-09-08',1,NULL,1);
/*!40000 ALTER TABLE `teacher_director` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher_file`
--

DROP TABLE IF EXISTS `teacher_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teacher_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catholic` int(11) NOT NULL,
  `evangelical` int(11) NOT NULL,
  `teacher` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher_file`
--

LOCK TABLES `teacher_file` WRITE;
/*!40000 ALTER TABLE `teacher_file` DISABLE KEYS */;
INSERT INTO `teacher_file` VALUES (1,1,1,'mmoscosodcl');
/*!40000 ALTER TABLE `teacher_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `technician_mid`
--

DROP TABLE IF EXISTS `technician_mid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `technician_mid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `technician_mid`
--

LOCK TABLES `technician_mid` WRITE;
/*!40000 ALTER TABLE `technician_mid` DISABLE KEYS */;
/*!40000 ALTER TABLE `technician_mid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `technician_top`
--

DROP TABLE IF EXISTS `technician_top`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `technician_top` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `technician_top`
--

LOCK TABLES `technician_top` WRITE;
/*!40000 ALTER TABLE `technician_top` DISABLE KEYS */;
/*!40000 ALTER TABLE `technician_top` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `title`
--

DROP TABLE IF EXISTS `title`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `idtitle` int(11) NOT NULL,
  `obtaining` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `userid` int(11) NOT NULL,
  `profession_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2B36786BFDEF8996` (`profession_id`),
  KEY `IDX_2B36786BA76ED395` (`user_id`),
  CONSTRAINT `FK_2B36786BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`),
  CONSTRAINT `FK_2B36786BFDEF8996` FOREIGN KEY (`profession_id`) REFERENCES `profession` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `title`
--

LOCK TABLES `title` WRITE;
/*!40000 ALTER TABLE `title` DISABLE KEYS */;
INSERT INTO `title` VALUES (1,'Educación Básica en Artes Visuales',2,'2010',1,NULL,NULL),(6,'TECNICO NIVEL SUPERIOR EN ADMINISTRACION',16,'2014',5,16,NULL),(7,'TECNICO NIVEL SUPERIOR EN INFORMATICA',18,'2015',5,18,5),(10,'Psicologo',12,'2010',4,12,4),(12,'Educación Básica en Lenguaje y Comunicación',6,'2012',1,6,1),(13,'Educación Media en Matemáticas',5,'2014',1,5,1),(14,'TECNICO NIVEL SUPERIOR EN ADMINISTRACION',16,'2016',5,16,5);
/*!40000 ALTER TABLE `title` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type`
--

LOCK TABLES `type` WRITE;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` VALUES (1,'Docentes'),(2,'Técnico de Nivel Superior'),(3,'Técnico de Nivel Medio'),(4,'Enseñanza media completa'),(5,'Profesional');
/*!40000 ALTER TABLE `type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertype`
--

DROP TABLE IF EXISTS `usertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usertype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2AA32F585E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertype`
--

LOCK TABLES `usertype` WRITE;
/*!40000 ALTER TABLE `usertype` DISABLE KEYS */;
INSERT INTO `usertype` VALUES (1,'Docente','Los usuarios Docentes son aquellas personas que realizan trabajos de docencia con título profesional de Enseñanza básica o media.'),(2,'Técnico de Nivel Superior','Técnico de Nivel Superior'),(3,'Técnico de Nivel Medio','Técnico de Nivel Medio'),(4,'Enseñanza media completa','Enseñanza media completa'),(5,'Profesional','Profesional');
/*!40000 ALTER TABLE `usertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workplace`
--

DROP TABLE IF EXISTS `workplace`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workplace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `responsable` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workplace`
--

LOCK TABLES `workplace` WRITE;
/*!40000 ALTER TABLE `workplace` DISABLE KEYS */;
INSERT INTO `workplace` VALUES (1,'Escuela Brilla el Sol Felipe Cubillos Sigall','6 ½ ote. 11 ½ sur, Pasaje Las Vertientes s/n. Talca','Juan Carlos Hernández Tapia'),(3,'Liceo Abate Molina2','6 ½ ote. 11 ½ sur, Pasaje Las Vertientes s/n. Talca','Juan Carlos Hernández Tapia');
/*!40000 ALTER TABLE `workplace` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-07 11:25:37
