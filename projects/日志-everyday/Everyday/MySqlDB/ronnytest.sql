/*
Navicat MySQL Data Transfer

Source Server         : ThinkPHP
Source Server Version : 50045
Source Host           : localhost:3306
Source Database       : ronnytest

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2010-10-31 22:08:33
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `think_attribute_content`
-- ----------------------------
DROP TABLE IF EXISTS `think_attribute_content`;
CREATE TABLE `think_attribute_content` (
  `aid` int(6) NOT NULL auto_increment,
  `eventid` int(6) NOT NULL,
  `content` varchar(10000) default NULL,
  `attributeid` int(8) NOT NULL,
  PRIMARY KEY  (`aid`),
  KEY `content_attr` (`attributeid`),
  KEY `attr_evt` (`eventid`),
  CONSTRAINT `attr_evt` FOREIGN KEY (`eventid`) REFERENCES `think_userevent` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `content_attr` FOREIGN KEY (`attributeid`) REFERENCES `think_category_attributes` (`attrid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_attribute_content
-- ----------------------------

-- ----------------------------
-- Table structure for `think_category`
-- ----------------------------
DROP TABLE IF EXISTS `think_category`;
CREATE TABLE `think_category` (
  `cid` int(6) NOT NULL auto_increment,
  `uid` int(5) NOT NULL,
  `categoryname` varchar(10) NOT NULL,
  `count` int(5) NOT NULL,
  PRIMARY KEY  (`cid`),
  KEY `cate_user` (`uid`),
  CONSTRAINT `cate_user` FOREIGN KEY (`uid`) REFERENCES `think_user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_category
-- ----------------------------

-- ----------------------------
-- Table structure for `think_category_attributes`
-- ----------------------------
DROP TABLE IF EXISTS `think_category_attributes`;
CREATE TABLE `think_category_attributes` (
  `attrid` int(8) NOT NULL auto_increment,
  `categoryid` int(6) NOT NULL,
  `ctrl_type` varchar(20) NOT NULL,
  `name` varchar(40) NOT NULL,
  `label` varchar(500) NOT NULL,
  `fill` int(1) NOT NULL,
  PRIMARY KEY  (`attrid`),
  KEY `attr_cate` (`categoryid`),
  CONSTRAINT `attr_cate` FOREIGN KEY (`categoryid`) REFERENCES `think_category` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_category_attributes
-- ----------------------------

-- ----------------------------
-- Table structure for `think_user`
-- ----------------------------
DROP TABLE IF EXISTS `think_user`;
CREATE TABLE `think_user` (
  `uid` int(5) NOT NULL auto_increment,
  `uaccount` varchar(100) NOT NULL,
  `upassword` varchar(100) NOT NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_user
-- ----------------------------

-- ----------------------------
-- Table structure for `think_userevent`
-- ----------------------------
DROP TABLE IF EXISTS `think_userevent`;
CREATE TABLE `think_userevent` (
  `id` int(6) NOT NULL auto_increment,
  `date` date NOT NULL,
  `title` varchar(200) NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `categoryid` int(6) NOT NULL,
  `userid` int(5) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `u_id` USING BTREE (`userid`),
  KEY `event_cate` (`categoryid`),
  CONSTRAINT `event_cate` FOREIGN KEY (`categoryid`) REFERENCES `think_category` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `event_user` FOREIGN KEY (`userid`) REFERENCES `think_user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_userevent
-- ----------------------------
DELIMITER ;;
CREATE TRIGGER `count_change` AFTER INSERT ON `think_userevent` FOR EACH ROW UPDATE think_category SET count=(SELECT COUNT(*) FROM think_userevent WHERE categoryid = NEW.categoryid) WHERE cid = NEW.categoryid
;;
DELIMITER ;
DELIMITER ;;
CREATE TRIGGER `count_change2` AFTER DELETE ON `think_userevent` FOR EACH ROW UPDATE think_category SET count=(SELECT COUNT(*) FROM think_userevent WHERE categoryid = OLD.categoryid) WHERE cid = OLD.categoryid
;;
DELIMITER ;
