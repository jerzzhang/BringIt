# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.0.95)
# Database: orderMenu
# Generation Time: 2015-04-15 16:14:57 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table account_address
# ------------------------------------------------------------

DROP TABLE IF EXISTS `account_address`;

CREATE TABLE `account_address` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `account_id` varchar(40) default NULL,
  `street` varchar(300) default NULL,
  `apartment` varchar(100) default NULL,
  `city` varchar(100) default NULL,
  `state` varchar(2) default NULL,
  `zip` int(5) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `account_address` WRITE;
/*!40000 ALTER TABLE `account_address` DISABLE KEYS */;

INSERT INTO `account_address` (`id`, `account_id`, `street`, `apartment`, `city`, `state`, `zip`)
VALUES
	(1,'C5C1DE2774F148D1BCE032A6A2E0A450','1911 Yearby Avenue','F','Durham','NC',27708);

/*!40000 ALTER TABLE `account_address` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table accounts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `uid` varchar(32) default NULL,
  `email` varchar(100) NOT NULL default '',
  `password_hash` varchar(200) NOT NULL default '',
  `password_salt` varchar(200) NOT NULL default '',
  `session` varchar(100) default NULL,
  `phone` varchar(10) NOT NULL default '',
  `stripe_cust_id` varchar(100) default NULL,
  `permission` int(1) default '1',
  `name` varchar(100) default NULL,
  `logintime` varchar(100) default NULL,
  `service_id` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;

INSERT INTO `accounts` (`id`, `uid`, `email`, `password_hash`, `password_salt`, `session`, `phone`, `stripe_cust_id`, `permission`, `name`, `logintime`, `service_id`)
VALUES
	(15,'270B82D2533A4D1F90BA2F8ACCD5D2A4','me@jason.sx','5c747270c0ac80f67232ed81c1522962b70474116e55e7f58474018d81bdbb9449217bfd60e6f34a5dab3a59e3b5ea08ce8254c4dfd5e26797ce0b510e79caa5','192010726552c249bca36f1.80522327','0','4782135736',NULL,4,'Jason Hamilton','0',1),
	(16,'C5C1DE2774F148D1BCE032A6A2E0A450','cam@chicago.com','c41c28d25dcd6876e5013ab4b0d92f1e0858e0daed25c4be6b975fd48066926a900993c569a403c3d30fd05cd0e48d631abf893042992354e67e13cc8304fcce','1768203362552d6688cdef53.26912305','F18EE07BF6CE47DD90FC798590C4420FC3ECD239C62F44D0B4','8474713541',NULL,4,'Cameron Wrigley','1429112488',1),
	(19,'95D06E56010A416C9217E02D36EE1381','stephanie.engle@duke.edu','9c44080d363caf6acff85b699d64ffdf796c844824d2f2e6625a408b6685b6e9595b908e362427983af58d2e4bcce9380300e165aa8d345dfe676b3ba8f2efb7','235106558552e84e2b0c244.15138263','EEA744158E924D3681EE7493DEFF4FC6105CF933096D4B6883','8583429680',NULL,4,'Stephanie Engle','1429112049',1);

/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table carts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `carts`;

CREATE TABLE `carts` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `cart_type` varchar(10) default NULL,
  `item_id` varchar(100) default NULL,
  `user_id` varchar(100) default NULL,
  `quantity` int(2) default '1',
  `active` int(11) default '1',
  `uid` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;

INSERT INTO `carts` (`id`, `cart_type`, `item_id`, `user_id`, `quantity`, `active`, `uid`)
VALUES
	(162,'1','2','C5C1DE2774F148D1BCE032A6A2E0A450',2,0,'5'),
	(163,'1','1','C5C1DE2774F148D1BCE032A6A2E0A450',1,0,'5'),
	(165,'1','2','C5C1DE2774F148D1BCE032A6A2E0A450',1,0,'6'),
	(166,'1','8','C5C1DE2774F148D1BCE032A6A2E0A450',1,0,'6'),
	(169,'1','1','C5C1DE2774F148D1BCE032A6A2E0A450',4,1,'CBEFC893E01C443A8938238FF4D63ABE'),
	(171,'1','1','95D06E56010A416C9217E02D36EE1381',2,1,'60489E4B48524511BF9EBF7DCD1B61F7'),
	(172,'1','2','95D06E56010A416C9217E02D36EE1381',1,1,'E1C415E10C10454DAE17F23D17BEAD9E'),
	(173,'1','3','95D06E56010A416C9217E02D36EE1381',1,1,'1D1E085D0950421580718CB0E92DD9DF'),
	(175,'1','2','270B82D2533A4D1F90BA2F8ACCD5D2A4',1,1,'180942C61C0945428EE07663AD8F3ADB'),
	(176,'1','4','270B82D2533A4D1F90BA2F8ACCD5D2A4',1,1,'A26E98D5B35F46DD822BB7C3A928E0CE');

/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `displayorder` int(2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `name`, `displayorder`)
VALUES
	(1,'Food',1),
	(2,'Groceries',2),
	(3,'Laundry',3);

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table category_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category_items`;

CREATE TABLE `category_items` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `category_id` int(2) default NULL,
  `image` varchar(100) default NULL,
  `type` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `category_items` WRITE;
/*!40000 ALTER TABLE `category_items` DISABLE KEYS */;

