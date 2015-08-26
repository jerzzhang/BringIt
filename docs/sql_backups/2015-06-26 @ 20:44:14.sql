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
  `account_id` varchar(40) NOT NULL DEFAULT '',
  `street` varchar(300) DEFAULT NULL,
  `apartment` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_address`
--

LOCK TABLES `account_address` WRITE;
/*!40000 ALTER TABLE `account_address` DISABLE KEYS */;
INSERT INTO `account_address` VALUES ('4EE5AED4815A437B894729024658313D','Perkins Library','','Durham','Nc','27705'),('5E3AC0A63D0A453CA3C27BEDCC9A9EEA','823 Burch Street','','Durham','NC','27703'),('86AC514D742C46EEAB1C20B5A79A768B','50 Prism ','1200','Irvine','CA','95405'),('87DE109EAE0E4766AAC02136AFA00D30','1712 Pace St','Apt K','Durham','NC','27708'),('C002B27961B2416DAF94E2C4E9C97655','1911 Yearby','Wilson 4','Durham','NC','27708'),('EF1B7DB5B047497198702392E5B10CA6','210 Alexander Avenue','H','Durham','NC','10580');
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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (15,'270B82D2533A4D1F90BA2F8ACCD5D2A4','me@jason.sx','5c747270c0ac80f67232ed81c1522962b70474116e55e7f58474018d81bdbb9449217bfd60e6f34a5dab3a59e3b5ea08ce8254c4dfd5e26797ce0b510e79caa5','192010726552c249bca36f1.80522327','B49CF7CB71F54D4BABE07FBF0874C0DDF532F8DE0BBC474B83','4782135736',NULL,4,'Jason Hamilton','1429028112',0),(25,'C002B27961B2416DAF94E2C4E9C97655','cam@chicago.com','f42a6f1b82d3bf61f1dccfad3883d09c1c21914dd8accc61898cc7cdbb8a38a7e615c6612e4a8baa7093b07974e53376162df79694f7ccf0f2605ed294c0f082','1456066305554d3ad5079c67.65743717','0','8474713541',NULL,4,'Cameron','0',0),(27,'D487E9A229ED4F4E871493E2DB67A49C','Rahim9328@yahoo.com','96f346d035b7af8bd70754bfa229aae3fac5430cfe18a57d037e27f3cdff62d3b5ee0975b5bd2446c5a258d2de4a3a9d3891e4d9260a9a32c6635c64482c472a','1100090901554ec521afc0e3.84798357','0','8175047621',NULL,4,'Rahim Gokal','0',0),(31,'4EE5AED4815A437B894729024658313D','info@campusenterprises.org','3d75902f141fe5082c40d16bb77c38e9a548bec3890ab3bc53a80f3fb51c35664dc855765d942602c0bbdfba736508859793245ee9714ede1ffccd275e2383e8','834902360557500dcc113e3.94211995','2D9FC22649D045C6809D93012C18BE91A02BE8A75EF64E5A9B','4077413626',NULL,4,'Campus Enterprises Admin','1434302764',0),(32,'30F43967448A4A34A46C0DBE1B7BFDAB','restaurant@campusenterprises.org','66f9d721d83cad9c37afe8feaa2d2d6648d845c1b227ee8649265ef7a84b06c67955929c591408a655899d8e24431878a4118cdca27a6a5f908bf84252562440','125282660955750d7b155eb5.15840198','77891C176DA64FCDBB27EA8DC6A3F7DBEA881FA20F434523A8','4077413626',NULL,3,'Restaurants Test','1433734685',1),(33,'868257E6887F480F90121F55D52E899A','colin.power@duke.edu','23456b460e06b2ca14f5a08f2f404deb02dfd72a71dfc1dc64cb35fed54d0278b16494a291b7d22b7ecad670f13c0f0ace913d3196f8444570d2fe60814e3319','4140897065575242a9ab674.94727662','55261B48DD804F74AB6DD01207153F56FA6F6DCDF12942D6BB','6177772994',NULL,1,'Colin Power','1433740403',0),(34,'EF1B7DB5B047497198702392E5B10CA6','kevinehatch@gmail.com','ce341d8ece169c1e0a028719929420b35c5670878751ddd235820f12abc3ea8bef46e5e71a791863a6717da2f16cbb534ecd34450df314488e225b1a355cbdb8','657431834557b14e92f6816.95171069','448184D7EB1E4511840C3D9F2DFEA08C445258F3ABAE453F82','9143564921',NULL,1,'Kevin Hatch','1434130422',0),(35,'5505805DD8014B459383B7108155F98A','jzipf2@gmail.com','0b0d70a76bc12788488aad0b5bd39e95c5a5bd8ca55ecfa06bc0cbd30c58b1278a291bee52264dc9c87317ac5ca22425a5ef6d18e2d34e5dee072bcb6e9a8e91','1041788642557b16a1273820.07721216','EA02DFE220F64424BA3268ECFE09910399C251F3C2DE417DA4','6102830721',NULL,1,'John Zipf','1434130342',0),(36,'86AC514D742C46EEAB1C20B5A79A768B','mmb53@duke.edu','619f9552f63fddcadaf97332b47ac73aaadad404949ff9ac0b586a470165e25cee5cc86e4d3b6c892a2961822b08551012aa87e6e844171f3dff5424c78ff4a6','306077126557b58920335c3.15545268','463EDEADDAC448178774A615BB933ECB694D48438DC14E13A1','707-225-49',NULL,1,'Madison Bradshaw','1434146962',0),(37,'5E3AC0A63D0A453CA3C27BEDCC9A9EEA','Wgb7@duke.edu','a215068e946e77edd2c045edf33640178593656cbd406844de39f5703da860673b4a470795fd5253f40f348fcba9696b5850c12595eef322cb15972cdd7181ee','1403728167557b68ab308c73.12058598','69C5B1073DF34D54966CBB4A0045B084543D0B93325F485296','8478141011',NULL,1,'Will Bobrinskoy','1434151083',0),(38,'3A092872E20343B1801ED3223EEE8DF4','test','9b4c23079e4402860b410b1af1dc196e9a05e7329b28c1ba8860fb0e58dd69fdef1aa80b9e1a207f67efaa6292616a7da8cc023f8b29f30142e11c5345f9d7cf','1809890911557b7a04e20962.08874361','CB4131AE779144589D1869CEE009A2904CEB7DE70FD141C4AE','1234567899',NULL,1,'Test','1434155524',0),(39,'87DE109EAE0E4766AAC02136AFA00D30','ag335@duke.edu','b15afb9d00dc25744697b1ea74300eb572c7ee23e04899ec385a2b90307df3a81e7f208046ec41f500359e2cafcae066544f01d31e79154067ea30f345bfffc6','730038135557b7ccd672615.83529158','EF2F4B6E80FE43DAB93DB8950D86A4D8ACDF0CFCFBF9439E8D','2037221603',NULL,1,'Ann Marie Guzzi','1434156770',0),(40,'DC3A2B9E7C114A8AAAA479444FA7372D','zz60@duke.edu','7ec71b9550dc8569a18bb53af15eba6f644a118928d7ef46f4845232278aa6ed65c929b340b212d275a82384e8d029c5c579c24fb78133cae1580c1f51db7f99','130467482557cb3978b8e26.81858122','0','4077413626',NULL,1,'Jeremy Zhang','0',0),(41,'0AA4F0DE63DA449EA8D5A22D05EF149E','jdoe@gmail.com','171cbb2257572821f7dab2fb81de6a750cafc3435f170e8d8f9351d1f46a642e6fd3c46f6ac3041de7be568475c5cad9c83aea3973cf3cf318f6de0bde9e8d53','182568726558dffd13c80f2.89935637','A637F8E0DA304D18B89385AC7AC819B0BB27AA9D57484B9896','test',NULL,1,'John doe','1435369425',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_sides`
--

