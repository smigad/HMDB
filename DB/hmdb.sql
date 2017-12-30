-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: hmdb
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

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
-- Table structure for table `award`
--

DROP TABLE IF EXISTS `award`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `award` (
  `award_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `award_name` varchar(50) NOT NULL,
  `agency` varchar(50) NOT NULL,
  PRIMARY KEY (`award_id`),
  UNIQUE KEY `award_name` (`award_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `award`
--

LOCK TABLES `award` WRITE;
/*!40000 ALTER TABLE `award` DISABLE KEYS */;
INSERT INTO `award` VALUES (1,'Guma','some org'),(2,'Elias movie award','elias corp'),(3,'dagim movie award','dagim corp'),(4,'kidus movie award','kidus corp'),(5,'hana movie award','hana corp'),(6,'nati movie award','nati corp');
/*!40000 ALTER TABLE `award` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `award_given`
--

DROP TABLE IF EXISTS `award_given`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `award_given` (
  `award_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL DEFAULT '0',
  `year_given` date NOT NULL,
  `film_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`award_id`,`person_id`,`film_id`),
  KEY `award_given_ibfk_2` (`person_id`),
  KEY `award_given_ibfk_3` (`film_id`),
  CONSTRAINT `award_given_ibfk_1` FOREIGN KEY (`award_id`) REFERENCES `award` (`award_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `award_given_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `people` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `award_given_ibfk_3` FOREIGN KEY (`film_id`) REFERENCES `movie` (`film_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `award_given`
--

LOCK TABLES `award_given` WRITE;
/*!40000 ALTER TABLE `award_given` DISABLE KEYS */;
INSERT INTO `award_given` VALUES (1,1,'2015-09-25',1),(1,18,'0000-00-00',8),(2,1,'2015-09-10',2),(2,5,'0000-00-00',5),(3,20,'0000-00-00',6),(4,5,'0000-00-00',8),(5,5,'0000-00-00',5),(6,8,'0000-00-00',8);
/*!40000 ALTER TABLE `award_given` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `date_trigger` BEFORE INSERT ON `award_given`
 FOR EACH ROW BEGIN	
IF (NEW.year_given < (SELECT released_date FROM movie WHERE film_id = NEW.film_id)) THEN
set NEW.year_given = (SELECT released_date FROM movie WHERE film_id = NEW.film_id);
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `movie`
--

DROP TABLE IF EXISTS `movie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movie` (
  `film_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `released_date` date DEFAULT NULL,
  `plot` text,
  `film_rating` enum('G','PG','PG-13','R','RC-17') DEFAULT 'G',
  `users_rating` decimal(2,1) unsigned DEFAULT NULL,
  `studio` varchar(200) DEFAULT NULL,
  `genre` varchar(100) DEFAULT 'N/A',
  `trailer` text,
  `film_poster` text,
  `running_time` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`film_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movie`
--

LOCK TABLES `movie` WRITE;
/*!40000 ALTER TABLE `movie` DISABLE KEYS */;
INSERT INTO `movie` VALUES (1,'Difret','2015-09-25','Three hours outside of Addis Ababa, a bright 14-year-old girl is on her way home from school when men on horses swoop in and kidnap her. The brave Hirut grabs a rifle and tries to escape, but ends up shooting her would-be husband. In her village, the practice of abduction into marriage is common and one of Ethiopia\'s oldest traditions. Meaza Ashenafi, an empowered and tenacious young lawyer, arrives from the city to represent Hirut and argue that she acted in self-defense. Meaza boldly embarks on a collision course between enforcing civil authority and abiding by customary law, risking the continuing work of her women\'s legal-aid practice to save Hirut\'s life.','R',9.6,'Haile Addis Pictures, Truth Aid','Biography, Crime, Drama, History',NULL,'movie_posters/Difret-images-17fac3fc-f87d-466e-b1e2-e2f868959bc.jpg',99),(2,'Lamb','2015-09-10','When an Ethiopian boy moves in with distant relatives he takes his pet sheep with him but the upcoming holidays spell danger for his beloved friend.','G',4.2,'Slum Kid Films, Gloria Films, Heimat film','drama',NULL,'movie_posters/bc53ba6b808c112c0f72d724ce3c16fe.jpg',100),(5,'Atletu','2010-02-11','Running the streets of Rome in 1960, an unknown, barefooted Ethiopian man stunned the world by winning Olympic gold in the marathon. Overnight, Abebe Bikila became a sports legend. A hero in his own country and to the continent, Bikila was the first African to win a gold medal, and four years later in Tokyo would become the first person in history to win consecutive Olympic gold medals in the marathon. This soldier and quiet son of a shepherd would be acknowledged by many as the greatest long distance runner the world had ever known. One evening while returning to his home in Addis Ababa from training in the Ethiopian countryside, Bikila was involved in a tragic car accident which left him paralyzed from the waist down. Unable to walk and faced with the greatest challenge of his life, he struggled to maintain his will to live and in the process discovered a deeper meaning of competition, taking up archery for the Paralympics and competing as a handicapped dog sledder in Norway. Though his running career had come to a tragic end, the race of his life had a new beginning. For the first time, the true story of Bikila\'s epic quest for life and sport comes to the big screen. Not since Raging Bull has the life of an athlete been rendered with such emotional power and cinematic grace.','PG-13',9.1,'AV Patchbay, El Atleta, Instinctive Film','Biography, Drama',NULL,'movie_posters/MV5BMjIyMjQ1NDM2NV5BMl5BanBnXkFtZTcwOTQyMTc5Nw@@._V1_SY317_CR5,0,214,317_AL_.jpg',92),(6,'Teza','2009-09-18','The Ethiopian intellectual Anberber returns to his native country during the repressive totalitarian regime of Haile Mariam Mengistu and the recognition of his own displacement and powerlessness at the dissolution of his people\'s humanity and social values. After several years spent studying medicine in Germany, he finds the country of his youth replaced by turmoil. His dream of using his craft to improve the health of Ethiopians is squashed by a military junta that uses scientists for its own political ends. Seeking the comfort of his countryside home, Anberber finds no refuge from violence. The solace that the memories of his youth provide is quickly replaced by the competing forces of military and rebelling factions. Anberber needs to decide whether he wants to bear the strain or piece together a life from the fragments that lie around him.','PG',9.8,'Negod-Gwad Productions, Pandora Film production','Drama',NULL,'movie_posters/teza-film-poster.jpg',115),(7,'Crumbs','2015-06-14','Crumbs is a Spanish-Ethiopian Science fictional love story. Tired of picking up the crumbs of gone-by civilizations, Candy dreams his life away when not living in a state of perpetual fear. Beautiful visuals and landscapes of Ethiopia create an mysterious world. The director\'s short with the same actor was in competition in Locarno, CRUMBS had a WP in Rotterdam Bright Futures.','RC-17',5.0,'Bira Biro Films,Lanzadera Films','Adventure, Fantasy, Mystery ',NULL,'movie_posters/index.jpeg',68),(8,'Beti and Amare','2016-04-14','\"Beti and Amare\" is a historical science-fiction film set in 1936 Ethiopia. Beti, a young Ethiopian girl has escaped Mussolini\'s troops and found refuge in the peaceful south of Ethiopia. As the Italians march ever closer Beti has to battle hunger, thirst, and the unwelcome sexual advances of the local militia. When the situation threatens to escalate towards the unthinkable, a spaceship cracks through the clouds... its cargo... love. This micro-budget gem is filled with many powerful moments made up of stunning, intense and thought provoking imagery, a unique but professional score and sound-design, masterful acting, and a hugely impressive directorial debut by Andy Siege.','G',9.1,'Fun De Mental Studios','Fantasy, Romance, Sci-Fi',NULL,'movie_posters/MV5BMjAyNDc3MDI4MF5BMl5BanBnXkFtZTgwMDU5MDkzMzE@._V1_SX214_AL_.jpg',94),(11,'Zewd ena Gofer','2003-07-09','once upon a time there was a zewed who was lonely and one day when he was walking down the streets of addis all alone he discovered a gofer sitting on the side of the road crying... the zewd got up to her and asked what was wrong and she said that she\'s very lonely so the zewd said \"ME TOO\" in excitment then they became friends and lived happily ever after. The End! ','G',0.0,'20th Century kebero','Asekign Yefikir Film','www.youtube.com','movie_posters/Zewd ena Gofer_20th Century kebero_1212_1.jpg',1212);
/*!40000 ALTER TABLE `movie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `people` (
  `person_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `Date_of_birth` date DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `photo` text,
  `bio` text,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (1,'Zeresenay','Mehari','M','1969-12-30','Ethiopia','people_photo/zere.jpg',NULL),(2,'Yared ','Zeleke','M','1989-06-29','Ethiopia','people_photo/yared.jpg',NULL),(3,'Ama ','Ampadu','M','1979-10-16',NULL,NULL,NULL),(4,'Bettina ','Brokemper','F','1981-07-02',NULL,NULL,NULL),(5,'Christophe ','Chassol','M','1989-05-21',NULL,'people_photo/christo.jpg',NULL),(6,'Eden ','Lagaly-Faynot','F','1970-01-01','Ethiopia',NULL,NULL),(7,'Davey ','Frankel','M','1980-12-31',NULL,NULL,NULL),(8,'Rasselas','Lakew','M','1966-03-04','Ethiopia',NULL,NULL),(9,'Meseret ','Argaw','F','1965-12-12','Ethiopia','people_photo/Meseret-Mebrate-3.jpg',NULL),(18,'Mahder','Assefa','F','1985-01-05','Ethiopia','people_photo/mahder.jpg','She was born in Addis Ababa, Ethiopia around shero meda from her mother Rebeka Feyessa and her father Assefa Demelash, and grew up there till the age of 5. In her early age, Assefa moved to a different location which is also called Kera also located in Addis Ababa.'),(19,'Girum','Ermias','M','1965-05-15','Ethiopia','people_photo/girum.jpg','Girum is one of the most talented and top paid Ethiopian actor. He was born and raised in Addis Ababa, in Teklaimanot neighborhood. As a teen, he was more into sports than acting or academic life.'),(20,'Roman','Befkadu','F','1965-05-25','Ethiopia','people_photo/Roman.jpg','Roman Fekade is an Ethiopian film producer, actress and film script writer who owns \"Kapital\" Film Production Company. She attended her elementary and secondary education at Cathedral Girls School and Akaki Adventist Boarding School respectively. '),(21,'Meseret ','Mebrate','F','1977-12-01','Ethiopia',NULL,NULL),(22,'Alemseged ','Tesfaye','M','1978-02-05','Ethiopia','people_photo/alemseged.jpg','Alemseged is one of the most talented movie star in Amharic film industry.');
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quote`
--

DROP TABLE IF EXISTS `quote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quote` (
  `quote_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `film_id` int(10) unsigned NOT NULL,
  `person_id` varchar(30) NOT NULL,
  `quote` text,
  PRIMARY KEY (`quote_id`),
  KEY `quote_ibfk_1` (`film_id`),
  CONSTRAINT `quote_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `movie` (`film_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quote`
--

LOCK TABLES `quote` WRITE;
/*!40000 ALTER TABLE `quote` DISABLE KEYS */;
INSERT INTO `quote` VALUES (1,1,'1','Afkereshalehu!'),(2,1,'2','Kifatesh Gedeb yelewem! '),(3,2,'2','ene malet mot negn'),(4,8,'20','ahun min litareg new?'),(5,5,'8','WUTA!'),(6,8,'22','min? Keldehen new?');
/*!40000 ALTER TABLE `quote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `role_description` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'director','responsible for overseeing the creative aspects of a film'),(2,'sound editor',' responsible for assembling and editing all the sound effects in the soundtrack.'),(3,'producer','creates the conditions for film-making.'),(4,'executive producer','play a financial or creative role in ensuring that the project goes into production.'),(5,'director of photography','the chief of the camera and lighting crew of the film.'),(6,'film editor','the person who assembles the various shots into a coherent film.'),(7,'writer','story writer of the film'),(8,'actor','the character player. ');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `security_question` varchar(50) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (8,'dagiopia','$2y$10$o50tg/.7j1/GHKo8Vg6R3erciudBBzIEppY1Wb./nQemqaEyvHZ.O','M','1970-01-01','hello','$2y$10$0KA/jSMr48QcZPxfYkAeBuyqlJjgMKjrqArAonDvxPcMLghydraj2',0),(9,'elisho','$2y$10$XZpcDglZ6VGdFdqVkhXL3eigzX8utt5V3VRamFDT6l.8q8y5nuNbO','M','1970-01-01','what is the name of your pet rat?','$2y$10$vm1uSwpb/7YjlYXt1v5.keXK3EDbAFUJwZCycprpDtj3z/iZVcDaa',0),(10,'kido','$2y$10$om2mWM2oh3xKyZV1rA6PWugboieGW3HRlRdBUjcUTUxauAbUwEwoC','M','1970-01-01','who do you love?','$2y$10$z0pOX4SyKDMmHkYf0smshu0stRCU/0a8feSA7ibDSPs/UwV9qXFGC',0),(11,'nhatty_man','$2y$10$zkLZ3Gh47RpH9WpY4I8o.eBiAmi.rvxPFtq.g1LuJ52C/AAe2I2EG','M','1970-01-01','jeles endet nesh?','$2y$10$hDFw/xAv7HcdL1lojHQqDOtpSVgMK8t6kYeG/YsdiYJRm1oBIWEYa',0),(12,'hanicho','$2y$10$W.4BB2hAaOwBq/0hmhsV9OjwM/PPhXh0dSMPa3HMZ2GikHVsdIVbu','F','1970-01-01','haniye endet nesh?','$2y$10$GKG1RSwtLbK2xsuzYDorhutqocS4SjPChSkMkMfxuCx29Qfi/ftoq',0),(13,'admin','$2y$10$XvxXBUJX6Aq41KE83KD7xOFgV8k6MFry2zJw1gbJmB9k7iyKxWQxC','M','1970-01-01','admin','$2y$10$gk49SIOfXcAePjTpz07kDeGS.HGNhjVez/t2PMVpx3y9DSB5FzXgG',1),(14,'user','$2y$10$j8WRGuIj8Z56ckx9Fmaxpe0/tmVjJpd1FQwf80sV2ejQ1Xc.dhOeS','F','1970-01-01','user','$2y$10$CBfhoNkivsgxijGWEVRRi.3FVv/Q0DWuI8sCpdkmsoav.6l/toMnm',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER user_level_check_insert BEFORE INSERT ON users
FOR EACH ROW
BEGIN	
IF NOT (NEW.level=0 OR NEW.level=1)  THEN

SIGNAL SQLSTATE '12345'
SET MESSAGE_TEXT  = 'INVALID LEVEL FOR USER. SET EITHER 1 OR 0';
END IF;
IF (NEW.password="") THEN 
SIGNAL SQLSTATE '12345'
SET MESSAGE_TEXT = 'CAN NOT LEAVE PASSWORD EMPTY';
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER user_level_check_update BEFORE UPDATE ON users
FOR EACH ROW
BEGIN
IF NOT (NEW.level=0 OR NEW.level=1)  THEN

SIGNAL SQLSTATE '12345'
SET MESSAGE_TEXT  = 'INVALID LEVEL FOR USER. SET EITHER 1 OR 0';
END IF;
IF (NEW.password="") THEN 
SIGNAL SQLSTATE '12345'
SET MESSAGE_TEXT = 'CAN NOT LEAVE PASSWORD EMPTY';
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `users_data`
--

DROP TABLE IF EXISTS `users_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_data` (
  `user_data_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `film_id` int(10) unsigned NOT NULL,
  `user_rating` decimal(2,1) unsigned DEFAULT NULL,
  `review` text,
  PRIMARY KEY (`user_data_id`),
  KEY `user_id` (`user_id`),
  KEY `film_id` (`film_id`),
  CONSTRAINT `users_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_data_ibfk_2` FOREIGN KEY (`film_id`) REFERENCES `movie` (`film_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_data`
--

LOCK TABLES `users_data` WRITE;
/*!40000 ALTER TABLE `users_data` DISABLE KEYS */;
INSERT INTO `users_data` VALUES (43,8,1,9.9,'this is a very nice movie!!! wedijewalew!!!!'),(44,8,2,0.7,'yihe debari film new... abo manim seleEthiopia ayawkim'),(45,8,5,9.9,'yihe jelesachin eko new!!! sanjo new yetemarew!! go sanjo!!!'),(46,8,6,9.9,'haile gerima\'s best work!! just love it'),(47,8,8,8.4,'ere mood alew!!! amharic sci-fi!!! surprise!'),(48,9,1,9.9,'i like it too dagim!! u have a very good taste in movies'),(49,9,2,8.4,'min honk dagim?? arif film new eshi!!!!'),(50,9,5,8.1,'awo arif film new demo... keSanjo minamin besteker'),(51,8,2,NULL,'this is a terrible movie!!! no one in the entire movie crew knows s*** about Ethiopia'),(52,11,1,8.5,'ere ela min tidenanekalachu ezi.. gin arif film new'),(53,11,8,9.7,'now this is a movie!!!!'),(54,10,2,7.8,'hahaha dagim calm down enji!!! I like it... it\'s a beautiful movie'),(55,10,5,9.2,'abo dagi!!!! yimechish!! Saint Joe pride!'),(56,10,6,9.6,'great move from one of the best directors out there'),(57,12,1,9.9,'ere enem wedijewalew yihen film!!! Meron Getnet is just awesome'),(58,12,2,0.0,'I\'m with dagi! this movie just sucks!!! ');
/*!40000 ALTER TABLE `users_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `BRating_insert` AFTER INSERT ON `users_data`
FOR EACH ROW BEGIN	
IF NOT (NEW.user_rating IS NULL)  THEN
update movie set users_rating = (SELECT AVG(user_rating) FROM users_data WHERE film_id = NEW.film_id) where film_id = NEW.film_id;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `BRating_update` AFTER UPDATE ON `users_data`
FOR EACH ROW BEGIN	
IF NOT (NEW.user_rating IS NULL)  THEN
update movie set users_rating = (SELECT AVG(user_rating) FROM users_data WHERE film_id = NEW.film_id) where film_id = NEW.film_id;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `works_on`
--

DROP TABLE IF EXISTS `works_on`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `works_on` (
  `person_id` int(10) unsigned NOT NULL,
  `film_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `name_in_role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`person_id`,`film_id`,`role_id`),
  KEY `film_id` (`film_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `works_on_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `people` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `works_on_ibfk_2` FOREIGN KEY (`film_id`) REFERENCES `movie` (`film_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `works_on_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `works_on`
--

LOCK TABLES `works_on` WRITE;
/*!40000 ALTER TABLE `works_on` DISABLE KEYS */;
INSERT INTO `works_on` VALUES (1,1,1,NULL),(1,6,5,NULL),(1,7,2,NULL),(2,1,2,NULL),(2,6,1,NULL),(2,8,1,NULL),(3,1,3,NULL),(3,2,1,NULL),(3,2,3,NULL),(3,6,3,NULL),(3,7,1,NULL),(4,1,4,NULL),(4,5,6,NULL),(4,6,6,NULL),(4,8,2,NULL),(5,5,8,NULL),(5,7,3,NULL),(6,1,5,NULL),(6,5,7,NULL),(6,6,2,NULL),(6,8,3,NULL),(7,7,4,NULL),(8,5,3,NULL),(8,6,7,NULL),(8,8,4,NULL),(8,8,5,NULL),(9,2,4,NULL),(9,5,1,NULL),(9,7,5,NULL),(18,1,8,NULL),(18,2,5,NULL),(18,5,2,NULL),(18,7,8,NULL),(18,8,6,NULL),(19,1,7,NULL),(19,2,1,NULL),(19,6,4,NULL),(19,7,6,NULL),(20,2,4,NULL),(20,2,8,NULL),(20,8,7,NULL),(21,2,6,NULL),(21,7,7,NULL),(22,2,1,NULL),(22,6,8,NULL),(22,8,8,NULL);
/*!40000 ALTER TABLE `works_on` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-31 23:15:48
