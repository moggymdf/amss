-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- โฮสต์: localhost
-- เวลาในการสร้าง: 
-- รุ่นของเซิร์ฟเวอร์: 5.0.51
-- รุ่นของ PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- ฐานข้อมูล: `amss`
-- 

-- --------------------------------------------------------

-- 
-- โครงสร้างตาราง `meeting_main`
-- 

CREATE TABLE `meeting_main` (
  `id` int(11) NOT NULL auto_increment,
  `room` tinyint(4) NOT NULL,
  `book_date` date NOT NULL,
  `start_time` tinyint(4) NOT NULL,
  `finish_time` tinyint(4) NOT NULL,
  `objective` varchar(255) NOT NULL,
  `book_person` varchar(13) NOT NULL,
  `rec_date` datetime NOT NULL,
  `approve` int(11) default NULL,
  `reason` varchar(200) default NULL,
  `person_num` int(11) default NULL,
  `chairman` varchar(255) NOT NULL,
  `coordinator` varchar(255) NOT NULL,
  `other` varchar(250) default NULL,
  `officer` varchar(13) default NULL,
  `officer_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- 
-- dump ตาราง `meeting_main`
-- 

INSERT INTO `meeting_main` VALUES (1, 1, '2015-07-26', 9, 14, 'ประชุม1', '4101700062303', '2015-07-26 14:27:15', 1, '', 1, '', '', '', '4101700062303', '2015-07-26 14:48:47');
INSERT INTO `meeting_main` VALUES (2, 1, '2015-07-30', 8, 16, 'ffff', '4101700062303', '2015-07-26 14:36:47', NULL, NULL, 122, '', '', '333333', NULL, NULL);
INSERT INTO `meeting_main` VALUES (3, 1, '2015-07-26', 8, 16, 'ประชุมคอม', '123456', '2015-07-26 15:39:01', 1, NULL, 4, 'นายกอไก่ ขอไข่', 'นายขอไข่', 'ไม่มีจร้าาา', '123456', '2015-07-26 16:44:04');
INSERT INTO `meeting_main` VALUES (5, 1, '2015-07-26', 8, 16, 'ประชุมคอม', '123456', '2015-07-26 15:50:37', 1, NULL, 4, 'นายกอไก่ ขอไข่', 'นายขอไข่', 'ไม่มีจร้าาา', '123456', '2015-07-26 16:44:04');
INSERT INTO `meeting_main` VALUES (6, 1, '2015-07-26', 8, 16, 'ประชุมคอม', '123456', '2015-07-26 15:50:46', 1, NULL, 4, 'นายกอไก่ ขอไข่', 'นายขอไข่', 'ไม่มีจร้าาา', '123456', '2015-07-26 16:44:04');
INSERT INTO `meeting_main` VALUES (7, 2, '2015-07-27', 11, 16, 'ประชุม1', '123456', '2015-07-26 16:00:44', NULL, NULL, 122, 'นายกอไก่ ขอไข่', 'นายขอไข่', 'ไม่มีจร้าาา', NULL, NULL);
INSERT INTO `meeting_main` VALUES (11, 4, '2015-07-31', 8, 16, 'กฟหกฟหกฟห', '123456', '2015-07-26 16:28:35', NULL, NULL, 0, 'นายกอไก่ ขอไข่', 'dsadasdas', '', NULL, NULL);
