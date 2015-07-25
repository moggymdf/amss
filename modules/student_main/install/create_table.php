<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ส่วนการสร้างตารางระบบย่อย
$sql_create="CREATE TABLE `student_main_edyear` (
  `id` int(11) NOT NULL auto_increment,
  `ed_year` int(11) NOT NULL,
  `year_active` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ed_year` (`ed_year`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE IF NOT EXISTS `student_main_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ed_year` int(11) NOT NULL,
  `ref_id` varchar(20) NOT NULL,
  `school_code` varchar(15) NOT NULL,
  `student_id` varchar(15) NOT NULL,
  `person_id` varchar(13) NOT NULL,
  `prename` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `sex` varchar(5) NOT NULL,
  `school_name` varchar(150) NOT NULL,
  `classlevel` tinyint(4) NOT NULL,
  `classroom` tinyint(4) NOT NULL DEFAULT '1',
  `disable` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `rec_date` date NOT NULL,
  `officer` varchar(13) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
$query = mysqli_query($connect,$sql_create);

$sql_create="CREATE TABLE `student_main_permission` (
  `id` int(11) NOT NULL auto_increment,
  `person_id` varchar(13) NOT NULL,
  `school_code` varchar(11) default NULL,
  `p1` tinyint(4) default NULL,
  `p2` tinyint(4) default NULL,
  `officer` varchar(13) NOT NULL,
  `rec_date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$query = mysqli_query($connect,$sql_create);

?>
