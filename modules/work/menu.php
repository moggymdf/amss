<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$login_user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
$login_status=mysqli_real_escape_string($connect,$_SESSION['login_status']);
//sd page
$sql_permission = "select * from work_permission where person_id=?";
    $dbquery_permiss = $connect->prepare($sql_permission);
    $dbquery_permiss->bind_param("i", $login_user_id);
    $dbquery_permiss->execute();
    $result_permiss=$dbquery_permiss->get_result();
     while($result_permission = $result_permiss->fetch_array())
    {
         $permission = $result_permission["p1"];
     }

if(isset($permission)){
    if($permission!=1 or $login_status<105 ){
        echo "<div align='center'><h2> เฉพาะผู้ดูแลการลงเวลาปฏิบัติราชการเท่านั้น </h2></div>";
        exit();
    }
    }else{
        $permission="";
    }

$system_user_department=mysqli_real_escape_string($connect,$_SESSION['system_user_department']);


if(!isset($_SESSION['admin_work'])){
$admin_work="";
}else{
$admin_work=mysqli_real_escape_string($connect,$_SESSION['admin_work']);
}


echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
	if($admin_work=="work"){
	echo "<li><a href='?option=work' class='dir'>ตั้งค่าระบบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=work&task=permission'>กำหนดเจ้าหน้าที่</a></li>";
		echo "</ul>";
	echo "</li>";
	}
	if(($admin_work=="work") or ($login_status<=4 and $permission==1)){
	echo "<li><a href='?option=work' class='dir'>บันทึกข้อมูล</a>";
		echo "<ul>";
			echo "<li><a href='?option=work&task=check'>บันทึกข้อมูลการปฏิบัติราชการวันนี้</a></li>";
			echo "<li><a href='?option=work&task=check_2'>บันทึกข้อมูลการปฏิบัติราชการย้อนหลัง</a></li>";

        //บันทึกข้อมูลผู้บริหาร
        if($system_user_department==4){
 			echo "<li><a href='?option=work&task=check_3'>บันทึกข้อมูลการปฏิบัติราชการของผู้บริหาร</a></li>";
        }

    echo "</ul>";
	echo "</li>";
	}
	if(isset($login_user_id)){
	echo "<li><a href='?option=work' class='dir'>รายงาน</a>";
		echo "<ul>";
			echo "<li><a href='?option=work&task=report_1'>สรุปการปฏิบัติราชการรายวัน</a></li>";
			echo "<li><a href='?option=work&task=report_2'>สรุปการปฏิบัติราชการรอบเดือน</a></li>";
//	if($login_status<105){
			echo "<li><a href='?option=work&task=report_4'>สรุปการปฏิบัติราชการรายสำนักรายวัน</a></li>";
			echo "<li><a href='?option=work&task=report_6'>สรุปการปฏิบัติราชการผู้บริหารงานวัน</a></li>";
//    }
		echo "</ul>";
	echo "</li>";
	}
	echo "</li>";
	echo "<li><a href='?option=work' class='dir'>คู่มือ</a>";
		echo "<ul>";
				echo "<li><a href='modules/work/manual/work.pdf' target='_blank'>คู่มือการปฏิบัติราชการ</a></li>";
		echo "</ul>";
	echo "</li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
