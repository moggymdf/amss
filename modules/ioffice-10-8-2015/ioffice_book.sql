/*
Navicat MySQL Data Transfer

Source Server         : smart.obec.go.th
Source Server Version : 50505
Source Host           : 10.10.20.21:3306
Source Database       : smartobec

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2015-08-08 14:19:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ioffice_book`
-- ----------------------------
DROP TABLE IF EXISTS `ioffice_book`;
CREATE TABLE `ioffice_book` (
  `bookid` int(11) NOT NULL AUTO_INCREMENT,
  `booktypeid` int(11) NOT NULL DEFAULT '1',
  `bookstatusid` int(11) NOT NULL DEFAULT '1',
  `bookheader` varchar(255) NOT NULL,
  `bookdetail` text,
  `post_personid` varchar(13) NOT NULL,
  `post_positionid` int(11) DEFAULT NULL,
  `post_subdepartmentid` int(11) DEFAULT NULL,
  `post_departmentid` int(11) DEFAULT NULL,
  `consult_departmentid` int(11) DEFAULT NULL,
  `consult_subdepartmentid` int(11) DEFAULT NULL,
  `consult_personid` varchar(13) DEFAULT NULL,
  `postdate` timestamp NULL DEFAULT NULL,
  `updatedate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`bookid`),
  KEY `fk_book1` (`booktypeid`),
  KEY `fk_book2` (`bookstatusid`),
  CONSTRAINT `fk_book1` FOREIGN KEY (`booktypeid`) REFERENCES `ioffice_booktype` (`booktypeid`),
  CONSTRAINT `fk_book2` FOREIGN KEY (`bookstatusid`) REFERENCES `ioffice_bookstatus` (`bookstatusid`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ioffice_book
-- ----------------------------
INSERT INTO `ioffice_book` VALUES ('1', '2', '20', 'ขออนุมัติจัดซื้อระบบ DLTV', 'ขออนุมัติจัดซื้อระบบ DLTV', '3460300107847', null, null, null, null, null, null, '2015-08-04 02:55:34', '2015-08-04 02:59:16');
INSERT INTO `ioffice_book` VALUES ('2', '1', '40', 'แจ้งกรอกข้อมูล DMC', 'แจ้งกรอกข้อมูล DMC', '3460300107847', null, null, null, null, null, null, '2015-08-04 02:55:34', '2015-08-04 12:09:33');
INSERT INTO `ioffice_book` VALUES ('9', '1', '30', 'เชิญประชุมคณะกรรมการเก็บข้อมูล iClassroom', 'เชิญประชุมคณะกรรมการเก็บข้อมูล iClassroom', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-04 10:46:47', '2015-08-04 12:09:27');
INSERT INTO `ioffice_book` VALUES ('12', '1', '3', 'ขอเบิกการศึกษาบุตร', 'ขอเบิกการศึกษาบุตร', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-04 11:32:48', '2015-08-06 15:07:23');
INSERT INTO `ioffice_book` VALUES ('13', '2', '4', 'เชิญประชุมคณะทำงานพัฒนาระบบ Smart OBEC', '<p>เชิญประชุมคณะทำงานพัฒนาระบบ Smart OBEC</p>\r\n', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-04 18:16:48', '2015-08-07 16:53:51');
INSERT INTO `ioffice_book` VALUES ('14', '1', '2', 'แจ้งกรอกข้อมูล DMC ภาคเรียนที่ 1 ประจำปีการศึกษา 2558', '<p>แจ้งกรอกข้อมูล DMC</p>\r\n', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-04 18:17:10', '2015-08-06 15:24:52');
INSERT INTO `ioffice_book` VALUES ('15', '1', '3', 'ขออนุญาตปรับปรุงระบบอินเตอร์เน็ตไร้สาย สำนักอำนวยการ', 'ขออนุญาตปรับปรุงระบบอินเตอร์เน็ตไร้สาย สำนักอำนวยการ', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-04 18:41:47', '2015-08-04 18:43:48');
INSERT INTO `ioffice_book` VALUES ('16', '2', '1', 'test', 'test', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-04 21:53:35', null);
INSERT INTO `ioffice_book` VALUES ('17', '1', '1', 'test', 'test', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-04 21:58:26', null);
INSERT INTO `ioffice_book` VALUES ('18', '1', '1', 'TESt', 'test', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-04 21:59:48', null);
INSERT INTO `ioffice_book` VALUES ('19', '1', '1', 'TESt', 'test', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-04 22:01:07', null);
INSERT INTO `ioffice_book` VALUES ('21', '1', '1', 'test', 'test', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-04 22:09:38', null);
INSERT INTO `ioffice_book` VALUES ('22', '1', '3', 'fasdf', 'asdfas', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-04 22:14:44', '2015-08-04 22:44:17');
INSERT INTO `ioffice_book` VALUES ('23', '1', '1', 'asdfsdf', 'asdf', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-04 22:15:33', null);
INSERT INTO `ioffice_book` VALUES ('25', '2', '1', 'aasdfsdfs', 'gesdfsdf', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-04 22:18:43', '2015-08-04 22:44:10');
INSERT INTO `ioffice_book` VALUES ('27', '1', '1', 'asdf  asdfasdfasdf', 'asdfsdfasdfasdf', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-04 22:27:44', null);
INSERT INTO `ioffice_book` VALUES ('28', '2', '40', 'rtyerty', 'ertyerty', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 06:17:33', '2015-08-05 21:37:25');
INSERT INTO `ioffice_book` VALUES ('29', '1', '30', 'ขออนุญาตปรับปรุงระบบอินเตอร์เน็ตไร้สาย สำนักอำนวยการ', '<p>ขออนุญาตปรับปรุงระบบอินเตอร์เน็ตไร้สาย สำนักอำนวยการasdf</p>\r\n\r\n<p>asdf</p>\r\n\r\n<p>asd</p>\r\n\r\n<p>fa</p>\r\n\r\n<p>sd</p>\r\n\r\n<p>fasdf</p>\r\n\r\n<p>as</p>\r\n\r\n<p>df</p>\r\n\r\n<p>as</p>\r\n\r\n<p>df</p>\r\n\r\n<p>a</p>\r\n', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 07:09:38', '2015-08-05 19:06:22');
INSERT INTO `ioffice_book` VALUES ('31', '1', '1', 'fdgdfgdfg', 'dfgadfasdf', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 10:35:00', null);
INSERT INTO `ioffice_book` VALUES ('32', '1', '1', 'uiklul', 'yuilyuil', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 10:36:03', null);
INSERT INTO `ioffice_book` VALUES ('33', '1', '1', 'ol;uilui', 'lyuiluil', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 10:37:08', null);
INSERT INTO `ioffice_book` VALUES ('34', '1', '1', 'ghjk', 'ghjkhjkldfsaf', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 10:38:55', null);
INSERT INTO `ioffice_book` VALUES ('35', '1', '1', 'asdfasdfsdf', 'asdfasdfasdfsdfsdfsdf', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 10:51:38', null);
INSERT INTO `ioffice_book` VALUES ('36', '2', '1', 'xcvzxcvzxc', 'vzxcvzxcvxc', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 10:52:56', null);
INSERT INTO `ioffice_book` VALUES ('37', '1', '1', 'zxczxc', 'zxczxczxc', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 10:54:31', '2015-08-05 12:41:30');
INSERT INTO `ioffice_book` VALUES ('38', '1', '1', 'kkyukyukyuk', 'yukyukyukyuk', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 10:55:51', '2015-08-05 12:42:22');
INSERT INTO `ioffice_book` VALUES ('39', '1', '1', 'fgdfgdf', 'gasdfasdf', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 10:58:55', '2015-08-05 11:58:53');
INSERT INTO `ioffice_book` VALUES ('40', '1', '21', 'uilyuilyuiluil', 'yuilujhjkhjkhjk', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 11:07:49', '2015-08-05 18:33:39');
INSERT INTO `ioffice_book` VALUES ('41', '1', '1', 'ทดทด', 'ทดสอบ', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 11:13:26', '2015-08-05 12:54:46');
INSERT INTO `ioffice_book` VALUES ('42', '1', '20', 'ทดสอบระบบฮ๊า', '<p><span style=\"font-family:courier new,courier,monospace\"><span style=\"font-size:16px\">ทดสอบระบบฮ๊า</span></span></p>\r\n', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 13:11:43', '2015-08-05 18:30:19');
INSERT INTO `ioffice_book` VALUES ('43', '2', '3', 'asdfasdf', '<p>sdfasdf</p>\r\n\r\n<p>asd</p>\r\n\r\n<p>f</p>\r\n\r\n<p>asd</p>\r\n', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 13:47:07', '2015-08-05 23:24:39');
INSERT INTO `ioffice_book` VALUES ('44', '2', '3', 'ขออนุญาตปรับปรุงระบบอินเตอร์เน็ตไร้สาย สำนักอำนวยการ', '<p>ขออนุญาตปรับปรุงระบบอินเตอร์เน็ตไร้สาย สำนักอำนวยการ</p>\r\n', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 21:38:02', '2015-08-06 15:08:20');
INSERT INTO `ioffice_book` VALUES ('62', '2', '1', 'asdfasdf', '<p>sdfasdf</p>\r\n\r\n<p>asd</p>\r\n\r\n<p>f</p>\r\n\r\n<p>asd</p>\r\n', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-05 23:39:31', '2015-08-05 23:39:53');
INSERT INTO `ioffice_book` VALUES ('63', '1', '20', 'ขออนุมัติจัดประชุม ', '<p>ดเหฟกดเหกฟหกดฃหฃฃ</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>ฟหกดฟหก</p>\r\n\r\n<p>ห</p>\r\n\r\n<p>กดฟหกด</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>หกดหก</p>\r\n', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-06 11:11:55', '2015-08-06 11:35:53');
INSERT INTO `ioffice_book` VALUES ('64', '2', '4', 'rtyerty', '<p>ertyerty</p>\r\n', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-06 11:39:37', '2015-08-07 08:46:21');
INSERT INTO `ioffice_book` VALUES ('66', '1', '1', 'test', '<p>test</p>\r\n', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-06 15:44:47', null);
INSERT INTO `ioffice_book` VALUES ('67', '2', '2', 'ขออนุญาตจัดงานวันเกษียณอายุราชการประจำปี 2558', '<p><span style=\"font-family:courier new,courier,monospace\"><span style=\"font-size:16px\">&nbsp; &nbsp; &nbsp;ด้วย สำนักงานเขตพื้นที่การศึกษาประถมศึกษากาฬสินธุ์ เขต 3 จะจัดให้มีงานมุฒิตาจิตรสำหรับผู้เกษียณอายุราชการ ในวันที่ 30 กันยายน 2558 จึงขอเชิญคณะครูและผู้บริหารโรงเรียนร่วมงานในวันเวลาดังกล่าว</span></span></p>\r\n\r\n<p><span style=\"font-size:16px\">เพื่อทราบ</span><br />\r\n<span style=\"font-size:16px\">เพื่อโปรดพิจารณา<br />\r\nเพื่อลงนามในหนังสือส่ง</span></p>\r\n', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-06 23:41:03', '2015-08-06 23:43:07');
INSERT INTO `ioffice_book` VALUES ('68', '1', '20', 'ขอลาบวช', '', '3460300107847', '44', '1403', '14', null, null, null, '2015-08-07 09:18:47', '2015-08-07 09:30:26');
INSERT INTO `ioffice_book` VALUES ('69', '1', '2', 'ขอนุมัติจัดซื้อระบบ DLTV', '<p>ขอนุมัติจัดซื้อระบบ DLTV</p>\r\n', '123456', '9', '0', '2', null, null, null, '2015-08-07 11:11:08', '2015-08-08 09:07:30');
INSERT INTO `ioffice_book` VALUES ('70', '1', '3', 'Test', '', '123456', '9', '0', '2', null, null, null, '2015-08-07 12:52:01', '2015-08-07 15:47:23');
INSERT INTO `ioffice_book` VALUES ('72', '1', '1', 'ขออนุญาตจัดประชุมวิชาการประจำปีงบประมาณปีนี้', '<p>อยากกินเค้กกกครับแต่ถ้าไม่รักกันดีนะที่ทำให้ฉันได้แต่คิดอย่าให้มันรู้ได้ไงงงเลยชึ่งงงเลยนะเนี่ยว่าจะไม่ไปแล้วครับผมเราหล่ะครับทำอะไรก็ทำไม่ได้เลยค่ะแต่ก็ไม่บอกหรอกนะครับแหม่แหม่ถ้าไม่รักกันดีว่าเป็นคนแรกเลยที่ได้จากที่ไหน</p>\r\n', '123456', '9', '0', '2', null, null, null, '2015-08-07 15:34:58', null);
INSERT INTO `ioffice_book` VALUES ('73', '1', '1', 'Test', '', '123456', '9', '0', '2', null, null, null, '2015-08-07 15:47:38', '2015-08-07 15:48:28');

-- ----------------------------
-- Table structure for `ioffice_bookcomment`
-- ----------------------------
DROP TABLE IF EXISTS `ioffice_bookcomment`;
CREATE TABLE `ioffice_bookcomment` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT,
  `bookid` int(11) NOT NULL,
  `bookstatusid` int(11) NOT NULL,
  `comment_personid` varchar(13) NOT NULL,
  `comment_positionid` int(11) NOT NULL,
  `comment_subdepartmentid` int(11) DEFAULT NULL,
  `comment_departmentid` int(11) DEFAULT NULL,
  `commentdetail` text,
  `commentdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`commentid`),
  KEY `fk_bookcomment1` (`bookid`),
  KEY `fk_bookcomment2` (`bookstatusid`),
  CONSTRAINT `fk_bookcomment1` FOREIGN KEY (`bookid`) REFERENCES `ioffice_book` (`bookid`),
  CONSTRAINT `fk_bookcomment2` FOREIGN KEY (`bookstatusid`) REFERENCES `ioffice_bookstatus` (`bookstatusid`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ioffice_bookcomment
-- ----------------------------
INSERT INTO `ioffice_bookcomment` VALUES ('1', '42', '20', '3460300107847', '0', null, null, 'ฟหกด', null);
INSERT INTO `ioffice_bookcomment` VALUES ('2', '42', '20', '3460300107847', '0', null, null, 'ฟหกด', null);
INSERT INTO `ioffice_bookcomment` VALUES ('3', '40', '2', '3460300107847', '0', null, null, 'กดฟหกดหกด', null);
INSERT INTO `ioffice_bookcomment` VALUES ('4', '40', '2', '3460300107847', '0', null, null, 'กดฟหกดหกด', null);
INSERT INTO `ioffice_bookcomment` VALUES ('5', '40', '21', '3460300107847', '44', '1403', '14', 'ฟหกดหกด', '2015-08-05 18:33:39');
INSERT INTO `ioffice_bookcomment` VALUES ('6', '29', '2', '3460300107847', '44', '1403', '14', 'ฟหกดหกด', '2015-08-05 18:53:55');
INSERT INTO `ioffice_bookcomment` VALUES ('7', '28', '2', '3460300107847', '44', '1403', '14', 'ให้ปฏิบัติตามระเบียบอย่างเคร่งครัด', '2015-08-05 18:58:54');
INSERT INTO `ioffice_bookcomment` VALUES ('8', '29', '30', '3460300107847', '44', '1403', '14', 'ให้นำงบประมาณไปใช้ในโครงการเพื่อการเรียนการสอน', '2015-08-05 19:06:22');
INSERT INTO `ioffice_bookcomment` VALUES ('9', '28', '40', '3460300107847', '44', '1403', '14', '', '2015-08-05 21:37:25');
INSERT INTO `ioffice_bookcomment` VALUES ('10', '44', '2', '3460300107847', '44', '1403', '14', 'เห็นควรอนุมัติ', '2015-08-05 21:44:56');
INSERT INTO `ioffice_bookcomment` VALUES ('11', '63', '2', '3460300107847', '44', '1403', '14', 'เห็นชอบ', '2015-08-06 11:20:58');
INSERT INTO `ioffice_bookcomment` VALUES ('12', '63', '2', '3460300107847', '44', '1403', '14', 'เห็นควรอนุมัติ', '2015-08-06 11:22:06');
INSERT INTO `ioffice_bookcomment` VALUES ('13', '63', '20', '3460300107847', '44', '1403', '14', 'ให้ปฏิบัติตามระเบียบอย่างเคร่งครัด', '2015-08-06 11:35:53');
INSERT INTO `ioffice_bookcomment` VALUES ('14', '14', '2', '3460300107847', '44', '1403', '14', 'TEST', '2015-08-06 15:24:52');
INSERT INTO `ioffice_bookcomment` VALUES ('15', '13', '2', '3460300107847', '44', '1403', '14', 'เห็นควรอนุมัติ', '2015-08-06 16:28:52');
INSERT INTO `ioffice_bookcomment` VALUES ('16', '64', '2', '3102002801481', '49', '1403', '14', 'เห็นควรอนุมัติ', '2015-08-06 16:39:48');
INSERT INTO `ioffice_bookcomment` VALUES ('17', '67', '2', '3460300107847', '44', '1403', '14', 'เห็นควรพิจารณาอนุมัติ', '2015-08-06 23:43:07');
INSERT INTO `ioffice_bookcomment` VALUES ('18', '13', '4', '3460300107847', '44', '1403', '14', 'ขอปรึกษาเรื่องสถานที่ในการจัดกิจกรรม', '2015-08-07 08:21:41');
INSERT INTO `ioffice_bookcomment` VALUES ('19', '13', '2', '3460300107847', '44', '1403', '14', 'เสนอให้จัดกิจกรรมที่โรงเรียนใกล้เคียง สพฐ.', '2015-08-07 08:25:17');
INSERT INTO `ioffice_bookcomment` VALUES ('20', '64', '4', '3460300107847', '44', '1403', '14', 'ขอทราบรายละเอียดในการใช้จ่ายงบประมาณ', '2015-08-07 08:46:21');
INSERT INTO `ioffice_bookcomment` VALUES ('21', '13', '2', '3102002801481', '49', '1403', '14', 'เห็นควรอนุมัติ', '2015-08-07 09:04:17');
INSERT INTO `ioffice_bookcomment` VALUES ('22', '68', '4', '3102002801481', '49', '1403', '14', 'มันจะรอดเหรอ คิดว่า ?', '2015-08-07 09:20:39');
INSERT INTO `ioffice_bookcomment` VALUES ('23', '68', '2', '3149700034660', '49', '1403', '14', 'ไม่รอดหรอก จริงๆ', '2015-08-07 09:29:00');
INSERT INTO `ioffice_bookcomment` VALUES ('24', '68', '20', '3102002801481', '49', '1403', '14', 'ให้เตรียมเครื่องคอมไปทำงานที่วัดด้วย\r\nอนุมัติ', '2015-08-07 09:30:26');
INSERT INTO `ioffice_bookcomment` VALUES ('25', '13', '4', '123456', '9', '0', '2', 'iuguighiouh', '2015-08-07 11:15:17');
INSERT INTO `ioffice_bookcomment` VALUES ('26', '13', '2', '123456', '9', '0', '2', 'uoygytftur', '2015-08-07 11:15:39');
INSERT INTO `ioffice_bookcomment` VALUES ('27', '13', '4', '123456', '9', '0', '2', 'ตามโครงสร้างสามารถดำเนินการได้หรือไม่', '2015-08-07 16:53:51');
INSERT INTO `ioffice_bookcomment` VALUES ('28', '69', '2', '123456', '9', '0', '2', 'เห็นควรอนุมัติ', '2015-08-08 09:07:30');

-- ----------------------------
-- Table structure for `ioffice_bookfile`
-- ----------------------------
DROP TABLE IF EXISTS `ioffice_bookfile`;
CREATE TABLE `ioffice_bookfile` (
  `fileid` int(11) NOT NULL AUTO_INCREMENT,
  `bookid` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filedesc` varchar(255) NOT NULL,
  `filetype` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`fileid`),
  KEY `fk_bookfile1` (`bookid`),
  CONSTRAINT `fk_bookfile1` FOREIGN KEY (`bookid`) REFERENCES `ioffice_book` (`bookid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ioffice_bookfile
-- ----------------------------
INSERT INTO `ioffice_bookfile` VALUES ('4', '39', './modules/ioffice/upload/39-2-1438747135.xlsx', 'ข้อมูลจำนวนนักเรียน.xlsx', 'xlsx');
INSERT INTO `ioffice_bookfile` VALUES ('5', '40', './modules/ioffice/upload/40-2-1438747670.xlsx', 'ประธานกลุ่มสถานศึกษา.xlsx', 'xlsx');
INSERT INTO `ioffice_bookfile` VALUES ('6', '40', './modules/ioffice/upload/40-3-1438747670.pdf', 'ประวัติและผลงาน-บอย.pdf', 'pdf');
INSERT INTO `ioffice_bookfile` VALUES ('9', '41', './modules/ioffice/upload/41-3-1438751473.pdf', 'แบบตอบรับการเข้าร่วมประชุมThaiCERT.pdf', 'pdf');
INSERT INTO `ioffice_bookfile` VALUES ('11', '37', './modules/ioffice/upload/37-1-1438753291.xlsx', 'ประธานกลุ่มสถานศึกษา.xlsx', 'xlsx');
INSERT INTO `ioffice_bookfile` VALUES ('12', '38', './modules/ioffice/upload/38-1-1438753343.xls', 'แบบสำรวจ ส่ง Cat.xls', 'xls');
INSERT INTO `ioffice_bookfile` VALUES ('13', '41', './modules/ioffice/upload/41-2-1438754029.xlsx', 'จัดสรรคอมกาละสิน3ปี52-54.xlsx', 'xlsx');
INSERT INTO `ioffice_bookfile` VALUES ('15', '41', './modules/ioffice/upload/41-4-1438754073.pdf', 'แบบตอบรับประชุม พรบ.อำนวยความสะดวก.pdf', 'pdf');
INSERT INTO `ioffice_bookfile` VALUES ('16', '42', './modules/ioffice/upload/42-1-1438756154.jpg', 'BOY.jpg', 'jpg');
INSERT INTO `ioffice_bookfile` VALUES ('18', '42', './modules/ioffice/upload/42-2-1438756245.pdf', 'แบบตอบรับการเข้าร่วมประชุมThaiCERT.pdf', 'pdf');
INSERT INTO `ioffice_bookfile` VALUES ('19', '43', './modules/ioffice/upload/43-1-1438757227.pdf', 'IPADหนังสือแจ้งจัดสรร+เงินงวด.pdf', 'pdf');
INSERT INTO `ioffice_bookfile` VALUES ('20', '43', './modules/ioffice/upload/43-2-1438761506.jpg', 'image.jpg', 'jpg');
INSERT INTO `ioffice_bookfile` VALUES ('21', '43', './modules/ioffice/upload/43-3-1438761506.jpg', 'image.jpg', 'jpg');
INSERT INTO `ioffice_bookfile` VALUES ('22', '44', './modules/ioffice/upload/44-1-1438785500.pdf', 'แบบตอบรับการเข้าร่วมประชุมThaiCERT.pdf', 'pdf');
INSERT INTO `ioffice_bookfile` VALUES ('23', '13', './modules/ioffice/upload/13-1-1438787981.xls', 'OBEC-SMIS-CODE.xls', 'xls');
INSERT INTO `ioffice_bookfile` VALUES ('34', '62', './modules/ioffice/upload/43-1-1438757227.pdf', 'IPADหนังสือแจ้งจัดสรร+เงินงวด.pdf', 'pdf');
INSERT INTO `ioffice_bookfile` VALUES ('36', '62', './modules/ioffice/upload/43-3-1438761506.jpg', 'image.jpg', 'jpg');
INSERT INTO `ioffice_bookfile` VALUES ('37', '63', './modules/ioffice/upload/63-1-1438834316.xls', 'ชื่อและเบอร์โทรศัพท์-กส3.xls', 'xls');
INSERT INTO `ioffice_bookfile` VALUES ('38', '63', './modules/ioffice/upload/63-2-1438834316.pdf', 'บัตรประชาชน-รองธนาดุล.pdf', 'pdf');
INSERT INTO `ioffice_bookfile` VALUES ('39', '63', './modules/ioffice/upload/63-3-1438834316.xlsx', 'จัดสรรคอมกาละสิน3ปี52-54.xlsx', 'xlsx');
INSERT INTO `ioffice_bookfile` VALUES ('40', '64', './modules/ioffice/upload/64-1-1438836140.png', 'Pasakorn-Signature.png', 'png');
INSERT INTO `ioffice_bookfile` VALUES ('41', '64', './modules/ioffice/upload/64-2-1438836140.pdf', 'แบบตอบรับการเข้าร่วมประชุมThaiCERT.pdf', 'pdf');
INSERT INTO `ioffice_bookfile` VALUES ('42', '64', './modules/ioffice/upload/64-3-1438836140.pdf', 'ขึ้นเงินเดือน1ตุลาคม57.pdf', 'pdf');
INSERT INTO `ioffice_bookfile` VALUES ('43', '67', './modules/ioffice/upload/67-1-1438879263.pdf', 'ประชุม e-office ครั้งที่ 2.pdf', 'pdf');
INSERT INTO `ioffice_bookfile` VALUES ('44', '67', './modules/ioffice/upload/67-2-1438879263.png', 'รายการบันทึกรอสั่งการ.png', 'png');
INSERT INTO `ioffice_bookfile` VALUES ('45', '69', './modules/ioffice/upload/69-1-1438926838.jpg', 'image.jpg', 'jpg');
INSERT INTO `ioffice_bookfile` VALUES ('46', '69', './modules/ioffice/upload/69-2-1438926838.jpg', 'image.jpg', 'jpg');
INSERT INTO `ioffice_bookfile` VALUES ('47', '72', './modules/ioffice/upload/72-1-1438936506.jpg', 'image.jpg', 'jpg');
INSERT INTO `ioffice_bookfile` VALUES ('48', '73', './modules/ioffice/upload/73-1-1438937316.jpg', 'image.jpg', 'jpg');

-- ----------------------------
-- Table structure for `ioffice_bookstatus`
-- ----------------------------
DROP TABLE IF EXISTS `ioffice_bookstatus`;
CREATE TABLE `ioffice_bookstatus` (
  `bookstatusid` int(11) NOT NULL,
  `bookstatusname` varchar(100) NOT NULL,
  PRIMARY KEY (`bookstatusid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ioffice_bookstatus
-- ----------------------------
INSERT INTO `ioffice_bookstatus` VALUES ('1', 'ร่าง');
INSERT INTO `ioffice_bookstatus` VALUES ('2', 'เสนอ');
INSERT INTO `ioffice_bookstatus` VALUES ('3', 'ยกเลิก');
INSERT INTO `ioffice_bookstatus` VALUES ('4', 'ขอความเห็น');
INSERT INTO `ioffice_bookstatus` VALUES ('20', 'อนุมัติ');
INSERT INTO `ioffice_bookstatus` VALUES ('21', 'อนุมัติ(ปฏิบัติราชการแทน)');
INSERT INTO `ioffice_bookstatus` VALUES ('22', 'อนุมัติ(รักษาราชการแทน)');
INSERT INTO `ioffice_bookstatus` VALUES ('30', 'ไม่อนุมัติ');
INSERT INTO `ioffice_bookstatus` VALUES ('40', 'คืนเรื่อง/แก้ไข');

-- ----------------------------
-- Table structure for `ioffice_booktype`
-- ----------------------------
DROP TABLE IF EXISTS `ioffice_booktype`;
CREATE TABLE `ioffice_booktype` (
  `booktypeid` int(11) NOT NULL,
  `booktypename` varchar(100) NOT NULL,
  PRIMARY KEY (`booktypeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ioffice_booktype
-- ----------------------------
INSERT INTO `ioffice_booktype` VALUES ('1', 'ปกติ');
INSERT INTO `ioffice_booktype` VALUES ('2', 'ด่วน');

-- ----------------------------
-- Table structure for `ioffice_config`
-- ----------------------------
DROP TABLE IF EXISTS `ioffice_config`;
CREATE TABLE `ioffice_config` (
  `configname` varchar(255) NOT NULL,
  `configvalue` varchar(255) NOT NULL,
  `configdate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`configname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ioffice_config
-- ----------------------------
INSERT INTO `ioffice_config` VALUES ('paststeptime', '24', null);
DROP TRIGGER IF EXISTS `tg_book1`;
DELIMITER ;;
CREATE TRIGGER `tg_book1` BEFORE INSERT ON `ioffice_book` FOR EACH ROW begin
   declare tmp_positionid int;
   declare tmp_departmentid int;
   declare tmp_subdepartmentid int;
   set new.postdate = now();

   select position_code into tmp_positionid from person_main where person_id = new.post_personid;
   set new.post_positionid = tmp_positionid;

   select department into tmp_departmentid from person_main where person_id = new.post_personid;
   set new.post_departmentid = tmp_departmentid;

   select sub_department into tmp_subdepartmentid from person_main where person_id = new.post_personid;
   set new.post_subdepartmentid = tmp_subdepartmentid;
end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `tg_book2`;
DELIMITER ;;
CREATE TRIGGER `tg_book2` BEFORE UPDATE ON `ioffice_book` FOR EACH ROW begin
   SET new.updatedate = now();
end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `tg_bookcomment1`;
DELIMITER ;;
CREATE TRIGGER `tg_bookcomment1` BEFORE INSERT ON `ioffice_bookcomment` FOR EACH ROW begin
   declare tmp_positionid int;
   declare tmp_departmentid int;
   declare tmp_subdepartmentid int;
   set new.commentdate = now();

   select position_code into tmp_positionid from person_main where person_id = new.comment_personid;
   set new.comment_positionid = tmp_positionid;

   select department into tmp_departmentid from person_main where person_id = new.comment_personid;
   set new.comment_departmentid = tmp_departmentid;

   select sub_department into tmp_subdepartmentid from person_main where person_id = new.comment_personid;
   set new.comment_subdepartmentid = tmp_subdepartmentid;
end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `tg_bookcomment2`;
DELIMITER ;;
CREATE TRIGGER `tg_bookcomment2` AFTER INSERT ON `ioffice_bookcomment` FOR EACH ROW begin
   update ioffice_book set bookstatusid = new.bookstatusid where bookid = new.bookid;
end
;;
DELIMITER ;
