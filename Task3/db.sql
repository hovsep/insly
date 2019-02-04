/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.24-0ubuntu0.18.04.1 : Database - insly_task3
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `employees` */

/*Table is denormalized for better performance*/
CREATE TABLE `employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `ssn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_current` tinyint(1) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intro_en` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_experience_en` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `education_en` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `intro_fr` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_experience_fr` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `education_fr` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `intro_es` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_experience_es` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `education_es` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_ssn_unique` (`ssn`),
  UNIQUE KEY `employees_email_unique` (`email`),
  UNIQUE KEY `employees_phone_unique` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `employees` */

insert  into `employees`(`id`,`name`,`birthday`,`ssn`,`is_current`,`email`,`phone`,`address`,`intro_en`,`work_experience_en`,`education_en`,`intro_fr`,`work_experience_fr`,`education_fr`,`intro_es`,`work_experience_es`,`education_es`,`created_at`,`updated_at`) values (1,'Hovsep Avakyan','1991-03-12','0000000001',1,'avakyan.hovsep@yandex.ru','+79081706915','Rostov on Don','Hi there!','7+ years in software engineering','BS and MS','intro fr','work experience fr','education fr','intro es','work experience es','education es',NULL,NULL);

/*Table structure for table `log` */

CREATE TABLE `log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'create or update',
  `user_id` int(10) unsigned NOT NULL,
  `employee_id` int(10) unsigned NOT NULL COMMENT 'No FK, so we will keep log even after employee is deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
