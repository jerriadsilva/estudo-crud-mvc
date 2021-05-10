/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MariaDB
 Source Server Version : 100418
 Source Host           : localhost:3306
 Source Schema         : crud_test

 Target Server Type    : MariaDB
 Target Server Version : 100418
 File Encoding         : 65001

 Date: 06/05/2021 15:24:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created` timestamp(0) NULL DEFAULT current_timestamp,
  `updated` timestamp(0) NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `level` smallint(6) NULL DEFAULT 0,
  `passwd` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
