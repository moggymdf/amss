<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เจ้าหน้าสารบรรณ</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มเจ้าหน้าที่</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
//echo "<Table width='50%' Border='0' Bgcolor='#Fcf9d8'>";
echo "<div align='center'><table width='50%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

echo "<Tr><Td align='right'>เจ้าหน้าที่สารบรรณกลาง สพฐ.&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><input type='radio' name='ctr_saraban' value='0' checked> ไม่ใช่&nbsp;<input type='radio' name='ctr_saraban' value='1'> ใช่ ";

echo "<Tr><Td align='right' >เจ้าหน้าที่สารบรรณ สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='saraban_grp'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from system_department order by department";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
	echo  "<option value = $result[department]>$result[department_name]</option>" ;
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='person_id'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from person_main order by position_code";
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

//echo "<tr><td></td><td></td></tr>";
echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
	&nbsp;&nbsp;&nbsp;";
echo "<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</td></tr></table>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=book&task=permission&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=book&task=permission\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from book_permission where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=book&task=permission'; </script>\n";
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into book_permission (person_id, p1, p2, officer,rec_date) values ('$_POST[person_id]', '$_POST[ctr_saraban]', '$_POST[saraban_grp]','$_SESSION[login_user_id]','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=book&task=permission'; </script>\n";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข เจ้าหน้าที่</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<div align='center'><table width='50%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

//echo "<Table width='50%' Border= '0' Bgcolor='#Fcf9d8'>";
$sql = "select * from book_permission where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);

if($ref_result['p1']==1){
$ctr_saraban_check1="checked";
$ctr_saraban_check0="";
}
else{
$ctr_saraban_check0="checked";
$ctr_saraban_check1="";
}

echo "<Tr><Td align='right' width='50%'>เจ้าหน้าที่สารบรรณกลาง สพฐ.&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><input type='radio' name='ctr_saraban' value='0' $ctr_saraban_check0> ไม่ใช่&nbsp;<input type='radio' name='ctr_saraban' value='1' $ctr_saraban_check1> ใช่ ";

echo "<Tr><Td align='right' width='50%'>เจ้าหน้าที่สารบรรณ สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='saraban_grp'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from system_department order by department";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		if($result[department]==$ref_result['p2']){
		echo  "<option value = $result[department] selected>$result[department_name]</option>" ;
		}
		else{
		echo  "<option value = $result[department]>$result[department_name]</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td align='right' width='50%'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='person_id'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from person_main order by position_code";
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
echo   "<tr><td align='right'>อนุญาตให้เป็นเจ้าหน้าที่ได้&nbsp;&nbsp;</td>";
echo   "<td align='left'> <input  type=radio name='book_permission1' value='1' $p1_check1> ใช่&nbsp;&nbsp; <input  type=radio name='book_permission1' value='0' $p1_check2> ไม่ใช่</td></tr>";

//echo "<tr><td></td><td></td></tr>";
echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</td></tr></table>";

echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update book_permission set  person_id='$_POST[person_id]', p1='$_POST[ctr_saraban]', p2='$_POST[saraban_grp]', officer='$_SESSION[login_user_id]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=book&task=permission'; </script>\n";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

// อาเรย์ชื่อหน่วยงาาน
$office_name_ar['saraban']="สาราบรรณกลาง";
$sql_work_group = mysqli_query($connect,"SELECT * FROM  system_department") ;
while ($row_work_group= mysqli_fetch_array($sql_work_group)){
$office_name_ar[$row_work_group['department']]=$row_work_group['department_name'];
}

$sql = "select book_permission.id, book_permission.p1, book_permission.p2, person_main.prename, person_main.name, person_main.surname from book_permission left join person_main on book_permission.person_id=person_main.person_id where person_main.status>='0' order by book_permission.id";
$dbquery = mysqli_query($connect,$sql);
//echo  "<table width=50% border=0 align=center>";
echo "<div align='center'><table width='70%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";


echo "<Tr><Td colspan='6' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มเจ้าหน้าที่' onclick='location.href=\"?option=book&task=permission&index=1\"'</Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td  align='center'>ที่</Td><Td  align='center'>ชื่อเจ้าหน้าที่</Td><td  align='center'>สารบรรณกลางสพฐ.</td></Td><td  align='center'>สารบรรณสำนัก</td><Td align='center' width='50'>ลบ</Td><Td align='center' width='50'>แก้ไข</Td></Tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$prename = $result['prename'];
		$name = $result['name'];
		$surname = $result['surname'];
		$p2 = $result['p2'];
			if($result['p1']==1){
			$p1_pic="<img src=images/yes.png border='0'>";			}
			else{
			$p1_pic="<img src=images/no.png border='0'>";
			}
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left' width='200'>$prename$name $surname</Td><Td align='center' width='100'>$p1_pic</Td><td>$office_name_ar[$p2]</td>
		<Td align='center' width='50' ><a href=?option=book&task=permission&index=2&id=$id><img src=images/drop.png border='0' alt='ลบ'></a></Td>
		<Td align='center' width='50'><a href=?option=book&task=permission&index=5&id=$id><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
$M++;
	}
echo "</Table>";
echo "</td></tr></table>";

}

echo "<br>";
echo "&nbsp;&nbsp;&nbsp;<center><b>หมายเหตุ</b>&nbsp;บุคลากรในสำนักงานให้สามารถเป็นเจ้าหน้าที่สารบรรณ สำนักได้เพียงสำนักเดียวเท่านั้น</center>";
?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=book&task=permission");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=book&task=permission&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=book&task=permission");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=book&task=permission&index=6");   //page ประมวลผล
		}
	}
}
</script>
