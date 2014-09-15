/*
SQLyog Ultimate v9.02 
MySQL - 5.6.12-log : Database - grades
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`grades` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*Table structure for table `countries` */

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=latin1;

/*Data for the table `countries` */

insert  into `countries`(`id`,`country_name`) values (1,'Afghanistan'),(2,'Albania'),(3,'Algeria'),(4,'American Samoa'),(5,'Andorra'),(6,'Angola'),(7,'Anguilla'),(8,'Antarctica'),(9,'Antigua and Barbuda'),(10,'Argentina'),(11,'Armenia'),(12,'Armenia'),(13,'Aruba'),(14,'Australia'),(15,'Austria'),(16,'Azerbaijan'),(17,'Azerbaijan'),(18,'Bahamas'),(19,'Bahrain'),(20,'Bangladesh'),(21,'Barbados'),(22,'Belarus'),(23,'Belgium'),(24,'Belize'),(25,'Benin'),(26,'Bermuda'),(27,'Bhutan'),(28,'Bolivia'),(29,'Bosnia and Herzegovina'),(30,'Botswana'),(31,'Bouvet Island'),(32,'Brazil'),(33,'British Indian Ocean Territory'),(34,'Brunei Darussalam'),(35,'Bulgaria'),(36,'Burkina Faso'),(37,'Burundi'),(38,'Cambodia'),(39,'Cameroon'),(40,'Canada'),(41,'Cape Verde'),(42,'Cayman Islands'),(43,'Central African Republic'),(44,'Chad'),(45,'Chile'),(46,'China'),(47,'Christmas Island'),(48,'Cocos (Keeling) Islands'),(49,'Colombia'),(50,'Comoros'),(51,'Congo'),(52,'Congo, The Democratic Republic of The'),(53,'Cook Islands'),(54,'Costa Rica'),(55,'Cote D\'ivoire'),(56,'Croatia'),(57,'Cuba'),(58,'Cyprus'),(60,'Czech Republic'),(61,'Denmark'),(62,'Djibouti'),(63,'Dominica'),(64,'Dominican Republic'),(65,'Easter Island'),(66,'Ecuador'),(67,'Egypt'),(68,'El Salvador'),(69,'Equatorial Guinea'),(70,'Eritrea'),(71,'Estonia'),(72,'Ethiopia'),(73,'Falkland Islands (Malvinas)'),(74,'Faroe Islands'),(75,'Fiji'),(76,'Finland'),(77,'France'),(78,'French Guiana'),(79,'French Polynesia'),(80,'French Southern Territories'),(81,'Gabon'),(82,'Gambia'),(83,'Georgia'),(85,'Germany'),(86,'Ghana'),(87,'Gibraltar'),(88,'Greece'),(89,'Greenland'),(91,'Grenada'),(92,'Guadeloupe'),(93,'Guam'),(94,'Guatemala'),(95,'Guinea'),(96,'Guinea-bissau'),(97,'Guyana'),(98,'Haiti'),(99,'Heard Island and Mcdonald Islands'),(100,'Honduras'),(101,'Hong Kong'),(102,'Hungary'),(103,'Iceland'),(104,'India'),(105,'Indonesia'),(106,'Indonesia'),(107,'Iran'),(108,'Iraq'),(109,'Ireland'),(110,'Israel'),(111,'Italy'),(112,'Jamaica'),(113,'Japan'),(114,'Jordan'),(115,'Kazakhstan'),(116,'Kazakhstan'),(117,'Kenya'),(118,'Kiribati'),(119,'Korea, North'),(120,'Korea, South'),(121,'Kosovo'),(122,'Kuwait'),(123,'Kyrgyzstan'),(124,'Laos'),(125,'Latvia'),(126,'Lebanon'),(127,'Lesotho'),(128,'Liberia'),(129,'Libyan Arab Jamahiriya'),(130,'Liechtenstein'),(131,'Lithuania'),(132,'Luxembourg'),(133,'Macau'),(134,'Macedonia'),(135,'Madagascar'),(136,'Malawi'),(137,'Malaysia'),(138,'Maldives'),(139,'Mali'),(140,'Malta'),(141,'Marshall Islands'),(142,'Martinique'),(143,'Mauritania'),(144,'Mauritius'),(145,'Mayotte'),(146,'Mexico'),(147,'Micronesia, Federated States of'),(148,'Moldova, Republic of'),(149,'Monaco'),(150,'Mongolia'),(151,'Montenegro'),(152,'Montserrat'),(153,'Morocco'),(154,'Mozambique'),(155,'Myanmar'),(156,'Namibia'),(157,'Nauru'),(158,'Nepal'),(159,'Netherlands'),(160,'Netherlands Antilles'),(161,'New Caledonia'),(162,'New Zealand'),(163,'Nicaragua'),(164,'Niger'),(165,'Nigeria'),(166,'Niue'),(167,'Norfolk Island'),(168,'Northern Mariana Islands'),(169,'Norway'),(170,'Oman'),(171,'Pakistan'),(172,'Palau'),(173,'Palestinian Territory'),(174,'Panama'),(175,'Papua New Guinea'),(176,'Paraguay'),(177,'Peru'),(178,'Philippines'),(179,'Pitcairn'),(180,'Poland'),(181,'Portugal'),(182,'Puerto Rico'),(183,'Qatar'),(184,'Reunion'),(185,'Romania'),(186,'Russia'),(187,'Russia'),(188,'Rwanda'),(189,'Saint Helena'),(190,'Saint Kitts and Nevis'),(191,'Saint Lucia'),(192,'Saint Pierre and Miquelon'),(193,'Saint Vincent and The Grenadines'),(194,'Samoa'),(195,'San Marino'),(196,'Sao Tome and Principe'),(197,'Saudi Arabia'),(198,'Senegal'),(199,'Serbia and Montenegro'),(200,'Seychelles'),(201,'Sierra Leone'),(202,'Singapore'),(203,'Slovakia'),(204,'Slovenia'),(205,'Solomon Islands'),(206,'Somalia'),(207,'South Africa'),(208,'South Georgia and The South Sandwich Islands'),(209,'Spain'),(210,'Sri Lanka'),(211,'Sudan'),(212,'Suriname'),(213,'Svalbard and Jan Mayen'),(214,'Swaziland'),(215,'Sweden'),(216,'Switzerland'),(217,'Syria'),(218,'Taiwan'),(219,'Tajikistan'),(220,'Tanzania, United Republic of'),(221,'Thailand'),(222,'Timor-leste'),(223,'Togo'),(224,'Tokelau'),(225,'Tonga'),(226,'Trinidad and Tobago'),(227,'Tunisia'),(228,'Turkey'),(229,'Turkey'),(230,'Turkmenistan'),(231,'Turks and Caicos Islands'),(232,'Tuvalu'),(233,'Uganda'),(234,'Ukraine'),(235,'United Arab Emirates'),(236,'United Kingdom'),(237,'United States'),(238,'United States Minor Outlying Islands'),(239,'Uruguay'),(240,'Uzbekistan'),(241,'Vanuatu'),(242,'Vatican City'),(243,'Venezuela'),(244,'Vietnam'),(245,'Virgin Islands, British'),(246,'Virgin Islands, U.S.'),(247,'Wallis and Futuna'),(248,'Western Sahara'),(249,'Yemen'),(250,'Yemen'),(251,'Zambia'),(252,'Zimbabwe');

