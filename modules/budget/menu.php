<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page

$sql_permission = "select * from budget_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_budget'])){
$_SESSION['admin_budget']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
echo "<li><a href='./'>รายการหลัก</a></li>";

if(($_SESSION['admin_budget']=="budget") or ($result_permission['p2']==1)){
	echo "<li><a href='?option=budget' class='dir'>ตั้งค่าระบบ</a>";
		echo "<ul>";
			if($_SESSION['admin_budget']=="budget"){
			echo "<li><a href='?option=budget&task=main/permission'>เจ้าหน้าที่การเงินฯ</a></li>";
			}
			if($result_permission['p2']==1){
			echo "<li><a href='?option=budget&task=main/budget_year'>ปีงบประมาณ</a></li>";
			echo "<li><a href='?option=budget&task=category/plan_project'>แผนงาน</a></li>";
			echo "<li><a href='?option=budget&task=category/proj_product'>ผลผลิตโครงการ</a></li>";
			echo "<li><a href='?option=budget&task=category/key_activity'>กิจกรรมหลัก</a></li>";
			echo "<li><a href='?option=budget&task=category/money_source'>แหล่งของเงิน</a></li>";
			echo "<li><a href='?option=budget&task=category/pay_type'>งบรายจ่าย</a></li>";
			echo "<li><a href='?option=budget&task=category/edit_category'>ประเภท(หลัก)ของเงิน</a></li>";
			echo "<li><a href='?option=budget&task=category/edit_type'>ประเภท(ย่อย)ของเงิน</a></li>";
			}
		echo "</ul>";
	echo "</li>";
}

if($_SESSION['login_status']<=4 and ($result_permission['p2']==1 or $result_permission['p5']==1 or $result_permission['p6']==1 or $result_permission['p7']==1)){
	echo "<li><a href='?option=budget' class='dir'>ทะเบียนรับ</a>";
		echo "<ul>";
			if($result_permission['p2']==1){
			echo "<li><a href='?option=budget&task=budget_unit/receive'>รับการจัดสรรงบประมาณ</a></li>";
			}
			if($result_permission['p5']==1){
			echo "<li><a href='?option=budget&task=main/receive_bud'>รับเงินงบประมาณ</a></li>";
			}
			if($result_permission['p6']==1){
			echo "<li><a href='?option=budget&task=main/receive_ex_bud'>รับเงินนอกงบประมาณ</a></li>";
			}
			if($result_permission['p7']==1){
			echo "<li><a href='?option=budget&task=main/receive_income_bud'>รับเงินรายได้แผ่นดิน</a></li>";
			}
		echo "</ul>";
	echo "</li>";
}

if($_SESSION['login_status']<=4 and ($result_permission['p3']==1 or $result_permission['p4']==1)){
	echo "<li><a href='?option=budget' class='dir'>ทะเบียนขอเบิก</a>";
		echo "<ul>";
			if($result_permission['p3']==1){
			echo "<li><a href='?option=budget&task=main/withdraw'>ทะเบียนขอเบิก/ขอยืมเงินโครงการ</a></li>";
			echo "<li><a href='?option=budget&task=main/return_withdraw'>***ทะเบียนคืนเงินโครงการ</a></li>";
			}
			if($result_permission['p4']==1){
			echo "<li><a href='?option=budget&task=deega/deega'>ทะเบียนขอเบิกเงินคงคลัง</a></li>";
			echo "<li><a href='?option=budget&task=deega/return_deega'>***ทะเบียนคืนเงินคงคลัง</a></li>";
			echo "<li><a href='?option=budget&task=main/cancel_deega'>***ยกเลิกฎีกา</a></li>";
			echo "<li><a href='?option=budget&task=deega/po'>ทะเบียนเงินกันเหลื่อมปี</a></li>";
			}
		echo "</ul>";
	echo "</li>";
}

if($_SESSION['login_status']<=4 and ($result_permission['p5']==1 or $result_permission['p6']==1 or $result_permission['p7']==1 or $result_permission['p8']==1 or $result_permission['p9']==1)){
	echo "<li><a href='?option=budget' class='dir'>ทะเบียนจ่าย</a>";
		echo "<ul>";
			if($result_permission['p5']==1){
			echo "<li><a href='?option=budget&task=main/pay_bud'>สั่งจ่ายเงินงบประมาณ</a></li>";
			}
			if($result_permission['p6']==1){
			echo "<li><a href='?option=budget&task=main/pay_ex_bud'>สั่งจ่ายเงินนอกงบประมาณ</a></li>";
			}
			if($result_permission['p7']==1){
			echo "<li><a href='?option=budget&task=main/pay_income_bud'>สั่งจ่ายเงินรายได้แผ่นดิน</a></li>";
			}
			if($result_permission['p8']==1){
			echo "<li><a href='?option=budget&task=main/reserve_money'>เงินทดรองราชการ</a></li>";
			}
			if($result_permission['p1']==1){
			echo "<li><a href='?option=budget&task=main/approve'>อนุมัติจ่ายเงินประเภทหลัก</a></li>";
			echo "<li><a href='?option=budget&task=main/approve_reserve'>อนุมัติจ่ายเงินทดรองราชการ</a></li>";
			}
			if($result_permission['p9']==1){
			echo "<li><a href='?option=budget&task=main/pay_check'>จ่ายเงินประเภทหลัก</a></li>";
			echo "<li><a href='?option=budget&task=main/pay_check_reserve'>จ่ายเงินทดรองราชการ</a></li>";
			}
		echo "</ul>";
	echo "</li>";
}

