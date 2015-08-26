# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.0.95)
# Database: orderMenu
# Generation Time: 2015-04-14 19:10:05 +0000
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
  `account_id` int(11) default NULL,
  `street` varchar(300) default NULL,
  `apartment` varchar(100) default NULL,
  `city` varchar(100) default NULL,
  `state` varchar(2) default NULL,
  `zip` int(5) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table accounts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `uid` varchar(32) default NULL,
  `email` varchar(100) NOT NULL default '',
  `password_hash` varchar(200) NOT NULL default '',
  `password_salt` varchar(100) NOT NULL default '',
  `session` varchar(100) default NULL,
  `phone` varchar(10) NOT NULL default '',
  `stripe_cust_id` varchar(100) default NULL,
  `type` int(1) default '1',
  `name` varchar(100) default NULL,
  `logintime` varchar(100) default NULL,
  `service_id` int(11) default '-1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;

INSERT INTO `accounts` (`id`, `uid`, `email`, `password_hash`, `password_salt`, `session`, `phone`, `stripe_cust_id`, `type`, `name`, `logintime`, `service_id`)
VALUES
	(14,'41C0B2190C74492398C5DF3EE2BD2CA7','cam','4661977c42b87f5efc5137757e10bd74162c490cba9c15f13a1e4f83dd0b5ea1ba963a74ffcfecf1731a83119a9b7d94f0964c985a9b672ee361eb5fe4cf37d5','1229083281552b62a2cece49.42463312','7717B74EFAD84340800F6CC75E05CD8ED732E7FAC97946C79D','8474713541',NULL,1,'Cameron Wrigley','1428960327',-1),
	(15,'270B82D2533A4D1F90BA2F8ACCD5D2A4','me@jason.sx','5c747270c0ac80f67232ed81c1522962b70474116e55e7f58474018d81bdbb9449217bfd60e6f34a5dab3a59e3b5ea08ce8254c4dfd5e26797ce0b510e79caa5','192010726552c249bca36f1.80522327','B49CF7CB71F54D4BABE07FBF0874C0DDF532F8DE0BBC474B83','4782135736',NULL,1,'Jason Hamilton','1429028112',-1);

/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table carts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `carts`;

CREATE TABLE `carts` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `cart_type` varchar(10) default NULL,
  `item_id` varchar(100) default NULL,
  `user_id` varchar(1000) default NULL,
  `quantity` int(2) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;

INSERT INTO `carts` (`id`, `cart_type`, `item_id`, `user_id`, `quantity`)
VALUES
	(162,'1','2','270B82D2533A4D1F90BA2F8ACCD5D2A4',1);

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
	(1,'food',1),
	(2,'groceries',2),
	(3,'laundry',3);

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
  `time` timestamp NULL default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



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
