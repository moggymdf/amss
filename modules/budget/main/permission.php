<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if($_SESSION['admin_budget']!='budget'){
exit();
}

echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เจ้าหน้าที่การเงินและบัญชี</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มเจ้าหน้าที่การเงิน และกำหนดสิทธิหน้าที่</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0' Bgcolor='#Fcf9d8'>";
echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='person_id'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from person_main where status<'1' order by name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		echo  "<option value = $person_id>$name $surname</option>" ;
	}
echo "</select>";
echo "</div></td></tr>";

echo   "<tr><td align='right'>ผู้อนุมัติ&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission1' value='1'>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission1' value='0'  checked></td></tr>";

echo   "<tr><td align='right'>ทะเบียนเงินงวด&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission2' value='1'>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission2' value='0'  checked></td></tr>";

echo   "<tr><td align='right'>ทะ่เบียนขอเบิก&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission3' value='1'>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission3' value='0'  checked></td></tr>";

echo   "<tr><td align='right'>ทะเบียนฎีกา&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission4' value='1'>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission4' value='0'  checked></td></tr>";

echo   "<tr><td align='right'>ทะเบียนเงินงบประมาณ&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission5' value='1'>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission5' value='0'  checked></td></tr>";

echo   "<tr><td align='right'>ทะเบียนเงินนอกงบประมาณ&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission6' value='1'>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission6' value='0'  checked></td></tr>";

echo   "<tr><td align='right'>ทเเบียนเงินรายได้แผ่นดิน&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission7' value='1'>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission7' value='0'  checked></td></tr>";

echo   "<tr><td align='right'>ทะเบียนเงินทดรองราชการ&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission8' value='1'>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission8' value='0'  checked></td></tr>";

echo   "<tr><td align='right'>จ่ายเงิน&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission9' value='1'>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission9' value='0'  checked></td></tr>";

echo   "<tr><td align='right'>ดูรายงาน&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission10' value='1'>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission10' value='0'  checked></td></tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
	&nbsp;&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=budget&task=main/permission&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=budget&task=main/permission\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from budget_permission where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=budget&task=main/permission';</script>";
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into budget_permission (person_id, p1, p2, p3, p4,p5, p6, p7, p8, p9, p10,  officer,rec_date) values ('$_POST[person_id]', '$_POST[budget_permission1]','$_POST[budget_permission2]', '$_POST[budget_permission3]', '$_POST[budget_permission4]','$_POST[budget_permission5]','$_POST[budget_permission6]','$_POST[budget_permission7]','$_POST[budget_permission8]','$_POST[budget_permission9]','$_POST[budget_permission10]','$_SESSION[login_user_id]','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=budget&task=main/permission';</script>";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข เจ้าหน้าที่การเงินและบัญชี</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border= '0' Bgcolor='#Fcf9d8'>";
$sql = "select * from budget_permission where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='person_id'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from person_main where status='0' order by name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		if($person_id==$ref_result['person_id']){
		echo  "<option value = $person_id selected>$name $surname</option>";
		}
		else{
		echo  "<option value = $person_id>$name $surname</option>";
		}
	}
echo "</select>";
echo "</div></td></tr>";
			if($ref_result['p1']==1){
			$p1_check1="checked";
			$p1_check2="";
			}
			else{
			$p1_check1="";
			$p1_check2="checked";
			}
			if($ref_result['p2']==1){
			$p2_check1="checked";
			$p2_check2="";
			}
			else{
			$p2_check1="";
			$p2_check2="checked";
			}
			if($ref_result['p3']==1){
			$p3_check1="checked";
			$p3_check2="";
			}
			else{
			$p3_check1="";
			$p3_check2="checked";
			}
			if($ref_result['p4']==1){
			$p4_check1="checked";
			$p4_check2="";
			}
			else{
			$p4_check1="";
			$p4_check2="checked";
			}
			if($ref_result['p5']==1){
			$p5_check1="checked";
			$p5_check2="";
			}
			else{
			$p5_check1="";
			$p5_check2="checked";
			}
			if($ref_result['p6']==1){
			$p6_check1="checked";
			$p6_check2="";
			}
			else{
			$p6_check1="";
			$p6_check2="checked";
			}
			if($ref_result['p7']==1){
			$p7_check1="checked";
			$p7_check2="";
			}
			else{
			$p7_check1="";
			$p7_check2="checked";
			}
			if($ref_result['p8']==1){
			$p8_check1="checked";
			$p8_check2="";
			}
			else{
			$p8_check1="";
			$p8_check2="checked";
			}
			if($ref_result['p9']==1){
			$p9_check1="checked";
			$p9_check2="";
			}
			else{
			$p9_check1="";
			$p9_check2="checked";
			}
			if($ref_result['p10']==1){
			$p10_check1="checked";
			$p10_check2="";
			}
			else{
			$p10_check1="";
			$p10_check2="checked";
			}
echo   "<tr><td align='right'>ผู้อนุมัติ&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission1' value='1' $p1_check1>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission1' value='0' $p1_check2></td></tr>";

echo   "<tr><td align='right'>ทะเบียนเงินงวด&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission2' value='1' $p2_check1>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission2' value='0' $p2_check2></td></tr>";