INSERT INTO `category_items` (`id`, `name`, `category_id`, `image`, `type`)
VALUES
	(0,'None',-1,NULL,NULL),
	(1,'Sushi Love',1,'sushi-love.jpg','Sushi'),
	(2,'Dragon Gate',1,'dragon-gate.jpg','Chinese'),
	(3,'Food Factory',1,'food-factory.jpg','American'),
	(4,'Hungry Leaf',1,'hungryleaf.jpg','Vegetarian'),
	(5,'Mediterra',1,'mediterra.jpg','Oriental'),
	(6,'TGI Fridays',1,'TGI.jpg','American'),
	(7,'The Loop',1,'the-loop.jpg','American'),
	(8,'Enzos',1,'enzos.jpg','Pizza');

/*!40000 ALTER TABLE `category_items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hours
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hours`;

CREATE TABLE `hours` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `category_id` int(11) default NULL,
  `service_id` int(11) default NULL,
  `start_hour` int(11) default NULL,
  `end_hour` int(11) default NULL,
  `start_am` int(1) default '1',
  `end_am` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `hours` WRITE;
/*!40000 ALTER TABLE `hours` DISABLE KEYS */;

INSERT INTO `hours` (`id`, `category_id`, `service_id`, `start_hour`, `end_hour`, `start_am`, `end_am`)
VALUES
	(1,1,1,5,11,0,0);

/*!40000 ALTER TABLE `hours` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table item_hours
# ------------------------------------------------------------

DROP TABLE IF EXISTS `item_hours`;

CREATE TABLE `item_hours` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `restaurant_id` varchar(100) default NULL,
  `start_hour` timestamp NULL default NULL,
  `end_hour` timestamp NULL default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table menu_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menu_categories`;

CREATE TABLE `menu_categories` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `category_id` varchar(100) default NULL,
  `name` varchar(100) default NULL,
  `service_id` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `menu_categories` WRITE;
/*!40000 ALTER TABLE `menu_categories` DISABLE KEYS */;

INSERT INTO `menu_categories` (`id`, `category_id`, `name`, `service_id`)
VALUES
	(1,'1','Appetizers','1'),
	(2,'1','Entrees','1'),
	(3,'1','Sides','1'),
	(4,'1','Desserts','1');

/*!40000 ALTER TABLE `menu_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table menu_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menu_items`;

CREATE TABLE `menu_items` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(200) default NULL,
  `price` varchar(20) default NULL,
  `service_id` varchar(100) default NULL,
  `category_id` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;

INSERT INTO `menu_items` (`id`, `name`, `price`, `service_id`, `category_id`)
VALUES
	(1,'California Roll','7.60','1','1'),
	(2,'Dragon Roll','8.00','1','1'),
	(3,'Vegetarian Roll','7.50','1','1'),
	(4,'Teriyaki Chicken','8.00','1','1'),
	(5,'Big Bomber Roll','14.0','1','2'),
	(6,'Spicy Jason Roll','200.0','1','2'),
	(7,'Good Lord Jesus Roll','-5.0','1','3'),
	(8,'Don\'t Spank Me Satan Roll','10.0','1','3'),
	(9,'Big Frickin\' Cake','5.0','1','4'),
	(10,'Hunk Of Ice Cream','10.0','1','4');

/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` varchar(100) default NULL,
  `cart_id` int(11) default NULL,
  `time` datetime default NULL,
  `campus` varchar(100) default NULL,
  `service_id` int(11) default NULL,
  `category_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;

INSERT INTO `orders` (`id`, `user_id`, `cart_id`, `time`, `campus`, `service_id`, `category_id`)
VALUES
	(1,'C5C1DE2774F148D1BCE032A6A2E0A450',5,'2015-04-15 04:10:32','West',1,1),
	(2,'C5C1DE2774F148D1BCE032A6A2E0A450',6,'2015-04-12 04:10:32','West',1,1);

/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table restaurants
# ------------------------------------------------------------

DROP TABLE IF EXISTS `restaurants`;

CREATE TABLE `restaurants` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `restaurant_id` varchar(100) default NULL,
  `name` varchar(1000) default NULL,
  `type` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
