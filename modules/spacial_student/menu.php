<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if($_SESSION['login_status']<5){
$sql_permission = "select * from spacial_student_permission where person_id='$_SESSION[login_user_id]'";
}
else{
$sql_permission = "select * from spacial_student_permission where person_id='$_SESSION[login_user_id]' and school_code='$_SESSION[user_school]'";
}

$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_spacial_student'])){
$_SESSION['admin_spacial_student']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
	if(($_SESSION['admin_spacial_student']=="spacial_student") or ($result_permission['p1']==1)){
	echo "<li><a href='?option=spacial_student' class='dir'>ตั้งค่าระบบ</a>";
		echo "<ul>";
			if($_SESSION['admin_spacial_student']=="spacial_student"){
			echo "<li><a href='?option=spacial_student&task=permission'>กำหนดเจ้าหน้าที่ ระดับสพท.</a></li>";
			}
			echo "<li><a href='?option=spacial_student&task=permission_sch_khet'>กำหนดเจ้าหน้าที่ ระดับสถานศึกษา</a></li>";
		echo "</ul>";
	echo "</li>";
	}

	if(($_SESSION['admin_spacial_student']=="spacial_student") or ($result_permission['p1']==1)){
	echo "<li><a href='?option=spacial_student' class='dir'>งานเจ้าหน้าที่(สพท)</a>";
		echo "<ul>";
			echo "<li><a href='?option=spacial_student&task=student_khet_disable'>นักเรียนที่มีความต้องการพิเศษ</a></li>";
		echo "</ul>";
	echo "</li>";
	}


	if ($_SESSION['login_status']==12){
	echo "<li><a href='?option=spacial_student&task=permission_sch' class='dir'>กำหนดเจ้าหน้าที่</a>";
		echo "<ul>";
			echo "<li><a href='?option=spacial_student&task=permission_sch'>กำหนดเจ้าหน้าที่</a></li>";
		echo "</ul>";
	echo "</li>";
	}

	if ($result_permission['p2']==1){
	echo "<li><a href='?option=spacial_student' class='dir'>งานเจ้าหน้าที่(สถานศึกษา)</a>";
		echo "<ul>";
			echo "<li><a href='?option=spacial_student&task=student_sch_disable'>นักเรียนที่มีความต้องการพิเศษ</a></li>";
		echo "</ul>";
	echo "</li>";
	}

	if($_SESSION['login_status']<5){
	echo "<li><a href='?option=spacial_student' class='dir'>รายงาน</a>";
		echo "<ul>";
			echo "<li><a href='?option=spacial_student&task=student_sch_disable_report3'>สรุปจำนวนนักเรียนพิเศษ</a></li>";
			echo "<li><a href='?option=spacial_student&task=student_sch_disable_report2'>รายละเอียดนักเรียนพิเศษ</a></li>";
		echo "</ul>";
	echo "</li>";
	}

	if($_SESSION['login_status']>=12){
	echo "<li><a href='?option=spacial_student' class='dir'>รายงาน</a>";
		echo "<ul>";
			echo "<li><a href='?option=spacial_student&task=student_sch_disable_report1'>นักเรียนพิเศษ</a></li>";
		echo "</ul>";
	echo "</li>";
	}

	echo "<li><a href='?option=spacial_student'>คู่มือ</a>";
		echo "<ul>";
				echo "<li><a href='modules/spacial_student/manual/spacial_student.pdf' target='_blank'>คู่มือนักเรียนพิเศษ</a></li>";
		echo "</ul>";
	echo "</li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