/*Table structure for table `country_system` */

DROP TABLE IF EXISTS `country_system`;

CREATE TABLE `country_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `grading_system_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_country_system` (`country_id`),
  KEY `FK_grading_system` (`grading_system_id`),
  CONSTRAINT `FK_country_system` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_grading_system` FOREIGN KEY (`grading_system_id`) REFERENCES `grading_systems` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `country_system` */

insert  into `country_system`(`id`,`country_id`,`grading_system_id`) values (1,165,3),(2,237,4);

/*Table structure for table `grades` */

DROP TABLE IF EXISTS `grades`;

CREATE TABLE `grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_score` int(11) DEFAULT NULL,
  `test_score` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `course` int(11) DEFAULT NULL,
  `studentnumber` varchar(45) DEFAULT NULL,
  `currentgpa` float DEFAULT NULL,
  `totalscore` int(11) DEFAULT NULL,
  `grade` varchar(3) DEFAULT NULL,
  `gradepoint` float DEFAULT NULL,
  `dropped` tinyint(4) DEFAULT '0',
  `creditload` int(11) DEFAULT NULL,
  `approved` tinyint(4) DEFAULT '0',
  `submittedby` int(11) DEFAULT NULL,
  `submitted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_submittedby` (`submittedby`),
  KEY `FK_grades` (`uid`),
  CONSTRAINT `FK_grades` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_submittedby` FOREIGN KEY (`submittedby`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `grades` */

insert  into `grades`(`id`,`exam_score`,`test_score`,`uid`,`course`,`studentnumber`,`currentgpa`,`totalscore`,`grade`,`gradepoint`,`dropped`,`creditload`,`approved`,`submittedby`,`submitted`) values (1,44,32,1,1,'10819960',NULL,76,'A',15,NULL,3,NULL,1,NULL),(2,58,32,1,2,'10819960',NULL,90,'A',15,NULL,3,NULL,1,NULL),(3,42,39,1,3,'10819960',NULL,81,'A',15,NULL,3,NULL,1,NULL),(4,45,40,1,4,'10819960',NULL,85,'A',15,NULL,3,NULL,1,NULL),(5,55,33,1,5,'10819960',NULL,88,'A',15,NULL,3,NULL,1,NULL),(6,55,34,1,6,'10819960',NULL,89,'A',15,NULL,3,NULL,1,NULL),(7,44,30,2,1,'10819961',NULL,74,'A',15,NULL,3,NULL,1,NULL),(8,44,30,2,2,'10819961',NULL,74,'A',15,NULL,3,NULL,1,NULL),(9,44,35,2,3,'10819961',NULL,79,'A',15,NULL,3,NULL,1,NULL),(10,40,23,2,4,'10819961',NULL,63,'B',12,NULL,3,NULL,1,NULL),(11,33,20,2,5,'10819961',NULL,53,'C',9,NULL,3,NULL,1,NULL),(12,55,21,2,6,'10819961',NULL,76,'A',15,NULL,3,NULL,1,NULL),(13,44,22,2,7,'10819961',NULL,66,'B',12,NULL,3,NULL,1,NULL),(14,20,25,2,8,'10819961',NULL,45,'D',6,NULL,3,NULL,1,NULL),(17,60,25,1,8,'10819960',NULL,85,'A',15,0,3,0,1,0);

/*Table structure for table `grading_scales` */

DROP TABLE IF EXISTS `grading_scales`;

CREATE TABLE `grading_scales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grading_system_id` int(11) DEFAULT NULL,
  `lower_bound` int(11) DEFAULT NULL,
  `upper_bound` int(11) DEFAULT NULL,
  `grade` varchar(3) DEFAULT NULL,
  `points` float DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_grading_scales` (`grading_system_id`),
  CONSTRAINT `FK_grading_scales` FOREIGN KEY (`grading_system_id`) REFERENCES `grading_systems` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

