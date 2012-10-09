-- MySQL dump 10.13  Distrib 5.5.27, for Win32 (x86)
--
-- Host: localhost    Database: droidbox
-- ------------------------------------------------------
-- Server version	5.5.27

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
-- Current Database: `droidbox`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `droidbox` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `droidbox`;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
  `table_num` int(11) NOT NULL,
  `id_num` int(11) NOT NULL,
  `num_requests` int(11) NOT NULL,
  PRIMARY KEY (`table_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playlist`
--

DROP TABLE IF EXISTS `playlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlist` (
  `playlistID` int(11) NOT NULL,
  `songID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlist`
--

LOCK TABLES `playlist` WRITE;
/*!40000 ALTER TABLE `playlist` DISABLE KEYS */;
INSERT INTO `playlist` VALUES (1,1),(1,2),(1,3),(1,10),(1,11),(1,12),(1,13),(1,22),(1,23),(1,24),(2,14),(2,15);
/*!40000 ALTER TABLE `playlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playlist_name`
--

DROP TABLE IF EXISTS `playlist_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlist_name` (
  `playlistID` int(11) NOT NULL AUTO_INCREMENT,
  `playlistName` varchar(255) NOT NULL,
  PRIMARY KEY (`playlistID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlist_name`
--

LOCK TABLES `playlist_name` WRITE;
/*!40000 ALTER TABLE `playlist_name` DISABLE KEYS */;
INSERT INTO `playlist_name` VALUES (1,'House Hits'),(2,'Labor Day Weekend');
/*!40000 ALTER TABLE `playlist_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queue`
--

DROP TABLE IF EXISTS `queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `queue` (
  `songID` int(11) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '0',
  `request_type` tinyint(1) NOT NULL DEFAULT '0',
  `time_requested` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`songID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `queue`
--

LOCK TABLES `queue` WRITE;
/*!40000 ALTER TABLE `queue` DISABLE KEYS */;
INSERT INTO `queue` VALUES (1,0,0,'0000-00-00 00:00:00'),(2,0,0,'0000-00-00 00:00:00'),(3,0,0,'0000-00-00 00:00:00'),(10,0,0,'0000-00-00 00:00:00'),(11,0,0,'0000-00-00 00:00:00'),(12,0,0,'0000-00-00 00:00:00'),(13,0,0,'0000-00-00 00:00:00'),(14,0,1,'0000-00-00 00:00:00'),(15,0,1,'0000-00-00 00:00:00'),(22,0,0,'0000-00-00 00:00:00'),(23,0,0,'0000-00-00 00:00:00'),(24,0,0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `song`
--

DROP TABLE IF EXISTS `song`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `song` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `album` varchar(255) NOT NULL,
  `genre` enum('Blues','Classical','Country','Electronic/Indie','Folk','Jazz','Reggae','Rock','Unknown') NOT NULL DEFAULT 'Unknown',
  `length` int(11) NOT NULL,
  `num_played` int(11) NOT NULL DEFAULT '0',
  `file_path` text NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `song`
--

LOCK TABLES `song` WRITE;
/*!40000 ALTER TABLE `song` DISABLE KEYS */;
INSERT INTO `song` VALUES (1,'Are You Feelin It (Feat. Elephant Man)','Teddybears','Soft Machine\r','Unknown',200,0,'',1),(3,'Dead End Friends','Them Crooked Vultures','Them Crooked Vultures\r','Unknown',200,0,'',1),(4,'Reptiles','Them Crooked Vultures','Them Crooked Vultures\r','Unknown',200,0,'',1),(5,'Caligulove','Them Crooked Vultures','Them Crooked Vultures\r','Unknown',200,0,'',1),(6,'White Sky','Vampire Weekend','Contra (Bonus Track Version)\r','Unknown',200,0,'',1),(7,'Taxi Cab','Vampire Weekend','Contra (Bonus Track Version)\r','Unknown',200,0,'',1),(8,'Giant (Bonus Track)','Vampire Weekend','Contra (Bonus Track Version)\r','Unknown',200,0,'',1),(10,'M79','Vampire Weekend','Vampire Weekend\r','Unknown',200,0,'',1),(11,'Get Free','The Vines','Highly Evolved\r','Unknown',200,0,'',1),(12,'Atmos','The Vines','Vision Valley\r','Unknown',200,0,'',1),(13,'TV Pro','The Vines','Winning Days\r','Unknown',200,0,'',1),(14,'Passive Manipulation','The White Stripes','Get Behind Me Satan\r','Unknown',200,0,'',1),(15,'Hotel Yorba','The White Stripes','White Blood Cells\r','Unknown',200,0,'',1),(16,'The Hellcat Spangled Shalalala','Arctic Monkeys','Suck It And See\r','Unknown',200,0,'',1),(17,'Dont Sit Down Cause Ive Moved Your Chair','Arctic Monkeys','Suck It And See\r','Unknown',200,0,'',1),(18,'The Delivery (The Bumfest Demo)','Babyshambles','The Delivery (NME Vinyl)\r','Unknown',200,0,'',1),(19,'Prangin Out - Pete and Mikes version','Babyshambles','The Hardest Way To Make An Easy Living\r','Unknown',200,0,'',1),(20,'The Man Who Came to Stay','Babyshambles','Killamangiro EP\r','Unknown',200,0,'',1),(21,'Unstookie Titled','Babyshambles','Oh What A Lovely Tour\r','Unknown',200,0,'',1),(22,'32nd Of December (Acoustic)','Babyshambles','Unknown','Unknown',200,0,'',1),(23,'Entropy','Bad Religion','Against the Grain\r','Unknown',200,0,'',1),(24,'Misery and Famine','Bad Religion','Against the Grain\r','Unknown',200,0,'',1),(25,'The Answer','Bad Religion','All Ages\r','Unknown',200,0,'',1);
/*!40000 ALTER TABLE `song` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Current Database: `droidbox`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `droidbox` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `droidbox`;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
  `table_num` int(11) NOT NULL,
  `id_num` int(11) NOT NULL,
  `num_requests` int(11) NOT NULL,
  PRIMARY KEY (`table_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playlist`
--

DROP TABLE IF EXISTS `playlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlist` (
  `playlistID` int(11) NOT NULL,
  `songID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlist`
--

LOCK TABLES `playlist` WRITE;
/*!40000 ALTER TABLE `playlist` DISABLE KEYS */;
INSERT INTO `playlist` VALUES (1,1),(1,2),(1,3),(1,10),(1,11),(1,12),(1,13),(1,22),(1,23),(1,24),(2,14),(2,15);
/*!40000 ALTER TABLE `playlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playlist_name`
--

DROP TABLE IF EXISTS `playlist_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlist_name` (
  `playlistID` int(11) NOT NULL AUTO_INCREMENT,
  `playlistName` varchar(255) NOT NULL,
  PRIMARY KEY (`playlistID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlist_name`
--

LOCK TABLES `playlist_name` WRITE;
/*!40000 ALTER TABLE `playlist_name` DISABLE KEYS */;
INSERT INTO `playlist_name` VALUES (1,'House Hits'),(2,'Labor Day Weekend');
/*!40000 ALTER TABLE `playlist_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queue`
--

DROP TABLE IF EXISTS `queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `queue` (
  `songID` int(11) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '0',
  `request_type` tinyint(1) NOT NULL DEFAULT '0',
  `time_requested` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`songID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `queue`
--

LOCK TABLES `queue` WRITE;
/*!40000 ALTER TABLE `queue` DISABLE KEYS */;
INSERT INTO `queue` VALUES (1,0,0,'0000-00-00 00:00:00'),(2,0,0,'0000-00-00 00:00:00'),(3,0,0,'0000-00-00 00:00:00'),(10,0,0,'0000-00-00 00:00:00'),(11,0,0,'0000-00-00 00:00:00'),(12,0,0,'0000-00-00 00:00:00'),(13,0,0,'0000-00-00 00:00:00'),(14,0,1,'0000-00-00 00:00:00'),(15,0,1,'0000-00-00 00:00:00'),(22,0,0,'0000-00-00 00:00:00'),(23,0,0,'0000-00-00 00:00:00'),(24,0,0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `song`
--

DROP TABLE IF EXISTS `song`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `song` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `album` varchar(255) NOT NULL,
  `genre` enum('Blues','Classical','Country','Electronic/Indie','Folk','Jazz','Reggae','Rock','Unknown') NOT NULL DEFAULT 'Unknown',
  `length` int(11) NOT NULL,
  `num_played` int(11) NOT NULL DEFAULT '0',
  `file_path` text NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `song`
--

LOCK TABLES `song` WRITE;
/*!40000 ALTER TABLE `song` DISABLE KEYS */;
INSERT INTO `song` VALUES (1,'Are You Feelin It (Feat. Elephant Man)','Teddybears','Soft Machine\r','Unknown',200,0,'',1),(3,'Dead End Friends','Them Crooked Vultures','Them Crooked Vultures\r','Unknown',200,0,'',1),(4,'Reptiles','Them Crooked Vultures','Them Crooked Vultures\r','Unknown',200,0,'',1),(5,'Caligulove','Them Crooked Vultures','Them Crooked Vultures\r','Unknown',200,0,'',1),(6,'White Sky','Vampire Weekend','Contra (Bonus Track Version)\r','Unknown',200,0,'',1),(7,'Taxi Cab','Vampire Weekend','Contra (Bonus Track Version)\r','Unknown',200,0,'',1),(8,'Giant (Bonus Track)','Vampire Weekend','Contra (Bonus Track Version)\r','Unknown',200,0,'',1),(10,'M79','Vampire Weekend','Vampire Weekend\r','Unknown',200,0,'',1),(11,'Get Free','The Vines','Highly Evolved\r','Unknown',200,0,'',1),(12,'Atmos','The Vines','Vision Valley\r','Unknown',200,0,'',1),(13,'TV Pro','The Vines','Winning Days\r','Unknown',200,0,'',1),(14,'Passive Manipulation','The White Stripes','Get Behind Me Satan\r','Unknown',200,0,'',1),(15,'Hotel Yorba','The White Stripes','White Blood Cells\r','Unknown',200,0,'',1),(16,'The Hellcat Spangled Shalalala','Arctic Monkeys','Suck It And See\r','Unknown',200,0,'',1),(17,'Dont Sit Down Cause Ive Moved Your Chair','Arctic Monkeys','Suck It And See\r','Unknown',200,0,'',1),(18,'The Delivery (The Bumfest Demo)','Babyshambles','The Delivery (NME Vinyl)\r','Unknown',200,0,'',1),(19,'Prangin Out - Pete and Mikes version','Babyshambles','The Hardest Way To Make An Easy Living\r','Unknown',200,0,'',1),(20,'The Man Who Came to Stay','Babyshambles','Killamangiro EP\r','Unknown',200,0,'',1),(21,'Unstookie Titled','Babyshambles','Oh What A Lovely Tour\r','Unknown',200,0,'',1),(22,'32nd Of December (Acoustic)','Babyshambles','Unknown','Unknown',200,0,'',1),(23,'Entropy','Bad Religion','Against the Grain\r','Unknown',200,0,'',1),(24,'Misery and Famine','Bad Religion','Against the Grain\r','Unknown',200,0,'',1),(25,'The Answer','Bad Religion','All Ages\r','Unknown',200,0,'',1);
/*!40000 ALTER TABLE `song` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-10-02 11:46:59
