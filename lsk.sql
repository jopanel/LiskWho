/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : localhost
 Source Database       : lsk

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : utf-8

 Date: 11/26/2017 22:06:08 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `activity`
-- ----------------------------
DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `activity` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `did` (`did`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `activity` (`activity`) USING BTREE,
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `addresses`
-- ----------------------------
DROP TABLE IF EXISTS `addresses`;
CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `address_id` int(24) NOT NULL,
  `confirmed` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `approval`
-- ----------------------------
DROP TABLE IF EXISTS `approval`;
CREATE TABLE `approval` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(11) NOT NULL,
  `weight` bigint(20) NOT NULL,
  `approval` float NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `did` (`did`) USING BTREE,
  KEY `weight` (`weight`) USING BTREE,
  KEY `approval` (`approval`) USING BTREE,
  KEY `created` (`created`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6032 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `comments`
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `delegate_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `ip` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `delegates`
-- ----------------------------
DROP TABLE IF EXISTS `delegates`;
CREATE TABLE `delegates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delegate` varchar(255) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `address_id` varchar(255) NOT NULL,
  `description` longtext,
  `short_description` varchar(255) DEFAULT NULL,
  `grp` varchar(255) NOT NULL DEFAULT 'independent',
  `rewards` float NOT NULL DEFAULT '0',
  `weight` bigint(20) NOT NULL,
  `json_data` longtext,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE,
  KEY `delegate` (`delegate`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `address_id` (`address_id`) USING BTREE,
  KEY `grp` (`grp`) USING BTREE,
  KEY `rewards` (`rewards`) USING BTREE,
  KEY `weight` (`weight`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6032 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `karma`
-- ----------------------------
DROP TABLE IF EXISTS `karma`;
CREATE TABLE `karma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(11) NOT NULL,
  `karma` float NOT NULL,
  `ip` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `did` (`did`) USING BTREE,
  KEY `karma` (`karma`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `updated`
-- ----------------------------
DROP TABLE IF EXISTS `updated`;
CREATE TABLE `updated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_update` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE,
  KEY `last_update` (`last_update`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `verification_key` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  `last_login` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
