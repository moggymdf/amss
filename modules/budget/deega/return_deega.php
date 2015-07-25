<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if($result_permission['p4']!=1){
exit();
}

$officer=$_SESSION['login_user_id'];
$t_month['01']="มค";
$t_month['02']="กพ";
$t_month['03']="มีค";
$t_month['04']="เมย";
$t_month['05']="พค";
$t_month['06']="มิย";
$t_month['07']="กค";
$t_month['08']="สค";
$t_month['09']="กย";
$t_month['10']="ตค";
$t_month['11']="พย";
$t_month['12']="ธค";

//ปีงบประมาณ
$sql = "select * from  budget_year where year_active='1' order by budget_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['budget_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีงบประมาณใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีงบประมาณ</div>";
exit();
}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ทะเบียนเงินคืนคลัง ปีงบประมาณ $year_active_result[budget_year]</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>คืนเงินคงคลัง ปีงบประมาณ $year_active_result[budget_year]</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='70%' Border='0' Bgcolor='#Fcf9d8'>";
echo "<Tr><Td></Td><Td align='right'>ที่เอกสาร&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='doc' Size='20'></Td></Tr>";

echo   "<tr><Td></Td><td align='right'>เลขที่ใบงวด&nbsp;&nbsp;</td>";
echo   "<td align='left'><div align=left><Select name='receive_num' size=1>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option  value = 'oth'>อื่นๆ</option>" ;
echo  "<option  value = 'sly'>เงินเดือน</option>" ;
echo  "<option  value = 'ctr'>งบกลางค่ารักษาพยาบาล</option>" ;
echo  "<option  value = 'etr'>งบกลางค่าการศึกษาบุตร</option>" ;
$sql = "select * from budget_receive where  budget_year='$year_active_result[budget_year]' order by num desc";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$num = $result[num];
		$item  = $result[item];
		$item=  substr($item,0,160);
		echo  "<option value = $num>$num $item</option>" ;
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td ></Td><Td align='right'>แผน&nbsp;&nbsp;</Td>";
echo   "<td align='left'><div align='left'><Select name='plan' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  budget_plan where budget_year='$year_active_result[budget_year]' order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
   $plan_name=$result['name'];
   $plan_name=substr($plan_name,0,160);
		echo  "<option value = $result[code]>$result[code] $plan_name</option>" ;
	}
echo "</select>";
echo "</div></td></tr>";

echo   "<tr><Td></Td><td align='right'>ผลผลิต/โครงการ&nbsp;&nbsp;</td>";
echo   "<td align='left'><div align='left'><Select name='project' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  budget_project where budget_year='$year_active_result[budget_year]' order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
   $product_name=$result['name'];
   $product_name=substr($product_name,0,160);
		echo  "<option value = $result[code]>$result[code] $product_name</option>" ;
	}
echo "</select>";
echo "</div></td></tr>";

echo   "<tr><Td></Td><td align='right'>กิจกรรมหลัก&nbsp;&nbsp;</td>";
echo   "<td><div align='left'><Select name='activity' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from  budget_key_activity where budget_year='$year_active_result[budget_year]' order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$key_activity_name = $result['name'];
		$key_activity_name=substr($key_activity_name,0,160);
		echo  "<option value = $result[code]>$result[code] $key_activity_name</option>" ;
	}
echo "</select>";
echo "</div></td></tr>";

echo   "<tr><Td></Td><td align='right'>รายการจ่าย&nbsp;&nbsp;</td>";
echo   "<td><div align='left'><Select name='pay_group' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  budget_pay_type order by pay_type_id";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$pay_type_name = $result['pay_type_name'];
		$pay_type_name =substr($pay_type_name,0,160);
		echo  "<option value = $result[pay_type_id]>$result[pay_type_id] $pay_type_name</option>" ;
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td ></Td><Td align='right'>รายการ&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='item' Size='60'></Td></Tr>";
echo "<Tr><Td ></Td><Td align='right'>จำนวนเงินคืน&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='money' Size='15' onkeydown='digitOnly()'></Td></Tr>";

echo "<Tr><Td ></Td><Td></Td><Td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<Input Type='checkbox' Name='check' value='1' checked>&nbsp;บันทึกข้อมูลในทะเบียนสั่งจ่ายเงินงบประมาณด้วย</Td></Tr>";

echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=budget&task=deega/return_deega&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=budget&task=deega/return_deega&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from budget_return_deega where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert  into  budget_return_deega (budget_year, document, receive_num,  plan, project, activity, pay_group, item, money, officer, rec_date)
values ('$year_active_result[budget_year]','$_POST[doc]', '$_POST[receive_num]', '$_POST[plan]', '$_POST[project]', '$_POST[activity]', '$_POST[pay_group]', '$_POST[item]', '$_POST[money]','$officer','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
//ส่วนการบันทึกทะเบียนเงินงบประมาณ
		if($_POST['check']==1){
		$sql = "insert into budget_main (budget_year, doc, type_id, item, pay_amount, pay_group, rec_date, officer) values ('$year_active_result[budget_year]', 'คืนคลัง$_POST[doc]', '200', '$_POST[item]','$_POST[money]','$_POST[pay_group]', '$rec_date','$officer')";
		$dbquery_bud = mysqli_query($connect,$sql);
				if($dbquery_bud){
				echo "<script>alert('ได้บันทึกข้อมูลในทะเบียนจ่ายเงินงบบประมาณด้วยแล้ว (สั่งจ่่าย)');</script>";
				}
		}
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
$sql = "select * from  budget_return_deega where id='$_GET[id]' ";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$doc= $result['document'];
		$receive_num= $result['receive_num'];
		$plan= $result['plan'];
		$project= $result['project'];
		$activity= $result['activity'];
		$pay_group= $result['pay_group'];
		$item2= $result['item'];
		$money= $result['money'];
		$officer= $result['officer'];
		$rec_date= $result['rec_date'];
	}
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขทะเบียนเงินคืนคลัง ปีประมาณ$year_active_result[budget_year]</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width=70% Border=0 Bgcolor=#Fcf9d8>";
echo "<Tr><Td ></Td><Td align='right'>วดป&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='rec_date' Size='10' value='$rec_date'></Td></Tr>";
echo "<Tr><Td></Td><Td align='right'>ที่เอกสาร&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='doc' Size='20' value='$doc'></Td></Tr>";

