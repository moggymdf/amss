<?php
	require_once("./modules/plan/planproject/plan_authen.php");
	require_once("./modules/plan/planproject/plan_person.php");
	require_once("./modules/plan/planproject/plan_default.php");


if(!isset($_SESSION['admin_plan'])){
$_SESSION['admin_plan']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
echo "<li><a href='./'>รายการหลัก</a></li>";
	if($_SESSION['admin_plan']=="plan"){
	echo "<li><a href=\"?option=plan\" class=\"dir\">ตั้งค่าระบบ</a>";
		echo "<ul>";
			echo "<li><a href=\"?option=plan&task=planproject/plan_setuser\">กำหนดเจ้าหน้าที่</a></li>";
			echo "<li><a href=\"?option=plan&task=planproject/plan_year\">กำหนดปีงบประมาณ</a></li>";
			echo "<li><a href=\"?option=plan&task=planproject/plan_setgic\">กำหนดกลยุทธ์</a></li>";
		echo "</ul>";
	echo "</li>";
	}
	if(($_SESSION['login_status']<=4) and ($_SESSION["mpms_add"]==1 or $_SESSION["mpms_edit"] ==1 or $_SESSION["mpms_dele"]==1)){
	echo "<li><a href=\"?option=plan\" class=\"dir\">โครงการ</a>";
		echo "<ul>";
			echo "<li><a href=\"?option=plan&task=planproject/plan_in_proj\">กำหนดโครงการ</a></li>";
			echo "<li><a href=\"?option=plan&task=planproject/plan_in_acti\">กำหนดกิจกรรม</a></li>";
			echo "<li><a href=\"?option=plan&task=planproject/plan_upload_detail\">แนบเอกสารโครงการ</a></li>";
		echo "</ul>";
	echo "</li>";
	}

if(($_SESSION['login_status']<=4) and ($_SESSION["mpms_add"]==1 or $_SESSION["mpms_edit"] ==1 or $_SESSION["mpms_dele"]==1)){
	echo "<li><a href='?option=budget' class='dir'>ตรวจสอบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=plan&task=check/receive_report'>ทะเบียนเงินงวด</a></li>";
			echo "<li><a href=\"?option=plan&task=check/check_2\">ตรวจสอบการจัดสรรงบประมาณ</a></li>";
		echo "</ul>";
	echo "</li>";
}

	echo "<li><a href=\"?option=plan\" class=\"dir\">รายงานโครงการ</a>";
		echo "<ul>";
			echo "<li><a href=\"?option=plan&task=planproject/plan_show_plan\">โครงการจำแนกตามกลุ่ม(งาน)</a></li>";
			if($_SESSION['login_status']<=4){
			echo "<li><a href=\"?option=plan&task=check/check_1\">รายงานการจัดสรรงบประมาณ</a></li>";
			echo "<li><a href=\"?option=plan&task=planproject/plan_show_plan2\">โครงการจำแนกตามกลยุทธ์</a></li>";
			echo "<li><a href=\"?option=plan&task=planproject/plan_owner_report\">รายงานผลการดำเนินงาน</a></li>";
			}
		echo "</ul>";
	echo "</li>";

	echo "<li><a href=\"?option=plan\" class=\"dir\">คู่มือ</a>";
		echo "<ul>";
   		  		echo "<li><a href=\"modules\plan\handbook\handbook1.htm\" target=  _blank>คู่มือการใช้งาน_1</a><li>";
   		  		echo "<li><a href=\"modules\plan\handbook\plan.pdf\" target=  _blank>คู่มือการใช้งาน_2</a><li>";
		echo "</ul>";
	echo "</li>";
echo "</ul>";
?>
</td></tr>
</table>
