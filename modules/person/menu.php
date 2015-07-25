<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page

$sql_permission = "select * from person_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_person'])){
$_SESSION['admin_person']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";

	echo "<li><a href='./'>รายการหลัก</a></li>";
	if(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']==99) or ($_SESSION['login_status']<=4 and $result_permission['p1']==1)){
	echo "<li><a href='?option=person' class='dir'>ตั้งค่าระบบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=person&task=permission'>เจ้าหน้าที่ระบบข้อมูลพื้นฐานครูและบุคลากร</a></li>";
			echo "<li><a href='?option=person&task=position'>กำหนดตำแหน่งครูและบุคลากรในสพท.</a></li>";
			if(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']<=4 and $result_permission['p1']==1)){
			echo "<li><a href='?option=person&task=sch_position'>กำหนดตำแหน่งครูและบุคลากรในสถานศึกษา</a></li>";
			}
			echo "<li><a href='?option=person&task=person_import'>นำเข้าข้อมูลครูและบุคลากรในสพท.จาก Text File</a></li>";
			if(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']<=4 and $result_permission['p1']==1)){
			echo "<li><a href='?option=person&task=person_sch_import'>นำเข้าข้อมูลครูและบุคลากรในสถานศึกษาจาก Text File</a></li>";
			echo "<li><a href='?option=person&task=school'>ชื่อและรหัสสถานศึกษา</a></li>";
			}
		echo "</ul>";
	echo "</li>";
	}

	if(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']==99) or ($_SESSION['login_status']<=4 and $result_permission['p1']==1)){
	echo "<li><a href='?option=person' class='dir'>ครูและบุคลากรปัจจุบัน</a>";
		echo "<ul>";
			echo "<li><a href='?option=person&task=person'>ครูและบุคลากร สพท.</a></li>";
			if(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']<=4 and $result_permission['p1']==1)){
			echo "<li><a href='?option=person&task=person_sch'>ครูและบุคลากร สถานศึกษา</a></li>";
			echo "<li><a href='?option=person&task=person_sch_other'>บุคลากรในสถานศึกษาปฏิบัติงานมากกว่า 1 แห่ง</a></li>";
			}
	echo "</ul>";
	echo "</li>";
	}

	if(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']<=4 and $result_permission['p1']==1)){
	echo "<li><a href='?option=person' class='dir'>ครูและบุคลากรในอดีต</a>";
		echo "<ul>";
			echo "<li><a href='?option=person&task=change_status_person'>ครูและบุคลากร สพท.</a></li>";
			echo "<li><a href='?option=person&task=change_status_person_sch'>ครูและบุคลากร สถานศึกษา</a></li>";
	echo "</ul>";
	echo "</li>";
	}

	echo "<li><a href='?option=person' class='dir'>รายงาน</a>";
		echo "<ul>";
			echo "<li><a href='?option=person&task=person_report1'>ครูและบุคลากร สพท.</a></li>";
			echo "<li><a href='?option=person&task=person_sch_report1'>ครูและบุคลากร สถานศึกษา</a></li>";
		   if($_SESSION['login_status']<=4){
			echo "<li><a href='modules/person/export_to_excel.php' target='_blank'>ส่งออกข้อมูลครูและบุคลากรสพท.เป็นไฟล์ Excel</a></li>";
		   }
		echo "</ul>";
	echo "</li>";
	echo "<li><a href='?option=person' class='dir'>คู่มือ</a>";
		echo "<ul>";
				echo "<li><a href='modules/person/manual/person.pdf' target='_blank'>คู่มือข้อมูลพื้นฐานบุคลากร</a></li>";
			if(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']==99) or ($_SESSION['login_status']<=4 and $result_permission['p1']==1)){
			echo "<li><a href='modules/person/manual/person.xls' target='_blank'>ตัวอย่างไฟล์ Excel ข้อมูลครูและบุคลากรในสพท.</a></li>";
			}
			if(($_SESSION['admin_person']=="person") or ($_SESSION['login_status']<=4 and $result_permission['p1']==1)){
				echo "<li><a href='modules/person/manual/school_person.xls' target='_blank'>ตัวอย่างไฟล์ Excel ข้อมูลครูและบุคลากรในสถานศึกษา</a></li>";
			}
		echo "</ul>";
	echo "</li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
