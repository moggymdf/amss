<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";

	echo "<li><a href='./'>รายการหลัก</a></li>";
	echo "<li><a href='?option=ioffice' class='dir'>ตั้งค่าระบบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=ioffice&task=permission'>กำหนดสิทธิ์การใช้งาน</a></li>";
			echo "<li><a href='?option=ioffice&task=position'>กำหนดลำดับการเสนอเรื่อง</a></li>";
			echo "<li><a href='?option=ioffice&task=special_position'>กำหนดเวลาในการข้ามลำดับการเสนอเรื่อง</a></li>";
		echo "</ul>";
	echo "</li>";

	echo "<li><a href='?option=ioffice' class='dir'>บันทึกเสนอ</a>";
		echo "<ul>";
			echo "<li><a href='?option=ioffice&task=book_insert'>เพิ่มบันทึกเสนอ</a></li>";
			echo "<li><a href='?option=ioffice&task=book_select'>รายการบันทึกเสนอ</a></li>";
		echo "</ul>";
	echo "</li>";

	echo "<li><a href='?option=ioffice' class='dir'>สั่งการ</a>";
		echo "<ul>";
			echo "<li><a href='?option=ioffice&task=book_pass'>รายการบันทึกรอสั่งการ</a></li>";
		echo "</ul>";
	echo "</li>";

	echo "<li><a href='?option=ioffice' class='dir'>ค้นหา</a>";
		echo "<ul>";
			echo "<li><a href='?option=ioffice&task=book_search'>ค้นหาหนังสือทั้งหมด</a></li>";
		echo "</ul>";
	echo "</li>";

	echo "<li><a href='?option=ioffice' class='dir'>คู่มือ</a>";
		echo "<ul>";
		echo "<li><a href='modules/ioffice/manual/ioffice.pdf' target='_blank'>คู่มือบันทึกเสนอสั่งการ</a></li>";
		echo "</ul>";
	echo "</li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
