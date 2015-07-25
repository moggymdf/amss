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
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ทะเบียนฎีกาที่ยกเลิก ปีงบประมาณ $year_active_result[budget_year]</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>ยกเลิกฎีกา ปีงบประมาณ $year_active_result[budget_year]</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='70%' Border='0'>";
echo "<Tr><Td></Td><Td align='right'>เลขที่ฎีกา&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='deega' Size='3'></Td></Tr>";

echo "<Tr><Td></Td><Td align='right'>ที่เอกสารอ้างอิง&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='ref' Size='20'></Td></Tr>";

echo "<Tr><Td></Td><Td align='right'>สาเหตุการยกเลิก&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='comment' Size='70'></Td></Tr>";

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
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=budget&task=main/cancel_deega&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=budget&task=main/cancel_deega\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from budget_cancel_deega where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert  into  budget_cancel_deega (budget_year, deega, ref, comment, officer, rec_date)
values ('$year_active_result[budget_year]','$_POST[deega]', '$_POST[ref]', '$_POST[comment]', '$officer','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
$sql = "select * from  budget_cancel_deega where id='$_GET[id]' ";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$deega= $result['deega'];
		$ref= $result['ref'];
		$comment= $result['comment'];
		$officer= $result['officer'];
		$rec_date= $result['rec_date'];
	}
echo "<form id='frm1' name='frm1'>";
echo "<Br>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขทะเบียนยกเลิกฎีกา ปีประมาณ$year_active_result[budget_year]</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0' >";
echo "<Tr><Td ></Td><Td align='right'>วดป&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='rec_date' Size='10' value='$rec_date'></Td></Tr>";

echo "<Tr><Td></Td><Td align='right'>ฎีกา&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='deega' Size='5' value='$deega'></Td></Tr>";

echo "<Tr><Td></Td><Td align='right'>ที่เอกสาร&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='ref' Size='20' value='$ref'></Td></Tr>";

echo "<Tr><Td></Td><Td align='right'>สาเหตุการยกเลิก&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='comment' Size='70' value='$comment'></Td></Tr>";

echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'>";
echo "<INPUT TYPE='hidden' name='id' value='$_GET[id]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "update budget_cancel_deega set
deega='$_POST[deega]',
ref='$_POST[ref]',
comment='$_POST[comment]',
rec_date='$_POST[rec_date]',
officer='$officer' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงรายละเอียด
if ($index==7){
$sql = "select * from  budget_cancel_deega where id='$_GET[id]' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
		$id = $result['id'];
		$deega= $result['deega'];
		$ref= $result['ref'];
		$comment= $result['comment'];
		$officer= $result['officer'];
		$rec_date= $result['rec_date'];

list($rec_year,$rec_month,$rec_day) = explode("-",$rec_date);
$t_year=($rec_year+543);
$to_date=$rec_day.$t_month[$rec_month].$t_year;

echo "<Br>";
echo "<Table align='center' width='50%' Border='0' Bgcolor='#Fcf9d8'>";
echo "<Tr ><Td colspan='7' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=budget&task=main/cancel_deega\"'></Td></Tr>";

echo "<Tr align='left'><Td width='20'></Td><Td align='right'>วดป ลงทะเบียน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='' Size='10'  value='$to_date' readonly></Td></Tr>";

echo "<Tr><Td></Td><Td align='right'>ฎีกา&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='' Size='10' value='$deega' readonly></Td></Tr>";

echo "<Tr><Td></Td><Td align='right'>ที่เอกสารอ้างอิง&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='' Size='20' value='$ref' readonly></Td></Tr>";

echo "<Tr><Td></Td><Td align='right'>สาเหตุการยกเลิก&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='' Size='60' value='$comment' readonly></Td></Tr>";

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

echo  "<table width='80%' border='0' align='center'>";
$sql = "select * from  budget_cancel_deega where budget_year='$year_active_result[budget_year]' ";
$dbquery = mysqli_query($connect,$sql);
echo "<Tr><Td colspan='7' align='left'><INPUT TYPE='button' name='smb' value='บันทึกข้อมูล' onclick='location.href=\"?option=budget&task=main/cancel_deega&index=1\"'></Td></Tr>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='40'>ที่</Td><Td width='90'>ว/ด/ป</Td><Td width='40'>ฎีกา</Td><Td width='150'>เลขที่เอกสารอ้างอิง</Td><Td>สาเหตุการยกเลิก</Td><Td></Td></Tr>";

$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$deega= $result['deega'];
		$ref= $result['ref'];
		$comment= $result['comment'];
		$rec_date= $result['rec_date'];

		if(($M%2) == 0)
		$color="#FFFFC";
		else  	$color="#FFFFFF";

	list($rec_year,$rec_month,$rec_day) = explode("-",$rec_date);
	$t_year=($rec_year+543);
	$to_date=$rec_day.$t_month[$rec_month].$t_year;

		echo "<Tr bgcolor='$color' align='center'><Td>$M</Td><Td align='left'>$to_date</Td><Td align='center'>$deega</Td><Td align='left'>$ref</Td><Td align='left'>$comment</Td>
		<Td width='70' align='center'><a href=?option=budget&task=main/cancel_deega&id=$id&index=7><img src=./images/browse.png border='0' alt='รายละเอียด'></a>
		<a href=?option=budget&task=main/cancel_deega&id=$id&index=2><img src=./images/drop.png border='0' alt='ลบ'></a></a>
		<a href=?option=budget&task=main/cancel_deega&id=$id&index=5><img src=./images/edit.png border='0' alt='แก้ไข'></Td>
	</Tr>";
$M++;
}
}
?>

<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=budget&task=main/cancel_deega");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.deega.value==""){
			alert("กรุณากรอกเลขที่ฎีกาที่ต้องการยกเลิก");
		}else if(frm1.comment.value==""){
			alert("กรุณากรอกสาเหตุการยกเลิก");
		}else{
			callfrm("?option=budget&task=main/cancel_deega&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=budget&task=main/cancel_deega");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.deega.value==""){
			alert("กรุณากรอกเลขที่ฎีกาที่ต้องการยกเลิก");
		}else if(frm1.comment.value==""){
			alert("กรุณากรอกสาเหตุการยกเลิก");
		}else{
			callfrm("?option=budget&task=main/cancel_deega&index=6");   //page ประมวลผล
		}
	}
}

</script>
