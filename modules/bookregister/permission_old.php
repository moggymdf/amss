<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เจ้าหน้าที่</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มเจ้าหน้าที่</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0' Bgcolor='#Fcf9d8'>";
echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='person_id'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

//นำเข้าข้อมูลบุคลากร
//require_once("person_chk.php");

$sql = "select  * from person_main where status='0' order by name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		$department = $result['department'];
		$sub_department = $result['sub_department'];
		echo  "<option value = $person_id>$name $surname</option>" ;
	}
echo "</select>";
echo "</div></td></tr>";

//เลือกสำนัก
echo "<Tr><Td align='right'>สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='department'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from system_department  order by department ASC";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$department = $result['department'];
		$department_name = $result['department_name'];
		if($department==$ref_result['department']){
		echo  "<option value = $department selected>$department_name</option>";
		}
		else{
		echo  "<option value = $department>$department_name</option>";
		}
	}
echo "</select>";

echo "</div></td></tr>";

echo   "<tr><td align='right'>อนุญาตให้เป็นเจ้าหน้าที่&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type=radio name='bookregister_permission1' value='1' checked>ใช่&nbsp;&nbsp;<input  type=radio name='bookregister_permission1' value='0'>ไม่ใช่</td></tr>";

echo   "<tr><td align='right'>กำหนดบทบาทหน้าที่&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type=radio name='saraban_status' value='1' >สารบรรณกลาง สพฐ.&nbsp;&nbsp;<input  type=radio name='saraban_status' value='2'>สารบรรณสำนัก&nbsp;&nbsp;<input  type=radio name='saraban_status' value='3'>สารบรรณกลุ่ม</td></tr>";

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
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=bookregister&task=permission&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=bookregister&task=permission\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from bookregister_permission where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=bookregister&task=permission'; </script>\n";
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into bookregister_permission (person_id, p1, officer, department, sub_department, saraban_status, rec_date) values ('$_POST[person_id]', '$_POST[bookregister_permission1]', '$_SESSION[login_user_id]','$_POST[department]', '$_POST[sub_department]','$_POST[saraban_status]','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=bookregister&task=permission'; </script>\n";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข เจ้าหน้าที่</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border= '0' Bgcolor='#Fcf9d8'>";
$sql = "select * from bookregister_permission where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='person_id'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from person_main where status='0' order by name";
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
//เลือกสำนัก
echo "<Tr><Td align='right'>สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='department_id'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from system_department  order by department ASC";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$department = $result['department'];
		$department_name = $result['department_name'];
		if($department==$ref_result['department']){
		echo  "<option value = $department selected>$department_name</option>";
		}
		else{
		echo  "<option value = $department>$department_name</option>";
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
		if($ref_result['saraban_status']==1){
			$s1_check1="checked";
			$s1_check2="";
			}
		if($ref_result['saraban_status']==2){
			$s2_check1="checked";
			$s2_check2="";
			}
		if($ref_result['saraban_status']==3){
			$s3_check1="checked";
			$s3_check2="";
			}


echo   "<tr><td align='right'>อนุญาตให้เป็นเจ้าหน้าที่ได้&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type=radio name='bookregister_permission1' value='1' $p1_check1>ใช่&nbsp;&nbsp;<input  type=radio name='bookregister_permission1' value='0' $p1_check2>ไม่ใช่</td></tr>";

echo   "<tr><td align='right'>กำหนดบทบาทหน้าที่&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type=radio name='saraban_status' value='1' $s1_check1>สารบรรณกลาง สพฐ.&nbsp;&nbsp;<input  type=radio name='saraban_status' value='2' $s2_check1>สารบรรณสำนัก&nbsp;&nbsp;<input  type=radio name='saraban_status' value='3' $s3_check1>สารบรรณกลุ่ม</td></tr>";


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
$sql = "update bookregister_permission set  person_id='$_POST[person_id]', p1='$_POST[bookregister_permission1]', officer='$_SESSION[login_user_id]', department='$_POST[department_id]', sub_department='$sub_department', saraban_status='$_POST[saraban_status]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=bookregister&task=permission'; </script>\n";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

$sql = "select bookregister_permission.id, bookregister_permission.p1, bookregister_permission.department, bookregister_permission.saraban_status, person_main.name, person_main.surname from bookregister_permission left join person_main on bookregister_permission.person_id=person_main.person_id where bookregister_permission.school_code is null order by bookregister_permission.id";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width=80% border=0 align=center>";
echo "<Tr><Td colspan='5' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มเจ้าหน้าที่' onclick='location.href=\"?option=bookregister&task=permission&index=1\"'</Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td  align='center' rowspan='2' >ที่</Td><Td  align='center' rowspan='2' >ชื่อเจ้าหน้าที่</Td>
  <Td colspan='3'  align='center' >บทบาท</Td>
  <td  align='center'>สิทธิ์</td><Td align='center' rowspan='2' width='50'>ลบ</Td><Td align='center' rowspan='2' width='50'>แก้ไข</Td></Tr>";
echo "'<tr bgcolor='#CC9900'>
  <Td  align='center' bgcolor='#FFFFCC' >สารบรรณกลาง สพฐ.</Td>
  <Td  align='center' bgcolor='#FFFFCC' >สารบรรณสำนัก</Td>
  <Td  align='center' bgcolor='#FFFFCC' >สารบรรณกลุ่ม</Td>
  <Td  align='center' width='80'>เจ้าหน้าที่</Td></tr>";
//echo "<tr bgcolor='#CC9900'><Td  align='center' width='80'>เจ้าหน้าที่</Td></tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$name = $result['name'];
		$surname = $result['surname'];
		$department_id = $result['department'];
		$saraban_status = $result['saraban_status'];

			if($result['p1']==1){
			$p1_pic="<img src=images/yes.png border='0' title='มีสิทธิ์'>";			}
			else{
			$p1_pic="<img src=images/no.png border='0' title='ไม่มีสิทธิ์'>";
			}

			//แสดงบทบาท
			if($result['saraban_status']==1){
			$s1_pic="<img src=images/yes.png border='0' title='มีสิทธิ์'>";			}
			else{
			$s1_pic="<img src=images/no.png border='0' title='ไม่มีสิทธิ์'>";
			}
			if($result['saraban_status']==2){
			$s2_pic="<img src=images/yes.png border='0' title='มีสิทธิ์'>";			}
			else{
			$s2_pic="<img src=images/no.png border='0' title='ไม่มีสิทธิ์'>";
			}
			if($result['saraban_status']==3){
			$s3_pic="<img src=images/yes.png border='0' title='มีสิทธิ์'>";			}
			else{
			$s3_pic="<img src=images/no.png border='0' title='ไม่มีสิทธิ์'>";
			}

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
			//เรียกชื่อสำนัก
	$sql_d="select * from system_department where department = '$department_id' ";		 //รหัสสำนัก
	$dbquery_d = mysqli_query($connect,$sql_d);
	$result_d = mysqli_fetch_array($dbquery_d);
	$department_name = $result_d['department_name'];
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left'>$name $surname ($department_name)</Td>
  <Td  align='center'>$s1_pic</Td>
  <Td  align='center'>$s2_pic</Td>
  <Td  align='center'>$s3_pic</Td>
  <Td align='center'>$p1_pic</Td>
		<Td align='center' width='50' ><a href=?option=bookregister&task=permission&index=2&id=$id><img src=images/drop.png border='0' alt='ลบ'></a></Td>
		<Td align='center' width='50'><a href=?option=bookregister&task=permission&index=5&id=$id><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
$M++;
	}
echo "</Table>";
}
?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=bookregister&task=permission");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=bookregister&task=permission&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=bookregister&task=permission");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=bookregister&task=permission&index=6");   //page ประมวลผล
		}
	}
}
</script>
