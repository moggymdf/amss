/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : smartobec

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-08-07 14:43:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `system_department`
-- ----------------------------
DROP TABLE IF EXISTS `system_department`;
CREATE TABLE `system_department` (
  `id` tinyint(4) NOT NULL auto_increment,
  `department` tinyint(4) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `department_precis` varchar(30) NOT NULL,
  `department_order` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `department` (`department`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_department
-- ----------------------------
INSERT INTO `system_department` VALUES ('14', '14', 'สำนักเทคโนโลยีเพื่อการเรียนการสอน', 'สทร.', '0');
INSERT INTO `system_department` VALUES ('13', '13', 'หน่วยตรวจสอบภายใน', 'ตสน.', '0');
INSERT INTO `system_department` VALUES ('12', '12', 'กลุ่มพัฒนาระบบบริหาร', 'กพร.', '0');
INSERT INTO `system_department` VALUES ('11', '11', 'สำนักวิชาการและมาตรฐานการศึกษา', 'สวก.', '0');
INSERT INTO `system_department` VALUES ('10', '10', 'สำนักพัฒนาการศึกษาเขตพัฒนาพิเศษเฉพาะกิจจังหวัดชายแดนภาคใต้', 'สปก.จชต.', '0');
INSERT INTO `system_department` VALUES ('9', '9', 'สำนักการคลังและสินทรัพย์', 'สคส.', '0');
INSERT INTO `system_department` VALUES ('8', '8', 'สำนักบริหารงานการมัธยมศึกษาตอนปลาย', 'สมป.', '0');
INSERT INTO `system_department` VALUES ('6', '5', 'สำนักทดสอบทางการศึกษา', 'สทศ.', '0');
INSERT INTO `system_department` VALUES ('7', '7', 'สำนักพัฒนาครูและบุคลากรทางการศึกษาขั้นพื้นฐาน', 'สพค.', '0');
INSERT INTO `system_department` VALUES ('5', '3', 'สำนักติดตามและประเมินผลการจัดการศึกษาขั้นพื้นฐาน', 'สตผ.', '0');
INSERT INTO `system_department` VALUES ('4', '4', 'สำนักอำนวยการ', 'สอ.', '0');
INSERT INTO `system_department` VALUES ('3', '2', 'สำนักพัฒนาระบบบริหารงานบุคคลและนิติการ', 'สพร.', '0');
INSERT INTO `system_department` VALUES ('2', '6', 'สำนักพัฒนานวัตกรรมการจัดการศึกษา', 'สนก.', '0');
INSERT INTO `system_department` VALUES ('1', '1', 'สำนักนโยบายและแผนการศึกษาขั้นพื้นฐาน', 'สนผ.', '0');
INSERT INTO `system_department` VALUES ('15', '15', 'สำนักพัฒนากิจกรรมนักเรียน', 'สกก.', '0');
INSERT INTO `system_department` VALUES ('16', '16', 'สถาบันภาษาอังกฤษ', 'สภษ.', '0');
INSERT INTO `system_department` VALUES ('17', '17', 'สำนักบริหารงานการศึกษาพิเศษ', 'สศศ.', '0');
INSERT INTO `system_department` VALUES ('18', '18', 'สำนักบริหารงานการศึกษาภาคบังคับ', 'สคบ.', '0');
INSERT INTO `system_department` VALUES ('19', '19', 'ศูนย์พัฒนาการนิเทศและเร่งรัดคุณภาพการศึกษาขั้นพื้นฐาน', 'สนฐ.', '0');
INSERT INTO `system_department` VALUES ('20', '20', 'ศูนย์เฉพาะกิจคุ้มครองและช่วยเหลือเด็กนักเรียน', 'ฉก.ชน.', '0');
INSERT INTO `system_department` VALUES ('21', '21', 'ศูนย์บริหารโครงการพัฒนาโรงเรียนจุฬาภรณฯ', '', '0');
INSERT INTO `system_department` VALUES ('22', '22', 'กลุ่มงานคุ้มครองจริยธรรม', '', '0');
