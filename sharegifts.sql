/*
Navicat MySQL Data Transfer

Source Server         : Homestead
Source Server Version : 50709
Source Host           : 172.168.10.11:3306
Source Database       : sharegifts

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2016-05-04 08:41:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for gifts
-- ----------------------------
DROP TABLE IF EXISTS `gifts`;
CREATE TABLE `gifts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fb_id` bigint(20) DEFAULT NULL,
  `register_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unq_username` (`name`) USING BTREE,
  UNIQUE KEY `unq_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for users__gifts
-- ----------------------------
DROP TABLE IF EXISTS `users__gifts`;
CREATE TABLE `users__gifts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) unsigned NOT NULL,
  `receiver_id` int(10) unsigned NOT NULL,
  `gift_id` int(10) unsigned NOT NULL,
  `sent_at` int(11) NOT NULL,
  `claim_at` int(11) DEFAULT NULL,
  `expired_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `frn_sender_id` (`sender_id`),
  KEY `frn_receiver_id` (`receiver_id`),
  KEY `frn_gift_id` (`gift_id`),
  CONSTRAINT `frn_gift_id` FOREIGN KEY (`gift_id`) REFERENCES `gifts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `frn_receiver_id` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `frn_sender_id` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
