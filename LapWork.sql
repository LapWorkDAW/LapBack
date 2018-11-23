CREATE DATABASE  IF NOT EXISTS `lapwork` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `lapwork`;
-- MySQL dump 10.13  Distrib 8.0.13, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: lapwork
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.35-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- BDs structure for table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `inscription` (
  `id_inscription` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_inscription`,`id_project`,`id_user`),
  KEY `FK_Inscription_Project` (`id_project`),
  KEY `FK_Inscription_Usuario` (`id_user`),
  CONSTRAINT `FK_Inscription_Project` FOREIGN KEY (`id_project`) REFERENCES `project` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Inscription_Usuario` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscription`
--

LOCK TABLES `inscription` WRITE;
/*!40000 ALTER TABLE `inscription` DISABLE KEYS */;
/*!40000 ALTER TABLE `inscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- BDs structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `message` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  PRIMARY KEY (`id_message`,`id_post`,`receiver`),
  KEY `FK_Message_Usuario` (`receiver`),
  KEY `FK_Message_Post` (`id_post`),
  CONSTRAINT `FK_Message_Post` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Message_Usuario` FOREIGN KEY (`receiver`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- BDs structure for table `messageproject`
--

DROP TABLE IF EXISTS `messageproject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `messageproject` (
  `id_messageProject` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  PRIMARY KEY (`id_messageProject`,`id_post`,`id_project`),
  KEY `FK_Messageproject_Project` (`id_project`),
  KEY `FK_MessageProject_Post` (`id_post`),
  CONSTRAINT `FK_MessageProject_Post` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Messageproject_Project` FOREIGN KEY (`id_project`) REFERENCES `project` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messageproject`
--

LOCK TABLES `messageproject` WRITE;
/*!40000 ALTER TABLE `messageproject` DISABLE KEYS */;
/*!40000 ALTER TABLE `messageproject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- BDs structure for table `portfolio`
--

DROP TABLE IF EXISTS `portfolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `portfolio` (
  `id_portfolio` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `archive` varchar(250) NOT NULL,
  PRIMARY KEY (`id_portfolio`,`id_user`),
  KEY `FK_Portfolio_Usuario` (`id_user`),
  CONSTRAINT `FK_Portfolio_Usuario` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolio`
--

LOCK TABLES `portfolio` WRITE;
/*!40000 ALTER TABLE `portfolio` DISABLE KEYS */;
/*!40000 ALTER TABLE `portfolio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- BDs structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `remitter` int(11) NOT NULL,
  `message` varchar(250) NOT NULL,
  `dataDay` datetime NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `FK_Post_usuario` (`remitter`),
  CONSTRAINT `FK_Post_usuario` FOREIGN KEY (`remitter`) REFERENCES `usuario` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- BDs structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `project` (
  `id_project` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `nameCreator` varchar(20) DEFAULT NULL,
  `projectName` varchar(20) NOT NULL,
  `id_type` int(11) NOT NULL,
  `description` text,
  `dateStart` date NOT NULL,
  `dateFinish` date NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `projectStatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_project`,`id_user`),
  KEY `FK_Project_User` (`id_user`),
  KEY `FK_Project_TypeProject` (`id_type`),
  CONSTRAINT `FK_Project_TypeProject` FOREIGN KEY (`id_type`) REFERENCES `typeproject` (`id_type`) ON UPDATE CASCADE,
  CONSTRAINT `FK_Project_User` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- BDs structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `team` (
  `id_team` int(11) NOT NULL AUTO_INCREMENT,
  `id_project` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_team`,`id_project`,`id_user`),
  KEY `FK_Team_Project` (`id_project`),
  KEY `FK_Team_Usuario` (`id_user`),
  CONSTRAINT `FK_Team_Project` FOREIGN KEY (`id_project`) REFERENCES `project` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Team_Usuario` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team`
--

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;

--
-- BDs structure for table `typeproject`
--

DROP TABLE IF EXISTS `typeproject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `typeproject` (
  `id_type` int(11) NOT NULL AUTO_INCREMENT,
  `nameType` varchar(50) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typeproject`
--

LOCK TABLES `typeproject` WRITE;
/*!40000 ALTER TABLE `typeproject` DISABLE KEYS */;
INSERT INTO `typeproject` VALUES (1,'Art'),(2,'Engineering'),(3,'IT'),(4,'Literary'),(5,'Technological');
/*!40000 ALTER TABLE `typeproject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- BDs structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `usuario` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(20) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `saveName` tinyint(1) DEFAULT NULL,
  `cv` varchar(100) DEFAULT NULL,
  `description` text,
  `knowledge` varchar(250) DEFAULT NULL,
  `isActiv` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- BDs structure for table `voteprojectfavourite`
--

DROP TABLE IF EXISTS `voteprojectfavourite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `voteprojectfavourite` (
  `id_voteFavourite` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  PRIMARY KEY (`id_voteFavourite`,`id_project`,`id_user`),
  KEY `FK_VoteProjectFavourite_Project` (`id_project`),
  KEY `FK_VoteProjectFavourite_Usuario` (`id_user`),
  CONSTRAINT `FK_VoteProjectFavourite_Project` FOREIGN KEY (`id_project`) REFERENCES `project` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_VoteProjectFavourite_Usuario` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voteprojectfavourite`
--

LOCK TABLES `voteprojectfavourite` WRITE;
/*!40000 ALTER TABLE `voteprojectfavourite` DISABLE KEYS */;
/*!40000 ALTER TABLE `voteprojectfavourite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- BDs structure for table `voteprojectstar`
--

DROP TABLE IF EXISTS `voteprojectstar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `voteprojectstar` (
  `id_voteStar` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  `quantity` int(1) NOT NULL,
  PRIMARY KEY (`id_voteStar`,`id_project`,`id_user`),
  KEY `FK_VoteProjectStar_Project` (`id_project`),
  KEY `FK_VoteProjectStar_Usuario` (`id_user`),
  CONSTRAINT `FK_VoteProjectStar_Project` FOREIGN KEY (`id_project`) REFERENCES `project` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_VoteProjectStar_Usuario` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voteprojectstar`
--

LOCK TABLES `voteprojectstar` WRITE;
/*!40000 ALTER TABLE `voteprojectstar` DISABLE KEYS */;
/*!40000 ALTER TABLE `voteprojectstar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- BDs structure for table `voteuser`
--

DROP TABLE IF EXISTS `voteuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `voteuser` (
  `id_voteUser` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_vote` int(11) NOT NULL,
  `id_candidate` int(11) NOT NULL,
  `quantity` int(1) NOT NULL,
  PRIMARY KEY (`id_voteUser`,`id_user_vote`,`id_candidate`),
  KEY `FK_VoteUser_Remitter` (`id_user_vote`),
  KEY `FK_VoteUser_Receiver` (`id_candidate`),
  CONSTRAINT `FK_VoteUser_Receiver` FOREIGN KEY (`id_candidate`) REFERENCES `usuario` (`id_user`) ON UPDATE CASCADE,
  CONSTRAINT `FK_VoteUser_Remitter` FOREIGN KEY (`id_user_vote`) REFERENCES `usuario` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voteuser`
--

LOCK TABLES `voteuser` WRITE;
/*!40000 ALTER TABLE `voteuser` DISABLE KEYS */;
/*!40000 ALTER TABLE `voteuser` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-21 12:28:54
