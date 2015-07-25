<br />
<div align="center">
        <font color="#006666" size="3"><strong>เงินคืนคลัง</strong></font>
 </div>

<?php
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
$year_index=$_REQUEST['year_index'];
if($year_index!=""){
$year_active_result['budget_year']=$year_index;
}
else{
$sql = "select * from  budget_year where year_active='1' order by budget_year desc limit 1";
$dbquery = mysqli_query($connect, $sql);
$year_active_result = mysqli_fetch_array($dbquery);
			if($year_active_result['budget_year']==""){
			echo "<br />";
			echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีงบประมาณใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีงบประมาณ</div>";
			exit();
			}
}

$sql = "select * from  budget_return_deega where id='$_GET[id]' ";
$dbquery = mysqli_query($connect, $sql);
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
echo "<Table align='center' width='70%' Border='0' Bgcolor='#Fcf9d8'>";
echo "<Tr ><Td colspan='7' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=budget&task=main/report_10_2&page=$_GET[page]&year_index=$year_active_result[budget_year]&num=$_GET[num]\"'></Td></Tr>";

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
$dbquery = mysqli_query($connect, $sql);
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
$dbquery = mysqli_query($connect, $sql);
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
$dbquery = mysqli_query($connect, $sql);
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
$dbquery = mysqli_query($connect, $sql);
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

echo   "<tr><Td></Td><td align='right'>งบรายจ่าย&nbsp;&nbsp;</td>";
echo   "<td><div align='left'><Select name='pay_group' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  budget_pay_type order by pay_type_id";
$dbquery = mysqli_query($connect, $sql);
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
$dbquery = mysqli_query($connect, $sql);
$result = mysqli_fetch_array($dbquery);
$fullname=$result['prename'].$result['name']." ".$result['surname'];
echo "<Tr align='left'><Td ></Td><Td align='right'>เจ้าหน้าที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='' Size='30' value='$fullname' readonly></Td></Tr>";

echo "</Table>";
?>
