/*
SQLyog Ultimate v10.2 
MySQL - 5.5.24-log : Database - rose
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `admin` */

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `active` char(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`admin_id`,`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `admin` */

insert  into `admin`(`admin_id`,`email`,`password`,`active`) values (1,'pengziyang@gmail.com','ae38f3e59310c930f2f9ebcfc9497499','Y');
insert  into `admin`(`admin_id`,`email`,`password`,`active`) values (2,'rosevoip@gmail.com','ae38f3e59310c930f2f9ebcfc9497499','Y');

/*Table structure for table `call_log` */

CREATE TABLE `call_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(50) NOT NULL,
  `call_number` varchar(50) NOT NULL,
  `destination` varchar(50) DEFAULT NULL,
  `timestamp` datetime NOT NULL,
  `duration` time NOT NULL,
  `base_rate` double NOT NULL,
  `charge` double NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `call_log` */

/*Table structure for table `client` */

CREATE TABLE `client` (
  `client_id` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `add_1` varchar(50) DEFAULT NULL,
  `add_2` varchar(50) DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'EUR',
  `balance` double(10,2) NOT NULL DEFAULT '0.00',
  `margin` double(10,2) NOT NULL DEFAULT '0.50',
  `active` char(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`client_id`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `client` */

/*Table structure for table `payment` */

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(50) NOT NULL,
  `timestamp` datetime NOT NULL,
  `amount` double(10,2) NOT NULL DEFAULT '0.00',
  `actual_cost` double(10,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(100) DEFAULT NULL,
  `remark` text,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `payment` */

/*Table structure for table `rate` */

CREATE TABLE `rate` (
  `destination` varchar(50) DEFAULT NULL,
  `rate` double DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rate` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
