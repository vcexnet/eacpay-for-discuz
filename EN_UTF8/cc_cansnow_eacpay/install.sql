SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cdb_eacpay_address
-- ----------------------------
DROP TABLE IF EXISTS `cdb_eacpay_address`;
CREATE TABLE `cdb_eacpay_address`  (
  `uid` mediumint(11) NOT NULL,
  `address` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  INDEX `plid`(`address`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cdb_eacpay_order
-- ----------------------------
DROP TABLE IF EXISTS `cdb_eacpay_order`;
CREATE TABLE `cdb_eacpay_order`  (
  `uid` mediumint(11) NOT NULL,
  `order_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `amount` float(10, 4) NULL DEFAULT 0.0000,
  `eac` float(10, 4) NULL DEFAULT 0.0000,
  `real_eac` float(10, 4) NULL DEFAULT 0.0000,
  `address` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `block_height` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` int(11) NULL DEFAULT 0,
  `pay_time` int(11) NULL DEFAULT 0,
  `last_time` int(11) NULL DEFAULT 0,
  `status` enum('cancel','reject','wait','complete','payed') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` enum('recharge','cash') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`) USING BTREE,
  INDEX `plid`(`order_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
