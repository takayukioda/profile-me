CREATE DATABASE `profileme`;

GRANT ALL PRIVILEGES
ON `profileme`.*
TO 'profileme'@'localhost'
IDENTIFIED BY 'profile';

use `profileme`;

DROP TABLE IF EXISTS `profileme`.`users`;
CREATE TABLE `users` (
	`id` int NOT NULL AUTO_INCREMENT,
	`username` varchar(100) NOT NULL,
	`mail` varchar(255) NOT NULL,
	`password` varchar(255) NOT NULL,
	`profile` text DEFAULT NULL,
	`created_at` datetime NOT NULL,
	`updated_at` datetime NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY (`mail`)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 ;

DROP TABLE IF EXISTS `profileme`.`accounts`;
CREATE TABLE `accounts` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`service_id` int NOT NULL,
	`service_userid` bigint DEFAULT NULL,
	`service_username` varchar(255) NOT NULL,
	`url` varchar(255) DEFAULT NULL,
	`created_at` datetime NOT NULL,
	`updated_at` datetime NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY (`user_id`, `service_id`)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 ;

DROP TABLE IF EXISTS `profileme`.`services`;
CREATE TABLE `services` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`url` varchar (255) NOT NULL,
	`created_at` datetime NOT NULL,
	`updated_at` datetime NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY (`name`)
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 ;
INSERT INTO `profileme`.`services` (`name`, `url`) VALUES
('Google', 'https://google.com'),
('Twitter', 'https://twitter.com'),
('Facebook', 'https://facebook.com'),
('GitHub', 'https://github.com'),
('LINE', 'https://line.me'),
('About Me', 'https://about.me')
;
