/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MariaDB
 Source Server Version : 100418
 Source Host           : localhost:3306
 Source Schema         : crud_mvc

 Target Server Type    : MariaDB
 Target Server Version : 100418
 File Encoding         : 65001

 Date: 11/05/2021 17:32:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for produtos
-- ----------------------------
DROP TABLE IF EXISTS `produtos`;
CREATE TABLE `produtos`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created` timestamp(0) NULL DEFAULT current_timestamp,
  `updated` timestamp(0) NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `descricao` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `valor` decimal(6, 0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produtos
-- ----------------------------
INSERT INTO `produtos` VALUES (6, '2021-05-11 13:59:14', '2021-05-11 15:08:11', 'Produto 1', 'Descrição do produto 1', 112);
INSERT INTO `produtos` VALUES (7, '2021-05-11 14:00:46', '2021-05-11 17:29:15', 'Produto 2', 'Descrição do produto 2', 120);
INSERT INTO `produtos` VALUES (8, '2021-05-11 14:01:14', '2021-05-11 15:08:21', 'Produto 3', 'Descrição do produto 3', 120);

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created` timestamp(0) NULL DEFAULT current_timestamp,
  `updated` timestamp(0) NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `admin` bit(1) NULL DEFAULT b'0',
  `passwd` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (3, '2021-05-10 14:51:44', '2021-05-11 09:29:34', 'Jerri Dick', 'email@gmail.com', b'1', '$2y$10$5ydZbPaEHSuGguPMpQxgfOAdbla3dgvdIF8URK1/AUvWQEp4bbRFq');
INSERT INTO `usuarios` VALUES (4, '2021-05-10 16:48:46', '2021-05-11 17:12:45', 'teste novo', 'email2@gmail.com', b'0', '');
INSERT INTO `usuarios` VALUES (5, '2021-05-10 16:49:32', '2021-05-11 09:28:11', 'teste usuario 2', 'email3@gmail.com', b'0', '$2y$10$8jVX6oE25e3YIxThORDRzevQ8xNhxmxUKJUOB/98DH./3KPBTsrfG');

SET FOREIGN_KEY_CHECKS = 1;