LOCK TABLES `cart_sides` WRITE;
/*!40000 ALTER TABLE `cart_sides` DISABLE KEYS */;
INSERT INTO `cart_sides` VALUES (2,'82B309D9962A46149873102A27E11E58',4,1),(3,'4FDD571EBDEE46EB9C1E2DDC1084DA68',4,1),(4,'4FDD571EBDEE46EB9C1E2DDC1084DA68',3,1),(5,'4F8FDE2FB80C47CE88841B09FD914C05',1,1),(6,'C9AF9B2B873240E1A2D127E6F21839AB',4,1),(7,'C9AF9B2B873240E1A2D127E6F21839AB',3,1),(8,'C058FA635199404381AC5FC5999D351A',4,1),(9,'C058FA635199404381AC5FC5999D351A',3,1),(15,'3AF3CBF5CB6B45FA8C9222F74593488B',4,1),(16,'3AF3CBF5CB6B45FA8C9222F74593488B',3,1),(17,'4FC33DA75CDD4F6C88972C346313C54A',1,1),(18,'498F5871113F4BA7B8B00642625780B9',4,1),(19,'498F5871113F4BA7B8B00642625780B9',3,1),(20,'E738F3D5F3B44479AF8D5C20000E2BC2',1,1),(21,'11C97E41306845EB880FD4341E970973',1,1),(22,'9032E07C2A7B47DAB1DBF1C0357EE795',1,1),(23,'051A90CFB5414802A47805C6F4C37687',1,1),(24,'9537F499D2864BC3866BDCFC570C4A60',4,1),(25,'8EB59524E0CE4BAA9749728941E560BD',4,1),(26,'178C6C6994014F8AA9B6A3AF2EDADDED',1,1),(27,'178C6C6994014F8AA9B6A3AF2EDADDED',3,1),(28,'E3ED0580A2A9406292F58AB4064DF95B',1,1),(29,'E3ED0580A2A9406292F58AB4064DF95B',3,1);
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
  `order_id` int(10) DEFAULT '-1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (2,'1','1','6FB4A3F0C55D4332B54463F1091B428D',1,0,'82B309D9962A46149873102A27E11E58',1,'',8),(3,'1','1','4EE5AED4815A437B894729024658313D',1,0,'4FDD571EBDEE46EB9C1E2DDC1084DA68',1,'',9),(4,'1','1','EF1B7DB5B047497198702392E5B10CA6',1,1,'4F8FDE2FB80C47CE88841B09FD914C05',1,'',-1),(5,'1','2','EF1B7DB5B047497198702392E5B10CA6',1,1,'C9AF9B2B873240E1A2D127E6F21839AB',1,'',-1),(6,'1','10','EF1B7DB5B047497198702392E5B10CA6',1,1,'5376D4C4A8B34CDDAB5DCB7A8AEE4C9E',1,'',-1),(7,'1','9','EF1B7DB5B047497198702392E5B10CA6',1,1,'1471B234E566408AA981FECA77BE5A08',1,'Dressing on the side',-1),(8,'1','9','EF1B7DB5B047497198702392E5B10CA6',1,1,'DD59854AD06346339E2FB1DB75DDA0BC',1,'Dressing on the side\r\n',-1),(9,'1','9','EF1B7DB5B047497198702392E5B10CA6',1,1,'CA74FA9035754FC496F364667ED42338',1,'dressing on the side',-1),(10,'1','9','EF1B7DB5B047497198702392E5B10CA6',1,1,'4CDF5D12A3C44F0084B3B90C28A07D18',1,'',-1),(11,'1','10','EF1B7DB5B047497198702392E5B10CA6',1,1,'76C1FE9FC82E40B08B197B29465DA1EF',1,'dressing on the side',-1),(12,'1','2','EF1B7DB5B047497198702392E5B10CA6',1,1,'C058FA635199404381AC5FC5999D351A',1,'',-1),(13,'1','8','4EE5AED4815A437B894729024658313D',1,0,'156DFB606D9E45FEB05A4EA1372B54BE',1,'',10),(14,'1','6','87DE109EAE0E4766AAC02136AFA00D30',1,0,'2C2968E2EA184925A9AB972B5ADCA673',1,'',11),(19,'1','1','DC3A2B9E7C114A8AAAA479444FA7372D',1,1,'3AF3CBF5CB6B45FA8C9222F74593488B',1,'',-1),(20,'1','1','DC3A2B9E7C114A8AAAA479444FA7372D',1,1,'4FC33DA75CDD4F6C88972C346313C54A',1,'gdfgsdfgsdfg',-1),(22,'1','2','4EE5AED4815A437B894729024658313D',1,0,'498F5871113F4BA7B8B00642625780B9',1,'',12),(23,'1','3','4EE5AED4815A437B894729024658313D',1,0,'E738F3D5F3B44479AF8D5C20000E2BC2',1,'',12),(24,'1','4','4EE5AED4815A437B894729024658313D',1,0,'11C97E41306845EB880FD4341E970973',1,'',12),(25,'1','20','4EE5AED4815A437B894729024658313D',1,0,'9032E07C2A7B47DAB1DBF1C0357EE795',1,'',12),(26,'1','4','4EE5AED4815A437B894729024658313D',1,0,'051A90CFB5414802A47805C6F4C37687',1,'',12),(27,'1','4','4EE5AED4815A437B894729024658313D',1,1,'9537F499D2864BC3866BDCFC570C4A60',1,'',-1),(28,'1','3','4EE5AED4815A437B894729024658313D',1,1,'8EB59524E0CE4BAA9749728941E560BD',1,'',-1),(29,'1','1','C002B27961B2416DAF94E2C4E9C97655',1,1,'178C6C6994014F8AA9B6A3AF2EDADDED',1,'',-1),(30,'1','1','C002B27961B2416DAF94E2C4E9C97655',1,1,'E3ED0580A2A9406292F58AB4064DF95B',1,'',-1);
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
  `active` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Food',1,4),(2,'Groceries',2,1),(3,'Laundry',3,1),(4,'TEST',4,1);
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
  `email` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_items`
--

LOCK TABLES `category_items` WRITE;
/*!40000 ALTER TABLE `category_items` DISABLE KEYS */;
INSERT INTO `category_items` VALUES (0,NULL,-1,NULL,NULL,NULL,NULL,0,1,''),(1,'Sushi Love',1,'sushi-love.jpg','Sushi',NULL,'Sushi Love Description',10,1,'orders@sushilove.com'),(2,'DG',1,'dragon-gate.jpg','Chinese',NULL,'Dragon Gate Description',5,1,NULL),(3,'Food Factory',1,'food-factory.jpg','American',NULL,'Food Factory Description',5,1,NULL),(4,'Hungry Leaf',1,'hungryleaf.jpg','Vegetarian',NULL,'Hungry Leaf Description',5,1,NULL),(5,'Mediterra',1,'mediterra.jpg','Oriental',NULL,'Mediterra Description',5,1,NULL),(6,'TGI Fridays',1,'TGI.jpg','American',NULL,'TGI Fridays Description',5,1,NULL),(7,'The Loop',1,'the-loop.jpg','American',NULL,'The Loop Description',5,1,NULL),(8,'Enzos',1,'enzos.jpg','Pizza',NULL,'Enzos Description',5,1,NULL);
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
  `start_hour` varchar(100) DEFAULT NULL,
  `end_hour` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_hours`