echo   "<tr><Td></Td><td align='right'>เลขที่ใบงวด&nbsp;&nbsp;</td>";
echo   "<td align='left'><div align=left><Select name='receive_num' size=1>";
echo  "<option  value = ''>เลือก</option>" ;
if($receive_num=='oth'){
echo  "<option  value = 'oth' selected>อื่นๆ</option>" ;
}
else{
echo  "<option  value = 'oth'>อื่นๆ</option>" ;
}
if($receive_num=='sly'){
echo  "<option  value = 'sly' selected>เงินเดือน</option>" ;
}
else{
echo  "<option  value = 'sly'>เงินเดือน</option>" ;
}
if($receive_num=='ctr'){
echo  "<option  value = 'ctr' selected>งบกลางค่ารักษาพยาบาล</option>" ;
}
else{
echo  "<option  value = 'ctr'>งบกลางค่ารักษาพยาบาล</option>" ;
}
if($receive_num=='etr'){
echo  "<option  value = 'etr' selected>งบกลางค่าการศึกษาบุตร</option>" ;
}
else{
echo  "<option  value = 'etr'>งบกลางค่าการศึกษาบุตร</option>" ;
}
$sql = "select * from budget_receive where  budget_year='$year_active_result[budget_year]' order by num desc";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$item  = $result[item];
		$item=  substr($item,0,160);
		if($result['num']==$receive_num){
		echo  "<option value = $result[num] selected>$result[num] $item</option>" ;
		}
		else{
		echo  "<option value = $result[num]>$result[num] $item</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td ></Td><Td align='right'>แผน&nbsp;&nbsp;</Td>";
echo   "<td align='left'><div align='left'><Select name='plan' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  budget_plan where budget_year='$year_active_result[budget_year]' order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
   $plan_name=$result['name'];
   $plan_name=substr($plan_name,0,160);
   		if($result['code']==$plan){
		echo  "<option value = $result[code] selected>$result[code] $plan_name</option>" ;
		}
		else{
		echo  "<option value = $result[code]>$result[code] $plan_name</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo   "<tr><Td></Td><td align='right'>ผลผลิต/โครงการ&nbsp;&nbsp;</td>";
echo   "<td align='left'><div align='left'><Select name='project' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  budget_project where budget_year='$year_active_result[budget_year]' order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
   $product_name=$result['name'];
   $product_name=substr($product_name,0,160);
   		if($result['code']==$project){
		echo  "<option value = $result[code] selected>$result[code] $product_name</option>" ;
		}
		else{
		echo  "<option value = $result[code]>$result[code] $product_name</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo   "<tr><Td></Td><td align='right'>กิจกรรมหลัก&nbsp;&nbsp;</td>";
echo   "<td><div align='left'><Select name='activity' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from  budget_key_activity where budget_year='$year_active_result[budget_year]' order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$key_activity_name = $result['name'];
		$key_activity_name=substr($key_activity_name,0,160);
		if($result['code']==$activity){
		echo  "<option value = $result[code] selected>$result[code] $key_activity_name</option>" ;
		}
		else {
		echo  "<option value = $result[code]>$result[code] $key_activity_name</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo   "<tr><Td></Td><td align='right'>รายการจ่าย&nbsp;&nbsp;</td>";
echo   "<td><div align='left'><Select name='pay_group' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  budget_pay_type order by pay_type_id";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$pay_type_name = $result['pay_type_name'];
		$pay_type_name =substr($pay_type_name,0,160);
		if($result['pay_type_id']==$pay_group){
		echo  "<option value = $result[pay_type_id] selected>$result[pay_type_id] $pay_type_name</option>" ;
		}
		else {
		echo  "<option value = $result[pay_type_id]>$result[pay_type_id] $pay_type_name</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td ></Td><Td align='right'>รายการ&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='item' Size='60' value='$item2'></Td></Tr>";
echo "<Tr><Td ></Td><Td align='right'>จำนวนเงิน&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='money' Size='15' value='$money' onkeydown='digitOnly()'></Td></Tr>";
echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'>";
echo "<INPUT TYPE='hidden' name='id' value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "update budget_return_deega set
document='$_POST[doc]',
receive_num='$_POST[receive_num]',
plan='$_POST[plan]',
project='$_POST[project]',
activity='$_POST[activity]',
pay_group='$_POST[pay_group]',
item='$_POST[item]',
money='$_POST[money]',
rec_date='$_POST[rec_date]',
officer='$officer' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงรายละเอียด
if ($index==7){
$sql = "select * from  budget_return_deega where id='$_GET[id]' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
		$id = $result['id'];
		$doc= $result['document'];
		$receive_num= $result['receive_num'];
		$plan= $result['plan'];
		$project= $result['project'];
		$activity= $result['activity'];
		$pay_group= $result['pay_group'];
		$item2= $result['item'];
		$money= $result['money'];
		$officer= $result['officer'];
		$rec_date= $result['rec_date'];

list($rec_year,$rec_month,$rec_day) = explode("-",$rec_date);
$t_year=($rec_year+543);
$to_date=$rec_day.$t_month[$rec_month].$t_year;

echo "<Br>";
echo "<Table align='center' width='60%' Border='0' Bgcolor='#Fcf9d8'>";
echo "<Tr ><Td colspan='7' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=budget&task=deega/return_deega&page=$_GET[page]\"'></Td></Tr>";

echo "<Tr align='left'><Td width='20'></Td><Td align='right'>วดป ลงทะเบียน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='' Size='10'  value='$to_date' readonly></Td></Tr>";

echo "<Tr><Td></Td><Td align='right'>ที่เอกสาร&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='doc' Size='20' value='$doc' readonly></Td></Tr>";

echo   "<tr><Td></Td><td align='right'>เลขที่ใบงวด&nbsp;&nbsp;</td>";
echo   "<td align='left'><div align=left><Select name='receive_num' size=1>";
echo  "<option  value = ''>เลือก</option>" ;
if($receive_num=='oth'){
echo  "<option  value = 'oth' selected>อื่นๆ</option>" ;
}
if($receive_num=='sly'){
echo  "<option  value = 'sly' selected>เงินเดือน</option>" ;
}
if($receive_num=='ctr'){
echo  "<option  value = 'ctr' selected>งบกลางค่ารักษาพยาบาล</option>" ;
}
if($receive_num=='etr'){
echo  "<option  value = 'etr' selected>งบกลางค่าการศึกษาบุตร</option>" ;
}
$sql = "select * from budget_receive where  budget_year='$year_active_result[budget_year]' order by num desc";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$item  = $result[item];
		$item=  substr($item,0,160);
		if($result['num']==$receive_num){
		echo  "<option value = $result[num] selected>$result[num] $item</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td ></Td><Td align='right'>แผน&nbsp;&nbsp;</Td>";
echo   "<td align='left'><div align='left'><Select name='plan' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  budget_plan where budget_year='$year_active_result[budget_year]' order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
   $plan_name=$result['name'];
   $plan_name=substr($plan_name,0,160);
   		if($result['code']==$plan){
		echo  "<option value = $result[code] selected>$result[code] $plan_name</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo   "<tr><Td></Td><td align='right'>ผลผลิต/โครงการ&nbsp;&nbsp;</td>";
echo   "<td align='left'><div align='left'><Select name='project' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  budget_project where budget_year='$year_active_result[budget_year]' order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
   $product_name=$result['name'];
   $product_name=substr($product_name,0,160);
   		if($result['code']==$project){
		echo  "<option value = $result[code] selected>$result[code] $product_name</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo   "<tr><Td></Td><td align='right'>กิจกรรมหลัก&nbsp;&nbsp;</td>";
echo   "<td><div align='left'><Select name='activity' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from  budget_key_activity where budget_year='$year_active_result[budget_year]' order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$key_activity_name = $result['name'];
		$key_activity_name=substr($key_activity_name,0,160);
		if($result['code']==$activity){
		echo  "<option value = $result[code] selected>$result[code] $key_activity_name</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo   "<tr><Td></Td><td align='right'>รายการจ่าย&nbsp;&nbsp;</td>";
echo   "<td><div align='left'><Select name='pay_group' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  budget_pay_type order by pay_type_id";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$pay_type_name = $result['pay_type_name'];
		$pay_type_name =substr($pay_type_name,0,160);
		if($result['pay_type_id']==$pay_group){
		echo  "<option value = $result[pay_type_id] selected>$result[pay_type_id] $pay_type_name</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td ></Td><Td align='right'>รายการ&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='item' Size='60' value='$item2' readonly></Td></Tr>";
echo "<Tr><Td ></Td><Td align='right'>จำนวนเงิน&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='money' Size='15' value='$money' readonly></Td></Tr>";
$sql = "select  * from  person_main where person_id='$officer' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$fullname=$result['prename'].$result['name']." ".$result['surname'];
echo "<Tr align='left'><Td ></Td><Td align='right'>เจ้าหน้าที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='' Size='30' value='$fullname' readonly></Td></Tr>";

echo "</Table>";
echo "<Br>";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7))){

//ส่วนของการคำนวณ
$sql = "select * from  budget_return_deega where budget_year='$year_active_result[budget_year]' order by id ";
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery); //นำไปแยกหน้า

//ส่วนของการแยกหน้า
$pagelen=20 ; // 1.กำหนดแถวต่อหน้า
$url_link="option=budget&task=deega/return_deega";  // 2_กำหนดลิงค์ฺ
$totalpages=ceil($num_rows/$pagelen);

//
if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}
//

if($_REQUEST['page']==""){
$page=$totalpages;
		if($page<2){
		$page=1;
		}
}
else{
		if($totalpages<$_REQUEST['page']){
		$page=$totalpages;
					if($page<1){
					$page=1;
					}
		}
		else{
		$page=$_REQUEST['page'];
		}
}

$start=($page-1)*$pagelen;

if(($totalpages>1) and ($totalpages<16)){
echo "<div align=center>";
echo "หน้า	";
			for($i=1; $i<=$totalpages; $i++)	{
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
					}
			}
echo "</div>";
}
if($totalpages>15){
			if($page <=8){
			$e_page=15;
			$s_page=1;
			}
			if($page>8){
					if($totalpages-$page>=7){
					$e_page=$page+7;
					$s_page=$page-7;
					}
					else{
					$e_page=$totalpages;
					$s_page=$totalpages-15;
					}
			}
			echo "<div align=center>";
			if($page!=1){
			$f_page1=$page-1;
			echo "<<a href=$PHP_SELF?$url_link&page=1>หน้าแรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>หน้าก่อน </a>";
			}
			else {
			echo "หน้า	";
			}
			for($i=$s_page; $i<=$e_page; $i++){
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
					}
			}
			if($page<$totalpages)	{
			$f_page2=$page+1;
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2> หน้าถัดไป</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages> หน้าสุดท้าย</a>>";
			}
			echo " <select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" name=\"select\">";
			echo "<option  value=\"\">หน้า</option>";
				for($p=1;$p<=$totalpages;$p++){
				echo "<option  value=\"?$url_link&page=$p\">$p</option>";
				}
			echo "</select>";
echo "</div>";
}
//จบแยกหน้า

echo  "<table width='90%' border='0' align='center'>";
$sql = "select * from  budget_return_deega where budget_year='$year_active_result[budget_year]' order by id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo "<Tr><Td colspan='7' align='left'><INPUT TYPE='button' name='smb' value='ลงทะเบียน' onclick='location.href=\"?option=budget&task=deega/return_deega&index=1\"'></Td></Tr>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='60'>ที่</Td><Td width='90'>ว/ด/ป</Td><Td width='120'>ที่เอกสาร</Td><Td width='70'>ใบงวด</Td><Td>รายการ</Td><Td width='120'>จำนวนเงิน</Td><Td></Td></Tr>";

$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$doc= $result['document'];
		$receive_num= $result['receive_num'];
		$item= $result['item'];
		$money= $result['money'];
		$money=number_format($money,2);
		$rec_date= $result['rec_date'];

		if(($M%2) == 0)
		$color="#FFFFC";
		else  	$color="#FFFFFF";

	list($rec_year,$rec_month,$rec_day) = explode("-",$rec_date);
	$t_year=($rec_year+543);
	$to_date=$rec_day.$t_month[$rec_month].$t_year;

		echo "<Tr bgcolor='$color' align='center'><Td>$N</Td><Td>$to_date</Td><Td align=left>$doc</Td><Td>$receive_num</Td><Td align=left>$item</Td><Td align=right>$money</Td>
		<Td width='70' align='left'>&nbsp;&nbsp;<a href=?option=budget&task=deega/return_deega&id=$id&index=7&page=$page><img src=./images/browse.png border='0' alt='รายละเอียด'></a>";
if($officer==$result['officer']){
echo "&nbsp;<a href=?option=budget&task=deega/return_deega&id=$id&index=2&page=$page><img src=./images/drop.png border='0' alt='ลบ'></a>&nbsp;<a href=?option=budget&task=deega/return_deega&id=$id&index=5&page=$page><img src=./images/edit.png border='0' alt='แก้ไข'>";
}
echo "</Td></Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
}
?>

<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=budget&task=deega/return_deega");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.plan.value==""){
			alert("กรุณาเลือกแผนงาน");
		}else if(frm1.project.value==""){
			alert("กรุณาเลือกผลผลิต/โครงการ");
		}else if(frm1.activity.value==""){
			alert("กรุณาเลือกกิจกรรมหลัก");
		}else if(frm1.pay_group.value == ""){
			alert("กรุณาเลือกรายการจ่าย");
		}else if(frm1.item.value == ""){
			alert("กรุณากรอกรายการ");
		}else if(frm1.money.value == ""){
			alert("กรุณากรอกจำนวนเงินขอเบิก");
		}else{
			callfrm("?option=budget&task=deega/return_deega&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=budget&task=deega/return_deega");   // page ย้อนกลับ
	}else if(val==1){
		 if(frm1.receive_num.value==""){
			alert("กรุณากรอกที่ใบงวด");
		}else if(frm1.plan.value==""){
			alert("กรุณาเลือกแผนงาน");
		}else if(frm1.project.value==""){
			alert("กรุณาเลือกผลผลิต/โครงการ");
		}else if(frm1.activity.value==""){
			alert("กรุณาเลือกกิจกรรมหลัก");
		}else if(frm1.pay_group.value == ""){
			alert("กรุณาเลือกรายการจ่าย");
		}else if(frm1.item.value == ""){
			alert("กรุณากรอกรายการ");
		}else if(frm1.money.value == ""){
			alert("กรุณากรอกจำนวนเงินขอเบิก");
		}else{
			callfrm("?option=budget&task=deega/return_deega&index=6");   //page ประมวลผล
		}
	}
}

</script>
