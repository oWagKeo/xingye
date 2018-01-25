/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : xingye

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-01-25 10:11:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sd_qqyy
-- ----------------------------
DROP TABLE IF EXISTS `sd_qqyy`;
CREATE TABLE `sd_qqyy` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `phone` varchar(15) NOT NULL DEFAULT '' COMMENT '手机号',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sd_qqyy
-- ----------------------------

-- ----------------------------
-- Table structure for sd_xhs
-- ----------------------------
DROP TABLE IF EXISTS `sd_xhs`;
CREATE TABLE `sd_xhs` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `phone` varchar(15) NOT NULL DEFAULT '' COMMENT '手机号',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sd_xhs
-- ----------------------------
