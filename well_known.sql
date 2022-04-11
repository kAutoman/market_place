/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100422
 Source Host           : localhost:3306
 Source Schema         : well_known

 Target Server Type    : MySQL
 Target Server Version : 100422
 File Encoding         : 65001

 Date: 11/04/2022 16:58:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bans
-- ----------------------------
DROP TABLE IF EXISTS `bans`;
CREATE TABLE `bans`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bannable_id` int(11) NULL DEFAULT NULL,
  `bannable_type` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  `created_by_type` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `created_by_id` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bans
-- ----------------------------
INSERT INTO `bans` VALUES (1, 66, 'App\\Models\\User', '2022-04-08 16:15:34', NULL, 'App\\Models\\User', '72', '2022-04-08 16:15:34');

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `order` int(11) NULL DEFAULT 1,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pricing_models` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `categories_parent_id_foreign`(`parent_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (4, 0, 1, 'Weaponry', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (5, 0, 1, 'Counterfeit items', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (6, 0, 1, 'Apparel', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (7, 0, 1, 'Art', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (8, 0, 1, 'Books', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (9, 0, 1, 'Computer equipment', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (10, 0, 1, 'Custom orders', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (11, 0, 1, 'Electronics', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (12, 0, 1, 'Erotica', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (13, 0, 1, 'Drug parahernalia', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (15, 2, 1, 'Henk', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (16, 2, 1, 'Test 1', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (17, 2, 1, 'Test 2', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (18, 2, 1, 'Test 3', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (19, 2, 1, 'Test 3', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (20, 3, 1, 'Testa 1', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (21, 3, 1, 'Testa 2', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (22, 3, 1, 'Testa 3', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (23, 3, 1, 'Testa 3', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (25, 4, 1, 'Testb 00', NULL, '2022-04-10 23:44:18', NULL, NULL, NULL);
INSERT INTO `categories` VALUES (26, 4, 1, 'Testb 3', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (27, 4, 1, 'Testb 300', NULL, '2022-04-10 23:44:27', NULL, NULL, NULL);
INSERT INTO `categories` VALUES (28, 5, 1, 'Testa 1c', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (29, 54, 1, 'Testa 2c', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (30, 5, 1, 'Testa 3c', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (31, 5, 1, 'Testa 3c', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (32, 6, 1, 'Testa 1d', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (33, 6, 1, 'Testa 2d', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (34, 6, 1, 'Testa 3d', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (35, 6, 1, 'Testa 3d', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (36, 7, 1, 'Testa 1e', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (37, 7, 1, 'Testa 2e', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (38, 7, 1, 'Testa 3e', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (39, 7, 1, 'Testa 3e', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (40, 12, 2, 'Automan', NULL, '2022-04-08 16:37:20', NULL, NULL, NULL);
INSERT INTO `categories` VALUES (41, 8, 1, 'Testa 2f', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (42, 8, 1, 'Testa 3f', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (43, 8, 1, 'Testa 3f', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (44, 9, 1, 'Testa 1g', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (45, 9, 1, 'Testa 2g', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (46, 9, 1, 'Testa 3g', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (47, 9, 1, 'Testa 3g', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (48, 10, 1, 'Testa 1h', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (49, 10, 1, 'Testa 2h', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (50, 10, 1, 'Testa 3h', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (51, 10, 1, 'Testa 3h', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (52, 11, 1, 'Testa 1i', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (53, 12, 1, 'Testa 2j', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (54, 13, 1, 'Testa 3k', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (56, 15, 1, 'Fuckyou9', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `categories` VALUES (57, 23, 1, 'Vladimir Yashin', '2022-04-08 16:53:03', '2022-04-08 16:53:03', NULL, 'vladimir-yashin', NULL);
INSERT INTO `categories` VALUES (58, 23, 1, 'Vladimir Yashin', '2022-04-08 16:53:52', '2022-04-08 16:53:52', NULL, 'vladimir-yashin', NULL);
INSERT INTO `categories` VALUES (59, 6, 1, 'new_category', '2022-04-11 03:43:37', '2022-04-11 03:43:37', NULL, 'new-category', NULL);
INSERT INTO `categories` VALUES (60, 37, 1, 'Vladimir Yashin', '2022-04-11 03:44:33', '2022-04-11 03:44:33', NULL, 'vladimir-yashin', NULL);
INSERT INTO `categories` VALUES (61, 5, 1, 'Vladimir Yashin', '2022-04-11 04:30:32', '2022-04-11 04:30:32', NULL, 'vladimir-yashin', NULL);
INSERT INTO `categories` VALUES (62, 5, 1, 'Vladimir Yashin', '2022-04-11 04:31:09', '2022-04-11 04:31:09', NULL, 'vladimir-yashin', NULL);
INSERT INTO `categories` VALUES (63, 5, 1, 'Vladimir Yashin', '2022-04-11 04:35:40', '2022-04-11 04:35:40', NULL, 'vladimir-yashin', NULL);

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `listing_id` int(11) NULL DEFAULT NULL,
  `seller_id` int(11) NULL DEFAULT NULL,
  `commenter_id` int(11) NULL DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 1,
  `rate` double(15, 8) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `comments_commentable_id_commentable_type_index`(`listing_id`) USING BTREE,
  INDEX `comments_commented_id_commented_type_index`(`commenter_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for conversations
-- ----------------------------
DROP TABLE IF EXISTS `conversations`;
CREATE TABLE `conversations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for countries
-- ----------------------------
DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_short_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_continent` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 260 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of countries
-- ----------------------------
INSERT INTO `countries` VALUES (1, 'Worldwide', 'WW', 1);
INSERT INTO `countries` VALUES (2, 'Europe', 'EU', 1);
INSERT INTO `countries` VALUES (3, 'Asia', 'Asia', 1);
INSERT INTO `countries` VALUES (4, 'United States', 'US', 0);
INSERT INTO `countries` VALUES (5, 'Afghanistan', 'AF', 0);
INSERT INTO `countries` VALUES (6, 'Åland Islands', 'AX', 0);
INSERT INTO `countries` VALUES (7, 'Albania', 'AL', 0);
INSERT INTO `countries` VALUES (8, 'Algeria', 'DZ', 0);
INSERT INTO `countries` VALUES (9, 'American Samoa', 'AS', 0);
INSERT INTO `countries` VALUES (10, 'Andorra', 'AD', 0);
INSERT INTO `countries` VALUES (11, 'Angola', 'AO', 0);
INSERT INTO `countries` VALUES (12, 'Anguilla', 'AI', 0);
INSERT INTO `countries` VALUES (13, 'Antarctica', 'AQ', 0);
INSERT INTO `countries` VALUES (14, 'Antigua & Barbuda', 'AG', 0);
INSERT INTO `countries` VALUES (15, 'Argentina', 'AR', 0);
INSERT INTO `countries` VALUES (16, 'Armenia', 'AM', 0);
INSERT INTO `countries` VALUES (17, 'Aruba', 'AW', 0);
INSERT INTO `countries` VALUES (18, 'Ascension Island', 'AC', 0);
INSERT INTO `countries` VALUES (19, 'Australia', 'AU', 1);
INSERT INTO `countries` VALUES (20, 'Austria', 'AT', 0);
INSERT INTO `countries` VALUES (21, 'Azerbaijan', 'AZ', 0);
INSERT INTO `countries` VALUES (22, 'Bahamas', 'BS', 0);
INSERT INTO `countries` VALUES (23, 'Bahrain', 'BH', 0);
INSERT INTO `countries` VALUES (24, 'Bangladesh', 'BD', 0);
INSERT INTO `countries` VALUES (25, 'Barbados', 'BB', 0);
INSERT INTO `countries` VALUES (26, 'Belarus', 'BY', 0);
INSERT INTO `countries` VALUES (27, 'Belgium', 'BE', 0);
INSERT INTO `countries` VALUES (28, 'Belize', 'BZ', 0);
INSERT INTO `countries` VALUES (29, 'Benin', 'BJ', 0);
INSERT INTO `countries` VALUES (30, 'Bermuda', 'BM', 0);
INSERT INTO `countries` VALUES (31, 'Bhutan', 'BT', 0);
INSERT INTO `countries` VALUES (32, 'Bolivia', 'BO', 0);
INSERT INTO `countries` VALUES (33, 'Bosnia & Herzegovina', 'BA', 0);
INSERT INTO `countries` VALUES (34, 'Botswana', 'BW', 0);
INSERT INTO `countries` VALUES (35, 'Brazil', 'BR', 0);
INSERT INTO `countries` VALUES (36, 'British Indian Ocean Territory', 'IO', 0);
INSERT INTO `countries` VALUES (37, 'British Virgin Islands', 'VG', 0);
INSERT INTO `countries` VALUES (38, 'Brunei', 'BN', 0);
INSERT INTO `countries` VALUES (39, 'Bulgaria', 'BG', 0);
INSERT INTO `countries` VALUES (40, 'Burkina Faso', 'BF', 0);
INSERT INTO `countries` VALUES (41, 'Burundi', 'BI', 0);
INSERT INTO `countries` VALUES (42, 'Cambodia', 'KH', 0);
INSERT INTO `countries` VALUES (43, 'Cameroon', 'CM', 0);
INSERT INTO `countries` VALUES (44, 'Canada', 'CA', 0);
INSERT INTO `countries` VALUES (45, 'Canary Islands', 'IC', 0);
INSERT INTO `countries` VALUES (46, 'Cape Verde', 'CV', 0);
INSERT INTO `countries` VALUES (47, 'Caribbean Netherlands', 'BQ', 0);
INSERT INTO `countries` VALUES (48, 'Cayman Islands', 'KY', 0);
INSERT INTO `countries` VALUES (49, 'Central African Republic', 'CF', 0);
INSERT INTO `countries` VALUES (50, 'Ceuta & Melilla', 'EA', 0);
INSERT INTO `countries` VALUES (51, 'Chad', 'TD', 0);
INSERT INTO `countries` VALUES (52, 'Chile', 'CL', 0);
INSERT INTO `countries` VALUES (53, 'China', 'CN', 0);
INSERT INTO `countries` VALUES (54, 'Christmas Island', 'CX', 0);
INSERT INTO `countries` VALUES (55, 'Cocos (Keeling) Islands', 'CC', 0);
INSERT INTO `countries` VALUES (56, 'Colombia', 'CO', 0);
INSERT INTO `countries` VALUES (57, 'Comoros', 'KM', 0);
INSERT INTO `countries` VALUES (58, 'Congo - Brazzaville', 'CG', 0);
INSERT INTO `countries` VALUES (59, 'Congo - Kinshasa', 'CD', 0);
INSERT INTO `countries` VALUES (60, 'Cook Islands', 'CK', 0);
INSERT INTO `countries` VALUES (61, 'Costa Rica', 'CR', 0);
INSERT INTO `countries` VALUES (62, 'Côte d’Ivoire', 'CI', 0);
INSERT INTO `countries` VALUES (63, 'Croatia', 'HR', 0);
INSERT INTO `countries` VALUES (64, 'Cuba', 'CU', 0);
INSERT INTO `countries` VALUES (65, 'Curaçao', 'CW', 0);
INSERT INTO `countries` VALUES (66, 'Cyprus', 'CY', 0);
INSERT INTO `countries` VALUES (67, 'Czechia', 'CZ', 0);
INSERT INTO `countries` VALUES (68, 'Denmark', 'DK', 0);
INSERT INTO `countries` VALUES (69, 'Diego Garcia', 'DG', 0);
INSERT INTO `countries` VALUES (70, 'Djibouti', 'DJ', 0);
INSERT INTO `countries` VALUES (71, 'Dominica', 'DM', 0);
INSERT INTO `countries` VALUES (72, 'Dominican Republic', 'DO', 0);
INSERT INTO `countries` VALUES (73, 'Ecuador', 'EC', 0);
INSERT INTO `countries` VALUES (74, 'Egypt', 'EG', 0);
INSERT INTO `countries` VALUES (75, 'El Salvador', 'SV', 0);
INSERT INTO `countries` VALUES (76, 'Equatorial Guinea', 'GQ', 0);
INSERT INTO `countries` VALUES (77, 'Eritrea', 'ER', 0);
INSERT INTO `countries` VALUES (78, 'Estonia', 'EE', 0);
INSERT INTO `countries` VALUES (79, 'Eswatini', 'SZ', 0);
INSERT INTO `countries` VALUES (80, 'Ethiopia', 'ET', 0);
INSERT INTO `countries` VALUES (81, 'Falkland Islands', 'FK', 0);
INSERT INTO `countries` VALUES (82, 'Faroe Islands', 'FO', 0);
INSERT INTO `countries` VALUES (83, 'Fiji', 'FJ', 0);
INSERT INTO `countries` VALUES (84, 'Finland', 'FI', 0);
INSERT INTO `countries` VALUES (85, 'France', 'FR', 0);
INSERT INTO `countries` VALUES (86, 'French Guiana', 'GF', 0);
INSERT INTO `countries` VALUES (87, 'French Polynesia', 'PF', 0);
INSERT INTO `countries` VALUES (88, 'French Southern Territories', 'TF', 0);
INSERT INTO `countries` VALUES (89, 'Gabon', 'GA', 0);
INSERT INTO `countries` VALUES (90, 'Gambia', 'GM', 0);
INSERT INTO `countries` VALUES (91, 'Georgia', 'GE', 0);
INSERT INTO `countries` VALUES (92, 'Germany', 'DE', 0);
INSERT INTO `countries` VALUES (93, 'Ghana', 'GH', 0);
INSERT INTO `countries` VALUES (94, 'Gibraltar', 'GI', 0);
INSERT INTO `countries` VALUES (95, 'Greece', 'GR', 0);
INSERT INTO `countries` VALUES (96, 'Greenland', 'GL', 0);
INSERT INTO `countries` VALUES (97, 'Grenada', 'GD', 0);
INSERT INTO `countries` VALUES (98, 'Guadeloupe', 'GP', 0);
INSERT INTO `countries` VALUES (99, 'Guam', 'GU', 0);
INSERT INTO `countries` VALUES (100, 'Guatemala', 'GT', 0);
INSERT INTO `countries` VALUES (101, 'Guernsey', 'GG', 0);
INSERT INTO `countries` VALUES (102, 'Guinea', 'GN', 0);
INSERT INTO `countries` VALUES (103, 'Guinea-Bissau', 'GW', 0);
INSERT INTO `countries` VALUES (104, 'Guyana', 'GY', 0);
INSERT INTO `countries` VALUES (105, 'Haiti', 'HT', 0);
INSERT INTO `countries` VALUES (106, 'Honduras', 'HN', 0);
INSERT INTO `countries` VALUES (107, 'Hong Kong SAR China', 'HK', 0);
INSERT INTO `countries` VALUES (108, 'Hungary', 'HU', 0);
INSERT INTO `countries` VALUES (109, 'Iceland', 'IS', 0);
INSERT INTO `countries` VALUES (110, 'India', 'IN', 0);
INSERT INTO `countries` VALUES (111, 'Indonesia', 'ID', 0);
INSERT INTO `countries` VALUES (112, 'Iran', 'IR', 0);
INSERT INTO `countries` VALUES (113, 'Iraq', 'IQ', 0);
INSERT INTO `countries` VALUES (114, 'Ireland', 'IE', 0);
INSERT INTO `countries` VALUES (115, 'Isle of Man', 'IM', 0);
INSERT INTO `countries` VALUES (116, 'Israel', 'IL', 0);
INSERT INTO `countries` VALUES (117, 'Italy', 'IT', 0);
INSERT INTO `countries` VALUES (118, 'Jamaica', 'JM', 0);
INSERT INTO `countries` VALUES (119, 'Japan', 'JP', 0);
INSERT INTO `countries` VALUES (120, 'Jersey', 'JE', 0);
INSERT INTO `countries` VALUES (121, 'Jordan', 'JO', 0);
INSERT INTO `countries` VALUES (122, 'Kazakhstan', 'KZ', 0);
INSERT INTO `countries` VALUES (123, 'Kenya', 'KE', 0);
INSERT INTO `countries` VALUES (124, 'Kiribati', 'KI', 0);
INSERT INTO `countries` VALUES (125, 'Kosovo', 'XK', 0);
INSERT INTO `countries` VALUES (126, 'Kuwait', 'KW', 0);
INSERT INTO `countries` VALUES (127, 'Kyrgyzstan', 'KG', 0);
INSERT INTO `countries` VALUES (128, 'Laos', 'LA', 0);
INSERT INTO `countries` VALUES (129, 'Latvia', 'LV', 0);
INSERT INTO `countries` VALUES (130, 'Lebanon', 'LB', 0);
INSERT INTO `countries` VALUES (131, 'Lesotho', 'LS', 0);
INSERT INTO `countries` VALUES (132, 'Liberia', 'LR', 0);
INSERT INTO `countries` VALUES (133, 'Libya', 'LY', 0);
INSERT INTO `countries` VALUES (134, 'Liechtenstein', 'LI', 0);
INSERT INTO `countries` VALUES (135, 'Lithuania', 'LT', 0);
INSERT INTO `countries` VALUES (136, 'Luxembourg', 'LU', 0);
INSERT INTO `countries` VALUES (137, 'Macao SAR China', 'MO', 0);
INSERT INTO `countries` VALUES (138, 'Madagascar', 'MG', 0);
INSERT INTO `countries` VALUES (139, 'Malawi', 'MW', 0);
INSERT INTO `countries` VALUES (140, 'Malaysia', 'MY', 0);
INSERT INTO `countries` VALUES (141, 'Maldives', 'MV', 0);
INSERT INTO `countries` VALUES (142, 'Mali', 'ML', 0);
INSERT INTO `countries` VALUES (143, 'Malta', 'MT', 0);
INSERT INTO `countries` VALUES (144, 'Marshall Islands', 'MH', 0);
INSERT INTO `countries` VALUES (145, 'Martinique', 'MQ', 0);
INSERT INTO `countries` VALUES (146, 'Mauritania', 'MR', 0);
INSERT INTO `countries` VALUES (147, 'Mauritius', 'MU', 0);
INSERT INTO `countries` VALUES (148, 'Mayotte', 'YT', 0);
INSERT INTO `countries` VALUES (149, 'Mexico', 'MX', 0);
INSERT INTO `countries` VALUES (150, 'Micronesia', 'FM', 0);
INSERT INTO `countries` VALUES (151, 'Moldova', 'MD', 0);
INSERT INTO `countries` VALUES (152, 'Monaco', 'MC', 0);
INSERT INTO `countries` VALUES (153, 'Mongolia', 'MN', 0);
INSERT INTO `countries` VALUES (154, 'Montenegro', 'ME', 0);
INSERT INTO `countries` VALUES (155, 'Montserrat', 'MS', 0);
INSERT INTO `countries` VALUES (156, 'Morocco', 'MA', 0);
INSERT INTO `countries` VALUES (157, 'Mozambique', 'MZ', 0);
INSERT INTO `countries` VALUES (158, 'Myanmar (Burma)', 'MM', 0);
INSERT INTO `countries` VALUES (159, 'Namibia', 'NA', 0);
INSERT INTO `countries` VALUES (160, 'Nauru', 'NR', 0);
INSERT INTO `countries` VALUES (161, 'Nepal', 'NP', 0);
INSERT INTO `countries` VALUES (162, 'Netherlands', 'NL', 0);
INSERT INTO `countries` VALUES (163, 'New Caledonia', 'NC', 0);
INSERT INTO `countries` VALUES (164, 'New Zealand', 'NZ', 0);
INSERT INTO `countries` VALUES (165, 'Nicaragua', 'NI', 0);
INSERT INTO `countries` VALUES (166, 'Niger', 'NE', 0);
INSERT INTO `countries` VALUES (167, 'Nigeria', 'NG', 0);
INSERT INTO `countries` VALUES (168, 'Niue', 'NU', 0);
INSERT INTO `countries` VALUES (169, 'Norfolk Island', 'NF', 0);
INSERT INTO `countries` VALUES (170, 'North Korea', 'KP', 0);
INSERT INTO `countries` VALUES (171, 'North Macedonia', 'MK', 0);
INSERT INTO `countries` VALUES (172, 'Northern Mariana Islands', 'MP', 0);
INSERT INTO `countries` VALUES (173, 'Norway', 'NO', 0);
INSERT INTO `countries` VALUES (174, 'Oman', 'OM', 0);
INSERT INTO `countries` VALUES (175, 'Pakistan', 'PK', 0);
INSERT INTO `countries` VALUES (176, 'Palau', 'PW', 0);
INSERT INTO `countries` VALUES (177, 'Palestinian Territories', 'PS', 0);
INSERT INTO `countries` VALUES (178, 'Panama', 'PA', 0);
INSERT INTO `countries` VALUES (179, 'Papua New Guinea', 'PG', 0);
INSERT INTO `countries` VALUES (180, 'Paraguay', 'PY', 0);
INSERT INTO `countries` VALUES (181, 'Peru', 'PE', 0);
INSERT INTO `countries` VALUES (182, 'Philippines', 'PH', 0);
INSERT INTO `countries` VALUES (183, 'Pitcairn Islands', 'PN', 0);
INSERT INTO `countries` VALUES (184, 'Poland', 'PL', 0);
INSERT INTO `countries` VALUES (185, 'Portugal', 'PT', 0);
INSERT INTO `countries` VALUES (186, 'Pseudo-Accents', 'XA', 0);
INSERT INTO `countries` VALUES (187, 'Pseudo-Bidi', 'XB', 0);
INSERT INTO `countries` VALUES (188, 'Puerto Rico', 'PR', 0);
INSERT INTO `countries` VALUES (189, 'Qatar', 'QA', 0);
INSERT INTO `countries` VALUES (190, 'Réunion', 'RE', 0);
INSERT INTO `countries` VALUES (191, 'Romania', 'RO', 0);
INSERT INTO `countries` VALUES (192, 'Russia', 'RU', 0);
INSERT INTO `countries` VALUES (193, 'Rwanda', 'RW', 0);
INSERT INTO `countries` VALUES (194, 'Samoa', 'WS', 0);
INSERT INTO `countries` VALUES (195, 'San Marino', 'SM', 0);
INSERT INTO `countries` VALUES (196, 'São Tomé & Príncipe', 'ST', 0);
INSERT INTO `countries` VALUES (197, 'Saudi Arabia', 'SA', 0);
INSERT INTO `countries` VALUES (198, 'Senegal', 'SN', 0);
INSERT INTO `countries` VALUES (199, 'Serbia', 'RS', 0);
INSERT INTO `countries` VALUES (200, 'Seychelles', 'SC', 0);
INSERT INTO `countries` VALUES (201, 'Sierra Leone', 'SL', 0);
INSERT INTO `countries` VALUES (202, 'Singapore', 'SG', 0);
INSERT INTO `countries` VALUES (203, 'Sint Maarten', 'SX', 0);
INSERT INTO `countries` VALUES (204, 'Slovakia', 'SK', 0);
INSERT INTO `countries` VALUES (205, 'Slovenia', 'SI', 0);
INSERT INTO `countries` VALUES (206, 'Solomon Islands', 'SB', 0);
INSERT INTO `countries` VALUES (207, 'Somalia', 'SO', 0);
INSERT INTO `countries` VALUES (208, 'South Africa', 'ZA', 0);
INSERT INTO `countries` VALUES (209, 'South Georgia & South Sandwich Islands', 'GS', 0);
INSERT INTO `countries` VALUES (210, 'South Korea', 'KR', 0);
INSERT INTO `countries` VALUES (211, 'South Sudan', 'SS', 0);
INSERT INTO `countries` VALUES (212, 'Spain', 'ES', 0);
INSERT INTO `countries` VALUES (213, 'Sri Lanka', 'LK', 0);
INSERT INTO `countries` VALUES (214, 'St. Barthélemy', 'BL', 0);
INSERT INTO `countries` VALUES (215, 'St. Helena', 'SH', 0);
INSERT INTO `countries` VALUES (216, 'St. Kitts & Nevis', 'KN', 0);
INSERT INTO `countries` VALUES (217, 'St. Lucia', 'LC', 0);
INSERT INTO `countries` VALUES (218, 'St. Martin', 'MF', 0);
INSERT INTO `countries` VALUES (219, 'St. Pierre & Miquelon', 'PM', 0);
INSERT INTO `countries` VALUES (220, 'St. Vincent & Grenadines', 'VC', 0);
INSERT INTO `countries` VALUES (221, 'Sudan', 'SD', 0);
INSERT INTO `countries` VALUES (222, 'Suriname', 'SR', 0);
INSERT INTO `countries` VALUES (223, 'Svalbard & Jan Mayen', 'SJ', 0);
INSERT INTO `countries` VALUES (224, 'Sweden', 'SE', 0);
INSERT INTO `countries` VALUES (225, 'Switzerland', 'CH', 0);
INSERT INTO `countries` VALUES (226, 'Syria', 'SY', 0);
INSERT INTO `countries` VALUES (227, 'Taiwan', 'TW', 0);
INSERT INTO `countries` VALUES (228, 'Tajikistan', 'TJ', 0);
INSERT INTO `countries` VALUES (229, 'Tanzania', 'TZ', 0);
INSERT INTO `countries` VALUES (230, 'Thailand', 'TH', 0);
INSERT INTO `countries` VALUES (231, 'Timor-Leste', 'TL', 0);
INSERT INTO `countries` VALUES (232, 'Togo', 'TG', 0);
INSERT INTO `countries` VALUES (233, 'Tokelau', 'TK', 0);
INSERT INTO `countries` VALUES (234, 'Tonga', 'TO', 0);
INSERT INTO `countries` VALUES (235, 'Trinidad & Tobago', 'TT', 0);
INSERT INTO `countries` VALUES (236, 'Tristan da Cunha', 'TA', 0);
INSERT INTO `countries` VALUES (237, 'Tunisia', 'TN', 0);
INSERT INTO `countries` VALUES (238, 'Turkey', 'TR', 0);
INSERT INTO `countries` VALUES (239, 'Turkmenistan', 'TM', 0);
INSERT INTO `countries` VALUES (240, 'Turks & Caicos Islands', 'TC', 0);
INSERT INTO `countries` VALUES (241, 'Tuvalu', 'TV', 0);
INSERT INTO `countries` VALUES (242, 'U.S. Outlying Islands', 'UM', 0);
INSERT INTO `countries` VALUES (243, 'U.S. Virgin Islands', 'VI', 0);
INSERT INTO `countries` VALUES (244, 'Uganda', 'UG', 0);
INSERT INTO `countries` VALUES (245, 'Ukraine', 'UA', 0);
INSERT INTO `countries` VALUES (246, 'United Arab Emirates', 'AE', 0);
INSERT INTO `countries` VALUES (247, 'United Kingdom', 'GB', 0);
INSERT INTO `countries` VALUES (249, 'Uruguay', 'UY', 0);
INSERT INTO `countries` VALUES (250, 'Uzbekistan', 'UZ', 0);
INSERT INTO `countries` VALUES (251, 'Vanuatu', 'VU', 0);
INSERT INTO `countries` VALUES (252, 'Vatican City', 'VA', 0);
INSERT INTO `countries` VALUES (253, 'Venezuela', 'VE', 0);
INSERT INTO `countries` VALUES (254, 'Vietnam', 'VN', 0);
INSERT INTO `countries` VALUES (255, 'Wallis & Futuna', 'WF', 0);
INSERT INTO `countries` VALUES (256, 'Western Sahara', 'EH', 0);
INSERT INTO `countries` VALUES (257, 'Yemen', 'YE', 0);
INSERT INTO `countries` VALUES (258, 'Zambia', 'ZM', 0);
INSERT INTO `countries` VALUES (259, 'Zimbabwe', 'ZW', 0);

-- ----------------------------
-- Table structure for currencies
-- ----------------------------
DROP TABLE IF EXISTS `currencies`;
CREATE TABLE `currencies`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of currencies
-- ----------------------------
INSERT INTO `currencies` VALUES (1, 'Bitcoin');
INSERT INTO `currencies` VALUES (2, 'Litecoin');
INSERT INTO `currencies` VALUES (3, 'Monero');

-- ----------------------------
-- Table structure for currency_rates
-- ----------------------------
DROP TABLE IF EXISTS `currency_rates`;
CREATE TABLE `currency_rates`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_id` int(11) NOT NULL,
  `usd` float NOT NULL,
  `eur` float NOT NULL,
  `gbp` float NOT NULL,
  `cad` float NOT NULL,
  `aud` float NOT NULL,
  `brl` float NOT NULL,
  `dkk` float NOT NULL,
  `nok` float NOT NULL,
  `sek` float NOT NULL,
  `try` float NOT NULL,
  `cny` float NOT NULL,
  `hkd` float NOT NULL,
  `rub` float NOT NULL,
  `inr` float NOT NULL,
  `jpy` float NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of currency_rates
-- ----------------------------
INSERT INTO `currency_rates` VALUES (1, 1, 9147.93, 8314.63, 7042.24, 12073.9, 13546.5, 38478, 62136, 83746, 88117, 54426, 63456, 71138, 572615, 652092, 996931, '2020-01-28 22:39:37', '2020-01-28 22:39:37');
INSERT INTO `currency_rates` VALUES (2, 2, 60.08, 54.59, 46.24, 79.28, 88.96, 252.93, 408.01, 549.8, 578.58, 357.5, 416.79, 467.24, 3762.12, 4283.48, 6548.35, '2020-01-28 22:39:37', '2020-01-28 22:39:37');
INSERT INTO `currency_rates` VALUES (3, 3, 66.96, 60.86, 51.54, 88.37, 99.15, 281.63, 454.78, 612.95, 644.94, 398.36, 464.45, 520.67, 4191.06, 4772.76, 7296.69, '2020-01-28 22:39:37', '2020-01-28 22:39:37');

-- ----------------------------
-- Table structure for dispute_replies
-- ----------------------------
DROP TABLE IF EXISTS `dispute_replies`;
CREATE TABLE `dispute_replies`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `dispute_id` int(10) UNSIGNED NOT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adminreply` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for disputes
-- ----------------------------
DROP TABLE IF EXISTS `disputes`;
CREATE TABLE `disputes`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int(10) UNSIGNED NOT NULL,
  `seller_id` int(10) UNSIGNED NOT NULL,
  `buyer_id` int(10) UNSIGNED NOT NULL,
  `resolved` tinyint(1) NOT NULL DEFAULT 0,
  `winner` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `disputes_buyer_id_foreign`(`buyer_id`) USING BTREE,
  INDEX `disputes_seller_id_foreign`(`seller_id`) USING BTREE,
  CONSTRAINT `disputes_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `disputes_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for favorites
-- ----------------------------
DROP TABLE IF EXISTS `favorites`;
CREATE TABLE `favorites`  (
  `user_id` int(10) UNSIGNED NOT NULL,
  `favoriteable_id` int(10) UNSIGNED NOT NULL,
  `favoriteable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`, `favoriteable_id`, `favoriteable_type`) USING BTREE,
  INDEX `favorites_favoriteable_id_favoriteable_type_index`(`favoriteable_id`, `favoriteable_type`) USING BTREE,
  INDEX `favorites_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of favorites
-- ----------------------------
INSERT INTO `favorites` VALUES (28, 6, 'App\\Models\\Listing', '2020-01-18 20:11:53', '2020-01-18 20:11:53');
INSERT INTO `favorites` VALUES (29, 1, 'App\\Models\\Listing', '2020-01-18 20:29:52', '2020-01-18 20:29:52');

-- ----------------------------
-- Table structure for followables
-- ----------------------------
DROP TABLE IF EXISTS `followables`;
CREATE TABLE `followables`  (
  `user_id` int(10) UNSIGNED NOT NULL,
  `followable_id` int(10) UNSIGNED NOT NULL,
  `followable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `relation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'follow' COMMENT 'follow/like/subscribe/favorite/upvote/downvote',
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `followables_user_id_foreign`(`user_id`) USING BTREE,
  INDEX `followables_followable_type_index`(`followable_type`(191)) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of followables
-- ----------------------------
INSERT INTO `followables` VALUES (29, 28, 'App\\Models\\User', 'follow', NULL, '2020-01-18 20:29:46', NULL);
INSERT INTO `followables` VALUES (28, 28, 'App\\Models\\User', 'follow', NULL, '2020-01-18 20:34:45', NULL);
INSERT INTO `followables` VALUES (41, 32, 'App\\Models\\User', 'follow', NULL, '2020-01-28 04:19:44', NULL);

-- ----------------------------
-- Table structure for listing_classes
-- ----------------------------
DROP TABLE IF EXISTS `listing_classes`;
CREATE TABLE `listing_classes`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `auto_finalize` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of listing_classes
-- ----------------------------
INSERT INTO `listing_classes` VALUES (1, 'Physical Package', '14', NULL, NULL);
INSERT INTO `listing_classes` VALUES (2, 'Digital Goods', '2', NULL, NULL);

-- ----------------------------
-- Table structure for listing_shipping_options
-- ----------------------------
DROP TABLE IF EXISTS `listing_shipping_options`;
CREATE TABLE `listing_shipping_options`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listing_id` int(11) NULL DEFAULT NULL,
  `price` decimal(11, 2) NULL DEFAULT NULL,
  `days` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `position` int(11) NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of listing_shipping_options
-- ----------------------------
INSERT INTO `listing_shipping_options` VALUES (1, 5, 1.00, 2, 'as', 0, '2020-01-18 20:04:48', '2020-01-18 20:04:48', NULL);
INSERT INTO `listing_shipping_options` VALUES (2, 6, 12.00, 1, 'DHL', 0, '2020-01-18 20:11:37', '2020-01-18 20:11:37', NULL);
INSERT INTO `listing_shipping_options` VALUES (3, 6, 15.00, 2, 'Fedex', 0, '2020-01-18 20:11:37', '2020-01-18 20:11:37', NULL);
INSERT INTO `listing_shipping_options` VALUES (4, 6, 20.00, 3, 'UPS', 0, '2020-01-18 20:11:37', '2020-01-18 20:11:37', NULL);
INSERT INTO `listing_shipping_options` VALUES (5, 6, 25.00, 4, 'USPS', 0, '2020-01-18 20:11:37', '2020-01-18 20:11:37', NULL);
INSERT INTO `listing_shipping_options` VALUES (6, 7, 10.00, 7, 'DHL', 0, '2020-01-18 20:14:46', '2020-01-22 00:12:55', NULL);
INSERT INTO `listing_shipping_options` VALUES (7, 8, 10.00, 7, 'DHL', 0, '2020-01-22 03:44:33', '2020-01-22 03:44:33', NULL);

-- ----------------------------
-- Table structure for listings
-- ----------------------------
DROP TABLE IF EXISTS `listings`;
CREATE TABLE `listings`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `category_id` int(11) NULL DEFAULT NULL,
  `payment_type_id` int(11) NOT NULL,
  `listing_class_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `quantity` int(11) NULL DEFAULT 0,
  `photos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `spotlight` datetime(0) NULL DEFAULT NULL,
  `expires_at` datetime(0) NULL DEFAULT NULL,
  `priority_until` datetime(0) NULL DEFAULT NULL,
  `bold_until` datetime(0) NULL DEFAULT NULL,
  `views_count` int(11) NULL DEFAULT 0,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `price` decimal(11, 2) NULL DEFAULT NULL,
  `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `shipped_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ships_to` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tags` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `units_in_product_display` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `price_per_unit_display` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_private` tinyint(1) NULL DEFAULT 0,
  `is_published` tinyint(1) NULL DEFAULT 0,
  `is_disabled` datetime(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `pricing_model_id` int(11) NULL DEFAULT NULL,
  `tags_string` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of listings
-- ----------------------------
INSERT INTO `listings` VALUES (1, 28, 48, 1, 1, 'Nike Shoes', NULL, 12, NULL, '1 pair of Nike shoes USA size 8 for men', '2020-01-15 00:00:00', NULL, '2020-01-16 00:00:00', NULL, 15, NULL, 100.00, 'usd', 'WW', 'a:1:{i:0;s:1:\"1\";}', '\"shoes\"', NULL, NULL, 0, 1, NULL, '2020-01-18 19:38:20', '2020-01-18 21:25:47', NULL, NULL, NULL);
INSERT INTO `listings` VALUES (2, 32, 31, 1, 1, 'asdasd', NULL, 1, NULL, 'asdasd', '2020-01-09 00:00:00', NULL, NULL, '2020-01-22 00:00:00', 14, NULL, 11.00, 'usd', 'WW', 'a:6:{i:0;s:1:\"3\";i:1;s:1:\"4\";i:2;s:1:\"5\";i:3;s:1:\"6\";i:4;s:1:\"7\";i:5;s:1:\"8\";}', '\"asdasd,asdasda,sdasd\"', NULL, NULL, 0, 1, NULL, '2020-01-18 19:49:04', '2022-04-08 19:31:41', '2022-04-08 19:31:41', NULL, NULL);
INSERT INTO `listings` VALUES (3, 32, 31, 1, 1, 'asdasd', NULL, 1, NULL, 'asdasd', NULL, NULL, NULL, NULL, 2, NULL, 11.00, 'usd', 'WW', 'a:6:{i:0;s:1:\"3\";i:1;s:1:\"4\";i:2;s:1:\"5\";i:3;s:1:\"6\";i:4;s:1:\"7\";i:5;s:1:\"8\";}', '\"asdasd,asdasda,sdasd\"', NULL, NULL, 0, 1, NULL, '2020-01-18 19:59:27', '2022-04-08 17:21:06', '2022-04-08 17:21:06', NULL, NULL);
INSERT INTO `listings` VALUES (4, 32, 31, 1, 1, 'asdasd', NULL, 1, NULL, 'asdasd', NULL, NULL, NULL, NULL, 4, NULL, 11.00, 'usd', 'WW', 'a:6:{i:0;s:1:\"3\";i:1;s:1:\"4\";i:2;s:1:\"5\";i:3;s:1:\"6\";i:4;s:1:\"7\";i:5;s:1:\"8\";}', '\"asdasd,asdasda,sdasd\"', NULL, NULL, 0, 1, NULL, '2020-01-18 20:01:35', '2022-04-08 19:31:38', '2022-04-08 19:31:38', NULL, NULL);
INSERT INTO `listings` VALUES (5, 32, 47, 1, 1, 'asdasd', NULL, 22, NULL, 'asdasd', NULL, NULL, NULL, NULL, 5, NULL, 22.00, 'usd', 'WW', 'a:5:{i:0;s:1:\"5\";i:1;s:1:\"6\";i:2;s:1:\"7\";i:3;s:1:\"8\";i:4;s:1:\"9\";}', '\"a,sdasd,asd\"', NULL, NULL, 0, 1, NULL, '2020-01-18 20:04:48', '2022-04-08 17:21:02', '2022-04-08 17:21:02', NULL, NULL);
INSERT INTO `listings` VALUES (6, 28, 15, 1, 1, 'Evenflo BabySuite Deluxe Playard', '/uploads/listings_images/RIXnJTcwzWBFKDi6mfOFbnbu9_91ic6ibhjl.acsl1500.jpg', 4, NULL, 'Weight: Bassinet 25lbs, Changer 15lbs, Playard (without bassinet) 40lbs\r\nFloormat converts to Playtime Playmat with toys to create a clean, safe play space for baby\r\nRotate-to-Store Changer rotates to the side when not in use\r\nNo lock hinges for easy set up and tear down\r\nDual-pocket fabric console for baby necessities\r\nLightweight with travel bag included for easy transport', '2020-01-08 00:00:00', NULL, NULL, NULL, 37, NULL, 1200.00, 'usd', 'Asia', 'a:1:{i:0;s:1:\"1\";}', '\"Evenflo,BabySuite,Deluxe,Playard,\"', NULL, NULL, 0, 1, NULL, '2020-01-18 20:11:37', '2022-04-08 19:30:21', NULL, NULL, NULL);
INSERT INTO `listings` VALUES (7, 29, 37, 4, 2, 'Test', '/uploads/listings_images/RW4K11OKWcLm05v2VCpDb0dWt_untitled.png', 1000, NULL, 'Test listing', '2020-01-16 00:00:00', NULL, NULL, NULL, 47, NULL, 10.00, NULL, 'WW', 'a:1:{i:0;s:1:\"1\";}', '\"Test\"', NULL, NULL, 0, 1, NULL, '2020-01-18 20:14:46', '2022-04-08 19:05:26', NULL, NULL, NULL);
INSERT INTO `listings` VALUES (8, 34, 35, 4, 1, 'Vendor', '/uploads/listings_images/uisim9qpJpFcIgwrsKq3Wagu9_untitled.png', 1000, NULL, 'Test', NULL, '2022-04-15 00:00:00', '2022-04-08 00:00:00', NULL, 42, NULL, 10.00, NULL, 'WW', 'a:1:{i:0;s:1:\"1\";}', '\"Test\"', NULL, NULL, 0, 1, NULL, '2020-01-22 03:44:33', '2022-04-08 17:00:18', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for ltm_translations
-- ----------------------------
DROP TABLE IF EXISTS `ltm_translations`;
CREATE TABLE `ltm_translations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL DEFAULT 0,
  `locale` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ltm_translations
-- ----------------------------
INSERT INTO `ltm_translations` VALUES (1, 0, 'en', '_json', 'Drugs', NULL, '2022-04-08 16:53:03', '2022-04-08 16:53:03');
INSERT INTO `ltm_translations` VALUES (2, 0, 'en', '_json', 'Digital goods', NULL, '2022-04-08 16:53:03', '2022-04-08 16:53:03');
INSERT INTO `ltm_translations` VALUES (3, 0, 'en', '_json', 'Weaponry', NULL, '2022-04-08 16:53:03', '2022-04-08 16:53:03');
INSERT INTO `ltm_translations` VALUES (4, 0, 'en', '_json', 'Counterfeit items', NULL, '2022-04-08 16:53:03', '2022-04-08 16:53:03');
INSERT INTO `ltm_translations` VALUES (5, 0, 'en', '_json', 'Apparel', NULL, '2022-04-08 16:53:03', '2022-04-08 16:53:03');
INSERT INTO `ltm_translations` VALUES (6, 0, 'en', '_json', 'Art', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (7, 0, 'en', '_json', 'Books', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (8, 0, 'en', '_json', 'Computer equipment', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (9, 0, 'en', '_json', 'Custom orders', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (10, 0, 'en', '_json', 'Electronics', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (11, 0, 'en', '_json', 'Erotica', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (12, 0, 'en', '_json', 'Drug parahernalia', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (13, 0, 'en', '_json', 'Henk', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (14, 0, 'en', '_json', 'Test 1', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (15, 0, 'en', '_json', 'Test 2', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (16, 0, 'en', '_json', 'Test 3', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (17, 0, 'en', '_json', 'Testa 1', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (18, 0, 'en', '_json', 'Testa 2', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (19, 0, 'en', '_json', 'Testa 3', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (20, 0, 'en', '_json', 'Testb 1', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (21, 0, 'en', '_json', 'Testb 2', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (22, 0, 'en', '_json', 'Testb 3', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (23, 0, 'en', '_json', 'Testa 1c', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (24, 0, 'en', '_json', 'Testa 2c', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (25, 0, 'en', '_json', 'Testa 3c', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (26, 0, 'en', '_json', 'Testa 1d', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (27, 0, 'en', '_json', 'Testa 2d', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (28, 0, 'en', '_json', 'Testa 3d', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (29, 0, 'en', '_json', 'Testa 1e', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (30, 0, 'en', '_json', 'Testa 2e', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (31, 0, 'en', '_json', 'Testa 3e', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (32, 0, 'en', '_json', 'Testa 2f', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (33, 0, 'en', '_json', 'Testa 3f', NULL, '2022-04-08 16:53:04', '2022-04-08 16:53:04');
INSERT INTO `ltm_translations` VALUES (34, 0, 'en', '_json', 'Testa 1g', NULL, '2022-04-08 16:53:05', '2022-04-08 16:53:05');
INSERT INTO `ltm_translations` VALUES (35, 0, 'en', '_json', 'Testa 2g', NULL, '2022-04-08 16:53:05', '2022-04-08 16:53:05');
INSERT INTO `ltm_translations` VALUES (36, 0, 'en', '_json', 'Testa 3g', NULL, '2022-04-08 16:53:05', '2022-04-08 16:53:05');
INSERT INTO `ltm_translations` VALUES (37, 0, 'en', '_json', 'Testa 1h', NULL, '2022-04-08 16:53:05', '2022-04-08 16:53:05');
INSERT INTO `ltm_translations` VALUES (38, 0, 'en', '_json', 'Testa 2h', NULL, '2022-04-08 16:53:05', '2022-04-08 16:53:05');
INSERT INTO `ltm_translations` VALUES (39, 0, 'en', '_json', 'Testa 3h', NULL, '2022-04-08 16:53:05', '2022-04-08 16:53:05');
INSERT INTO `ltm_translations` VALUES (40, 0, 'en', '_json', 'Testa 1i', NULL, '2022-04-08 16:53:05', '2022-04-08 16:53:05');
INSERT INTO `ltm_translations` VALUES (41, 0, 'en', '_json', 'Testa 2j', NULL, '2022-04-08 16:53:05', '2022-04-08 16:53:05');
INSERT INTO `ltm_translations` VALUES (42, 0, 'en', '_json', 'Testa 3k', NULL, '2022-04-08 16:53:05', '2022-04-08 16:53:05');
INSERT INTO `ltm_translations` VALUES (43, 0, 'en', '_json', 'Fuckyou9', NULL, '2022-04-08 16:53:05', '2022-04-08 16:53:05');
INSERT INTO `ltm_translations` VALUES (44, 0, 'en', '_json', 'Vladimir Yashin', NULL, '2022-04-08 16:53:05', '2022-04-08 16:53:05');
INSERT INTO `ltm_translations` VALUES (45, 0, 'en', '_json', 'Automan', NULL, '2022-04-08 16:53:05', '2022-04-08 16:53:05');
INSERT INTO `ltm_translations` VALUES (46, 0, 'en', '_json', 'wqd', NULL, '2022-04-08 17:52:17', '2022-04-08 17:52:17');
INSERT INTO `ltm_translations` VALUES (47, 0, 'en', '_json', '_plural', NULL, '2022-04-08 17:52:17', '2022-04-08 17:52:17');
INSERT INTO `ltm_translations` VALUES (48, 0, 'en', '_json', 'Testb 00', NULL, '2022-04-11 03:44:33', '2022-04-11 03:44:33');
INSERT INTO `ltm_translations` VALUES (49, 0, 'en', '_json', 'Testb 300', NULL, '2022-04-11 03:44:33', '2022-04-11 03:44:33');
INSERT INTO `ltm_translations` VALUES (50, 0, 'en', '_json', 'new_category', NULL, '2022-04-11 03:44:33', '2022-04-11 03:44:33');

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_from_sender` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_from_receiver` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `attachments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_04_02_193005_create_translations_table', 1);

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` int(11) NULL DEFAULT NULL,
  `role_id` int(11) NULL DEFAULT NULL,
  `model_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 51, 2, 'App\\Models\\User');
INSERT INTO `model_has_roles` VALUES (2, 72, 1, 'App\\Models\\User');

-- ----------------------------
-- Table structure for multisig_addresses
-- ----------------------------
DROP TABLE IF EXISTS `multisig_addresses`;
CREATE TABLE `multisig_addresses`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `multisig_id` int(11) NOT NULL,
  `address_1` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `address_2` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `address_3` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of multisig_addresses
-- ----------------------------
INSERT INTO `multisig_addresses` VALUES (1, 1, '2N2hSqAcjoxKxq7ptbj7ZV93vyVQ5qxZBqM', '2NCyvtHiQGyS9eeekarqpxu6yxMYhfdfcCs', '2NFJc4cp9FubpV1qa9UYFp9esq1TySovsmE');
INSERT INTO `multisig_addresses` VALUES (2, 2, '2MzmWGosJhhRk7Qp61sCtVgU9Gxu4X9gEmk', '2N1Js6fiJpnvWrt6Mz2SjnA1GvfGh82742f', '2NAYHaLCaSFRCAkLUJsVyQWKsBAMRoMcyDN');
INSERT INTO `multisig_addresses` VALUES (3, 3, '2Mt8ipVw9169tZxfrghhChiakjPCa9wumUr', '2NDppVajcj6JZ6gi8M7C4dg9W4BQWzrT2ke', '2MwG9eYPh1a6Nrs5JNU2jcHhxA3rBz9Du55');
INSERT INTO `multisig_addresses` VALUES (4, 4, '2MzZEWz9zfXV5f9AB71K5qcVdb27oTWnme7', '2NAkY38EkZL4U6DVjgyukpqTZGxGki3oEm4', '2MxdVVXHbeVvSfVeyy2K23VzMZSzNmwQZ4V');
INSERT INTO `multisig_addresses` VALUES (5, 5, '2N1AKYr8p28XfG9iuxs41NZyYjwtfgyND9o', '2My25yrnf2ZwQC19eCRE7omU7eNSNodX6p9', '2MtcGtMrEGfGED6As5iDsEha6PpmfvYK9eE');
INSERT INTO `multisig_addresses` VALUES (6, 6, '2MuqCcnVFNwc8VQwryrsoKvsmXfvDRhVd86', '2Mz6ftxP3XaUhaBxukyrEtM3sQ2vdtbFzAd', '2N9UWsPQpTK1mtqNvs5w4PyzswZFQNtZiqt');
INSERT INTO `multisig_addresses` VALUES (7, 7, '2NEdT1LLexgtjtYRcqMCEFc8vynSrYzMikv', '2N1HJ5Wyx4muzRcr846RbuYcY57k5Jh4FAR', '2N6rSjhush1JCQFn6mGcSxSaaGXoPPSteya');
INSERT INTO `multisig_addresses` VALUES (8, 8, '2N85XGJGQKssmPga9eQEb89xNAZc7s15cxn', '2NDoU1TbjDoFwAQYBRhLdRiKXBtjWBwFqjR', '2NG844TvnwtGUdy7WikdCN5W7KWKvGddUXK');
INSERT INTO `multisig_addresses` VALUES (9, 9, '2Mud7VxtCw2PUjvfifBCCseaQUARwDZMG2i', '2N6TkjAr1kWVdH8Ri8CfJcEjnFUryfLPztx', '2NAuz2TgLBixKTCbesNUUGpG1abL87D1N1C');
INSERT INTO `multisig_addresses` VALUES (10, 10, '2NAqZ2wMXkKooiYjYUPYbkJqg3ogHW1t8cS', '2NDi6E4MqMTQrCrraQXPk1Yq54T8ApDBc1U', '2NE2qzzzX8ZdyLCwt3Ghv4BXQ2kFgKE87uU');
INSERT INTO `multisig_addresses` VALUES (11, 11, '2N8fnf5nvgVNemHYyXMVSR1n2B445maHtwf', '2NGJX7mxB1JW4pNhRwA3ThiKQrg3LvMrtb4', '2N169GuHoFAF5u58xCsCpHidCjwpVPbHYZx');
INSERT INTO `multisig_addresses` VALUES (12, 12, '2NAA4RcyoizxhKrphdqTfDrECHtHYXjgK9A', '2MthhXyrwdbjYHpeeVJKc6cJM5cWoJq11nh', '2MsJq8E6cy1cTBkiy1EU1uYtNyGRzooxgA6');
INSERT INTO `multisig_addresses` VALUES (13, 13, '2NEL6AYZbqiZQdEnMGnVsxFJv1k5NqeL5DL', '2MtxLTACRHC7422JsS7jRoiCDxXKtuAjBHE', '2NFq3gJfWyEFkgURELNbcqfQPg3DN7P1iFN');
INSERT INTO `multisig_addresses` VALUES (14, 14, '2MzLSnkcb4KgEA1kicGEkUUhg3o6fsdRyK1', '2NCN2uviFqH9pyHy5S5CUaXqiXj8SMSBY3W', '2N3TiGfvxDUHrhWVEiXkXKCspJXEhRHhjCB');
INSERT INTO `multisig_addresses` VALUES (15, 15, '2NBRNtfq7KepCC8eJyeWh8CoMoBc71g8NLV', '2MuG8N2a52e5L1E3zuV3VtcvDw2Lx1HHteP', '2N8kZLF3d7B96tuqB3GaustA2Pvhc9zgxGv');
INSERT INTO `multisig_addresses` VALUES (16, 16, '2N8YdX9rst7UDKZoAq4v1a8XSGj5JKsjMcS', '2NGJsc2vmZMSfJumrWCbok9KSTyLn6iXKNs', '2NDdspjnqmvpbcGMxYqVzm64Qu9eEk4PDd1');
INSERT INTO `multisig_addresses` VALUES (17, 17, '2N55HACzn8AwhJpW4UYREPrqi4jojmyErF8', '2MySgAjqowRA9zF7eyareH8SJcFEp1xSh4N', '2NDszUthbZRCNdNGZJtfXYui2gc16UoJ68n');
INSERT INTO `multisig_addresses` VALUES (18, 18, '2N8kLy77UAas5P1gT6ucg8AHgKHNhs5oEu9', '2NFiFLdgCaTkhsAd9uRXrSh6Z5DsYoUjs8x', '2N3Dzx3iougcba7T4G75Euv9zCDf56uBXdh');
INSERT INTO `multisig_addresses` VALUES (19, 19, '2MyMfdVrvircwuXs383sgo7sySKSFFNuRCP', '2N2N5SXdNamUc8rC98uwWqG3nQd7iJV6i3k', '2MshEov4ovwr89jgVbrVXRnLdDaohisrjX3');
INSERT INTO `multisig_addresses` VALUES (20, 20, '2NDWyUCrmjQEGzVnQtpHpLxaUtS5JdAUpgB', '2NEbrN6kMZpvWrsUf4DYGADjQB5hqsEamWU', '2N7F7o5tXuUvezDi83Cx11XN24EvW7pkqSG');

-- ----------------------------
-- Table structure for multisig_transactions
-- ----------------------------
DROP TABLE IF EXISTS `multisig_transactions`;
CREATE TABLE `multisig_transactions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `multisig_address` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `multisig_redeem` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `multisig_amount` float NOT NULL,
  `listing_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `order_id` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of multisig_transactions
-- ----------------------------
INSERT INTO `multisig_transactions` VALUES (1, '2NDZAoBjXFxqsFsLd3QeeTS8sqNJmWQM9n9', '5221027adfd32f13bdc5d3600e0682c00db5e36b56aa1547d566f1fadd9e5dee5edf432102ac29e828839653fb67a7f333ae1c6d37a85aa55659f75627e9e7da54bdb17dc02103b9bc86af7496933a6adb828bafd9f5d1bc761d084cb5d63df46eda527249da1b53ae', 0.00239755, 8, 29, 34, 1, '2020-01-23 21:46:40', '2020-01-23 21:47:34');
INSERT INTO `multisig_transactions` VALUES (2, '2MvTNDy5HWGEKieLipDSTvTGt7f9cXdT69u', '522102ad083da2a2fdc5559f88825d267269e46898903a3d95509d13929133cfe9771721023be5cb4bdeda5b7db7d706583382197af76853d5c1bc261a5e7eee55a47ddeb921038f7fe6133dc6cbac8ec532e969981588c51afdb861c372dcab7c69093c8cab2e53ae', 0.00240295, 8, 29, 34, NULL, '2020-01-23 22:24:25', '2020-01-23 22:24:25');
INSERT INTO `multisig_transactions` VALUES (3, '2MyhZKBLNMpZS5aNwT3ccGC1tM6wb2hebHc', '5221026715063c1c16f4bcfe8f006ea15a88691421608c60696b83ae8676bdcf58a95421039b5bea4c6421ac75f23ce4e5234584c0b39ac2714f6f84c966776961531acfc42102bad42d0ec66ce07f288732d4ba2d5782e3cda088254602f35859feb01a1b906353ae', 0.00240589, 8, 29, 34, 2, '2020-01-23 22:26:06', '2020-01-23 22:26:46');
INSERT INTO `multisig_transactions` VALUES (4, '2MtNzzXjSdRqKDdXpcocVpBCxSSLQgMb38X', '52210266e0dd7cd6cccd444245b32f9b5bd908685410d5375f202ed60cc0633174fa842102ede1196d608677573fdbfa322a6be063eeb2fbf51a9b04e129e4339c30bb4e4821031413bdbf9a1cb965e9d3d851c17dcfce287dc14fb2b9382b56e6b7280cb2236253ae', 0.0024041, 8, 29, 34, NULL, '2020-01-23 22:33:07', '2020-01-23 22:33:07');
INSERT INTO `multisig_transactions` VALUES (5, '2MwtyrC9cNwvMsCZ8xGn68jQuwHHPKw98ZA', '522102090596d3a7aa42ac32601372ed9f2c8299dda1043075f5148b7e40d442cd169021022a8908b00be3df24a3c4c4ae2e50d5fcd9d27682f0680f25eda64fb9d5b5fb1021028ecffa2dc5dde4c58079577390901480e2b5851dfd00738d33f8e8bb16ad708b53ae', 0.00240195, 8, 29, 34, NULL, '2020-01-23 22:34:20', '2020-01-23 22:34:20');
INSERT INTO `multisig_transactions` VALUES (6, '2NFkeBkPPzETZ7ZGarTuDLrQMDJ5GhksJzh', '522102b0ffc9778037f262f63fd69bd17239af529f90e20016be5a0d0234e64d004485210209d0f419768d11c791d224fb644f5915b2d8a57fbc139b427e0e55b07876c5a42103e21ae7239c8f4f0777c95e1252a4b78135ce2c3c153f9e36df369f92b2b2368753ae', 0.00240265, 8, 29, 34, NULL, '2020-01-23 22:35:37', '2020-01-23 22:35:37');
INSERT INTO `multisig_transactions` VALUES (7, '2N378M9uHdmW6DbukLDm7LpSFhJ5AejjKgW', '522103bf7551f2b0a36f744ab1a146b17443087821cac9f97e8a295597c86527751eb021030aa9d4db7b145ba030bebea617443b2936fd3a7dd625c5328b337e0a892c824c2103270e84a4450c5e2dbccd3a9fabcb49237b63ae9c7c1b3fc120462eb3cc44fa4f53ae', 0.00240071, 8, 29, 34, NULL, '2020-01-23 22:38:14', '2020-01-23 22:38:14');
INSERT INTO `multisig_transactions` VALUES (8, '2N79LQaoXLfsFVuxh4XUDcPo7D9xPwVz6Gz', '522102b4f6539cddd6a52881f300145385687561a7712d6c9a12c74891376c8e66f1fe2103f65d73ebcdde16e646d1be70971c04af460d6aa4985e0f710013abb3cf635e812103054b98ccdbb205eaa9627b955c094b8d08dc6c40213ee695b343cad6054df41d53ae', 0.00239755, 8, 29, 34, NULL, '2020-01-23 22:40:05', '2020-01-23 22:40:05');
INSERT INTO `multisig_transactions` VALUES (9, '2N1XTjeW9A9oXWtzDMU6Q3EmVdKy2a4CKm4', '522103d7e85e3251020af1b4ceca7f25dbb1e75f8a7522aecdc2b2fa762a411b21e52721030eb72d54273eda2f95be20d14b9d6a4a1249c7b1f7c5dce3a036a7f239abafdf21031605e2f9ad0b4e99f6fe8159aea4ec3790be7a09c8d15a5a874257e0c0f3602a53ae', 0.00239727, 8, 29, 34, NULL, '2020-01-23 22:41:14', '2020-01-23 22:41:14');
INSERT INTO `multisig_transactions` VALUES (10, '2N4nFkXCxbF8hhBkTAgGvA19CAiCvaj2W6T', '52210214daa4350b5269e694a42437050e0c4a845277aa1aad21c7aa29a0359580ae912103eb2c68db4834f4cd3a8a392112c821a9a5a44c58fe2aa232b2d8883dab8768362103e7f1faa923023e19b5f75730ee5ef19724172a9859215900e26acc9c04a07be253ae', 0.00239709, 8, 29, 34, NULL, '2020-01-23 22:43:48', '2020-01-23 22:43:48');
INSERT INTO `multisig_transactions` VALUES (11, '2MwXkuiYCuoTQAEHAvm8Raz9sbmXEJ2fYMp', '5221039ed013b1de4f0a4dd33466002abad56a1ee3acd2d982fba3a24f4875a9e08414210344f301ebfcf13976fa74b7f724c45fc9ad7a7451101a75a6530cf857042334b121029bfb66a7ed109d47d60754545887912c801d192f4b32395d885e31be5b44b3ba53ae', 0.00239889, 8, 29, 34, NULL, '2020-01-23 22:46:23', '2020-01-23 22:46:23');
INSERT INTO `multisig_transactions` VALUES (12, '2N2ExcJvwi1Y5WYAz65ewEqVHnsA7b5x2YG', '52210390d51083022aba6ed7fe597804ada91fee20f41fad5b927bf71e00e37b4f82532103f56be7aeb35ca30ed4aa7534138e3578445c324945ce66e90743e20a6a5265142102bbfd40428ad62b4143f5758fd194552d84f565be6b73de0aadeae1eea1307b2353ae', 0.0023994, 8, 29, 34, 1, '2020-01-23 22:47:33', '2020-01-23 22:48:27');
INSERT INTO `multisig_transactions` VALUES (13, '2NA6q7CtBX1yHiYdnPrBJZrZiwBAWgEYmhC', '5221035f74a9366a837e0358b285b735e643f4062cb5e8ea21c748694abfa3fbb0b01c2102b8d9d3a536341f8c1bc395f936c0d089d2cdd47cbfc5991d015991b096dff4c621039882b9861c8f5efa73ad709e05d091405f52201bad241a4c031002ca160698f453ae', 0.00240185, 8, 29, 34, 1, '2020-01-23 23:03:16', '2020-01-23 23:04:10');
INSERT INTO `multisig_transactions` VALUES (14, '2MwEHBnWv1fD167tJwZktuuMf3CG8BAXMdU', '52210325966291165f43b1ba8d8596dea9cc7af2fa0c6afe7fd9867441757ada2f22a1210380ff03db5a5b916ea572619548abc61dac62f3601bc2a7991428fa0efa056c3621024b4efd9736a29720b0028f42c33702dc5becf9431c15370314019f6a809f3f8353ae', 0.00240294, 8, 29, 34, NULL, '2020-01-23 23:15:19', '2020-01-23 23:15:19');
INSERT INTO `multisig_transactions` VALUES (15, '2N9992gJYqUHAwSZK39jQLiZ7RmzyVwkAGm', '522102dfeba34e0c5f91a10f23b388998ef76f1e6cf3648c6f5c0b009aae4515471df72102b8bf3b38928ee3dc8822806d7550011dc2c6f59e2c02948fb355af8cc1e2fd76210237f8cb95f273ecc50301440581c4994dd8b182d05ba483ab2b60f360d0b14e3b53ae', 0.00239777, 8, 29, 34, NULL, '2020-01-23 23:17:25', '2020-01-23 23:17:25');
INSERT INTO `multisig_transactions` VALUES (16, '2NFneR52SJPbTzUq2StoowJ84ofU1huCADv', '52210303a8e021136bd8fb4251f833e40c2dfdfaf73d4fa2cd45e18efff105cc11df7e2102383e434b8e7ab1b1e0c2924baf10bea1f5b99248296dcb4d57200a4a12f9d9d621021140d8654912a9bf6cb1490c0688a0ce62a457507173f0b23a79e35fe06049ae53ae', 0.00239621, 8, 29, 34, 1, '2020-01-23 23:23:30', '2020-01-23 23:24:24');
INSERT INTO `multisig_transactions` VALUES (17, '2N9yASGKLwqiC2CqqJvthWt1J4a3piwzr83', '52210343368b3553e43a54790f65e6d2a07e5704d6199e58ad56977030cc00ea7cf22b2102684ed92789a0724a498d243063c8895ecabfb59f7947c551cdffd03f87d70eb6210292ec2203de13d8451efbc403591fb51dd62772654feca5fd355989888694ff8253ae', 0.00239521, 8, 29, 34, 1, '2020-01-23 23:28:41', '2020-01-23 23:29:21');
INSERT INTO `multisig_transactions` VALUES (18, '2N9fxzuj2q8igAdYb1PVUWi9nXKrWFhD7Kg', '52210204141be844c2c9bc5b6fcfdb0e4527a6be22f6e900bc6273d0d44d8c72305ffb210363ac5e6b72820bd716ec6cdfe6ac99e823cee7df2dcd7a0e316fd532da12398a2102f86c1161d0cd98e9000b99bc74bda041bd032932ee9224485946e70ec580d86653ae', 0.00239467, 8, 29, 34, NULL, '2020-01-23 23:42:02', '2020-01-23 23:42:02');
INSERT INTO `multisig_transactions` VALUES (19, '2NCjWtiJdiUoZfziZ2RMUaVcz5PWSi6gSzJ', '52210321667642157aff26d240b0c980e3c6f711251836ad5f29638297f2a7a55f5e822102a26962cef94f2a6093cc419a507577e9edeffdb40d2e06c5c7b336219b46f85c2103c67cb42cb66851aea2d33329465643a61b7b9591f3e9db5426db1d572ab5205453ae', 0.0023946, 8, 29, 34, NULL, '2020-01-23 23:43:38', '2020-01-23 23:43:38');
INSERT INTO `multisig_transactions` VALUES (20, '2N2ZGWfVDKnATYasDDQo2WzvieoPg842JEo', '52210264be7e918387163c56f87e6ffb74b7c901397c4fc668b19c7437e545f8d1ea472102c27aa6fedbb546ab3a19f3c318b0aa6cc88cbbf106c3d2306fc63860278825ec21028f6b7c697f1a63635ece63e9cddc99e0dd41e25bf83d051dfaf80bab0291479553ae', 0.00239333, 8, 29, 34, 1, '2020-01-23 23:45:08', '2020-01-23 23:46:07');

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `news_category_id` int(3) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured` int(11) NULL DEFAULT NULL,
  `vote_up` int(11) NOT NULL DEFAULT 0,
  `vote_down` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES (1, 1, 4, 'Becoming a Vendor', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 1, 3, 2, '2020-01-04 08:00:00', '2020-01-12 07:58:15');
INSERT INTO `news` VALUES (2, 1, 4, 'Roman Road Advertising', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 1, 0, 0, '2020-01-04 08:00:00', NULL);
INSERT INTO `news` VALUES (3, 1, 5, 'Safe and successful trading', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 1, 1, 0, '2020-01-04 08:00:00', '2020-01-18 20:36:07');
INSERT INTO `news` VALUES (4, 1, 4, 'Placing a Listing', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 1, 1, 0, '2020-01-04 08:00:00', '2020-01-18 20:35:06');
INSERT INTO `news` VALUES (5, 1, 4, 'Becoming a Vendor', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 0, 0, 0, '2020-01-04 08:00:00', NULL);
INSERT INTO `news` VALUES (6, 1, 4, 'Roman Road Advertising', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 0, 0, 0, '2020-01-04 08:00:00', NULL);
INSERT INTO `news` VALUES (7, 1, 5, 'Safe and successful trading', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 0, 0, 0, '2020-01-04 08:00:00', NULL);
INSERT INTO `news` VALUES (8, 1, 4, 'Placing a Listing', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 0, 0, 0, '2020-01-04 08:00:00', NULL);
INSERT INTO `news` VALUES (9, 1, 5, 'Safe and successful trading', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 0, 0, 0, '2020-01-04 08:00:00', NULL);
INSERT INTO `news` VALUES (10, 1, 4, 'Placing a Listing', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 0, 0, 0, '2020-01-04 08:00:00', NULL);

-- ----------------------------
-- Table structure for news_categories
-- ----------------------------
DROP TABLE IF EXISTS `news_categories`;
CREATE TABLE `news_categories`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of news_categories
-- ----------------------------
INSERT INTO `news_categories` VALUES (1, 'Roman Road Ideas');
INSERT INTO `news_categories` VALUES (2, 'Security');
INSERT INTO `news_categories` VALUES (3, 'Buying');
INSERT INTO `news_categories` VALUES (4, 'Selling');
INSERT INTO `news_categories` VALUES (5, 'Tips');
INSERT INTO `news_categories` VALUES (6, 'Speaking with Staff');

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of notifications
-- ----------------------------
INSERT INTO `notifications` VALUES ('b0b441f8-91de-46d7-9241-3a692e23d8a3', 'App\\Notifications\\Alert', 'App\\Models\\User', 29, '{\"message\":\"Your transaction of 20 USD has been received and will be available i you account after 2 confimations.\",\"image\":\"\\/web\\/images\\/icon.png\",\"url\":\"\",\"vendor\":\"\"}', '2020-01-25 04:09:36', '2020-01-23 23:46:07', '2020-01-25 04:09:36');
INSERT INTO `notifications` VALUES ('645b39d4-c01f-4f53-a835-d81182f86edb', 'App\\Notifications\\Alert', 'App\\Models\\User', 29, '{\"message\":\"A new order has been made #1.\",\"image\":\"\\/web\\/images\\/icon.png\",\"url\":\"http:\\/\\/development.test\\/account\\/purchase-history\",\"vendor\":\"\"}', '2020-01-25 04:09:36', '2020-01-23 23:46:07', '2020-01-25 04:09:36');
INSERT INTO `notifications` VALUES ('0219dce6-772c-42a0-8a0d-280c23a3f33e', 'App\\Notifications\\Alert', 'App\\Models\\User', 34, '{\"message\":\"A new order has been made #1.\",\"image\":\"\\/web\\/images\\/icon.png\",\"url\":\"http:\\/\\/development.test\\/account\\/orders\\/state\\/1\",\"vendor\":\"\"}', NULL, '2020-01-23 23:46:07', '2020-01-23 23:46:07');
INSERT INTO `notifications` VALUES ('4a16ad26-579b-46bd-875d-5bb1f050965f', 'App\\Notifications\\Alert', 'App\\Models\\User', 29, '{\"message\":\"Your order has been accepted by the seller #1.\",\"image\":\"\\/web\\/images\\/icon.png\",\"url\":\"http:\\/\\/development.test\\/account\\/purchase-history\",\"vendor\":\"\"}', '2020-01-25 04:09:36', '2020-01-23 23:48:02', '2020-01-25 04:09:36');
INSERT INTO `notifications` VALUES ('9facc99f-1945-440a-83cd-325037b6c08d', 'App\\Notifications\\Alert', 'App\\Models\\User', 29, '{\"message\":\"your order been shipped to you. #1.\",\"image\":\"\\/web\\/images\\/icon.png\",\"url\":\"http:\\/\\/development.test\\/account\\/purchase-history\",\"vendor\":\"\"}', '2020-01-25 04:09:36', '2020-01-23 23:48:12', '2020-01-25 04:09:36');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listing_id` int(11) NULL DEFAULT NULL,
  `seller_id` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `shipping_id` int(11) NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'open',
  `amount` decimal(11, 2) NULL DEFAULT NULL,
  `price` decimal(11, 2) NOT NULL,
  `service_fee` decimal(11, 2) NULL DEFAULT 0,
  `payment_type_id` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `currency` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `shipping_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (1, 8, 34, 29, 7, 'finalized', 1.00, 20.00, 0.80, '4', 'LTC', NULL, '2020-01-23 23:46:07', '2020-01-23 23:49:21', NULL, '');
INSERT INTO `orders` VALUES (2, 6, 28, 29, 2, 'processing', 1.00, 1212.00, 48.48, '1', 'LTC', NULL, '2020-01-29 23:50:51', '2020-01-29 23:50:51', NULL, '');

-- ----------------------------
-- Table structure for page_translations
-- ----------------------------
DROP TABLE IF EXISTS `page_translations`;
CREATE TABLE `page_translations`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locale` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `username` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
INSERT INTO `password_resets` VALUES ('admin', 'QsdLANTX2gSrLGNsgGeHd29SCzepy7G27GF7ZmWIuIkQae9JRKjXCbqAcON5', '2022-04-07 21:50:36');
INSERT INTO `password_resets` VALUES ('admin', '3WwQXda73RQwMTZvstzyPKtIFMM4yjOEpF4NsG4DOFQMFx5Z5YN9gPofbuK1', '2022-04-07 21:52:21');
INSERT INTO `password_resets` VALUES ('admin', 'qzblBcoG67gXmpVggkuA5WFWIN7LAOijSoDNktVmnP8B2k6tKSyNw5q2ENLf', '2022-04-07 21:52:38');

-- ----------------------------
-- Table structure for payment_providers
-- ----------------------------
DROP TABLE IF EXISTS `payment_providers`;
CREATE TABLE `payment_providers`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `display_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `payment_instructions` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_enabled` int(11) NULL DEFAULT NULL,
  `position` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `icon` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `is_offline` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of payment_providers
-- ----------------------------
INSERT INTO `payment_providers` VALUES (1, 'Visa Card', 'offline', 'Visa', NULL, NULL, 1, NULL, 'https://images.freeimages.com/images/small-previews/d2e/credit-card-gold-platinum-1512619.jpg', '1', '2022-04-08 17:46:13', '2022-04-08 17:41:51');
INSERT INTO `payment_providers` VALUES (2, 'Master Card', 'offline', 'Master Card', NULL, NULL, 1, NULL, 'data:image/jpeg;base64,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', '1', '2022-04-08 17:45:57', '2022-04-08 17:45:34');

-- ----------------------------
-- Table structure for payment_type
-- ----------------------------
DROP TABLE IF EXISTS `payment_type`;
CREATE TABLE `payment_type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of payment_type
-- ----------------------------
INSERT INTO `payment_type` VALUES (1, '100% Escrow');
INSERT INTO `payment_type` VALUES (2, '100% Early Finalize');
INSERT INTO `payment_type` VALUES (3, '50% Early Finalize');
INSERT INTO `payment_type` VALUES (4, 'Multisig 2/3');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guard_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pricing_models
-- ----------------------------
DROP TABLE IF EXISTS `pricing_models`;
CREATE TABLE `pricing_models`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `can_add_pricing` int(11) NULL DEFAULT NULL,
  `can_accept_payments` int(11) NULL DEFAULT NULL,
  `can_add_variants` int(11) NULL DEFAULT NULL,
  `can_add_shipping` int(11) NULL DEFAULT NULL,
  `can_add_additional_pricing` int(11) NULL DEFAULT NULL,
  `widget` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `quantity_label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `requires_shipping_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `requires_billing_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `can_list_multiple_services` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pricing_models
-- ----------------------------
INSERT INTO `pricing_models` VALUES (1, 'wqd', 'Vladimir Yashin', 1, 1, 1, 1, 1, 'buy', '2022-04-08 17:54:44', '2022-04-08 17:52:17', NULL, '1', '1', '1');

-- ----------------------------
-- Table structure for reported_listings
-- ----------------------------
DROP TABLE IF EXISTS `reported_listings`;
CREATE TABLE `reported_listings`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reported_user` int(11) NOT NULL,
  `reported_conversation` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `moderator_id` int(11) NULL DEFAULT NULL,
  `moderator_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `active` tinyint(1) NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NULL DEFAULT NULL,
  `role_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `roles` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `guard_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'moderator', NULL, 'web', '2022-04-08 00:02:04', '2022-04-08 00:02:04');
INSERT INTO `roles` VALUES (2, 'admin', NULL, 'web', '2022-04-08 00:04:46', '2022-04-08 00:04:46');

-- ----------------------------
-- Table structure for server_credentials
-- ----------------------------
DROP TABLE IF EXISTS `server_credentials`;
CREATE TABLE `server_credentials`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `currency` int(11) NOT NULL,
  `username` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `host` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `port` int(15) NOT NULL,
  `logo` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `is_enabled` int(2) NOT NULL DEFAULT 1,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of server_credentials
-- ----------------------------
INSERT INTO `server_credentials` VALUES (1, 1, 'root', 'test', '127.0.0.1', 18332, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkTVOILDJ9tcRtPDPBZkMc_cBfr0YZ9v4obQ&usqp=CAU', 1, '2022-04-11 07:57:43');
INSERT INTO `server_credentials` VALUES (2, 2, 'user', 'pass', '127.0.0.1', 19332, 'data:image/jpeg;base64,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', 1, NULL);
INSERT INTO `server_credentials` VALUES (3, 3, 'user', 'pass', '127.0.0.1', 28083, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZcv3WqH8jokMG7MlUGSrdTwpOCL5q4mjg3A&usqp=CAU', 1, NULL);

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (3, 'site_name', 'Roman MarketPlace');
INSERT INTO `settings` VALUES (6, 'currency', 'USD');
INSERT INTO `settings` VALUES (30, 'default_locale', 'en');
INSERT INTO `settings` VALUES (38, 'marketplace_transaction_fee', '4');
INSERT INTO `settings` VALUES (39, 'marketplace_withdraw_fee', '1');

-- ----------------------------
-- Table structure for taggables
-- ----------------------------
DROP TABLE IF EXISTS `taggables`;
CREATE TABLE `taggables`  (
  `tag_id` int(10) UNSIGNED NOT NULL,
  `taggable_id` int(10) UNSIGNED NOT NULL,
  `taggable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tags
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags`  (
  `id` int(10) UNSIGNED NOT NULL,
  `name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `slug` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `order_column` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_addresses
-- ----------------------------
DROP TABLE IF EXISTS `user_addresses`;
CREATE TABLE `user_addresses`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `btc_address` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ltc_address` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `xmr_address` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_markets
-- ----------------------------
DROP TABLE IF EXISTS `user_markets`;
CREATE TABLE `user_markets`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `market_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `positive` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `neutral` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `negatives` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `percentage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `rate` float NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_transactions
-- ----------------------------
DROP TABLE IF EXISTS `user_transactions`;
CREATE TABLE `user_transactions`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tx_id` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `currency` int(11) NOT NULL,
  `amount` float NOT NULL,
  `type` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `confirmations` int(11) NOT NULL,
  `status` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `avatar_background` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `terms_conditions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `trader_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'individual',
  `avatar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `locale` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'en',
  `unread_messages` int(11) NULL DEFAULT 0,
  `is_admin` tinyint(1) NULL DEFAULT 0,
  `withdrawpin` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `btc_balance` double NOT NULL DEFAULT 0,
  `xmr_balance` double NOT NULL DEFAULT 0,
  `ltc_balance` double NULL DEFAULT 0,
  `support_bitcoin` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `support_monero` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `support_litecoin` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `multisig_key_pub` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address_refunds` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address_sales` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `currency` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `has_fe` tinyint(4) NOT NULL DEFAULT 0,
  `last_login_at` datetime(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `pgp_key` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `otp` int(1) NOT NULL DEFAULT 0,
  `withdraw_disabled` tinyint(1) NULL DEFAULT 0,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `mnemonic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `banned_at` datetime(0) NULL DEFAULT NULL,
  `reason_ban` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `on_vacation` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 73 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (28, '/web/images/nobackground.png', 'Django', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '963852', 0, 0, 0, '1', '1', '1', NULL, NULL, '', 'USD', 0, '2020-01-18 10:34:03', '2020-01-17 23:16:39', '2020-01-18 20:22:45', NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 0);
INSERT INTO `users` VALUES (29, '/web/images/nobackground.png', 'fff', 'fff', 'Test', 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '121221', 0.005, 0.1, 0.1, '1', '1', '1', '024e1dbe93d24d44e4bd1618e887b342d2dcfa3499b410fbebc4d731051f0e1651', '2MsHTT3UHwdsHV8VnNw2g1Xk3QtPQ1jXPcn', '', 'EUR', 0, '2020-01-30 21:10:12', '2020-01-18 01:41:39', '2020-01-31 05:10:12', NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 1);
INSERT INTO `users` VALUES (30, '/web/images/nobackground.png', 'test', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, 'asdasd', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, '', 'USD', 0, NULL, '2020-01-18 18:30:13', '2020-01-18 18:30:13', NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0);
INSERT INTO `users` VALUES (31, '/web/images/nobackground.png', 'fuckk', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123123', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, '', 'USD', 0, '2020-01-18 09:37:00', '2020-01-18 18:37:00', '2020-01-18 18:37:09', NULL, NULL, 0, 0, 1, 'enough venture wasp axis debris erode engine achieve two maple seek art', NULL, NULL, 0);
INSERT INTO `users` VALUES (32, '/web/images/nobackground.png', 'oiboi', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123123', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, '', 'USD', 0, '2020-01-18 10:48:42', '2020-01-18 19:48:42', '2020-01-18 19:48:46', NULL, NULL, 0, 0, 1, 'beauty vacuum merge always response match machine angry grace injury share design', NULL, NULL, 0);
INSERT INTO `users` VALUES (33, '/web/images/nobackground.png', 'fuckyou', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '192i31', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, '', 'USD', 0, '2020-01-18 12:22:19', '2020-01-18 21:22:19', '2020-01-18 21:22:24', NULL, NULL, 0, 0, 1, 'gasp hen garment vacant gate field snap move mango ethics jump tunnel', NULL, NULL, 0);
INSERT INTO `users` VALUES (34, NULL, 'Vendor', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '121221', 0, 0, 0, '1', '1', '1', 'mkHS9ne12qx9pS9VojpwU5xtRd4T7X7ZUtmkHS9ne12qx9pS9VojpwU5xtRd4T7X7ZUt', 'mkHS9ne13qx9pS9VojpwU5xtRd4T7X7ZUt', 'mkHS9ne12qx9pS9VojpwU5xtRd4T7X7ZUt', 'USD', 0, '2020-01-23 13:45:31', '2020-01-21 23:03:10', '2020-01-23 21:45:31', NULL, NULL, 0, 0, 1, 'habit total shoot pitch disagree okay cheap manage extra keen seed certain', NULL, NULL, 0);
INSERT INTO `users` VALUES (35, NULL, 'Mod', NULL, NULL, 'moderator', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 1, '121221', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, '2022-04-07 21:53:58', '2020-01-23 03:49:11', '2022-04-07 21:53:58', NULL, NULL, 0, 0, 1, 'setup glove genius matrix huge latin bargain quality bicycle trick spoon timber', NULL, NULL, 0);
INSERT INTO `users` VALUES (39, NULL, 'Test123', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '121221', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2020-01-27 21:51:23', '2020-01-27 21:51:23', NULL, NULL, 0, 0, 0, 'scan achieve seed argue false stem crystal robot sea wash bounce teach', NULL, NULL, 0);
INSERT INTO `users` VALUES (40, NULL, 'Test12', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '121221', 1.5, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, '2020-01-27 13:53:53', '2020-01-27 21:53:52', '2020-01-27 22:02:33', NULL, NULL, 0, 0, 1, 'problem vague lyrics lawn train nurse quit tip beyond state slush maple', NULL, NULL, 0);
INSERT INTO `users` VALUES (41, NULL, 'hoi9', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, 'a9sda9', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, '2020-01-27 20:16:44', '2020-01-28 04:15:01', '2020-01-28 04:16:51', NULL, NULL, 0, 0, 1, 'once offer morning social oyster cradle vague cousin pulse scissors during shell', NULL, NULL, 0);
INSERT INTO `users` VALUES (42, NULL, 'dj', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '963852', 0, 0, 0, NULL, NULL, NULL, '18JERgZHtoAnRxPoeYnaaCcnbgPX6T3yWt', '18JERgZHtoAnRxPoeYnaaCcnbgPX6T3yWt', '18JERgZHtoAnRxPoeYnaaCcnbgPX6T3yWt', 'USD', 0, '2020-01-27 20:19:59', '2020-01-28 04:18:25', '2020-01-28 04:21:46', NULL, NULL, 0, 0, 1, 'list age lake hello brother around evil dream amateur tired find hurt', NULL, NULL, 0);
INSERT INTO `users` VALUES (43, NULL, 'test45', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '121221', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, '2020-01-27 20:18:52', '2020-01-28 04:18:52', '2020-01-28 04:19:01', NULL, NULL, 0, 0, 1, 'kingdom outside disorder life bracket runway twist defy render surround pull snake', NULL, NULL, 0);
INSERT INTO `users` VALUES (44, NULL, 'fuckyou9', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, 'asda9s', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2020-01-28 04:23:40', '2020-01-28 04:23:40', NULL, NULL, 0, 0, 0, 'divorce view envelope market letter together pen speed protect split purity swear', NULL, NULL, 0);
INSERT INTO `users` VALUES (45, NULL, 'rockey', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '963852', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2020-01-28 04:24:03', '2020-01-28 04:24:03', NULL, NULL, 0, 0, 0, 'exercise pitch normal mutual injury hello snap tenant sketch journey donkey clarify', NULL, NULL, 0);
INSERT INTO `users` VALUES (46, NULL, 'Test89', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '121221', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2020-01-28 04:26:56', '2020-01-28 04:26:56', NULL, NULL, 0, 0, 0, 'direct light gym crucial mean live shoot foil spoil travel dune armed', NULL, NULL, 0);
INSERT INTO `users` VALUES (47, NULL, 'newuser', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '121212', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, '2020-01-27 20:28:53', '2020-01-28 04:28:52', '2020-01-28 04:29:03', NULL, NULL, 0, 0, 1, 'damp kiwi party weapon future addict electric dilemma off aware joy ceiling', NULL, NULL, 0);
INSERT INTO `users` VALUES (48, NULL, 'hi99', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, 'asodas', 0.0161584, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, '2020-01-27 20:29:52', '2020-01-28 04:29:52', '2020-01-28 05:13:10', NULL, NULL, 0, 0, 1, 'name fiction entry hunt bomb special egg detect cereal symptom lunch reveal', NULL, NULL, 0);
INSERT INTO `users` VALUES (49, NULL, 'newdemos', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '963852', 0, 0, 0, NULL, NULL, NULL, '18JERgZHtoAnRxPoeYnaaCcnbgPX6T3yWt', '18JERgZHtoAnRxPoeYnaaCcnbgPX6T3yWt', '18JERgZHtoAnRxPoeYnaaCcnbgPX6T3yWt', 'USD', 0, '2020-01-27 20:30:21', '2020-01-28 04:30:21', '2020-01-28 04:59:54', NULL, NULL, 0, 0, 1, 'physical boss traffic grid relax employ nut hour result cable loop focus', NULL, NULL, 0);
INSERT INTO `users` VALUES (50, NULL, 'codeless', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '181050', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, '2022-03-19 06:45:26', '2022-03-19 15:43:44', '2022-03-19 15:45:26', NULL, NULL, 0, 0, 0, 'police daughter couch school armor game matter lucky behind seed vague solution', NULL, NULL, 0);
INSERT INTO `users` VALUES (51, NULL, 'admin', NULL, NULL, 'admin', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 1, '181050', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, '2022-04-11 07:42:03', '2022-03-19 22:33:24', '2022-04-11 07:42:03', NULL, NULL, 0, 0, 1, 'sure notable domain latin identify hockey strategy aspect stool rookie orange green', NULL, NULL, 0);
INSERT INTO `users` VALUES (52, NULL, 'KENGERP', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123456', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, '2022-03-19 22:07:29', '2022-03-20 07:05:33', '2022-03-20 07:07:29', NULL, NULL, 0, 0, 0, 'farm void arm company ride top gasp chuckle swift radar topic syrup', NULL, NULL, 0);
INSERT INTO `users` VALUES (53, NULL, 'antilian', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123456', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-20 07:20:04', '2022-03-20 07:20:04', NULL, NULL, 0, 0, 0, 'endless blue cluster depth engage minimum verb object chalk love ritual critic', NULL, NULL, 0);
INSERT INTO `users` VALUES (54, NULL, 'Admin68', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, 'D12345', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-20 15:45:36', '2022-03-20 15:45:36', NULL, NULL, 0, 0, 0, 'olive fury shed giraffe grunt century dinner add foam market embark sound', NULL, NULL, 0);
INSERT INTO `users` VALUES (55, NULL, '\'or\'', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, 'D12345', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-20 16:01:38', '2022-03-20 16:01:38', NULL, NULL, 0, 0, 0, 'chimney alter glue action shiver slush mix feel grant solid allow prepare', NULL, NULL, 0);
INSERT INTO `users` VALUES (56, NULL, 'Nayla', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '237423', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-20 18:52:40', '2022-03-20 18:52:40', NULL, NULL, 0, 0, 0, 'reform flower eager frame where help usage witness fox club vehicle rule', NULL, NULL, 0);
INSERT INTO `users` VALUES (57, NULL, 'Nayla11', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123123', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-20 19:28:30', '2022-03-20 19:28:30', NULL, NULL, 0, 0, 0, 'cargo distance fever much hand spread rice swing round vacuum imitate silly', NULL, NULL, 0);
INSERT INTO `users` VALUES (58, NULL, 'Nayla123', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123123', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-20 19:32:53', '2022-03-20 19:32:53', NULL, NULL, 0, 0, 0, 'reduce razor check canal option other sound rabbit proof name attract phone', NULL, NULL, 0);
INSERT INTO `users` VALUES (59, NULL, 'Nayla1232', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123123', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-20 19:35:10', '2022-03-20 19:35:10', NULL, NULL, 0, 0, 0, 'motion exhibit embark eye typical drum unit much swear ensure crush hub', NULL, NULL, 0);
INSERT INTO `users` VALUES (60, NULL, 'test1', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123123', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-20 21:25:13', '2022-03-20 21:25:13', NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0);
INSERT INTO `users` VALUES (61, NULL, 'kengerp2020@gmail.com', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, 'D12345', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-20 21:38:30', '2022-03-20 21:38:30', NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0);
INSERT INTO `users` VALUES (62, NULL, 'fuckyoubitch', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '212212', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-21 22:48:43', '2022-04-08 15:47:54', '2022-04-08 15:47:54', NULL, 0, 0, 0, NULL, NULL, NULL, 0);
INSERT INTO `users` VALUES (63, NULL, 'admin1', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, 'D12345', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-22 19:19:41', '2022-04-08 15:35:03', '2022-04-08 15:35:03', NULL, 0, 0, 0, NULL, NULL, NULL, 0);
INSERT INTO `users` VALUES (64, NULL, 'memo123', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123456', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-23 22:36:36', '2022-03-23 22:36:36', NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0);
INSERT INTO `users` VALUES (65, NULL, 'memo32', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, 'D12345', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-23 22:37:01', '2022-04-08 16:16:11', '2022-04-08 16:16:11', NULL, 0, 0, 0, NULL, NULL, NULL, 0);
INSERT INTO `users` VALUES (66, NULL, 'tre', 'tre', NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123456', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-23 22:38:06', '2022-04-08 16:15:34', NULL, NULL, 0, 0, 0, NULL, '2022-04-08 16:15:34', NULL, 0);
INSERT INTO `users` VALUES (67, NULL, 'Kadmin', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123123', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-28 04:21:57', '2022-03-28 04:21:57', NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0);
INSERT INTO `users` VALUES (68, NULL, 'kautoman99923@gmail.com', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, 'BG2WjK', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-28 07:09:26', '2022-03-28 07:09:26', NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0);
INSERT INTO `users` VALUES (69, NULL, 'root1234@gmail.com', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123123', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-03-28 10:12:03', '2022-03-28 10:12:03', NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0);
INSERT INTO `users` VALUES (70, NULL, 'test@test.com', NULL, NULL, 'individual', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123123', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, NULL, '2022-04-07 20:10:20', '2022-04-07 20:10:20', NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 0);
INSERT INTO `users` VALUES (71, NULL, 'json@test.com', NULL, NULL, 'buyer', '/web/images/noavatar.png', '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123123', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, '2022-04-11 03:42:36', '2022-04-07 20:11:39', '2022-04-11 03:42:36', NULL, NULL, 0, 0, 1, 'move into violin cruel machine recipe december spirit chat gaze melt between', NULL, NULL, 0);
INSERT INTO `users` VALUES (72, NULL, 'adam', NULL, NULL, 'buyer', NULL, '$2y$10$.92CWICxXxWDw.9maSgKUu/.xnrH25wULYaTLGy/p.xkTMZhYbyhS', 'en', 0, 0, '123123', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 0, '2022-04-08 19:39:03', '2022-04-07 21:53:01', '2022-04-08 19:39:15', NULL, NULL, 0, 0, 1, 'solar guard must visa tape museum arrow flat fashion jealous system maple', NULL, NULL, 0);

SET FOREIGN_KEY_CHECKS = 1;
