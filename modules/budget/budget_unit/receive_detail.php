<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ปีงบประมาณ
$sql = "select * from  budget_year where year_active='1' order by budget_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['budget_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีงบประมาณใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีงบประมาณ</div>";
exit();
}
?>

<br /><br />
<div align="center"><font color="#006666" size="3"><strong>รายละเอียด การโอนเปลียนแปลงการจัดสรรงบประมาณรายจ่าย ปีงบประมาณ <?=$year_active_result['budget_year']?></strong></font></div>

<?php

$sql = "select * from  budget_receive where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$num= $result['num'];
		$book_number= $result['book_number'];
		$out_date= $result['out_date'];
		$book_ref= $result['book_ref'];
		$plan= $result['plan'];
		$project= $result['project'];
		$activity= $result['activity'];
		$activity2= $result['activity2'];
		$m_source= $result['m_source'];
		$account= $result['account'];
		$m_pay= $result['m_pay'];
		$item= $result['item'];
		$detail= $result['detail'];
		$money= $result['money'];
		$file= $result['file'];
		$money=number_format($money,2);
		$rec_date= $result['rec_date'];
		$officer= $result['officer'];
}

$sql = "select  * from  budget_plan where budget_year='$year_active_result[budget_year]'";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
{
		$code = $result['code'];
		$name = $result['name'];
		$plan_ar[$code]=$name;
}

$sql = "select  * from  budget_project where budget_year='$year_active_result[budget_year]'";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
{
		$code = $result['code'];
		$name = $result['name'];
		$project_ar[$code]=$name;
}

 $sql = "select  * from  budget_key_activity where budget_year='$year_active_result[budget_year]'";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
{
		$code = $result['code'];
		$name = $result['name'];
		$activity_ar[$code]=$name;
}

 $sql = "select  * from  budget_money_source where budget_year='$year_active_result[budget_year]'";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
{
		$code = $result['code'];
		$name = $result['name'];
		$m_source_ar[$code]=$name;
}

$sql = "select * from budget_pay_type order by pay_type_id";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
{
		$code = $result['pay_type_id'];
		$name = $result['pay_type_name'];
		$pay_group_ar[$code]=$name;
}

echo "<Form>";
echo "<Table  align='center' width='85%' Border='0' Bgcolor='#Fcf9d8'>";
echo "<Tr ><Td colspan='2' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=budget&task=budget_unit/receive&page=$_GET[page]\"'></Td></Tr>";
echo "<Tr><Td align='right' width='30%'>เลขที่ใบงวด&nbsp;&nbsp;</Td><Td><Input Type=Text Name=''_number Size='5'  value='$num'></Td></Tr>";
echo "<Tr><Td align='right' width='30%'>เลขที่หนังสือ&nbsp;&nbsp;</Td><Td><Input Type=Text Name='book'_number Size='20'  value='$book_number'></Td></Tr>";
echo "<Tr><Td align='right'>ลงวันที่&nbsp;&nbsp;</Td><Td><Input Type='Text'  name='out_date' Size='20' value='$out_date'></Td></Tr>";
echo "<Tr><Td align='right'>อ้างอิงหนังสือจัดสรร&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='book_ref' Size='20' value='$book_ref'></Td></Tr>";
echo "<Tr><Td align='right'>แผนงาน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='plan' Size='80'  value='$plan_ar[$plan]'></Td></Tr>";
echo "<Tr><Td align='right'>ผลผลิต/โครงการ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='project' Size='80'  value='$project&nbsp;$project_ar[$project]'></Td></Tr>";
echo "<Tr><Td align='right'>กิจกรรมหลัก&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='activity' Size='80' value='$activity&nbsp;$activity_ar[$activity]'></Td></Tr>";
echo  "<tr><td align='right'>กิจกรรมหลักเพิ่มเติม&nbsp;&nbsp;</td>";
echo   "<td><div align='left'><textarea  name='activity2' cols='40' rows='2'>$activity2</textarea></div></td></tr>";
echo "<Tr><Td align='right'>แหล่งของเงิน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='m_source' Size='60' value='$m_source&nbsp;$m_source_ar[$m_source]'></Td></Tr>";
echo "<Tr><Td align='right'>รหัสบัญชี&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='account' Size='20'  value='$account'></Td></Tr>";
echo "<Tr><Td align='right'>งบรายจ่าย&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='m_pay' Size='60'  value='$m_pay&nbsp;$pay_group_ar[$m_pay]'></Td></Tr>";
echo "<Tr><Td align='right'>รายการ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='item' Size='80'  value='$item'></Td></Tr>";
echo   "<tr><td align='right'>รายละเอียด&nbsp;&nbsp;</td>";
echo   "<td><div align='left'><textarea  name='detail' cols='40' rows='4'>$detail</textarea></div></td></tr>";
echo "<Tr><Td align='right'>จำนวนเงิน&nbsp;&nbsp;</Td><Td><Input Type='Tex't Name='mone'y Size='20' value='$money'>&nbsp;บาท</Td></Tr>";
echo "<Tr><Td align='right'>บันทึกข้อมูล (ปีคศ.  เดือน วัน)&nbsp;&nbsp;</Td><Td><Input Type=Text  Size=20  value=$rec_date></Td></Tr>";
if($file!=""){
echo "<Tr><Td align='right'>ไฟล์เอกสาร&nbsp;&nbsp;</Td><Td><a href=$file target=_blank><img src=./images/browse.png border='0' alt='File'></Td></Tr>";
}
echo "<Tr><Td></Td><Td></Td></Tr>";
echo "<Br>";
echo "</Table>";
echo "</Form>";
?>
