CREATE DATABASE  IF NOT EXISTS `esportsladdersystem` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `esportsladdersystem`;
-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: esportsladdersystem
-- ------------------------------------------------------
-- Server version	8.0.18

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
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `game` (
  `idgame` int(11) NOT NULL AUTO_INCREMENT,
  `game_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `game_image` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idgame`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game`
--

LOCK TABLES `game` WRITE;
/*!40000 ALTER TABLE `game` DISABLE KEYS */;
INSERT INTO `game` VALUES (1,'FIFA 20','fifa20.png'),(2,'Super Smash Bros. Ultimate','smashultimate.png'),(3,'Call of Duty: Warzone','codwar.png'),(4,'Rocket League','rocketleague.png'),(5,'Fortnite','fortnite.png');
/*!40000 ALTER TABLE `game` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_has_ladder`
--

DROP TABLE IF EXISTS `game_has_ladder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `game_has_ladder` (
  `idgame` int(11) NOT NULL,
  `idladder` int(11) NOT NULL,
  PRIMARY KEY (`idgame`,`idladder`),
  KEY `fk_game_has_ladder_ladder1_idx` (`idladder`),
  KEY `fk_game_has_ladder_game1_idx` (`idgame`),
  CONSTRAINT `fk_game_has_ladder_game1` FOREIGN KEY (`idgame`) REFERENCES `game` (`idgame`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_game_has_ladder_ladder1` FOREIGN KEY (`idladder`) REFERENCES `ladder` (`idladder`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_has_ladder`
--

LOCK TABLES `game_has_ladder` WRITE;
/*!40000 ALTER TABLE `game_has_ladder` DISABLE KEYS */;
INSERT INTO `game_has_ladder` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(1,2),(2,2),(3,2),(4,2),(5,2),(4,3),(3,4),(4,4),(5,4);
/*!40000 ALTER TABLE `game_has_ladder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ladder`
--

DROP TABLE IF EXISTS `ladder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ladder` (
  `idladder` int(11) NOT NULL AUTO_INCREMENT,
  `ladderType` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idladder`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ladder`
--

LOCK TABLES `ladder` WRITE;
/*!40000 ALTER TABLE `ladder` DISABLE KEYS */;
INSERT INTO `ladder` VALUES (1,'Single Ladder'),(2,'Double Ladder'),(3,'Trio Ladder'),(4,'Quad Ladder');
/*!40000 ALTER TABLE `ladder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `match`
--

DROP TABLE IF EXISTS `match`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `match` (
  `idmatch` int(11) NOT NULL AUTO_INCREMENT,
  `matchTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `matchStatus` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Posted',
  `idgame` int(11) NOT NULL,
  `idladder` int(11) NOT NULL,
  `idteam` int(11) NOT NULL,
  PRIMARY KEY (`idmatch`,`idgame`,`idladder`,`idteam`),
  KEY `fk_match_game_has_ladder1_idx` (`idgame`,`idladder`),
  KEY `fk_match_team1_idx` (`idteam`),
  CONSTRAINT `fk_match_game_has_ladder1` FOREIGN KEY (`idgame`, `idladder`) REFERENCES `game_has_ladder` (`idgame`, `idladder`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_match_team1` FOREIGN KEY (`idteam`) REFERENCES `team` (`idteam`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `match`
--

LOCK TABLES `match` WRITE;
/*!40000 ALTER TABLE `match` DISABLE KEYS */;
INSERT INTO `match` VALUES (1,'2020-05-06 21:14:43','Done',3,4,1),(2,'2020-05-06 21:14:43','Done',3,1,3),(3,'2020-05-06 21:14:43','Posted',3,1,6),(4,'2020-05-06 21:14:43','Rejected',1,1,7),(5,'2020-05-06 21:14:43','Disputed',1,1,8),(6,'2020-05-06 21:14:43','Done',4,2,5),(7,'2020-05-06 21:14:43','Disputed',1,1,9),(8,'2020-05-06 21:14:43','Done',1,1,10),(9,'2020-05-06 21:14:43','Done',1,1,8),(10,'2020-05-06 21:14:43','Done',3,4,4);
/*!40000 ALTER TABLE `match` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `from_iduser` int(11) NOT NULL,
  `to_iduser` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci,
  `receive_date` datetime DEFAULT CURRENT_TIMESTAMP,
  KEY `fk_player_has_player_player2_idx` (`to_iduser`),
  KEY `fk_player_has_player_player1_idx` (`from_iduser`),
  CONSTRAINT `fk_player_has_player_player1` FOREIGN KEY (`from_iduser`) REFERENCES `user` (`iduser`),
  CONSTRAINT `fk_player_has_player_player2` FOREIGN KEY (`to_iduser`) REFERENCES `user` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team` (
  `idteam` int(11) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `team_owner` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `team_type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `team_matches` int(11) DEFAULT '0',
  `team_wins` int(11) DEFAULT '0',
  `team_losses` int(11) DEFAULT '0',
  `idgame` int(11) NOT NULL,
  PRIMARY KEY (`idteam`,`idgame`),
  KEY `fk_team_game1_idx` (`idgame`),
  CONSTRAINT `fk_team_game1` FOREIGN KEY (`idgame`) REFERENCES `game` (`idgame`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team`
--

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` VALUES (1,'The Fellas','thriftyRuffs5','Quad Ladder',2,1,1,3),(2,'Sindoze','dreadfulThrush2','Double Ladder',1,0,1,4),(3,'I Carry','excludedBuzzard7','Single Ladder',1,0,1,3),(4,'SoaR Gaming','drearyChough8','Quad Ladder',2,1,1,3),(5,'Galaxy','fondTomatoe7','Double Ladder',1,1,0,4),(6,'M0ZILL4','euphoricWasp5','Single Ladder',2,1,1,3),(7,'CR7 Fan','pitifulPonie0','Single Ladder',1,0,1,1),(8,'American Ducks','betrayedOtter5','Single Ladder',1,1,0,1),(9,'TSM','joyfulLard0','Single Ladder',0,0,0,1),(10,'Sidemen','puzzledOcelot8','Single Ladder',1,1,0,1),(12,'100 Thieves','dmartinez341','Single Ladder',0,0,0,3);
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_has_match`
--

DROP TABLE IF EXISTS `team_has_match`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_has_match` (
  `idteam` int(11) NOT NULL,
  `idmatch` int(11) NOT NULL,
  `idgame` int(11) NOT NULL,
  `idladder` int(11) NOT NULL,
  `team1Score` int(11) DEFAULT NULL,
  `team2Score` int(11) DEFAULT NULL,
  PRIMARY KEY (`idteam`,`idmatch`,`idgame`,`idladder`),
  KEY `fk_team_has_match_match1_idx` (`idmatch`,`idgame`,`idladder`),
  KEY `fk_team_has_match_team1_idx` (`idteam`),
  CONSTRAINT `fk_team_has_match_match1` FOREIGN KEY (`idmatch`, `idgame`, `idladder`) REFERENCES `match` (`idmatch`, `idgame`, `idladder`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_team_has_match_team1` FOREIGN KEY (`idteam`) REFERENCES `team` (`idteam`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_has_match`
--

LOCK TABLES `team_has_match` WRITE;
/*!40000 ALTER TABLE `team_has_match` DISABLE KEYS */;
INSERT INTO `team_has_match` VALUES (1,1,3,4,23,16),(1,10,3,4,6,15),(2,6,4,2,2,5),(3,2,3,1,2,3),(4,1,3,4,16,23),(4,10,3,4,15,6),(5,6,4,2,5,2),(6,2,3,1,3,2),(7,8,1,1,1,3),(8,5,1,1,3,0),(9,5,1,1,4,1),(9,7,1,1,5,0),(10,7,1,1,3,1),(10,8,1,1,3,1);
/*!40000 ALTER TABLE `team_has_match` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_in_ladder`
--

DROP TABLE IF EXISTS `team_in_ladder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_in_ladder` (
  `idteam` int(11) NOT NULL,
  `idladder` int(11) NOT NULL,
  `idgame` int(11) NOT NULL,
  PRIMARY KEY (`idteam`,`idladder`,`idgame`),
  KEY `fk_team_has_game_has_ladder_game_has_ladder1_idx` (`idgame`,`idladder`),
  KEY `fk_team_has_game_has_ladder_team1_idx` (`idteam`),
  CONSTRAINT `fk_team_has_game_has_ladder_game_has_ladder1` FOREIGN KEY (`idgame`, `idladder`) REFERENCES `game_has_ladder` (`idgame`, `idladder`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_team_has_game_has_ladder_team1` FOREIGN KEY (`idteam`) REFERENCES `team` (`idteam`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_in_ladder`
--

LOCK TABLES `team_in_ladder` WRITE;
/*!40000 ALTER TABLE `team_in_ladder` DISABLE KEYS */;
INSERT INTO `team_in_ladder` VALUES (1,4,3),(2,2,4),(3,1,3),(4,4,3),(5,2,4),(6,1,3),(7,1,1),(8,1,1),(9,1,1),(10,1,1);
/*!40000 ALTER TABLE `team_in_ladder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_wins` int(11) DEFAULT '0',
  `user_matches` int(11) DEFAULT '0',
  `user_losses` int(11) DEFAULT '0',
  `isonline` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'thriftyRuffs5','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',1,2,1,0),(2,'annoyedGelding4','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',1,2,1,0),(3,'crushedBuck8','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',1,2,1,0),(4,'anxiousCur0','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',1,2,1,0),(5,'dreadfulThrush2','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',0,1,1,0),(6,'awedBuzzard4','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',0,1,1,0),(7,'excludedBuzzard7','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',0,1,1,0),(8,'drearyChough8','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',1,2,1,0),(9,'solidJaguar0','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',1,2,1,0),(10,'humorousCur1','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',1,2,1,0),(11,'thrilledLollies2','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',1,2,1,0),(13,'fondTomatoe7','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',1,1,0,0),(14,'gleefulUnicorn5','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',1,1,0,0),(15,'euphoricWasp5','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',1,2,1,0),(16,'pitifulPonie0','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',0,1,1,0),(17,'betrayedOtter5','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',1,1,0,0),(18,'joyfulLard0','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',0,0,0,0),(19,'puzzledOcelot8','$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS','2020-05-06 21:14:43',1,1,0,0),(20,'dmartinez341','$2y$10$XERXApAOpQacNfx7cmTTMu4B8f8N1OoM7mopIW.1GAc9VpA5M0kz6','2020-05-06 22:19:47',0,0,0,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_has_team`
--

DROP TABLE IF EXISTS `user_has_team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_has_team` (
  `iduser` int(11) NOT NULL,
  `idteam` int(11) NOT NULL,
  PRIMARY KEY (`iduser`,`idteam`),
  KEY `fk_user_has_team_team1_idx` (`idteam`),
  KEY `fk_user_has_team_user1_idx` (`iduser`),
  CONSTRAINT `fk_user_has_team_team1` FOREIGN KEY (`idteam`) REFERENCES `team` (`idteam`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_has_team_user1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_has_team`
--

LOCK TABLES `user_has_team` WRITE;
/*!40000 ALTER TABLE `user_has_team` DISABLE KEYS */;
INSERT INTO `user_has_team` VALUES (1,1),(2,1),(3,1),(4,1),(5,2),(6,2),(7,3),(8,4),(9,4),(10,4),(11,4),(13,5),(14,5),(15,6),(16,7),(17,8),(18,9),(19,10),(20,12);
/*!40000 ALTER TABLE `user_has_team` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_image`
--

DROP TABLE IF EXISTS `user_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_image` (
  `idimage` int(11) NOT NULL AUTO_INCREMENT,
  `is_set` tinyint(1) NOT NULL DEFAULT '0',
  `image_dir` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.png',
  `bio` text COLLATE utf8_unicode_ci NOT NULL,
  `iduser` int(11) NOT NULL,
  PRIMARY KEY (`idimage`,`iduser`),
  KEY `fk_user_image_user1_idx` (`iduser`),
  CONSTRAINT `fk_user_image_user1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_image`
--

LOCK TABLES `user_image` WRITE;
/*!40000 ALTER TABLE `user_image` DISABLE KEYS */;
INSERT INTO `user_image` VALUES (1,0,'default.png','',1),(2,0,'default.png','',2),(3,0,'default.png','',3),(4,0,'default.png','',4),(5,0,'default.png','',5),(6,0,'default.png','',6),(7,0,'default.png','',7),(8,0,'default.png','',8),(9,0,'default.png','',9),(10,0,'default.png','',10),(11,0,'default.png','',11),(13,0,'default.png','',13),(14,0,'default.png','',14),(15,0,'default.png','',15),(16,0,'default.png','',16),(17,0,'default.png','',17),(18,0,'default.png','',18),(19,0,'default.png','',19),(20,1,'1589079676-nade.png','Hello',20);
/*!40000 ALTER TABLE `user_image` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-10 20:04:45