--

LOCK TABLES `item_hours` WRITE;
/*!40000 ALTER TABLE `item_hours` DISABLE KEYS */;
INSERT INTO `item_hours` VALUES (1,'1','8:00am','9:00pm');
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (1,'Cali Roll','desc1','7.60','1','1',1),(2,'French Roll','desc2','8.00','1','1',1),(3,'Veggie Roll','desc3','12.53','1','1',1),(4,'Teriyaki Chicken','desc4','8.00','1','1',1),(5,'Big Bomber Roll','desc5','14.0','1','2',1),(6,'Spicy Jason Roll','desc6','200.0','1','2',1),(7,'Good Lord Jesus Roll','desc7','-5.0','1','3',1),(8,'Don\'t Spank Me Satan Roll','desc8','10.0','1','3',1),(9,'Big Frickin\' Cake','desc9','5.0','1','4',0),(10,'Hunk Of Ice Cream','desc10','10.0','1','4',0),(20,'French Salad','Good','12.00','1','1',1);
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
  `service_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_sides`
--

LOCK TABLES `menu_sides` WRITE;
/*!40000 ALTER TABLE `menu_sides` DISABLE KEYS */;
INSERT INTO `menu_sides` VALUES (1,'Fried Rice','1.00',1,1),(2,'Miso Soup','1.50',0,1),(3,'Pork Fried Rice','1.50',0,1),(4,'Steamed Rice','1.00',1,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_sides_item_link`
--

LOCK TABLES `menu_sides_item_link` WRITE;
/*!40000 ALTER TABLE `menu_sides_item_link` DISABLE KEYS */;
INSERT INTO `menu_sides_item_link` VALUES (1,1,1),(2,4,1),(5,1,3),(6,4,3),(7,1,4),(8,4,4),(9,2,1),(11,2,3),(12,2,4),(13,3,1),(15,3,3),(16,3,4),(70,3,2),(72,1,2),(73,2,2),(74,4,2),(77,1,20),(78,2,20);
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
  `payment_cc` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (8,'6FB4A3F0C55D4332B54463F1091B428D',NULL,'2015-05-27 15:18:30',NULL,1,1,0),(9,'4EE5AED4815A437B894729024658313D',NULL,'2015-06-09 21:29:49',NULL,1,1,0),(10,'4EE5AED4815A437B894729024658313D',NULL,'2015-06-12 18:00:44',NULL,1,1,1),(11,'87DE109EAE0E4766AAC02136AFA00D30',NULL,'2015-06-12 21:01:44',NULL,1,1,0),(12,'4EE5AED4815A437B894729024658313D',NULL,'2015-06-14 13:24:56',NULL,1,1,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'sitename','BringIt','Site Name',1),(2,'imageexts','png,jpg,jpeg','Valid Image Extensions',1),(3,'sitelogo','61A5E01E12544FE8B0354A6F54EA562CEFF3C711B95C4AAAA7.png','Logo',2),(4,'checkoutmsg','You are checking out!','Checkout Message',1),(5,'lastitem','25','NONE',0),(7,'lastsrv','0','NONE',0);
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

-- Dump completed on 2015-06-26 20:44:14
