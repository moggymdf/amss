<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ส่วนการสร้างตารางระบบย่อย
$sql_create="CREATE TABLE `permission_date` (
  `id` int(11) NOT NULL auto_increment,
  `person_id` varchar(13) NOT NULL,
  `ref_id` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `rec_date` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE IF NOT EXISTS `permission_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` varchar(13) NOT NULL,
  `ref_id` varchar(50) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `place` varchar(150) NOT NULL,
  `vehicle` varchar(150) DEFAULT NULL,
  `document` varchar(150) DEFAULT NULL,
  `no_comment` tinyint(4) NOT NULL DEFAULT '0',
  `grant_person_selected` varchar(13) DEFAULT NULL,
  `rec_date` datetime NOT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `comment_person` varchar(13) DEFAULT NULL,
  `comment_date` datetime DEFAULT NULL,
  `grant_x` tinyint(4) DEFAULT NULL,
  `grant_comment` varchar(200) DEFAULT NULL,
  `grant_person` varchar(13) DEFAULT NULL,
  `grant_date` datetime DEFAULT NULL,
  `report` text,
  `report_date` datetime DEFAULT NULL,
  `report_read` varchar(13) NOT NULL,
  `report_read_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ref_id` (`ref_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE `permission_permission` (
  `id` int(11) NOT NULL auto_increment,
  `person_id` varchar(13) NOT NULL,
  `p1` tinyint(4) NOT NULL,
  `officer` varchar(13) NOT NULL,
  `rec_date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE `permission_person_set` (
  `id` int(11) NOT NULL auto_increment,
  `person_id` varchar(13) NOT NULL,
  `comment_person` varchar(13) default NULL,
  `grant_person` varchar(13) default NULL,
  `officer` varchar(13) default NULL,
  `rec_date` date default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `person_id` (`person_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
$query = mysqli_query($connect,$sql_create);

?>
