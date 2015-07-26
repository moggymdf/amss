<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$sql_permission = "select * from  car_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_car'])){
$_SESSION['admin_car']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
	if(($_SESSION['admin_car']=="car")  or ($result_permission['p1']==1)){
	echo "<li><a href='?option=car' class='dir'>ตั้งค่าระบบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=car&task=main/permission'>กำหนดเจ้าหน้าที่</a></li>";
			if($result_permission['p1']==1){
			echo "<li><a href='?option=car&task=main/car_type'>กำหนดประเภท</a></li>";
			echo "<li><a href='?option=car&task=main/car_list'>กำหนดยานพาหนะ</a></li>";
			echo "<li><a href='?option=car&task=main/set_driver'>กำหนดพนักงานขับรถ</a></li>";
			}
		echo "</ul>";
	echo "</li>";
	}

	if($_SESSION['login_group']<=4){
	echo "<li><a href='?option=car' class='dir'>ขอใช้ยานพาหนะ</a>";
		echo "<ul>";
			echo "<li><a href='?option=car&task=main/car_request'>ขอใช้รถราชการ</a></li>";
	echo "</ul>";
	echo "</li>";
	}

	if($_SESSION['login_status']<=4 and $result_permission['p1']==1){
	echo "<li><a href='?option=car' class='dir'>เจ้าหน้าที่</a>";
		echo "<ul>";
			echo "<li><a href='?option=car&task=main/car_officer'>เจ้าหน้าที่ลงความเห็น</a></li>";
			echo "<li><a href='?option=car&task=main/oil_withdraw'>ใบเบิกน้ำมัน</a></li>";
	echo "</ul>";
	echo "</li>";
	}

	if($_SESSION['login_status']<=4 and $result_permission['p1']>=2){
	echo "<li><a href='?option=car' class='dir'>ลงความเห็น/อนุมัติ</a>";
		echo "<ul>";
			if($result_permission['p1']==2){
			echo "<li><a href='?option=car&task=main/car_group'>ผู้ให้ความเห็นชอบ</a></li>";
			}
			if($result_permission['p1']==3) {
			echo "<li><a href='?option=car&task=main/car_commander'>ผู้อนุมัติ</a></li>";
			}
	echo "</ul>";
	echo "</li>";
	}

	if($_SESSION['login_status']<=4){
	echo "<li><a href='?option=car' class='dir'>รายงาน</a>";
		echo "<ul>";
			echo "<li><a href='?option=car&task=main/car_report'>รายงานการใช้ยานหานะ</a></li>";
	echo "</ul>";
	echo "</li>";
	}

	echo "<li><a href='?option=car' class='dir'>คู่มือ</a>";
		echo "<ul>";
				echo "<li><a href='modules/car/manual/car.pdf' target='_blank'>คู่มือ</a></li>";
		echo "</ul>";
	echo "</li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
