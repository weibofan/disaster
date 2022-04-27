/*
Navicat MySQL Data Transfer

Source Server         : disaster
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : think

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2022-01-29 20:27:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for conduct
-- ----------------------------
DROP TABLE IF EXISTS `conduct`;
CREATE TABLE `conduct` (
  `user_id` int(11) NOT NULL,
  `help_id` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`help_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of conduct
-- ----------------------------
INSERT INTO `conduct` VALUES ('68', '68', '1640429665', '1640429665', null);
INSERT INTO `conduct` VALUES ('68', '69', '1640429575', '1640429575', null);
INSERT INTO `conduct` VALUES ('69', '62', '1640426468', '1640426468', null);
INSERT INTO `conduct` VALUES ('70', '62', '1640427153', '1640427153', null);
INSERT INTO `conduct` VALUES ('70', '63', '1640427111', '1640427111', null);
INSERT INTO `conduct` VALUES ('70', '64', '1640427123', '1640427123', null);
INSERT INTO `conduct` VALUES ('70', '65', '1640427117', '1640427117', null);

-- ----------------------------
-- Table structure for helpinfo
-- ----------------------------
DROP TABLE IF EXISTS `helpinfo`;
CREATE TABLE `helpinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL,
  `position` varchar(50) DEFAULT '',
  `mobile` varchar(20) DEFAULT '',
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT '',
  `content` varchar(255) DEFAULT '',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `clicks` bigint(20) unsigned zerofill NOT NULL,
  `helpcounts` bigint(20) unsigned zerofill NOT NULL,
  `long` decimal(10,7) DEFAULT NULL,
  `lati` decimal(10,7) DEFAULT NULL,
  `needtype` int(10) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of helpinfo
-- ----------------------------
INSERT INTO `helpinfo` VALUES ('62', '2', '上海市黄浦区威海路48号中国民生银行大厦(威海路)', '123456789', '68', '小A', '地震了求物资！！', '1640426232', '1640426232', null, '00000000000000000004', '00000000000000000002', '121.4703320', '31.2284480', '0000000002');
INSERT INTO `helpinfo` VALUES ('63', '3', '新疆维吾尔自治区巴音郭楞蒙古自治州轮台县阿来郎', '222222222', '68', '小A', '发现新疫情对象！！！', '1640426376', '1640426376', null, '00000000000000000005', '00000000000000000002', '85.0131600', '41.4576800', '0000000003');
INSERT INTO `helpinfo` VALUES ('64', '3', '江西省南昌市新建区新建区厚田村', '111111111', '69', '小B', '新疫情传染！！求救！！', '1640426583', '1640426583', null, '00000000000000000003', '00000000000000000001', '115.8008684', '28.4608970', '0000000001');
INSERT INTO `helpinfo` VALUES ('65', '1', '浙江省温州市鹿城区G330温州长伦制衣厂', '111111111', '69', '小B', '台风求救！！', '1640426667', '1640426667', null, '00000000000000000001', '00000000000000000001', '120.5047100', '28.1287800', '0000000001');
INSERT INTO `helpinfo` VALUES ('66', '1', '江苏省南通市如东县如东县丰利镇野人庄', '123456789', '70', '小C', '求台风物资！！！', '1640427072', '1640427072', null, '00000000000000000005', '00000000000000000000', '121.0667767', '32.4534030', '0000000002');
INSERT INTO `helpinfo` VALUES ('67', '1', '福建省福州市闽侯县X111闽侯县洋里乡刘村', '123123123', '71', '小D', '遇到台风，求助！！', '1640429068', '1640429068', null, '00000000000000000000', '00000000000000000000', '118.9970984', '26.3253915', '0000000001');
INSERT INTO `helpinfo` VALUES ('68', '1', '山东省烟台市招远市招远市张星镇风会山', '123123123', '71', '小D', '台风！', '1640429256', '1640429256', null, '00000000000000000002', '00000000000000000001', '120.4190983', '37.4993492', '0000000003');
INSERT INTO `helpinfo` VALUES ('69', '1', '辽宁省沈阳市浑南区全运三路浑南区府城铭邸东南(全运三路)', '123123', '71', '小D', '台风求救11111', '1640429443', '1640429443', null, '00000000000000000002', '00000000000000000001', '123.4419264', '41.6795857', '0000000003');

-- ----------------------------
-- Table structure for newsinfo
-- ----------------------------
DROP TABLE IF EXISTS `newsinfo`;
CREATE TABLE `newsinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `imgurl` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of newsinfo
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `score` int(11) unsigned zerofill NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('68', 'oAMaI6BbO93LYhzLW5LGOE5eJR9Y', 'Ashleigh', '00000000000', null, '1640423298', '1640429591');
INSERT INTO `user` VALUES ('69', 'oAMaI6PS6_iJJ2e2yn0BbDssvON0', '白', '00000000001', null, '1640426445', '1640426451');
INSERT INTO `user` VALUES ('70', 'oAMaI6AWu9rJQrfzNY1Bxf3dAH0Q', '真正的与众不同', '00000000000', null, '1640427005', '1640427012');
INSERT INTO `user` VALUES ('71', 'oAMaI6P2cYlUbY8q-jU4Ow9VXAQk', 'Dr.', '00000000000', null, '1640428626', '1640428655');

-- ----------------------------
-- Table structure for user_address
-- ----------------------------
DROP TABLE IF EXISTS `user_address`;
CREATE TABLE `user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delete_time` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT '外键',
  `update_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `posname` varchar(50) DEFAULT NULL,
  `pos` varchar(30) DEFAULT NULL,
  `long` decimal(20,16) DEFAULT NULL,
  `lati` decimal(20,16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of user_address
-- ----------------------------
INSERT INTO `user_address` VALUES ('41', null, '68', '1640426373', '1640426208', '阿来郎', '新疆维吾尔自治区巴音郭楞蒙古自治州轮台县', '85.0131600000000000', '41.4576800000000000');
INSERT INTO `user_address` VALUES ('42', null, '69', '1640426644', '1640426556', '温州长伦制衣厂', '浙江省温州市鹿城区G330', '120.5047100000000000', '28.1287800000000000');
INSERT INTO `user_address` VALUES ('43', null, '70', '1640427052', '1640427052', '如东县丰利镇野人庄', '江苏省南通市如东县', '121.0667767059326100', '32.4534030166679500');
INSERT INTO `user_address` VALUES ('44', null, '71', '1640429407', '1640429004', '浑南区府城铭邸东南(全运三路)', '辽宁省沈阳市浑南区全运三路', '123.4419264328002900', '41.6795857489527300');