/*Data for the table `grading_scales` */

insert  into `grading_scales`(`id`,`grading_system_id`,`lower_bound`,`upper_bound`,`grade`,`points`,`description`) values (1,1,70,100,'A',4,NULL),(2,1,60,69,'B+',3.3,NULL),(3,1,50,59,'B',3,NULL),(4,1,45,49,'C+',2.3,NULL),(5,1,40,44,'C',2,NULL),(6,1,0,39,'F',0,NULL),(7,2,75,100,'A',4,NULL),(8,2,70,74,'A-',3.7,NULL),(9,2,60,69,'B',3,NULL),(10,2,50,59,'C',2,NULL),(11,2,0,49,'F',0,NULL),(12,3,70,100,'A',5,NULL),(13,3,60,69,'B',4,NULL),(14,3,50,59,'C',3,NULL),(15,3,45,49,'D',2,NULL),(16,3,40,44,'E',1,NULL),(17,3,0,39,'F',0,NULL),(18,4,90,100,'A',4,NULL),(19,4,80,89,'B',3,NULL),(20,4,70,79,'C',2,NULL),(21,4,0,60,'F',1,NULL);

/*Table structure for table `grading_systems` */

DROP TABLE IF EXISTS `grading_systems`;

CREATE TABLE `grading_systems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `grading_systems` */

insert  into `grading_systems`(`id`,`type`) values (1,'WES Nigeria'),(2,'WES South Africa'),(3,'Nigeria Local'),(4,'US Local');

/*Table structure for table `scores` */

DROP TABLE IF EXISTS `scores`;

CREATE TABLE `scores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `programme` int(11) DEFAULT NULL,
  `course` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `islocked` tinyint(1) DEFAULT '0',
  `semester` int(11) DEFAULT NULL,
  `academicsession` varchar(45) DEFAULT NULL,
  `overall` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `cascore` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `scores` */

