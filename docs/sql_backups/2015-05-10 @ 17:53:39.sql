-- MySQL dump 10.13  Distrib 5.6.17, for osx10.7 (i386)
--
-- Host: 127.0.0.1    Database: ordermenu
-- ------------------------------------------------------
-- Server version	5.5.38

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
-- Table structure for table `account_address`
--

DROP TABLE IF EXISTS `account_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` varchar(40) DEFAULT NULL,
  `street` varchar(300) DEFAULT NULL,
  `apartment` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_address`
--

LOCK TABLES `account_address` WRITE;
/*!40000 ALTER TABLE `account_address` DISABLE KEYS */;
INSERT INTO `account_address` VALUES (1,'C5C1DE2774F148D1BCE032A6A2E0A450','1911 Yearby Avenue','F','Durham','NC',27708);
/*!40000 ALTER TABLE `account_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(32) DEFAULT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `password_hash` varchar(200) NOT NULL DEFAULT '',
  `password_salt` varchar(100) NOT NULL DEFAULT '',
  `session` varchar(100) DEFAULT NULL,
  `phone` varchar(10) NOT NULL DEFAULT '',
  `stripe_cust_id` varchar(100) DEFAULT NULL,
  `permission` int(1) DEFAULT '1',
  `name` varchar(100) DEFAULT NULL,
  `logintime` varchar(100) DEFAULT NULL,
  `service_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (15,'270B82D2533A4D1F90BA2F8ACCD5D2A4','me@jason.sx','5c747270c0ac80f67232ed81c1522962b70474116e55e7f58474018d81bdbb9449217bfd60e6f34a5dab3a59e3b5ea08ce8254c4dfd5e26797ce0b510e79caa5','192010726552c249bca36f1.80522327','B49CF7CB71F54D4BABE07FBF0874C0DDF532F8DE0BBC474B83','4782135736',NULL,4,'Jason Hamilton','1429028112',7),(25,'C002B27961B2416DAF94E2C4E9C97655','cam@chicago.com','f42a6f1b82d3bf61f1dccfad3883d09c1c21914dd8accc61898cc7cdbb8a38a7e615c6612e4a8baa7093b07974e53376162df79694f7ccf0f2605ed294c0f082','1456066305554d3ad5079c67.65743717','03A7D19A0A324FFCA0473E33B5B4C55545C340292A1446A0BA','8474713541',NULL,4,'Cameron Wrigley','1431290944',0),(27,'D487E9A229ED4F4E871493E2DB67A49C','Rahim9328@yahoo.com','96f346d035b7af8bd70754bfa229aae3fac5430cfe18a57d037e27f3cdff62d3b5ee0975b5bd2446c5a258d2de4a3a9d3891e4d9260a9a32c6635c64482c472a','1100090901554ec521afc0e3.84798357','0','8175047621',NULL,4,'Rahim Gokal','0',0);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_sides`
--

DROP TABLE IF EXISTS `cart_sides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_sides` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cart_entry_uid` varchar(100) DEFAULT NULL,
  `side_id` int(10) DEFAULT NULL,
  `quantity` int(10) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_sides`
--