echo   "<tr><td align='right'>ทะ่เบียนขอเบิก&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission3' value='1' $p3_check1>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission3' value='0' $p3_check2></td></tr>";

echo   "<tr><td align='right'>ทะเบียนฎีกา&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission4' value='1' $p4_check1>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission4' value='0' $p4_check2></td></tr>";

echo   "<tr><td align='right'>ทะเบียนเงินงบประมาณ&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission5' value='1' $p5_check1>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission5' value='0' $p5_check2></td></tr>";

echo   "<tr><td align='right'>ทะเบียนเงินนอกงบประมาณ&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission6' value='1' $p6_check1>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission6' value='0' $p6_check2></td></tr>";

echo   "<tr><td align='right'>ทเเบียนเงินรายได้แผ่นดิน&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission7' value='1' $p7_check1>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission7' value='0' $p7_check2></td></tr>";

echo   "<tr><td align='right'>ทะเบียนเงินทดรองราชการ&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission8' value='1' $p8_check1>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission8' value='0' $p8_check2></td></tr>";

echo   "<tr><td align='right'>จ่ายเงิน&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission9' value='1' $p9_check1>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission9' value='0' $p9_check2></td></tr>";

echo   "<tr><td align='right'>ดูรายงาน&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='budget_permission10' value='1' $p10_check1>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='budget_permission10' value='0' $p10_check2></td></tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update budget_permission set  person_id='$_POST[person_id]', p1='$_POST[budget_permission1]', p2='$_POST[budget_permission2]',p3='$_POST[budget_permission3]',p4='$_POST[budget_permission4]',p5='$_POST[budget_permission5]',p6='$_POST[budget_permission6]',p7='$_POST[budget_permission7]',p8='$_POST[budget_permission8]',p9='$_POST[budget_permission9]',p10='$_POST[budget_permission10]',officer='$_SESSION[login_user_id]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=budget&task=main/permission'; </script>\n";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

$sql = "select budget_permission.id, budget_permission.p1, budget_permission.p2, budget_permission.p3, budget_permission.p4,budget_permission.p5,budget_permission.p6,budget_permission.p7,budget_permission.p8,budget_permission.p9,budget_permission.p10, person_main.name, person_main.surname from budget_permission left join person_main on budget_permission.person_id=person_main.person_id order by budget_permission.id";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width=95% border=0 align=center>";
echo "<Tr><Td colspan='5' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มเจ้าหน้าที่' onclick='location.href=\"?option=budget&task=main/permission&index=1\"'</Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td  align='center' rowspan='2' >ที่</Td><Td  align='center' rowspan='2'>ชื่อเจ้าหน้าที่</Td><td  align='center' colspan='10'>สิทธื์</td><Td align='center' rowspan='2' >ลบ</Td><Td align='center' rowspan='2' >แก้ไข</Td></Tr>";
echo "<tr bgcolor='#CC9900'><Td  align='center' width='60'>ผู้อนุมัติ</Td><Td align='center' width='60'>เงินงวด</Td><Td align='center' width='60'>ขอเบิก</Td><Td align='center' width='60'>วางฎีกา</Td><Td align='center' width='60'>เงินงบประมาณ</Td><Td align='center' width='60'>เงินนอกงบประมาณ</Td><Td align='center' width='60'>เงินรายได้แผ่นดิน</Td><Td align='center' width='60'>เงินทดรองราชการ</Td><Td align='center' width='60'>จ่ายเงิน</Td><Td align='center' width='60'>ดูรายงาน</Td></tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$name = $result['name'];
		$surname = $result['surname'];
			if($result['p1']==1){
			$p1_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p1_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
			if($result['p2']==1){
			$p2_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p2_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
			if($result['p3']==1){
			$p3_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p3_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
			if($result['p4']==1){
			$p4_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p4_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
			if($result['p5']==1){
			$p5_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p5_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
			if($result['p6']==1){
			$p6_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p6_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
			if($result['p7']==1){
			$p7_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p7_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
			if($result['p8']==1){
			$p8_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p8_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
			if($result['p9']==1){
			$p9_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p9_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
			if($result['p10']==1){
			$p10_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p10_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left'>$name $surname</Td><Td align='center'>$p1_pic</Td><Td align='center'>$p2_pic</Td><Td align='center'>$p3_pic</Td><Td align='center'>$p4_pic</Td><Td align='center'>$p5_pic</Td><Td align='center'>$p6_pic</Td><Td align='center'>$p7_pic</Td><Td align='center'>$p8_pic</Td><Td align='center'>$p9_pic</Td><Td align='center'>$p10_pic</Td>
		<Td align='center' width='50' ><a href=?option=budget&task=main/permission&index=2&id=$id><img src=images/drop.png border='0' alt='ลบ'></a></Td>
		<Td align='center' width='50'><a href=?option=budget&task=main/permission&index=5&id=$id><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
$M++;
	}
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=budget&task=main/permission");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=budget&task=main/permission&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=budget&task=main/permission");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=budget&task=main/permission&index=6");   //page ประมวลผล
		}
	}
}
</script>
