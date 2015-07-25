<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page

echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>สถานศึกษา</strong></font></td></tr>";
echo "</table>";
}
//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มสถานศึกษา</B></Font>";
echo "</Cener>";
echo "<Br>";
echo "<Table   width=60% Border='0'>";
echo "<Tr align='left'><Td width=20></Td><Td align='right'>รหัสสถานศึกษา&nbsp;</Td><Td><Input Type='Text' Name='school_code' Size='5' onkeydown='integerOnly()'>&nbsp;*ควรใช้รหัส smiss 8 หลัก</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อสถานศึกษา&nbsp;</Td><Td><Input Type='Text' Name='school_name' Size='40'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ประเภทสถานศึกษา&nbsp;</Td><Td>";
echo "<Select  name='school_type' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option  value = '1'>สถานศึกษารัฐบาล</option>" ;
echo  "<option  value = '2'>สถานศึกษาเอกชน</option>" ;
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>กลุ่มสถานศึกษา&nbsp;</Td><Td>";
echo "<Select  name='school_group' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from system_school_group order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)) {
echo  "<option  value = '$result[code]'>$result[code] $result[name]</option>" ;
}

echo "</select>";
echo "</Td></Tr>";

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
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?file=school&task=school&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?file=school&task=school\"'";
echo "</td></tr></table>";
}
//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from system_school where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนเพิ่มข้อมูล
if($index==4){
$sql = "insert into system_school (school_code, school_name, school_type, school_group) values ( '$_POST[school_code]','$_POST[school_name]','$_POST[school_type]', '$_POST[school_group]')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขสถานศึกษา</B></Font>";
echo "</Cener>";
echo "<Br>";
$sql = "select * from  system_school where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);

echo "<Table width='70%' Border='0'>";
echo "<Tr align='left'><Td width=20></Td><Td align='right'>รหัสสถานศึกษา&nbsp;</Td><Td><Input Type='Text' Name='school_code' Size='5' value='$ref_result[school_code]' onkeydown='integerOnly()'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อสถานศึกษา&nbsp;</Td><Td><Input Type='Text' Name='school_name' Size='60' value='$ref_result[school_name]'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ประเภทสถานศึกษา&nbsp;</Td><Td>";
if($ref_result['school_type']==1){
$seclect1="selected";
$seclect2="";
}
else if($ref_result['school_type']==2){
$seclect1="";
$seclect2="selected";
}
else{
$seclect1='';
$seclect2='';
}

echo "<Select  name='school_type' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option  value = '1' $seclect1>สถานศึกษารัฐบาล</option>" ;
echo  "<option  value = '2' $seclect2>สถานศึกษาเอกชน</option>" ;
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>กลุ่มสถานศึกษา&nbsp;</Td><Td>";
echo "<Select  name='school_group' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from system_school_group order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)) {
		if($ref_result['school_group']==$result['code']){
		echo  "<option  value = '$result[code]' selected>$result[code] $result[name]</option>" ;
		}
		else{
		echo  "<option  value = '$result[code]'>$result[code] $result[name]</option>" ;
		}
}

echo "</select>";
echo "</Td></Tr>";

echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'>";

echo "</form>";
}
//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "update system_school set school_code='$_POST[school_code]',school_name='$_POST[school_name]',school_type='$_POST[school_type]',school_group='$_POST[school_group]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

$sql = "select system_school.id, system_school.school_code, system_school.school_type, system_school.school_name, system_school_group.name from system_school left join system_school_group on system_school.school_group=system_school_group.code order by system_school.school_type,system_school.school_code";
$dbquery = mysqli_query($connect,$sql);

echo  "<table width=75% border=0 align=center>";
echo "<Tr><Td colspan='6' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มข้อมูล' onclick='location.href=\"?file=school&task=school&index=1\"'></Td></Tr>";

echo "<Tr bgcolor=#FFCCCC align='center' class=style2><Td width='50'>ที่</Td> <Td>รหัสสถานศึกษา</Td><Td>ชื่อสถานศึกษา</Td><Td>ประเภท</Td><Td>กลุ่มสถานศึกษา</Td><Td   width='50'>ลบ</Td><Td width='50'>แก้ไข</Td></Tr>";
$N=1;
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$school_code= $result['school_code'];
		$school_name= $result['school_name'];
		$school_type= $result['school_type'];
		$school_group= $result['name'];
			if($school_type==1){
			$school_type_text="สถานศึกษารัฐบาล";
			}
			else if($school_type==2){
			$school_type_text="<font color='#FF0000'>สถานศึกษาเอกชน</font>";
			}
			else{
			$school_type_text="";
			}

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr  bgcolor=$color align=center class=style1><Td>$N</Td> <Td>$school_code</Td><Td align=left>$school_name</Td><Td align=left>$school_type_text</Td><Td align=left>$school_group</Td><Td><div align=center><a href=?file=school&task=school&index=2&id=$id><img src=../images/drop.png border='0' alt='ลบ'></a></div></Td><Td><a href=?file=school&task=school&index=5&id=$id><img src=../images/edit.png border='0' alt='แก้ไข'></a></div></Td>
	</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</Table>";
}


?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?file=school&task=school");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.school_code.value == ""){
			alert("กรุณากรอกรหัสตำแหน่ง");
		}else if(frm1.school_name.value==""){
			alert("กรุณากรอกชื่อตำแหน่ง");
		}else if(frm1.school_type.value==""){
			alert("กรุณาเลือกประเภทสถานศึกษา");
		}else{
			callfrm("?file=school&task=school&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?file=school&task=school");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.school_code.value == ""){
			alert("กรุณากรอกรหัสตำแหน่ง");
		}else if(frm1.school_name.value==""){
			alert("กรุณากรอกชื่อตำแหน่ง");
		}else if(frm1.school_type.value==""){
			alert("กรุณาเลือกประเภทสถานศึกษา");
		}else{
			callfrm("?file=school&task=school&index=6");   //page ประมวลผล
		}
	}
}
</script>
