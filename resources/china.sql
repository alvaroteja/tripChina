/*
 Navicat Premium Dump SQL

 Source Server         : alvaro
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : trips

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 04/03/2025 21:24:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for china
-- ----------------------------
DROP TABLE IF EXISTS `china`;
CREATE TABLE `china`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `gasto` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tipo` enum('Compras','Alcohol','Comida','Gifts') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Compras',
  `monto` decimal(10, 2) NOT NULL,
  `ocultar` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of china
-- ----------------------------
INSERT INTO `china` VALUES (29, '2025-03-04 20:37:59', 'aaa', '', 100.00, 0);
INSERT INTO `china` VALUES (30, '2025-03-04 20:40:13', 'b', 'Compras', 10.10, 0);
INSERT INTO `china` VALUES (31, '2025-03-04 20:41:37', 'q', 'Compras', 50.12, 0);
INSERT INTO `china` VALUES (32, '2025-03-04 20:42:27', 'asd', 'Compras', 123.00, 1);

SET FOREIGN_KEY_CHECKS = 1;
