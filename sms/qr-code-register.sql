/*
MySQL Data Transfer
Source Host: localhost
Source Database: qr-code-register
Target Host: localhost
Target Database: qr-code-register
Date: 8/23/2018 10:00:58 AM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for tbl_department
-- ----------------------------
CREATE TABLE `tbl_department` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(100) DEFAULT NULL,
  `position_dep` varchar(100) DEFAULT NULL,
  `active_status` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_employee
-- ----------------------------
CREATE TABLE `tbl_employee` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `sname` varchar(100) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `qrcode` varchar(100) DEFAULT NULL,
  `register_status` varchar(1) DEFAULT NULL,
  `register_dte_tme` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `register_by` varchar(100) DEFAULT NULL,
  `register_by_user` varchar(100) DEFAULT NULL,
  `sms` varchar(1) DEFAULT NULL,
  `department` varchar(10) DEFAULT NULL,
  `position_dep` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_game
-- ----------------------------
CREATE TABLE `tbl_game` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `game_desc` varchar(200) DEFAULT NULL,
  `choice_1` varchar(100) DEFAULT NULL,
  `score_1` double DEFAULT NULL,
  `choice_2` varchar(100) DEFAULT NULL,
  `score_2` double DEFAULT NULL,
  `choice_3` varchar(100) DEFAULT NULL,
  `score_3` double DEFAULT NULL,
  `choice_4` varchar(100) DEFAULT NULL,
  `score_4` double DEFAULT NULL,
  `play_time` int(11) NOT NULL,
  `peried_time_begin` datetime NOT NULL,
  `peried_time_end` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_game_answer
-- ----------------------------
CREATE TABLE `tbl_game_answer` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(100) DEFAULT NULL,
  `game_id` varchar(100) DEFAULT NULL,
  `choice_id` varchar(100) DEFAULT NULL,
  `choice_score` double DEFAULT NULL,
  `playgame_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_question
-- ----------------------------
CREATE TABLE `tbl_question` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `question_desc` varchar(100) DEFAULT NULL,
  `choice_1` varchar(100) DEFAULT NULL,
  `score_1` double(10,0) DEFAULT NULL,
  `choice_2` varchar(100) DEFAULT NULL,
  `score_2` double(10,0) DEFAULT NULL,
  `choice_3` varchar(100) DEFAULT NULL,
  `score_3` double(10,0) DEFAULT NULL,
  `choice_4` varchar(100) DEFAULT NULL,
  `score_4` double(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_question_answer
-- ----------------------------
CREATE TABLE `tbl_question_answer` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(100) DEFAULT NULL,
  `question_id` varchar(100) DEFAULT NULL,
  `choice_id` varchar(1) DEFAULT NULL,
  `choice_score` double(10,0) DEFAULT NULL,
  `create_dtetme` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
CREATE TABLE `tbl_user` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `fname` varchar(100) DEFAULT NULL,
  `sname` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `tel` varchar(10) DEFAULT NULL,
  `status_active` varchar(1) DEFAULT NULL,
  `status_position` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `tbl_department` VALUES ('1', 'กฟน.', null, 'y');
INSERT INTO `tbl_department` VALUES ('2', 'การปะปา', null, 'y');
INSERT INTO `tbl_department` VALUES ('3', 'การท่าอากาสยาน', null, 'y');
INSERT INTO `tbl_employee` VALUES ('7', 'นาย', 'Narabhattara', 'Jankeaw', '0890332907', '0890332907', 'n', '2018-08-22 05:05:39', 'Web App', '3', null, '1', null);
INSERT INTO `tbl_employee` VALUES ('8', 'นาย', 'นรภทร', 'จันทร์แก้ว', '0890332906', '0890332906', 'y', '2018-08-22 13:48:32', 'Web App', '3', null, '2', null);
INSERT INTO `tbl_employee` VALUES ('9', null, 'สมชาย', 'สมหวัง', '0890002434', '0890002434', 'y', '2018-08-22 08:05:43', 'Mobile App', '3', null, null, null);
INSERT INTO `tbl_employee` VALUES ('10', null, 'Somchai', 'Somsir', '0816651234', '0816651234', 'y', '2018-08-22 08:04:12', 'Mobile App', '3', null, null, null);
INSERT INTO `tbl_game` VALUES ('3', 'บิดาแห่งการไฟฟ้าไทย คือบุคคลใดปปป', 'พระบามสมเด็จพระจุลจอมเกล้าเจ้าอยู่', '0', 'สมเด็จพระเจ้าบรมวงศ์เธอกรมพระยาเทววงศ์วโรปการ', '1', 'จอมพลและมหาอำมาตย์เอกเจ้าพระยาสุรศักดิ์มนตรี (เจิม แสงชูโต)', '0', 'เจ้าพระยายมราช (ปั้น สุขุม)', '0', '30', '2018-09-10 09:45:00', '2018-09-10 10:00:20');
INSERT INTO `tbl_game` VALUES ('4', 'ทำเนียบผู้ว่าการไฟฟ้านครหลวง ตั้งแต่ปี 2501-2561 มีจำนวนกี่ท่าน', '12', '0', '14', '0', '16', '1', '18', '0', '30', '2018-09-11 11:35:00', '2018-09-11 12:00:00');
INSERT INTO `tbl_game` VALUES ('5', 'อุโมงค์สายส่งไฟฟ้าใต้ดินขนาดใหญ่ที่สุดในประเทศไทย สร้างขึ้นเมื่อ พ.ศ.', '2540', '0', '2542', '0', '2546', '0', '2548', '1', '30', '2018-09-11 13:30:00', '2018-09-11 13:55:00');
INSERT INTO `tbl_question` VALUES ('7', 'ท่านประทับใจการจัดกิจกรรมภายในงานเพียงใด', 'มาก', '4', 'ค่อนข้างมาก', '3', 'ปานกลาง', '2', 'น้อย', '1');
INSERT INTO `tbl_question` VALUES ('8', 'เนื้อหาความรู้ที่จัดแสดง', 'ดีมาก', '4', 'ดี', '3', 'ปานกลาง', '2', 'น้อย', '1');
INSERT INTO `tbl_user` VALUES ('3', 'Narajan', 'Jan', 'hrung', 'hrung', '0890332906', 'y', 'Admin');
INSERT INTO `tbl_user` VALUES ('4', 'Kanyapat', 'Sarapee', 'kanyapat', 'kanyapat', '9999999999', 'y', 'Admin');
