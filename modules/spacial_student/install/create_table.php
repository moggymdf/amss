<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ส่วนการสร้างตารางระบบย่อย
$sql_create="CREATE TABLE IF NOT EXISTS `spacial_student_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` varchar(13) NOT NULL,
  `school_code` varchar(11) DEFAULT NULL,
  `p1` tinyint(4) DEFAULT NULL,
  `p2` tinyint(4) DEFAULT NULL,
  `p3` tinyint(4) DEFAULT NULL,
  `class_level` varchar(2) DEFAULT NULL,
  `officer` varchar(13) NOT NULL,
  `rec_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE IF NOT EXISTS `spacial_student_disabled` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` varchar(13) NOT NULL,
  `school_code` varchar(15) NOT NULL,
  `disable_type` tinyint(4) NOT NULL,
  `disable_detail` text NOT NULL,
  `other` text NOT NULL,
  `pic` varchar(150) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `officer` varchar(13) NOT NULL,
  `rec_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE IF NOT EXISTS `spacial_student_help1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` varchar(13) NOT NULL,
  `school_code` varchar(15) NOT NULL,
  `help_date` varchar(100) NOT NULL,
  `help_type` tinyint(4) NOT NULL,
  `purpose` varchar(250) NOT NULL,
  `operation` varchar(250) NOT NULL,
  `result` varchar(250) NOT NULL,
  `pic` varchar(150) NOT NULL,
  `officer` varchar(13) NOT NULL,
  `rec_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);
?>
