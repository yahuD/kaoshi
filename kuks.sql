/*
 Navicat Premium Data Transfer

 Source Server         : 本地数据库
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : kuks

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 22/09/2020 12:46:38
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for kp_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `kp_admin_user`;
CREATE TABLE `kp_admin_user`  (
  `uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员姓名',
  `account` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员账号',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员密码',
  `roleid` int(11) NULL DEFAULT NULL COMMENT '管理员角色',
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登录ip',
  `addtime` datetime NULL DEFAULT NULL COMMENT '添加时间',
  `last_login` datetime NULL DEFAULT NULL COMMENT '最后登录时间',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of kp_admin_user
-- ----------------------------
INSERT INTO `kp_admin_user` VALUES (1, '管理员1', '1', 'bbaa99c41b7ff674c96c405b2d1a22c8', 0, '127.0.0.1', '2020-09-03 11:43:56', NULL);
INSERT INTO `kp_admin_user` VALUES (2, '测试', 'ceshi', '2bda8a1ac2fa095124eac8531b0f3623', 1, NULL, '0000-00-00 00:00:00', NULL);
INSERT INTO `kp_admin_user` VALUES (4, '教师', 'jiaoshi123', '2bda8a1ac2fa095124eac8531b0f3623', 2, NULL, '2020-09-03 03:24:13', NULL);

-- ----------------------------
-- Table structure for kp_exampaper
-- ----------------------------
DROP TABLE IF EXISTS `kp_exampaper`;
CREATE TABLE `kp_exampaper`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` int(11) UNSIGNED NOT NULL COMMENT '试卷分类id',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '试卷名称',
  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '试卷状态',
  `pass_line` int(11) NOT NULL DEFAULT 60 COMMENT '及格线',
  `operator` int(11) NOT NULL COMMENT '操作人',
  `addtime` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of kp_exampaper
-- ----------------------------
INSERT INTO `kp_exampaper` VALUES (1, 1, '测试试卷1', 1, 59, 1, '2020-09-04 01:44:46');
INSERT INTO `kp_exampaper` VALUES (2, 1, '测试', 1, 60, 1, '2020-09-04 04:05:22');
INSERT INTO `kp_exampaper` VALUES (3, 1, '电子商务', 1, 60, 1, '2020-09-09 04:15:04');
INSERT INTO `kp_exampaper` VALUES (4, 4, '测试添加是拒签3', 1, 60, 1, '2020-09-15 04:03:26');
INSERT INTO `kp_exampaper` VALUES (5, 4, '计算机', 1, 60, 1, '2020-09-17 09:47:35');
INSERT INTO `kp_exampaper` VALUES (6, 4, '测试', 1, 60, 1, '2020-09-17 09:58:23');
INSERT INTO `kp_exampaper` VALUES (7, 4, '数学', 1, 60, 1, '2020-09-17 10:06:27');
INSERT INTO `kp_exampaper` VALUES (8, 1, '语文111111', 1, 111, 1, '2020-09-20 07:52:47');
INSERT INTO `kp_exampaper` VALUES (9, 1, '周三测试考试', 1, 50, 1, '2020-09-20 08:34:25');
INSERT INTO `kp_exampaper` VALUES (10, 1, '大卫的舞的', 1, 222, 1, '2020-09-21 05:09:13');

-- ----------------------------
-- Table structure for kp_questype
-- ----------------------------
DROP TABLE IF EXISTS `kp_questype`;
CREATE TABLE `kp_questype`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `questype` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '题型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of kp_questype
-- ----------------------------
INSERT INTO `kp_questype` VALUES (1, '单选题');
INSERT INTO `kp_questype` VALUES (2, '多选题');
INSERT INTO `kp_questype` VALUES (3, '判断题');
INSERT INTO `kp_questype` VALUES (4, '填空题');
INSERT INTO `kp_questype` VALUES (9, '计算题');
INSERT INTO `kp_questype` VALUES (10, '问答题');
INSERT INTO `kp_questype` VALUES (11, '简答题');
INSERT INTO `kp_questype` VALUES (12, '作品题');

-- ----------------------------
-- Table structure for kp_section
-- ----------------------------
DROP TABLE IF EXISTS `kp_section`;
CREATE TABLE `kp_section`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `school` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学校',
  `majors` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '专业',
  `grade` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '年级',
  `term` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学期',
  `course` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '科目',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kp_section
-- ----------------------------
INSERT INTO `kp_section` VALUES (1, '安徽大学', '计算机', '2020', '第一学期', '电子商务');
INSERT INTO `kp_section` VALUES (3, '北京大学', '机电一体化', '2019', '第一学期', '函数');
INSERT INTO `kp_section` VALUES (4, 'ddd', 'hhh', '1', '2', '3');

-- ----------------------------
-- Table structure for kp_teacher
-- ----------------------------
DROP TABLE IF EXISTS `kp_teacher`;
CREATE TABLE `kp_teacher`  (
  `uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '教师姓名',
  `teacher_id` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '教师编号',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登录密码',
  `roleid` int(11) NULL DEFAULT 0 COMMENT '教师角色',
  `last_login` datetime NULL DEFAULT NULL COMMENT '最后登录时间',
  `addtime` datetime NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of kp_teacher
-- ----------------------------
INSERT INTO `kp_teacher` VALUES (1, 'ss1', '15589774558', '2bda8a1ac2fa095124eac8531b0f3623', 0, NULL, '2020-09-03 10:34:19');

-- ----------------------------
-- Table structure for kp_test
-- ----------------------------
DROP TABLE IF EXISTS `kp_test`;
CREATE TABLE `kp_test`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL COMMENT '考试分类',
  `tid` int(11) NOT NULL COMMENT '试卷id',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '考试名称',
  `begin_time` datetime NULL DEFAULT NULL COMMENT '考试开始时间',
  `end_time` datetime NULL DEFAULT NULL COMMENT '考试结束时间',
  `grader` int(11) NOT NULL COMMENT '批卷人',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '考试状态',
  `is_make_up` tinyint(2) NULL DEFAULT NULL COMMENT '是否补考',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of kp_test
-- ----------------------------
INSERT INTO `kp_test` VALUES (1, 1, 1, '测试考试', '2020-09-07 16:00:00', '2020-09-07 19:00:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (2, 1, 1, '测试2', '2020-09-08 09:10:00', '2020-09-08 12:00:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (3, 3, 1, '电子商务', '2020-09-08 16:00:00', '2020-09-08 18:00:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (4, 3, 1, '机电', '2020-09-09 09:25:00', '2020-09-09 12:20:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (5, 3, 1, '计算机一级', '2020-09-09 14:45:00', '2020-09-09 17:45:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (6, 3, 3, '你好啊', '2020-09-10 08:30:00', '2020-09-10 18:30:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (7, 4, 1, '333', '2020-09-15 23:02:00', '2020-09-16 00:00:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (8, 1, 1, '微页面标题', '2020-09-15 21:27:00', '2020-09-15 22:00:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (9, 1, 1, '微页面标题', '2020-09-16 01:20:00', '2020-09-16 03:00:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (10, 3, 1, '周三测试考试', '2020-09-16 10:08:00', '2020-09-16 16:08:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (11, 1, 1, '周四考试', '2020-09-17 10:28:00', '2020-09-17 23:59:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (12, 3, 3, '周三测试考试', '2020-09-17 21:13:00', '2020-09-17 21:14:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (13, 1, 2, '语文', '2020-09-18 21:34:00', '2020-09-18 22:34:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (14, 4, 2, '测试考试', '2020-09-17 21:36:00', '2020-09-18 21:36:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (15, 4, 1, '语文', '2020-09-17 21:41:00', '2020-09-17 22:41:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (16, 1, 2, '计算机', '2020-09-17 21:48:00', '2020-09-17 23:48:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (17, 4, 7, '考数学', '2020-09-17 22:18:00', '2020-09-18 22:19:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (18, 4, 7, '测试测试', '2020-09-17 22:27:00', '2020-09-18 22:27:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (19, 4, 7, '111111111', '2020-09-17 22:30:00', '2020-09-18 22:30:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (20, 1, 1, 'test23', '2020-09-17 22:40:00', '2020-09-18 02:40:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (21, 4, 1, 'test34', '2020-09-17 22:46:00', '2020-09-19 02:46:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (22, 4, 1, '3333', '2020-09-17 22:53:00', '2020-09-17 22:53:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (23, 1, 1, 'ceshi', '2020-09-18 03:28:00', '2020-09-19 03:28:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (24, 1, 1, 'qqqqqqqqqqqqq', '2020-09-18 18:06:00', '2020-09-20 18:06:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (25, 1, 1, '语文', '2020-09-19 17:51:00', '2020-09-20 17:51:00', 4, 2, 0);
INSERT INTO `kp_test` VALUES (26, 1, 1, '计算机', '2020-09-21 02:36:00', '2020-09-24 15:36:00', 4, 0, 0);
INSERT INTO `kp_test` VALUES (27, 1, 1, 'zzzzzzzzzzzzzzzzzzz', '2020-09-20 16:06:00', '2020-09-22 16:06:00', 4, 0, 0);
INSERT INTO `kp_test` VALUES (28, 1, 8, '语文11111', '2020-09-20 19:53:00', '2020-09-22 19:53:00', 4, 0, 0);
INSERT INTO `kp_test` VALUES (29, 1, 10, 'dwwdw', '2020-09-21 05:03:00', '2020-09-21 08:10:00', 4, 2, 0);

-- ----------------------------
-- Table structure for kp_test_question
-- ----------------------------
DROP TABLE IF EXISTS `kp_test_question`;
CREATE TABLE `kp_test_question`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `eid` int(11) NOT NULL COMMENT '试卷id',
  `questype` int(11) NOT NULL COMMENT '试题类型',
  `question` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '试题名称',
  `anwswer` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '试题答案',
  `option` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '试题选项',
  `score` decimal(10, 1) NOT NULL COMMENT '试题分值',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 70 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of kp_test_question
-- ----------------------------
INSERT INTO `kp_test_question` VALUES (5, 1, 3, '使用PHP写好的程序，在Linux和Windows平台上都可以运行。', 'yes', '', 10.0);
INSERT INTO `kp_test_question` VALUES (6, 1, 1, '下列选项中，不是URL地址中所包含的信息是（ ）。', 'D', '主机名,端口号,网络协议,软件版本,测试名字', 10.0);
INSERT INTO `kp_test_question` VALUES (7, 1, 4, '在PHP中，标识符允许包含字母、数字和_____。', '下划线', '', 20.0);
INSERT INTO `kp_test_question` VALUES (8, 1, 3, '使用PHP写好的程序，在Linux和Windows平台上都可以运行。', 'yes', '', 10.0);
INSERT INTO `kp_test_question` VALUES (9, 1, 1, '下列选项中，不是URL地址中所包含的信息是（ ）。', 'D', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (10, 1, 4, '在PHP中，标识符允许包含字母、数字和_____。', '下划线', '', 20.0);
INSERT INTO `kp_test_question` VALUES (11, 1, 1, '2下列选项中，不是URL地址中所包含的信息是（ ）。', 'D', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (12, 1, 1, '下列选项中，不是URL地址中所包含的信息是（ ）。', 'C', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (13, 1, 1, '下列选项中，不是URL地址中所包含的信息是（ ）。', 'D', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (14, 1, 1, '下列选项中，不是URL地址中所包含的信息是（ ）。', 'D', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (15, 1, 1, '下列选项中，不是URL地址中所包含的信息是（ ）。', 'A', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (16, 1, 4, '在PHP中，标识符允许包含字母、数字和_____。', '下划线', '', 20.0);
INSERT INTO `kp_test_question` VALUES (17, 1, 4, '在PHP中，标识符允许包含字母、数字和_____。', '下划线', '', 20.0);
INSERT INTO `kp_test_question` VALUES (18, 3, 3, '使用PHP写好的程序，在Linux和Windows平台上都可以运行。', 'yes', '', 10.0);
INSERT INTO `kp_test_question` VALUES (19, 3, 1, '下列选项中，不是URL地址中所包含的信息是（ ）。', 'D', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (20, 3, 4, '在PHP中，标识符允许包含字母、数字和_____。', '下划线', '', 20.0);
INSERT INTO `kp_test_question` VALUES (21, 3, 1, '2下列选项中，不是URL地址中所包含的信息是（ ）。', 'D', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (22, 3, 1, '3下列选项中，不是URL地址中所包含的信息是（ ）。', 'C', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (23, 3, 1, '4下列选项中，不是URL地址中所包含的信息是（ ）。', 'D', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (24, 3, 1, '5下列选项中，不是URL地址中所包含的信息是（ ）。', 'D', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (25, 3, 1, '6下列选项中，不是URL地址中所包含的信息是（ ）。', 'A', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (26, 3, 4, '在PHP中，标识符允许包含字母、数字和() () () ()。', '下划线,上划线,做划线,有划线', '', 20.0);
INSERT INTO `kp_test_question` VALUES (27, 3, 4, '在PHP中，标识符允许包含字母、数字和() () () 。', '下划线,上划线,做划线', '', 20.0);
INSERT INTO `kp_test_question` VALUES (28, 4, 3, '使用PHP写好的程序，在Linux和Windows平台上都可以运行。', 'yes', '', 10.0);
INSERT INTO `kp_test_question` VALUES (29, 4, 1, '下列选项中，不是URL地址中所包含的信息是（ ）。', 'D', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (30, 4, 4, '在PHP中，标识符允许包含字母、数字和_____。', '下划线', '', 20.0);
INSERT INTO `kp_test_question` VALUES (31, 4, 1, '2下列选项中，不是URL地址中所包含的信息是（ ）。', 'D', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (32, 4, 1, '3下列选项中，不是URL地址中所包含的信息是（ ）。', 'C', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (33, 4, 1, '4下列选项中，不是URL地址中所包含的信息是（ ）。', 'D', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (34, 4, 1, '5下列选项中，不是URL地址中所包含的信息是（ ）。', 'D', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (35, 4, 1, '6下列选项中，不是URL地址中所包含的信息是（ ）。', 'A', '主机名,端口号,网络协议,软件版本', 10.0);
INSERT INTO `kp_test_question` VALUES (36, 4, 4, '在PHP中，标识符允许包含字母、数字和() () () ()。', '下划线,上划线,做划线,有划线', '', 20.0);
INSERT INTO `kp_test_question` VALUES (37, 4, 4, '在PHP中，标识符允许包含字母、数字和() () () 。', '下划线,上划线,做划线,有划线', '', 20.0);
INSERT INTO `kp_test_question` VALUES (38, 1, 2, '下列关于个性化功能介绍，正确的是？', 'A,B,C', 'logo,icon,banner,text,img', 5.0);
INSERT INTO `kp_test_question` VALUES (39, 1, 9, '请算出3+2=？', '5', '', 5.0);
INSERT INTO `kp_test_question` VALUES (40, 1, 10, '你叫什么', '333', '', 5.0);
INSERT INTO `kp_test_question` VALUES (41, 1, 11, '自我介绍？', '3333', '', 5.0);
INSERT INTO `kp_test_question` VALUES (42, 1, 12, '展示作品', '5', '', 5.0);
INSERT INTO `kp_test_question` VALUES (43, 6, 1, '你是狗吗', '是', '是', 10.0);
INSERT INTO `kp_test_question` VALUES (44, 6, 1, '你是谁', '是', '是', 10.0);
INSERT INTO `kp_test_question` VALUES (45, 7, 11, '你是谁', '我', '', 10.0);
INSERT INTO `kp_test_question` VALUES (46, 4, 2, '111', '1', '1', 10.0);
INSERT INTO `kp_test_question` VALUES (47, 1, 11, '测试', '我', '', 10.0);
INSERT INTO `kp_test_question` VALUES (48, 8, 1, '你是谁', 'B', 'A.123,B.234', 10.0);
INSERT INTO `kp_test_question` VALUES (49, 1, 12, '1', '1', '', 19.0);
INSERT INTO `kp_test_question` VALUES (50, 1, 3, '测试', '1', '', 19.0);
INSERT INTO `kp_test_question` VALUES (51, 8, 12, '123', '22', '', 22.0);
INSERT INTO `kp_test_question` VALUES (52, 1, 1, '1', 'A', '11,22,33,44', 10.0);
INSERT INTO `kp_test_question` VALUES (53, 8, 1, '1', 'A', '11,22,33,44', 10.0);
INSERT INTO `kp_test_question` VALUES (54, 8, 1, '1', 'A', '11,22,33,44', 77.0);
INSERT INTO `kp_test_question` VALUES (55, 8, 1, '测试', 'oa', 'oa,ob,oc,od', 22.0);
INSERT INTO `kp_test_question` VALUES (56, 8, 2, '这个是多选题', '多选1,多选2', '多选1,多选2,多选3', 44.0);
INSERT INTO `kp_test_question` VALUES (57, 8, 2, '这个是多选题2', '多选d', '多选a,多选b,多选c,多选d', 66.0);
INSERT INTO `kp_test_question` VALUES (58, 8, 3, '这是判断题', 'T', '', 33.0);
INSERT INTO `kp_test_question` VALUES (59, 8, 4, '这是填空题', '没有答案', '', 22.0);
INSERT INTO `kp_test_question` VALUES (60, 8, 9, '这是计算题', '这是答案', '', 23.0);
INSERT INTO `kp_test_question` VALUES (61, 8, 9, '第二个计算题', '111', '', 19.0);
INSERT INTO `kp_test_question` VALUES (62, 8, 4, '()()()', '填空1,填空2,填空3,', '', 33.0);
INSERT INTO `kp_test_question` VALUES (63, 8, 4, '填空3个', '填空1,填空2,填空3', '', 11.0);
INSERT INTO `kp_test_question` VALUES (64, 5, 4, '()()()', '答案1,答案2,答案3', '', 22.0);
INSERT INTO `kp_test_question` VALUES (65, 5, 4, '()()()', '答案1,答案2,答案3', '', 23.0);
INSERT INTO `kp_test_question` VALUES (66, 5, 4, '()()()', '答案1,答案2,答案3', '', 19.0);
INSERT INTO `kp_test_question` VALUES (67, 5, 4, '()()()', '答案1,答案2,答案3', '', 22.0);
INSERT INTO `kp_test_question` VALUES (68, 10, 4, '()()()', '答案1,答案2,答案3', '', 22.0);
INSERT INTO `kp_test_question` VALUES (69, 10, 11, '12321', '我', '', 22.0);

-- ----------------------------
-- Table structure for kp_user
-- ----------------------------
DROP TABLE IF EXISTS `kp_user`;
CREATE TABLE `kp_user`  (
  `uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(35) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `sex` enum('m','f') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'm' COMMENT '性别',
  `student_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学号/身份证',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登录密码',
  `school` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学校',
  `majors` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '专业',
  `grade` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '年级',
  `course` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '科目',
  `section` int(11) NULL DEFAULT NULL COMMENT '所属分类kp_section.id',
  `last_login` datetime NULL DEFAULT NULL COMMENT '最后登录时间',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of kp_user
-- ----------------------------
INSERT INTO `kp_user` VALUES (1, '逍遥1', 'm', '123456', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (2, '逍遥2', 'm', '1234567', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (3, '逍遥3', 'm', '2345678', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (4, '逍遥4', 'f', '3456789', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (5, '逍遥5', 'm', '4567900', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (6, '逍遥6', 'm', '5679011', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (7, '逍遥7', 'f', '6790122', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (8, '逍遥8', 'm', '7901233', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (9, '逍遥9', 'm', '9012344', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (10, '逍遥10', 'm', '10123455', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (11, '逍遥11', 'f', '11234566', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (12, '逍遥12', 'm', '12345677', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (13, '逍遥13', 'm', '13456788', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (16, '逍遥1', 'm', '123456', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (17, '逍遥2', 'm', '1234567', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (18, '逍遥3', 'm', '2345678', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (19, '逍遥4', 'f', '3456789', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (20, '逍遥5', 'm', '4567900', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (21, '逍遥6', 'm', '5679011', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (22, '逍遥7', 'f', '6790122', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (23, '逍遥8', 'm', '7901233', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (24, '逍遥9', 'm', '9012344', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (25, '逍遥10', 'm', '10123455', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (26, '逍遥11', 'f', '11234566', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (27, '逍遥12', 'm', '12345677', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (28, '逍遥13', 'm', '13456788', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (29, '逍遥1', 'm', '123456', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (30, '逍遥2', 'm', '1234567', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (31, '逍遥3', 'm', '2345678', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (32, '逍遥4', 'f', '3456789', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (33, '逍遥5', 'm', '4567900', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (34, '逍遥6', 'm', '5679011', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (35, '逍遥7', 'f', '6790122', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (36, '逍遥8', 'm', '7901233', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (37, '逍遥9', 'm', '9012344', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (38, '逍遥10', 'm', '10123455', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (39, '逍遥11', 'f', '11234566', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (40, '逍遥12', 'm', '12345677', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (41, '逍遥13', 'm', '13456788', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '机电一体化', '2020', '电子信息', NULL, NULL);
INSERT INTO `kp_user` VALUES (42, '测试1', 'm', '123456', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (43, '张三', 'm', '1154787845', 'c89ea9bfcfd8f98ebc6f6bce8e5b9953', 'ddd', 'hhh', '1', '3', 4, NULL);
INSERT INTO `kp_user` VALUES (44, '李四', 'm', '5454', '2bda8a1ac2fa095124eac8531b0f3623', 'ddd', 'hhh', '1', '电子商务', 4, NULL);
INSERT INTO `kp_user` VALUES (45, 'test12', 'm', '123456789', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (46, 'test45', 'm', '6543210', '2bda8a1ac2fa095124eac8531b0f3623', 'ddd', 'hhh', '1', '3', 4, NULL);
INSERT INTO `kp_user` VALUES (47, '王二1', 'm', '111111', 'b478e6374a743dbe27b95deda11d085c', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (48, '王二2', 'm', '111111', 'b478e6374a743dbe27b95deda11d085c', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (49, '王二3', 'm', '111111', 'b478e6374a743dbe27b95deda11d085c', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (50, '王二4', 'm', '111111', 'b478e6374a743dbe27b95deda11d085c', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (51, '王二7', 'm', '111111', 'b478e6374a743dbe27b95deda11d085c', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (52, '王二5', 'm', '111111', 'b478e6374a743dbe27b95deda11d085c', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (53, '王二6', 'm', '111111', 'b478e6374a743dbe27b95deda11d085c', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (54, '王二8', 'm', '111111', 'b478e6374a743dbe27b95deda11d085c', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (55, '王二9', 'm', '111111', 'b478e6374a743dbe27b95deda11d085c', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (56, '王二10', 'm', '111111', 'b478e6374a743dbe27b95deda11d085c', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (57, '王二11', 'm', '111111', 'b478e6374a743dbe27b95deda11d085c', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (58, '王二12', 'm', '111111', 'b478e6374a743dbe27b95deda11d085c', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (59, 'CESHI', 'm', '32128319930430451261', '2905c5b6ec2cf67bfa6a65d3449de4a3', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (60, '11', 'm', '32128319930430451261', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (61, '67', 'm', '32128319930430451261', '2bda8a1ac2fa095124eac8531b0f3623', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);
INSERT INTO `kp_user` VALUES (63, 'SSS', 'm', '111', 'ec90381b6113935a4c8146ed85a876e6', '安徽大学', '计算机', '2020', '电子商务', 1, NULL);

-- ----------------------------
-- Table structure for kp_user_test
-- ----------------------------
DROP TABLE IF EXISTS `kp_user_test`;
CREATE TABLE `kp_user_test`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '学生UID',
  `test_num` int(11) NOT NULL COMMENT '试卷ID=kp_test.id',
  `test_id` int(11) NOT NULL COMMENT '试题主键',
  `question_type` int(11) NOT NULL COMMENT '试题类型',
  `user_anwser` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学生答案',
  `true_anwser` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '正确答案',
  `is_true` tinyint(1) NOT NULL COMMENT '是否正确',
  `score` int(11) NOT NULL COMMENT '当前题目所得分数',
  `create_time` int(11) NOT NULL COMMENT '考试结束时间',
  `is_review` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否阅卷 1是',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 172 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kp_user_test
-- ----------------------------
INSERT INTO `kp_user_test` VALUES (162, 55, 20, 5, 3, 'no', 'yes', 0, 0, 1600360872, 0);
INSERT INTO `kp_user_test` VALUES (163, 55, 20, 7, 4, '', '下划线', 0, 0, 1600360872, 0);
INSERT INTO `kp_user_test` VALUES (164, 55, 20, 10, 4, '', '下划线', 0, 0, 1600360872, 0);
INSERT INTO `kp_user_test` VALUES (165, 55, 20, 16, 4, '', '下划线', 0, 0, 1600360872, 0);
INSERT INTO `kp_user_test` VALUES (166, 55, 20, 17, 4, '', '下划线', 0, 0, 1600360872, 0);
INSERT INTO `kp_user_test` VALUES (167, 58, 23, 7, 4, '', '下划线', 0, 0, 1600445427, 0);
INSERT INTO `kp_user_test` VALUES (168, 58, 23, 10, 4, '', '下划线', 0, 0, 1600445427, 0);
INSERT INTO `kp_user_test` VALUES (169, 58, 23, 16, 4, '', '下划线', 0, 0, 1600445427, 0);
INSERT INTO `kp_user_test` VALUES (170, 58, 23, 17, 4, '', '下划线', 0, 0, 1600445427, 0);
INSERT INTO `kp_user_test` VALUES (171, 63, 28, 59, 4, '', '没有答案', 0, 0, 1600624551, 0);
INSERT INTO `kp_user_test` VALUES (113, 4, 11, 17, 4, '', '下划线', 0, 0, 1600349176, 0);
INSERT INTO `kp_user_test` VALUES (112, 4, 11, 16, 4, '', '下划线', 0, 0, 1600349176, 0);
INSERT INTO `kp_user_test` VALUES (111, 4, 11, 10, 4, '', '下划线', 0, 0, 1600349176, 0);
INSERT INTO `kp_user_test` VALUES (110, 4, 11, 7, 4, '', '下划线', 0, 0, 1600349176, 0);
INSERT INTO `kp_user_test` VALUES (109, 4, 11, 8, 3, 'yes', 'yes', 1, 10, 1600349176, 0);
INSERT INTO `kp_user_test` VALUES (108, 4, 11, 5, 3, 'yes', 'yes', 1, 10, 1600349176, 0);
INSERT INTO `kp_user_test` VALUES (94, 3, 11, 5, 3, 'yes', 'yes', 1, 10, 1600312343, 0);
INSERT INTO `kp_user_test` VALUES (95, 3, 11, 8, 3, 'no', 'yes', 0, 0, 1600312343, 0);
INSERT INTO `kp_user_test` VALUES (96, 3, 11, 6, 1, 'B', 'D', 0, 0, 1600312343, 0);
INSERT INTO `kp_user_test` VALUES (97, 3, 11, 9, 1, 'B', 'D', 0, 0, 1600312343, 0);
INSERT INTO `kp_user_test` VALUES (98, 3, 11, 11, 1, 'B', 'D', 0, 0, 1600312343, 0);
INSERT INTO `kp_user_test` VALUES (99, 3, 11, 12, 1, 'A', 'C', 0, 0, 1600312343, 0);
INSERT INTO `kp_user_test` VALUES (100, 3, 11, 13, 1, 'A', 'D', 0, 0, 1600312343, 0);
INSERT INTO `kp_user_test` VALUES (101, 3, 11, 14, 1, 'A', 'D', 0, 0, 1600312343, 0);
INSERT INTO `kp_user_test` VALUES (102, 3, 11, 15, 1, 'B', 'A', 0, 0, 1600312343, 0);
INSERT INTO `kp_user_test` VALUES (103, 3, 11, 7, 4, '33', '下划线', 0, 0, 1600312343, 0);
INSERT INTO `kp_user_test` VALUES (104, 3, 11, 10, 4, '33', '下划线', 0, 0, 1600312343, 0);
INSERT INTO `kp_user_test` VALUES (105, 3, 11, 16, 4, '33', '下划线', 0, 0, 1600312343, 0);
INSERT INTO `kp_user_test` VALUES (106, 3, 11, 17, 4, '333', '下划线', 0, 0, 1600312343, 0);
INSERT INTO `kp_user_test` VALUES (107, 3, 11, 38, 2, 'B', 'A,B,C', 0, 0, 1600312343, 0);
INSERT INTO `kp_user_test` VALUES (161, 54, 20, 17, 4, '', '下划线', 0, 0, 1600360257, 0);
INSERT INTO `kp_user_test` VALUES (157, 54, 20, 5, 3, 'no', 'yes', 0, 0, 1600360257, 0);
INSERT INTO `kp_user_test` VALUES (158, 54, 20, 7, 4, '', '下划线', 0, 0, 1600360257, 0);
INSERT INTO `kp_user_test` VALUES (159, 54, 20, 10, 4, '', '下划线', 0, 0, 1600360257, 0);
INSERT INTO `kp_user_test` VALUES (160, 54, 20, 16, 4, '', '下划线', 0, 0, 1600360257, 0);

SET FOREIGN_KEY_CHECKS = 1;
