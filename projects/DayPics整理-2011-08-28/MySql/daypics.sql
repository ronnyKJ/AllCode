/*
Navicat MySQL Data Transfer

Source Server         : ThinkPHP
Source Server Version : 50045
Source Host           : localhost:3306
Source Database       : daypics

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2011-08-29 21:04:55
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `pics`
-- ----------------------------
DROP TABLE IF EXISTS `pics`;
CREATE TABLE `pics` (
  `id` int(5) NOT NULL auto_increment,
  `filename` varchar(20) NOT NULL,
  `date` varchar(30) NOT NULL,
  `words` varchar(300) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pics
-- ----------------------------
INSERT INTO pics VALUES ('1', '20110825220349.jpg', '2011-06-23 15:42:56', 'abc');
INSERT INTO pics VALUES ('2', '20110825220402.jpg', '2011-07-01 11:57:57', ' 	 	1256是吧～～～');
INSERT INTO pics VALUES ('3', '20110826010643.jpg', '2011-08-26 01:06:43', ' 好漂亮～～～');
INSERT INTO pics VALUES ('4', '20110826123749.jpg', '2011-08-26 12:14:47', ' 小荷才露尖尖角，早有蜻蜓立上头。');
INSERT INTO pics VALUES ('5', '20110826140701.jpg', '2011-08-26 13:59:11', ' 耶岛的积分奖品～～');
INSERT INTO pics VALUES ('6', '20110826142401.jpg', '2011-08-26 13:59:11', ' 刚刚那张没有传上去…');
INSERT INTO pics VALUES ('7', '20110826151443.jpg', '2011-08-26 15:14:43', ' 	 	 	今天的星湖～～');
INSERT INTO pics VALUES ('8', '20110826182406.jpg', '2011-08-26 18:24:06', ' 	 	回家的时候拍的，黄冈河。');
INSERT INTO pics VALUES ('9', '20110826182551.jpg', '2011-08-14 23:25:07', '这是\n我的\n书架\n~~~~~');
INSERT INTO pics VALUES ('10', '20110827173510.jpg', '2011-08-27 17:33:40', '...好吧这个还要继续加油~~~我在小龙这边试一下。');
INSERT INTO pics VALUES ('11', '20110827183922.jpg', '2011-08-27 18:36:40', '中西悲剧之比。');
INSERT INTO pics VALUES ('12', '20110828141341.jpg', '2011-08-28 14:12:49', '阿飞～');
INSERT INTO pics VALUES ('13', '20110828195401.jpg', '2011-08-28 18:34:01', '条纹～～');
INSERT INTO pics VALUES ('14', '20110828202209.jpg', '2011-08-26 12:23:15', '剪头发前…');
INSERT INTO pics VALUES ('15', '20110828212018.jpg', '2011-08-10 14:58:47', 'cctigjitiidiciv\nifcitcjggvt\ncifjjfu\ntidicu\nhhgvuuj\ngbikmuoujjij');
INSERT INTO pics VALUES ('16', '20110828222517.jpg', '2011-08-28 22:24:25', '这是小龙～～～');
INSERT INTO pics VALUES ('17', '20110829002217.jpg', '2011-08-29 00:20:32', '面朝大海，春暖花开～');
INSERT INTO pics VALUES ('18', '20110829002709.jpg', '2011-08-29 00:27:09', '这是用布丁相机拍的～～\n从家里回来武汉，花了一个星期的时间，写了一个系统，算是快速开发吧，很有充实的感觉，终于可以睡个好觉了，明天可以出去学习，顺便准备一下找工作的事情～');

-- ----------------------------
-- Table structure for `viewcount`
-- ----------------------------
DROP TABLE IF EXISTS `viewcount`;
CREATE TABLE `viewcount` (
  `id` int(6) NOT NULL auto_increment,
  `ip` varchar(20) default NULL,
  `time` datetime NOT NULL,
  `count` int(6) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of viewcount
-- ----------------------------
INSERT INTO viewcount VALUES ('7', '27.18.151.152', '2011-08-28 02:08:45', '39');
INSERT INTO viewcount VALUES ('8', '117.136.23.113', '2011-08-27 23:08:19', '1');
INSERT INTO viewcount VALUES ('9', '127.0.0.1', '2011-08-29 21:08:39', '9');
INSERT INTO viewcount VALUES ('10', '192.168.1.101', '2011-08-28 12:08:27', '1');
INSERT INTO viewcount VALUES ('11', '27.18.149.91', '2011-08-28 13:08:30', '2');
INSERT INTO viewcount VALUES ('12', '27.17.132.55', '2011-08-28 14:08:50', '5');
INSERT INTO viewcount VALUES ('13', '192.168.1.103', '2011-08-28 13:08:25', '2');
INSERT INTO viewcount VALUES ('14', '27.18.148.167', '2011-08-29 00:08:15', '45');
