<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if($_SESSION['login_status']<5){
$sql_permission = "select * from student_main_permission where person_id='$_SESSION[login_user_id]'";
}
else{
$sql_permission = "select * from student_main_permission where person_id='$_SESSION[login_user_id]' and school_code='$_SESSION[user_school]'";
}

$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_student_main'])){
$_SESSION['admin_student_main']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
	if(($_SESSION['admin_student_main']=="student_main") or ($result_permission['p1']==1)){
	echo "<li><a href='?option=student_main' class='dir'>ตั้งค่าระบบ</a>";
		echo "<ul>";
			if($_SESSION['admin_student_main']=="student_main"){
			echo "<li><a href='?option=student_main&task=permission'>กำหนดเจ้าหน้าที่ ระดับสพท.</a></li>";
			}
			echo "<li><a href='?option=student_main&task=ed_year'>กำหนดปีการศึกษา</a></li>";
			echo "<li><a href='?option=student_main&task=permission_sch_khet'>กำหนดเจ้าหน้าที่ ระดับสถานศึกษา</a></li>";
		echo "</ul>";
	echo "</li>";
	}

	if(($_SESSION['admin_student_main']=="student_main") or ($result_permission['p1']==1)){
	echo "<li><a href='?option=student_main' class='dir'>ข้อมูลนักเรียน(เจ้าหน้าที่)</a>";
		echo "<ul>";
	echo "<li><a href='?option=student_main&task=student_import'>นำเข้าข้อมูลจากไฟล์</a></li>";
	echo "<li><a href='?option=student_main&task=student_khet_update'>ปรับปรุงข้อมูลนักเรียน</a></li>";
	echo "<li><a href='?option=student_main&task=student_tranfer'>เลื่อนชั้นนักเรียน</a></li>";
		echo "</ul>";
	echo "</li>";
	}


	if ($_SESSION['login_status']==12){
	echo "<li><a href='?option=student_main&task=permission_sch' class='dir'>กำหนดเจ้าหน้าที่</a>";
		echo "<ul>";
			echo "<li><a href='?option=student_main&task=permission_sch'>กำหนดเจ้าหน้าที่</a></li>";
		echo "</ul>";
	echo "</li>";
	}

	if ($result_permission['p2']==1){
	echo "<li><a href='?option=student_main&task=student_sch_update' class='dir'>ปรับปรุงข้อมูลนักเรียน</a>";
		echo "<ul>";
			echo "<li><a href='?option=student_main&task=student_sch_update'>ปรับปรุงข้อมูลนักเรียน</a></li>";
		echo "</ul>";
	echo "</li>";
	}

	if($_SESSION['login_status']<=14){
	echo "<li><a href='?option=student_main' class='dir'>รายงานข้อมูลนักเรียน</a>";
		echo "<ul>";
			echo "<li><a href='?option=student_main&task=student_report1'>รายชื่อนักเรียน</a></li>";
			echo "<li><a href='?option=student_main&task=student_report2'>จำนวนนักเรียนรายชั้น</a></li>";
			echo "<li><a href='?option=student_main&task=student_report3'>ค้นหานักเรียน</a></li>";
		echo "</ul>";
	echo "</li>";
	}

	echo "<li><a href='?option=student_main'>คู่มือ</a>";
		echo "<ul>";
				echo "<li><a href='modules/student_main/manual/student.pdf' target='_blank'>คู่มือข้อมูลนักเรียน</a></li>";
				if(($_SESSION['admin_student_main']=="student_main") or ($result_permission['p1']==1)){
				echo "<li><a href='modules/student_main/manual/student.csv' target='_blank'>ตัวอย่างไฟล์สำหรับนำเข้าข้อมูล</a></li>";
				}
		echo "</ul>";
	echo "</li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