insert  into `scores`(`id`,`programme`,`course`,`uid`,`type`,`islocked`,`semester`,`academicsession`,`overall`,`score`,`cascore`,`created`,`updated`) values (1,1,1,1,NULL,0,1,'2014/2015',100,52,32,'2014-09-14 20:04:46','2014-09-13 21:05:35'),(2,1,2,1,NULL,0,1,'2014/2015',100,45,39,'2014-09-14 20:35:38','2014-09-13 21:06:54'),(3,1,3,1,NULL,0,1,'2014/2015',100,42,39,'2014-09-14 20:35:52','2014-09-13 21:07:23'),(4,1,4,1,NULL,0,2,'2014/2015',100,45,40,'2014-09-14 20:39:07','2014-09-13 21:07:48'),(5,1,5,1,NULL,0,2,'2014/2015',100,55,33,'2014-09-14 20:39:08','2014-09-13 21:08:01'),(6,1,6,1,NULL,0,1,'2014/2015',100,55,34,'2014-09-14 20:38:04','2014-09-13 21:08:14'),(7,1,3,2,NULL,0,1,'2014/2015',100,44,30,'2014-09-14 20:44:20','2014-09-13 21:08:34'),(8,1,2,2,NULL,0,1,'2014/2015',100,44,30,'2014-09-14 20:44:41','2014-09-13 21:08:45'),(9,1,3,2,NULL,0,1,'2014/2015',100,44,35,'2014-09-14 20:43:18','2014-09-13 21:08:56'),(10,1,4,2,NULL,0,1,'2014/2015',100,40,23,'2014-09-14 20:45:47','2014-09-13 21:09:06'),(11,1,5,2,NULL,0,2,'2014/2015',100,33,20,'2014-09-14 20:46:28','2014-09-13 21:10:04'),(12,1,6,2,NULL,0,2,'2014/2015',100,55,21,'2014-09-14 20:46:50','2014-09-13 21:10:16'),(13,1,7,2,NULL,0,2,'2014/2015',100,44,22,'2014-09-14 20:47:08','2014-09-13 21:17:57'),(14,1,8,2,NULL,0,2,'2014/2015',100,20,25,'2014-09-14 20:47:30','2014-09-13 21:20:43'),(17,1,8,1,NULL,0,2,'2014/2015',100,60,25,'2014-09-14 21:20:47','2014-09-14 21:20:47');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(55) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `api_key` varchar(100) DEFAULT NULL,
  `studentnumber` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`api_key`,`studentnumber`) values (1,'dtgeadamo@yahoo.com','abc123abc','abc123abc','10819960'),(2,'Eberechi Akoma','$2a$10$d7ac622b87fbf7a844cb6OPIly7Oyp5wsfDVqx','0b0c817657e89bd64894717c2a3d878c','10819961'),(3,'John Doe','$2a$10$accf40e7550f52ce2ed82uao2vDc831U9PHAS2','d2ac5463b09b5cd15fa20f2e8a01d9ad',NULL),(4,'Tommy Lee','$2a$10$f11292eefb4a0374cfa53urvvhnjhSsjgMK1zz','022c0d4907f74c952b529a8ac45efbaa',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
