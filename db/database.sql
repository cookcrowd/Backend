# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.9)
# Datenbank: cookielicious
# Erstellungsdauer: 2011-11-09 14:42:53 +0100
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Export von Tabelle ingredients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ingredients`;

CREATE TABLE `ingredients` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle recipies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `recipies`;

CREATE TABLE `recipies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL DEFAULT '',
  `preparation_time` smallint(4) NOT NULL,
  `thumbnail` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle step_images
# ------------------------------------------------------------

DROP TABLE IF EXISTS `step_images`;

CREATE TABLE `step_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `step_id` int(11) unsigned NOT NULL,
  `src` varchar(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fk_image_step` (`step_id`),
  CONSTRAINT `fk_image_step` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle step_ingredients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `step_ingredients`;

CREATE TABLE `step_ingredients` (
  `ingredient_id` int(11) unsigned NOT NULL,
  `step_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ingredient_id`,`step_id`),
  KEY `fk_step_ingredients_step` (`step_id`),
  CONSTRAINT `fk_step_ingredients_step` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`),
  CONSTRAINT `fk_step_ingredients_ingredient` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle step_todos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `step_todos`;

CREATE TABLE `step_todos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `step_id` int(10) unsigned NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fk_todo_step` (`step_id`),
  CONSTRAINT `fk_todo_step` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle steps
# ------------------------------------------------------------

DROP TABLE IF EXISTS `steps`;

CREATE TABLE `steps` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recipie_id` int(11) unsigned NOT NULL,
  `title` varchar(80) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `duration` smallint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_step_recipie` (`recipie_id`),
  CONSTRAINT `fk_step_recipie` FOREIGN KEY (`recipie_id`) REFERENCES `recipies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