LOCK TABLES `cart_sides` WRITE;
/*!40000 ALTER TABLE `cart_sides` DISABLE KEYS */;
INSERT INTO `cart_sides` VALUES (85,'766511027EB74221A2D28F7AFA920D7E',1,1),(86,'CA1685DAD3E34E9B90F505066D5C86DC',1,1),(87,'CA1685DAD3E34E9B90F505066D5C86DC',2,1);
/*!40000 ALTER TABLE `cart_sides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cart_type` varchar(10) DEFAULT NULL,
  `item_id` varchar(100) DEFAULT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `quantity` int(2) DEFAULT '1',
  `active` int(11) DEFAULT '1',
  `uid` varchar(100) DEFAULT NULL,
  `cat_id` int(10) DEFAULT NULL,
  `instructions` varchar(2000) DEFAULT 'None',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=238 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (236,'1','1','C002B27961B2416DAF94E2C4E9C97655',1,1,'766511027EB74221A2D28F7AFA920D7E',1,''),(237,'1','4','C002B27961B2416DAF94E2C4E9C97655',1,1,'CA1685DAD3E34E9B90F505066D5C86DC',1,'');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `displayorder` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Food',1),(2,'Groceries',2),(3,'Laundry',3),(4,'TEST',4);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_items`
--

DROP TABLE IF EXISTS `category_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `category_id` int(2) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `order_image` varchar(100) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `delivery_fee` int(10) DEFAULT '0',
  `minimum_price` int(10) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_items`
--

LOCK TABLES `category_items` WRITE;
/*!40000 ALTER TABLE `category_items` DISABLE KEYS */;
INSERT INTO `category_items` VALUES (0,'None',-1,NULL,NULL,NULL,NULL,0,1),(1,'Sushi Love',1,'sushi-love.jpg','Sushi',NULL,'Sushi Love Description',10,1),(2,'Dragon Gate',1,'dragon-gate.jpg','Chinese',NULL,'Dragon Gate Description',5,1),(3,'Food Factory',1,'food-factory.jpg','American',NULL,'Food Factory Description',5,1),(4,'Hungry Leaf',1,'hungryleaf.jpg','Vegetarian',NULL,'Hungry Leaf Description',5,1),(5,'Mediterra',1,'mediterra.jpg','Oriental',NULL,'Mediterra Description',5,1),(6,'TGI Fridays',1,'TGI.jpg','American',NULL,'TGI Fridays Description',5,1),(7,'The Loop',1,'the-loop.jpg','American',NULL,'The Loop Description',5,1),(8,'Enzos',1,'enzos.jpg','Pizza',NULL,'Enzos Description',5,1);
/*!40000 ALTER TABLE `category_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hours`
--

DROP TABLE IF EXISTS `hours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hours` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `start_hour` int(11) DEFAULT NULL,
  `end_hour` int(11) DEFAULT NULL,
  `start_am` int(1) DEFAULT '1',
  `end_am` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hours`
--

LOCK TABLES `hours` WRITE;
/*!40000 ALTER TABLE `hours` DISABLE KEYS */;
INSERT INTO `hours` VALUES (1,1,1,5,11,0,0);
/*!40000 ALTER TABLE `hours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_hours`
--

DROP TABLE IF EXISTS `item_hours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_hours` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `restaurant_id` varchar(100) DEFAULT NULL,
  `start_hour` timestamp NULL DEFAULT NULL,
  `end_hour` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_hours`
--

LOCK TABLES `item_hours` WRITE;
/*!40000 ALTER TABLE `item_hours` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_hours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_categories`
--

DROP TABLE IF EXISTS `menu_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `service_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_categories`
--

LOCK TABLES `menu_categories` WRITE;
/*!40000 ALTER TABLE `menu_categories` DISABLE KEYS */;
INSERT INTO `menu_categories` VALUES (1,'1','Appetizers','1'),(2,'1','Entrees','1'),(3,'1','Sides','1'),(4,'1','Desserts','1');
/*!40000 ALTER TABLE `menu_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `desc` varchar(2000) DEFAULT NULL,
  `price` varchar(20) DEFAULT NULL,
  `service_id` varchar(100) DEFAULT NULL,
  `category_id` varchar(100) DEFAULT NULL,
  `has_side` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (1,'California Roll','desc1','7.60','1','1',1),(2,'Dragon Roll','desc2','8.00','1','1',1),(3,'Vegetarian Roll','desc3','7.50','1','1',1),(4,'Teriyaki Chicken','desc4','8.00','1','1',1),(5,'Big Bomber Roll','desc5','14.0','1','2',1),(6,'Spicy Jason Roll','desc6','200.0','1','2',1),(7,'Good Lord Jesus Roll','desc7','-5.0','1','3',1),(8,'Don\'t Spank Me Satan Roll','desc8','10.0','1','3',1),(9,'Big Frickin\' Cake','desc9','5.0','1','4',0),(10,'Hunk Of Ice Cream','desc10','10.0','1','4',0);
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_sides`
--

DROP TABLE IF EXISTS `menu_sides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_sides` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `price` varchar(15) DEFAULT NULL,
  `required` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_sides`
--

LOCK TABLES `menu_sides` WRITE;
/*!40000 ALTER TABLE `menu_sides` DISABLE KEYS */;
INSERT INTO `menu_sides` VALUES (1,'Fried Rice','1.00',1),(2,'Miso Soup','1.50',0),(3,'Pork Fried Rice','1.50',0),(4,'Steamed Rice','1.00',1);
/*!40000 ALTER TABLE `menu_sides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_sides_item_link`
--

DROP TABLE IF EXISTS `menu_sides_item_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_sides_item_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sides_id` int(10) DEFAULT NULL,
  `item_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_sides_item_link`
--

LOCK TABLES `menu_sides_item_link` WRITE;
/*!40000 ALTER TABLE `menu_sides_item_link` DISABLE KEYS */;
INSERT INTO `menu_sides_item_link` VALUES (1,1,1),(2,4,1),(3,1,2),(4,4,2),(5,1,3),(6,4,3),(7,1,4),(8,4,4),(9,2,1),(10,2,2),(11,2,3),(12,2,4),(13,3,1),(14,3,2),(15,3,3),(16,3,4);
/*!40000 ALTER TABLE `menu_sides_item_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `campus` varchar(100) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'D065441921F842988ACA2F5AF89C1D07',5,'2015-04-15 04:10:32','West',1,1),(2,'D065441921F842988ACA2F5AF89C1D07',6,'2015-04-12 04:10:32','West',1,1);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurants` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `restaurant_id` varchar(100) DEFAULT NULL,
  `name` varchar(1000) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurants`
--

LOCK TABLES `restaurants` WRITE;
/*!40000 ALTER TABLE `restaurants` DISABLE KEYS */;
/*!40000 ALTER TABLE `restaurants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  `display` varchar(100) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'sitename','BringIt','Site Name',1),(2,'imageexts','png,jpg,jpeg','Valid Image Extensions',1),(3,'sitelogo','61A5E01E12544FE8B0354A6F54EA562CEFF3C711B95C4AAAA7.png','Logo',2),(4,'checkoutmsg','You are checking out!','Checkout Message',1);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-10 17:53:39
