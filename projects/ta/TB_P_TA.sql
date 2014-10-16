/*
Navicat MySQL Data Transfer

Source Server         : ronny-i
Source Server Version : 50081
Source Host           : us11phmyadmini.us11.usf57.com:3306
Source Database       : ronnykj

Target Server Type    : MYSQL
Target Server Version : 50081
File Encoding         : 65001

Date: 2012-02-13 22:04:14
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `tb_p_ta`
-- ----------------------------
DROP TABLE IF EXISTS `tb_p_ta`;
CREATE TABLE `tb_p_ta` (
  `MY_NAME` varchar(10) NOT NULL,
  `MY_BIRTHDAY` varchar(6) NOT NULL,
  `TA_NAME` varchar(10) NOT NULL,
  `TA_BIRTHDAY` varchar(6) NOT NULL,
  `UPDATE_TIME` datetime NOT NULL,
  `RELATION_ID` varchar(20) NOT NULL,
  `RES_PARAM1` varchar(50) default NULL,
  `RES_PARAM2` varchar(50) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_p_ta
-- ----------------------------