if($_SESSION['login_status']<=4 and ($result_permission['p5']==1 or $result_permission['p6']==1 or $result_permission['p7']==1)){
	echo "<li><a href='?option=budget' class='dir'>เปลี่ยนแปลงสถานะ</a>";
		echo "<ul>";
			if($result_permission['p5']==1){
			echo "<li><a href='?option=budget&task=main/change_bud'>เงินงบประมาณ</a></li>";
			}
			if($result_permission['p6']==1){
			echo "<li><a href='?option=budget&task=main/change_ex_bud'>เงินนอกงบประมาณ</a></li>";
			}
			if($result_permission['p7']==1){
			echo "<li><a href='?option=budget&task=main/change_income_bud'>เงินรายได้แผ่นดิน</a></li>";
			}
		echo "</ul>";
	echo "</li>";
}

if($_SESSION['login_status']<=4 and ($result_permission['p10']==1)){
	echo "<li><a href='?option=budget' class='dir'>ตรวจสอบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=budget&task=check/check_2'>ตรวจสอบการจัดสรรงบประมาณ</a></li>";
			echo "<li><a href='?option=budget&task=main/report_10'>รายงานเงินประจำงวด</a></li>";
			echo "<li><a href='?option=budget&task=main/report_pay_check'>จ่ายเงินประเภทหลัก</a></li>";
			echo "<li><a href='?option=budget&task=main/report_pay_check_reserve'>จ่ายเงินทดรองราชการ</a></li>";
			echo "<li><a href='?option=budget&task=check/check_3'>เลขที่ฎีกาที่ไม่มีในระบบ</a></li>";
			echo "<li><a href='?option=budget&task=check/check_4'>ฎีกากับการตัดโครงการจำแนกตามใบงวด</a></li>";
			echo "<li><a href='?option=budget&task=check/check_5'>ฎีกากับการอ้างอิงการขอเบิกจำแนกตามฎีกา</a></li>";
			echo "<li><a href='?option=budget&task=check/check_6'>รายการขอเบิกฯที่ยังไม่ได้วางฎีกา</a></li>";
			echo "<li><a href='?option=budget&task=check/check_7'>รายการขอเบิกฯที่วางฎีกาผิดใบงวด</a></li>";
		echo "</ul>";
	echo "</li>";
}

	echo "<li><a href='?option=budget' class='dir'>รายงาน</a>";
		echo "<ul>";
			if($_SESSION['login_status']<=15){
			echo "<li><a href='?option=budget&task=main/report_9'>รายงานการจัดสรรงบประมาณ</a></li>";
			echo "<li><a href='?option=budget&task=main/report_1'>รายงานการใช้จ่ายจำแนกตามโครงการ</a></li>";
			echo "<li><a href='?option=budget&task=budget_unit/receive_report'>ทะเบียนเงินงวด</a></li>";
			}
			if($result_permission['p10']==1){
			echo "<li><a href='?option=budget&task=main/report_12'>รายงานการใช้จ่ายจำแนกตามรหัสงบประมาณ</a></li>";
			echo "<li><a href='?option=budget&task=main/report_5'>รายงานการใช้จ่ายจำแนกตามประเภทรายการจ่าย</a></li>";
			echo "<li><a href='?option=budget&task=main/today_report'>รายงานเงินคงเหลือประจำวัน</a></li>";
			echo "<li><a href='?option=budget&task=main/cash_book'>สมุดเงินสด</a></li>";
			echo "<li><a href='?option=budget&task=main/bud_book'>รายงานเงินงบประมาณ</a></li>";
			echo "<li><a href='?option=budget&task=main/ex_bud_book'>รายงานเงินนอกงบประมาณ</a></li>";
			echo "<li><a href='?option=budget&task=main/income_bud_book'>รายงานเงินรายได้แผ่นดิน</a></li>";
			}
			if($_SESSION['login_status']<=5){
			echo "<li><a href='?option=budget&task=main/report_8'>รายงานลูกหนี้เงินยืม</a></li>";
			}
		echo "</ul>";
	echo "</li>";
	echo "<li><a href='?option=budget' class='dir'>คู่มือ</a>";
		echo "<ul>";
				echo "<li><a href='modules/budget/manual/budget.pdf' target='_blank'>คู่มือการเงินและบัญชี</a></li>";
		echo "</ul>";
	echo "</li>";
echo "</ul>";
?>
</td></tr>
</table>
