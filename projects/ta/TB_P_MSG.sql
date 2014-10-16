/*
Navicat MySQL Data Transfer

Source Server         : ronny-i
Source Server Version : 50081
Source Host           : us11phmyadmini.us11.usf57.com:3306
Source Database       : ronnykj

Target Server Type    : MYSQL
Target Server Version : 50081
File Encoding         : 65001

Date: 2012-02-13 22:02:30
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `tb_p_msg`
-- ----------------------------
DROP TABLE IF EXISTS `tb_p_msg`;
CREATE TABLE `tb_p_msg` (
  `RELATION_ID` varchar(20) NOT NULL,
  `MESSAGE_CONTENT` varchar(500) NOT NULL,
  `UPDATE_TIME` datetime NOT NULL,
  `RES_PARAM1` varchar(50) default NULL,
  `RES_PARAM2` varchar(50) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_p_msg
-- ----------------------------
