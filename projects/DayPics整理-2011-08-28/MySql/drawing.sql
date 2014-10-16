/*
Navicat MySQL Data Transfer

Source Server         : ThinkPHP
Source Server Version : 50045
Source Host           : localhost:3306
Source Database       : daypics

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2011-10-05 00:34:55
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `drawing`
-- ----------------------------
DROP TABLE IF EXISTS `drawing`;
CREATE TABLE `drawing` (
  `id` int(5) NOT NULL auto_increment,
  `imgname` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `descript` varchar(300) NOT NULL,
  `folder` varchar(50) NOT NULL,
  `foldername` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of drawing
-- ----------------------------
INSERT INTO drawing VALUES ('1', 'baiduDownload_collapse.jpg', '下载-折叠面板', '', '01baidu', '百度实习');
INSERT INTO drawing VALUES ('2', 'baiduIME.jpg', '输入法默认皮肤', '', '01baidu', '百度实习');
INSERT INTO drawing VALUES ('3', 'baiduIME_banner.jpg', '输入法banner', '', '01baidu', '百度实习');
INSERT INTO drawing VALUES ('4', 'baiduIME_elements.jpg', '输入法元素', '', '01baidu', '百度实习');
INSERT INTO drawing VALUES ('5', 'baiduSky_1.jpg', '百度天空软件_1', '', '01baidu', '百度实习');
INSERT INTO drawing VALUES ('6', 'baiduSky_2.jpg', '百度天空软件_2', '', '01baidu', '百度实习');
INSERT INTO drawing VALUES ('7', 'baiduSky_3.jpg', '百度天空软件_3', '', '01baidu', '百度实习');
INSERT INTO drawing VALUES ('8', 'baiduSky_all.jpg', '百度天空软件', '', '01baidu', '百度实习');
INSERT INTO drawing VALUES ('9', 'baiduZip_alerticon.jpg', '百度压缩icon', '', '01baidu', '百度实习');
INSERT INTO drawing VALUES ('10', 'baiduZip_compress.jpg', '压缩界面', '', '01baidu', '百度实习');
INSERT INTO drawing VALUES ('11', 'baiduZip_contextmenu.jpg', '右键菜单', '', '01baidu', '百度实习');
INSERT INTO drawing VALUES ('12', 'baiduZip_depress.jpg', '解压界面', '', '01baidu', '百度实习');
INSERT INTO drawing VALUES ('13', 'prc_01.jpg', '荧光塑料棒', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('14', 'prc_02.jpg', '绿意logo', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('15', 'prc_03.jpg', '彩虹壁纸', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('16', 'prc_04.jpg', '花纹', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('17', 'prc_05.jpg', '手机按键', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('18', 'prc_06.jpg', '手机菜单', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('19', 'prc_07.jpg', '蓝翡翠', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('20', 'prc_08.jpg', 'OPhone', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('21', 'prc_09.jpg', '3D按钮', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('22', 'prc_10.jpg', '小Q', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('23', 'prc_11.jpg', '网页菜单', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('24', 'prc_12.jpg', 'Android按钮', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('25', 'prc_13.jpg', '方向-海报', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('26', 'prc_14.jpg', 'PS logo', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('27', 'prc_15.jpg', '吾家-海报', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('28', 'prc_16.jpg', '南美风格-乱吉他', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('29', 'prc_17.jpg', '手机icon-短信', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('30', 'prc_18.jpg', '魔兽争霸-按钮', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('31', 'prc_19.jpg', '垂涎欲滴', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('32', 'prc_20.jpg', '经典荧光按钮', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('33', 'prc_21.jpg', '光线', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('34', 'prc_22.jpg', '仿PS logo', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('35', 'prc_23.jpg', '表盘-未完成', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('36', 'prc_24.jpg', '水滴对比', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('37', 'prc_25.jpg', '播放器面板-部分', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('38', 'prc_26.jpg', '金属搜索框', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('39', 'prc_27.jpg', '蓝宝石按钮', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('40', 'prc_28.jpg', 'PS游戏手柄', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('41', 'prc_29.jpg', '玻璃透明-按钮', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('42', 'prc_30.jpg', 'Apple iMac', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('43', 'prc_31.jpg', '小尺寸图标', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('44', 'prc_32.jpg', 'Android icons', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('45', 'prc_33.jpg', '山寨暴风影音', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('46', 'prc_34.jpg', 'Android摄像机', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('47', 'prc_35.jpg', 'iCloud', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('48', 'prc_36.jpg', 'iPhone5畅想', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('49', 'prc_37.jpg', '像素画和文字', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('50', 'prc_38.jpg', '光照物理图', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('51', 'prc_39.jpg', '安装包', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('52', 'prc_40.jpg', '琢玉', '', '02practice', '闲暇涂鸦');
INSERT INTO drawing VALUES ('53', 'PCManager_black.jpg', '电脑管家icon_黑', '', '03exam', '百度笔试');
INSERT INTO drawing VALUES ('54', 'PCManager_white.jpg', '电脑管家icon_白', '', '03exam', '百度笔试');
INSERT INTO drawing VALUES ('55', 'Zoom.jpg', '放大镜', '', '03exam', '百度笔试');
INSERT INTO drawing VALUES ('56', 'learning_cup.jpg', 'icon临摹', '', '04tencent', '腾讯实习');
INSERT INTO drawing VALUES ('57', 'QQDict_1.jpg', 'QQDict logo_1', '', '04tencent', '腾讯实习');
INSERT INTO drawing VALUES ('58', 'QQDict_2.jpg', 'QQDict logo_2', '', '04tencent', '腾讯实习');
INSERT INTO drawing VALUES ('59', 'QQDict_3.jpg', 'QQDict logo_3', '', '04tencent', '腾讯实习');
INSERT INTO drawing VALUES ('60', 'QQDict_4.jpg', 'QQDict logo_4', '', '04tencent', '腾讯实习');
INSERT INTO drawing VALUES ('61', '2-9_1.jpg', '高中黑板报-图', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('62', '2-9_2.jpg', '高中黑板报-实例', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('63', '2-9_3.jpg', '高中班服-logo', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('64', '2-9_4.jpg', '高中班服-照片', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('65', 'iss-10_1.jpg', '大学班服-logo', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('66', 'iss-10_2.jpg', '大西班服-照片', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('67', 'my_name.jpg', '我的签名', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('68', 'nagasawa_1.jpg', '日式漫画-原稿', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('69', 'nagasawa_2.jpg', '日式漫画-PS上色', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('70', 'nagasawa_3.jpg', '日式漫画-风格化', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('71', 'paint_howl_1.jpg', '哈尔移动城-线稿', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('72', 'paint_howl_2.jpg', '哈尔移动城-完成', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('73', 'paint_howl_3.jpg', '哈尔移动城-后期', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('74', 'paint_mononoke_1.jpg', '幽灵公主-线稿', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('75', 'paint_mononoke_2.jpg', '幽灵公主-完成', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('76', 'paint_mononoke_3.jpg', '幽灵公主-后期', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('77', 'paint_ponyo_1.jpg', '金鱼公主-线稿', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('78', 'paint_ponyo_2.jpg', '金鱼公主-完成', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('79', 'paint_ponyo_3.jpg', '金鱼公主-后期', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('80', 'sketch_1.jpg', '素描-仿EVA', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('81', 'sketch_2.jpg', '素描-Jay', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('82', 'sketch_3.jpg', '素描-USHIDAKA', '', '05draw', '鼠绘作品');
INSERT INTO drawing VALUES ('83', 'sketch_4.jpg', '素描-KIKI', '', '05draw', '鼠绘作品');
